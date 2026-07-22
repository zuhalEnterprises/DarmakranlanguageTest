
@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', ['title' => ss('SITE_NAME')])
@section('head')
    <link href="/frontend/js/modules/leaflet/leaflet.css" rel="stylesheet" type="text/css">
    <link href="/frontend/js/modules/leaflet/markercluster/MarkerCluster.css" rel="stylesheet" type="text/css">
    <link href="/frontend/js/modules/leaflet/leaflet.draw.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" media="screen" href="/vendor/expandable/jquery.expandable.css" />
    <style>
        .leaflet-draw-toolbar{display:none}
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
        li {
            list-style-type: none;
        }
    </style>
    <link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
    <link rel="stylesheet" media="screen" href="/vendor/tiny-slider/dist/tiny-slider.css" />
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
    <main class="page-wrapper">
        @include(ss('THEME') . '.frontend.layouts.header_v2')
        <div class="container mt-5 pt-5 p-0">
            <div class="row g-0 mt-n3">
            <!-- Filters sidebar (Offcanvas on mobile)-->
            <input type="hidden" name="type" id="type" value="1">
                <input type="hidden" name="view" id="view" value="1">
                <input type="hidden" name="estateType" id="estateType" value="">
                <input type="hidden" name="districts" id="districts" value="{{app('request')->input('district_id')}}">
                <input type="hidden" id="js_HiddenMapDrawPoints" style="width:0px;height:0px;overflow:hidden;border:0px"
                    value="">
            <aside class="col-lg-4 col-xl-3 border-top-lg border-end-lg card card-body shadow-sm mb-3 px-3 px-xl-4 pt-lg-2" style="margin-top: 35px;">
                <div class="offcanvas-lg offcanvas-start" id="filters-sidebar">
                    <div class="offcanvas-header d-flex d-lg-none align-items-center">
                        <h2 class="h5 mb-0">Filters</h2>
                        <button class="btn-close" type="button" data-bs-dismiss="offcanvas" data-bs-target="#filters-sidebar"></button>
                    </div>
                    <div class="offcanvas-header d-block border-bottom pt-0 pt-lg-4 px-lg-0">
                        <ul class="nav nav-tabs mb-0">
                            <li class="nav-item">
                                <a class="nav-link  js_type2" onclick="typechange(2); checkSend();" href="javascript:void(0)">
                                    <i class="fi-rent fs-base me-2"></i>For rent
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active js_type1" onclick="typechange(1); checkSend();" href="javascript:void(0)">
                                    <i class="fi-home fs-base me-2"></i>
                                    For sale
                                </a>
                            </li>
                        </ul>
                    </div>
                    <script>
                        @if(app('request')->input('type') != 3)
                        $(document).ready(function() {
                            typechange({{(app('request')->input('type') == '')? 1 : app('request')->input('type')}})
                        })
                        @endif
                    </script>
                    <div class="offcanvas-body py-lg-4">
                        <div class="pb-4 mb-2">
                            <h3 class="h6">Location</h3>

                            <select multiple id="district_id" name="district_id" class="form-control sel2"
                                cus-valid="true">
                                <option disabled value="">{{l('انتخاب محله')}}</option>
                                @foreach ($city->districts as $district2)
                                <option value="{{ $district2->id }}" {{ app('request')->input('district_id') == $district2->id ? "selected" : ""}}>
                                    {{ $district2->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pb-4 mb-2 buyer-content  usage_type1">
                            <div>
                                <h3 class="h6">{{l('نوع کاربری')}}</h3>
                                <select name="usage_type" id="usage_type" class="form-select">
                                    @foreach (usage_type() as $key=>$val)
                                    <option value="{{$key}}" {{!empty($model)?($model->usage_type==$key ? 'selected':''):""}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="pb-4 mb-2">
                            <h3 class="h6">{{l('نوع ملک')}}</h3>
                            <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" style="height: 11rem;">
                                @foreach (estateTypesResidential() as $key=>$val)
                                <div class="form-check g107">
                                    <input class="form-check-input" type="checkbox" value="{{$key}}" id="js_{{$key}}" name="estateTypes[]" onchange="estatechange()" {{ app('request')->input('estate_type') == $key ? "checked" : ""}}>
                                    <label class="form-check-label fs-sm" for="{{$val}}">{{$val}}</label>
                                </div>
                                @endforeach

                                @foreach (estateTypesCommercial() as $key=>$val)
                                <div class="form-check g109">
                                    <input class="form-check-input" type="checkbox" value="{{$key}}" id="js_{{$key}}" name="estateTypes[]" onchange="estatechange()" {{ app('request')->input('estate_type') == $key ? "checked" : ""}}>
                                    <label class="form-check-label fs-sm" for="{{$val}}">{{$val}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pb-4 mb-2 js_price">
                            <h3 class="h6">{{l('قیمت خرید')}} ({{l('تومان')}})</h3>
                            <div class="d-flex justify-content-between align-items-start gap-1">
                                <div style="border:1px solid #d5d2dc" class="rounded-1 text-center px-18px closeprice">
                                    <button selected style="border:0px;background:white" class="flex items-center justify-between w-full h-59px js_min_button js_min_Price js_button">
                                        <span class="text-gray-400 text-2xl">
                                            <i class="fa-thin fa-angle-down"></i>
                                        </span>
                                        <input type="hidden" id="minPrice" name="minPrice" value="{{(int)(app('request')->input('pricefrom'))*1000 > 0 ? (int)(app('request')->input('pricefrom'))*1000 : ''}}">
                                        <input type="text" id="minPrice1" placeholder="{{l('حداقل')}} " name="minPrice1" style="border:0px;background:white" class="text-gray-400 font-light w-full outline-0 text-center js_min_max_input js_price input-price" value="{{(int)(app('request')->input('pricefrom'))*1000 > 0 ? (int)(app('request')->input('pricefrom'))*1000 : ''}}">
                                    </button>
                                    <ul class="hidden text-left text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0 h-260px css_scroll js_min_query_2 miniprice">
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items  jsbutton">{{l('مقدار دلخواه')}}</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items js_min js_filter_action1" value="300000" onclick="js_price('min',300000)">300,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="500000" onclick="js_price('min',500000)">500,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items js_min js_filter_action1" value="1000000" onclick="js_price('min',1000000)">1,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="1500000" onclick="js_price('min',1500000)">1,500,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="2000000" onclick="js_price('min',2000000)">2,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="3000000" onclick="js_price('min',3000000)">3,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="5000000" onclick="js_price('min',5000000)">5,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="10000000" onclick="js_price('min',10000000)">10,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="20000000" onclick="js_price('min',20000000)">20,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="30000000" onclick="js_price('min',30000000)">20,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="50000000" onclick="js_price('min',50000000)">50,000,000</button>
                                        </li>
                                    </ul>
                                </div>
                                <div style="border:1px solid #d5d2dc" class="rounded-1 text-center px-18px closeprice">
                                    <button selected style="border:0px;background:white" class="flex items-center justify-between w-full h-59px js_max_button js_max_Price js_button">
                                        <span class="text-gray-400 text-2xl">
                                            <i class="fa-thin fa-angle-down"></i>
                                        </span>
                                        <input type="text" name="maxPrice1" id="maxPrice1" placeholder="{{l('حداکثر')}} " style="border:0px;background:white" class="text-gray-400 font-light w-full outline-0 text-center js_min_max_input js_price input-price" value="{{(int)(app('request')->input('priceto'))*1000 > 0 ? (int)(app('request')->input('priceto'))*1000 : ''}}">
                                        <input type="hidden" name="maxPrice" id="maxPrice" value="{{(int)(app('request')->input('priceto'))*1000 > 0 ? (int)(app('request')->input('priceto'))*1000 : ''}}">
                                    </button>
                                    <ul class="maxiprice hidden text-left text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0 h-260px css_scroll  js_max_query_2">
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items  jsbutton">{{l('مقدار دلخواه')}}</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items js_min js_filter_action1" value="300000" onclick="js_price('min',300000)">300,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="500000" onclick="js_price('min',500000)">500,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items js_min js_filter_action1" value="1000000" onclick="js_price('min',1000000)">1,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="1500000" onclick="js_price('min',1500000)">1,500,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="2000000" onclick="js_price('min',2000000)">2,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="3000000" onclick="js_price('min',3000000)">3,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="5000000" onclick="js_price('min',5000000)">5,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="10000000" onclick="js_price('min',10000000)">10,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="20000000" onclick="js_price('min',20000000)">20,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="30000000" onclick="js_price('min',30000000)">20,000,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_action1" value="50000000" onclick="js_price('min',50000000)">50,000,000</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pb-4 mb-2 js_rent" style="display: none">
                            <h3 class="h6">{{l('قیمت اجاره (تومان)')}}</h3>
                            <div class="d-flex justify-content-between align-items-start gap-1">
                                <div style="border:1px solid #d5d2dc" class="rounded-1 text-center px-18px ">
                                    <button selected style="border:0px;background:white" class="flex items-center justify-between w-full h-59px js_min_button js_min_Price js_button">
                                        <span class="text-gray-400 text-2xl">
                                            <i class="fa-thin fa-angle-down"></i>
                                        </span>
                                        <input type="hidden" id="minRent" name="minRent">
                                        <input type="text" id="minRent1" placeholder="{{l('حداقل')}} " name="minRent1" style="border:0px;background:white" class="text-gray-400 font-light w-full outline-0 text-center js_min_max_input js_rahn input-price">
                                    </button>
                                    <ul class="hidden text-left text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0 h-260px css_scroll js_min_query_2 miniprice">
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items  jsbutton">{{l('مقدار دلخواه')}}</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items js_min js_filter_actionRent" value="20000" onclick="js_price('min',20000)">20,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="30000" onclick="js_price('min',30000)">30,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500 js_items js_min js_filter_actionRent" value="40000" onclick="js_price('min',40000)">40,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="50000" onclick="js_price('min',50000)">50,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="100000" onclick="js_price('min',100000)">100,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="150000" onclick="js_price('min',150000)">150,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="200000" onclick="js_price('min',200000)">200,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="300000" onclick="js_price('min',300000)">300,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="400000" onclick="js_price('min',400000)">400,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="500000" onclick="js_price('min',500000)">500,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="600000" onclick="js_price('min',600000)">600,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="700000" onclick="js_price('min',700000)">700,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_min js_filter_actionRent" value="800000" onclick="js_price('min',800000)">800,000</button>
                                        </li>
                                    </ul>
                                </div>
                                <div style="border:1px solid #d5d2dc" class="rounded-1 text-center px-18px ">
                                    <button selected style="border:0px;background:white" class="flex items-center justify-between w-full h-59px js_max_button js_max_Price js_button">
                                        <span class="text-gray-400 text-2xl">
                                            <i class="fa-thin fa-angle-down"></i>
                                        </span>
                                        <input type="text" name="maxRent1" id="maxRent1" placeholder="{{l('حداکثر')}} " style="border:0px;background:white" class="text-gray-400 font-light w-full outline-0 text-center js_min_max_input js_rahn input-price">
                                        <input type="hidden" name="maxRent" id="maxRent">
                                    </button>
                                    <ul class="maxirahn hidden text-left text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0 h-260px css_scroll  js_max_query_2">
                                        <li>
                                            <button style="background: white;border:0px"class="cursor-pointer w-full text-right text-gray-500  js_items    jsbutton">{{l('مقدار دلخواه')}}</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="20000" onclick="js_price('max',20000)">20,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="30000" onclick="js_price('max',30000)">30,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="40000" onclick="js_price('max',40000)">40,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="50000" onclick="js_price('max',50000)">50,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="100000" onclick="js_price('max',100000)">100,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="150000" onclick="js_price('max',150000)">150,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="200000" onclick="js_price('max',200000)">200,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent"  value="300000" onclick="js_price('max',300000)">300,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="400000" onclick="js_price('max',400000)">400,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_maX js_filter_actionRent" value="500000" onclick="js_price('max',500000)">500,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="600000" onclick="js_price('max',600000)">600,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="700000" onclick="js_price('max',700000)">700,000</button>
                                        </li>
                                        <li>
                                            <button style="background: white;border:0px" class="cursor-pointer w-full text-right text-gray-500  js_items js_max js_filter_actionRent" value="800000" onclick="js_price('max',800000)">800,000</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="pb-4 mb-2">

                            <label class="d-block fs-sm pt-2 my-1">{{l(' حداقل اتاق')}}</label>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Choose number of rooms">
                                <input class="btn-check" type="radio" id="bedrooms-0" name="room_count" value="186" onchange="checkSend()" {{ app('request')->input('room_count') == "studio" ? "checked" : ""}}>
                                <label class="btn btn-outline-secondary fw-normal" for="bedrooms-0">Studio</label>
                                <input class="btn-check" type="radio" id="bedrooms-1" name="room_count" value="187" onchange="checkSend()" {{ app('request')->input('room_count') == 1 ? "checked" : ""}}>
                                <label class="btn btn-outline-secondary fw-normal" for="bedrooms-1">1</label>
                                <input class="btn-check" type="radio" id="bedrooms-2" name="room_count" value="188" onchange="checkSend()" {{ app('request')->input('room_count') == 2 ? "checked" : ""}}>
                                <label class="btn btn-outline-secondary fw-normal" for="bedrooms-2">2</label>
                                <input class="btn-check" type="radio" id="bedrooms-3" name="room_count" value="189" onchange="checkSend()" {{ app('request')->input('room_count') == 3 ? "checked" : ""}}>
                                <label class="btn btn-outline-secondary fw-normal" for="bedrooms-3">3</label>
                                <input class="btn-check" type="radio" id="bedrooms-4" name="room_count" value="190" onchange="checkSend()" {{ app('request')->input('room_count') == 4 ? "checked" : ""}}>
                                <label class="btn btn-outline-secondary fw-normal" for="bedrooms-4">4</label>
                                <input class="btn-check" type="radio" id="bedrooms-5" name="room_count" value="191" onchange="checkSend()" {{ app('request')->input('room_count') == 5 ? "checked" : ""}}>
                                <label class="btn btn-outline-secondary fw-normal" for="bedrooms-5">5+</label>
                            </div>
                        </div>
                        <div class="pb-4 mb-2">
                            <label class="d-block fs-sm pt-2 my-1">Bathrooms</label>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Choose number of bathrooms">
                                <input class="btn-check" type="radio" id="bathrooms-1" name="bath_count" value="1">
                                <label class="btn btn-outline-secondary fw-normal" for="bathrooms-1">1</label>
                                <input class="btn-check" type="radio" id="bathrooms-2" name="bath_count" value="2">
                                <label class="btn btn-outline-secondary fw-normal" for="bathrooms-2">2</label>
                                <input class="btn-check" type="radio" id="bathrooms-3" name="bath_count" value="3">
                                <label class="btn btn-outline-secondary fw-normal" for="bathrooms-3">3</label>
                                <input class="btn-check" type="radio" id="bathrooms-4" name="bath_count" value="4">
                                <label class="btn btn-outline-secondary fw-normal" for="bathrooms-4">4</label>
                            </div>
                        </div>
                        <div class="pb-4 mb-2">
                            <h3 class="h6 pt-1">{{l('مساحت (مترمربع)')}}</h3>
                            <div class="d-flex align-items-center">
                                <input class="form-control w-100" type="number" min="20" max="500" step="10" placeholder="Min" id="minarea" onchange="checkSend()">
                                <div class="mx-2">&mdash;</div>
                                <input class="form-control w-100" type="number" min="20" max="500" step="10" placeholder="Max" id="maxarea" onchange="checkSend()">
                            </div>
                        </div>
                        <div class="pb-4 mb-2">
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="keynot" name="keynot" value="1">
                                    <label class="form-check-label fs-sm" for="keynot">{{l('کلید نخورده')}}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input condition" type="checkbox" id="condition15" name="condition[]" value="15" {{app('request')->input('type') == 3 ? "checked":""}}>
                                    <label class="form-check-label fs-sm" for="condition15">{{l('پیش فروش')}}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="condition348"  value="348" type="checkbox" name="conditions[]">
                                    <label class="form-check-label fs-sm" for="conditions348">
                                        {{l('فول امکانات')}}
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="pb-4 mb-2">
                            <label class="form-label">{{l('سازنده')}}</label>
                            <select class="form-select"  name="manufacturer_id" id="manufacturer_id" onchange="changeManufacturer()">
                                <option value="">{{l('انتخاب')}}</option>
                                @foreach ($manufacturers as $manufacturer)
                                <option value="{{$manufacturer->id}}">{{$manufacturer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pb-4 mb-2">
                            <label class="form-label">{{l('پروژه')}}</label>
                            <select class="form-select"  name="project_id" id="project_id">
                                <option value="">{{l('انتخاب')}}</option>
                            </select>
                        </div>

                        <div class="sticky py-4" style="z-index: 1000">
                            <button class=" btn btn-primary w-100" type="button" onclick="searched()">
                                <i class=" me-2"></i>{{l('جستجو')}}
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
            <!-- Page content-->
            <div class="col-lg-8 col-xl-9 position-relative overflow-hidden pb-5 pt-4 px-3">
                <!-- Sorting-->
                <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch my-2">
                    <div class="d-flex align-items-center flex-shrink-0">
                        <label class="fs-sm me-2 pe-1 text-nowrap" for="sortby">
                            <i class="fi-arrows-sort text-muted mt-n1 me-2"></i>Sort by:
                        </label>
                        <select class="form-select form-select-sm" id="sortby" onchange="searched()">
                            <option value="1">{{l('جدیدترین')}}</option>
                            <option value="4">{{l('گرانترین')}}</option>
                            <option value="3">{{l('ارزانترین')}}</option>
                        </select>
                    </div>
                    <hr class="d-none d-sm-block w-100 mx-4">
                    @if (!empty($currentUser) && $currentUser->isExpert())
                        <div class="d-none d-sm-flex align-items-center flex-shrink-0 text-muted">
                            <i class="fi-check-circle me-2"></i>
                            <span class="fs-sm mt-n1">
                                Number of results: <span id="totalCount"></span>
                            </span>
                        </div>
                    @endif
                </div>
                <div style="display:none;position:absolute;z-index:1000;left:0;height:100%;width:100%;background: rgba( 255, 255, 255, .8 )url('/img/FhHRx.gif')50% 10% no-repeat;" id="backlazy">
                </div>
                <!-- Map popup-->
                <div class="zindex-0 rounded-1 card card-body shadow-sm" id="map" style="height: 400px"></div>
                <!-- Catalog grid-->
                <div class="row g-4" id="estate-wrapper">
                </div>
                <!-- Pagination-->
                <nav aria-label="Pagination" id="pagination" class="mt-4">
                </nav>
            </div>
            </div>
        </div>
    </main>
    <!-- Filters sidebar toggle button (mobile)-->
    <button class="btn btn-primary btn-sm w-100 rounded-0 fixed-bottom d-lg-none zindex-0" type="button"
        data-bs-toggle="offcanvas" data-bs-target="#filters-sidebar"><i class="fi-filter me-2"></i>{{ l('فیلترها') }}</button>
    @include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
    <script src="/frontend/js/paging.js"></script>
    <script type="text/javascript">
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
            $(".js_filter_action1").click(function() {
                if ($(this).hasClass('js_min')) {
                    $("#minPrice").val($(this).attr('value'));
                    $("#minPrice1").val($(this).html());
                    $("#minPrice1").attr('disabled', true);
                } else {
                    $("#maxPrice").val($(this).attr('value'));
                    $("#maxPrice1").val($(this).html());
                    $("#maxPrice1").attr('disabled', true);
                }
                $(this).parent().parent().addClass('hidden');
                checkSend();
                //$("#js_filter_result").append('<button name_id="maxPrice" id="js_maxPrice" attr_id="'+$("#maxPrice").val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>تا '+$("#maxPrice1").val()+' تومان</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_maxPrice\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
            });
            $(".js_filter_actionRahn").click(function() {
                if ($(this).hasClass('js_min')) {
                    $("#minRahn").val($(this).attr('value'));
                    $("#minRahn1").val($(this).html());
                    $("#minRahn1").attr('disabled', true);
                } else {
                    $("#maxRahn").val($(this).attr('value'));
                    $("#maxRahn1").val($(this).html());
                    $("#maxRahn1").attr('disabled', true);
                }
                $(this).parent().parent().addClass('hidden');
                checkSend();
            });
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
            $(".js_price").change(function() {
                var attr = $(this).attr('disabled');
                if (typeof attr == 'undefined' && attr !== true) {
                    if ($(this).attr('id') == 'minPrice1') {
                        $("#minPrice").val($("#minPrice1").val());
                    }
                    if ($(this).attr('id') == 'maxPrice1') {
                        $("#maxPrice").val($("#maxPrice1").val());
                    }
                }
                checkSend();
            });
            $(".js_rahn").change(function() {
                var attr = $(this).attr('disabled');
                if (typeof attr == 'undefined' && attr !== true) {
                    if ($(this).attr('id') == 'minRahn1') {
                        $("#minRahn").val($("#minRahn1").val());
                    }
                    if ($(this).attr('id') == 'maxRahn1') {
                        $("#maxRahn").val($("#maxRahn1").val());
                    }
                }
                checkSend();
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
        function checkload(){
            var title="";
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            if(urlParams.get('districts')!==null && urlParams.get('districts').length>0){
                   $("#districts").val(urlParams.get('districts'));
                    dis=urlParams.get('districts');
                //$("select#district_id").select2().val(urlParams.get('districts')).trigger('change');
                }
            if(urlParams.get('city_id')!==null && urlParams.get('city_id').length>0){
                $("select#city_id").select2().val(urlParams.get('city_id')).trigger('change');
                //district_request(urlParams.get('city_Id'));
            }
           // title+= $('#city_id').find(':selected').text().trim();
                if(urlParams.get('estateTypes')!==null && urlParams.get('estateTypes').length>0){
                    var str = '';
                    if(urlParams.get('estateTypes')==1)
                        $("#js_apartment").prop('checked',true);
                        if(urlParams.get('estateTypes')==2)
                        $("#js_villa").prop('checked',true);
                        if(urlParams.get('estateTypes')==3)
                        $("#js_shop").prop('checked',true);
                        if(urlParams.get('estateTypes')==4)
                        $("#js_land").prop('checked',true);
                        if(urlParams.get('estateTypes')==5)
                        $("#js_industrial").prop('checked',true);
                        if ($('#js_apartment').is(":checked")) str += ',1';
                        if ($('#js_villa').is(":checked")) str += ',2';
                        if ($('#js_shop').is(":checked")) str += ',3';
                        if ($('#js_land').is(":checked")) str += ',4';
                        if ($('#js_industrial').is(":checked")) str += ',5';
                        str = str.substring(1);
                        $('#estateType').val(str);
                }
            checkSend();
        }
        //golab
        function estatechange() {
            var str = '';
            for(i = 1 ; i <= 35 ; i++)
            {
                if ($('#js_'+i).is(":checked")) str += ','+i;
            }
            str = str.substring(1);
            $('#estateType').val(str);
            checkSend();
        }
        $("#district_id").on("select2:select select2:unselect", function(e) {
            //this returns all the selected item
            var items = $(this).val();
            $('#districts').val(items);
            checkSend();
        })
        //golab
        var valuechec=0;
        var floorchec=0;
        $(document).ready(function() {
            $(".condtion").change(function(){
                checkSend();
            });
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
            $('input[name="floor_count"]').click(function() {
                if ($(this).is(':checked') && $(this).val()!=floorchec) {
                    $(this).prop('checked', true);
                    floorchec=$(this).val();
                }
                else
                {
                    $(this).prop('checked', false);
                    floorchec=0;
                    checkSend();
                }
            });
            estatechange();
        });
        var chkroom=0;
        function filter()
        {
            var title=""
            var countdis = 0;
            var sr = "";
            var codition=[];
            $('input[name="room_count"]:checked').length>0?sr += "room_count=" + $('input[name="room_count"]:checked').val() + "&":"";
            $('input[name="bath_count"]:checked').length>0?sr += "bath_count=" + $('input[name="bath_count"]:checked').val() + "&":"";
            $('input[name="floor_count"]:checked').length>0?sr += "floor_count=" + $('input[name="floor_count"]:checked').val() + "&":"" ;
            sr += $('#geography').val() > 0 ? "geography=" + $('#geography').val() + "&" : "";
            sr += $('#type').val() > 0 ? "type=" + $('#type').val() + "&" : "";
            sr += $('#usage_type').val() > 0 ? "usage_type=" + $('#usage_type').val() + "&" : "";
            sr += $('#estate_id').val() > 0 ? "id=" + $('#estate_id').val() + "&" : "";
            sr += $('#city_id').val() > 0 ?"city_id=" + $('#city_id').val() + "&" : "";
            sr += $('#estateType').val() != '' ? "estateTypes=" + $('#estateType').val() + "&" : "";
            sr += $('#minarea').val() > 0 ? "minArea=" + $('#minarea').val() + "&" : "";
            sr += $('#maxarea').val() > 0 ? "maxArea=" + $('#maxarea').val() + "&" : "";
            sr += $('#minfloorcount').val() > 0 ? "minfloorcount=" + $('#minfloorcount').val() + "&" : "";
            sr += $('#maxfloorcount').val() > 0 ? "maxfloorcount=" + $('#maxfloorcount').val() + "&" : "";
            sr += $('#districts').val() != '' ? "districts=" + $('#districts').val() + "&" : "";
            sr += $('#built_year').val() > 0 ? "built_year=" + $('#built_year').val() + "&" : "";
            sr += $('#unit_in_floor').val()>0 ? "unit_in_floor=" + $('#unit_in_floor').val() + "&" : "";
            sr +=$('input[name="keynot"]:checked').length>0 ?"keynot=1&" : "";
            $('input[name="store"]:checked').length>0 ?codition.push(35) : "";
            $('input[name="elevator"]:checked').length>0 ?codition.push(36): "";
            $('input[name="parking"]:checked').length>0 ?codition.push(37): "";
            $('#condition348:checked').length>0 ?codition.push(348) : "";
            $('#condition15:checked').length>0 ?codition.push(15) : "";
            sr +=codition.length>0?"conditions="+codition+"&":""
            sr += (typeof $('#manufacturer_id').val()!=='undefined' && $('#manufacturer_id').val() != '') ? "manufacturer_id=" + $('#manufacturer_id').val() + "&" : "";
            sr += (typeof $('#project_id').val()!=='undefined' && $('#project_id').val() != '') ? "project_id=" + $('#project_id').val() + "&" : "";
            $(".photo").each(function() {
                if($(this).is(':checked')){
                    sr+="photo="+$(this).val()+"&";
                }
            });

            sr +=codition.length>0?"conditions="+codition+"&":""

            if ($('#type').val() > 0) {
                if ($('#type').val() == 1) {
                    sr += ($('#minPrice').val() > 0 || $('#maxPrice').val() > 0) ? ("price=" + ($('#minPrice').val() > 0 ?
                        $('#minPrice').val() : 0) + "," + ($('#maxPrice').val()) + "&") : "";
                } else {
                    sr += ($('#minRahn').val() > 0 || $('#maxRahn').val() > 0) ? ("rahn=" + ($('#minRahn').val() > 0 ? $(
                        '#minRahn').val() : 0) + "," + ($('#maxRahn').val()) + "&") : "";
                    sr += ($('#minRent').val() > 0 || $('#maxRent').val() > 0) ? ("rent=" + ($('#minRent').val() > 0 ? $(
                        '#minRent').val() : 0) + "," + ($('#maxRent').val()) + "&") : "";
                }
            }
            sr += $('#view').val() > 0 ? "view=" + $('#view').val() + "&" : "";
            //sr += $('#title').val() != '' ? "title=" + $('#title').val() + "&" : "";
            window.history.pushState("object or string", "Title", "/c/{{$selectedCity}}?"+sr);
            sr += sort() + "&";
            //sr+="title="+$("#title").val();
            if ($('#map').length > 0) {
                let points = $('#js_HiddenMapDrawPoints').val();
                if (!isNullOrEmpty(points)) {
                    sr += '&eslistflag=true&eslist=' + points;
                    //            alert(sr);
                }
            }
            type2 = sr;
            $(".js_Neighbourhood_count").html(countdis);
            return sr;
        }
        function checkSend()
        {
            console.log('checkSend');
            sr = filter();
            @if(ss('SITE_ID') != 2)
            //SetMapCluster(sr);
            //loadMoreData_v2(1, sr)
            @endif
        }
        function searched(){
            console.log('searched');
            sr = filter();
            jQuery('.btn-close').click();
            SetMapCluster(sr);
            loadMoreData_v2(1, sr);
        }
        //golab

        //golab
        function district_request(cityId) {
            $.get("/api/cities/" + cityId + "/districts1", function(data, status) {
                if (data.status) {
                    if(data.result.length>0)
                    {
                        var village = 0;
                        var str="";
                        $.each(data.result, function(i, item) {
                            if(data.result[i]['village'] == 1 && village == 0)
                            {
                                str+="<optgroup label=l('روستاها')>";
                                village == 1;
                            }
                            str+="<option value='"+data.result[i]['id']+"'>"+data.result[i]['name']+"</option>";
                        });
                        if(village == 1)
                        {
                            str+="</optgroup>";
                        }
                    }
                    $('select#district_id').html(str);
                    const queryString = window.location.search;
                    const urlParams = new URLSearchParams(queryString);
                    if(urlParams.get('districts')!==null && urlParams.get('districts').length>0){
                       // $("#districts").val(urlParams.get('districts'));
                        $("select#district_id").select2({closeOnSelect: false}).val(urlParams.get('districts')).trigger('change');
                    }
                   else if (district_id !== '') {
                       // $("select#district_id").select2().val(district_id).trigger('change');
                    }
                }
            });
        }
        var type2 = "";
        $(document).ready(function() {
            $(".sel2").select2({
                language: "fa",
                closeOnSelect: false
                //placeholder: l("انتخاب"),
            });
        })
        //golab
        function sort() {
            var type1 = "";
            switch ($('#sortby').val()) {
                case "1":
                    type1 = "sortBy=1&&sortType=1";
                    break;
                case "2":
                    type1 = "sortBy=1&&sortType=2";
                    break;
                case "3":
                    type1 = "sortBy=3&&sortType=2";
                    break;
                case "4":
                    type1 = "sortBy=3&&sortType=1";
                    break;
            }
            return type1;
        }
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
        function viewchange(id) {
            $("#js_view1").removeClass('active');
            $("#js_view2").removeClass('active');
            $("#js_view3").removeClass('active');
            $("#js_view" + id).addClass('active');
            $('#view').val(id);
        }
        function typechange(id) {
            if (id == 1) {
                $(".js_type1").addClass('active');
                $(".js_type2").removeClass('active');
                $('.js_rahn').hide();
                $('.js_rent').hide();
                $('.js_price').show();
            } else {
                $(".js_type2").addClass('active');
                $(".js_type1").removeClass('active');
                $('.js_rahn').show();
                $('.js_rent').show();
                $('.js_price').hide();
            }
            $('#type').val(id);
        }
        //const input_array = ['35', '36', '37'];
        //const selection_array = [];
    </script>
    <script>
        var addressPoints;
        var mp;
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0-beta.2/leaflet.js"></script>
    <script src="/frontend/js/modules/leaflet/kama.js"></script>
    <script src="/frontend/js/modules/leaflet/leaflet.draw-src.js"></script>
    <script src="/frontend/js/modules/leaflet/turf.min.js"></script>
    <script src="/frontend/js/modules/leaflet/markercluster/markercluster-src.js"></script>

    <script>
        var refreshIntervalId;
        /*refreshIntervalId = setInterval(function() {
            $('.leaflet-marker-icon').on('dblclick', function() {
                if ($(this).attr('title') != undefined) {
                    mapClick($(this).attr('title'));
                }
            })
        }, 2000);*/
        function mapClick(id){
            $('#estate_id').val(id);
            searched();
        }
        function SetMapCluster(sr) {
            $.ajax({
                    url: `?mapexists=1&&${sr}`,
                    type: "get",
                    beforeSend: function() {
                        $("#spiner").removeClass("d-none");
                    }
                })
                .done(function(data) {
                    addressPoints = eval(data.map);
                    mp.setCluster();
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    $("#spiner").addClass("d-none");
                });
        }
        var defaultLocation = [{{ $city->posx }}, {{ $city->posy }}]; //tehran azadi
        mp = $('#map').kamaMap({
            zoom: 12,
            minZoom: 1,
            lat: defaultLocation[0],
            lng: defaultLocation[1]
        }).setPen().PenDrawBoundry(function(data) {
            $('#js_HiddenMapDrawPoints').val(data.points);
            $('#js_PenIsActive').val(1);
            searched();
        }, function() {
            ClearPenBoundry();
            $('#js_PenIsActive').val(0);
        });
        mp.drawBoundary($('#js_boundary').val(), '#00f', 0.0);
        function ClearPenBoundry() {
            $('#js_HiddenMapDrawPoints').val('');
            $('#js_PenIsActive').val('');
            searched();
        }
        //mp.panTo(new L.LatLng(40.737, -73.923), 8);
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
        function changeManufacturer() {
            $("select#project_id").html('<option value="" >Select</option>');
            var id = $('#manufacturer_id').val();
            $.get("/estate/projects/"+id, function (data, status) {
                if (data.status) {
                    //$('select#project_id').append('<option value="" >Select</option>');
                    $.each(data.result, function (i, item) {
                        $('select#project_id').append($('<option>', {
                            value: i,
                            text: item
                        }));
                    });

                }
            });
        }
    </script>



@endsection
