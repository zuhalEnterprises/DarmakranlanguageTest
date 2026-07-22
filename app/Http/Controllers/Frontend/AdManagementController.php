<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Requests\User\VerifyMobileRequest;
use App\Http\Requests\User\VerifyCodeRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\City;
use App\Models\Estate;
use App\Models\EstateFavorite;
use App\Models\EstateNote;
use App\Models\ExpertFavorite;
use App\Models\Province;
use App\Models\TemplatePage;
use App\Models\UserSearch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserLogin;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\Validator;

class AdManagementController extends Controller
{

    public function preview(Request $request,$token)
    {
        // auth user
        $user = Auth::user();

        // retrieve estate
        $estate = Estate::with([
            'images',
            'expert',
            'expert.roles',
            'district.adjacentDistricts',
            'notes' => function ($q) use ($user) {
                $q->where('user_id', ($user->id ?? 0));
            },
            'reports' => function ($q) use ($user) {
                $q->where('user_id', ($user->id ?? 0));
            },
            'hits'
        ])->where('token', $token)
            ->where('confirmation', 'verified')
            ->first();

        if (!$estate) {
            return view('frontend.errors.404');
        }

        // get estate attributes and features
        $attributesText = $attributesText2 = $features = [];

        // attributesText
        switch ($estate->estate_type) {
            case 1:
                $attributesText = [
                    'متراژ' => $estate->area,
                    'کاربری' => getSaleFields($estate->estate_type, 'usage_type', $estate->usage_type),
                    'تعداد اتاق' => $estate->room_count,
                ];
                break;
            case 2:
                $attributesText = [
                    'متراژ' => $estate->area,
                    'تعداد طبقه' => $estate->floor_count,
                    'جهت جغرافیایی' => getSaleFields($estate->estate_type, 'geography', $estate->geography)
                ];
                break;
            case 3:
                $attributesText = [
                    'متراژ کف' => $estate->floor_area,
                    'متراژ بر' => $estate->front_area,
                    'موقعیت مکانی' => getSaleFields($estate->estate_type, 'position_type', $estate->position_type),
                ];
                break;
            case 4:
                $attributesText = [
                    'متراژ کل' => $estate->area,
                    'متراژ بر' => $estate->front_area,
                    'جهت جغرافیایی' => getSaleFields($estate->estate_type, 'geography', $estate->geography),
                ];
                break;
        }

        // attributesText2
        if (in_array($estate->estate_type, [2, 3, 4])) {
            $attributesText2 = [
                'متراژ بر' => $estate->front_area,
                'متراژ گذر' => $estate->street_width,
            ];
        }

        // features
        switch ($estate->estate_type) {
            case 1:
                $features = [
                    'پارکینگ' => 'fa-car',
                    'انباری' => 'fa-warehouse',
                    'آسانسور' => 'fa-sort-circle-down',
                ];
                break;
            case 2:
                $features = [
                    'پارکینگ' => 'fa-car',
                    'انباری' => 'fa-warehouse',
                    'بالکن' => 'fa-window-frame-open'
                ];
                break;
            case 3:
                $features = [
                    'زیرزمین' => 'fa-inventory',
                    'انباری' => 'fa-warehouse',
                    'بالکن' => 'fa-window-frame-open',
                ];
                break;
        }

        $dt = Carbon::now();
        // check expired
        $estate->isExpired = $estate->expired_at >= $dt ? 0 : 1;
        // get cover image
        $firstImage = $estate->images->first();
        $estate->coverImage = $estate->cover ?? ($firstImage ? asset('/upload/images/estate/' . $firstImage->dimension['medium']) : asset('/upload/images/photos-coming-soon.jpg'));

        $templatePage = getTemplatePageWithAds(7);

        return view('frontend.profile.ad_management.preview', compact(
            'estate',
            'attributesText',
            'attributesText2',
            'features',
            'templatePage'
        ));
    }

    public function upgrade(Request $request)
    {
        // auth user
        $user = Auth::user();

        $templatePage = getTemplatePageWithAds(7);

        return view('frontend.profile.ad_management.upgrade', compact('templatePage'));
    }

    public function edit(Request $request)
    {
        // auth user
        $user = Auth::user();

        $templatePage = getTemplatePageWithAds(7);

        return view('frontend.profile.ad_management.edit', compact('templatePage'));
    }
}
