<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Requests\User\VerifyMobileRequest;
use App\Http\Requests\User\VerifyCodeRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\Estate;
use App\Models\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Branch;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\UserOperation;
use App\Models\UserTime;
use App\Models\Customer;
use App\Models\Province;
use App\Models\City;
use App\Models\UserActivityDistrict;
use App\Models\District;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Arr;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    protected $model, $route, $viewPath;
    protected $adminRoleIds = [1,2,3,4];// admins role ids

    public function index( Request $request )
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if(!isset($user) || !($user->isAdmin() || $user->isAdminBranch()) )
        {
            return view('frontend.errors.404');
        }
        $branches = [];
        if(!$request->ajax())
        {
            $branches = Branch::where('active',1)->where('status',1)->get();
        }
        // start query
        $model = User::with(['city','roles']);
        $model = ! empty( $request->id ) ? $model->where( 'id', (int) $request->id ) : $model;
        $model = ! empty( $request->name ) ? $model->where( 'name',  'like' , '%'.$request->name.'%' ) : $model;
        $model = ! empty( $request->last_name ) ? $model->where( 'last_name',  'like' , '%'.$request->last_name.'%' ) : $model;
        $model = ! empty( $request->username ) ? $model->where( 'username', $request->username) : $model;
        $model = ! empty( $request->status) ? $model->where( 'status',$request->status) : $model;
        $model = ! empty( $request->branch_id) ? $model->where( 'status',$request->branch_id) : $model;
        if(! empty( $request->role_id))
        {
            if($request->role_id > 0)
            {
                $model = $model->where( 'role_ids',  'like' , '%'.$request->role_id.'%')->where( 'has_role', 1);
            }
            else
            {
                $model = $model->where( 'has_role', 0);
            }
        }
        if($user->isAdminBranch() && !$user->isAdmin())
        {
            $model = $model->where( 'branch_id', $user->branch_id);
        }
        // paginate list
        if(!empty($request->order) && !empty($request->orderby)){
            $model = $model->orderBy($request->order, $request->orderby);
        }
        else
        {
            $model = $model->orderBy('id', 'desc');
        }
        //dd(getQuery($model));
        $totalCount = $model->count();
        $model = $model->paginate($request->showcount);
        if ($request->ajax() && $model->count() > 0) {
            $couter=$totalCount/$request->showcount;
            $counter1= round($couter);
            if($counter1>=$couter)
                $couter=$counter1;
            else
                $couter=$counter1+1;
            $hasPage = ($couter==$request->page)? false : true;
            $request_type = $request->request_type;
            $currentuserid = $user->id;
            if(ss('SITE_ID') == 7)
            {
                $view = view('site7.frontend.auth.component_ex_user_type', compact('model','totalCount'))->render();
            }
            else
            {
                $view = view('frontend.auth.component_ex_user_type', compact('model','totalCount'))->render();
            }
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        if(ss('SITE_ID') == 7)
        {

            return view( 'site7.frontend.auth.list', compact( 'model' ) );
        }
        else
        {
            return view( 'frontend.auth.list', compact( 'model' , 'branches' ) );
        }
	}
    public function rental_list( Request $request )
    {

        $user = Auth::user();
        if(!isset($user) || !$user->isAdmin())
        {
            return view('frontend.errors.404');
        }

        // start query
        $model = User::with(['city','roles']);
        $model = ! empty( $request->id ) ? $model->where( 'id', (int) $request->id ) : $model;
        $model = ! empty( $request->name ) ? $model->where( 'name',  'like' , '%'.$request->name.'%' ) : $model;
        $model = ! empty( $request->last_name ) ? $model->where( 'last_name',  'like' , '%'.$request->last_name.'%' ) : $model;
        $model = ! empty( $request->username ) ? $model->where( 'username', $request->username) : $model;
        $model = ! empty( $request->status) ? $model->where( 'status',$request->status) : $model;
        $model = $model->where( 'role_ids',  'like' , '%10%')->where( 'has_role', 1);
        $model = $model->orderBy('id', 'desc');
        $totalCount = $model->count();
        $model = $model->paginate($request->showcount);
        if ($request->ajax() && $model->count() > 0) {
            $couter=$totalCount/$request->showcount;
            $counter1= round($couter);
            if($counter1>=$couter)
                $couter=$counter1;
            else
                $couter=$counter1+1;
            $hasPage = ($couter==$request->page)? false : true;
            $request_type = $request->request_type;
            $currentuserid = $user->id;
            $view = view('site2.frontend.rental.component_ex_user_type', compact('model','totalCount'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        return view( 'site2.frontend.rental.user_list', compact( 'model' ) );
	}
    public function status( $user_id, $user_status ) {
        $user = Auth::user();
        if(!isset($user) || !$user->isAdmin())
        {
            return view('frontend.errors.404');
        }
		$validator = Validator::make( [ 'id' => $user_id, 'status' => $user_status ], [
			'id'     => 'required|exists:users,id',
			'status' => 'required|between:-1,4'
		] );
		if ( $validator->fails() ) {
			return response( [
				'status' => 'error',
				'result' => $validator->errors()
			], config( 'StatusCode.INVALID_INPUT' ) );
		}
		$model = User::find( $user_id );
        $model->update( [ 'status' => $user_status ] );
		return response( [
			'status' => 'ok',
			'result' => 'تغییر وضعیت با موفقیت انجام شد.'
		], config( 'StatusCode.SUCCESS' ) );
	}

    public function destroy( $id ) {
        $user = Auth::user();
        if(!isset($user) || !$user->isAdmin())
        {
            return view('frontend.errors.404');
        }
		$ids = explode( ',', $id );
		$ids = count( $ids ) > 1 ? $ids : implode( '', $ids );
		if ( is_array( $ids ) ) {
			$model = User::with('estates','customers')->whereIn( 'id', $ids )->get();
			foreach ( $model as $item ) {
				Customer::where( 'user_id', $item->id )->update( [ 'user_id' => (!empty($parent) ? end($parent) : null), 'label' => null , 'status' => -1] );
				$item->tickets()->delete();
                User::where('id', $item->id )->update(['username'=>$item->id]);
				$item->delete();
			}
			return response()->json( [ 'status' => 'ok', 'result' => 'deleted!' ], config( 'StatusCode.SUCCESS' ) );
		}
		$validator = Validator::make( [ 'id' => $ids ], [
			'id' => 'required|numeric|exists:users,id'
		] );
		if ( $validator->fails() ) {
			return response()->json( [
				'status' => 'error',
				'result' => $validator->errors()
			], config( 'StatusCode.INVALID_INPUT' ) );
		}
		$model = User::find( $ids );
        $modl1=Estate::where('expert_id', $ids)->get();
        if($modl1->count()>0){
		    Estate::where( 'expert_id', $ids)->update( [  'expert_id'=>null] );
        }
        $model->forceDelete();
		return response()->json( [ 'status' => 'ok', 'result' => 'deleted!' ], config( 'StatusCode.SUCCESS' ) );
	}
    public function rental_destroy( $id ) {
        $user = Auth::user();
        if(!isset($user) || !$user->isAdmin())
        {
            return view('frontend.errors.404');
        }
		$ids = explode( ',', $id );
		$ids = count( $ids ) > 1 ? $ids : implode( '', $ids );
		if ( is_array( $ids ) ) {
			$model = User::with('estates','customers')->whereIn( 'id', $ids )->get();
			foreach ( $model as $item ) {
				Customer::where( 'user_id', $item->id )->update( [ 'user_id' => (!empty($parent) ? end($parent) : null), 'label' => null , 'status' => -1] );
				$item->tickets()->delete();
                User::where('id', $item->id )->update(['username'=>$item->id]);
				$item->delete();
			}
			return response()->json( [ 'status' => 'ok', 'result' => 'deleted!' ], config( 'StatusCode.SUCCESS' ) );
		}
		$validator = Validator::make( [ 'id' => $ids ], [
			'id' => 'required|numeric|exists:users,id'
		] );
		if ( $validator->fails() ) {
			return response()->json( [
				'status' => 'error',
				'result' => $validator->errors()
			], config( 'StatusCode.INVALID_INPUT' ) );
		}
		$model = User::find( $ids );
        $modl1=Estate::where('expert_id', $ids)->get();
        if($modl1->count()>0){
		    Estate::where( 'expert_id', $ids)->update( [  'expert_id'=>null] );
        }
        $model->delete();
		return response()->json( [ 'status' => 'ok', 'result' => 'deleted!' ], config( 'StatusCode.SUCCESS' ) );
	}
    public function userPanel(Request $request,$id)
    {
        $superAdmin = Auth::user();
        if(!isset($superAdmin) || !$superAdmin->isAdmin())
        {
            return view('frontend.errors.404');
        }

        $model = User::find( $id );
        if ( empty( $model ) ) {
            return back()->withErrors([ 'یافت نشد!' ] );
        }
        //Auth::logout();
        Auth::loginUsingId( $id );
        session( [ 'adminID' => $superAdmin->id ] );
        return redirect('/');
	}
    public function create()
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $superAdmin = Auth::user();
        if(!isset($superAdmin))
        {
            return view('frontend.errors.404');
        }
        if(ss('SITE_ID') != 7)
        {
            if(!$superAdmin->isAdmin())
            {
                return view('frontend.errors.404');
            }
        }
        else
        {
            if(!$superAdmin->isAdmin() && !$superAdmin->isAdminBranch())
            {
                return redirect( '/profile/users/edit/'.$superAdmin->id );
            }
        }
        // if(!isset($superAdmin) || !$superAdmin->isAdmin())
        // {
        //     return view('frontend.errors.404');
        // }
        $provinces = Province::get();
        $cities = City::get();
        $districts = [];
        if(old('city_id')){
            $districts = District::where('city_id',old('city_id'))->get();
        }
        $user = Auth::user();
        // get users
        $users = User::whereHas('roles')->where('is_admin',0)->where('has_role',1);
        // get expert couch
        $users = $users->whereJsonContains('role_ids', [8])->get();
        $users->map(function ($item){
            $item->role = $item->roles()->first() ?? null;
        });
        // get roles
        $roles = !empty($filteredRoleIds) ? Role::whereIn( 'id', $filteredRoleIds )->get() : Role::/*where( 'name', '!=', 'admin_super' )->*/get();
        $headers = [];
        $branches = [];
        if(ss('SITE_ID') == 3){
            $headers = User::where('header',-1)->get();
            $branches = Branch::where('active',1)->where('status',1)->get();
        }
		return view((ss('SITE_ID') == 7?'site7.':'' ).'frontend.auth.create', compact( 'roles','provinces','cities','districts', 'users', 'headers','branches') );
	}
    public function rental_create()
    {
        $superAdmin = Auth::user();
        if(!isset($superAdmin) || !$superAdmin->isAdmin())
        {
            return view('frontend.errors.404');
        }
		return view('site2.frontend.rental.user_create' );
	}
	public function store( Request $request )
    {
        $superAdmin = Auth::user();
        if(!isset($superAdmin))
        {
            return view('frontend.errors.404');
        }
        if(!$superAdmin->isAdmin() && !$superAdmin->isAdminBranch())
        {
            return view('frontend.errors.404');
        }

        // if(!isset($superAdmin) || !$superAdmin->isAdmin())
        // {
        //     return view('frontend.errors.404');
        // }
	    // validate inputs
        $validator = Validator::make( $request->all(), [
			'photo'    => 'nullable|max:2048',
			'name'     => 'required',
            'last_name'     => 'required',
			'username' => 'bail|required|unique:users,username',
			'password' => 'required|min:6|max:64',
			'role'     => 'required',
		] );
        // return validation errors
		if ( $validator->fails() ) {
			return back()->withInput()->with( [ 'errors' => $validator->errors() ] );
		}
		// generate user code
        $userCode = makeUserCode($request->city_id);
		// upload profile photo
		$photo = uploader( $request, 'photo','images/profile' );
        $selectedRole = Role::whereIn('name',$request->role)->pluck('id')->toArray();
        $roleIds = $selectedRole ? json_encode($selectedRole) : null;
        // getting all inputs
		$inputs = $request->all();
        $inputs['code'] = $userCode;
        $inputs['alias'] = TokenMaker(8);
        $inputs['photo'] = $photo;// empty( $photo ) ? $photo : $model->photo,
        $inputs['password'] = bcrypt( $request->password );
        $inputs['has_role'] = 1;
        if($request->role){
            $selectedRole = Role::whereIn('name',$request->role)->pluck('id')->toArray();
            $roleIds = $selectedRole ? json_encode($selectedRole) : null;
            $inputs['role_ids'] = $roleIds;
        }
        unset($inputs['districts']);
        $inputs['activity_estate_type'] = !empty($request->activity_estate_type) ? json_encode($request->activity_estate_type) : '[]';
        unset($inputs['role']);

		$model = User::create(checkInputs($inputs));
		if($model){
            if (env('COUNTRY') == 'UAE')
            {

                if(!empty($request->get('languages'))){
                    $langIds = $request->get('languages');
                    $model->languages()->sync( $langIds );
                }
            }
            $district_ids = $request->districts;
            if ( empty( $district_ids ) ) {
                UserActivityDistrict::where('user_id',$model->id)->delete();
            } else {
                // get count
                $selectedList = array_count_values($district_ids);
                $districts=[];
                foreach ( $selectedList as $districtId => $selectedCount ) {
                    $percentValue = ($selectedCount * 100) / count($district_ids);
                    $districts[] = [ 'user_id' => $model->id, 'district_id' => $districtId, 'selection_count'=> $selectedCount, 'ratio'=> $percentValue];
                }
                UserActivityDistrict::where('user_id',$model->id)->delete();
                UserActivityDistrict::insert( $districts );
            }
            // assign role
            if(is_array($request->role)){
                foreach ($request->role as $role){
                    $model->assignRole( $role );
                }
            }
            // add user docs
		}
        session()->flash('اطلاعات عضو جدید با موفقیت ثبت شد.','success');
		return redirect( '/profile/users' )->with( 'success', 'created successfully' );
	}
    public function rental_store( Request $request )
    {
        $superAdmin = Auth::user();
        if(!isset($superAdmin) || !$superAdmin->isAdmin())
        {
            return view('frontend.errors.404');
        }
	    // validate inputs
        $validator = Validator::make( $request->all(), [
			'photo'    => 'nullable|max:2048',
			'name'     => 'required',
            'last_name'     => 'required',
			'username' => 'bail|required|unique:users,username',
			'password' => 'required|min:6|max:64',
		] );
        // return validation errors
		if ( $validator->fails() ) {
			return back()->withInput()->with( [ 'errors' => $validator->errors() ] );
		}

		// upload profile photo
		$photo = uploader( $request, 'photo','images/profile' );
        if ( ! empty( $inputs['photoCover'] ) ) {
            $photoCover= uploader( $request, 'photoCover','images/profile' );
            $inputs['profile_cover'] = $photoCover;
        }
        // getting all inputs
		$inputs = $request->all();
        $inputs['alias'] = TokenMaker(8);
        $inputs['photo'] = $photo;// empty( $photo ) ? $photo : $model->photo,
        $inputs['password'] = bcrypt( $request->password );
        $inputs['has_role'] = 1;
        $inputs['role_ids'] = '[10]';
		$model = User::create(checkInputs($inputs));
		$model->assignRole( 10 );
        session()->flash('اطلاعات عضو جدید با موفقیت ثبت شد.','success');
		return redirect( '/rental/users' )->with( 'success', 'created successfully' );
	}

	public function edit( $id ) {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        // if(!isset($user) || !$user->isAdmin())
        // {
        //     return view('frontend.errors.404');
        // }
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        if(ss('SITE_ID') != 7)
        {
            if(!$user->isAdmin())
            {
                return view('frontend.errors.404');
            }
        }

		$model = User::with( [
		    'roles',
            'province',
            'city',
            'province.cities',
            'districts'=>function($q){
		        $q->orderByDesc('selection_count');
            }
        ] )->find($id);
		if ( empty( $model ) ) {
		    $errorMsg = $user->isAdmin() || $user->hasRole('admin_super|admin_site') ? 'یافت نشد!' : 'درخواست شما پذیرفته نیست!';
            return back()->withErrors( [ $errorMsg ] );
		}
        if (!($user->isAdmin() || $user->id == $model->id || ($user->isAdminBranch() && $model->branch_id == $user->branch_id))){
            // ثبت لاگ برای درخواست های غیرمجاز جهت ویرایش پروفایل
            return back()->withErrors( [ 'درخواست شما پذیرفته نیست!' ] );//view('errors.500');
        }
        $selectedDistricts = [];
        $model->district_ids = $model->districts()->pluck('district_id');
        $model->selectedDistricts = $model->districts()->orderByDesc('selection_count')->pluck('selection_count','district_id')->toArray();
        if(!empty($model->selectedDistricts)){
            $selectedDistricts = array_map(function ($val){
                return (int) $val;
            },$model->selectedDistricts);
        }
		$model_role  = $model->roles()->first();
		$model->role = ! empty( $model_role ) ? $model_role->name : null;
		$model->role_id = ! empty( $model_role ) ? $model_role->id : 0;
        $model->selected_roles = $model->getRoleNames()->toArray(); //$model->roles()->pluck('id')->toArray();

        $provinces = Province::get();
        $cities = City::where('province_id',$model->province_id)->get();

        $districts = District::where('city_id',$model->city_id)->get();
        // get users
        $users = User::whereHas('roles')->where('id','!=',$model->id)->where('is_admin',0)->where('has_role',1);
        // get expert couch
        $users = $users->whereJsonContains('role_ids', [8])->get();
        $users->map(function ($item){
            $item->role = $item->roles()->first() ?? null;
        });
        // get roles
        $roles = !empty($filteredRoleIds) ? Role::whereIn( 'id', $filteredRoleIds )->get() : Role::get();
        $headers = [];
        $branches = [];
        if(ss('SITE_ID') == 3){
            $headers = User::where('header',-1)->get();
            $branches = Branch::where('active',1)->where('status',1)->get();
            //dd($headers);
        }
        $language_ids = [];
        if (env('COUNTRY') == 'UAE')
        {
            $model->language_ids = $model->languages()->pluck('language_id');
            foreach($model->language_ids as $_){
                $language_ids[] = $_;
            }
        }
        //dd($model);
		return view((ss('SITE_ID') == 7?'site7.':'' ).'frontend.auth.create', compact(
		    'model',
            'roles',
            'provinces',
            'cities',
            'districts',
            'users',
            'user',
            'selectedDistricts',
            'headers',
            'branches',
            'language_ids'
        ) );
	}
    public function rental_edit( $id )
    {
        $user = Auth::user();
        if(!isset($user) || !$user->isAdmin())
        {
            return view('frontend.errors.404');
        }
		$model = User::with( [
		    'roles'
        ] )->find($id);
		if ( empty( $model ) ) {
		    $errorMsg = $user->isAdmin() || $user->hasRole('admin_super|admin_site') ? 'یافت نشد!' : 'درخواست شما پذیرفته نیست!';
            return back()->withErrors( [ $errorMsg ] );
		}
        if ( $user->id != $model->id && (!$user->isAdmin() || !$user->hasRole('admin_super|admin_site'))){
            // ثبت لاگ برای درخواست های غیرمجاز جهت ویرایش پروفایل
            return back()->withErrors( [ 'درخواست شما پذیرفته نیست!' ] );//view('errors.500');
        }

		$model_role  = $model->roles()->first();
		$model->role = ! empty( $model_role ) ? $model_role->name : null;
		$model->role_id = ! empty( $model_role ) ? $model_role->id : 0;
        $model->selected_roles = $model->getRoleNames()->toArray(); //$model->roles()->pluck('id')->toArray();


        $users = User::whereHas('roles')->where('id','!=',$model->id)->where('is_admin',0)->where('has_role',1);
        // get expert couch
        $users = $users->whereJsonContains('role_ids', [10])->get();
        $users->map(function ($item){
            $item->role = $item->roles()->first() ?? null;
        });

		return view('site2.frontend.rental.user_create', compact(
		    'model',
            'users',
            'user'
        ) );
	}
	public function update( Request $request, $id ) {
	    // auth user
        $authUser = Auth::user();
        if(!isset($authUser))
        {
            return view('frontend.errors.404');
        }
        if(ss('SITE_ID') != 7)
        {
            if(!$authUser->isAdmin())
            {
                return view('frontend.errors.404');
            }
        }
        // if(!isset($authUser) || !$authUser->isAdmin())
        // {
        //     return view('frontend.errors.404');
        // }
        // find user model
		$model = User::find( $id );
		if ( empty( $model ) ) {
			return back()->with( [ 'errors' => 'یافت نشد!' ] );
		}
        // validate inputs
        if(ss('SITE_ID') == 7)
        {
            $validator = Validator::make( $request->all(), [
                'photo'    => 'nullable|max:2048',
                'gender'   => 'nullable|in:male,female',
                'name'     => 'nullable',
                'role'     => 'required',
            ] );
        }
        else
        {
            $validator = Validator::make( $request->all(), [
                'photo'    => 'nullable|max:2048',
                'gender'   => 'nullable|in:male,female',
                'name'     => 'nullable',
                'username' => 'required|unique:users,username,' . $id,
                'role'     => 'required',
            ] );
        }
        // return validation errors
        if ( $validator->fails() ) {
            return back()->withInput()->with( [ 'errors' => $validator->errors() ] );
        }
        // get all inputs
		$inputs = $request->all();
		// make|update user code
        if($authUser->isAdmin() && $model->city_id != $request->city_id){
            $inputs['code'] = makeUserCode($request->city_id);
        }else{
            $inputs = Arr::except( $inputs, array( 'code' ) );
        }
		// password
		if ( ! empty( $inputs['password'] ) ) {
			$inputs['password'] = Hash::make( $inputs['password'] );
		} else {
			$inputs = Arr::except( $inputs, array( 'password' ) );
		}
        // profile photo
        if ( ! empty( $inputs['photo'] ) ) {
            $photo= uploader( $request, 'photo','images/profile' );
            $inputs['photo'] = $photo;
        } else {
            //$inputs['photo'] = null;
        }

        if($request->photoshow == 1)
        {
            $inputs['photo'] = null;
            $inputs['photoStatus']=0;
        }

        // get user role
        if((ss('SITE_ID') == 7 || $authUser->isAdmin()) && $request->role){
            $selectedRole = Role::whereIn('name',$request->role)->pluck('id')->toArray();
            $roleIds = $selectedRole ? json_encode($selectedRole) : null;
            $inputs['role_ids'] = $roleIds;
            $inputs['has_role'] = 1;
        }
        // convert experience year to date
        $experienceDate = null;
        if(!empty($request->experience) && (int)$request->experience > 0){
            $experienceDate = Carbon::now()->subYears((int)$request->experience);//->toDateTime();
        }
        $inputs['activity_estate_type'] = !empty($request->activity_estate_type) ? json_encode($request->activity_estate_type) : $model->activity_estate_type;
        $inputs['experience_date'] = $experienceDate;
        if($model->alias!=$request->alias&&$model->alias_status==0){
            $inputs['alias_status'] = 1;
        }
        //$inputs['alias']=$model->alias!=$request->alias&&$model->alias_status==0?$request->alias:$model->alias;
        // if the user status was suspended or awaiting confirmation
        //if($model->status != '-1' && !$authUser->isAdmin()){
            $inputs['gender']= $request->gender;
            $inputs['name']= $request->name;
            $inputs['last_name']= $request->last_name;
        //}

        // update user model
        $model->update( $inputs );
        // check updated
        if($model)
        {
            if (env('COUNTRY') == 'UAE')
            {

                if(!empty($request->get('languages'))){
                    $langIds = $request->get('languages');

                    $model->languages()->sync( $langIds );
                }
            }
            $district_ids = $request->districts;
            if ( empty( $district_ids ) ) {
                UserActivityDistrict::where('user_id',$model->id)->delete();
            } else {
                // get count
                $selectedList = array_count_values($district_ids);
                $districts=[];
                foreach ( $selectedList as $districtId => $selectedCount ) {
                    $percentValue = ($selectedCount * 100) / count($district_ids);
                    $districts[] = [ 'user_id' => $model->id, 'district_id' => $districtId, 'selection_count'=> $selectedCount, 'ratio'=> $percentValue];
                }
                UserActivityDistrict::where('user_id',$model->id)->delete();
                UserActivityDistrict::insert( $districts );
            }
            if(ss('SITE_ID') == 7 || $authUser->isAdmin()){
                // assign | update role
                DB::table( 'model_has_roles' )->where( 'model_id', $id )->delete();
                if(is_array($request->role)){
                    foreach ($request->role as $role){
                        $model->assignRole( $role );
                    }
                }
                // update user commissions (sync roles with commission roles)
                if($model->roles){
                    // remove additional roles
                    $roleIds = $model->roles->pluck('id');
                }
                // assign commission
                //$this->assignRoleCommission($request,$model);
            }
                // update activity districts
            $district_ids = $request->districts;
            if ( empty( $district_ids ) ) {
                UserActivityDistrict::where('user_id',$model->id)->delete();
            } else {
                // get count
                $selectedList = array_count_values($district_ids);
                $districts=[];
                foreach ( $selectedList as $districtId => $selectedCount ) {
                    $percentValue = ($selectedCount * 100) / count($district_ids);
                    $districts[] = [ 'user_id' => $model->id, 'district_id' => $districtId, 'selection_count'=> $selectedCount, 'ratio'=> $percentValue];
                }
                UserActivityDistrict::where('user_id',$model->id)->delete();
                UserActivityDistrict::insert( $districts );
            }
        }
        // display message
        session()->flash('بروزرسانی با موفقیت انجام شد.','success');
        // get redirect url
        $redirectPath = Auth::user()->isAdminSuper() ? redirect('/profile/users') : back();
        return $redirectPath->with( 'success', 'User updated successfully' );
	}
    public function rental_update( Request $request, $id ) {
	    // auth user
        $authUser = Auth::user();
        if(!isset($authUser) || !$authUser->isAdmin())
        {
            return view('frontend.errors.404');
        }
        // find user model
		$model = User::find( $id );
		if ( empty( $model ) ) {
			return back()->with( [ 'errors' => 'یافت نشد!' ] );
		}
        // validate inputs
        $validator = Validator::make( $request->all(), [
			'photo'    => 'nullable|max:2048',
			'gender'   => 'nullable|in:male,female',
			'name'     => 'nullable',
			'username' => 'required|unique:users,username,' . $id
        ] );

        // return validation errors
        if ( $validator->fails() ) {
            return back()->withInput()->with( [ 'errors' => $validator->errors() ] );
        }
        // get all inputs
		$inputs = $request->all();

		// password
		if ( ! empty( $inputs['password'] ) ) {
			$inputs['password'] = Hash::make( $inputs['password'] );
		} else {
			$inputs = Arr::except( $inputs, array( 'password' ) );
		}
        // profile photo
        if ( ! empty( $inputs['photo'] ) ) {
            $photo= uploader( $request, 'photo','images/profile' );
            $inputs['photo'] = $photo;
        } else {
            //$inputs['photo'] = null;
        }
        if ( ! empty( $inputs['profile_cover'] ) ) {
            $photoCover= uploader( $request, 'profile_cover','images/profile' );
            $inputs['profile_cover'] = $photoCover;
        }
        if($request->photoshow == 1)
        {
            $inputs['photo'] = null;
            $inputs['photoStatus']=0;
        }
        if($request->photocover == 1)
        {
            $inputs['profile_cover'] = null;

        }

        // get user role
        if($authUser->isAdmin() && $request->role){
            $selectedRole = Role::whereIn('name',$request->role)->pluck('id')->toArray();
            $roleIds = $selectedRole ? json_encode($selectedRole) : null;
            $inputs['role_ids'] = $roleIds;
        }

        if($model->status != '-1' && !$authUser->isAdmin()){
            $inputs['gender']= $model->gender;
            $inputs['name']= $model->name;
            $inputs['last_name']= $model->last_name;
        }

        // update user model
        $model->update( $inputs );
        // check updated
        if($model){
            if($authUser->isAdmin()){
                // assign | update role
                // DB::table( 'model_has_roles' )->where( 'model_id', $id )->delete();
                // if(is_array($request->role)){
                //     foreach ($request->role as $role){
                //         $model->assignRole( $role );
                //     }
                // }
                // update user commissions (sync roles with commission roles)
                if($model->roles){
                    // remove additional roles
                    $roleIds = $model->roles->pluck('id');
                }

            }

        }
        // display message
        session()->flash('بروزرسانی با موفقیت انجام شد.','success');
        // get redirect url
        $redirectPath = Auth::user()->isAdminSuper() ? redirect('/rental/users') : back();
        return $redirectPath->with( 'success', 'User updated successfully' );
	}
    public function verifyMobile(VerifyMobileRequest $request)
    {
        $forgetStatus = $request->forget_pass ?? 0; // forget status
        $loginType = $request->login_type ?? 1; // [1 => password , 2 => verification code]
        $registerStatus = $hasPassword = 0;
        $mobile = en_num($request->mobile);
        $code = mt_rand(10000, 99999);
        // find user
        $finalUser = User::where('username', $mobile)->first();

        if($finalUser == null){
            //dd($finalUser);
            if(ss('SITE_ID') == 6)
            {
                return success_false('این کاربر در سیستم تعریف نشده است');
            }
            else
            {
                $registerStatus = 1;
                // create user
                User::where('username', $mobile)->forceDelete();
                $finalUser = $newUser = User::create(checkInputs([
                    'username' => $mobile,
                    'phone' => $mobile,
                    'has_role' => 0,
                    'active' => 0,
                    'status' => 1,
                ]));
            }
        }
        // check user has password
        $hasPassword = !empty($finalUser->password) || $finalUser->has_password == 1 ? 1 : 0;
        // login type is password
        if($registerStatus == 0 && $forgetStatus == 0 && $hasPassword == 1 && $loginType == 1){
            return success_true([
                'login_type' => $loginType,
                'register'=>$registerStatus,
                'forget_status'=>$forgetStatus,
                'has_password'=>$hasPassword,
//                'verify_code'=>''
            ], 'ورود با رمز عبور');
        }
        $loginType = 2; // login type is code
        // check login requests count
        $loginRequestCount = UserLogin::where('user_id', $finalUser->id)->where('used', 0)->where('created_at', '>', Carbon::now()->subMinutes(5))->count();
        if ($loginRequestCount > 4) {
            return success_false('تعداد درخواست شما بیش از حد مجاز بوده است، لطفا دقایقی دیگر مجددا تلاش کنید');
        }
        // create a login request
        UserLogin::create(['user_id' => $finalUser->id, 'code' => $code, 'ip' => $request->ip(), 'used' => 0]);
        // forget password
        if($forgetStatus == 1){
            $request->session()->put( 'resetPassword', true );
        }
        // send verify code
        //$res = sendSms($mobile,$code,null,null,'verify');
        $res = sendSms($mobile,smsText('verify',$code));
        return success_true([
            'login_type' => $loginType,
            'register'=>$registerStatus,
            'forget_status'=>$forgetStatus,
            'has_password'=>$hasPassword,
            //'verify_code'=>$code
        ], 'کد ورود ارسال شد');
    }
    public function verifyCode(VerifyCodeRequest $request)
    {
        $loginType = $request->login_type ?? 1; // [1 => password , 2 => verification code]
        $mobile = en_num($request->mobile);
        $codePass = en_num($request->code);

        // find user
        $user = User::where('username' , $mobile)/*->where('status' , 1)*/->first();
        //dd($user);
        if(!$user){
            // user not found
            return success_false('درخواست شما پذیرفته نیست!');
        }
        // login by password
        //dd($user);
        if($loginType == 1){
            // check password
            if(!Hash::check($codePass, $user->password)){
                return success_false(l('رمز عبور اشتباه است'));
            }
        }
        // login by verify code
        elseif($loginType == 2){
            $loginRequest = UserLogin::where(['user_id' => $user->id])
                ->where('created_at', '>', Carbon::now()->subMinutes(10))
                ->orderBy('id', 'DESC')
                ->first();
            //dd($loginRequest);
            if(!$loginRequest){
                // invalid input
                return success_false('کد تایید اشتباه است');
            }
            if($loginRequest->used==1 || $loginRequest->code!=$codePass){
                return success_false('کد تایید اشتباه است');
            }
            // update login request
            $loginRequest->update(['used' => 1]);
        }
        // update verified date
        if(session()->has( 'registerStatus' ) && session('registerStatus') == true){
            $user->update(['active' => 1, 'verified_at' => Carbon::now()]);
        }
        // get previous url
        $redirectUrl = session('url.intended') ?? url()->previous();
        // check forget password status and has password
        if(session()->has('resetPassword') && session()->get('resetPassword') == true && !empty($user->password)){
            session(['url.intended' => url()->previous()]);
            $user->update(['change_password' => 1]);
            $redirectUrl = '/profile/change_password';
        }
        // login user
        if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5){
            Session::where('user_id' , $user->id)->delete();
        }
        if(ss('SITE_ID') == 3){
            UserOperation::where('created_at' , '>=' , date('Y-m-d 00:00:00'))->where('expert_id' , $user->id)->where('type',3)->delete();
        }
        Auth::loginUsingId($user->id, (ss('SITE_ID') != 3 && ss('SITE_ID') != 5 && ss('SITE_ID') != 8));
        $user->load('roles');  // بارگذاری نقش‌ها
        //dd($user->isExpert());
        if($user->isExpert())
        {
            UserTime::where('user_id' , $user->id)->update(['archived'=>1]);
            UserTime::create(['user_id' => $user->id, 'time' => 1200, 'archived' => 0]);
        }
        // check user has password
        $hasPassword = !empty($user->password) || $user->has_password == 1 ? 1 : 0;
        return success_true([
            'login_type' => $loginType,
            'has_password' => $hasPassword,
            'callback'=> $redirectUrl
        ], 'کاربر گرامی ، شما با موفقیت وارد شدید');
    }
    public function login(Request $request)
    {
        $user = Auth::user();
        if($user){
            return redirect(session('url.intended') ?? '/');
        }
        if(ss('THEME') == 'site4' || ss('THEME') == 'site8'  || ss('THEME') == 'site10' || ss('THEME') == 'site11')
        {
            return view( ss('THEME').'.frontend.auth.login' );
        }
        else
        {
            return view( 'frontend.auth.login' );
        }
    }
    public function login2(Request $request)
    {
        // find user
        $user = User::where('username' , $request->username)->first();
        if(!$user){
            // user not found
            return back()->withErrors([l('کلمه کاربری یا پسورد اشتباه است')]);
        }
        // login by password
        // check password
        if(!Hash::check($request->password, $user->password)){
            return back()->withErrors([l('کلمه کاربری یا پسورد اشتباه است')]);
        }
        // update verified date
        if(session()->has( 'registerStatus' ) && session('registerStatus') == true){
            $user->update(['active' => 1, 'verified_at' => Carbon::now()]);
        }
        // get previous url
        $redirectUrl = session('url.intended') ?? url()->previous();
        // check forget password status and has password
        if(session()->has('resetPassword') && session()->get('resetPassword') == true && !empty($user->password)){
            session(['url.intended' => url()->previous()]);
            $user->update(['change_password' => 1]);
            $redirectUrl = '/profile/change_password';
        }
        // login user
        if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5){
            Session::where('user_id' , $user->id)->delete();
        }
        if(ss('SITE_ID') == 3){
            UserOperation::where('created_at' , '>=' , date('Y-m-d 00:00:00'))->where('expert_id' , $user->id)->where('type',3)->delete();
        }

        Auth::loginUsingId($user->id, (ss('SITE_ID') != 3 && ss('SITE_ID') != 5 && ss('SITE_ID') != 8));
        $user->load('roles');  // بارگذاری نقش‌ها

        if($user->isExpert())
        {
            UserTime::where('user_id' , $user->id)->update(['archived'=>1]);
            UserTime::create(['user_id' => $user->id, 'time' => 1200, 'archived' => 0]);
        }
        // check user has password
        $hasPassword = !empty($user->password) || $user->has_password == 1 ? 1 : 0;
        return redirect( $redirectUrl);
    }
    public function login1(Request $request)
    {
        $user = Auth::user();
        if($user){
            return redirect(session('url.intended') ?? '/');
        }
        return view( 'frontend.auth.login' );
    }
    public function showRegistrationForm(Request $request)
    {
        return view( 'frontend.auth.register' );
    }
    public function register(Request $request)
    {
        // اگر ایمیل وجود دارد، برگرد با خطا
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'این ایمیل قبلاً ثبت شده است.']);
        }

        // اعتبارسنجی معمول
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'has_role' => 0,
            'active' => 0,
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'ثبت‌نام با موفقیت انجام شد. لطفاً ایمیل خود را برای فعال‌سازی بررسی کنید.');
    }
    public function logout(){
    }
    public function loginByMobile(VerifyMobileRequest $request)
    {
        $mobile = en_num($request->mobile);
        $code = mt_rand(10000, 99999);
        $user = User::where('username', $mobile)->first();
        $registerStatus =0;
        if (!empty($user)) {// exists user
            $checkLogin = UserLogin::where('user_id', $user->id)->where('created_at', '>', Carbon::now()->subMinutes(5))->count();
            if ($checkLogin > 4) {
                return success_false('درخواست شما پذیرفته نیست. لطفا لحظاتی دیگر تلاش کنید');
            } else {
                UserLogin::create(['user_id' => $user->id, 'code' => $code, 'ip' => $request->ip()]);
            }
        }
        else { // register new user
            $registerStatus = 1;
            $request->session()->put( 'registerStatus', true );
            // create user
            $newUser = User::create([
                'username' => $mobile,
                'phone' => $mobile,
                'has_role' => 0,
                'active' => 0,
                'status' => 0,
            ]);
            UserLogin::create(['user_id' => $newUser->id, 'code' => $code]);
            return success_true(['register'=>$registerStatus], 'کد ورود به '.ss('SITE_NAME').' ارسال شد.');
        }
        // send verify code
        //$res = sendSms($mobile,$code,null,null,'verify');
        $res = sendSms($mobile,smsText('verify',$code));
        return success_true(['register'=>$registerStatus], 'کد فعالسازی ارسال شد.');
    }
    public function confirm( Request $request ) {
        $mobile = $request->username;
        // validate
        $validator = Validator::make( $request->all(), [
            'username' => [
                'required',
                'digits:11',
                Rule::unique( 'users' )->where( function ( $query ) use ( $mobile ) {
                    return $query->where( 'username', $mobile )->where( 'active', 1 );//->where( 'deleted_at', null )
                } )
            ],
            'password' => 'required|min:6|max:64',
        ] );
        if ( $validator->fails() ) {
            //return unValidation( $validator->errors() );
            return redirect( '/login' )->withErrors( $validator->errors() );
        }
        $code = mt_rand(10000, 99999);
        // create or update user
        $user = User::firstOrNew([
            'username' => $mobile,
        ]);
        $user->phone = $mobile;
        $user->name = $request->name;
        $user->password = bcrypt( $request->password );
        $user->has_role = 0;
        $user->active = 0;
        $user->status = 0;
        $user->save();
//        $user = User::firstOrCreate( [
//            'name' => $request->name,
//            'username' => $mobile,
//            'phone' => $mobile,
//            'password' => bcrypt( $request->password ),
//            'has_role' => 0,
//            'active' => 0,
//            'status' => 0,
//        ] );
        if ( $user ) {
            UserLogin::create(['user_id' => $user->id, 'code' => $code]);
            // put status in session
            $request->session()->put( 'registerStatus', true );
            // send verify code
            $res = sendSms($mobile,smsText('verify',$code));
            return redirect( '/check_validation/create' )->with( 'user', $user );
        }
    }
    public function showCheckValidationForm( Request $request ) {
        if ( session()->has( 'user' ) ) {
            return view( 'frontend.auth.confirm' );
        }
        return redirect( '/login' )->withInput()->withErrors( [ 'session_time_out' => 'لطفا مجدد تلاش کنید' ] );
    }
    public function checkValidation( Request $request ) {
        $username = $request->username;
        $code = $request->code;
        // find user
        $user = User::where( 'username', $username )->first();
        if ( ! $user ) {
            return back()->withInput()->withErrors( [ 'code' => 'کاربر یافت نشد' ] )->with( 'user', $user );
        }
        // validate
        $validator = Validator::make( $request->all(), [
            'code' => 'required|digits:5',
        ] );
        if ( $validator->fails() ) {
            return back()->with( [ 'errors' => $validator->errors() ] )->with( 'user', $user );
        }
        // check login requests
        $checkLogin = UserLogin::where(['user_id' => $user->id, 'code' => $code])->where('created_at', '>', Carbon::now()->subMinutes(10))->orderBy('id', 'DESC')->first();
        if (empty($checkLogin)) {
            // invalid input
            return back()->withInput()->withErrors( [ 'code' => 'کد فعال سازی اشتباه است.' ] )->with( 'user', $user );
        }
        $checkLogin->update(['used' => 1]);
        // update verified date
        if(session()->has( 'registerStatus' ) && session('registerStatus') == true){
            $user->update(['active' => 1, 'verified_at' => Carbon::now()]);
        }
        // login user
        Auth::loginUsingId($user->id, true);
        if($user->isExpert())
        {
            UserTime::where('user_id' , $user->id)->update(['archived'=>1]);
            UserTime::create(['user_id' => $user->id, 'time' => 600, 'archived' => 0]);
        }
        // get previous url
        $redirectUrl = session('url.intended') ?? '/profile';//url()->previous();
        // check forget password status
        if(session()->has('resetPassword') && session()->get('resetPassword') == true){
            $user->update(['change_password' => 1]);
            $redirectUrl = '/profile/change_password';
        }
        return redirect( $redirectUrl );
    }
    public function sendAgain( Request $request ) {
        $username  = $request->username;
        $existUser = User::where( 'username', $username );
        if ( ! session()->has( 'resetPassword' ) ) {
            $existUser = $existUser->where( 'active', 0 );
        }
        $existUser = $existUser->first();
        if ( ! $existUser ) {
            return back()->withInput()->withErrors( [ 'code' => 'کاربر یافت نشد' ] )->with( 'user', $existUser );
        }
        $code = mt_rand(10000, 99999);
        UserLogin::create(['user_id' => $existUser->id, 'code' => $code]);
        // update session status
        $request->session()->put( 'registerStatus', (session('registerStatus') ?? false) );
        // send verify code
        //$res = sendSms($username,$code,null,null,'verify');
        $res = sendSms($username,smsText('verify',$code));
        return redirect( '/check_validation/create' )->with( 'user', $existUser );
    }
    public function showForgetPasswordForm( Request $request ) {
        return view( 'frontend.auth.forget_password' );
    }
    public function forgetPassword( Request $request ) {
        $username = $request->username;
        $user     = User::where( 'username', $username )->first();
        if ( ! $user ) {
            return back()->withInput()->withErrors( [ 'user' => 'کاربر یافت نشد' ] )->with( 'user', $user );
        }
        $code = mt_rand(10000, 99999);
        UserLogin::create(['user_id' => $user->id, 'code' => $code]);
        // add|update session status
        $request->session()->put( 'resetPassword', true );
        // send verify code
        //$res = sendSms($username,$code,null,null,'verify');
        $res = sendSms($username,smsText('verify',$code));
        return redirect( '/check_validation/create' )->with( 'user', $user );
    }
    public function rules()
    {
        return view('site2.frontend.estate.rules');
    }
    public function host()
    {
        return view('site2.frontend.estate.host');
    }

    public function destroyOperationUser($id)
    {
        $user = Auth::user();
        if($user->isAdmin()){
            UserOperation::where( 'id', $id )->delete();
            return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function addOperation(Request $request)
    {
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            $score = 0;
            switch((int)$request->type)
            {
                case 1:
                    $score = getsetting('statictis','cover');
                    break;
                case 2:
                    $today = gregorian_to_jalali(date('Y'),date('m'),date('d'),'/');
                    $now = explode('/' , $today);
                    $firstmonth =  jalali_to_gregorian($now[0],$now[1],1,'-');
                    $UserOperations = UserOperation::where('created_at' , '>=' , $firstmonth)->where('expert_id' , ($request->expert_id > 0 ? $request->expert_id : $user->id))->where('type' , 2)->get();
                    $delay = 0;
                    foreach($UserOperations as $UserOperation)
                    {
                        $delay += $UserOperation->comment;
                    }
                    $delay += (int)$request->comment;

                    if($delay <= 60)
                    {

                        $score = (int)getsetting('statictis','delay1');
                    }
                    elseif($delay >= 240 && $delay <= 600)
                    {

                        $score = (int)($delay/60) * (int)getsetting('statictis','delay2');
                    }
                    elseif($delay > 600)
                    {

                        $score = (int)($delay/60) * (int)getsetting('statictis','delay3');
                    }
                    foreach($UserOperations as $userOperation)
                    {
                        $userOperation->update( [ 'score' => 0 ] );
                    }
                    break;
                case 4:
                    $score = getsetting('statictis','session');
                    break;
                case 5:
                    $score = (int)$request->comment;
                    break;

            }
            $operation_id = UserOperation::create([
                'expert_id' => $request->expert_id > 0 ? $request->expert_id : $user->id,
                'score' => $score,
                'comment' => $request->comment,
                'type'=> $request->type
            ]);
        }
        return success_true(['operation_id'=>$operation_id], 'عملکرد با موفقیت ذخیره گردید');
    }
    public function operationsUser(Request $request)
    {
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            // datetime
            $dt = Carbon::now();
            // retrieve estate
            $operationsuser = UserOperation::orderBy('id', 'desc');
            if($user != null && $user->isExpert())
            {
                $operationsuser = $operationsuser->where('expert_id', $user->id);
            }
            $operationsuser = $operationsuser->paginate(20);;
            $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
            $users = $users->whereHas('roles', function ($query) {
                $query->where( 'id', '=', 9);
            })->get(['id', 'name','last_name', 'username','status']);
            $branches = null;
            if(ss('SITE_ID') == 3 || ss('SITE_ID') == 8)
            {
                $branches = Branch::get();
            }
            return view('frontend.profile.operation_user', compact('operationsuser','users','branches'));
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function operationsUserShow(Request $request)
    {
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        // retrieve estate
        $operationsUser = UserOperation::orderBy($request->order, $request->orderby);
        if(!empty($request->type))
        {
            $operationsUser = $operationsUser->where('type',$request->type);
        }
        if($user->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch|expert')){
            if (!empty($request->user_id))
            {
                if($request->user_id < 0)
                {
                    $users = User::where('branch_id' , $request->user_id * -1)->get(['id', 'name','last_name', 'username','status']);
                    foreach($users as $user){
                        $u[] = $user->id;
                    }
                    $operationsUser = $operationsUser->whereIn('expert_id', $u);
                }
                else
                {
                    $operationsUser = $operationsUser->where('expert_id', $request->user_id);
                }
            }
            else
            {
                $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
                $users = $users->whereHas('roles', function ($query) {
                    $query->where( 'id', '=', 9);
                })->get(['id']);
                foreach($users as $u)
                {
                    $user1[] = $u->id;
                }
                $operationsUser = $operationsUser->whereIn('expert_id', $user1);
            }
        }
        else
        {
            $operationsUser = $operationsUser->where('expert_id', $user->id);
        }
        if($request->datefrom != ''){
            //dd($request->datefrom);
            if(env('COUNTRY') != 'UAE')
            {
                $datefrom = explode('/',$request->datefrom);
                $operationsUser = $operationsUser->where('created_at' , '>=' , jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-'));
            }
            else
            {
                $operationsUser = $operationsUser->where('created_at' , '>=' , $request->datefrom);
            }
        }
        if($request->dateto != ''){
            if(env('COUNTRY') != 'UAE')
            {
                $dateto = explode('/',$request->dateto);
                $operationsUser = $operationsUser->where('created_at' , '<=' , jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:59:59");
            }
            else
            {
                $operationsUser = $operationsUser->where('created_at' , '<=' , $request->dateto);
            }
        }
        $totalCount = $operationsUser->count();
        $operationsUser = $operationsUser->paginate(20);
        $couter=$totalCount/20;
        $couter=(int)$couter;
        $hasPage = ($couter==$request->page)? false : true;
        $view = view('frontend.profile.operation_user_show_type', compact('operationsUser','totalCount'))->render();
        return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
    }
    public function operationsUserCron()
    {
        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 9);
        })->get(['id', 'name','last_name', 'username','status'])->unique('id');
        //dd(getQuery($users));
        $today = gregorian_to_jalali(date('Y'),date('m'),date('d'),'/');
        $now = explode('/' , $today);

        foreach($users as $user)
        {
            if($now[2] == 1)
            {
                UserOperation::create([
                    'expert_id' => $user->id,
                    'score' => getsetting('statictis','delay1'),
                    'comment' => 0,
                    'type'=> 2
                ]);
            }
            if(date("D") != 'Fri')
            {
                $alreadyExists = UserOperation::where('expert_id', $user->id)
                ->where('type', 3)
                ->whereDate('created_at', date('Y-m-d')) // بررسی امروز میلادی
                ->exists();

                if (!$alreadyExists) {
                    UserOperation::create([
                        'expert_id' => $user->id,
                        'score' => getsetting('statictis', 'inactivity'),
                        'comment' => 0,
                        'type' => 3
                    ]);
                }
            }
        }
    }

}
