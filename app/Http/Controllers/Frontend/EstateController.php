<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Agents;
use App\Models\AgentDistrict;
use App\Models\City;
use App\Models\District;
use App\Models\Street;
use App\Models\Customer;
use App\Models\Estate;
use App\Models\EstateFavorite;
use App\Models\EstateOperation;
use App\Models\EstateCompare;
use App\Models\RelationEstateCustomer;
use App\Models\EstateNote;
use App\Models\EstateReport;
use App\Models\EstateVisit;
use App\Models\EstateEdit;
use App\Models\EstateUserVisit;
use App\Models\EstateAppraisal;
use App\Models\Feature;
use App\Models\FeatureValue;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\Picture;
use App\Models\Setting;
use App\Models\SearchKeyword;
use App\Models\User;
use App\Models\UserSearch;
use App\Models\Project;
use App\Models\Manufacturer;
use App\Models\Brand;
use App\Models\Comment;
use Carbon\Carbon;
use Hamcrest\Type\IsInteger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use DOMDocument;
use DOMXPath;
use SimpleXMLElement;
use Illuminate\Support\Facades\Config;

class EstateController extends Controller
{
    public function listbayut()
    {
        set_time_limit(0);
        $url = "https://www.bayut.com/for-sale/property/uae/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;
        exit;
        $pattern = '/https:\/\/www\.bayut\.com\/property\/details-(\d+)\.html/';

        preg_match_all($pattern, $text, $matches);

        $details = $matches[1] ?? []; // آرایه‌ای از مقادیر details
        //dd($details);
        foreach($details as $id)
        {
            $district = Estate::where('divar', 'details-'.$id)->first();
            if (!$district) {
                $this->bayut($id);
            }

        }
    }

    public function bayut($url)
    {
        // دریافت محتوای HTML صفحه
        $html = file_get_contents('https://gilandmelk.com/1.php?url=https://www.bayut.com/property/details-'.$url.'.html');

        if (!$html) {
            throw new \Exception("Unable to fetch content from the URL.");
        }

        // بارگذاری HTML در DOMDocument
        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        // استفاده از XPath برای استخراج اطلاعات
        $xpath = new DOMXPath($dom);
        //dd($xpath->query("//span[@aria-label='Property header']"));
        // استخراج قیمت بر اساس aria-label="Price"
        $price = $xpath->query("//span[@aria-label='Price']")->item(0)->nodeValue ?? "N/A";
        $title = $xpath->query("//h1")->item(0)->nodeValue ?? "N/A";
        $beds =  $xpath->query("//span[@aria-label='Beds']")->item(0)->nodeValue ?? "N/A";
        $baths =  $xpath->query("//span[@aria-label='Baths']")->item(0)->nodeValue ?? "N/A";

        // استخراج مساحت بر اساس aria-label="Area"
        $area = $xpath->query("//span[@aria-label='Area']")->item(0)->nodeValue ?? "N/A";

        $type = $xpath->query("//span[@aria-label='Type']")->item(0)->nodeValue ?? "N/A";
        $Purpose = $xpath->query("//span[@aria-label='Purpose']")->item(0)->nodeValue ?? "N/A";
        $Completion = $xpath->query("//span[@aria-label='Completion status']")->item(0)->nodeValue ?? "N/A";
        $Furnishing = $xpath->query("//span[@aria-label='Furnishing']")->item(0)->nodeValue ?? "N/A";


        // استخراج مکان: اصلاح مسیر برای مکان
        $location = $xpath->query("//div[@aria-label='Property header']")->item(0)->nodeValue ?? "N/A";
        $loc = explode(',' , $location);
        $city = trim($loc[count($loc) - 1]);
        $district = trim($loc[count($loc) - 2]);
        $address = trim($loc[count($loc) - 3]);
        // استخراج امکانات بر اساس aria-label="Features"
        $featuresNodes = $xpath->query("//ul[@aria-label='Features']/li");
        $features = [];
        foreach ($featuresNodes as $feature) {
            $features[] = trim($feature->nodeValue);
        }

        // استخراج توضیحات: اصلاح مسیر برای توضیحات
        $description = $xpath->query("//div[@aria-label='Property description']")->item(0)->nodeValue ?? "N/A";

        // ساخت XML
        $xml = new SimpleXMLElement('<Property/>');
        $xml->addChild('Description', trim(htmlspecialchars($description)));
        $xml->addChild('Price', trim($price));
        $xml->addChild('Area', trim($area));
        $xml->addChild('Location', trim($location));
        $xml->addChild('Type', trim($type));
        $xml->addChild('Purpose', trim($Purpose));
        $xml->addChild('Completion', trim($Completion));
        $xml->addChild('Furnishing', trim($Furnishing));
        $xml->addChild('Title', trim(htmlspecialchars($title)));
        $xml->addChild('Beds', trim(strip_tags($beds)));
        $xml->addChild('Baths', trim(strip_tags($baths)));
        if (strpos($html, 'Off-Plan') !== false) {
            $xml->addChild('OffPlan', 1);
        }

        if (strpos($html, 'Balcony or Terrace') !== false) {
            $xml->addChild('BalconyTerrace', 1);
        }
        if (strpos($html, 'Parking Spaces') !== false) {
            $xml->addChild('ParkingSpaces', 1);
        }
        if (strpos($html, 'Centrally Air-Conditioned') !== false) {
            $xml->addChild('CentrallyAirConditioned', 1);
        }
        if (strpos($html, 'Gym or Health Club') !== false) {
            $xml->addChild('GymHealthClub', 1);
        }
        if (strpos($html, 'Swimming Pool') !== false) {
            $xml->addChild('SwimmingPool', 1);
        }

        if (strpos($html, 'Barbeque Area') !== false) {
            $xml->addChild('BarbequeArea', 1);
        }


        if (strpos($html, 'Security Staff') !== false) {
            $xml->addChild('SecurityStaff', 1);
        }
        if (strpos($html, 'Freehold') !== false) {
            $xml->addChild('Freehold', 1);
        }
        if (strpos($html, 'Broadband Internet') !== false) {
            $xml->addChild('BroadbandInternet', 1);
        }
        if (strpos($html, 'Satellite/Cable TV') !== false) {
            $xml->addChild('SatelliteCableTV', 1);
        }
        if (strpos($html, 'Laundry Facility') !== false) {
            $xml->addChild('LaundryFacility', 1);
        }

        if (strpos($html, 'CCTV Security') !== false) {
            $xml->addChild('CCTVSecurity', 1);
        }

        if (strpos($html, 'Elevators in Building') !== false) {
            $xml->addChild('elevator', 1);
        }
        if (strpos($html, 'Parking Spaces') !== false) {
            $xml->addChild('parking', 1);
        }

        if (strpos($html, 'Day Care Center') !== false) {
            $xml->addChild('DayCareCenter', 1);
        }


        if (strpos($html, 'Floor:') !== false) {
            preg_match('/Floor:\s*(\d+)/', $html, $matches);
            if(count($matches) > 0 && $matches[1] != null)
            {
                $xml->addChild('floor', $matches[1]);
            }
        }

        if (strpos($html, 'Waste Disposal') !== false) {
            $xml->addChild('WasteDisposal', 1);
        }
        if (strpos($html, 'Maintenance Staff') !== false) {
            $xml->addChild('MaintenanceStaff', 1);
        }
        if (strpos($html, 'Kids Play Area') !== false) {
            $xml->addChild('KidsPlayArea', 1);
        }

        if (strpos($html, 'Facilities for Disabled') !== false) {
            $xml->addChild('FacilitiesforDisabled', 1);
        }

        if (strpos($html, 'Lobby in Building') !== false) {
            $xml->addChild('LobbyinBuilding', 1);
        }

        if (strpos($html, 'Lawn or Garden') !== false) {
            $xml->addChild('LawnGarden', 1);
        }

        if (strpos($html, 'Cafeteria or Canteen') !== false) {
            $xml->addChild('CafeteriaCanteen', 1);
        }

        if (strpos($html, 'First Aid Medical Center') !== false) {
            $xml->addChild('FirstAidMedicalCenter', 1);
        }

        if (strpos($html, 'Jacuzzi') !== false) {
            $xml->addChild('Jacuzzi', 1);
        }
        if (strpos($html, 'Sauna') !== false) {
            $xml->addChild('Sauna', 1);
        }
        if (strpos($html, 'Steam Room') !== false) {
            $xml->addChild('SteamRoom', 1);
        }
        if (strpos($html, 'Double Glazed Windows') !== false) {
            $xml->addChild('DoubleGlazedWindows', 1);
        }

        if (strpos($html, 'Central Heating') !== false) {
            $xml->addChild('CentralHeating', 1);
        }

        if (strpos($html, 'Electricity Backup') !== false) {
            $xml->addChild('ElectricityBackup', 1);
        }

        if (strpos($html, 'Study Room') !== false) {
            $xml->addChild('StudyRoom', 1);
        }


        $xml->addChild('city', $city);
        $xml->addChild('district', $district);
        $xml->addChild('address', $address);

        // $featuresXml = $xml->addChild('Features');
        // foreach ($features as $feature) {
        //     $featuresXml->addChild('Feature', $feature);
        // }



        // استخراج تصاویر مخصوص ملک
        $imageNodes = $xpath->query("//div[@aria-label='Gallery dialog photo grid']//img");
        $images = [];
        foreach ($imageNodes as $image) {
            // بررسی src یا data-src برای URL تصویر
            $src = $image->getAttribute('src') ?: $image->getAttribute('data-src');
            if ($src) {
                $images[] = $src;
            }
        }
        $imagesXml = $xml->addChild('Images');
        foreach ($images as $image) {
            $imagesXml->addChild('Image', $image);
        }
        //dd($xml);
        $this->bayut2($url , $xml->asXML());
    }
    public function bayut2($url , $val)
    {
        //echo($val);
        //exit;
        $xml = new SimpleXMLElement($val);
        //dd((string)$xml->city);

        $inputs['province_id'] = 1;
        $city = City::where('name', (string)$xml->city)->where('active', 1)->first();
        //dd($city);
        if($city == null)
        {
            return;
        }
        $inputs['city_id'] = $city->id;

        $district = District::where('city_id', $city->id)->where('name', (string)$xml->district)->first();
        if (isset($district)) {
            $inputs['district_id'] = $district->id;

        } else {
            $district = District::create([
                'province_id' => 1,
                'city_id' => $city->id,
                'name' => (string)$xml->district,
                'active' => 1,
                'divar' => 1
            ]);
            $inputs['district_id'] = $district->id;
        }
        $inputs['address'] = (string)$xml->address;
        $inputs['type'] = 1;
        $inputs['published_at'] = date('Y-m-d H:i:s');
        $inputs['showdate'] = date('Y-m-d H:i:s');


        switch ((string)$xml->Type)
        {
            case 'Villa':
                $estate_type = 2;
                break;
            case 'Apartment':
                $estate_type = 1;
                break;
            default:
                $estate_type = -1;
        }
        if($estate_type == -1){
            echo '$estate_type == -1<br>';
            return;
        }
        $inputs['estate_type'] = $estate_type;
        $inputs['description'] = (string)$xml->Description;




        $inputs['area'] =  str_replace(array(' sqft', ','), array('', ''), (string)$xml->Area);
        $inputs['room_count'] =  str_replace(array(' Beds', ',' , 'Studio'), array('', '' , 0), (string)$xml->Beds);
        if(!is_int($inputs['room_count']))
        {
            return;
        }
        $inputs['bath_count'] =  str_replace(array(' Baths',' Bath', ','), array('','', ''), (string)$xml->Baths);
        $inputs['price'] = str_replace(array(','), array(''), (string)$xml->Price);



        if((string)$xml->floor != '')
        {
            $inputs['floor'] = (string)$xml->floor;
        }


        if ((string)$xml->elevator == 1) {
            $_a[] = '"37"';
        }
        if ((string)$xml->parking == 1) {
            $_a[] = '"37"';
        }
        if ((string)$xml->Furnishing == 'Furnished') {
            $_a[] = '"348"';
        }
        if ((string)$xml->BarbequeArea == 1) {
            $_a[] = '"369"';
        }
        if ((string)$xml->DayCareCenter == 1) {
            $_a[] = '"368"';
        }
        if ((string)$xml->KidsPlayArea == 1) {
            $_a[] = '"367"';
        }
        if ((string)$xml->LawnGarden == 1) {
            $_a[] = '"366"';
        }
        if ((string)$xml->CafeteriaCanteen == 1) {
            $_a[] = '"365"';
        }
        if ((string)$xml->FirstAidMedicalCenter == 1) {
            $_a[] = '"364"';
        }
        if ((string)$xml->GymHealthClub == 1) {
            $_a[] = '"363"';
        }
        if ((string)$xml->Sauna == 1) {
            $_a[] = '"361"';
        }
        if ((string)$xml->SteamRoom == 1) {
            $_a[] = '"360"';
        }
        if ((string)$xml->SwimmingPool == 1) {
            $_a[] = '"359"';
        }

        if ((string)$xml->DoubleGlazedWindows == 1) {
            $_a[] = '"358"';
        }
        if ((string)$xml->CentralHeating == 1) {
            $_a[] = '"356"';
        }
        if ((string)$xml->ElectricityBackup == 1) {
            $_a[] = '"355"';
        }
        if ((string)$xml->StudyRoom == 1) {
            $_a[] = '"354"';
        }
        if ((string)$xml->Sauna == 1) {
            $_a[] = '"361"';
        }
        if ((string)$xml->CentrallyAirConditioned == 1) {
            $_a[] = '"357"';
        }

        if ((string)$xml->OffPlan == 1) {
            $inputs['keynot'] = 1;
            $inputs['conditions'] = '[15]';
        }




        if (is_array($_a)) {
            $inputs['facilities'] = '[' . implode(',', $_a) . ']';
        }

        // if ($list->data->title == 'سرمایش کولر آبی') {
        //     $_b[] = '"94"';
        // }
        // if ($list->data->title == 'سرمایش کولر گازی') {
        //     $_b[] = '"92"';
        // }
        // if ($list->data->title == 'گرمایش شوفاژ') {
        //     $_b[] = '"87"';
        // }
        // if ($list->data->title == 'گرمایش بخاری') {
        //     $_b[] = '"86"';
        // }
        // if ($list->data->title == 'آبگرم‌کن') {
        //     $_b[] = '"101"';
        // }
        // if ($list->data->title == 'تأمین‌کننده آب گرم پکیج') {
        //     $_b[] = '"88"';
        // }
        // if ($list->data->title == 'موتورخانه') {
        //     $_b[] = '"95"';
        // }
        // if (is_array($_b)) {
        //     $inputs['heating_cooling'] = '[' . implode(',', $_b) . ']';
        // }


        $inputs['title'] = (string)$xml->Title;
        $inputs['confirmation'] = 'verified';
        $inputs['visibility'] = 1;
        $inputs['divar'] = 'details-'.$url;
        $inputs['last_activity'] = Carbon::now();
        $inputs['token'] = TokenMaker(8);
        $inputs['user_id'] = 1;

        //dd($inputs);
        $estate = Estate::create($inputs);
        $default_image = '';
        foreach ($xml->Images->Image as $image) {
            $__images = $this->storeMedia2('https://gilandmelk.com/1.php?url='.$image , $estate->id);
            if ($default_image == '') {
                $default_image = $__images;
            }
        }
    }
    public function addTowerEstate(Request $request, $id = null)
    {
        $user = Auth::user();
        if((ss('SITE_ID') == 10 || ss('SITE_ID') == 11) && $user != null &&  $user->isExpert())
        {
            Config::set('app.locale' , 'en');
        }
        if ($user == null)
        {
            return redirect('/login');
        }
        $project = Project::find($id);
        if ($project != null)
        {
            if($project->estate_id != null)
            {
                $estateid = $project->estate_id;
                $estate = Estate::find($estateid);
            }
            else
            {
                $defaultCity=$_COOKIE['city'] ?? ss('DEFAULT_CITY');
                $city = City::with(['districts' => function ($q) {
                    $q->orderBy('name', 'asc');
                }])
                    ->where('name_en', $defaultCity)
                    ->where('active', 1)
                    ->first();
                if (!$city) {
                    $city = City::with(['districts' => function ($q) {
                        $q->orderBy('name', 'asc');
                    }])
                    ->where('name_en', ss('DEFAULT_CITY'))
                    ->where('active', 1)
                    ->first();
                }
                $inputs['manufacturer_id'] = $project->manufacturer_id;
                $inputs['project_id'] = $id;
                $inputs['type'] = 3;
                $inputs['divar'] = '';
                $inputs['phone'] = '';
                $inputs['phone2'] = '';
                $inputs['city_id'] = $city->id;
                $inputs['province_id'] = $city->province_id;
                $inputs['confirmation'] = 'pending';

                $estate = Estate::create($inputs);
                Project::where('id' , $project->id)->update(['estate_id' => $estate->id]);
            }


            if($estate != null)
            {
                $city = City::with(['districts' => function ($q) {
                    $q->orderBy('name', 'asc');
                }])
                    ->where('id', $estate->city_id)
                    ->where('active', 1)
                    ->first();
                $cities = City::where('province_id', $estate->province_id)
                    ->where('active', 1)
                    ->get();
                $districts = $city->districts;
                $streets = Street::where('district_id', $estate->district_id)->where('active', 1)->get();
            }
            $defaultImage = '';
            if (count($estate->images) > 0) {
                $defaultImage = $estate->images->where('cover', 1)->first();
                if (!$defaultImage) {
                    $defaultImage = $estate->images->first();
                }
            }
            $projects = null;
            if($estate->manufacturer_id>0)
            {
                $projects = Project::where('manufacturer_id', $estate->manufacturer_id)->get();
            }
            $manufacturers = Manufacturer::get();
            $brands = Brand::get();


            return view('frontend.estate.createTowerEstate', compact(
                'defaultImage',
                'districts',
                'streets',
                'estate',
                'cities',
                'city',

                'manufacturers',
                'projects',
                'brands',
            ));
        }
    }
    public function addnew(Request $request, $id = null)
    {
        $user = Auth::user();
        if((ss('SITE_ID') == 10 || ss('SITE_ID') == 11) && $user != null &&  $user->isExpert())
        {
            Config::set('app.locale' , 'en');
        }
        if ($user == null && env('COUNTRY') != 'UAE') {
            return redirect('/login');
        }
        if (session()->has('referrerUrl')) {
            session()->forget('referrerUrl');
        }
        $defaultCity=$_COOKIE['city'] ?? ss('DEFAULT_CITY');
        //return view('frontend.estate.estateform.index1');
        $city = City::with(['districts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])
            ->where('name_en', $defaultCity)
            ->where('active', 1)
            ->first();
        if (!$city) {
            $city = City::with(['districts' => function ($q) {
                $q->orderBy('name', 'asc');
            }])
            ->where('name_en', ss('DEFAULT_CITY'))
            ->where('active', 1)
            ->first();
        }
        $districts = $city->districts;
        $estate = null;
        $defaultImage = null;
        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 9);
        })->get(['id', 'name','last_name', 'username','status']);
        $manufacturers = null;
        $brands = null;
        if(env('COUNTRY') == 'UAE')
        {
            $manufacturers = Manufacturer::get();
            $brands = Brand::get();
        }
        $tags = '';
        if(ss('SITE_ID') == 2)
        {
            $tags = Tag::get();
        }
        if ($request->has('towerid') && $request->towerid > 0)
        {
            $project = Project::find($request->towerid);
            if($project != null)
            {
                $id = $project->estate_id;
            }
            else
            {
                return redirect('/add');
            }
        }

        if (!empty($id)) {

            $user = Auth::user();
            $userId = $user->id ?? 0;
            $estate = Estate::with([
                'images',
                'expert'
            ])->where('id', $id);

            $estate = $estate->first();
            if($estate != null){
                if(
                    !($estate->user_id == $user->id ||
                    $user->isAdmin() ||
                    $estate->percent_expert == 0 ||
                    ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $user->id == $estate->expert_id) ||
                    ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s')))// && $estate->created_at > date('Y-m-d H:i:s',strtotime("-1 days"))) ||
                    //(($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s'))) && (Auth::user()->id == $estate->shownexpert_id && $estate->shownexpert && $estate->shownexpert->isExpert()))
                    )
                ){
                    return view('frontend.errors.404');
                }
                $city = City::with(['districts' => function ($q) {
                    $q->orderBy('name', 'asc');
                }])
                    ->where('id', $estate->city_id)
                    ->where('active', 1)
                    ->first();
                if (!$city) {
                    $request->session()->put('referrerUrl', $request->getRequestUri());
                    return redirect('/cities');
                }
                $cities = City::where('province_id', $estate->province_id)
                    ->where('active', 1)
                    ->get();
                $districts = $city->districts;
                $streets = Street::where('district_id', $estate->district_id)->where('active', 1)->get();
            }
            if (!$estate) {
                return view('frontend.errors.404');
            }
            $defaultImage = '';
            if (count($estate->images) > 0) {
                $defaultImage = $estate->images->where('cover', 1)->first();
                if (!$defaultImage) {
                    $defaultImage = $estate->images->first();
                }
            }
            $projects = null;
            if($estate->manufacturer_id>0)
            {
                $projects = Project::where('manufacturer_id', $estate->manufacturer_id)->get();
            }
            $parameters = '';

            foreach($_GET as $key=>$val)
            {
                $parameters .= $key.'='.$val.'&';
            }
            $exchange_selected = [];
            if(ss('SITE_ID') == 2)
            {
                $exchange_selected2 = Tag::join('taggables', 'tags.id', '=', 'taggables.tag_id')
                    ->where('taggable_id',$id)->where('taggable_type' , 'exchange_selected')
                    ->select('tags.*')
                    ->get();
                foreach($exchange_selected2 as $t)
                {
                    $exchange_selected[] = $t->id;
                }
            }

