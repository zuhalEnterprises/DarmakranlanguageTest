<?php
use App\helper\SmsService;
use App\Models\District;
use App\Models\Street;
use App\Models\City;
use App\Models\FeatureValue;
use App\Models\Feature;
use App\Models\Notification;
use App\Models\NotificationLog;
use App\Models\TemplatePage;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\Sms;
use App\Models\Setting;
use App\Models\Customer;
use App\Models\Estate;
use App\Models\EstateEdit;
use App\Models\EstateOperation;
use App\Models\UserActivityDistrict;
use App\Models\CustomerDistrict;
use App\Models\RelationEstateCustomer;
use App\Models\Country;
use App\Models\Language;
use App\Models\SiteSetting;
use Carbon\Carbon;
//use ConsoleTVs\Charts\Facades\Charts;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use  \Morilog\Jalali\CalendarUtils;
use  \Morilog\Jalali\Jalalian;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

function getClassName($className): string
{
    return $className->getShortName();
    //return class_basename($className);
}
function toPersianNumbers($string, $format_numeber = true)
{
    if ($string === null) {
        return null;
    }
    if ($format_numeber) {
        $string = number_format($string);
    }
    if(env('COUNTRY') != 'UAE'){
        $farsi_array = array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹");
        $english_array = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $persian_number = str_replace($english_array, $farsi_array, $string);
    }
    else
    {
        $persian_number = $string;
    }
    return $persian_number;
}
function toPersianDate($date, $ago = false, $dateVisibility = true, $format = null)
{
    if(Config::get('app.locale') == 'en')
    {
        return $date;
    }
    else
    {
        $format = $format ?? 'H:i Y/m/d';

        $newDate = CalendarUtils::strftime($format, strtotime($date));
        if ($ago) {
            $ago = Jalalian::forge($date)->ago();
            $newDate = $dateVisibility ? "$newDate ($ago)" : "$ago";
        }
        return toPersianNumbers($newDate, false);
    }
}
function toPersianDateYdm($date)
{
    if($date != '' && $date != null)
    {
        return  Verta($date)->format('Y/%m/%d');
    }
}
function topersianTimeword($date){
    return Verta::parse($date)->formatWord('d F');
}
function toPersianTime($date)
{
    $v2 = verta($date);
    return (strlen($v2->hour)<2?"0".$v2->hour:$v2->hour).":".(strlen($v2->minute)<2?"0".$v2->minute:$v2->minute);
}
function yearhijriago($date){
    $currentDate = Jalalian::now();
     return $currentDate->subYears($date)->format('Y');
}
function builtyearago($date){
    $currentDate = Jalalian::now();
     return $currentDate->subYears($date)->format('Y');
}
function subtractyear($year){
    $currentDate = Jalalian::now();
    return $currentDate->format('Y')-$year;
}
function estateValue($key , $value)
{
    if($value != '' && $value != null)
    {
        $_ = [];
        switch($key)
        {
            case 'expiretime_expert':
            case 'showdate':
            case 'showdate':
            case 'deleted_at':
                $value = toPersianDate($value);
                break;
            case 'geography':
                $fieldList = getFeatures(0, 0);
                if(array_key_exists($value , $fieldList['geography']))
                {
                    $value = $fieldList['geography'][$value];
                }
                else
                {
                    $value = '';
                }
                break;
            case 'document_type':
                $fieldList = getFeatures(0, 0);
                if(array_key_exists($value , $fieldList['document_type']))
                {
                    $value = $fieldList['document_type'][$value];
                }
                else
                {
                    $value = '';
                }
                break;
            case 'usage_type':
                $fieldList = getFeatures(0, 0);
                if($value>0 and array_key_exists($value , $fieldList['usage_type']))
                {
                    $value = $fieldList['usage_type'][$value];
                }
                else
                {
                    $value = '';
                }
                break;
            case 'unit_in_floor':
                $fieldList = getFeatures(0, 0);
                if(array_key_exists($value , $fieldList['unit_in_floor']))
                {
                    $value = $fieldList['unit_in_floor'][$value];
                }
                else
                {
                    $value = '';
                }
                break;
            case 'structure_type':
                $fieldList = getFeatures(0, 0);
                if(array_key_exists($value , $fieldList['structure_type']))
                {
                    $value = $fieldList['structure_type'][$value];
                }
                else
                {
                    $value = '';
                }
                break;
            case 'floor_count':
                $fieldList = getFeatures(0, 0);
                if(array_key_exists($value , $fieldList['floor_count']))
                {
                    $value = $fieldList['floor_count'][$value];
                }
                else
                {
                    $value = '';
                }
                break;
            case 'position_type':
                $fieldList = getFeatures(0, 0);
                if(array_key_exists($value , $fieldList['position_type']))
                {
                    $value = $fieldList['position_type'][$value];
                }
                else
                {
                    $value = '';
                }
                break;
            case 'floor_start':
                $fieldList = getFeatures(0, 0);
                if(array_key_exists($value , $fieldList['floor_start']))
                {
                    $value = $fieldList['floor_start'][$value];
                }
                else
                {
                    $value = '';
                }
                break;
            case 'residence_type':
                $fieldList = getFeatures(0, 0);
                if(array_key_exists($value , $fieldList['residence_type']))
                {
                    $value = $fieldList['residence_type'][$value];
                }
                else
                {
                    $value = '';
                }
                break;
            case 'room_count':
                $fieldList = getFeatures(0, 0);
                if(array_key_exists($value , $fieldList['room_count']))
                {
                    $value = $fieldList['room_count'][$value];
                }
                else
                {
                    $value = '';
                }
                break;
            case 'build_license':
                $fieldList = getFeatures(0, 0);
                if(array_key_exists($value , $fieldList['build_license']))
                {
                    $value = $fieldList['build_license'][$value];
                }
                else
                {
                    $value = '';
                }
                break;
            case 'wc':
                $fieldList = getFeatures(0, 0);
                $value = $fieldList['wc'][$value];
                break;
            case 'kitchen':
                $fieldList = getFeatures(0, 0);
                foreach (json_decode($value, true) as $val)
                {
                    $_[] = $fieldList['kitchen'][$val];
                }
                $value = implode(' , ' , $_);
                break;
            case 'heating_cooling':
                $fieldList = getFeatures(0, 0);
                foreach (json_decode($value, true) as $val)
                {
                    $_[] = $fieldList['heating_cooling'][$val];
                }

                $value = count($_)>0 ? implode(' , ' , $_) : '';
                break;
            case 'conditions':
                $fieldList = getFeatures(0, 0);
                foreach (json_decode($value, true) as $val)
                {
                    $_[] = $fieldList['conditions'][$val];
                }
                $value = count($_)>0 ? implode(' , ' , $_) : '';
                break;
            case 'facilities':
                $fieldList = getFeatures(0, 0);
                foreach (json_decode($value, true) as $val)
                {
                    $_[] = $fieldList['facilities'][$val];
                }
                $value = count($_)>0 ? implode(' , ' , $_) : '';
                break;
            case 'expertid':
                $user = User::where('id', $value)->first();
                if($user){
                    return $user->fullname();
                }
                break;
            case 'district_id':
                $district = District::where('id', $value)->first();
                if($district){
                    return $district->name;
                }
                break;
            case 'street_id':
                $street = Street::where('id', $value)->first();
                if($street){
                    return $street->name;
                }
                break;
            case 'confirmation':
                $value = confirmStatuses($value);
                break;
            case 'estate_type':
                return estateTypes($value);
                break;
            case 'price':
            case 'mortgage':
            case 'rent':
            case 'price_per_meter':
                $value = toPersianNumbers($value);
                break;
            case 'exchange':
            case 'isbongah':
            case 'urgent':
            case 'special':
            case 'convertible':
            case 'evacuation':
            case 'keynot':
                if($value == '1')
                {
                    $value = 'بله';
                }
                if($value == '0')
                {
                    $value = 'خیر';
                }
            break;
        }
    }
    else
    {
        $value = '';
    }
    return $value;
}
function buildYear($key){
    $year=$key;
    switch($key){
        case 2000:$year="کلید نخورده ";break;
        case 1359:$year="کمتر از 1360 ";break;
    }
    return $year;
}
function toAgoTime($date)
{
    $startTime = Carbon::parse($date);
    //$finishTime = Carbon::parse(date('Y-m-d H:i:s'));
    if(env('DATE') == 'miladi')
    {
        Carbon::setLocale('en');
    }
    else
    {
        Carbon::setLocale('fa');
    }
    $total=Carbon::createFromFormat('Y-m-d H:i:s',$startTime)->diffForHumans();
    $total = str_replace('پیش از','پیش',$total);
    return $total;
}

function list2tree(array $list, $parentId = 'id', $parentKey = 'parent', $childKey = 'childes')
{
    $tree = [];
    foreach ($list as $k => &$v) {
        ///>
        if ($v[$parentKey] == 0) {
            $tree[] =& $v;
        } else {
            if ($parentId === null) {
                $list[$v[$parentKey]];
            } else {
                foreach ($list as $k1 => &$v1) {
                    if ($v1[$parentId] == $v[$parentKey]) {
                        ///>
                        if (empty($v1[$childKey])) {
                            $v1[$childKey] = [&$v];
                        } else {
                            if (!is_array($v1[$childKey])) {
                                $v1[$childKey] = [$v1[$childKey]];
                            }
                            $v1[$childKey][] =& $v;
                        }
                        break;
                    }
                }
            }
        }
    }
    return $tree;
}
function TokenMaker($len)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLenght = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $len; $i++) {
        $randomString .= $characters[rand(0, $charLenght - 1)];
    }
    return $randomString;
}
function randomNumber($length)
{
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }
    return $result;
}
function basefileUrl()
{
    return url('/') . '/';
}
function success_true($result = null, $message = null)
{
    return (new JsonResponse([
        'data' => $result,
        'status' => 'Success',
        'message' => $message,
    ]));
}
function success_false($message)
{
    return new JsonResponse([
        'errors' => null,
        'status' => 'Error',
        'message' => $message,
    ], 422);
}
function unValidation($errors = null)
{
    return makeResponse('error', 'invalid input !', config('StatusCode.INVALID_INPUT'));
}
function accessDenied()
{
    return makeResponse('error', 'access denied !', config('StatusCode.FOR_BIDDEN'));
}
function unauthorized($error_message)
{
    return makeResponse('error', $error_message, config('StatusCode.UNAUTHORIZED'));
}
function badRequest($error_message)
{
    return makeResponse('error', $error_message, config('StatusCode.BAD_REQUEST'));
}
function serverError($error_message)
{
    return makeResponse('error', $error_message, config('StatusCode.INTERNAL_SERVER_ERROR'));
}
function serviceUnavailable($error_message)
{
    return makeResponse('error', $error_message, config('StatusCode.SERVICE_UNAVAILABLE'));
}
function notFound()
{
    return makeResponse('error', 'یافت نشد!', config('StatusCode.NOT_FOUND'));
}
function makeResponse($status, $result, $statusCode, $message = null)
{
    if ($status === 'error') {
        $result = checkErrors($result);
    }
    return new JsonResponse(['status' => $status, 'result' => $result, 'message' => $message], $statusCode);
}
function checkErrors($error_message)
{
    if (is_object($error_message)) {
        $error_message = $error_message->toArray();
    }
    $result = [];
    if (is_array($error_message)) {
        foreach ($error_message as $key => $error) {
            !empty($error[0]) ? array_push($result, $error[0]) : array_push($result, $error);
        }
    } else {
        $result[0] = $error_message;
    }
    return $result;
}
function noImage()
{
    $notFoundImg = '/upload/images/photos-coming-soon.jpg';
    return $notFoundImg;
}
function getImage($filename)
{
    $result = !empty($filename) ? asset('/upload/images/' . $filename) : null;//asset('/upload/images/not_found.png')
    return $result;
}
function getAudio($filename)
{
    $result = !empty($filename) ? asset('/upload/audios/' . $filename) : '';
    return $result;
}
function getVideo($filename)
{
    $result = !empty($filename) ? asset('/upload/videos/' . $filename) : '';
    return $result;
}
function notifier($title, $content, $imageUrl = null, $send_at = null)
{
    $data = [
        "data" => [
            "title" => $title,
            "content" => $content,
            "imageUrl" => $imageUrl
        ],
        "to" => "/topics/all"
    ];
    $url = 'https://fcm.googleapis.com/fcm/send';
    try {
        $client = new Client();
        $response = $client->request('POST', $url, [
            'headers' => [
                'Authorization' => 'key=AAAA1c_6zcY:APA91bEMoSNr443e3hpTrW2FgkFwYTt741MJE2SaF17G5vqwhwO3MUVwEyE556FnCcjsLwKvYr94UKXZA8TmpI4Z1s6fgqw1hIU2K-zHwGrOFBT2tbtGrKHFr4Zgt3z6rdT-9VAKH-d6',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => $data
//            'ssl' => [
//                'verify_peer' => false,
//                'verify_peer_name' => false,
//                'allow_self_signed' => true
//            ],
        ]);
        $status_code = $response->getStatusCode();
        $res = $response->getBody();
        if ($status_code == 200) {
            $result = json_decode($res->getContents(), true);
            return ['status' => true, 'result' => $result];
        }
    } catch (\GuzzleHttp\Exception\ClientException $clientException) {
        $result = json_decode($clientException->getResponse()->getBody()->getContents(), true);
        return ['status' => false, 'result' => $result];
    }
}
function timeToMillisecond($stringTime)
{
    if (empty($stringTime)) {
        return null;
    }
    $time = explode(":", $stringTime);
    $hour = $time[0] * 60 * 60 * 1000;
    $minute = $time[1] * 60 * 1000;
    $second = $time[2] * 1000;
    $result = $hour + $minute + $second;
    return $result;
}
function uploader3($request, $field, $upload_dir = null, $file_type = null, $crop = false, $crop_detail = [])
{

    $result = null;
    $prefix = null;
    $base_dir = env('PUBLIC_PATH').'/upload/';
    $upload_dir = !empty($upload_dir) ? $upload_dir . '/' : 'images/';
    $dimension = ['small' => 200, 'medium' => 600];
    switch ($field) {
        case 'logo':
            $prefix = 'logo_';
            break;
        case 'icon':
            $prefix = 'icon_';
            break;
        case 'gallery':
            $prefix = 'gallery_';
            break;
        case 'video':
            $prefix = 'video_';
            break;
        default:
            $prefix = 'img_';
            break;
    }
    if (empty($request->file($field))) {
        return $result;
    }
    $publicThumbDir = base_path(env('PUBLIC_PATH')."/upload/images/thumb");

    if (!file_exists($publicThumbDir)) {
        //dd($publicThumbDir);

        mkdir($publicThumbDir, 0777);
    }
    $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/contract/".date('Y'));
    if (!file_exists($CropDir)) {
        mkdir($CropDir, 0777);
    }
    $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/contract/".date('Y').'/'.date('m'));
    if (!file_exists($CropDir)) {
        mkdir($CropDir, 0777);
    }
    // make upload dir
    $ud = base_path($base_dir . $upload_dir);
    if (!file_exists($ud)) {
        mkdir($ud, 0777);
    }
    if (is_array($request->file($field))) {
        if (count($request->file($field)) == 0) {
            return null;
        }
        $result = [];
        foreach ($request->file($field) as $item) {
            if ($request->hasFile($field) && $item->isValid()) {
                $fileName = $prefix . Str::random(16);
                $new_dimension = [];
                foreach ($dimension as $name => $size) {
                    $file_name = $fileName . '_' . $name . '.' . $item->getClientOriginalExtension();
                    if (empty($file_type) || $file_type != 'video') {
                        // Image::make($item)->resize($size, null, function ($constraint) {
                        //     $constraint->aspectRatio();
                        // })->save(base_path($base_dir . $upload_dir . $file_name));
                        list($width, $height, $type) = getimagesize($item->getPathname());
                        $newWidth = $size;
                        $newHeight = intval(($height / $width) * $size);

                        switch ($type) {
                            case IMAGETYPE_JPEG:
                                $sourceImage = imagecreatefromjpeg($item->getPathname());
                                break;
                            case IMAGETYPE_PNG:
                                $sourceImage = imagecreatefrompng($item->getPathname());
                                break;
                            case IMAGETYPE_GIF:
                                $sourceImage = imagecreatefromgif($item->getPathname());
                                break;
                            default:
                                continue 2; // skip this file if unsupported type
                        }

                        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        imagejpeg($resizedImage, base_path($base_dir . $upload_dir . $file_name), 90);
                        imagedestroy($sourceImage);
                        imagedestroy($resizedImage);
                    }
                    $new_dimension[$name] = $file_name;
                }
                $item->move(base_path($base_dir . $upload_dir), $fileName . '.' . $item->getClientOriginalExtension());
                $result[] = [
                    'image' => $fileName . '.' . $item->getClientOriginalExtension(),

                    'extension' => $item->getClientOriginalExtension()
                ];
            }
        }
        return $result;
    }
    if($upload_dir == 'images/branch/')
    {
        $file = $request->file($field);
        $filename = $prefix . Str::random(16);
        $fileName = $filename . '.' . $file->getClientOriginalExtension();
        $thumbDir = base_path(env('PUBLIC_PATH')."/upload/images/branch");
        if (!file_exists($thumbDir)) {
            mkdir($thumbDir, 0777);
        }
        if ($crop == true && empty($file_type) && $file_type != 'video') {
            $cropList = $croppedResult = [];
            if ($crop && !empty($crop_detail)) {
                $crop_dimension = ['small' => [200, 200], 'medium' => [600, 600], 'large' => [1000, 1000]];
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/branch");
                if (!file_exists($CropDir)) {
                    mkdir($CropDir, 0777);
                }
                list($width, $height, $x, $y) = $crop_detail;
                // crop image
                $coppedDimension =[];
                $cf = $prefix . uniqid();
                foreach ($crop_dimension as $key => $dimension) {
                    $cfn = $cf . '_' . $key;
                    $coppedFileName = $cfn . '.jpg';

                    list($originalWidth, $originalHeight, $type) = getimagesize($file->getPathname());

                    switch ($type) {
                        case IMAGETYPE_JPEG:
                            $srcImage = imagecreatefromjpeg($file->getPathname());
                            break;
                        case IMAGETYPE_PNG:
                            $srcImage = imagecreatefrompng($file->getPathname());
                            break;
                        case IMAGETYPE_GIF:
                            $srcImage = imagecreatefromgif($file->getPathname());
                            break;
                        default:
                            continue 2;
                    }

                    $targetWidth = $dimension[0];
                    $targetHeight = $dimension[1];

                    // محاسبه نسبت‌ها برای crop مرکزی (fit)
                    $srcRatio = $originalWidth / $originalHeight;
                    $targetRatio = $targetWidth / $targetHeight;

                    if ($srcRatio > $targetRatio) {
                        // عرض زیادتره => crop عرض
                        $newHeight = $originalHeight;
                        $newWidth = $originalHeight * $targetRatio;
                        $srcX = ($originalWidth - $newWidth) / 2;
                        $srcY = 0;
                    } else {
                        // ارتفاع زیادتره => crop ارتفاع
                        $newWidth = $originalWidth;
                        $newHeight = $originalWidth / $targetRatio;
                        $srcX = 0;
                        $srcY = ($originalHeight - $newHeight) / 2;
                    }

                    $croppedResizedImage = imagecreatetruecolor($targetWidth, $targetHeight);
                    imagecopyresampled(
                        $croppedResizedImage, $srcImage,
                        0, 0,
                        $srcX, $srcY,
                        $targetWidth, $targetHeight,
                        $newWidth, $newHeight
                    );

                    imagejpeg($croppedResizedImage, base_path($base_dir . $upload_dir . $coppedFileName), 90);

                    imagedestroy($srcImage);
                    imagedestroy($croppedResizedImage);

                    $cropList[] = $coppedFileName;
                    $coppedDimension[$key] = $coppedFileName;
                }
                $croppedResult = [
                    'image_url' => $coppedDimension['large'],//$cf . '.' . $file->getClientOriginalExtension(),
                    'dimension' => $coppedDimension,
                    'extension' => $file->getClientOriginalExtension()
                ];
            }
            return $croppedResult;
        }
        $file->move(base_path($base_dir . $upload_dir), $fileName);
        $result = $fileName;
        return $result;
    }
    if ($request->hasFile($field) && $request->file($field)->isValid())
    {
        $file = $request->file($field);
        $filename = $prefix . Str::random(16);
        $fileName = $filename . '.' . $file->getClientOriginalExtension();
        $thumbDir = basename($upload_dir) == 'products' ? base_path(env('PUBLIC_PATH')."/upload/images/products/thumb") : base_path(env('PUBLIC_PATH')."/upload/images/thumb");
        if (!file_exists($thumbDir)) {
            mkdir($thumbDir, 0777);
        }
        if ($crop == true && empty($file_type) && $file_type != 'video') {
            $cropList = $croppedResult = [];
            if ($crop && !empty($crop_detail)) {
                $crop_dimension = ['small' => [200, 200], 'medium' => [600, 600], 'large' => [1000, 1000]];
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate");
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate/".date('Y'));
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate/".date('Y').'/'.date('m'));
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                list($width, $height, $x, $y) = $crop_detail;
                // crop image
                $coppedDimension =[];
                $cf = $prefix . uniqid();
                foreach ($crop_dimension as $key => $dimension) {
                    $cfn = $cf . '_' . $key;
                    $coppedFileName = $cfn . '.' . $file->getClientOriginalExtension();
                    $cropList[] = $croppedImageFile = Image::make($file)->fit($dimension[0], $dimension[1])
                        ->save(base_path($base_dir . $upload_dir . $cfn . '.jpg'));
                    $coppedDimension[$key] = $cfn . '.jpg';
                }
                $croppedResult = [
                    'image_url' => $coppedDimension['large'],//$cf . '.' . $file->getClientOriginalExtension(),
                    'dimension' => $coppedDimension,
                    'extension' => $file->getClientOriginalExtension()
                ];
            }
            return $croppedResult;
        }
        $file->move(base_path($base_dir . $upload_dir), $fileName);
        $result = $fileName;
        return $result;
    }
    return $result;
}
function cvf_add_watermark($image_path){
    $stamp_path = env('WATERMARK');
    $file = pathinfo($image_path);
    // Declare valid formats
    $valid_formats = array("jpg", "jpeg", "gif", "png");
    // Check if image exists
    if(!file_exists($image_path)){
        return -1;
        // Check if file meets extension requirements
    } else if(!in_array($file['extension'], $valid_formats)) {
        return false;
    } else {
        // Load the stamp and the photo to apply the watermark to
        $stamp = imagecreatefrompng($stamp_path);
        // Designate image depending on extension
        if($file['extension'] == 'jpg' || $file['extension'] == 'jpeg'){
            $image = imagecreatefromjpeg($image_path);
        } else if ($file['extension'] == 'png'){
            $image = imagecreatefrompng($image_path);
        } else if ($file['extension'] == 'gif'){
            $image = imagecreatefromgif($image_path);
        }
        // Set the margins for the stamp and get the height/width of the stamp image
        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);
        // Copy the stamp image onto our photo using the margin offsets and the photo
        // width to calculate positioning of the stamp.
        imagecopy(
            $image,
            $stamp,
            (imagesx($image) - $sx)/2,
            (imagesy($image) - $sy )-20,
            0,
            0,
            imagesx($stamp),
            imagesy($stamp)
        );
        // Output as PNG file and free memory
        imagejpeg($image,$image_path);
        imagedestroy($image);
    }
}

