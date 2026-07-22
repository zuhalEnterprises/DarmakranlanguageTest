<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Requests\User\VerifyMobileRequest;
use App\Http\Requests\User\VerifyCodeRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\Province;
use App\Models\City;
use App\Models\Street;
use App\Models\Customer;
use App\Models\FeatureValue;
use App\Models\AdjacentDistrict;
use App\Models\AdjacentStreet;
use App\Models\Estate;
use App\Models\Task;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\Contract;
use App\Models\EstateOperation;
use App\Models\EstateFavorite;
use App\Models\EstateCompare;
use App\Models\EstateNote;
use App\Models\Manufacturer;
use App\Models\EstateEdits;
use App\Models\RelationEstateCustomer;
use App\Models\UserSearch;
use App\Models\Branch;
use App\Models\Phonebook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserLogin;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\Validator;
use App\Models\District;
use App\Models\UserActivityDistrict;
use App\helper\Uploader;
use App\Models\EstateEdit;
use App\Models\Language;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Config;
class ProfileController extends Controller
{
    protected $arraylevel=[];

    public function favorite(Request $request)
    {
        // auth user
        $user = Auth::user();
        // get current datetime
        $dt = Carbon::now();
        // retrieve estate
        $estates = Estate::whereHas('favorites', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with([
            'images',
            'district',
            'favorites',
        ])->where('confirmation', 'verified')->where('visibility', 1)
            //->where('expired_at', '>=', $dt)
            ->orderBy('published_at', 'desc')
            ->get();
        // get user favorite estates
        $favList = EstateFavorite::where('user_id', $user->id)->whereIn('estate_id', $estates->pluck('id')->toArray() ?? [])->get();
        // iterate on collection
        $estates->map(function ($item) use ($dt, $favList) {
            $fe = $favList->where('estate_id', $item->id)->first();
            $item->pin = $fe && $fe->pin == '1' ? 1 : 0;
            $item->isExpired = $item->expired_at >= $dt ? 0 : 1;
            $firstImage = $item->images->first();
            //$item->coverImage = $item->coverImage;
            $item->url = $item->url();
        });
        // sort by pin status
        $estates = $estates->sortByDesc('pin');
        $featureValues = FeatureValue::get();
        //dd(getQuery($favoriteCustomer));
        if (env('COUNTRY') == 'UAE')
        {
            $manufacturers = Manufacturer::get();
            return view('site'.ss('SITE_ID').'.frontend.profile.favorite', compact('estates' , 'featureValues'));
        }
        else
        {
            return view('frontend.profile.favorite', compact('estates' , 'featureValues'));
        }
    }
    public function compare(Request $request)
    {
        // auth user
        $user = Auth::user();
        // get current datetime
        $dt = Carbon::now();
        // retrieve estate
        $estates = Estate::whereHas('compare', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with([
            'images',
            'district',
            'compare',
        ])->where('confirmation', 'verified')->where('visibility', 1)
            //->where('expired_at', '>=', $dt)
            ->orderBy('published_at', 'desc')
            ->get();
        // get user favorite estates
        $comList = EstateCompare::where('user_id', $user->id)->whereIn('estate_id', $estates->pluck('id')->toArray() ?? [])->get();
        // iterate on collection
        $estates->map(function ($item) use ($dt, $comList) {
            $fe = $comList->where('estate_id', $item->id)->first();
            $item->pin = $fe && $fe->pin == '1' ? 1 : 0;
            $item->isExpired = $item->expired_at >= $dt ? 0 : 1;
            $firstImage = $item->images->first();
            $item->url = $item->url();
        });
        // sort by pin status
        $estates = $estates->sortByDesc('pin');
        $featureValues = FeatureValue::get();
        return view('frontend.profile.compare', compact('estates' , 'featureValues'));
    }
    public function myEstate(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        // retrieve estate
        $estates = Estate::with([
            'images',
            'district',
        ])->where('user_id', $user->id)
            ->orderBy('showdate', 'desc');
        $estates = $estates->where('showdate', '>' ,  date("Y-m-d", strtotime("-2 years")));
        $estates = $estates->paginate(200);;
        $estates->map(function ($item) use ($dt) {
            $item->isExpired = empty($item->expired_at) && $item->expired_at >= $dt ? 1 : 0;
            $firstImage = $item->images->first();
            $item->coverImage = $item->coverImage();
        });
        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 9);
        })->get(['id', 'name','last_name', 'username','status']);
        $defaultCity = ss('DEFAULT_CITY');
        $citiesSelected = [];
        $citySelected = City::with(['districts' => function ($q) {$q->orderBy('name', 'asc');}])->where('name_en', $defaultCity)->where('active', 1)->first();
        if($citySelected)
        {
            $citiesSelected = City::where('province_id', $citySelected->province_id)->where('active', 1)->get();
        }
        $streets = null;
        if(ss('SITE_ID') == 3)
        {
            $streets = Street::where('province_id', $citySelected->province_id)->where('active', 1)->get();
        }
        $Agent = new Agent();
        //dd(getQuery($users));
        if (env('COUNTRY') == 'UAE')
        {
            $manufacturers = Manufacturer::get();
            return view('site'.ss('SITE_ID').'.frontend.profile.my_estate', compact('estates','users','citySelected','citiesSelected','Agent','manufacturers'));
        }
        elseif(ss('SITE_ID') == 7)
        {
            $typelist = 'my';
            return view('site7.frontend.profile.my_estate', compact('estates','users','citySelected','citiesSelected','Agent','typelist'));
        }
        else
        {
            $tags = '';
            if(ss('SITE_ID') == 2)
            {
                $tags = Tag::get();
            }
            return view('frontend.profile.my_estate', compact('estates','users','citySelected','citiesSelected','Agent','streets','tags'));
        }
    }
    public function branchEstate(Request $request)
    {
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        // retrieve estate
        $estates = Estate::with([
            'images',
            'district',
        ])->where('user_id', $user->id)
            ->orderBy('showdate', 'desc');
        $estates = $estates->where('showdate', '>' ,  date("Y-m-d", strtotime("-2 years")));
        $estates = $estates->paginate(200);;
        $estates->map(function ($item) use ($dt) {
            $item->isExpired = empty($item->expired_at) && $item->expired_at >= $dt ? 1 : 0;
            $firstImage = $item->images->first();
            $item->coverImage = $item->coverImage();
        });
        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 9);
        })->get(['id', 'name','last_name', 'username','status']);
        $defaultCity = ss('DEFAULT_CITY');
        $citiesSelected = [];
        $citySelected = City::with(['districts' => function ($q) {$q->orderBy('name', 'asc');}])->where('name_en', $defaultCity)->where('active', 1)->first();
        if($citySelected)
        {
            $citiesSelected = City::where('province_id', $citySelected->province_id)->where('active', 1)->get();
        }
        $streets = null;
        if(ss('SITE_ID') == 3)
        {
            $streets = Street::where('province_id', $citySelected->province_id)->where('active', 1)->get();
        }
        $Agent = new Agent();
        $typelist = 'branch';
        return view('site7.frontend.profile.my_estate', compact('estates','users','citySelected','citiesSelected','Agent','typelist'));
    }
    public function Task(Request $request){
        $user = Auth::user();
        $model = Task::where('user_id',$user->id);
        if(!empty($request->done)){
            $model =$model->where('done',$request->done);
        }
        $totalCount = $model->count();
        $model = $model->paginate(10);
        if ($request->ajax() && $model->count() > 0) {
            $couter=$totalCount/10;
            $counter1= round($couter);
            if($counter1>=$couter) $couter=$counter1;
            else $couter=$counter1+1;
            $hasPage = ($couter==$request->page)? false : true;
            $view = view('frontend.profile.TaskList', compact('model'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        return view('frontend.profile.task', compact('model'));
    }
    public function deleteTask($id)
    {
        $user = Auth::user();
        if(empty($user) ){
            return view('frontend.errors.404');
        }
        $model = Task::where('id', $id)->first();
        if($model->user_id == $user->id) {
            $model->delete();
        }
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
    }
    public function statusTask($id)
    {
        $user = Auth::user();
        if(empty($user)){
            return view('frontend.errors.404');
        }
        $model = Task::find($id);
        if (empty($model)) {
            return notFound();
        }
        if($model->user_id == $user->id) {
            $model->update(['done' => ($model->done) ? false : true]);
        }
        return response(['status' => 'ok', 'result' => true], config('StatusCode.SUCCESS'));
    }
    public function province(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = new Province;
            $model = ( $request->active != null && $request->active != 2 ) ? $model->where( 'active', $request->active ) : $model;
            $model = $model->get();
            return view('frontend.province.province',compact( 'model' ) );
        }
    }
    public function city(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $city = City::orderBy('id', 'desc');
            if(!empty($request->name))
            {
                $city = $city->where('name', 'like' , '%'.$request->name.'%');
            }
            if(!empty($request->name_en))
            {
                $city = $city->where('name_en', 'like' , '%'.$request->name_en.'%');
            }
            if (!empty($request->province_id))
            {
                $city = $city->where('province_id', $request->province_id);
            }
            $totalCount = $city->count();
            $model = $city->paginate(20);
            $provinces = Province::get(['id', 'name']);

            if ($request->ajax() && $totalCount > 0)
            {
                //dd($totalCount);
                $couter=$totalCount/20;
                $counter1= round($couter);
                if($counter1>=$couter) $couter=$counter1;
                else $couter=$counter1+1;
                $hasPage = ($couter==$request->page)? false : true;
                //dd($hasPage);
                $view = view('frontend.province.citylist', compact('model', 'provinces'))->render();
                return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
            }
            return view('frontend.province.city', compact('model', 'provinces'));
        }
    }
    public function district(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $district = District::orderBy('id', 'desc');
            if(!empty($request->name))
            {
                $district = $district->where('name', 'like' , '%'.$request->name.'%');
            }
            if(!empty($request->name_en))
            {
                $district = $district->where('name_en', 'like' , '%'.$request->name_en.'%');
            }
            if(!empty($request->city_id))
            {
                $district = $district->where('city_id',  $request->city_id);
            }
            if (!empty($request->province_id))
            {
                $district = $district->where('province_id', $request->province_id);
            }
            $totalCount = $district->count();
            $model = $district->paginate(20);
            //dd($model);
            $provinces = Province::get(['id', 'name']);
            if ($request->ajax() && $totalCount > 0)
            {
                $couter=$totalCount/20;
                $counter1= round($couter);
                if($counter1>=$couter) $couter=$counter1;
                else $couter=$counter1+1;
                $hasPage = ($couter==$request->page)? false : true;
                $view = view('frontend.province.districtlist', compact('model', 'provinces'))->render();
                return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
            }
            return view('frontend.province.district', compact('model', 'provinces'));
        }
    }
    public function street(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $street = Street::orderBy('id', 'desc');
            if(!empty($request->name))
            {
                $street = $street->where('name', 'like' , '%'.$request->name.'%');
            }
            if(!empty($request->city_id))
            {
                $street = $street->where('city_id',  $request->city_id);
            }
            if (!empty($request->province_id))
            {
                $street = $street->where('province_id', $request->province_id);
            }
            if (!empty($request->district_id))
            {
                $street = $street->where('district_id', $request->district_id);
            }
            $totalCount = $street->count();
            $model = $street->paginate(20);
            if ($request->ajax() && $totalCount > 0)
            {
                $couter=$totalCount/20;
                $counter1= round($couter);
                if($counter1>=$couter) $couter=$counter1;
                else $couter=$counter1+1;
                $hasPage = ($couter==$request->page)? false : true;
                $view = view('frontend.province.streetlist', compact('model'))->render();
                return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
            }
            return view('frontend.province.street');
        }
    }
    public function provincecreate(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Province::where( 'active',1 )->first();
            return view('frontend.province.provincecreate',compact('model'));
        }
    }
    public function citycreate(Request $request)
    {
        if(ss('SITE_ID') == 10)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $provinces = Province::where( 'active',1 )->get();
            $posts = Post::where( 'category_id',10 )->get();
            return view('frontend.province.citycreate', compact('provinces','posts'));
        }
    }
    public function cityupdate(Request $request, $id)
    {

        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = City::find($id);
            if (empty($model)) {
                return back()->withErrors(['یافت نشد!']);
            }
            $validator = Validator::make($request->all(), [
                //'province_id' => 'required|exists:provinces,id',
                'name' => 'required|unique:cities,name,' . $id,
            ]);
            if ($validator->fails()) {
            // dd($validator->fails());
                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $model->update($inputs);
            session()->flash('عملیات بروزرسانی با موفقیت انجام شد.', 'success');
            return redirect("/profile/city");
        }
    }


    public function StreetUpdate(Request $request, $id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Street::find($id);
            if (empty($model)) {
                return back()->with(['errors' => 'یافت نشد!']);
            }
            $validator = Validator::make($request->all(), [
                'province_id' => 'required|exists:provinces,id',
                'city_id' => 'required|exists:cities,id',
                'district_id' => 'required|exists:districts,id',
                'name' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $model->update($inputs);
            $adjacentStreets_ids = $request->adjacent_streets;
            $adjacentDistricts_ids = $request->adjacent_districts;
            if (empty($adjacentStreets_ids)) {
                AdjacentStreet::where('adjacent_street_id' , '>' , 0)->where('street_id' , $id)->delete();
            }
            else
            {
                $adjacentStreets = [];
                foreach ($adjacentStreets_ids as $adjacent_id) {
                    $adjacentStreets[] = ['street_id' => $model->id, 'adjacent_street_id' => $adjacent_id];
                }
                AdjacentStreet::where('adjacent_street_id' , '>' , 0)->where('street_id' , $id)->delete();
                if (!empty($adjacentStreets)) {
                    AdjacentStreet::insert($adjacentStreets);
                }
            }
            if (empty($adjacentDistricts_ids)) {
                AdjacentStreet::where('adjacent_district_id' , '>' , 0)->where('street_id' , $id)->delete();
            }
            else
            {
                $adjacentDistricts = [];
                foreach ($adjacentDistricts_ids as $adjacent_id) {
                    $adjacentDistricts[] = ['street_id' => $model->id, 'adjacent_district_id' => $adjacent_id];
                }
                AdjacentStreet::where('adjacent_district_id' , '>' , 0)->where('street_id' , $id)->delete();
                if (!empty($adjacentDistricts)) {
                    AdjacentStreet::insert($adjacentDistricts);
                }
            }
            if(ss('SITE_ID') == 3 && (int)$inputs['post_id'] == 0)
            {
                $inputpost['title'] = 'خیابان '.$inputs['name'].' '.$model->district->title.' '.$model->city->title;
                $inputpost['category_id'] = 9;
                $post = Post::create( $inputpost );
                $inputs['post_id'] = $post->id;
                $model->update($inputs);
                $ta = array('املاک {0} {1} {2}',
                            'قیمت آپارتمان در {0} {1} {2}',
                            'قیمت منزل ویلایی در {0} {1} {2}',
                            'قیمت زمین در {0} {1} {2}',
                            'قیمت رهن در {0} {1} {2}',
                            'مبلغ اجاره در {0} {1} {2}',
                            'خرید آپارتمان در {0} {1} {2}',
                            'فروش آپارتمان در {0} {1} {2}',
                            'خرید منزل ویلایی در {0} {1} {2}',
                            'فروش منزل ویلایی در {0} {1} {2}',
                            'خرید زمین در {0} {1} {2}',
                            'فروش زمین در {0} {1} {2}',
                            'اجاره آپارتمان در {0} {1} {2}',
                            'رهن آپارتمان در {0} {1} {2}',
                            'اجاره ویلایی در {0} {1} {2}',
                            'رهن ویلایی در {0} {1} {2}',
                            '{0} {1} {2}',
                            );
                foreach($ta as $val)
                {
                    $val = str_replace(array('{0}','{1}','{2}') , array($inputs['name'] , $model->district->title , $model->city->title) , $val);
                    $tag = Tag::where( 'name', $val )->first();
                    if($tag == null)
                    {
                        $tag = Tag::create( [ 'name' => $val ] );
                    }
                    $tagsid[] = $tag->id;
                }

                Taggable::where('taggable_type' , 'exchange_selected')
                        ->where('taggable_id' , $post->id)
                        ->delete();
                if(isset($tagsid))
                {
                    foreach($tagsid as $id)
                    {
                        Taggable::create( [ 'tag_id' => $id, 'taggable_type' => 'App\Model\Post', 'taggable_id' => $post->id] );
                    }
                }
            }
            session()->flash('عملیات بروزرسانی با موفقیت انجام شد.', 'success');
            return redirect('/profile/street');
        }
    }
    public function citystore(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $validator = Validator::make($request->all(), [
                'province_id' => 'required|exists:provinces,id',
                'name' => 'required|unique:cities,name',
            ]);
            //dd($validator->fails());
            if ($validator->fails()) {
                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $model = City::create($inputs);
        // session()->flash('عملیات ثبت با موفقیت انجام شد.', 'success');
            return redirect("/profile/city");
        }
    }
    public function districtstore(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $validator = Validator::make($request->all(), [
                //'province_id' => 'required|exists:provinces,id',
                'city_id' => 'required|exists:cities,id',
                'name' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $model = District::create($inputs);
            // adjacent districts
            $adjacentDistricts = [];
            $adjacent_ids = $request->adjacent_districts;
            if (!empty($adjacent_ids))
            {
                foreach ($adjacent_ids as $adjacent_id) {
                    $adjacentDistricts[] = ['district_id' => $model->id, 'adjacent_district_id' => $adjacent_id];
                }
                if (!empty($adjacentDistricts)) {
                    AdjacentDistrict::insert($adjacentDistricts);
                }

            }
            if(ss('SITE_ID') == 3 && (int)$inputs['post_id'] == 0)
            {
                $inputpost['title'] = 'محله '.$inputs['name'].' '.$model->city->title;
                $inputpost['category_id'] = 9;
                $post = Post::create( $inputpost );
                $inputs['post_id'] = $post->id;
                $model->update($inputs);

                $ta = array('املاک {0} {1} {2}',
                            'قیمت آپارتمان در {0} {1} {2}',
                            'قیمت منزل ویلایی در {0} {1} {2}',
                            'قیمت زمین در {0} {1} {2}',
                            'قیمت رهن در {0} {1} {2}',
                            'مبلغ اجاره در {0} {1} {2}',
                            'خرید آپارتمان در {0} {1} {2}',
                            'فروش آپارتمان در {0} {1} {2}',
                            'خرید منزل ویلایی در {0} {1} {2}',
                            'فروش منزل ویلایی در {0} {1} {2}',
                            'خرید زمین در {0} {1} {2}',
                            'فروش زمین در {0} {1} {2}',
                            'اجاره آپارتمان در {0} {1} {2}',
                            'رهن آپارتمان در {0} {1} {2}',
                            'اجاره ویلایی در {0} {1} {2}',
                            'رهن ویلایی در {0} {1} {2}',
                            '{0} {1} {2}',
                            );
                foreach($ta as $val)
                {
                    $val = str_replace(array('{0}','{1}','{2}') , array('محله '.$inputs['name'] , $model->city->title , '') , $val);
                    $tag = Tag::where( 'name', $val )->first();
                    if($tag == null)
                    {
                        $tag = Tag::create( [ 'name' => $val ] );
                    }
                    $tagsid[] = $tag->id;
                }

                Taggable::where('taggable_type' , 'exchange_selected')
                        ->where('taggable_id' , $post->id)
                        ->delete();
                if(isset($tagsid))
                {
                    foreach($tagsid as $id)
                    {
                        Taggable::create( [ 'tag_id' => $id, 'taggable_type' => 'App\Model\Post', 'taggable_id' => $post->id] );
                    }
                }
            }
            session()->flash('عملیات ثبت با موفقیت انجام شد.', 'success');
            return redirect("/profile/district");
        }
    }
    public function streetstore(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $validator = Validator::make($request->all(), [
                'province_id' => 'required|exists:provinces,id',
                'city_id' => 'required|exists:cities,id',
                'district_id' => 'required',
                'name' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $model = Street::create($inputs);
            $adjacentStreets = [];
            $adjacent_ids = $request->adjacent_streets;
            $adjacentDistricts_ids = $request->adjacent_districts;

            if (!empty($adjacent_ids)) {
                foreach ($adjacent_ids as $adjacent_id) {
                    $adjacentStreets[] = ['street_id' => $model->id, 'adjacent_street_id' => $adjacent_id];
                }
                if (!empty($adjacentStreets)) {
                    AdjacentStreet::insert($adjacentStreets);
                }

            }
            if (!empty($adjacentDistricts_ids)) {
                $adjacentDistricts = [];
                foreach ($adjacentDistricts_ids as $adjacent_id) {
                    $adjacentDistricts[] = ['street_id' => $model->id, 'adjacent_district_id' => $adjacent_id];
                }
                if (!empty($adjacentDistricts)) {
                    AdjacentStreet::insert($adjacentDistricts);
                }
            }

            if(ss('SITE_ID') == 3 && (int)$inputs['post_id'] == 0)
            {
                $inputpost['title'] = 'خیابان '.$inputs['name'].' '.$model->district->title.' '.$model->city->title;
                $inputpost['category_id'] = 9;
                $post = Post::create( $inputpost );
                $inputs['post_id'] = $post->id;
                $model->update($inputs);
                $ta = array('املاک {0} {1} {2}',
                            'قیمت آپارتمان در {0} {1} {2}',
                            'قیمت منزل ویلایی در {0} {1} {2}',
                            'قیمت زمین در {0} {1} {2}',
                            'قیمت رهن در {0} {1} {2}',
                            'مبلغ اجاره در {0} {1} {2}',
                            'خرید آپارتمان در {0} {1} {2}',
                            'فروش آپارتمان در {0} {1} {2}',
                            'خرید منزل ویلایی در {0} {1} {2}',
                            'فروش منزل ویلایی در {0} {1} {2}',
                            'خرید زمین در {0} {1} {2}',
                            'فروش زمین در {0} {1} {2}',
                            'اجاره آپارتمان در {0} {1} {2}',
                            'رهن آپارتمان در {0} {1} {2}',
                            'اجاره ویلایی در {0} {1} {2}',
                            'رهن ویلایی در {0} {1} {2}',
                            '{0} {1} {2}',
                            );
                foreach($ta as $val)
                {
                    $val = str_replace(array('{0}','{1}','{2}') , array($inputs['name'] , $model->district->title , $model->city->title) , $val);
                    $tag = Tag::where( 'name', $val )->first();
                    if($tag == null)
                    {
                        $tag = Tag::create( [ 'name' => $val ] );
                    }
                    $tagsid[] = $tag->id;
                }

                Taggable::where('taggable_type' , 'exchange_selected')
                        ->where('taggable_id' , $post->id)
                        ->delete();
                if(isset($tagsid))
                {
                    foreach($tagsid as $id)
                    {
                        Taggable::create( [ 'tag_id' => $id, 'taggable_type' => 'App\Model\Post', 'taggable_id' => $post->id] );
                    }
                }
            }
            session()->flash('عملیات ثبت با موفقیت انجام شد.', 'success');
            return redirect("/profile/street");
        }
    }
    public function cityedit($id)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $provinces = Province::where( 'active',1 )->get();
            $model =city::where('id',$id)->first();
            $posts = Post::where( 'category_id',10 )->get();
            return view('frontend.province.citycreate', compact('model', 'provinces' , 'posts'));
        }
    }
    public function provinceedit($id)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Province::where('id',$id )->first();
            //$model =city::where('id',$id)->first();
            return view('frontend.province.provincecreate', compact('model'));
        }
    }
    public function districtdestroy($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $ids = explode(',', $id);
            $ids = count($ids) > 1 ? $ids : implode('', $ids);
            if (is_array($ids)) {
                $model = District::whereIn('id', $ids)->get();
                foreach ($model as $item) {
                    $item->delete();
                }
                return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
            }
            $validator = Validator::make(['id' => $ids], [
                'id' => 'required|numeric|exists:districts,id'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'result' => $validator->errors()
                ], config('StatusCode.INVALID_INPUT'));
            }
            $model = District::find($ids);
            $model->delete();
            return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        }
    }
    public function streetdestroy($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $ids = explode(',', $id);
            $ids = count($ids) > 1 ? $ids : implode('', $ids);
            if (is_array($ids)) {
                $model = Street::whereIn('id', $ids)->get();
                foreach ($model as $item) {
                    $item->delete();
                }
                return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
            }
            $validator = Validator::make(['id' => $ids], [
                'id' => 'required|numeric|exists:streets,id'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'result' => $validator->errors()
                ], config('StatusCode.INVALID_INPUT'));
            }
            $model = Street::find($ids);
            $model->delete();
            return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        }
    }
    public function citydestroy($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $ids = explode(',', $id);
            $ids = count($ids) > 1 ? $ids : implode('', $ids);
            if (is_array($ids)) {
                $model = City::whereIn('id', $ids)->get();
                foreach ($model as $item) {
                    $item->delete();
                }
                return response(['status' => 'ok', 'result' => true], config('StatusCode.SUCCESS'));
            }
            $validator = Validator::make(['id' => $ids], [
                'id' => 'required|numeric|exists:cities,id'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'result' => $validator->errors()
                ], config('StatusCode.INVALID_INPUT'));
            }
            $model = City::find($ids);
            $model->delete();
            return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        }
    }
    public function citystatus($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|numeric|exists:cities,id'
            ]);
            if ($validator->fails()) {
                return response([
                    'status' => 'error',
                    'result' => $validator->errors()
                ], config('StatusCode.INVALID_INPUT'));
            }
            $model = City::find($id);
            $model->update(['active' => ($model->active) ? false : true]);
            return response(['status' => 'ok', 'result' => $model->active], config('StatusCode.SUCCESS'));
        }
    }
    public function provincestore( Request $request ) {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $validator = Validator::make( $request->all(), [
                'name' => 'required|min:2|max:64',
            ] );
            if ( $validator->fails() ) {
                return back()->with( [ 'errors' => $validator->errors() ] );
            }
            $model = Province::create( [ 'name' => $request->name ] );
            return redirect('/profile/province/');
        }
	}
	public function provinceupdate( Request $request, $id )
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Province::find( $id );
            if ( empty( $model ) ) {
                return back()->with( [ 'errors' => 'یافت نشد!' ] );
            }
            $validator = Validator::make( $request->all(), [ 'name' => 'required|min:2|max:64' ] );
            if ( $validator->fails() ) {
                return back()->with( [ 'errors' => $validator->errors() ] );
            }
            $model->update( [ 'name' => $request->name ] );
            return redirect("/profile/province");
        }
	}
	public function provincedestroy( $id )
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $ids = explode( ',', $id );
            $ids = count( $ids ) > 1 ? $ids : implode( '', $ids );
            if ( is_array( $ids ) ) {
                $model = Province::whereIn( 'id', $ids )->get();
                foreach ( $model as $item ) {
                    $item->cities()->delete();
                    $item->delete();
                }
                return response()->json( [ 'status' => 'ok', 'result' => 'deleted!' ], config( 'StatusCode.SUCCESS' ) );
            }
            $validator = Validator::make( [ 'id' => $ids ], [
                'id' => 'required|numeric|exists:provinces,id'
            ] );
            if ( $validator->fails() ) {
                return response()->json( [
                    'status' => 'error',
                    'result' => $validator->errors()
                ], config( 'StatusCode.INVALID_INPUT' ) );
            }
            $model = Province::find( $ids );
            $model->cities()->delete();
            $model->delete();
            return response()->json( [ 'status' => 'ok', 'result' => 'deleted!' ], config( 'StatusCode.SUCCESS' ) );
        }
	}
	public function provincestatus( $id ) {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $validator = Validator::make( [ 'id' => $id ], [
                'id' => 'required|numeric|exists:provinces,id'
            ] );
            if ( $validator->fails() ) {
                return response( [
                    'status' => 'error',
                    'result' => $validator->errors()
                ], config( 'StatusCode.INVALID_INPUT' ) );
            }
            $model = Province::find( $id );
            $model->update( [ 'active' => ( $model->active ) ? false : true ] );
            return response( [ 'status' => 'ok', 'result' => $model->active ], config( 'StatusCode.SUCCESS' ) );
        }
	}
    public function districtupdate(Request $request, $id){
        $user = Auth::user();
        if($user->isAdmin())
        {
            if(empty($request->village))
                $request->village = 0;
            //dd($request->village);
            $model = District::find($id);
            if (empty($model)) {
                return back()->with(['errors' => 'یافت نشد!']);
            }
            $validator = Validator::make($request->all(), [
                //'province_id' => 'required|exists:provinces,id',
                'city_id' => 'required|exists:cities,id',
                'name' => 'bail|required',
            ]);
            if ($validator->fails()) {
                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $inputs['village']=$request->village;
            $model->update($inputs);
            // update adjacent districts

            $adjacent_ids = $request->adjacent_districts;
            if (empty($adjacent_ids)) {
                $model->adjacentDistricts()->delete();
            }
            else
            {
                $adjacentDistricts = [];
                foreach ($adjacent_ids as $adjacent_id) {
                    $adjacentDistricts[] = ['district_id' => $model->id, 'adjacent_district_id' => $adjacent_id];
                }
                $model->adjacentDistricts()->delete();
                if (!empty($adjacentDistricts))
                {
                    AdjacentDistrict::insert($adjacentDistricts);
                }

            }
            if(ss('SITE_ID') == 3 && (int)$inputs['post_id'] == 0)
            {
                $inputpost['title'] = 'محله '.$inputs['name'].' '.$model->city->title;
                $inputpost['category_id'] = 9;
                $post = Post::create( $inputpost );
                $inputs['post_id'] = $post->id;
                $model->update($inputs);
                $ta = array('املاک {0} {1} {2}',
                            'قیمت آپارتمان در {0} {1} {2}',
                            'قیمت منزل ویلایی در {0} {1} {2}',
                            'قیمت زمین در {0} {1} {2}',
                            'قیمت رهن در {0} {1} {2}',
                            'مبلغ اجاره در {0} {1} {2}',
                            'خرید آپارتمان در {0} {1} {2}',
                            'فروش آپارتمان در {0} {1} {2}',
                            'خرید منزل ویلایی در {0} {1} {2}',
                            'فروش منزل ویلایی در {0} {1} {2}',
                            'خرید زمین در {0} {1} {2}',
                            'فروش زمین در {0} {1} {2}',
                            'اجاره آپارتمان در {0} {1} {2}',
                            'رهن آپارتمان در {0} {1} {2}',
                            'اجاره ویلایی در {0} {1} {2}',
                            'رهن ویلایی در {0} {1} {2}',
                            '{0} {1} {2}',
                            );
                foreach($ta as $val)
                {
                    $val = str_replace(array('{0}','{1}','{2}') , array('محله '.$inputs['name'] , $model->city->title , '') , $val);
                    $tag = Tag::where( 'name', $val )->first();
                    if($tag == null)
                    {
                        $tag = Tag::create( [ 'name' => $val ] );
                    }
                    $tagsid[] = $tag->id;
                }

                Taggable::where('taggable_type' , 'exchange_selected')
                        ->where('taggable_id' , $post->id)
                        ->delete();
                if(isset($tagsid))
                {
                    foreach($tagsid as $id)
                    {
                        Taggable::create( [ 'tag_id' => $id, 'taggable_type' => 'App\Model\Post', 'taggable_id' => $post->id] );
                    }
                }
            }
            session()->flash('عملیات بروزرسانی با موفقیت انجام شد.', 'success');
            return redirect("/profile/district");
        }
    }
    public function districtcreate(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $provinces = Province::get(['id', 'name']);
            $posts = Post::where( 'category_id',9 )->get();
            return view('frontend.province.districtcreate',compact('provinces' , 'posts'));
        }
    }
    public function streetcreate(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $provinces = Province::get(['id', 'name']);
            $posts = Post::where( 'category_id',9 )->get();
            $cities = [];
            return view('frontend.province.streetcreate',compact('provinces','cities','posts'));
        }
    }
    public function districtedit($id)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = District::with('province', 'city')->find($id);
            if (empty($model)) {
                return back()->withErrors(['یافت نشد!']);
            }
            $provinces = Province::with('cities')->get(['id', 'name']);
            $cities2 = City::where('province_id', $model->province_id)->get(['id', 'name']);
            $districts = District::where('city_id', $model->city_id)->get(['id', 'name']);
            $posts = Post::where( 'category_id',9 )->get();
            $suggestAvgLand = Estate::where('district_id' , $id)->where('type' , 1)->where('percent_expert' , '>' , 0)->whereNotNull('expert_id')->where('estate_type' , 4)->where('updated_at' , '>' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-150 day" ) ) )->where('price_per_meter' , '>' , 0)->avg('price_per_meter');
            $suggestAvgApartment = Estate::where('district_id' , $id)->where('type' , 1)->where('percent_expert' , '>' , 0)->whereNotNull('expert_id')->where('estate_type' , 1)->where('updated_at' , '>' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-150 day" ) ) )->where('price_per_meter' , '>' , 0)->where('built_year','>=', yearhijriago(1))->avg('price_per_meter');
            $suggestAvgApartment5 = Estate::where('district_id' , $id)->where('type' , 1)->where('percent_expert' , '>' , 0)->whereNotNull('expert_id')->where('estate_type' , 1)->where('updated_at' , '>' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-150 day" ) ) )->where('price_per_meter' , '>' , 0)->where('built_year','>=', yearhijriago(5))->avg('price_per_meter');
            $suggestAvgApartment10 = Estate::where('district_id' , $id)->where('type' , 1)->where('percent_expert' , '>' , 0)->whereNotNull('expert_id')->where('estate_type' , 1)->where('updated_at' , '>' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-150 day" ) ) )->where('price_per_meter' , '>' , 0)->where('built_year','>=', yearhijriago(10))->where('built_year','<=', yearhijriago(5))->avg('price_per_meter');

            return view('frontend.province.districtcreate',compact('model', 'provinces', 'cities2', 'districts','posts','suggestAvgLand','suggestAvgApartment','suggestAvgApartment5','suggestAvgApartment10'));
        }
    }
    public function streetedit($id)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Street::with('province', 'city', 'district')->find($id);

            if (empty($model)) {
                return back()->withErrors(['یافت نشد!']);
            }
            $provinces = Province::with('cities')->get(['id', 'name']);
            $cities = City::where('province_id', $model->province_id)->get(['id', 'name']);
            $districts = District::where('city_id', $model->city_id)->get(['id', 'name']);
            $streets = Street::where('district_id', $model->district_id)->get(['id', 'name']);
            $posts = Post::where( 'category_id',9 )->get();
            $suggestAvgLand = Estate::where('street_id' , $id)->where('type' , 1)->where('percent_expert' , '>' , 0)->whereNotNull('expert_id')->where('estate_type' , 4)->where('updated_at' , '>' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-150 day" ) ) )->where('price_per_meter' , '>' , 0)->avg('price_per_meter');
            $suggestAvgApartment = Estate::where('street_id' , $id)->where('type' , 1)->where('percent_expert' , '>' , 0)->whereNotNull('expert_id')->where('estate_type' , 1)->where('updated_at' , '>' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-150 day" ) ) )->where('price_per_meter' , '>' , 0)->where('built_year','>=', yearhijriago(1))->avg('price_per_meter');
            $suggestAvgApartment5 = Estate::where('street_id' , $id)->where('type' , 1)->where('percent_expert' , '>' , 0)->whereNotNull('expert_id')->where('estate_type' , 1)->where('updated_at' , '>' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-150 day" ) ) )->where('price_per_meter' , '>' , 0)->where('built_year','>=', yearhijriago(5))->avg('price_per_meter');
            $suggestAvgApartment10 = Estate::where('street_id' , $id)->where('type' , 1)->where('percent_expert' , '>' , 0)->whereNotNull('expert_id')->where('estate_type' , 1)->where('updated_at' , '>' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-150 day" ) ) )->where('price_per_meter' , '>' , 0)->where('built_year','>=', yearhijriago(10))->where('built_year','<=', yearhijriago(5))->avg('price_per_meter');
            return view('frontend.province.streetcreate', compact('model', 'provinces', 'cities', 'districts' , 'streets','posts','suggestAvgLand','suggestAvgApartment','suggestAvgApartment5','suggestAvgApartment10'));
        }
    }

    public function createTask(Request $request)
    {
        $user = Auth::user();
        if(empty($user)){
            return view('frontend.errors.404');
        }
        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.INVALID_INPUT'));
        }
        $inputs = $request->all();
        $inputs['user_id'] = $user->id;
        //dd($request->time_of_do);
        $inputs['time_of_do']= Verta::parse($request->time_of_do)->formatGregorian('Y-m-d h:i');
        $model = Task::create($inputs);
        return response([
            'status'=>'ok',
            'result'=>1,
            'id'=>$model->id
        ], config('StatusCode.SUCCESS'));
    }
    public function myEstateShow(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        // retrieve estate
        $estates = Estate::with([
            'images',
            'district',
        ]);
        if(ss('SITE_ID') == 3)
        {
            /*if ($user->isAdmin()) {
                // همه ملک‌ها را می‌بیند بجز ملک‌هایی که expert_id دارند و 30 روز از showdate آن‌ها گذشته است
                $estates = $estates->where(function($query) {
                    $query->whereNull('expert_id')
                        ->orWhere('showdate', '>=', now()->subDays(30));
                });
            }
            else*/
            if (!$user->isAdmin() && $user->isExpert()) {
                // ملک‌هایی که showdate آن‌ها قبل از ۳۰ روز است
                // و همچنین ملک‌هایی که بیشتر از ۳۰ روز گذشته ولی expert_id برابر با شناسه کاربر است
                $estates = $estates->where(function($query) use ($user) {
                    $query->where('showdate', '>', now()->subDays(30))
                        ->orWhere(function($q) use ($user) {
                            $q->where('showdate', '<=', now()->subDays(30))
                            ->where('expert_id', $user->id);
                        });
                });
            }
            if (!empty($request->isexpire)) {
                if ($user->isAdmin())
                {
                    if (!empty($request->user_id) && $request->user_id != 2) {
                        $estates = $estates->where('expert_id', $request->user_id)
                                    ->where('showdate', '<=', now()->subDays(30));
                        $estates = $estates->where('percent_expert', '>' , 0);
                        $estates = $estates->where(function ($query) use ($user) {
                            $query->where('expiretime_expert', '>' , date('Y-m-d H:i:s'))
                                ->orWhereNull('expiretime_expert');
                        });
                    }
                    else
                    {
                        // صرفاً ملک‌هایی که expert_id مقدار نداشته باشد و 30 روز از showdate گذشته باشد
                        $estates = $estates/*->whereNull('expert_id')*/
                                        ->where('showdate', '<', now()->subDays(30));
                    }
                }
                elseif ($user->isExpert()) {
                    // صرفاً ملک‌هایی که expert_id برابر خودش باشد و 30 روز از showdate گذشته باشد
                    $estates = $estates->where('expert_id', $user->id)
                                    ->where('showdate', '<=', now()->subDays(30));
                    $estates = $estates->where('percent_expert', '>' , 0);
                    $estates = $estates->where(function ($query) use ($user) {
                        $query->where('expiretime_expert', '>' , date('Y-m-d H:i:s'))
                            ->orWhereNull('expiretime_expert');
                    });
                }
            }
        }
        if($user->isExpert() && $request->order != null && $request->orderby != null)
        {
            $estates = $estates->orderBy($request->order, $request->orderby);
        }
        else
        {
            $estates = $estates->orderBy('id', 'desc');
        }
        if(ss('SITE_ID') != 5 && ss('SITE_ID') != 8 && ss('SITE_ID') != 3)
        {
            $estates = $estates->where('showdate', '>' ,  date("Y-m-d", strtotime("-2 years")));
        }
        if(!empty($request->confirmation))
        {
            if(ss('SITE_ID') == 3)
            {
                if($request->confirmation == 'rejected')
                {
                    $estates=$estates->where('confirmation' , '!=' ,  'verified');
                }
                else
                {
                    $estates=$estates->where('confirmation' , $request->confirmation);
                }
            }
            else
            {
                $estates=$estates->where('confirmation',$request->confirmation);
            }
        }
        if($user->isExpert())
        {
            if($request->visibility != null)
            {
                $estates=$estates->where('visibility',$request->visibility);
            }
        }
        if(!empty($request->estateTypes))
        {
            $estates=$estates->where('estate_type',$request->estateTypes);
        }
        $fieldList = getFeatures(0, 0);
        if (!empty($request->room_count)) {
            $estates = $estates->where('room_count', '>=',  $request->room_count );
        }
        if($user->isAdmin() || $user->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch|expert') ){
            if (!empty($request->create_date_of)) {
                $create_date_of =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->create_date_of);
                $estates = $estates->where('created_at', '>=',  Verta::parse($create_date_of)->formatGregorian('Y-m-d h:i'));
            }
            if (!empty($request->create_date_to)) {
                $create_date_to =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->create_date_to);
                $estates = $estates->where('created_at', '<=',  Verta::parse($create_date_to)->formatGregorian('Y-m-d h:i'));
            }
            if (!empty($request->show_date_of)) {
                $show_date_of =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->show_date_of);
                $estates = $estates->where('published_at', '>=',  Verta::parse($show_date_of)->formatGregorian('Y-m-d h:i'));
            }
            if (!empty($request->show_date_to)) {
                $show_date_to =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->show_date_to);
                $estates = $estates->where('published_at', '<=',  Verta::parse($show_date_to)->formatGregorian('Y-m-d h:i'));
            }
        }
        if (!empty($request->delivery_date_from)) {
            $delivery_date_from =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->delivery_date_from);
            $estates = $estates->where('delivery_date', '>=',  Verta::parse($delivery_date_from)->formatGregorian('Y-m-d'));
        }
        if (!empty($request->delivery_date_to)) {
            $delivery_date_to =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->delivery_date_to);
            $estates = $estates->where('delivery_date', '<=',  Verta::parse($delivery_date_to)->formatGregorian('Y-m-d'));
        }
        if (!empty($request->street_width)) {
            $estates = $estates->where('street_width', '>=',  $request->street_width );
        }
        if (!empty($request->unit_in_complex)) {
            $estates = $estates->where('unit_in_complex', $request->unit_in_complex );
        }
        if (!empty($request->existing_document)) {
            $estates = $estates->where('existing_document', $request->existing_document );
        }
        if (!empty($request->position_type)) {
            $estates = $estates->where('position_type',  $request->position_type );
        }
        if (!empty($request->minArea)) {
            $estates = $estates->where('area', '>=', $request->minArea);
        }
        if (!empty($request->maxArea)) {
            $estates = $estates->where('area', '<=', $request->maxArea);
        }
        if (!empty($request->built_area_min)) {
            $estates = $estates->where('built_area', '>=', $request->built_area_min);
        }
        if (!empty($request->built_area_max)) {
            $estates = $estates->where('built_area', '<=', $request->built_area_max);
        }
        if (!empty($request->exchange)) {
            $estates = $estates->where('exchange', '=',$request->exchange);
        }
        if (!empty($request->exchangetext)) {
            $exchangetext = explode(',' , $request->exchangetext);
            $query = "";
            $query = "SELECT `taggable_id` FROM `taggables` where `tag_id` in ($request->exchangetext) group by `taggable_id` Having count(*) = '".count($exchangetext)."'";

            $lists = DB::select($query);
            foreach($lists as $list)
            {
                $_exchange[] = $list->taggable_id;

            }
            if(is_array($_exchange))
            {
                $estates =$estates->whereIn('id', $_exchange);
            }
        }
        //dd(getQuery($estates));
        // dd(yearhijriago($request->built_year_min));
        if (!empty($request->built_year_min) && $request->built_year_min!=null) {
            $estates =$estates->where('built_year','<=', yearhijriago($request->built_year_min));
        }
        if (!empty($request->built_year_max) && $request->built_year_max!=null) {
                $estates =$estates->where('built_year','>=', yearhijriago($request->built_year_max));
        }
        if(!empty($request->keynot)){
            $estates = $estates->where('keynot',$request->keynot);
        }
        if(!empty($request->floor_start)){
            $estates = $estates->where('floor_start',$request->floor_start);
        }
        if(!empty($request->floor_min)){
            $estates = $estates->where('floor','>=',$request->floor_min);
        }
        if(!empty($request->floor_max)){
            $estates = $estates->where('floor','<=',$request->floor_max);
        }
        if(!empty($request->unit_in_floor)){
            $estates = $estates->where('unit_in_floor' ,'<=', $request->unit_in_floor);
        }
        if(!empty($request->geography)){
            $estates = $estates->where('geography',$request->geography);
        }
        if(!empty($request->build_density)){
            $estates = $estates->where('build_density','>=',$request->build_density);
        }
        if(!empty($request->SeparateVilla)){
            $estates = $estates->where('SeparateVilla',$request->SeparateVilla);
        }
        if(!empty($request->onebuilding)){
            $estates = $estates->where('onebuilding',$request->onebuilding);
        }
        if(!empty($request->urgent)){
            $estates = $estates->where('urgent',$request->urgent);
        }
        // if(!empty($request->title)){
        //     $estates= $estates->where('title', 'LIKE', '%'.$request->title.'%');
        // }
        if (!empty($request->title)) {
            $estates = $estates->where(function ($query) use ($request) {
                $query->where('title', 'like', "%$request->title%")
                    ->orWhere('description', 'like', "%$request->title%");
            });
        }
        if(!empty($request->usage_type)){
            $estates = $estates->where('usage_type',$request->usage_type);
        }
        if(!empty($request->expert_type)){
            if($request->expert_type == 1){
                $estates = $estates->where('percent_expert', '>' , 0);
                $estates = $estates->where(function ($query) use ($user) {
                    $query->where('expiretime_expert', '>' , date('Y-m-d H:i:s'))
                        ->orWhereNull('expiretime_expert');
                });
            }
            if($request->expert_type == 2){
                $estates = $estates->where(function ($query) use ($user) {
                    $query->where('percent_expert' , 0)
                        ->orWhere(function ($query) use ($user) {
                            $query->where('expiretime_expert', '<' , date('Y-m-d H:i:s'))
                                ->whereNotNull('expiretime_expert');
                        });
                });
            }
        }
        if(!empty($request->document_type)){
            $estates = $estates->where('document_type',$request->document_type);
        }
        if(!empty($request->buildingname)){
            $estates = $estates->where('buildingname','like', "%$request->buildingname%");
        }
        if(!empty($request->build_license)){
            $estates = $estates->where('build_license',$request->build_license);
        }
        if(!empty($request->undermetraj)){
            $estates = $estates->where('undermetraj','>',0);
        }
        if(!empty($request->photo)){
            $estates = $estates->whereHas('images', function ($query) {
                $query->where('hidden','=',null)->where('is_360','=',null)->where('plan','=',null);
            });
        }
        if(!empty($request->video)){
            $estates = $estates->where('video','!=',null) ;
        }
        if(!empty($request->vr)){
            $estates = $estates->where(function ($query) use ($request) {
                $query->whereHas('images', function ($query) {
                    $query->where('is_360','=',1);
                })
                ->orWhereNotNull('vrhouse');
            });
            // $estates = $estates->whereHas('images', function ($query) {
            //     $query->where('360','=',1);
            // });
        }
        if(!empty($request->floor_count)){
            $estates = $estates->where('floor_count', $request->floor_count);
        }
        if(!empty($request->balconmetraj)){
            $estates = $estates->where('balconmetraj','>',0);
        }
        if(!empty($request->manufacturer_id)){
            $estates = $estates->where('manufacturer_id',$request->manufacturer_id);
        }
        if(!empty($request->project_id)){
            $estates = $estates->where('project_id',$request->project_id);
        }
        $estates = !empty($request->facilities) ? $estates->whereJsonContains('facilities', $request->facilities) : $estates;
        $estates = !empty($request->conditions) ? $estates->whereJsonContains('conditions', $request->conditions) : $estates;

        $estates = !empty($request->province_id) ? $estates->where('province_id', (int) $request->province_id) : $estates;
        $estates = !empty($request->city_id) && $request->city_id>0 ? $estates->where('city_id', $request->city_id) : $estates;
        $estates = !empty($request->district_id) ? $estates->whereIn('district_id', explode(',', $request->district_id)) : $estates;
        if(!empty($request->area) && $request->area>0){
            $listDistricts = District::where('city_id', $request->city_id)->where('active', 1)->where('area' , $request->area)->get();
            $ldistrict = [];
            foreach($listDistricts as $district)
            {
                $ldistrict[] = $district->id;
            }
            if(count($ldistrict)>0){
                $estates = $estates->whereIn('district_id', $ldistrict);
            }
        }
        $User11=null;
        if (!empty($request->username)) {
            $username=$request->username;
            $estates = $estates->where(function ($query) use ($username) {
                $query->where('phone', $username)->orWhere('phone2', $username);
            });
        }
        if($User11!=null){
            $estates = $estates->where('user_id',$User11->id);
        }
        if (!empty($request->name)) {
            $estates = $estates->where('owner_name', 'like', "%$request->name%");
        }
        if($user->isExpert() || $user->isAdmin())
        {
            if (!empty($request->user_id) && $request->user_id != 2) {
                $estates = $estates->where('expert_id', $request->user_id);
            }
            elseif($request->user_id == 2){
                $estates = $estates->whereNull('expert_id');
            }
        }
        else
        {
            $estates = $estates->where('user_id', $user->id);
        }
        if($request->divar == 1){
            $estates = $estates->where('divar' , '!=' , '');
        }
        if($request->divar == 2){
            $estates = $estates->where('divar' , '=' , '');
        }
        if(!empty($request->favorite)){
            $ef = EstateFavorite::where('user_id', $user->id)->get(['estate_id']);
            $estates = $estates->whereIn('id', $ef);
        }
        if (!empty($request->districts)) {
            $selectedDistricts = explode(",", $request->districts);
            $selectedDistricts = array_map(function ($value) {
                return (int)$value;
            }, $selectedDistricts);
            $estates = $estates->whereHas('district')->whereIn('district_id', $selectedDistricts);
        }
        if (!empty($request->streets)) {
            $selectedStreets = explode(",", $request->streets);
            $selectedStreets = array_map(function ($value) {
                return (int)$value;
            }, $selectedStreets);
            $estates = $estates->whereHas('street')->whereIn('street_id', $selectedStreets);
        }
        $estates = !empty($request->type) ? $estates->where('type', (int) $request->type) : $estates->whereIn('type', [1,2]);
        $estates = !empty($request->id) ? $estates->where('id', (int) $request->id) : $estates;
        if ($request->price) {
            $price = explode(",", $request->price);
            $price = array_map(function ($value) {
                return (int)$value;
            }, $price);
            if (empty($price[1])) {
                $estates->where('price', '>=', $price[0]);
            } elseif (empty($price[0]) && !empty($price[1])) {
                $estates->where('price', '<=', $price[1]);
            } else {
                $estates->whereBetween('price', $price);
            }
        }
        if ($request->price_per_meter) {
            $price_per_meter = explode(",", $request->price_per_meter);
            $price_per_meter = array_map(function ($value) {
                return (int)$value;
            }, $price_per_meter);
            if (empty($price_per_meter[1])) {
                $estates->where('price_per_meter', '>=', $price_per_meter[0]);
            } elseif (empty($price_per_meter[0]) && !empty($price_per_meter[1])) {
                $estates->where('price_per_meter', '<=', $price_per_meter[1]);
            } else {
                $estates->whereBetween('price_per_meter', $price_per_meter);
            }
        }
        // filter mortgage range
        if ($request->mortgage) {
            $mortgage = explode(",", $request->mortgage);
            if (is_array($request->mortgage)) {
                $mortgage = array_map(function ($value) {
                    return (int)$value;
                }, $request->mortgage);
            }
            if ($mortgage[1] == "null" || empty($mortgage[1])) {
                $estates->where('mortgage', '>=', $mortgage[0]);
            } elseif (empty($mortgage[0] || $mortgage[0] == "null") && (!empty($mortgage[1]) || $mortgage[1] != "null")) {
                $estates->where('mortgage', '<=', $mortgage[1]);
            } else {
                $estates->whereBetween('mortgage', $mortgage);
            }
        }
        // filter rent range
        if ($request->rent) {
            $rent = explode(",", $request->rent);
            $rent = array_map(function ($value) {
                return (int)$value;
            }, $rent);
            if ($rent[1] == "null" || empty($rent[1])) {
                $estates->where('rent', '>=', $rent[0]);
            } elseif (empty($rent[0] || $rent[0] == "null") && (!empty($rent[1]) || $rent[1] != "null")) {
                $estates->where('rent', '<=', $rent[1]);
            } else {
                $estates->whereBetween('rent', $rent);
            }
        }
        if ($request->myexpert)
        {
            $userActivityDistricts = UserActivityDistrict::where('user_id' , $user->id)->get();
            if($userActivityDistricts)
            {
                foreach($userActivityDistricts as $userActivityDistrict){
                    $activityDistrict[] = $userActivityDistrict->district_id;
                }
                if(isset($activityDistrict))
                {
                    $estates->whereIn('district_id', $activityDistrict);
                }
            }
            if($user->activity_estate_type != null)
            {
                $estates->whereIn('estate_type', json_decode($user->activity_estate_type));
            }
            $estates = $estates->where(function ($query) use ($user) {
                $query->where('confirmation', 'verified')
                    ->orWhere(
                        function ($query) use ($user) {
                            $query->where('confirmation', 'pending')
                            ->where(
                                function ($query) use ($user) {
                                    $query->where('user_id', $user->id)
                                    ->orWhere(function ($query) use ($user) {
                                    $query->where('expert_id', $user->id)
                                          ->where('expiretime_expert' , '>' , date('Y-m-d H:i:s'));
                                    })->orWhere('expiretime_expert' , '<' ,date('Y-m-d H:i:s'));
                                });
                        }
                    );
            });
            //
        }
        //dd(getQuery($estates));
        if($request->pagesize>0){
            $pagesize = $request->pagesize;
        }
        else
        {
            $pagesize = 9;
        }

        $totalCount=$estates->count();
        //dd(getQuery($estates));
        if ($request->mapexists != 1)
        {
            $estates=$estates->paginate($pagesize);
            //dd($estates);
            $estates->map(function ($item) use ($dt) {
                $item->isExpired = empty($item->expired_at) && $item->expired_at >= $dt ? 1 : 0;
                $firstImage = $item->images->first();
                $item->coverImage = $item->coverImage();
            });
            $couter=$totalCount/$pagesize;
            $couter=(int)$couter;
            $hasPage = ($couter==$request->page)? false : true;
            if($request->page == 1)
            {
                $boolDistrict = $user->districts->whereIn('id',explode(',', $request->district_id))->first() != null;
                $this->addSearch($request);
            }

            if(ss('SITE_ID') == 7)
            {
                $view = view('site7.frontend.profile.my_estate_show_type1', compact('estates','fieldList','totalCount'))->render();
            }
            elseif(env('COUNTRY') != 'UAE')
            {
                $view = view('frontend.profile.my_estate_show_type2', compact('estates','fieldList','totalCount'))->render();
            }
            else
            {
                //dd($fieldList);
                $view = view('site'.ss('SITE_ID').'.frontend.profile.my_estate_show_type1', compact('estates','fieldList','totalCount'))->render();
            }
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        else
        {
            $map = "[";
            $counter = 1;
            $maparray = $estates->whereNotNull("latitude")->get(['id', 'latitude', 'longitude','title','estate_type','area','price']);
            foreach ($maparray as $array) {
                if ($maparray->count() != $counter) {
                    $counter += 1;
                    $map .= "[" . $array->latitude . "," . $array->longitude . "," . $array->id . ",'" .estateTypes($array->estate_type).' - '.$array->area ." متر ". (($array->price>0)?' - '.$array->price.' تومان': '')."<br><br>". $array->title . "'],";
                } else {
                    $map .= "[" . $array->latitude . "," . $array->longitude . "," . $array->id . ",'" .estateTypes($array->estate_type).' - '.$array->area ." متر ". (($array->price>0)?' - '.$array->price.' تومان': '')."<br><br>". $array->title . "']";
                }
            }
            $map .= "]";
            return response()->json(['map' => $map]);
        }
    }
    public function addSearch(Request $request)
    {
        $user = Auth::user();
        // get user agent data
        $agent = new Agent();
        $platform = $agent->platform();
        $platform .= ' ' . $agent->version($platform);
        $browser = $agent->browser();
        $browser .= ' ' . $agent->version($browser);
        $ip = \Request::ip();
        // create or update
        $us = UserSearch::firstOrNew([
            'user_id' => $user->id,
            'type' => 1,
            'url' => $_SERVER["REQUEST_URI"],
        ]);
        $us->title = $request->title;
        $us->ip = $ip;
        $us->agent = $browser;
        $us->device = $platform;
        $us->save();
    }
    public function operationsEstate(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            // datetime
            $dt = Carbon::now();
            // retrieve estate
            $operationsestate = EstateOperation::orderBy('id', 'desc')->where('type','<' ,  10);
            if($user != null && $user->isExpert())
            {
                $operationsestate = $operationsestate->where('expert_id', $user->id);
            }
            $operationsestate = $operationsestate->paginate(20);;
            $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
            $users = $users->whereHas('roles', function ($query) {
                $query->where( 'id', '=', 9);
            })->get(['id', 'name','last_name', 'username','status']);
            $branches = null;
            if(ss('SITE_ID') == 3 || ss('SITE_ID') == 8)
            {
                $branches = Branch::get();
            }
            return view('frontend.profile.operation_estate', compact('operationsestate','users','branches'));
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function operationsEstateShow(Request $request)
    {
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        // retrieve estate
        $operationsEstate = EstateOperation::orderBy($request->order, $request->orderby)->where('type','<' ,  10);
        if(!empty($request->estate_id))
        {
            $operationsEstate = $operationsEstate->where('estate_id',$request->estate_id);
        }
        if(!empty($request->type))
        {
            $operationsEstate = $operationsEstate->where('type',$request->type);
        }
        if (!empty($request->customer_id))
        {
            $operationsEstate = $operationsEstate->where('customer_id', $request->customer_id);
        }
        if($user->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch|expert')){
            if (!empty($request->user_id))
            {
                //$operationsEstate = $operationsEstate->where('expert_id', $request->user_id);
                if($request->user_id < 0)
                {
                    $users = User::where('branch_id' , $request->user_id * -1)->get(['id', 'name','last_name', 'username','status']);
                    foreach($users as $user){
                        $u[] = $user->id;
                    }
                    $operationsEstate = $operationsEstate->whereIn('expert_id', $u);
                }
                else
                {
                    $operationsEstate = $operationsEstate->where('expert_id', $request->user_id);
                }
            }
        }
        else
        {
            $operationsEstate = $operationsEstate->where('expert_id', $user->id);
        }
        //dd($request);
        if($request->datefrom != ''){
            //dd($request->datefrom);
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $operationsEstate = $operationsEstate->where('created_at' , '>=' , jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-'));
            }
            else
            {
                $operationsEstate = $operationsEstate->where('created_at' , '>=' , $request->datefrom);
            }
        }
        if($request->dateto != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $operationsEstate = $operationsEstate->where('created_at' , '<=' , jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59");
            }
            else
            {
                $operationsEstate = $operationsEstate->where('created_at' , '<=' , $request->dateto);
            }
        }
        //dd(getQuery($operationsEstate));
        $totalCount = $operationsEstate->count();
        $operationsEstate = $operationsEstate->paginate(20);
        $couter=$totalCount/20;
        $couter=(int)$couter;
        $hasPage = ($couter==$request->page)? false : true;
        $view = view('frontend.profile.operation_estate_show_type', compact('operationsEstate','totalCount'))->render();
        return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
    }
    public function operationsCustomer(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            // datetime
            $dt = Carbon::now();
            // retrieve estate
            $operationscustomer = EstateOperation::orderBy('id', 'desc')->where('type','>' ,  10);
            if($user != null && $user->isExpert())
            {
                $operationscustomer = $operationscustomer->where('expert_id', $user->id);
            }
            $operationscustomer = $operationscustomer->paginate(20);;
            $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
            $users = $users->whereHas('roles', function ($query) {
                $query->where( 'id', '=', 9);
            })->get(['id', 'name','last_name', 'username','status']);
            $branches = null;
            if(ss('SITE_ID') == 3 || ss('SITE_ID') == 8)
            {
                $branches = Branch::get();
            }
            return view('frontend.profile.operation_customer', compact('operationscustomer','users','branches'));
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function operationsCustomerShow(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        // retrieve estate
        $operationsCustomer = EstateOperation::orderBy($request->order, $request->orderby)->where('type','>' ,  10);
        if(!empty($request->estate_id))
        {
            $operationsCustomer = $operationsCustomer->where('estate_id',$request->estate_id);
        }
        if(!empty($request->type))
        {
            $operationsCustomer = $operationsCustomer->where('type',$request->type);
        }
        if (!empty($request->customer_id))
        {
            $operationsCustomer = $operationsCustomer->where('customer_id', $request->customer_id);
        }
        if($user->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch|expert')){
            if (!empty($request->user_id))
            {
                //$operationsCustomer = $operationsCustomer->where('expert_id', $request->user_id);
                if($request->user_id < 0)
                {
                    $users = User::where('branch_id' , $request->user_id * -1)->get(['id', 'name','last_name', 'username','status']);
                    foreach($users as $user){
                        $u[] = $user->id;
                    }
                    $operationsCustomer = $operationsCustomer->whereIn('expert_id', $u);
                }
                else
                {
                    $operationsCustomer = $operationsCustomer->where('expert_id', $request->user_id);
                }
            }
        }
        else
        {
            $operationsCustomer = $operationsCustomer->where('expert_id', $user->id);
        }
        $totalCount = $operationsCustomer->count();
        $operationsCustomer = $operationsCustomer->paginate(20);
        $couter=$totalCount/20;
        $couter=(int)$couter;
        $hasPage = ($couter==$request->page)? false : true;
        $view = view('frontend.profile.operation_customer_show_type', compact('operationsCustomer','totalCount'))->render();
        return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
    }
    public function phonebook(Request $request)
    {
        $user = Auth::user();
        $PerPage = 20;
        $pageEstate = isset($request->pageEstate) ? $request->pageEstate : 1;
        $OffsetEstate = ($pageEstate - 1) * $PerPage;
        //dd($pageEstate , $OffsetEstate);
        $pageCustomer = isset($request->pageCustomer) ? $request->pageCustomer : 1;
        $OffsetCustomer = ($pageCustomer - 1) * $PerPage;

        $pageUser = isset($request->pageUser) ? $request->pageUser : 1;
        $OffsetUser = ($pageUser - 1) * $PerPage;

        $pagePhonebook = isset($request->pagePhonebook) ? $request->pagePhonebook : 1;
        $OffsetPhonebook = ($pagePhonebook - 1) * $PerPage;
        $similarEstate = Estate::where('visibility', 1)->where('confirmation', 'verified');
        $similarCustomer = Customer::query();
        $similarUser = User::query();
        $similarPhonebook = Phonebook::where(function ($query) use ($user) {
            $query->where('private', 0)->orWhere('createdBy', $user->id);
        });
        $private = 0;
        if(!empty($request->private) && $request->private == 1)
        {
            $similarPhonebook = $similarPhonebook->where('private', 1)->where('createdBy', $user->id);
            $private = 1;
        }
        if($request->phone != '09120000000' && (!empty($request->name) || !empty($request->phone)))
        {
            if(!empty($request->name))
            {

                $similarEstate = $similarEstate->where('owner_name', 'like' , '%'.$request->name.'%');
                $similarCustomer = $similarCustomer->where('name', 'like' , '%'.$request->name.'%');
                $similarUser = $similarUser->where('last_name', 'like' , '%'.$request->name.'%');
                $similarPhonebook = $similarPhonebook->where('name', 'like' , '%'.$request->name.'%');
            }
            if(!empty($request->phone))
            {
                $similarEstate = $similarEstate->where('phone', $request->phone);
                $similarCustomer = $similarCustomer->where('mobile', $request->phone);
                $similarUser = $similarUser->where('username', $request->phone);
                $similarPhonebook = $similarPhonebook->where('phone', $request->phone);
            }

        }
        $totalCountEstate = $similarEstate->count();
        $totalCountCustomer = $similarCustomer->count();
        $totalCountUser = $similarUser->count();
        $totalCountPhonebook = $similarPhonebook->count();
        $modelEstate = $similarEstate->limit($PerPage)->offset($OffsetEstate)->get();
        $modelCustomer = $similarCustomer->limit($PerPage)->offset($OffsetCustomer)->get();
        $modelUser = $similarUser->limit($PerPage)->offset($OffsetUser)->get();
        $modelPhonebook = $similarPhonebook->limit($PerPage)->offset($OffsetPhonebook)->get();

        if ($request->ajax() && ($totalCountEstate > 0 || $totalCountCustomer > 0 || $totalCountUser > 0 || $totalCountPhonebook > 0))
        {
            //dd($totalCount);
            $couterEstate = round($totalCountEstate/20);

            //$hasPage = ($couter==$request->page)? false : true;
            $hasPage = 1;
            $viewEstate = view('frontend.profile.phonebookEstatelist', compact('modelEstate'))->render();
            $viewCustomer = view('frontend.profile.phonebookCustomerlist', compact('modelCustomer'))->render();
            $viewUser = view('frontend.profile.phonebookUserlist', compact('modelUser'))->render();
            $viewPhonebook = view('frontend.profile.phonebookPhonebooklist', compact('modelPhonebook'))->render();
            return response()->json([
                'private' => $private,
                'htmlEstate' => $viewEstate,
                'htmlCustomer' => $viewCustomer,
                'htmlUser' => $viewUser,
                'htmlPhonebook' => $viewPhonebook,
                'hasPage' => $hasPage,
                'totalCountEstate' => $totalCountEstate,
                'totalCountCustomer' => $totalCountCustomer,
                'totalCountUser' => $totalCountUser,
                'totalCountPhonebook' => $totalCountPhonebook]);
        }
        return view('frontend.profile.phonebook', compact('modelEstate' , 'modelCustomer' , 'modelUser' , 'modelPhonebook' , 'private'));

    }
    public function phonebookcreate(Request $request)
    {
        $user = Auth::user();
        if($user->isExpert())
        {
            return view('frontend.profile.phonebookcreate');
        }
    }
    public function phonebookupdate(Request $request, $id)
    {
        $user = Auth::user();
        if($user->isExpert())
        {
            $model = Phonebook::find($id);
            if (empty($model)) {
                return back()->withErrors(['یافت نشد!']);
            }

            $inputs = $request->all();
            $model->update($inputs);
            session()->flash('عملیات بروزرسانی با موفقیت انجام شد.', 'success');
            return redirect("/profile/phonebook");
        }
    }
    public function phonebookstore(Request $request)
    {
        $user = Auth::user();
        if($user->isExpert())
        {

            $inputs = $request->all();
            $inputs['createdBy'] = $user->id;
            $model = Phonebook::create($inputs);
            return redirect("/profile/phonebook");
        }
    }
    public function phonebookedit($id)
    {
        $user = Auth::user();
        if($user->isExpert())
        {
            $model = Phonebook::where('id',$id)->first();
            return view('frontend.profile.phonebookcreate', compact('model'));
        }
    }
    public function phonebookdestroy($id)
    {
        $user = Auth::user();
        if($user->isExpert())
        {
            $model = Phonebook::find($id);
            $model->delete();
            return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        }
    }
    public function report(Request $request)
    {
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            // datetime
            $dt = Carbon::now();
            // retrieve estate
            $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
            $users = $users->whereHas('roles', function ($query) {
                $query->where( 'id', '=', 9);
            })->get(['id', 'name','last_name', 'username','status']);
            $std = strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-30 day" ) ;
            if (env('COUNTRY') == 'UAE')
            {
                $datefrom = date('Y' , $std).'-'.date('m' , $std).'-'.date('d' , $std);
                $dateto = date('Y').'-'.date('m').'-'.date('d');
            }
            else
            {
                $datefrom = gregorian_to_jalali(date('Y' , $std),date('m' , $std),date('d' , $std),'/');
                $dateto = gregorian_to_jalali(date('Y'),date('m'),date('d'),'/');
            }
            $branches = null;
            if(ss('SITE_ID') == 3 || ss('SITE_ID') == 8)
            {
                $branches = Branch::get();
            }
            if(ss('SITE_ID') == 7)
            {
                return view('frontend.profile.report', compact('users','datefrom','dateto'));
            }
            else
            {
                return view('frontend.profile.report', compact('users','datefrom','dateto','branches'));
            }
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function myreport(Request $request)
    {
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            // datetime
            $dt = Carbon::now();
            // retrieve estate
            $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1'])->where('id' , $user->id);
            $users = $users->whereHas('roles', function ($query) {
                $query->whereIn( 'id', [9,10]);
            })->get(['id', 'name','last_name', 'username','status']);
            $std = strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-30 day" ) ;
            $datefrom = gregorian_to_jalali(date('Y' , $std),date('m' , $std),date('d' , $std),'/');
            $dateto = gregorian_to_jalali(date('Y'),date('m'),date('d'),'/');
            $typelist = 'my';
            return view('site7.frontend.profile.report', compact('users','datefrom','dateto','typelist'));
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function reportValue($lists , $request , $_user , $users){
        if($_user == false && $users == false){
            return $lists;
        }
        foreach($users as $user){
            $_user[$user->id] = $user;
            $_userName['search'][$user->id] = 0;
        }
        $totals = 0;
        $usercount = 0;
        foreach($lists as $row)
        {
            $usercount++;
            $totals += $row->count;
            $_userName['search'][$row->expert_id] = $row->count;
        }
        $__ = $_userName['search'];
        arsort($__);
        $count = 0;
        $va = 0;

        foreach($__ as $key => $val)
        {
            if($va != $val){
                $count++;
            }
            if(array_key_exists($key , $_user))
            {
                $report['name'][$key] = $_user[$key]->fullname();
                $report['search'][$key] = (int)$val;
                $report['searchAve'][$key] = sprintf("%.02lf\n", $totals / count($users));
                $report['searchRnk'][$key] = $count;
                $va = $val;
            }
        }
        if($request->user_id > 0)
        {
            if(array_key_exists($request->user_id , $report['name']))
            {
                $report_ = array();
                $report_['name'][$request->user_id] = $report['name'][$request->user_id];
                $report_['search'][$request->user_id] = $report['search'][$request->user_id];
                $report_['searchAve'][$request->user_id] = $report['searchAve'][$request->user_id];
                $report_['searchRnk'][$request->user_id] = $report['searchRnk'][$request->user_id];
                unset($report);
                $report = $report_;
            }
        }

        return $report;
    }
    public function reportSearch($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,count(*) as `count` FROM `user_searches` where user_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            //dd($request->datefrom);
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportSentRelation($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "select `customer_expert_id` as `expert_id` , count(*) as `count` from ( SELECT `status`,`send_at`,`customer_expert_id` FROM `relation_estate_customer` where `send_at` is NOT null and `customer_expert_id` is NOT null and `status` = 3 group by `status`,`send_at`,`customer_expert_id` ) as `rel`
        where `customer_expert_id` in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `send_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `send_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `send_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `send_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `customer_expert_id`";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportViewRelation($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "select `customer_expert_id` as `expert_id` , count(*) as `count` from `relation_estate_customer` where `send_at` is NOT null and `customer_expert_id` is NOT null and `status` = 3 and `seen_estate` = 1 and `customer_expert_id` in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `send_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `send_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `send_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `send_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `customer_expert_id`";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportViewhouse($u , $request , $_user = false , $users = false){
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,count(*) as `count` FROM `estate_user_visits` where user_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        //dd($query);
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportHousing($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,count(*) as `count` FROM `estates` where user_id in (".implode(',' , $u).")  ";
        if(ss('SITE_ID') == 5)
        {
            $query .= " and type=1";
        }
        if($request->datefrom != ''){
            //$datefrom = explode('/',$request->datefrom);
            //$query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportUpdateHousing($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,count(DISTINCT estate_id) as `count` FROM `estate_edits` where user_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportFullUpdate($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,count(*) as `count` FROM `estate_edits` where user_id in (".implode(',' , $u).") and `type` = 'percent_expert' and `changeto` > 0 ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportAdvanced360($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,count(*) as `count` FROM `estate_edits` where user_id in (".implode(',' , $u).") and `type` = 'vrhouse' and `changeto` is not null ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportFilm($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,count(*) as `count` FROM `estate_edits` where user_id in (".implode(',' , $u).") and `type` = 'video' and `changeto` is not null ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportTotalcustomer($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,count(*) as `count` FROM `customers` where user_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportTime($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,sum(`time`)/3600 as `count` FROM `user_time` where user_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportLadder($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,count(*) as `count` FROM `estate_edits` where `type` = 'showdate' and user_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportAdvertisment($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id` as `expert_id`,count(*) as `count` FROM `estate_operations` where `type` = '3' and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportVisit($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id` as `expert_id`,count(*) as `count` FROM `estate_operations` where `type` = '2' and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportMasters($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id` as `expert_id`,count(*)/*count(DISTINCT expert_id)*/ as `count` FROM `estate_operations` where `type` = '1' and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportBuyContract($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT contract_users.`expert_id` as `expert_id`, count(*) as `count` FROM `contract_users` inner join `contracts` on `contracts`.id = contract_users.`contract_id` where `contracts`.`type` = '1' and contract_users.expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= "
        and contract_users.`contract_id` in (select `contract_id` from `contract_users` group by `contract_id` having count(*) = 1)
        group by contract_users.`expert_id` ";

        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportRentContract($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT contract_users.`expert_id` as `expert_id`, count(*) as `count` FROM `contract_users` inner join `contracts` on `contracts`.id = contract_users.`contract_id` where `contracts`.`type` = '2' and contract_users.expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` >= '".$request->datefrom." 00:00:00'";
            }

        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= "
        and contract_users.`contract_id` in (select `contract_id` from `contract_users` group by `contract_id` having count(*) = 1)
        group by contract_users.`expert_id` ";

        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportCommonBuyContract($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT contract_users.`expert_id` as `expert_id`, count(*) as `count` FROM `contract_users` inner join `contracts` on `contracts`.id = contract_users.`contract_id` where `contracts`.`type` = '1' and contract_users.expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= "
        and contract_users.`contract_id` in (select `contract_id` from `contract_users` group by `contract_id` having count(*) > 1)
        group by contract_users.`expert_id` ";
        //dd($query);
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportCommonRentContract($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT contract_users.`expert_id` as `expert_id`, count(*) as `count` FROM `contract_users` inner join `contracts` on `contracts`.id = contract_users.`contract_id` where `contracts`.`type` = '2' and contract_users.expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        //and contract_users.`contract_id` in (select `contract_id` from `contract_users` where `type` = '2' group by `contract_id` having count(*) > 1)
        $query .= "
        and contract_users.`contract_id` in (select `contract_id` from `contract_users` group by `contract_id` having count(*) > 1)
        group by contract_users.`expert_id` ";

        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportUnsuccessContract($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id` as `expert_id`, count(*) as `count` FROM `contract_users` inner join `contracts` on `contracts`.id = contract_users.`contract_id` where contracts.`type` = '3' and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= "

        group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportContract($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id` as `expert_id`, count(*) as `count` FROM `contract_users` inner join `contracts` on `contracts`.id = contract_users.`contract_id` where  expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= "

        group by `expert_id` ";
        //dd($query);
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportMosharekatContract($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id` as `expert_id`, count(*) as `count` FROM `contract_users` inner join `contracts` on `contracts`.id = contract_users.`contract_id` where contracts.`type` = '4' and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= "
        and contract_users.`contract_id` in (select `contract_id` from `contract_users` group by `contract_id` having count(*) = 1)
        group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportCommonMosharekatContract($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id` as `expert_id`, count(*) as `count` FROM `contract_users` inner join `contracts` on `contracts`.id = contract_users.`contract_id` where contracts.`type` = '4' and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= "
        and contract_users.`contract_id` in (select `contract_id` from `contract_users` group by `contract_id` having count(*) > 1)
        group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportTahatorContract($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id` as `expert_id`, count(*) as `count` FROM `contract_users` inner join `contracts` on `contracts`.id = contract_users.`contract_id` where contracts.`type` = '5' and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= "
        and contract_users.`contract_id` in (select `contract_id` from `contract_users` group by `contract_id` having count(*) = 1)
        group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportCommonTahatorContract($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id` as `expert_id`, count(*) as `count` FROM `contract_users` inner join `contracts` on `contracts`.id = contract_users.`contract_id` where contracts.`type` = '5' and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contracts`.`register_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contracts`.`register_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contracts`.`register_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= "
        and contract_users.`contract_id` in (select `contract_id` from `contract_users` group by `contract_id` having count(*) > 1)
        group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportIncome($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT contract_users.expert_id as `expert_id` , sum(contract_parties.commission * expert_commission / 100)/1000000 as `count` FROM `contract_parties` INNER JOIN `contract_users` on contract_parties.contract_id = contract_users.contract_id where 1=1 ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `contract_parties`.`created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contract_parties`.`created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contract_parties`.`created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `contract_parties`.`created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contract_parties`.`created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contract_parties`.`created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportBuyIncome($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT contract_users.expert_id as `expert_id` , sum(contract_parties.commission * expert_commission / 100)/1000000 as `count` FROM `contract_parties` INNER JOIN `contract_users` on contract_parties.contract_id = contract_users.contract_id
        INNER JOIN `contracts` on contract_parties.contract_id = contracts.id where contracts.type in (1,4,5)
        ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `contract_parties`.`created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contract_parties`.`created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contract_parties`.`created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `contract_parties`.`created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contract_parties`.`created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contract_parties`.`created_at` <= '".$request->dateto." 23:29:59'";
            }
        }
        $query .= " group by `expert_id` ";

        $lists = DB::select($query);
        if(count($lists) > 0)
        {
            return $this->reportValue($lists , $request , $_user , $users);
        }
    }
    public function reportRentIncome($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT contract_users.expert_id as `expert_id` , sum(contract_parties.commission * expert_commission / 100)/1000000 as `count` FROM `contract_parties` INNER JOIN `contract_users` on contract_parties.contract_id = contract_users.contract_id
        INNER JOIN `contracts` on contract_parties.contract_id = contracts.id where contracts.type=2";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and contract_parties.created_at >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `contract_parties`.`created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `contract_parties`.`created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and contract_parties.created_at <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `contract_parties`.`created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `contract_parties`.`created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportRelation($u , $request , $_user = false , $users = false)
    {
        $reports = [];
        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        //$users = $users->whereIn('id' ,  implode(',' , $u)) ;
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 9);
        })->orderBy('last_name', 'asc')->orderBy('name', 'asc')->get();
        foreach($users as $user)
        {
            $reports[$user->id]['name'] = $user->fullname();
            $reports[$user->id]['expertid'] = $user->id;
            $reports[$user->id]['sum'] = 0;
            $reports[$user->id][0] = 0;
            $reports[$user->id][1] = 0;
            $reports[$user->id][2] = 0;
            $reports[$user->id][3] = 0;
            $reports[$user->id]['customer'] = 0;
            $reports[$user->id]['p0'] = 0;
            $reports[$user->id]['p1'] = 0;
            $reports[$user->id]['p2'] = 0;
            $reports[$user->id]['p3'] = 0;
        }
        $query = "";
        $query = "SELECT relation_estate_customer.`customer_expert_id`,relation_estate_customer.`status`,count(*) as `count` FROM `relation_estate_customer` inner join `customers` on
        `relation_estate_customer`.customer_id = `customers`.id where customers.`deleted_at` is null and customers.`status` = 1 and
        relation_estate_customer.`deleted_at` is null ";
        if(ss('SITE_ID') == 5)
        {
            $query .= " and relation_estate_customer.priority = 1 ";
        }
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and relation_estate_customer.created_at >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `relation_estate_customer`.`created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `relation_estate_customer`.`created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and relation_estate_customer.created_at <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and relation_estate_customer.created_at <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and relation_estate_customer.created_at <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by relation_estate_customer.`customer_expert_id`,relation_estate_customer.`status` ";

        $lists = DB::select($query);
        $total3 = 0;
        $total2 = 0;
        $total1 = 0;
        $total0 = 0;
        foreach($lists as $list)
        {
            if($list->customer_expert_id>0)
            {
                $reports[$list->customer_expert_id][$list->status] = $list->count;
                /*switch($list->status)
                {
                    case 0:
                        $total0 += $list->count;
                        break;
                    case 1:
                        $total1 += $list->count;
                        break;
                    case 2:
                        $total2 += $list->count;
                        break;
                    case 3:
                        $total3 += $list->count;
                        break;
                }*/
            }
        }

        $query = "";
        $query = "SELECT relation_estate_customer.`customer_expert_id`,count(DISTINCT relation_estate_customer.`customer_id`) as `count` FROM `relation_estate_customer` inner join `customers` on
        `relation_estate_customer`.customer_id = `customers`.id  where customers.`deleted_at` is null and customers.`status` = 1 and
        relation_estate_customer.`deleted_at` is null ";
        if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
        {
            $query .= " and relation_estate_customer.priority = 1 ";
        }
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and relation_estate_customer.created_at >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `relation_estate_customer`.`created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `relation_estate_customer`.`created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and relation_estate_customer.created_at <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and relation_estate_customer.created_at <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and relation_estate_customer.created_at <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by relation_estate_customer.`customer_expert_id`";

        $lists = DB::select($query);
        $customerTotal = 0;
        foreach($lists as $list)
        {
            if($list->customer_expert_id>0)
            {
                $reports[$list->customer_expert_id]['customer'] = $list->count;
                //$customerTotal += $list->count;
            }
        }
        $sumTotal = 0;

        foreach($reports as $key=>$val)
        {
            if(array_key_exists(0, $reports[$key]) && array_key_exists(1, $reports[$key]) && array_key_exists(2, $reports[$key]) && array_key_exists(3, $reports[$key]))
            {
                $reports[$key]['sum'] = $reports[$key][0] + $reports[$key][1] + $reports[$key][2] + $reports[$key][3];
                $sumTotal += $reports[$key]['sum'];
                $total0 += $reports[$key][0];
                $total1 += $reports[$key][1];
                $total2 += $reports[$key][2];
                $total3 += $reports[$key][3];
                $customerTotal += $reports[$key]['customer'];
                /*if($reports[$key]['sum']>0){
                    $reports[$key]['p0'] = sprintf("%.02lf\n",$reports[$key][0] / $reports[$key]['sum'] * 100);
                    $reports[$key]['p1'] = sprintf("%.02lf\n",$reports[$key][1] / $reports[$key]['sum'] * 100) ;
                    $reports[$key]['p2'] = sprintf("%.02lf\n",$reports[$key][2] / $reports[$key]['sum'] * 100);
                    $reports[$key]['p3'] = sprintf("%.02lf\n",$reports[$key][3] / $reports[$key]['sum'] * 100);
                }*/
            }
        }
        $reports['total']['name'] = l('نتیجه کلی');
        $reports['total']['expertid'] = '0';
        $reports['total']['sum'] = $sumTotal;
        $reports['total'][0] = $total0;
        $reports['total'][1] = $total1;
        $reports['total'][2] = $total2;
        $reports['total'][3] = $total3;
        $reports['total']['customer'] = $customerTotal;
        /*if($sumTotal>0){
            $reports['total']['p0'] = sprintf("%.02lf\n",$total0 / $sumTotal * 100);
            $reports['total']['p1'] = sprintf("%.02lf\n",$total1 / $sumTotal * 100);
            $reports['total']['p2'] = sprintf("%.02lf\n",$total2 / $sumTotal * 100);
            $reports['total']['p3'] = sprintf("%.02lf\n",$total3 / $sumTotal * 100);
        }*/
        //dd($reports);
        return $reports;
    }
    public function report360Deg($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,count(DISTINCT estate_id) as `count` FROM `images` where `is_360` > 0 and user_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportImage($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `user_id` as `expert_id`,count(DISTINCT estate_id) as `count` FROM `images` where `is_360` = 0 and user_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `user_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportManagement($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id`,sum(`score`) as `count` FROM `user_operations` where `type` = 5 and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportCover($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id`,sum(`score`) as `count` FROM `user_operations` where `type` = 1 and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `expert_id` ";
        //dd($query);
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportDelay($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id`,sum(`score`) as `count` FROM `user_operations` where `type` = 2 and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportInactivity($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id`,sum(`score`) as `count` FROM `user_operations` where `type` = 3 and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom."'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto."'";
            }
        }
        $query .= " group by `expert_id` ";
        //dd($query);
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportSession($u , $request , $_user = false , $users = false)
    {
        $query = "";
        $query = "SELECT `expert_id`,sum(`score`) as `count` FROM `user_operations` where `type` = 4 and expert_id in (".implode(',' , $u).") ";
        if($request->datefrom != ''){
            // $datefrom = explode('/',$request->datefrom);
            // $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $query .= " and `created_at` >= '".jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00'";
            }
            else
            {
                $query .= " and `created_at` >= '".$request->datefrom." 00:00:00'";
            }
        }
        if($request->dateto != ''){
            // $dateto = explode('/',$request->dateto);
            // $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $query .= " and `created_at` <= '".jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59'";
            }
            else
            {
                $query .= " and `created_at` <= '".$request->dateto." 00:00:00'";
            }
        }
        $query .= " group by `expert_id` ";
        $lists = DB::select($query);
        return $this->reportValue($lists , $request , $_user , $users);
    }
    public function reportShow(Request $request , $havepage = true)
    {
        //return;
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        // retrieve estate
        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 9);
        });

        if(is_int((int)$request->user_id) && (int)$request->user_id < 0){
            $users = $users->where('branch_id' , (int)$request->user_id * -1);

        }
        //
        $users = $users->get(['id', 'name','last_name', 'username','status']);
        if(count($users) == 0)
        {
            return;
        }
        foreach($users as $user){
            $_user[$user->id] = $user;
            $u[] = $user->id;
            $_userName['search'][$user->id] = 0;
        }

        //$usercount = 0;
        //$totals = 0;
        //$query = "";
        $unit = l('تا');
        switch($request->type)
        {
            case "search":
                $title = l('آمار جستجو');
                $unit = l('جستجو');
                $report = $this->reportSearch($u , $request , $_user , $users);
                break;
            case "sentRelation":
                $title = l('آمار پیامک املاک متناسب');
                $unit = l('پیامک املاک متناسب');
                $report = $this->reportSentRelation($u , $request , $_user , $users);
                break;
            case "viewRelation":
                $title = l('آمار مشاهده املاک متناسب');
                $unit = l('مشاهده');
                $report = $this->reportViewRelation($u , $request , $_user , $users);
                break;

            case "viewhouse":
                $title = l('مشاهده ملک');
                $unit = l('مشاهده');
                $report = $this->reportViewhouse($u , $request , $_user , $users);
                break;
            case "updatehouse":
                $title = l('ویرایش ملک');
                $unit = l('ویرایش');
                $report = $this->reportUpdateHousing($u , $request , $_user , $users);
                break;
            case "fullupdate":
                $title = l('ویرایش کامل ملک');
                $unit = l('ویرایش');
                $report = $this->reportFullUpdate($u , $request , $_user , $users);
                break;

            case "housing":
                $title = l('ثبت ملک');
                $unit = l('ثبت ملک');
                $report = $this->reportHousing($u , $request , $_user , $users);
                break;
            case "advanced360":
                $title = l('تور مجازی پیشرفته');
                $unit = l('تور مجازی پیشرفته');
                $report = $this->reportAdvanced360($u , $request , $_user , $users);
                break;
            case "film":
                $title = l('ثبت ملک با فیلم');
                $unit = l('ثبت ملک با فیلم');
                $report = $this->reportFilm($u , $request , $_user , $users);
                break;
            case "image":
                $title = l('عکس');
                $unit = l('عکس');
                $report = $this->reportImage($u , $request , $_user , $users);
                break;
            case "360deg":
                $title = l('ثبت ملک با عکس 360 درجه');
                $unit = l('ثبت ملک');
                $report = $this->report360Deg($u , $request , $_user , $users);
                break;
            case "totalcustomer":
                $title = l('ثبت مشتری');
                $unit = l('ثبت مشتری');
                $report = $this->reportTotalcustomer($u , $request , $_user , $users);
                break;
            case "time":
                $title = l('زمان حضور');
                $unit = l('ساعت');
                $report = $this->reportTime($u , $request , $_user , $users);
                break;
            case "ladder":
                $title = l('نردبان');
                $unit = l('بار');
                $report = $this->reportLadder($u , $request , $_user , $users);
                break;
            case "advertisment":
                $title = l('آگهی شدن املاک');
                $unit = l('بار');
                $report = $this->reportAdvertisment($u , $request , $_user , $users);
                break;
            case "visit":
                $title = l('بازدید ملک همراه با مشتری');
                $unit = l('بار');
                $report = $this->reportVisit($u , $request , $_user , $users);
                break;
            case "masters":
                $title = l('کارشناسی ملک');
                $unit = l('بار');
                $report = $this->reportMasters($u , $request , $_user , $users);
                break;
            case "delay":
                $title = l('تاخیرات');
                $unit = l('امتیاز');
                $report = $this->reportDelay($u , $request , $_user , $users);
                break;
            case "cover":
                $title = l('پوشش');
                $unit = l('امتیاز');
                $report = $this->reportCover($u , $request , $_user , $users);
                break;
            case "management":
                $title = l('امتیاز مدیریت');
                $unit = l('امتیاز');
                $report = $this->reportManagement($u , $request , $_user , $users);
                break;
            case "inactivity":
                $title = l('عدم فعالیت');
                $unit = l('امیتاز');
                $report = $this->reportInactivity($u , $request , $_user , $users);
                break;
            case "session":
                $title = l('جلسه مذاکره حضوری');
                $unit = l('امیتاز');
                $report = $this->reportSession($u , $request , $_user , $users);
                break;
            case "contract":
                $title = l('قرارداد');
                $unit = l('بار');
                $report = $this->reportContract($u , $request , $_user , $users);
                break;
            case "buycontract":
                $title = l('قرارداد خرید و فروش');
                $unit = l('بار');
                $report = $this->reportBuyContract($u , $request , $_user , $users);
                break;
            case "rentcontract":
                $title = l('قرارداد اجاره');
                $unit = l('بار');
                $report = $this->reportRentContract($u , $request , $_user , $users);
                break;
            case "commonbuycontract":
                $title = l('قرارداد خرید و فروش اشتراکی');
                $unit = l('بار');
                $report = $this->reportCommonBuyContract($u , $request , $_user , $users);
                break;
            case "commonrentcontract":
                $title = l('قرارداد اجاره اشتراکی');
                $unit = l('بار');
                $report = $this->reportCommonRentContract($u , $request , $_user , $users);
                break;
            case "unsuccesscontract":
                $title = l('قرارداد ناموق');
                $unit = l('بار');
                $report = $this->reportUnsuccessContract($u , $request , $_user , $users);
                break;
            case "tahatorcontract":
                $title = l('قرارداد تهاتر');
                $unit = l('بار');
                $report = $this->reportTahatorContract($u , $request , $_user , $users);
                break;
            case "mosharekatcontract":
                $title = l('قرارداد مشارکت در ساخت');
                $unit = l('بار');
                $report = $this->reportMosharekatContract($u , $request , $_user , $users);
                break;
            case "commontahatorcontract":
                $title = l('قرارداد تهاتر مشارکتی');
                $unit = l('بار');
                $report = $this->reportCommonTahatorContract($u , $request , $_user , $users);
                break;
            case "commonmosharekatcontract":
                $title = l('قرارداد مشارکت در ساخت مشارکتی' );
                $unit = l('بار');
                $report = $this->reportCommonMosharekatContract($u , $request , $_user , $users);
                break;
            case "income":
                $title = l('درآمد کارشناس');
                $unit = l('تومان');
                $report = $this->reportIncome($u , $request , $_user , $users);
                break;
            case "buyincome":
                $title = l('درآمد خرید و فروش');
                $unit = l('تومان');
                $report = $this->reportBuyIncome($u , $request , $_user , $users);
                break;
            case "rentincome":
                $title = l('درآمد رهن و اجاره');
                $unit = l('تومان');
                $report = $this->reportRentIncome($u , $request , $_user , $users);
                break;
            case "relation":
                $title = l('املاک متناسب');
                $reports = $this->reportRelation($u , $request , $_user , $users);
                $view = view('frontend.profile.report_show_type', compact('reports' ,  'request'))->render();
                return response()->json(['html' => $view]);
                break;
            case "total2":
                $request->income = 1;
            case "total":

                $title = l('آمار کلی کارشناسان');
                $unit = l('امتیاز');
                if($request->user_id > 0 && ((ss('SITE_ID') != 5  && ss('SITE_ID') != 8) || !$havepage))
                {

                    $request->type = "search";
                    $reportSearch = $this->reportSearch($u , $request , $_user , $users);
                    if(count($reportSearch)>0 && array_key_exists($request->user_id , $reportSearch['search'])){
                        $reportSearchCount = $reportSearch['search'][$request->user_id];
                    }
                    else
                    {
                        $reportSearchCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "sentRelation";
                    $reportSentRelation = $this->reportSentRelation($u , $request , $_user , $users);
                    if(count($reportSentRelation)>0 && array_key_exists($request->user_id , $reportSentRelation['search'])){
                        $reportSentRelationCount = $reportSentRelation['search'][$request->user_id];
                    }
                    else
                    {
                        $reportSentRelationCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "viewRelation";
                    $reportViewRelation = $this->reportViewRelation($u , $request , $_user , $users);
                    if(count($reportViewRelation)>0 && array_key_exists($request->user_id , $reportViewRelation['search'])){
                        $reportViewRelationCount = $reportViewRelation['search'][$request->user_id];
                    }
                    else
                    {
                        $reportViewRelationCount = 0;
                    }
                    //////////////////////////////////////////////////////

                    $request->type = "viewhouse";
                    $reportViewhouse = $this->reportViewhouse($u , $request , $_user , $users);
                    if(count($reportViewhouse)>0 && array_key_exists($request->user_id , $reportViewhouse['search'])){
                        $reportViewhouseCount = $reportViewhouse['search'][$request->user_id];
                    }
                    else
                    {
                        $reportViewhouseCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "updatehouse";
                    $reportUpdateHousing = $this->reportUpdateHousing($u , $request , $_user , $users);
                    if(count($reportUpdateHousing)>0 && array_key_exists($request->user_id , $reportUpdateHousing['search'])){
                        $reportUpdateHousingCount = $reportUpdateHousing['search'][$request->user_id];
                    }
                    else
                    {
                        $reportUpdateHousingCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "fullupdate";
                    $reportFullUpdate = $this->reportFullUpdate($u , $request , $_user , $users);
                    if(count($reportFullUpdate)>0 && array_key_exists($request->user_id , $reportFullUpdate['search'])){
                        $reportFullUpdateCount = $reportFullUpdate['search'][$request->user_id];
                    }
                    else
                    {
                        $reportFullUpdateCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "advanced360";
                    $reportAdvanced360 = $this->reportAdvanced360($u , $request , $_user , $users);
                    if(count($reportAdvanced360)>0 && array_key_exists($request->user_id , $reportAdvanced360['search'])){
                        $reportAdvanced360Count = $reportAdvanced360['search'][$request->user_id];
                    }
                    else
                    {
                        $reportAdvanced360Count = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "film";
                    $reportFilm = $this->reportFilm($u , $request , $_user , $users);
                    if(count($reportFilm)>0 && array_key_exists($request->user_id , $reportFilm['search'])){
                        $reportFilmCount = $reportFilm['search'][$request->user_id];
                    }
                    else
                    {
                        $reportFilmCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "image";
                    $reportImage = $this->reportImage($u , $request , $_user , $users);
                    if(count($reportImage)>0 && array_key_exists($request->user_id , $reportImage['search'])){
                        $reportImageCount = $reportImage['search'][$request->user_id];
                    }
                    else
                    {
                        $reportImageCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "housing";
                    $reportHousing = $this->reportHousing($u , $request , $_user , $users);
                    if(count($reportHousing)>0 && array_key_exists($request->user_id , $reportHousing['search'])){
                        $reportHousingCount = $reportHousing['search'][$request->user_id];
                    }
                    else
                    {
                        $reportHousingCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "360deg";
                    $report360Deg = $this->report360Deg($u , $request , $_user , $users);
                    if(count($report360Deg)>0 && array_key_exists($request->user_id , $report360Deg['search'])){
                        $report360DegCount = $report360Deg['search'][$request->user_id];
                    }
                    else
                    {
                        $report360DegCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "buycontract";
                    $reportBuyContract = $this->reportBuyContract($u , $request , $_user , $users);
                    if(count($reportBuyContract)>0 && array_key_exists($request->user_id , $reportBuyContract['search'])){
                        $reportBuyContractCount = $reportBuyContract['search'][$request->user_id];
                    }
                    else
                    {
                        $reportBuyContractCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "rentcontract";
                    $reportRentContract = $this->reportRentContract($u , $request , $_user , $users);
                    if(count($reportRentContract)>0 && array_key_exists($request->user_id , $reportRentContract['search'])){
                        $reportRentContractCount = $reportRentContract['search'][$request->user_id];
                    }
                    else
                    {
                        $reportRentContractCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "commonbuycontract";
                    $reportCommonBuyContract = $this->reportCommonBuyContract($u , $request , $_user , $users);
                    if(count($reportCommonBuyContract)>0 && array_key_exists($request->user_id , $reportCommonBuyContract['search'])){
                        $reportCommonBuyContractCount = $reportCommonBuyContract['search'][$request->user_id];
                    }
                    else
                    {
                        $reportCommonBuyContractCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "commontrentcontract";
                    $reportCommonRentContract = $this->reportCommonRentContract($u , $request , $_user , $users);
                    if(count($reportCommonRentContract)>0 && array_key_exists($request->user_id , $reportCommonRentContract['search'])){
                        $reportCommonRentContractCount = $reportCommonRentContract['search'][$request->user_id];
                    }
                    else
                    {
                        $reportCommonRentContractCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "unsuccesscontract";
                    $reportUnsuccessContract = $this->reportUnsuccessContract($u , $request , $_user , $users);
                    if(count($reportUnsuccessContract)>0 && array_key_exists($request->user_id , $reportUnsuccessContract['search'])){
                        $reportUnsuccessContractCount = $reportUnsuccessContract['search'][$request->user_id];
                    }
                    else
                    {
                        $reportUnsuccessContractCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "contract";
                    $reportContract = $this->reportContract($u , $request , $_user , $users);
                    if(count($reportContract)>0 && array_key_exists($request->user_id , $reportContract['search'])){
                        $reportContractCount = $reportContract['search'][$request->user_id];
                    }
                    else
                    {
                        $reportContractCount = 0;
                    }

                    //////////////////////////////////////////////////////
                    $request->type = "tahatorcontract";
                    $reportTahatorContract = $this->reportTahatorContract($u , $request , $_user , $users);
                    if(count($reportTahatorContract)>0 && array_key_exists($request->user_id , $reportTahatorContract['search'])){
                        $reportTahatorContractCount = $reportTahatorContract['search'][$request->user_id];
                    }
                    else
                    {
                        $reportTahatorContractCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "mosharekatcontract";
                    $reportMosharekatContract = $this->reportMosharekatContract($u , $request , $_user , $users);
                    if(count($reportMosharekatContract)>0 && array_key_exists($request->user_id , $reportMosharekatContract['search'])){
                        $reportMosharekatContractCount = $reportMosharekatContract['search'][$request->user_id];
                    }
                    else
                    {
                        $reportMosharekatContractCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "commontahatorcontract";
                    $reportCommonTahatorContract = $this->reportCommonTahatorContract($u , $request , $_user , $users);
                    if(count($reportCommonTahatorContract)>0 && array_key_exists($request->user_id , $reportCommonTahatorContract['search'])){
                        $reportCommonTahatorContractCount = $reportCommonTahatorContract['search'][$request->user_id];
                    }
                    else
                    {
                        $reportCommonTahatorContractCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "mosharekatcontract";
                    $reportMosharekatContract = $this->reportMosharekatContract($u , $request , $_user , $users);
                    if(count($reportMosharekatContract)>0 && array_key_exists($request->user_id , $reportMosharekatContract['search'])){
                        $reportMosharekatContractCount = $reportMosharekatContract['search'][$request->user_id];
                    }
                    else
                    {
                        $reportMosharekatContractCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "commonmosharekatcontract";
                    $reportCommonMosharekatContract = $this->reportCommonMosharekatContract($u , $request , $_user , $users);
                    if(count($reportCommonMosharekatContract)>0 && array_key_exists($request->user_id , $reportCommonMosharekatContract['search'])){
                        $reportCommonMosharekatContractCount = $reportCommonMosharekatContract['search'][$request->user_id];
                    }
                    else
                    {
                        $reportCommonMosharekatContractCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "income";
                    $reportIncome = $this->reportIncome($u , $request , $_user , $users);
                    if(count($reportIncome)>0 && array_key_exists($request->user_id , $reportIncome['search'])){
                        $reportIncomeCount = $reportIncome['search'][$request->user_id];
                    }
                    else
                    {
                        $reportIncomeCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "buyincome";
                    $reportBuyIncome = $this->reportBuyIncome($u , $request , $_user , $users);
                    if(is_array($reportBuyIncome) && count($reportBuyIncome)>0 && array_key_exists($request->user_id , $reportBuyIncome['search'])){
                        $reportBuyIncomeCount = $reportBuyIncome['search'][$request->user_id];
                    }
                    else
                    {
                        $reportBuyIncomeCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "rentincome";
                    $reportRentIncome = $this->reportRentIncome($u , $request , $_user , $users);
                    if(is_array($reportRentIncome) && count($reportRentIncome)>0 && array_key_exists($request->user_id , $reportRentIncome['search'])){
                        $reportRentIncomeCount = $reportRentIncome['search'][$request->user_id];
                    }
                    else
                    {
                        $reportRentIncomeCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "totalcustomer";
                    $reportTotalcustomer = $this->reportTotalcustomer($u , $request , $_user , $users);
                    if(count($reportTotalcustomer)>0 && array_key_exists($request->user_id , $reportTotalcustomer['search'])){
                        $reportTotalcustomerCount = $reportTotalcustomer['search'][$request->user_id];
                    }
                    else
                    {
                        $reportTotalcustomerCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "time";
                    $reportTime = $this->reportTime($u , $request , $_user , $users);
                    if(count($reportTime)>0 && array_key_exists($request->user_id , $reportTime['search'])){
                        $reportTimeCount = $reportTime['search'][$request->user_id];
                    }
                    else
                    {
                        $reportTimeCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "ladder";
                    $reportLadder = $this->reportLadder($u , $request , $_user , $users);
                    if(count($reportLadder)>0 && array_key_exists($request->user_id , $reportLadder['search'])){
                        $reportLadderCount = $reportLadder['search'][$request->user_id];
                    }
                    else
                    {
                        $reportLadderCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "advertisment";
                    $reportAdvertisment = $this->reportAdvertisment($u , $request , $_user , $users);
                    if(count($reportAdvertisment)>0 && array_key_exists($request->user_id , $reportAdvertisment['search'])){
                        $reportAdvertismentCount = $reportAdvertisment['search'][$request->user_id];
                    }
                    else
                    {
                        $reportAdvertismentCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "visit";
                    $reportVisit = $this->reportVisit($u , $request , $_user , $users);
                    if(count($reportVisit)>0 && array_key_exists($request->user_id , $reportVisit['search'])){
                        $reportVisitCount = $reportVisit['search'][$request->user_id];
                    }
                    else
                    {
                        $reportVisitCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "delay";
                    $reportDelay = $this->reportDelay($u , $request , $_user , $users);
                    if(count($reportDelay)>0 && array_key_exists($request->user_id , $reportDelay['search'])){
                        $reportDelayCount = $reportDelay['search'][$request->user_id];
                    }
                    else
                    {
                        $reportDelayCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "session";
                    $reportSession = $this->reportSession($u , $request , $_user , $users);
                    if(count($reportSession)>0 && array_key_exists($request->user_id , $reportSession['search'])){
                        $reportSessionCount = $reportSession['search'][$request->user_id];
                    }
                    else
                    {
                        $reportSessionCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "cover";
                    $reportCover = $this->reportCover($u , $request , $_user , $users);
                    if(count($reportCover)>0 && array_key_exists($request->user_id , $reportCover['search'])){
                        $reportCoverCount = $reportCover['search'][$request->user_id];
                    }
                    else
                    {
                        $reportCoverCount = 0;
                    }
                    //////////////////////////////////////////////////////

                    $request->type = "management";
                    $reportManagement = $this->reportManagement($u , $request , $_user , $users);
                    if(count($reportManagement)>0 && array_key_exists($request->user_id , $reportManagement['search'])){
                        $reportManagementCount = $reportManagement['search'][$request->user_id];
                    }
                    else
                    {
                        $reportManagementCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "inactivity";
                    $reportInactivity = $this->reportInactivity($u , $request , $_user , $users);
                    if(count($reportInactivity)>0 && array_key_exists($request->user_id , $reportInactivity['search'])){
                        $reportInactivityCount = $reportInactivity['search'][$request->user_id];
                    }
                    else
                    {
                        $reportInactivityCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "masters";
                    $reportMasters = $this->reportMasters($u , $request , $_user , $users);
                    if(count($reportMasters)>0 && array_key_exists($request->user_id , $reportMasters['search'])){
                        $reportMastersCount = $reportMasters['search'][$request->user_id];
                    }
                    else
                    {
                        $reportMastersCount = 0;
                    }
                    //////////////////////////////////////////////////////
                    $request->type = "total";
                    if($havepage)
                    {
                        $view = view('frontend.profile.report_show_type', compact('request' , 'reportSearchCount','reportSentRelationCount','reportViewRelationCount','reportViewhouseCount','reportUpdateHousingCount','reportHousingCount','report360DegCount','reportTotalcustomerCount',
                        'reportTimeCount','reportLadderCount','reportAdvertismentCount','reportVisitCount','reportMastersCount',
                        'reportBuyContractCount','reportRentContractCount','reportCommonBuyContractCount','reportCommonRentContractCount','reportUnsuccessContractCount','reportIncomeCount','reportTahatorContractCount','reportCommonTahatorContractCount','reportMosharekatContractCount','reportCommonMosharekatContractCount','reportSessionCount','reportBuyIncomeCount','reportRentIncomeCount',
                        'reportFullUpdateCount','reportAdvanced360Count','reportFilmCount','reportImageCount','reportDelayCount','reportCoverCount','reportManagementCount','reportInactivityCount','reportBuyIncome','reportRentIncome','reportSession','reportContractCount'
                        ))->render();
                        return response()->json(['html' => $view]);
                    }
                    else
                    {
                        return compact('request' , 'reportSearchCount','reportSentRelationCount','reportViewRelationCount','reportViewhouseCount','reportUpdateHousingCount','reportHousingCount','report360DegCount','reportTotalcustomerCount',
                        'reportTimeCount','reportLadderCount','reportAdvertismentCount','reportVisitCount','reportMastersCount','reportBuyContractCount','reportRentContractCount','reportCommonBuyContractCount','reportCommonRentContractCount','reportUnsuccessContractCount','reportIncomeCount','reportTahatorContractCount','reportCommonTahatorContractCount','reportMosharekatContractCount','reportCommonMosharekatContractCount','reportSessionCount','reportBuyIncomeCount','reportRentIncomeCount',
                        'reportFullUpdateCount','reportAdvanced360Count','reportFilmCount','reportImageCount','reportDelayCount','reportCoverCount','reportManagementCount','reportInactivityCount','reportBuyIncome','reportRentIncome','reportSession','reportContractCount');
                    }
                }
                else
                {
                    $userid = $request->user_id;
                    $request->user_id = '';
                    $unit = l('امتیاز');
                    if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                    {
                        $type = 3;
                    }
                    else
                    {
                        $type = 1;
                    }
                    $zarib = (true)?getsetting2($request->income , 'statictis','housing'):1;
                    if($zarib>0)
                    {
                        $reports = $this->reportHousing($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;

                            }

                        }
                    }
                    //var_dump($_userName['search']['160602']);

                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','sentRelation'):1;
                    if($zarib>0)
                    {
                        $reports = $this->reportSentRelation($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','viewRelation'):0.5;
                    if($zarib>0)
                    {
                        $reports = $this->reportViewRelation($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','search'):1;

                    if($zarib>0)
                    {
                        $reports = $this->reportSearch($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','buyincome'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportBuyIncome($u , $request , $_user , $users);
                        if($reports != null && array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','rentincome'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportRentIncome($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','advanced360'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportAdvanced360($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','ladder'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportLadder($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','film'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportFilm($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','image'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportImage($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','viewhouse'):2;
                    //sdd($zarib);
                    if($zarib>0)
                    {

                        $reports = $this->reportViewhouse($u , $request , $_user , $users);

                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','updatehouse'):3;
                    if($zarib>0)
                    {
                        $reports = $this->reportUpdateHousing($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','income'):3;
                    if($zarib>0)
                    {
                        $reports = $this->reportIncome($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','buycontract'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportBuyContract($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','contract'):10;
                    if($zarib>0)
                    {
                        $reports = $this->reportContract($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','rentcontract'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportRentContract($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','commonbuycontract'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportCommonBuyContract($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','commonrentcontract'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportCommonRentContract($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','unsuccesscontract'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportUnsuccessContract($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','tahatorcontract'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportTahatorContract($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','commontahatorcontract'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportCommonTahatorContract($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','mosharekatcontract'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportMosharekatContract($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','commonmosharekatcontract'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportCommonMosharekatContract($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    $zarib = (true)?getsetting2($request->income , 'statictis','fullupdate'):0;
                    if($zarib>0)
                    {
                        $reports = $this->reportFullUpdate($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','totalcustomer'):1;
                    if($zarib>0)
                    {
                        $reports = $this->reportTotalcustomer($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','masters'):1;
                    if($zarib>0)
                    {
                        $reports = $this->reportMasters($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','visit'):2;
                    if($zarib>0)
                    {
                        $reports = $this->reportVisit($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    //var_dump($_userName['search']['160602']);
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','advertisment'):2;
                    if($zarib>0)
                    {
                        $reports = $this->reportAdvertisment($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    ///////////////////////////////////////////
                    $zarib = (true)?getsetting2($request->income , 'statictis','360Deg'):0;
                    if($zarib>0)
                    {
                        $reports = $this->report360Deg($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $zarib * $val * $sum;
                            }
                        }
                    }
                    ///////////////////////////////////////////
                    if($request->income == 2 || $request->income == 0)
                    {
                        $reports = $this->reportCover($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $val * $sum;
                            }
                        }
                        ///////////////////////////////////////////
                        $reports = $this->reportManagement($u , $request , $_user , $users);
                        if(array_sum($reports['search']) > 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $val * $sum;
                            }
                        }
                        ///////////////////////////////////////////
                        $reports = $this->reportInactivity($u , $request , $_user , $users);
                        if(array_sum($reports['search']) != 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $val * $sum;
                            }
                        }
                        ///////////////////////////////////////////
                        $reports = $this->reportDelay($u , $request , $_user , $users);
                        if(array_sum($reports['search']) != 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $val * $sum;
                            }
                        }
                        ///////////////////////////////////////////
                        $reports = $this->reportSession($u , $request , $_user , $users);
                        if(array_sum($reports['search']) != 0)
                        {
                            switch($type)
                            {
                                case 3:
                                    $sum = 100 / array_sum($reports['search']);
                                    break;
                                case 1:
                                    $sum = 1;
                                    break;
                            }
                            foreach($reports['search'] as $key => $val)
                            {
                                $_userName['search'][$key] += $val * $sum;
                            }
                        }
                    }
                    ///////////////////////////////////////////
                    $report = null;
                    if(isset($_userName))
                    {
                        $__ = $_userName['search'];
                        arsort($__);
                        $count = 0;
                        $va = 0;
                        foreach($__ as $key => $val)
                        {
                            if($va != $val){
                                $count++;
                            }
                            $report['name'][$key] = $_user[$key]->fullname();
                            $report['search'][$key] = (int)$val;
                            $report['searchAve'][$key] = 0;
                            $report['searchRnk'][$key] = $count;
                            $va = $val;
                        }
                        if($userid != null && $userid > 0){
                            $report_ = array();
                            $report_['name'][$userid] = $report['name'][$userid];
                            $report_['search'][$userid] = $report['search'][$userid];
                            $report_['searchAve'][$userid] = $report['searchAve'][$userid];
                            $report_['searchRnk'][$userid] = $report['searchRnk'][$userid];
                            unset($report);
                            $report = $report_;
                        }
                        if($havepage)
                        {
                            $height = count($report['name'])*100 + 150;
                            $view = view('frontend.profile.report_show_type', compact('report' , 'title' , 'height' , 'unit' , 'request'))->render();
                            return response()->json(['html' => $view]);
                        }
                        else
                        {
                            return $report;
                        }
                    }
                }
        }
        // $lists = DB::select($query);
        // foreach($lists as $row)
        // {
        //     $usercount++;
        //     $totals += $row->count;
        //     $_userName['search'][$row->expert_id] = $row->count;
        // }
        // $__ = $_userName['search'];
        // arsort($__);
        // $count = 0;
        // $va = 0;
        // foreach($__ as $key => $val)
        // {
        //     if($va != $val){
        //         $count++;
        //     }
        //     $report['name'][$key] = $_user[$key]->fullname();
        //     $report['search'][$key] = (int)$val;
		// 	$report['searchAve'][$key] = sprintf("%.02lf\n", $totals / count($users));
        //     $report['searchRnk'][$key] = $count;
        //     $va = $val;
        // }
        // if($request->user_id != null){
        //     $report_ = array();
        //     $report_['name'][$request->user_id] = $report['name'][$request->user_id];
        //     $report_['search'][$request->user_id] = $report['search'][$request->user_id];
		// 	$report_['searchAve'][$request->user_id] = $report['searchAve'][$request->user_id];
        //     $report_['searchRnk'][$request->user_id] = $report['searchRnk'][$request->user_id];
        //     unset($report);
        //     $report = $report_;
        // }
        if($havepage)
        {
            $height = count($report['name'])*100 + 150;
            $view = view('frontend.profile.report_show_type', compact('report' , 'title' , 'height' , 'unit' , 'request'))->render();
            return response()->json(['html' => $view]);
        }
        else
        {
            return $report;
        }
    }
    public function estateget($id)
    {
        $user = Auth::user();
        $estate="";
        if($user->isAdmin() || $user->isExpert())
        {
        $estate= Estate::with([
            'expert:id,code,name,last_name,username,photo,phone',
            'user:id,code,name,last_name,username,photo,phone',
            'district','city','street','province'
        ])->where('id', $id )->first();
        }
        return response()->json(['html' => $estate]);
    }
    public function deleteMedia(Request $request, $id)
    {
        Image::where('estate_id', $request->estate_id)->where('id', $id)->delete();
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
    }
    public function edit($id)
    {
        // get auth user
        $user = Auth::user();
        //check role
        if ($user->isAdminLegal()) {
            return redirect('/admin/contracts');
        }
        $model = Contract::with([
            'city:id,name',
            'user:id,name,username',
            'branch',
            'contractUsers',
            'contractUsers.expert:id,name,username',
            'contractParties'
        ])->where('status', '!=', 'verified')->find($id);
        if (empty($model)) {
            return back()->withErrors(['یافت نشد!']);
        }
        if ($user->id != $model->user_id && !$user->hasRole('admin_branch')) {
            return back()->withErrors(['شما مجوز دسترسی به این بخش را ندارید!']);
        }
        $model->register_date = $model->register_at->getTimestamp();
        $cities = City::pluck('name', 'id');
        $branches = Branch::get();
        $adminTrades = null;
//        $adminTrades = User::role(['admin_trades'])->where('has_role', 1)->where('is_admin', 0)->get(['id', 'city_id', 'code', 'name']);
        $users = User::role(['expert'])->where('has_role', 1)->where('is_admin', 0)->get(['id', 'city_id', 'code', 'name']);
        // get branch relations
        $defaultAdminTrades = [];
        $defaultBranch = $model->branch;
        if (!empty($defaultBranch)) {
            $roles = Role::whereIn('name', ['expert', 'intern'])->pluck('id');
            //$adminTrades = $adminTrades->where('city_id', $defaultBranch->city_id);
            $users = $users->where('city_id', $defaultBranch->city_id);
        }
        return view($this->viewPath . '.edit',
            compact(
                'model',
                'cities',
                'branches',
                'adminTrades',
                'users',
                'defaultBranch'
            )
        );
    }
    public function customerget($id)
    {
        $user = Auth::user();
        $customer="";
        if($user->isAdmin() || $user->isExpert())
        {
        $customer=Customer::with([
            'user:id,code,name,last_name,username,photo',
        ])->where('id', $id )->first();
        }
        return response()->json(['html' => $customer]);
    }
    public function destroyOperationEstate($id)
    {
        $user = Auth::user();
        if($user->isAdmin()){
            EstateOperation::where( 'id', $id )->delete();
            return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function relationEstateCustomer(Request $request)
    {
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            // datetime
            $dt = Carbon::now();
            // retrieve estate
            $relationEstateCustomer = RelationEstateCustomer::orderBy('id', 'desc');
            /*if($user != null && ($user->isExpert() || $user->isAdmin()))
            {
                $relationEstateCustomer = $relationEstateCustomer->where('expert_id', $user->id);
            }*/
            $relationEstateCustomer = $relationEstateCustomer->paginate(20);;
            $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
            $users = $users->whereHas('roles', function ($query) {
                $query->where( 'id', '=', 9);
            })->get(['id', 'name','last_name', 'username','status']);
            return view('frontend.profile.relation_estate_customer', compact('relationEstateCustomer','users'));
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function relationEstateCustomerShow(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $type=$request->type;
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        $reports[0] = 0;
        $reports[1] = 0;
        $reports[2] = 0;
        $reports[3] = 0;
        $reports['total'] = 0;
        if($request->show && (ss('SITE_ID') == 8 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2 || env('COUNTRY') == 'UAE'))
        {
            if (!empty($request->customer_id))
            {
                $query = "";
                $query = "SELECT `status`,count(*) as `count` FROM `relation_estate_customer` where `deleted_at` is null
                and `customer_id` = '".$request->customer_id."' ";
                if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                {
                    $query .= " and relation_estate_customer.priority = 1 ";
                }
                $query .= " group by `status`";
                $lists = DB::select($query);
                foreach($lists as $list)
                {
                    $reports[$list->status] = $list->count;
                }
                $reports['total'] = $reports[0] + $reports[1] + $reports[2] + $reports[3];
            }
        }
        // retrieve estate
        $relationEstateCustomer = RelationEstateCustomer::orderBy('priority', 'asc')->orderBy('id', 'desc');
        $relationEstateCustomer = $relationEstateCustomer->orWhereNotNull('estate_id')->where('estate_id' , '>' , 0);
        if(!empty($request->estate_id))
        {
            $relationEstateCustomer = $relationEstateCustomer->where('estate_id',$request->estate_id);
        }
        if (!empty($request->customer_id))
        {
            $relationEstateCustomer = $relationEstateCustomer->where('customer_id', $request->customer_id);
        }
        if (!empty($request->estate_expert_id))
        {
            $relationEstateCustomer = $relationEstateCustomer->where('estate_expert_id', $request->estate_expert_id);
        }
        if (!empty($request->customer_expert_id))
        {
            $relationEstateCustomer = $relationEstateCustomer->where('customer_expert_id', $request->customer_expert_id);
        }
        if ($request->status != "")
        {
            $relationEstateCustomer = $relationEstateCustomer->where('status', $request->status);
        }
        else
        {
            if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
            {
                $relationEstateCustomer = $relationEstateCustomer->where('status' , '!=' , 1);
            }
        }
        if ($request->priority != "")
        {
            $relationEstateCustomer = $relationEstateCustomer->where('priority', $request->priority);
        }

        if (!empty($request->creator))
        {
            if($request->creator == 1)
            {
                $relationEstateCustomer = $relationEstateCustomer->where('creator_id', '>', 0);
            }
            if($request->creator == -1)
            {
                $relationEstateCustomer = $relationEstateCustomer->whereNull('creator_id');
            }
        }
        if (!empty($request->seen_estate))
        {
            if($request->seen_estate == 1)
            {
                $relationEstateCustomer = $relationEstateCustomer->where('seen_estate', 1);
            }
            if($request->seen_estate == 0)
            {
                $relationEstateCustomer = $relationEstateCustomer->whereNull('seen_estate' , 0);
            }
        }
        $showcount = isset($request->showcount) ? $request->showcount : 20;
        $totalCount = $relationEstateCustomer->count();
        $relationEstateCustomer = $relationEstateCustomer->paginate($showcount);
        $couter=$totalCount/$showcount;
        $couter=(int)$couter;
        $hasPage = ($couter==$request->page)? false : true;
        if($request->show)
        {
            $view = view('frontend.profile.relation_estate_customer_show_type2', compact('relationEstateCustomer','totalCount','type','reports'))->render();
        }
        else
        {
            $view = view('frontend.profile.relation_estate_customer_show_type', compact('relationEstateCustomer','totalCount'))->render();
        }
        return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
    }
    public function destroyRelationEstateCustomer($id)
    {
        $user = Auth::user();
        if($user->isAdmin()){
            RelationEstateCustomer::where( 'id', $id )->delete();
        }
        return redirect('/profile/relationEstateCustomer');
    }
    public function confirmRelationEstateCustomer(Request $request)
    {
        $id = $request->id;
        $user = Auth::user();
        if($user->isExpert()){
            $relationEstateCustomer = RelationEstateCustomer::where('id', $id)->first();
            if($relationEstateCustomer)
            {
                if($relationEstateCustomer->customer->user_id == $user->id || $user->isAdmin())
                {
                    RelationEstateCustomer::where('id', $id)->update(['status' => 2 , 'creator_id' => $user->id]);
                    return response()->json(['status' => 'ok', 'result' => 'ladder'], config('StatusCode.SUCCESS'));
                }
            }
        }
        return response()->json(['status' => 'false', 'result' => 'ladder'], config('StatusCode.SUCCESS'));
    }
    public function rejectRelationEstateCustomer(Request $request)
    {
        $id = $request->id;
        $user = Auth::user();
        if($user->isExpert()){
            $relationEstateCustomer = RelationEstateCustomer::where('id', $id)->first();
            if($relationEstateCustomer)
            {
                if($relationEstateCustomer->customer->user_id == $user->id || $user->isAdmin())
                {
                    RelationEstateCustomer::where('id', $id)->update(['status' => 1]);
                }
            }
        }
        return response()->json(['status' => 'ok', 'result' => 'ladder'], config('StatusCode.SUCCESS'));
    }
    public function priorityRelationEstateCustomer(Request $request)
    {
        $id = $request->id;
        $val = $request->val;
        $user = Auth::user();
        if($user->isExpert()){
            $relationEstateCustomer = RelationEstateCustomer::where('id', $id)->first();
            if($relationEstateCustomer->customer->user_id == $user->id  || $user->isAdmin())
            {
                RelationEstateCustomer::where('id', $id)->update(['priority' => $val]);
            }
        }
        return response()->json(['status' => 'ok', 'result' => 'ladder'], config('StatusCode.SUCCESS'));
    }
    public function editsEstate(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $estateEdits = EstateEdit::orderBy('id', 'desc');
            $estateEdits = $estateEdits->paginate(20);;
            $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1'])->get(['id', 'name','last_name', 'username','status']);
            $typeName = array(
                'expertid'=>'کارشناس',
                'price'=>'قیمت',
                'convertible'=>'قابل معاوضه',
                'price_per_meter'=>'قیمت متری',
                'confirmation'=>'وضعیت تایید',
                'latitude_secondary'=>'طول جغرافیایی',
                'longitude_secondary'=>'عرض جغرافیایی',
                'description'=>'توضیحات',
                'owner_name'=>'نام مالک',
                'phone'=>'تلفن',
                'expert_id'=>'کارشناس',
                'deleted_at'=>'تاریخ حذف',
                'showdate'=>'تاریخ بروزرسانی',
                'built_year'=>'سال ساخت',
                'title'=>'عنوان',
                'image_count'=>'تعداد عکس',
                'image_cover'=>'عکس اصلی',
                'isbongah'=>'همکار',
                'evacuation'=>'ملک تخلیه',
                'address'=>'آدرس',
                'build_license'=>'پروانه ساخت',
                'facilities'=>'امکانات ملک',
                'heating_cooling'=>'سرمایش و گرمایش',
                'latitude'=>'طول جغرافیایی',
                'longitude'=>'عرض جغرافیایی',
                'kitchen'=>'آشپزخانه',
                'unit_no'=>'پلاک',
                'exchange'=>'معاوضه',
                'exchange_comment'=>'توضیحات معاوضه',
                'conditions'=>'شرایط',
                'geography'=>'جغرافیا',
                'residence_type'=>'وضعیت سکونت',
                'urgent'=>'فروش فوری',
                'floor_count'=>'تعداد طبقه در ساختمان',
                'unit_in_floor'=>'تعداد واحد در طبقه',
                'token'=>'توکن اگهی ',
                'front_area'=>'متراژ بر ',
                'district_id'=>'محله',
                'usage_type'=>'نوع کاربری',
                'street_width'=>'عرض گذر',
                'build_density'=>'تراکم ساخت',
                'area'=>'مساحت',
                'estate_type'=>'نوع ملک',
                'room_count'=>'تعداد اتاق',
                'document_type'=>'نوع سند',
                'structure_type'=>'نوع سازه',
                'keynot'=>'کلید نخورده',
                'mortgage'=>'مبلغ رهن',
                'rent'=>'مبلغ اجاره',
                'special'=>'اکازیون',
                'vrhouse'=>'vrhouse',
                'default_image'=>'عکس پیش فرض',
                'buildingname'=>'نام مجتمع',
                'SeparateVilla'=>'تعداد واحد مجزا',
                'wc'=>'نوع توالت',
                'position_type'=>'موقعیت مکانی',
                'built_area'=>'مساحت زیربنا',
                'floor_start'=>'شروع طبقات',
                'street_id'=>'خیابان',
                'expiretime_expert'=>'تاریخ پایان کارشناس');
            return view('frontend.profile.edits_estate', compact('estateEdits','users','typeName'));
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function editsEstateShow(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            // retrieve estate
            $estateEdits = EstateEdit::orderBy($request->order, $request->orderby);
            if(!empty($request->estate_id))
            {
                $estateEdits = $estateEdits->where('estate_id',$request->estate_id);
            }
            if (!empty($request->user_id))
            {
                $estateEdits = $estateEdits->where('user_id', $request->user_id);
            }
            if (!empty($request->type))
            {
                $estateEdits = $estateEdits->where('type', $request->type);
            }
            if($request->datefrom != ''){
                //dd($request->datefrom);
                if(env('COUNTRY') != 'UAE')
                {
                    $datefrom = explode('/',$request->datefrom);
                    $estateEdits = $estateEdits->where('created_at' , '>=' , jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-'));
                }
                else
                {
                    $estateEdits = $estateEdits->where('created_at' , '>=' , $request->datefrom);
                }
            }
            if($request->dateto != ''){
                if(env('COUNTRY') != 'UAE')
                {
                    $dateto = explode('/',$request->dateto);
                    $estateEdits = $estateEdits->where('created_at' , '<=' , jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59");
                }
                else
                {
                    $estateEdits = $estateEdits->where('created_at' , '<=' , $request->dateto);
                }
            }

            $totalCount = $estateEdits->count();
            $estateEdits = $estateEdits->paginate(20);
            $couter = $totalCount/20;
            $couter = (int)$couter;
            $hasPage = ($couter==$request->page)? false : true;
            $typeName = array(
            'expertid'=>'کارشناس',
            'price'=>'قیمت',
            'convertible'=>'قابل معاوضه',
            'price_per_meter'=>'قیمت متری',
            'confirmation'=>'وضعیت تایید',
            'latitude_secondary'=>'طول جغرافیایی',
            'longitude_secondary'=>'عرض جغرافیایی',
            'description'=>'توضیحات',
            'owner_name'=>'نام مالک',
            'phone'=>'تلفن',
            'expert_id'=>'کارشناس',
            'deleted_at'=>'تاریخ حذف',
            'showdate'=>'تاریخ بروزرسانی',
            'built_year'=>'سال ساخت',
            'title'=>'عنوان',
            'image_count'=>'تعداد عکس',
            'image_cover'=>'عکس اصلی',
            'isbongah'=>'همکار',
            'evacuation'=>'ملک تخلیه',
            'address'=>'آدرس',
            'build_license'=>'پروانه ساخت',
            'facilities'=>'امکانات ملک',
            'heating_cooling'=>'سرمایش و گرمایش',
            'latitude'=>'طول جغرافیایی',
            'longitude'=>'عرض جغرافیایی',
            'kitchen'=>'آشپزخانه',
            'unit_no'=>'پلاک',
            'exchange'=>'معاوضه',
            'exchange_comment'=>'توضیحات معاوضه',
            'conditions'=>'شرایط',
            'geography'=>'جغرافیا',
            'residence_type'=>'وضعیت سکونت',
            'urgent'=>'فروش فوری',
            'floor_count'=>'تعداد طبقه در ساختمان',
            'unit_in_floor'=>'تعداد واحد در طبقه',
            'token'=>'توکن اگهی ',
            'front_area'=>'متراژ بر ',
            'district_id'=>'محله',
            'usage_type'=>'نوع کاربری',
            'street_width'=>'عرض گذر',
            'build_density'=>'تراکم ساخت',
            'area'=>'مساحت',
            'estate_type'=>'نوع ملک',
            'room_count'=>'تعداد اتاق',
            'document_type'=>'نوع سند',
            'structure_type'=>'نوع سازه',
            'keynot'=>'کلید نخورده',
            'mortgage'=>'مبلغ رهن',
            'rent'=>'مبلغ اجاره',
            'special'=>'اکازیون',
            'vrhouse'=>'vrhouse',
            'default_image'=>'عکس پیش فرض',
            'buildingname'=>'نام مجتمع',
            'SeparateVilla'=>'تعداد واحد مجزا',
            'wc'=>'نوع توالت',
            'position_type'=>'موقعیت مکانی',
            'built_area'=>'مساحت زیربنا',
            'floor_start'=>'شروع طبقات',
            'street_id'=>'خیابان',
            'expiretime_expert'=>'تاریخ پایان کارشناس');
            $view = view('frontend.profile.edits_estate_show_type', compact('estateEdits','typeName','totalCount'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
    }
    public function adManagement(Request $request, $token)
    {
        // auth user
        $user = Auth::user();
        // retrieve estate
        $estate = Estate::with([
            'images',
            'expert',
            'expert.roles',
            'hits'
        ])->where('token', $token)
            //->where('confirmation', 'verified')
            ->first();
        if (!$estate) {
            return view('frontend.errors.404');
        }
        // get estate attributes and features
        $attributesText = $attributesText2 = $features = [];
        // attributesText
        switch ($estate->estate_type) {
            case 1:
                $attributesText = [
                    'مساحت' => $estate->area,
                    'کاربری' => $estate->usage_type ? getSaleFields($estate->estate_type, 'usage_type', $estate->usage_type) : '',
                    'تعداد اتاق' => $estate->room_count,
                ];
                break;
            case 2:
                $attributesText = [
                    'مساحت' => $estate->area,
                    'تعداد طبقه' => $estate->floor_count,
                    'جهت جغرافیایی' => $estate->geography ? getSaleFields($estate->estate_type, 'geography', $estate->geography) : ''
                ];
                break;
            case 3:
                $attributesText = [
                    'مساحت کف' => $estate->floor_area,
                    'متراژ بر' => $estate->front_area,
                    'موقعیت مکانی' => $estate->position_type ? getSaleFields($estate->estate_type, 'position_type', $estate->position_type) : '',
                ];
                break;
            case 4:
                $attributesText = [
                    'مساحت کل' => $estate->area,
                    'متراژ بر' => $estate->front_area,
                    'جهت جغرافیایی' => $estate->geography ? getSaleFields($estate->estate_type, 'geography', $estate->geography) : '',
                ];
                break;
        }
        // attributesText2
        if (in_array($estate->estate_type, [2, 3, 4])) {
            $attributesText2 = [
                'متراژ بر' => $estate->front_area,
                'متراژ گذر' => $estate->street_width,
            ];
        }
        // features
        switch ($estate->estate_type) {
            case 1:
                $features = [
                    'پارکینگ' => 'fa-car',
                    'انباری' => 'fa-warehouse',
                    'آسانسور' => 'fa-sort-circle-down',
                ];
                break;
            case 2:
                $features = [
                    'پارکینگ' => 'fa-car',
                    'انباری' => 'fa-warehouse',
                    'بالکن' => 'fa-window-frame-open'
                ];
                break;
            case 3:
                $features = [
                    'زیرزمین' => 'fa-inventory',
                    'انباری' => 'fa-warehouse',
                    'بالکن' => 'fa-window-frame-open',
                ];
                break;
        }
        $dt = Carbon::now();
        // check expired
        $estate->isExpired = empty($estate->expired_at) || $estate->expired_at >= $dt ? 0 : 1;
        // get cover image
        $firstImage = $estate->images->first();
        $estate->coverImage = $estate->coverImage();
        $hits = $this->hitsChart($estate);
        $templatePage = getTemplatePageWithAds(16);
        return view('frontend.profile.ad_management', compact(
            'estate',
            'attributesText',
            'attributesText2',
            'features',
            'templatePage',
            'hits'
        ));
    }
    public function favoriteEstate(Request $request)
    {
        // auth user
        $user = Auth::user();
        // get current datetime
        $dt = Carbon::now();
        // retrieve estate
        $estates = Estate::whereHas('favorites', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with([
            'images',
            'district',
            'favorites',
        ])->where('confirmation', 'verified')->where('visibility', 1)
            //->where('expired_at', '>=', $dt)
            ->orderBy('published_at', 'desc')
            ->get();
        // get user favorite estates
        $favList = EstateFavorite::where('user_id', $user->id)->whereIn('estate_id', $estates->pluck('id')->toArray() ?? [])->get();
        // iterate on collection
        $estates->map(function ($item) use ($dt, $favList) {
            $fe = $favList->where('estate_id', $item->id)->first();
            $item->pin = $fe && $fe->pin == '1' ? 1 : 0;
            $item->isExpired = $item->expired_at >= $dt ? 0 : 1;
            $firstImage = $item->images->first();
            $item->coverImage = $item->coverImage();
            $item->url = $item->url();
        });
        // sort by pin status
        $estates = $estates->sortByDesc('pin');
        $li[]=0;
        foreach($estates as $e){
            $li[] = $e->id;
        }
        $sharedUrl = url('/').'/profile/bookmark-estate/'.implode(',' , $li);;
        // get template page ads
        $templatePage = getTemplatePageWithAds(8);
        return view('frontend.profile.favorite_estate', compact('estates', 'sharedUrl', 'templatePage'));
    }
    public function bookmarkEstate(Request $request , String $code)
    {
        $list = explode(',',$code);
        foreach($list as $_){
            $_listEstate[] = (int)$_;
        }
        // get current datetime
        $dt = Carbon::now();
        // retrieve estate
        $estates = Estate::with([
            'images',
            'district',
            'favorites',
        ])->where('confirmation', 'verified')->where('visibility', 1)
        ->whereIn('id' , $_listEstate)
            //->where('expired_at', '>=', $dt)
            ->orderBy('published_at', 'desc')
            ->get();
        // get template page ads
        $templatePage = getTemplatePageWithAds(8);
        return view('frontend.profile.bookmark_estate', compact('estates', 'templatePage'));
    }
    public function sharedEstate($tokens)
    {
        // get current datetime
        $dt = Carbon::now();
        // get estate tokens for group sharing
        $tokens = explode(',',$tokens);
        if(empty($tokens)){
            return view('frontend.errors.404');
        }
        // retrieve estate
        $estates = Estate::with([
            'images',
            'district',
        ])->whereIn('token', array_unique($tokens))
            ->where('confirmation', 'verified')
            ->where('visibility', 1)
            //->where('expired_at', '>=', $dt)
            ->orderBy('published_at', 'desc')
            ->get();
        if(!$estates){
            return view('frontend.errors.404');
        }
        $estates->map(function ($item) {
            $firstImage = $item->images->first();
            $item->coverImage = $item->coverImage();
            $item->url = '/v/' . $item->id . '/' . $item->link_rewrite;
        });
        return view('frontend.shared_estate.index', compact('estates'));
    }
    public function history(Request $request)
    {
        $estateIds = $_COOKIE['esids'] ?? [];
        $estateIds = !empty($estateIds) ? json_decode($estateIds) : [];
        // auth user
        $user = Auth::user();
        $dt = Carbon::now();
        // retrieve estate
        $estates = Estate::with([
            'images',
            'district',
        ])->where('confirmation', 'verified')
            ->where('visibility', 1)
            ->whereIn('id', $estateIds)
            //->where('expired_at', '>=', $dt)
            //->orderBy('published_at', 'desc')
            ->get();
        // iterate on collection
        $estates->map(function ($item) use ($dt) {
            $item->isExpired = $item->expired_at >= $dt ? 0 : 1;
            $firstImage = $item->images->first();
            $item->coverImage = $item->coverImage();
            $item->url = '/v/' . $item->id . '/' . $item->link_rewrite;
        });
        $templatePage = getTemplatePageWithAds(12);
        return view('frontend.profile.history', compact('estates', 'templatePage'));
    }
    public function myNotes(Request $request)
    {
        // auth user
        $user = Auth::user();
        $dt = Carbon::now();
        // retrieve estate
        $estates = Estate::whereHas('notes', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with([
            'images',
            'district',
            'notes',
        ])->where('confirmation', 'verified')->where('visibility', 1)
            //->where('expired_at', '>=', $dt)
            ->orderBy('published_at', 'desc')
            ->get();
        // get user notes
        $noteList = EstateNote::where('user_id', $user->id)->whereIn('estate_id', $estates->pluck('id')->toArray() ?? [])->get();
        // iterate on collection
        $estates->map(function ($item) use ($noteList) {
            $note = $noteList->where('estate_id', $item->id)->first();
            $item->note = $note ?? null;
            $firstImage = $item->images->first();
            $item->coverImage = $item->coverImage();
            $item->url = '/v/' . $item->id . '/' . $item->link_rewrite;
        });
        $templatePage = getTemplatePageWithAds(11);
        return view('frontend.profile.my_note', compact('estates', 'templatePage'));
    }
    public function deleteNote($id)
    {
        // auth user
        $user = Auth::user();
        $estateNote = EstateNote::where('user_id', $user->id)->find($id);
        $status = 0;
        if ($estateNote) {
            $estateNote->delete();
            $status = 1;
        }
        return response([
            'status' => 'ok',
            'result' => $status
        ], config('StatusCode.SUCCESS'));
    }
    public function savedSearch(Request $request)
    {
        // auth user
        $user = Auth::user();
        $searches = UserSearch::where('user_id', $user->id)->where('type', 1)->get();
        $templatePage = getTemplatePageWithAds(10);
        return view('frontend.profile.saved_search', compact('searches', 'templatePage'));
    }
    public function deleteSavedSearch($id)
    {
        // auth user
        $user = Auth::user();
        $userSearch = UserSearch::where('user_id', $user->id)->find($id);
        $status = 0;
        if ($userSearch) {
            $userSearch->delete();
            $status = 1;
        }
        return response([
            'status' => 'ok',
            'result' => $status
        ], config('StatusCode.SUCCESS'));
    }
    public function getProfile()
    {
        // auth user
        $user = Auth::user();
        if (!$user) {
            return view('frontend.errors.404');
        }
        $user->birthday_jalali = null;
        if ( ! empty( $user->birthday ) && $user->birthday != '0000-00-00') {
            $dt= new Verta( $user->birthday );
            $user->birthday_jalali = $dt->formatJalaliDate();
        }
        $user->activity_estate_type = (array)json_decode($user->activity_estate_type);
        $templatePage = getTemplatePageWithAds(17);
        $districts = District::where('city_id',$user->city_id)->get();
        $selectedDistricts = [];
        $user->district_ids = $user->districts()->pluck('district_id');
        $user->selectedDistricts = $user->districts()->orderByDesc('selection_count')->pluck('selection_count','district_id')->toArray();
        if(!empty($user->selectedDistricts)){
            $selectedDistricts = array_map(function ($val){
                return (int) $val;
            },$user->selectedDistricts);
        }
        if($user->isExpert())
        {
            return view('frontend.profile.info_expert_edit', compact('user', 'templatePage' , 'districts'  , 'selectedDistricts'));
        }
        else
        {
           return view('frontend.profile.info_edit', compact('user', 'templatePage'));
        }
    }
    function search1($user2,$level,$counter,$counter1){
        $counter+=1;
        if($counter==$level)
            return $counter1;
        $list1=User::whereIn('parent_id',$user2)->get();
        $arraylist=$list1->pluck('id')->toarray();
        //$counter1=$list1->count();
        $this->arraylevel[$counter]=$list1->count();
        return $this->search1($arraylist,$level,$counter,$counter1);
    }
    public function updateProfile1(Request $request)
    {
        //dd($request->all());
        // auth user
        $user = Auth::user();
        // check exists
        if (!$user) {
            return view('frontend.errors.404');
        }
        // validation
        $validator = Validator::make($request->all(), [
            'photo' => 'nullable|max:2048'
        ]);
        if ($validator->fails()) {
            return back()->with(['errors' => $validator->errors()]);
        }
        /*$user->update([
            'photo' => $photo,
            'alias_status' => ($user->alias!=$request->alias&&$user->alias_status==0)?1:0 ,
            'alias' => $user->alias!=$request->alias&&$user->alias_status==0?$request->alias:$user->alias
        ]);*/
        $inputs = $request->all();
        // profile photo
       //  dd($request->photoshow,$request->profile_covershow);
      // dd('$photo');
        if ( $request->images1) {
            $folderPath = public_path('upload/images/profile/');
            $image_parts = explode(";base64,", $request->images1);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            if($image_type=="png" || $image_type=="jpg" || $image_type=="jpeg"){
                $image_base64 = base64_decode($image_parts[1]);
                $fileupload=uniqid().".". $image_type;
                $file = $folderPath . $fileupload;
                file_put_contents($file, $image_base64);
                $inputs['photo'] = $fileupload;
                $inputs['photoStatus']=1;
            }
        }
        else if($request->photoshow==1)
        {
            $inputs['photo'] = null;
            $inputs['photoStatus']=0;
        }
        if ( $request->images2) {
            $folderPath = public_path('upload/images/profile/');
            $image_parts = explode(";base64,", $request->images2);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            if($image_type=="png" || $image_type=="jpg" || $image_type=="jpeg"){
                $image_base64 = base64_decode($image_parts[1]);
                //$image_base64=resize_image($image_base64, 500, 500);
                $fileupload=uniqid() .".". $image_type;
                $file = $folderPath . $fileupload;
                file_put_contents($file, $image_base64);
                $inputs['profile_cover'] = $fileupload;
            }
        }
        else if($request->profile_covershow==1)
        {
            $inputs['profile_cover'] = null;
        }
        $request->activity_estate_type = array_map('intval', explode(',', substr($request->activity_estate_type, 0,strlen($request->activity_estate_type)-1)));
        $inputs['activity_estate_type'] = !empty($request->activity_estate_type) ? json_encode($request->activity_estate_type) : $user->activity_estate_type;
        //dd($inputs['activity_estate_type']);
        //dd($request->all());
        $inputs['alias_status'] = ($user->alias!=$request->alias&&$user->alias_status==0)?1:0;
        $inputs['alias']=$user->alias!=$request->alias&&$user->alias_status==0?$request->alias:$user->alias;
        $birthday = null;
        if (!empty($request->birthday)) {
            // convert date
            $birthday = Verta::parse($request->birthday)->DateTime()->format('Y-m-d');
            try {
                $birthday = new Carbon($birthday);
            } catch (\Exception $e) {
            }
        }
        $inputs['birthday']=$birthday;
        $user->update($inputs);
        if(strlen($request->districts)>1){
            $request->districts = array_map('intval', explode(',', substr($request->districts, 0,strlen($request->districts)-1)));
            $district_ids = $request->districts;
            if ( empty( $district_ids ) ) {
                UserActivityDistrict::where('user_id',$user->id)->delete();
            } else {
                // get count
                $selectedList = array_count_values($district_ids);
                $districts=[];
                foreach ( $selectedList as $districtId => $selectedCount ) {
                    $percentValue = ($selectedCount * 100) / count($district_ids);
                    $districts[] = [ 'user_id' => $user->id, 'district_id' => $districtId, 'selection_count'=> $selectedCount, 'ratio'=> $percentValue];
                }
                UserActivityDistrict::where('user_id',$user->id)->delete();
                UserActivityDistrict::insert( $districts );
            }
        }
        return back()->with( 'success', l('اطلاعات شما با موفقیت بروزرسانی شد.') );
    }
    public function info2()
    {
        $defaultCity  = $_COOKIE['city'] ?? ss('DEFAULT_CITY');
        $city = City::with(['districts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])
            ->where('name_en', $defaultCity)
            ->where('active', 1)
            ->first();
            //$districts="[";
            $districts = [];
            $districtsId = [];
            if($city != null)
            {
                $districts = $city->districts->pluck('name')->toArray();
                $districtsId = $city->districts->pluck('id')->toArray();
            }
            /*$counter=1;
            foreach($districts1 as $array)
            {
                if($districts1->count()!=$counter){
                    $counter+=1;
                    $districts.='['.$array->id.','.$array->name.'],';
                }
                else
                {
                    $districts.='['.$array->id.','.$array->name.']';
                }
            }
            $districts.="],";
*/
        $user = Auth::user();
        if (!$user) {
            return view('frontend.errors.404');
        }
        $user->birthday_jalali = null;
        if ( ! empty( $user->birthday ) && $user->birthday != '0000-00-00') {
            $dt       = new Verta( $user->birthday );
            $user->birthday_jalali = $dt->formatJalaliDate();
        }
        $user->activity_estate_type = (array)json_decode($user->activity_estate_type);
        $templatePage = getTemplatePageWithAds(17);
        $selectedDistricts = [];
        $user->district_ids = $user->districts()->pluck('district_id');
        $user->selectedDistricts = $user->districts()->orderByDesc('selection_count')->pluck('selection_count','district_id')->toArray();
        if(!empty($user->selectedDistricts)){
            $selectedDistricts = array_map(function ($val){
                return (int) $val;
            },$user->selectedDistricts);
        }
        $activity= [];
        foreach($user->activity_estate_type as $_){
            $activity[$_] =1;
        }
        $language_ids = [];
        $languages = '';
        if (env('COUNTRY') == 'UAE')
        {
            $user->language_ids = $user->languages()->pluck('language_id');
            $languages = Language::get(['id','name']);
            foreach($user->language_ids as $_){
                $language_ids[] = $_;
            }
        }
        if($user->isExpert() || 1)
        {
            return view('frontend.profile.info_edit_v2',compact('districts','districtsId','selectedDistricts','activity', 'languages' , 'language_ids'));
        }
        // else
        // {
        //    return view('frontend.profile.info_edit_user_v2', compact('user', 'templatePage'));
        // }
    }
    public function updateProfile(Request $request)
    {
        // auth user
        $user = Auth::user();
        // check exists
        if (!$user) {
            return view('frontend.errors.404');
        }
        // validation
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|max:2048'
        ]);
        if ($validator->fails()) {
            return back()->with(['errors' => $validator->errors()]);
        }
        /*$user->update([
            'photo' => $photo,
            'alias_status' => ($user->alias!=$request->alias&&$user->alias_status==0)?1:0 ,
            'alias' => $user->alias!=$request->alias&&$user->alias_status==0?$request->alias:$user->alias
        ]);*/
        //dd($request);
        $inputs = $request->all();
        if ($request->bio!=$user->bio) {
            $inputs['status_bio']=1;
            //$inputs['bio']=$request->bio;
            $inputs['temp_bio']=$request->bio;
            $inputs['bio']=$user->bio;
        }
        $inputs['experience']=$request->experience;
        if ( $request->images1) {
            $folderPath = base_path(env('PUBLIC_PATH').'/upload/images/profile/');
            $image_parts = explode(";base64,", $request->images1);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            if($image_type=="png" || $image_type=="jpg" || $image_type=="jpeg"){
                $image_base64 = base64_decode($image_parts[1]);
                $fileupload=uniqid().".". $image_type;
                $file = $folderPath . $fileupload;
                file_put_contents($file, $image_base64);
                $inputs['photo'] = $fileupload;
                $inputs['photoStatus']=1;
            }
        }
        else if($request->photoshow==1)
        {
            $inputs['photo'] = null;
            $inputs['photoStatus']=0;
        }

        if ( ! empty( $inputs['profile_cover'] ) ) {
            $photoCover= uploader( $request, 'profile_cover','images/profile' );
            $inputs['profile_cover'] = $photoCover;
        }
        else if($request->photocover==1)
        {
            $inputs['profile_cover'] = null;
        }

        if(!empty($request->password)){
            if($request->password==$request->password_confirmation){
                $inputs['password']=bcrypt($request->password);
                $inputs['change_password']= 0 ;
                $inputs['has_password']= 1;
            }
            else
            {
                $inputs['password']=$user->password;
            }
        }
        else if(!empty($user->password)){
            $inputs['password']=$user->password;
        }
        if ($request->bio!=$user->bio) {
            $inputs['status_bio']=1;
            //$inputs['bio']=$request->bio;
            $inputs['temp_bio']=$request->bio;
            $inputs['bio']=$user->bio;
       }
        //$inputs['activity_estate_type'] = !empty($request->activity_estate_type) ? json_encode($request->activity_estate_type) : $user->activity_estate_type;
        $inputs['activity_estate_type'] = json_encode($request->activity_estate_type);
        $inputs['alias_status'] = ($user->alias!=$request->alias&&$user->alias_status==0)?1:0;
        $inputs['activity_type']=$request->activity_type??1;
        $inputs['alias']=$user->alias!=$request->alias&&$user->alias_status==0?$request->alias:$user->alias;
        $birthday = null;
        if (!empty($request->birthday)) {
            // convert date
            $birthday = Verta::parse($request->birthday)->DateTime()->format('Y-m-d');
            try {
                $birthday = new Carbon($birthday);
            } catch (\Exception $e) {
            }
        }
        $inputs['birthday']=$birthday;
        if(!empty($request->video)){
            $vid="";
            $video = explode("/", $request->video);
            if(!empty($video[4])){
                $vid=explode("?",$video[4]);
                if(!empty($vid[0])){
                    $inputs['video'] =$vid[0];
                }
            }
        }
        //dd($inputs);
        $user->update($inputs);
        if (env('COUNTRY') == 'UAE')
        {
            if(!empty($request->get('languages'))){
                $langIds = $request->get('languages');
                $user->languages()->sync( $langIds );
            }
        }
        $district_ids = $request->districts;
        if ( empty( $district_ids ) ) {
            UserActivityDistrict::where('user_id',$user->id)->delete();
        } else {
            // get count
            $selectedList = array_count_values($district_ids);
            $districts=[];
            foreach ( $selectedList as $districtId => $selectedCount ) {
                $percentValue = ($selectedCount * 100) / count($district_ids);
                $districts[] = [ 'user_id' => $user->id, 'district_id' => $districtId, 'selection_count'=> $selectedCount, 'ratio'=> $percentValue];
            }
            UserActivityDistrict::where('user_id',$user->id)->delete();
            UserActivityDistrict::insert( $districts );
        }
        return back()->with( 'success', l('اطلاعات شما با موفقیت بروزرسانی شد.') );
    }
    public function getChangePasswordForm(){
        // auth user
        $user = Auth::user();
        if (!$user) {
            return view('frontend.errors.404');
        }
        $templatePage = getTemplatePageWithAds(17);
        return view('frontend.profile.change_password', compact('user', 'templatePage'));
    }
    public function changePassword( Request $request ) {
        $user = Auth::user();
        $validator = Validator::make( $request->all(), [
            'password' => 'required|min:6|confirmed',
        ]);
        if ( $validator->fails() ) {
            return back()->with( [ 'errors' => $validator->errors() ] );
        }
        $user->update( [
            'password' => bcrypt( $request->password ),
            'change_password' => 0 ,
            'has_password' => 1
        ] );
        return redirect('/');
        //return back()->with( 'success', 'رمز عبور شما با موفقیت تغییر یافت.' );
    }
}
