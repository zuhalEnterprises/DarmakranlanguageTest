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
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        // retrieve selected city
        $selectedCity = $_COOKIE['city'] ?? null;
        if(!empty($selectedCity)){
            return redirect('/c/'.$selectedCity);
        }

        // retrieve cities
        $cities = City::where('active', 1)->get(['id', 'name', 'name_en']);

        // get template page and ads
        $templatePage = getTemplatePageWithAds(2);

        return view('frontend.city.index', compact('cities', 'templatePage'));
    }
}
