<style>
    .nav-item .select2-selection.select2-selection--single {
        border: 1px solid transparent !important;
    }

    .nav-item .select2-selection__arrow {
        display: none
    }
    .logo-name {
        font-size: 14px;
    }
    @media (min-width:768px) {
        .logo-name
        {
            font-size: 24px;
        }
    }
    @media (max-width:768px) {
        .container {padding-top: 2px !important;margin-top:1rem !important}
        .fixed-top{position: unset}
    }
</style>

<?php
    $currentUser=Auth::user();
    //dd(Auth::user());
?>
@include('frontend.layouts.modal_city')
<header class="navbar navbar-expand-lg navbar-light  fixed-top pt-lg-0 flex-column" data-scroll-header>
    <div class="container-fluid bg-secondary d-none d-lg-block">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between gap-2 py-2">
                    <div class="d-flex gap-5">
                        <a href="/rental" class="text-dark d-flex gap-2 align-items-center fs-sm">
                            <span><i class="fi-billboard-house"></i></span>
                            <span>{{ l('اجاره کوتاه مدت و روزانه') }}</span>
                        </a>
                        <div class="text-dark d-flex gap-2 align-items-center fs-sm">
                            <!--span><i class="fi-books"></i></span-->
                            <a href="/" class="text-dark d-flex gap-2 align-items-center fs-sm text-decoration-none">
                            <span><i class="fi-house-chosen"></i></span>
                                <span>{{ l('خرید و فروش و اجاره در گیلان') }}</span>
                            </a>
                        </div>

                    </div>
                    <ul class="nav flex-row  gap-3">
                        <li class="nav-item mb-2 fs-5 ">
                                        <a class="nav-link p-0 fw-normal opacity-80 text-accent" aria-label="instagram" href="https://www.instagram.com/gilandmelk_">
                                            <i class="fi-instagram"></i>
                                        </a>
                        </li>
                        <li class="nav-item mb-2 fs-5">
                                        <a class="nav-link p-0 fw-normal opacity-80 text-info" rel="nofollow" aria-label="telegram" href="https://t.me/gilandmelk">
                                            <i class="fi-telegram-circle"></i>
                                        </a>
                        </li>
                        <li class="nav-item mb-2 fs-5">
                                        <a class="nav-link p-0 fw-normal opacity-80 text-primary" rel="nofollow" aria-label="whatsapp" href="https://web.whatsapp.com/send?phone=09129406124">
                                            <i class="fi-whatsapp"></i>
                                        </a>
                        </li>
                        <li class="nav-item mb-2 fs-5">
                                        <a class="nav-link p-0 fw-normal opacity-80" rel="nofollow" aria-label="youtube" href="javascript:void(0)" style="width: 21px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3584.55 3673.6">
                                            <g id="Isolation_Mode" data-name="Isolation Mode">
                                                <path d="M1071.43,2.75H2607.66C3171,2.75,3631.82,462.91,3631.82,1026.2v493.93c-505,227-1014.43,1348.12-1756.93,1104.51-61.16,43.46-202.11,222.55-212,358.43-257.11-34.24-553.52-328.88-517.95-646.62C717,2026.91,1070.39,1455.5,1409.74,1225.51c727.32-492.94,1737.05-69,1175.39,283.45-341.52,214.31-1071.84,355.88-995.91-170.24-200.34,57.78-328.58,431.34-87.37,626-223.45,219.53-180.49,623.07,58.36,755.57,241.56-625.87,1082.31-544.08,1422-1291.2,255.57-562-123.34-1202.37-880.91-1104C1529.56,399.34,993.64,881.63,725.62,1453.64,453.68,2034,494.15,2811.15,1052.55,3202.82c657.15,460.92,1356.78,34.13,1780.52-523.68,249.77-328.78,468-693,798.75-903.37v875.72c0,563.28-460.88,1024.86-1024.16,1024.86H1071.43c-563.29,0-1024.16-460.87-1024.16-1024.16V1026.9C47.27,463.61,508.14,2.74,1071.43,2.74Z" transform="translate(-47.27 -2.74)" fill="#f5a300" fill-rule="evenodd"></path>
                                             </g>
                                             </svg>


                                        </a>
                        </li>
                    </ul>
                    <ul class="nav flex-row  gap-3">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLang" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(Session::get(\'locale\', config(\'app.locale\')) == \'fa\')
                                🇮🇷 فارسی
                                @elseif(Session::get(\'locale\', config(\'app.locale\')) == \'ar\')
                                🇦🇪 العربية
                                @else
                                🇬🇧 English
                                @endif
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownLang">
                                <li><a class="dropdown-item" href="{{ route(\'lang.switch\', [\'locale\' => \'fa\']) }}">{{ l('🇮🇷 فارسی') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route(\'lang.switch\', [\'locale\' => \'ar\']) }}">{{ l('🇦🇪 العربية') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route(\'lang.switch\', [\'locale\' => \'en\']) }}">🇬🇧 English</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
    </div>
    <div class="container gap-1 pt-2 pb-3 border-bottom" style="margin-top: 0 !important;">

        <div class="d-flex flex-column flex-lg-row align-items-center">
            <a href="/" class="navbar-brand m-0 ms-xl-4 logo" style="color:#3a4936">
                <img src="/img/site2/logo.png" style="height: 50px" alt="{{ss(\'SITE_NAME\')}}">
            </a>
            <a href="/" class="navbar-brand m-0 ms-xl-4 logo logo-name" style="color:#3a4936">
                {{ss(\'SITE_NAME\')}}
            </a>
        </div>
        <a style="color:red;font-weight:bolder" class="nav-link align-items-center border-end-lg px-2 pe-lg-4 ms-auto d-none d-lg-block" href="tel:09133386608" aria-expanded="false"> 09133386608
        </a>

        <a style="color:red;font-weight:bolder" class="nav-link align-items-center border-end-lg px-2 pe-lg-4 ms-auto d-none d-lg-block" href="tel:09129406124" aria-expanded="false"> 09129406124
        </a>
        <div class="d-flex align-items-center flex-column d-lg-none nav-link align-items-center p-0">
            <a style="color:red;font-weight:bolder" class="nav-link align-items-center border-end-lg p-1 pe-lg-4 ms-auto " href="tel:09133386608" aria-expanded="false"> 09133386608
            </a>

            <a style="color:red;font-weight:bolder" class="nav-link align-items-center border-end-lg p-1 pe-lg-4 ms-auto " href="tel:09129406124" aria-expanded="false"> 09129406124
            </a>
        </div>

        @if(empty($currentUser))
        <a class="btn btn-primary d-lg-none order-lg-3" href="/login">
            <i class="fi-user me-2"></i>{{ l('ورود') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @else
        <button class="navbar-toggler  " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <img class="rounded-circle" src="{{!empty($currentUser)?$currentUser->photo():\'\'}}" width="40" alt="{{!empty($currentUser)?$currentUser->fullname():\'\'}}">
        </button>
        @endif

        <?php
        $listArray = [];
        if (!empty($currentUser)) {
            $listArray = json_decode(Auth::user()->role_ids);
        }
        ?>
        <a class="btn btn-primary btn-sm ms-2 order-lg-3 d-none d-lg-block" href="/add"><i class="fi-plus me-2"></i>{{ l('ثبت رایگان ملک') }}</a>
        <a class="btn btn-primary btn-sm ms-2 d-none order-lg-3  d-lg-block" href="/customers/create"><i class="fi-plus me-2"></i>{{ l('ثبت خریدار') }}</a>
        <a class="btn btn-primary btn-sm ms-2 d-none order-lg-3  d-lg-block" href="/rental/estate/create"><i class="fi-plus me-2"></i>{{ l('ثبت اقامتگاه') }}</a>

        @if(empty($currentUser))
        <a class="btn btn-sm text-primary d-none d-lg-block order-lg-3" href="/login">
            <i class="fi-user me-2"></i>{{ l('ورود') }}
        </a>
        @else
                            <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle py-0 text-gold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fi-globe me-1"></i> {{ strtoupper(session('locale', app()->getLocale())) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="/lang/en">🇬🇧 English</a></li>
                            <li><a class="dropdown-item" href="/lang/ar">🇦🇪 العربية</a></li>
                            <li><a class="dropdown-item" href="/lang/fa">🇮🇷 فارسی</a></li>
                        </ul>
                    </div>
                                        </div>
                                    </li>
                                    @endif
                                    @if(!empty($currentUser) && $currentUser->isExpert())
                                    <li class="nav-item d-lg-none">
                                        <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 border-0" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fi-building opacity-60 me-2 "></i>
                                            <span class="ms-1  d-sm-inline">{{ l('مدیریت مشتریان') }}</span>
                                            <i class="fi-chevron-down opacity-60  me-auto"></i>
                                        </a>
                                        <div class="collapse" id="collapseExample">
                                            <div class="card card-body shadow-none mb-3 px-5 py-1">
                                                <ul class=" nav flex-column ms-1">
                                                    <li class="w-100">
                                                        <a class="nav-link px-0 {{$menu==3?\'active\':\'\'}}" href="/customer">
                                                            <i class="fi-building opacity-60 me-2"></i>{{l(\'لیست مشتریان\')}}
                                                        </a>
                                                    </li>
                                                    <li class="w-100">
                                                        <a class="nav-link px-0 {{$menu==4?\'active\':\'\'}}" href="/customers/create">
                                                            <i class="fi-check opacity-60 me-2"></i>{{l(\'ثبت مشتری\')}}
                                                        </a>
                                                    </li>

                                                    @if(!empty($currentUser) && $currentUser->isExpert())
                                                    @if(ss(\'SITE_ID\') == 3 || ss(\'SITE_ID\') == 5 || ss(\'SITE_ID\') == 2)
                                                    <li class="w-100">
                                                        <a href="/profile/operationCustomer"  class="nav-link px-0 {{$menu==17?\'active\':\'\'}}">
                                                            <i class="fa fa-home opacity-60 me-2"></i> {{ l('عملکرد مشتریان') }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @endif
                                                </ul>

                                            </div>
                                        </div>
                                    </li>
                                    @endif

                                    @if(!empty($currentUser) && $currentUser->isExpert())
                                    @if(ss(\'SITE_ID\') == 3 || ss(\'SITE_ID\') == 5)
                                    <li class="nav-item d-lg-none">
                                        <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 border-0" data-bs-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample4">
                                            <i class="fi-building opacity-60 me-2 "></i>
                                            <span class="ms-1  d-sm-inline">{{ l('مدیریت عملکرد مشاور') }}</span>
                                            <i class="fi-chevron-down opacity-60  me-auto"></i>
                                        </a>
                                        <div class="collapse" id="collapseExample">
                                            <div class="card card-body shadow-none mb-3 px-5 py-1">
                                                <ul class=" nav flex-column ms-1">
                                                    <li class="w-100">
                                                        <a href="/profile/relationEstateCustomer"  class="nav-link px-0 {{$menu==10?\'active\':\'\'}}">
                                                            <i class="fa fa-building opacity-60 me-2"></i> {{ l('مشتریان و املاک متناسب') }}
                                                        </a>
                                                    </li>
                                                    <li class="w-100">
                                                        <a href="/profile/report" class="nav-link px-0 {{$menu==11?\'active\':\'\'}}">
                                                            <i class="fa fa-bar-chart opacity-60 me-2"></i> {{ l('آمار کارشناسان') }}
                                                        </a>
                                                    </li>
                                                    <li class="w-100">
                                                        <a href="/task" class="nav-link px-0" {{$menu==20?\'active\':\'\'}}">
                                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('تقویم کاری') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    @endif
                                    @if(ss(\'SITE_ID\') == 2)
                                    <li class="nav-item d-lg-none">
                                        <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 border-0" data-bs-toggle="collapse" href="#collapseExample14" role="button" aria-expanded="false" aria-controls="collapseExample14">
                                            <i class="fi-building opacity-60 me-2 "></i>
                                            <span class="ms-1  d-sm-inline">{{ l('اجاره کوتاه مدت') }}</span>
                                            <i class="fi-chevron-down opacity-60  me-auto"></i>
                                        </a>
                                        <div class="collapse" id="collapseExample14">
                                            <div class="card card-body shadow-none mb-3 px-5 py-1">
                                                <ul class=" nav flex-column ms-1">
                                                    <li class="w-100">
                                                        <a class="nav-link px-0 {{$menu==\'rentallists\'?\'active\':\'\'}}" href="/rental/estates">
                                                            <i class="fi-building opacity-60 me-2"></i>{{ l('لیست اقامتگاه‌ها') }}
                                                        </a>
                                                    </li>
                                                    <li class="w-100">
                                                        <a class="nav-link px-0 {{$menu==\'rentalcreate\'?\'active\':\'\'}}" href="/rental/estate/create">
                                                            <i class="fi-building opacity-60 me-2"></i>{{ l('ثبت اقامتگاه‌ها') }}
                                                        </a>
                                                    </li>
                                                    @if(!empty($currentUser) && $currentUser->isAdmin())
                                                    <li class="w-100">
                                                        <a class="nav-link px-0 {{$menu==\'rentalusers\'?\'active\':\'\'}}" href="/rental/users">
                                                            <i class="fi-check opacity-60 me-2"></i>{{ l('لیست موجرین') }}
                                                        </a>
                                                    </li>
                                                    <li class="w-100">
                                                        <a class="nav-link px-0 {{$menu==\'rentaladduser\'?\'active\':\'\'}}" href="/rental/users/create">
                                                            <i class="fi-check opacity-60 me-2"></i>{{ l('اضافه کردن موجر') }}
                                                        </a>
                                                    </li>
                                                    <li class="w-100">
                                                        <a class="nav-link px-0 {{$menu==\'rentalcustomers\'?\'active\':\'\'}}" href="/rental/customers">
                                                            <i class="fi-check opacity-60 me-2"></i> {{ l('تقاضاهای اجاره') }}
                                                        </a>
                                                    </li>
                                                    <li class="w-100">
                                                        <a class="nav-link px-0 {{$menu==\'rentaladdcustomer\'?\'active\':\'\'}}" href="/rental/customer/create">
                                                            <i class="fi-check opacity-60 me-2"></i> {{ l('ثبت تقاضا') }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    @endif

                                    @if(!empty($currentUser) && $currentUser->isAdmin())
                                    <li class="nav-item d-lg-none">
                                        <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 border-0" data-bs-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                                            <i class="fi-building opacity-60 me-2 "></i>
                                            <span class="ms-1  d-sm-inline">{{ l('مدیریت سیستم') }}</span>
                                            <i class="fi-chevron-down opacity-60  me-auto"></i>
                                        </a>
                                        <div class="collapse" id="collapseExample3">
                                            <div class="card card-body shadow-none mb-3 px-5 py-1">
                                                <ul class=" nav flex-column ms-1">
                                                    <li class="w-100">
                                                        <a class="nav-link px-0 {{$menu==14?\'active\':\'\'}}" href="/profile/sms">
                                                            <i class="fa fa-user  opacity-60 me-2"></i> {{ l('پیامکهای ارسالی و دریافتی') }}
                                                        </a>
                                                    </li>

                                                    @if(ss(\'SITE_ID\') == 3)
                                                    <li class="w-100">
                                                        <a class="nav-link px-0" href="/profile/branches">
                                                            <i class="fa fa-sitemap  opacity-60 me-2"></i>
                                                            {{ l('شعبه ها') }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                    <li class="w-100">
                                                        <a href="/profile/settings" class="nav-link px-0">
                                                            <i class="fa fa-gears opacity-60 me-2"></i>{{l(\'تنظیمات\')}}
                                                        </a>
                                                    </li>
                                                    @if(env(\'COUNTRY\') != \'UAE\')
                                                    @if(ss(\'SITE_ID\') != 2)
                                                    <li class="w-100">
                                                        <a href="/profile/province" class="nav-link px-0">
                                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('استان ها') }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                    <li class="w-100">
                                                        <a href="/profile/city" class="nav-link px-0">
                                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('شهرها') }}
                                                        </a>
                                                    </li>
                                                    <li class="w-100">
                                                        <a href="/profile/district" class="nav-link px-0">
                                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('محله ها') }}
                                                        </a>
                                                    </li>

                                                    @if(ss(\'SITE_ID\') == \'3\' || ss(\'SITE_ID\') == \'5\')
                                                    <li class="w-100">
                                                        <a href="/profile/street" class="nav-link px-0">
                                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('زیرمحلات') }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @endif
                                                    <li class="w-100">
                                                        <a class="nav-link px-0" href="/profile/users"><i class="fa fa-user  opacity-60 me-2"></i>{{ l('اعضای سیستم') }}</a>
                                                    </li>
                                                    <li class="w-100">
                                                        <a href="/profile/posts" class="nav-link px-0">
                                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('مدیریت مطالب') }}
                                                        </a>
                                                    </li>
                                                    @if(ss(\'SITE_ID\') == 5 || ss(\'SITE_ID\') == 3)
                                                    <li class="w-100">
                                                        <a href="/profile/contract" class="nav-link px-0">
                                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('مدیریت قولنامه') }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    @endif

                                    @if(!empty($currentUser) && $currentUser->isExpert())
                                    <li class="nav-item d-lg-none">
                                        <a class="nav-link {{$menu==6?\'active\':\'\'}}" href="/profile/info_v2">
                                            <i class="fi-edit opacity-60 me-2"></i>{{l(\'ویرایش مشخصات\')}}
                                        </a>
                                    </li>

                                    @endif
                                    @if(!empty($currentUser))
                                    <li class="nav-item d-lg-none">
                                        <a class="nav-link" href="/admin/logout"><i class="fi-logout opacity-60 me-2"></i>{{l(\'خروج\')}}</a>
                                    </li>
                                    @endif
                            </ul>
            </div>
        </div>
        <div class="collapse navbar-collapse order-lg-2" id="navbarNav2">

            <ul class="navbar-nav navbar-nav-scroll m-0" style="max-height: 35rem;">

                <li class="nav-item dropdown d-lg-none d-flex align-items-center my-2 gap-2 py-1">
                    <div class="" style="width:48px">
                        <img class="rounded-circle" src="{{ !empty($currentUser) ? $currentUser->photo() : \'\' }}" alt="{{ !empty($currentUser) ? $currentUser->fullname() : \'\' }}" style="height: 48px">
                    </div>
                    <div class="pt-md-2 pt-lg-0 pe-md-0 ps-lg-3">
                        <h2 class="fs-lg mb-0">{{ !empty($currentUser) ? $currentUser->fullname() : \'\' }}</h2>
                        <span class="star-rating">
                         <?php
                            if(!empty(Auth::user())){
                            $listArray = json_decode(Auth::user()->role_ids);
                            if(ss(\'SITE_ID\') == 3 && $IpLogin == null){
                                $listArray = null;
                            }
                            ?>
                            @if(!empty(Auth::user()) && Auth::user()->isExpert())
                            {{l(\'کارشناس\')}}
                            @else
                            {{l(\'کاربر عادی\')}}
                            @endif
                        <?php } ?>
                        </span>
                    </div>
                </li>
                <li class="nav-item d-lg-none"><a class="nav-link" href="/customers/create"><i class="fi-plus me-2"></i>{{ l('ثبت خریدار') }}</a></li>
                <li class="nav-item d-lg-none"><a class="nav-link" href="/add"><i class="fi-plus me-2"></i>{{ l('ثبت رایگان ملک') }}</a></li>
                <li class="nav-item py-2 me-lg-2 d-lg-none"><a class="nav-link align-items-center border-end-lg py-1 pe-lg-4" href="/cities" aria-expanded="false">
                <i class="fi-search me-2"></i>
                {{ l('ﺟﺴﺘﺠﻮی ملک') }}
                </a></li>
                <li class="nav-item dropdown d-lg-none px-0">

                    <a class="dropdown-item d-flex align-items-center gap-2" href="/dashboard">
                        <i class="fi-home opacity-60 me-2"></i>
                            {{ l('داشبورد من') }}
                        </a>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="/profile/my-estate-ads">
                            <i class="fi-home opacity-60 me-2"></i>
                            {{ l('لیست املاک') }}
                        </a>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="/customer">
                            <i class="fi-home opacity-60 me-2"></i>
                            {{ l('لیست مشتریان') }}
                        </a>




                        <a class="dropdown-item d-flex align-items-center gap-2" href="/profile/info_v2">
                            <i class="fi-user opacity-60 me-2"></i>
                            {{ l('ویرایش مشخصات') }}
                        </a>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="/favorite">
                            <i class="fi-heart opacity-60 me-2"></i>
                            {{ l('موردعلاقه ها') }}

                        </a>

                        <a class="dropdown-item d-flex align-items-center gap-2" href="/logout">
                            <i class="fi-logout opacity-60 me-2"></i>
                            {{ l('خروج') }}
                        </a>

                </li>


            </ul>
        </div>
    </header>


<script>
    var str = "";
    $(document).ready(function(){

    })
        // get province and cities
        var city_data = <?php echo json_encode($cityData) ?>;
        $(document).ready(function() {
            $(\".select_city\").on(\'click\',function(){
                // var hhhh = $(this).val();
                // console.log(hhhh);
                alert(\'ttt\')
            })

            $(\"#cityListSearch\").on(\"keyup\", function() {
                var searchValue = $(this).val();

                $(\"#province1 .item-name\").filter(function() {
                    // $(this).parent().toggle($(this).text().indexOf(value) > -1);
                    if (!($(this).text().indexOf(searchValue) > -1)) {
                        $(this).parent().attr(\'style\', \'display :none !important\');
                    } else {
                        $(this).parent().removeAttr(\'style\');
                    }
                });
            });

            $(document).on(\"click\", \".province1\", function() {
                var data = $.parseJSON(city_data); //$.parseJSON($(\"#cityData\").val()) ;
                for (var i = 0; i < data.length; i++) {
                    if (data[i].id == $(this).attr(\'value\')) {
                        $(\"#returnpr\").addClass(\'d-block\').removeClass(\'d-none\');
                        str = \'\';
                        var province = data[i];

                        for (var j = 0; j < province.cities.length; j++) {
                            //str += \'<div id=\"' + province.cities[j].id + \'\" data-city=\"' + province.cities[j].name_en + \'\" class=\"border-bottom d-flex justify-content-around py-3 province1 city-item\"><span class=\"item-name\" style=\"width:90%;display:inline;cursor:pointer\">\' + province.cities[j].name + \'</span></div>\';
                            //old str += \'<div class=\"form-check select_city\" id=\"' + province.cities[j].id + \'\" data-city=\"' + province.cities[j].name_en + \'\" style=\"border-bottom: 1px solid #f9f2f2;padding: 8px 2rem;\"><input class=\"form-check-input\" type=\"checkbox\" value=\"\" id=\"' + province.cities[j].name_en + \'\"><label class=\"form-check-label\" for=\"' + province.cities[j].name_en + \'\">\' + province.cities[j].name + \'</label></div>\';
                        }

                    }
                }
                $(\"#province1\").html(str)
            });

            $(\"#returnpr\").click(function() {
                $(\"#returnpr\").addClass(\'d-none\').removeClass(\'d-block\');
                showprovince()
            });

        });

        showprovince();


        function showprovince() {

            var str = \'\';
            var data = $.parseJSON(city_data); //$.parseJSON($(\"#cityData\").val()) ;
            console.log(data);
            for (var i = 0; i < data.length; i++) {
                str += \'<div onclick=setProvince(\"' + data[i].name_en + \'\") value=\"' + data[i].id + \'\" class=\"border-bottom d-flex justify-content-around py-3 province11\"><span  class=\"item-name\" style=\"width:80%;display:inline;cursor:pointer\"><a href=\"/c/\'+data[i].name_en+\'\">\' + data[i].name + \'</a></span><i class=\"far fa-chevron-left\" aria-hidden=\"true\" style=\"display:inline\"></i></div>\'
            }
            $(\"#province1\").html(str);
        }
</script>
