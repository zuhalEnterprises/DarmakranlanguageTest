<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Exports\PagesExport;
use App\Exports\PostsExport;
use App\helper\Uploader;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Taggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Config;
use Verta;

class PostController extends Controller
{
    public function __construct() {
        $this->middleware( 'role:admin_super|admin_site' );
    }
    // public function createBlog(Request $request)
    // {
    //     return view('frontend.blog.create');
    // }
    public function viewBlog(Request $request)
    {
        return view('frontend.blog.view');
    }
	public function index( Request $request )
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
		$model = POST::orderBy('id', 'desc');
        if (!empty($request->id)) {
            $model = $model->where('id',  $request->id );
        }
        if (!empty($request->category_id)) {
            $model = $model->where('category_id',  $request->category_id );
        }
        if (!empty($request->title)) {
            $model = $model->where(function ($query) use ($request) {
                $query->where('title', 'like', "%$request->title%")
                    ->orWhere('description', 'like', "%$request->title%")
                    ->orWhere('body', 'like', "%$request->title%");
            });
        }

        if ($request->active == 0 || $request->active == 1) {
            $model = $model->where('active',  $request->active);
        }

        if ($request->type == 'page') {
            $model = $model->where('type', 'page');
        }
        $totalCount = $model->count();
        $model = $model->paginate(10);
        $categories = Category::where( 'parent_id', null )->get( [
			'id',
			'parent_id',
			'name',
		] );

