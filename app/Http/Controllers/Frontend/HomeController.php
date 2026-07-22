<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use App\Models\Estate;
use App\Models\District;
use App\Models\Customer;
use App\Models\Post;
use App\Models\Agents;
use App\Models\RelationEstateCustomer;
use App\Models\Category;
use App\Models\SearchKeyword;
use App\Models\Slide;
use App\Models\Project;
use App\Models\Branch;
use App\Models\LogExpert;
use App\Models\Sms;
use App\Models\NotificationLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use App\Models\FeatureValue;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function cropjs(Request $request) {
        return view( 'test1.index');
    }
    public function cropjs1(Request $request){
        $folderPath = public_path('upload/');
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.png';
        file_put_contents($file, $image_base64);
        //return view( 'frontend.intro.show');
        return response()->json(['success'=>'success']);
    }
    public function show1(Request $request) {
        return view( 'frontend.intro.show');
    }
    public function about(Request $request){
        return view( 'frontend.help.about');
    }
    public function selectedcity(Request $request, $selectedcity = '')
    {
        $minutes = 600000;
        setcookie('city', $selectedcity, $minutes);
        return redirect('/');
    }
    public function mainPage(Request $request)
    {

        $defaultCity=$_COOKIE['city'] ?? ss('DEFAULT_CITY');
        if(env('SITE_ID') == '1' || env('SITE_ID') == '9')
            return redirect('/c/' . $defaultCity);
        elseif(ss('SITE_ID') == '2')
            return $this->mainPage_v2($request , $defaultCity);
        elseif(ss('SITE_ID') == '3')
            return $this->mainPage_v3($request , $defaultCity);
        elseif(ss('SITE_ID') == '4')
            //return redirect('/c/' . $defaultCity);
            return $this->mainPage_v4($request , $defaultCity);
        elseif(ss('SITE_ID') == '5')
            return $this->mainPage_v5($request , $defaultCity);
        elseif(ss('SITE_ID') == '6')
            return redirect('/customer');
        elseif(ss('SITE_ID') == '7')
            return $this->mainPage_v7($request);
        elseif(ss('SITE_ID') == '8')
            return $this->mainPage_v8($request , $defaultCity);
        elseif(ss('SITE_ID') == '10')
            return $this->mainPage_v10($request , $defaultCity);
        elseif(ss('SITE_ID') == '11')
            return $this->mainPage_v10($request , $defaultCity);
    }
    public function shortTermRental(Request $request)
    {
        $articles  = QueryBuilder::for ( Post::class )
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
		$articles=!empty( $request->input_created_at ) ? $articles->createDate( $request->input_created_at ) : $articles;
		$articles = $articles->where( 'type', 'post');
        $articles = $articles->where('active',1);
		$articles = $articles->paginate(4);
		$articles->map( function ( $item ) {
			$item->publish_date = toAgoTime( $item->created_at );
		} );
        $estatePareh = Estate::with([
            'expert:id,code,name,last_name,username,photo,alias,title,phone',
            'user:id,code,name,last_name,username,photo,alias,title,phone'
        ])->where('visibility', 1)
            ->where('city_id', 594)
            ->where('image_count','>',0)
            ->where('type',3)
            ->where('special' , 1)
            ->where('confirmation', 'verified')->orderBy('id','desc')->limit(9)->get();
            //echo getQuery($estates);
        $estateRezvan = Estate::with([
            'expert:id,code,name,last_name,username,photo,alias,title,phone',
            'user:id,code,name,last_name,username,photo,alias,title,phone'
        ])->where('city_id', 440)
            ->where('visibility', 1)
            ->where('image_count','>',0)
            ->where('type',3)
            ->where('special' , 1)
            ->where('confirmation', 'verified')->orderBy('id','desc')->limit(10)->get();
        $estateAnzal = Estate::with([
            'expert:id,code,name,last_name,username,photo,alias,title,phone',
            'user:id,code,name,last_name,username,photo,alias,title,phone'
        ])->where('city_id', 92)
            ->where('visibility', 1)
            ->where('image_count','>',0)
            ->where('type',3)
            ->where('special' , 1)
            ->where('confirmation', 'verified')->orderBy('id','desc')->limit(10)->get();

        return view( 'site'.ss('SITE_ID').'.frontend.intro.shortTermRental',compact('articles','estatePareh' , 'estateRezvan' , 'estateAnzal'));
    }
    public function map(Request $request , $defaultCity = ''){
        $city = null;
        if($defaultCity != ''){
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
                ->where('name_en', $defaultCity)
                ->where('active', 1)
                ->first();
        }
        if($city == null || $defaultCity == '')
        {
            $defaultCity = ss('DEFAULT_CITY');
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
                ->where('name_en', $defaultCity)
                ->where('active', 1)
                ->first();
        }
        if (!$city) {
            return view('frontend.errors.404');
        }
        $estates = Estate::with([
            'expert:id,code,name,last_name,username,photo,alias,title,phone',
            'user:id,code,name,last_name,username,photo,alias,title,phone'
        ])->where('city_id', $city->id)
            ->where('visibility', 1)
            ->where('type',1)
            ->where('confirmation', 'verified');
        $estates = $estates->where('showdate', '>' ,  date("Y-m-d", strtotime("-1 years")));
            $map = "[";
            $counter = 1;
            $maparray = $estates->whereNotNull("latitude")->get(['id', 'latitude', 'longitude']);
            foreach ($maparray as $array) {
                if ($maparray->count() != $counter) {
                    $counter += 1;
                    $map .= "[" . $array->latitude . "," . $array->longitude . "," . $array->id . "],";
                } else {
                    $map .= "[" . $array->latitude . "," . $array->longitude . "," . $array->id . "]";
                }
            }
            $map .= "]";
        return response()->json(['map' => $map]);
    }
    public function mainPage_v2(Request $request , $defaultCity = '') {

        $defaultCity = 'qom';
        $city = null;
        if($defaultCity != ''){
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
                ->where('name_en', $defaultCity)
                ->where('active', 1)
                ->first();
        }
        if($city == null || $defaultCity == '')
        {
            $defaultCity = ss('DEFAULT_CITY');
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
                ->where('name_en', $defaultCity)
                ->where('active', 1)
                ->first();
        }

        if (!$city) {
            return view('frontend.errors.404');
        }
        $districts = $city->districts;
        $agent = new \Jenssegers\Agent\Agent;
        if($agent->isMobile())
        {
            $experts = User::whereNotNull('photo')->where('city_id',$city->id)->where('status','1')->where('active','1')->role('expert')->inRandomOrder()->limit(10)->get();
        }
        else
        {
            $experts = User::whereNotNull('photo')->where('city_id',$city->id)->where('status','1')->where('active','1')->role('expert')->inRandomOrder()->limit(10)->get();
        }
        $expertCount = User::where('status','1')->where('city_id',$city->id)->where('active','1')->role('expert')->count();
        $estates = Cache::remember('estates', 3000, function () use ($city){
            return Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('city_id', $city->id)
                ->where('visibility', 1)
                ->where('image_count','>',0)
                ->where('price','<>',0)
                ->where('type',1)
                ->where('built_year' , '>', 1399)
                ->where('confirmation', 'verified')->orderBy('id','desc')->limit(9)->get();
        });
        $estatesr = Cache::remember('estatesr', 3000, function () use ($city){
            //echo getQuery($estates);
            return Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('city_id', $city->id)
                ->where('visibility', 1)
                ->where('image_count','>',0)
                ->where('type',2)
                //->where('special' , 1)
                ->where('confirmation', 'verified')->orderBy('id','desc')->limit(10)->get();
        });
            //dd($estate->coverImage());
        $fieldList = Cache::remember('fieldListHome', 3000, function (){
            return getFeatures(0, 0);
        });
        $user = Auth::user();
        //dd($user->id);
        if(!empty($user)){
        //$NotificationLog=NotificationLog::where('userId',$user->id)->where('seen',0)->get();
        if($user->isExpert()){
            if(session('dateexpert')!=date("Y/m/d")){
                $request->session()->put('dateexpert',date("Y/m/d"));

            }
            }
            else if($user->has_role==0){
                if(session('dateuser')!=date("Y/m/d")){
                    $request->session()->put('dateuser',date("Y/m/d"));

                }
            }
        }
        //$slides = Slide::where('active',1)->where('show_place','page_home')->get();
        $featureValues = Cache::remember('featureValuesHome', 3000, function (){
            return FeatureValue::get();
        });
        $articles = Cache::remember('articlesHome', 3000, function (){
            $articles  = QueryBuilder::for ( Post::class )
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
            $articles=!empty( $request->input_created_at ) ? $articles->createDate( $request->input_created_at ) : $articles;
            $articles = $articles->where( 'type', 'post');
            $articles = $articles->where('category_id', '!=' , 6);
            $articles = $articles->where('active',1);
            $articles = $articles->paginate(8);
            $articles->map( function ( $item ) {
                $item->publish_date = toAgoTime( $item->created_at );
            } );
            return $articles;
        });
        $articlesCustomer = Cache::remember('articlesCustomerHome', 3000, function (){
            $articlesCustomer  = QueryBuilder::for ( Post::class )
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
            $articlesCustomer = $articlesCustomer->where( 'type', 'post');
            $articlesCustomer = $articlesCustomer->where('category_id',  6);
            $articlesCustomer = $articlesCustomer->where('active',1);
            $articlesCustomer = $articlesCustomer->paginate(4);
            $articlesCustomer->map( function ( $item ) {
                $item->publish_date = toAgoTime( $item->created_at );
            } );
            return $articlesCustomer;
        });
        $estateGilan = null;
        if(ss('SITE_ID') == 2)
        {
            $estateGilan = Cache::remember('$estateGilanHome', 3000, function (){
                return Estate::with([
                    'expert:id,code,name,last_name,username,photo,alias,title,phone',
                    'user:id,code,name,last_name,username,photo,alias,title,phone'
                ])->where('visibility', 1)
                    ->where('type',3)
                    ->where('special' , 1)
                    ->where('confirmation', 'verified')->orderBy('id','desc')->limit(10)->get();
            });
        }
        //dd($estates);
        return view( 'site'.ss('SITE_ID').'.frontend.intro.index',compact('experts','expertCount','estates','fieldList','city','estatesr','featureValues','articles','estateGilan' , 'articlesCustomer'));
    }
    /*public function mainPage_rent(Request $request) {

        return view( 'site'.ss('SITE_ID').'.frontend.intro.index2');
    }*/
    public function mainPage_v3(Request $request , $defaultCity = '')
    {
        $city = null;
        if($defaultCity != ''){
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
                ->where('name_en', $defaultCity)
                ->where('active', 1)
                ->first();
        }
        if($city == null || $defaultCity == '')
        {
            $defaultCity = ss('DEFAULT_CITY');
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
                ->where('name_en', $defaultCity)
                ->where('active', 1)
                ->first();
        }
        if (!$city) {
            return view('frontend.errors.404');
        }

        $districts = $city->districts;
        $agent = new \Jenssegers\Agent\Agent;
        $estates = Cache::remember('estates', 3000, function () use ($city){
            $estates = Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('province_id', $city->province_id)->where('visibility', 1);
            $estates = $estates->whereIn('estate_type', array(1,2))
            ->where('built_year' , '>' , '1396')
            ->where('special',1)
            ->where('image_count','>',0);
            return $estates->where('type',1)->where('confirmation', 'verified')->orderBy('showdate','desc')->limit(9)->get();
        });

        $estatesr = Cache::remember('estatesr', 3000, function () use ($city){
            $estatesr = Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('province_id', $city->province_id)->where('visibility', 1);
            $estatesr = $estatesr->whereIn('estate_type', array(1,2))
                ->where('built_year' , '>' , '1396')
            // ->where('special',1)
                ->where('image_count','>',0);
            return $estatesr->where('type',2)->where('confirmation', 'verified')->orderBy('showdate','desc')->limit(10)->get();
        });
        $estatespecial = Cache::remember('estatespecial', 3000, function (){
            $estatespecial = null;
            return Estate::with([
                    'expert:id,code,name,last_name,username,photo,alias,title,phone',
                    'user:id,code,name,last_name,username,photo,alias,title,phone'
                ])->whereNotNull('vrhouse')->where('type',1)->where('confirmation', 'verified')->where('visibility', 1)->orderBy('showdate','desc')->limit(4)->get();
        });

        //return;
        //dd(getQuery($experts));
        $experts = Cache::remember('experts', 3000, function (){
            return User::whereNotNull('photo')->where('status','1')->where('active','1')->role('expert')->inRandomOrder()->limit(10)->get();
        });
        $user = Auth::user();
        if(!empty($user)){
        //$NotificationLog=NotificationLog::where('userId',$user->id)->where('seen',0)->get();
        if($user->isExpert()){
            if(session('dateexpert')!=date("Y/m/d")){
                $request->session()->put('dateexpert',date("Y/m/d"));
                LogExpert::create([
                    'userId'   =>$user->id,
                    'date'      => date("Y/m/d"),
                    'page'=>1,
                    'type'=>'expert'
                ]);
            }
            }
            else if($user->has_role==0){
                if(session('dateuser')!=date("Y/m/d")){
                    $request->session()->put('dateuser',date("Y/m/d"));
                    LogExpert::create([
                        'userId'   =>$user->id,
                        'date'      => date("Y/m/d"),
                        'page'=>1,
                        'type'=>'user'
                    ]);
                }
            }
        }

        $featureValues = Cache::remember('featureValues', 3000, function (){
            return FeatureValue::get();
        });
        $branches = null;
        $reportShow = null;
        $articles = null;
        $articlesArea = null;
        $month = 0;
        //$reportShow = Cache::remember('reportShow', 3000, function () use ($request){
            $jalali = gregorian_to_jalali(date('Y'),date('m'),date('d'),'-');
            $lalalilist = explode('-' , $jalali);
            $profileController = new ProfileController();
            $request->type = 'total';
            $request->income = 1;
            $request->datefrom = $lalalilist[0] . '/' . $lalalilist[1] . '/1';
            $request->dateto = $lalalilist[0] . '/' . $lalalilist[1] . '/' . $lalalilist[2];
            $month = $lalalilist[1];
            $reportShow = $profileController->reportShow($request , false);
            if(is_array($reportShow))
            {
                foreach($reportShow['search'] as $key=>$val)
                {
                    $user2 = User::where('id', $key)->first();
                    $reportShow['pic'][$key] = $user2->photo();
                    $reportShow['branch'][$key] = $user2->branch_id;
                }
            }
        //    return $reportShow;
        //});

        $branches = Cache::remember('branches', 3000, function () use ($request){
            $profileController = new ProfileController();
            $branches = Branch::where('active',1)->where('status',1)->get();
            foreach($branches as $branch)
            {
                $request->user_id = ($branch->id)*-1;
                $reportShow[$branch->id] = $profileController->reportShow($request , false);
                if(is_array($reportShow[$branch->id]))
                {
                    foreach($reportShow[$branch->id]['search'] as $key=>$val)
                    {
                        $user2 = User::where('id', $key)->first();
                        $reportShow[$branch->id]['pic'][$key] = $user2->photo();
                    }
                }

                $branch->report = $reportShow[$branch->id];

            }
            return $branches;
        });
        $articles = Cache::remember('articles', 3000, function () use ($request){
            $articles  = QueryBuilder::for ( Post::class )
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
            $articles=!empty( $request->input_created_at ) ? $articles->createDate( $request->input_created_at ) : $articles;
            $articles = $articles->where( 'type', 'post');
            $articles = $articles->where('category_id', 3);
            $articles = $articles->where('active',1);
            $articles = $articles->paginate(2);
            $articles->map( function ( $item ) {
                $item->publish_date = toAgoTime( $item->created_at );
            } );
            return $articles;
        });

        $articlesArea = Cache::remember('articlesArea', 3000, function () use ($request){
            $articlesArea  = QueryBuilder::for ( Post::class )
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
            $articlesArea=!empty( $request->input_created_at ) ? $articlesArea->createDate( $request->input_created_at ) : $articlesArea;
            $articlesArea = $articlesArea->where( 'type', 'post');
            $articlesArea = $articlesArea->whereIn('category_id', array(9,10));
            $articlesArea = $articlesArea->where('active',1);
            $articlesArea = $articlesArea->where('image','!=','');
            $articlesArea = $articlesArea->paginate(10);
            $articlesArea->map( function ( $item ) {
                $item->publish_date = toAgoTime( $item->created_at );
            } );
            return $articlesArea;
        });


        return view( 'site'.ss('SITE_ID').'.frontend.intro.index',compact('branches','estates','city','estatesr','featureValues','experts','estatespecial','reportShow','articles','articlesArea','month'));
    }
    public function mainPage_v10(Request $request , $defaultCity = '')
    {
        $city = null;
        $districts = collect();
        $agent = new \Jenssegers\Agent\Agent;
        $estates = collect();
        $estatespecial = collect();
        $estateurgent = collect();
        $experts = collect();
        $user = Auth::user();
        $featureValues = collect();
        $branches = null;
        $reportShow = null;
        $articles = collect();
        $articlesArea = collect();
        $month = 0;

        return view( ss('THEME').'.frontend.intro.index',compact('branches','estates','city','estateurgent','featureValues','experts','estatespecial','reportShow','articles','articlesArea','month'));
    }
    public function mainPage_v5(Request $request , $defaultCity = '')
    {
        $city = null;
        if($defaultCity != ''){
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
                ->where('name_en', $defaultCity)
                ->where('active', 1)
                ->first();
        }
        if($city == null || $defaultCity == '')
        {
            $defaultCity = ss('DEFAULT_CITY');
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
                ->where('name_en', $defaultCity)
                ->where('active', 1)
                ->first();
        }
        if (!$city) {
            return view('frontend.errors.404');
        }

        $districts = $city->districts;
        $agent = new \Jenssegers\Agent\Agent;
        $estates = Cache::remember('estates', 3000, function () use ($city){
            $estates = Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('province_id', $city->province_id)->where('visibility', 1);
            $estates = $estates->whereIn('estate_type', array(1,2))

            ->where('image_count','>',0);
            return $estates->where('type',1)->where('confirmation', 'verified')->orderBy('showdate','desc')->limit(9)->get();
        });

        $estatesr = Cache::remember('estatesr', 3000, function () use ($city){
            $estatesr = Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('province_id', $city->province_id)->where('visibility', 1);
            $estatesr = $estatesr->whereIn('estate_type', array(1,2))
                ->where('image_count','>',0);
            return $estatesr->where('type',2)->where('confirmation', 'verified')->orderBy('showdate','desc')->limit(10)->get();
        });

        $estatespecial = null;
        $experts = Cache::remember('expertsHomePage', 3000, function () use ($city){
            return User::whereNotNull('photo')->where('status','1')->where('active','1')->role('expert')->inRandomOrder()->limit(10)->get();
        });
        $user = Auth::user();
        if(!empty($user)){
        //$NotificationLog=NotificationLog::where('userId',$user->id)->where('seen',0)->get();
        if($user->isExpert()){
            if(session('dateexpert')!=date("Y/m/d")){
                $request->session()->put('dateexpert',date("Y/m/d"));

            }
            }
            else if($user->has_role==0){
                if(session('dateuser')!=date("Y/m/d")){
                    $request->session()->put('dateuser',date("Y/m/d"));

                }
            }
        }
        $featureValues = Cache::remember('featureValues', 3000, function (){
            return FeatureValue::get();
        });
        $branches = null;
        $reportShow = null;
        $articles = null;
        $articlesArea = null;
        $month = 0;


        return view( ss('THEME').'.frontend.intro.index',compact('branches','estates','city','estatesr','featureValues','experts','estatespecial','reportShow','articles','articlesArea','month'));
    }
    public function mainPage_v4(Request $request , $defaultCity = '')
    {

        $defaultCity = ss('DEFAULT_CITY');
        $city = City::with(['districts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])
        ->where('name_en', $defaultCity)
        ->where('active', 1)
        ->first();

        if (!$city) {
            return view('frontend.errors.404');
        }

        $districts = $city->districts;
        $agent = new \Jenssegers\Agent\Agent;
        $estates = Cache::remember('estates', 3000, function () use ($city){
            $estates = Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('province_id', $city->province_id)->where('visibility', 1);
            return $estates = $estates->where('type',1)->where('confirmation', 'verified')->orderBy('showdate','desc')->limit(9)->get();
        });

        $estatesr = Cache::remember('estatesr', 3000, function () use ($city){
            $estatesr = Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('province_id', $city->province_id)->where('visibility', 1);
            return $estatesr = $estatesr->where('type',2)->where('confirmation', 'verified')->orderBy('showdate','desc')->limit(10)->get();
        });

        $estateurgent = Cache::remember('estateurgent', 3000, function () use ($city){
            $estateurgent = Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('province_id', $city->province_id)->where('visibility', 1);
            return $estateurgent = $estateurgent->where('type',1)->where('urgent',1)->where('confirmation', 'verified')->orderBy('showdate','desc')->limit(9)->get();
        });

        $estatespecials = null;
        $estatespecials = Cache::remember('estatespecials', 3000, function () use ($city){
            $estatespecial = Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('province_id', $city->province_id)->where('visibility', 1);
            $estatespecial = $estatespecial->where('type',1)->where('special',1)->where('confirmation', 'verified')->orderBy('showdate','desc')->limit(3)->get();
            foreach($estatespecial as $_)
            {
                $estatespecials[] = $_;
            }
            return $estatespecials;
        });


        $experts = Cache::remember('experts', 3000, function (){
            $experts = User::whereNotNull('photo')->where('status','1')->where('active','1')->role('expert')->inRandomOrder()->limit(10)->get();
            return $experts;
        });
        $user = Auth::user();

        //if(!empty($user)){

        $featureValues = Cache::remember('featureValues', 3000, function (){
            return FeatureValue::get();
        });
        $branches = null;
        $articles = Cache::remember('articles', 3000, function () use ($request){
            $articles  = QueryBuilder::for ( Post::class )
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
            $articles=!empty( $request->input_created_at ) ? $articles->createDate( $request->input_created_at ) : $articles;
            $articles = $articles->where( 'type', 'post');
            $articles = $articles->where('active',1);
            $articles = $articles->paginate(4);
            $articles->map( function ( $item ) {
                $item->publish_date = toAgoTime( $item->created_at );
            });
            return $articles;
        });


        $lists = District::whereIn('id' , array(9,11,15,21,23,66,91,93,94))->get();
        $areas = null;
        foreach($lists as $list)
        {
            $areas[$list->id]['name'] = $list->name;
            $areas[$list->id]['post'] = (int)$list->post_id;
            $areas[$list->id]['url'] = isset($list->post) ? $list->post->url() : '';
            $areas[$list->id][1] = 0;
            $areas[$list->id][2] = 0;
        }
        if(isset($areas))
        {
            $query = "SELECT `district_id`,`type`,count(`type`) as count FROM `estates` where `district_id` in (9,11,15,21,23,66,91,93,94)  GROUP by `district_id`,`type`";
            $lists = DB::select($query);
            foreach($lists as $list)
            {
                $areas[$list->district_id][$list->type] = $list->count;

            }
        }

        $projects = Project::orderBy('name', 'asc')->limit(2)->get();
        return view( ss('THEME').'.frontend.intro.index',compact('branches','estates','city','estatesr','featureValues','experts','estatespecials','estateurgent','districts','articles','areas','projects'));
    }
    public function mainPage_v7(Request $request)
    {
        //$cities = $_COOKIE['cities'];
        $cities = $_COOKIE['cities'] ?? null;
        $featureValues = FeatureValue::get();
        if($request->kind == 1)
        {
            $estates = Estate::with([
                'expert:id,code,name,last_name,username,photo,phone',
                'user:id,code,name,last_name,username,photo,phone'
            ])
            ->where('visibility', 1)
            ->where('confirmation', 'verified');
            $estates = !empty($request->type) ? $estates->where('type', $request->type) : $estates;
            $estates = !empty($cities) ? $estates->whereIn('city_id', $cities) : $estates;
            if (!empty($request->estateTypes)) {
                $selectedEstateType = explode(",", $request->estateTypes);
                for ($i = 0; $i < count($selectedEstateType); $i++)
                    if ($selectedEstateType[0] != 0) {
                        $estates = $estates->whereIn('estate_type', $selectedEstateType);
                    }
            }
            // filter has photo
            if ($request->has_photo == 'true') {
                $hasPhoto = true;
                $estates = $estates->where(function ($q) {
                    $q->whereHas('images');
                });
            }
            // filter has agent
            if ($request->has_agent == 'true') {
                $hasAgent = true;
                $estates = $estates->whereHas('agent');
            }

            // filter districts
            if (!empty($request->districts)) {
                $selectedDistricts = explode(",", $request->districts);
                $selectedDistricts = array_map(function ($value) {
                    return (int)$value;
                }, $selectedDistricts);
                $estates = $estates->whereHas('district')->whereIn('district_id', $selectedDistricts);
            }
            if (!empty($request->minArea)) {
                $estates = $estates->where('area', '>=', $request->minArea);
            }
            if (!empty($request->maxArea)) {
                $estates = $estates->where('area', '<=', $request->maxArea);
            }
            // filter keyword
            if ($request->q) {
                $estates = $estates->where('description', 'LIKE', '%' . $request->q . '%');
                $q = $request->q;
            }
            // filter price range
            //dd($request->price);
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

            // filter by city
            $estates = $estates->where('confirmation', 'verified');
            $sortBy = $request->sortBy ?? 1;
            $sortType = $request->sortType ?? 1;

            $totalCount = $estates->count();
            if ($request->mapexists != 1) {
                $estates = $estates->paginate(12);
            }
            $lists = null;
            foreach($estates as $key=>$estate)
            {
                $lists[$key] = $estate;
                $lists[$key]['t'] = 'estate';
            }
        }
        elseif($request->kind == 2)
        {
            $model = Customer::with([
                'user:id,name,last_name,username',
                'districts',
                'notes'
            ]);
            $model = ! empty( $request->id ) ? $model->where( 'id', (int) $request->id ) : $model;
            $model = ! empty( $request->request_type ) ? $model->where( 'request_type', (int) $request->request_type ) : $model->where( 'request_type', 1 );
            if(!empty( $request->estate_type ))
            {
                $rt = explode(',' , $request->estate_type);
                $model =  $model->whereIn( 'estate_type', $rt);
            }
            $model = ! empty( $request->conditions) ? $model->whereJsonContains( 'conditions',$request->conditions) : $model;
            $model = ! empty( $request->name ) ? $model->where( 'name', 'like', "%$request->name%" ) : $model;
            $model = ! empty( $request->residence_type ) ? $model->where('residence_type', $request->residence_type ) : $model;
            $model = ! empty( $request->acquaintance_type) ? $model->where('acquaintance_type', $request->acquaintance_type ) : $model;
            $model = ! empty( $request->max_room_count) ? $model->where('max_room_count', $request->max_room_count) : $model;
            $model = ! empty( $request->max_unit_in_floor) ? $model->where('max_unit_in_floor','<=', $request->max_unit_in_floor) : $model;
            $model = ! empty( $request->max_building_age) ? $model->where('max_building_age','<=', $request->max_building_age) : $model;
            $model = ! empty( $request->usage_type) ? $model->where('usage_type', $request->usage_type) : $model;
            $model = ! empty( $request->floor_count) ? $model->where('floor_count', $request->floor_count) : $model;
            $model = ! empty( $request->min_floor_count) ? $model->where('min_floor_count','>=', $request->min_floor_count) : $model;
            $model = ! empty( $request->floor_start) ? $model->where('floor_start', $request->floor_start) : $model;
            $model = ! empty( $request->min_floor_area) ? $model->where('min_floor_area','>=', $request->min_floor_area) : $model;
            $model = ! empty( $request->min_front_area) ? $model->where('min_front_area','>=', $request->min_front_area) : $model;
            $model = ! empty( $request->min_density) ? $model->where('min_density','>=', $request->min_density) : $model;
            $model = ! empty( $request->min_street_width) ? $model->where('min_street_width','>=', $request->min_street_width) : $model;
            $model = ! empty( $request->build_license) ? $model->where('build_license', $request->build_license) : $model;
            $model = ! empty( $request->geography) ? $model->where('geography', $request->geography) : $model;
            $model = ! empty( $request->status) ? $model->where('status', $request->status) : $model;
            $model = ! empty( $request->mobile) ? $model->where('mobile', $request->mobile) : $model;
            $model = ! empty( $request->area_min) ? $model->where('area_min', '>=', (int)$request->area_min) : $model;
            // price range
            $model = !empty($request->price_min) ? $model->where('price_min', '>=', (int)$request->price_min) : $model;
            $model = !empty($request->price_max) ? $model->where('price_max', '<=', (int)$request->price_max) : $model;
            // mortgage range
            $model = !empty($request->mortgage_min) ? $model->where('mortgage_min', '>=', (int)$request->mortgage_min) : $model;
            $model = !empty($request->mortgage_max) ? $model->where('mortgage_max', '<=', (int)$request->mortgage_max) : $model;
            // rent range
            $model = !empty($request->rent_min) ? $model->where('rent_min', '>=', (int)$request->rent_min) : $model;
            $model = !empty($request->rent_max) ? $model->where('rent_max', '<=', (int)$request->rent_max) : $model;
            //dd($request->create_date_to);
            if (!empty($request->create_date_of))
            {
                $create_date_of =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->create_date_of);
                $model = $model->where('created_at', '>=',  Verta::parse($create_date_of)->formatGregorian('Y-m-d h:i'));
            }
            if (!empty($request->create_date_to))
            {
                $create_date_to =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->create_date_to);
                $model = $model->where('created_at', '<=',  Verta::parse($create_date_to)->formatGregorian('Y-m-d h:i'));
            }
            //dd(getQuery($model));
            // district
            if (!empty( $request->district_id )) {
                $districts = $request->district_id;
                $model = $model->whereHas('districts',function ($query) use ($districts) {
                    $query->whereIn( 'district_id', $districts );
                });
            }
            if(!empty($request->order) && !empty($request->orderby)){
                $model = $model->orderBy($request->order, $request->orderby);
            }
            $model = $model->orderBy('id', 'desc');
            //dd(getQuery($model));
            $totalCount = $model->count();
            //dd($totalCount);
            $model = $model->paginate($request->showcount);
            foreach($model as $key=>$customer)
            {
                $lists[$key] = $customer;
                $lists[$key]['t'] = 'customer';
            }
        }
        else
        {
            $query = "
            SELECT id , created_at , 'estate' as 'type'  FROM `estates` where  `visibility`= 1
            union
            SELECT id , created_at , 'customer' as 'type' FROM `customers`
            order by created_at desc limit 0 , 10";
            $lists = DB::select($query);
            $totalCount = 0;
            foreach($lists as $key=>$list)
            {
                $totalCount++;
                if($list->type == "customer")
                {
                    $customer = Customer::find($list->id);
                    $lists[$key] = $customer;
                    $lists[$key]['t'] = 'customer';
                    $CustomerId[$key] = $list->id;
                }
                else
                {
                    $estate = Estate::find($list->id);
                    $lists[$key] = $estate;
                    $lists[$key]['t'] = 'estate';
                    $EstateId[$key] = $list->id;
                }
            }
            //dd($lists);
        }

        if(isset($CustomerId) && is_array($CustomerId) && count($CustomerId)>0)
        {

            $query = "";
            $query = "SELECT `customer_id`,count(*) as `count` FROM `relation_estate_customer` where `deleted_at` is null and `priority` = '1' ";
            $query .= " and `customer_id` in (".implode(',' , $CustomerId).")";
            $query .= " group by `customer_id` ";
            $cs = DB::select($query);
            foreach($cs as $c)
            {
                $relate[$c->customer_id] = $c->count;
            }
            foreach($CustomerId as $k=>$v)
            {
                $lists[$k]['relate'] = isset($relate) && isset($relate[$v]) ? $relate[$v] : 0;
            }
        }
        if(isset($EstateId) && is_array($EstateId) && count($EstateId)>0)
        {

            $query = "";
            $query = "SELECT `estate_id`,count(*) as `count` FROM `relation_estate_customer` where `deleted_at` is null and `priority` = '1' ";
            $query .= " and `estate_id` in (".implode(',' , $EstateId).")";
            $query .= " group by `estate_id` ";
            $cs = DB::select($query);
            foreach($cs as $c)
            {
                $relate[$c->estate_id] = $c->count;
            }
            foreach($EstateId as $k=>$v)
            {
                $lists[$k]['relate'] = isset($relate) && isset($relate[$v]) ? $relate[$v] : 0;
            }
        }
        if ($request->mapexists != 1)
        {
            if ($request->ajax() && $totalCount > 0) {
                $couter = $totalCount / 12;
                $hasPage = ($couter + 1 == $request->page) ? false : true;
                $type=$request->type;
                //$hasPage = fmod($estates->total(), $request->page) == 0 ? false : true;
                //$lists = $estates;
                $view = view('site7.frontend.intro.component_ex', compact('lists', 'featureValues','type','totalCount'))->render();

                return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
            }
        } else if ($request->mapexists == 1) {
            return response()->json(['map' => $map]);
        }
    return view( 'site7.frontend.intro.index'/*,compact('lists','featureValues')*/);
    }
    public function indexShow(Request $request)
    {
        //$cities = $_COOKIE['cities'];
        $cities = $_COOKIE['cities'] ?? null;
        $featureValues = FeatureValue::get();
        if($request->kind == 1)
        {
            $estates = Estate::with([
                'expert:id,code,name,last_name,username,photo,phone',
                'user:id,code,name,last_name,username,photo,phone'
            ])
            ->where('visibility', 1)
            ->where('confirmation', 'verified');
            $estates = !empty($request->type) ? $estates->where('type', $request->type) : $estates;
            $estates = !empty($cities) ? $estates->whereIn('city_id', $cities) : $estates;
            if (!empty($request->estateTypes)) {
                $selectedEstateType = explode(",", $request->estateTypes);
                for ($i = 0; $i < count($selectedEstateType); $i++)
                    if ($selectedEstateType[0] != 0) {
                        $estates = $estates->whereIn('estate_type', $selectedEstateType);
                    }
            }
            // filter has photo
            if ($request->has_photo == 'true') {
                $hasPhoto = true;
                $estates = $estates->where(function ($q) {
                    $q->whereHas('images');
                });
            }
            // filter has agent
            if ($request->has_agent == 'true') {
                $hasAgent = true;
                $estates = $estates->whereHas('agent');
            }

            // filter districts
            if (!empty($request->districts)) {
                $selectedDistricts = explode(",", $request->districts);
                $selectedDistricts = array_map(function ($value) {
                    return (int)$value;
                }, $selectedDistricts);
                $estates = $estates->whereHas('district')->whereIn('district_id', $selectedDistricts);
            }
            if (!empty($request->minArea)) {
                $estates = $estates->where('area', '>=', $request->minArea);
            }
            if (!empty($request->maxArea)) {
                $estates = $estates->where('area', '<=', $request->maxArea);
            }
            // filter keyword
            if ($request->q) {
                $estates = $estates->where('description', 'LIKE', '%' . $request->q . '%');
                $q = $request->q;
            }
            // filter price range
            //dd($request->price);
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

            // filter by city
            $estates = $estates->where('confirmation', 'verified');
            $sortBy = $request->sortBy ?? 1;
            $sortType = $request->sortType ?? 1;

            $totalCount = $estates->count();
            if ($request->mapexists != 1) {
                $estates = $estates->paginate(12);
            }
            $lists = null;
            foreach($estates as $key=>$estate)
            {
                $lists[$key] = $estate;
                $lists[$key]['type'] = 'estate';
            }
        }
        elseif($request->kind == 2)
        {
            $model = Customer::with([
                'user:id,name,last_name,username',
                'districts',
                'notes'
            ]);
            $model = ! empty( $request->id ) ? $model->where( 'id', (int) $request->id ) : $model;
            $model = ! empty( $request->request_type ) ? $model->where( 'request_type', (int) $request->request_type ) : $model->where( 'request_type', 1 );
            if(!empty( $request->estate_type ))
            {
                $rt = explode(',' , $request->estate_type);
                $model =  $model->whereIn( 'estate_type', $rt);
            }
            $model = ! empty( $request->conditions) ? $model->whereJsonContains( 'conditions',$request->conditions) : $model;
            $model = ! empty( $request->name ) ? $model->where( 'name', 'like', "%$request->name%" ) : $model;
            $model = ! empty( $request->residence_type ) ? $model->where('residence_type', $request->residence_type ) : $model;
            $model = ! empty( $request->acquaintance_type) ? $model->where('acquaintance_type', $request->acquaintance_type ) : $model;
            $model = ! empty( $request->max_room_count) ? $model->where('max_room_count', $request->max_room_count) : $model;
            $model = ! empty( $request->max_unit_in_floor) ? $model->where('max_unit_in_floor','<=', $request->max_unit_in_floor) : $model;
            $model = ! empty( $request->max_building_age) ? $model->where('max_building_age','<=', $request->max_building_age) : $model;
            $model = ! empty( $request->usage_type) ? $model->where('usage_type', $request->usage_type) : $model;
            $model = ! empty( $request->floor_count) ? $model->where('floor_count', $request->floor_count) : $model;
            $model = ! empty( $request->min_floor_count) ? $model->where('min_floor_count','>=', $request->min_floor_count) : $model;
            $model = ! empty( $request->floor_start) ? $model->where('floor_start', $request->floor_start) : $model;
            $model = ! empty( $request->min_floor_area) ? $model->where('min_floor_area','>=', $request->min_floor_area) : $model;
            $model = ! empty( $request->min_front_area) ? $model->where('min_front_area','>=', $request->min_front_area) : $model;
            $model = ! empty( $request->min_density) ? $model->where('min_density','>=', $request->min_density) : $model;
            $model = ! empty( $request->min_street_width) ? $model->where('min_street_width','>=', $request->min_street_width) : $model;
            $model = ! empty( $request->build_license) ? $model->where('build_license', $request->build_license) : $model;
            $model = ! empty( $request->geography) ? $model->where('geography', $request->geography) : $model;
            $model = ! empty( $request->status) ? $model->where('status', $request->status) : $model;
            $model = ! empty( $request->mobile) ? $model->where('mobile', $request->mobile) : $model;
            $model = ! empty( $request->area_min) ? $model->where('area_min', '>=', (int)$request->area_min) : $model;
            // price range
            $model = !empty($request->price_min) ? $model->where('price_min', '>=', (int)$request->price_min) : $model;
            $model = !empty($request->price_max) ? $model->where('price_max', '<=', (int)$request->price_max) : $model;
            // mortgage range
            $model = !empty($request->mortgage_min) ? $model->where('mortgage_min', '>=', (int)$request->mortgage_min) : $model;
            $model = !empty($request->mortgage_max) ? $model->where('mortgage_max', '<=', (int)$request->mortgage_max) : $model;
            // rent range
            $model = !empty($request->rent_min) ? $model->where('rent_min', '>=', (int)$request->rent_min) : $model;
            $model = !empty($request->rent_max) ? $model->where('rent_max', '<=', (int)$request->rent_max) : $model;
            //dd($request->create_date_to);
            if (!empty($request->create_date_of))
            {
                $create_date_of =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->create_date_of);
                $model = $model->where('created_at', '>=',  Verta::parse($create_date_of)->formatGregorian('Y-m-d h:i'));
            }
            if (!empty($request->create_date_to))
            {
                $create_date_to =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->create_date_to);
                $model = $model->where('created_at', '<=',  Verta::parse($create_date_to)->formatGregorian('Y-m-d h:i'));
            }
            //dd(getQuery($model));
            // district
            if (!empty( $request->district_id )) {
                $districts = $request->district_id;
                $model = $model->whereHas('districts',function ($query) use ($districts) {
                    $query->whereIn( 'district_id', $districts );
                });
            }
            if(!empty($request->order) && !empty($request->orderby)){
                $model = $model->orderBy($request->order, $request->orderby);
            }
            $model = $model->orderBy('id', 'desc');
            //dd(getQuery($model));
            $totalCount = $model->count();
            //dd($totalCount);
            $model = $model->paginate($request->showcount);
            foreach($model as $key=>$customer)
            {
                $lists[$key] = $customer;
                $lists[$key]['type'] = 'customer';
            }
        }
        else
        {
            $query = "
            SELECT id , created_at , 'estate' as 'type'  FROM `estates` where  'visibility'= 1
            union
            SELECT id , created_at , 'customer' as 'type' FROM `customers`
            order by created_at desc limit 0 , 10";
            //dd($query);
            $lists = DB::select($query);

            foreach($lists as $key=>$list)
            {
                if($list->type == "customer")
                {
                    $customer = Customer::find($list->id);
                    $lists[$key] = $customer;
                    $lists[$key]['type'] = 'customer';
                }
                else
                {
                    $estate = Estate::find($list->id);
                    $lists[$key] = $estate;
                    $lists[$key]['type'] = 'estate';
                }
            }
            //dd($lists);
        }
        if($request->isAjax)
        {
            if ($request->mapexists != 1)
            {
                if ($request->ajax() && $estates->count() > 0) {
                    $couter = $totalCount / 12;
                    $hasPage = ($couter + 1 == $request->page) ? false : true;
                    $type=$request->type;
                    //$hasPage = fmod($estates->total(), $request->page) == 0 ? false : true;
                    $view = view(ss('THEME').'.frontend.intro.component_ex', compact('lists', 'featureValues'))->render();

                    return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
                }
            } else if ($request->mapexists == 1) {
            // return response()->json(['map' => $map]);
            }
        }
    }

    public function mainPage_v8(Request $request , $defaultCity = '')
    {

        $city = null;
        if($defaultCity != ''){
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
                ->where('name_en', $defaultCity)
                ->where('active', 1)
                ->first();
        }
        if($city == null || $defaultCity == '')
        {
            $defaultCity = ss('DEFAULT_CITY');
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
                ->where('name_en', $defaultCity)
                ->where('active', 1)
                ->first();
        }
        if (!$city) {
            return view('frontend.errors.404');
        }

        $districts = $city->districts;
        $agent = new \Jenssegers\Agent\Agent;
        $estates = Cache::remember('estates', 3000, function () use ($city){
            $estates = Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('province_id', $city->province_id)->where('visibility', 1);
            $estates = $estates->whereIn('estate_type', array(1,2))
            ->where('built_year' , '>' , '1396')
            ->where('special',1)
            ->where('image_count','>',0);
            return $estates->where('type',1)->where('confirmation', 'verified')->orderBy('showdate','desc')->limit(9)->get();
        });

        $estatesr = Cache::remember('estatesr', 3000, function () use ($city){
            $estatesr = Estate::with([
                'expert:id,code,name,last_name,username,photo,alias,title,phone',
                'user:id,code,name,last_name,username,photo,alias,title,phone'
            ])->where('province_id', $city->province_id)->where('visibility', 1);
            $estatesr = $estatesr->whereIn('estate_type', array(1,2))
                ->where('built_year' , '>' , '1396')
            // ->where('special',1)
                ->where('image_count','>',0);
            return $estatesr->where('type',2)->where('confirmation', 'verified')->orderBy('showdate','desc')->limit(10)->get();
        });
        $estatespecial = Cache::remember('estatespecial', 3000, function (){
            $estatespecial = null;
            return Estate::with([
                    'expert:id,code,name,last_name,username,photo,alias,title,phone',
                    'user:id,code,name,last_name,username,photo,alias,title,phone'
                ])->whereNotNull('vrhouse')->where('type',1)->where('confirmation', 'verified')->where('visibility', 1)->orderBy('showdate','desc')->limit(4)->get();
        });
        //return;
        //dd(getQuery($experts));
        $experts = Cache::remember('experts', 3000, function (){
            return User::whereNotNull('photo')->where('status','1')->where('active','1')->role('expert')->inRandomOrder()->limit(10)->get();
        });
        $user = Auth::user();
        if(!empty($user)){
        //$NotificationLog=NotificationLog::where('userId',$user->id)->where('seen',0)->get();
        if($user->isExpert()){
            if(session('dateexpert')!=date("Y/m/d")){
                $request->session()->put('dateexpert',date("Y/m/d"));
                LogExpert::create([
                    'userId'   =>$user->id,
                    'date'      => date("Y/m/d"),
                    'page'=>1,
                    'type'=>'expert'
                ]);
            }
            }
            else if($user->has_role==0){
                if(session('dateuser')!=date("Y/m/d")){
                    $request->session()->put('dateuser',date("Y/m/d"));
                    LogExpert::create([
                        'userId'   =>$user->id,
                        'date'      => date("Y/m/d"),
                        'page'=>1,
                        'type'=>'user'
                    ]);
                }
            }
        }
        $featureValues = Cache::remember('featureValues', 3000, function (){
            return FeatureValue::get();
        });
        return view( 'site'.ss('SITE_ID').'.frontend.intro.index',compact('estates','city','estatesr','featureValues','experts','estatespecial','districts'));
    }
	public function mainIntro(Request $request) {
	    $page = 'page_home';
	    $slides = Slide::where('active',1)->where('show_place','page_home')->get();
		return view( 'frontend.intro.index', compact( 'page','slides' ) );
	}
    public function expertIntro(Request $request) {
        $page = 'page_expert';
        $slides = Slide::where('active',1)->where('show_place','page_expert')->get();
        return view( 'frontend.intro.index', compact( 'page','slides' ) );
    }
    public function Help(Request $request){
        return view('frontend.intro.help');
    }
    public function Account(Request $request){
        return view('site5.frontend.account.index');
    }
    public function signin(Request $request){
        return view('site7.frontend.account.index_signin');
    }
    public function signup(Request $request){
        return view('site7.frontend.account.signup');
    }
    public function signupExpert(Request $request){
        return view('site7.frontend.account.signup_expert');
    }
    public function signupExpert2(Request $request){
        return view('site7.frontend.account.signup_expert2');
    }
    public function contactus(Request $request){
        return view(ss('THEME').'.frontend.page.contactus');
    }
    public function sidebartest(Request $request){
        return view('test1.slidebar');
    }
    public function suggest($slug)
    {
        $model = Customer::with(['user','districts'])->where('guid' , $slug)->first();
        if (empty($model)) {
            return back()->withErrors(['مشتری یافت نشد!']);
        }
        $featureValues = FeatureValue::get();
        $relationEstates = Estate::join('relation_estate_customer', 'estates.id', '=', 'relation_estate_customer.estate_id')
            ->where('customer_id',$model->id)/*->where('active' , 1)*/
            ->where('estates.showdate', '>' ,  date("Y-m-d", strtotime("-5 months")))
            ->where('estates.visibility', 1)
            ->where('confirmation', 'verified')
            ->whereNotNull('relation_estate_customer.send_at')
            ->select('estates.*','relation_estate_customer.send_at','relation_estate_customer.id AS uid')->orderBy('send_at', 'desc')
            ->get();
        if(ss('SITE_ID') == 3)
        {
            return view('site3.frontend.customer.suggest', compact('model','relationEstates','featureValues','slug'));
        }
        else
        {
            return view('frontend.customer.suggest', compact('model','relationEstates','featureValues','slug'));
        }

    }
    public function query(){
    }
    /*public function (){
    }*/
    public function relationEstate()
    {
        set_time_limit(0);
        $ddg = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-60 day" ) );
        $listCustomers = DB::select("select * from `customers` where `status` = '1'  and `deleted_at` is null and `updated_at` >=  '".$ddg."' ");


        foreach($listCustomers as $customers)
        {
            relEstate($customers->id);
            //relEstate(157268);
            //exit;
        }
    }
    public function sendAgent()
    {
        $agent = Agents::where('active' , 1)->whereNull('senddate')->first();
        $text = $agent->name." عزیز\nپیشنهاد ویژه برای شما\nasnr.ir/m";
        //foreach($agents as $agent)
        //{
            /*$arrSearch = array("{0}" , "{1}" , "{2}" , "{3}");
            if(str_contains($agent->name, 'خانم ') || str_contains($agent->name, 'آقای ') || str_contains($agent->name, 'اقای '))
            {
                $name = $agent->name;
            }
            else
            {
                $name = ($agent->gender == 'female'?'سرکار خانم ':'جناب آقای ').$agent->name;
            }*/
            //$arrReplace = array($name , $estateid , $model->user->fullname() , $model->user->username);
            //$text = str_replace($arrSearch, $arrReplace, $suggest);
            $agent->update(['senddate' => date('Y-m-d')]);
            sendSmsNew($agent->mobile , $text);

            //dd(sendSmsNew('09124525207' , $text));
        //}
    }
    public function sendAgent2()
    {
        return;
        $ddg4 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2 day" ) );
        $agent = Agents::where('active' , 1)->whereNull('senddate2')->where('senddate' , '<=' , $ddg4)->first();

        $text = $agent->name." عزیز\nپورسانت باورنکردنی برای شما، با معرفی مشتری اقامت یا خرید ملک دبی\ninstagram.com/mahmood.vaezii";

        $agent->update(['senddate2' => date('Y-m-d')]);
        sendSmsNew($agent->mobile , $text);

    }
    public function sendRelationEstate($customerid = 0,$estateid = 0)
    {
        set_time_limit(0);
        if($customerid == 0)
        {
            if($estateid>0)
            {
                return;
            }
            if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
            {
                $ddg0 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "0 day" ) );
                $ddg2 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 day" ) );
                $ddg1 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 day" ) );
                $ddg4 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2 day" ) );
                $ddg3 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2 day" ) );
                $ddg6 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-3 day" ) );
                $ddg5 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-3 day" ) );
                $ddg8 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-6 day" ) );
                $ddg7 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-6 day" ) );
                $ddg10 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-9 day" ) );
                $ddg9 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-9 day" ) );
                $ddg12 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-12 day" ) );
                $ddg11 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-12 day" ) );
                $ddg14 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-16 day" ) );
                $ddg13 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-16 day" ) );
                $ddg16 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-21 day" ) );
                $ddg15 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-21 day" ) );
                $ddg18 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-26 day" ) );
                $ddg17 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-26 day" ) );
                $ddg20 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-36 day" ) );
                $ddg19 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-36 day" ) );
                $ddg22 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-46 day" ) );
                $ddg21 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-46 day" ) );
                $ddg24 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-56 day" ) );
                $ddg23 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-56 day" ) );
                $listCustomers = DB::select("select * from `customers` where `status` = '1' and (`lastdateSms` != '".date('Y-m-d')."' or `lastdateSms` is null) and (`resenddate` <= '".date('Y-m-d')."' or `resenddate` is null) and `deleted_at` is null and
                (
                    (`updated_at` >=  '".$ddg0."' ) or
                    (`updated_at` >=  '".$ddg1."' and `updated_at` <  '".$ddg2."') or
                    (`updated_at` >=  '".$ddg3."' and `updated_at` <=  '".$ddg4."') or
                    (`updated_at` >=  '".$ddg5."' and `updated_at` <=  '".$ddg6."') or
                    (`updated_at` >=  '".$ddg7."' and `updated_at` <=  '".$ddg8."') or
                    (`updated_at` >=  '".$ddg9."' and `updated_at` <=  '".$ddg10."') or
                    (`updated_at` >=  '".$ddg11."' and `updated_at` <=  '".$ddg12."') or
                    (`updated_at` >=  '".$ddg13."' and `updated_at` <=  '".$ddg14."') or
                    (`updated_at` >=  '".$ddg15."' and `updated_at` <=  '".$ddg16."') or
                    (`updated_at` >=  '".$ddg17."' and `updated_at` <=  '".$ddg18."') or
                    (`updated_at` >=  '".$ddg19."' and `updated_at` <=  '".$ddg20."') or
                    (`updated_at` >=  '".$ddg21."' and `updated_at` <=  '".$ddg22."') or
                    (`updated_at` >=  '".$ddg23."' and `updated_at` <=  '".$ddg24."')
                )
                ");
            }
            else
            {
                $ddg2 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "0 day" ) );
                $ddg1 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "0 day" ) );
                $ddg4 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2 day" ) );
                $ddg3 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2 day" ) );
                $ddg6 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-4 day" ) );
                $ddg5 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-4 day" ) );
                $ddg8 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-6 day" ) );
                $ddg7 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-6 day" ) );
                $ddg10 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-9 day" ) );
                $ddg9 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-9 day" ) );
                $ddg12 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-11 day" ) );
                $ddg11 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-11 day" ) );
                $ddg16 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-15 day" ) );
                $ddg15 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-15 day" ) );
                $ddg20 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-19 day" ) );
                $ddg19 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-19 day" ) );
                $ddg22 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-30 day" ) );
                $ddg21 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-30 day" ) );
                $ddg24 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-40 day" ) );
                $ddg23 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-40 day" ) );
                $ddg26 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-50 day" ) );
                $ddg25 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-50 day" ) );
                $ddg28 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-80 day" ) );
                $ddg27 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-80 day" ) );
                $ddg30 = date("Y-m-d 23:59:59", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-110 day" ) );
                $ddg29 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-110 day" ) );
                $listCustomers = DB::select("select * from `customers` where (`lastdateSms` != '".date('Y-m-d')."' or `lastdateSms` is null) and `status` = '1' and (`resenddate` <= '".date('Y-m-d')."' or `resenddate` is null) and `deleted_at` is null and
                (
                    (`created_at` >=  '".$ddg1."' and `created_at` <=  '".$ddg2."') or
                    (`created_at` >=  '".$ddg3."' and `created_at` <=  '".$ddg4."') or
                    (`created_at` >=  '".$ddg5."' and `created_at` <=  '".$ddg6."') or
                    (`created_at` >=  '".$ddg7."' and `created_at` <=  '".$ddg8."') or
                    (`created_at` >=  '".$ddg9."' and `created_at` <=  '".$ddg10."') or
                    (`created_at` >=  '".$ddg11."' and `created_at` <=  '".$ddg12."') or
                    (`created_at` >=  '".$ddg15."' and `created_at` <=  '".$ddg16."') or
                    (`created_at` >=  '".$ddg19."' and `created_at` <=  '".$ddg20."') or
                    (`created_at` >=  '".$ddg21."' and `created_at` <=  '".$ddg22."') or
                    (`created_at` >=  '".$ddg23."' and `created_at` <=  '".$ddg24."') or
                    (`created_at` >=  '".$ddg25."' and `created_at` <=  '".$ddg26."') or
                    (`created_at` >=  '".$ddg27."' and `created_at` <=  '".$ddg28."') or
                    (`created_at` >=  '".$ddg29."' and `created_at` <=  '".$ddg30."')
                )
                ");
            }
        }
        else
        {
            $listCustomers = DB::select("select * from `customers` where (`lastdateSms` != '".date('Y-m-d')."' or `lastdateSms` is null) and `id` = '".$customerid."' and `status` = '1' and `deleted_at` is null");
        }
        if($estateid>0)
        {
            if(!($customerid > 0))
            {
                return;
            }
            $suggest = getsetting('sms','suggestOne');
            //return;
        }
        else
        {
            $suggest = getsetting('sms','suggest');
        }
        if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
        {
            $pagesize = 5;
        }
        else
        {
            $pagesize = 6;
        }
        foreach($listCustomers as $customers)
        {
            if($estateid>0)
            {
                if(!($customerid > 0))
                {
                    return;
                }
                //dd($estateid);
                Estate::where('id', $estateid)
                ->where('visibility', 1)
                ->where('confirmation', 'verified')->first();
                if($customers->guid)
                {
                    $model = Customer::with([
                        'user',
                        'districts'
                    ])->find($customers->id);
                    if($model->user_id > 0 && $model->user != null)
                    {
                        $arrSearch = array("{0}" , "{1}" , "{2}" , "{3}");
                        if(str_contains($customers->name, 'خانم ') || str_contains($customers->name, 'آقای ') || str_contains($customers->name, 'اقای '))
                        {
                            $name = $customers->name;
                        }
                        else
                        {
                            $name = ($customers->gender == 'female'?'سرکار خانم ':'جناب آقای ').$customers->name;
                        }
                        $arrReplace = array($name , $estateid , $model->user->fullname() , $model->user->username);

                        $text = str_replace($arrSearch, $arrReplace, $suggest);
                        sendSms($customers->mobile , $text);
                        //$model->update(['lastdateSms' => date('Y-m-d')]);
                    }

                }
                break;
            }
            else
            {
                if($customers->countSms > 0)
                {
                    $pagesize = $customers->countSms;
                }
                $relationEstateCustomers = DB::select("select * from `estates` inner join `relation_estate_customer` on `estates`.id = `relation_estate_customer`.`estate_id`
                and relation_estate_customer.`send_at` is null and relation_estate_customer.`status` = 2 and relation_estate_customer.`customer_id` = '".$customers->id."'
                where  estates.`deleted_at` is null and estates.`confirmation`='verified' and estates.`visibility` = 1 order by `priority` asc,estates.`showdate` desc limit 0 , ".$pagesize);
                if(count($relationEstateCustomers)>0)
                {
                    if(ss('SITE_ID') == 3 && count($relationEstateCustomers)<3)
                    {
                        continue;
                    }
                    foreach($relationEstateCustomers as $relationEstateCustomer)
                    {
                        RelationEstateCustomer::where('customer_id' , $relationEstateCustomer->customer_id)->where('estate_id' , $relationEstateCustomer->estate_id)->update(['send_at' => date('Y-m-d'),'status' => 3]);
                    }
                    if($customers->guid)
                    {
                        $model = Customer::with([
                            'user',
                            'districts'
                        ])->find($customers->id);
                        if($model->user_id > 0 && $model->user != null)
                        {
                            $arrSearch = array("{0}" , "{1}" , "{2}" , "{3}");
                            if(str_contains($customers->name, 'خانم ') || str_contains($customers->name, 'آقای ') || str_contains($customers->name, 'اقای '))
                            {
                                $name = $customers->name;
                            }
                            else
                            {
                                $name = ($customers->gender == 'female'?'سرکار خانم ':'جناب آقای ').$customers->name;
                            }
                            $arrReplace = array($name , $customers->guid , $model->user->fullname() , $model->user->username);
                            if(ss('SITE_ID') == 3)
                            {
                                $query = "";
                                $query = "SELECT count(distinct(`send_at`)) as `count` FROM `relation_estate_customer` where `deleted_at` is null and `send_at` is not null and `customer_id` = '".$customers->id."' ";
                                $lists = DB::select($query);
                                foreach($lists as $list)
                                {
                                    $count = $list->count;
                                }
                                //$count = Sms::where('mobile' , $customers->mobile)->where('type' , 1)->count();
                                $count++;
                                $suggest = getsetting('sms','suggest'.$count);
                            }
                            $text = str_replace($arrSearch, $arrReplace, $suggest);
                            sendSms($customers->mobile , $text);
                            $model->update(['lastdateSms' => date('Y-m-d')]);
                        }

                    }
                }
            }
        }
        //////////////////////////////////////////////////////////////////////
        /*$listCustomers = DB::select("select * from `customers` where `request_type` = '2' and `lastdateSms` != '".date('Y-m-d')."' and `status` = '1'  and `deleted_at` is null and
        (
            (`updated_at` >=  '".$ddg1."' and `updated_at` <=  '".$ddg2."') or
            (`updated_at` >=  '".$ddg3."' and `updated_at` <=  '".$ddg4."') or
            (`updated_at` >=  '".$ddg5."' and `updated_at` <=  '".$ddg6."')
        )
        ");
        $suggest = getsetting('sms','suggest');
        foreach($listCustomers as $customers)
        {
            $relationEstateCustomers = DB::select("select * from `estates` inner join `relation_estate_customer` on `estates`.id = `relation_estate_customer`.`estate_id`
            and relation_estate_customer.`send_at` is null and relation_estate_customer.`status` = 2 and relation_estate_customer.`customer_id` = '".$customers->id."'
            where  estates.`deleted_at` is null and estates.`confirmation`='verified' and estates.`visibility` = 1 order by `priority` asc

            ,estates.`showdate` desc limit 0 , 5");
            if(count($relationEstateCustomers)>0)
            {
                foreach($relationEstateCustomers as $relationEstateCustomer) {
                    RelationEstateCustomer::where('customer_id' , $customers->id)->where('estate_id' , $relationEstateCustomer->id)->update(['send_at' => date('Y-m-d'),'status' => 3]);
                }
                if($customers->guid){
                    $model = Customer::with([
                        'user',
                        'districts'
                    ])->find($customers->id);
                    if($model->user_id > 0)
                    {
                        $arrSearch = array("{0}" , "{1}" , "{2}" , "{3}");
                        $arrReplace = array(($customers->gender == 'female'?'سرکار خانم ':'جناب آقای ').$customers->name , $customers->guid , $model->user->fullname() , $model->user->username);
                        $text = str_replace($arrSearch, $arrReplace, $suggest);
                        sendSms($customers->mobile , $text);
                        $model->update(['lastdateSms' => date('Y-m-d')]);
                    }
                }
            }
        }*/
    }
}