function uploader($request, $field, $upload_dir = null, $file_type = null, $crop = false, $crop_detail = [])
{

    $result = null;
    $prefix = null;
    $base_dir = env('PUBLIC_PATH').'/upload/';
    $upload_dir = !empty($upload_dir) ? $upload_dir . '/' : 'images/';
    $dimension = ['small' => 200, 'medium' => 600];
    switch ($field) {
        case 'logo':
            $prefix = 'logo_';
            break;
        case 'icon':
            $prefix = 'icon_';
            break;
        case 'gallery':
            $prefix = 'gallery_';
            break;
        case 'video':
            $prefix = 'video_';
            break;
        default:
            $prefix = 'img_';
            break;
    }
    if (empty($request->file($field))) {
        return $result;
    }
    $publicThumbDir = base_path(env('PUBLIC_PATH')."/upload/images/thumb");
    if (!file_exists($publicThumbDir)) {
        //dd($publicThumbDir);
        mkdir($publicThumbDir, 0777);
    }
    $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate/".date('Y'));
    if (!file_exists($CropDir)) {
        mkdir($CropDir, 0777);
    }
    $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate/".date('Y').'/'.date('m'));
    if (!file_exists($CropDir)) {
        mkdir($CropDir, 0777);
    }
    // make upload dir
    $ud = base_path($base_dir . $upload_dir);
    if (!file_exists($ud)) {
        mkdir($ud, 0777);
    }
    if (is_array($request->file($field))) {
        if (count($request->file($field)) == 0) {
            return null;
        }
        $result = [];
        foreach ($request->file($field) as $item)
        {
            // if ($request->hasFile($field) && $item->isValid())
            // {
            //     $fileName = $prefix . Str::random(16);
            //     $new_dimension = [];
            //     foreach ($dimension as $name => $size) {
            //         $file_name = $fileName . '_' . $name . '.' . $item->getClientOriginalExtension();
            //         if (empty($file_type) || $file_type != 'video') {
            //             // resizing an uploaded file
            //             Image::make($item)->resize($size, null, function ($constraint) {
            //                 $constraint->aspectRatio();
            //             })->save(base_path($base_dir . $upload_dir . $file_name));
            //         }
            //         $new_dimension[$name] = $file_name;
            //     }
            //     $item->move(base_path($base_dir . $upload_dir), $fileName . '.' . $item->getClientOriginalExtension());
            //     $result[] = [
            //         'image' => $fileName . '.' . $item->getClientOriginalExtension(),
            //         'dimension' => $new_dimension,
            //         'extension' => $item->getClientOriginalExtension()
            //     ];
            // }
            if ($request->hasFile($field) && $item->isValid()) {
                $fileName = $prefix . Str::random(16);
                $new_dimension = [];

                // مسیر مقصد اصلی برای ذخیره فایل‌ها
                $destinationPath = base_path($base_dir . $upload_dir);
                $originalFileName = $fileName . '.' . $item->getClientOriginalExtension();

                // ذخیره فایل اصلی
                $item->move($destinationPath, $originalFileName);

                // فقط در صورتی که فایل تصویر باشد، نسخه‌های دیگر را کپی می‌کنیم
                if (empty($file_type) || $file_type != 'video') {
                    foreach ($dimension as $name => $size) {
                        $resizedFileName = $fileName . '_' . $name . '.' . $item->getClientOriginalExtension();
                        // فقط کپی فایل اصلی به نام جدید بدون تغییر اندازه
                        copy($destinationPath . '/' . $originalFileName, $destinationPath . '/' . $resizedFileName);
                        $new_dimension[$name] = $resizedFileName;
                    }
                }

                $result[] = [
                    'image' => $originalFileName,
                    'dimension' => $new_dimension,
                    'extension' => $item->getClientOriginalExtension()
                ];
            }
        }
        return $result;
    }
    if($upload_dir == 'images/branch/')
    {
        $file = $request->file($field);
        $filename = $prefix . Str::random(16);
        $fileName = $filename . '.' . $file->getClientOriginalExtension();
        $thumbDir = base_path(env('PUBLIC_PATH')."/upload/images/branch");
        if (!file_exists($thumbDir)) {
            mkdir($thumbDir, 0777);
        }
        if ($crop == true && empty($file_type) && $file_type != 'video') {
            $cropList = $croppedResult = [];
            if ($crop && !empty($crop_detail)) {
                $crop_dimension = ['small' => [200, 200], 'medium' => [600, 600], 'large' => [1000, 1000]];
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/branch");

                if (!file_exists($CropDir)) {
                    mkdir($CropDir, 0777, true);
                }

                list($width, $height, $x, $y) = $crop_detail;
                $coppedDimension = [];
                $cf = $prefix . uniqid();

                // Load the original image
                $originalPath = $file->getPathname();
                $extension = strtolower($file->getClientOriginalExtension());

                // Create image resource based on file type
                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                        $sourceImage = imagecreatefromjpeg($originalPath);
                        break;
                    case 'png':
                        $sourceImage = imagecreatefrompng($originalPath);
                        break;
                    case 'gif':
                        $sourceImage = imagecreatefromgif($originalPath);
                        break;
                    default:
                        // Handle unsupported formats or throw error
                        return null;
                }

                foreach ($crop_dimension as $key => $dimension) {
                    $cfn = $cf . '_' . $key;
                    $coppedFileName = $cfn . '.jpg'; // Always save as JPG for consistency

                    // Create a new true color image with the target dimensions
                    $croppedImage = imagecreatetruecolor($dimension[0], $dimension[1]);

                    // Preserve transparency for PNG and GIF
                    if ($extension == 'png' || $extension == 'gif') {
                        imagealphablending($croppedImage, false);
                        imagesavealpha($croppedImage, true);
                        $transparent = imagecolorallocatealpha($croppedImage, 255, 255, 255, 127);
                        imagefilledrectangle($croppedImage, 0, 0, $dimension[0], $dimension[1], $transparent);
                    }

                    // Resize and crop the image
                    imagecopyresampled(
                        $croppedImage,    // Destination image
                        $sourceImage,    // Source image
                        0, 0,            // Destination x, y
                        $x, $y,          // Source x, y
                        $dimension[0],   // Destination width
                        $dimension[1],   // Destination height
                        $width,          // Source width
                        $height         // Source height
                    );

                    // Save the cropped image
                    $fullPath = base_path($base_dir . $upload_dir . $coppedFileName);
                    imagejpeg($croppedImage, $fullPath, 90); // 90 is quality (0-100)

                    // Free memory
                    imagedestroy($croppedImage);

                    $coppedDimension[$key] = $coppedFileName;
                }

                // Free original image memory
                imagedestroy($sourceImage);

                $croppedResult = [
                    'image_url' => $coppedDimension['large'],
                    'dimension' => $coppedDimension,
                    'extension' => 'jpg' // We're saving all cropped images as JPG
                ];
            }
            return $croppedResult;
        }
        $file->move(base_path($base_dir . $upload_dir), $fileName);
        $result = $fileName;
        return $result;
    }
    if ($request->hasFile($field) && $request->file($field)->isValid())
    {

        $file = $request->file($field);
        $filename = $prefix . Str::random(16);
        $fileName = $filename . '.' . $file->getClientOriginalExtension();
        $thumbDir = basename($upload_dir) == 'products' ? base_path(env('PUBLIC_PATH')."/upload/images/products/thumb") : base_path(env('PUBLIC_PATH')."/upload/images/thumb");
        if (!file_exists($thumbDir)) {
            mkdir($thumbDir, 0777);
        }
        if ($crop == true && empty($file_type) && $file_type != 'video') {
            $cropList = $croppedResult = [];
            if ($crop && !empty($crop_detail)) {
                $crop_dimension = [/*'small' => [200, 200], 'medium' => [600, 600],*/ 'large' => [1000, 1000]];
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate");
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate/".date('Y'));
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate/".date('Y').'/'.date('m'));
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                list($width, $height, $x, $y) = $crop_detail;
                // crop image
                $coppedDimension =[];
                $cf = $prefix . uniqid();

                // foreach ($crop_dimension as $key => $dimension) {
                //     $cfn = $cf . '_' . $key;
                //     $coppedFileName = $cfn . '.' . $file->getClientOriginalExtension();
                //     $cropList[] = $croppedImageFile = Image::make($file)->fit($dimension[0], $dimension[1])->save(base_path($base_dir . $upload_dir . $cfn . '.jpg'));

                //     $coppedDimension[$key] = $cfn . '.jpg';
                // }
                foreach ($crop_dimension as $key => $dimension) {
                    $cfn = $cf . '_' . $key;
                    $coppedFileName = $cfn . '.' . $file->getClientOriginalExtension();

                    // مسیر فایل مقصد
                    $destination = base_path($base_dir . $upload_dir . $coppedFileName);

                    // فقط کپی فایل اصلی با نام جدید
                    copy($file->getRealPath(), $destination);

                    // ذخیره مسیر یا نام فایل جدید
                    $cropList[] = $destination;
                    $coppedDimension[$key] = $coppedFileName;
                }

                $croppedResult = [
                    'image_url' => $coppedDimension['large'],//$cf . '.' . $file->getClientOriginalExtension(),
                    'dimension' => $coppedDimension,
                    'extension' => $file->getClientOriginalExtension()
                ];
            }
            return $croppedResult;
        }
        $file->move(base_path($base_dir . $upload_dir), $fileName);
        $result = $fileName;

        return $result;
    }
    return $result;
}


// function uploader($request, $field, $upload_dir = null, $file_type = null, $crop = false, $crop_detail = [])
// {
//     $result = null;
//     $prefix = null;
//     $base_dir = env('PUBLIC_PATH').'/upload/';
//     $upload_dir = !empty($upload_dir) ? $upload_dir . '/' : 'images/';
//     $dimension = ['small' => 200, 'medium' => 600];

//     // تعیین پیشوند بر اساس نوع فیلد
//     switch ($field) {
//         case 'logo': $prefix = 'logo_'; break;
//         case 'icon': $prefix = 'icon_'; break;
//         case 'gallery': $prefix = 'gallery_'; break;
//         case 'video': $prefix = 'video_'; break;
//         default: $prefix = 'img_'; break;
//     }

//     if (empty($request->file($field))) {
//         return $result;
//     }

//     // ایجاد دایرکتوری‌های مورد نیاز
//     $publicThumbDir = base_path(env('PUBLIC_PATH')."/upload/images/thumb");
//     if (!file_exists($publicThumbDir)) {
//         mkdir($publicThumbDir, 0777, true);
//     }

//     // بررسی آرایه بودن فایل‌های ورودی (مثل آپلود چندتایی)
//     if (is_array($request->file($field))) {
//         if (count($request->file($field)) == 0) {
//             return null;
//         }

//         $result = [];
//         foreach ($request->file($field) as $item) {
//             if ($request->hasFile($field) && $item->isValid()) {
//                 $fileName = $prefix . Str::random(16);
//                 $new_dimension = [];
//                 $extension = $item->getClientOriginalExtension();

//                 // ذخیره نسخه اصلی
//                 $item->move(base_path($base_dir . $upload_dir), $fileName . '.' . $extension);

//                 // ایجاد نسخه‌های با سایزهای مختلف (فقط برای تصاویر)
//                 if (empty($file_type) || $file_type != 'video') {
//                     foreach ($dimension as $name => $size) {
//                         $file_name = $fileName . '_' . $name . '.' . $extension;
//                         resizeImage(
//                             base_path($base_dir . $upload_dir . $fileName . '.' . $extension),
//                             base_path($base_dir . $upload_dir . $file_name),
//                             $size,
//                             $size
//                         );
//                         $new_dimension[$name] = $file_name;
//                     }
//                 }

//                 $result[] = [
//                     'image' => $fileName . '.' . $extension,
//                     'dimension' => $new_dimension,
//                     'extension' => $extension
//                 ];
//             }
//         }
//         return $result;
//     }

//     // پردازش فایل تکی
//     if ($request->hasFile($field) && $request->file($field)->isValid()) {
//         $file = $request->file($field);
//         $filename = $prefix . Str::random(16);
//         $extension = $file->getClientOriginalExtension();
//         $fileName = $filename . '.' . $extension;

//         // پردازش مخصوص شاخه branch
//         if ($upload_dir == 'images/branch/') {
//             if ($crop && empty($file_type) && $file_type != 'video' && !empty($crop_detail)) {
//                 $crop_dimension = ['small' => [200, 200], 'medium' => [600, 600], 'large' => [1000, 1000]];
//                 $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/branch");
//                 if (!file_exists($CropDir)) {
//                     mkdir($CropDir, 0777, true);
//                 }

//                 $coppedDimension = [];
//                 $cf = $prefix . uniqid();

//                 foreach ($crop_dimension as $key => $dimension) {
//                     $cfn = $cf . '_' . $key;
//                     $coppedFileName = $cfn . '.jpg';

//                     cropImage(
//                         $file->getRealPath(),
//                         base_path($base_dir . $upload_dir . $coppedFileName),
//                         $crop_detail[0], // width
//                         $crop_detail[1], // height
//                         $crop_detail[2], // x
//                         $crop_detail[3], // y
//                         $dimension[0],   // target width
//                         $dimension[1]    // target height
//                     );

//                     $coppedDimension[$key] = $coppedFileName;
//                 }

//                 return [
//                     'image_url' => $coppedDimension['large'],
//                     'dimension' => $coppedDimension,
//                     'extension' => $extension
//                 ];
//             }

//             $file->move(base_path($base_dir . $upload_dir), $fileName);
//             return $fileName;
//         }

//         // پردازش عمومی برای سایر فایل‌ها
//         if ($crop && empty($file_type) && $file_type != 'video' && !empty($crop_detail)) {
//             $crop_dimension = ['small' => [200, 200], 'medium' => [600, 600], 'large' => [1000, 1000]];
//             $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate/".date('Y').'/'.date('m'));
//             if (!file_exists($CropDir)) {
//                 mkdir($CropDir, 0777, true);
//             }

//             $coppedDimension = [];
//             $cf = $prefix . uniqid();

//             foreach ($crop_dimension as $key => $dimension) {
//                 $cfn = $cf . '_' . $key;
//                 $coppedFileName = $cfn . '.jpg';

//                 cropImage(
//                     $file->getRealPath(),
//                     base_path($base_dir . $upload_dir . $coppedFileName),
//                     $crop_detail[0], // width
//                     $crop_detail[1], // height
//                     $crop_detail[2], // x
//                     $crop_detail[3], // y
//                     $dimension[0],   // target width
//                     $dimension[1]    // target height
//                 );

//                 $coppedDimension[$key] = $coppedFileName;
//             }

//             return [
//                 'image_url' => $coppedDimension['large'],
//                 'dimension' => $coppedDimension,
//                 'extension' => $extension
//             ];
//         }

//         $file->move(base_path($base_dir . $upload_dir), $fileName);
//         return $fileName;
//     }

//     return $result;
// }

// تابع تغییر اندازه تصویر
function resizeImage($sourcePath, $targetPath, $targetWidth, $targetHeight)
{
    list($originalWidth, $originalHeight, $type) = getimagesize($sourcePath);

    // محاسبه اندازه جدید با حفظ نسبت ابعاد
    $ratio = $originalWidth / $originalHeight;
    if ($targetWidth / $targetHeight > $ratio) {
        $targetWidth = $targetHeight * $ratio;
    } else {
        $targetHeight = $targetWidth / $ratio;
    }

    // ایجاد تصویر جدید
    $newImage = imagecreatetruecolor($targetWidth, $targetHeight);

    // بارگذاری تصویر اصلی بر اساس نوع
    switch ($type) {
        case IMAGETYPE_JPEG:
            $originalImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $originalImage = imagecreatefrompng($sourcePath);
            // حفظ شفافیت برای PNG
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $targetWidth, $targetHeight, $transparent);
            break;
        case IMAGETYPE_GIF:
            $originalImage = imagecreatefromgif($sourcePath);
            // حفظ شفافیت برای GIF
            $transparencyIndex = imagecolortransparent($originalImage);
            if ($transparencyIndex >= 0) {
                $transparentColor = imagecolorsforindex($originalImage, $transparencyIndex);
                $transparencyIndex = imagecolorallocate($newImage, $transparentColor['red'], $transparentColor['green'], $transparentColor['blue']);
                imagefill($newImage, 0, 0, $transparencyIndex);
                imagecolortransparent($newImage, $transparencyIndex);
            }
            break;
        default:
            return false;
    }

    // تغییر اندازه تصویر
    imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $originalWidth, $originalHeight);

    // ذخیره تصویر جدید
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $targetPath, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($newImage, $targetPath, 9);
            break;
        case IMAGETYPE_GIF:
            imagegif($newImage, $targetPath);
            break;
    }

    // آزاد کردن حافظه
    imagedestroy($originalImage);
    imagedestroy($newImage);

    return true;
}

