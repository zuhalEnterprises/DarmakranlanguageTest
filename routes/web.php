<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\TranslationController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\ChatController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\EstateController;
use App\Http\Controllers\Frontend\CityController;
use App\Http\Controllers\Frontend\NotificationController;
use App\Http\Controllers\Frontend\ExpertController;
use App\Http\Controllers\Frontend\BranchController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\SmsController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\QuestionController;
use App\Http\Controllers\Frontend\ContractController;
use App\Http\Controllers\Frontend\SettingController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\ShareDataInFrontend;
use App\Http\Controllers\Auth\SocialLoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\ForgotPasswordController;
// routes/web.php
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Config;

Route::get('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');


Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');


Route::get('/auth/google', [SocialLoginController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);
Auth::routes(['verify' => true]);
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard'); // مسیر بعد از تایید ایمیل
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'ایمیل تایید دوباره ارسال شد.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Web Routes
Route::get('/translate', [TranslationController::class, 'translate']);
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['fa', 'ar', 'en'], true)) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
        Config::set('app.locale', $locale);
        \Carbon\Carbon::setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');
Route::get('/logout', [LoginController::class, 'logout']);
// Frontend
Route::post('/comment/addComment', [CommentController::class, 'store']);
Route::middleware([ShareDataInFrontend::class])->group(function () {
    Route::get('/', [HomeController::class, 'mainPage'])->name('mainPage');
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::get('/register', [UserController::class, 'showRegistrationForm']);
    Route::post('/register', [UserController::class, 'register'])->name('register');
    Route::post('/login2', [UserController::class, 'login2'])->name('login2');
    Route::post('/confirm', [UserController::class, 'confirm']);
    Route::get('/check_validation/create', [UserController::class, 'showCheckValidationForm']);
    Route::post('/forget_password', [UserController::class, 'forgetPassword']);
    Route::get('/forget_password/create', [UserController::class, 'showForgetPasswordForm']);
    Route::get('/send_again/{username}', [UserController::class, 'sendAgain']);
    Route::post('/check_validation', [UserController::class, 'checkValidation']);

    Route::post('/login_mobile', [UserController::class, 'loginByMobile'])->name('loginMobile');
    Route::post('/verify_mobile', [UserController::class, 'verifyMobile'])->name('verifyMobile');
    Route::post('/verify_code', [UserController::class, 'verifyCode'])->name('verifyCode');

    Route::get('/chat_v2', [ChatController::class, 'chat_v2'])->name('chat_v2');

    Route::get('/account', [HomeController::class, 'account'])->name('account');
    Route::get('/account/signin', [HomeController::class, 'signin'])->name('signin');
    Route::get('/account/signup', [HomeController::class, 'signup'])->name('signup');
    Route::get('/account/signupExpert', [HomeController::class, 'signupExpert'])->name('signupExpert');
    Route::get('/account/signupExpert2', [HomeController::class, 'signupExpert2'])->name('signupExpert2');
    Route::get('/account/search', [EstateController::class, 'search_acc'])->name('search_acc');
    Route::get('/account/agent', [EstateController::class, 'agent_acc'])->name('agent_acc');
    Route::get('/account/signupBranch', [EstateController::class, 'signup_branch'])->name('signup_branch');
    Route::get('/account/signupBranch2', [EstateController::class, 'signup_branch2'])->name('signup_branch2');
    Route::get('/showbranch', [EstateController::class, 'showBranch2'])->name('showBranch2');
    Route::get('/showexpert', [EstateController::class, 'showExpert2'])->name('showExpert2');
    Route::get('/myestate', [EstateController::class, 'my_estate'])->name('my_estate');
    Route::get('/homemap', [HomeController::class, 'map'])->name('homemap');
    Route::get('/show1', [HomeController::class, 'show1'])->name('show1');
    Route::get('/home', [HomeController::class, 'mainPage']);

    Route::get('/about', [HomeController::class, 'about'])->name('about');


    Route::get('/home/{city}', [HomeController::class, 'mainPage_v2']);
    Route::get('/fav', [EstateController::class, 'estate_fav'])->name('estate_fav');
    Route::get('/intro/agents', [HomeController::class, 'expertIntro'])->name('introExpert');
    Route::get('/cities', [CityController::class, 'index'])->name('cities');

    Route::get('notifications', [NotificationController::class, 'index'])->name('index');
    Route::get('/c/{city}', [EstateController::class, 'index'])->name('home');
    Route::get('/c/{city}/{type}-{estate_type}', [EstateController::class, 'search'])->name('search');
    Route::get('/c1/{city}/{type}-{estate_type}', [EstateController::class, 'search']);
    Route::get('/cs/{selectedcity}', [HomeController::class, 'selectedcity'])->name('selectedcity');

    Route::get('/{id}.html', [EstateController::class, 'show']);
    Route::get('/v/{id}/{slug?}', [EstateController::class, 'show']);
    Route::get('/w/{id}', [EstateController::class, 'showEdit']);
    Route::get('/k/{id}', [EstateController::class, 'keyword']);
    Route::get('/v1/{id}/{slug?}', [EstateController::class, 'show1']);
    Route::get('/sitemap/estate', [EstateController::class, 'sitemaplist']);
    Route::get('/sitemap/estate/{pagesize}', [EstateController::class, 'sitemap']);
    Route::get('/divar/{id}', [EstateController::class, 'divar']);
    Route::get('/listbayut', [EstateController::class, 'listbayut']);
    Route::get('/bayut/{url}', [EstateController::class, 'bayut']);
    Route::get('/commission_calculation', [EstateController::class, 'commission']);
    Route::get('/property_appraisal', [EstateController::class, 'appraisal']);
    Route::post('/property_appraisal/store', [EstateController::class, 'storeAppraisal']);
    Route::get('/api/divar/tel/{id}', [EstateController::class, 'teldivar']);
    Route::get('/sheypoor/{id}', [EstateController::class, 'sheypoor']);
    Route::get('/agent', [EstateController::class, 'agent']);

    Route::post('/estate/addRelation', [EstateController::class, 'addRelation']);
    Route::post('/estate/editRelationComment', [EstateController::class, 'editRelationComment']);
    Route::post('/estate/addOperation', [EstateController::class, 'addOperation']);
    Route::post('/estate/editOperation', [EstateController::class, 'editOperation']);
    Route::get('/addnew', [EstateController::class, 'addnew'])->name('addnew');
    Route::get('/addnew/{id}', [EstateController::class, 'addnew']);
    Route::get('/checkaddnew', [EstateController::class, 'checkaddnew'])->name('checkaddnew');
    Route::get('/agents/search', [ExpertController::class, 'getSearchForm']);
    Route::get('/{city}/agents/search', [ExpertController::class, 'getSearchForm']);
    Route::get('/agents/{code}', [ExpertController::class, 'show']);
    Route::post('/agents/comment', [ExpertController::class, 'addComment']);

    Route::get('/agent/authentication', [ExpertController::class, 'create_expert_report']);
    Route::get('/sitemap/agents', [ExpertController::class, 'sitemap']);

    Route::get('/branches', [BranchController::class, 'getSearchForm']);
    Route::get('/branches/search', [BranchController::class, 'getSearchForm']);
    Route::get('/branches2/search', [BranchController::class, 'branchSearch2']);
    Route::get('/branch/{code}', [BranchController::class, 'show']);

    Route::get('/suggest/{slug}', [HomeController::class, 'suggest']);
    Route::get('/addSuggest', [HomeController::class, 'addSuggest']);
    Route::get('/page/{slug}', [PageController::class, 'show']);
    Route::get('/contactus', [HomeController::class, 'contactus']);

    Route::post('/contact', [ContactController::class, 'submitContact']);

    Route::post('/estates/get_search_fields', [EstateController::class, 'getMoreFieldsSearch']);
    Route::post('/estates/get_search_fields_v2', [EstateController::class, 'getMoreFieldsSearch_v2']);
    Route::post('/estates/get_search_fields_mobile_v2', [EstateController::class, 'getMoreFieldsSearch_mobile_v2']);

    Route::get('/experts/ShowEstate', [ExpertController::class, 'ShowEstate']);
    Route::get('/experts/ShowEstate_v2', [ExpertController::class, 'ShowEstate_v2']);
    Route::get('/experts/ShowEstate1', [ExpertController::class, 'ShowEstate1']);
    Route::get('/experts/Comment', [ExpertController::class, 'showComment']);

    Route::get('/profile/bookmark-estate/{code}', [ProfileController::class, 'bookmarkEstate']);

    Route::get('blog', [BlogController::class, 'index']);
    Route::get('blog/list', [BlogController::class, 'list'])->name('list');
    Route::get('blog/show/{id}', [BlogController::class, 'show'])->name('show');
    Route::get('area/{id}/{slug?}', [BlogController::class, 'show']);
    Route::get('city/{id}/{slug?}', [BlogController::class, 'show']);
    Route::get('blog/{id}/{slug?}', [BlogController::class, 'show']);
    Route::get('posts/{id}', [BlogController::class, 'index']);
    Route::get('blogs/{id}', [BlogController::class, 'index']);

    Route::get('/panorma', [EstateController::class, 'panorma']);
    Route::get('/sendCommonSms', [EstateController::class, 'sendCommonSms']);
    Route::get('/panorma1', [EstateController::class, 'panorma1']);
    Route::get('/checkConfirm', [CustomerController::class, 'CheckConfirmation']);
    Route::get('/sendAgent', [HomeController::class, 'sendAgent']);
    Route::get('/sendAgent2', [HomeController::class, 'sendAgent2']);
    Route::get('/sms', [SmsController::class, 'add']);
    Route::get('/updateExpireDate', [EstateController::class, 'updateExpireDate']);
    Route::get('/sendRelationEstate', [HomeController::class, 'sendRelationEstate']);
    Route::get('/sendRelationEstate/{slug}', [HomeController::class, 'sendRelationEstate']);
    Route::get('/sendRelationEstate/{slug}/{slug2}', [HomeController::class, 'sendRelationEstate']);
    Route::get('/relationEstate', [HomeController::class, 'relationEstate']);
    Route::get('/appointment', [EstateController::class, 'appointment']);
    Route::get('customer/changecustomerstatus/{slug}', [CustomerController::class, 'changeCustomerStatus']);

    Route::get('/rental/estateShow', [EstateController::class, 'rental_estate_show']);
    Route::get('/rent', [HomeController::class, 'mainPage_rent'])->name('mainPage_rent');
    Route::get('/rental', [HomeController::class, 'shortTermRental'])->name('shortTermRental');
    Route::get('/room/{id}/{slug?}', [EstateController::class, 'roomShow'])->name('roomShow');
    Route::get('/rental/rules', [UserController::class, 'rules'])->name('rules');
    Route::get('/rental/host', [UserController::class, 'host'])->name('host');
    Route::post('/rental/customer/delete', [CustomerController::class, 'deleteRentalCustomer']);
    Route::get('/rental/search', [EstateController::class, 'rental_search']);
    Route::get('/customer/changeGrade', [CustomerController::class, 'changeGrade']);
    Route::get('/estate/projects/{id}', [EstateController::class, 'getProjects']);
    Route::post('/customers/assign-expert/{id}',[CustomerController::class, 'assignExpert']);

    Route::get('/chatsEstate2/{chat_id}/{estate_id}', [ChatController::class, 'chatsEstate2']);
    Route::get('/estates/destroyAll', [EstateController::class, 'destroyAll']);
    Route::get('/addteldivar', [EstateController::class, 'addTelDivar']);

    Route::get('/add', [EstateController::class, 'addnew']);
    Route::get('/addTowerEstate/{id}', [EstateController::class, 'addTowerEstate']);
    Route::post('/estates/media', [EstateController::class, 'storeMedia'])->name('estates.storeMedia');
    Route::post('/add', [EstateController::class, 'store']);

    Route::get('/estates/setVisit/{estate_id}', [EstateController::class, 'setVisit'])->name('setVisit');
    Route::middleware(['auth'])->group(function () {
        Route::get('/comment', [CommentController::class, 'index']);
        Route::get('/comment/destroy/{id}', [CommentController::class, 'destroy']);
        Route::get('/comment/statusVerified/{id}', [CommentController::class, 'approve']);
        Route::get('/comment/statusRejected/{id}', [CommentController::class, 'reject']);


        Route::get('/rental/customer/create', [CustomerController::class, 'rental_create']);
        Route::get('/rental/customers', [CustomerController::class, 'rental_list']);
        Route::get('/rental/customer/{id}/edit', [CustomerController::class, 'rental_edit']);
        Route::post('/rental/customer/store', [CustomerController::class, 'rental_store']);
        Route::put('/rental/customer/update/{id}', [CustomerController::class, 'rental_update']);
        Route::get('/rental/users', [UserController::class, 'rental_list']);
        Route::post('/rental/users/delete', [UserController::class, 'rental_destroy']);
        Route::get('/rental/users/create', [UserController::class, 'rental_create']);
        Route::get('/rental/users/edit/{id}', [UserController::class, 'rental_edit']);
        Route::post('/rental/users/store', [UserController::class, 'rental_store']);
        Route::post('/rental/users/update/{id}', [UserController::class, 'rental_update']);
        Route::get('/rental/estate/create', [EstateController::class, 'rental_create']);
        Route::get('/rental/estates', [EstateController::class, 'rental_list']);
        Route::get('/rental/estate/{id}/edit', [EstateController::class, 'rental_create']);
        Route::post('/rental/estate/store', [EstateController::class, 'rental_store']);
        Route::post('/rental/estate/update/{id}', [EstateController::class, 'rental_update']);
        Route::post('/estate/presentsend', [EstateController::class, 'presentsend'])->name('presentsend');
        Route::post('/estate/archive', [EstateController::class, 'archive'])->name('archive');
        Route::post('/estate/absence', [EstateController::class, 'absence'])->name('absence');

        // estates add
        Route::get('/operationsEstate/{estate_id}', [EstateController::class, 'operationsEstate']);
        Route::get('/operationsCustomer/{customer_id}', [CustomerController::class, 'operationsCustomer']);
        Route::get('/chatsEstate/{estate_id}', [ChatController::class, 'chatsEstate']);

        Route::get('/NotificationLog/NotificationGet', [NotificationController::class, 'notificationGet']);
        Route::get('/NotificationLog/Update', [NotificationController::class, 'NotificationLogUpdate']);
        Route::post('/dashboard/performanceCreate', [DashboardController::class, 'PerformanceCreate']);
        Route::post('/dashboard/PerformanceVisitUpdate', [DashboardController::class, 'PerformanceVisitUpdate']);

        Route::get('/question', [QuestionController::class, 'index']);
        Route::get('/estates/{id}/edit', [EstateController::class, 'addnew']);
        Route::put('/estates/update/{id}', [EstateController::class, 'update']);
        Route::get('/estates/destroy/{id}', [EstateController::class, 'destroy']);

        Route::get('/estates/archived/{id}', [EstateController::class, 'archived']);
        Route::get('/estates/verified/{id}', [EstateController::class, 'verified']);
        Route::get('/estates/changeConfirmation/{id}/{status}', [EstateController::class, 'changeConfirmation']);
        Route::get('/estates/ladder/{id}', [EstateController::class, 'ladder']);
        Route::get('/estates/visible/{id}', [EstateController::class, 'visible']);
        Route::post('/estates/update1/{id}', [EstateController::class, 'update1']);
        Route::post('/estates/get_fields', [EstateController::class, 'getMoreFields']);
        Route::post('/estates/get_fields1', [HomeController::class, 'cropjs1']);

        Route::post('/branches/media', [BranchController::class, 'storeMedia'])->name('branches.storeMedia');
        Route::post('/contract/media', [ContractController::class, 'storeMedia'])->name('contract.storeMedia');
        Route::delete('/contract/media/{id}', [ContractController::class, 'deleteMedia'])->name('contract.deleteMedia');
        Route::delete('/estates/media/{id}', [EstateController::class, 'deleteMedia'])->name('estates.deleteMedia');
        Route::delete('/branches/media/{id}', [BranchController::class, 'deleteMedia'])->name('branches.deleteMedia');
        Route::get('/estates/{id}/assign_agent', [EstateController::class, 'getAgent'])->name('estates.getAgent');
        Route::post('/estates/{id}/assign_agent', [EstateController::class, 'assignAgent'])->name('estates.assignAgent');

        // customer
        Route::post('/customer/absence', [CustomerController::class, 'absence']);
        Route::get('/customer/{id}', [CustomerController::class, 'detail']);
        Route::get('customer', [CustomerController::class, 'index']);
        Route::post('customer', [CustomerController::class, 'index']);
        Route::get('customerReferrer', [CustomerController::class, 'referrer']);
        Route::post('customerReferrer', [CustomerController::class, 'referrer']);

        Route::get('/customerBooking', [CustomerController::class, 'booking']);
        Route::post('/customerBooking', [CustomerController::class, 'booking']);
        Route::get('/customerBooking/destroy/{id}', [CustomerController::class, 'bookingDestroy']);

        Route::get('/customers/create', [CustomerController::class, 'create']);
        Route::get('/customer/{id}/edit_v2', [CustomerController::class, 'edit_v2']);
        Route::get('/customer/{id}/edit', [CustomerController::class, 'edit']);
        Route::post('/customer/store', [CustomerController::class, 'store']);
        Route::put('/customer/update/{id}', [CustomerController::class, 'update']);
        Route::get('customer/updatelabel/{id}/{lable}', [CustomerController::class, 'updatelabel']);
        Route::get('customer/favorite/{customer_id}', [CustomerController::class, 'addToFavorite']);

        Route::post('branchcustomer', [CustomerController::class, 'branchlist'])->name('branchlist');
        Route::get('estates/norole', [EstateController::class, 'estateShowExpert']);

        // favorite estate (add | remove)
        Route::get('/estates/favorite/{estate_id}', [EstateController::class, 'addToFavorite'])->name('addToFavorite');
        Route::get('/estates/favorite_pin/{estate_id}', [EstateController::class, 'pinFavorite']);

        // compare
        Route::get('/estates/compare/{estate_id}', [EstateController::class, 'addToCompare'])->name('addToCompare');

        Route::get('/estates/compare_remove_all', [EstateController::class, 'removeallCompare']);
        Route::get('/estates/compare_remove/{estate_id}', [EstateController::class, 'removeCompare']);

        // note
        Route::post('/estates/note', [EstateController::class, 'addNote']);
        Route::post('/customer/note', [CustomerController::class, 'addNote']);

        // report
        Route::post('/estates/report', [EstateController::class, 'addReport']);

        // save-search (estate)
        Route::post('/save-search', [EstateController::class, 'addSearch']);

        // favorite agent (add | remove)
        Route::get('/agents/addToFavorite/{expert_id}', [ExpertController::class, 'show1']);
        Route::get('/agents/favorite/{expert_id}', [ExpertController::class, 'addToFavorite']);
        Route::get('/agents/favorite_pin/{expert_id}', [ExpertController::class, 'pinFavorite']);

        // save-search (agent)
        Route::post('/agents/save-search', [ExpertController::class, 'addSearch']);

        // Chat (Message)
        Route::post('chats/sendmsg', [ChatController::class, 'sendMessage']);
        Route::resource('chats', ChatController::class);

        // agent registration
        Route::get('/agent/register', [ExpertController::class, 'getRegisterForm']);
        Route::post('/agent/register', [ExpertController::class, 'register']);
        Route::get('/kyc', [ExpertController::class, 'getRegisterForm']);

        // Branch registration
        Route::get('/branch/create', [BranchController::class, 'create']);
        Route::get('/branch', [BranchController::class, 'list']);
        Route::get('/branch/{id}/edit', [BranchController::class, 'edit']);
        Route::post('/branch/store', [BranchController::class, 'store']);
        Route::put('/branch/update/{id}', [BranchController::class, 'update']);
        Route::post('branch/edit1', [BranchController::class, 'edit1']);
        Route::post('branch/updaterate', [BranchController::class, 'updaterate']);

        // Profile
        Route::get('/profile', function () {
            return redirect('/profile/my-estate-ads');
        });
        Route::post('/customer/ladder', [CustomerController::class, 'ladder']);
        Route::post('/notecustomer/delete', [CustomerController::class, 'deleteNote']);
        Route::post('/customer/removeagent', [CustomerController::class, 'removeAgent']);
        Route::post('/customer/assignToMe', [CustomerController::class, 'assignToMe']);
        Route::post('/notecustomer/undelete', [CustomerController::class, 'undelete']);
        Route::post('/estate/estatecheck', [EstateController::class, 'estatecheck']);

        // Expert authentication
        Route::get('/agents/auth/{expert_id}', [ExpertController::class, 'authentication']);

        // Club
        Route::get('/club', [ProfileController::class, 'club'])->name('club');
        Route::get('/favorite', [ProfileController::class, 'favorite'])->name('favorite');
        Route::get('/compare', [ProfileController::class, 'compare'])->name('compare');
        Route::get('/estateget/{id}', [ProfileController::class, 'estateget']);
        Route::post('/customer/customercheck', [CustomerController::class, 'customercheck']);
        Route::get('/customerget/{id}', [ProfileController::class, 'customerget']);
        Route::post('/tasks/createTask', [ProfileController::class, 'createTask'])->name('createTask');
        Route::post('/tasks/deleted', [ProfileController::class, 'createTask']);
        Route::get('/task', [ProfileController::class, 'Task'])->name('Task');
        Route::get('/tasks/delete/{id}', [ProfileController::class, 'deleteTask']);
        Route::get('/tasks/status/{id}', [ProfileController::class, 'statusTask']);

        // Acquaintance
        Route::get('/acquaintance', [CustomerController::class, 'acquaintance']);
        Route::get('/acquaintance/create', [CustomerController::class, 'acquaintancecreate']);
        Route::get('/acquaintance/edit/{id}', [CustomerController::class, 'acquaintanceedit']);
        Route::get('/acquaintance/destroy/{id}', [CustomerController::class, 'acquaintancedestroy']);
        Route::post('/acquaintance/update/{id}', [CustomerController::class, 'acquaintanceupdate']);
        Route::post('/acquaintance/store', [CustomerController::class, 'acquaintancestore'])->name('acquaintancestore');

        // Estate properties
        Route::get('/propertiesShow', [EstateController::class, 'propertiesShow']);
        Route::get('/myProperties', [EstateController::class, 'myProperties']);
        Route::get('/branchProperties', [EstateController::class, 'branchProperties']);
        Route::get('/properties', [EstateController::class, 'allProperties']);
        Route::prefix('profile')->group(function () {


            ## Blog Post
            // info
            Route::post('/estates/update1/{id}', [EstateController::class, 'update1']);
            Route::post('/area/update/{id}', [ProfileController::class, 'areaupdate'])->name('areaupdate');
            Route::post('/area/store', [ProfileController::class, 'areastore']);
            Route::post('/city/update/{id}', [ProfileController::class, 'cityupdate'])->name('cityupdate');
            Route::post('/city/store', [ProfileController::class, 'citystore'])->name('citystore');
            Route::post('/manufacturer/update/{id}', [EstateController::class, 'manufacturerupdate'])->name('manufacturerupdate');
            Route::post('/manufacturer/store', [EstateController::class, 'manufacturerstore'])->name('manufacturerstore');
            Route::post('/project/update/{id}', [EstateController::class, 'projectupdate'])->name('projectupdate');
            Route::post('/project/store', [EstateController::class, 'projectstore'])->name('projectstore');

            Route::post('/brand/update/{id}', [EstateController::class, 'brandupdate'])->name('brandupdate');
            Route::post('/brand/store', [EstateController::class, 'brandstore'])->name('brandstore');

            Route::post('/district/update/{id}', [ProfileController::class, 'districtupdate'])->name('districtupdate');
            Route::post('/district/store', [ProfileController::class, 'districtstore'])->name('districtstore');
            Route::post('/street/update/{id}', [ProfileController::class, 'streetupdate'])->name('streetupdate');
            Route::post('/street/store', [ProfileController::class, 'streetstore'])->name('streetstore');
            Route::post('/province/update/{id}', [ProfileController::class, 'provinceupdate']);
            Route::post('/province/store', [ProfileController::class, 'provincestore'])->name('provincestore');

            Route::get('/appraisal', [EstateController::class, 'listAppraisal']);
            Route::get('/appraisalShow', [EstateController::class, 'listAppraisalShow']);
            Route::get('/appraisal/remove/{id}', [EstateController::class, 'removeAppraisal'])->name('removeAppraisal');

            Route::get('/posts', [PostController::class, 'index']);
            Route::get('/posts/create', [PostController::class, 'create']);
            Route::post('/posts/store', [PostController::class, 'store']);
            Route::get('/posts/edit/{id}', [PostController::class, 'edit']);
            Route::post('/posts/update/{id}', [PostController::class, 'update']);
            Route::get('/posts/destroy/{id}', [PostController::class, 'destroy']);
            Route::get('/posts/status/{id}', [PostController::class, 'status']);
            Route::get('/viewPost', [PostController::class, 'viewBlog']);

            Route::post('/ContractAdd', [ContractController::class, 'ContractAdd'])->name('ContractAdd');
            Route::post('/ContractEdit/{id}', [ContractController::class, 'ContractEdit'])->name('ContractEdit');
            Route::get('/Contract/destroy/{id}', [ContractController::class, 'contractDestroy']);
            Route::get('/contract/{id}/edit', [ContractController::class, 'create']);
            Route::get('/info', [ProfileController::class, 'getProfile']);
            Route::get('/info_v2', [ProfileController::class, 'info2']);
            Route::get('/expertlevel', [ProfileController::class, 'expertlevel']);
            Route::get('/expertlevel_v2', [ProfileController::class, 'expertlevel_v2']);
            Route::put('/info/update', [ProfileController::class, 'updateProfile']);
            Route::put('/info/update1', [ProfileController::class, 'updateProfile1']);
            Route::get('/change_password', [ProfileController::class, 'getChangePasswordForm'])->name('changePassword');
            Route::get('/province', [ProfileController::class, 'province']);
            Route::get('/area', [ProfileController::class, 'area']);
            Route::get('/district', [ProfileController::class, 'district']);
            Route::get('/street', [ProfileController::class, 'street']);
            Route::get('/city', [ProfileController::class, 'city']);

            Route::get('/manufacturer', [EstateController::class, 'manufacturer']);
            Route::get('/project', [EstateController::class, 'project']);
            Route::get('/brand', [EstateController::class, 'brand']);
            Route::get('/province/create', [ProfileController::class, 'provincecreate']);
            Route::get('/area/create', [ProfileController::class, 'areacreate']);
            Route::get('/district/create', [ProfileController::class, 'districtcreate']);
            Route::get('/street/create', [ProfileController::class, 'streetcreate']);
            Route::get('/city/create', [ProfileController::class, 'citycreate']);
            Route::get('/city/edit/{id}', [ProfileController::class, 'cityedit']);
            Route::get('/manufacturer/create', [EstateController::class, 'manufacturercreate']);
            Route::get('/manufacturer/edit/{id}', [EstateController::class, 'manufactureredit']);

            Route::get('/brand/create', [EstateController::class, 'brandcreate']);
            Route::get('/brand/edit/{id}', [EstateController::class, 'brandedit']);

            Route::get('/project/create', [EstateController::class, 'projectcreate']);
            Route::get('/project/edit/{id}', [EstateController::class, 'projectedit']);
            Route::get('/street/edit/{id}', [ProfileController::class, 'streetedit']);
            Route::get('/province/edit/{id}', [ProfileController::class, 'provinceedit']);
            Route::get('/district/edit/{id}', [ProfileController::class, 'districtedit']);
            Route::post('/change_password', [ProfileController::class, 'changePassword']);

            // Manage estate
            Route::get('/v/preview/{id}', [EstateController::class, 'preview']);

            // My estates
            Route::post('/createparties', [ContractController::class, 'createparties'])->name('createparties');
            Route::get('/contracts/{id}', [ContractController::class, 'Show'])->name('ContractShow');
            Route::get('/contract/add', [ContractController::class, 'create'])->name('contractcreate');
            Route::get('/contract/reminder', [ContractController::class, 'reminder'])->name('contractreminder');
            Route::get('/contract', [ContractController::class, 'index']);
            Route::get('/contractearn/{id}', [ContractController::class, 'contractearn'])->name('contractearn');
            Route::post('/partiesAdd', [ContractController::class, 'partiesAdd'])->name('partiesAdd');
            Route::post('/partiesEdit', [ContractController::class, 'partiesEdit'])->name('partiesEdit');
            Route::get('/partiesDestroy/{id}', [ContractController::class, 'partiesDestroy'])->name('partiesDestroy');
            Route::get('/contractUserDestroy/{id}', [ContractController::class, 'contractUserDestroy'])->name('contractUserDestroy');
            Route::get('/street/destroy/{id}', [ProfileController::class, 'streetdestroy']);
            Route::get('/city/destroy/{id}', [ProfileController::class, 'citydestroy']);
            Route::get('/manufacturer/destroy/{id}', [EstateController::class, 'manufacturerdestroy']);
            Route::get('/brand/destroy/{id}', [EstateController::class, 'branddestroy']);
            Route::get('/project/destroy/{id}', [EstateController::class, 'projectdestroy']);
            Route::get('/city/status/{id}', [ProfileController::class, 'citystatus']);
            Route::get('/district/destroy/{id}', [ProfileController::class, 'districtdestroy']);
            Route::get('/province/destroy/{id}', [ProfileController::class, 'provincedestroy']);
            Route::get('/province/status/{id}', [ProfileController::class, 'provincestatus']);

            Route::get('/myEstateShow', [ProfileController::class, 'myEstateShow']);
            Route::get('/my-estate-ads', [ProfileController::class, 'myEstate'])->name('my.estates');
            Route::get('/branch-estate-ads', [ProfileController::class, 'branchEstate'])->name('branch.estates');
            Route::get('/operationEstate', [ProfileController::class, 'operationsEstate']);
            Route::get('/operationEstateShow', [ProfileController::class, 'operationsEstateShow']);
            Route::get('/operationEstate/destroy/{id}', [ProfileController::class, 'destroyOperationEstate']);
            Route::get('/operationUser', [UserController::class, 'operationsUser']);
            Route::get('/operationUserShow', [UserController::class, 'operationsUserShow']);
            Route::get('/operationUser/destroy/{id}', [UserController::class, 'destroyOperationUser']);
            Route::post('/user/addOperation', [UserController::class, 'addOperation']);

            Route::get('/phonebook', [ProfileController::class, 'phonebook']);
            Route::post('/phonebook/update/{id}', [ProfileController::class, 'phonebookupdate'])->name('phonebookupdate');
            Route::post('/phonebook/store', [ProfileController::class, 'phonebookstore'])->name('phonebookstore');
            Route::get('/phonebook/destroy/{id}', [ProfileController::class, 'phonebookdestroy']);
            Route::get('/phonebook/create', [ProfileController::class, 'phonebookcreate']);
            Route::get('/phonebook/edit/{id}', [ProfileController::class, 'phonebookedit']);

            Route::get('/operationCustomer', [ProfileController::class, 'operationsCustomer']);
            Route::get('/operationCustomerShow', [ProfileController::class, 'operationsCustomerShow']);
            Route::get('/myreport', [ProfileController::class, 'myreport']);
            Route::get('/report', [ProfileController::class, 'report']);
            Route::get('/reportShow', [ProfileController::class, 'reportShow']);

            Route::get('/settings', [SettingController::class, 'index']);
            Route::post('/setting/update', [SettingController::class, 'update']);
            Route::get('/sms', [SmsController::class, 'smsList']);
            Route::get('/smsShow', [SmsController::class, 'smsListShow']);

            Route::resource('/users', UserController::class);
            Route::get('/users/status/{user_id}/{user_status}', [UserController::class, 'status']);
            Route::post('/users/delete', [UserController::class, 'destroy']);
            Route::get('/users/{id}/panel', [UserController::class, 'userPanel']);
            Route::get('/users/create', [UserController::class, 'create']);
            Route::get('/users/edit/{id}', [UserController::class, 'edit']);
            Route::post('/users/store', [UserController::class, 'store']);
            Route::post('/users/update/{id}', [UserController::class, 'update']);
            Route::get('/users/added', [UserController::class, 'added']);

            Route::resource('/branches', 'BranchController');
            Route::get('/branches/status/{user_id}/{user_status}', [BranchController::class, 'status']);
            Route::post('/branches/delete', [BranchController::class, 'destroy']);
            Route::get('/branches/create', [BranchController::class, 'create']);
            Route::get('/branches/edit/{id}', [BranchController::class, 'edit']);
            Route::post('/branches/store', [BranchController::class, 'store']);
            Route::post('/branches/update/{id}', [BranchController::class, 'update']);
            Route::get('/branches/added', [BranchController::class, 'added']);

            Route::get('/reportEstate', [EstateController::class, 'reportEstate']);
            Route::get('/reportEstateShow', [EstateController::class, 'reportEstateShow']);
            Route::get('/reportEstateStatus/{estate_report_id}/{status}', [EstateController::class, 'reportEstateStatus']);
            Route::get('/reportEstateDestroy/{id}', [EstateController::class, 'reportEstateDestroy']);
            Route::get('/relationEstateCustomer', [ProfileController::class, 'relationEstateCustomer']);
            Route::get('/relationEstateCustomerShow', [ProfileController::class, 'relationEstateCustomerShow']);
            Route::post('/relationEstateCustomer/destroy', [ProfileController::class, 'destroyRelationEstateCustomer']);
            Route::post('/relationEstateCustomer/confirm', [ProfileController::class, 'confirmRelationEstateCustomer']);
            Route::post('/relationEstateCustomer/reject', [ProfileController::class, 'rejectRelationEstateCustomer']);
            Route::post('/relationEstateCustomer/priority', [ProfileController::class, 'priorityRelationEstateCustomer']);
            Route::get('/editsEstate', [ProfileController::class, 'editsEstate']);
            Route::get('/editsEstateShow', [ProfileController::class, 'editsEstateShow']);
            // favorite estates
            Route::get('/bookmark-estate', [ProfileController::class, 'favoriteEstate']);
            // history (recently view)
            Route::get('/history', [ProfileController::class, 'history']);
            // my notes
            Route::get('/notes', [ProfileController::class, 'myNotes']);
            Route::get('/notes/{id}/delete', [ProfileController::class, 'deleteNote']);
            // favorite estates
            Route::get('/bookmark-expert', [ProfileController::class, 'favoriteExpert']);
            // saved searches (estate)
            Route::get('/saved-search', [ProfileController::class, 'savedSearch']);
            Route::get('/searches/{id}/delete', [ProfileController::class, 'deleteSavedSearch']);
            // saved searches (estate)
            Route::get('/agents/saved-search', [ProfileController::class, 'savedSearchAgent']);
            // ad management
            Route::get('/ad_management/{id}', [ProfileController::class, 'adManagement']);
        });
        Route::get('/shared-estates/{tokens}', [ProfileController::class, 'sharedEstate']);
    });
    Route::get('/operationUserCron', [UserController::class, 'operationsUserCron']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
Route::get('/admin-panel', function () {
    return view('admin.auth.login');
});
Route::get('/password/forget', function () {
    return view('admin.auth.passwords.email');
})->name('password.request');

Route::post('/password/forget', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
