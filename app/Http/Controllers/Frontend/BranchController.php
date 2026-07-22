<?php
namespace App\Http\Controllers\Frontend;
use App\Models\Branch;
use App\Models\BranchDistrict;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use App\Models\BranchImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class BranchController extends Controller
{
    public function show(Request $request, $code)
    {
        $brach="";
        if(empty(Auth::user()))
        $brach="";
        else
        $brach=Auth::user()->ismember();
        // retrieve branch
        $branch = Branch::where('status', '1')
                ->where('active', 1)
                ->where('id', $code)
                ->first();
        $experts = User::whereNotNull('photo')->where('branch_id',$code)->where('status','1')->where('active','1')->role('expert')->get();
        return view('frontend.branch.show', compact(
            'branch',
            'brach',
            'experts'
        ));
    }


    public function index( Request $request )
    {
        $user = Auth::user();
        if(!isset($user) || !($user->isAdmin() || $user->isAdminBranch()) )
        {
            return view('frontend.errors.404');
        }
        // start query
        $model = Branch::with([]);
        $model = ! empty( $request->id ) ? $model->where( 'id', (int) $request->id ) : $model;
        $model = ! empty( $request->name ) ? $model->where( 'name',  'like' , '%'.$request->name.'%' ) : $model;
        $model = ! empty( $request->status) ? $model->where( 'status',$request->status) : $model;
        if($user->isAdminBranch())
        {
            $model = $model->where( 'id', $user->branch_id);
        }
        // paginate list
        if(!empty($request->order) && !empty($request->orderby)){
            $model = $model->orderBy($request->order, $request->orderby);
        }
        else
        {
            $model = $model->orderBy('id', 'desc');
        }

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
            $view = view('frontend.branch.component_ex_user_type', compact('model','totalCount'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        return view( 'frontend.branch.list', compact( 'model' ) );

	}

    public function status( $branch_id, $branch_status ) {
        $user = Auth::user();
        if(!isset($user) || !$user->isAdmin())
        {
            return view('frontend.errors.404');
        }
		$validator = Validator::make( [ 'id' => $branch_id, 'status' => $branch_status ], [
			'id'     => 'required|exists:users,id',
			'status' => 'required|between:-1,4'
		] );
		if ( $validator->fails() ) {
			return response( [
				'status' => 'error',
				'result' => $validator->errors()
			], config( 'StatusCode.INVALID_INPUT' ) );
		}
		$model = Branch::find( $branch_id );
        $model->update( [ 'status' => $branch_status ] );
		return response( [
			'status' => 'ok',
			'result' => 'تغییر وضعیت با موفقیت انجام شد.'
		], config( 'StatusCode.SUCCESS' ) );
	}

    public function destroy( $id ) {
        $user = Auth::user();
        $model = Branch::find( $id );
        if(!isset($model) || !isset($user) || !($user->isAdmin() || ($user->isAdminBranch() && ($model->id == $user->branch_id))))
        {
            return view('frontend.errors.404');
        }


        $model->delete();
		return response()->json( [ 'status' => 'ok', 'result' => 'deleted!' ], config( 'StatusCode.SUCCESS' ) );
	}
    public function added()
    {
        return view('site7.frontend.branch.added');
    }
    public function create()
    {
        $superAdmin = Auth::user();
        if(!isset($superAdmin))
        {
            return view('frontend.errors.404');
        }
        if(ss('SITE_ID') == 7)
        {
            if(!$superAdmin->isExpert())
            {
                return redirect('/profile/users/create?addBranch=true');
            }
            if($superAdmin->isAdminBranch())
            {
                return redirect('/profile/branches/edit/'.$superAdmin->branch_id);
            }
        }
        else
        {
            if(!$superAdmin->isAdmin())
            {
                return view('frontend.errors.404');
            }
        }
        if(ss('SITE_ID') == 7)
        {
            return view('site7.frontend.branch.create' );
        }
        else
        {
		    return view('frontend.branch.create' );
        }
	}

	public function store( Request $request )
    {
        $superAdmin = Auth::user();
        if(!isset($superAdmin))
        {
            return view('frontend.errors.404');
        }
        if(ss('SITE_ID') == 7)
        {
            if(!$superAdmin->isExpert())
            {
                $addBranch = true;
                return view('site7.frontend.auth.create', compact('addBranch'));
            }
            if($superAdmin->isAdminBranch())
            {
                return redirect('/profile/branches/edit/'.$superAdmin->branch_id);
            }
        }
        else
        {
            if(!$superAdmin->isAdmin())
            {
                return view('frontend.errors.404');
            }
        }

        $inputs = $request->all();
		$branch = Branch::create(checkInputs($inputs));
        if($branch){
            $district_ids = $request->districts;
            if ( empty( $district_ids ) ) {
                BranchDistrict::where('branch_id',$branch->id)->delete();
            } else {
                // get count
                $selectedList = array_count_values($district_ids);
                $districts=[];
                foreach ( $selectedList as $districtId => $selectedCount ) {
                    $percentValue = ($selectedCount * 100) / count($district_ids);
                    $districts[] = [ 'branch_id' => $branch->id, 'district_id' => $districtId];
                }
                BranchDistrict::where('branch_id',$branch->id)->delete();
                BranchDistrict::insert( $districts );
            }

		}
        if (!empty($request->document)) {
            // all images id
            $imgIds = $request->document;
            // selected image
            $defaultId = $request->default_image;
            // update model_id
            BranchImage::whereIn('id', $request->document)->update(['branch_id' => $branch->id]);
            // check has default image
            if (!empty($defaultId) && in_array($defaultId, $imgIds)) {
                $img = BranchImage::find($defaultId);
            } else {
                $img = BranchImage::where('branch_id', $branch->id)->first();
            }
            // update image fields of estate model

            // update default image in images table
            if ($img) {
                $img->update(['cover' => 1]);
            }
        }
        session()->flash('اطلاعات شعبه جدید با موفقیت ثبت شد.','success');
        if(ss('SITE_ID') == 7 && !$superAdmin->isExpert())
        {
            return redirect( '/profile/branches/added' );
        }
        else
        {
            return redirect( '/profile/branches' )->with( 'success', 'created successfully' );
        }

	}


	public function edit( $id ) {
        $user = Auth::user();
        if(!isset($user))
        {
            return view('frontend.errors.404');
        }
        if(ss('SITE_ID') == 7)
        {

            if(!$user->isAdminBranch())
            {
                return view('frontend.errors.404');
            }
            elseif($user->branch_id != $id)
            {
                return view('frontend.errors.404');
            }
        }
        else
        {
            if(!$user->isAdmin())
            {
                return view('frontend.errors.404');
            }
        }
		$model = Branch::find($id);
        $selectedDistricts = [];
        $model->district_ids = $model->districts()->pluck('district_id');

        $model->selectedDistricts = $model->districts()->pluck('district_id')->toArray();
        if(!empty($model->selectedDistricts)){
            $selectedDistricts = array_map(function ($val){
                return (int) $val;
            },$model->selectedDistricts);
        }
        $defaultImage = null;
        if (count($model->images) > 0) {
            $defaultImage = $model->images->where('cover', 1)->first();
            if (!$defaultImage) {
                $defaultImage = $model->images->first();
            }
        }
        $provinces = Province::get();
        $cities = City::where('province_id',$model->province_id)->get();
        $districts = District::where('city_id',$model->city_id)->get();
        //dd($model);

		return view((ss('SITE_ID') == 7?'site7.':'' ).'frontend.branch.create', compact(
		    'model','provinces',
            'cities',
            'selectedDistricts',
            'districts',
            'defaultImage'
        ) );
	}

    public function storeMedia(Request $request)
    {
        $cropDetail = [600, 600, 0, 0];
        $gallery = uploaderImage($request, 'file', 'images/branch', null, true, $cropDetail);
        if (empty($gallery)) {
            return response()->json(['error' => 'upload failed!'], 500);
        }
        $user = Auth::user();
        $userid = null;
        if($user)
        {
            $userid = $user->id;
        }
        // save images
        $image = BranchImage::create([
            'token' => uniqid(),
            'user_id' => $userid,
            'extension' => $gallery['extension'],
            'url' => $gallery['image_url'],
            'dimension' => $gallery['dimension'],
            'month' => date('m'),
            'year' => date('Y')
        ]);
        if (!$image) {
            return response()->json(['error' => 'saving failed!'], 500);
        }
        return response()->json(['name' => $image->id]);
    }
    public function deleteMedia(Request $request, $id)
    {
        BranchImage::where('branch_id', $request->branch_id)->where('id', $id)->delete();
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
    }

	public function update( Request $request, $id ) {
	    // auth user
        $authUser = Auth::user();
        if(!isset($authUser))
        {
            return view('frontend.errors.404');
        }
        if(ss('SITE_ID') == 7)
        {
            if(!$authUser->isAdminBranch())
            {
                return view('frontend.errors.404');
            }
            elseif($authUser->branch_id != $id)
            {
                return view('frontend.errors.404');
            }
        }
        else
        {
            if(!$authUser->isAdmin())
            {
                return view('frontend.errors.404');
            }
        }
        $inputs = $request->all();
        // find branch model
		$branch = Branch::find( $id );
        $district_ids = $request->districts;
        if ( empty( $district_ids ) ) {
            BranchDistrict::where('branch_id',$branch->id)->delete();
        } else {
            // get count
            $selectedList = array_count_values($district_ids);
            $districts=[];
            foreach ( $selectedList as $districtId => $selectedCount ) {
                $percentValue = ($selectedCount * 100) / count($district_ids);
                $districts[] = [ 'branch_id' => $branch->id, 'district_id' => $districtId];
            }
            BranchDistrict::where('branch_id',$branch->id)->delete();
            BranchDistrict::insert( $districts );
        }
        if (!empty($request->document)) {
            $imgIds = $request->document;
            BranchImage::whereIn('id', $imgIds)->update(['branch_id' => $branch->id]);
        }
        $branch->update(checkInputs($inputs));
		if ( empty( $branch ) ) {
			return back()->with( [ 'errors' => 'یافت نشد!' ] );
		}
        // validate inputs
        return redirect( '/profile/branches' );
	}

    public function search(Request $request, $city = 'tehran')
    {
        // retrieve selected city
        $selectedCity = $_COOKIE['city'] ?? 'none';
        $city = City::with(['districts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])
            ->where('name_en', $selectedCity)
            ->where('active', 1)
            ->first();
        // get districts of selected city
        $districts = $city->districts ?? [];
        $selectedDistricts = [];
        $branchType = $request->branch_type ?? '';
        $branchName = $request->branch_name ?? '';
        $branchAdminName = $request->branch_admin_name ?? '';
        $contractRoomCount = $request->contract_room_count ?? '';
        $activityRange = [0, 0];
        // start query
        $branches = Branch::whereHas('user', function ($q) {
                $q->where('active', 1)->where('status', '1');
            })->with([
            'user:id,code,name,username',
            'districts',
            'contracts' => function ($q) {
                $q->orderBy('id', 'desc');
            }])
            ->where('status', '1')
            ->where('active', 1)
            ->where('city_id', $city->id);

        // filter type
//        $branches = !empty($branchType) ? $branches->where('type', $branchType) : $branches->whereIn('type', [1,2]);
        if ($branchType) {
            $branches = $branches->where('type', $branchType);
        }
        // filter name
        if ($branchName) {
            $branches = $branches->where('name', 'LIKE', '%' . $branchName . '%');
            $branches = $branches->where('name', 'LIKE', '%' . $branchName . '%');
        }
        // filter admin name
        if ($branchAdminName) {
            $branches = $branches->whereHas('user',function ($q)use($branchAdminName){
                $q->where('name', 'LIKE', '%' . $branchAdminName . '%');
            });
        }
        // filter contract room count
        if ($contractRoomCount) {
            $branches = $branches->where('contract_room_count','>=',(int)$contractRoomCount);
        }
        // filter scores
        if ($request->score) {
        }
        // filter districts
        $selectedDistricts = !empty($request->districts) ? array_filter($request->districts,function ($value) {
            return !empty($value);
        }) : [];
        if (!empty($selectedDistricts)) {
            $selectedDistricts = array_map(function ($value) {
                return (int)$value;
            }, $selectedDistricts);
            $branches = $branches->whereHas('districts', function ($q) use ($selectedDistricts) {
                $q->whereIn('district_id', $selectedDistricts);
            });
        }
        // filter activity range (contracts)
        if (!empty($request->activity_range_min) || !empty($request->activity_range_max)) {
            $activityRange = [$request->activity_range_min ?? 0, $request->activity_range_max ?? 0];
            if (empty($activityRange[1])) {
                $branches = $branches->whereHas('contracts', function ($q) use ($activityRange) {
                    $q->where('total_price', '>=', $activityRange[0]);
                });
            } elseif (empty($price[0]) && !empty($price[1])) {
                $branches = $branches->whereHas('contracts', function ($q) use ($activityRange) {
                    $q->where('total_price', '<=', $activityRange[1]);
                });
            } else {
                $branches = $branches->whereHas('contracts', function ($q) use ($activityRange) {
                    $q->whereBetween('total_price', $activityRange);
                });
            }
        }
        $branches = $branches->paginate(20);
        // iterate on collection
        foreach ($branches as $branch) {
            // get last activity
            $branch->last_activity = $branch->contracts->first()->created_at ?? '';
            // activity range
            $branch->activityRangeMin = $branch->contracts->min('total_price');
            $branch->activityRangeMax = $branch->contracts->max('total_price');
        }
        return view('frontend.branch.search', compact(
            'templatePage',
            'city',
            'districts',
            'branches',
            'selectedDistricts',
            'branchType',
            'branchName',
            'branchAdminName',
            'activityRange',
            'contractRoomCount'
        ));
    }
    public function branchSearch2(){
        return view( 'site7.frontend.branch.list' );
    }
    public function getSearchForm(Request $request)
    {
        // $currentUser = Auth::user();

        // if(!$currentUser || $currentUser->has_role != 1){
        //     return view('frontend.errors.404');;
        // }
        // get referrer url
        if (session()->has('referrerUrl')) {
            session()->forget('referrerUrl');
        }
        // get template page and ads
        // retrieve selected city
        $selectedCity = $_COOKIE['city'] ?? 'qom';
        // get city with districts
        $city = City::with(['districts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])
            ->where('name_en', $selectedCity)
            ->where('active', 1)
            ->first();
        // if default city was not set
        if (!$city) {
            $request->session()->put('referrerUrl', $request->getRequestUri());
            return redirect('/cities');
        }
        // get districts of city
        $districts = $city->districts;
        // start query
        $branches = Branch::where('status', '1')
            ->where('active', 1)
            ->where('city_id', $city->id)
            ->paginate(20);
        foreach ($branches as $branch) {
            // get last activity
            $branch->last_activity = '';
            // from activity log
            //$lastContract = $branch->contracts->first();
            // if($lastContract){
            //     $branch->last_activity = $lastContract->created_at;
            // }
            // get current datetime
            $now = Carbon::now();
            // computing experience
            $created = $branch->created_at;
            $diff_in_months = $now->diffInMonths($created);
            $diff_in_years = $now->diffInYears($created);
            $branch->experienceKama = !empty($diff_in_years) ? $diff_in_years.' سال': $diff_in_months.' ماه';
            // activity range
            // $branch->activityRangeMin = $branch->contracts->min('total_price');
            // $branch->activityRangeMax = $branch->contracts->max('total_price');
        }
        $selectedDistricts = [];
        $name = $request->branch_name ?? '';
        $branchType = $request->branch_type ?? '';
        $activityRange = [0, 0];
        if(ss('SITE_ID') == 7)
        {
            return view('site7.frontend.branch.search', compact(
                'city',
                'branches',
                'districts',
                'branchType',
                'selectedDistricts',
                'name',
                'activityRange'
            ));
        }
        else
        {
            return view('frontend.branch.search', compact(
                'city',
                'branches',
                'districts',
                'branchType',
                'selectedDistricts',
                'name',
                'activityRange'
            ));
        }
    }



}