// تابع برش تصویر
function cropImage($sourcePath, $targetPath, $srcWidth, $srcHeight, $srcX, $srcY, $targetWidth, $targetHeight)
{
    list($originalWidth, $originalHeight, $type) = getimagesize($sourcePath);

    // ایجاد تصویر جدید
    $newImage = imagecreatetruecolor($targetWidth, $targetHeight);

    // بارگذاری تصویر اصلی بر اساس نوع
    switch ($type) {
        case IMAGETYPE_JPEG:
            $originalImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $originalImage = imagecreatefrompng($sourcePath);
            // حفظ شفافیت برای PNG
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $targetWidth, $targetHeight, $transparent);
            break;
        case IMAGETYPE_GIF:
            $originalImage = imagecreatefromgif($sourcePath);
            // حفظ شفافیت برای GIF
            $transparencyIndex = imagecolortransparent($originalImage);
            if ($transparencyIndex >= 0) {
                $transparentColor = imagecolorsforindex($originalImage, $transparencyIndex);
                $transparencyIndex = imagecolorallocate($newImage, $transparentColor['red'], $transparentColor['green'], $transparentColor['blue']);
                imagefill($newImage, 0, 0, $transparencyIndex);
                imagecolortransparent($newImage, $transparencyIndex);
            }
            break;
        default:
            return false;
    }

    // برش و تغییر اندازه تصویر
    imagecopyresampled($newImage, $originalImage, 0, 0, $srcX, $srcY, $targetWidth, $targetHeight, $srcWidth, $srcHeight);

    // ذخیره تصویر جدید
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $targetPath, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($newImage, $targetPath, 9);
            break;
        case IMAGETYPE_GIF:
            imagegif($newImage, $targetPath);
            break;
    }

    // آزاد کردن حافظه
    imagedestroy($originalImage);
    imagedestroy($newImage);

    return true;
}

function resizeAndSaveImage($filePath, $savePath, $width)
{
    list($originalWidth, $originalHeight, $type) = getimagesize($filePath);
    $aspectRatio = $originalWidth / $originalHeight;
    $height = intval($width / $aspectRatio);

    switch ($type) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($filePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($filePath);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($filePath);
            break;
        default:
            return false;
    }

    $resizedImage = imagecreatetruecolor($width, $height);
    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
    imagejpeg($resizedImage, $savePath, 90);
    imagedestroy($sourceImage);
    imagedestroy($resizedImage);

    return true;
}
function uploaderImage($request, $field, $upload_dir = null, $file_type = null, $crop = false, $crop_detail = [])
{
    $prefix = null;
    $base_dir = env('PUBLIC_PATH').'/upload/';
    $upload_dir = !empty($upload_dir) ? $upload_dir . '/' : 'images/';
    $dimension = ['small' => 200, 'medium' => 600];
    switch ($field) {
        case 'logo':
            $prefix = 'logo_';
            break;
        case 'icon':
            $prefix = 'icon_';
            break;
        case 'gallery':
            $prefix = 'gallery_';
            break;
        case 'video':
            $prefix = 'video_';
            break;
        default:
            $prefix = 'img_';
            break;
    }

    $file = $request->file($field);
    $filename = $prefix . Str::random(16);
    $fileName = $filename . '.' . $file->getClientOriginalExtension();
    $thumbDir = base_path(env('PUBLIC_PATH')."/upload/images/branch");
    if (!file_exists($thumbDir)) {
        mkdir($thumbDir, 0777);
    }
    if ($crop == true && empty($file_type) && $file_type != 'video') {
        $cropList = $croppedResult = [];
        if ($crop && !empty($crop_detail)) {
            $crop_dimension = ['small' => [200, 200], 'medium' => [600, 600], 'large' => [1000, 1000]];
            $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/branch");
            if (!file_exists($CropDir)) {
                mkdir($CropDir, 0777);
            }
            list($width, $height, $x, $y) = $crop_detail;
            // crop image
            $coppedDimension =[];
            $cf = $prefix . uniqid();
            foreach ($crop_dimension as $key => $dimension) {
                $cfn = $cf . '_' . $key;
                $coppedFileName = $cfn . '.' . $file->getClientOriginalExtension();
                $cropList[] = $croppedImageFile = Image::make($file)->fit($dimension[0], $dimension[1])
                    ->save(base_path($base_dir . $upload_dir . $cfn . '.jpg'));
                $coppedDimension[$key] = $cfn . '.jpg';
            }
            $croppedResult = [
                'image_url' => $coppedDimension['large'],//$cf . '.' . $file->getClientOriginalExtension(),
                'dimension' => $coppedDimension,
                'extension' => $file->getClientOriginalExtension()
            ];
        }
        return $croppedResult;
    }
    $file->move(base_path($base_dir . $upload_dir), $fileName);
    $result = $fileName;
    return $result;

    return $result;
}
function crop($source_file, $max_width, $max_height)
{
    try {
        $path = parse_url($source_file, PHP_URL_PATH);
        $_p = explode('/', $path);
        $filename = ($_p[count($_p) - 1]);
        $_f = explode('.', $filename);

        if (!array_key_exists(1, $_f)) {
            return $source_file;
        }

        $newfilename = $_f[0] . '_' . $max_width . '_' . $max_height . '.' . $_f[1];
        $filepath = '';

        for ($i = 0; $i < count($_p) - 1; $i++) {
            $filepath .= $_p[$i] . '/';
            $publicThumbDir = base_path(env('PUBLIC_PATH') . "/cache/" . $filepath);
            if (!file_exists($publicThumbDir)) {
                try {
                    mkdir($publicThumbDir, 0777, true);
                } catch (\Exception $e) {
                    // Do nothing, just skip
                }
            }
        }

        $cache_file = '/cache' . $filepath . $newfilename;
        $cache_full_path = $_SERVER['DOCUMENT_ROOT'] . $cache_file;
        $original_full_path = $_SERVER['DOCUMENT_ROOT'] . $path;

        // 1. اگر فایل کش از قبل وجود داره و اندازه‌اش معقول هست، همونو برگردون
        if (is_file($cache_full_path) && filesize($cache_full_path) > 50) {
            return $cache_file;
        }

        // 2. اگر عکس اصلی وجود داره، نسخه کوچک‌شده رو تولید کن
        if (is_file($original_full_path)) {
            $ret = img_resize($max_width, $max_height, $original_full_path, $cache_full_path);

            if ($ret) {
                return $cache_file; // بعد از ساخت موفق، مسیر فایل کش رو برگردون
            } else {
                return $source_file; // اگر resize موفق نبود همون عکس اصلی رو بده
            }
        }

        // 3. اگر عکس اصلی پیدا نشد
        return $source_file;
    } catch (\Exception $e) {
        return $source_file;
    }
}

function convertWebp($fullPath,$outPutQuality = 100,$deleteOriginal=false){
    try {
        if(file_exists($fullPath)):

            $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
            $extension = $ext;
            $newFilefullPath = str_replace('.'.$ext,'.webp',$fullPath);


            $isValidFormat = false;

            // Create and save
            if($extension == 'png' || $extension == 'PNG' ){
                $img = imagecreatefrompng($fullPath);
                $isValidFormat = true;

            }
            else if($extension == 'jpg' || $extension == 'JPG' || $extension == 'JPEG' || $extension == 'jpeg') {
                $img = imagecreatefromjpeg($fullPath);
                $isValidFormat = true;
            }
            else if($extension == 'gif' || $extension == 'GIF') {
                $img = imagecreatefromgif($fullPath);
                $isValidFormat = true;
            }

            if($isValidFormat){

                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
                imagewebp($img, $newFilefullPath,$outPutQuality);
                imagedestroy($img);

                //delete original file if desired
                if($deleteOriginal){
                    unlink($fullPath);
                }

            }else{
                //if wrong file format
                return (Object) array('error'=>'Given file cannot be converted to webp','status'=>0);
            }

            $newPathInfo = explode('/', $newFilefullPath);
            $finalImage  = $newPathInfo[count($newPathInfo)-1];

            $result = array(
                "fullPath"=>$newFilefullPath,
                "file"=>$finalImage,
                "status"=>1);

            return (Object) $result;

        else:
            return (Object) array('error'=>'File does not exist','status'=>0);
        endif;
    } catch (\Exception $e) {
        return (Object) array('error'=>'Error converting to webp','status'=>0);
    }
}

function img_resize($w, $h , $file, $dst_dir , $crop=false)
{
    // if(getIp() == '5.239.172.88')
    // {
    //     dd($dst_dir);
    // }
    try
    {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }

        //Get file extension
        $exploding = explode(".",$file);
        $ext = end($exploding);

        switch($ext){
            case "png":
                $src = imagecreatefrompng($file);
                $image = "imagepng";
                $level = 9;
            break;
            case "jpeg":
            case "jpg":
                $src = imagecreatefromjpeg($file);
                $image = "imagejpeg";
                $level = 70;
            break;
            case "gif":
                $src = imagecreatefromgif($file);
                $image = "imagegif";
                $level = 70;
            break;
            default:
                $src = imagecreatefromjpeg($file);
                $image = "imagejpeg";
                $level = 70;
            break;
        }

        $dst_img = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst_img, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        $image($dst_img, $dst_dir, $level);
        if ($dst_img) imagedestroy($dst_img);
        if ($src) imagedestroy($src);
        return true;
    } catch (\Exception $e) {

        return false;
    }
}
function img_resize2($max_width, $max_height, $source_file, $dst_dir)
{
    try {
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];
        switch ($mime) {
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;
            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 100;
                break;
            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 100;
                break;
            default:
                return false;
                break;
        }
        if($width>$max_width || $height>$max_height){

            if($width > $height){

                $wi = $max_width;
                $he = ($max_width * $height) / $width;
                if($he>$max_height){
                    $he = $max_height;
                    $wi = ($max_height * $width) / $height;
                }
            }
            else
            {
                 $he = $max_height;
                 $wi = ($max_height * $width) / $height;
                if($wi>$max_width){
                    $wi = $max_width;
                    $he = ($max_width * $height) / $width;
                }
            }
        }
        else
        {
            $he = $height;
            $wi = $width;
        }
        $dst_img = imagecreatetruecolor($wi, $he);
        $src_img = $image_create($source_file);
        //copy image
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $wi, $he, $width, $height);
        $image($dst_img, $dst_dir, 100);
        if ($dst_img) imagedestroy($dst_img);
        if ($src_img) imagedestroy($src_img);
    } catch (\Exception $e) {
        // Do nothing
    }
}

function uploader2($request, $field, $upload_dir = null, $file_type = null, $crop = false, $crop_detail = [])
{
    
    $result = null;
    $prefix = null;
    $base_dir = '/upload/';
    $upload_dir = !empty($upload_dir) ? $upload_dir . '/' : 'images/';
    $dimension = ['small' => 200, 'medium' => 600];
    $prefix = 'img_';
    $publicThumbDir = base_path(env('PUBLIC_PATH')."/upload/images/thumb");
    if (!file_exists($publicThumbDir)) {
        try {
            mkdir($publicThumbDir, 0777);
        } catch (\Exception $e) {
            // Do nothing
        }
    }
    // make upload dir
    if (true) {
        //$file = $request->file($field);
        $filename = $prefix . Str::random(16);
        $fileName = $filename . '.jpg';
        $thumbDir = base_path(env('PUBLIC_PATH')."/upload/images/thumb");
        if (!file_exists($thumbDir)) {
            try {
                mkdir($thumbDir, 0777);
            } catch (\Exception $e) {
                // Do nothing
            }
        }
        if (true) {

            $cropList = $croppedResult = [];
            if ($crop && !empty($crop_detail))
            {
                $crop_dimension = ['large' => [800, 800]];
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate");
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate/".date('Y'));
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate/".date('Y').'/'.date('m'));
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                list($width, $height, $x, $y) = $crop_detail;
                // crop image
                $coppedDimension =[];
                $coppedDimension['large'] = '';
                $cf = $prefix . uniqid();

                foreach ($crop_dimension as $key => $dimension) {
                    $cfn = $cf . '_' . $key;
                    $coppedFileName = $cfn . '.jpg';
                    $streamContext = stream_context_create(
                        array('http'=>
                            array(
                                'timeout' => 10,  //120 seconds
                            )
                        )
                    );

                    try
                    {
                        //$__ = file_get_contents($request, false, $streamContext);
                        $__ = file_get_contents("https://divar2.liara.run/pic.php?image=".$request);

                        file_put_contents(base_path(env('PUBLIC_PATH').$base_dir . $upload_dir . $cfn . '.jpg') , $__);
                        $dst_dir = $source_file = base_path(env('PUBLIC_PATH').$base_dir . $upload_dir . $cfn . '.jpg');
                        $image = imagecreatefromjpeg($source_file);
                        $width = imagesx($image);
                        $height = imagesy($image);
                        //if($key != 'large')
                        {
                            if($width>=$height){
                                $_re = $dimension[0] / $width;
                                $thumb_width = $dimension[0];
                                if($key == 'medium' || $key == 'large'){
                                    $thumb_height = $_re * $height - 200;
                                }
                                elseif($key == 'small')
                                {
                                    $thumb_height = $_re * $height - 50;
                                }
                            }
                            else
                            {
                                $_re = $dimension[1] / $height;
                                $thumb_width = $_re * $width;
                                if($key == 'medium' || $key == 'large'){
                                    $thumb_height = $dimension[1] - 200;
                                }
                                else
                                {
                                    $thumb_height = $dimension[1] - 50;
                                }
                            }
                        }
                    /* else
                        {
                            $thumb_width = $width;
                            $thumb_height = $height - 180;
                        }*/
                        $original_aspect = $width / $height;
                        $thumb_aspect = $thumb_width / $thumb_height;
                        if ( $original_aspect >= $thumb_aspect )
                        {
                            // If image is wider than thumbnail (in aspect ratio sense)
                            $new_height = $thumb_height;
                            $new_width = $width / ($height / $thumb_height);
                        }
                        else
                        {
                            // If the thumbnail is wider than the image
                            $new_width = $thumb_width;
                            $new_height = $height / ($width / $thumb_width);
                        }
                        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
                        // Resize and crop
                        imagecopyresampled($thumb,
                                        $image,
                                        0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                                        0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                                        0, 0,
                                        $new_width, $new_height,
                                        $width, $height);
                        imagejpeg($thumb, $dst_dir, 70);
                        $coppedDimension[$key] = $cfn . '.jpg';

                    }
                    catch (Throwable $e)
                    {
                        report($e);
                        continue;
                    }
                }
                if($coppedDimension != null && $coppedDimension['large'] != '')
                {
                    $croppedResult = [
                        'image_url' => $coppedDimension['large'],//$cf . '.' . $file->getClientOriginalExtension(),
                        'dimension' => $coppedDimension,
                        'extension' => 'jpg'
                    ];
                }
            }
            return $croppedResult;
        }
    }
}


function uploader4($request, $field, $upload_dir = null, $file_type = null, $crop = false, $crop_detail = [])
{
    $result = null;
    $prefix = null;
    $base_dir = env('PUBLIC_PATH').'/upload/';
    $upload_dir = !empty($upload_dir) ? $upload_dir . '/' : 'images/';
    $dimension = ['small' => 200, 'medium' => 600];
    $prefix = 'img_';
    $publicThumbDir = base_path(env('PUBLIC_PATH')."/upload/images/thumb");
    if (!file_exists($publicThumbDir)) {
        try {
            mkdir($publicThumbDir, 0777);
        } catch (\Exception $e) {
            // Do nothing
        }
    }
    // make upload dir
    /*$ud = public_path($base_dir . $upload_dir);
    if (!file_exists($ud)) {
        mkdir($ud, 0777);
    }*/
    if (true) {
        //$file = $request->file($field);
        $filename = $prefix . Str::random(16);
        $fileName = $filename . '.jpg';
        $thumbDir = base_path(env('PUBLIC_PATH')."/upload/images/thumb");
        if (!file_exists($thumbDir)) {
            try {
                mkdir($thumbDir, 0777);
            } catch (\Exception $e) {
                // Do nothing
            }
        }
        if (true) {
            $cropList = $croppedResult = [];
            if ($crop && !empty($crop_detail)) {
                $crop_dimension = ['small' => [200, 200], 'medium' => [600, 600], 'large' => [800, 800]];
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate");
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate/".date('Y'));
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                $CropDir = base_path(env('PUBLIC_PATH')."/upload/images/estate/".date('Y').'/'.date('m'));
                if (!file_exists($CropDir)) {
                    try {
                        mkdir($CropDir, 0777);
                    } catch (\Exception $e) {
                        // Do nothing
                    }
                }
                list($width, $height, $x, $y) = $crop_detail;
                // crop image
                $coppedDimension =[];
                $coppedDimension['large'] = '';
                $cf = $prefix . uniqid();
                foreach ($crop_dimension as $key => $dimension) {
                    $cfn = $cf . '_' . $key;
                    $coppedFileName = $cfn . '.jpg';
                    $streamContext = stream_context_create(
                        array('http'=>
                            array(
                                'timeout' => 10,  //120 seconds
                            )
                        )
                    );
                    try {
                        $__ = file_get_contents($request, false, $streamContext);
                       // dd($__);
                    file_put_contents(base_path($base_dir . $upload_dir . $cfn . '.jpg') , $__);
                    $dst_dir = $source_file = base_path($base_dir . $upload_dir . $cfn . '.jpg');

                    $image = @imagecreatefromjpeg($source_file);
                    $width = imagesx($image);
                    $height = imagesy($image);
                    //if($key != 'large')
                    {
                        if($width>=$height){
                            $_re = $dimension[0] / $width;
                            $thumb_width = $dimension[0];
                            if($key == 'medium' || $key == 'large'){
                                $thumb_height = $_re * $height;
                            }
                            elseif($key == 'small')
                            {
                                $thumb_height = $_re * $height;
                            }
                        }
                        else
                        {
                            $_re = $dimension[1] / $height;
                            $thumb_width = $_re * $width;
                            if($key == 'medium' || $key == 'large'){
                                $thumb_height = $dimension[1];
                            }
                            else
                            {
                                $thumb_height = $dimension[1];
                            }
                        }
                    }

                    $original_aspect = $width / $height;
                    $thumb_aspect = $thumb_width / $thumb_height;
                    if ( $original_aspect >= $thumb_aspect )
                    {
                        // If image is wider than thumbnail (in aspect ratio sense)
                        $new_height = $thumb_height;
                        $new_width = $width / ($height / $thumb_height);
                    }
                    else
                    {
                        // If the thumbnail is wider than the image
                        $new_width = $thumb_width;
                        $new_height = $height / ($width / $thumb_width);
                    }
                    $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
                    // Resize and crop
                    imagecopyresampled($thumb,
                                    $image,
                                    0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                                    0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                                    0, 0,
                                    $new_width, $new_height,
                                    $width, $height);
                    imagejpeg($thumb, $dst_dir, 100);
                    $coppedDimension[$key] = $cfn . '.jpg';

                    } catch (Throwable $e) {
                        report($e);
                        continue;
                    }
                }
                if($coppedDimension != null && $coppedDimension['large'] != '')
                {
                    $croppedResult = [
                        'image_url' => $coppedDimension['large'],//$cf . '.' . $file->getClientOriginalExtension(),
                        'dimension' => $coppedDimension,
                        'extension' => 'jpg'
                    ];
                }
            }
            return $croppedResult;
        }
    }
}
function mergeTextWithDash($str, $default = null)
{
    $str = str_replace('/','',$str);
    if (!empty($str)) {
        $link_rewrite = preg_replace('/\s+/', '-', $str);
    } else {
        $link_rewrite = preg_replace('/\s+/', '-', $default);
    }
    return $link_rewrite;
}
function getIp(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
    return request()->ip(); // it will return the server IP if the client IP is not found using this method.
}
function makeLinkRewrite($str, $default = null)
{
    if (!empty($str)) {
        $res = preg_replace('/\s+/', '-', $str);
    } else {
        $res = preg_replace('/\s+/', '-', $default);
    }
    return $res;
}
function HtmlToText($html_content)
{
    $app_content = strip_tags($html_content, '<img><p><br><table><ul><li><tr><td>');
    $app_content = preg_replace([
        "/<p.*?>/s",
        "/<li.*?>/s",
        "/<tr.*?>/s",
        "/<ul.*?>/s",
        "/<br.*?>/s",
        "/<table.*?>/s",
        "/<td.*?>/s",
        "/<\/td>/s",
        "/<\/[a-zA-Z]+?>/s",
        "/&nbsp;/"
    ], [
        "",
        "*  ",
        "\n\t",
        "\n",
        "\n",
        "\n\n",
        "\n",
        "",
        "\n",
        " "
    ], $app_content);
    preg_match_all('/<img.*?src="(.*?)".*?>/i', $app_content, $urls);
    $urls = $urls[1];
    $app_content = preg_replace('/<img.*?src=".*?".*?>/i', "{{img}}", $app_content);
    return json_encode(['post_content' => $app_content, 'image_urls' => $urls], JSON_UNESCAPED_UNICODE);
}
function StringToArray($array)
{
    $array = preg_replace(['/[^\d|^,|^.]/', '/\./'], ['', ','], $array);
    $array = explode(',', $array);
    $array = array_values(array_filter($array, function ($val) {
        return $val != '';
    }));
    asort($array);
    // convert array values to int
    $array = array_map(function ($val) {
        return (int)$val;
    }, $array);
    return $array;
}
function CompareArray($array, $model)
{
    // get exist ids from table
    $exist_ids = $model::pluck('id');
    // Compare $array with $exist_ids
    $result = array_diff($array, $exist_ids->toArray());
    $array = array_filter($array, function ($val) use ($result) {
        return !in_array($val, $result);
    });
    return $array;
}
// combination multiple array
function get_combinations($arrays)
{
    $result = [[]];
    foreach ($arrays as $property => $property_values) {
        $tmp = [];
        foreach ($result as $result_item) {
            foreach ($property_values as $property_value) {
                $tmp[] = array_merge($result_item, [$property => $property_value]);
            }
        }
        $result = $tmp;
    }
    return $result;
}
// Template: replace variable name with value
function replace_variables($model, $message_text)
{
    $vars = $new_vars = [];
    preg_match_all('/{.*?.*?}/i', $message_text, $vars);
    $vars = array_collapse($vars);
    foreach ($vars as $item) {
        $new_item = str_replace(['{', '}'], ["", ""], $item);
        $new_item = str_replace($new_item, $model->$new_item, $new_item);
        array_push($new_vars, $new_item);
    }
    $combined_values = array_combine($vars, $new_vars);
    $result = strtr($message_text, $combined_values);
    return $result;
}
function sendSms($to_number, $text, $udh = "",$adv="")
{
    if(strlen($to_number) != 11 || substr($to_number , 0 , 2) != '09')return;
    if (trim($text) == '') return;
    date_default_timezone_set('Asia/Tehran');
    $text = str_replace('\n', "\n", $text);
    $input["text"] = $text;
    $text = urlencode("$text");
    $sms_number = env('SMS_NUMBER');
    $username = env('SMS_USERNAME');
    $password = env('SMS_PASSWORD');
    $url_sms = "http://tsms.ir/url/tsmshttp.php?from=$sms_number&to=$to_number&username=$username&password=$password&message=$text";

    eval ("\$url_sms = \"$url_sms\";");
    $code_number = file_get_contents_curl("$url_sms");
    $input["type"] = 1;
    $input["mobile"] = $to_number;

    $user = Auth::user();
    // user not found
    if ($user) {
        $input["user_id"] = $user->id;
    }
    $input["udh"]=$code_number;
    Sms::create($input);
    return $code_number;
}
function sendSmsNew($to_number, $text, $udh = "",$adv="")
{
    if(strlen($to_number) != 11 || substr($to_number , 0 , 2) != '09')return;
    if (trim($text) == '') return;
    date_default_timezone_set('Asia/Tehran');
    $text = str_replace('\n', "\n", $text);
    $input["text"] = $text;
    $text = urlencode("$text");
    $sms_number = '3000101160';
    $username = 'asanrayan';
    $password = 'tyvbgxpd';
    $url_sms = "http://tsms.ir/url/tsmshttp.php?from=$sms_number&to=$to_number&username=$username&password=$password&message=$text";

    eval ("\$url_sms = \"$url_sms\";");
    $code_number = file_get_contents_curl("$url_sms");
    // $input["type"] = 1;
    // $input["mobile"] = $to_number;

    // $user = Auth::user();
    // // user not found
    // if ($user) {
    //     $input["user_id"] = $user->id;
    // }
    // $input["udh"]=$code_number;
    // Sms::create($input);
    return $code_number;
}

