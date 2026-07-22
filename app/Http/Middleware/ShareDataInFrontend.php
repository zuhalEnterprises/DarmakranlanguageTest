<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Chat;
use App\Models\City;
use App\Models\Province;
use App\Models\UserTime;
use App\Models\IpLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class ShareDataInFrontend
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Set application locale from session
        $locale = session('locale', config('app.locale', 'fa'));
        $locale = in_array($locale, ['fa', 'ar', 'en'], true) ? $locale : config('app.fallback_locale', 'en');
        app()->setLocale($locale);
        Config::set('app.locale', $locale);
        Carbon::setLocale($locale);
        View::share('currentLocale', $locale);
        View::share('availableLocales', ['fa' => 'فارسی', 'ar' => 'العربية', 'en' => 'English']);

        // No database calls - use default values only
        View::share('IpLogin', null);
        
        $c = ss('DEFAULT_CITY');
        $myString = "";
        if(!empty($request->refId)){
            $myString = $request->refId;
        }
        session(['refId' => $myString ?? '']);
        $defaultCity = null;
        $selectedCity = $c;
        
        $currentUser = Auth::user();
        
        $cityData = '[]';
        $provinces = collect();
        $allcities = collect();
        $cities = collect();
        $chatCount = 0;

        View::share('currentUser', $currentUser);
        View::share('selectedCity', $selectedCity);
        View::share('defaultCity', $defaultCity);
        View::share('cityData', $cityData);
        View::share('provinces', $provinces);
        View::share('cities', $cities);
        View::share('allcities', $allcities);
        View::share('chatCount', $chatCount);


        $response = $next($request);
        return $response;
    }
}
