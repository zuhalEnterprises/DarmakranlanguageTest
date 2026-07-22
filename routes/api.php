<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route کاربر با احراز هویت
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Routeهای بخش Frontend
/*Route::prefix('frontend')->group(function () {
    Route::post('comment', [\App\Http\Controllers\Frontend\CommentController::class, 'store']);
    Route::post('home_search', [\App\Http\Controllers\Frontend\HomeController::class, 'home_search']);
    Route::post('newsletter', [\App\Http\Controllers\Frontend\NewsletterController::class, 'store']);
    Route::post('search_keyword', [\App\Http\Controllers\Frontend\HomeController::class, 'saveSearchedKeyword']);
});*/

// Routeهای API

    // Province Routes
    Route::controller(\App\Http\Controllers\Api\ProvinceController::class)->group(function () {
        Route::get('provinces/{id}/cities', 'getCities');
        Route::get('provinces/{id}/get_cities', 'getCities2');
    });

    // City Routes
    Route::controller(\App\Http\Controllers\Api\CityController::class)->group(function () {
        Route::get('cities/{id}/districts', 'getDistricts');
        Route::get('cities/{id}/districts1', 'getDistricts1');
        Route::get('cities/{id}/areas', 'getArea');
        Route::get('cities/{id}/branch_admins', 'getBranchAdmins');
        Route::get('cities/{id}/coaches', 'getCoaches');
        Route::get('cities/{id}', 'show');
        Route::get('cities/{id}/AreaDistrict', 'getAreaDistrict');
    });

    // District Routes
    Route::controller(\App\Http\Controllers\Api\DistrictController::class)->group(function () {
        Route::get('districts/{id}/streets', 'getStreets');
    });

    // Branch Routes
    Route::controller(\App\Http\Controllers\Frontend\BranchController::class)->group(function () {
        Route::get('branches/{id}/districts', 'getDistricts');
        Route::get('branches/{id}/admin_trades', 'getAdminTrades');
        Route::get('branches/{id}/experts', 'getExperts');
    });


    Route::controller(\App\Http\Controllers\Api\CustomerController::class)->group(function () {
        Route::post('addCustomer', 'store');
        Route::post('addBooking', 'storeAppointment');
    });
