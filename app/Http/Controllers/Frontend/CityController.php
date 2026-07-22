<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Branch;
use App\Models\City;
use App\Models\Province;
use App\Models\TemplatePage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use kcfinder\session;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class CityController extends Controller
{
    public function index(Request $request)
    {
        // if redirected from the expert search
        $redirectUrl = session('referrerUrl') ?? '';
        // retrieve selected city
        $selectedCity = $_COOKIE['city'] ?? ss('DEFAULT_CITY');
        //$selectedCity ="qom";
        if (!empty($selectedCity)) {

            // redirect to experts search
            if(!empty($redirectUrl)){
                session()->forget('referrerUrl');

                return redirect($redirectUrl);
            }

            // redirect to estates search
            return redirect('/c/' . $selectedCity);
        }

        // retrieve provinces
        $provinces = Province::where('active', 1)->get();

        // get template page and ads
        $templatePage = getTemplatePageWithAds(2);

        return view('frontend.city.index', compact('provinces', 'templatePage', 'redirectUrl'));
    }
}
