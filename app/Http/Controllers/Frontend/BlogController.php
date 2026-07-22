<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\helper\Uploader;
use App\Models\Category;
use App\Models\City;
use App\Models\District;
use App\Models\Street;
use App\Models\Estate;
use App\Models\FeatureValue;
use App\Models\Tag;
use Illuminate\Http\Request;
//use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\BlogPosting;
use Illuminate\Support\Facades\Cache;
use Verta;


class BlogController extends Controller {
	public function index(Request $request , $id = 0)
    {
        $post_type = ! empty( $request->type ) ? $request->type : 'post';
		$model  = QueryBuilder::for ( Post::class )
                    ->allowedIncludes( 'categories' )
                    ->allowedFilters( [
                        'category',
                        'id',
                        'type',
                        'categories.id',
                        'title',
                    ])
                    ->defaultSort( '-id' )
                    ->allowedSorts( [ 'id', 'title', 'created_at' ] );
		$model=!empty( $request->input_created_at ) ? $model->createDate( $request->input_created_at ) : $model;
		$model=$model->where( 'type', 'post');
        $model=$model->where('active',1);

        if($id > 0)
        {
            $model=$model->where('category_id',$id);
            $category = Category::where('id' , $id)->first();
        }
        else
        {

            $category = Category::where('id' ,1)->first();
        }
        $usercount=$model->count();
		$model= $model->paginate(21);
		$model->map( function ( $item ) {
			$item->publish_date = toAgoTime( $item->created_at );
		} );
        $categories = Category::get( [ 'id', 'name' ] );
        if($request->ajax()  && $model->count()>0) {
            $couter=$usercount/21;
            $couter=(int)$couter;
            $hasPage = ($couter+1==$request->page)? false : true;
            //dd($couter+1,$request->page);
            $view = view('frontend.blog.advance_search', compact('model'))->render();
            return response()->json( [ 'html' => $view, 'count'=>$usercount,'hasPage'=>$hasPage ] );
        }
		return view( 'frontend.blog.index', compact( 'model', 'post_type', 'categories' ,'category') );
	}

    public function list() {

		return view('frontend.blog.list');
	}
    function insertAdsInContent($content , $title)
    {
        // تبلیغات (می‌توانید چند نوع تعریف کنید)
        $ads = [
            '<div class="card text-white border-0 shadow-lg rounded-4 mb-5 mt-5" style="background: linear-gradient(135deg, #5e3b1e, #b48c4e);">
  <div class="card-body text-right p-4">
    <h5 class="card-title fw-bold text-white mb-3">
      آیا سوالی دارید یا به‌دنبال ملک‌های خاص با قیمت استثنایی هستید؟
    </h5>
    <p class="card-text fs-sm mb-3">
      همین حالا تماس بگیرید و اولین قدم به‌سوی یک خرید هوشمند را بردارید!
    </p>
    <p class="card-text fs-sm">
      <strong><a href="tel:09133386608" class="text-warning text-decoration-none">09133386608</a></strong>&nbsp; | &nbsp;
      <strong><a href="tel:09129406124" class="text-warning text-decoration-none">09129406124</a></strong>
    </p>
  </div>
</div>
',
            '<div class="card text-white bg-danger border-0 shadow-lg rounded-4 mb-5 mt-5">
  <div class="card-body text-center">
    <h5 class="card-title fw-bold text-white mb-3">
      برای مشاوره رایگان و شروع سرمایه‌گذاری هوشمند در املاک رضوانشهر، همین حالا تماس بگیرید.
    </h5>
    <p class="card-text fs-sm">
      <strong>
        <a href="tel:09133386608" class="text-white text-decoration-underline">09133386608</a>
        &nbsp; | &nbsp;
        <a href="tel:09129406124" class="text-white text-decoration-underline">09129406124</a>
      </strong> — اولین قدم شما به‌سوی سودآوری در بازار ملک!
    </p>
  </div>
</div>
',
            (($title != '')?'<div class="card text-white bg-accent border-0 shadow-lg rounded-4 my-5">
  <div class="card-body text-center">
    <h5 class="card-title fw-bold text-white mb-3">
      بهترین فرصت برای خرید ملک ارزان در '.$title.' همین حالاست!
    </h5>
    <p class="card-text fs-sm mb-3">
      قیمت‌ها رو به افزایش هستند... حالا وقتشه که قبل از دیگران اقدام کنید.
      با یک تماس ساده، مشاوره رایگان بگیرید و گام اول برای یک سرمایه‌گذاری سودآور رو بردارید.
    </p>
    <p class="card-text fs-sm">
      📞 <strong><a href="tel:09133386608" class="text-white text-decoration-underline">09133386608</a></strong> &nbsp; | &nbsp;
      <strong><a href="tel:09129406124" class="text-white text-decoration-underline">09129406124</a></strong>
    </p>
  </div>
</div>'
:'')
        ];

        // تقسیم پاراگراف‌ها با توجه به <p>
        $paragraphs = explode('</p>', $content);

        $newContent = '';
        $adIndex = 0;

        foreach ($paragraphs as $index => $para) {
            // اگر پاراگراف خالی بود ادامه نده
            if (trim($para) === '') continue;

            // بازسازی پاراگراف
            $newContent .= $para . '</p>';

            // مثلاً بعد از هر 2 پاراگراف یک تبلیغ اضافه شود
            if (($index + 1) % 5 == 0 && isset($ads[$adIndex])) {
                $newContent .= $ads[$adIndex];
                $adIndex++;
            }
        }

        return $newContent;
    }

