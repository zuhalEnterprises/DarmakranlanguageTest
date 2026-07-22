<style>
    .nav-item .select2-selection.select2-selection--single {
        border: 1px solid transparent !important;
    }

    .nav-item .select2-selection__arrow {
        display: none
    }

    .search-container {
      position: relative;
    }

    #search-btn {
      right: 30px;
    }

    #search-box {
        display: none;
    }

    #search-input {
    padding-right: 40px;
    }
</style>

<?php

    $currentUser=Auth::user();
    //dd(Auth::user());
?>
@include('frontend.layouts.modal_city')
<header class="navbar navbar-expand-lg navbar-light bg-light fixed-top border-bottom flex-column py-0" data-scroll-header>
    <div class="container-fluid bg-secondary d-none d-lg-block">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between gap-2 py-2">
                <div class="d-flex gap-2">
                    <a href="#" class="btn  btn-xs d-flex gap-2 align-items-center fs-sm fs-xs">
                        <span><i class="fi-real-estate-house"></i></span>
                        {{ l('املاک فروشی') }}
                    </a>
                    <a href="#" class="btn  btn-xs d-flex gap-2 align-items-center fs-sm fs-xs">
                        <span><i class="fi-apartment"></i></span>
                        {{ l('املاک اجاره ای') }}
                    </a>
                    <a href="#" class="btn  btn-xs d-flex gap-2 align-items-center fs-sm fs-xs">
                        <span><i class="fi-shop"></i></span>
                        {{ l('مشتریان خرید ملک') }}
                    </a>
                    <a href="#" class="btn  btn-xs d-flex gap-2 align-items-center fs-sm fs-xs">
                        <span><i class="fi-rent"></i></span>
                        {{ l('مشتریان اجاره ملک') }}
                    </a>
                </div>
                <div class="d-flex gap-2">
                    <a href="#" class="btn  btn-xs d-flex gap-2 align-items-center fs-sm fs-xs">
                        <span><i class="fi-users"></i></span>
                        {{ l('فهرست مشاوران') }}
                    </a>

                    <a href="#" class="btn  btn-xs d-flex gap-2 align-items-center fs-sm fs-xs">
                        <span><i class="fi-real-estate-buy"></i></span>
                        {{ l('فهرست آژانس ها') }}
                    </a>
                    <a href="/account/signup" class="btn  btn-xs d-flex gap-2 align-items-center fs-sm fs-xs">
                        <span><i class="fi-user-plus"></i></span>
                        {{ l('عضویت مشاورین املاک') }}
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="container py-2">

        <a href="/" class="ms-lg-5">
            <img src="/img/site7/logo.png" style="height: 50px">
        </a>
        <a class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#provinceModal" >
            <i class="fi-map-pin"></i>
            <span id="selectCityButton">{{ l('قم') }}</span>
        </a>
        <!-- <div class="search-container order-lg-3 d-lg-none">
            <button id="search-btn" class="btn btn-sm"><i class="fi-search"></i></button>
        </div> -->

        @if(empty($currentUser))

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @else
        <button class="navbar-toggler  " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @endif


        <!--a href="#" data-bs-toggle="modal" data-bs-target="#modalCity" class="text-decoration-none d-flex align-items-center gap-2">
        {{$defaultCity->{{ l('name ?? \'قم\'}}') }}
            <i class="icon-map-header fal fa-map-marker-alt"></i><span class="kt-text-truncate no-pointer-event location-span">
        </a-->
        <!-- <button class="kt-button kt-button--inlined kt-nav-button d-sm-inline-flex gap-1 mx-auto" type="button" data-target="#exampleModal" data-toggle="modal" id="modalActivate">-->





        <?php
        $listArray = [];
        if (!empty($currentUser)) {
            $listArray = json_decode(Auth::user()->role_ids);
        }
        ?>
       <!--  <a class="btn btn-primary btn-sm ms-2 order-lg-3 d-none d-lg-block" href="/add"><i class="fi-plus me-2"></i>{{ l('ثبت رایگان ملک') }}</a>
        <a class="btn btn-primary btn-sm ms-2 d-none order-lg-3  d-lg-block" href="/customers/create"><i class="fi-plus me-2"></i>{{ l('ثبت خریدار') }}</a> -->

        @if(empty($currentUser))

        <a class="btn btn-sm btn-primary text-white d-none d-lg-block order-lg-3" href="/login">
            <i class="fi-user me-2"></i>{{ l('ورود') }}
        </a>

        @else

        <a class="p-3  order-3 rounded-4 align-items-center justify-content-center me-2 d-none d-lg-flex" style="width: 40px; height:40px;background:#dadada;" href="">
            <i class="fi-heart text-dark"></i>
        </a>
        <a class="p-3  order-3 rounded-4 align-items-center justify-content-center me-2 d-none d-lg-flex" style                            <div class="dropdown">
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
                                                        <a class="nav-link px-0 {{$menu==3?'active':''}}" href="/customer">
                                                            <i class="fi-building opacity-60 me-2"></i>{{l('لیست مشتریان')}}
                                                        </a>
                                                    </li>
                                                    <li class="w-100">
                                                        <a class="nav-link px-0 {{$menu==4?'active':''}}" href="/customers/create">
                                                            <i class="fi-check opacity-60 me-2"></i>{{l('ثبت مشتری')}}
                                                        </a>
                                                    </li>

                                                    @if(!empty($currentUser) && $currentUser->isExpert())
                                                    @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2)
                                                    <li class="w-100">
                                                        <a href="/profile/operationCustomer"  class="nav-link px-0 {{$menu==17?'active':''}}">
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
                                    @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 5)
                                    <li class="nav-item d-lg-none">
                                        <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 border-0" data-bs-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample4">
                                            <i class="fi-building opacity-60 me-2 "></i>
                                            <span class="ms-1  d-sm-inline">{{ l('مدیریت عملکرد مشاور') }}</span>
                                            <i class="fi-chevron-down opacity-60  me-auto"></i>
                                        </a>
                                        <div class="collapse" id="collapseExample4">
                                            <div class="card card-body shadow-none mb-3 px-5 py-1">
                                                <ul class=" nav flex-column ms-1">
                                                    <li class="w-100">
                                                    <a href="/profile/relationEstateCustomer"  class="nav-link px-0 {{$menu==10?'active':''}}">
                                                        <i class="fa fa-building opacity-60 me-2"></i> {{ l('مشتریان و املاک متناسب') }}
                                                    </a>
                                                    </li>
                                                    <li class="w-100">
                                                    <a href="/profile/report" class="nav-link px-0 {{$menu==11?'active':''}}">
                                                        <i class="fa fa-bar-chart opacity-60 me-2"></i> {{ l('آمار کارشناسان') }}
                                                    </a>
                                                    </li>
                                                    <li class="w-100">
                                                    <a href="/task" class="nav-link px-0" {{$menu==20?'active':''}}">
                                                        <i class="fa fa-city opacity-60 me-2"></i> {{ l('تقویم کاری') }}
                                                    </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
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
                                                        <a class="nav-link px-0 {{$menu==14?'active':''}}" href="/profile/sms">
                                                            <i class="fa fa-user  opacity-60 me-2"></i> {{ l('پیامکهای ارسالی و دریافتی') }}
                                                        </a>
                                                    </li>

                                                    @if(ss('SITE_ID') == 3)
                                                    <li class="w-100">
                                                        <a class="nav-link px-0" href="/profile/branches">
                                                            <i class="fa fa-sitemap  opacity-60 me-2"></i>
                                                            {{ l('شعبه ها') }}
                                                        </a>
                                                    </li>
                                                    @endif
                                                    <li class="w-100">
                                                        <a href="/profile/settings" class="nav-link px-0">
                                                            <i class="fa fa-gears opacity-60 me-2"></i>{{l('تنظیمات')}}
                                                        </a>
                                                    </li>
                                                    @if(env('COUNTRY') != 'UAE')
                                                    @if(ss('SITE_ID') != 2)
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

                                                    @if(ss('SITE_ID') == '3' || ss('SITE_ID') == '5')
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
                                                    @if(ss('SITE_ID') == 5 || ss('SITE_ID') == 3)
                                                    <li class="w-100">
                                                        <a href="/profile/contract" class="nav-link px-0">
                                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('مدیریت قرارداد') }}
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
                                        <a class="nav-link {{$menu==6?'active':''}}" href="/profile/info_v2">
                                            <i class="fi-edit opacity-60 me-2"></i>{{l('ویرایش مشخصات')}}
                                        </a>
                                    </li>
                                    <li class="nav-item d-lg-none">
                                        <a class="nav-link" href="/admin/logout"><i class="fi-logout opacity-60 me-2"></i>{{l('خروج')}}</a>
                                    </li>
                                    @endif
                        </ul>
            </div>
        </div>
        <div class="collapse navbar-collapse order-lg-2" id="navbarNav2">
            <ul class="navbar-nav navbar-nav-scroll m-0" style="max-height: 35rem;">
                <li class="nav-item dropdown d-lg-none d-flex align-items-center my-2 gap-2 py-1">
                    <div class="" style="width:48px">
                        <img class="rounded-circle" src="{{ !empty($currentUser) ? $currentUser->photo() : '' }}" alt="{{ !empty($currentUser) ? $currentUser->fullname() : '' }}">
                    </div>
                    <div class="pt-md-2 pt-lg-0 pe-md-0 ps-lg-3">
                        <h2 class="fs-lg mb-0">{{ !empty($currentUser) ? $currentUser->fullname() : '' }}</h2>
                        <span class="star-rating">
                         <?php
                            if(!empty(Auth::user())){
                            $listArray = json_decode(Auth::user()->role_ids);
                            if(ss('SITE_ID') == 3 && $IpLogin == null){
                                $listArray = null;
                            }
                            ?>
                            @if(!empty(Auth::user()) && Auth::user()->isExpert())
                            {{l('کارشناس')}}
                            @else
                            {{l('کاربر عادی')}}
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

                        <a class="dropdown-item d-flex align-items-center gap-2" href="/profile/my-estate-ads">
                            <i class="fi-home opacity-60 me-2"></i>
                            {{ l('لیست املاک') }}
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
<div class="bg-danger fixed-top p-3 bg-white w-100" id="search-box">
     <div class="d-flex align-items-center justify-content-between" >
        <input type="text" class="input-group px-3 py-1"  id="search-input" placeholder="{{ l('جستجو...') }}">
        <button class="btn" id="close-btn" ><i class="fi-x"></i></button>
    </div>
</div>

<!-- مدال استان‌ها و شهرها -->
<div class="modal fade" id="provinceModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- عنوان مدال -->
                <div class="modal-header">
                    <h4 class="modal-title fs-6" id="modalTitle">{{ l('لیست استان‌ها') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- محتوای مدال -->
                <div class="modal-body">
                    <!-- فیلد جستجو -->
                    <input type="text" class="form-control mb-3" id="searchInput" placeholder="{{ l('جستجو...') }}">
                    <ul id="province-list" class="list-group">
                        <li class="list-group-item province">{{ l('تهران') }}</li>
                        <li class="list-group-item province">{{ l('قم') }}</li>
                        <li class="list-group-item province">{{ l('اصفهان') }}</li>
                        <!-- اینجا می‌توانید استان‌های دیگر را اضافه کنید -->
                    </ul>
                    <div id="city-list" style="display:none;">
                        <!-- اینجا چک باکس‌های شهرها نمایش داده می‌شود -->
                    </div>
                    <div id="selected-cities" class="mt-3">
                        <h5 class="fs-base">{{ l('انتخاب شهر:') }}</h5>
                        <ul id="selected-cities-list" class="d-flex list-unstyled gap-2 flex-wrap"></ul>
                    </div>
                </div>
                <!-- دکمه بروزرسانی مدال -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="backButton" style="display:none;">{{ l('برگشت') }}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ l('بستن') }}</button>
                    <button type="button" class="btn btn-primary" id="updateSelectCityButton">{{ l('انتخاب') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () { // تعریف لیست شهرها برای هر استان var cities = { l("تهران"): ["تهران", l("پرند"), l("شهریار")], l("قم"): ["قم", l("کهک"), l("جعفریه")], l("اصفهان"): ["کاشان", l("شهررضا"), l("اصفهان")] // اینجا می‌توانید شهرهای استان‌های دیگر را اضافه کنید }; // متغیر برای ذخیره شهرهای انتخاب شده var selectedCities = []; var temporarySelectedCities = []; // وقتی روی یک استان کلیک می‌کنید $('#province-list').on('click', '.province', function () { var province = $(this).text().trim(); var citiesOfProvince = cities[province]; $('#modalTitle').text(province); $('#province-list').hide(); $('#city-list').empty(); // شهرهای مربوط به استان انتخاب شده را نمایش می‌دهیم $.each(citiesOfProvince, function (index, city) { var checked = selectedCities.includes(city) ? 'checked' : ''; $('#city-list').append('<div class="form-check"><input class="form-check-input city-checkbox" type="checkbox" value="' + city + '" id="' + city + '" ' + checked + '><label class="form-check-label" for="' + city + '">' + city + '</label></div>');
                });

                $('#city-list').show();
                // $('#selected-cities').hide();
                $('#backButton').show();
                // $('#selectCityButton').hide();
            });

            // تعریف تابع برای بروزرسانی متن دکمه بیرون از مدال
            function updateSelectCityButton() {
                if (selectedCities.length > 0) { if (selectedCities.length === 1) { $('#selectCityButton').text(selectedCities); } else { $('#selectCityButton').text(selectedCities.length + ' شهر'); } } else { $('#selectCityButton').text('انتخاب شهر'); } } // تابع برای به روزرسانی لیست شهرهای انتخاب شده در مدال function updateSelectedCitiesList() { $('#selected-cities-list').empty(); $.each(selectedCities, function (index, city) { $('#selected-cities-list').append('<li class="d-flex align-items-center gap-1 border rounded-4 px-2 border-danger">' + city + ' <div class="text-danger delete-city" data-city="' + city + '"><span class="fi-x"></span></div></li>');
                });
            }



            // وقتی روی دکمه بروزرسانی مدال کلیک می‌شود
            $('#updateSelectCityButton').on('click', function () {
                updateSelectCityButton();
                $('#provinceModal').modal('hide');
            });

            // وقتی روی یک چک باکس شهر کلیک می‌کنید
            $('#city-list').on('click', '.city-checkbox', function () {
                var city = $(this).val();
                if ($(this).prop('checked')) {
                    // اگر چک باکس انتخاب شده باشد، شهر را به آرایه selectedCities اضافه کنید
                    selectedCities.push(city);
                } else {
                    // اگر چک باکس انتخاب نشده باشد، شهر را از آرایه selectedCities حذف کنید
                    var index = selectedCities.indexOf(city);
                    if (index !== -1) {
                        selectedCities.splice(index, 1);
                    }
                }

                // به روزرسانی لیست شهرهای انتخاب شده
                updateSelectedCitiesList();
            });

            // جستجو در لیست استان‌ها و شهرها
            $('#searchInput').on('input', function () {
                var searchText = $(this).val().trim().toLowerCase();

                // نمایش تمام المان‌های مخفی شده
                $('#province-list li:hidden').show();
                $('#city-list .form-check:hidden').show();

                $('#province-list li').each(function () {
                    var text = $(this).text().trim().toLowerCase();
                    if (!text.includes(searchText)) {
                        $(this).hide();
                    }
                });

                $('#city-list .form-check').each(function () {
                    var text = $(this).find('label').text().trim().toLowerCase();
                    if (!text.includes(searchText)) {
                        $(this).hide();
                    }
                });
            });

            // وقتی روی دکمه حذف کلیک می‌شود
            $(document).on('click', '.delete-city', function () {
                var cityToRemove = $(this).data('city');
                var index = selectedCities.indexOf(cityToRemove);
                if (index !== -1) {
                    selectedCities.splice(index, 1);
                }
                updateSelectedCitiesList();
                $('#city-list input[value="' + cityToRemove + '"]').prop('checked', false);
            });




            // وقتی مدال باز شد
            $('#provinceModal').on('shown.bs.modal', function () {
                if (selectedCities.length > 0) {
                    $('#selected-cities').show().html('<h5 class="fs-base">{{ l('انتخاب شهر:') }}</h5><ul id="selected-cities-list" class="d-flex flex-wrap list-unstyled gap-2"></ul>');
                    $.each(selectedCities, function (index, city) {
                        $('#selected-cities-list').append('<li class="d-flex align-items-center gap-1 border rounded-4 px-2 border-danger">' + city + ' <div class="text-danger delete-city" data-city="' + city + '"><span class="fi-x"></span></div></li>'); }); } }); // وقتی مدال بسته شده است $('#provinceModal').on('hidden.bs.modal', function () { $('#city-list').empty(); $('#province-list').show(); $('#backButton').hide(); $('#selectCityButton').show(); $('#modalTitle').text('لیست استان‌ها'); $('#searchInput').val(''); }); // وقتی دکمه برگشت کلیک می‌شود $('#backButton').on('click', function () { $('#city-list').hide(); $('#backButton').hide(); $('#selectCityButton').show(); $('#modalTitle').text('لیست استان‌ها'); $('#province-list').show(); }); });
