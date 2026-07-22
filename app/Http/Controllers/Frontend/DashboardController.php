<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Estate;
use App\Models\Branch;
use App\Models\RelationEstateCustomer;
use App\Models\EstateOperation;
use App\Models\Post;
use App\Models\CustomerFavorite;
use App\Models\CustomerNote;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;
use App\Models\Feature;
use App\Models\FeatureValue;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class DashboardController extends Controller
{
    public function PerformanceVisitUpdate(Request $request)
    {

    }
    public function PerformanceCreate(Request $request)
    {

    }

    public function index(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $inputs = $request->all();

        $user=Auth::user();

        if(!$user)
        {
            return redirect("/login");
        }
        $customers = [];
        $featureValues = Cache::remember('featureValuesDashboard', 1000, function (){
            return FeatureValue::get();
        });
        $estate_count = Cache::remember('estate_countDashboard'.$user->id, 1000, function () use ($user){
            //ملک های سپرده شده
            $estate_count=Estate::where('confirmation','verified')->where('visibility',1);
            if(!$user->isAdmin())
            {
                $estate_count = $estate_count->where('user_id', $user->id);
            }
            return $estate_count->count();
        });

        $countEstatesNow = Cache::remember('countEstatesNowDashboard', 1000, function (){
            return Estate::where('confirmation','verified')->where('visibility',1)->whereDate('created_at', '>=', Carbon::today())->count();
        });
        $countEstatesExpire = null;
        if(ss('SITE_ID') == 3)
        {
            $countEstatesExpire = Cache::remember('countEstatesExpireDashboard'.$user->id, 1000, function () use($user)
            {
                $estates=Estate::where('confirmation','verified')->where('visibility',1);
                if ($user->isAdmin()) {
                    // همه ملک‌ها را می‌بیند بجز ملک‌هایی که expert_id دارند و 30 روز از showdate آن‌ها گذشته است
                    $estates = $estates->where(function($query) {
                        $query->orWhere('showdate', '<', now()->subDays(30));
                    });
                }
                elseif ($user->isExpert()) {
                    // ملک‌هایی که showdate آن‌ها قبل از ۳۰ روز است
                    // و همچنین ملک‌هایی که بیشتر از ۳۰ روز گذشته ولی expert_id برابر با شناسه کاربر است
                    $estates = $estates->where('expert_id', $user->id)
                                    ->where('showdate', '<', now()->subDays(30));
                    $estates = $estates->where(function ($query) use ($user) {
                        $query->where('expiretime_expert', '>' , date('Y-m-d H:i:s'))
                            ->orWhereNull('expiretime_expert');
                    });
                }
                return $estates->count();
            });
        }
        $user_customers_count = Cache::remember('user_customers_countDashboard_'.$user->id, 1000, function () use ($user){
            //خریدار ثبت کرده
            $user_customers_count= Customer::where('status',1);
            if(!$user->isAdmin())
            {
                $user_customers_count = $user_customers_count->where('user_id', $user->id);
            }
            return $user_customers_count->count();
        });
        if($user->isAdmin())
        {
            unset($reports);
            $profileController = new ProfileController();
            $request->type = 'ralation';
            $request->datefrom = '';
            $request->dateto = '';
            $request->datefromExpire = '';
            $request->datetoExpire = '';
            $reports = Cache::remember('reportsDashboardralation', 1000, function () use($profileController , $request){
                return $profileController->reportRelation(false , $request);
            });
            //dd($reports);
        }
        if(!$user->isAdmin() || ss('SITE_ID') == 3)
        {
            $customers = Cache::remember('customersDashboard'.$user->id, 1000, function () use ($user){
                $customers = Customer::where('status',1)/*->where('request_type',1)*/;
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
                    $customers = $customers->where('status' , '1')->whereRaw("
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
                    $customers = $customers->where('status' , '1')->whereRaw("
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
                if(!$user->isAdmin())
                {
                    $customers = $customers->where('user_id', $user->id);
                }
                //dd(getQuery($customers));

                return $customers->orderBy('label', 'asc')->orderBy('id', 'desc')->paginate(150);
            });
            $customerids = [];
            foreach($customers as $customer)
            {
                $customerids[] = $customer->id;
            }

            foreach($customerids as $customerid)
            {
                $reports[$customerid]['sum'] = 0;
                $reports[$customerid][0] = 0;
                $reports[$customerid][1] = 0;
                $reports[$customerid][2] = 0;
                $reports[$customerid][3] = 0;
                $reports[$customerid]['customer'] = 0;
            }
            $reports[] = '';
            if(is_array($customerids) && count($customerids)>0)
            {
                //$reports = Cache::remember('reportsDashboards', 1000, function () use ($customerids){
                    $query = "";
                    $query = "SELECT `customer_id`,`status`,count(*) as `count` FROM `relation_estate_customer` where `deleted_at` is null ";
                    $query .= " and `customer_id` in (".implode(',' , $customerids).")";
                    if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                    {
                        $query .= " and priority = 1 ";
                    }
                    $query .= " group by `customer_id`,`status`
                    ";
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
                        }
                    }
                //    return $reports;
                //});
            }
        }


        //کارشناس یا شعبه جذب
        //$user_parent_count=User::where('parent_id', $user->id)->where('active', 1)->where('status', '1')->count();
        $today = $date_from = Carbon::today();
        $v = new Verta();
        $startMonth = $v->startMonth();
        $v = new Verta();
        $endMonth = $v->endMonth();
        $from = $startMonth->formatGregorian('Y-m-d H:i:s');
        $to = $endMonth->formatGregorian('Y-m-d H:i:s');
        $visit = 0;
        $visit_max = 0;
        $estate_count_max = 0;
        $user_customers_count_max = 0;
        $monthEarning=0;
        $jalali = gregorian_to_jalali(date('Y'),date('m'),date('d'),'-');
        $lalalilist = explode('-' , $jalali);
        $profileController = new ProfileController();
        $request->type = 'total';
        $type = app('request')->input('type');
        $datefrom = '';
        $dateto = '';
        $datefromExpire = '';
        $datetoExpire = '';
        if(ss('SITE_ID') == 3)
        {
            if(array_key_exists('ajax' , $inputs) && $inputs['ajax'] == 1)
            {
                if(array_key_exists('datefrom' , $inputs))
                {
                    $request->datefrom = $inputs['datefrom'];
                }
                if(array_key_exists('dateto' , $inputs))
                {
                    $request->dateto = $inputs['dateto'];
                }
            }
            elseif(array_key_exists('ajaxExpire' , $inputs) && $inputs['ajaxExpire'] == 1)
            {
                if(array_key_exists('datefromExpire' , $inputs))
                {
                    $request->datefromExpire = $inputs['datefromExpire'];
                }
                if(array_key_exists('datetoExpire' , $inputs))
                {
                    $request->datetoExpire = $inputs['datetoExpire'];
                }
            }
            else
            {
                $yesterday = Carbon::yesterday();
                $df = $yesterday->format('Y-m-d');
                $dflist = explode('-' , $df);
                $jalali = gregorian_to_jalali($dflist[0] , $dflist[1] , $dflist[2],'-');
                $datefromExpire = explode('-' , $jalali);
                $request->datefrom = $lalalilist[0] . '/' . $lalalilist[1] . '/1';
                $request->datefromExpire = $datefromExpire[0] . '/' . $datefromExpire[1] . '/' . $datefromExpire[2];
                $request->dateto = $lalalilist[0] . '/' . $lalalilist[1] . '/' . $lalalilist[2];
                $request->datetoExpire = $lalalilist[0] . '/' . $lalalilist[1] . '/' . $lalalilist[2];
            }
            $datefrom = $request->datefrom;
            $dateto = $request->dateto;

            $datefromExpire = $request->datefromExpire;
            $datetoExpire = $request->datetoExpire;

        }
        else
        {
            $dateY = date("Y", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-30 day" ) );
            $dateM = date("m", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-30 day" ) );
            $dateD = date("d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-30 day" ) );

            $jalalifrom = gregorian_to_jalali($dateY , $dateM , $dateD , '-');
            $jalalifromlist = explode('-' , $jalalifrom);
            if(env('COUNTRY') != 'UAE')
            {
                $request->datefrom = $jalalifromlist[0] . '/' . $jalalifromlist[1] . '/' . $jalalifromlist[2];
                $request->dateto = $lalalilist[0] . '/' . $lalalilist[1] . '/' . $lalalilist[2];
            }
            else
            {
                $request->datefrom = $dateY.'-'.$dateM.'-'.$dateD;
                $request->dateto = date('Y').'-'.date('m').'-'.date('d');

            }
        }

        $reportShow = Cache::remember('reportShowDashboard'.$datefrom.$dateto, 1, function () use ($profileController , $request)
        {
            if(ss('SITE_ID') == 3)
            {
                $request->income = 2;
            }
            $reportShow = $profileController->reportShow($request , false);
            if(isset($reportShow))
            {
                foreach($reportShow['search'] as $key=>$val)
                {
                    $user2 = User::where('id', $key)->first();
                    $reportShow['pic'][$key] = $user2->photo();
                    $reportShow['branch'][$key] = $user2->branch != null ? $user2->branch->name : '';
                    $reportShow['branchid'][$key] = $user2->branch != null ? $user2->branch->id : '';
                }
            }

            return $reportShow;
        });

        $reportShow3 = null;
        $reportShow4 = null;
        $reportExpire = null;
        if(ss('SITE_ID') == 3)
        {
            $reportShow3 = Cache::remember('reportShow3Dashboard'.$datefrom.$dateto, 1, function () use ($profileController , $request , $reportShow){
                $request->income = 1;
                $reportShow3 = $profileController->reportShow($request , false);

                // بررسی مقداردهی اولیه
                if (!isset($reportShow3["searchRnk"]) || !is_array($reportShow3["searchRnk"])) {
                    $reportShow3["searchRnk"] = []; // مقدار پیش‌فرض
                }

                $va = 0;
                $_ = [];
                foreach($reportShow3["searchRnk"] as $key=>$val) {
                    $_[$val][] = $key;
                }

                $count = 0;
                foreach($_ as $key=>$val) {
                    unset($__);
                    foreach($val as $v) {
                        if (!isset($reportShow["searchRnk"][$v])) {
                            continue; // اگر مقدار وجود ندارد، رد شود
                        }
                        $__[$v] = $reportShow["searchRnk"][$v];
                    }
                    asort($__);
                    foreach($__ as $a=>$b) {
                        $reportShow3["searchRnk2"][$a] = ++$count;
                    }
                }

                return $reportShow3;
            });


            $branches = Branch::get();
            foreach($branches as $branch)
            {
                $reportShow4['branch'][$branch->id] = $branch->name;
                $reportShow4['count'][$branch->id] = 0;
                $reportShow4['sum'][$branch->id] = 0;
                $reportShow4['avg'][$branch->id] = 0;
            }

            if (!empty($reportShow["branchid"]) && is_array($reportShow["branchid"]))
            {
                foreach ($reportShow["branchid"] as $key => $val) {
                    if (!isset($val)) {
                        continue; // اگر مقدار `null` بود، از این مقدار رد شود
                    }

                    if (!isset($reportShow4['count'][$val])) {
                        $reportShow4['count'][$val] = 0;
                    }

                    $reportShow4['count'][$val] += 1;
                }
            }

            if (isset($reportShow3['search']) && is_array($reportShow3['search'])) {
                foreach ($reportShow3['search'] as $key => $val) {
                    if (!isset($reportShow['branchid'][$key])) {
                        continue; // اگر مقدار branchid نامعتبر است، از این مقدار رد شود
                    }

                    if (!isset($reportShow4['sum'][$reportShow['branchid'][$key]])) {
                        $reportShow4['sum'][$reportShow['branchid'][$key]] = 0; // مقداردهی اولیه
                    }

                    $reportShow4['sum'][$reportShow['branchid'][$key]] += $val;
                }
            }
            foreach ($reportShow4['sum'] as $key => $val) {
                // اگر مقدار count نامعتبر باشد یا صفر باشد، از تقسیم جلوگیری شود
                if (!isset($reportShow4['count'][$key]) || $reportShow4['count'][$key] == 0) {
                    $reportShow4['avg'][$key] = 0; // مقدار پیش‌فرض
                    continue;
                }

                $reportShow4['avg'][$key] = $val / $reportShow4['count'][$key];
            }

            arsort($reportShow4['avg']);
            foreach($reportShow4['avg'] as $key=>$val)
            {
                $reportShow4['branchname'][$key] = $reportShow4['branch'][$key];
            }

            $reportExpire = Cache::remember('reportExpire' . $datefromExpire . $datetoExpire, 1, function () use ($request)
            {
                $usersE = User::with('roles')
                    ->where('has_role', 1)
                    ->whereIn('status', ['1'])
                    ->get();

                // لیست آی‌دی کاربران
                $u = $usersE->pluck('id')->toArray();

                // ساخت query دستی برای گرفتن تعداد ویرایش ملک توسط هر کاربر
                $queryEdit = "SELECT `user_id` as `expert_id`, count(DISTINCT estate_id) as `count`
                            FROM `estate_edits`
                            WHERE user_id IN (" . implode(',', $u) . ")";

                if ($request->datefromExpire != '') {
                    $datefrom = explode('/', $request->datefromExpire);
                    $queryEdit .= " AND `created_at` >= '" . jalali_to_gregorian($datefrom[0], $datefrom[1], $datefrom[2], '-') . " 00:00:00'";
                }

                if ($request->datetoExpire != '') {
                    $dateto = explode('/', $request->datetoExpire);
                    $queryEdit .= " AND `created_at` <= '" . jalali_to_gregorian($dateto[0], $dateto[1], $dateto[2], '-') . " 23:59:59'";
                }

                $queryEdit .= " GROUP BY `user_id`";

                // اجرای query با DB::select
                $edits = DB::select($queryEdit);

                // تبدیل نتایج به آرایه کلید=>مقدار برای دسترسی سریع
                $editMap = collect($edits)->mapWithKeys(fn($row) => [$row->expert_id => $row->count]);

                $result = [];

                foreach ($usersE as $usere) {

                    $estates = Estate::where('confirmation', 'verified')
                        ->where('visibility', 1);

                    if ($usere->isAdmin()) {
                        $estates = $estates->where(function ($query) {
                            $query->where('showdate', '<', now()->subDays(30));
                        });
                    } elseif ($usere->isExpert()) {
                        $estates = $estates->where('expert_id', $usere->id)
                            ->where('showdate', '<', now()->subDays(30))
                            ->where(function ($query) {
                                $query->where('expiretime_expert', '>', now())
                                    ->orWhereNull('expiretime_expert');
                            });
                    }

                    $count = $estates->count();
                    $editCount = $editMap[$usere->id] ?? 0;

                    $result[] = [
                        'userid'     => $usere->id,
                        'fullname'  => $usere->fullname(),
                        'count'      => $count,
                        'editCount'  => $editCount,
                    ];
                }

                return $result;
            });
            //dd($reportExpire);
        }
        $reportShow2 = null;
        if(ss('SITE_ID') == 3 && $user->branch_id > 0)
        {
            $request->user_id = -1 * $user->branch_id;
            $reportShow2 = Cache::remember('reportShow2Dashboard'.$user->branch_id, 1, function () use ($profileController , $request){
                $reportShow2 = $profileController->reportShow($request , false);
                if(is_array($reportShow2))
                {
                    foreach($reportShow2['search'] as $key=>$val)
                    {
                        $user2 = User::where('id', $key)->first();
                        $reportShow2['pic'][$key] = $user2->photo();
                    }
                }
                return $reportShow2;
            });
        }
        // if (env('COUNTRY') == 'UAE')
        // {
        //     $reportShow2 = $profileController->reportShow($request , false);
        //     if(is_array($reportShow2))
        //     {
        //         foreach($reportShow2['search'] as $key=>$val)
        //         {
        //             $user2 = User::where('id', $key)->first();
        //             $reportShow2['pic'][$key] = $user2->photo();
        //         }
        //     }
        // }

        $request->user_id = $user->id;
        //$rep = Cache::remember('repDashboard', 1000, function () use ($profileController , $request){
            $rep = $profileController->reportShow($request , false);
        //});
        if(isset($rep))
        {
            $reportSearchCount = $rep['reportSearchCount'];
            $reportViewhouseCount = $rep['reportViewhouseCount'];
            $reportUpdateHousingCount = $rep['reportUpdateHousingCount'];
            $reportHousingCount = $rep['reportHousingCount'];
            $report360DegCount = $rep['report360DegCount'];
            $reportTotalcustomerCount =  $rep['reportTotalcustomerCount'];
            $reportTimeCount = $rep['reportTimeCount'];
            $reportLadderCount =  $rep['reportLadderCount'];
            $reportAdvertismentCount = $rep['reportAdvertismentCount'];
            $reportVisitCount = $rep['reportVisitCount'];
            $reportMastersCount = $rep['reportMastersCount'];
            $reportContractBuyCount = $rep['reportBuyContractCount'];
            $reportContractRentCount = $rep['reportRentContractCount'];
            $reportContractCommonBuyCount = $rep['reportCommonBuyContractCount'];
            $reportContractCommonRentCount = $rep['reportCommonRentContractCount'];
            $reportContractUnsuccessCount = $rep['reportUnsuccessContractCount'];
            $reportIncomeCount = $rep['reportIncomeCount'];
        }
        else
        {
            $reportSearchCount = 0;
            $reportViewhouseCount = 0;
            $reportUpdateHousingCount = 0;
            $reportHousingCount = 0;
            $report360DegCount = 0;
            $reportTotalcustomerCount =  0;
            $reportTimeCount = 0;
            $reportLadderCount = 0;
            $reportAdvertismentCount = 0;
            $reportVisitCount = 0;
            $reportMastersCount = 0;
            $reportContractBuyCount = 0;
            $reportContractRentCount = 0;
            $reportContractCommonBuyCount = 0;
            $reportContractCommonRentCount = 0;
            $reportContractUnsuccessCount = 0;
            $reportIncomeCount = 0;
            $reportContractCount = 0;
        }

        $specialCustomers = [];
        $specialEstates = [];
        $dailyquote = null;
        $announcements = null;
        if(ss('SITE_ID') == 3)
        {
            if(array_key_exists('ajax' , $inputs) && $inputs['ajax'] == 1)
            {
                $view = view(ss('THEME').'.frontend.dashboard_type',['reportShow4'=>$reportShow4 , 'reportShow3'=>$reportShow3 , 'reportShow'=>$reportShow, 'reportShow2'=>$reportShow2])->render();
                return response()->json(['html' => $view]);
            }
            if(array_key_exists('ajaxExpire' , $inputs) && $inputs['ajaxExpire'] == 1)
            {
                $view = view(ss('THEME').'.frontend.dashboard_expire_type',['reportExpire'=>$reportExpire])->render();
                return response()->json(['html' => $view]);
            }
            if($user->branch_id>0)
            {
                $userlists = User::where('branch_id', $user->branch_id)->get();
                foreach($userlists as $user)
                {
                    $_user[] = $user->id;
                }
                $ddg = date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-7 day" ) );

                $specialCustomers = EstateOperation::where('type' , 13)->where('created_at' ,'>=', $ddg)->whereIn('expert_id' , $_user)->orderBy('id', 'desc')->get();
                $specialEstates = EstateOperation::where('type' , 6)->where('created_at' ,'>=', $ddg)->whereIn('expert_id' , $_user)->orderBy('id', 'desc')->get();
                switch($user->branch_id)
                {
                    case 19: //جمهوری
                        $announcements = Post::where('category_id' , 5)->orderBy('id', 'desc')->first();
                        $dailyquote = Post::where('category_id' , 2)->orderBy('id', 'desc')->first();
                        break;
                    case 18: //سلمان
                        $announcements = Post::where('category_id' , 6)->orderBy('id', 'desc')->first();
                        $dailyquote = Post::where('category_id' , 7)->orderBy('id', 'desc')->first();
                        break;
                    case 37: //صدوقی
                        $announcements = Post::where('category_id' , 12)->orderBy('id', 'desc')->first();
                        $dailyquote = Post::where('category_id' , 11)->orderBy('id', 'desc')->first();
                        break;
                    case 38: //زمرد
                        $announcements = Post::where('category_id' , 14)->orderBy('id', 'desc')->first();
                        $dailyquote = Post::where('category_id' , 13)->orderBy('id', 'desc')->first();
                        break;
                }

                if($announcements != null && $announcements->expire_at != null && $announcements->expire_at<date('Y-m-d H:i:s'))
                {
                    $announcements = null;
                }
                if($dailyquote != null && $dailyquote->expire_at != null && $dailyquote->expire_at<date('Y-m-d H:i:s'))
                {
                    $dailyquote = null;
                }
            }
        }
        if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
        {
            $specialCustomers= Customer::where('status',8);
            if(!$user->isAdmin())
            {
                $specialCustomers = $specialCustomers->where('user_id', $user->id);
            }
            $specialCustomers = $specialCustomers->orderBy('id', 'desc')->paginate(100);
        }
        if(isset($rep))
        {
            $reportContractCount = $reportContractBuyCount + $reportContractRentCount + $reportContractCommonBuyCount + $reportContractCommonRentCount;
        }

        return view(ss('THEME').'.frontend.dashboard',compact(
            'datefrom','dateto','datefromExpire','datetoExpire',
            'reportExpire',
            'visit',
            'visit_max',
            'estate_count_max',
            'user_customers_count_max',
            'featureValues',
            'estate_count',
            'user_customers_count',
            'countEstatesNow',
            'countEstatesExpire',
            'customers','specialCustomers',
            'specialEstates',
            'dailyquote',
            'announcements',
            /*'estates',*/
            'reportContractBuyCount','reportContractRentCount','reportContractCommonBuyCount','reportContractCommonRentCount','reportContractUnsuccessCount',
            'reportShow','reportShow2','reportShow3','reportShow4',
            'reportSearchCount','reportViewhouseCount','reportUpdateHousingCount','reportHousingCount','report360DegCount','reportTotalcustomerCount',
            'reportTimeCount','reportLadderCount','reportAdvertismentCount','reportVisitCount','reportMastersCount','reportContractCount','reportIncomeCount'
            ,'reports'
        ));
    }
}
?>