function file_get_contents_curl($url) {
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 ); //Set curl to return the data instead of printing it to the browser.
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
    $data = curl_exec ( $ch );
    curl_close ( $ch );
    return $data;
}
function sendSms2($receptor, $message)
{
    date_default_timezone_set('Asia/Tehran');
    $text = str_replace('\n', "\n", $message);
    $text = urlencode($text);
    //$sms_number = $receptor;
    $sms_number = env('TSMS_NUMBER');
	$to_number = $receptor;
    $username = env('TSMS_USERNAME');
    $password = env('TSMS_PASSWORD');
    $url_sms = "http://tsms.ir/url/tsmshttp.php?from=$sms_number&to=$to_number&username=$username&password=$password&message=$text";
    eval ("\$url_sms = \"$url_sms\";");
    $code_number = file_get_contents_curl("$url_sms");
    return $code_number;
}

function smsSendRequest($url, $postVars = array())
{
    $postStr = http_build_query($postVars);
    $options = array(
        'http' =>
            array(
                'method' => 'POST', //We are using the POST HTTP method.
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postStr //Our URL-encoded query string.
            )
    );
    $streamContext = stream_context_create($options);
    $result = file_get_contents($url, false, $streamContext);
    if ($result === false) {
        $error = error_get_last();
        throw new Exception('POST request failed: ' . $error['message']);
    }
    return $result;
}
function makeUserCode($cityID)
{
    // find city
    $city = City::find($cityID);
    if (!$city || empty($city->code)) {
        return null;
    }

    // get city code
    $cityPrefix = $city->code;
    // first code
    $userCode = $cityPrefix . '_1001';

    $cityUsersCode = User::where('city_id', $cityID)->pluck('code');
    $existsCodes = [];

    foreach ($cityUsersCode as $code) {
        if (!empty($code)) {
            $codeArray = explode('_', $code);
            $codeId = (int) ($codeArray[1] ?? 0);
            if (!empty($codeId)) {
                $existsCodes[] = $codeId;
            }
        }
    }

    // مرتب‌سازی با توابع PHP
    sort($existsCodes);

    $lastId = end($existsCodes);
    if (!empty($lastId)) {
        $userCode = $cityPrefix . '_' . ($lastId + 1);
    }

    return $userCode;
}


