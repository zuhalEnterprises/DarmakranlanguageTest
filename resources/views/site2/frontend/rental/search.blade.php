@php
$title = "";
if(!empty($_REQUEST['estateTypes'])){
    switch ($_REQUEST['estateTypes'])
    {
        case '1':
            $title=l('آپارتمان');
            break;
        case '2':
            $title=l('ویلایی');
            break;
        case '3':
            $title=l('مغازه');
            break;
        case '4':
            $title=l('زمین');
            break;
        case '5':
            $title=l('صنعتی');
            break;
        case '5':
            $title=l('ساختمان با مستغلات');
            break;
        default:
            break;
    }
}
else {
    $title=l('املاک');
}
if(!empty($_REQUEST['type'])){
    $_REQUEST['type']==1 ? $title.= l('خرید و فروش ') : $title.= l('رهن و اجاره ') ;
}
else {
    $title.= l("املاک") ;
}
if(!empty($_REQUEST['districts'])){
    $title.=l('در')." ".getDistrict($_REQUEST['districts']);
}
else
{
    $title.= l('در شهر ');
}
if(!empty($_REQUEST['city_id'])){
    $title.=" ".getCity($_REQUEST['city_id']);
}
$title="-".$title;
@endphp
@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', ['title' => ss('SITE_NAME') . $title])
@section('head')
    <link href="/frontend/js/modules/leaflet/leaflet.css" rel="stylesheet" type="text/css">
    <link href="/frontend/js/modules/leaflet/markercluster/MarkerCluster.css" rel="stylesheet" type="text/css">
    <link href="/frontend/js/modules/leaflet/leaflet.draw.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" media="screen" href="/vendor/expandable/jquery.expandable.css" />
    <style>
        div.sticky {
            position: -webkit-sticky;
            position: sticky;
            bottom: 0 !important;
            background-color: #fff;
        }
        .to-expand {
            padding-bottom: 50px;
        }
        .hidden {
            display: none
        }
        .text-center {
            text-align: center;
        }
        .px-18px {
            padding-left: 5px;
            padding-right: 5px;
        }
        .input-price:focus {
            outline: none;
        }
        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        }
        .border-gray-400 {
            --tw-border-opacity: 1;
            border-color: rgb(163 163 163 / var(--tw-border-opacity));
        }
        .border-1px {
            border-width: 1px;
        }
        .rounded-25 {
            border-radius: 25px;
        }
        .select2-dropdown {
            z-index: 100000000;
        }
        .justify-between {
            justify-content: space-between;
        }
        .items-center {
            align-items: center;
        }
        .w-full {
            width: 100%;
        }
        .h-59px {
            height: 39px;
        }
        .flex {
            display: flex;
        }
        button,
        [role="button"] {
            cursor: pointer;
        }
        .duration-300 {
            transition-duration: 300ms;
        }
        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(92 92 92 / var(--tw-text-opacity));
        }
        .font-light {
            font-weight: 300;
        }
        .text-right {
            text-align: right;
        }
        .overflow-auto {
            overflow: auto;
        }
        .scroll-p-4 {
            scroll-padding: 1rem;
        }
        .h-260px {
            height: 260px !important;
        }
        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(92 92 92 / var(--tw-text-opacity));
        }
        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }
        .text-right {
            text-align: right;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .h-0 {
            height: 0px;
        }
        .object-cover {
            object-fit: cover;
        }
        .page-loading {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            -webkit-transition: all .4s .2s ease-in-out;
            transition: all .4s .2s ease-in-out;
            background-color: #fff;
            opacity: 0;
            visibility: hidden;
            z-index: 9999;
        }
        .page-loading.active {
            opacity: 1;
            visibility: visible;
        }
        .page-loading-inner {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            text-align: center;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            -webkit-transition: opacity .2s ease-in-out;
            transition: opacity .2s ease-in-out;
            opacity: 0;
        }
        .page-loading.active>.page-loading-inner {
            opacity: 1;
        }
        .page-loading-inner>span {
            display: block;
            font-size: 1rem;
            font-weight: normal;
            color: #666276;
            ;
        }
        .page-spinner {
            display: inline-block;
            width: 2.75rem;
            height: 2.75rem;
            margin-bottom: .75rem;
            vertical-align: text-bottom;
            border: .15em solid #bbb7c5;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: spinner .75s linear infinite;
            animation: spinner .75s linear infinite;
        }
        @-webkit-keyframes spinner {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes spinner {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        .imgestate {
            height: 206px;
            width: 100%
        }
        .range-slider .align-items-center {
            display: none !important
        }
        .noUi-handle-upper .noUi-tooltip {
            bottom: -150% !important;
        }
        .nav-pills .nav-link {
            background: none;
            border: 0;
            border-radius: .1rem;
        }
        .img-over {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* transition: opacity 0.25s ease-in-out;
            background-color: #1f1b2d;
            opacity: 0.5; */
            z-index: 15;
        }
        .tns-carousel {
            display: flex !important;
            flex-direction: row-reverse !important;
        }
        .swiper-slide {
            width: auto !important;
            /* padding: 4px 20px; */
        }
        @media (max-height:780px) {
            .swiper-slide {
            width: auto !important;
            /* padding: 8px 25px; */
        }
        }
        .highlight {
            background-color: #dddddd;
            /* color: white; */
            transition: background-color 1s;
        }
        .btn-primary:hover {
            box-shadow: 0 !important;
        }
        .btn-light-primary:hover {
            box-shadow: 0 !important;
        }
    </style>
    <link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
    <link rel="stylesheet" media="screen" href="/vendor/tiny-slider/dist/tiny-slider.css" />
    <link
        rel="stylesheet"
        href="/vendor/swiper/swiper-bundle.min.css"
        />

    <script src="/vendor/swiper/swiper-bundle.min.js"></script>
    <style>
        .checkmap {
            --tw-bg-opacity: 1;
            background-color: rgb(2 94 198 / var(--tw-bg-opacity));
        }
        #js_overlay {
            z-index: 1001
        }
        html {
            scroll-behavior: smooth;
        }
        .aside-search {
            width:280px;
            position: fixed;
            top: 50px;
            overflow: auto;
            height: calc(100vh - 64px);
        }
        .main-search{
            width: auto;
            margin-right: 280px;
        }
    </style>
@endsection
@section('main_content')
    <!-- main -->
    <main class="page-wrapper" style="background-color:#fff;">
        @include(ss('THEME') . '.frontend.layouts.header_rent')
        <!-- Page container-->
        <div class="container mt-5 pt-5 p-0" style="">
            <div class="row g-0 mt-n3">
                <!-- Filters sidebar (Offcanvas on mobile)-->
                <input type="hidden" name="type" id="type" value="1">
                <input type="hidden" name="view" id="view" value="1">
                <input type="hidden" name="districts" id="districts" value="">
                <input type="hidden" id="js_HiddenMapDrawPoints" style="width:0px;height:0px;overflow:hidden;border:0px" value="">

                <!-- Page content-->
                <div class="main col-12 position-relative overflow-hidden pb-5 px-3" style="border-top:1px solid #efecf3 !important">
                    <!-- Breadcrumb-->
                    <nav class="mb-3 pt-md-2 " aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{l('جستجوی املاک')}}</li>
                        </ol>
                    </nav>
                    <div class="w-100 py-3 px-3 px-md-5 start-0 border-top border-bottom" style="z-index:1029;background:#f9f9f9;">
                        <div class="swiper">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t7" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                    <i class="fi-city"></i>
                                   {{ l('شهر') }}
                                </a>
                                <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t5" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                    <i class="fi-house-chosen"></i>
                                    {{ l('نوع اقامتگاه') }}
                                </a>
                                <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t2" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                    <i class="fi-real-estate-buy"></i>
                                    {{ l('محدوده اجاره‌بها') }}
                                </a>
                                <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t8" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                    <i class="fi-real-estate-buy"></i>
                                    {{ l('متراژ') }}
                                </a>
                                <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t1" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                    <i class="fi-users"></i>
                                    {{ l('تعداد نفرات') }}
                                </a>

                                <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t9" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                    <i class="fi-double-bed"></i>
                                    {{ l('تعداد اتاق') }}
                                </a>
                                <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t4" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                    <i class="fi-billboard-house"></i>
                                    {{ l('ویژگی های اقامتگاه') }}
                                </a>

                                <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t6" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                    <i class="fi-house-chosen"></i>
                                    {{ l('منطقه اقامتگاه') }}
                                </a>
                                <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t0" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                    <i class="fi-users"></i>
                                    {{ l('فیلتر پیشرفته') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Title-->
                    <!-- Sorting-->
                    <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch my-2">
                        <!--div class="d-flex align-items-center flex-shrink-0">
                            <label class="fs-sm me-2 pe-1 text-nowrap" for="sortby">
                                <i class="fi-arrows-sort text-muted mt-n1 me-2"></i>{{l('مرتب سازی براساس:')}} </label>
                            <select class="form-select form-select-sm" id="sortby" onchange="searched()">
                                <option value="1">{{l('جدیدترین')}}</option>
                                <option value="4">{{l('گرانترین')}}</option>
                                <option value="3">{{l('ارزانترین')}}</option>
                            </select>
                        </div-->
                        <hr class="d-none d-sm-block w-100 mx-4">
                        @if (!empty($currentUser) && $currentUser->isExpert())
                            <div class="d-none d-sm-flex align-items-center flex-shrink-0 text-muted"><i
                                    class="fi-check-circle me-2"></i><span class="fs-sm mt-n1"><span
                                        id="totalCount"></span> {{l('نتیجه یافت شد')}}</span>
                            </div>
                        @endif
                    </div>
                    <!-- Catalog grid-->
                    <div class="position-relative">
                        <div style="display:none;position:absolute;z-index:1000;left:0;height:100%;width:100%;background: rgba( 255, 255, 255, .8 )url('/img/FhHRx.gif')50% 10% no-repeat;" id="backlazy">
                        </div>
                        <div class="row g-4 py-4 " id="estate-wrapper">
                        </div>
                    </div>
                    <!-- Pagination-->
                    <nav class="border-top pb-md-4 pt-4 mt-2" aria-label="Pagination" id="pagination">
                    </nav>
                </div>
            </div>
        </div>
    </main>


    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{ l('فیلترها') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body" id="sidebar">
                <div class="pb-4 mb-2">
                    <h3 class="h6 sidebar-item" tabindex="0" data-title="t0">{{l('کد ملک')}}</h3>
                    <input type="text" id="estate_id" name="estate_id" class="form-control" onchange="checkSend()" >
                </div>
                <div class="pb-4 mb-2">
                    <h3 class="h6 sidebar-item" data-title="t7" tabindex="0">{{ l('شهر') }}</h3>
                    <select id="city_id" name="city_id" class="form-control sel2" cus-valid="true">
                        <option value="0">{{l('انتخاب شهر')}}</option>
                        @foreach ($cities as $city2)
                            <option value="{{ $city2->id }}"
                                {{ isset($_REQUEST['city']) && $city2->id == $_REQUEST['city'] ? 'selected' : '' }}>
                                {{ $city2->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pb-4 mb-2">
                    <h3 class="h6 sidebar-item" data-title="t5" tabindex="0">{{l('نوع اقامتگاه')}}</h3>
                    <select class="form-select" name="estateTypes" id="estateTypes">
                        <option value=""></option>
                        @foreach (estateTypesRental() as $key=>$val)
                            <option value="{{$key}}" {{((int)app('request')->input('estate_type') == $key)?"selected":'' }}>{{$val}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="pb-4 mb-2">
                    <h3 class="h6 sidebar-item" data-title="t6" tabindex="0">{{ l('منطقه اقامتگاه') }}</h3>
                    <select class="form-select" name="position_type" id="position_type">
                        <option value=""></option>
                        <option value="292" {{((int)app('request')->input('position_type') == 292)?"selected":'' }}>{{ l('ساحلی') }}</option>
                        <option value="293" {{((int)app('request')->input('position_type') == 293)?"selected":'' }}>{{ l('جنگلی') }}</option>
                        <option value="266" {{((int)app('request')->input('position_type') == 266)?"selected":'' }}>{{ l('بر خیابان اصلی') }}</option>
                        <option value="267" {{((int)app('request')->input('position_type') == 267)?"selected":'' }}>{{ l('داخل کوچه') }}</option>
                        <option value="268" {{((int)app('request')->input('position_type') == 268)?"selected":'' }}>{{ l('کنار جاده') }}</option>
                        <option value="294" {{((int)app('request')->input('position_type') == 294)?"selected":'' }}>{{ l('داخل محدوده شهری') }}</option>
                        <option value="295" {{((int)app('request')->input('position_type') == 295)?"selected":'' }}>{{ l('خارج محدوده شهری') }}</option>
                        <option value="365" {{((int)app('request')->input('position_type') == 365)?"selected":'' }}>{{ l('ییلاقی') }}</option>
                    </select>
                </div>
                <div class="pb-4 mb-2 js_rent">
                    <h3 class="h6 sidebar-item" data-title="t2" tabindex="0">{{ l('محدوده اجاره بها') }}</h3>
                    <div class="d-flex justify-content-between align-items-start gap-1">
                        <div style="border:1px solid #d5d2dc" class="rounded-1 text-center px-18px closeprice">
                            <button selected style="border:0px;background:white" class="flex items-center justify-between w-full h-59px js_min_button js_min_Price js_button">
                                <span class="text-gray-400 text-2xl">
                                    <i class="fa-thin fa-angle-down"></i>
                                </span>
                                <input type="hidden" id="minRent" name="minRent">
                                <input type="text" id="minRent1" placeholder="{{ l('حداقل') }}" name="minRent1" style="border:0px;background:white" class="text-gray-400 font-light w-full outline-0 text-center js_min_max_input js_rahn input-price">
                            </button>
                            <ul class="hidden text-right text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0 h-260px css_scroll js_min_query_2 miniprice">
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items  jsbutton">{{ l('مقدار دلخواه') }}</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items js_max js_filter_actionRent" value="100000" onclick="js_price('min',100000)">100,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="200000" onclick="js_price('min',200000)">200,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items js_max js_filter_actionRent" value="500000" onclick="js_price('min',500000)">500,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="1000000" onclick="js_price('min',1000000)">1,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="2000000" onclick="js_price('min',2000000)">2,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="3000000" onclick="js_price('min',3000000)">3,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="4000000" onclick="js_price('min',4000000)">4,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="5000000" onclick="js_price('min',5000000)">5,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="6000000" onclick="js_price('min',6000000)">6,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="7000000" onclick="js_price('min',7000000)">7,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="8000000" onclick="js_price('min',8000000)">8,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="9000000" onclick="js_price('min',9000000)">9,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="10000000" onclick="js_price('min',10000000)">10,000,000</button>
                                </li>
                            </ul>
                        </div>
                        <div style="border:1px solid #d5d2dc" class="rounded-1 text-center px-18px closeprice">
                            <button selected style="border:0px;background:white" class="flex items-center justify-between w-full h-59px js_max_button js_max_Price js_button">
                                <span class="text-gray-400 text-2xl">
                                    <i class="fa-thin fa-angle-down"></i>
                                </span>
                                <input type="text" name="maxRent1" id="maxRent1" placeholder="{{ l('حداکثر') }}" style="border:0px;background:white" class="text-gray-400 font-light w-full outline-0 text-center js_min_max_input js_rahn input-price">
                                <input type="hidden" name="maxRent" id="maxRent">
                            </button>
                            <ul class="maxirahn hidden text-right text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0 h-260px css_scroll  js_max_query_2">
                                <li>
                                    <button style="background: white;border:0px"class="cursor-pointer w-full text-right text-gray-500  js_items    jsbutton">{{ l('مقدار دلخواه') }}</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items js_min js_filter_actionRent" value="100000" onclick="js_price('min',100000)">100,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="200000" onclick="js_price('min',200000)">200,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items js_min js_filter_actionRent" value="500000" onclick="js_price('min',500000)">500,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="1000000" onclick="js_price('min',1000000)">1,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="2000000" onclick="js_price('min',2000000)">2,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="3000000" onclick="js_price('min',3000000)">3,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="4000000" onclick="js_price('min',4000000)">4,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="5000000" onclick="js_price('min',5000000)">5,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="6000000" onclick="js_price('min',6000000)">6,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="7000000" onclick="js_price('min',7000000)">7,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="8000000" onclick="js_price('min',8000000)">8,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="9000000" onclick="js_price('min',9000000)">9,000,000</button>
                                </li>
                                <li>
                                    <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="10000000" onclick="js_price('min',10000000)">10,000,000</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="pb-4 mb-2">
                    <h3 class="h6 pt-1 sidebar-item" data-title="t8" tabindex="0">{{l('متراژ (مترمربع)')}}</h3>
                    <div class="d-flex align-items-center">
                        <input class="form-control w-100" type="tel" min="1" max="5000"
                            step="1" placeholder="{{l('حداقل')}}" id="minarea" onchange="checkSend()">
                        <div class="mx-2">&mdash;</div>
                        <input class="form-control w-100" type="tel" min="1" max="5000"
                            step="1" placeholder="{{l('حداکثر')}}" id="maxarea" onchange="checkSend()">
                    </div>
                </div>
                <div class="pb-4 mb-2">
                    <h3 class="h6 sidebar-item pt-1" data-title="t9" tabindex="0">{{l('تعداد اتاق')}}</h3>
                    <div class="btn-group btn-group-sm" role="group"
                        aria-label="Choose number of bedrooms">
                        <input class="btn-check" type="radio" id="bedrooms-1"  name="room_count"  value="187"  onchange="checkSend()">
                        <label class="btn btn-outline-secondary fw-normal" for="bedrooms-1">1</label>
                        <input class="btn-check" type="radio" id="bedrooms-2" name="room_count" value="188" onchange="checkSend()">
                        <label class="btn btn-outline-secondary fw-normal" for="bedrooms-2">2</label>
                        <input class="btn-check" type="radio" id="bedrooms-3" name="room_count" value="189" onchange="checkSend()">
                        <label class="btn btn-outline-secondary fw-normal" for="bedrooms-3">3</label>
                        <input class="btn-check" type="radio" id="bedrooms-4" name="room_count" value="190" onchange="checkSend()">
                        <label class="btn btn-outline-secondary fw-normal" for="bedrooms-4">4</label>
                        <input class="btn-check" type="radio" id="bedrooms-5" name="room_count" value="191" onchange="checkSend()">
                        <label class="btn btn-outline-secondary fw-normal" for="bedrooms-5">5+</label>
                    </div>
                </div>
                <div class="pb-4 mb-2">
                    <h3 class="h6 sidebar-item pt-1" data-title="t1" tabindex="0">{{l('تعداد نفرات')}}</h3>
                    <input type="text" id="max_person" name="max_person" class="form-control number" onchange="checkSend()" >

                </div>


                <div class="pb-4 mb-2">
                    <h3 class="h6">{{l('امکانات')}} </h3>
                    <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false"
                        data-simplebar-direction="rtl" >
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="closedoor" name="closedoor" value="352"
                                onchange="checkSend()">
                            <label class="form-check-label fs-sm" for="closedoor">{{l('دربست')}}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="elevator" name="elevator" value="37"
                                onchange="checkSend()">
                            <label class="form-check-label fs-sm" for="elevator"> {{l('آسانسور')}}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="parking" name="parking" value="35"
                                onchange="checkSend()">
                            <label class="form-check-label fs-sm" for="parking">{{l('پارکینگ')}}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="swimming" name="swimming" value="39"  {{((int)app('request')->input('facilities') == 39)?"checked":'' }} onchange="checkSend()">
                            <label class="form-check-label fs-sm" for="swimming">{{ l('استخر') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="internet" name="internet" value="356" onchange="checkSend()">
                            <label class="form-check-label fs-sm" for="internet">{{ l('اینترنت') }}</label>
                        </div>
                    </div>
                </div>
                <div class="sticky py-4">
                    <button class=" btn btn-primary w-100" type="button" onclick="searched()">
                        <i class=" me-2"></i>{{l('جستجو')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-primary btn-sm w-100 rounded-0 fixed-bottom d-lg-none zindex-0 d-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#filters-sidebar"><i class="fi-filter me-2"></i>{{ l('فیلترها') }}</button>
    @include(ss('THEME') . '.frontend.layouts.footer_rent', ['cssClass' => 'intro'])
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $(".swiper-wrapper a").on("click", function() {
            const target = $(this).data("title");
            showSidebar(target);
        });
    });
    function showSidebar(target)
    {
        const $sidebar = $("#sidebar");
        const $sidebarItem = $(".sidebar-item[data-title='" + target + "']");
        // $sidebar.fadeIn();
        console.log($sidebarItem)
        $sidebarItem.addClass("active").siblings().removeClass("active");
        const sidebarTop = $sidebarItem.offset().top;
        const sidebarHeight = $sidebarItem.outerHeight();
        const viewportHeight = $(window).height();
        const currentScroll = $sidebar.scrollTop();
        $sidebar.animate({
            scrollTop: sidebarTop - $sidebar.offset().top + currentScroll
        }, 500);
        $sidebarItem.addClass("highlight");

        setTimeout(() => {
            $sidebarItem.removeClass("highlight");
        }, 2000);
    }
    </script>
    <script src="/frontend/js/paging.js"></script>
    <script type="text/javascript">

    const swiper = new Swiper('.swiper', {
        // Optional parameters
        // direction: 'vertical',
        loop: false,
        spaceBetween: 50,
        slidesPerView: 1.5,
        spaceBetween: 10,

        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            320: {
            slidesPerView: 2.5,
            spaceBetween: 30
            },
            // when window width is >= 480px
            480: {
            slidesPerView: 3.5,
            spaceBetween: 35
            },
            // when window width is >= 640px
            640: {
            slidesPerView: 4.5,
            spaceBetween: 40
            },
            // when window width is >= 640px
            820: {
            slidesPerView: 7,
            spaceBetween: 50
            },
            1100: {
            slidesPerView: 9,
            spaceBetween: 60
            }
        }
    });
    var totalCount=0;
    var flagcheck=false;
    $(document).ready(function() {
        var cdis="";
        checkload();
        searched();

        $(".js_button").click(function() {
            if ($(this).siblings('ul').hasClass('hidden'))
                $(this).siblings('ul').removeClass('hidden');
            else
                $(this).siblings('ul').addClass('hidden');
        })


        $(".js_filter_actionRent").click(function() {
            if ($(this).hasClass('js_min')) {
                $("#minRent").val($(this).attr('value'));
                $("#minRent1").val($(this).html());
                $("#minRent1").attr('disabled', true);
            } else {
                $("#maxRent").val($(this).attr('value'));
                $("#maxRent1").val($(this).html());
                $("#maxRent1").attr('disabled', true);
            }
            $(this).parent().parent().addClass('hidden');
            checkSend();
        });
        $(".jsbutton").click(function() {
            $(this).parent().parent().parent().find('.js_min_max_input').removeAttr('disabled');
            $(this).parent().parent().parent().find('.js_min_max_input').val('');
            $(this).parent().parent().parent().find('.js_min_max_input').focus();
            $(this).parent().parent().parent().find('ul').addClass('hidden');
        });


        $(".js_rent").change(function() {
            var attr = $(this).attr('disabled');
            if (typeof attr == 'undefined' && attr !== true) {
                if ($(this).attr('id') == 'minRent') {
                    $("#minRent").val($("#minRent1").val());
                }
                if ($(this).attr('id') == 'maxRent1') {
                    $("#maxRent").val($("#maxRent1").val());
                }
            }
            checkSend();
        });
    });
    function checkload()
    {
        var title="";
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        if(urlParams.get('city_id')!==null && urlParams.get('city_id').length>0){
            $("select#city_id").select2().val(urlParams.get('city_id')).trigger('change');
        }
        if(urlParams.get('max_person')!==null && urlParams.get('max_person').length>0){
            $("#max_person").val(urlParams.get('max_person'));
        }
        checkSend();
    }
    //golab


    //golab
    var valuechec=0;
    var floorchec=0;
    $(document).ready(function() {

        $('input[name="room_count"]').click(function() {
            if ($(this).is(':checked') && $(this).val()!=valuechec) {
                $(this).prop('checked', true);
                valuechec=$(this).val();
            }
            else
            {
                $(this).prop('checked', false);
                valuechec=0;
                checkSend();
            }
        });

    });
    $(".js_min_max_input").change(function()
    {
        $(this).parent().parent().find('ul').addClass('hidden');
    });
    var modal = document.querySelector("body");
    modal.addEventListener("click", handleModalClick);
    function handleModalClick(evt) {
    // `evt.target` is the DOM node the user clicked on.
        if (evt.target.closest(".closeprice")) {
            flag10=false;
        }
        else
        {
            $(".closeprice").find('ul').addClass("hidden");
        }
    }
    var chkroom=0;
    function filter()
    {
        var title=""
        var countdis = 0;
        var sr = "";
        var codition=[];
        var facilities=[];
        $('input[name="room_count"]:checked').length>0?sr += "room_count=" + $('input[name="room_count"]:checked').val() + "&":"";
        sr += $('#estate_id').val() > 0 ? "id=" + $('#estate_id').val() + "&" : "";
        sr += $('#city_id').val() > 0 ?"city_id=" + $('#city_id').val() + "&" : "";
        sr += $('#position_type').val() > 0 ?"position_type=" + $('#position_type').val() + "&" : "";
        sr += $('#max_person').val() > 0 ?"max_person=" + $('#max_person').val() + "&" : "";
        sr += $('#estateTypes').val() > 0 ? "estateTypes=" + $('#estateTypes').val() + "&" : "";
        sr += $('#minarea').val() > 0 ? "minArea=" + $('#minarea').val() + "&" : "";
        sr += $('#maxarea').val() > 0 ? "maxArea=" + $('#maxarea').val() + "&" : "";
        sr +=$('input[name="closedoor"]:checked').length>0 ?facilities.push(352) : "";
        $('input[name="elevator"]:checked').length>0 ?facilities.push(36): "";
        $('input[name="parking"]:checked').length>0 ?facilities.push(37): "";
        $('input[name="swimming"]:checked').length>0 ?facilities.push(39): "";
        $('input[name="internet"]:checked').length>0 ?facilities.push(356): "";
        sr +=codition.length>0?"conditions="+codition+"&":""
        sr +=facilities.length>0?"facilities="+facilities+"&":""

        sr += ($('#minRent').val() > 0 || $('#maxRent').val() > 0) ? ("rent=" + ($('#minRent').val() > 0 ? $('#minRent').val() : 0) + "," + ($('#maxRent').val()) + "&") : "";
        return sr;
    }
    function checkSend()
    {
        sr = filter();
    }
    function searched(){
        sr = filter();
        jQuery('.btn-close').click();
        loadMoreData_v2(1, sr);
    }

    var type2 = "";
    $(document).ready(function() {
        $(".sel2").select2({
            language: "fa",
            //placeholder: l("انتخاب"),
        });
    })
    function district_request(cityId) {
    }
    //golab

    var page = 1;
    var pagin = 1;
    var currentpage = 1;
    @if(ss('SITE_ID') == 2)
    $(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 500) {
            if(flagcheck==false)
            {
                if(parseInt(totalCount)>=parseInt(pagin)+1)
                {
                    pagin=pagin+1;
                    sr = filter();
                    currentpage = pagin;
                    loadMoreData_v2(pagin, sr)
                }
            };
        };
    });
    @endif
    $("#pagination").on("click", "a", function() {
        pagin = $(this).attr("pn");
        window.scrollTo(0, 250);
        loadMoreData_v2($(this).attr("pn"), type2)
    });

    function loadMoreData_v2(page, type2) {
        $("#backlazy").show();
        @if(ss('SITE_ID') != 2)
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        @endif
        if (page == 1) {
            $("#estate-wrapper").empty();
        }
        $.ajax({
                url: `?page=${page}&&${type2}`,
                type: "get",
                beforeSend: function() {
                    $("#spiner").removeClass("d-none");
                }
            }).done(function(data) {
                //$('.offcanvas').toggle();
                @if(ss('SITE_ID') != 2)
                $("#estate-wrapper").empty();
                @endif
                if (data.totalCount < 9)
                    hasPage = false;
                else
                    hasPage = data.hasPage;
                $("#spiner").addClass("d-none");
                if (data.length == 0) {
                    return;
                }

                // console.log(data.totalCount);
                var htmlpage = data.html;
                @if(ss('SITE_ID') != 2)
                $("#estate-wrapper").html(htmlpage);
                @else
                $("#estate-wrapper").append(htmlpage);
                @endif
                @if(ss('SITE_ID') != 2)
                var result = Paging(pagin, 15, data.totalCount, "myClass", "myDisableClass");
                $("#pagination").html(result);
                @endif
                if (data.totalCount == 0) {
                    $(".js_stateCount2").addClass("d-none").removeClass("d-block");
                    $(".js_stateCount1").addClass("d-block").removeClass("d-none");
                    //$(".js_stateCount1").html(data.totalCount);
                } else {
                    $(".js_stateCount2").addClass("d-block").removeClass("d-none");
                    $(".js_stateCount1").addClass("d-none").removeClass("d-block");
                    $(".js_stateCount").html(data.totalCount);
                }
                pageflag = true;
                totalCount=data.totalCount;
                $("#totalCount").html(data.totalCount)
                $("#backlazy").hide();
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                $("#spiner").addClass("d-none");
                //alert(l('مشکلی در دریافت اطلاعات بوجود آمده است...'));
            });
    };


    var refreshIntervalId;

    $('select#city_id').on('change', function() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const positionx = [];
        const positiony = [];
        @foreach ($cities as $city2)
        positionx[{{$city2->id}}]= '{{$city2->posx}}';
        positiony[{{$city2->id}}]= '{{$city2->posy}}';
        @endforeach


        var cityId = this.value;
        district_request(cityId);
        if(urlParams.get('districts')!==null && urlParams.get('districts').length>0)
        {
            if(cityId!=dis){
                dis=cityId;
                checkSend();
            }
        }
        else
        {
            checkSend();
        }
    });

</script>

@endsection
