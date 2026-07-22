<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Comment;
use App\Models\FeatureValue;
use App\Models\ExpertFavorite;
use App\Models\Post;
use App\Models\Estate;
use App\Models\Province;
use App\Models\User;
use App\Models\UserSearch;
use App\Models\Agent_authentications;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;
use Spatie\Permission\Models\Role;
use Hekmatinasser\Verta\Verta;
class ExpertController extends Controller
{
    protected $model;
    public function __construct()
    {
        $this->model = new User();
    }
    public function getRegisterForm(Request $request, $referralId=null)
    {
        $authUser = Auth::user();
       // dd($request);
        $cities = null;
        $district= null;
        // referrer code
        $referralId = $referralId ?? null;
        // check session has ref url
        if(!empty($referralId) && session()->has('url.intended')){
            session()->forget('url.intended');
        }
        // get authenticated user
        $user = Auth::user();
        // get all provinces
        $provinces = Province::get();
        // get template page and ads

        // check exists agent
        /*$agent = User::where('is_admin', 0)//->role([9=>'expert'])
            ->where(function ($query){
                $query->whereJsonContains('role_ids',[9])->orWhere('status', '-1')->orWhere('status', '1')->orWhere('status', '4');
            })
            ->where('id',$user->id)
            ->first();
            $agent_authentications="";
        if($agent && $agent->status==4)
        {
            $agent_authentications = Agent_authentications::where('Token',$agent->authentication_token)->first();
            $cities = City::where('province_id' , $agent->province_id)->get();
        }*/
        $user = Auth::user();
        // redirect to profile
        if($user && $user->isExpert()){
            return redirect('/profile/info_v2');
        }
      return view('frontend.expert.register', compact(
            'user',
            'agent',
            'provinces',
            'cities'
        ));
    }