// روزهای هفته
function workDays()
{
    $days = [
        1 => 'شنبه',
        2 => 'یکشنبه',
        3 => 'دوشنبه',
        4 => 'سه شنبه',
        5 => 'چهارشنبه',
        6 => 'پنجشنبه',
        7 => 'جمعه'
    ];
    return $days;
}
function CustomerGrade($key = null)
{
    $arr = [
        1 => 'Fresh Lead',
        2 => 'F24',
        3 => 'Lead Store',
        4 => 'Old Lead',
        5 => 'Hot Lead'
    ];
    if (!empty($key)) {
        if($key != null && $key>0)
        {
            return $arr[$key];
        }
        else
        {
            return '';
        }
    }
    return $arr;
}
function CustomerStatus($key = null)
{
    if(ss('SITE_ID') == 3){
        $arr = [
            1 => l('جاری'),
            2 => 'خرید از کومه',
            3 => 'خرید خارج از کومه',
            4 => l('انصرافی')/*,
            9 => 'انصرافی'*/
        ];
    }
    elseif(ss('SITE_ID') == 5 || ss('SITE_ID') == 8)
    {
        $arr = [
            1 => l('جاری'),
            4 => l('آرشیو'),
            3 => '',
            8 => 'در انتظار حذف و ویرایش'
        ];
    }

    else
    {
        $arr = [
            1 => l('جاری'),
            4 => l('آرشیو')
        ];
    }
    if (!empty($key)) {
        if($key != null)
        {
            return $arr[$key];
        }
        else
        {
            return '';
        }
    }
    return $arr;
    // switch($key){
    //     case 1:return "جاری";break;
    //     case 2:return "عمومی";break;
    //     case 3:return "آرشیو";break;
    // }
}
//وضعیت های ملک
function confirmStatuses($key = null,$statusBadge = null)
{
    if(ss('SITE_ID') == 3){
        $arr = [
            'verified' => 'جاری',
            'rejected' => 'آرشیو شده',
            'tradedoutsideoffice' =>  'معامله شده در کومه',
            'tradedoffice' => 'معامله شده خارج از کومه',
            'withdrawal' => 'انصرافی',
            //'colleague' => 'همکار',
            'repetitious' => 'تکراری',
            'missedcall' => 'تماس بی پاسخ'
            //'pending' => 'در انتظار تائید'
        ];
    }
    elseif(ss('SITE_ID') == 5 || ss('SITE_ID') == 8)
    {
        $arr = [
            'verified' => 'جاری',
            'rejected' => 'آرشیو شده',
            'withdrawal' => 'انصرافی',
            'tradedoutsideoffice' =>  'معامله شده',
            'tradedoffice' => 'معامله شده در  دفتر',
            'hidden' => 'مخفی'
        ];
    }
    elseif(env('COUNTRY') == 'UAE')
    {
        $arr = [
            'verified' => 'جاری',
            'rejected' => 'آرشیو شده'
        ];
    }
    else
    {
        $arr = [
            'verified' => 'جاری',
            'rejected' => 'آرشیو شده',
            'pending' => 'در انتظار تائید',

        ];
    }
    if (!empty($key))
    {
        if($key == 'rejected')
        {
            return 'آرشیو شده';
        }
        else
        {
            return $arr[$key];
        }
    }
    $cssClasses = [
        "pending" => "orange",
        "verified" => "bg-olive",
        "rejected" => "bg-red",
    ];
    if (!empty($statusBadge)) {
        return $cssClasses[$statusBadge];
    }
    return $arr;
}
//وضعیت های ملک
function branchStatuses($key = null,$statusBadge = null)
{
    $arr = [
        '0' => 'در انتظار تایید',
        '1' => 'تایید شده',
        '2' => 'رد شده',
        '3' => 'معلق'
    ];
    if (!is_null($key)) {
        return $arr[$key];
    }
    $cssClasses = [
        '0' => "bg-yellow-active",
        '1' => "bg-olive",
        '2' => "bg-red",
        '3' => "bg-gray-active",
    ];
    if (!is_null($statusBadge)) {
        return $cssClasses[$statusBadge];
    }
    return $arr;
}
function offplanyear()
{
    for($i=2025 ; $i<date('Y')+15 ; $i++)
    {
        $_[$i*10] = $i.' '.' Q1';
        $_[$i*10 + 1] = $i.' '.' Q2';
        $_[$i*10 + 2] = $i.' '.' Q3';
        $_[$i*10 + 3] = $i.' '.' Q4';
    }
    return $_;
}
function getoffplanyear($number)
{
    $year = intdiv($number, 10); // حاصل تقسیم صحیح
    $remainder = $number % 10;       // باقیمانده
    switch($remainder)
    {
        case 0:
            $sq = 'Q1';
            break;
        case 1:
            $sq = 'Q2';
            break;
        case 2:
            $sq = 'Q3';
            break;
        case 3:
            $sq = 'Q4';
            break;
        default:
            $sq = '';

    }
    if($year>2020)
    {
        return $year.' '.$sq;
    }
    else
    {
        return '';
    }
}
function estateStatuses()
{
    return [-1 => 'عمومی', 1 => 'موجود', 2 => 'انصرافی', 3 => 'در حال معامله', 4 => 'معامله شده'];
}
function mapEstateStatusName($str)
{
    $arr = [-1, 1, 2, 3, 4];
    $arr2 = ['عمومی', 'موجود', 'انصرافی', 'در حال معامله', 'معامله شده'];
    $result = str_replace($arr, $arr2, $str);
    return $result;
}
//اولویت
function priorities($key = null)
{
    $arr = [
        1 => 'زیاد',
        2 => 'متوسط',
        3 => 'کم',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
//لیبل
function labels($key = null)
{
    $arr = [
        1 => 'طلایی',
        2 => 'نقره ای',
        3 => 'برنزی',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}

//نوع و جنس ملک
function estateTypes($key = null)
{
    if(env('COUNTRY') == 'UAE'){
        $arr = [
            1  => l('آپارتمان'),
            2  => l('ویلا'),
            3  => l(''), // (خالی)
            4  => l('زمین'),
            6  => l('تاون‌هاوس'),
            7  => l('پنت‌هاوس'),
            8  => l('مجتمع ویلاها (ویلا کامپوند)'),
            9  => l('آپارتمان هتلی'),
            10 => l('زمین مسکونی'),
            11 => l('طبقه مسکونی'),
            12 => l('ساختمان مسکونی'),
            13 => l('واحد فروش عمده'),
            16 => l('دفتر کار'),
            17 => l('مغازه'),
            18 => l('انبار'),
            19 => l('اردوگاه کارگری'),
            20 => l('ویلا تجاری'),
            21 => l('واحد عمده فروشی'),
            22 => l('زمین تجاری'),
            23 => l('طبقه تجاری'),
            24 => l('ساختمان تجاری'),
            25 => l('کارخانه'),
            26 => l('زمین صنعتی'),
            27 => l('زمین کاربری مختلط'),
            28 => l('نمایشگاه'),
            29 => l('سایر موارد تجاری')
        ];
    }
    elseif(ss('SITE_ID') == 3)
    {
        $arr = [
            1 => 'آپارتمان',
            2 => 'منزل ویلایی',
            3 => 'مغازه',
            4 => 'زمین',
            5 => 'صنعتی',
            6 => 'ساختمان و مستغلات',
            7 => 'باغ و ویلا',
            8 => 'پیش فروش'
        ];
    }
    elseif(ss('SITE_ID') == 7)
    {
        $arr = [
            1 => 'آپارتمان',
            2 => 'منزل ویلایی',
            4 => 'زمین و خانه کلنگی',
            5 => 'صنعتی',
            6 => 'آپارتمان یک جا',
            7 => 'باغ و ویلا',
            8 => 'زمین کشاورزی و باغ',
            9 => 'مغازه و غرفه',
            10 => 'کارگاه و کارخانه',
            11 => 'آپارتمان تجاری یک جا',
            12 => 'اداری, دفتر کار و مطب',
            13 => 'زمین تجاری',
            14 => 'مشارکت در ساخت و ساز',
            15 => 'پیش فروش',
        ];
    }
    else
    {
        $arr = [
            1 => 'آپارتمان',
            2 => 'منزل ویلایی',
            3 => 'مغازه',
            4 => 'زمین و باغ',
            5 => 'صنعتی-تجاری'
        ];
    }
    if (!empty($key)) {
        if($key != null)
        {
            return $arr[$key];
        }
        else
        {
            return '';
        }
    }
    return $arr;
}
function estateTypesRental($key = null)
{
    $arr = [
        2 => 'ویلایی',
        1 => 'آپارتمان',
        10 => 'هتل',
        11 => 'کلبه و آلاچیق'
    ];
    if (!empty($key)) {
        if($key != null)
        {
            return $arr[$key];
        }
        else
        {
            return '';
        }
    }
    return $arr;
}
function estateTypesResidential($key = null)
{
    if(env('COUNTRY') == 'UAE'){
        $arr = [
            1  => 'آپارتمان',
            2  => 'ویلا',
            4  => 'زمین',
            6  => 'تاون‌هاوس',
            7  => 'پنت‌هاوس',
            8  => 'مجتمع ویلاها',
            9  => 'آپارتمان هتلی',
            10 => 'پلاک مسکونی',
            11 => 'طبقه مسکونی',
            12 => 'ساختمان مسکونی',
            13 => 'واحد فروش عمده'
        ];
    }
    elseif(ss('SITE_ID') == 3)
    {
        $arr = [
            1 => 'آپارتمان',
            2 => 'منزل ویلایی',
            3 => 'مغازه',
            4 => 'زمین',
            5 => 'صنعتی',
            6 => 'ساختمان و مستغلات',
            7 => 'باغ و ویلا'
        ];
    }
    else
    {
        $arr = [
            1 => 'آپارتمان',
            2 => 'منزل ویلایی',
            3 => 'مغازه',
            4 => 'زمین و باغ',
            5 => 'صنعتی-تجاری'
        ];
    }
    if (!empty($key)) {
        if($key != null)
        {
            return $arr[$key];
        }
        else
        {
            return '';
        }
    }
    return $arr;
}
function estateTypesCommercial($key = null)
{
    if(env('COUNTRY') == 'UAE'){
        $arr = [
            16 => 'دفتر اداری',
            17 => 'مغازه',
            18 => 'انبار',
            19 => 'اردوگاه کارگری',
            20 => 'ویلا تجاری',
            21 => 'واحد عمده فروشی',
            22 => 'زمین تجاری',
            23 => 'طبقه تجاری',
            24 => 'ساختمان تجاری',
            25 => 'کارخانه',
            26 => 'زمین صنعتی',
            27 => 'زمین با کاربری ترکیبی',
            28 => 'نمایشگاه',
            29 => 'سایر املاک تجاری'

        ];
    }
    elseif(ss('SITE_ID') == 3)
    {
        $arr = [
            1 => 'آپارتمان',
            2 => 'منزل ویلایی',
            3 => 'مغازه',
            4 => 'زمین',
            5 => 'صنعتی',
            6 => 'ساختمان و مستغلات',
            7 => 'باغ و ویلا'
        ];
    }
    else
    {
        $arr = [
            1 => 'آپارتمان',
            2 => 'منزل ویلایی',
            3 => 'مغازه',
            4 => 'زمین و باغ',
            5 => 'صنعتی-تجاری'
        ];
    }
    if (!empty($key)) {
        if($key != null)
        {
            return $arr[$key];
        }
        else
        {
            return '';
        }
    }
    return $arr;
}
function last_operation($type , $customer_id)
{
    $estateOperation = EstateOperation::where('customer_id' , $customer_id)->where('type' , $type)->orderBy('id', 'desc')->first();
    return $estateOperation;
}
function language_list()
{
    return Language::get();
}
function country_list()
{
    return Country::get();
}
function usage_type($key = null)
{
    if(ss('SITE_ID') == 3){
        $arr = [
            107 => 'مسکونی',
            109 => 'تجاری',
            108 => 'اداری',
            110 => 'اداری - تجاری',
            253 => 'تجاری - مسکونی',
            285 => 'کشاورزی',
            288 => 'صنعتی',
            111 => 'گردشگری',
            341 => 'بدون توافق',
            112 => 'غیره'
        ];
    }
    elseif(ss('SITE_ID') == 2){
        $arr = [
            107 => 'مسکونی',
            109 => 'تجاری',
            108 => 'اداری',
            110 => 'اداری - تجاری',
            253 => 'تجاری - مسکونی',
            285 => 'کشاورزی',
            286 => 'باغ',
            288 => 'صنعتی',
            111 => 'گردشگری',
            341 => 'بدون توافق',
            112 => 'غیره'
        ];
    }
    elseif(env('COUNTRY') == 'UAE'){
        $arr = [
            107 => 'مسکونی',
            109 => 'تجاری'
        ];
    }
    else
    {
        $arr = [
            107 => 'مسکونی',
            109 => 'تجاری',
            108 => 'اداری',
            253 => 'مسکونی به همراه تجاری',
            285 => 'کشاورزی',
            288 => 'صنعتی',
            110 => 'مسکونی با موقعیت اداری - تجاری',
            341 => 'بدون توافق',
            112 => 'غیره'
        ];
    }
    if (!empty($key)) {
        if($key != null)
        {
            return $arr[$key];
        }
        else
        {
            return '';
        }
    }
    return $arr;
}
//نوع و جنس ملک به انگلیسی
function estateTypesEn($key = null)
{
    $arr = [
        1 => 'apartment',
        2 => 'villa',
        3 => 'store',
        4 => 'land',
        5 => 'industrial-commercial',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
//دریافت کلید به ازای مقدار نوع و جنس ملک
function estateTypesKey($name = null)
{
    $arr = [
        'apartment' => 1,
        'villa' => 2,
        'store' => 3,
        'land' => 4,
        'industrial-commercial' => 5,
    ];
    if (!empty($name)) {
        return $arr[$name];
    }
    return $arr;
}
// نحوه آشنایی
function acquaintanceTypes($key = null)
{
    $arr = [
        1 => 'سایت '.ss('SITE_NAME'),
        2 => 'شبکه های اجتماعی',
        3 => 'ارتباطات شخصی',
        4 => 'حضوری',
        5 => 'تلفنی',
        7 => 'دیوار',
        6 => 'غیره',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
// نوع و وضعیت سند
function documentTypes($key = null)
{
    $arr = [
        1 => 'شش دانگ',
        2 => 'سرقفلی',
        3 => 'مشاع',
        4 => 'اوقافی',
        5 => 'مسکن مهر',
        6 => 'وکالتی',
        7 => 'قولنامه ای',
        8 => 'بنیادی',
        9 => 'زمین شهری',
        10 => 'شورایی',
        11 => 'در دست اقدام',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
// دلیل فروش
function saleReasons($key = null)
{
    $arr = [
        1 => 'سرمایه گذاری',
        2 => 'نیاز به نقدینگی',
        3 => 'تبدیل و جابجایی',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
// وضعیت سکونت
function residenceTypes($key = null)
{
    $arr = [
        1 => 'سکونت مالک',
        2 => 'سکونت مستاجر',
        3 => 'تخلیه',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
// دلیل خرید
function purchaseReasons($key = null)
{
    $arr = [
        1 => 'سرمایه گذاری',
        2 => 'استفاده',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
// وضعیت سکونت مشتری
function residenceTypes_Customer($key = null)
{
    $arr = [
        1 => 'مقیم محلی',
        2 => 'مقیم غیر محلی',
        3 => 'مهاجر',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
// تحصیلات
function educationTypes($key = null)
{
    $arr = [
        1 => 'زیردیپلم',
        2 => 'دیپلم',
        3 => 'لیسانس',
        4 => 'فوق لیسانس',
        5 => 'دکتری و بالاتر',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
// وضعیت نقدینگی
function financialLiquidityTypes($key = null)
{
    $arr = [
        1 => 'کاملا نقد',
        2 => 'بخشی نقد',
        3 => 'غیر نقد',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
// نوع ملک
function mapEstateCategoryName($str)
{
    if((int)$str == 0)
    {
        return '';
    }
    if(env('COUNTRY') == 'UAE'){
        $arr2 = [
            1 => 'آپارتمان',
            2 => 'ویلا',
            3 => 'مغازه',
            4 => 'زمین',
            6 => 'تاون هاوس',
            7 => 'پنت هاوس',
            8 => 'کامپوند (مجتمع مسکونی محصور)',
            9 => 'داپلکس (ساختمان دو طبقه مستقل)',
            10 => 'طبقه کامل',
            11 => 'نیم طبقه',
            12 => 'ساختمان کامل',
            13 => 'واحد فروش عمده',
            14 => 'بانگلو (خانه تک واحدی)',
            15 => 'هتل - آپارتمان هتلی',
            16 => 'فضای اداری',
            17 => 'فضای خرده فروشی',
            18 => 'انبار',
            19 => 'مغازه',
            20 => 'نمایشگاه',
            21 => 'واحد فروش عمده',
            22 => 'کارخانه',
            23 => 'اردوگاه کارگری',
            24 => 'اسکان کارکنان',
            25 => 'مرکز کسب و کار',
            26 => 'فضای کار اشتراکی',
            27 => 'مزرعه',
        ];
    }
    else
    {
        $arr2 = [
            1 => 'آپارتمان',
            2 => 'منزل ویلایی',
            3 => 'مغازه',
            4 => 'زمین و باغ',
            5 => 'صنعتی-تجاری',
            6 => 'ساختمان و مستغلات',
            7 => 'باغ و ویلا',
            8 => 'پیش فروش'
        ];
    }
    $result = $arr2[$str];
    return $result;
}
function getFieldFaName($str)
{
    $arr = [
        'conditions',
        'document_type',
        'structure_type',
        'position_type',
        'facilities',
        'kitchen',
        'heating_cooling',
        'usage_type',
        'geography',
        'built_year',
        'residence_type',
        'build_license',
        'rent_type',
        'convertible',
        'floor_type',
        'floor_start',
        'floor_count',
        'unit_in_floor',
        'room_count',
        'floor',
    ];
    $arr2 = [
        'شرایط',
        'نوع سند',
        'نوع سازه',
        'نوع موقعیت',
        'امکانات',
        'آشپزخانه',
        'سیستم سرمایش و گرمایش',
        'کاربری',
        'جهت جغرافیایی',
        'سال ساخت',
        'وضعیت سکونت',
        'پروانه ساختمانی',
        'نوع اجاره',
        'قابلیت تبدیل',
        'نوع طبقات',
        'شروع طبقات',
        'تعداد طبقات',
        'تعداد واحد در طبقه',
        'تعداد اتاق',
        'شماره طبقه',
    ];
    $result = str_replace($arr, $arr2, $str);
    return $result;
}

function isValueShow($key,$val){
    if(!empty($key))
    {
        foreach(json_decode($key,true) as $value)
        {
            if($value==$val)
                return true;
        }
    }
    else
    {
        return false;
    }
}

function checkValueCreate($key,$val){
    if(!empty($key))
    {
        foreach(json_decode($key,true) as $value){
            if($value==$val) return 'checked';
        }
    }
    else
    {
        return '';
    }
}
function selectValueCreate($key,$val){
    if(!empty($key) && (is_array(json_decode($key,true)) || is_object(json_decode($key,true))) ){

        foreach(json_decode($key,true) as $value){
            if($value==$val) return 'selected';
        }
    }
    else
    {
        return '';
    }
}
function getvalueMeta($array,$key,$type){
    $val="";
    $fieldset=json_decode($key,true);
    $numItems = count($fieldset);
    $i=0;
    foreach(json_decode($key,true) as $value){
        if(++$i == $numItems) {
            $val.=$array[$type][$value];
        }
        else
        {
           $val.=$array[$type][$value]." , ";
        }
    }
    return $val;
}
function getvalueMetaFacility($array,$key,$type){
    $val="";
    $fieldset=json_decode($key,true);
    return json_decode($key,true);
    //$val=IconFacility("هود");
    /*$fieldset=json_decode($key,true);
    $numItems = count($fieldset);
    $i=0;
    foreach(json_decode($key,true) as $value){
        if(++$i == $numItems) {
            $val.=$array[$type][$value];
        }
        else
        {
           $val.=$array[$type][$value]." , ";
        }
    }*/
    //return $val;
}
function IconFacility($key){
    $arr = [
        "هود" => "hood",
        "انباری" => "warehouse",
        "آلاچیق" => "alachigh",
        "آنتن مرکزی"=>"anten_markazi",
        "آسانسور"=>"asansor_barbari",
        "آسانسور باربری"=>"asansor_barbari",
        "آسانسور خودروبر"=>"asansor_khodro",
        "بالکن"=>"balcon",
        "باربکیو"=>"barbeqiu",
        "درب ریموت دار"=>"darbe_remote_dar",
        "درب ضد حریق"=>"darbe_zede_harigh",
        "درب ضد سرقت"=>"darbe_zede_serghat",
        "دوربین مدار بسته"=>"dorbine_madar_baste",
        "استخر"=>"estakhr",
        "آیفون تصویری"=>"iphone_tasviri",
        "جکوزی"=>"jakozi",
        "جاروبرقی مرکزی"=>"jaro_markazi",
        "کف سرامیک"=>"kaf_ceramic",
        "کف موکت"=>"kaf_moket",
        "کف موزاییک"=>"kaf_mosaic",
        "کف پارکت"=>"kaf_parket",
        "کف سنگ"=>"kaf_sang",
        "کاغذ دیواری"=>"kaghaz_divari",
        "کمد دیواری"=>"komod_divari",
        "لابی"=>"lobby",
        "لابی من"=>"lobby",
        "نگهبانی"=>"negahban",
        "پنجره دوجداره"=>"panjere_do_jedare",
        "پرده"=>"parde",
        "پاسیو"=>"pasio",
        "روف گاردن"=>"roof_garden",
        "پارکینگ"=>"parking",
        "سالن اجتماعات"=>"salone_ejtemaat",
        "سالن پرده خور"=>"salone_pardekhor",
        "سالن ورزشی"=>"salone_varzeshi",
        "شوتینگ زباله"=>"shoting_zobale",
        "سونا"=>"sona",
        "تراس (فضای آزاد بدون سقف)"=>"terrace",
        "ایرانی"=>"wc_irani",
        "فرنگی"=>"wc_farangi",
        "ایرانی-فرنگی"=>"wc_farangi",
//        "پکیج"=>"heating",
//        "بخاری"=>"heater",
//        "رادیات"=>"heating",
        "شومینه"=>"shomineh",
//        "موتورخانه مرکزی"=>"heating (1)",
//        "فن کوئل"=>"ac",
        "گاز صفحه ای"=>"ac",
        "بخاری"=>"bokhari",
        "رادیات"=>"radiat",
        "گرمایش از کف"=>"garmayesh_az_kaf",
        "موتورخانه مرکزی"=>"motorkhane_markazi",
        "پکیج"=>"package_abgarmkon",
        "آب گرمکن ایستاده"=>"package_abgarmkon",
        "آب گرمکن"=>"package_abgarmkon",
        "چیلر"=>"chiler",
        "مینی چیلر"=>"chiler",
        "فن کوئل"=>"fancoel",
        "کولر آبی"=>"koolerabi",
        "کولر گازی"=>"gazi",
        "داکت اسپیلت"=>"gazi",
        "هواساز"=>"Havasaz_VRF_GHP",
        "VRF"=>"Havasaz_VRF_GHP",
        "GHP"=>"Havasaz_VRF_GHP",
        "تعداد طبقه"=>"tabaghe",
        "جهت جغرافیایی"=>"joghrafi",
        "موقعیت مکانی"=>"joghrafi",
        "نوع سند"=>"document",
        "متراژ بر"=>"3",
        "سال ساخت"=>"year",
        "تعداد خواب"=>"room",
        "کاربری"=>"home",
        "قابليت تبديل"=>"smart-home-svgrepo-com",
        "Study Room"=>"people-study",
        "Electricity Backup"=>"electricity",
        "Central Heating"=>"heating",
        "Centrally Air-Conditioned"=>"air-conditioner",
        "Double Glazed Windows"=>"windows",
        "Swimming Pool"=>"pool",
        "Steam Room"=>"steam-bath",
        "Sauna"=>"sauna",
        "Jacuzzi"=>"jacuzzi",
        "Gym or Health Club"=>"heating",
        "First Aid Medical Center"=>"first-aid-kit",
        "Cafeteria or Canteen"=>"tray-food-svgrepo-com",
        "Lawn or Garden"=>"garden",
        "Kids Play Area"=>"playground",
        "Day Care Center"=>"care-treatment-heart",
        "Barbeque Area"=>"barbeque",


        "اتاق مطالعه"=>"people-study",
        "برق اضطراری"=>"electricity",
        "گرمایش مرکزی"=>"heating",
        "سیستم تهویه مطبوع مرکزی"=>"air-conditioner",
        "پنجره‌های دوجداره"=>"windows",
        "استخر شنا"=>"pool",
        "اتاق بخار"=>"steam-bath",
        "سونا"=>"sauna",
        "جکوزی"=>"jacuzzi",
        "باشگاه ورزشی یا مرکز سلامت"=>"heating",
        "مرکز فوریت‌های پزشکی"=>"first-aid-kit",
        "کافه تریا یا غذاخوری"=>"tray-food-svgrepo-com",
        "چمنزار یا باغ"=>"garden",
        "فضای بازی کودکان"=>"playground",
        "مهد کودک"=>"care-treatment-heart",
        "محل باربیکیو"=>"barbeque",
        "فول امکانات"=>"Semi-Furnished",
        "بدون امکانات"=>"Unfurnished",
        "نیمه مبله"=>"Semi-Furnished",
        "اتاق رختشویی"=>"LaundryRoom",
        "اتاق راننده"=>"DriverRoom",
        "اتاق خدمتکار"=>"MaidRoom",
        "اقساط پس از تحویل"=>"phpp",
        "استخر با لبه باز"=>"pool",
        "استخر اختصاصی"=>"pool",
        "استخر کودک"=>"pool",
        "باشگاه اختصاصی"=>"heating",
        "خدمات نظافت"=>"LaundryRoom",
        "رختکن"=>"komod_divari",
        "کمد دیواری"=>"komod_divari",

        "خدمات پذیرش"=>"DriverRoom",
        "خانه هوشمند"=>"smart-home-svgrepo-com",
        "حیوان خانگی مجاز"=>"no-pets-svgrepo-com",
        "فضای سبز"=>"garden-tree-plant-svgrepo-com",
        "چشم‌انداز بنای معروف"=>"landmark-svgrepo-com",
        "چشم‌انداز آب"=>"water-svgrepo-com",

    ];
    if (!empty($key)) {
        return $arr[$key] ?? '';
    }
    return $arr;
}
// دریافت فیلدهای ملک از جدول
function getMetaValues($kind,$sale){
    $result = [];
    // get metaValues from db
    $newFields = DB::table('metavalue')
        ->where('kind',$kind)
        ->where('sale',$sale)
        ->where('deleted',0)
        ->get()
        ->toArray();
    foreach ($newFields as $fieldGroup){
        $result[$fieldGroup->type][$fieldGroup->id] = $fieldGroup->title;
    }
    return $result;
}
// دریافت امکانات ملک
function getFeatures($kind,$type){
    $result = [];
    if($kind>0){
        $kinds = [
            1 => 'apartment',
            2 => 'villa',
            3 => 'store',
            4 => 'land',
            5 => 'industrial',
        ];
        $selectedKind = $kinds[$kind];//get selected kind
        $selectedKind = $selectedKind.$type;
        $featureType = $type == 1 ? 'sale' : 'rent';
        $features = Feature::with([
            'values' => function ($q) use ($selectedKind) {
                $q->where($selectedKind, 1);
            }
        ])->where($featureType, 1)
            ->orderBy('position', 'desc')
            ->get();
    }
    else
    {
        /*$features = Cache::remember('similarEstates-0' , 3000, function (){
            return Feature::join('feature_values', 'feature_values.feature_id', '=', 'features.id')->get();
        });*/
        $features = Feature::join('feature_values', 'feature_values.feature_id', '=', 'features.id')->get();
    }
    foreach ($features as $feature){
        //$values = $feature->values->pluck('title','id')->toArray() ?? [];
        //if($values){
            $result[$feature->title_en][$feature->id] = $feature->title;
        //}
    }
    //dd($result);
    return $result;
}
function getFeatureValue($featureValues,$fieldId=null){
    if(empty($fieldId)){
        return '';
    }
    if(empty($featureValues)){
        return '';
    }

    $fv = $featureValues->where('id',$fieldId)->first();
    if(!$fv){
        return '';
    }
    return $fv->title ?? '';
}
function getMetaValuesk($documenttype){
    $result ="";
    // get metaValues from db
    $newFields = DB::table('metavalue')
        ->where('deleted',0)
        ->where("id",$documenttype)
        ->get()
        ->toArray();
        foreach ($newFields as $fieldGroup){
            $result= $fieldGroup->title;
        }
   return $result;
}
// فیلدهای فروش ملک براساس نوع و جنس ملک
function getSaleFields($estateType, $field = null, $key = null)
{
    $arr[1] = [
        'conditions' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'ندارد',
                'پیش فروش',
                'قابل معاوضه',
                'وام دار',
                'مجتمع/ برج',
                'قدرالسهمی',]
        ],
        'unit_in_floor' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12',
                '13',
                '14',
                '15',
                '16',
                '17',
                '18',
                '19',
                '20',
                '21',
                '22',
                '23',
                '24',
                '25',
                '26',
                '27',
                '28',
                '29',
                '30',
                'بیشتر از 30',
            ]
        ],
        'document_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'شش دانگ',
                'سرقفلی',
                'مشاع',
                'اوقافی',
                'مسکن مهر',
                'وکالتی',
                'قولنامه ای',
                'بنیادی',
                'زمین شهری',
                'شورایی',
                'در دست اقدام',]
        ],
        'structure_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'فلزی',
                'بتنی',
                'بتنی – فلزی',
                'غیره',]
        ],
        'facilities' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'پارکینگ',
                'انباری',
                'آسانسور',
                'سالن پرده خور',
                'استخر',
                'سونا',
                'جکوزی',
                'پرده',
                'کاغذ دیواری',
                'کف سرامیک',
                'کف پارکت',
                'کف لمینت',
                'کف سنگ',
                'کف موزاییک',
                'کف موکت',
                'درب ضد سرقت',
                'درب ضد حریق',
                'کمد دیواری',
                'لابی',
                'نگهبانی',
                'سرایداری',
                'لابی من',
                'سالن اجتماعات',
                'سالن ورزشی',
                'پنجره دوجداره',
                'پاسیو',
                'باربکیو',
                'بالکن (فضای آزاد سقف دار)',
                'تراس (فضای آزاد بدون سقف)',
                'آیفون تصویری',
                'شوتینگ زباله',
                'جاروبرقی مرکزی',
                'آنتن مرکزی',
                'آسانسور باربری',
                'آسانسور خودروبر',
                'روف گاردن',
                'درب ریموت دار',
                'آلاچیق',
                'دوربین مدار بسته',]
        ],
        'kitchen' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'هود',
                'گاز صفحه ای',
                'آب شیرین کن',
                'فضای ماشین ظرفشویی',
                'فضای ماشین لباسشویی',
                'MDF',
                'ممبران',
                'فلزی',
                'چوب',
                'فلز و MDF',
                'مطبخ',
                'کابینت',]
        ],
        'heating_cooling' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'بخاری',
                'رادیات',
                'پکیج',
                'فن کوئل',
                'چیلر',
                'مینی چیلر',
                'کولر گازی',
                'داکت اسپیلت',
                'کولر آبی',
                'موتورخانه مرکزی',
                'شومینه',
                'گرمایش از کف',
                'هواساز',
                'VRF',
                'GHP',
                'آب گرمکن ایستاده',
                'آب گرمکن',
                'سایر',]
        ],
        'usage_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'مسکونی',
                'اداری',
                'تجاری',
                'مسکونی با موقعیت اداری - تجاری',
                'گردشگری',
                'غیره',]
        ],
        'geography' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'شمالی',
                'جنوبی',
                'شرقی',
                'غربی',
                'دوبر',
                'سه بر',
                'چهاربر',
                'دوکله',]
        ],
        'floor' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                '-1' => 'زیرهمکف',
                '0' => 'همکف',
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '13' => '13',
                '14' => '14',
                '15' => '15',
                '16' => '16',
                '17' => '17',
                '18' => '18',
                '19' => '19',
                '20' => '20',
                '21' => '21',
                '22' => '22',
                '23' => '23',
                '24' => '24',
                '25' => '25',
                '26' => '26',
                '27' => '27',
                '28' => '28',
                '29' => '29',
                '30' => '30',
                '31' => 'بیشتر از 30',
                '32' => 'پنت هاوس',
            ]
        ],
        'floor_count' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12',
                '13',
                '14',
                '15',
                '16',
                '17',
                '18',
                '19',
                '20',
                '21',
                '22',
                '23',
                '24',
                '25',
                '26',
                '27',
                '28',
                '29',
                '30',
                'بیشتر از 30',]
        ],
        'room_count' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'بدون اتاق',
                '1',
                '2',
                '3',
                '4',
                'بیشتر از 4',]
        ],
        'built_year' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'کلید نخورده',
                '1400',
                '1399',
                '1398',
                '1397',
                '1396',
                '1395',
                '1394',
                '1393',
                '1392',
                '1391',
                '1390',
                '1389',
                '1388',
                '1387',
                '1386',
                '1385',
                '1384',
                '1383',
                '1382',
                '1381',
                '1380',
                '1379',
                '1378',
                '1377',
                '1376',
                '1375',
                '1374',
                '1373',
                '1372',
                '1371',
                '1370',
                '1369',
                '1368',
                '1367',
                '1366',
                '1365',
                '1364',
                '1363',
                '1362',
                '1361',
                '1360',
                'قبل از 1360',]
        ],
        'residence_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'سکونت مالک',
                'سکونت مستاجر',
                'تخلیه',]
        ],
    ];
    $arr[2] = [
        'conditions' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'ندارد',
                'پیش فروش',
                'قابل معاوضه',
                'وام دار',
                'مشارکت در ساخت',
                'کلنگی',
            ]
        ],
        'document_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'شش دانگ',
                'سرقفلی',
                'مشاع',
                'اوقافی',
                'مسکن مهر',
                'وکالتی',
                'قولنامه ای',
                'بنیادی',
                'زمین شهری',
                'شورایی',
                'در دست اقدام',
            ]
        ],
        'structure_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'فلزی',
                'بتنی',
                'بتنی – فلزی',
                'غیره',
            ]
        ],
        'facilities' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'پارکینگ',
                'انباری',
                'آسانسور',
                'سالن پرده خور',
                'استخر',
                'سونا',
                'جکوزی',
                'پرده',
                'کاغذ دیواری',
                'کف سرامیک',
                'کف پارکت',
                'کف لمینت',
                'کف سنگ',
                'کف موزاییک',
                'کف موکت',
                'درب ضد سرقت',
                'درب ضد حریق',
                'کمد دیواری',
                'لابی',
                'نگهبانی',
                'سرایداری',
                'لابی من',
                'سالن اجتماعات',
                'سالن ورزشی',
                'پنجره دوجداره',
                'پاسیو',
                'باربکیو',
                'بالکن (فضای آزاد سقف دار)',
                'تراس (فضای آزاد بدون سقف)',
                'آیفون تصویری',
                'شوتینگ زباله',
                'جاروبرقی مرکزی',
                'آنتن مرکزی',
                'آسانسور باربری',
                'آسانسور خودروبر',
                'روف گاردن',
                'درب ریموت دار',
                'آلاچیق',
                'دوربین مدار بسته',
            ]
        ],
        'heating_cooling' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'بخاری',
                'رادیات',
                'پکیج',
                'فن کوئل',
                'چیلر',
                'مینی چیلر',
                'کولر گازی',
                'داکت اسپیلت',
                'کولر آبی',
                'موتورخانه مرکزی',
                'شومینه',
                'گرمایش از کف',
                'هواساز',
                'VRF',
                'GHP',
                'آب گرمکن ایستاده',
                'آب گرمکن',
            ]
        ],
        'usage_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'مسکونی',
                'اداری',
                'تجاری',
                'مسکونی با موقعیت اداری',
                'مسکونی به همراه تجاری',
                'گردشگری',
                'باغ ویلا',
                'ویلا جنگلی',
                'ویلا ساحلی',
            ]
        ],
        'geography' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'شمالی',
                'جنوبی',
                'شرقی',
                'غربی',
                'دوبر',
                'سه بر',
                'چهاربر',
                'دوکله',
            ]
        ],
        'floor_start' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'زیرزمین',
                'همکف',
                'پیلوت بدون سوئیت',
                'پیلوت با سوئیت',
            ]
        ],
        'floor_count' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12',
                '13',
                '14',
                '15',
                '16',
                '17',
                '18',
                '19',
                '20',
                '21',
                '22',
                '23',
                '24',
                '25',
                '26',
                '27',
                '28',
                '29',
                '30',
                'بیشتر از 30',
            ]
        ],
        'room_count' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'بدون اتاق',
                '1',
                '2',
                '3',
                '4',
                'بیشتر از 4',
            ]
        ],
        'built_year' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'کلید نخورده',
                '1400',
                '1399',
                '1398',
                '1397',
                '1396',
                '1395',
                '1394',
                '1393',
                '1392',
                '1391',
                '1390',
                '1389',
                '1388',
                '1387',
                '1386',
                '1385',
                '1384',
                '1383',
                '1382',
                '1381',
                '1380',
                '1379',
                '1378',
                '1377',
                '1376',
                '1375',
                '1374',
                '1373',
                '1372',
                '1371',
                '1370',
                '1369',
                '1368',
                '1367',
                '1366',
                '1365',
                '1364',
                '1363',
                '1362',
                '1361',
                '1360',
                'قبل از 1360',
            ]
        ],
        'residence_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'سکونت مالک',
                'سکونت مستاجر',
                'تخلیه',
            ]
        ],
    ];
    $arr[3] = [
        'conditions' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'ندارد',
                'پیش فروش',
                'قابل معاوضه',
                'وام دار',
                'مجتمع تجاری',
                'غرفه',
            ]
        ],
        'room_count' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'بدون اتاق',
                '1',
                '2',
                '3',
                '4',
                'بیشتر از 4',
            ]
        ],
        'floor_count' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12',
                '13',
                '14',
                '15',
                '16',
                '17',
                '18',
                '19',
                '20',
                '21',
                '22',
                '23',
                '24',
                '25',
                '26',
                '27',
                '28',
                '29',
                '30',
                'بیشتر از 30',
            ]
        ],
        'floor_type' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'همکف',
                'دارای زیرزمین',
                'دارای بالکن',
            ]
        ],
        'document_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'شش دانگ',
                'سرقفلی',
                'مشاع',
                'اوقافی',
                'وکالتی',
                'قولنامه ای',
                'بنیادی',
                'در دست اقدام',
            ]
        ],
        'position_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'بر خیابان اصلی',
                'داخل کوچه',
                'کنار جاده',
                'دور میدان',
                'داخل بازار',
                'داخل مجتمع تجاری',
                'داخل شهرک صنعتی',
                'سایر',
            ]
        ],
        'geography' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'یک بر',
                'دو بر',
                'سه بر',
                'چهار بر',
                'دوکله',
            ]
        ],
        'heating_cooling' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'بخاری',
                'رادیات',
                'پکیج',
                'فن کوئل',
                'چیلر',
                'مینی چیلر',
                'کولر گازی',
                'داکت اسپیلت',
                'کولر آبی',
                'موتورخانه مرکزی',
                'گرمایش از کف',
                'هواساز',
                'VRF',
                'GHP',
                'آب گرمکن ایستاده',
                'آب گرمکن',
            ]
        ],
        'facilities' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'پارکینگ',
                'انباری',
                'آسانسور',
                'بالابر',
                'کاغذ دیواری',
                'کف سرامیک',
                'کف پارکت',
                'کف لمینت',
                'کف سنگ',
                'کف موزاییک',
                'لابی',
                'نگهبانی',
                'سرایداری',
                'لابی من',
                'سالن اجتماعات',
                'شیشه سکوریت',
                'شوتینگ زباله',
                'جاروبرقی مرکزی',
                'آنتن مرکزی',
                'آسانسور باربری',
                'آسانسور خودروبر',
                'روف گاردن',
                'کرکره برقی',
                'درب اتوماتیک',
                'دوربین مدار بسته',
                'دزدگیر',
            ]
        ],
        'residence_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'سکونت مالک',
                'سکونت مستاجر',
                'تخلیه',
            ]
        ],
    ];
    $arr[4] = [
        'conditions' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'ندارد',
                'قابل معاوضه',
                'تمایل به مشارکت در ساخت',
            ]
        ],
        'document_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'شش دانگ',
                'مشاع',
                'اوقافی',
                'وکالتی',
                'قولنامه ای',
                'بنیادی',
                'زمین شهری',
                'شورایی',
                'قراداد واگذاری',
                'در دست اقدام',
            ]
        ],
        'usage_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'مسکونی',
                'اداری',
                'تجاری',
                'گردشگری',
                'کشاورزی',
                'باغ',
                'دامپروری',
                'صنعتی',
                'بایر',
            ]
        ],
        'build_license' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'دارد',
                'ندارد',
            ]
        ],
        'geography' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'شمالی',
                'جنوبی',
                'شرقی',
                'غربی',
                'دوبر',
                'سه بر',
                'چهاربر',
                'دوکله',
            ]
        ],
        'position_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'بر خیابان اصلی',
                'داخل کوچه',
                'کنار جاده',
                'دور میدان',
                'داخل بازار',
                'ساحلی',
                'جنگلی',
                'داخل محدوده شهری',
                'خارج محدوده شهری',
                'داخل شهرک صنعتی',
            ]
        ],
    ];
    $arr[5] = [
    ];
    if (!is_null($estateType) && !is_null($field) && !is_null($key)) {
        return $arr[$estateType][$field]['values'][$key] ?? '';
    }
    return $arr[$estateType];
}
// فیلدهای اجاره ملک براساس نوع و جنس ملک
function getRentFields($estateType)
{
    $arr[1] = [
        'rent_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => ['یک ساله', 'کوتاه مدت']
        ],
        'convertible' => [
            'multiple' => '',
            'required' => 'required',
            'values' => ['دارد', 'ندارد']
        ],
        'usage_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'مسکونی',
                'اداری',
                'تجاری',
                'مسکونی با موقعیت اداری - تجاری',
                'گردشگری',
            ]
        ],
        'conditions' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'ندارد',
                'مناسب مجرد',
                'مخصوص سکونت خانواده',
                'مناسب مطب و دفتر کار',
                'اتاق اداری',
                'کلید نخورده',
            ]
        ],
        'room_count' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'بدون اتاق',
                '1',
                '2',
                '3',
                '4',
                'بیشتر از 4',
            ]
        ],
        'unit_in_floor' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12',
                '13',
                '14',
                '15',
                '16',
                '17',
                '18',
                '19',
                '20',
                '21',
                '22',
                '23',
                '24',
                '25',
                '26',
                '27',
                '28',
                '29',
                '30',
                'بیشتر از 30',
            ]
        ],
        'floor' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                '-1' => 'زیرهمکف',
                '0' => 'همکف',
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '13' => '13',
                '14' => '14',
                '15' => '15',
                '16' => '16',
                '17' => '17',
                '18' => '18',
                '19' => '19',
                '20' => '20',
                '21' => '21',
                '22' => '22',
                '23' => '23',
                '24' => '24',
                '25' => '25',
                '26' => '26',
                '27' => '27',
                '28' => '28',
                '29' => '29',
                '30' => '30',
                '31' => 'بیشتر از 30',
                '32' => 'پنت هاوس',
            ]
        ],
        'geography' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'شمالی',
                'جنوبی',
                'شرقی',
                'غربی',
                'دوبر',
                'سه بر',
                'چهاربر',
                'دوکله',
            ]
        ],
        'heating_cooling' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'بخاری',
                'رادیات',
                'پکیج',
                'فن کوئل',
                'چیلر',
                'مینی چیلر',
                'کولر گازی',
                'داکت اسپیلت',
                'کولر آبی',
                'موتورخانه مرکزی',
                'شومینه',
                'گرمایش از کف',
                'هواساز',
                'VRF',
                'GHP',
                'آب گرمکن ایستاده',
                'آب گرمکن',
            ]
        ],
        'facilities' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'پارکینگ',
                'انباری',
                'آسانسور'
            ]
        ],
        'residence_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'سکونت مالک',
                'سکونت مستاجر',
                'تخلیه',
            ]
        ],
    ];
    $arr[2] = [
        'rent_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => ['یک ساله', 'کوتاه مدت']
        ],
        'convertible' => [
            'multiple' => '',
            'required' => 'required',
            'values' => ['دارد', 'ندارد']
        ],
        'room_count' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'بدون اتاق',
                '1',
                '2',
                '3',
                '4',
                'بیشتر از 4',
            ]
        ],
        'floor_count' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12',
                '13',
                '14',
                '15',
                '16',
                '17',
                '18',
                '19',
                '20',
                '21',
                '22',
                '23',
                '24',
                '25',
                '26',
                '27',
                '28',
                '29',
                '30',
                'بیشتر از 30',
            ]
        ],
        'floor_start' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'زیرزمین',
                'همکف',
                'پیلوت بدون سوئیت',
                'پیلوت با سوئیت',
            ]
        ],
        'usage_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'مسکونی',
                'اداری',
                'تجاری',
                'مسکونی با موقعیت اداری',
                'مسکونی به همراه تجاری',
                'گردشگری ( اقامتی)',
                'باغ ویلا',
                'ویلا جنگلی',
                'ویلا ساحلی',
            ]
        ],
        'conditions' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'ندارد',
                'مناسب مجرد',
                'اجاره کوتاه مدت',
                'مخصوص سکونت خانواده',
                'مناسب مطب و دفتر کار',
                'دربست',
                'درب مجزا',
                'کلید نخورده',
            ]
        ],
        'geography' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'شمالی',
                'جنوبی',
                'شرقی',
                'غربی',
                'دوبر',
                'سه بر',
                'چهاربر',
                'دوکله',
            ]
        ],
        'heating_cooling' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'بخاری',
                'رادیات',
                'پکیج',
                'فن کوئل',
                'چیلر',
                'مینی چیلر',
                'کولر گازی',
                'داکت اسپیلت',
                'کولر آبی',
                'موتورخانه مرکزی',
                'شومینه',
                'گرمایش از کف',
                'هواساز',
                'VRF',
                'GHP',
                'آب گرمکن ایستاده',
                'آب گرمکن',
            ]
        ],
        'facilities' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'پارکینگ',
                'انباری',
                'آسانسور'
            ]
        ],
        'residence_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'سکونت مالک',
                'سکونت مستاجر',
                'تخلیه',
            ]
        ],
    ];
    $arr[3] = [
        'conditions' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'ندارد',
                'مجتمع تجاری',
                'غرفه',
            ]
        ],
        'room_count' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'بدون اتاق',
                '1',
                '2',
                '3',
                '4',
                'بیشتر از 4',
            ]
        ],
        'floor_count' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12',
                '13',
                '14',
                '15',
                '16',
                '17',
                '18',
                '19',
                '20',
                '21',
                '22',
                '23',
                '24',
                '25',
                '26',
                '27',
                '28',
                '29',
                '30',
                'بیشتر از 30',
            ]
        ],
        'floor_type' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'همکف',
                'دارای زیرزمین',
                'دارای بالکن',
            ]
        ],
        'geography' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'دو بر',
                'سه بر',
                'دوکله',
            ]
        ],
        'position_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'بر خیابان اصلی',
                'داخل کوچه',
                'کنار جاده',
                'دور میدان',
                'داخل بازار',
                'داخل مجتمع تجاری',
                'داخل شهرک صنعتی',
                'سایر',
            ]
        ],
        'heating_cooling' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'بخاری',
                'رادیات',
                'پکیج',
                'فن کوئل',
                'چیلر',
                'مینی چیلر',
                'کولر گازی',
                'داکت اسپیلت',
                'کولر آبی',
                'موتورخانه مرکزی',
                'شومینه',
                'گرمایش از کف',
                'هواساز',
                'VRF',
                'GHP',
                'آب گرمکن ایستاده',
                'آب گرمکن',
            ]
        ],
        'facilities' => [
            'multiple' => 'multiple',
            'required' => 'required',
            'values' => [
                'پارکینگ',
                'انباری',
                'آسانسور',
            ]
        ],
        'residence_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'سکونت مالک',
                'سکونت مستاجر',
                'تخلیه',
            ]
        ],
    ];
    $arr[4] = [
        'document_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'شش دانگ',
                'مشاع',
                'اوقافی',
                'وکالتی',
                'قولنامه ای',
                'بنیادی',
                'زمین شهری',
                'شورایی',
                'قراداد واگذاری',
                'در دست اقدام',
            ]
        ],
        'usage_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'مسکونی',
                'اداری',
                'تجاری',
                'گردشگری',
                'کشاورزی',
                'باغ',
                'دامپروری',
                'صنعتی',
                'بدون توافق',
            ]
        ],
        'build_license' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'دارد',
                'ندارد',
            ]
        ],
        'geography' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'شمالی',
                'جنوبی',
                'شرقی',
                'غربی',
                'دوبر',
                'سه بر',
                'چهاربر',
                'دوکله',
            ]
        ],
        'position_type' => [
            'multiple' => '',
            'required' => 'required',
            'values' => [
                'بر خیابان اصلی',
                'داخل کوچه',
                'کنار جاده',
                'دور میدان',
                'داخل بازار',
                'ساحلی',
                'جنگلی',
                'داخل محدوده شهری',
                'خارج محدوده شهری',
                'داخل شهرک صنعتی',
            ]
        ]
    ];
    return $arr[$estateType];
}
function getModels()
{
    $path = app_path() . "/Model";
    $out = [];
    $results = scandir($path);
    foreach ($results as $result) {
        if ($result === '.' or $result === '..') continue;
        $filename = $path . '/' . $result;
        if (is_dir($filename)) {
            $out = array_merge($out, getModels($filename));
        } else {
            $out[] = substr($filename, 0, -4);
        }
    }
    return $out;
}
function setNotificationLog($userid, $type, $description)
{
    $input["userId"]=$userid;
    $input["type"]=$type;
    $input["description"]=$description;
    $model=NotificationLog::create($input);
    return $model;
}
function setActivityLog($performedOn, $causedBy, $logName, $log, $withProperties = null)
{
    activity()
        ->performedOn($performedOn)
        ->causedBy($causedBy)
        ->withProperties($withProperties ?? [])
        ->useLog($logName)
        ->log($log);
    return true;
}
function ActivityLogModelTypes($key = null)
{
    $arr = [
        "App\Model\Province" => "استان",
        "App\Model\City" => "شهر",
        "App\Model\District" => "محله",
        "App\Model\Customer" => "مشتری",
        "App\Model\CustomerDistrict" => "محل های درخواست مشتری",
        "App\Model\CustomerFavorite" => "مشتری نشان شده",
        "App\Model\Estate" => "ملک",
        "App\Model\EstateFavorite" => "ملک نشان شده",
        "App\Model\Feature" => "امکانات ملک",
        "App\Model\FeatureValue" => "مقادیر امکانات ملک",
        "App\Model\User" => "کاربر",
        "App\Model\UserActivityDistrict" => "محل های فعالیت کاربر",
        "App\Model\UserCommission" => "کمیسیون های کاربر",
        "App\Model\UserLogin" => "ورودهای کاربر",
        "App\Model\UserMedal" => "مدالهای کاربر",
        "App\Model\Notification" => "اعلان",
        "App\Model\Comment" => "کامنت",
        "App\Model\Medal" => "مدال",
        "App\Model\Ticket" => "تیکت پشتیبانی",
        "App\Model\SearchKeyword" => "جستجوی کاربر",
        "App\Model\Category" => "دسته بندی مطالب",
        "App\Model\Post" => "مطالب",
        "App\Model\Slide" => "اسلایدشو",
        "App\Model\Tag" => "تگ",
        "App\Model\Setting" => "تنظیمات",
        "App\Model\Ads" => "تبلیغات",
        "App\Model\UserSearch" => "جستجوی ذخیره شده",
        "App\Model\UserNote" => "یادداشت کاربر",
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
function ActivityLogEvents($key = null, $eventKey = null)
{
    $arr = [
        "created" => "ایجاد",
        "updated" => "ویرایش",
        "deleted" => "حذف",
        "assign" => "اختصاص",
        "archive" => "آرشیو",
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    $cssClasses = [
        "created" => "bg-olive",
        "updated" => "bg-yellow-active",
        "deleted" => "bg-red",
        "assign" => "bg-light-blue",
        "archive" => "bg-light-green",
    ];
    if (!empty($eventKey)) {
        return $cssClasses[$eventKey];
    }
    return $arr;
}
/**
 * @param $userId
 * @param $expireTime
 * @param $notifTitle
 * @param $notifBody
 * @param $notifUrl
 */
function sendNotification($userId,$expireTime,$notifTitle,$notifBody=null,$notifUrl=null)
{
    Notification::insert([
        'city_id' => null,
        'user_id' => $userId,
        'role_id' => null,
        'title' => $notifTitle,
        'body' => $notifBody,
        'systemic' => 1,
        'validity' => $expireTime,
        'url' => $notifUrl,
        'send_to_all' => 0,
        'send_at' => Carbon::now(),
        'expired_at' => Carbon::now()->addHours($expireTime),
    ]);
}
function getCity($cityid){
    $city = City::find($cityid);
    return ($city != null)?$city->name:'';
}
function getDistrict($districtid){
    $district = District::find($districtid);
    return ($district != null)?$district->name:'';
}
function getNotifications($user, $getNotifs = false)
{
    return;
    $dt = Carbon::now();
    $newestIds = $visitedIds = [];
    // get valid notifications
    $notifs = Notification::where(function ($q) use ($user, $dt) {
        $q->orWhere('send_to_all', 1)
            ->orWhere('user_id', $user->id)
            ->orWhere('city_id', $user->city_id)
            ->orWhereIn('role_id', [$user->role_ids]);
    })->whereDate('expired_at', '>=', $dt);
    if ($getNotifs) {
        // get model list
        $notifs = $notifs->paginate(15);
        return $notifs;
    }
    $notifs = $notifs->get();
    $notifs->map(function ($item) {
        $item->created_at_fa = toPersianDate($item->created_at, false, true, 'Y/m/d');
        $item->url = $item->url ? url('/' . $item->url) : '';
        $item->setVisible(['id', 'image', 'title', 'body', 'url', 'created_at', 'created_at_fa']);
    });
    // get ids
    $notificationIds = $notifs->pluck('id')->toArray();
    if ($notificationIds) {
        // retrieve cookie ids (visited notifications)
        $visitedIds = $_COOKIE[$user->id . '_notifs'] ?? null;//Cookie::get($user->id.'_notifs');
        if ($visitedIds != null) {
            $visitedIds = !empty($visitedIds) ? json_decode($visitedIds) : [];
            $notifs = $notifs->filter(function ($item) use ($visitedIds) {
                return !in_array($item->id, $visitedIds);
            });
            // get new notifications
            /*$newestIds = array_diff($notificationIds,$visitedIds);
            if(!empty($newestIds)){
                // filter the newest notifications
                $notifs = $notifs->filter(function ($item) use ($newestIds) {
                    return in_array($item->id, $newestIds);
                });
            }*/
        }
        return [
            'notifications_visit_ids' => $visitedIds,
            'notifications_new_ids' => $newestIds,
            'notifs' => $notifs
        ];
        //setcookie($ownerUser->id.'_notifs',json_encode($notifs->pluck('id')),time() + (365 * 86400));
    }
}
function sortable($field)
{
    $str = '
<a href="' . url()->current() . '?' . http_build_query(array_merge(request()->all(), ['sort' => $field])) . '<i class="fa fa-caret-down</i></a>
<a href="' . url()->current() . '?' . http_build_query(array_merge(request()->all(), ['sort' => '-' . $field])) . '<i class="fa fa-caret-up</i></a>
';
    return $str;
}
function getFilters($modelFields, $inputs, $inputsCustom = null)
{
    $filters = [];
    $fields = array_merge(['id', 'created_at'], $modelFields);
    foreach ($fields as $field) {
        $filters["filter[$field]"] = $inputs[$field] ?? '';
    }
    if (!empty($inputsCustom)) {
        foreach ($inputsCustom as $field) {
            $filters["filter[$field]"] = $inputsCustom[$field] ?? '';
        }
    }
    return $filters;
}
function devices($key = null)
{
    $arr = [
        'desktop' => 'دسکتاپ',
        'tablet' => 'تبلت',
        'mobile' => 'موبایل',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
// places of ads
function adsPlaces($key = null)
{
    $arr = [
        1 => 'ستون بالا',
        2 => 'ستون راست',
        3 => 'ستون پایین',
        4 => 'ستون چپ',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
// built year
function builtYears($key = null)
{
    if (empty($key)) {
        return null;
    }
    $arr = [
        1 => 'کلید نخورده',
        2 => '1400',
        3 => '1399',
        4 => '1398',
        5 => '1397',
        6 => '1396',
        7 => '1395',
        8 => '1394',
        9 => '1393',
        10 => '1392',
        11 => '1391',
        12 => '1390',
        13 => '1389',
        14 => '1388',
        15 => '1387',
        16 => '1386',
        17 => '1385',
        18 => '1384',
        19 => '1383',
        20 => '1382',
        21 => '1381',
        22 => '1380',
        23 => '1379',
        24 => '1378',
        25 => '1377',
        26 => '1376',
        27 => '1375',
        28 => '1374',
        29 => '1373',
        30 => '1372',
        31 => '1371',
        32 => '1370',
        33 => '1369',
        34 => '1368',
        35 => '1367',
        36 => '1366',
        37 => '1365',
        38 => '1364',
        39 => '1363',
        40 => '1362',
        41 => '1361',
        42 => '1360',
        43 => 'قبل از 1360',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
function reportReasons($key = null)
{
    $arr = [
        1 => 'محتوای آگهی ملک',
        2 => 'عکس آگهی ملک',
        3 => 'اطلاعات تماس',
        4 => 'آدرس و نقشه',
        5 => 'ناموجود بودن ملک',
        6 => 'مشکلات با صاحب ملک',
        7 => 'کلاهبرداری، نقض قانون یا وقوع جرم',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
function chatNewCount($id){
    $user = Auth::user();
    if($user->isAdmin())
    {
        $count = ChatMessage::where('is_seen',0)->count() ?? 0;
    }
    else
    {
        $count  = ChatMessage::where('is_seen',0)->whereIn('id', function($query){
            $user = Auth::user();
            $query->select('chat_id')
            ->from(with(new Chat)->getTable())
            ->Where('sender_id', '!=', $user->id)->Where('receiver_id', $user->id);
        })->count() ?? 0;
        //dd(getQuery($count));
    }
    return $count;
    //return Chat::Where('sender_id', '!=', $id)->Where('receiver_id', $id)->count() ?? 0;
}
function estateReportReasons($key = null)
{
    $arr = [
        1 => [
            'group'=>'محتوای آگهی ملک',
            'subgroup'=>[
                1=>'آگهی تکراری است',
                2=>'دسته‌بندی اشتباه است',
                3=>'اطلاعات آگهی اشتباه یا متناقض است',
                4=>'اطلاعات آگهی ناقص است',
                5=>'شمارهٔ تماس در توضیحات نوشته شده است',
                6=>'در عنوان یا متن آگهی اشتباه نگارشی وجود دارد',
                7=>'سایر موارد',
            ]
        ],
        2 => [
            'group'=>'عکس آگهی ملک',
            'subgroup'=>[
                1=>'از عکس آگهی دیگری استفاده شده است',
                2=>'از عکس کسب‌وکار دیگری استفاده شده است',
                3=>'صورت یا اطلاعات شناسایی در عکس است',
                4=>'عکس‌ بی‌کیفیت یا ناکافی است',
                5=>'عکس با اطلاعات آگهی تناقض دارد',
                6=>'محتوای عکس نامناسب است',
                7=>'سایر موارد',
            ]
        ],
        3 => [
            'group'=>'اطلاعات تماس',
            'subgroup'=>[
                1=>'شماره خاموش است یا در دسترس نیست',
                2=>'به تماس پاسخ داده نمی‌شود',
                3=>'به چت پاسخ داده نمی‌شود',
                4=>'شماره‌ٔ تماس متعلق به شخص دیگری است',
                5=>'تماس به شمارهٔ دیگری منتقل می‌شود',
                6=>'مشکلی در صحبت از طریق پیام‌رسان‌ها دارم',
                7=>'مشکلی در لینک یا وب‌سایت آگهی است',
                8=>'سایر موارد',
            ]
        ],
        4 => [
            'group'=>'قیمت',
            'subgroup'=>[
                1=>'قیمت بیشتر از ارزش کالا یا خدمات است',
                2=>'قیمت کمتر از ارزش کالا یا خدمات است',
                3=>'قیمت اشتباه نوشته شده است',
                4=>'تفاوت زیادی با قیمت آگهی‌های مشابه دارد',
                5=>'تناقض در قیمت آگهی با توضیحات وجود دارد',
                6=>'سایر موارد',
            ]
        ],
        5 => [
            'group'=>'آدرس و نقشه',
            'subgroup'=>[
                1=>'آدرس نوشته‌شده اشتباه است یا وجود ندارد',
                2=>'آدرس واقعی با آدرس نقشه تفاوت دارد',
                3=>'آدرس مشخص نشده است',
                4=>'آگهی متعلق به شهر دیگری است',
                5=>'سایر موارد',
            ]
        ],
        6 => [
            'group'=>'ناموجود بودن ملک',
            'subgroup'=>[
                1=>'ملک فروخته شده است',
                2=>'صاحب آگهی از فروش منصرف شده است',
                3=>'خدمات نوشته‌شده وجود ندارد',
                4=>'سایر موارد',
            ]
        ],
        7 => [
            'group'=>'مشکلات با صاحب ملک',
            'subgroup'=>[
                1=>'صاحب آگهی سر قرار حاضر نشده است',
                2=>'در تماس یا مراجعه رفتار بی‌ادبانه داشت',
                3=>'درخواست غیرقانونی یا غیراخلاقی دارد',
                4=>'درخواست اطلاعات خصوصی دارد',
                5=>'از خدمات ارائه‌شده راضی نبودم',
                6=>'هویت صاحب آگهی جعلی است',
                7=>'سایر موارد',
            ]
        ],
        8 => [
            'group'=>'کلاهبرداری، نقض قانون یا وقوع جرم',
            'subgroup'=>[
                1=>'صاحب آگهی درخواست بیعانه دارد',
                2=>'صاحب آگهی طبق قرار عمل نکرده است',
                3=>'محتوای آگهی خلاف قانون است',
                4=>'محتوای آگهی غیراخلاقی است',
                5=>'سایر موارد',
            ]
        ],
        9 => [
            'group'=>'سایر'

        ],
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
// دریافت اطلاعات یک صفحه از قالب سایت به همراه تبلیغات همان صفحه براساس شناسه صفحه
function getTemplatePageWithAds($pageId)
{
    $selectedCity = $_COOKIE['city'] ?? null;
    $city_id = $selectedCity ? (City::where('name_en', $selectedCity)->first()->id ?? null) : null;
    // get template page and ads
    $templatePage = TemplatePage::with([
        'ads' => function ($q)use($city_id) {
            $q->where('active', 1)->where(function ($query)use($city_id){
                $query->where('city_id',$city_id)->orWhere('city_id',NULL);
            });
        }
    ])->find($pageId);
    if (!$templatePage) return null;
    return $templatePage;
}

function ticketStatuses($key = null)
{
    $arr = [
        1 => 'در انتظار پاسخ',
        2 => 'پاسخ داده شده',
        3 => 'پاسخ مشتری',
        4 => 'بسته شده',
        5 => 'آرشیو شده',
    ];
    if (!empty($key)) {
        return $arr[$key];
    }
    return $arr;
}
/*/* */
function l($word)
{
    $message = trim((string)$word);
    if ($message === '') {
        return '';
    }

    $locale = session('locale', app()->getLocale());
    $locale = in_array($locale, ['fa', 'ar', 'en'], true) ? $locale : config('app.fallback_locale', 'en');
    $keyword = str_replace(' ', '-', $message);

    if ($locale === 'en') {
        $path = resource_path('lang/en/message.php');
        if (file_exists($path)) {
            $_ = include $path;
            if (is_array($_)) {
                if (isset($_[$keyword]) && $_[$keyword] !== '') {
                    return $_[$keyword];
                }
                if (isset($_[$message]) && $_[$message] !== '') {
                    return $_[$message];
                }
            }
        }
        return $message;
    }

    if ($locale === 'fa') {
        return $message;
    }

    $translationFiles = [
        resource_path('lang/' . $locale . '/messages.php'),
        resource_path('lang/' . $locale . '/message.php'),
        resource_path('lang/' . $locale . '/labels.php'),
    ];

    foreach ($translationFiles as $path) {
        if (file_exists($path)) {
            $translations = include $path;
            if (is_array($translations)) {
                if (isset($translations[$keyword]) && $translations[$keyword] !== '') {
                    $translated = $translations[$keyword];
                    if ($locale !== 'ar' || preg_match('/[\x{0600}-\x{06FF}]/u', $translated)) {
                        return $translated;
                    }
                }
                if (isset($translations[$message]) && $translations[$message] !== '') {
                    $translated = $translations[$message];
                    if ($locale !== 'ar' || preg_match('/[\x{0600}-\x{06FF}]/u', $translated)) {
                        return $translated;
                    }
                }
            }
        }
    }

    if ($locale === 'ar') {
        return app(\App\Services\PersianToArabicService::class)->translate($message);
    }

    return $message;
}
function newRoles()
{
    $roles = [
        'یوزر عادی',
        'کارشناس',
        'مدیر سایت',
        'مدیر مالی سیستم',
        'مدیر شعبه (همکار)',
        'اپراتور پشتیبان',
        'سوپر ادمین'
    ];
}
function updateExpert($estate)
{
    $district_id = $estate->district_id;
    $user = User::where('role_ids', "%9%")->with([
        'roles',
        'estates' => function ($q) {
            $q->where('visibility',1)->orderBy('id', 'desc');
        }])
        ->where('has_role', 1)
        ->where('status', '1')
        ->where('active', 1)
        ->where('city_id', $estate->city_id)
        //->where('district_id', $estate->district_id)
        ->whereIn('id', function($query) use ($district_id){
			$query->select('user_id')
			->from(with(new UserActivityDistrict)->getTable())
			->where('district_id', $district_id);

			})
        ->whereIn('activity_type' , array($estate->type , 3));

        $user =  $user->inRandomOrder();
        $user =  $user->where('activity_estate_type','like', "%".$estate->estate_type."%");

        if((ss('SITE_ID') == 5 || ss('SITE_ID') == 8) && $estate->type == 1 && $estate->price>0){

            $user = $user->where(function ($query) use ($estate) {
                $query->where(function($query2) use ($estate)
                {
                    $query2->where('operand', 1) ->where('price','<=', $estate->price);
                })
                ->orWhere(function($query2) use ($estate)
                {
                    $query2->where('operand', 2)->where('price','>', $estate->price);
                }
            )
            ;});
        }
       // dd(getQuery($user));
    $user1 = $user->get();
    $district_id = $estate->district_id;

    if($user1 == null || count($user1) == 0)
    {
        $user = User::whereHas('roles', function ($q) {
            $q->where('role_id', 9);
        })->with(['roles'])
            ->where('has_role', 1)
            ->where('status', '1')
            ->where('active', 1)
            ->where('city_id', $estate->city_id)
			->whereIn('id', function($query) use ($district_id){
			$query->select('user_id')
			->from(with(new UserActivityDistrict)->getTable())
			->where('district_id', $district_id);

			})
            ->whereIn('activity_type' , array($estate->type , 3));
            $user =  $user->where('activity_estate_type','like', "%".$estate->estate_type."%");
            $user =  $user->inRandomOrder();
        //dd(getQuery($user));
        $user1 = $user->get();
    }
    if($user1 == null || count($user1) == 0)
    {
        $user = User::whereHas('roles', function ($q) {
            $q->where('role_id', 9);
        })->with(['roles'])
            ->where('has_role', 1)
            ->where('status', '1')
            ->where('active', 1)
            ->where('city_id', $estate->city_id)
			->whereIn('id', function($query) use ($district_id){
			$query->select('user_id')
			->from(with(new UserActivityDistrict)->getTable())
			->where('district_id', $district_id);

			})
            ->whereIn('activity_type' , array($estate->type , 3));
            $user =  $user->inRandomOrder();
        //dd(getQuery($user));
        $user1 = $user->get();
    }
    //dd($user1);
    if($user1 != null)
    {
        $listuser = [];
        foreach($user1 as $user){
            $listuser[] = $user->id;
        }
        if(count($listuser)>1)
        {
            $request = Request();
            //$request = new object();
            $jalali = gregorian_to_jalali(date('Y'),date('m'),date('d'),'-');
            $lalalilist = explode('-' , $jalali);
            $profileController = new App\Http\Controllers\Frontend\ProfileController();
            $request->type = 'total';
            $request->datefrom = $lalalilist[0] . '/' . $lalalilist[1] . '/1';
            $request->dateto = $lalalilist[0] . '/' . $lalalilist[1] . '/' . $lalalilist[2];
            $reportShow = $profileController->reportShow($request , false);
            $countuser  = count($user1);

            foreach($reportShow['searchRnk'] as $key=>$val)
            {
                if(in_array($key , $listuser))
                {
                    for($j=1 ; $j<=$countuser ; $j++)
                    {
                        $_lu[] = $key;
                    }
                    $countuser--;
                }
            }

            $rand = rand(0 , count($_lu) - 1);
            $u = $_lu[$rand];
        }
        elseif(count($listuser)==1)
        {
            $u = $listuser[0];
        }
        if(count($listuser)>0)
        {
            if(ss('SITE_ID') == 5 || ss('SITE_ID') == 8)
            {
                Estate::where('id', $estate->id)->update(['expert_id' =>  $u, 'percent_expert' => 0 , 'expiretime_expert' => date('Y-m-d H:i:s')]);
            }
            else
            {
                Estate::where('id', $estate->id)->update(['expert_id' =>  $u, 'percent_expert' => 0 , 'expiretime_expert' => date('Y-m-d H:i:s',strtotime("+1 days"))]);
            }

            return $u;
        }
    }
    return 0;

}
function resize_image($file, $w, $h, $crop=FALSE) {
    //list($width, $height) = getimagesize($file);
    $src = imagecreatefromstring($file);
    if (!$src) return false;
    $width = imagesx($src);
    $height = imagesy($src);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
          $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
          $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
          $newwidth = $h*$r;
          $newheight = $h;
        } else {
          $newheight = $w/$r;
          $newwidth = $w;
        }
    }
    //$src = imagecreatefrompng($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    // Buffering
    ob_start();
    imagepng($dst);
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
}
function relCustomer($estate_id)
{
    return;
    RelationEstateCustomer::where('estate_id' , $estate_id)->whereNull('creator_id')->whereNull('send_at')->delete();
    $estate = Estate::where('id' , $estate_id)->first();
    if(!$estate){
        return;
    }
    $listRelationEstateCustomer = RelationEstateCustomer::where('estate_id' , $estate_id)->get();
    $customerslist = [];
    foreach($listRelationEstateCustomer as $relationEstateCustomer)
    {
        $customerslist[] = $relationEstateCustomer->customer_id;
    }
    $customer = Customer::where('request_type' , $estate->type)->where('estate_type' , $estate->estate_type)->where('city_id' , $estate->city_id);
    if(is_array($customerslist) && count($customerslist)>0){
        $customer = $customer->whereNotIn('id' , $customerslist);
    }
    if($estate->district_id>0)
    {
        $customerids = [];
        $customerDistricts = DB::select("select * from `customer_districts` inner join `customers` on customers.id = customer_districts.customer_id where `status` = '1' and `deleted_at` is null and customer_districts.district_id = '".$estate->district_id."'");
        foreach($customerDistricts as $customerDistrict)
        {
            $customerids[] = $customerDistrict->customer_id;
        }
        $customer = $customer->whereIn('id' , $customerids);
        // $customerDistricts = CustomerDistrict::where('district_id' , $estate->district_id)->get();
        // global $customerids;
        // $customerids = [];
        // if($customerDistricts){
        //     foreach($customerDistricts as $customerDistrict){
        //         $customerids[] = $customerDistrict->customer_id;
        //     }
        //     $customer = $customer->whereIn('id' , $customerids);
        // }
    }
    else
    {
        $customerDistricts = DB::select("select * from `customer_districts` inner join `customers` on customers.id = customer_districts.customer_id where `status` = '1' and `deleted_at` is null");
        $customerids = [];
        foreach($customerDistricts as $customerDistrict)
        {
            $customerids[] = $customerDistrict->customer_id;
        }
        $customer = $customer->whereNotIn('id' , $customerids);
        //$customerDistricts = CustomerDistrict::where('district_id' , $estate->district_id)->get();
    }
    if($estate->price > 0){
        $customer = $customer->where('price_max' , '>=' ,  (0.9)*$estate->price);
        $customer = $customer->where('price_min' , '<' ,  (1.1)*$estate->price);
    }

    $listCustomers = $customer->get();
    //dd(getQuery($customer));
    foreach($listCustomers as $customer){
        RelationEstateCustomer::create([
            'estate_id' => $estate_id,
            'customer_id' => $customer->id
        ]);
    }
}
function relEstate($customer_id)
{
    //return;
    $customerDistricts = CustomerDistrict::where('customer_id' , $customer_id)->get();
    $customer = Customer::where('id' , $customer_id)->first();
    if(!$customer){
        return;
    }
    if($customerDistricts){
        global $districts;
        $districts = [];
        foreach($customerDistricts as $customerDistrict){
            $districts[] = $customerDistrict->district_id;
        }
    }
    $userbongah = User::where('isbongah' , 1)->get();
    if($userbongah){
        global $bongahlist;
        $bongahlist = [];
        foreach($userbongah as $user){
            $bongahlist[] = $user->id;
        }
    }
    //RelationEstateCustomer::where('customer_id' , $customer_id)->whereNull('creator_id')->whereNull('send_at')->where('status',0)->delete();
    $listRelationEstateCustomer = RelationEstateCustomer::where('customer_id' , $customer_id)->get();
    $estatslist = [];
    foreach($listRelationEstateCustomer as $relationEstateCustomer)
    {
        $estatslist[] = $relationEstateCustomer->estate_id;
    }
    $estates = Estate::where('type' , $customer->request_type)
                    ->where('estate_type' , $customer->estate_type)
                    ->where('city_id' , $customer->city_id)
                    ->where('confirmation','verified')
                    ->where('visibility',1)
                    ->where('showdate', '>' ,  date("Y-m-d", strtotime("-4 months")));
    if(is_array($bongahlist) && count($bongahlist)>0)
    {
        $estates = $estates->where(function ($query) use ($bongahlist) {
            $query->orWhereNull('user_id')
                ->orWhereNotIn('user_id' , $bongahlist);
        });
        //$estates = $estates->whereNotIn('user_id' , $bongahlist);
    }
    /*if(is_array($estatslist) && count($estatslist)>0){
        $estates = $estates->whereNotIn('id' , $estatslist);
    }*/
    if(is_array($districts) && count($districts)>0){
        $estates = $estates->whereIn('district_id' , $districts);
    }
    if($customer->request_type == 1)
    {
        if($customer->price_max > 0){
            $estates = $estates->where('price' , '<=' ,  $customer->price_max);
        }
        if($customer->price_min > 0){
            $estates = $estates->where('price' , '>=' ,  $customer->price_min);
        }
    }
    if($customer->request_type == 2)
    {
        if($customer->rent_max > 0){
            $estates = $estates->where('rent' , '<=' ,  $customer->rent_max);
        }
        if($customer->rent_min > 0){
            $estates = $estates->where('rent' , '>=' ,  $customer->rent_min);
        }
        if($customer->mortgage_max > 0){
            $estates = $estates->where('mortgage' , '<=' ,  $customer->mortgage_max);
        }
        if($customer->mortgage_min > 0){
            $estates = $estates->where('mortgage' , '>=' ,  $customer->mortgage_min);
        }
    }
    if($customer->area_min > 0){
        $estates = $estates->where('area' , '>=' ,  $customer->area_min);
    }
    if($customer->estate_type == 1 && $customer->request_type == 1)
    {
        if(str_contains($customer->conditions , '"35"'))
        {
            //dd($customer->conditions);
            $estates->whereJsonContains('conditions', '[15]');
        }
    }
    if($customer->usage_type > 0 && $customer->usage_type != 107)
    {
        $estates = $estates->where('usage_type' ,   $customer->usage_type);
    }
    /*if($customer->min_street_width > 0){
        $estates = $estates->where('street_width' , '>=' ,  $customer->min_street_width);
    }
    if($customer->min_floor_area > 0){
        $estates = $estates->where('floor_area' , '>=' ,  $customer->min_floor_area);
    }

    if($customer->geography != null){
        $estates = $estates->where('geography' , $customer->geography);
    }
    if($customer->build_license != null ){
        $estates = $estates->where('build_license' , $customer->build_license);
    }
    if($customer->document_type > 0){
        $estates = $estates->where('document_type' , $customer->document_type);
    }
    if($customer->min_front_area > 0){
        $estates = $estates->where('front_area' , '>=' , $customer->min_front_area);
    }
    if($customer->max_room_count > 0){
        $estates = $estates->where('room_count' , '>=' , $customer->max_room_count);
    }
    if($customer->max_unit_in_floor > 0){
        $estates = $estates->where('unit_in_floor' , '<=' , $customer->max_unit_in_floor);
    }

    if($customer->max_building_age > 0){
        switch($customer->max_building_age)
        {
            case 1:
                $estates = $estates->where('built_year' ,'>=', date('Y')-622);
                break;
            case 2:
                $estates = $estates->where('built_year' ,'>=', date('Y')-623);
                break;
            case 3:
                $estates = $estates->where('built_year' ,'>=', date('Y')-626);
                break;
            case 4:
                $estates = $estates->where('built_year' ,'>=', date('Y')-631);
                break;
            case 5:
                $estates = $estates->where('built_year' ,'>=', date('Y')-641);
                break;
            case 6:
                $estates = $estates->where('built_year' ,'>=', date('Y')-651);
                break;
            case 7:
                $estates = $estates->where('built_year' ,'<', date('Y')-651);
                break;
        }
    }*/
    $estatslist2 = array();
    //dd(getQuery($estates));
    $listEstates = $estates->get();

    foreach($listEstates as $estate)
    {


        $priority = 5;
        switch($customer->estate_type)
        {
            case 1:
                if($customer->max_room_count > 0){
                    if(!(($estate->room_count-186) >= $customer->max_room_count))
                    {
                        break;
                    }
                }
                if(str_contains($customer->facilities , '"37"')){ // پارکینگ
                    if(!str_contains($estate->facilities , '"37"'))
                    {
                        break;
                    }
                }
                if(str_contains($customer->facilities , '"35"')){ // آسانسور
                    if(!str_contains($estate->facilities , '"35"'))
                    {
                        break;
                    }
                }
                $priority = 4;

                if($customer->max_building_age > 0){
                    switch($customer->max_building_age)
                    {
                        case 1:
                            $year = date('Y')-622;
                            break;
                        case 2:
                            $year = date('Y')-623;
                            break;
                        case 3:
                            $year = date('Y')-626;
                            break;
                        case 4:
                            $year = date('Y')-631;
                            break;
                        case 5:
                            $year = date('Y')-641;
                            break;
                        case 6:
                            $year = date('Y')-651;
                            break;
                        case 7:
                            $year = date('Y')-651;
                            break;
                    }
                    if(!($estate->built_year >= $year))
                    {
                        break;
                    }
                }

                if(str_contains($customer->facilities , '"36"')){ //انباری
                    if(!str_contains($estate->facilities , '"36"'))
                    {
                        break;
                    }
                }

                if($customer->floor_count > 0){ // طبقات
                    switch($customer->floor_count)
                    {
                        case 1: //طبقه اول
                            break;
                        case 2: // بجز طبقه اول
                            break;
                        case 3: // طبقات وسط
                            break;
                        case 4: // طبقه آخر
                            break;
                    }
                }

                if($customer->min_floor_count > 0){
                    if(!(($estate->floor_count - 154) <= $customer->min_floor_count))
                    {
                        break;
                    }
                }
                // if($estate->id == 158723)
                // {
                //     dd('fffff');
                // }
                $priority = 3;
                if($customer->document_type > 0){ // سند
                    if(!($estate->document_type == $customer->document_type))
                    {
                        break;
                    }
                }
                if($customer->existing_document > 0){ // سند موجود
                    if(!($estate->existing_document == $customer->existing_document))
                    {
                        break;
                    }
                }
                if($customer->geography != null){
                    if(!($estate->geography == $customer->geography))
                    {
                        break;
                    }
                }

                if($customer->max_unit_in_floor > 0){
                    if(!(($estate->unit_in_floor - 304) <= $customer->max_unit_in_floor))
                    {
                        break;
                    }
                }

                $priority = 2;

                if(str_contains($customer->conditions , '"304"')){ // کلید نخورده
                    if(!str_contains($estate->conditions , '"304"'))
                    {
                        break;
                    }
                }
                if($customer->compensation > 0){ // قابلیت معاوضه
                    if(!($estate->exchange == 1))
                    {
                        break;
                    }
                }

                $priority = 1;
                break;
            case 2:
                if($customer->min_built_area > 0){ // مساحت زیر بنا
                    if(!($estate->min_built_area >= $customer->min_built_area))
                    {
                        break;
                    }
                }
                if($customer->document_type > 0){ // سند
                    if(!($estate->document_type == $customer->document_type))
                    {
                        break;
                    }
                }
                if($customer->geography != null){
                    if(!($estate->geography == $customer->geography))
                    {
                        break;
                    }
                }
                $priority = 4;
                if(str_contains($customer->facilities , '"36"')){ //انباری
                    if(!str_contains($estate->facilities , '"36"'))
                    {
                        break;
                    }
                }
                if(str_contains($customer->facilities , '"37"')){ // پارکینگ
                    if(!str_contains($estate->facilities , '"37"'))
                    {
                        break;
                    }
                }
                if(str_contains($customer->facilities , '"35"')){ // آسانسور
                    if(!str_contains($estate->facilities , '"35"'))
                    {
                        break;
                    }
                }
                if($customer->max_room_count > 0){
                    if(!(($estate->room_count-186) >= $customer->max_room_count))
                    {
                        break;
                    }
                }
                if($customer->max_building_age > 0){
                    switch($customer->max_building_age)
                    {
                        case 1:
                            $year = date('Y')-622;
                            break;
                        case 2:
                            $year = date('Y')-623;
                            break;
                        case 3:
                            $year = date('Y')-626;
                            break;
                        case 4:
                            $year = date('Y')-631;
                            break;
                        case 5:
                            $year = date('Y')-641;
                            break;
                        case 6:
                            $year = date('Y')-651;
                            break;
                        case 7:
                            $year = date('Y')-651;
                            break;
                    }
                    if(!($estate->built_year >= $year))
                    {
                        break;
                    }
                }
                $priority = 3;
                if($customer->min_front_area > 0){ // متراژ بر
                    if(!($estate->front_area >= $customer->min_front_area))
                    {
                        break;
                    }
                }
                if($customer->min_floor_count > 0){
                    if(!($estate->floor_count <= $customer->min_floor_count))
                    {
                        break;
                    }
                }
                $priority = 2;
                if(str_contains($customer->conditions , '"304"')){ // کلید نخورده
                    if(!str_contains($estate->conditions , '"304"'))
                    {
                        break;
                    }
                }
                if($customer->compensation > 0){ // قابلیت معاوضه
                    if(!($estate->exchange == 1))
                    {
                        break;
                    }
                }
                if($customer->build_license > 0 ){ // پروانه ساخت
                    if(!($estate->build_license == 1))
                    {
                        break;
                    }
                }
                if($customer->min_street_width > 0){ // عرض گذر
                    if(!($estate->street_width >= $customer->min_street_width))
                    {
                        break;
                    }
                }
                if($customer->floor_start != null){
                    if(!($estate->floor_start == $customer->floor_start))
                    {
                        break;
                    }
                }

                $priority = 1;
                break;
            case 4:
                if($customer->document_type > 0){ // سند
                    if(!($estate->document_type == $customer->document_type))
                    {
                        break;
                    }
                }
                if($customer->min_front_area > 0){ // متراژ بر
                    if(!($estate->front_area >= $customer->min_front_area))
                    {
                        break;
                    }
                }
                $priority = 4;
                if($customer->build_license > 0 ){ // پروانه ساخت
                    if(!($estate->build_license == 1))
                    {
                        break;
                    }
                }
                $priority = 3;
                if($customer->min_density > 0){ //  حداقل تراکم
                    if(!($estate->build_density >= $customer->min_density))
                    {
                        break;
                    }
                }
                if($customer->usage_type > 0){ // کاربری
                    if(!($estate->usage_type == $customer->usage_type))
                    {
                        break;
                    }
                }


                $priority = 2;
                if($customer->compensation > 0){ // قابلیت معاوضه
                    if(!($estate->exchange == 1))
                    {
                        break;
                    }
                }
                $priority = 1;
                break;
        }
        if(ss('SITE_ID') == 5 || ss('SITE_ID') == 3 || ss('SITE_ID') == 2 || ss('SITE_ID') == 8)
        {
            $status= 0;
            if($priority == 1)
            {
                if($estate->haveExpert()){
                    $status= 2;
                }
                else
                {
                    $estateEdit = EstateEdit::where('estate_id' , $estate->id)->where('type' ,'percent_expert')->where('changeto' , '>' , 0)->first();
                    if(isset($estateEdit) && $estateEdit != null){
                        $status= 2;
                    }
                }
            }
        }
        else
        {
            $status= 2;
        }
        $estatslist2[] = $estate->id;
        $getrel = RelationEstateCustomer::where('customer_id' , $customer_id)->where('estate_id' , $estate->id)->first();
        if(!$getrel)
        {
            RelationEstateCustomer::create([
                'estate_id' => $estate->id,
                'customer_id' => $customer_id,
                'customer_expert_id' => $customer->user_id,
                'status' => $status,
                'priority' => $priority
            ]);
        }
        else
        {
            if($getrel->priority != $priority)
            {
                RelationEstateCustomer::where('id' , $getrel->id)->update(['priority' => $priority]);

            }
        }
    }
    if(is_array($estatslist) && is_array($estatslist2))
    {
        $arr = array_diff($estatslist , $estatslist2);
        if(count($arr) > 0)
        {
            RelationEstateCustomer::where('customer_id' , $customer_id)->whereIn('estate_id' , $arr)->delete();
        }
    }
}
function getQuery($item){
    $query = str_replace(array('?'), array('\'%s\''), $item->toSql());
    return $query = vsprintf($query, $item->getBindings());
        //echo($query);
}
/*function getsetting($group, $name) {
    $setting = Setting::where('group',$group)->where('name',$name)->first();
    if(isset($setting)){
        return $setting->value;
    }
    else
    {
        return '';
    }
}*/
function smsText($type , $value)
{
    switch($type)
    {
        case 'verify':
            return "به ".ss('SITE_NAME')." خوش آمدید\nکد فعالسازی شما : ".$value."\n\n".env('APP_URL');
            break;
        case 'okauth':
            return "$value[0] $value[1] ، احراز هویت شما در ".ss('SITE_NAME')." با موفقیت انجام شد.\nویرایش اطلاعات از طریق:\n".env('APP_URL')."/kyc";
            break;
        case 'notokauth':
            return "$value[0] $value[1] ، احراز هویت شما در ".ss('SITE_NAME')." با مشکل مواجه شده است\nویرایش اطلاعات از طریق :\n".env('APP_URL')."/kyc";
            break;
    }
}
function checkInputs($inputs){

    $english = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $persian = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    foreach($inputs as $key=>$val){
        if($val != null && !is_array($val))
        $inputs[$key] = str_replace($persian , $english, $val);
    }
    return $inputs;
}

function en_num( $str) {
    $num_a = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $key_a = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
    return str_replace( $key_a, $num_a, $str );
}
function tr_num( $str, $mod = 'en', $mf = '٫' ) {
    $num_a = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.' );
    $key_a = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', $mf );
    return ( $mod == 'fa' ) ? str_replace( $num_a, $key_a, $str ) : str_replace( $key_a, $num_a, $str );
}
function gregorian_to_jalali( $gy, $gm, $gd, $mod = '' ) {
    list( $gy, $gm, $gd ) = explode( '_', tr_num( $gy . '_' . $gm . '_' . $gd ) );/* <= Extra :اين سطر ، جزء تابع اصلي نيست */
    $g_d_m = array( 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334 );
    if ( $gy > 1600 ) {
        $jy = 979;
        $gy -= 1600;
    } else {
        $jy = 0;
        $gy -= 621;
    }
    $gy2  = ( $gm > 2 ) ? ( $gy + 1 ) : $gy;
    $days = ( 365 * $gy ) + ( (int) ( ( $gy2 + 3 ) / 4 ) ) - ( (int) ( ( $gy2 + 99 ) / 100 ) ) + ( (int) ( ( $gy2 + 399 ) / 400 ) ) - 80 + $gd + $g_d_m[ $gm - 1 ];
    $jy += 33 * ( (int) ( $days / 12053 ) );
    $days %= 12053;
    $jy += 4 * ( (int) ( $days / 1461 ) );
    $days %= 1461;
    $jy += (int) ( ( $days - 1 ) / 365 );
    if ( $days > 365 ) {
        $days = ( $days - 1 ) % 365;
    }
    if ( $days < 186 ) {
        $jm = 1 + (int) ( $days / 31 );
        $jd = 1 + ( $days % 31 );
    } else {
        $jm = 7 + (int) ( ( $days - 186 ) / 30 );
        $jd = 1 + ( ( $days - 186 ) % 30 );
    }
    return ( $mod === '' ) ? array( $jy, $jm, $jd ) : $jy . $mod . sprintf("%'.02d", $jm) . $mod . sprintf("%'.02d", $jd);
}
/*	F	*/
function jalali_to_gregorian( $jy, $jm, $jd, $mod = '' ) {
    list( $jy, $jm, $jd ) = explode( '_', tr_num( $jy . '_' . $jm . '_' . $jd ) );/* <= Extra :اين سطر ، جزء تابع اصلي نيست */
    if ( $jy > 979 ) {
        $gy = 1600;
        $jy -= 979;
    } else {
        $gy = 621;
    }
    $days = ( 365 * $jy ) + ( ( (int) ( $jy / 33 ) ) * 8 ) + ( (int) ( ( ( $jy % 33 ) + 3 ) / 4 ) ) + 78 + $jd + ( ( $jm < 7 ) ? ( $jm - 1 ) * 31 : ( ( $jm - 7 ) * 30 ) + 186 );
    $gy += 400 * ( (int) ( $days / 146097 ) );
    $days %= 146097;
    if ( $days > 36524 ) {
        $gy += 100 * ( (int) ( -- $days / 36524 ) );
        $days %= 36524;
        if ( $days >= 365 ) {
            $days ++;
        }
    }
    $gy += 4 * ( (int) ( ( $days ) / 1461 ) );
    $days %= 1461;
    $gy += (int) ( ( $days - 1 ) / 365 );
    if ( $days > 365 ) {
        $days = ( $days - 1 ) % 365;
    }
    $gd = $days + 1;
    foreach (
        array(
            0,
            31,
            ( ( ( $gy % 4 == 0 ) and ( $gy % 100 != 0 ) ) or ( $gy % 400 == 0 ) ) ? 29 : 28,
            31,
            30,
            31,
            30,
            31,
            31,
            30,
            31,
            30,
            31
        ) as $gm => $v
    ) {
        if ( $gd <= $v ) {
            break;
        }
        $gd -= $v;
    }
    return ( $mod === '' ) ? array( $gy, $gm, $gd ) : $gy . $mod . $gm . $mod . $gd;
}
function getDomainImg($id)
{
    if(env('SITE_ID') == 5 && $id<499730)
    {
        return 'https://file.kolbeh.ir';
    }
    if(env('SITE_ID') == 3 && $id<358361)
    {
        return 'https://file.koomeh.ir';
    }
    return '';
}
function ss($name = '' , $default = '')
{
    // Only use .env file for settings - don't touch database
    return env($name, $default);
}
function getSetting($group = '' , $name ='' , $default = '')
{
    // Only use .env file for settings - don't touch database
    return env($name, $default);
}
function getSetting2($income = 0 , $group = '' , $name ='')
{
    // Only use .env file for settings - don't touch database
    return env($name, 0);
}
function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    return '';
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