    public function show($id)
    {

        $post_type = ! empty( $request->type ) ? $request->type : 'post';
		$model  = Post::Where('id', $id)->where('active',1);
        $model     = $model->first();

        if($model != null)
        {

            $model->body = preg_replace_callback(
                '/<img[^>]{1,}src="(https?.*?\.(?:png|gif|jpe?g))"[^>]{1,}>/',
                function ($matches) {
                    //dd($matches[0]);
                    $useragent=$_SERVER['HTTP_USER_AGENT'];
                    $isMobile =  preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));
                    if($isMobile)
                    {
                        $w = 360;
                        $h = 360;
                        $p = '100%';
                    }
                    else
                    {
                        $w = 600;
                        $h = 600;
                        $p = '';
                    }
                    $_ = crop($matches[1] , $w , $h);
                    return '<img src="'.$_.'" width="'.$p.'" style="display: block; margin-left: auto; margin-right: auto;">';
                },
                $model->body
            );

        }
        //dd($model->body);
        $recentposts = null;
        if($model == null)
        {
            return view('frontend.errors.404');
        }
        $tags = Cache::remember('tags-'.$id , 3000, function () use ($id){
            return Tag::join('taggables', 'tags.id', '=', 'taggables.tag_id')
                    ->where('taggable_id',$id)->where('taggable_type' , 'App\Model\Post')
                    ->select('tags.*')
                    ->get();
        });

        if($model->category_id != null && $model->category_id > 0 && $model->type != 'page')
        {
            $recentposts = Cache::remember('recentposts-'.$model->category_id , 3000, function () use ($model){
                return Post::where('category_id',$model->category_id)->orderBy('id','desc')->limit(10)->get();
            });
        }
        $estateBuy = null;
        $estateRent = null;
        $posx = null;
        $posy = null;
        $featureValues = null;
        $avgLand = 0;
        $avgApartment = 0;
        $avgApartment5 = 0;
        $avgApartment10 = 0;
        if(ss('SITE_ID') == 2 || ss('SITE_ID') == 3)
        {
            $featureValues = Cache::remember('featureValues' , 3000, function (){
                return FeatureValue::get();
            });
            $city = City::where('active', 1)->where('post_id', $id)->first();
            if($city != null)
            {
                if(ss('SITE_ID') == 2)
                {
                    $model->body = $this->insertAdsInContent($model->body , $city->name);
                }
                $posx = $city->posx;
                $posy = $city->posy;
                $id = $city->id;
                $estateBuy = Cache::remember('estateBuy-city-'.$city->id , 3000, function () use ($city){
                    return Estate::with([
                        'expert:id,code,name,last_name,username,photo,alias,title,phone',
                        'user:id,code,name,last_name,username,photo,alias,title,phone'
                    ])->where('city_id', $city->id)
                        ->where('visibility', 1)
                        ->where('type',1)
                        ->where('confirmation', 'verified')->orderBy('id','desc')->limit(10)->get();
                });
                if(ss('SITE_ID') == 2)
                {
                    $estateRent = Cache::remember('estateRent-city-'.$id , 3000, function () use ($id){
                        return Estate::with([
                            'expert:id,code,name,last_name,username,photo,alias,title,phone',
                            'user:id,code,name,last_name,username,photo,alias,title,phone'
                        ])->where('city_id', $id)
                            ->where('visibility', 1)
                            ->where('type',3)
                            ->where('confirmation', 'verified')->orderBy('id','desc')->limit(10)->get();
                    });
                }
            }
            else
            {
                $district = District::where('active', 1)->where('post_id', $id)->first();
                if($district != null)
                {
                    if(ss('SITE_ID') == 2)
                    {
                        $model->body = $this->insertAdsInContent($model->body , $district->name);
                    }
                    $posx = $district->posx;
                    $posy = $district->posy;
                    $id = $district->id;
                    $estateBuy = Cache::remember('estateBuy-district-'.$district->id , 3000, function () use ($district){
                        return Estate::with([
                            'expert:id,code,name,last_name,username,photo,alias,title,phone',
                            'user:id,code,name,last_name,username,photo,alias,title,phone'
                        ])->where('district_id', $district->id)
                            ->where('visibility', 1)
                            ->where('type',1)
                            ->where('confirmation', 'verified')->orderBy('id','desc')->limit(10)->get();
                    });
                    if(ss('SITE_ID') == 2)
                    {
                        $estateRent = Cache::remember('estateRent-city-'.$district->city_id , 3000, function () use ($district){
                            $estateRent = Estate::with([
                                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                                'user:id,code,name,last_name,username,photo,alias,title,phone'
                            ])->where('city_id', $district->city_id)
                                ->where('visibility', 1)
                                ->where('type',3)
                                ->where('confirmation', 'verified')->orderBy('id','desc')->limit(10)->get();
                        });
                    }
                    $dis = [];
                    $diss = [];
                    foreach($district->adjacentDistricts as $distr)
                    {
                        $dist = $distr->districts;
                        $dis[] = '<a href="'.(isset($dist->post)?$dist->post->url():'javascript:void(0)').'" target="_blank" alt="'.$dist->name.'"  title="'.$dist->name.'" >'.$dist->name.'</a>';
                        $diss[] = $dist->name;
                    }
                    $body = '<p>'. $model->title .' در استان '. $district->province->name .' و در شهر '. $district->city->name .' واقع شده است.';
                    if(count($dis)>0)
                    {
                        $body .= 'این محله
                        با محله های '.implode(" , " , $dis).' مجاورت دارد.';
                    }
                    $body .= '</p>';
                    $model->body = $body . $model->body;

                    if($model->description == '')
                    {
                        $model->description = $model->title .' در استان '. $district->province->name .' و در شهر '. $district->city->name .' واقع شده است.';
                        if(count($diss)>0)
                        {
                            $model->description .=  'این محله
                            با محله های '.implode(" , " , $diss).' مجاورت دارد';
                        }
                    }
                    $avgLand = $district->avgLand;
                    $avgApartment = $district->avgApartment;
                    $avgApartment5 = $district->avgApartment5;
                    $avgApartment10 = $district->avgApartment10;


                }
                else
                {
                    $street = Street::where('active', 1)->where('post_id', $id)->first();
                    if($street != null)
                    {
                        if(ss('SITE_ID') == 2)
                        {
                            $model->body = $this->insertAdsInContent($model->body , $street->name);
                        }
                        $posx = $street->posx;
                        $posy = $street->posy;
                        $id = $street->id;
                        $estateBuy = Cache::remember('estateBuy-street-'.$street->id , 3000, function () use ($street){
                            return Estate::with([
                                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                                'user:id,code,name,last_name,username,photo,alias,title,phone'
                            ])->where('street_id', $street->id)
                                ->where('visibility', 1)
                                ->where('type',1)
                                ->where('confirmation', 'verified')->orderBy('id','desc')->limit(10)->get();
                        });
                        $dis = [];
                        $dis2 = [];
                        foreach($street->adjacentStreets as $stree)
                        {
                            $stre = $stree->streets;
                            if($stre != null)
                            {

                                $dis[] = '<a href="'.($stre->post != null?$stre->post->url():'javascript:void(0)').'" target="_blank" alt="'.$stre->name.'"  title="'.$stre->name.'" >'.$stre->name;
                                $dis2[] = $stre->name;
                            }
                            $stre = $stree->districts;
                            if($stre != null)
                            {
                                $dis[] = '<a href="'.($stre->post != null ?$stre->post->url():'javascript:void(0)').'" target="_blank" alt="'.$stre->name.'"  title="'.$stre->name.'" >'.$stre->name;
                                $dis2[] = $stre->name;
                            }
                        }

                        $body = '<p>'. $model->title .' در استان '. $street->province->name .' و در شهر '. $street->city->name .
                        ' و در محله '.$street->district->name.
                        ' واقع شده است.';
                        if(count($dis)>0)
                        {
                            $body .= ' این خیابان با خیابان های '.implode(" , " , $dis).' مجاورت دارد.';
                        }
                        $body .= '</p>';
                        $model->body = $body . $model->body;
                        if($model->description == '')
                        {
                            $model->description = $model->title .' در استان '. $street->province->name .' و در شهر '. $street->city->name .
                            ' و در محله '.$street->district->name.
                            ' واقع شده است.';
                            if(count($dis2)>0)
                            {
                                $model->description .= 'این خیابان
                                با خیابان های '.implode(" , " , $dis2).' مجاورت دارد';
                            }
                        }
                        $avgLand = $street->avgLand;
                        $avgApartment = $street->avgApartment;
                        $avgApartment5 = $street->avgApartment5;
                        $avgApartment10 = $street->avgApartment10;
                    }
                    else
                    {
                        if(ss('SITE_ID') == 2)
                        {
                            $model->body = $this->insertAdsInContent($model->body , '');
                        }
                    }

                }
            }
        }
        if(ss('SITE_ID') == 3)
        {
            return view( 'site3.frontend.blog.show' , compact( 'model','estateBuy','estateRent' , 'recentposts' , 'featureValues' , 'tags' , 'posx' , 'posy' , 'avgLand' , 'avgApartment' , 'avgApartment5' , 'avgApartment10'));
        }
        else
        {
		    return view( 'frontend.blog.show' , compact( 'model','estateBuy','estateRent' , 'recentposts' , 'featureValues' , 'tags'));
        }
		//return view( 'frontend.blog.show', compact( 'model','estateBuy','estateRent' , 'recentposts' , 'featureValues'));

	}
}
