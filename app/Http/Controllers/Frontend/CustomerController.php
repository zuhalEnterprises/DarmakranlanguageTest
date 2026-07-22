<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\RentalCustomer;
use App\Models\CustomerFavorite;
use App\Models\RelationEstateCustomer;
use App\Models\CustomerNote;
use App\Models\EstateOperation;
use App\Models\Acquaintance;
use App\Models\CustomerDistrict;
use App\Models\User;
use App\Models\City;
use App\Models\Estate;
use App\Models\Branch;
use App\Models\CustomerAppointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Jenssegers\Agent\Agent;
use App\Models\FeatureValue;
use Verta;

class CustomerController extends Controller
{
    protected $model, $route, $viewPath, $routeName;
    public function __construct()
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            $this->middleware('role:admin_super|expert|referrer');
        }
        elseif(ss('SITE_ID') != 3 && ss('SITE_ID') != 2  && ss('SITE_ID') != 7)
        {
            $this->middleware('role:admin_super|expert');
        }
        $this->model = new Customer();
        $this->route = 'customers';
        $this->viewPath = 'customer';
    }
    public function assignExpert(Request $request, $id)
    {
        // احراز هویت و مجوز دسترسی
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            return response()->json(['message' => 'شما اجازه این عملیات را ندارید.'], 403);
        }

        // اعتبارسنجی ورودی
        $request->validate([
            'expert_id' => 'required|exists:users,id',
        ]);

        // دریافت مشتری
        $customer = Customer::findOrFail($id);



        // اعمال تغییر
        $customer->user_id = $request->expert_id;
        $customer->save();

        return response()->json(['message' => 'مشاور با موفقیت تغییر یافت.']);
    }

    public function update(Request $request, $id)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $model = Customer::find($id);
        if (empty($model)) {
            return back()->withInput()->withErrors(['یافت نشد!']);
        }
        if ($model->user_id != $user->id && !$user->isAdminSuper()) {
            return back()->withErrors(['شما دسترسی به این بخش را ندارید!']);
        }
        $inputs = $request->all();
        if($request->status==6){
            $datefrom = explode('/',$request->datereconfirm);
            if(count($datefrom)>2)
            {
                $inputs['datereconfirm']=Verta::parse(jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-'))->formatGregorian('Y-m-d H:i:s');
            }
        }
        else if($request->status==5 && ss('SITE_ID') == 3){
            $inputs['datereconfirm']=Carbon::now()->addDays(7);
        }
        else
        {
            $inputs['datereconfirm'] = null;
        }
        $inputs['price_min'] = str_replace(',' , '' , $request->price_min);
        $inputs['price_max'] = str_replace(',' , '' , $request->price_max);
        $inputs['rent_min'] = str_replace(',' , '' , $request->rent_min);
        $inputs['rent_max'] = str_replace(',' , '' , $request->rent_max);
        $inputs['mortgage_min'] = str_replace(',' , '' , $request->mortgage_min);
        $inputs['mortgage_max'] = str_replace(',' , '' , $request->mortgage_max);
        if($inputs['price_min'] == ''){
            $inputs['price_min'] = null;
        }
        if($inputs['price_max'] == ''){
            $inputs['price_max'] = null;
        }
        if($inputs['rent_min'] == ''){
            $inputs['rent_min'] = null;
        }
        if($inputs['rent_max'] == ''){
            $inputs['rent_max'] = null;
        }
        if($inputs['mortgage_min'] == ''){
            $inputs['mortgage_min'] = null;
        }
        if($inputs['mortgage_max'] == ''){
            $inputs['mortgage_max'] = null;
        }
        if(isset($inputs['conditions'])){
            $inputs['conditions'] = !empty($inputs['conditions']) && is_array($inputs['conditions']) ? json_encode($inputs['conditions']) : null;
        }
        if(isset($inputs['facilities'])){
            $inputs['facilities'] = !empty($inputs['facilities']) && is_array($inputs['facilities']) ? json_encode($inputs['facilities']) : null;
        }
        //dd($inputs);
        if($request->expertid){
            $inputs['user_id'] = $request->expertid;
            $inputs['grade'] = null;
            if($model->user_id != $request->expertid)
            {
                $userFrom = User::find($model->user_id);
                $userTo = User::find($request->expertid);
                if($userFrom != null && $userTo != null)
                {
                    $operation_id = EstateOperation::create([
                        'expert_id' => $user->id,
                        'comment' => 'Change From '.$userFrom->fullname().' to '.$userTo->fullname(),
                        'customer_id'=> $id,
                        'type'=> 16
                    ]);
                }
            }
        }
        $model->update(checkInputs($inputs));
       // $noteList = CustomerNote::where('user_id', $user->id)->where('customer_id', $model->id);
        if ($model->user_id != $user->id){
            $agent = new Agent();
            $platform = $agent->platform();
            $platform .= ' ' . $agent->version($platform);
            $browser = $agent->browser();
            $browser .= ' ' . $agent->version($browser);
            $ip = \Request::ip();
            CustomerNote::create([
                'user_id' => $user->id,
                'customer_id' => $model->id,
                'note' => $request->note,
                'ip' => $ip,
                'agent' => $browser,
                'device' => $platform
            ]);
        }
        $districts = $request->districts ?? [];
        $districts = array_filter($districts, function ($value) {
            return $value != null;
        });
        // assign districts
        $model->districts()->sync($districts);
        relEstate($id);
        //session()->flash('مشتری با موفقیت بروزرسانی شد.')->success();
        return redirect('/customer/'.$id);
    }
    public function rental_update(Request $request, $id)
    {
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $model = RentalCustomer::find($id);
        if (empty($model)) {
            return back()->withInput()->withErrors(['یافت نشد!']);
        }
        if (!$user->isAdminSuper()) {
            return back()->withErrors(['شما دسترسی به این بخش را ندارید!']);
        }
        $inputs = $request->all();
        if($inputs['stay_from'] != ''){
            $stay_from = explode('/' , $inputs['stay_from']);
            $inputs['stay_from'] = jalali_to_gregorian($stay_from[0] , $stay_from[1] , $stay_from[2] , '-');
        }
        if($inputs['stay_to'] != ''){
            $stay_to = explode('/' , $inputs['stay_to']);
            $inputs['stay_to'] = jalali_to_gregorian($stay_to[0] , $stay_to[1] , $stay_to[2] , '-');
        }
        if($model->status == 1 && $inputs['status'] == 2)
        {
            $suggest = getsetting('sms','rentalcustomerStatus2');
            $name = ($inputs['gender'] == 'female'?'سرکار خانم ':'جناب آقای ').$inputs['name'];
            $arrSearch = array("{0}","{1}");
            $arrReplace = array(toPersianNumbers($inputs['price']) , $name);
            $text = str_replace($arrSearch, $arrReplace, $suggest);
            sendSms($model->mobile , $text);
            $model->update(checkInputs($inputs));
        }
        if($model->status == 2 && $inputs['status'] == 3)
        {
            $suggest = getsetting('sms','rentalcustomerStatus3');
            $name = ($inputs['gender'] == 'female'?'سرکار خانم ':'جناب آقای ').$inputs['name'];
            $estate = Estate::where('id', $inputs['estate_id'])->first();
            $address = ($estate->city->name ?? '').' '.(!empty($estate->address)?" ،".$estate->address:"");
            $arrSearch = array("{0}" , "{1}" , "{2}", "{3}", "{4}", "{5}");
            $arrReplace = array($name , $inputs['estate_id'] , toPersianDateYdm($inputs['stay_from']) , toPersianDateYdm($inputs['stay_to']) , $address , $estate->phone);
            $text = str_replace($arrSearch, $arrReplace, $suggest);
            sendSms($model->mobile , $text);
            $model->update(checkInputs($inputs));
        }


        //session()->flash('تقاضا با موفقیت بروزرسانی شد.')->success();
        return redirect('/rental/customers');
    }
    function GUID()
    {
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
    public function absence(Request $request)
    {
        $customer = Customer::where('id', $request->customer_id)->first();
        if(!$customer)
        {
            return response()->json( ['status' => 'error'] );
        }
        $user = Auth::user();
        if((!empty(Auth::user()) && Auth::user()->isAdmin()) || (!empty(Auth::user()) && Auth::user()->isExpert() ))
        {
            $absence = getsetting('sms','absence');
            $arrSearch = array("{0}" , "{1}");
            $arrReplace = array(Auth::user()->fullname() , Auth::user()->username);
            $text = str_replace($arrSearch, $arrReplace, $absence);
            sendSms($customer->mobile , $text);
            //sendSms('09124525207' , $text);
            return response()->json( ['status' => 'ok'] );
        }
    }
    public function CheckConfirmation()
    {
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        Customer::Where('datereconfirm','<',Carbon::today())->whereIn('status',[5,6])->update(['status' => 1]);
        return response()->json(['html' => "ثبت شد"]);
        //return view($this->viewPath . '.show', compact('model'));
    }
    public function changeCustomerStatus($slug)
    {
        Customer::Where('guid' , $slug)->update(['status' => 8]);
        return response()->json( ['status' => 'ok'] );
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $inputs = $request->all();
        $inputs['guid'] = $this->GUID();
        $inputs['price_min'] = str_replace(',' , '' , $request->price_min);
        $inputs['price_max'] = str_replace(',' , '' , $request->price_max);
        $inputs['rent_min'] = str_replace(',' , '' , $request->rent_min);
        $inputs['rent_max'] = str_replace(',' , '' , $request->rent_max);
        $inputs['mortgage_min'] = str_replace(',' , '' , $request->mortgage_min);
        $inputs['mortgage_max'] = str_replace(',' , '' , $request->mortgage_max);
        if($inputs['price_min'] == ''){
            $inputs['price_min'] = null;
        }
        if($inputs['price_max'] == ''){
            $inputs['price_max'] = null;
        }
        if($inputs['rent_min'] == ''){
            $inputs['rent_min'] = null;
        }
        if($inputs['rent_max'] == ''){
            $inputs['rent_max'] = null;
        }
        if($inputs['mortgage_min'] == ''){
            $inputs['mortgage_min'] = null;
        }
        if($inputs['mortgage_max'] == ''){
            $inputs['mortgage_max'] = null;
        }
        if(isset($inputs['conditions'])){
            $inputs['conditions'] = !empty($inputs['conditions']) && is_array($inputs['conditions']) ? json_encode($inputs['conditions']) : null;
        }
        if(isset($inputs['facilities'])){
            $inputs['facilities'] = !empty($inputs['facilities']) && is_array($inputs['facilities']) ? json_encode($inputs['facilities']) : null;
        }
        //dd($user);
        if($user->isExpert() || $user->isAdmin() || $user->isAdminBranch())
        {
            $inputs['user_id'] = $request->expertid;
        }
        else
        {
            $inputs['user_id'] = null;
        }
        $inputs['create_id']=$request->user_id;
        //dd($inputs);
        $model = Customer::create(checkInputs($inputs));
        if($model->user_id != null)
        {
            if(ss('SITE_ID') != 3)
            {
                $suggest = getsetting('sms','addcustomer');
                $arrSearch = array("{0}" , "{1}" , "{2}" , "{3}");
                if(str_contains($model->name, 'خانم ') || str_contains($model->name, 'آقای ') || str_contains($model->name, 'اقای '))
                {
                    $name = $model->name;
                }
                else
                {
                    $name = ($model->gender == 'female'?'سرکار خانم ':'جناب آقای ').$model->name;
                }
                $arrReplace = array($name , $model->user->fullname() , $model->user->username , $model->guid);
                $text = str_replace($arrSearch, $arrReplace, $suggest);
                sendSms($model->mobile , $text);
            }
        }
        if ($model)
        {
            $agent = new Agent();
            $platform = $agent->platform();
            $platform .= ' ' . $agent->version($platform);
            $browser = $agent->browser();
            $browser .= ' ' . $agent->version($browser);
            $ip = \Request::ip();
            // create or update
            CustomerNote::create([
               'user_id' => $user->id,
               'customer_id' => $model->id,
               'note' => $request->note,
               'ip' => $ip,
               'agent' => $browser,
               'device' => $platform
            ]);
            //$districts = $request->districts ?? [];
            $districts = $request->districts ?? [];
            $districts = array_filter($districts, function ($value) {
                return $value != null;
            });
            // assign districts
            if (count($districts) > 0) $model->districts()->sync($districts);
            relEstate($model->id);
            // add custom log
            // $log = 'ثبت مشتری توسط ' . ($user->name??'') . ' در ' . toPersianDate($model->created_at);
            // setActivityLog( $model, $user, __FUNCTION__, $log);
            //session()->flash('مشتری جدید با موفقیت ثبت شد.')->success();
        }
        return redirect('customer');
    }
    public function rental_store(Request $request)
    {
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $inputs = $request->all();
        $inputs['guid'] = $this->GUID();
        $inputs['user_id'] = $user->id;
        if($inputs['stay_from'] != ''){
            $stay_from = explode('/' , $inputs['stay_from']);
            $inputs['stay_from'] = jalali_to_gregorian($stay_from[0] , $stay_from[1] , $stay_from[2] , '-');
        }
        if($inputs['stay_to'] != ''){
            $stay_to = explode('/' , $inputs['stay_to']);
            $inputs['stay_to'] = jalali_to_gregorian($stay_to[0] , $stay_to[1] , $stay_to[2] , '-');
        }
        $model = RentalCustomer::create(checkInputs($inputs));

        $suggest = getsetting('sms','addrentalcustomer');
        $arrSearch = array("{0}");
        $name = ($model->gender == 'female'?'سرکار خانم ':'جناب آقای ').$model->name;
        $arrReplace = array($name);
        $text = str_replace($arrSearch, $arrReplace, $suggest);
        sendSms($model->mobile , $text);



        return redirect('rental/customers');
    }
    public function index(Request $request, $defaultCity = '')
    {

        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
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
        if($defaultCity == ''){
            $defaultCity = ss('DEFAULT_CITY');
        }
        $append_fields = [ 'district_id', 'favorite'];
        $filters = $this->model->getFilters($request->all(),$append_fields,false);
        foreach ($append_fields as $field){
            $v = $field == 'favorite' ? $request->$field ?? 0 : $request->$field ?? '';
            $filters[$field] = $v;
        }
        // get auth user
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        if($request->page == 1)
        {
            if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
            {
                Customer::where('updated_at' , '<' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-58 day" ) ) )->update(['label' => '0']);
            }
            Customer::where('updated_at' , '<' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-65 day" ) ) )->update(['status' => 4]);
        }
        // start query
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
        /*if(!empty($request->user_id1))
        {
            $model =!empty($request->user_id1)?$model->where('user_id', (int)$request->user_id1) : $model;
        }
        else
        {*/
        if(!empty($request->user_id)){
            if($request->user_id > 0)
            {
                if(ss('SITE_ID') ==4)
                {
                    $model = $model->where('user_id', (int)$user->id);
                }
                else
                {
                    $model = $model->where('user_id', (int)$request->user_id);
                }
            }
            elseif($request->user_id == -1)
            {
                $model = $model->whereNull('user_id');
            }
        }
        if(!$user->isAdmin() && env('PORTAL'))
        {
            if($user->branch_id > 0)
            {
                $model = $model->where( 'branch_id', $user->branch_id);
            }
            else
            {
                $model = $model->where(function ($query) use ($user)
                {
                    $query->where('user_id',  $user->user_id)->orwhereNull('user_id');
                });
            }
        }
        //}
        $model = ! empty( $request->name ) ? $model->where( 'name', 'like', "%$request->name%" ) : $model;
        $model = ! empty( $request->label ) ? $model->where('label', $request->label ) : $model;
        $model = ! empty( $request->residence_type ) ? $model->where('residence_type', $request->residence_type ) : $model;
        $model = ! empty( $request->education )?$model->where('education', $request->education ) : $model;
        $model = ! empty( $request->purchase_reason ) ? $model->where('purchase_reason', $request->purchase_reason ) : $model;
        $model = ! empty( $request->purchase_priority ) ? $model->where('purchase_priority', $request->purchase_priority ) : $model;
        $model = ! empty( $request->financial_liquidity_type ) ? $model->where('financial_liquidity_type', $request->financial_liquidity_type ) : $model;
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
        $model = ! empty( $request->referrer_id) ? $model->where('referrer_id', $request->referrer_id) : $model;
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
        $model = !empty($request->grade) ? $model->where('grade', (int)$request->grade) : $model;
        $model = !empty($request->language) ? $model->where('language_id', (int)$request->language) : $model;
        $model = !empty($request->country) ? $model->where('country_id', (int)$request->country) : $model;
        //dd($request->create_date_to);
        if (!empty($request->create_date_of))
        {
            if(env('COUNTRY') != 'UAE')
            {
                $create_date_of =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->create_date_of);
                $model = $model->where('created_at', '>=',  Verta::parse($create_date_of)->formatGregorian('Y-m-d h:i'));
            }
            else
            {
                $model = $model->where('created_at', '>=',  $request->create_date_of.' 00:00:00');
            }
        }
        if (!empty($request->create_date_to))
        {
            if(env('COUNTRY') != 'UAE')
            {
                $create_date_to =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->create_date_to);
                $model = $model->where('created_at', '<=',  Verta::parse($create_date_to)->formatGregorian('Y-m-d h:i'));
            }
            else
            {
                $model = $model->where('created_at', '<=',  $request->create_date_to.' 23:59:59');
            }
        }
        if (!empty($request->today))
        {
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
                $model = $model->where('status' , '1')->whereRaw("
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
                $model = $model->where('status' , '1')->whereRaw("
                (
                    (`updated_at` >=  '".$ddg1."' and `updated_at` <=  '".$ddg2."') or
                    (`updated_at` >=  '".$ddg3."' and `updated_at` <=  '".$ddg4."') or
                    (`updated_at` >=  '".$ddg5."' and `updated_at` <=  '".$ddg6."') or
                    (`updated_at` >=  '".$ddg7."' and `updated_at` <=  '".$ddg8."') or
                    (`updated_at` >=  '".$ddg9."' and `updated_at` <=  '".$ddg10."') or
                    (`updated_at` >=  '".$ddg11."' and `updated_at` <=  '".$ddg12."') or
                    (`updated_at` >=  '".$ddg15."' and `updated_at` <=  '".$ddg16."') or
                    (`updated_at` >=  '".$ddg19."' and `updated_at` <=  '".$ddg20."') or
                    (`updated_at` >=  '".$ddg21."' and `updated_at` <=  '".$ddg22."') or
                    (`updated_at` >=  '".$ddg23."' and `updated_at` <=  '".$ddg24."') or
                    (`updated_at` >=  '".$ddg25."' and `updated_at` <=  '".$ddg26."') or
                    (`updated_at` >=  '".$ddg27."' and `updated_at` <=  '".$ddg28."') or
                    (`updated_at` >=  '".$ddg29."' and `updated_at` <=  '".$ddg30."')
                )
                ");
            }
        }

        // district
        if (!empty( $request->district_id )) {
            $districts = $request->district_id;
            $model = $model->whereHas('districts',function ($query) use ($districts) {
                $query->whereIn( 'district_id', $districts );
            });
        }
        if (!$user->isReferrer()) {
            $model = $model->where('status', 1);
            $model = $model->where('create_id', $user->id);
        }
        if($user->isExpert() && !$user->isAdmin() && env('COUNTRY') == 'UAE')
        {
            $model = $model->where(function ($query) use ($user)
            {
                //dd($user->languages);
                $query->where(function($query2) use ($user)
                {
                    $query2->where('user_id', '>' , 0);
                })
                ->orWhere(function($query2) use ($user)
                {
                    if($user->languages != null)
                    {
                        foreach($user->languages as $lang)
                        {
                            $l[] = $lang->id;
                        }
                        if(isset($l) && is_array($l) && count($l)>0)
                        {
                            $query2->whereIn('language_id', $l);
                        }
                    }
                }
            )
            ;});
            //dd($user->label);
            if($user->label == 0)
            {
                $model = $model->whereNotIn('grade', [1,2])->where('label' , 0);
            }
            if($user->label == 1)
            {
                $model = $model->where('grade','!=' , 1)->where('label' ,'<=', 1);
            }
            if($user->label == 2)
            {
                $model = $model->where('label' ,'<=', 2);
            }
            if($user->label == 3)
            {
                $model = $model->where('label' ,'<=', 3);
            }
            if($user->label == 4)
            {
                $model = $model->where('label' ,'<=', 4);
            }
        }
        // favorite
        $favorites = CustomerFavorite::where('user_id', $user->id)->pluck('customer_id')->toArray();
        if (!empty($request->favorite)) {
            $model = $model->whereIn('id', $favorites);
        }
        // paginate list
        if(!empty($request->order) && !empty($request->orderby)){
            $model = $model->orderBy($request->order, $request->orderby);
        }
        $model = $model->orderBy('id', 'desc');
        //dd(getQuery($model));
        $totalCount = $model->count();
        //dd($totalCount);
        $model = $model->paginate($request->showcount);
        $model->map(function ($item) {
            //$customerids[] = $item->id;
            $item->chat_id = 0;
            if (count($item->chats) > 0) {
                $item->chat_id = $item->chats->where('customer_id', $item->id)->first()->id;
            }
        });
        $reports = [];
        if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2 || ss('SITE_ID') == 3)
        {
            $customerids = [];
            foreach($model as $customer)
            {
                $customerids[] = $customer->id;
                $reports[$customer->id]['sum'] = 0;
                $reports[$customer->id][0] = 0;
                $reports[$customer->id][1] = 0;
                $reports[$customer->id][2] = 0;
                $reports[$customer->id][3] = 0;
                $reports[$customer->id][3] = 0;
                $reports[$customer->id][3] = 0;
                $reports[$customer->id][3] = 0;
                $reports[$customer->id][3] = 0;
                $reports[$customer->id]['customer'] = 0;
                $reports[$customer->id]['p0'] = 0;
                $reports[$customer->id]['p1'] = 0;
                $reports[$customer->id]['p2'] = 0;
                $reports[$customer->id]['p3'] = 0;
                $reports[$customer->id]['send_at'] = 0;
            }
            if(is_array($customerids) && count($customerids)>0)
            {
                if(ss('SITE_ID') != 3)
                {
                    $query = "";
                    $query = "SELECT `customer_id`,`status`,count(*) as `count` FROM `relation_estate_customer` where `deleted_at` is null ";
                    $query .= " and `customer_id` in (".implode(',' , $customerids).")";
                    if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                    {
                        $query .= " and priority = 1 ";
                    }
                    $query .= " group by `customer_id`,`status` ";
                    $lists = DB::select($query);
                    foreach($lists as $list)
                    {
                        $reports[$list->customer_id][$list->status] = $list->count;
                    }
                }
                if(ss('SITE_ID') == 3)
                {
                    $query = "";
                    $query = "SELECT `customer_id`,`send_at`,count(*) as `count` FROM `relation_estate_customer` where `deleted_at` is null and `send_at` is not null ";
                    $query .= " and `customer_id` in (".implode(',' , $customerids).")";
                    $query .= " group by `customer_id`,`send_at` ";
                    $lists = DB::select($query);
                    foreach($lists as $list)
                    {
                        $reports[$list->customer_id]['send_at'] = $list->count;
                    }
                }
                $sumTotal = 0;
                foreach($reports as $key=>$val)
                {
                    if($reports[$key] && array_key_exists('0',$reports[$key]) &&  array_key_exists('1',$reports[$key]) && array_key_exists('2',$reports[$key]) && array_key_exists('3',$reports[$key]))
                    {
                        $reports[$key]['sum'] = $reports[$key][0] + $reports[$key][1] + $reports[$key][2] + $reports[$key][3];
                        $sumTotal += $reports[$key]['sum'];
                        if($reports[$key]['sum']>0){
                            $reports[$key]['p0'] = sprintf("%.02lf\n", $reports[$key][0] / $reports[$key]['sum'] * 100);
                            $reports[$key]['p1'] = sprintf("%.02lf\n",$reports[$key][1] / $reports[$key]['sum'] * 100) ;
                            $reports[$key]['p2'] = sprintf("%.02lf\n",$reports[$key][2] / $reports[$key]['sum'] * 100);
                            $reports[$key]['p3'] = sprintf("%.02lf\n",$reports[$key][3] / $reports[$key]['sum'] * 100);
                        }
                    }
                }
            }
        }


        $districts = $user->city ? $user->city->districts->pluck('name', 'id') : [];
        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        if(!$user->isAdmin() && env('PORTAL'))
        {
            if($user->branch_id > 0)
            {
                $users->where('branch_id', $user->branch_id);
            }

        }
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 9);
        })->get(['id', 'name','last_name', 'username','status']);
        if ($request->ajax() && $model->count() > 0)
        {
            $report2[0] = 0;
            $report2[1] = 0;
            $report2[2] = 0;
            $report2[3] = 0;
            $report2['total'] = 0;
            if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2)
            {
                $query = "SELECT relation_estate_customer.`status`,count(*) as `count` FROM `relation_estate_customer` inner join `customers` on
                `relation_estate_customer`.customer_id = `customers`.id where customers.`deleted_at` is null and customers.`status` = 1 and
                relation_estate_customer.`deleted_at` is null";
                if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                {
                    $query .= " and relation_estate_customer.priority = 1 ";
                }
                if(!empty($request->user_id)){
                    if($request->user_id > 0)
                    {
                        $query .= " and `customer_expert_id` = '".$request->user_id."'";
                    }
                }
                $query .= " group by `status`";
                //dd($query);
                $lists = DB::select($query);
                foreach($lists as $list)
                {
                    $report2[$list->status] = $list->count;
                }
                $report2['total'] = $report2[0] + $report2[1] + $report2[2] + $report2[3];
            }
            $couter=$totalCount/$request->showcount;
            $counter1= round($couter);
            if($counter1>=$couter) $couter=$counter1;
            else $couter=$counter1+1;
            $hasPage = ($couter==$request->page)? false : true;
            $request_type = $request->request_type;
            $currentuserid = $user->id;
            if(ss('SITE_ID') == 7)
            {

                $view = view('site'.ss('SITE_ID').'.frontend.customer.component_ex_customer_type1', compact('model','request_type','currentuserid','totalCount','reports','report2'))->render();
            }
            elseif(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
            {
                $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
                $users = $users->whereHas('roles', function ($query) {
                    $query->where( 'id', '=', 9);
                })->get(['id', 'name','last_name', 'username','status']);

                $view = view('site'.ss('SITE_ID').'.frontend.customer.component_ex_customer_type3', compact('model','request_type','currentuserid','totalCount','reports','report2' , 'users'))->render();
            }
            else
            {
                $view = view('frontend.customer.component_ex_customer_type2', compact('model','request_type','currentuserid','totalCount','reports','report2'))->render();
            }
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        // dd($model[0]->user);
        $deal_type=$request->deal_type;
        $defaultCity=$_COOKIE['city'] ?? ss('DEFAULT_CITY');
        $city = City::where('name_en', $defaultCity)->where('active', 1)->first();
        if($city == null){
            $city = City::where('name_en', ss('DEFAULT_CITY'))->where('active', 1)->first();
        }
        $cities = City::where('province_id', $city->province_id)->where('active', 1)->get();
        $dateto = gregorian_to_jalali(date('Y'),date('m'),date('d'),'/');
        /*if(env('COUNTRY') == 'UAE')
        {
            $Agent = new Agent();
            return view('site4.frontend.customer.index', compact('model', 'users', 'districts', 'favorites', 'filters','deal_type','cities' , 'dateto' , 'Agent'));
        }
        elseif(ss('SITE_ID') == 7)
        {
            $typelist = 'my';
            $Agent = new Agent();
            return view('site7.frontend.customer.index', compact('model', 'users', 'districts', 'favorites', 'filters','deal_type','cities' , 'dateto' , 'Agent','typelist'));
        }
        else*/
        {
            $referrers = null;
            if(env('COUNTRY') == 'UAE')
            {
                $referrers = User::with('roles')
                ->where('has_role', 1)
                ->whereIn('status', ['1'])
                ->whereHas('roles', function ($query) {
                    $query->where( 'id', '=', 10);
                })->get(['id', 'name','last_name', 'username','status']);
            }
            $branches = null;
            if($user->isAdmin() && env('PORTAL'))
            {
                $branches = Branch::get();
            }
            if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
            {
                return view(ss('THEME').'.frontend.customer.index', compact('model', 'users', 'districts', 'favorites', 'filters','deal_type','cities' , 'datefrom', 'dateto' , 'branches' , 'referrers'));
            }
            else
            {
                return view('frontend.customer.index', compact('model', 'users', 'districts', 'favorites', 'filters','deal_type','cities' , 'datefrom', 'dateto' , 'branches' , 'referrers'));
            }
        }
    }

    public function referrer(Request $request, $defaultCity = '')
    {

        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
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
        if($defaultCity == ''){
            $defaultCity = ss('DEFAULT_CITY');
        }
        $append_fields = [ 'district_id', 'favorite'];
        $filters = $this->model->getFilters($request->all(),$append_fields,false);
        foreach ($append_fields as $field){
            $v = $field == 'favorite' ? $request->$field ?? 0 : $request->$field ?? '';
            $filters[$field] = $v;
        }
        // get auth user
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        if($request->page == 1)
        {
            if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
            {
                Customer::where('updated_at' , '<' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-58 day" ) ) )->update(['label' => '0']);
            }
            Customer::where('updated_at' , '<' , date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-65 day" ) ) )->update(['status' => 4]);
        }
        // start query
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


        //}
        $model = ! empty( $request->name ) ? $model->where( 'name', 'like', "%$request->name%" ) : $model;
        $model = ! empty( $request->label ) ? $model->where('label', $request->label ) : $model;
        $model = ! empty( $request->residence_type ) ? $model->where('residence_type', $request->residence_type ) : $model;
        $model = ! empty( $request->status) ? $model->where('status', $request->status) : $model;
        $model = ! empty( $request->mobile) ? $model->where('mobile', $request->mobile) : $model;
        $model = ! empty( $request->referrer_id) ? $model->where('referrer_id', $request->referrer_id) : $model;
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
        $model = !empty($request->grade) ? $model->where('grade', (int)$request->grade) : $model;
        $model = !empty($request->language) ? $model->where('language_id', (int)$request->language) : $model;
        $model = !empty($request->country) ? $model->where('country_id', (int)$request->country) : $model;
        //dd($request->create_date_to);
        if (!empty($request->create_date_of))
        {
            if(env('COUNTRY') != 'UAE')
            {
                $create_date_of =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->create_date_of);
                $model = $model->where('created_at', '>=',  Verta::parse($create_date_of)->formatGregorian('Y-m-d h:i'));
            }
            else
            {
                $model = $model->where('created_at', '>=',  $request->create_date_of.' 00:00:00');
            }
        }
        if (!empty($request->create_date_to))
        {
            if(env('COUNTRY') != 'UAE')
            {
                $create_date_to =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->create_date_to);
                $model = $model->where('created_at', '<=',  Verta::parse($create_date_to)->formatGregorian('Y-m-d h:i'));
            }
            else
            {
                $model = $model->where('created_at', '<=',  $request->create_date_to.' 23:59:59');
            }
        }


        // paginate list
        if(!empty($request->order) && !empty($request->orderby)){
            $model = $model->orderBy($request->order, $request->orderby);
        }
        $model = $model->orderBy('id', 'desc');
        //dd(getQuery($model));
        $totalCount = $model->count();
        //dd($totalCount);
        $model = $model->paginate($request->showcount);
        $model->map(function ($item) {
            //$customerids[] = $item->id;
            $item->chat_id = 0;
            if (count($item->chats) > 0) {
                $item->chat_id = $item->chats->where('customer_id', $item->id)->first()->id;
            }
        });
        if ($request->ajax() && $model->count() > 0)
        {

            $couter=$totalCount/$request->showcount;
            $counter1= round($couter);
            if($counter1>=$couter) $couter=$counter1;
            else $couter=$counter1+1;
            $hasPage = ($couter==$request->page)? false : true;
            $request_type = $request->request_type;
            $currentuserid = $user->id;
            $view = view('site'.ss('SITE_ID').'.frontend.customer.component_ex_customer_type2', compact('model','request_type','currentuserid','totalCount'))->render();

            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        $deal_type=$request->deal_type;
        $defaultCity=$_COOKIE['city'] ?? ss('DEFAULT_CITY');
        $city = City::where('name_en', $defaultCity)->where('active', 1)->first();
        if($city == null){
            $city = City::where('name_en', ss('DEFAULT_CITY'))->where('active', 1)->first();
        }
        $dateto = gregorian_to_jalali(date('Y'),date('m'),date('d'),'/');


            $referrers = null;
            if(env('COUNTRY') == 'UAE')
            {
                $referrers = User::with('roles')
                ->where('has_role', 1)
                ->whereIn('status', ['1'])
                ->whereHas('roles', function ($query) {
                    $query->whereIn( 'id',  [1,9,10]);
                })->get(['id', 'name','last_name', 'username','status']);
            }

            return view('site'.ss('SITE_ID').'.frontend.customer.referrer', compact('model', 'filters','deal_type', 'datefrom', 'dateto' ,  'referrers'));

    }

    public function booking(Request $request)
    {

        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
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


        // get auth user
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }

        // start query
        $model = CustomerAppointment::query();

        $model = ! empty( $request->name ) ? $model->where( 'name', 'like', "%$request->name%" ) : $model;
        $model = ! empty( $request->email ) ? $model->where('email', $request->label ) : $model;
        $model = ! empty( $request->mobile) ? $model->where('mobile', $request->mobile) : $model;
        $model = !empty($request->country_id) ? $model->where('country_id', (int)$request->country_id) : $model;
        if (!empty($request->date_of))
        {
            $model = $model->where('created_at', '>=',  $request->date_of.' 00:00:00');
        }
        if (!empty($request->date_to))
        {
            $model = $model->where('created_at', '<=',  $request->date_to.' 23:59:59');
        }
        if(!empty($request->order) && !empty($request->orderby)){
            $model = $model->orderBy($request->order, $request->orderby);
        }
        $model = $model->orderBy('id', 'desc');
        $totalCount = $model->count();
        $model = $model->paginate($request->showcount);
        if ($request->ajax() && $model->count() > 0)
        {
            $couter=$totalCount/$request->showcount;
            $counter1= round($couter);
            if($counter1>=$couter)
                $couter=$counter1;
            else
                $couter=$counter1+1;
            $hasPage = ($couter==$request->page)? false : true;
            $view = view('site'.ss('SITE_ID').'.frontend.customer.booking_type', compact('model','totalCount'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        $dateto = gregorian_to_jalali(date('Y'),date('m'),date('d'),'/');
        return view('site'.ss('SITE_ID').'.frontend.customer.booking', compact('model',  'datefrom', 'dateto' ));
    }

    public function bookingDestroy( $id )
    {
        $user = Auth::user();
        if($user->isAdmin())
        {

            $model = CustomerAppointment::find( $id );
            $model->delete();
            return response()->json( [ 'status' => 'ok', 'result' => 'deleted!' ], config( 'StatusCode.SUCCESS' ) );
        }
	}

    public function branchlist(Request $request, $defaultCity = '')
    {
        if($defaultCity == ''){
            $defaultCity = ss('DEFAULT_CITY');
        }
        $append_fields = [ 'district_id', 'favorite'];
        $filters = $this->model->getFilters($request->all(),$append_fields,false);
        foreach ($append_fields as $field){
            $v = $field == 'favorite' ? $request->$field ?? 0 : $request->$field ?? '';
            $filters[$field] = $v;
        }
        // get auth user
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }

        // start query
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

        if(!empty($request->user_id)){
            if($request->user_id > 0)
            {
                $model = $model->where('user_id', (int)$request->user_id);

            }
            elseif($request->user_id == -1)
            {
                $model = $model->whereNull('user_id');
            }
        }

        if($user->branch_id > 0)
        {
            $model = $model->where( 'branch_id', $user->branch_id);
        }

        //}
        $model = ! empty( $request->name ) ? $model->where( 'name', 'like', "%$request->name%" ) : $model;

        $model = ! empty( $request->residence_type ) ? $model->where('residence_type', $request->residence_type ) : $model;

        $model = ! empty( $request->purchase_reason ) ? $model->where('purchase_reason', $request->purchase_reason ) : $model;
        $model = ! empty( $request->purchase_priority ) ? $model->where('purchase_priority', $request->purchase_priority ) : $model;
        $model = ! empty( $request->financial_liquidity_type ) ? $model->where('financial_liquidity_type', $request->financial_liquidity_type ) : $model;
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
        if (!$user->isExpert()) {
            $model = $model->where('status', 1);
            $model = $model->where('create_id', $user->id);
        }

        // favorite
        $favorites = CustomerFavorite::where('user_id', $user->id)->pluck('customer_id')->toArray();
        if (!empty($request->favorite)) {
            $model = $model->whereIn('id', $favorites);
        }
        // paginate list
        if(!empty($request->order) && !empty($request->orderby)){
            $model = $model->orderBy($request->order, $request->orderby);
        }
        $model = $model->orderBy('id', 'desc');
        //dd(getQuery($model));
        $totalCount = $model->count();
        //dd($totalCount);
        $model = $model->paginate($request->showcount);

        $reports = [];

        $customerids = [];
        foreach($model as $customer)
        {
            $customerids[] = $customer->id;
            $reports[$customer->id]['sum'] = 0;
            $reports[$customer->id][0] = 0;
            $reports[$customer->id][1] = 0;
            $reports[$customer->id][2] = 0;
            $reports[$customer->id][3] = 0;
            $reports[$customer->id][3] = 0;
            $reports[$customer->id][3] = 0;
            $reports[$customer->id][3] = 0;
            $reports[$customer->id][3] = 0;
            $reports[$customer->id]['customer'] = 0;

        }
        if(is_array($customerids) && count($customerids)>0)
        {
            $query = "";
            $query = "SELECT `customer_id`,`status`,count(*) as `count` FROM `relation_estate_customer` where `deleted_at` is null ";
            $query .= " and `customer_id` in (".implode(',' , $customerids).")";
            $query .= " and priority = 1 ";

            $query .= " group by `customer_id`,`status` ";
            $lists = DB::select($query);
            foreach($lists as $list)
            {
                $reports[$list->customer_id][$list->status] = $list->count;
            }


            $sumTotal = 0;
            foreach($reports as $key=>$val)
            {
                if($reports[$key] && array_key_exists('0',$reports[$key]) &&  array_key_exists('1',$reports[$key]) && array_key_exists('2',$reports[$key]) && array_key_exists('3',$reports[$key]))
                {
                    $reports[$key]['sum'] = $reports[$key][0] + $reports[$key][1] + $reports[$key][2] + $reports[$key][3];
                    $sumTotal += $reports[$key]['sum'];
                }
            }
        }
        $districts = $user->city ? $user->city->districts->pluck('name', 'id') : [];
        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        if($user->branch_id > 0)
        {
            $users->where('branch_id', $user->branch_id);
        }
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 9);
        })->get(['id', 'name','last_name', 'username','status']);
        if ($request->ajax() && $model->count() > 0)
        {
            $report2[0] = 0;
            $report2[1] = 0;
            $report2[2] = 0;
            $report2[3] = 0;
            $report2['total'] = 0;

            $query = "SELECT relation_estate_customer.`status`,count(*) as `count` FROM `relation_estate_customer` inner join `customers` on
            `relation_estate_customer`.customer_id = `customers`.id where customers.`deleted_at` is null and customers.`status` = 1 and
            relation_estate_customer.`deleted_at` is null";
            $query .= " and relation_estate_customer.priority = 1 ";

            if(!empty($request->user_id)){
                if($request->user_id > 0)
                {
                    $query .= " and `customer_expert_id` = '".$request->user_id."'";
                }
            }
            $query .= " group by `status`";
            //dd($query);
            $lists = DB::select($query);
            foreach($lists as $list)
            {
                $report2[$list->status] = $list->count;
            }
            $report2['total'] = $report2[0] + $report2[1] + $report2[2] + $report2[3];

            $couter=$totalCount/$request->showcount;
            $counter1= round($couter);
            if($counter1>=$couter) $couter=$counter1;
            else $couter=$counter1+1;
            $hasPage = ($couter==$request->page)? false : true;
            $request_type = $request->request_type;
            $currentuserid = $user->id;
            $view = view('site7.frontend.customer.component_ex_customer_type1', compact('model','request_type','currentuserid','totalCount','reports','report2'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        // dd($model[0]->user);
        $deal_type=$request->deal_type;
        $defaultCity=$_COOKIE['city'] ?? ss('DEFAULT_CITY');
        $city = City::where('name_en', $defaultCity)->where('active', 1)->first();
        if($city == null){
            $city = City::where('name_en', ss('DEFAULT_CITY'))->where('active', 1)->first();
        }
        $cities = City::where('province_id', $city->province_id)->where('active', 1)->get();
        $dateto = gregorian_to_jalali(date('Y'),date('m'),date('d'),'/');

        $branches = null;
        if($user->isAdmin() && env('PORTAL'))
        {
            $branches = Branch::get();
        }
        $typelist = 'branch';
        return view('site7.frontend.customer.index', compact('model', 'users', 'districts', 'favorites', 'filters','deal_type','cities' , 'dateto' , 'branches','typelist'));

    }
    public function acquaintance(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = new Acquaintance;
            $model = $model->get();
            return view('site4.frontend.customer.acquaintance',compact( 'model' ) );
        }
    }
    public function acquaintancecreate(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            return view('site4.frontend.customer.acquaintancecreate');
        }
    }
    public function acquaintanceedit($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Acquaintance::where('id',$id )->first();
            return view('site4.frontend.customer.acquaintancecreate', compact('model'));
        }
    }
    public function acquaintancestore( Request $request ) {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $validator = Validator::make( $request->all(), [
                'name' => 'required|min:2|max:64',
            ] );
            if ( $validator->fails() ) {
                return back()->with( [ 'errors' => $validator->errors() ] );
            }
            $model = Acquaintance::create( [ 'name' => $request->name ] );
            return redirect('/customer/acquaintance');
        }
	}
	public function acquaintanceupdate( Request $request, $id )
    {

        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Acquaintance::find( $id );
            if ( empty( $model ) ) {
                return back()->with( [ 'errors' => 'یافت نشد!' ] );
            }
            $validator = Validator::make( $request->all(), [ 'name' => 'required' ] );
            if ( $validator->fails() ) {
                return back()->with( [ 'errors' => $validator->errors() ] );
            }
            $model->update( [ 'name' => $request->name ] );
            return redirect("/acquaintance");
        }
	}
	public function acquaintancedestroy( $id )
    {

        $user = Auth::user();
        if($user->isAdmin())
        {

            $model = Acquaintance::find( $id );
            $model->delete();
            return response()->json( [ 'status' => 'ok', 'result' => 'deleted!' ], config( 'StatusCode.SUCCESS' ) );
        }
	}
    public function rental_list(Request $request, $defaultCity = '')
    {
        $append_fields = ['favorite'];
        $model = new RentalCustomer();
        $filters = $model->getFilters($request->all(),$append_fields,false);
        foreach ($append_fields as $field){
            $v = $field == 'favorite' ? $request->$field ?? 0 : $request->$field ?? '';
            $filters[$field] = $v;
        }
        // get auth user
        $user = Auth::user();
        if(!isset($user) || !$user->isAdmin())
        {
            return view('frontend.errors.404');
        }

        // start query
        $model = RentalCustomer::with([
            'user:id,name,last_name,username'
        ]);
        $model = ! empty( $request->id ) ? $model->where( 'id', (int) $request->id ) : $model;
        $model = ! empty( $request->name ) ? $model->where( 'name', 'like', "%$request->name%" ) : $model;
        $model = ! empty( $request->description ) ? $model->where( 'description', 'like', "%$request->description%" ) : $model;
        $model = ! empty( $request->with_family) ? $model->where('with_family', $request->with_family) : $model;
        $model = ! empty( $request->estate_id) ? $model->where('estate_id', $request->estate_id) : $model;
        $model = ! empty( $request->status) ? $model->where('status', $request->status) : $model;
        $model = ! empty( $request->mobile) ? $model->where('mobile', $request->mobile) : $model;

        if (!empty($request->stay_from) && !empty($request->stay_to)) {
            $model = $model->where(function ($query) use ($request) {
                $query->where(function($query2) use ($request)
                {
                    $stay_from =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->stay_from);
                    $stay_to =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->stay_to);
                    $query2->where('stay_from', '>=' , Verta::parse($stay_from)->formatGregorian('Y-m-d'))->where('stay_from','<=', Verta::parse($stay_to)->formatGregorian('Y-m-d'));
                })
                ->orWhere(function($query2) use ($request)
                {
                    $stay_from =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->stay_from);
                    $stay_to =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->stay_to);
                    $query2->where('stay_to', '>=' , Verta::parse($stay_from)->formatGregorian('Y-m-d'))->where('stay_to','<=', Verta::parse($stay_to)->formatGregorian('Y-m-d'));
                }
            )
            ;});
        }
        elseif(!empty($request->stay_from))
        {
            $model = $model->where(function ($query) use ($request) {
                $query->where(function($query2) use ($request)
                {
                    $stay_from =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->stay_from);
                    $query2->where('stay_from', '>=' , Verta::parse($stay_from)->formatGregorian('Y-m-d'));
                })
                ->orWhere(function($query2) use ($request)
                {
                    $stay_from =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->stay_from);
                    $query2->where('stay_to', '>=' , Verta::parse($stay_from)->formatGregorian('Y-m-d'));
                }
            )
            ;});
        }
        elseif(!empty($request->stay_to)) {
            $model = $model->where(function ($query) use ($request) {
                $query->where(function($query2) use ($request)
                {
                    $stay_to =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->stay_to);
                    $query2->where('stay_from','<=', Verta::parse($stay_to)->formatGregorian('Y-m-d'));
                })
                ->orWhere(function($query2) use ($request)
                {
                    $stay_to =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $request->stay_to);
                    $query2->where('stay_to','<=', Verta::parse($stay_to)->formatGregorian('Y-m-d'));
                }
            )
            ;});
        }


        // paginate list
        if(!empty($request->order) && !empty($request->orderby)){
            $model = $model->orderBy($request->order, $request->orderby);
        }
        $model = $model->orderBy('id', 'desc');
        //dd(getQuery($model));
        $totalCount = $model->count();
        $model = $model->paginate($request->showcount);

        $reports = [];

        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 9);
        })->get(['id', 'name','last_name', 'username','status']);
        if ($request->ajax() && $model->count() > 0)
        {

            $couter=$totalCount/$request->showcount;
            $counter1= round($couter);
            if($counter1>=$couter) $couter=$counter1;
            else $couter=$counter1+1;
            $hasPage = ($couter==$request->page)? false : true;
            $request_type = $request->request_type;
            $currentuserid = $user->id;
            $view = view('site2.frontend.rental.component_ex_customer', compact('model','totalCount'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        $dateto = gregorian_to_jalali(date('Y'),date('m'),date('d'),'/');
        return view('site2.frontend.rental.rental_list', compact('model', 'users', 'filters' , 'dateto'));
    }
    public function operationsCustomer(Request $request,$customer_id)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            $customerOperations = EstateOperation::where('customer_id' , $customer_id)->orderBy('id', 'desc')->get();
            $view = view('frontend.customer.opertaion_list', compact('customerOperations'))->render();
        }
        return response(['status' => 'success', 'html' => $view], config('StatusCode.SUCCESS'));
    }
    public function customercheck(Request $request){
        $user = Auth::user();
        if(!$user->isExpert())
            return null;
        $estates=Customer::With(["user"])->Where('mobile',$request->mobile);
        if(ss('SITE_ID') == 8 || ss('SITE_ID')==5){
            if(!empty($request->mobile2)){
                $estates=$estates->orWhere('mobile',$request->mobile2);
            }
        }
        $estates= $estates->where('status',1)->get();
        $totalCount = $estates->count();
        $view = view('frontend.customer.customerCheck', compact('estates','totalCount'))->render();
        return response()->json(['html' => $view,'count'=>$estates->count()]);
    }
    public function edit(Request $request,$id=null)
    {
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $districts = $user->city ? $user->city->districts->pluck('name', 'id') : [];
        if (count($districts) == 0) {
            return back()->withErrors(['شهر فعالیت شما فاقد محله است، لطفا قبل از ثبت خریدار محله های شهرها را کامل کنید!']);
        }
        $model = Customer::with(['user', 'districts','notes'])->find($id);
        if (empty($model)) {
            return back()->withErrors(['مشتری یافت نشد!']);
        }
        if ($model->user_id != $user->id && !$user->isAdminSuper()) {
            return back()->withErrors(['شما دسترسی به این بخش را ندارید!']);
        }
        $model->district_ids = $model->districts()->pluck('district_id');
        $users = User::with('roles')->where('is_admin', '!=', 1)->where('has_role', 1)->get(['id', 'name', 'username']);
        $notes=CustomerNote::where('user_id', $user->id)->where('customer_id', $model->id)->first();
        return view('frontend.customer.edit', compact('model', 'users', 'districts','notes'));
    }
    public function rental_edit(Request $request,$id=null)
    {
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $model = RentalCustomer::find($id);
        if (empty($model)) {
            return back()->withErrors(['مشتری یافت نشد!']);
        }
        if (!$user->isAdminSuper()) {
            return back()->withErrors(['شما دسترسی به این بخش را ندارید!']);
        }

        $dateto = gregorian_to_jalali(date('Y'),date('m'),date('d'),'/');
        return view('site2.frontend.rental.rental_create', compact('model','dateto'));
    }
    public function edit_v2(Request $request,$id=null)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $model = Customer::find($id);
        if (empty($model)) {
            return back()->withErrors(['مشتری یافت نشد!']);
        }
        if ($model->user_id != $user->id && !$user->isAdminSuper()) {
            return back()->withErrors(['شما دسترسی به این بخش را ندارید!']);
        }
        //$model->district_ids = $model->districts()->pluck('district_id');
        $city = City::with(['districts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])
            ->where('id', $model->city_id)
            ->where('active', 1)
            ->first();
        if($model->city_id == null || $city == null){
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
                ->where('name_en', ss('DEFAULT_CITY'))
                ->where('active', 1)
                ->first();
        }
        if (!$city) {
            $request->session()->put('referrerUrl', $request->getRequestUri());
            return redirect('/cities');
        }
        $cities = City::where('province_id', $city->province_id)
            ->where('active', 1)
            ->get();
        $districts = $city->districts;
        //dd($districts);
        $model->district_ids = $model->districts()->pluck('district_id');
        $users = User::with('roles')->where('has_role', 1)->get();
        $notes=CustomerNote::where('user_id', $user->id)->where('customer_id', $model->id)->first();
        /*if(env('COUNTRY') == 'UAE')
        {
            $acquaintancelist = Acquaintance::get();
            return view('site4.frontend.customer.create', compact('model', 'users', 'districts','notes','city','cities','acquaintancelist'));
        }
        else*/
        {
            return view('frontend.customer.create', compact('model', 'users', 'districts','notes','city','cities'));
        }
    }
    public function create(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }

        if(ss('SITE_ID') != 7 && ss('SITE_ID') != 3   && ss('SITE_ID') != 2 && !$user->isExpert())
        {
            return view('frontend.errors.404');
        }

        $users = null;
        if($user->isAdmin() || $user->isAdminBranch())
        {
            $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
            if($user->branch_id > 0 && $user->isAdminBranch())
            {
                $users = $users->where('branch_id' , $user->branch_id);
            }
            $users = $users->whereHas('roles', function ($query) {
                $query->where( 'id', '=', 9);
            })//;
            //dd(getQuery($users));
            ->get(['id', 'name','last_name', 'username','status']);
        }

        $city = City::where('name_en' , ss('DEFAULT_CITY'))->first();
        $districts = $city->districts;
        /*if(env('COUNTRY') == 'UAE')
        {
            $acquaintancelist = Acquaintance::get();
            return view('site4.frontend.customer.create', compact('users' , 'city','districts','acquaintancelist'));
        }
        elseif(ss('SITE_ID') == 7)
        {
            return view('site7.frontend.customer.create', compact('users' , 'city','districts'));
        }
        else*/
        {
            return view('frontend.customer.create', compact('users' , 'city','districts'));
        }
    }
    public function rental_create(Request $request)
    {
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $dateto = gregorian_to_jalali(date('Y'),date('m'),date('d'),'/');
        return view('site2.frontend.rental.rental_create' , compact('dateto'));
    }
    public function detail($id)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $model = Customer::with([
            'user',
            'districts'
        ])->find($id);
        if (empty($model)) {
            return back()->withErrors(['مشتری یافت نشد!']);
        }
        if($user->isExpert() && !$user->isAdmin() && env('COUNTRY') == 'UAE')
        {
            if(!($model->user_id > 0) && $model->language_id)
            {
                if(is_array($user->languages()))
                {
                    if(!in_array($model->language_id , $user->languages()))
                    {
                        return view('frontend.errors.404');
                    }
                }
            }

            if($user->label == 0)
            {
                if(!in_array($model->label , [0]) || !in_array($model->grade , [1,2]))
                {
                    return view('frontend.errors.404');
                }
            }
            if($user->label == 1)
            {
                if(!in_array($model->label , [0,1]) || $model->grade != 1)
                {
                    return view('frontend.errors.404');
                }
            }
            if($user->label == 2)
            {
                if(!in_array($model->label , [0,1,2]))
                {
                    return view('frontend.errors.404');
                }
            }
            if($user->label == 3)
            {
                if(!in_array($model->label , [0,1,2,3]))
                {
                    return view('frontend.errors.404');
                }
            }
            if($user->label == 4)
            {
                if(!in_array($model->label , [0,1,2,3,4]))
                {
                    return view('frontend.errors.404');
                }
            }
        }
        if ($model->status == 1 && ($model->user_id == $user->id || $user->isAdmin()))
        {
            //relEstate($id);
        }
        $featureValues = FeatureValue::get();
        $relationEstates = Estate::join('relation_estate_customer', 'estates.id', '=', 'relation_estate_customer.estate_id')
            ->where('customer_id',$id)/*->where('active' , 1)*/
            ->where('estates.showdate', '>' ,  date("Y-m-d", strtotime("-1 years")))
            ->where('estates.visibility', 1)
            ->select('estates.*')
            ->orderBy('id', 'desc')
            ->paginate(10);
        //$notes=CustomerNote::where('customer_id', $id)->get();
        $estates=Customer::With(["user"])->Where('mobile',$model->mobile)->where('id','!=',$id);
        if(ss('SITE_ID') == 8 || ss('SITE_ID')==5){
            $estates=$estates->orWhere('mobile',$model->mobile2);
        }
        $countLike =$estates->where('status',1)->get();
        if(ss('THEME') == 'site6' || ss('THEME') == 'site7')
        {
            return view(ss('THEME').'.frontend.customer.detail', compact('model', 'relationEstates','featureValues','countLike'));
        }
        else
        {
            return view('frontend.customer.detail', compact('model', 'relationEstates','featureValues','countLike'));
        }
    }
    public function addNote(Request $request)
    {
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        if (!$user) {
            return response([
                'status' => 'error',
                'result' => 'authentication failed!'
            ], config('StatusCode.UNAUTHORIZED'));
        }
        $validator = Validator::make($request->all(), [
            'customerid' => 'required|exists:customers,id,deleted_at,NULL',
            'note' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.INVALID_INPUT'));
        }
        $customerNote = Customer::where('user_id', $user->id)->find($request->customerid);
        $status = 0;
        $en="";
        if ($customerNote) {
            $agent = new Agent();
            $platform = $agent->platform();
            $platform .= ' ' . $agent->version($platform);
            $browser = $agent->browser();
            $browser .= ' ' . $agent->version($browser);
            $ip = \Request::ip();
            // create or update
            $en = CustomerNote::create([
                'user_id' => $user->id,
                'customer_id' => $request->customerid,
                'note' => $request->note,
                'ip' => $ip,
                'agent' => $browser,
                'device' => $platform
            ]);
            }
        if (empty($en)) {
            return response([
                'status' => 'false',
                'result' => 'error!'
            ], config('StatusCode.INVALID_INPUT'));
        }
        return response([
            'status' => 'true',
            'result' => 'note added successfully'
        ], config('StatusCode.SUCCESS'));
    }
    public function myNotes(Request $request)
    {
        // auth user
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $dt = Carbon::now();
        // retrieve customer
        $customers = Customer::whereHas('notes', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with([
            'images',
            'district',
            'notes',
        ])->where('status', 1)
            //->where('expired_at', '>=', $dt)
            ->orderBy('published_at', 'desc')
            ->get();
        // get user notes
        $noteList = CustomerNote::where('user_id', $user->id)->whereIn('customer_id', $customers->pluck('id')->toArray() ?? [])->get();
        // iterate on collection
        $customers->map(function ($item) use ($noteList) {
            $note = $noteList->where('customer_id', $item->id)->first();
            $item->note = $note ?? null;
            $firstImage = $item->images->first();
            $item->url = '/customer/' . $item->id ;
        });
        $templatePage = getTemplatePageWithAds(11);
        return view('frontend.profile.my_note_customer', compact('customers', 'templatePage'));
    }
    public function deleteNote(Request $request)
    {
        // auth user
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $model = Customer::find($request->customerid);
        if($model)
        {
            $status = 0;
            if ($model->user_id == $user->id || $user->isAdminSuper()) {
                //$model->update(['status' => 4]);
                $model->delete();
                $status = 1;
                return response([
                    'status' => 'ok',
                    'result' => $status
                ], config('StatusCode.SUCCESS'));
            }
            else
            {
                return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
            }
        }
        else
        {
            return response(['status' => 'error'], config('StatusCode.UNAUTHORIZED'));
        }
    }
    public function deleteRentalCustomer(Request $request)
    {
        // auth user
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $model = RentalCustomer::find($request->customerid);
        if($model)
        {
            $status = 0;
            if ($model->user_id == $user->id || $user->isAdmin()) {
                $model->delete();
                $status = 1;
                return response([
                    'status' => 'ok',
                    'result' => $status
                ], config('StatusCode.SUCCESS'));
            }
            else
            {
                return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
            }
        }
        else
        {
            return response(['status' => 'error'], config('StatusCode.UNAUTHORIZED'));
        }
    }
    public function removeAgent(Request $request)
    {
        // auth user
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $model = Customer::find($request->customerid);
        if($model)
        {
            $status = 0;
            if ($model->user_id == $user->id || $user->isAdmin()) {
                $model->update(['user_id' => null , 'grade' => 3]);
                $operation_id = EstateOperation::create([
                    'expert_id' => $user->id,
                    'comment' => $request->comment,
                    'customer_id'=> $request->customerid,
                    'type'=> 14
                ]);
                return response([
                    'status' => 'ok',
                    'result' => $status
                ], config('StatusCode.SUCCESS'));
            }
            else
            {
                return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
            }
        }
        else
        {
            return response(['status' => 'error'], config('StatusCode.UNAUTHORIZED'));
        }
    }
    public function changeGrade(Request $request)
    {
        $customer = Customer::where('grade' , 1)->where('created_at' , '<=' , date("Y-m-d", strtotime("-24 hours")))->where('created_at' , '>' , date("Y-m-d", strtotime("-200 hours")))->update(['grade' => 2]);
    }
    public function assignToMe(Request $request)
    {
        // auth user
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $model = Customer::find($request->customerid);
        if($model)
        {
            $status = 0;
            if ($model->user_id == null && $user->isExpert()) {
                if(!$user->isAdmin())
                {
                    if($user->label == 3)
                    {
                        $backOperation = EstateOperation::where('type' , 15)->where('expert_id' , $user->id)->where('created_at' , '>' , date("Y-m-d", strtotime("-12 hours")))->get();
                        if(count($backOperation)>0)
                        {
                            return response(['status' => 'error', 'result' => 'error12'], config('StatusCode.INVALID_INPUT'));
                        }
                    }
                    if($user->label == 2 || $user->label == 1 || $user->label == 0)
                    {
                        $backOperation = EstateOperation::where('type' , 15)->where('expert_id' , $user->id)->where('created_at' , '>' , date("Y-m-d", strtotime("-24 hours")))->get();
                        if(count($backOperation)>0)
                        {
                            return response(['status' => 'error', 'result' => 'error24'], config('StatusCode.INVALID_INPUT'));
                        }
                    }
                }
                $model->update(['user_id' => $user->id , 'grade' => null]);
                EstateOperation::create([
                    'expert_id' => $user->id,
                    'comment' => '',
                    'customer_id'=> $request->customerid,
                    'type'=> 15
                ]);
                return response([
                    'status' => 'ok',
                    'result' => $status
                ], config('StatusCode.SUCCESS'));
            }
            else
            {
                return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
            }
        }
        else
        {
            return response(['status' => 'error'], config('StatusCode.UNAUTHORIZED'));
        }
    }

    public function ladder(Request $request)
    {
        // auth user
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $model = Customer::find($request->customerid);

        if($model)
        {
            $status = 0;
            if ($model->user_id == $user->id || $user->isAdminSuper())
            {

                $model->update(['job' => date('Y-m-d H:i:s')]);
                $status = 1;
                return response([
                    'status' => 'ok',
                    'result' => $status
                ], config('StatusCode.SUCCESS'));
            }
            else
            {
                return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
            }
        }
        else
        {
            return response(['status' => 'error'], config('StatusCode.UNAUTHORIZED'));
        }
    }
    public function undelete(Request $request)
    {
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        $model = Customer::find($request->customerid);
        if($model)
        {
            $status = 0;
            if ($model->user_id == $user->id || $user->isAdmin()) {
                $model->update(['status' => 1]);
                $status = 1;
                return response([
                    'status' => 'ok',
                    'result' => $status
                ], config('StatusCode.SUCCESS'));
            }
            else
            {
                return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
            }
        }
        else
        {
            return response(['status' => 'error'], config('StatusCode.UNAUTHORIZED'));
        }
    }
}
?>