    public function register(Request $request){
        // validate inputs
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            //'father_name' => 'required',
            //'national_code' => 'required|digits:10',
           // 'military_status' => 'nullable|between:1,5',
           // 'marital_status' => 'nullable|between:1,2',
           // 'experience' => 'required',
        ]);
        //
        // check city code
        if (empty(City::find($request->city_id)->code)) {
            $validator->after(function ($validator) {
                $validator->errors()->add('city_id', 'شهر انتخاب شده فاقد کد می باشد');
            });
        }
        /*$user_ = User::where('national_code' , $request->national_code)->first();;
        if($user_ != null && $user_->id != Auth::user()->id){
            $validator->after(function ($validator) {
                $validator->errors()->add('national_code', 'کدملی قبلا انتخاب شده است');
            });
        }*/
        // return validation errors
        if ($validator->fails()) {
            //$dd = (object)$request->all();
            //return success_false($validator->errors());
            return back()->with(['user'=>(object)$request->all() , 'errors' => $validator->errors()]);
        }
        $user = Auth::user();
        if (!$user) {
            return back()->withErrors(['شما به این بخش دسترسی ندارید!']);
        }
        $model = Auth::user();//User::where('username', $request->mobile)->first();
        // find reagent user
        if(!empty($request->referral_id)){
            $reagentUser = User::where(function ($query)use($request){
                $query->role('expert')->Where('alias',$request->referral_id);
            })->first();
        }
        else if(!empty($request->reagent_username))
        {
            $reagentUser = User::where(function ($query)use($request,$model){
                $query->role('expert')->where('username', $request->reagent_username)->where('username','!=', $model->username);
            })->first();
        }
        // generate user code
        $userCode = makeUserCode($request->city_id);
        // getting all inputs
        $inputs = $request->all();
        $inputs['photo'] = uploader( $request, 'photo','images/profile' );
        $inputs['profile_cover'] = uploader( $request, 'profile_cover','images/profile' );
        $inputs['code'] = $userCode;
        $inputs['alias'] = TokenMaker(8);
        $inputs['TypeCooperation'] =$request->TypeCooperation;
        $inputs['last_activity'] = date('Y-m-d H:i:s');
        //$inputs['password'] = bcrypt($request->mobile);
        //$inputs['has_role'] = 0;
        if($user->parent_id == null){
            $inputs['parent_id'] =$reagentUser->id ?? null;
            $inputs['reagent_id'] = $reagentUser->id ?? null;
        }
        $inputs['name'] = $inputs['first_name'];
        //$inputs['status'] = '-1';
        //$inputs['birthday'] = !empty($request->input_birthday) ? Carbon::createFromTimestamp($request->input_birthday) : null;
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
        $inputs['experience_date'] = !empty($request->experience) && (int)$request->experience > 0 ? Carbon::now()->subYear($request->experience) : null;
        //$model->update($inputs);
        $mytoken=env('REGISTER_TOKEN');
        //$time=Jalalian::fromCarbon($inputs['birthday'])->format('Y/m/d');
        $inputs['has_role'] = '1';
        $inputs['active'] = '0';
        $inputs['status'] = '-1';
        // assign role
        $role = ['expert'];
        $selectedRole = Role::whereIn('name',$role)->pluck('id')->toArray();
        $roleIds = $selectedRole ? json_encode($selectedRole) : null;
        $inputs['role_ids'] = $roleIds;
        // assign role
        if(is_array($role)){
            foreach ($role as $roleName){
                $model->assignRole( $roleName );
            }
        }


        //$inputs['message'] = 'https://inquery.ir/:70?Token='.$mytoken.'&IdCode='.$request->national_code.'&BirthDate='.$request->birthday.'&Name='.urlencode($request->first_name).'&Family='.urlencode($request->last_name).'&FatherName='.urlencode($request->father_name);
        $model->update($inputs);
        /*try{
            dd('https://inquery.ir/:70?Token='.$mytoken.'&IdCode='.$request->national_code.'&BirthDate='.$request->birthday.'&Name='.urlencode($request->first_name).'&Family='.urlencode($request->last_name).'&FatherName='.urlencode($request->father_name));
            $response = json_decode(file_get_contents('https://inquery.ir/:70?Token='.$mytoken.'&IdCode='.$request->national_code.'&BirthDate='.$request->birthday.'&Name='.urlencode($request->first_name).'&Family='.urlencode($request->last_name).'&FatherName='.urlencode($request->father_name)), true);
            //dd($response);
            if($response){
            $inputs['authentication_token']=$response['Result']['ID'];
            $inputs['is_authenticated']=0;
                }
                else
                {
                    $inputs['is_authenticated'] = -1;
                }
        }
        catch(Exception $e) {
            $inputs['is_authenticated'] = -1;
        }*/
        $model->update($inputs);
        // check has branch
        $hasBranch = $request->has_license == 1 && $request->has_branch == 1 ? 1 : 0;
        return back()->with( 'success', $model->name . ' عزیز، ثبت نام شما با موفقیت انجام شد. اطلاعات وارد شده شما در حال بررسی میباشد. ' );
        //return back()->with(['registerStatus'=>'success',  'message' => $model->name . ' عزیز، ثبت نام شما با موفقیت انجام شد. اطلاعات وارد شده شما در حال بررسی میباشد. .']);
    }

    public function authentication($expert_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
        }
        $validator = Validator::make(['id' => $expert_id], [
            'id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.INVALID_INPUT'));
        }
        $model = User::where('id', $expert_id)->first();
        $response = json_decode(file_get_contents($model->message), true);
      //  dd($response);
        if($response){
            $inputs['authentication_token']=$response['Result']['ID'];
            $inputs['is_authenticated'] = 0;
            $model->update($inputs);
        }
        return response([
            'status' => 'ok',
            'result' => 1
        ], config('StatusCode.SUCCESS'));
    }
    public function create_expert_report(Request $request){
        $user = Agent_authentications::where('Token',$request['ID'])->first();
        $inputs['Token']=$request['ID'];
        $inputs['IdCode']=($request['IdCode']=='true')?1:0;
        $inputs['Name']= ($request['Name']=='true')?1:0;
        $inputs['Family']= ($request['Family']=='true')?1:0;
        $inputs['FatherName']= ($request['FatherName']=='true')?1:0;
        //$inputs['Mobile']= ($request['Mobile']=='true')?1:0;
        if($user == null){
            Agent_authentications::Create($inputs);
        }
        else
        {
            Agent_authentications::where('Token',$inputs['Token'])->update($inputs);
        }
        $user = User::where('authentication_token',$inputs['Token'])->first();
        if(empty($user))
        {
            return false;
        }
        if($inputs['IdCode'] && $inputs['Name'] && $inputs['Family'] && $inputs['FatherName']/* && $inputs['Mobile']*/){
            $status='1';
            $sms = 'okauth';
            $model = User::find( $user->id);
            $model->has_role = 1;
            $model->active = 1;
            $model->is_authenticated = '1';
            $model->status = $status;
            // assign role
            $role = ['expert'];
            $selectedRole = Role::whereIn('name',$role)->pluck('id')->toArray();
            $roleIds = $selectedRole ? json_encode($selectedRole) : null;
            $model->role_ids = $roleIds;
            // assign role
            if(is_array($role)){
                foreach ($role as $roleName){
                    $model->assignRole( $roleName );
                }
            }
            $model->save();
            $sms = 'okauth';
            //sendSms($user->username,'عزیز',null,null,$sms,null,null,$user->fullname());
            sendSms($user->username,smsText('okauth',array($user->fullname() , 'عزیز')));
        }
        else
        {
            $status='4';
            $sms = 'notokauth';
            User::where('authentication_token',$inputs['Token'])->update(array('status'=>$status));
            //sendSms($user->username,'عزیز',null,null,$sms,null,null,$user->fullname());
            sendSms($user->username,smsText('notokauth',array($user->fullname() , 'عزیز')));
            setNotificationLog($user->id,"notokauth", $user->fullname()." عزیز ، احراز هویت شما در ".ss('SITE_NAME')." با مشکل مواجه شده است<br/>ویرایش اطلاعات از طریق :<br/><a target='_blank' href='".env('APP_URL')."/kyc'>".env('APP_URL')."/kyc</a>" );
        }
    }

    public function experts(Request $request)
    {
        $user = Auth::user();
        $users = User::where('has_role', 1)->where('status', '1')->where('active', 1);
        if ($request->name) {
            $searchTerms = explode(' ',$request->name);
            foreach($searchTerms as $searchTerm){
                $users=$users->where('name', 'like', '%'.$searchTerm.'%')->orWhere('last_name', 'like', '%'.$searchTerm.'%');
            }
        }
        $totalCount = $users->count();
        $model = $users->paginate(20);
        $provinces = Province::get(['id', 'name']);
        if ($request->ajax() && $totalCount > 0)
        {
            $couter=$totalCount/20;
            $counter1= round($couter);
            if($counter1>=$couter) $couter=$counter1;
            else $couter=$counter1+1;
            $hasPage = ($couter==$request->page)? false : true;
            //$view = view('frontend.province.districtlist', compact('model'))->render();
            if(ss('SITE_ID') == 7)
            {
                $view = view('site7.frontend.expert.component_agent_list', compact('model'))->render();
            }
            else
            {
                $view = view('frontend.expert.component_agent_list', compact('model'))->render();
            }
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        if(ss('THEME') == 'site8' || ss('THEME') == 'site5' || ss('THEME') == 'site7')
        {
            return view(ss('THEME').'.frontend.expert.search',compact(
                'model',
                'usercount'
            ));
        }
        else
        {
            return view('frontend.expert.search', compact(
                'model'
            ));
        }
        return view('frontend.province.district', compact('model', 'provinces'));
    }

    public function getSearchForm(Request $request , $city = '')
    {
        if($city == ''){
            $city = ss('DEFAULT_CITY');
        }
        $authUser = Auth::user();
        if (session()->has('referrerUrl')) {
            session()->forget('referrerUrl');
        }
        // get template page and ads
        //$templatePage = getTemplatePageWithAds(4);
        // retrieve selected city
        $selectedCity = $city;
        $city = City::with(['districts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])
            ->where('name_en', $selectedCity)
            ->where('active', 1)
            ->first();
        if (!$city) {
            $request->session()->put('referrerUrl', $request->getRequestUri());
            return redirect('/cities');
        }
        // $cityList = City::where('province_id', $city->province_id)->where('active', 1)->get();
        // foreach($cityList as $city){
        //     $arrCity[] = $city->id;
        // }

        // get district
        $districts = $city->districts;
        $users = User::where('has_role', 1)->where('status', '1')->where('active', 1);

        // filter name
        if ($request->name) {
            $searchTerms = explode(' ',$request->name);
            foreach($searchTerms as $searchTerm){
                $users=$users->where('name', 'like', '%'.$searchTerm.'%')->orWhere('last_name', 'like', '%'.$searchTerm.'%');
            }
        }

        //$users = $users->whereIn('city_id', $arrCity)
        ;

        $users=$users->orderBy('id', 'desc');
        //dd(getQuery($users));
        $usercount=$users->count();
        //
        $users = $users->paginate(20);
        //dd(getQuery($users));
        $dt = Carbon::now();

        if($request->ajax()  && $usercount>0) {

            $couter=$usercount/20;

            $hasPage = true;
            //dd($couter+1,$request->page);
            if(ss('SITE_ID') == 7)
            {
                $view = view('site7.frontend.expert.component_agent_list', compact('users'))->render();
            }
            else
            {
                $view = view('frontend.expert.component_agent_list', compact('users'))->render();
            }
            return response()->json( [ 'html' => $view, 'count'=>$usercount,'hasPage'=>$hasPage ] );
        }
        $selectedDistricts = [];
        $name = $request->name ?? '';
        $activityType = $request->activity_type ?? '';
        $estateType = $request->activity_estate_type ?? [];
        $sortBy = 1;
        $request->session()->put('url.intended', '/'.$city.'/agents/search');

        if(ss('THEME') == 'site8' || ss('THEME') == 'site5' || ss('THEME') == 'site7')
        {
            return view(ss('THEME').'.frontend.expert.search',compact(
                'city',
                'districts',
                'users',
                'name',
                'sortBy',
                'usercount'
            ));
        }
        else
        {
            return view('frontend.expert.search', compact(
                'city',
                'districts',
                'users',
                'name',
                'sortBy'

            ));
        }
    }
    public function search(Request $request, $city = '')
    {
        if($city == ''){
            $city = ss('DEFAULT_CITY');
        }
        // retrieve selected city
        $selectedCity = $city;
        $city = City::with(['districts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])
            ->where('name_en', $selectedCity)
            ->where('active', 1)
            ->first();
        if (!$city) {
            return redirect('/home');
        }
        // get districts of selected city
        $districts = $city->districts ?? [];
        $selectedDistricts = [];
        $name = $request->name ?? '';
        $gender = $request->gender ?? '';
        $activityType = $request->activity_type ?? '';
        $estateType = $request->activity_estate_type ?? [];
        $activityRange = [0, 0];
        $sortBy = $request->sort ?? 1;
        // start query
        $users = User::whereHas('roles', function ($q) {
            $q->where('role_id', 9);
        })->with([
            'estates' => function ($q) {
                $q->orderBy('id', 'desc');
            }
        ])->where('is_admin', 0)
            ->where('has_role', 1)
            ->where('status', '1')
            ->where('active', 1)
            ->where('city_id', $city->id);
        // filter districts
        $selectedDistricts = !empty($request->districts) ? array_filter($request->districts,function ($value) {
            return !empty($value);
        }) : [];
        if (!empty($selectedDistricts)) {
            $selectedDistricts = array_map(function ($value) {
                return (int)$value;
            }, $selectedDistricts);
            $users = $users->whereHas('districts', function ($q) use ($selectedDistricts) {
                $q->whereIn('district_id', $selectedDistricts);
            });
        }
        // filter gender
        if ($request->gender) {
            $users = $users->where('gender', $request->gender);
        }
        // filter name
        if ($request->name) {
            $users = $users->where('name', 'LIKE', '%' . $request->name . '%');
        }
        // filter activity type
        if ($request->activity_type != 3) {
            $users = $users->where('activity_type', $request->activity_type);
        }
        // filter estate type
        if ($request->activity_estate_type) {
//            $users = $users->whereIn('activity_estate_type', $request->activity_estate_type);
            $users = $users->whereJsonContains('activity_estate_type', $request->activity_estate_type);
        }
        $selectedExperience=0;
        // filter experience
        if ((int)$request->experience > 0) {
            $selectedExperience = (int)$request->experience;
            $experienceStartDate = Carbon::now()->subYear($selectedExperience);
            //$users = $users->where('experience', '<=', $request->experience);
            $users = $users->where('experience_date', '<=', $experienceStartDate);
        }
        $selectedExperience_kama=0;

        if ($sortBy == 2) {
            $users = $users->orderBy('last_activity', 'desc')->orderBy('id', 'desc');
        }
        // get data
        $users = $users->paginate(10);
        $dt = Carbon::now();
        foreach ($users as $user) {
            // get estates for sale
            $user->estate_for_sale = $user->estates->where('expired_at', '>=', $dt)->where('confirmation', 'verified')->count() ?? 0;
            // get last activity
            $lastActivity = '';
            // from activity log
            $lastEstate = $user->estates->first();
            if($lastEstate){
                $lastActivity = $lastEstate->updated_at;
            }
            $user->last_activity = $lastActivity ?? '';
            // calc kama experience
            $created = $user->created_at;
            $now = Carbon::now();
            try {
                $created = new Carbon($user->created_at);
            } catch (\Exception $e) {
            }
        }
        if ( $request->ajax() && $users->count() > 0) {
            $view = view( 'frontend.expert.component_agent_list', compact( 'users' ) )->render();
            return response()->json( [ 'html' => $view ] );
        }
        return view('frontend.expert.search', compact(
            //'templatePage',
            'city',
            'districts',
            'users',
            'selectedDistricts',
            'gender',
            'name',
            'activityType',
            'estateType',
            'activityRange',
            'sortBy',
            'selectedExperience',
            'selectedExperience_kama',
            'request'
        ));
    }
    public function sitemap(Request $request, $pagesize = 0)
    {
        $agents = User::where('is_admin', 0)
            ->where('has_role', 1)
            ->where('status', '1')
            ->where('active', 1)->get();
        return response()->view('frontend.expert.sitemap', ['agents'=>$agents])->header('Content-Type', 'text/xml');;
    }

    public function ShowEstate(Request $request)
    {
        $estates=Estate::where('expert_id',$request->user)->where('type',$request->type)->where('active',0)->where('visibility', 1);
        $totalCount=$estates->count();
        $estates=$estates->paginate(4);
        $featureValues = FeatureValue::get();
            $couter=$totalCount/9;
            $couter=(int)$couter;
            $hasPage = ($couter==$request->page)? false : true;
            $view = view('frontend.estate.component_ex_estate_item', compact('estates','featureValues','totalCount'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
    }
    public function ShowEstate_v2(Request $request)
    {
        if($request->estate>0){
            $estates=Estate::where('expert_id',$request->user)->whereIn('estate_type',explode(',',$request->estate))->where('visibility',1)->where('confirmation','verified');
        }
        else
        {
            $estates=Estate::where('expert_id',$request->user)->where('visibility',1)->where('confirmation','verified');
        }
        $totalCount=$estates->count();
        $estates=$estates->paginate(6);
        $featureValues = FeatureValue::get();
            $couter=$totalCount/6;
            $couter=(int)$couter;
            $hasPage = ($couter==($request->page-1))? false : true;
            $view = view('frontend.estate.component_ex_estate_item_v2', compact('estates','featureValues','totalCount'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
    }
    public function ShowEstate1(Request $request)
    {
        $estates=Estate::where('expert_id',$request->user)->where('estate_type',$request->type)->where('visibility',1)->where('confirmation','verified');
        $totalCount=$estates->count();
        $estates=$estates->paginate(9);
        $featureValues = FeatureValue::get();
        $couter=$totalCount/9;
        $couter=(int)$couter;
        $hasPage = ($couter==$request->page)? false : true;
        $fieldList = getFeatures(0, 0);
        $view = view('frontend.estate.component_ex_estate_item1', compact('estates','featureValues','fieldList','totalCount'))->render();
        return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
    }
    public function show(Request $request, $token)
    {

        $estates = Estate::with([
            'expert:id,code,name,last_name,username,photo,alias,title,video,temp_bio,phone',
            'user:id,code,name,last_name,username,photo,alias,title,video,temp_bio,phone'
        ])->where('visibility', 1)
            ->where('image_count','>',0)
            ->where('price','<>',0)
            ->where('confirmation', 'verified')->orderBy('id','desc')->limit(9)->get();
            //dd($estate->coverImage());
        $fieldList = getFeatures(0, 0);

        // retrieve user
        $user = User::whereHas('roles', function ($q) {
            $q->where('role_id', 9);
        })->with([
            'roles',
            'estates' => function ($q) {
                $q->where('visibility',1)->limit(10)->orderBy('id', 'desc');
            }])
            ->where('has_role', 1)
            ->where('status', '1')
            ->where('active', 1)
            ->where('id', $token)
            ->first();
            //dd(getQuery($user));
        if (!$user) {
            return view('frontend.errors.404');
        }

        $featureValues = FeatureValue::get();
        if(ss('SITE_ID') == 8 || ss('SITE_ID') == '5' || ss('SITE_ID') == '7' || ss('SITE_ID') == '10' || ss('SITE_ID') == 11)
        {
            return view('site'.ss('SITE_ID').'.frontend.expert.show',compact('user','featureValues','estates','fieldList'));
        }
        else
        {
            return view('frontend.expert.show',compact('user','featureValues','estates','fieldList'));
        }
    }

    public function addComment(Request $request)
    {
        // auth user
        $authUser = Auth::user();
        // retrieve user
        $expert = User::where('is_admin', 0)
            ->where('has_role', 1)
            ->where('status', '1')
            ->where('active', 1)
            ->where('code', $request->code)
            ->first();
        if (!$expert) {
            return back()->with(['errors' => 'کارشناس انتخاب شده نامعتبر است!']);
        }
        $validator = Validator::make( $request->all(), [
            'code'   => 'required|exists:users,code',
            'body'      => 'required|max:4000',
        ] );
        if ( $validator->fails() ) {
            return back()->with(['errors' => $validator->errors()]);
        }
        Comment::create( [
            'commentable_type' => 'user',
            'commentable_id'   => $expert->id,
            'user_id'   => $authUser->id ?? null,
            'body'      => $request->body,
            'rate'=>$request->rate
        ] );
        return response([
            'status' => 'ok',
        ], config('StatusCode.SUCCESS'));
    }
    public function addToFavorite($expert_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
        }
        $validator = Validator::make(['id' => $expert_id], [
            'id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.INVALID_INPUT'));
        }
        $ef = ExpertFavorite::where('expert_id', $expert_id)->where('user_id', $user->id)->first();
        //dd($ef);
        if (!$ef) {
            $user->favoriteExperts()->attach($expert_id);
            $status = 1;
        } else {
            $user->favoriteExperts()->detach($expert_id);
            $status = 0;
        }
        return response([
            'status' => 'ok',
            'result' => $status
        ], config('StatusCode.SUCCESS'));
    }
    public function pinFavorite($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
        }
        $ef = ExpertFavorite::find($id);
        if (!$ef) {
            $status = 1;
        } else {
            $ef->update(['pin'=> $ef->pin == 1 ? 0 : 1]);
            $status = $ef->pin;
        }
        return response([
            'status' => 'ok',
            'result' => $status
        ], config('StatusCode.SUCCESS'));
    }
    public function showComment(Request $request)
    {
        $expert = User::where('is_admin', 0)
        ->where('has_role', 1)
        ->where('status', '1')
        ->where('active', 1)
        ->where('id', $request->id)
        ->first();
    if (!$expert) {
        return back()->with(['errors' => 'کارشناس انتخاب شده نامعتبر است!']);
    }
        $comments=Comment::where('status','verified')->where('commentable_type','user')->where('commentable_id',$expert->id)->orderBy('id', 'desc');
        $totalCount=$comments->count();
        $comments=$comments->paginate(20);
        $featureValues = FeatureValue::get();
            $couter=$totalCount/20;
            $couter=(int)$couter;
            if($totalCount<20)
                 $hasPage=false;
            else
                 $hasPage = ($couter==$request->page)? false : true;
            $view = view('frontend.expert.comment', compact('comments','featureValues','totalCount'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
    }
    public function addSearch(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response([
                'status' => 'error',
                'result' => 'authentication failed!'
            ], config('StatusCode.UNAUTHORIZED'));
        }
        $validator = Validator::make($request->all(), [
            'url' => 'required',
            'title' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.INVALID_INPUT'));
        }
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
            'type' => 2,
            'url' => $request->get('url'),
        ]);
        $us->title = $request->title;
        $us->ip = $ip;
        $us->agent = $browser;
        $us->device = $platform;
        $us->save();
        if (!$us) {
            return response([
                'status' => 'false',
                'result' => 'error!'
            ], config('StatusCode.SUCCESS'));
        }
        return response([
            'status' => 'true',
            'result' => 'search added successfully'
        ], config('StatusCode.SUCCESS'));
    }
}