</script>

<script>
    var str = "";
    $(document).ready(function(){

    })
        // get province and cities
        var city_data = <?php echo json_encode($cityData) ?>;
        $(document).ready(function() {
            $('.select_city').on('click',function(){
                // var hhhh = $(this).val();
                // console.log(hhhh);
                alert('ttt')
            })

            $("#cityListSearch").on("keyup", function() {
                var searchValue = $(this).val();

                $("#province1 .item-name").filter(function() {
                    // $(this).parent().toggle($(this).text().indexOf(value) > -1);
                    if (!($(this).text().indexOf(searchValue) > -1)) {
                        $(this).parent().attr('style', 'display :none !important');
                    } else {
                        $(this).parent().removeAttr('style');
                    }
                });
            });

            $(document).on("click", ".province1", function() {
                var data = $.parseJSON(city_data); //$.parseJSON($("#cityData").val()) ;
                for (var i = 0; i < data.length; i++) {
                    if (data[i].id == $(this).attr('value')) {
                        $("#returnpr").addClass('d-block').removeClass('d-none');
                        str = '';
                        var province = data[i];

                        for (var j = 0; j < province.cities.length; j++) {
                            //str += '<div id="' + province.cities[j].id + '" data-city="' + province.cities[j].name_en + '" class="border-bottom d-flex justify-content-around py-3 province1 city-item"><span class="item-name" style="width:90%;display:inline;cursor:pointer">' + province.cities[j].name + '</span></div>';
                            //old str += '<div class="form-check select_city" id="' + province.cities[j].id + '" data-city="' + province.cities[j].name_en + '" style="border-bottom: 1px solid #f9f2f2;padding: 8px 2rem;"><input class="form-check-input" type="checkbox" value="" id="' + province.cities[j].name_en + '"><label class="form-check-label" for="' + province.cities[j].name_en + '">' + province.cities[j].name + '</label></div>';
                        }

                    }
                }
                $("#province1").html(str)
            });

            $("#returnpr").click(function() {
                $("#returnpr").addClass('d-none').removeClass('d-block');
                showprovince()
            });

        });
        showprovince();
        function showprovince() {
            var str = "";
            var data = $.parseJSON(city_data); //$.parseJSON($("#cityData").val()) ;
            console.log(data);
            for (var i = 0; i < data.length; i++) {
                str += '<div onclick=setProvince("' + data[i].name_en + '") value="' + data[i].id + '" class="border-bottom d-flex justify-content-around py-3 province11"><span  class="item-name" style="width:80%;display:inline;cursor:pointer"><a href="/c/'+data[i].name_en+'">' + data[i].name + '</a></span><i class="far fa-chevron-left" aria-hidden="true" style="display:inline"></i></div>'
            }
            $("#province1").html(str);
        }


        $(document).ready(function(){
            $("#search-btn").click(function(){
                $("#search-btn").hide();
                $("#search-box").show();
                // $("#search-input").show().focus();
            });

            $("#close-btn").click(function(){
                // $("#search-input").hide();
                $("#search-box").hide();
                $("#search-btn").show();
            });
        });


</script>
