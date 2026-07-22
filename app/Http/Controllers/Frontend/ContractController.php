<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\ContractUser;
use App\Models\ContractDocument;
use App\Models\ContractParties;
use App\Models\ContractEarning;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Customer;
use App\Models\Estate;
use Illuminate\Support\Facades\Auth;
use App\helper\Uploader;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
class ContractController extends Controller
{
    public function create(Request $request,$id = null)
    {
        $users = User::role('expert')->where('has_role', 1)->where('is_admin', 0)->get();
        $model="";
        if(!empty($id)){
            $model = Contract::with(['contractUsers','contractDocument'])->orderBy('id', 'desc')->where('id',$id)->first();
       }
        return view('frontend.contract.create',compact('users','model'));
    }
    public function deleteMedia(Request $request, $id)
    {
        ContractDocument::where('id', $id)->delete();
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
    }
    public function storeMedia(Request $request)
    {
        $cropDetail = [600, 600, 0, 0];
        $gallery = uploader3($request, 'file', 'images/contract/'.date('Y').'/'.date('m'), null, true, $cropDetail);
        if (empty($gallery)) {
            return response()->json(['error' => 'upload failed!'], 500);
        }
        // save images
        $image = ContractDocument::create([
            'extension' => $gallery['extension'],
            'url' => $gallery['image_url'],
            'month' => date('m'),
            'year' => date('Y')
        ]);
        if (!$image) {
            return response()->json(['error' => 'saving failed!'], 500);
        }
        return response()->json(['name' => $image->id]);
    }
    public function contractearn($id)
    {
        $user = Auth::user();
        if($id > 0)
        {
            $ContractParties = ContractParties::where('contract_id',$id);
        }
        else
        {
            $user_id = app('request')->input('user_id');
            $ContractParties = ContractParties::join('contracts', 'contracts.id', '=', 'contract_parties.contract_id')->join('contract_users', 'contract_parties.contract_id' , '=' , 'contract_users.contract_id')
            ->where('contract_users.expert_id', $user_id);

            if(app('request')->input('datefrom') != ''){
                $datefrom = explode('/' , app('request')->input('datefrom'));
                $ContractParties = $ContractParties->where('contract_parties.created_at' , '>=' , jalali_to_gregorian($datefrom[0] , $datefrom[1] , $datefrom[2] , '-')." 00:00:00");
            }
            if(app('request')->input('dateto') != ''){
                $dateto = explode('/' , app('request')->input('dateto'));
                $ContractParties = $ContractParties->where('contract_parties.created_at' , '<=' , jalali_to_gregorian($dateto[0] , $dateto[1] , $dateto[2] , '-')." 23:29:59");
            }
            if(app('request')->input('type') == 'buy'){

                $ContractParties = $ContractParties->where('contracts.type' , '!=' , 2);
            }
            else
            {
                $ContractParties = $ContractParties->where('contracts.type' , 2);
            }
        }
        //dd(getQuery($ContractParties));
        $ContractParties = $ContractParties->get();
       return view('frontend.contract.contractParties', compact('ContractParties','id'));
    }
    public function contractDestroy($id)
    {
        Contract::where('id',$id)->delete();
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
    }
    public function partiesAdd(Request $request)
    {
        $inputs = checkInputs($request->all());
        $inputs["commission"] = str_replace(',' , '' , $inputs["commission"]);
        $model = ContractParties::create($inputs);
        session()->flash('عملیات ثبت با موفقیت انجام شد.', 'success');
        return redirect('/profile/contractearn/'.$request->contract_id);
    }
    public function partiesDestroy($id)
    {
        ContractParties::where('id',$id)->delete();
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
    }
    public function partiesEdit(Request $request)
    {
        $inputs = $request->all();
        $inputs = checkInputs($inputs);
        $model = ContractParties::where('id',$request->id)->update(['type' => $inputs["type"], 'name' => $inputs["name"],'commission'=>str_replace(',' , '' , $inputs["commission"]),'receipt_number'=>$inputs["receipt_number"],'receipt_doc'=>$inputs["receipt_doc"],'description'=>$inputs["description"]]);
        return redirect('/profile/contractearn/'.$request->contract_id);
    }
    public function createparties(Request $request)
    {
        $user = Auth::user();
        $contractid=$request->contract_id;
        $model = ContractParties::where('id',$request->id)->first();
        $view = view('frontend.contract.contractPartiesCreate', compact('model','contractid'))->render();
        return response()->json(['html' => $view]);
    }
    public function ContractAdd(Request $request)
    {
        $superAdmin = Auth::user();
        if(!isset($superAdmin) || !$superAdmin->isAdmin())
        {
            return view('frontend.errors.404');
        }
	    // validate inputs
        /*$validator = Validator::make( $request->all(), [
			'contractId' => 'bail|required|unique:contracts,contractId'
		] );
        //return validation errors
		if ( $validator->fails() ) {
			return back()->withInput()->with( [ 'errors' => $validator->errors() ] );
		}*/
        // get auth user
        $user = Auth::user();
        $registerAt = null;
        $registryofficedate = null;
        $deliverydate = null;
        if (!empty($request->register_date)) {
            $registerAt = Verta::parse($request->register_date)->formatGregorian('Y-m-d h:i');
        }
        if (!empty($request->registryofficedate)) {
            $registryofficedate = Verta::parse($request->registryofficedate)->formatGregorian('Y-m-d h:i');
        }
        if (!empty($request->deliverydate)) {
            $deliverydate = Verta::parse($request->deliverydate)->formatGregorian('Y-m-d h:i');
        }
        $inputs = $request->all();
        $inputs['register_at'] = $registerAt;
        $inputs['registryofficedate'] = $registryofficedate;
        $inputs['deliverydate'] = $deliverydate;
        if(!empty($inputs['total_price']))
        {
            $inputs['total_price'] = str_replace(',','',en_num($inputs['total_price']));
        }
        if(!empty($inputs['total_rent']))
        {
            $inputs['total_rent'] = str_replace(',','',en_num($inputs['total_rent']));
        }
        if(!empty($inputs['total_mortgage']))
        {
            $inputs['total_mortgage'] = str_replace(',','',en_num($inputs['total_mortgage']));
        }
        if(!empty($inputs['total_commission'])){
            $inputs['total_commission'] = str_replace(',','',en_num($inputs['total_commission']));
        }
        $model = Contract::create($inputs);
        if ($model && !empty($request->contract_users)) {
            foreach($request->contract_users as $field => $values) {
                if($request->contract_users2[$field]!=null){
                $inputs['contract_id'] = $model->id;
                $inputs['type']=$values;
                $inputs['expert_id']=$request->contract_users1[$field];
                $inputs['expert_commission']=$request->contract_users2[$field];
                $model1 = ContractUser::create($inputs);
                }
            }
            if (!empty($request->document)) {
                $imgIds = $request->document;
                ContractDocument::whereIn('id', $request->document)->update(['contract_id' => $model->id]);
            }
        }
        session()->flash('عملیات ثبت با موفقیت انجام شد.', 'success');
        return redirect('/profile/contract');
    }
    public function contractUserDestroy($id)
    {
        $model = ContractUser::where('id',$id)->delete();
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
    }
    public function ContractEdit(Request $request,$id)
    {
        $user = Auth::user();
        $registerAt = null;
        $registryofficedate = null;
        $deliverydate = null;
        if (!empty($request->register_date)) {
            $registerAt = Verta::parse($request->register_date)->formatGregorian('Y-m-d h:i');
        }
        if (!empty($request->registryofficedate)) {
            $registryofficedate = Verta::parse($request->registryofficedate)->formatGregorian('Y-m-d h:i');
        }
        if (!empty($request->deliverydate)) {
            $deliverydate = Verta::parse($request->deliverydate)->formatGregorian('Y-m-d h:i');
        }
        //$inputs = $request->all();
        $inputs['register_at'] = $registerAt;
        $inputs['tracking_code'] = $request->tracking_code;
        $inputs['registryofficedate'] = $registryofficedate;
        $inputs['deliverydate'] = $deliverydate;
        if(!empty($request->total_price)){
            $inputs['total_price'] = str_replace(',','', en_num($request->total_price));
        }
        if(!empty($request->total_commission)){
            $inputs['total_commission'] = str_replace(',','', en_num($request->total_commission));
        }
        if(!empty($request->total_rent))
        {
            $inputs['total_rent'] = str_replace(',','',en_num($request->total_rent));
        }
        if(!empty($request->total_mortgage))
        {
            $inputs['total_mortgage'] = str_replace(',','',en_num($request->total_mortgage));
        }
        $inputs['contractid'] =$request->contractid;
        $inputs['estate_id'] =$request->estate_id;
        $inputs['estate_name'] =$request->estate_name;
        $inputs['estate_phone'] =$request->estate_phone;
        $inputs['customer_id'] =$request->customer_id;
        $inputs['customer_name'] =$request->customer_name;
        $inputs['customer_phone'] =$request->customer_phone;
        $inputs['customer_fatherName'] =$request->customer_fatherName;
        $inputs['customer_nationalId'] =$request->customer_nationalId;
        $inputs['customer_idCard'] =$request->customer_idCard;
        $inputs['estate_fatherName'] =$request->estate_fatherName;
        $inputs['estate_nationalId'] =$request->estate_nationalId;
        $inputs['estate_idCard'] =$request->estate_idCard;
        $inputs['type'] =$request->type;
        $inputs['estate_type'] =$request->estate_type;
        $inputs['estate_address'] =$request->estate_address;
        $inputs['description'] =$request->description;
        $model = Contract::where('id',$id)->update($inputs);
        // if contract created
        if ($id) {

            if (!empty($request->contractUsersold)) {
                foreach ($request->contractUsersold as $field1 => $values1) {
                    if (isset($request->contract_users_old[$field1]) && isset($request->contract_users1_old[$field1]) && isset($request->contract_users2_old[$field1])) {
                        $model222 = ContractUser::where('id', $values1)
                            ->update([
                                'type' => $request->contract_users_old[$field1],
                                'expert_id' => $request->contract_users1_old[$field1],
                                'expert_commission' => $request->contract_users2_old[$field1]
                            ]);
                    }
                }
            }

            foreach($request->contract_users as $field => $values) {
                if($request->contract_users2[$field]!=null){
                $inputs['contract_id'] =$id;
                $inputs['type']=$values;
                $inputs['expert_id']=$request->contract_users1[$field];
                $inputs['expert_commission']=$request->contract_users2[$field];
                $model1 = ContractUser::create($inputs);
                }
            }
            if (!empty($request->document)) {
                $imgIds = $request->document;
                ContractDocument::whereIn('id', $request->document)->update(['contract_id' => $id]);
            }
        }
        session()->flash('عملیات ثبت با موفقیت انجام شد.', 'success');
        return redirect('/profile/contract');
    }
    public function index(Request $request)
    {
        $users = User::role('expert')->where('has_role', 1)->where('is_admin', 0)->get();
        $model = Contract::with(['contractUsers','contractDocument'])->orderBy('id', 'desc');
        if (!empty($request->create_date_of)) {
            $create_date_of = Verta::parse($request->create_date_of)->formatGregorian('Y-m-d h:i');
            $model=$model->where('register_at','>=',$create_date_of);
        }
        if (!empty($request->create_date_to)) {
            $create_date_to = Verta::parse($request->create_date_to)->formatGregorian('Y-m-d h:i');
            $model=$model->where('register_at','<=',$create_date_to);
        }
        if($request->contractid)
        {
            $model=$model->where('contractid',$request->contractid);
        }
        if($request->estate_nationalId)
        {
            $model=$model->where('estate_nationalId','like', '%'.$request->estate_nationalId.'%');
        }
        if($request->estate_name)
        {
            $model=$model->where('estate_name','like', '%'.$request->estate_name.'%');
        }
        if($request->reminder)
        {
            $ddg[1] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-360 day" ) );
            $ddg[2] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-725 day" ) );
            $ddg[3] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1090 day" ) );
            $ddg[4] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1455 day" ) );
            $ddg[5] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1820 day" ) );
            $ddg[6]= date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2185 day" ) );
            $ddg[7] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2550 day" ) );
            $ddg[8] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2915 day" ) );
            $ddg[9]= date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-3280 day" ) );
            $ddg[10] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-3645 day" ) );
            $ddg[11] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-4010 day" ) );
            $ddg[12] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-4375 day" ) );
            $ddg[13] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-4740 day" ) );
            $ddg[14] = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-5105 day" ) );
            $model=$model->where(function ($query) use ($ddg) {
                $query->where('register_at', $ddg[1])
                    ->orWhere('register_at', $ddg[2])
                    ->orWhere('register_at', $ddg[3])
                    ->orWhere('register_at', $ddg[4])
                    ->orWhere('register_at', $ddg[5])
                    ->orWhere('register_at', $ddg[6])
                    ->orWhere('register_at', $ddg[7])
                    ->orWhere('register_at', $ddg[8])
                    ->orWhere('register_at', $ddg[9])
                    ->orWhere('register_at', $ddg[10])
                    ->orWhere('register_at', $ddg[11])
                    ->orWhere('register_at', $ddg[12])
                    ->orWhere('register_at', $ddg[13])
                    ->orWhere('register_at', $ddg[14]);
            });
        }
        if($request->expert)
        {
            $model=$model->whereHas('ContractUsers', function ($q) use($request) {
                $q->where('expert_id', $request->expert);
            });
        }
        if($request->estate_phone)
        {
            $model=$model->where('estate_phone','like', '%'.$request->estate_phone.'%');
        }
        if($request->customer_nationalId)
        {
            $model=$model->where('customer_nationalId','like', '%'.$request->customer_nationalId.'%');
        }
        if($request->customer_name)
        {
            $model=$model->where('customer_name','like', '%'.$request->customer_name.'%');
        }
        if($request->customer_phone)
        {
            $model=$model->where('customer_phone','like', '%'.$request->customer_phone.'%');
        }
        if($request->estate_type)
        {
            $model=$model->where('estate_type',$request->estate_type);
        }
        if($request->type)
        {
            $model=$model->where('type',$request->type);
        }
        if($request->estate_address)
        {
            $model=$model->where('estate_address','like', '%'.$request->estate_address.'%');
        }
        //dd(getQuery($model));
        $totalCount = $model->count();
        $model = $model->paginate(10);
        if ($request->ajax() && $model->count() > 0) {
            $couter=$totalCount/10;
            $counter1= round($couter);
            if($counter1>=$couter) $couter=$counter1;
            else $couter=$counter1+1;
            $hasPage = ($couter==$request->page)? false : true;
            $view = view('frontend.contract.indexlist', compact('model'))->render();
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        return view('frontend.contract.index', compact('model','users'));
    }
    function reminder()
    {
        $ddg1 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-360 day" ) );
        $ddg2 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-725 day" ) );
        $ddg3 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1090 day" ) );
        $ddg4 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1455 day" ) );
        $ddg5 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1820 day" ) );
        $ddg6= date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2185 day" ) );
        $ddg7 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2550 day" ) );
        $ddg8 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-2915 day" ) );
        $ddg9 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-3280 day" ) );
        $ddg10 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-3645 day" ) );
        $ddg11 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-4010 day" ) );
        $ddg12 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-4375 day" ) );
        $ddg13 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-4740 day" ) );
        $ddg14 = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-5105 day" ) );
        $listContracts = DB::select("select * from `contracts` where  `deleted_at` is null and
        (
            `register_at` =  '".$ddg1."'  or
            `register_at` =  '".$ddg2."'  or
            `register_at` =  '".$ddg3."'  or
            `register_at` =  '".$ddg4."'  or
            `register_at` =  '".$ddg5."'  or
            `register_at` =  '".$ddg6."'  or
            `register_at` =  '".$ddg7."'  or
            `register_at` =  '".$ddg8."'  or
            `register_at` =  '".$ddg9."'  or
            `register_at` =  '".$ddg10."'  or
            `register_at` =  '".$ddg11."'  or
            `register_at` =  '".$ddg12."'  or
            `register_at` =  '".$ddg13."'  or
            `register_at` =  '".$ddg14."'
        )
        ");
        foreach($listContracts as $contract)
        {
            if($contract->type == 2)
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
    }
    public function show( $id ) {
        $user = Auth::user();
        $model = Contract::with([
            'city:id,name',
            'user:id,name,username',
            'branch',
            'contractUsers',
            'contractUsers.expert:id,name,username',
            'histories',
            'earnings.user',
            'earnings.role',
        ])->find($id);
//        dd($user->id != $model->user_id,
//            $user->isAdmin() == false,
//            !$user->hasAnyRole('admin_super|admin_branch|admin_financial')
//        );
        if ($user->id != $model->user_id && !$user->hasAnyRole('admin_super|admin_financial')) {
            return back()->withErrors(['شما مجوز دسترسی به این بخش را ندارید!']);
        }
        $userSumCommission = ContractEarning::with('user:id,code,name,username')
            ->where('contract_id', $model->id)
            ->groupBy('user_id')
            ->selectRaw('sum(commission_amount) as sum_commission, user_id')
            ->get();
        $agentSellerCommission = $agentBuyerCommission = 0;
        /*if($model->meeting){
            // agent commissions (sum)
            $agentSumCommission = ContractEarning::with('user:id,code,name,username')
                ->where('contract_id', $model->id)
                ->where('role_id', 9)
                ->sum('commission_amount');
            // get meeting commission percent
            $sellerCommission = $model->meeting->percent_commission ?? 0;
            // calc seller commission
            $agentSellerCommission = $sellerCommission > 0 ? ($sellerCommission / 100) * $agentSumCommission : 0;
            // calc buyer commission
            $agentBuyerCommission = $agentSumCommission - $agentSellerCommission;
        }*/
        return view('frontend.contract.show', compact(
            'model',
            'userSumCommission',
            //'sellerCommission',
            //'agentSellerCommission',
            //'agentBuyerCommission'
        ));
	}
}