        if ($request->ajax() && $model->count() > 0)
        {
            $couter=$totalCount/10;
            $counter1= round($couter);
            if($counter1>=$couter) $couter=$counter1;
            else $couter=$counter1+1;
            $hasPage = ($couter==$request->page)? false : true;
            $view = view('frontend.blog.component_ex_blog_type', compact('model','totalCount' , 'categories'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
		$categories = Category::get( [ 'id', 'name' ] );
		return view('frontend.blog.list', compact( 'model','categories' ));
	}

	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:posts,id'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$model = Post::find( $id );
		$model->update( [ 'visit' => $model->visit + 1 ] );

		return view( 'admin.post.index', compact( 'model' ) );
	}

	public function create( Request $request ) {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
		//$post_type  = $request->type;
		$categories = Category::where( 'parent_id', null )->get( [
			'id',
			'parent_id',
			'name',
		] );
		//$tags       = Tag::get( [ 'id', 'name' ] );
        $expire_at = '';

        $tags = Tag::get();

        $tag_selected = [];

		return view( 'frontend.blog.create', compact( /*'post_type',*/ 'categories', 'expire_at' , 'tags' , 'tag_selected'));
	}

	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), [
			/*'cat_id.*' => 'required|numeric|exists:categories,id',
			'tag_id.*' => 'nullable|numeric|exists:tags,id',
			'type'     => 'required|in:post,page',*/
			'image'    => 'nullable|mimes:jpg,jpeg,png,bmp,webp',
			'title'    => 'required',
            /*'body'     => 'required|min:5',*/
		] );
		if ( $validator->fails() ) {

			return back()->withErrors($validator)->withInput();
		}

		$image = uploader( $request, 'image', 'images/blog' );

		$inputs                 = $request->all();
		$inputs['image']        = $image;
        if($request->expire_at != '')
        {
            $expire_at = explode('/',$request->expire_at);
            $inputs['expire_at'] = jalali_to_gregorian($expire_at[0] , $expire_at[1] , $expire_at[2] , '-')." 23:59:59";
        }

        if(array_key_exists('tags' , $inputs))
        {
            $tag_comment = $inputs['tags'];
            $inputs['tags'] = '';
        }
		$model = Post::create( $inputs );
        if(isset($tag_comment))
        {
            foreach($tag_comment as $val)
            {
                $tag = Tag::where( 'name', $val )->first();
                if($tag == null)
                {
                    $tag = Tag::create( [ 'name' => $val ] );
                }
                $tagsid[] = $tag->id;
            }
        }
        Taggable::where('taggable_type' , 'App\Model\Post')
                ->where('taggable_id' , $model->id)
                ->delete();
        if(isset($tagsid))
        {
            foreach($tagsid as $id)
            {
                Taggable::create( [ 'tag_id' => $id, 'taggable_type' => 'App\Model\Post', 'taggable_id' => $model->id] );
            }
        }
		/*if ( ! empty( $model ) ) {
			// assign categories
			$model->categories()->sync( $request->cat_id );

			// assign tags
			if ( ! empty( $tags ) ) {
				$model->tags()->sync( $tags );
			}
		}*/

		return redirect( '/profile/posts' )->with( 'success', 'created successfully' );
	}

	public function edit( Request $request, $id ) {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
		//$post_type = $request->type;
		$model     = Post::where( 'id', $id )->first();
        $categories = Category::where( 'parent_id', null )->get( [
			'id',
			'parent_id',
			'name',
		] );
		if ( empty( $model ) ) {
			return back()->with( [ 'errors' => 'یافت نشد!' ] );
		}
        $expire_at = '';
        if($model->expire_at)
        {
            $expire_at1 = explode(' ',$model->expire_at);
            $expire_at = explode('-',$expire_at1[0]);
            $expire_at = gregorian_to_jalali($expire_at[0] , $expire_at[1] , $expire_at[2] , '/');
        }

        $tags = Tag::get();

        $tag_selected = [];
        $tag_selected2 = Tag::join('taggables', 'tags.id', '=', 'taggables.tag_id')
            ->where('taggable_id',$id)->where('taggable_type' , 'App\Model\Post')
            ->select('tags.*')
            ->get();
        foreach($tag_selected2 as $t)
        {
            $tag_selected[] = $t->id;
        }
		return view( 'frontend.blog.create', compact( [ 'model', 'categories' , 'expire_at', 'tags', 'tag_selected'] ) );
	}

	public function update( Request $request, $id ) {

		$model = Post::find( $id );
		if ( empty( $model ) ) {
			return back()->with( [ 'errors' => 'یافت نشد!' ] );
		}

		$validator = Validator::make( $request->all(), [
			/*'cat_id.*' => 'required|numeric|exists:categories,id',*/
			//'image'    => 'nullable|mimes:jpg,jpeg,png,bmp|max:2048',
			'title'    => 'required|max:255',
            /*'body'     => 'required'*/
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

        $image = uploader( $request, 'image','images/blog' );

		$inputs                 = $request->all();
		$inputs['image']        = ! empty( $image ) ? $image : $model->image;
        if($request->expire_at != '')
        {
            $expire_at = explode('/',$request->expire_at);
            $inputs['expire_at'] = jalali_to_gregorian($expire_at[0] , $expire_at[1] , $expire_at[2] , '-')." 23:59:59";
        }
		//$inputs['link_rewrite'] = ! empty( $inputs['link_rewrite'] ) ? preg_replace( '/\s+/', '-', $inputs['link_rewrite'] ) : preg_replace( '/\s+/', '-', $inputs['title'] );

        if(array_key_exists('tags' , $inputs))
        {
            $tag_comment = $inputs['tags'];
            $inputs['tags'] = '';
        }
        $model->update( $inputs );

        if(isset($tag_comment))
        {
            foreach($tag_comment as $val)
            {
                $tag = Tag::where( 'name', $val )->first();

                if($tag == null)
                {
                    $tag = Tag::create( [ 'name' => $val ] );
                }
                $tagsid[] = $tag->id;
            }
        }
        Taggable::where('taggable_type' , 'App\Model\Post')
                ->where('taggable_id' , $model->id)
                ->delete();
        if(isset($tagsid))
        {
            foreach($tagsid as $id)
            {
                Taggable::create( [ 'tag_id' => $id, 'taggable_type' => 'App\Model\Post', 'taggable_id' => $model->id] );
            }
        }

		return redirect( '/profile/posts' );
	}

	public function destroy( $id ) {

		$model = Post::where('id' , $id )->delete();

		return redirect( '/profile/posts');
	}

	public function status( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:posts,id'
		] );
		if ( $validator->fails() ) {
			return response( [
				'status' => 'error',
				'result' => $validator->errors()
			], config( 'StatusCode.INVALID_INPUT' ) );
		}

		$model = Post::find( $id );
		$model->update( [ 'active' => ( $model->active ) ? false : true ] );

		return response( [ 'status' => 'ok', 'result' => $model->active ], config( 'StatusCode.SUCCESS' ) );
	}

	public function cat_post( Request $request, $cat_id ) {
		$validator = Validator::make( [ 'cat_id' => $cat_id ], [
			'cat_id' => 'required|numeric|exists:categories,id'
		] );
		if ( $validator->fails() ) {
			return back( 302 )->with( [ 'errors' => $validator->errors() ] );
		}

		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->mount > 0 ? (int) $request->mount : 10;

		$category = Category::find( $cat_id );
		$all_post = $category->posts();
		$count    = $all_post->get()->count();
		$all_post = $all_post->skip( $offset )->take( $mount )->get();
		$all_post->map( function ( $item ) {
			unset( $item->pivot );
		} );

		return response( [ 'all_post' => $all_post, 'count' => $count ], 200 );
	}

	public function tag_post( Request $request, $tag_id ) {
		$validator = Validator::make( [ 'tag_id' => $tag_id ], [
			'tag_id' => 'required|numeric|exists:tags,id'
		] );
		if ( $validator->fails() ) {
			return back( 302 )->with( [ 'errors' => $validator->errors() ] );
		}

		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->mount > 0 ? (int) $request->mount : 10;

		$tag      = Tag::find( $tag_id );
		$all_post = $tag->posts();
		$count    = $all_post->get()->count();
		$all_post = $all_post->skip( $offset )->take( $mount )->get();

		$all_post->map( function ( $item ) {
			unset( $item->pivot );
		} );

		return response( [ 'all_post' => $all_post, 'count' => $count ], 200 );
	}

	public function query_posts( $cat_id ) {
		$category = Category::find( $cat_id );
		$all_post = $category->posts()->get();
		$all_post->map( function ( $item ) {
			unset( $item->pivot );
		} );

		return $all_post;
	}

	public function export( Request $request ) {
		$post_type = ! empty( $request->type ) ? $request->type : 'post';
		$model     = QueryBuilder::for ( Post::with( 'categories' ) )
		                         ->allowedIncludes( 'categories' )
		                         ->allowedFilters( [
			                         Filter::scope( 'category' ),
			                         'id',
			                         'type',
			                         'categories.id',
			                         'title',
			                         'active'
		                         ] )
		                         ->defaultSort( '-id' )
		                         ->allowedSorts( [ 'id', 'title', 'created_at' ] );
		$model     = ! empty( $request->input_created_at ) ? $model->createDate( $request->input_created_at ) : $model;
		$model     = ! empty( $post_type ) ? $model->where( 'type', $post_type ) : $model;
		$model     = $model->get( [ 'id', 'title', 'meta_description', 'link_rewrite', 'active' ] );

		$model->map( function ( $item ) use ( $post_type ) {
			if ( $post_type == 'post' ) {
				$item->category = $item->categories && $item->categories->count() > 0 ? implode( ', ', $item->categories->pluck( 'name' )->toArray() ) : '';
			}

			$item->create_date = new Verta( $item->created_at );
		} );

		$export = $post_type == 'post' ? new PostsExport( $model ) : new PagesExport( $model );

		return Excel::download( $export, $post_type . 's.xlsx' );
	}

}
