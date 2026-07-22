<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
//use App\Models\Sms;
use App\Models\User;
use App\Models\Sms;
use App\Models\IpLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;


class SmsController extends Controller
{
    public function __construct()
    {
        /*$this->model = new Sms();
        $this->route = 'sms';
        $this->viewPath = 'sms';
        $this->middleware('role:admin_super', [
            'except' => [
                'index'
            ]
        ]);*/
    }


    public function add(Request $request){
        if($_REQUEST['from'] && $_REQUEST['text'])
        {
            $fa = array('۰','۱','۶','۸','٠','١','۲','۳','۴','۵','٦','۷','٨','۹','‏','‏');
            $en = array('0','1','6','8','0','1','2','3','4','5','6','7','8','9','','');
            $_REQUEST['text'] = str_replace($fa,$en,$_REQUEST['text']);

            $input["type"] = 2;
            $input["text"] = $_REQUEST['text'];
            $input["mobile"] = $_REQUEST['from'];
            $input["udh"] = '';
            Sms::create($input);

            if(preg_match('/([0-9]{1,}\.[0-9]{1,}\.[0-9]{1,}\.[0-9]{1,})/',trim($_REQUEST['text']),$reg))
            {
                $expire_date = date("Y-m-d H:i:s", strtotime( date( "Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") ) ) . "+30 minute" ) );
                $user = User::whereHas('roles', function ($q) {
                    $q->where('role_id', 9);
                })->with([
                    'roles',
                    'estates' => function ($q) {
                        $q->where('visibility',1)->orderBy('id', 'desc');
                    }])
                    ->where('has_role', 1)
                    ->where('status', '1')
                    ->where('active', 1)
                    ->where('username', $_REQUEST['from'])
                    ->first();

                if($user != null){

                    IpLogin::where('user_id' , $user->id)->delete();

                    IpLogin::create( [
                        'ip' => $reg[1],
                        'expire_date' => $expire_date,
                        'user_id' => $user->id
                    ] );
                }
                //$ths->UpdateIP(trim($reg[1]),$_REQUEST[from]);

            }
        }
    }
    public function smsList(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            // datetime
            $dt = Carbon::now();
            $sms = Sms::orderBy('id', 'desc');
            $sms = $sms->paginate(20);;
            return view('frontend.profile.sms', compact('sms'));
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function smsListShow(Request $request)
    {
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        $smss = Sms::orderBy('id', 'desc');
        if(!empty($request->mobile))
        {
            $smss = $smss->where('mobile',$request->mobile);
        }
        if (!empty($request->text))
        {
            $smss = $smss->where('text', $request->text);
        }
        if (!empty($request->type))
        {
            $smss = $smss->where('type', $request->type);
        }
        $totalCount = $smss->count();
        $smss = $smss->paginate(20);
        $couter=$totalCount/20;
        $couter=(int)$couter;
        $hasPage = ($couter==$request->page)? false : true;
        $view = view('frontend.profile.sms_show', compact('smss','totalCount'))->render();
        return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
    }
}