            return view(((ss('SITE_ID') == 10 || ss('SITE_ID') == 7 || ss('SITE_ID') == 11)?'site'.ss('SITE_ID').'.':'').'frontend.estate.create', compact(
                'defaultImage',
                'districts',
                'streets',
                'estate',
                'cities',
                'city',
                'users',
                'manufacturers',
                'projects',
                'brands',
                'parameters',
                'tags',
                'exchange_selected'
            ));
        }
        else
        {
            $streets = [];
            $projects = null;
            return view(((ss('SITE_ID') == 10 || ss('SITE_ID') == 7 || ss('SITE_ID') == 11)?'site'.ss('SITE_ID').'.':'').'frontend.estate.create', compact(
                'districts',
                'streets',
                'estate',
                'city',
                'users',
                'manufacturers',
                'projects',
                'brands',
                'tags'
            ));
        }
    }
    public function sitemaplist()
    {
        header("Content-type: text/xml");
        $estatesCount = Cache::remember('sitemaplistCount' , 86400, function (){
            return Estate::where('visibility', 1)
            ->where('confirmation', 'verified')
            ->count();
        });
        return response()->view('frontend.estate.sitemaplist', ['count' => (int)($estatesCount/1000)])->header('Content-Type', 'text/xml');;
    }
    public function sitemap(Request $request, $pagesize = 0)
    {
        header("Content-type: text/xml");
        $estates = Cache::remember('sitemapEstate'.$pagesize , 86400, function () use($pagesize){
            return Estate::where('visibility', 1)
            ->where('confirmation', 'verified')
            ->orderBy('id', 'asc')
            ->skip($pagesize*1000)->take(1000)->get();
        });
        return response()->view('frontend.estate.sitemap', ['estates' => $estates])->header('Content-Type', 'text/xml');;
    }
    public function updateExpireDate()
    {
        if (ss('SITE_ID') == 3) {
            $estates = Estate::whereNotNull('expert_id')
                ->where('showdate', '<', now()->subDays(37))
                ->whereNotNull('divar')
                ->update(['expert_id' => null]);

            return response()->json([
                'message' => 'تاریخ انقضای ملک‌ها بروزرسانی شد.',
                'updated_rows' => $estates
            ]);
        }

        return response()->json([
            'message' => 'سایت فعال با شناسه ۳ نیست، عملیات انجام نشد.'
        ], 403);
    }

    public function index(Request $request, $defaultCity = '')
    {
        $city = null;
        if($defaultCity != '')
        {
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
            $districts = [];
            $districtsId = [];
        } else {
            $districts = $city->districts->pluck('name')->toArray();
            $districtsId = $city->districts->pluck('id')->toArray();
        }
        if ($city) {
            $cities = City::where('province_id', $city->province_id)->where('active', 1)->get();
            foreach ($cities as $city2) {
                $listCities[] = $city2->id;
            }
        } else {
            $cities = collect();
            $listCities = [];
        }
        // set cookie
        $hasPhoto = $hasAgent = false;
        $selectedType = $request->type ?? 1; // sale type
        $selectedEstateType = [0, 1, 2, 3, 4, 5]; // all estate type
        $selectedDistricts = [];
        $price = [0, 0];
        $q = '';
        // start query
        // filter by city and type
        if ($request->mapexists == 1) {
            $estates = Estate::where('province_id', $city->province_id)
                ->where('type', $selectedType)
                ->where('visibility', 1)
                ->where('confirmation', 'verified');
        } else {
            $estates = Estate::with([
                'expert:id,code,name,last_name,username,photo,phone',
                'user:id,code,name,last_name,username,photo,phone'
            ])
            ->where('province_id', $city->province_id)
            ->where('type', $selectedType)
            ->where('visibility', 1)
            ->where('confirmation', 'verified');
        }
        $estates = $estates->where('phone' , '!=' , '09120000000');
        if(ss('SITE_ID') == 3)
        {
            $estates = $estates->where('showdate', '>' ,  date("Y-m-d", strtotime("-1 months")));
        }
        else
        {
            if($selectedType == 1)
            {
                $estates = $estates->where('showdate', '>' ,  date("Y-m-d", strtotime("-8 months")));
            }
            else
            {
                $estates = $estates->where('showdate', '>' ,  date("Y-m-d", strtotime("-4 months")));
            }
        }
        //$estates = $estates->where('showdate', '>' ,  date("Y-m-d", strtotime("-1 years")));
        // filter kind (estate type)
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
        // filter more
        $estates = !empty($request->id) ? $estates->where('id', (int) $request->id) : $estates;
        $estates = !empty($request->estateTypes) ? $estates->whereIn('estate_type', explode(',', $request->estateTypes)) : $estates;
        $estates = !empty($request->request_type) ? $estates->where('request_type', (int) $request->request_type) : $estates;
        $estates = !empty($request->province_id) ? $estates->where('province_id', (int) $request->province_id) : $estates;
        $estates = !empty($request->city_id) && $request->city_id>0 ? $estates->where('city_id', $request->city_id) : $estates;
        $estates = !empty($request->district_id) ? $estates->whereIn('district_id', explode(',', $request->district_id)) : $estates;
        $estates = !empty($request->address) ? $estates->where('address', $request->address) : $estates;
        $estates = !empty($request->unit_no) ? $estates->where('unit_no', $request->unit_no) : $estates;
        $estates = !empty($request->room_count) ? $estates->where('room_count', '>=', $request->room_count)->where('room_count', '>', 0) : $estates;
        $estates = !empty($request->user_id) ? $estates->where('user_id', (int) $request->user_id) : $estates;
        $estates = !empty($request->bath_count) ? $estates->where('bath_count', (int) $request->bath_count) : $estates;
        $estates = !empty($request->commission_percent) ? $estates->where('commission_percent', '>=', (int) $request->commission_percent) : $estates;
        $estates = !empty($request->commission_amount) ? $estates->where('commission_amount', '>=', (int) $request->commission_amount) : $estates;
        $estates = !empty($request->residence_type) ? $estates->where('residence_type', $request->residence_type) : $estates;
        $estates = !empty($request->sale_reason) ? $estates->where('sale_reason', $request->sale_reason) : $estates;
        $estates = !empty($request->sale_priority) ? $estates->where('sale_priority', $request->sale_priority) : $estates;
        $estates = !empty($request->built_area) ? $estates->where('built_area', $request->built_area) : $estates;
        $estates = !empty($request->front_area) ? $estates->where('front_area', '>=', $request->front_area) : $estates;
        $estates = !empty($request->street_width) ? $estates->where('street_width', '>=', $request->street_width) : $estates;
        $estates = !empty($request->floor_area) ? $estates->where('floor_area', $request->floor_area) : $estates;
        $estates = !empty($request->manufacturer_id) ? $estates->where('manufacturer_id', $request->manufacturer_id) : $estates;
        $estates = !empty($request->project_id) ? $estates->where('project_id', $request->project_id) : $estates;
        $estates = !empty($request->brand_id) ? $estates->where('brand_id', $request->brand_id) : $estates;
        $estates = !empty($request->monthly_installments) ? $estates->where('monthly_installments', $request->monthly_installments) : $estates;
        $estates = !empty($request->paid_installments) ? $estates->where('paid_installments', $request->paid_installments) : $estates;
        $estates = !empty($request->rent_type) ? $estates->where('rent_type', $request->rent_type) : $estates;
        $estates = !empty($request->minfloorcount) ?($estates->where('floor_count', '>=',154+$request->minfloorcount)): $estates;
        $estates = !empty($request->maxfloorcount) ?($estates->where('floor_count', '<=',154+$request->maxfloorcount)): $estates;
        $estates = !empty($request->floor_count) ?($request->floor_count==159?$estates->where('floor_count', '>=',$request->floor_count):($estates->where('floor_count', '<=', $request->floor_count)->where('floor_count', '>', 0))) : $estates;
        $estates = !empty($request->keynot) ? $estates->where('keynot',1): $estates;
        $estates = !is_null($request->floor_start) ? $estates->where('floor_start', $request->floor_start) : $estates;
        $estates =!empty($request->built_year)?($request->built_year==31?$estates->where('built_year','<', yearhijriago($request->built_year)): $estates->where('built_year','>=', yearhijriago($request->built_year))): $estates;
        $estates = !is_null($request->floor_type) ? $estates->whereJsonContains('floor_type', $request->floor_type) : $estates;
        $estates = !is_null($request->position_type) ? $estates->where('position_type', $request->position_type) : $estates;
        $estates = !is_null($request->geography) ? $estates->whereIn('geography', explode(',', $request->geography)) : $estates;
        $estates = !is_null($request->usage_type) ? $estates->whereIn('usage_type', explode(',', $request->usage_type)) : $estates;
        $estates = !is_null($request->structure_type) ? $estates->where('structure_type', $request->structure_type) : $estates;
        $estates = !is_null($request->wc) ? $estates->where('wc', $request->wc) : $estates;
        $estates = !is_null($request->build_license) ? $estates->where('build_license', $request->build_license) : $estates;
        $estates = !is_null($request->convertible) ? $estates->where('convertible', $request->convertible) : $estates;
        $estates = !empty($request->document_type) ? $estates->whereIn('document_type', explode(',', $request->document_type)) : $estates;
        $estates = !empty($request->confirmation) ? $estates->where('confirmation', $request->confirmation) : $estates;
        if(!empty($request->facilities))
        {
            $fac = explode(',' , $request->facilities);
            foreach($fac as $f)
            {
                $estates =  $estates->whereJsonContains('facilities', $f);
            }
        }
        //$estates = !empty($request->facilities) ? $estates->whereJsonContains('facilities', $request->facilities) : $estates;
        $estates = !empty($request->kitchen) ? $estates->whereJsonContains('kitchen', $request->kitchen) : $estates;
        $estates = !empty($request->heating_cooling) ? $estates->whereJsonContains('heating_cooling', $request->heating_cooling) : $estates;
        $estates = !empty($request->conditions) ? $estates->whereJsonContains('conditions', $request->conditions) : $estates;

        $estates = !empty($request->unit_in_floor) ?($estates->where('unit_in_floor', '<=',$request->unit_in_floor)): $estates;
        if(!empty($request->photo)){
            $estates = $estates->whereHas('images', function ($query) {
                $query->where('hidden','=',null)->where('is_360','=',null)->where('plan','=',null);
            });
        }
        //dd(getQuery($estates));
        //dd('dddvd');
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
        }
        //$estates = !empty($request->title) ? $estates->Where('title', 'like', '%' . $request->title . '%')  : $estates;
        if (!empty($request->title)) {
            $estates = $estates->where(function ($query) use ($request) {
                $query->where('title', 'like', "%$request->title%")
                    ->orWhere('description', 'like', "%$request->title%");
            });
        }
        // end filter more
        // sort
        $selectedeslist = 0;
        if ($request->eslistflag) {
            if ($request->eslistflag == "true") {
                //dd($request->eslistflag);
                $selectedeslist = explode(",", $request->eslist);
                $selectedeslist = array_map(function ($value) {
                    return (int)$value;
                }, $selectedeslist);
                $estates = $estates->whereIn('id', $selectedeslist);
            }
        }
        //dd($request->sortBy,$request->sortType);
        $sortBy = $request->sortBy ?? 1;
        $sortType = $request->sortType ?? 1;
        $estates = $this->sortBy($estates, $sortBy, $sortType , $selectedType);
        $query = str_replace(array('?'), array('\'%s\''), $estates->toSql());
        $query = vsprintf($query, $estates->getBindings());

        // paginate all
        $totalCount = $estates->count();
        if ($request->mapexists != 1) {
            $estates = $estates->paginate(12);
            $featureValues = FeatureValue::get();
        }
        else
        {
            $map = "[";
            $counter = 1;
            //dd(getQuery($estates));
            $maparray = $estates->whereNotNull("latitude")->get(['id', 'latitude', 'longitude','title','estate_type','type','price','mortgage','rent','project_id','manufacturer_id','room_count']);
            foreach ($maparray as $array) {
                if (env('COUNTRY') == 'UAE')
                {
                    $featureValues = getFeatures(0, 0);;
                    if($array->type == 1)
                    {
                        $price = '';
                        if (!empty($array->project_id) && isset($array->project))
                        {
                            $price .= l('پروژه').': '.$array->project->name .'<p></p>';

                        }
                        if (!empty($array->manufacturer_id))
                        {
                            $price .= l('سازنده').': '.$array->manufacturer->name .'<p></p>';

                        }

                        if (!empty($array->room_count))
                        {
                            $price .= l('تعداد اتاق').': '.($featureValues['room_count'][$array->room_count] != l('بدون اتاق') ? l($featureValues['room_count'][$array->room_count])  : l('بدون اتاق'))  .'<p></p>';

                        }
                        $price .= l('قیمت ملک').': '.toPersianNumbers($array->price).' درهم';
                    }
                    else
                    {
                        $price = l('اجاره ماهیانه').': '.toPersianNumbers($array->rent).' درهم';
                    }
                }
                else
                {
                    if($array->type == 1)
                    {
                        $price = l('قیمت ملک').': '.toPersianNumbers($array->price).' '.l('تومان');
                    }
                    else
                    {
                        $price = l('ودیعه').': '.toPersianNumbers($array->mortgage).' '.l('تومان').
                        '&nbsp;&nbsp;&nbsp;&nbsp;'.
                        l('اجاره ماهیانه').': '.toPersianNumbers($array->rent).' '.l('تومان');
                    }
                }
                if ($maparray->count() != $counter) {
                    $counter += 1;
                    $map .= "[" . $array->latitude . "," . $array->longitude . "," . $array->id . ",'" .estateTypes($array->estate_type) ."<br><br>". $array->title ."<br><br>".$price. "'],";
                } else {
                    $map .= "[" . $array->latitude . "," . $array->longitude . "," . $array->id . ",'" .estateTypes($array->estate_type) ."<br><br>". $array->title ."<br><br>".$price. "']";
                }
            }
            $map .= "]";
        }
        // get estate features (from db)
        // ajax load more
        if ($request->mapexists != 1)
        {
            if ($request->ajax() /*&& $estates->count() > 0*/) {
                $couter = $totalCount / 12;
                $hasPage = ($couter + 1 == $request->page) ? false : true;
                $type=$request->type;
                //$hasPage = fmod($estates->total(), $request->page) == 0 ? false : true;
                if(ss('THEME') == 'site8' || ss('THEME') == 'site5' || ss('THEME') == 'site3'  || ss('THEME') == 'site4' || ss('THEME') == 'site7' || ss('THEME') == ss('THEME').'')
                {
                    $view = view(ss('THEME').'.frontend.estate.component_ex_estate_type'.($request->view ?? 1), compact('estates', 'featureValues','type','totalCount' , 'city'))->render();
                }
                else
                {
                    $view = view('frontend.estate.component_ex_estate_type'.($request->view ?? 1), compact('estates', 'featureValues','type','totalCount'))->render();
                }
                return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
            }
        } else if ($request->mapexists == 1) {
            return response()->json(['map' => $map]);
        }
        $fields = [];
        $flage = true;
        $agent = new \Jenssegers\Agent\Agent;
        if(isset($_REQUEST['city_id'])){
            $districts = District::where('city_id',$_REQUEST['city_id'])->pluck('name','id')->toArray();
        }

        if(ss('THEME') == ss('THEME').'')
        {
            $manufacturers = Manufacturer::get();
            $brands = Brand::get();
            return view(ss('THEME').'.frontend.estate.index', compact(
                'manufacturers',
                'brands',
                'city',
                'cities',
                'districts',
                'districtsId',
                'estates',
                'selectedDistricts',
                'selectedType',
                'selectedEstateType',
                'hasPhoto',
                'hasAgent',
                'price',
                'q',
                'fields',
                'flage',
                'sortBy',
                'sortType',
                'featureValues',
                'totalCount'
            ));
        }
        elseif(ss('THEME') == 'site8' || ss('THEME') == 'site5' || ss('THEME') == 'site3' || ss('THEME') == 'site7' || ss('THEME') == 'site9' || ss('THEME') == ss('THEME').'')
        {

            return view(ss('THEME').'.frontend.estate.index', compact(
                'city',
                'cities',
                'districts',
                'districtsId',
                'estates',
                'selectedDistricts',
                'selectedType',
                'selectedEstateType',
                'hasPhoto',
                'hasAgent',
                'price',
                'q',
                'fields',
                'flage',
                'sortBy',
                'sortType',
                'featureValues',
                'totalCount'
            ));
        }
        else
        {
            return view('frontend.estate.index', compact(
            'city',
            'cities',
            'districts',
            'districtsId',
            'estates',
            'selectedDistricts',
            'selectedType',
            'selectedEstateType',
            'hasPhoto',
            'hasAgent',
            'price',
            'q',
            'fields',
            'flage',
            'sortBy',
            'sortType',
            'featureValues',
            'totalCount'
            ));
        }
    }
    public function manufacturer(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $manufacturer = Manufacturer::orderBy('id', 'desc');
            if(!empty($request->name))
            {
                $manufacturer = $manufacturer->where('name', 'like' , '%'.$request->name.'%');
            }

            $totalCount = $manufacturer->count();
            $model = $manufacturer->paginate(20);
            if ($request->ajax() && $totalCount > 0)
            {
                $couter=$totalCount/20;
                $counter1= round($couter);
                if($counter1>=$couter) $couter=$counter1;
                else $couter=$counter1+1;
                $hasPage = ($couter==$request->page)? false : true;
                //dd($hasPage);
                $view = view(ss('THEME').'.frontend.estate.manufacturerlist', compact('model'))->render();
                return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
            }
            return view(ss('THEME').'.frontend.estate.manufacturer', compact('model'));
        }
    }
    public function brand(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $brand = Brand::orderBy('id', 'desc');
            if(!empty($request->name))
            {
                $brand = $brand->where('name', 'like' , '%'.$request->name.'%');
            }

            $totalCount = $brand->count();
            $model = $brand->paginate(20);
            if ($request->ajax() && $totalCount > 0)
            {
                $couter=$totalCount/20;
                $counter1= round($couter);
                if($counter1>=$couter) $couter=$counter1;
                else $couter=$counter1+1;
                $hasPage = ($couter==$request->page)? false : true;
                //dd($hasPage);
                $view = view(ss('THEME').'.frontend.estate.brandlist', compact('model'))->render();
                return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
            }
            return view(ss('THEME').'.frontend.estate.brand', compact('model'));
        }
    }
    public function manufacturercreate(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            return view(ss('THEME').'.frontend.estate.manufacturercreate');
        }
    }
    public function brandcreate(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            return view(ss('THEME').'.frontend.estate.brandcreate');
        }
    }
    public function manufacturerupdate(Request $request, $id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Manufacturer::find($id);
            if (empty($model)) {
                return back()->withErrors(['یافت نشد!']);
            }
            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);
            if ($validator->fails()) {

                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $model->update($inputs);
            session()->flash('عملیات بروزرسانی با موفقیت انجام شد.', 'success');
            return redirect("/profile/manufacturer");
        }
    }
    public function brandupdate(Request $request, $id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Brand::find($id);
            if (empty($model)) {
                return back()->withErrors(['یافت نشد!']);
            }
            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);
            if ($validator->fails()) {

                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $model->update($inputs);
            session()->flash('عملیات بروزرسانی با موفقیت انجام شد.', 'success');
            return redirect("/profile/brand");
        }
    }
    public function manufacturerstore(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $model = Manufacturer::create($inputs);
        // session()->flash('عملیات ثبت با موفقیت انجام شد.', 'success');
            return redirect("/profile/manufacturer");
        }
    }
    public function brandstore(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $model = Brand::create($inputs);
        // session()->flash('عملیات ثبت با موفقیت انجام شد.', 'success');
            return redirect("/profile/brand");
        }
    }
    public function manufactureredit($id)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Manufacturer::where('id',$id)->first();
            return view(ss('THEME').'.frontend.estate.manufacturercreate', compact('model'));
        }
    }
    public function brandedit($id)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Brand::where('id',$id)->first();
            return view(ss('THEME').'.frontend.estate.brandcreate', compact('model'));
        }
    }
    public function manufacturerdestroy($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {

            $validator = Validator::make(['id' => $id], [
                'id' => 'required|numeric|exists:manufacturer,id'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'result' => $validator->errors()
                ], config('StatusCode.INVALID_INPUT'));
            }
            $model = Manufacturer::find($id);
            $model->delete();
            return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        }
    }
    public function branddestroy($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {

            $validator = Validator::make(['id' => $id], [
                'id' => 'required|numeric|exists:brand,id'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'result' => $validator->errors()
                ], config('StatusCode.INVALID_INPUT'));
            }
            $model = Brand::find($id);
            $model->delete();
            return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        }
    }
    /////////////////////
    public function project(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $project = Project::orderBy('id', 'desc');
            if(!empty($request->name))
            {
                $project = $project->where('name', 'like' , '%'.$request->name.'%');
            }
            if (!empty($request->manufacturer_id))
            {
                $project = $project->where('manufacturer_id', $request->manufacturer_id);
            }
            $totalCount = $project->count();
            $model = $project->paginate(20);
            $manufacturers = Manufacturer::get(['id', 'name']);

            if ($request->ajax() && $totalCount > 0)
            {
                //dd($totalCount);
                $couter=$totalCount/20;
                $counter1= round($couter);
                if($counter1>=$couter) $couter=$counter1;
                else $couter=$counter1+1;
                $hasPage = ($couter==$request->page)? false : true;
                //dd($hasPage);
                $view = view(ss('THEME').'.frontend.estate.projectlist', compact('model', 'manufacturers'))->render();
                return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
            }
            return view(ss('THEME').'.frontend.estate.project', compact('model', 'manufacturers'));
        }
    }
    public function projectcreate(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $manufacturers = Manufacturer::get();
            $city = City::where('name_en' , ss('DEFAULT_CITY'))->first();
            $districts = $city->districts;
            return view(ss('THEME').'.frontend.estate.projectcreate', compact('manufacturers','city','districts'));
        }
    }
    public function projectupdate(Request $request, $id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $model = Project::find($id);
            if (empty($model)) {
                return back()->withErrors(['یافت نشد!']);
            }
            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);
            if ($validator->fails()) {
            // dd($validator->fails());
                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $model->update($inputs);
            session()->flash('عملیات بروزرسانی با موفقیت انجام شد.', 'success');
            return redirect("/profile/project");
        }
    }
    public function projectstore(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);
            //dd($validator->fails());
            if ($validator->fails()) {
                return back()->with(['errors' => $validator->errors()]);
            }
            $inputs = $request->all();
            $model = Project::create($inputs);
            return redirect("/profile/project");
        }
    }
    public function projectedit($id)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $manufacturers = Manufacturer::get();
            $model =Project::where('id',$id)->first();
            $city = City::where('name_en' , ss('DEFAULT_CITY'))->first();
            $districts = $city->districts;
            return view(ss('THEME').'.frontend.estate.projectcreate', compact('model', 'manufacturers','city','districts'));
        }
    }
    public function projectdestroy($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {

            $validator = Validator::make(['id' => $id], [
                'id' => 'required|numeric|exists:project,id'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'result' => $validator->errors()
                ], config('StatusCode.INVALID_INPUT'));
            }
            $model = Project::find($id);
            $model->delete();
            return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        }
    }
    public function getProjects($id)
    {
        $projects = Project::where('manufacturer_id',$id)->pluck('name','id');
		return response( [ 'status' => 'ok', 'result' => $projects ], config( 'StatusCode.SUCCESS' ) );
    }
    public function rental_search(Request $request, $defaultCity = '')
    {
        $city = null;
        if($defaultCity != '')
        {
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
        $cities = City::where('province_id', $city->province_id)->where('active', 1)->get();
        foreach ($cities as $city2) {
            $listCities[] = $city2->id;
        }
        // set cookie
        $hasPhoto = $hasAgent = false;
        $selectedType = $request->type ?? 1; // sale type
        $selectedEstateType = [0, 1, 2, 3, 4, 5]; // all estate type
        $selectedDistricts = [];
        $price = [0, 0];
        $q = '';
        // start query
        // filter by city and type

        $estates = Estate::with([
            'expert:id,code,name,last_name,username,photo,phone',
            'user:id,code,name,last_name,username,photo,phone'
        ])
        ->where('visibility', 1)
        ->where('type', 3)
        ->where('confirmation', 'verified');


        //$estates = $estates->where('showdate', '>' ,  date("Y-m-d", strtotime("-1 years")));
        // filter kind (estate type)
        if (!empty($request->estateTypes)) {
            $selectedEstateType = explode(",", $request->estateTypes);
            for ($i = 0; $i < count($selectedEstateType); $i++)
                if ($selectedEstateType[0] != 0) {
                    $estates = $estates->whereIn('estate_type', $selectedEstateType);
                }
        }


        if (!empty($request->minArea)) {
            $estates = $estates->where('area', '>=', $request->minArea);
        }
        if (!empty($request->maxArea)) {
            $estates = $estates->where('area', '<=', $request->maxArea);
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

        // filter more
        $estates = !empty($request->id) ? $estates->where('id', (int) $request->id) : $estates;
        $estates = !empty($request->estateTypes) ? $estates->whereIn('estate_type', explode(',', $request->estateTypes)) : $estates;

        $estates = !empty($request->city_id) && $request->city_id>0 ? $estates->where('city_id', $request->city_id) : $estates;
        $estates = !empty($request->room_count) ? $estates->where('room_count', '<=', $request->room_count)->where('room_count', '>', 0) : $estates;
        $estates = !is_null($request->position_type) ? $estates->where('position_type', $request->position_type) : $estates;
        $estates = !empty($request->conditions) ? $estates->whereJsonContains('conditions', $request->conditions) : $estates;
        $estates = !empty($request->facilities) ? $estates->whereJsonContains('facilities', $request->facilities) : $estates;
        $estates = !empty($request->max_person) ? $estates->where('max_person', '>=', $request->max_person) : $estates;
        if (!empty($request->minArea)) {
            $estates = $estates->where('area', '>=', $request->minArea);
        }
        if (!empty($request->maxArea)) {
            $estates = $estates->where('area', '<=', $request->maxArea);
        }

        $sortBy = $request->sortBy ?? 1;
        $sortType = $request->sortType ?? 1;
        $estates = $this->sortBy($estates, $sortBy, $sortType , $selectedType);
        $query = str_replace(array('?'), array('\'%s\''), $estates->toSql());
        $query = vsprintf($query, $estates->getBindings());
        //dd(getQuery($estates));
        // paginate all
        $totalCount = $estates->count();

        $estates = $estates->paginate(12);
        $featureValues = FeatureValue::get();

        // get estate features (from db)
        // ajax load more

        if ($request->ajax() && $estates->count() > 0) {

            $couter = $totalCount / 12;
            $hasPage = ($couter + 1 == $request->page) ? false : true;
            $type=$request->type;
            $view = view('site2.frontend.rental.component_ex_estate_type'.($request->view ?? 1), compact('estates', 'featureValues','type','totalCount'))->render();

            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }

        return view('site2.frontend.rental.search', compact(
            'city',
            'cities',
            'estates',
            'selectedDistricts',
            'selectedType',
            'selectedEstateType',
            'hasPhoto',
            'hasAgent',
            'price',
            'q',

            'sortBy',
            'sortType',
            'featureValues',
            'totalCount'
        ));
    }

    public function panorma(Request $request)
    {
        return view('frontend.estate.panorma');
    }
    public function panorma1(Request $request)
    {
        return view('frontend.estate.panormaframe');
    }
    public function sendCommonSms(Request $request)
    {
        $day10estates = Estate::where('city_id', 1)
            ->where('type', 1)
            ->where('created_at', '>' ,  date("Y-m-d", strtotime("-10 days")))
            ->where('created_at', '<=' ,  date("Y-m-d", strtotime("-9 days")))
            ->where('visibility', 1)
            ->where('confirmation', 'verified')->get();
        foreach($day10estates as $estate)
        {
            $text = getsetting('sms','legalsecurity');
            sendSms($estate->phone , $text);
        }

        $day30estates = Estate::where('city_id', 1)
            ->where('type', 1)
            ->where('created_at', '>' ,  date("Y-m-d", strtotime("-31 days")))
            ->where('created_at', '<=' ,  date("Y-m-d", strtotime("-30 days")))
            ->where('visibility', 1)
            ->where('confirmation', 'verified')->get();
        foreach($day30estates as $estate)
        {
            $text = getsetting('sms','qomestatelist');
            sendSms($estate->phone , $text);
        }

    }
    public function roomShow(Request $request, $id)
    {
        $user = Auth::user();
        $userId = $user->id ?? 0;
        // retrieve estate
        $estate = Estate::with([
            'images',
            'expert',
            'expert.roles',
            'district.adjacentDistricts',
            'notes' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            },
            'reports' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            },
            'hits' => function ($q) {
                $q->whereDate('created_at', Carbon::today());
            }
        ])->where('id', $id);
        /*if(!$user->isAdmin())
        {
            $estate = $estate->where(function ($q) use ($user) {
                if (!empty($user)) {
                    $q->Where('user_id', $user->id);
                }
            });
        }*/
        $flag = true;
        if ($flag == true) {
            $estate = $estate->where('published_at', '<=', date("Y-m-d H:i:s"));
        }
        //dd(getQuery($estate));
        $estate = $estate->first();
        if (!$estate) {
            return view('frontend.errors.404');
        }

        $similar="";

        $estateuser="";
        $dateend="";

        // similar (current district)
        $districtId = $estate->district_id;

        $estatenote = EstateNote::where('estate_id', $estate->id)->where('user_id', $userId)->first();
        $similarEstates = Estate::where('district_id', $districtId)
            ->with(['expert:id,name,last_name,username,title,alias,photo'])
            ->where('id', '!=', $estate->id)
            ->where('type', $estate->type)
            ->where('estate_type', $estate->estate_type)
            ->where('showdate', '>' ,  date("Y-m-d", strtotime("-1 years")))
            ->where('visibility', 1)
            ->where('confirmation', 'verified');

        $similarEstates = $this->sortBy($similarEstates, 'id', 'desc');
        // paginate all
        $similarEstates = $similarEstates->paginate(9);
        // similar (other districts)
        // check favorite
        $favorite = EstateFavorite::where('user_id', $userId)->where('estate_id', $estate->id)->first();
        $estate->isFavorite = !$favorite ? 0 : 1;
        // check has note
        $estate->note = count($estate->notes) > 0 ? $estate->notes->first()->note : null;
        // check has report
        $estate->hasReport = count($estate->reports) > 0 ? true : false;
        // get estate attributes and features
        $attributesText = $attributesText2 = $features = [];
        $esatetype = "";

        // increase visit count
        $estateVisit = $estate->hits->first();
        if (!$estateVisit)
        {
            $estateVisit = EstateVisit::create(['estate_id' => $estate->id, 'visit_count' => 0]);
        }
        $estateVisit->increment('visit_count');
        $fieldList = getFeatures(0, 0);
        $featureValues = FeatureValue::get();
        $images = Image::where('estate_id', $estate->id)->get();
        return view('site2.frontend.rental.estate_show', compact(
            'estate',
            'images',
            'features',
            'featureValues',
            'similarEstates',
            'fieldList',

            'estatenote',
            'estateuser',
            'dateend'
        ));
    }
    public function showEdit(Request $request, $id)
    {
        return $this->show($request, $id , true);
    }
    public function show(Request $request, $id , $edit = false)
    {
        //if(getIp() != '127.0.0.1'){
            //echo ($this->buyut("https://www.bayut.com/property/details-10366466.html"));
            //exit;
        //}
        $user = Auth::user();
        $userId = $user->id ?? 0;
        // retrieve estate
        $estate = Estate::/*with([
            'images',
            'expert',
            'expert.roles',
            'district.adjacentDistricts',
            'notes' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            },
            'reports' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            },
            'hits' => function ($q) {
                $q->whereDate('created_at', Carbon::today());
            }
        ])->*/where('id', $id);
        /*if(ss('SITE_ID') == 3 && $estate->district->post_id == null)
        {

        }*/
        $flag = true;
        /*if ($flag == true) {
            $estate = $estate->where('published_at', '<=', date("Y-m-d H:i:s"));
        }*/
        //dd($estate);
        $estate = $estate->first();
        if (!$estate) {
            return view('frontend.errors.404');
        }
        /*if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
        {
            if(getIp() != '127.0.0.1'  && $estate->id>250000  && $estate->id<=343206){
                $pics =  Picture::where('category_id' , $estate->id)->where('convert' , 0)->get();
                foreach ($pics as $image) {
                    $__images = $this->storeMedia3('http://kolbe.ir/images/housing/big_'.$image->id.'.'.$image->pic_format, $estate->id);
                    $default_image = $__images;
                    $image->update(['convert' => 1]);
                }
                $img = Image::where('estate_id', $estate->id)->where('is_360',0)->first();
                // update image fields of estate model
                $estate->update([
                    'image_count' => Image::where('estate_id', $estate->id)->count(),
                    'image_cover' => $img ? asset('/upload/images/estate/'.date('Y').'/'.date('m') .'/'. $img->dimension['large']) : null,
                ]);
                // update default image in images table
                if ($img) {
                    $img->update(['cover' => 1]);
                }
            }
            if(getIp() != '127.0.0.1' && $estate->divar != '' && $estate->id>343206  && $estate->id<398281){

                $estatekoomeh = EstateKoomeh::where('divar' , $estate->divar)->first();
                if($estatekoomeh != null)
                {
                $pics =  ImageKoomeh::where('estate_id' , $estatekoomeh->id)->where('cover' , 0)->get();

                if($pics != null)
                {
                    foreach ($pics as $image) {
                        $__images = $this->storeMedia3('https://koomeh.ir/upload/images/estate/'.$image->url(), $estate->id);
                        $default_image = $__images;
                        $image->update(['cover' => 1]);
                    }
                    $img = Image::where('estate_id', $estate->id)->where('is_360',0)->first();
                    // update image fields of estate model
                    $estate->update([
                        'image_count' => Image::where('estate_id', $estate->id)->count(),
                        'image_cover' => $img ? asset('/upload/images/estate/'.date('Y').'/'.date('m') .'/'. $img->dimension['large']) : null,
                    ]);
                    // update default image in images table
                    if ($img) {
                        $img->update(['cover' => 1]);
                    }
                }
                }
            }
        }*/
        $showrent = ($estate->type == 2 && ss('SITE_ID') == 2 && $estate->estate_type == 8)? true : false;
        $similar="";
        if(ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || ss('SITE_ID') == 8)
        {
            if($estate->phone != '09120000000')
            {
                $similar=Estate::where('phone',$estate->phone)->where('id', '!=', $estate->id)->where('visibility', 1)->where('confirmation', 'verified')->get();
            }
        }
        if(ip_info("Visitor", "Country") == "Iran" || 1)
        {
            if(!$showrent)
            {
                if($estate->expert_id == null ||
                !$estate->expert ||
                !$estate->expert->isExpert())
                {
                    $ret = updateExpert($estate);
                    if($ret>0){
                        $estate->expert_id = $ret;
                    }
                }
            }
        }
        $estateuser="";
        $dateend="";
        if($userId>0)
        {
            $estateEdits = EstateEdit::where('estate_id',$id)->orderBy('id', 'desc')->first();
            if(!empty($estateEdits)){
                $estateuser=User::Where('id',$estateEdits->user_id)->first();
                $dateend=$estateEdits->created_at;
            }
        }
        $districtId = $estate->district_id;
        $similarEstates = [];
        // if(!$showrent)
        // {
        //     $estatenote = EstateNote::where('estate_id', $estate->id)->where('user_id', $userId)->first();
        // }

        $similarEstates = Cache::remember('similarEstates-'.$id , 3000, function () use ($districtId,$estate){
            $similarEstates = Estate::where('district_id', $districtId)->where('city_id', $estate->city_id)
                ->with(['expert:id,name,last_name,username,title,alias,photo'])
                ->where('id', '!=', $estate->id)
                ->where('type', $estate->type)
                ->where('estate_type', $estate->estate_type)
                ->where('showdate', '>' ,  date("Y-m-d", strtotime("-1 years")))
                ->where('visibility', 1)
                ->where('confirmation', 'verified');
            if($estate->price>0)
            {
                $similarEstates = $similarEstates->where('price' , '>' , 0.95 * $estate->price)->where('price' , '<' , 1.05 * $estate->price);
            }
            return $similarEstates->orderBy('id', 'desc')->paginate(5);
        });


        if($userId>0)
        {
            $favorite = EstateFavorite::where('user_id', $userId)->where('estate_id', $estate->id)->first();
            $estate->isFavorite = !$favorite ? 0 : 1;
        }
        $esatetype = "";


        $fieldList = getFeatures(0, 0);

        if($user && $user->isExpert() && ss('SITE_ID') != 5)
        {
            EstateUserVisit::create(['estate_id' => $estate->id, 'user_id' => $user->id]);
        }


        $estatesexpert = "";
        $relationCustomers = [];
        $customers = '';
        if(!empty(Auth::user()) && Auth::user()->isExpert())
        {

            if ($estate->expert_id != null && $estate->expert != null) {
                $estatesexpert = Estate::where('expert_id', $estate->expert->id)->where('visibility', 1)
                ->where('confirmation', 'verified')
                ->where('showdate', '>' ,  date("Y-m-d", strtotime("-1 years")))
                ->paginate(9);
            }

            if(isset($user) && $user->isExpert()){
                $relationCustomers = Customer::join('relation_estate_customer', 'customers.id', '=', 'relation_estate_customer.customer_id')
                    ->where('estate_id',$estate->id)/*->where('active' , 1)*/
                    ->select('customers.*')
                    ->orderBy('customer_id', 'desc')
                    ->paginate(10);
            }

            if($user){

                $customers = Customer::where('user_id', $user->id)->where('status', 1)->get();
            }
        }
        $featureValues = Cache::remember('featureValues' , 3000, function (){
            return FeatureValue::get();
        });
        $images = Cache::remember('images-'.$estate->id , 1, function () use ($estate){
            return Image::where('estate_id', $estate->id)->orderBy('cover', 'desc')->get();
        });
        if(ss('SITE_ID') == 3 && (int)app('request')->input('he') > 0)
        {
            RelationEstateCustomer::where('id' , (int)app('request')->input('he'))->update(['seen_estate' => 1]);
        }
        // increase visit count
        $estateVisit = $estate->hits->first();
        if (!$estateVisit)
        {
            $estateVisit = EstateVisit::create(['estate_id' => $estate->id, 'visit_count' => 0]);
        }
        $estateVisit->increment('visit_count');
        $comments = Comment::where('commentable_type' , 'estate')->where('commentable_id' , $estate->id)/*->where('lang' , Config::get('app.locale'))*/->where('status' , 'verified')->get();
        $data = array(
            'estate' => $estate,
            'images' => $images,
            'featureValues' => $featureValues,
            'similarEstates' => $similarEstates,
            'fieldList' => $fieldList,
            'relationCustomers' => $relationCustomers,
            'customers' => $customers,
            'similar' => $similar,
            'estateuser' => $estateuser,
            'dateend' => $dateend,
            'edit' => $edit,
            'comments' => $comments
        );

        return view((in_array(ss('SITE_ID') , array(2,3,4,5,7,8,9,10,11))?(ss('THEME').'.'):'').'frontend.estate.show', $data);

    }
    public function presentsend(Request $request){
        $estate = Estate::where('id', $request->estate_id)->first();
        if(!$estate)
        {
            return response()->json( ['status' => 'error'] );
        }
        $user = Auth::user();
        if((!empty(Auth::user()) && Auth::user()->isAdmin()) || (!empty(Auth::user()) && Auth::user()->isExpert() && Auth::user()->id == $estate->expert_id && $estate->percent_expert>0 && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s'))))
        {
            if($estate->expert)
            {
                $viewexpert = getsetting('sms','viewexpert');
                $arrSearch = array("{0}" , "{1}");
                $arrReplace = array($estate->expert->fullname() , $estate->expert->username);
                $text = str_replace($arrSearch, $arrReplace, $viewexpert);
                sendSms($estate->phone , $text);
                //sendSms('09124525207' , $text);
            }
            return response()->json( ['status' => 'ok'] );
        }
    }
    public function absence(Request $request)
    {
        $estate = Estate::where('id', $request->estate_id)->first();
        if(!$estate)
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
            sendSms($estate->phone , $text);
            //sendSms('09124525207' , $text);
            return response()->json( ['status' => 'ok'] );
        }
    }
    public function keyword(Request $request, $id)
    {
        return view('frontend.estate.keyword');
    }
    public function addToFavorite($estate_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
        }
        $validator = Validator::make(['id' => $estate_id], [
            'id' => 'required|exists:estates,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.INVALID_INPUT'));
        }
        $ef = EstateFavorite::where('estate_id', $estate_id)->where('user_id', $user->id)->first();
        if (!$ef) {
            $user->favoriteEstates()->attach($estate_id);
            $status = 1;
        } else {
            $user->favoriteEstates()->detach($estate_id);
            $status = 0;
        }
        return response([
            'status' => 'ok',
            'result' => $status
        ], config('StatusCode.SUCCESS'));
    }
    public function addOperation(Request $request)
    {
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            $operation_id = EstateOperation::create([
                'expert_id' => $request->expert_id > 0 ? $request->expert_id : $user->id,
                'estate_id' => $request->estate_id,
                'comment' => $request->comment,
                'customer_id'=> $request->customer_id,
                'type'=> $request->type
            ]);
            $this->ladder($request->estate_id);
            if($request->type == 7 && (ss('SITE_ID') == 5 || ss('SITE_ID') == 8) )
            {
                /*
                {0} سلام
                قرار بازدید ملک شما برای ساعت {1} هماهنگ گردیده است
                مشتری شما {2} باشماره {3} می باشد
                ماموریت ما انجام معاملات بدون واسطه توسط وکیل حقوقی جهت حفاظت از سرمایه شما می باشد

                */
                if($request->estate_id > 0 && $request->customer_id > 0)
                {
                    $estate = Estate::where('id',$request->estate_id)->first();
                    $customer = Customer::where('id',$request->customer_id)->first();
                    //dd($customer);
                    $suggest = getsetting('sms','EstateAppointment');
                    $arrSearch = array("{0}","{1}","{2}","{3}");
                    if(str_contains($customer->name, 'خانم ') || str_contains($customer->name, 'آقای ') || str_contains($customer->name, 'اقای '))
                    {
                        $customername = $customer->name;
                    }
                    else
                    {
                        $customername = ($customer->gender == 'female'?'سرکار خانم ':'جناب آقای ').$customer->name;
                    }
                    //dd($estate->name);
                    if(str_contains($estate->owner_name, 'خانم ') || str_contains($estate->owner_name, 'آقای ') || str_contains($estate->owner_name, 'اقای '))
                    {
                        $estatename = $estate->owner_name;
                    }
                    else
                    {
                        $estatename = ('جناب ').$estate->owner_name;
                    }
                    $arrReplace = array($estatename , $request->comment , $customername , $customer->mobile);
                    $text = str_replace($arrSearch, $arrReplace, $suggest);
                    //dd($text);
                    sendSms($estate->phone , $text);


                    /*
                    {0} سلام
                    قرار بازدید شما برای ساعت {1} هماهنگ گردیده است
                    مالک ملک {2} با شماره {3} می باشد
                    آدرس ملک: {4}
                    ماموریت ما انجام معاملات بدون واسطه توسط وکیل حقوقی جهت حفاظت از سرمایه شما می باشد
                    */
                    $address = $estate->city->name ?? '';
                    $address .= $estate->district && $estate->district->name ? " - ".$estate->district->name:"";
                    $address .= !empty($estate->address)?" - ".$estate->address:"";
                    $address .= !empty($estate->buildingname)?" - نام مجتمع: ".$estate->buildingname:"";
                    $address .= !empty($estate->unit_no)?" - پلاک ".$estate->unit_no:"";
                    $suggest = getsetting('sms','CustomerAppointment');
                    $arrSearch = array("{0}" , "{1}" , "{2}" , "{3}" , "{4}" );
                    $arrReplace = array($customername , $request->comment , $estatename , $estate->phone , $address);
                    $text = str_replace($arrSearch, $arrReplace, $suggest);
                    sendSms($customer->mobile , $text);
                }
            }
        }

        return success_true(['operation_id'=>$operation_id], 'عملکرد با موفقیت ذخیره گردید');
    }
    public function appointment()
    {
        set_time_limit(0);
        $ddg1 = date("Y-m-d H:i:s", strtotime( date( "Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") ) ) . "-5 hours" ) );
        $ddg2 = date("Y-m-d H:i:s", strtotime( date( "Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") ) ) . "-6 hours" ) );
        $operations = EstateOperation::where('type' , 7)->where('created_at' , '>=' , $ddg2)->where('created_at' , '<' , $ddg1)->get();

        foreach($operations as $operation)
        {
            $estate = Estate::where('id',$operation->estate_id)->first();
            $customer = Customer::where('id',$operation->customer_id)->first();
            if($customer != null)
            {
                $suggest = getsetting('sms','EstateAppointment2');
                $arrSearch = array("{0}");
                if(str_contains($customer->name, 'خانم ') || str_contains($customer->name, 'آقای ') || str_contains($customer->name, 'اقای '))
                {
                    $customername = $customer->name;
                }
                else
                {
                    $customername = ($customer->gender == 'female'?'سرکار خانم ':'جناب آقای ').$customer->name;
                }
                if(str_contains($estate->owner_name, 'خانم ') || str_contains($estate->owner_name, 'آقای ') || str_contains($estate->owner_name, 'اقای '))
                {
                    $estatename = $estate->owner_name;
                }
                else
                {
                    $estatename = ('جناب ').$estate->owner_name;
                }
                $arrReplace = array($estatename);
                $text = str_replace($arrSearch, $arrReplace, $suggest);
                sendSms($estate->phone , $text);



                $suggest = getsetting('sms','CustomerAppointment2');
                $arrSearch = array("{0}" );
                $arrReplace = array($customername );
                $text = str_replace($arrSearch, $arrReplace, $suggest);
                sendSms($customer->mobile , $text);
            }
        }
    }
    public function editOperation(Request $request)
    {
        $user = Auth::user();
        $model = EstateOperation::find($request->id);
        if($user->isAdmin() || ($user->isExpert() && $model->expert_id == $user->id))
        {
            EstateOperation::where('id' , $model->id)->update(['comment' => $request->comment]);
        }
        return success_true([], 'عملکرد با موفقیت ذخیره گردید');
    }
    public function addRelation(Request $request)
    {
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            $estate = Estate::where('id',$request->estate_id)->first();
            $customer = Customer::where('id',$request->customer_id)->first();
            if($estate != null && $customer != null)
            {
                $relation_id = RelationEstateCustomer::create([
                    'creator_id' => $user->id,
                    'estate_id' => $request->estate_id,
                    'customer_id'=> $request->customer_id,
                    'estate_expert_id'=> $estate->expert_id,
                    'customer_expert_id'=> $customer->user_id
                ]);
            }
        }
        return success_true(['relation_id'=>$relation_id], 'عملکرد با موفقیت ذخیره گردید');
    }
    public function editRelationComment(Request $request)
    {
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            $relation_id = $request->relation_id;
            $comment = $request->comment;
            $type = $request->type;
            $rel = RelationEstateCustomer::where('id',$relation_id)->first();
            if($type == 'estate' && $rel->estate_expert_id == $user->id)
            {
                RelationEstateCustomer::where('id' , $rel->id)->update(['estate_comment' => $comment]);
            }
            if($type == 'customer' && $rel->customer_expert_id == $user->id)
            {
                RelationEstateCustomer::where('id' , $rel->id)->update(['customer_comment' => $comment]);
            }
        }
        return success_true(['relation_id'=>$relation_id], 'عملکرد با موفقیت ذخیره گردید');
    }
    public function operationsEstate(Request $request,$estate_id)
    {
        $user = Auth::user();
        if($user->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator'))
        {
            $estateOperations = EstateOperation::where('estate_id' , $estate_id)->orderBy('type', 'asc')->orderBy('id', 'desc')->get();
            $view = view('frontend.estate.opertaion_list', compact('estateOperations','estate_id'))->render();
            return response(['status' => 'success', 'html' => $view], config('StatusCode.SUCCESS'));
        }
    }
    public function addToCompare($estate_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
        }
        $validator = Validator::make(['id' => $estate_id], [
            'id' => 'required|exists:estates,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.INVALID_INPUT'));
        }
        $status = 0;
        $ef = EstateCompare::where('estate_id', $estate_id)->where('user_id', $user->id)->first();
        if (!$ef) {
            $user->compareEstates()->attach($estate_id);
            $status = 1;
        } /*else {
            $user->compareEstates()->detach($estate_id);
            $status = 0;
        }*/
        return response([
            'status' => 'ok',
            'result' => $status
        ], config('StatusCode.SUCCESS'));
    }
    public function setVisit($estate_id)
    {
        $user = Auth::user();
        if($user && $user->isExpert())
        {
            EstateUserVisit::create(['estate_id' => $estate_id, 'user_id' => $user->id]);
        }
        return response([
            'status' => 'ok',
            'result' => 200
        ], config('StatusCode.SUCCESS'));
    }
    public function removeallCompare()
    {
        $user = Auth::user();
        $re = EstateCompare::where('user_id', $user->id)->delete();
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
    }
    public function removeCompare($estate_id)
    {
        $user = Auth::user();
        $re = EstateCompare::where('user_id', $user->id)->where('estate_id', $estate_id)->delete();
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
    }
    public function pinFavorite($estate_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response(['status' => 'error', 'result' => 'authentication failed!'], config('StatusCode.UNAUTHORIZED'));
        }
        $ef = EstateFavorite::where('estate_id', $estate_id)->where('user_id', $user->id)->first();
        if (!$ef) {
            $status = 0;
        } else {
            $ef->update(['pin' => $ef->pin == 1 ? 0 : 1]);
            $status = $ef->pin;
        }
        return response([
            'status' => 'ok',
            'result' => $status
        ], config('StatusCode.SUCCESS'));
    }
    public function addNote(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response([
                'status' => 'error',
                'result' => 'authentication failed!'
            ], config('StatusCode.UNAUTHORIZED'));
        }
        $validator = Validator::make($request->all(), [
            'estate_id' => 'required|exists:estates,id,deleted_at,NULL',
            'note' => 'required',
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
        $en = EstateNote::firstOrNew([
            'user_id' => $user->id,
            'estate_id' => $request->estate_id,
        ]);
        $en->note = $request->note;
        $en->ip = $ip;
        $en->agent = $browser;
        $en->device = $platform;
        $en->save();
        if (!$en) {
            return response([
                'status' => 'false',
                'result' => 'error!'
            ], config('StatusCode.SUCCESS'));
        }
        return response([
            'status' => 'true',
            'result' => 'note added successfully'
        ], config('StatusCode.SUCCESS'));
    }
    public function addReport(Request $request)
    {
        $user = Auth::user();
        if (empty($user)) {
            return response([
                'status' => 'error',
                'result' => 'authentication failed!'
            ], config('StatusCode.UNAUTHORIZED'));
        }
        $validator = Validator::make($request->all(), [
            'reason_group' => 'required',
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
        $rep = EstateReport::where('user_id', $user->id)->where('estate_id', $request->estate_id)->first();
        if (empty($rep)) {
            $er = EstateReport::create([
                'user_id' => $user->id,
                'estate_id' => $request->estate_id,
                'ip' => $ip,
                'agent' => $browser,
                'device' => $platform,
                'reason_group' => $request->reason_group,
                'description' => $request->reason_description
            ]);
            if (!$er) {
                return response([
                    'status' => 'false',
                    'result' => 'error!'
                ], config('StatusCode.SUCCESS'));
            }
        } else {
            $inputs["ip"] = $ip;
            $inputs["agent"] = $browser;
            $inputs["device"] = $platform;
            $inputs["reason_group"] = $request->reason_group;
            $er = $rep->update($inputs);
        }
        return response([
            'status' => 'true',
            'result' => 'report added successfully'
        ], config('StatusCode.SUCCESS'));
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
            'type' => 1,
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
    public function saveSearchedKeyword(Request $request)
    {
        $model = SearchKeyword::create([
            'user_id' => $request->user_id ?: null,
            'ip' => $request->ip(),
            'keyword' => $request->keyword
        ]);
        if (!$model) {
            return response([
                'status' => 'error',
                'result' => 'error in storing!',
            ], config('StatusCode.INTERNAL_SERVER_ERROR'));
        }
        return response([
            'status' => 'success',
            'result' => $model,
        ], config('StatusCode.SUCCESS'));
    }
    public function searchParams($request, $model, $fields = null)
    {
        // filter has photo
        if ($request->has_photo == 'true') {
            $hasPhoto = true;
            $model = $model->whereHas('images');
        }
        // filter districts
        if (!empty($request->districts)) {
            $selectedDistricts = explode(",", $request->districts);
            $selectedDistricts = array_map(function ($value) {
                return (int)$value;
            }, $selectedDistricts);
            $model = $model->whereHas('district')->whereIn('district_id', $selectedDistricts);
        }
        // filter keyword
        if ($request->q) {
            $model = $model->where('title', 'LIKE', '%' . $request->q . '%');
            $q = $request->q;
        }
        // filter price
        if ($request->price) {
            $price = explode(",", $request->price);
            $price = array_map(function ($value) {
                return (int)$value;
            }, $price);
            if (empty($price[1])) {
                $model->where('price', '>=', $price[0]);
            } else {
                $model->whereBetween('price', $price);
            }
        }
        return $model;
    }
    public function create(Request $request)
    {
        if (session()->has('referrerUrl')) {
            session()->forget('referrerUrl');
        }
        // retrieve selected city
        $selectedCity = $_COOKIE['city'] ?? 'none';
        $city = City::with(['districts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])
            ->where('name_en', 'qom')
            ->where('active', 1)
            ->first();
        if (!$city) {
            $request->session()->put('referrerUrl', $request->getRequestUri());
            return redirect('/cities');
        }
        // get district
        $districts = $city->districts;
        // get template page and ads
        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 9);
        })
        ->get(['id', 'name','last_name', 'username','status']);
        $manufacturers = null;
        if(env('COUNTRY') == 'UAE')
        {
            $manufacturers = Manufacturer::get();
        }

        return view(((ss('SITE_ID') == 4)?'site4.':'').'frontend.estate.create', compact(
            'districts',
            'users',
            'manufacturers'
        ));
    }
    public function rental_create(Request $request, $id = null)
    {
        if (session()->has('referrerUrl')) {
            session()->forget('referrerUrl');
        }
        $defaultCity=$_COOKIE['city'] ?? ss('DEFAULT_CITY');
        $city = City::where('name_en', $defaultCity)
            ->where('active', 1)
            ->first();
        if (!$city) {
            $city = City::where('name_en', ss('DEFAULT_CITY'))
            ->where('active', 1)
            ->first();
        }

        $estate = null;
        $defaultImage = null;
        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 10);
        })->get(['id', 'name','last_name', 'username','status']);
        if (!empty($id))
        {
            $user = Auth::user();
            $userId = $user->id ?? 0;
            $estate = Estate::with([
                'images',
                'expert'
            ])->where('id', $id);
            $estate = $estate->first();
            if($estate != null)
            {
                if(
                    !($estate->expert_id == $user->id || $user->isAdmin())
                ){
                    return view('frontend.errors.404');
                }
                $city = City::where('id', $estate->city_id)
                    ->where('active', 1)
                    ->first();
                if (!$city) {
                    $request->session()->put('referrerUrl', $request->getRequestUri());
                    return redirect('/cities');
                }
                $cities = City::where('province_id', $estate->province_id)
                    ->where('active', 1)
                    ->get();

            }
            if (!$estate) {
                return view('frontend.errors.404');
            }
            $defaultImage = '';
            if (count($estate->images) > 0) {
                $defaultImage = $estate->images->where('cover', 1)->first();
                if (!$defaultImage) {
                    $defaultImage = $estate->images->first();
                }
            }

            return view('site2.frontend.rental.estate_create', compact(
                'defaultImage',
                'estate',
                'cities',
                'city',
                'users'
            ));
        }
        else
        {
            $streets = [];
            return view('site2.frontend.rental.estate_create', compact(
                'estate',
                'city',
                'users'
            ));
        }
    }
    public function storeMedia(Request $request)
    {
        $user = Auth::user();
        if ($user == null && env('COUNTRY') != 'UAE') {
            return redirect('/login');
        }

        $cropDetail = [600, 600, 0, 0];
        $gallery = uploader($request, 'file', 'images/estate/'.date('Y').'/'.date('m'), null, true, $cropDetail);
        if (empty($gallery)) {
            return response()->json(['error' => 'upload failed!'], 500);
        }
        $userid = 0;
        if($user)
        {
            $userid = $user->id;
        }
        // save images
        $image = Image::create([
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
        Image::where('estate_id', $request->estate_id)->where('id', $id)->delete();
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
    }
    public function CreateEstateEdit($from , $to , $type , $estate_id , $confirm){
        if(!in_array($type , array('_token','link_rewrite','esatateid')))
        {
            EstateEdit::create([
                'changefrom' => $from,
                'changeto' => $to,
                'type' => $type,
                'user_id' => Auth::user()->id,
                'estate_id' => $estate_id,
                'confirm' => $confirm
            ]);
        }
    }
    public function destroy($id)
    {
        $model = Estate::find($id);
        if ($model) {
            if ($model->user_id == Auth::user()->id || Auth::user()->isAdmin()) {

                foreach($model->images as $image)
                {

                    if(getDomainImg($image->id) == '' && file_exists($image->path()))
                    {
                        unlink($image->path());
                    }
                }

                $model->images()->delete();
                $model->delete();
            }
            $this->CreateEstateEdit('' , date('Y-m-d H:i:s') , 'deleted_at' , $id , 1);
            relCustomer($id);
        }
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        //return redirect('/profile/my-estate-ads');
    }
    public function destroyAll()
    {
        $date360 = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-365 day" ) );
        $model = Estate::whereNotIn('district_id' , [1,2,4,6,8,9,10,11,13,14,15,16,17,19,21,22,29,30,34,35,40,42,43,45,48,51,54,55,57,58,68,80,84,112,115,7336,7640,25890,26035,26139,26160,26161,26165,26166,26167,26168,26170,26172,26173,26175,26180,26182,26183,26191,26200,26201,26204,26205,26206,26207,26208,26213])->where('type' , 1)->where('updated_at' , '<' , $date360)->get();
        foreach($model as $estate)
        {
            $this->destroy($estate->id);
        }
        $date120 = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-120 day" ) );
        $model = Estate::whereNotIn('district_id' , [1,2,4,6,8,9,10,11,13,14,15,16,17,19,21,22,29,30,34,35,40,42,43,45,48,51,54,55,57,58,68,80,84,112,115,7336,7640,25890,26035,26139,26160,26161,26165,26166,26167,26168,26170,26172,26173,26175,26180,26182,26183,26191,26200,26201,26204,26205,26206,26207,26208,26213])->where('type' , 2)->where('updated_at' , '<' , $date120)->get();
        foreach($model as $estate)
        {
            $this->destroy($estate->id);
        }
    }
    public function addTelDivar(Request $request)
    {
        // اعتبارسنجی داده‌های ورودی
        $validatedData = $request->validate([
            'code' => 'required|string',
            'phone' => 'required|string|regex:/^0[0-9]{9,15}$/',
        ]);

        // تبدیل اعداد فارسی به انگلیسی
        $farsiToEnglish = function ($number) {
            $farsi_array = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
            $english_array = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
            return str_replace($farsi_array, $english_array, $number);
        };

        // بررسی وجود رکورد با شرایط مشخص
        $estate = Estate::where('divar', $validatedData['code'])
            ->where('phone', '09120000000')
            ->first();

        if ($estate) {
            // حذف رکوردهای تکراری
            $estateList = Estate::where('divar', $validatedData['code'])
                ->where('phone', '09120000000')
                ->where('id', '!=', $estate->id)
                ->get();

            foreach ($estateList as $es) {
                $this->destroy($es->id);
            }

            // حذف رکورد در صورت شماره خاص
            if ($validatedData['phone'] == '09999999999') {
                $this->destroy($estate->id);
            }
            elseif(!preg_match("/^09[0-9]{9}$/", $validatedData['phone'])) {
                $this->destroy($estate->id);
            }
            else
            {
                // به‌روزرسانی شماره تلفن
                if ($estate->phone == '09120000000' && $estate->divar != '') {
                    $englishPhone = $farsiToEnglish($validatedData['phone']);
                    $finalUser = User::where('username', $englishPhone)->first();
                    if(!$finalUser)
                    {
                        $finalUser = User::create(checkInputs([
                            'username' => $englishPhone,
                            'phone' => $englishPhone,
                            'has_role' => 0,
                            'active' => 0,
                            'status' => 1,
                            'isbongah' => 0
                        ]));

                    }
                    if($finalUser->isbongah == 1)
                    {
                        $this->destroy($estate->id);
                    }
                    else
                    {
                        $estate->update(['phone' => $englishPhone, 'owner_name' => $englishPhone , 'user_id' => $finalUser->id]);
                    }
                }
            }
        }

        // یافتن آخرین رکورد
        $latestEstate = Estate::where('phone', '09120000000')
            ->where('divar', '!=', '')
            ->where('divar', '!=', $validatedData['code'])
            ->orderBy('id', 'desc')
            ->first();

        $id = $latestEstate ? $latestEstate->divar : null;

        if ($id != null) {
            return redirect('https://divar.ir/v/aa/' . $id);
        } else {
            exit;
        }
    }

    public function ladder($id)
    {
        $user = Auth::user();
        if($user && $user->isExpert())
        {
            $model = Estate::find($id);
            if ($model)
            {
                if (1 || $model->user_id == Auth::user()->id || Auth::user()->isAdmin())
                {
                    /*if(!$user->isAdmin() && $user->isExpert() && $model->showdate <= date('Y-m-d H:i:s',strtotime("-180 days")))
                    {
                        if(ss('SITE_ID') == 5)
                        {
                            $per = 25;
                        }
                        else
                        {
                            $per = 20;
                        }
                        if(($model->haveExpert() && $model->percent_expert <= $per) || !$model->haveExpert())
                        {
                            $inputs['expert_id'] = $user->id;
                            $inputs['percent_expert'] = $per;
                            $inputs['expiretime_expert'] = date('Y-m-d H:i:s',strtotime("+30 days"));
                            Estate::where('id', $id)->update($inputs);
                            $this->CreateEstateEdit($model->expert_id , $user->id , 'expert_id' , $id , 1);
                            $this->CreateEstateEdit($model->percent_expert , $per , 'percent_expert' , $id , 1);
                            $this->CreateEstateEdit($model->expiretime_expert , date('Y-m-d H:i:s',strtotime("+30 days")) , 'expiretime_expert' , $id , 1);
                        }
                    }*/
                    Estate::where('id', $id)->update(['showdate' => date('Y-m-d H:i:s')]);
                    $this->CreateEstateEdit($model->showdate , date('Y-m-d H:i:s') , 'showdate' , $id , 1);
                    relCustomer($id);
                }
            }
            return response()->json(['status' => 'ok', 'result' => 'ladder'], config('StatusCode.SUCCESS'));
            //return redirect('/profile/my-estate-ads');
        }
    }
    public function visible($id)
    {
        $user = Auth::user();
        if($user && $user->isAdmin())
        {
            $model = Estate::find($id);
            if ($model)
            {
                Estate::where('id', $id)->update(['visibility' => 1]);
                $this->CreateEstateEdit($model->visibility , 1 , 'visibility' , $id , 1);
            }
            return response()->json(['status' => 'ok', 'result' => 'ladder'], config('StatusCode.SUCCESS'));
            //return redirect('/profile/my-estate-ads');
        }
    }


    public function store(Request $request)
    {
        // get auth user
        $user = Auth::user();
        if ($user == null && env('COUNTRY') != 'UAE') {
            return redirect('/login');
        }
        $city = City::with('province')->find($request->city_id);
        // get request inputs

        $inputs = $request->all();
        $inputs['token'] = $estate->token ?? TokenMaker(8);
        if (!empty($request->price)) $inputs['price'] = str_replace(",", "", $request->price);
        if (!empty($request->money_paid)) $inputs['money_paid'] = str_replace(",", "", $request->money_paid);

        if ($user != null)
        {
            $inputs['user_id'] = $user->id;
            if($user->isAdmin() || ($user->isExpert() && (ss('SITE_ID') != 5 && ss('SITE_ID') != 8) ))
            {
                $inputs['expert_id'] = $request->expert_id; // must be change
                if((ss('SITE_ID') == 8 || ss('SITE_ID') == 5) && $request->expert_id>0)
                {
                    $inputs['expiretime_expert'] = date('Y-m-d H:i:s',strtotime("+100 days"));
                }
                if(ss('SITE_ID') != 5 && ss('SITE_ID') != 8)
                {
                    $inputs['percent_expert'] = ($request->percent_expert > 0) ? $request->percent_expert:50;
                }
                else
                {
                    $inputs['percent_expert'] = $request->percent_expert;
                }
            }
            elseif($user->isExpert())
            {
                if($inputs['type'] == 1)
                {
                    $key1 = array('owner_name' , 'price','area' ,'unit_no', 'address','floor_count','room_count','floor','unit_in_floor','usage_type','document_type','built_year','geography','latitude','longitude');
                    $key2 = array('owner_name' , 'price','area' ,'unit_no','address','front_area','built_area','floor_start','room_count','usage_type','document_type','built_year','latitude','longitude');
                    $key4 = array('owner_name' , 'price','area' ,'unit_no','address','front_area','usage_type','document_type','geography','latitude','longitude');
                }
                else
                {
                    $key1 = array('owner_name' , 'mortgage', 'rent','area' ,'unit_no','address','floor_count','room_count','floor','unit_in_floor','built_year','geography','latitude','longitude');
                    $key2 = array('owner_name' , 'mortgage', 'rent','area' ,'unit_no','address','front_area','built_area','floor_start','room_count','built_year','latitude','longitude');
                    $key4 = array('owner_name' , 'mortgage', 'rent','area' ,'unit_no','address','front_area','geography','latitude','longitude');
                }
                $key = array(1 => $key1 , 2 => $key2 , 4 => $key4);
                if(in_array($inputs['estate_type'] , array(1,2,4)) )
                {
                    $keyvalue = $key[$inputs['estate_type']];
                    $changeExpert = true;
                    foreach($keyvalue as $key)
                    {
                        if(array_key_exists($key, $inputs) && $inputs[$key] == '')
                        {
                            $changeExpert = false;
                        }
                    }
                    if($changeExpert == true)
                    {
                        $inputs['expert_id'] = $user->id;
                        $inputs['percent_expert'] = 50;
                        if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                        {
                            $inputs['expiretime_expert'] = date('Y-m-d H:i:s',strtotime("+100 days"));
                        }
                        else
                        {
                            $inputs['expiretime_expert'] = null;
                        }
                    }
                }
            }
        }
        $inputs['owner_name'] = $request->owner_name;
        $inputs['phone'] = $request->phone;
        if(!empty($request->price)) $inputs['price'] = str_replace(",", "", $request->price);
        if((int)$inputs['area'] > 0)
        {
            $inputs['price_per_meter'] = $inputs['type'] == 1 && $inputs['price'] > 0 ? round(($inputs['price'] + ($inputs['loan'] ?? 0)) / $inputs['area']) : 0;
        }
        $inputs['province_id'] = $city->province_id ?? null;
        $codition = array();
        if (!empty($inputs['conditions'])){
            foreach($inputs['conditions'] as $cond){
                array_push($codition, $cond);
            }
        }
        if ($request->exchange == 1)
            array_push($codition, "16");
        if ($request->participation == 283)
            array_push($codition, "283");
        $inputs['conditions'] = !empty($codition) && is_array($codition) ? json_encode($codition) : null;
        $inputs['facilities'] = !empty($request->facilities) && is_array($request->facilities) ? json_encode($request->facilities) : null;
        $inputs['kitchen'] = !empty($request->kitchen) && is_array($request->kitchen) ? json_encode($request->kitchen) : null;
        $inputs['heating_cooling'] = !empty($request->heating_cooling) && is_array($request->heating_cooling) ? json_encode($request->heating_cooling) : null;
        $inputs['floor_type'] = !empty($request->floor_type) && is_array($request->floor_type) ? json_encode($request->floor_type) : null;
        //$inputs['confirmation'] = ($user->isAdminSite()  || $user->isExpert()) ? 'verified' : 'pending';
        if($user != null && ($user->isAdmin() || (ss('SITE_ID') != 5 && ss('SITE_ID') != 8 && $user->isExpert())))
        {
            $inputs['visibility'] = 1;
        }
        else
        {
            $inputs['visibility'] = 0;
        }
        //dd($inputs);
        $inputs['link_rewrite'] = $request->title ? makeLinkRewrite($request->title) : '';
        //$inputs['visibility'] = !is_null($request->visibility) ? $request->visibility : 1;
        $inputs['last_activity'] = $request->visibility == 1 ? Carbon::now() : null;
        $inputs['published_at'] = Carbon::now();
        if (!empty($request->mortgage)) $inputs['mortgage'] = str_replace(',', '', $request->mortgage);
        if (!empty($request->rent)) $inputs['rent'] = str_replace(',', '', $request->rent);
        //dd($request->commission_type);
        $inputs['commission_percent'] = 0;
        $inputs['commission_amount'] = 0;
        $inputs['divar'] = '';
        $inputs['showdate'] = date('Y-m-d H:i:s');
        $inputs['video']="";

        if (!empty($request->video))
        {
            if (env('COUNTRY') == 'UAE')
            {
                $inputs['video'] = $request->video;
            }
            else
            {
                $vid = "";
                $video = explode("/", $request->video);
                if (!empty($video[4])) {
                    $vid = explode("?", $video[4]);
                    if (!empty($vid[0])) {
                        $inputs['video'] = $vid[0];
                    }
                }
            }
        }
        if($user != null && !$user->isExpert())
        {
            $inputs['confirmation'] = 'verified';
        }
        if(array_key_exists('exchange_comment' , $inputs))
        {
            $exchange_comment = $inputs['exchange_comment'];
            $inputs['exchange_comment'] = '';
        }
        $estate = Estate::create($inputs);
        if(ss('SITE_ID') == 2)
        {
            //dd($exchange_comment);
            if(isset($exchange_comment))
            {
                foreach($exchange_comment as $val)
                {
                    $tag = Tag::where( 'name', $val )->first();
                    if($tag == null)
                    {
                        $tag = Tag::create( [ 'name' => $val ] );
                    }
                    $tagsid[] = $tag->id;
                }
            }
            Taggable::where('taggable_type' , 'exchange_selected')
                    ->where('taggable_id' , $estate->id)
                    ->delete();
            if(isset($tagsid))
            {
                foreach($tagsid as $id)
                {
                    Taggable::create( [ 'tag_id' => $id, 'taggable_type' => 'exchange_selected', 'taggable_id' => $estate->id] );
                }
            }
        }
        if((ss('SITE_ID') == 8 || ss('SITE_ID') == 5) && !empty($request->operation))
        {
            EstateOperation::create([
                'expert_id' => $user->id,
                'estate_id' => $estate->id,
                'comment' => $request->operation,
                'type'=> 1
            ]);
        }
        if($request->js_National_card_upload!=null)
        {
            foreach( $request->js_National_card_upload as $index=>$imgField1 )
            {
                $extension = $imgField1->getClientOriginalExtension();
                $fileName = "360_" . $user->Id . "_". Str::random(8);
                $imageUrl = '/upload/images/estate/360/'.$fileName . '.' . $extension;
                $imgField1->move(public_path('/upload/images/estate/360/'), $fileName . '.' . $extension);
                $user = Auth::user();
                $userid = 0;
                if($user)
                {
                    $userid = $user->id;
                }

                $image = Image::create([
                    'name'=>$request->title1[$index],
                    'estate_id' => $estate->id,
                    'user_id' => $userid,
                    'token' => uniqid(),
                    'extension' =>$extension,
                    'url' => $imageUrl,
                    'is_360'=>1
                ]);
                if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
                {
                    $image->update(['plan' => 1]);
                }
            }
        }
        // check auth user is agent
        //بروزرسانی آخرین تاریخ فعالیت کارشناس
        if($user != null)
        {
            $model = User::find($user->id);
            $model->last_activity = Carbon::now();
            $model->save();

            // update images
            if (!empty($request->isbongah)){
                $model->update(['isbongah'=>1]);
            }
            else
            {
                $model->update(['isbongah'=>0]);
            }
        }
        if (!empty($request->document)) {
            // all images id
            $imgIds = $request->document;
            // selected image
            $defaultId = $request->default_image;
            // update model_id
            Image::whereIn('id', $request->document)->update(['estate_id' => $estate->id]);
            // check has default image
            if (!empty($defaultId) && in_array($defaultId, $imgIds)) {
                $img = Image::find($defaultId);
            } else {
                $img = Image::where('estate_id', $estate->id)->first();
            }
            // update image fields of estate model
            $estate->update([
                'image_count' => Image::where('estate_id', $estate->id)->count(),
                'image_cover' => $img ? asset('/upload/images/estate/'.$img->year.'/'.$img->month .'/' . $img->dimension['large']) : null,
            ]);
            // update default image in images table
            if ($img) {
                $img->update(['cover' => 1]);
            }
        }
        if (!empty($request->documenthidden)) {
            // all images id
            // selected image
            // update model_id
            Image::whereIn('id', $request->documenthidden)->update(['estate_id' => $estate->id,'hidden'=>1]);
        }
        if (!empty($request->document1)) {
            // all images id
            $imgIds = $request->document1;
            // selected image
            //$defaultId = $request->default_image;
            // update model_id
            Image::whereIn('id', $request->document1)->update(['estate_id' => $estate->id,'plan' => 1]);
            // check has default image
            // update image fields of estate modelupdate-database
            // update default image in images table
        }
        if ($estate) {
            if($user != null)
            {
                return redirect('/profile/my-estate-ads?accept=1');
            }
            else
            {
                //در اینجا میخوام صرفا یک پیغام به کاربر نمایش داده شود.
                return back()->with('message', 'آگهی ملک شما با موفقیت ذخیره شد. در صورت لزوم، کارشناسان برای هماهنگی‌های بیشتر تماس خواهند گرفت.');
            }
        }
        //return redirect('/profile');
    }
    public function rental_store(Request $request)
    {
        // get auth user
        $user = Auth::user();
        $city = City::with('province')->find($request->city_id);
        // get request inputs
        $inputs = $request->all();
        //$inputs['sound'] = $request->sound;
        //$inputs['token'] = $estate->token ?? TokenMaker(8);
        $inputs['token'] = TokenMaker(8);
        if($request->expertid > 0)
        {
            $inputs['expert_id'] = $request->expertid;
        }
        else
        {
            if($user->isAdmin())
            {
                $finalUser = User::where('username', $request->phone)->first();
                if($finalUser){
                    if(!$finalUser->isRenter())
                    {
                        if($finalUser->owner_name != '')
                        {
                            $role_ids = $finalUser->role_ids;
                            if(is_array($role_ids))
                            {
                                $role_ids[] = 10;
                            }
                            else
                            {
                                $role_ids = [10];
                            }
                            $finalUser->update( [
                                'last_name' => $request->owner_name,
                                'has_role' => 1,
                                'role_ids' => '[' . implode(',' , $role_ids) . ']'
                            ]);
                        }
                        $finalUser->assignRole( 10 );
                        $inputs['expert_id'] = $request->expertid;
                    }
                }
                else
                {
                    $finalUser = User::create(checkInputs([
                        'username' => $request->phone,
                        'phone' => $request->phone,
                        'last_name' => $request->owner_name,
                        'has_role' => 1,
                        'role_ids' => '[10]',
                        'active' => 1,
                        'status' => 1,
                        'isbongah' => 0
                    ]));
                    $finalUser->assignRole( 10 );
                    $inputs['expert_id'] = $finalUser->id;
                }
            }
            else
            {
                $finalUser = User::find( $user->id );
                $role_ids = $finalUser->role_ids;
                if(is_array($role_ids))
                {
                    $role_ids[] = 10;
                }
                else
                {
                    $role_ids = [10];
                }
                $finalUser->update( [
                    'last_name' => $request->owner_name,
                    'has_role' => 1,
                    'role_ids' => '[' . implode(',' , $role_ids) . ']'
                ]);
                $finalUser->assignRole( 10 );
                $inputs['expert_id'] = $request->expertid;
            }
        }
        $inputs['type'] = 3;
        $inputs['owner_name'] = $request->owner_name;
        //$inputs['phone'] = !$user->isExpert()?$request->phone:$user->username;
        $inputs['phone'] = $request->phone;
        $inputs['province_id'] = $city->province_id ?? null;
        $codition = array();
        if (!empty($inputs['conditions'])){
            foreach($inputs['conditions'] as $cond){
                array_push($codition, $cond);
            }
        }

        $inputs['conditions'] = !empty($codition) && is_array($codition) ? json_encode($codition) : null;
        $inputs['facilities'] = !empty($request->facilities) && is_array($request->facilities) ? json_encode($request->facilities) : null;
        $inputs['heating_cooling'] = !empty($request->heating_cooling) && is_array($request->heating_cooling) ? json_encode($request->heating_cooling) : null;
        $inputs['link_rewrite'] = $request->title ? makeLinkRewrite($request->title) : '';
        $inputs['visibility'] = !is_null($request->visibility) ? $request->visibility : 1;
        $inputs['last_activity'] = $request->visibility == 1 ? Carbon::now() : null;
        $inputs['published_at'] = Carbon::now();
        if (!empty($request->mortgage)) $inputs['mortgage'] = str_replace(',', '', $request->mortgage);
        if (!empty($request->rent)) $inputs['rent'] = str_replace(',', '', $request->rent);

        $inputs['showdate'] = date('Y-m-d H:i:s');
        $inputs['video']="";

        $estate = Estate::create($inputs);

        if (!empty($request->document)) {
            // all images id
            $imgIds = $request->document;
            // selected image
            $defaultId = $request->default_image;
            // update model_id
            Image::whereIn('id', $request->document)->update(['estate_id' => $estate->id]);
            // check has default image
            if (!empty($defaultId) && in_array($defaultId, $imgIds)) {
                $img = Image::find($defaultId);
            } else {
                $img = Image::where('estate_id', $estate->id)->first();
            }
            // update image fields of estate model
            $estate->update([
                'image_count' => Image::where('estate_id', $estate->id)->count(),
                'image_cover' => $img ? asset('/upload/images/estate/'.$img->year.'/'.$img->month .'/' . $img->dimension['large']) : null,
            ]);
            // update default image in images table
            if ($img) {
                $img->update(['cover' => 1]);
            }
        }
        if (!empty($request->documenthidden)) {
            // all images id
            // selected image
            // update model_id
            Image::whereIn('id', $request->documenthidden)->update(['estate_id' => $estate->id,'hidden'=>1]);
        }

        if ($estate) {
            if(!$user->isAdmin() && !$user->isRenter())
            {
                return redirect('/profile/info_v2');

            }
            else
            {
                return redirect('/rental/estates');
            }
        }
    }
    public function getAgent($token)
    {
        // auth user
        $user = Auth::user();
        // retrieve model
        $estate = Estate::with([
            'expert',
            'expert.roles',
            'district'
        ])->where('token', $token)
            ->where('confirmation', 'pending')
            ->first();
        // not found
        if (!$estate) {
            return view('frontend.errors.404');
        }
        // check has assigned agent
        if (!empty($estate->expert_id)) {
            return redirect('/profile');
        }
        // retrieve agents
        $agents = User::Role('expert')->whereHas('districts', function ($q) use ($estate) {
            $q->where('district_id', $estate->district_id);
        })->where([
            ['is_admin', 0],
            ['has_role', 1],
            //['status', 1],
        ])
            ->whereIn('activity_type', [3, $estate->type])
            //->whereJsonContains('activity_estate_type',$estate->estate_type)
            ->get();
        // not found
        if (count($agents) == 0) {
            return redirect('/profile');
        }
        // get template page and ads
        $templatePage = getTemplatePageWithAds(18);
        return view('frontend.estate.select_agent', compact('agents', 'templatePage', 'token'));
    }
    public function estatecheck(Request $request)
    {
        $user = Auth::user();
        if(!$user->isExpert() || !$user->isAdmin())
            return null;
        $estates=Estate::Where('phone',$request->phone);
        $estates=$estates->where('visibility', 1)->where('confirmation', 'verified')->get();
        $type=$request->type;
        $totalCount = $estates->count();
        $view = view('frontend.estate.EstateCheck', compact('estates','type','totalCount'))->render();
        return response()->json(['html' => $view,'count'=>$estates->count()]);
    }
    public function assignAgent(Request $request, $token)
    {
        // auth user
        $user = Auth::user();
        // find agent
        $agent = User::find($request->agent_id);
        if (!$agent) {
            return view('frontend.errors.404');
        }
        // retrieve estate
        $estate = Estate::with(['expert'])
            ->where('token', $token)
            ->where('confirmation', 'pending')
            ->first();
        if (!$estate || !empty($estate->estateConfirmation)) {
            return view('frontend.errors.404');
        }
        // update estate model
        //        $estate->update(['expert_id'=>$agent->id, 'phone'=>$agent->username]);
        // add estate confirmation logs
        DB::table('estate_confirmations')->insert([
            'estate_id' => $estate->id,
            'user_id' => $agent->id,
            'assign_date' => Carbon::now(),
            'expire_date' => Carbon::now()->addHours(6),
            'confirmation' => 'pending',
            'created_at' => Carbon::now(),
        ]);
        // send notification to agent
        sendNotification($agent->id, 6, 'ملک جدید', 'ملک جدیدی در انتظار بررسی و تایید شماست', 'admin/estates_assigned');
        return Redirect::route('my.estates')->with(['success' => 'اطلاعات ملک شما با موفقیت ثبت شد، پس بررسی و تایید منتشر خواهد شد.']);
    }
    public function getMoreFields_old(Request $request)
    {
        $estateType = $request->estateType;
        $activityType = $request->activityType;
        if (empty($estateType) || empty($activityType)) {
            return null;
        }
        $selectedEstateType = estateTypesEn($estateType);
        $selectedType = $activityType == 1 ? 'buy' : 'rent';
        $fields = $activityType == 1 ? getSaleFields($estateType) : getRentFields($estateType);
        //return view('frontend.estate.form.'.$selectedType.'_'.$selectedEstateType,compact('fields'))->render();
        return view('frontend.estate.advanced_fields', compact('fields'))->render();
    }
    public function getMoreFields(Request $request)
    {
        $estateType = $request->estateType;
        $activityType = $request->activityType;
        if (empty($estateType) || empty($activityType)) {
            return null;
        }
        // get estate features (from db)
        $result = [];
        $kinds = [
            1 => 'apartment',
            2 => 'villa',
            3 => 'store',
            4 => 'land',
            5 => 'industrial',
        ];
        $selectedKind = $kinds[$estateType]; //get selected kind
        $selectedKind = $selectedKind . $activityType;
        $featureType = $activityType == 1 ? 'sale' : 'rent';
        $features = Feature::with([
            'values' => function ($q) use ($selectedKind) {
                $q->where($selectedKind, 1);
            }
        ])->where($featureType, 1)
            ->orderBy('position')
            ->get();
        foreach ($features as $feature) {
            $values = $feature->values->pluck('title', 'id')->toArray() ?? [];
            if ($values) {
                $feature->items = $values;
                //                $result[$feature->title_en]['group'] = $feature->group ?? '';
                //                $result[$feature->title_en]['title'] = $feature->title ?? '';
                //                $result[$feature->title_en]['icon'] = $feature->icon ?? '';
                //                $result[$feature->title_en]['multiple'] = $feature->multiple == 1 ? 'multiple' : '';
                //                $result[$feature->title_en]['required'] = $feature->required == 1 ? 'required' : '';
                //                $result[$feature->title_en]['values'] = $values;
            }
            unset($feature->values);
        }
        $fields1 = $features;
        //$fields1 = getFeatures($estateType,$activityType);
        $fields = $activityType == 1 ? getSaleFields($estateType) : getRentFields($estateType);
        return view('frontend.estate.advanced_fields', compact('fields', 'features'))->render();
    }
    public function getMoreFieldsSearch(Request $request)
    {
        //dd($request->all());
        $estateType = $request->estateType ?? [1, 2, 3, 4, 5];
        $activityType = $request->activityType;
        if (empty($estateType) || empty($activityType)) {
            return null;
        }
        // get estate features (from db)
        $result = [];
        $kinds = [
            1 => 'apartment',
            2 => 'villa',
            3 => 'store',
            4 => 'land',
            5 => 'industrial',
        ];
        //$columns=[];
        //        $query = '';
        //        $lastElement = end($estateType);
        //        foreach ($estateType as $et){
        //            if(!empty($kinds[$et])){
        //                //$columns[] = $kinds[$et].$activityType;
        //                $query .= ' WHERE ' .$kinds[$et].$activityType. ' = 1';
        //                $query .= $et == $lastElement ? '' : ' AND ';
        //            }
        //        }
        $features = Feature::with([
            'values' => function ($q) use ($kinds, $estateType, $activityType) {
                foreach ($estateType as $et) {
                    if (!empty($kinds[$et])) {
                        $column = $kinds[$et] . $activityType;
                        $q = $q->where($column, 1);
                    }
                }
            }
        ])->orderBy('position')
            ->get();
        foreach ($features as $feature) {
            $values = $feature->values->pluck('title', 'id')->toArray() ?? [];
            if ($values) {
                $feature->items = $values;
                //                $result[$feature->title_en]['group'] = $feature->group ?? '';
                //                $result[$feature->title_en]['title'] = $feature->title ?? '';
                //                $result[$feature->title_en]['icon'] = $feature->icon ?? '';
                //                $result[$feature->title_en]['multiple'] = $feature->multiple == 1 ? 'multiple' : '';
                //                $result[$feature->title_en]['required'] = $feature->required == 1 ? 'required' : '';
                //                $result[$feature->title_en]['values'] = $values;
            }
            unset($feature->values);
        }
        //dd($features);
        //$fields = $activityType == 1 ? getSaleFields($estateType) : getRentFields($estateType);
        return view('frontend.estate.advanced_search_fields', compact('features'))->render();
    }
    public function getMoreFieldsSearch_v2(Request $request)
    {
        $estateType = $request->estateType ?? [1, 2, 3, 4, 5];
        $activityType = $request->activityType;
        if (empty($estateType) || empty($activityType)) {
            return null;
        }
        // get estate features (from db)
        $result = [];
        $kinds = [
            1 => 'apartment',
            2 => 'villa',
            3 => 'store',
            4 => 'land',
            5 => 'industrial',
        ];
        //$columns=[];
        //        $query = '';
        //        $lastElement = end($estateType);
        //        foreach ($estateType as $et){
        //            if(!empty($kinds[$et])){
        //                //$columns[] = $kinds[$et].$activityType;
        //                $query .= ' WHERE ' .$kinds[$et].$activityType. ' = 1';
        //                $query .= $et == $lastElement ? '' : ' AND ';
        //            }
        //        }
        $features = Feature::with([
            'values' => function ($q) use ($kinds, $estateType, $activityType) {
                foreach ($estateType as $et) {
                    if (!empty($kinds[$et])) {
                        $column = $kinds[$et] . $activityType;
                        $q = $q->where($column, 1);
                    }
                }
            }
        ])->orderBy('position')
            ->get();
        foreach ($features as $feature) {
            $values = $feature->values->pluck('title', 'id')->toArray() ?? [];
            if ($values) {
                $feature->items = $values;
                //                $result[$feature->title_en]['group'] = $feature->group ?? '';
                //                $result[$feature->title_en]['title'] = $feature->title ?? '';
                //                $result[$feature->title_en]['icon'] = $feature->icon ?? '';
                //                $result[$feature->title_en]['multiple'] = $feature->multiple == 1 ? 'multiple' : '';
                //                $result[$feature->title_en]['required'] = $feature->required == 1 ? 'required' : '';
                //                $result[$feature->title_en]['values'] = $values;
            }
            unset($feature->values);
        }
        //dd($features);
        //$fields = $activityType == 1 ? getSaleFields($estateType) : getRentFields($estateType);
        return view('frontend.estate.advanced_search_fields_v2', compact('features'))->render();
    }
    public function getMoreFieldsSearch_mobile_v2(Request $request)
    {
        $estateType = $request->estateType ?? [1, 2, 3, 4, 5];
        $activityType = $request->activityType;
        if (empty($estateType) || empty($activityType)) {
            return null;
        }
        // get estate features (from db)
        $result = [];
        $kinds = [
            1 => 'apartment',
            2 => 'villa',
            3 => 'store',
            4 => 'land',
            5 => 'industrial',
        ];
        //$columns=[];
        //        $query = '';
        //        $lastElement = end($estateType);
        //        foreach ($estateType as $et){
        //            if(!empty($kinds[$et])){
        //                //$columns[] = $kinds[$et].$activityType;
        //                $query .= ' WHERE ' .$kinds[$et].$activityType. ' = 1';
        //                $query .= $et == $lastElement ? '' : ' AND ';
        //            }
        //        }
        $features = Feature::with([
            'values' => function ($q) use ($kinds, $estateType, $activityType) {
                foreach ($estateType as $et) {
                    if (!empty($kinds[$et])) {
                        $column = $kinds[$et] . $activityType;
                        $q = $q->where($column, 1);
                    }
                }
            }
        ])->orderBy('position')
            ->get();
        foreach ($features as $feature) {
            $values = $feature->values->pluck('title', 'id')->toArray() ?? [];
            if ($values) {
                $feature->items = $values;
                //                $result[$feature->title_en]['group'] = $feature->group ?? '';
                //                $result[$feature->title_en]['title'] = $feature->title ?? '';
                //                $result[$feature->title_en]['icon'] = $feature->icon ?? '';
                //                $result[$feature->title_en]['multiple'] = $feature->multiple == 1 ? 'multiple' : '';
                //                $result[$feature->title_en]['required'] = $feature->required == 1 ? 'required' : '';
                //                $result[$feature->title_en]['values'] = $values;
            }
            unset($feature->values);
        }
        //dd($features);
        //$fields = $activityType == 1 ? getSaleFields($estateType) : getRentFields($estateType);
        $city = City::with(['districts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])
            ->where('name_en', $request->defaultCity)
            ->where('active', 1)
            ->first();
        //$districts = $city->districts->all();
        $districts = $city->districts->pluck('name')->toArray();
        $districtsId = $city->districts->pluck('id')->toArray();
        return view('frontend.estate.advanced_search_fields_vmobile2', compact('features', 'districts', 'districtsId'))->render();
    }
    public function edit(Request $request, $token)
    {
        // auth user
        $user = Auth::user();
        // user not found
        if (!$user) {
            return view('frontend.errors.404');
        }
        // retrieve estate
        $estate = Estate::with(['images', 'city'])
            ->where('id', $token);
        if(!$user->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch')){
            $estate = $estate->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('expert_id', $user->id);
            });
        }
        $estate = $estate->first();
        // not found
        if (!$estate) {
            return view('frontend.errors.404');
        }
        $defaultImage = null;
        if (count($estate->images) > 0) {
            $defaultImage = $estate->images->where('cover', 1)->first();
            if (!$defaultImage) {
                $defaultImage = $estate->images->first();
            }
        }
        $city = City::with(['districts' => function ($q) {
            $q->orderBy('name', 'asc');
        }])
            ->where('id', $estate->city_id)
            ->where('active', 1)
            ->first();
        // get district
        $districts = $city->districts;
        // get advanced fields
        $fields = $estate->type == 1 ? getSaleFields($estate->estate_type) : getRentFields($estate->estate_type);
        $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
        $users = $users->whereHas('roles', function ($query) {
            $query->where( 'id', '=', 9);
        })->get(['id', 'name','last_name', 'username','status']);
        return view('frontend.estate.edit', compact(
            'estate',
            'defaultImage',
            'districts',
            'fields',
            'templatePage',
            'users'
        ));
    }

    public function archive(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json( ['status' => 'error'] );
        }
        $estate = Estate::find($request->estate_id);
        if (empty($estate)) {
            return response()->json( ['status' => 'error'] );
        }
        if(
            !($estate->user_id == $user->id ||
            $user->isAdmin() ||
            ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $user->id == $estate->expert_id) ||
            ($user->isExpert() && ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s'))))// && $estate->created_at > date('Y-m-d H:i:s',strtotime("-1 days"))) ||
            )
        ){
            return response()->json( ['status' => 'error'] );
        }
        $estate->update(['confirmation'=>'rejected']);
        $this->CreateEstateEdit($estate->confirmation , 'rejected' , 'confirmation' , $estate->id , 1);
        if(!$user->isAdmin())
        {
            $estate->update(['visibility'=> 0]);
            $this->CreateEstateEdit($estate->visibility , 0 , 'visibility' , $estate->id , 1);
        }
        return response()->json( ['status' => 'ok'] );
    }
    public function archived($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json( ['status' => 'error'] );
        }
        $estate = Estate::find($id);
        if (empty($estate)) {
            return response()->json( ['status' => 'error'] );
        }
        if(
            !($estate->user_id == $user->id ||
            $user->isAdmin() ||
            ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $user->id == $estate->expert_id) ||
            ($user->isExpert() && ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s'))))// && $estate->created_at > date('Y-m-d H:i:s',strtotime("-1 days"))) ||
            )
        ){
            return response()->json( ['status' => 'error'] );
        }
        $estate->update(['confirmation'=>'rejected']);
        $this->CreateEstateEdit($estate->confirmation , 'rejected' , 'confirmation' , $estate->id , 1);
        if(!$user->isAdmin())
        {
            $estate->update(['visibility'=> 0]);
            $this->CreateEstateEdit($estate->visibility , 0 , 'visibility' , $estate->id , 1);
        }
        return response()->json( ['status' => 'ok'] );
    }
    public function verified($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json( ['status' => 'error'] );
        }
        $estate = Estate::find($id);
        if (empty($estate)) {
            return response()->json( ['status' => 'error'] );
        }
        if(
            !($estate->user_id == $user->id ||
            $user->isAdmin() ||
            ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $user->id == $estate->expert_id) ||
            ($user->isExpert() && ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s'))))// && $estate->created_at > date('Y-m-d H:i:s',strtotime("-1 days"))) ||
            )
        ){
            return response()->json( ['status' => 'error'] );
        }
        $estate->update(['confirmation'=>'verified']);
        $this->CreateEstateEdit($estate->confirmation , 'verified' , 'confirmation' , $estate->id , 1);
        if(!$user->isAdmin())
        {
            $estate->update(['visibility'=> 0]);
            $this->CreateEstateEdit($estate->visibility , 0 , 'visibility' , $estate->id , 1);
        }
        return response()->json( ['status' => 'ok'] );
    }
    public function changeConfirmation($id , $status)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json( ['status' => 'error'] );
        }
        $estate = Estate::find($id);
        if (empty($estate)) {
            return response()->json( ['status' => 'error'] );
        }
        if(
            !($estate->user_id == $user->id ||
            $user->isAdmin() ||
            ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $user->id == $estate->expert_id) ||
            ($user->isExpert() && ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s'))))// && $estate->created_at > date('Y-m-d H:i:s',strtotime("-1 days"))) ||
            )
        ){
            return response()->json( ['status' => 'error'] );
        }
        $estate->update(['confirmation'=>$status]);
        $this->CreateEstateEdit($estate->confirmation , $status , 'confirmation' , $estate->id , 1);
        // if(!$user->isAdmin())
        // {
        //     $estate->update(['visibility'=> 0]);
        //     $this->CreateEstateEdit($estate->visibility , 0 , 'visibility' , $estate->id , 1);
        // }
        return response()->json( ['status' => 'ok'] );
    }
    public function update1(Request $request, $id)
    {

        $user = Auth::user();
        if (!$user) {
            return view('frontend.errors.404');
        }
        $estate = Estate::find($id);
        if (empty($estate)) {
            return view('frontend.errors.404');
        }
        if(!$estate->haveExpert())
        {
            $estate->expert_id = null;
            $estate->expiretime_expert = null;
            $estate->percent_expert = null;
        }

        if(
            !($estate->user_id == $user->id ||
            $user->isAdmin() ||
            $estate->percent_expert == 0 ||
            ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $user->id == $estate->expert_id) ||
            ($user->isExpert() && ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s'))))// && $estate->created_at > date('Y-m-d H:i:s',strtotime("-1 days"))) ||
            )
        ){
            return view('frontend.errors.404');
        }
        // find city
        $city = City::with('province')->find($request->city_id);
        // check has default image
        if (!empty($request->default_image))
        {
            $img = Image::find($request->default_image);
        }
        else
        {
            $img = Image::where('estate_id', $estate->id)->where('hidden','!=',1)->where('plan','!=',1)->where('is_360','!=',1)->first();
        }
        // update default image in table
        if ($img) {
            Image::where('estate_id', $estate->id)->update(['cover' => 0]);
            // update new cover
            $img->update(['cover' => 1]);
        }
        if (!empty($request->documenthidden)) {
            // all images i
            // update model_id
            Image::whereIn('id', $request->documenthidden)->update(['estate_id' => $estate->id,'hidden'=>1]);
            if((ss('SITE_ID') == 8 || ss('SITE_ID') == 5) && !$user->isAdmin())
            {
                $inputs['visibility'] = 0;
            }
        }
        // get request inputs
        $inputs = $request->all();
        if (!empty($request->document1)) {
            // all images id
            $imgIds = $request->document1;
            // selected image
            //$defaultId = $request->default_image;
            // update model_id
            Image::whereIn('id', $request->document1)->update(['estate_id' => $estate->id,'plan' => 1]);
            if((ss('SITE_ID') == 8 || ss('SITE_ID') == 5) && !$user->isAdmin())
            {
                $inputs['visibility'] = 0;
            }
            // check has default image
            // update image fields of estate modelupdate-database
            // update default image in images table
        }
        if (!empty($request->document)) {
            // all images id
            $imgIds = $request->document;
            // update model_id
            Image::whereIn('id', $imgIds)->update(['estate_id' => $estate->id]);
            if((ss('SITE_ID') == 8 || ss('SITE_ID') == 5) && !$user->isAdmin())
            {
                $inputs['visibility'] = 0;
            }
        }
        $inputs['token'] = $estate->token ?? TokenMaker(8);
        //var_dump($inputs);
        if($inputs['price']!=null)
        {
            $inputs['price'] = str_replace(',','',$inputs['price']);
        }
        if($inputs['area']>0)
        {
            $inputs['price_per_meter'] = $inputs['type'] == 1 && $inputs['price'] > 0 ? round(($inputs['price'] ) / $inputs['area']) : 0;
        }
        $inputs['province_id'] = $city->province_id ?? null;
        $codition = array();
        if (!empty($inputs['conditions'])){
            foreach($inputs['conditions'] as $cond){
                array_push($codition, $cond);
            }
        }
        if ($request->exchange == 1)
            array_push($codition, "16");
        if ($request->participation == 283)
            array_push($codition, "283");
        $inputs['conditions'] = !empty($codition) && is_array($codition) ? json_encode($codition) : null;
        $inputs['facilities'] = !empty($request->facilities) ? json_encode($request->facilities) : null;
        $inputs['kitchen'] = !empty($request->kitchen) ? json_encode($request->kitchen) : null;
        $inputs['heating_cooling'] = !empty($request->heating_cooling) ? json_encode($request->heating_cooling) : null;
        $inputs['floor_type'] = !empty($request->floor_type) ? json_encode($request->floor_type) : null;
        //$inputs['confirmation'] = 'pending'; //Auth::user()->isAdmin() || Auth::user()->isAdminSite() ? 'verified' : 'pending';
        $inputs['link_rewrite'] = $request->title ? makeLinkRewrite($request->title) : '';
        if($user->isAdmin())
        {
            $inputs['visibility'] = 1;
        }
        $inputs['image_count'] = Image::where('estate_id', $estate->id)->count();
        $inputs['image_cover'] = $img && !empty($img->dimension['large'])? asset('/upload/images/estate/' .$img->year.'/'.$img->month .'/' . $img->dimension['large']) : null;
        $inputs['video']="";

        if (!empty($request->video))
        {
            if (env('COUNTRY') == 'UAE')
            {
                // $vide = explode("/" , $request->video);
                // if(is_array($vide))
                // {
                //     $inputs['video'] = $vide[count($vide) - 1];
                // }
                $inputs['video'] = $request->video;
            }
            else
            {
                $vid = "";
                $video = explode("/", $request->video);
                if (!empty($video[4])) {
                    $vid = explode("?", $video[4]);
                    if (!empty($vid[0])) {
                        $inputs['video'] = $vid[0];
                    }
                }
            }
        }
        if (!empty($request->mortgage)) $inputs['mortgage'] = str_replace(',', '', $request->mortgage);
        if (!empty($request->rent)) $inputs['rent'] = str_replace(',', '', $request->rent);
        if($user->isAdmin() || $user->isExpert())
        {
            $inputs['confirmation'] = $request->confirmation;
        }
        else
        {
            $inputs['visibility'] = 0;
            //$inputs['confirmation'] = "pending";
        }
        $changeExpert = false;
        if($request->js_National_card_upload!=null){
            $i=0;
            //  dd($request->js_National_card_upload);
            foreach( $request->js_National_card_upload as $index=>$imgField1 ) {
                $extension = $imgField1->getClientOriginalExtension();
                $fileName = "360_" . $user->Id . "_". Str::random(8);
                $imageUrl = '/upload/images/estate/360/'.$fileName . '.' . $extension;

                $imgField1->move(base_path(env('PUBLIC_PATH').'/upload/images/estate/360/'), $fileName . '.' . $extension);
                // dd($imageUrl);
                $user = Auth::user();
                $userid = null;
                if($user)
                {
                    $userid = $user->id;
                }

                $image = Image::create([
                    'is_360'=>1,
                    'name'=>$request->title1[$index],
                    'estate_id' => $id,
                    'user_id' => $userid,
                    'token' => uniqid(),
                    'extension' =>$extension,
                    'url' => $imageUrl,

                    'priority' => 1000
                ]);

                if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
                {
                    $image->update(['plan' => 1]);
                }
                if(!$user->isAdmin() && $user->isExpert())
                {
                    $changeExpert = true;
                    $inputs['expert_id'] = $user->id;
                    $inputs['percent_expert'] = 50;
                    if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                    {
                        $inputs['expiretime_expert'] = date('Y-m-d H:i:s',strtotime("+30 days"));
                    }
                    else
                    {
                        $inputs['expiretime_expert'] = null;
                    }
                }

            }
        }
        if(ss('SITE_ID')==3 && $changeExpert == false && (0.9)*$estate->price >= $inputs['price'] && !$user->isAdmin() && $user->isExpert())
        {
            $changeExpert = true;
            $inputs['expert_id'] = $user->id;
            $inputs['percent_expert'] = 50;
            if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
            {
                $inputs['expiretime_expert'] = date('Y-m-d H:i:s',strtotime("+100 days"));
            }
            else
            {
                $inputs['expiretime_expert'] = null;
            }
        }
        if(ss('SITE_ID')==3 && $changeExpert == false && (ss('SITE_ID') == 8 || ss('SITE_ID') == 5) && (0.95)*$estate->price >= $inputs['price'] && !$user->isAdmin() && $user->isExpert()){
            $changeExpert = true;
            if(($estate->haveExpert() && $estate->percent_expert <= 25) || !$estate->haveExpert())
            {
                $inputs['expert_id'] = $user->id;
                $inputs['percent_expert'] = 50;
                $inputs['expiretime_expert'] = null;
            }
        }
        if($estate->type == 1)
        {
            if(ss('SITE_ID')==3)
            {
                $key1 = array('owner_name' , 'price','area' ,'unit_no', 'address','floor_count','room_count','floor','unit_in_floor','usage_type','document_type','built_year','geography','latitude','longitude');
                $key2 = array('owner_name' , 'price','area' ,'unit_no','address','front_area','built_area','floor_start','room_count','usage_type','document_type','built_year','latitude','longitude');
                $key4 = array('owner_name' , 'price','area' ,'unit_no','address','front_area','usage_type','document_type','geography','latitude','longitude');
            }
            else
            {
                $key1 = array('owner_name' , 'price','area' ,'unit_no', 'address','floor_count','room_count','floor','unit_in_floor','usage_type','document_type','built_year','geography');
                $key2 = array('owner_name' , 'price','area' ,'unit_no','address','front_area','built_area','floor_start','room_count','usage_type','document_type','built_year');
                $key4 = array('owner_name' , 'price','area' ,'unit_no','address','front_area','usage_type','document_type','geography');
            }
        }
        else
        {
            $key1 = array('owner_name' , 'mortgage', 'rent','area' ,'unit_no', 'address','floor_count','room_count','floor','unit_in_floor','built_year','geography');
            $key2 = array('owner_name' , 'mortgage', 'rent','area' ,'unit_no','address','front_area','built_area','floor_start','room_count','built_year');
            $key4 = array('owner_name' , 'mortgage', 'rent','area' ,'unit_no','address','front_area','geography');
        }
        $key = array(1 => $key1 , 2 => $key2 , 4 => $key4);
        if($changeExpert == false && in_array($estate->estate_type , array(1,2,4)))
        {

            foreach($inputs as $key2=>$val2)
            {
                $inputskey[] = $key2;
            }
            $keyvalue = $key[$estate->estate_type];
            $_changeval = false;
            foreach($keyvalue as $key)
            {
                if(in_array($key , $inputskey))
                {
                    if($inputs[$key] == '')
                    {
                        $changeExpert = true;
                    }
                    if($inputs[$key] != $estate->$key){
                        $_changeval = true;
                    }
                }
                else
                {
                    $changeExpert = false;
                }
            }
            if(!$user->isAdmin() && $user->isExpert())
            {
                //if($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $user->id == $estate->expert_id)
                {
                    if($changeExpert == false && $_changeval == true)
                    {
                        if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                        {
                            /*if($estate->showdate <= date('Y-m-d H:i:s',strtotime("-180 days")))
                            {
                                $per = 50;
                            }
                            else
                            {*/
                                $per = 50;
                            //}
                        }
                        else
                        {
                            $per = 50;
                        }
                        if(($estate->haveExpert() && $estate->expert_id == $user->id) || !$estate->haveExpert())
                        {
                            if(date('Y-m-d H:i:s',strtotime("+30 days")) > $estate->expiretime_expert && $estate->percent_expert <= $per)
                            {
                                $inputs['expert_id'] = $user->id;
                                $this->CreateEstateEdit($estate->expert_id , $user->id , 'expert_id' , $id , 1);
                                $inputs['percent_expert'] = $per;
                                $this->CreateEstateEdit($estate->percent_expert , $per , 'percent_expert' , $id , 1);
                                if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                                {
                                    $inputs['expiretime_expert'] = date('Y-m-d H:i:s',strtotime("+30 days"));
                                    $this->CreateEstateEdit($estate->expiretime_expert , date('Y-m-d H:i:s',strtotime("+30 days")) , 'expiretime_expert' , $id , 1);
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach($inputs as $key=>$val)
        {
            if($val != $estate->$key && !is_array($val))
            {
                if($key == 'expert_id')
                {
                    if($user->isAdmin())
                    {
                        $inputsa['expert_id'] = $val;
                        $inputs['expert_id'] = $val;
                        $inputsa['percent_expert'] = 50;
                        $inputs['percent_expert'] = 50;
                        if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                        {
                            $inputsa['expiretime_expert'] = date('Y-m-d H:i:s',strtotime("+30 days"));
                            $inputs['expiretime_expert'] = date('Y-m-d H:i:s',strtotime("+30 days"));
                            $this->CreateEstateEdit($estate->expiretime_expert , date('Y-m-d H:i:s',strtotime("+30 days")) , 'expiretime_expert' , $id , 1);
                        }
                        else
                        {
                            $inputsa['expiretime_expert'] = null;
                            $inputs['expiretime_expert'] = null;
                            $this->CreateEstateEdit($estate->expiretime_expert , null , 'expiretime_expert' , $id , 1);
                        }
                        $this->CreateEstateEdit($estate->percent_expert , 50 , 'percent_expert' , $id , 1);
                        $this->CreateEstateEdit($estate->expert_id , $val , 'expert_id' , $id , 1);

                        Estate::where('id', $id)->update($inputsa);
                    }
                }
                if((ss('SITE_ID') == 5 || ss('SITE_ID') == 8) && !$user->isAdmin())
                {
                    if($key == 'title' || $key == 'description' || $key == 'video'){
                        $inputs['visibility'] = 0;
                    }
                    if($key == 'confirmation' /*&&  ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s')))*/)
                    {
                        $inputs['visibility'] = 0;
                    }
                }
                $this->CreateEstateEdit($estate->$key , $val , $key , $id , 1);
            }
        }
        //dd(checkInputs($inputs));
        if(array_key_exists('exchange_comment' , $inputs))
        {
            $exchange_comment = $inputs['exchange_comment'];
            $inputs['exchange_comment'] = '';
        }
        $estate->update(checkInputs($inputs));
        if(ss('SITE_ID') == 2)
        {
            if(isset($exchange_comment))
            {
                foreach($exchange_comment as $val)
                {
                    $tag = Tag::where( 'name', $val )->first();

                    if($tag == null)
                    {
                        $tag = Tag::create( [ 'name' => $val ] );
                    }
                    $tagsid[] = $tag->id;
                }
            }
            Taggable::where('taggable_type' , 'exchange_selected')
                    ->where('taggable_id' , $estate->id)
                    ->delete();
            if(isset($tagsid))
            {
                foreach($tagsid as $id)
                {
                    Taggable::create( [ 'tag_id' => $id, 'taggable_type' => 'exchange_selected', 'taggable_id' => $estate->id] );
                }
            }
        }
        //if(ss('SITE_ID') == 5)
        {
            $this->ladder($estate->id);
        }
        if($estate->user_id>0)
        {
            $model = User::where('username' , $estate->phone)->first();
            if($model)
            {
                if (!empty($request->isbongah))
                {
                    $model->update(['isbongah'=>1]);
                    $this->CreateEstateEdit($estate->confirmation , 'rejected' , 'confirmation' , $estate->id , 1);
                    $estate->update(['confirmation'=>'rejected']);
                }
                else
                {
                    $model->update(['isbongah'=>0]);
                }
            }
        }
        if (is_array($request->image_orders)) {
            foreach ($request->image_orders as $order) {
                [$imageId, $position] = explode(':', $order);

                // تبدیل به عدد صحیح برای جلوگیری از تزریق
                $imageId = (int) $imageId;
                $position = (int) $position;

                // اگر عکس پیدا شد، priority رو آپدیت کن
                $image = Image::find($imageId);
                if ($image) {
                    $image->priority = $position;
                    $image->save();
                }
            }
        }

        if(env('COUNTRY') == 'UAE' && $request->baseestate == 1){
            return redirect('/profile/project');
        }
        else
        {
            return redirect('/profile/my-estate-ads?'.$request->parameters);
        }
    }
    public function rental_estate_show(Request $request)
    {
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        // retrieve estate
        $estates = Estate::with([
            'images',
            'district',
        ]);
        if($user->isExpert())
        {
           $estates = $estates->orderBy($request->order, $request->orderby);
        }
        else
        {
            $estates = $estates->orderBy('id', 'desc');
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
            $estates=$estates->where('visibility',$request->visibility);
        }

        if(!empty($request->estateTypes))
        {
            $estates=$estates->where('estate_type',$request->estateTypes);
        }
        $fieldList = getFeatures(0, 0);
        if (!empty($request->room_count)) {
            $estates = $estates->where('room_count', '>=',  $request->room_count );
        }

        if (!empty($request->street_width)) {
            $estates = $estates->where('street_width', '>=',  $request->street_width );
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

        if(!empty($request->floor_min)){
            $estates = $estates->where('floor','>=',$request->floor_min);
        }
        if(!empty($request->floor_max)){
            $estates = $estates->where('floor','<=',$request->floor_max);
        }
        if(!empty($request->unit_in_floor)){
            $estates = $estates->where('unit_in_floor', $request->unit_in_floor);
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
        if (!empty($request->title)) {
            $estates = $estates->where(function ($query) use ($request) {
                $query->where('title', 'like', "%$request->title%")
                    ->orWhere('description', 'like', "%$request->title%");
            });
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
        }
        //dd(getQuery($estates));
        if(!empty($request->floor_count)){
            $estates = $estates->where('floor_count','>',$request->floor_count);
        }
        if(!empty($request->balconmetraj)){
            $estates = $estates->where('balconmetraj','>',0);
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
        $estates = $estates->where('type', 3);
        $estates = !empty($request->id) ? $estates->where('id', (int) $request->id) : $estates;
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

        if($request->pagesize>0){
            $pagesize = $request->pagesize;
        }
        else
        {
            $pagesize = 9;
        }
        $fieldList = getFeatures(0, 0);
        //dd(getQuery($estates));
        $totalCount=$estates->count();

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
        $view = view('site2.frontend.rental.estate_show_type', compact('estates','totalCount','fieldList'))->render();
        return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
    }
    public function rental_list(Request $request)
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
        $estates = $estates->paginate(200);;
        $estates->map(function ($item) use ($dt) {
            $item->isExpired = empty($item->expired_at) && $item->expired_at >= $dt ? 1 : 0;
            $firstImage = $item->images->first();
            $item->coverImage = $item->coverImage();
        });

        $defaultCity = ss('DEFAULT_CITY');
        $citiesSelected = [];
        $citySelected = City::with(['districts' => function ($q) {$q->orderBy('name', 'asc');}])->where('name_en', $defaultCity)->where('active', 1)->first();
        if($citySelected)
        {
            $citiesSelected = City::where('province_id', $citySelected->province_id)->where('active', 1)->get();
        }
        //dd(getQuery($users));
        return view('site2.frontend.rental.estate_list', compact('estates','citySelected','citiesSelected'));
    }
    public function rental_update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return view('frontend.errors.404');
        }
        $estate = Estate::find($id);
        if (empty($estate)) {
            return view('frontend.errors.404');
        }
        if(
            !($estate->user_id == $user->id || $user->isAdmin())
        ){
            return view('frontend.errors.404');
        }
        // find city
        $city = City::with('province')->find($request->city_id);
        // check has default image
        if (!empty($request->default_image))
        {
            $img = Image::find($request->default_image);
        } else
        {
            $img = Image::where('estate_id', $estate->id)->where('hidden','!=',1)->where('plan','!=',1)->where('is_360','!=',1)->first();
        }
        // update default image in table
        if ($img) {
            Image::where('estate_id', $estate->id)->update(['cover' => 0]);
            // update new cover
            $img->update(['cover' => 1]);
        }

        // get request inputs
        $inputs = $request->all();

        if (!empty($request->document)) {
            // all images id
            $imgIds = $request->document;
            // update model_id
            Image::whereIn('id', $imgIds)->update(['estate_id' => $estate->id]);
            if((ss('SITE_ID') == 5 || ss('SITE_ID') == 8) && !$user->isAdmin())
            {
                $inputs['visibility'] = 0;
            }
        }
        $inputs['token'] = $estate->token ?? TokenMaker(8);

        $inputs['province_id'] = $city->province_id ?? null;
        $codition = array();
        if (!empty($inputs['conditions'])){
            foreach($inputs['conditions'] as $cond){
                array_push($codition, $cond);
            }
        }

        $inputs['conditions'] = !empty($codition) && is_array($codition) ? json_encode($codition) : null;
        $inputs['facilities'] = !empty($request->facilities) ? json_encode($request->facilities) : null;
        $inputs['heating_cooling'] = !empty($request->heating_cooling) ? json_encode($request->heating_cooling) : null;
        //$inputs['confirmation'] = 'pending'; //Auth::user()->isAdmin() || Auth::user()->isAdminSite() ? 'verified' : 'pending';
        $inputs['link_rewrite'] = $request->title ? makeLinkRewrite($request->title) : '';
        $inputs['image_count'] = Image::where('estate_id', $estate->id)->count();
        if (!empty($request->mortgage)) $inputs['mortgage'] = str_replace(',', '', $request->mortgage);
        if (!empty($request->rent)) $inputs['rent'] = str_replace(',', '', $request->rent);
        $inputs['confirmation'] = $request->confirmation;
        //dd($request->expertid);
        if($request->expert_id > 0)
        {
            $inputs['expert_id'] = $request->expert_id;
        }
        else
        {
            if($user->isAdmin())
            {

                $finalUser = User::where('username', $request->phone)->first();

                if($finalUser)
                {

                    if(!$finalUser->isRenter())
                    {

                        if($request->owner_name != '')
                        {
                            $role_ids = $finalUser->role_ids;
                            if(is_array($role_ids))
                            {
                                $role_ids[] = 10;
                            }
                            else
                            {
                                $role_ids = [10];
                            }
                            $finalUser->update( [
                                'last_name' => $request->owner_name,
                                'has_role' => 1,
                                'role_ids' => '[' . implode(',' , $role_ids) . ']'
                            ]);
							$finalUser->assignRole( 10 );
							$inputs['expert_id'] = $finalUser->id;
                        }

                    }
                    else
                    {
                        $inputs['expert_id'] = $finalUser->id;
                    }
                }
                else
                {
                    $finalUser = User::create(checkInputs([
                        'username' => $request->phone,
                        'phone' => $request->phone,
                        'last_name' => $request->owner_name,
                        'has_role' => 1,
                        'role_ids' => '[10]',
                        'active' => 1,
                        'status' => 1,
                        'isbongah' => 0
                    ]));
                    $finalUser->assignRole( 10 );
                    $inputs['expert_id'] = $finalUser->id;
                }
            }
        }
        $inputs['image_count'] = Image::where('estate_id', $estate->id)->count();
        $inputs['image_cover'] = $img && !empty($img->dimension['large'])? asset('/upload/images/estate/' .$img->year.'/'.$img->month .'/' . $img->dimension['large']) : null;
        $estate->update(checkInputs($inputs));
        return redirect('/rental/estates');
    }
    public function sortBy($estates, $sortBy, $sortType , $type=1)
    {
        if($type == 1)
        {
            $sortList = [
                1 => 'showdate',
                2 => 'price_per_meter',
                3 => 'price',
                4 => 'built_area',
                5 => 'commission_amount',
                6 => 'commission_percent'
            ];
        }
        else
        {
            $sortList = [
                1 => 'showdate',
                2 => 'price_per_meter',
                3 => 'mortgage',
                4 => 'built_area',
                5 => 'commission_amount',
                6 => 'commission_percent'
            ];
        }
        $sortTypes = [
            1 => 'desc',
            2 => 'asc',
            3 => 'asc',
            5 => 'desc',
            6 => 'desc'
        ];
        if (empty($sortList[$sortBy])) {
            $sortBy = 1;
        }
        if (empty($sortTypes[$sortType])) {
            $sortType = 2;
        }
        $estates = $estates->orderBy($sortList[$sortBy], $sortTypes[$sortType]);
        return $estates;
    }
    public function hitsChart($estate)
    {
        $visitCount = [];
        $estateVisits = EstateVisit::where('estate_id', $estate->id);
        $visitTotal = $estateVisits->sum('visit_count');
        $estateVisits = $estateVisits->orderBy('created_at')
            ->groupBy('created_at')
            ->selectRaw('*, sum(visit_count) as visit_sum')
            ->pluck('visit_sum', 'created_at');
        if (empty($estateVisits)) {
            return null;
        }
        foreach ($estateVisits as $key => $value) {
            $d = Verta($key)->format('Y/m/d');
            $visitCount[$d] = (int)$value;
        }
        $visitCount = collect($visitCount);
        $dimensions = [0, 400];
        $chart = makeChart(false, $dimensions, ' ', 'bar', 'highcharts', false, null, ['#faa61a'], array_keys($visitCount->toArray()), 'تعداد بازدید', array_values($visitCount->toArray()));
        return ['chart' => $chart, 'total' => $visitTotal];
    }
    public function teldivar($id , $returnNumber=false)
    {
        $districts   = [ ];
        $validator = Validator::make(['id' => $id], [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.BAD_REQUEST'));
        }
        if(ss('SITE_ID') == 1){
            $code = 'sim'.rand(1,5);
        }
        if(ss('SITE_ID') == 2){
            $code = 'sim'.rand(1,3);
        }
        $setting  = Setting::where('group','divar')->where('name',$code)->first();
        $code = $setting->value;
		if(trim($code) == ''){
		    $estate = Estate::where('divar', $id)->delete();
            return;
		}
		$curl = curl_init();
		curl_setopt_array($curl, array(
				  CURLOPT_URL => 'https://api.divar.ir/v8/postcontact/web/contact_info/'.$id,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'GET',
				  CURLOPT_POSTFIELDS =>'Host: api.divar.ir
				User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:106.0) Gecko/20100101 Firefox/106.0
				Accept: application/json, text/plain, */*
				Accept-Language: en-US,en;q=0.5
				Accept-Encoding: gzip, deflate, br
				Origin: https://divar.ir
				Sec-Fetch-Dest: empty
				Sec-Fetch-Mode: cors
				Sec-Fetch-Site: same-site
				Authorization: Basic '.$code.'
				Referer: https://divar.ir/
				Connection: keep-alive
				TE: trailers',
				  CURLOPT_HTTPHEADER => array(
					'User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:106.0) Gecko/20100101 Firefox/106.0',
					'Accept:  application/json, text/plain, */*',
					'Accept-Language:  en-US,en;q=0.5',
					'Accept-Encoding:  gzip, deflate, br',
					'Origin:  https://divar.ir',
					'Sec-Fetch-Dest:  empty',
					'Sec-Fetch-Mode:  cors',
					'Sec-Fetch-Site:  same-site',
					'Authorization:  Basic '.$code,
					'Referer:  https://divar.ir/',
					'Connection:  keep-alive',
					'TE:  trailers',
					'Content-Type: text/plain'
				  ),
				));
		$response = curl_exec($curl);
		curl_close($curl);
        $manage = json_decode($response);
        if($manage->widget_list[0]->data->title == "شماره مخفی شده است")
        {
            $estate = Estate::where('divar', $id)->delete();
            if(!$returnNumber){
                return response([ 'status' => 'success', 'result' =>  "شماره مخفی شده است" ], config('StatusCode.SUCCESS'));
            }
            else
            {
                return;
            }
        }
        $mobile = $manage->widget_list[0]->data->action->payload->phone_number;
        $estate = Estate::where('divar', $id)->first();
        if(!preg_match("/^09[0-9]{9}$/", $mobile)) {
            Estate::where('divar', $id)->delete();
        }
        // update image fields of estate model
        $estate->update([
            'phone' => $mobile,
            'owner_name' => $mobile
        ]);
        if(!$returnNumber){
            return response([ 'status' => 'success', 'result' => $mobile ], config('StatusCode.SUCCESS'));
        }
        else
        {
            return;
        }
    }
    public function divar(Request $request, $id)
    {
        set_time_limit(0);

        if(env('COUNTRY') != 'UAE' || 1){
            /*$estates = Estate::where('divar', '<>', '')->where('phone', '<>', '09120000000')->where('created_at', '<',  date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-30 day" ) ) )->get();
            foreach($estates as $estate)
            {
                $this->destroy($estate->id);
            }*/
            switch ($id) {
                case 1:
                    $this->listDivar('tabriz', [], 1);
                    break;
                case 2:
                    $this->listDivar('oromieh', [], 2);
                    break;
                case 3:
                    $this->listDivar('ardabil', [], 3);
                    break;
                case 4:
                    $this->listDivar('isfahan', [], 4);
                    break;
                case 5:
                    $this->listDivar('karaj', [], 5);
                    break;
                case 6:
                    $this->listDivar('ilam', [], 6);
                    break;
                case 7:
                    $this->listDivar('bushehr', [], 7);
                    break;
                case 8:
                    $tehran = (ss('SITE_ID') == 8 || ss('SITE_ID') == 5) ? 2 : 8;
                    $citylist = (ss('SITE_ID') == 8 || ss('SITE_ID') == 5) ? [2]:[];
                    $this->listDivar('tehran', $citylist, $tehran , false);
                    break;
                case 9:
                    $this->listDivar('shahrekord', [], 9);
                    break;
                case 10:
                    $this->listDivar('birjand', [], 10);
                    break;
                case 11:
                    $this->listDivar('mashhad', [], 11);
                    break;
                case 12:
                    $this->listDivar('bojnurd', [], 12);
                    break;
                case 13:
                    $this->listDivar('ahvaz', [], 13);
                    break;
                case 14:
                    $this->listDivar('zanjan', [], 14);
                    break;
                case 15:
                    $this->listDivar('semnan', [], 15);
                    break;
                case 16:
                    $this->listDivar('zahedan', [], 16);
                    break;
                case 17:
                    $this->listDivar('shiraz', [], 17);
                    break;
                case 18:
                    $this->listDivar('ghazvin', [], 18);
                    break;
                case 19:
                    $qomp = (ss('SITE_ID') == 8 || ss('SITE_ID') == 5) ? 3 : 19;
                    $this->listDivar('qom', array(1), $qomp);
                    break;
                case 20:
                    $this->listDivar('sanandaj', [], 20);
                    break;
                case 21:
                    $this->listDivar('kerman', [], 21);
                    break;
                case 22:
                    $this->listDivar('kermanshah', [], 22);
                    break;
                case 23:
                    $this->listDivar('yasooj', [], 23);
                    break;
                case 24:
                    $this->listDivar('gorgan', [], 24);
                    break;
                case 25:
                    $citylist = (ss('SITE_ID') == 2) ? [594,440]:[];
                    //$citylist = [];
                    $this->listDivar('rasht', $citylist , 25);
                    break;
                case 250:
                    $citylist = (ss('SITE_ID') == 2) ? [594,440]:[];
                    //$citylist = [];
                    $this->listDivar('rasht', $citylist , 25);
                    break;
                case 26:
                    $this->listDivar('khorramabad', [], 26);
                    break;
                case 27:
                    $sarip = (ss('SITE_ID') == 8 || ss('SITE_ID') == 5) ? 29 : 27;
                    $citylist = (ss('SITE_ID') == 8 || ss('SITE_ID') == 5) ? [5]:[];
                    $this->listDivar('sari', $citylist, $sarip);
                    break;
                case 28:
                    $this->listDivar('arak', [], 28);
                    break;
                case 29:
                    $this->listDivar('bandarabbas', [], 29);
                    break;
                case 30:
                    $this->listDivar('hamedan', [], 30);
                    break;
                case 31:
                    $this->listDivar('yazd', [], 31);
                    break;
                case 32:
                    $citylist = (ss('SITE_ID') == 2) ? [594,92,440,25]:[];
                    //$citylist = [];
                    $this->listDivarShort('rasht', $citylist , 25);
                    break;
            }
        }
    }
    public function agent()
    {
        //&cities=824%2C825%2C1852%2C1812%2C1688%2C1854%2C708%2C1841%2C829%2C1855%2C1850%2C864%2C1686%2C1844%2C1847%2C1689%2C1809%2C1814%2C1851%2C1839%2C1835%2C12%2C1684%2C1810%2C1849%2C826%2C1683%2C1811%2C861%2C1813%2C1845%2C827%2C860%2C863%2C1840%2C1843%2C1687%2C1846%2C746%2C1690%2C828%2C1836%2C1842%2C1837%2C1848%2C862%2C1815%2C1853%2C1834%2C870%2C1816%2C830%2C26%2C1817%2C27%2C752%2C831%2C753%2C1871%2C663%2C1703%2C1701%2C664%2C710%2C1873%2C832%2C1865%2C1702%2C833%2C834%2C835%2C1694%2C1861%2C1868%2C745%2C1860%2C1698%2C1872%2C1859%2C22%2C1700%2C1699%2C1862%2C1863%2C1697%2C1819%2C836%2C1875%2C665%2C1858%2C1695%2C1696%2C1870%2C1869%2C1864%2C1866%2C1876%2C1856%2C837%2C1867%2C1874%2C1818%2C838%2C744%2C709%2C15%2C839%2C1824%2C671%2C1825%2C840%2C1826%2C18%2C1822%2C1820%2C660%2C33%2C841%2C1821%2C842%2C1828%2C866%2C1827%2C843%2C844%2C14%2C846%2C1829%2C1831%2C871%2C1830%2C845%2C16%2C1691%2C748%2C751%2C823%2C750%2C1692%2C1832%2C21%2C749%2C743%2C1693%2C819%2C1801%2C820%2C854%2C855%2C1800%2C9%2C821%2C1802%2C1799%2C1804%2C1805%2C1807%2C815%2C816%2C817%2C867%2C818%2C13%2C1803%2C1806%2C662%2C868%2C1798%2C812%2C28%2C813%2C1797%2C814%2C869%2C1795%2C872%2C811%2C1796%2C19%2C873%2C851%2C1728%2C808%2C1793%2C809%2C1791%2C6%2C810%2C1789%2C1734%2C1790%2C1730%2C1731%2C1788%2C1792%2C1794%2C1726%2C807%2C747%2C1785%2C706%2C11%2C1787%2C865%2C1786%2C805%2C35%2C707%2C806%2C802%2C803%2C20%2C804%2C24%2C1779%2C796%2C7%2C797%2C798%2C37%2C314%2C1782%2C1784%2C799%2C23%2C1781%2C800%2C756%2C1780%2C754%2C602%2C317%2C1783%2C793%2C794%2C39%2C795%2C1735%2C1729%2C791%2C1776%2C1732%2C1736%2C316%2C1775%2C1774%2C1733%2C1777%2C1773%2C847%2C3%2C1778%2C318%2C34%2C788%2C789%2C790%2C785%2C1833%2C36%2C786%2C787%2C778%2C1756%2C779%2C780%2C25%2C1757%2C1755%2C775%2C32%2C776%2C777%2C1823%2C1722%2C1721%2C1739%2C1740%2C850%2C1751%2C2%2C1738%2C1720%2C1753%2C1752%2C774%2C1754%2C1737%2C1723%2C4%2C1747%2C1727%2C1750%2C1724%2C1725%2C1744%2C849%2C1745%2C1746%2C30%2C848%2C1749%2C1748%2C31%2C17%2C771%2C772%2C1741%2C1743%2C773%2C1742%2C10%2C859%2C765%2C766%2C767%2C857%2C768%2C858%2C856%2C769%2C792%2C770%2C853%2C759%2C760%2C5%2C852%2C761%2C762%2C763%2C764%2C1709%2C1715%2C1714%2C29%2C1764%2C1707%2C1768%2C1760%2C1767%2C1766%2C781%2C1%2C1718%2C782%2C783%2C1765%2C1769%2C1763%2C1713%2C1717%2C1759%2C1712%2C1710%2C1716%2C1772%2C1770%2C1758%2C1761%2C1708%2C1719%2C1706%2C1771%2C784%2C1711%2C1762%2C8
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.divar.ir/v8/web-search/iran/real-estate?business-type=real-estate-business',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/plain'
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);
        $manage = json_decode($response);
        if($manage == null || $manage->web_widgets == null){
            return;
        }
        if($manage == null || $manage->web_widgets == null){
            return;
        }
        $_widget_list = $manage->web_widgets->post_list;
        //dd($_widget_list);
        foreach ($_widget_list as $wl) {
            if(!isset($wl->data->token)){
				continue;
			}
            $this->agent2($wl->data->token);
        }
    }
    public function agent2($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_URL,"https://api.divar.ir/v8/posts-v2/web/".$id);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
        $response = curl_exec($ch);
        curl_close($ch);
        $manage = json_decode($response);
        if($manage == null){
            return;
        }
        foreach ($manage->sections as $section)
        {
            if($section->section_name == "LIST_DATA")
            {
                foreach ($section->widgets as $list_data) {
                    if($list_data->widget_type == "UNEXPANDABLE_ROW")
                    {
                        if ($list_data->data->title == 'مشاور املاک')
                        {
                            $name = $list_data->data->value;
                            $city = $manage->analytics->city;
                            $mobile = $this->agent3($list_data->data->action->payload->slug);
                            $finalUser = Agents::where('mobile', $mobile)->first();
                            if($finalUser == null)
                            {
                                $finalUser = Agents::create([
                                    'name' => $name,
                                    'mobile' => $mobile,
                                    'city' => $city
                                ]);
                            }

                            $finalDistrict = AgentDistrict::where('divar_id', $id)->where('agent_id', $finalUser->id)->first();

                            if($finalDistrict == null && isset($manage->seo->web_info->district_persian))
                            {
                                AgentDistrict::create([
                                    'divar_id' => $id,
                                    'agent_id' => $finalUser->id,
                                    'city' => $city,
                                    'street' => $manage->seo->web_info->district_persian
                                ]);
                            }
                            //dd(array($name , $city , $mobile));
                        }
                    }
                }
            }
        }
    }
    public function agent3($id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.divar.ir/v8/real-estate/w/agency-public-view',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"request_data":{"slug":"'.$id.'"},"specification":{"tab_identifier":"AGENT_INFO","filter_data":{}}}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: text/plain'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $manage = json_decode($response);
        //dd($manage->page);
        foreach ($manage->page->widget_list as $list_data){

            if($list_data->widget_type == "UNEXPANDABLE_ROW")
            {
                if ($list_data->data->title == 'موبایل')
                {
                    //dd($list_data->data->value);
                    $v = str_replace(array(',','۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('','0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                    return $v;
                    //$this->agent3($list_data->data->action->payload->slug);
                }
            }

        }
    }
    public function sheypoor(Request $request, $id)
    {
        set_time_limit(0);
        if(env('COUNTRY') != 'UAE'){
            switch ($id) {
                case 1:
                    $this->listSheypoor('tabriz', [], 1);
                    break;
                case 2:
                    $this->listSheypoor('oromieh', [], 2);
                    break;
                case 3:
                    $this->listSheypoor('ardabil', [], 3);
                    break;
                case 4:
                    $this->listSheypoor('isfahan', [], 4);
                    break;
                case 5:
                    $this->listSheypoor('karaj', [], 5);
                    break;
                case 6:
                    $this->listSheypoor('ilam', [], 6);
                    break;
                case 7:
                    $this->listSheypoor('bushehr', [], 7);
                    break;
                case 8:
                    $tehran = (ss('SITE_ID') == 8 || ss('SITE_ID') == 5) ? 2 : 8;
                    $citylist = (ss('SITE_ID') == 8 || ss('SITE_ID') == 5) ? [2]:[];
                    $this->listSheypoor('tehran', $citylist, $tehran , false);
                    break;
                case 9:
                    $this->listSheypoor('shahrekord', [], 9);
                    break;
                case 10:
                    $this->listSheypoor('birjand', [], 10);
                    break;
                case 11:
                    $this->listSheypoor('mashhad', [], 11);
                    break;
                case 12:
                    $this->listSheypoor('bojnurd', [], 12);
                    break;
                case 13:
                    $this->listSheypoor('ahvaz', [], 13);
                    break;
                case 14:
                    $this->listSheypoor('zanjan', [], 14);
                    break;
                case 15:
                    $this->listSheypoor('semnan', [], 15);
                    break;
                case 16:
                    $this->listSheypoor('zahedan', [], 16);
                    break;
                case 17:
                    $this->listSheypoor('shiraz', [], 17);
                    break;
                case 18:
                    $this->listSheypoor('ghazvin', [], 18);
                    break;
                case 19:
                    $qomp = (ss('SITE_ID') == 5) ? 3 : 19;
                    $this->listSheypoor('qom', array(1), $qomp);
                    break;
                case 20:
                    $this->listSheypoor('sanandaj', [], 20);
                    break;
                case 21:
                    $this->listSheypoor('kerman', [], 21);
                    break;
                case 22:
                    $this->listSheypoor('kermanshah', [], 22);
                    break;
                case 23:
                    $this->listSheypoor('yasooj', [], 23);
                    break;
                case 24:
                    $this->listSheypoor('gorgan', [], 24);
                    break;
                case 25:
                    $citylist = (ss('SITE_ID') == 2) ? [594,440]:[];
                    $this->listSheypoor('rasht', $citylist , 25);
                    break;
                case 26:
                    $this->listSheypoor('khorramabad', [], 26);
                    break;
                case 27:
                    $sarip = (ss('SITE_ID') == 5) ? 29 : 27;
                    $citylist = (ss('SITE_ID') == 5) ? [5]:[];
                    $this->listSheypoor('sari', $citylist, $sarip);
                    break;
                case 28:
                    $this->listSheypoor('arak', [], 28);
                    break;
                case 29:
                    $this->listSheypoor('bandarabbas', [], 29);
                    break;
                case 30:
                    $this->listSheypoor('hamedan', [], 30);
                    break;
                case 31:
                    $this->listSheypoor('yazd', [], 31);
                    break;
            }
        }
    }
    public function listDivarShort($city, $cityid, $provinceid , $rahn = true)
    {
        $qomp = (ss('SITE_ID') == 8 || ss('SITE_ID') == 5) ? 3 : 19;
        $city2 = City::where('province_id', $provinceid)->where('active', 1);
        if(is_array($cityid) && count($cityid)>0)
        {
            $city2 = $city2->whereIn('id', $cityid);
        }
        $city2 = $city2->inRandomOrder()->first();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.divar.ir/v8/web-search/'.$city2->name_en.'/rent-temporary-villa',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/plain'
            ),
        ));

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);
        $manage = json_decode($response);
        //dd($manage);
        if($manage == null || $manage->web_widgets == null){
            return;
        }
        $_widget_list = $manage->web_widgets->post_list;

        foreach ($_widget_list as $wl) {
            if(!isset($wl->data->token)){
                continue;
            }
            $district = Estate::where('divar', $wl->data->token)->first();
            if (!$district) {
                $this->divarShort($wl->data->token, 1, $city2->id, $provinceid);
            }
        }
        return;

    }
    public function listDivar($city, $cityid, $provinceid , $rahn = true)
    {

        $qomp = (ss('SITE_ID') == 8 || ss('SITE_ID') == 5) ? 3 : 19;
        if($provinceid == $qomp)
        {
            if(ss('SITE_ID') == 5)
            {
                $rahn = false;
            }
            $city2 = City::whereIn('id', $cityid)
            ->where('active', 1)
            ->inRandomOrder()->first();
        }
        else
        {
            $city2 = City::where('province_id', $provinceid)->where('active', 1);
            if(is_array($cityid) && count($cityid)>0)
            {
                $city2 = $city2->whereIn('id', $cityid);
            }
            $city2 = $city2->inRandomOrder()->first();
        }
        $response = file_get_contents("https://divar2.liara.run/list.php?city=".$city2->code."&type=sell");
        //$response = file_get_contents("https://kolb.iran.liara.run/list.php?city=".$city2->code."&type=sell");
        $manage = json_decode($response);

        if($manage == null){
            return;
        }
        $_widget_list = $manage->list_widgets;
        //dd($_widget_list);
        foreach ($_widget_list as $wl) {
            //dd($wl->data->action->payload->token);
            if(!isset($wl->data->action->payload->token)){
				continue;
			}

            $district = Estate::where('divar', $wl->data->action->payload->token)->first();
            if (!$district) {
                $this->divar2($wl->data->action->payload->token, 1, $city2->id, $provinceid);
            }
        }
        if($rahn)
        {
            $response = file_get_contents("https://divar2.liara.run/list.php?city=".$city2->code."&type=rent");
            //$response = file_get_contents("https://kolb.iran.liara.run/list.php?city=".$city2->code."&type=rent");
            $manage = json_decode($response);
            if($manage == null){
                return;
            }
            $_widget_list = $manage->list_widgets;
            //dd($_widget_list);
            foreach ($_widget_list as $wl) {
                //dd($wl->data->action->payload->token);
                if(!isset($wl->data->action->payload->token)){
                    continue;
                }

                $district = Estate::where('divar', $wl->data->action->payload->token)->first();
                if (!$district) {
                    $this->divar2($wl->data->action->payload->token, 2, $city2->id, $provinceid);
                }
            }


        }
    }
    public function listSheypoor($city, $cityid, $provinceid , $rahn = true)
    {
        $qomp = (ss('SITE_ID') == 5 ) ? 3 : 19;
        if($provinceid == $qomp)
        {
            $city2 = City::whereIn('id', $cityid)
            ->where('active', 1)
            ->inRandomOrder()->first();
        }
        else
        {
            $city2 = City::where('province_id', $provinceid)->where('active', 1);
            if(is_array($cityid) && count($cityid)>0)
            {
                $city2 = $city2->whereIn('id', $cityid);
            }
            $city2 = $city2->inRandomOrder()->first();
        }

        $c = $city2->name_en;
        if($c == 'pare-sar')
        {
            $c = 'pareh-sar';
        }
        if($c == 'rezvanshahr' || 1)
        {
            $c = 'gilan-rezvanshahr';
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.sheypoor.com/api/v10.0.0/search/'.$c.'/real-estate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/plain'
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);
        $manage = json_decode($response);
        if($manage == null){
            return;
        }
        $_widget_list = $manage->data;
        //dd($_widget_list);
        foreach ($_widget_list as $wl) {
            if(!isset($wl->id)){
				continue;
			}
            $district = Estate::where('divar', 'sheypoor-'.$wl->id)->first();
            if (!$district) {
                $this->sheypoor2($wl->id, 1, $city2->id, $provinceid);
            }
            break;
        }
    }
    public function sheypoor2($id, $type, $cityid, $provinceid)
    {
        //$id = 'QZFNeT1Q';
        echo $id . '<br>';
        $inputs = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_URL,"https://www.sheypoor.com/api/v10.0.0/listings/".$id);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
        $response = curl_exec($ch);
        curl_close($ch);
        $manage = json_decode($response);

        list($ret , $mobile) = $this->getMobileSheypoor($id);
        echo $mobile;
        //
        if(!$ret || $mobile==''){
            return ;
        }
        //dd($mobile);
        //$mobile = '09124525207';
        $inputs['token'] = TokenMaker(8);
        $finalUser = User::where('username', $mobile)->first();
        if($finalUser){
            if($finalUser->isbongah == 1)
            {
                return;
            }
        }
        else
        {
            $finalUser = User::create(checkInputs([
                'username' => $mobile,
                'phone' => $mobile,
                'has_role' => 0,
                'active' => 0,
                'status' => 1,
                'isbongah' => 0
            ]));
        }
        $inputs['user_id'] = $finalUser->id;
        $inputs['owner_name'] = $mobile;
        $inputs['phone'] = $mobile;
        $inputs['province_id'] = $provinceid;
        $inputs['city_id'] = $cityid;
        //
        $inputs['published_at'] = date('Y-m-d H:i:s');
        $inputs['showdate'] = date('Y-m-d H:i:s');
        if($manage == null)
        {
            return;
        }
        if(!isset($manage->data))
        {
            return;
        }
        // if($manage->data->attributes === null)
        // {
        //     return;
        // }

        $estate_type = -1;
        foreach($manage->data->attributes->attributes as $att) {
            if($att->key == "نوع ملک")
            {
                switch($att->value)
                {
                    case "آپارتمان":
                        $estate_type = 1;
                        break;
                    case "خانه و کلنگی":
                        $estate_type = 2;
                        break;
                    case "تجاری و مغازه":
                        $estate_type = 3;
                        break;
                    default:
                    $estate_type = -1;
                }
            }
            if ($att->key == 'متراژ') {
                $inputs['area'] =  str_replace(array(',','۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('','0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $att->value);
            }
            if ($att->key == 'تعداد اتاق') {
                switch ($att->value) {
                    case '1':
                        $inputs['room_count'] = 187;
                        break;
                    case '2':
                        $inputs['room_count'] = 188;
                        break;
                    case '3':
                        $inputs['room_count'] = 189;
                        break;
                    case '4':
                        $inputs['room_count'] = 190;
                        break;
                }
            }
            if ($att->key == 'آسانسور' && $att->value == "دارد") {
                $_a[] = '"37"';
            }
            if ($att->key == 'پارکینگ' && $att->value == "دارد") {
                $_a[] = '"35"';
            }
            if ($att->key == 'انباری' && $att->value == "دارد") {
                $_a[] = '"36"';
            }

            if ($att->key == 'سن بنا') {
                if ($att->value == 'بیشتر از 30 سال')
                    $inputs['built_year'] = 234;
                elseif ($att->value == 'نوساز')
                    $inputs['built_year'] = date('Y') - 621;
                else
                    $inputs['built_year'] =  date('Y') - 621 - str_replace(array(' سال', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $att->value);
            }
            if ($att->key == "قیمت هر متر") {
                $type = 1;
                $inputs['price_per_meter'] =  str_replace(array(' تومان', ',', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $att->value);
            }
            if ($att->key == "رهن") {
                $type = 2;
                $inputs['mortgage'] = str_replace(array(' تومان', ',', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $att->value);
                if ($inputs['mortgage'] == 'توافقی') {
                    return;
                }
            }
            if ($att->key == "اجاره")
            {
                $type = 2;
                $inputs['rent'] = str_replace(array(' تومان', ',', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $att->value);
                if ($inputs['rent'] == 'توافقی') {
                    return;
                }
            }
        }

        if($estate_type == -1){
            return;
        }
        if (isset($_a) && is_array($_a)) {
            $inputs['facilities'] = '[' . implode(',', $_a) . ']';
        }
        $inputs['estate_type'] = $estate_type;
        $inputs['type'] = $type;

        if ($type == 1) {
            $inputs['price'] = $manage->data->attributes->price[0]->amount;
            if ($inputs['price'] == 'توافقی') {
                return;
            }
        }

        if(count($manage->data->attributes->breadcrumbs) == 5)
        {
            $district = District::where('city_id', $cityid)->where('name', $manage->data->attributes->breadcrumbs[4]->title)->first();
            if (isset($district)) {
                $inputs['district_id'] = $district->id;
            } else {
                $district = District::create([
                    'province_id' => $provinceid,
                    'city_id' => $cityid,
                    'name' => $manage->data->attributes->breadcrumbs[4]->title,
                    'active' => 1,
                    'divar' => 2
                ]);
                $inputs['district_id'] = $district->id;
            }
        }

        $inputs['title'] = $manage->data->attributes->title;
        $inputs['description'] = strip_tags($manage->data->attributes->description);

        /*if(str_contains($inputs['description'], 'همکار')
        || str_contains($inputs['description'], 'املاک')
        || str_contains($inputs['description'], 'دهات')
        || str_contains($inputs['description'], 'قرارداد')
        || str_contains($inputs['description'], 'خرید و فروش')
        || str_contains($inputs['description'], 'مزرعه')
        || str_contains($inputs['description'], 'درخت')
        || str_contains($inputs['description'], 'چاه')
        || str_contains($inputs['description'], 'ساعت')
        || str_contains($inputs['description'], 'مشاور')
        || str_contains($inputs['description'], 'فایل')
        || str_contains($inputs['description'], 'فایلینک')
        || str_contains($inputs['description'], 'دپارتمان')
        || str_contains($inputs['description'], 'آوه')
        || str_contains($inputs['description'], 'مبارک آباد')
        || str_contains($inputs['description'], 'جنت آباد')
        || str_contains($inputs['description'], 'صالح آباد')
        || str_contains($inputs['description'], 'تاج خاتون')
        || str_contains($inputs['description'], 'حاجی آباد')
        || str_contains($inputs['description'], 'قمرود')
        || str_contains($inputs['description'], 'میم')
        || str_contains($inputs['description'], 'سراجه')
        || str_contains($inputs['description'], 'وشنوه')
        || str_contains($inputs['description'], 'خاوه')
        || str_contains($inputs['description'], 'جنداب')
        || str_contains($inputs['description'], 'دستجرد')
        || str_contains($inputs['description'], 'لنگرود')
        || str_contains($inputs['description'], 'ورجان')
        || str_contains($inputs['description'], 'بنگاه')
        || str_contains($inputs['description'], 'طایقان')
        || str_contains($inputs['description'], 'فردو')
        || str_contains($inputs['description'], 'روستا')
        || str_contains($inputs['description'], 'باغ')
        || str_contains($inputs['description'], 'قنوات')
        || str_contains($inputs['description'], 'راهجرد')
        || str_contains($inputs['description'], 'سنجگان')
        || str_contains($inputs['description'], 'بیک محمد')
        || str_contains($inputs['description'], 'قلعه حیدری')
        || str_contains($inputs['description'], 'راوه')
        || str_contains($inputs['description'], 'وشاره')
        || str_contains($inputs['description'], 'خدیجه خاتون')
        || str_contains($inputs['description'], 'جزه')
        || str_contains($inputs['description'], 'سنجان')
        || str_contains($inputs['description'], 'نایه')
        || str_contains($inputs['description'], 'حیدرآباد')
        || str_contains($inputs['description'], 'لبن')
        || str_contains($inputs['description'], 'ازدیدار')
        || str_contains($inputs['description'], 'از دیدار')
        || str_contains($inputs['description'], 'کارشناس')
        || str_contains($inputs['description'], 'تماس')
        || str_contains($inputs['description'], 'تلفن')
        || str_contains($inputs['description'], 'کهک')
        || str_contains($inputs['description'], 'آشتیان')
        || str_contains($inputs['description'], 'ایستگاه محمدیه')
        || str_contains($inputs['description'], 'امامزاده اسماعیل')
        || str_contains($inputs['description'], 'قلعه صدری')
        || str_contains($inputs['description'], 'آمره')
        || str_contains($inputs['description'], 'باغ یک')
        || str_contains($inputs['description'], 'بشارت')
        || str_contains($inputs['description'], 'خاتون')
        || str_contains($inputs['description'], 'حاجی')
        || str_contains($inputs['description'], 'نیزار')
        || str_contains($inputs['description'], 'خرم آباد')
        || str_contains($inputs['description'], 'زوار')
        || str_contains($inputs['description'], 'سنجگ')
        || str_contains($inputs['description'], 'طایق')
        || str_contains($inputs['description'], 'فوجرد')
        || str_contains($inputs['description'], 'کوه سفید')
        || str_contains($inputs['description'], 'گیو')
        || str_contains($inputs['description'], 'موجان')
        || str_contains($inputs['description'], 'بشاره')
        || str_contains($inputs['description'], 'اندیس')
        || str_contains($inputs['description'], 'قاضی')
        || str_contains($inputs['description'], 'قباد')
        || str_contains($inputs['description'], 'منصورآباد')
        || str_contains($inputs['description'], 'دهکده صبا')
        || str_contains($inputs['description'], 'راوه')
        || str_contains($inputs['description'], 'مهری آباد')
        || str_contains($inputs['description'], 'خاوه')
        || str_contains($inputs['description'], 'کندرود')
        || str_contains($inputs['description'], 'مشابه')
        || str_contains($inputs['description'], 'متفاوت')
        || str_contains($inputs['description'], 'سرمایه')
        || str_contains($inputs['description'], 'فروشنده')
        || str_contains($inputs['description'], 'واقعی')
        || str_contains($inputs['description'], 'دفتر')
        || str_contains($inputs['description'], 'زیزیگان')
        || str_contains($inputs['description'], 'سازنده بنام')
        || str_contains($inputs['description'], 'سازنده خوشنام')
        || str_contains($inputs['description'], 'آدرس دفتر')
        || str_contains($inputs['description'], 'پاسخگوی شما آقا')
        || str_contains($inputs['description'], 'پاسخگوی شما خانم')
        || str_contains($inputs['description'], '09')
        || preg_match('~[0-9]{6,}}~', $inputs['description'])
        )
        {
            return;
        }
        if(str_contains($inputs['title'], 'همکار')
        || str_contains($inputs['title'], 'املاک')
        || str_contains($inputs['title'], 'دهات')
        || str_contains($inputs['title'], 'قرارداد')
        || str_contains($inputs['title'], 'خرید و فروش')
        || str_contains($inputs['title'], 'مزرعه')
        || str_contains($inputs['title'], 'درخت')
        || str_contains($inputs['title'], 'چاه')
        || str_contains($inputs['title'], 'ساعت')
        || str_contains($inputs['title'], 'مشاور')
        || str_contains($inputs['title'], 'فایلینگ')
        || str_contains($inputs['title'], 'فایلینک')
        || str_contains($inputs['title'], 'دپارتمان')
        || str_contains($inputs['title'], 'آوه')
        || str_contains($inputs['title'], 'مبارک آباد')
        || str_contains($inputs['title'], 'جنت آباد')
        || str_contains($inputs['title'], 'صالح آباد')
        || str_contains($inputs['title'], 'تاج خاتون')
        || str_contains($inputs['title'], 'حاجی آباد')
        || str_contains($inputs['title'], 'قمرود')
        || str_contains($inputs['title'], 'میم')
        || str_contains($inputs['title'], 'سراجه')
        || str_contains($inputs['title'], 'وشنوه')
        || str_contains($inputs['title'], 'خاوه')
        || str_contains($inputs['title'], 'جنداب')
        || str_contains($inputs['title'], 'دستجرد')
        || str_contains($inputs['title'], 'لنگرود')
        || str_contains($inputs['title'], 'ورجان')
        || str_contains($inputs['title'], 'بنگاه')
        || str_contains($inputs['title'], 'طایقان')
        || str_contains($inputs['title'], 'فردو')
        || str_contains($inputs['title'], 'روستا')
        || str_contains($inputs['title'], 'باغ')
        || str_contains($inputs['title'], 'قنوات')
        || str_contains($inputs['title'], 'راهجرد')
        || str_contains($inputs['title'], 'سنجگان')
        || str_contains($inputs['title'], 'بیک محمد')
        || str_contains($inputs['title'], 'قلعه حیدری')
        || str_contains($inputs['title'], 'راوه')
        || str_contains($inputs['title'], 'وشاره')
        || str_contains($inputs['title'], 'خدیجه خاتون')
        || str_contains($inputs['title'], 'جزه')
        || str_contains($inputs['title'], 'سنجان')
        || str_contains($inputs['title'], 'نایه')
        || str_contains($inputs['title'], 'حیدرآباد')
        || str_contains($inputs['title'], 'لبن')
        || str_contains($inputs['title'], 'ازدیدار')
        || str_contains($inputs['title'], 'از دیدار')
        || str_contains($inputs['title'], 'کارشناس')
        || str_contains($inputs['title'], 'تماس')
        || str_contains($inputs['title'], 'تلفن')
        || str_contains($inputs['title'], 'کهک')
        || str_contains($inputs['title'], 'آشتیان')
        || str_contains($inputs['title'], 'ایستگاه محمدیه')
        || str_contains($inputs['title'], 'امامزاده اسماعیل')
        || str_contains($inputs['title'], 'قلعه صدری')
        || str_contains($inputs['title'], 'آمره')
        || str_contains($inputs['title'], 'باغ یک')
        || str_contains($inputs['title'], 'بشارت')
        || str_contains($inputs['title'], 'خاتون')
        || str_contains($inputs['title'], 'حاجی')
        || str_contains($inputs['title'], 'نیزار')
        || str_contains($inputs['title'], 'خرم آباد')
        || str_contains($inputs['title'], 'زوار')
        || str_contains($inputs['title'], 'سنجگ')
        || str_contains($inputs['title'], 'طایق')
        || str_contains($inputs['title'], 'فوجرد')
        || str_contains($inputs['title'], 'کوه سفید')
        || str_contains($inputs['title'], 'گیو')
        || str_contains($inputs['title'], 'موجان')
        || str_contains($inputs['title'], 'بشاره')
        || str_contains($inputs['title'], 'اندیس')
        || str_contains($inputs['title'], 'قاضی')
        || str_contains($inputs['title'], 'قباد')
        || str_contains($inputs['title'], 'منصورآباد')
        || str_contains($inputs['title'], 'دهکده صبا')
        || str_contains($inputs['title'], 'راوه')
        || str_contains($inputs['title'], 'مهری آباد')
        || str_contains($inputs['title'], 'خاوه')
        || str_contains($inputs['title'], 'کندرود')
        || str_contains($inputs['title'], 'مشابه')
        || str_contains($inputs['title'], 'متفاوت')
        || str_contains($inputs['title'], 'سرمایه')
        || str_contains($inputs['title'], 'فروشنده')
        || str_contains($inputs['title'], 'واقعی')
        || str_contains($inputs['title'], 'دفتر')
        || str_contains($inputs['title'], 'زیزیگان')
        || str_contains($inputs['title'], '09')
        || preg_match('~[0-9]{6,}}~', $inputs['title'])
        )
        {
            return;
        }*/

        if(1 || ss('SITE_ID') != 3){
            $inputs['confirmation'] = 'verified';
        }
        else
        {
            $inputs['confirmation'] = 'pending';
        }
        $inputs['visibility'] = 1;
        $inputs['divar'] = 'sheypoor-'.$id;
        $inputs['last_activity'] = Carbon::now();

        foreach ($manage->data->attributes->images as $section){
            $images[] = $section->source->desktop;
        }

        $estate = Estate::create($inputs);
        //dd($estate);

        if($estate->phone != null && ss('SITE_ID') == 2 && in_array($cityid , [594,92,440,25]))
        {
            $suggest = getsetting('sms','addestate');
            $arrSearch = array("{0}");
            $arrReplace = array($estate->id);
            $text = str_replace($arrSearch, $arrReplace, $suggest);
            sendSms($estate->phone , $text);
        }
        if($estate->phone != null && ss('SITE_ID') == 5 && in_array($cityid , [1]))
        {
            if($type == 1)
            {
                $suggest = getsetting('sms','addestatebuy');
            }
            else
            {
                $suggest = getsetting('sms','addestaterent');
            }
            $arrSearch = array("{0}");
            $arrReplace = array($estate->id);
            $text = str_replace($arrSearch, $arrReplace, $suggest);
            sendSms($estate->phone , $text);
        }
        updateExpert($estate);
        relCustomer($estate->id);
        $default_image = '';
        if(isset($images))
        foreach ($images as $image) {
            $__images = $this->storeMedia2($image, $estate->id);
            if ($default_image == '') {
                $default_image = $__images;
            }
        }
        $img = Image::where('estate_id', $estate->id)->where('is_360',0)->first();
        // update image fields of estate model
        $estate->update([
            'image_count' => Image::where('estate_id', $estate->id)->count(),
            'image_cover' => $img ? asset('/upload/images/estate/'.date('Y').'/'.date('m') .'/'. $img->dimension['large']) : null,
        ]);
        // update default image in images table
        if ($img) {
            $img->update(['cover' => 1]);
        }
    }
    public function divar2($id, $type, $cityid, $provinceid)
    {
        //$id = 'QZFNeT1Q';
        echo $id . '<br>';
        $inputs = [];
        $countEstate = Estate::where('divar', '<>', '')->where('created_at', '>', date('Y-m-d 00:00:00'))->count();
        $idd = intdiv($countEstate, 240) + 1;
        $response = file_get_contents("https://divar2.liara.run/divar.php?id=".$id);
        //$response = file_get_contents("https://kolb.iran.liara.run/divar.php?id=".$id);
        $manage = json_decode($response);


        $inputs['province_id'] = $provinceid;
        $inputs['city_id'] = $cityid;
        $inputs['type'] = $type;
        $inputs['published_at'] = date('Y-m-d H:i:s');
        $inputs['showdate'] = date('Y-m-d H:i:s');

        if($manage == null)
        {
            echo '$manage == null<br>';
            return;
        }

        switch ($manage->seo->web_info->category_slug_persian)
        {
            case 'فروش خانه و ویلا':
                $estate_type = 2;
                break;
            case 'فروش آپارتمان':
                $estate_type = 1;
                break;
            case 'فروش زمین و ملک کلنگی':
                $estate_type = 4;
                break;
            case 'اجارهٔ خانه و ویلا':
                $estate_type = 2;
                break;
            case 'اجارهٔ آپارتمان':
                $estate_type = 1;
                break;
            case 'اجارهٔ زمین و ملک کلنگی':
                $estate_type = 4;
                break;
            default:
                $estate_type = -1;
        }
        if($estate_type == -1){
            echo '$estate_type == -1<br>';
            return;
        }
        $inputs['estate_type'] = $estate_type;

        foreach ($manage->sections as $section){
            if($section->section_name == "IMAGE")
            {
                foreach ($section->widgets as $list_data)
                {

                    $images = $list_data->data->items;
                }
            }

            if($section->section_name == "DESCRIPTION")
            {
                foreach ($section->widgets as $list_data)
                {
                    if($list_data->widget_type == "DESCRIPTION_ROW")
                    {
                        $inputs['description'] = $list_data->data->text;
                    }
                }
            }
            if($section->section_name == "MAP")
            {
                foreach($section->widgets as $widget)
                {
                    if (isset($widget->data->location->fuzzy_data->point->latitude)) {
                        $inputs['latitude'] = trim($widget->data->location->fuzzy_data->point->latitude);
                        $inputs['latitude_secondary'] = trim($widget->data->location->fuzzy_data->point->latitude);
                    }
                    if (isset($widget->data->location->fuzzy_data->point->longitude)) {
                        $inputs['longitude'] = trim($widget->data->location->fuzzy_data->point->longitude);
                        $inputs['longitude_secondary'] = trim($widget->data->location->fuzzy_data->point->longitude);
                    }
                }
            }
            if($section->section_name == "LIST_DATA")
            {
                foreach ($section->widgets as $list_data) {
                    if($list_data->widget_type == "GROUP_INFO_ROW")
                    {
                        foreach ($list_data->data->items as $item)
                        {
                            if ($item->title == 'متراژ') {
                                $inputs['area'] =  str_replace(array(' متر', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $item->value);
                            }
                            /*if ($item->title == 'متراژ بنا') {
                                $inputs['built_area'] =  str_replace(array(' متر', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $item->value);
                            }*/
                            if ($item->title == 'ساخت') {
                                if ($item->value == 'قبل از ۱۳۷۰')
                                    $inputs['built_year'] = 234;
                                else
                                    $inputs['built_year'] =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $item->value);
                            }
                            if ($item->title == 'اتاق') {
                                $item->value =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $item->value);
                                switch ($item->value) {
                                    case '1':
                                        $inputs['room_count'] = 187;
                                        break;
                                    case '2':
                                        $inputs['room_count'] = 188;
                                        break;
                                    case '3':
                                        $inputs['room_count'] = 189;
                                        break;
                                    case '4':
                                        $inputs['room_count'] = 190;
                                        break;
                                }
                            }
                        }
                    }
                    if($list_data->widget_type == "UNEXPANDABLE_ROW")
                    {
                        if ($type == 1) {
                            if ($list_data->data->title == 'قیمت کل') {
                                $inputs['price'] = str_replace(array('،',' تومان', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('','', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                                if ($inputs['price'] == 'توافقی') {
                                    echo '$price == توافقی<br>';
                                    return;
                                }
                            }
                            if ($list_data->data->title == 'قیمت هر متر') {
                                $inputs['price_per_meter'] =  str_replace(array('،',' تومان', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('','', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                            }
                        }
                        if ($type == 2) {
                            if ($list_data->data->title == 'ودیعه') {
                                $inputs['mortgage'] = str_replace(array('،',' تومان', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('','', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                                if ($inputs['mortgage'] == 'توافقی') {
                                    echo 'mortgage == توافقی<br>';
                                    return;
                                }
                                if ($inputs['mortgage'] == 'مجانی')
                                {
                                    $inputs['mortgage'] = 0;
                                }
                            }
                            if ($list_data->data->title == 'اجارهٔ ماهانه') {
                                if ($list_data->data->value == 'مجانی')
                                    $inputs['rent'] = 0;
                                else
                                    $inputs['rent'] = str_replace(array('،',' تومان', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('','', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                                if ($inputs['rent'] == 'توافقی') {
                                    echo 'rent == توافقی<br>';
                                    return;
                                }
                            }
                            if ($list_data->data->title == 'ودیعه و اجاره') {
                                if ($list_data->data->value == 'غیر قابل تبدیل') {
                                    $inputs['convertible'] = 2;
                                }
                                if ($list_data->data->value == 'قابل تبدیل') {
                                    $inputs['convertible'] = 1;
                                }
                                if ($inputs['convertible'] == 'توافقی') {
                                    echo 'convertible == توافقی<br>';
                                    return;
                                }
                            }
                        }
                        if ($list_data->data->title == 'متراژ') {
                            $inputs['area'] =  str_replace(array('،',' متر', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('','', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                        }
                        if ($list_data->data->title == 'متراژ زمین') {
                            if($inputs['area']>0){
                                $inputs['built_area'] = $inputs['area'];
                            }
                            $inputs['area'] =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                        }
                        if ($list_data->data->title == 'طبقه') {
                            if (str_contains($list_data->data->value, 'از')) {
                                $value = explode(' از ', $list_data->data->value);
                                if ($value[0] == 'همکف')
                                    $inputs['floor'] = 122;
                                elseif ($value[0] == 'زیرهمکف')
                                    $inputs['floor'] = 121;
                                else
                                    $inputs['floor'] = 122 + str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $value[0]);
                                if((int)$value[1]>0)
                                {
                                    $inputs['floor_count'] = 154 + str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $value[1]);
                                }
                            } else {
                                if ($list_data->data->value == 'همکف')
                                    $inputs['floor'] = 122;
                                elseif ($list_data->data->value == 'زیرهمکف')
                                    $inputs['floor'] = 121;
                                else
                                    $inputs['floor'] = 122 + str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                            }
                        }
                    }
                    if($list_data->widget_type == "GROUP_FEATURE_ROW")
                    {
                        global $_a;
                        $_a = [];
                        foreach($list_data->data->items as $item)
                        {
                            if ($item->title == 'آسانسور' && $item->available == true) {
                                $_a[] = '"37"';
                            }
                            if ($item->title == 'پارکینگ' && $item->available == true) {
                                $_a[] = '"35"';
                            }
                            if ($item->title == 'انباری' && $item->available == true) {
                                $_a[] = '"36"';
                            }
                        }
                        if (is_array($_a)) {
                            $inputs['facilities'] = '[' . implode(',', $_a) . ']';
                        }
                        //dd($list_data->data->action->payload->modal_page->widget_list);
                        global $_b;
                        $_b = [];
                        if(isset($list_data->data->action))
                        foreach($list_data->data->action->payload->modal_page->widget_list as $list)
                        {
                            if($list->widget_type ==  "UNEXPANDABLE_ROW" || $list->widget_type ==  "FEATURE_ROW")
                            {
                                if ($list->data->title == 'جهت ساختمان') {
                                    if ($list->data->value == 'جنوبی') {
                                        $inputs['geography'] = 114;
                                    }
                                    if ($list->data->value == 'شمالی') {
                                        $inputs['geography'] = 113;
                                    }
                                }
                                if ($list->data->title == 'سند') {
                                    if ($list->data->value == 'تک‌برگ') {
                                        $inputs['document_type'] = 20;
                                    }
                                }
                                if ($list->data->title == 'تعداد واحد در طبقه') {
                                    if(is_integer(str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list->data->value)))
                                    {
                                        $inputs['unit_in_floor'] = 304 + str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list->data->value);
                                    }
                                }
                                if ($list->data->title == 'سرویس بهداشتی') {
                                    if ($list->data->value == 'سرویس بهداشتی ایرانی') {
                                        $inputs['wc'] = 104;
                                    }
                                    if ($list->data->value == 'سرویس بهداشتی فرنگی') {
                                        $inputs['wc'] = 105;
                                    }
                                    if ($list->data->value == 'سرویس بهداشتی ایرانی و فرنگی') {
                                        $inputs['wc'] = 106;
                                    }
                                }
                                //if ($__v[0] == 'سرمایش' || $__v[0] == 'گرمایش'  || $__v[0] ==  'تأمین‌کننده آب گرم') {
                                if ($list->data->title == 'سرمایش کولر آبی') {
                                    $_b[] = '"94"';
                                }
                                if ($list->data->title == 'سرمایش کولر گازی') {
                                    $_b[] = '"92"';
                                }
                                if ($list->data->title == 'گرمایش شوفاژ') {
                                    $_b[] = '"87"';
                                }
                                if ($list->data->title == 'گرمایش بخاری') {
                                    $_b[] = '"86"';
                                }
                                if ($list->data->title == 'آبگرم‌کن') {
                                    $_b[] = '"101"';
                                }
                                if ($list->data->title == 'تأمین‌کننده آب گرم پکیج') {
                                    $_b[] = '"88"';
                                }
                                if ($list->data->title == 'موتورخانه') {
                                    $_b[] = '"95"';
                                }
                            }
                        }
                        if (is_array($_b)) {
                            $inputs['heating_cooling'] = '[' . implode(',', $_b) . ']';
                        }
                    }
                }
            }
        }
        //dd($inputs);
        if(isset($manage->seo->web_info->district_persian)){
            $district = District::where('city_id', $cityid)->where('name', $manage->seo->web_info->district_persian)->first();
            if (isset($district)) {
                $inputs['district_id'] = $district->id;
                /*if(ss('SITE_ID') == 3)
                {
                    if(!in_array($inputs['district_id'] , [1,2,4,6,8,9,10,11,13,14,15,16,17,19,21,22,29,30,34,35,40,42,43,45,48,51,54,55,57,58,68,80,84,112,115,7336,7640,25890,26035,26139,26160,26161,26165,26166,26167,26168,26170,26172,26173,26175,26180,26182,26183,26191,26200,26201,26204,26205,26206,26207,26208,26213]))
                    {
                        echo 'district_id not valid<br>';
                        return;

                    }
                }*/
                if(ss('SITE_ID') == 8)
                {
                    if(in_array($inputs['district_id'] , [20,25,91]))
                    {
                        echo 'district_id not valid<br>';
                        return;
                    }
                }
                if(ss('SITE_ID') == 5)
                {
                    if(in_array($inputs['district_id'] , [1]))
                    {
                        echo 'district_id not valid<br>';
                        return;
                    }
                }
            } else {
                $district = District::create([
                    'province_id' => $provinceid,
                    'city_id' => $cityid,
                    'name' => $manage->seo->web_info->district_persian,
                    'active' => 1,
                    'divar' => 1
                ]);
                $inputs['district_id'] = $district->id;
            }
        }
        $inputs['title'] = $manage->seo->web_info->title;

        if(ss('SITE_ID') == 2)
        {
            if(str_contains($inputs['description'], 'همکار')
            || str_contains($inputs['description'], 'قرارداد')
            || str_contains($inputs['description'], 'املاک')
            || str_contains($inputs['description'], 'خرید و فروش')
            || str_contains($inputs['description'], 'مشاور')
            || str_contains($inputs['description'], 'فایل')
            || str_contains($inputs['description'], 'فایلینک')
            || str_contains($inputs['description'], 'دپارتمان')
            || str_contains($inputs['description'], 'روستا')
            || str_contains($inputs['description'], 'باغ')
            || str_contains($inputs['description'], 'ازدیدار')
            || str_contains($inputs['description'], 'از دیدار')
            || str_contains($inputs['description'], 'کارشناس')
            || str_contains($inputs['description'], 'دفتر')
            || str_contains($inputs['description'], 'سازنده بنام')
            || str_contains($inputs['description'], 'سازنده خوشنام')
            || str_contains($inputs['description'], 'آدرس دفتر')
            || str_contains($inputs['description'], 'پاسخگوی شما آقا')
            || str_contains($inputs['description'], 'پاسخگوی شما خانم')
            || preg_match('~[0-9]{6,}}~', $inputs['description'])
            )
            {
                echo 'description not valid<br>';
                return;
            }
            if(str_contains($inputs['title'], 'همکار')
            || str_contains($inputs['title'], 'قرارداد')
            || str_contains($inputs['title'], 'خرید و فروش')
            || str_contains($inputs['title'], 'املاک')
            || str_contains($inputs['title'], 'مشاور')
            || str_contains($inputs['title'], 'فایل')
            || str_contains($inputs['title'], 'فایلینک')
            || str_contains($inputs['title'], 'دپارتمان')
            || str_contains($inputs['title'], 'روستا')
            || str_contains($inputs['title'], 'باغ')
            || str_contains($inputs['title'], 'ازدیدار')
            || str_contains($inputs['title'], 'از دیدار')
            || str_contains($inputs['title'], 'کارشناس')
            || str_contains($inputs['title'], 'دفتر')
            || str_contains($inputs['title'], 'سازنده بنام')
            || str_contains($inputs['title'], 'سازنده خوشنام')
            || str_contains($inputs['title'], 'آدرس دفتر')
            || str_contains($inputs['title'], 'پاسخگوی شما آقا')
            || str_contains($inputs['title'], 'پاسخگوی شما خانم')
            || preg_match('~[0-9]{6,}}~', $inputs['description'])
            )
            {
                echo 'title not valid<br>';
                return;
            }
        }
        else
        {
            if($cityid == 1)
            {
                if(str_contains($inputs['description'], 'همکار')
                || str_contains($inputs['description'], 'دهات')
                || str_contains($inputs['description'], 'املاک')
                || str_contains($inputs['description'], 'مزرعه')

                || str_contains($inputs['description'], 'چاه')

                || str_contains($inputs['description'], 'مشاور')
                || str_contains($inputs['description'], 'فایل')
                || str_contains($inputs['description'], 'فایلینک')
                || str_contains($inputs['description'], 'دپارتمان')
                || str_contains($inputs['description'], 'آوه')
                || str_contains($inputs['description'], 'مبارک آباد')
                || str_contains($inputs['description'], 'جنت آباد')
                || str_contains($inputs['description'], 'صالح آباد')
                || str_contains($inputs['description'], 'تاج خاتون')
                || str_contains($inputs['description'], 'حاجی آباد')
                || str_contains($inputs['description'], 'قمرود')
                || str_contains($inputs['description'], 'میم')
                || str_contains($inputs['description'], 'سراجه')
                || str_contains($inputs['description'], 'وشنوه')
                || str_contains($inputs['description'], 'خاوه')
                || str_contains($inputs['description'], 'جنداب')
                || str_contains($inputs['description'], 'دستجرد')
                || str_contains($inputs['description'], 'لنگرود')
                || str_contains($inputs['description'], 'ورجان')
                || str_contains($inputs['description'], 'بنگاه')
                || str_contains($inputs['description'], 'طایقان')
                || str_contains($inputs['description'], 'فردو')

                || str_contains($inputs['description'], 'قنوات')
                || str_contains($inputs['description'], 'راهجرد')
                || str_contains($inputs['description'], 'سنجگان')
                || str_contains($inputs['description'], 'بیک محمد')
                || str_contains($inputs['description'], 'قلعه حیدری')
                || str_contains($inputs['description'], 'راوه')
                || str_contains($inputs['description'], 'وشاره')
                || str_contains($inputs['description'], 'خدیجه خاتون')
                || str_contains($inputs['description'], 'جزه')
                || str_contains($inputs['description'], 'سنجان')
                || str_contains($inputs['description'], 'نایه')
                || str_contains($inputs['description'], 'حیدرآباد')
                || str_contains($inputs['description'], 'لبن')
                || str_contains($inputs['description'], 'ازدیدار')
                || str_contains($inputs['description'], 'از دیدار')
                || str_contains($inputs['description'], 'کارشناس')

                || str_contains($inputs['description'], 'کهک')
                || str_contains($inputs['description'], 'آشتیان')
                || str_contains($inputs['description'], 'ایستگاه محمدیه')
                || str_contains($inputs['description'], 'امامزاده اسماعیل')
                || str_contains($inputs['description'], 'قلعه صدری')
                || str_contains($inputs['description'], 'آمره')
                || str_contains($inputs['description'], 'باغ یک')
                || str_contains($inputs['description'], 'بشارت')
                || str_contains($inputs['description'], 'خاتون')
                || str_contains($inputs['description'], 'حاجی')
                || str_contains($inputs['description'], 'نیزار')
                || str_contains($inputs['description'], 'خرم آباد')
                || str_contains($inputs['description'], 'زوار')
                || str_contains($inputs['description'], 'سنجگ')
                || str_contains($inputs['description'], 'طایق')
                || str_contains($inputs['description'], 'فوجرد')
                || str_contains($inputs['description'], 'کوه سفید')
                || str_contains($inputs['description'], 'گیو')
                || str_contains($inputs['description'], 'موجان')
                || str_contains($inputs['description'], 'بشاره')
                || str_contains($inputs['description'], 'اندیس')
                || str_contains($inputs['description'], 'قاضی')
                || str_contains($inputs['description'], 'قباد')
                || str_contains($inputs['description'], 'منصورآباد')
                || str_contains($inputs['description'], 'دهکده صبا')
                || str_contains($inputs['description'], 'راوه')
                || str_contains($inputs['description'], 'مهری آباد')
                || str_contains($inputs['description'], 'خاوه')
                || str_contains($inputs['description'], 'کندرود')

                || str_contains($inputs['description'], 'زیزیگان')
                || str_contains($inputs['description'], 'سازنده بنام')
                || str_contains($inputs['description'], 'سازنده خوشنام')
                || str_contains($inputs['description'], 'آدرس دفتر')
                || str_contains($inputs['description'], 'پاسخگوی شما آقا')
                || str_contains($inputs['description'], 'پاسخگوی شما خانم')
                || str_contains($inputs['description'], '09')
                || preg_match('~[0-9]{6,}}~', $inputs['description'])
                )
                {
                    echo 'description not valid<br>';
                    return;
                }
                if(str_contains($inputs['title'], 'همکار')
                || str_contains($inputs['title'], 'دهات')
                || str_contains($inputs['title'], 'املاک')


                || str_contains($inputs['title'], 'مزرعه')

                || str_contains($inputs['title'], 'چاه')

                || str_contains($inputs['title'], 'مشاور')
                || str_contains($inputs['title'], 'فایلینگ')
                || str_contains($inputs['title'], 'فایلینک')
                || str_contains($inputs['title'], 'دپارتمان')
                || str_contains($inputs['title'], 'آوه')
                || str_contains($inputs['title'], 'مبارک آباد')
                || str_contains($inputs['title'], 'جنت آباد')
                || str_contains($inputs['title'], 'صالح آباد')
                || str_contains($inputs['title'], 'تاج خاتون')
                || str_contains($inputs['title'], 'حاجی آباد')
                || str_contains($inputs['title'], 'قمرود')
                || str_contains($inputs['title'], 'میم')
                || str_contains($inputs['title'], 'سراجه')
                || str_contains($inputs['title'], 'وشنوه')
                || str_contains($inputs['title'], 'خاوه')
                || str_contains($inputs['title'], 'جنداب')
                || str_contains($inputs['title'], 'دستجرد')
                || str_contains($inputs['title'], 'لنگرود')
                || str_contains($inputs['title'], 'ورجان')

                || str_contains($inputs['title'], 'طایقان')
                || str_contains($inputs['title'], 'فردو')
                || str_contains($inputs['title'], 'روستا')
                || str_contains($inputs['title'], 'باغ')
                || str_contains($inputs['title'], 'قنوات')
                || str_contains($inputs['title'], 'راهجرد')
                || str_contains($inputs['title'], 'سنجگان')
                || str_contains($inputs['title'], 'بیک محمد')
                || str_contains($inputs['title'], 'قلعه حیدری')
                || str_contains($inputs['title'], 'راوه')
                || str_contains($inputs['title'], 'وشاره')
                || str_contains($inputs['title'], 'خدیجه خاتون')
                || str_contains($inputs['title'], 'جزه')
                || str_contains($inputs['title'], 'سنجان')
                || str_contains($inputs['title'], 'نایه')
                || str_contains($inputs['title'], 'حیدرآباد')
                || str_contains($inputs['title'], 'لبن')
                || str_contains($inputs['title'], 'ازدیدار')
                || str_contains($inputs['title'], 'از دیدار')
                || str_contains($inputs['title'], 'کارشناس')

                || str_contains($inputs['title'], 'کهک')
                || str_contains($inputs['title'], 'آشتیان')
                || str_contains($inputs['title'], 'ایستگاه محمدیه')
                || str_contains($inputs['title'], 'امامزاده اسماعیل')
                || str_contains($inputs['title'], 'قلعه صدری')
                || str_contains($inputs['title'], 'آمره')
                || str_contains($inputs['title'], 'باغ یک')
                || str_contains($inputs['title'], 'بشارت')
                || str_contains($inputs['title'], 'خاتون')
                || str_contains($inputs['title'], 'حاجی')
                || str_contains($inputs['title'], 'نیزار')
                || str_contains($inputs['title'], 'خرم آباد')
                || str_contains($inputs['title'], 'زوار')
                || str_contains($inputs['title'], 'سنجگ')
                || str_contains($inputs['title'], 'طایق')
                || str_contains($inputs['title'], 'فوجرد')
                || str_contains($inputs['title'], 'کوه سفید')
                || str_contains($inputs['title'], 'گیو')
                || str_contains($inputs['title'], 'موجان')
                || str_contains($inputs['title'], 'بشاره')
                || str_contains($inputs['title'], 'اندیس')
                || str_contains($inputs['title'], 'قاضی')
                || str_contains($inputs['title'], 'قباد')
                || str_contains($inputs['title'], 'منصورآباد')
                || str_contains($inputs['title'], 'دهکده صبا')
                || str_contains($inputs['title'], 'راوه')
                || str_contains($inputs['title'], 'مهری آباد')
                || str_contains($inputs['title'], 'خاوه')
                || str_contains($inputs['title'], 'کندرود')
                || str_contains($inputs['title'], 'مشابه')


                || str_contains($inputs['title'], 'فروشنده')

                || str_contains($inputs['title'], 'زیزیگان')
                || str_contains($inputs['title'], '09')
                || preg_match('~[0-9]{6,}}~', $inputs['title'])
                )
                {
                    echo 'title not valid<br>';
                    return;
                }
            }
        }
        if(1 || ss('SITE_ID') != 3){
            $inputs['confirmation'] = 'verified';
        }
        else
        {
            $inputs['confirmation'] = 'pending';
        }
        $inputs['visibility'] = 1;
        $inputs['divar'] = $id;
        $inputs['last_activity'] = Carbon::now();
        //->info->contact_uuid
        $contact_uuid = $manage->contact->action_log->server_side_info->info->contact_uuid;
        /*list($ret , $mobile) = $this->getMobileDivar($id , $contact_uuid);
        if(!$ret){
            echo 'mobile not valid<br>';

            return ;
        }*/
        $inputs['token'] = TokenMaker(8);
        if(false)
        {
            $finalUser = User::where('username', $mobile)->first();
            if($finalUser)
            {
                if($finalUser->isbongah == 1)
                {
                    echo 'isbongah<br>';
                    return;
                }
            }
            else
            {
                $finalUser = User::create(checkInputs([
                    'username' => $mobile,
                    'phone' => $mobile,
                    'has_role' => 0,
                    'active' => 0,
                    'status' => 1,
                    'isbongah' => 0
                ]));
            }
            $inputs['user_id'] = $finalUser->id;
            $inputs['owner_name'] = $mobile;
            $inputs['phone'] = $mobile;
        }
        else
        {
            $inputs['owner_name'] = '';
            $inputs['phone'] = '09120000000';
        }
        $countEstate = Estate::where('divar', $id)->where('created_at', '>', date('Y-m-d 00:00:00'))->first();
        if($countEstate)
        {
            return;
        }
        $estate = Estate::create($inputs);
        echo '$estate: '.$estate->id.'<br>';
        /*if($estate->phone != null && ss('SITE_ID') == 2 && in_array($cityid , [594,440,25]))
        {
            $suggest = getsetting('sms','addestate');
            $arrSearch = array("{0}");
            $arrReplace = array($estate->id);
            $text = str_replace($arrSearch, $arrReplace, $suggest);
            sendSms($estate->phone , $text);
        }*/
        /*if($estate->phone != null && (ss('SITE_ID') == 8 || ss('SITE_ID') == 5) && in_array($cityid , [1]) && $type==1)
        {
            if($type == 1)
            {
                $suggest = getsetting('sms','addestatebuy');
                $arrSearch = array("{0}");
                $arrReplace = array($estate->id);
                $text = str_replace($arrSearch, $arrReplace, $suggest);
                sendSms($estate->phone , $text);
            }
            else
            {
            }
        }*/
        updateExpert($estate);
        relCustomer($estate->id);
        $default_image = '';
        if(isset($images))
        {

            foreach ($images as $image) {

                $__images = $this->storeMedia2($image->image->url, $estate->id);
                if ($default_image == '') {
                    $default_image = $__images;
                }
            }
        }
        $img = Image::where('estate_id', $estate->id)->where('is_360',0)->first();
        // update image fields of estate model
        $estate->update([
            'image_count' => Image::where('estate_id', $estate->id)->count(),
            'image_cover' => $img ? asset('/upload/images/estate/'.date('Y').'/'.date('m') .'/'. $img->dimension['large']) : null,
        ]);
        // update default image in images table
        if ($img) {
            $img->update(['cover' => 1]);
        }
    }
    public function divarShort($id, $type, $cityid, $provinceid)
    {
        //$id = 'QZFNeT1Q';
        echo $id . '<br>';
        $inputs = [];
        $countEstate = Estate::where('divar', '<>', '')->where('created_at', '>', date('Y-m-d 00:00:00'))->count();
        $idd = intdiv($countEstate, 240) + 1;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_URL,"https://api.divar.ir/v8/posts-v2/web/".$id);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
        $response = curl_exec($ch);
        curl_close($ch);
        $manage = json_decode($response);
        //dd($manage);


        $inputs['province_id'] = $provinceid;
        $inputs['city_id'] = $cityid;
        $inputs['type'] = 3;
        $inputs['published_at'] = date('Y-m-d H:i:s');
        $inputs['showdate'] = date('Y-m-d H:i:s');
        if($manage == null)
        {
            return;
        }

        $inputs['estate_type'] = 2;
        foreach ($manage->sections as $section){
            if($section->section_name == "IMAGE")
            {
                foreach ($section->widgets as $list_data)
                {
                    $images = $list_data->data->items;
                }
            }
            if($section->section_name == "DESCRIPTION")
            {
                foreach ($section->widgets as $list_data)
                {
                    if($list_data->widget_type == "DESCRIPTION_ROW")
                    {
                        $inputs['description'] = $list_data->data->text;
                    }
                }
            }
            if($section->section_name == "MAP")
            {
                foreach($section->widgets as $widget)
                {
                    if (isset($widget->data->location->fuzzy_data->point->latitude)) {
                        $inputs['latitude'] = trim($widget->data->location->fuzzy_data->point->latitude);
                        $inputs['latitude_secondary'] = trim($widget->data->location->fuzzy_data->point->latitude);
                    }
                    if (isset($widget->data->location->fuzzy_data->point->longitude)) {
                        $inputs['longitude'] = trim($widget->data->location->fuzzy_data->point->longitude);
                        $inputs['longitude_secondary'] = trim($widget->data->location->fuzzy_data->point->longitude);
                    }
                }
            }
            if($section->section_name == "LIST_DATA")
            {
                foreach ($section->widgets as $list_data) {
                    if($list_data->widget_type == "GROUP_INFO_ROW")
                    {
                        foreach ($list_data->data->items as $item)
                        {
                            if ($item->title == 'متراژ') {
                                $inputs['area'] =  str_replace(array(' متر', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $item->value);
                            }
                            /*if ($item->title == 'متراژ بنا') {
                                $inputs['built_area'] =  str_replace(array(' متر', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $item->value);
                            }*/

                            if ($item->title == 'اتاق') {
                                $item->value =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $item->value);
                                switch ($item->value) {
                                    case '1':
                                        $inputs['room_count'] = 187;
                                        break;
                                    case '2':
                                        $inputs['room_count'] = 188;
                                        break;
                                    case '3':
                                        $inputs['room_count'] = 189;
                                        break;
                                    case '4':
                                        $inputs['room_count'] = 190;
                                        break;
                                }
                            }
                        }
                    }

                    if($list_data->widget_type == "UNEXPANDABLE_ROW")
                    {
                        if ($list_data->data->title == 'روزهای عادی') {
                            $inputs['rent'] = str_replace(array(' تومان/شب', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                            if ($inputs['rent'] == 'توافقی') {
                                return;
                            }
                        }
                        if ($list_data->data->title == 'آخر هفته') {
                            $inputs['mortgage'] =  str_replace(array(' تومان/شب', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                        }

                        if ($list_data->data->title == 'ظرفیت') {
                            $inputs['max_person'] =  (int)str_replace(array('تا ', ' نفر ', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                        }


                        if ($list_data->data->title == 'متراژ') {
                            $inputs['area'] =  str_replace(array(' متر', '٬', '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('', '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                        }
                        if ($list_data->data->title == 'متراژ زمین') {
                            if($inputs['area']>0){
                                $inputs['built_area'] = $inputs['area'];
                            }
                            $inputs['area'] =  str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list_data->data->value);
                        }

                    }
                    if($list_data->widget_type == "GROUP_FEATURE_ROW")
                    {
                        global $_a;
                        $_a = [];
                        foreach($list_data->data->items as $item)
                        {
                            if ($item->title == 'آسانسور' && $item->available == true) {
                                $_a[] = '"37"';
                            }
                            if ($item->title == 'پارکینگ' && $item->available == true) {
                                $_a[] = '"35"';
                            }
                            if ($item->title == 'انباری' && $item->available == true) {
                                $_a[] = '"36"';
                            }
                        }
                        if (is_array($_a)) {
                            $inputs['facilities'] = '[' . implode(',', $_a) . ']';
                        }
                        //dd($list_data->data->action->payload->modal_page->widget_list);
                        global $_b;
                        $_b = [];
                        if(isset($list_data->data->action))
                        foreach($list_data->data->action->payload->modal_page->widget_list as $list)
                        {
                            if($list->widget_type ==  "UNEXPANDABLE_ROW" || $list->widget_type ==  "FEATURE_ROW")
                            {
                                if ($list->data->title == 'جهت ساختمان') {
                                    if ($list->data->value == 'جنوبی') {
                                        $inputs['geography'] = 114;
                                    }
                                    if ($list->data->value == 'شمالی') {
                                        $inputs['geography'] = 113;
                                    }
                                }
                                if ($list->data->title == 'سند') {
                                    if ($list->data->value == 'تک‌برگ') {
                                        $inputs['document_type'] = 20;
                                    }
                                }
                                if ($list->data->title == 'تعداد واحد در طبقه') {
                                    if(is_integer(str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list->data->value)))
                                    {
                                        $inputs['unit_in_floor'] = 304 + str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $list->data->value);
                                    }
                                }
                                if ($list->data->title == 'سرویس بهداشتی') {
                                    if ($list->data->value == 'سرویس بهداشتی ایرانی') {
                                        $inputs['wc'] = 104;
                                    }
                                    if ($list->data->value == 'سرویس بهداشتی فرنگی') {
                                        $inputs['wc'] = 105;
                                    }
                                    if ($list->data->value == 'سرویس بهداشتی ایرانی و فرنگی') {
                                        $inputs['wc'] = 106;
                                    }
                                }
                                //if ($__v[0] == 'سرمایش' || $__v[0] == 'گرمایش'  || $__v[0] ==  'تأمین‌کننده آب گرم') {
                                if ($list->data->title == 'سرمایش کولر آبی') {
                                    $_b[] = '"94"';
                                }
                                if ($list->data->title == 'سرمایش کولر گازی') {
                                    $_b[] = '"92"';
                                }
                                if ($list->data->title == 'گرمایش شوفاژ') {
                                    $_b[] = '"87"';
                                }
                                if ($list->data->title == 'گرمایش بخاری') {
                                    $_b[] = '"86"';
                                }
                                if ($list->data->title == 'آبگرم‌کن') {
                                    $_b[] = '"101"';
                                }
                                if ($list->data->title == 'تأمین‌کننده آب گرم پکیج') {
                                    $_b[] = '"88"';
                                }
                                if ($list->data->title == 'موتورخانه') {
                                    $_b[] = '"95"';
                                }
                            }
                        }
                        if (is_array($_b)) {
                            $inputs['heating_cooling'] = '[' . implode(',', $_b) . ']';
                        }
                    }
                }
            }
        }
        //dd($inputs);
        if(isset($manage->seo->web_info->district_persian)){
            $district = District::where('city_id', $cityid)->where('name', $manage->seo->web_info->district_persian)->first();
            if (isset($district)) {
                $inputs['district_id'] = $district->id;

            } else
            {
                $district = District::create([
                    'province_id' => $provinceid,
                    'city_id' => $cityid,
                    'name' => $manage->seo->web_info->district_persian,
                    'active' => 1,
                    'divar' => 1
                ]);
                $inputs['district_id'] = $district->id;
            }
        }
        $inputs['title'] = $manage->seo->web_info->title;


        $inputs['confirmation'] = 'verified';

        $inputs['visibility'] = 0;
        $inputs['divar'] = $id;
        $inputs['last_activity'] = Carbon::now();
        list($ret , $mobile) = $this->getMobileDivar($id);
        if(!$ret){
            return ;
        }
        $inputs['token'] = TokenMaker(8);

        if((ss('SITE_ID') != 1) || $ret){
            $finalUser = User::where('username', $mobile)->first();
            if($finalUser){
                if($finalUser->isbongah == 1)
                {
                    return;
                }
            }
            else
            {
                $finalUser = User::create(checkInputs([
                    'username' => $mobile,
                    'phone' => $mobile,
                    'has_role' => 1,
                    'active' => 0,
                    'status' => 1,
                    'role_ids' => '[10]',
                    'isbongah' => 0
                ]));
                $finalUser->assignRole( 10 );
            }
            $inputs['user_id'] = $finalUser->id;
            $inputs['expert_id'] = $finalUser->id;
            $inputs['owner_name'] = $mobile;
            $inputs['phone'] = $mobile;
        }
        //dd($inputs);
        $estate = Estate::create($inputs);
        if($estate->phone != null && ss('SITE_ID') == 2 && in_array($cityid , [594,92,440,25]))
        {
            // $suggest = getsetting('sms','addestate');
            // $arrSearch = array("{0}");
            // $arrReplace = array($estate->id);
            // $text = str_replace($arrSearch, $arrReplace, $suggest);
            // sendSms($estate->phone , $text);
        }

        $default_image = '';
        if(isset($images))
        foreach ($images as $image) {
            $__images = $this->storeMedia2($image->image->url, $estate->id);
            if ($default_image == '') {
                $default_image = $__images;
            }
        }
        $img = Image::where('estate_id', $estate->id)->where('is_360',0)->first();
        // update image fields of estate model
        $estate->update([
            'image_count' => Image::where('estate_id', $estate->id)->count(),
            'image_cover' => $img ? asset('/upload/images/estate/'.date('Y').'/'.date('m') .'/'. $img->dimension['large']) : null,
        ]);
        // update default image in images table
        if ($img) {
            $img->update(['cover' => 1]);
        }
    }
    public function getMobileDivar($id , $contact_uuid)
    {
        $setting  = Setting::where('group','divar')->whereIn('id' , [289,291])->inRandomOrder()->first();
        //dd(getQuery($setting));
        if($setting)
        {
            $inputs['count'] = (int)$setting->count + 1;
            $setting->update($inputs);
            $code = $setting->value;
            if(trim($code) == ''){
                return [false, ''];
            }

            $URL = "https://koomeh.ir/tel2.php?code=".$id."&token=".$code."&contact_uuid=".$contact_uuid;
            //dd($URL);
            $c = curl_init();
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_URL, $URL);
            $response = curl_exec($c);
            curl_close($c);


            //$response = file_get_contents();
            $manage = json_decode($response);

            if(!$manage || !$manage->mobile)
            {
                var_dump($manage);
                echo '<br>'.$URL.'<br>';
                return [false , ''];
            }
            else
            {
                return [ true , $manage->mobile ];
            }
        }
        else
        {
            Setting::where('group','divar')->update(['count'=>0]);
        }
        //echo 'https://api.divar.ir/v8/postcontact/web/contact_info/'.$id;
		// $curl = curl_init();
		// curl_setopt_array($curl, array(
		// 		  CURLOPT_URL => 'https://api.divar.ir/v8/postcontact/web/contact_info/'.$id,
		// 		  CURLOPT_RETURNTRANSFER => true,
		// 		  CURLOPT_ENCODING => '',
		// 		  CURLOPT_MAXREDIRS => 10,
		// 		  CURLOPT_TIMEOUT => 0,
		// 		  CURLOPT_FOLLOWLOCATION => true,
		// 		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		// 		  CURLOPT_CUSTOMREQUEST => 'GET',
		// 		  CURLOPT_POSTFIELDS =>'Host: api.divar.ir
		// 		User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:106.0) Gecko/20100101 Firefox/106.0
		// 		Accept: application/json, text/plain, */*
		// 		Accept-Language: en-US,en;q=0.5
		// 		Accept-Encoding: gzip, deflate, br
		// 		Origin: https://divar.ir
		// 		Sec-Fetch-Dest: empty
		// 		Sec-Fetch-Mode: cors
		// 		Sec-Fetch-Site: same-site
		// 		Authorization: Basic '.$code.'
		// 		Referer: https://divar.ir/
		// 		Connection: keep-alive
		// 		TE: trailers',
		// 		  CURLOPT_HTTPHEADER => array(
		// 			'User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:106.0) Gecko/20100101 Firefox/106.0',
		// 			'Accept:  application/json, text/plain, */*',
		// 			'Accept-Language:  en-US,en;q=0.5',
		// 			'Accept-Encoding:  gzip, deflate, br',
		// 			'Origin:  https://divar.ir',
		// 			'Sec-Fetch-Dest:  empty',
		// 			'Sec-Fetch-Mode:  cors',
		// 			'Sec-Fetch-Site:  same-site',
		// 			'Authorization:  Basic '.$code,
		// 			'Referer:  https://divar.ir/',
		// 			'Connection:  keep-alive',
		// 			'TE:  trailers',
		// 			'Content-Type: text/plain'
		// 		  ),
		// 		));
		// $response = curl_exec($curl);
        // dd($response);
		// curl_close($curl);
        // $manage = json_decode($response);
    }
    public function getMobileSheypoor($id)
    {
        /*$setting  = Setting::where('group','sheypoor')->inRandomOrder()->first();
        $code = $setting->value;
		if(trim($code) == ''){
            return [false, ''];
		}*/
		$curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.sheypoor.com/api/v10.0.0/listings/'.$id.'/number',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        /*CURLOPT_HTTPHEADER => array(
            'Host:  www.sheypoor.com',
            'User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/119.0',
            'Accept:  application/vnd.api+json',
            'Accept-Language:  en-US,en;q=0.5',
            'Accept-Encoding:  gzip, deflate, br',
            'Connection:  keep-alive',
            'Referer:  https://www.sheypoor.com',
            'Cookie:  refresh_token=Bearer+'.$code.'; access_token=Bearer+'.$code.'; access_token=Bearer+'.$code,
            'Sec-Fetch-Dest:  empty',
            'Sec-Fetch-Mode:  cors',
            'Sec-Fetch-Site:  same-origin',
            'TE:  trailers'
        ),*/
        /*CURLOPT_HTTPHEADER => array(
            'Host:  www.sheypoor.com',
            'User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/119.0',
            'Accept:  application/vnd.api+json',
            'Accept-Language:  en-US,en;q=0.5',
            'Accept-Encoding:  gzip, deflate, br',
            'Connection:  keep-alive',
            'Referer:  https://www.sheypoor.com',
            'Sec-Fetch-Dest:  empty',
            'Sec-Fetch-Mode:  cors',
            'Sec-Fetch-Site:  same-origin',
            'TE:  trailers'
        ),*/
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $manage = json_decode($response);
        //dd($manage);
        if(!$manage || $manage == null)
        {
            return [false , ''];
        }
        else
        {
            return [ true , $manage->data->attributes->phoneNumber ];
        }
    }
    public function storeMedia2($request, $estateid)
    {
        $cropDetail = [600, 600, 0, 0];
        $gallery = uploader2($request, 'file', 'images/estate/'.date('Y').'/'.date('m'), null, true, $cropDetail);

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
        $image = Image::create([
            'token' => uniqid(),
            'user_id' => $userid,
            'extension' => 'jpg',
            'url' => $gallery['image_url'],
            'dimension' => $gallery['dimension'],
            'estate_id' => $estateid,
            'month' => date('m'),
            'year' => date('Y')
        ]);
        if (!$image) {
            return response()->json(['error' => 'saving failed!'], 500);
        }
        return $image->id;
    }
    public function storeMedia3($request, $estateid)
    {

        $cropDetail = [600, 600, 0, 0];
        $gallery = uploader4($request, 'file', 'images/estate/'.date('Y').'/'.date('m'), null, true, $cropDetail);
        //dd($request);
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
        $image = Image::create([
            'token' => uniqid(),
            'user_id' => $userid,
            'extension' => 'jpg',
            'url' => $gallery['image_url'],
            'dimension' => $gallery['dimension'],
            'estate_id' => $estateid,
            'month' => date('m'),
            'year' => date('Y')
        ]);
        if (!$image) {
            return response()->json(['error' => 'saving failed!'], 500);
        }
        return $image->id;
    }
    public function reportEstate(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            // datetime
            $dt = Carbon::now();
            // retrieve estate
            return view('frontend.estate.report_estate');
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function reportEstateShow(Request $request)
    {
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        // retrieve estate
        $estateReports = EstateReport::orderBy($request->order, $request->orderby);
        if(!empty($request->estate_id))
        {
            $estateReports = $estateReports->where('estate_id',$request->estate_id);
        }
        if (!empty($request->reason_group))
        {
            $estateReports = $estateReports->where('reason_group', $request->reason_group);
        }
        if (!empty($request->status))
        {
            $estateReports = $estateReports->where('status', $request->status);
        }
        //dd(getQuery($estateReports));
        $totalCount = $estateReports->count();
        $estateReports = $estateReports->paginate(20);
        $couter=$totalCount/9;
        $couter=(int)$couter;
        $hasPage = ($couter==$request->page)? false : true;
        $view = view('frontend.estate.report_estate_show', compact('estateReports','totalCount'))->render();
        return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
    }
    public function reportEstateDestroy( $id ) {
        $ids = explode( ',', $id );
        $ids = count( $ids ) > 1 ? $ids : implode( '', $ids );
        if ( is_array( $ids ) ) {
            EstateReport::whereIn( 'id', $ids )->delete();
            return response()->json( [ 'status' => 'ok', 'result' => 'deleted!' ], config( 'StatusCode.SUCCESS' ) );
        }
        $validator = Validator::make( [ 'id' => $ids ], [
            'id' => 'required|exists:estate_reports,id'
        ] );
        if ( $validator->fails() ) {
            return response()->json( [
                'status' => 'error',
                'result' => $validator->errors()
            ], config( 'StatusCode.INVALID_INPUT' ) );
        }
        EstateReport::where('id', $ids)->delete();
        return response()->json( [ 'status' => 'ok', 'result' => 'deleted!' ], config( 'StatusCode.SUCCESS' ) );
    }
    public function reportEstateStatus( $estate_report_id, $status ) {
        $validator = Validator::make( [ 'id' => $estate_report_id, 'status' => $status ], [
            'id'     => 'required|exists:estate_reports,id',
            'status' => 'required|in:pending,verified,rejected'
        ] );
        if ( $validator->fails() ) {
            return response( [
                'status' => 'error',
                'result' => $validator->errors()
            ], config( 'StatusCode.INVALID_INPUT' ) );
        }
        EstateReport::where( 'id', $estate_report_id )->update( [ 'status' => $status ] );
        return response( [
            'status' => 'ok',
            'result' => 'تغییر وضعیت با موفقیت انجام شد.'
        ], config( 'StatusCode.SUCCESS' ) );
    }
    public function commission()
    {
		return view( 'frontend.estate.commission' );
	}
    public function appraisal()
    {
        $estateAppraisalId = 0;
        if(ss('SITE_ID') == 2)
        {
            return view( 'site2.frontend.estate.appraisal' , compact('estateAppraisalId'));
        }
        else
        {
		    return view( 'frontend.estate.appraisal' , compact('estateAppraisalId'));
        }
	}
    public function storeAppraisal(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        $estateAppraisal = EstateAppraisal::create($inputs);
        $estateAppraisalId = $estateAppraisal->id;
		return view( 'frontend.estate.appraisal' , compact('estateAppraisalId'));
	}
    public function listAppraisal(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $estateAppraisal = EstateAppraisal::orderBy('id', 'desc');
            $estateAppraisal = $estateAppraisal->paginate(20);;
            if(ss('SITE_ID') == 2)
            {
                return view('site2.frontend.estate.listAppraisal', compact('estateAppraisal'));
            }
            else
            {
                return view('frontend.estate.listAppraisal', compact('estateAppraisal'));
            }
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function listAppraisalShow(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $dt = Carbon::now();
            $appraisals = EstateAppraisal::orderBy('id', 'desc');
            $totalCount = $appraisals->count();
            $appraisals = $appraisals->paginate(20);
            $couter=$totalCount/20;
            $couter=(int)$couter;
            $hasPage = ($couter==$request->page)? false : true;
            if(ss('SITE_ID') == 2)
            {
                $view = view('site2.frontend.estate.listAppraisalShow', compact('appraisals','totalCount'))->render();
            }
            else
            {
                $view = view('frontend.estate.listAppraisalShow', compact('appraisals','totalCount'))->render();
            }
            return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
        }
        else
        {
            return view('frontend.errors.404');
        }
    }
    public function removeAppraisal($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            EstateAppraisal::where('id', $id)->delete();
            return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        }
        else
        {
            return view('frontend.errors.404');
        }
    }

    public function estate_show()
    {
        return view('site2.frontend.estate.estate_show');
    }
    public function estate_fav()
    {
        return view('site4.frontend.estate.estate_fav');
    }
    public function search_acc()
    {
        return view('site5.frontend.account.search');
    }
    public function agent_acc()
    {
        return view('site7.frontend.account.agent');
    }
    public function signup_branch()
    {
        return view('site7.frontend.account.signup_branch');
    }
    public function signup_branch2()
    {
        return view('site7.frontend.account.signup_branch2');
    }
    public function showBranch2()
    {
        return view('site7.frontend.account.showBranch');
    }
    public function my_estate()
    {
        return view('site7.frontend.estate.my_estate');
    }
    public function showExpert2()
    {
        return view('site7.frontend.account.showExpert');
    }
    public function myProperties(Request $request)
    {
        return $this->properties($request , 1 , 'املاک من');
    }
    public function branchProperties(Request $request)
    {
        $user = Auth::user();
        $title = '';
        if($user->branch_id)
        {
            $title = $user->branch->name;
        }
        return $this->properties($request , 2 , 'املاک '.$title);
    }
    public function allProperties(Request $request)
    {
        return $this->properties($request , 3 , 'لیست املاک');
    }
    public function properties($request , $type = 1 , $title = '')
    {
        $user = Auth::user();
        $users = null;
        if($type != 1)
        {
            $users = User::with('roles')->where('has_role', 1)->whereIn('status', ['1']);
            $users = $users->whereHas('roles', function ($query) {
                $query->where( 'id', '=', 9);
            })->get(['id', 'name','last_name', 'username','status']);
        }
        $defaultCity = ss('DEFAULT_CITY');
        $citiesSelected = [];
        $citySelected = City::with(['districts' => function ($q) {$q->orderBy('name', 'asc');}])->where('name_en', $defaultCity)->where('active', 1)->first();
        if($citySelected)
        {
            $citiesSelected = City::where('province_id', $citySelected->province_id)->where('active', 1)->get();
        }
        return view('frontend.estate.propertiesList', compact('users','citySelected','citiesSelected' , 'title' , 'type'));
    }
    public function propertiesShow(Request $request)
    {
        $user = Auth::user();
        // datetime
        $dt = Carbon::now();
        // retrieve estate
        $estates = Estate::with([
            'images',
            'district',
        ]);
        if($user->isExpert())
        {
           $estates = $estates->orderBy($request->order, $request->orderby);
        }
        else
        {
            $estates = $estates->orderBy('id', 'desc');
        }
        if(ss('SITE_ID') != 5 && ss('SITE_ID') != 8)
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
            $estates=$estates->where('visibility',$request->visibility);
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
            //     $query->where('is_360','=',1);
            // });
        }
        if(!empty($request->floor_count)){
            $estates = $estates->where('floor_count','>',$request->floor_count);
        }
        if(!empty($request->balconmetraj)){
            $estates = $estates->where('balconmetraj','>',0);
        }
        if(!empty($request->manufacturer_id)){
            $estates = $estates->where('manufacturer_id',$request->manufacturer_id);
        }
        if(!empty($request->brand_id)){
            $estates = $estates->where('brand_id',$request->brand_id);
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
        if($request->pagesize>0){
            $pagesize = $request->pagesize;
        }
        else
        {
            $pagesize = 9;
        }
        //dd(getQuery($estates));
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


            $view = view('frontend.estate.propertiesShow', compact('estates','fieldList','totalCount'))->render();
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
}
