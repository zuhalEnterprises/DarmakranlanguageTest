@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])
@section('head')
<link rel="stylesheet" href="/vendor/swiper/swiper-bundle.min.css" />
<script src="/vendor/swiper/swiper-bundle.min.js"></script>

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
        width: 280px;
        position: fixed;
        top: 50px;
        overflow: auto;
        height: calc(100vh - 64px);
    }

    .main-search {
        width: auto;
        margin-right: 280px;
    }

    .icon-box-media {
        display: block;
        width: 5rem;
        height: 5rem;
    }
</style>
@endsection
@section('main_content')

<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')

    <div class="container mt-lg-5 pt-5 p-0" style="">
        <div class="row g-0 mt-n3">
            <!-- Filters sidebar (Offcanvas on mobile)-->
            <input type="hidden" name="type" id="type" value="1">
            <input type="hidden" name="view" id="view" value="1">
            <input type="hidden" name="districts" id="districts" value="">
            <input type="hidden" id="js_HiddenMapDrawPoints" style="width:0px;height:0px;overflow:hidden;border:0px" value="">

            <!-- Page content-->
            <div class="main col-12 position-relative overflow-hidden pb-5 px-3 mt-4">
                <!-- Breadcrumb-->
                <nav class="mt-4 pt-md-2 " aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{l('جستجوی املاک')}}</li>
                    </ol>
                </nav>
                <div class="w-100 py-3 px-3 px-md-5 start-0 border-top border-bottom mb-3" style="z-index:1029;background:#f9f9f9;">
                    <div class="swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper h-auto">
                            <!-- Slides -->
                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t7" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-city"></i>
                                {{ l('تعیین محل') }}
                            </a>
                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t5" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-house-chosen"></i>
                                {{ l('تعیین قیمت کل') }}
                            </a>

                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t8" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-real-estate-buy"></i>
                                {{ l('متراژ') }}
                            </a>
                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t9" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-double-bed"></i>
                                {{ l('تعداد اتاق') }}
                            </a>
                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t10" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-real-estate-buy"></i>
                                {{ l('تعیین سن بنا') }}
                            </a>
                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t1" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-users"></i>
                                {{ l('تعیین طبقه') }}
                            </a>


                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-billboard-house"></i>
                                {{ l('سند') }}
                            </a>

                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-house-chosen"></i>
                                {{ l('ویدئو دار') }}
                            </a>
                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-house-chosen"></i>
                                {{ l('عکس دار') }}
                            </a>
                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-house-chosen"></i>
                                {{ l('نمایش فقط فوری') }}
                            </a>
                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-house-chosen"></i>
                                {{ l('نمایش با آسانسور') }}
                            </a>
                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-house-chosen"></i>
                                {{ l('نمایش با پارکینگ') }}
                            </a>
                            <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t0" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                                <i class="fi-users"></i>
                                {{ l('فیلتر پیشرفته') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="d-none d-lg-block">
                    <div class="row g-3 mt-2 justify-content-center mb-4">
                        <div class=" col-md-3">
                            <a class=" icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 shadow-sm  " href="city-guide-catalog.html">
                                <div class="icon-box-media bg-faded-primary text-primary me-2 d-flex align-items-center justify-content-center">
                                    <i class="fi-entertainment fs-3"></i>
                                </div>
                                <div>
                                    <h3 class="icon-box-title fs-base ps-1 pe-2 mb-1">{{ l('فهرست مشاوران') }}</h3>
                                    <p class="mb-0 ps-1 pe-2 fs-sm">{{ l('همه اطلاعات و آگهیشان') }}</p>
                                </div>
                            </a>
                        </div>
                        <div class=" col-md-3">
                            <a class=" icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 shadow-sm  " href="city-guide-catalog.html">
                                <div class="icon-box-media bg-faded-primary text-primary me-2 d-flex align-items-center justify-content-center">
                                    <i class="fi-entertainment fs-3"></i>
                                </div>
                                <div>
                                    <h3 class="icon-box-title fs-base ps-1 pe-2 mb-1">{{ l('فهرست آژانس ها') }}</h3>
                                    <p class="mb-0 ps-1 pe-2 fs-sm">{{ l('همه اطلاعات و آگهیشان') }}</p>
                                </div>
                            </a>
                        </div>
                        <div class=" col-md-3">
                            <a class=" icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 shadow-sm  " href="city-guide-catalog.html">
                                <div class="icon-box-media bg-faded-success text-success me-2 d-flex align-items-center justify-content-center">
                                    <i class="fi-museum fs-3"></i>
                                </div>
                                <h3 class="icon-box-title fs-base ps-1 pe-2 mb-1">{{ l('عضویت مشاورین املاک') }}</h3>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row d-lg-none">
                    <div class="col">
                        <a class="icon-box  h-100 border-0 d-flex flex-column align-items-center justify-content-center text-center" href="/">
                            <div class="icon-box-media bg-faded-primary text-primary mb-3 d-flex align-items-center justify-content-center">
                                <i class="fi-rent"></i>
                            </div>
                            <h3 class="icon-box-title fs-xs mb-0">{{ l('فهرست مشاوران') }}</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a class="icon-box  h-100 border-0 d-flex flex-column align-items-center justify-content-center text-center" href="/">
                            <div class="icon-box-media bg-faded-primary text-primary mb-3 d-flex align-items-center justify-content-center">
                                <i class="fi-rent"></i>
                            </div>
                            <h3 class="icon-box-title fs-xs mb-0">{{ l('فهرست آژانس ها') }}</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a class="icon-box  h-100 border-0 d-flex flex-column align-items-center justify-content-center text-center" href="/">
                            <div class="icon-box-media bg-faded-primary text-primary mb-3 d-flex align-items-center justify-content-center">
                                <i class="fi-rent"></i>
                            </div>
                            <h3 class="icon-box-title fs-xs mb-0">{{ l('عضویت مشاورین') }}</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="container mb-5 pb-md-4">
        <div class="d-flex align-items-lg-center justify-content-start justify-content-lg-between mb-3 flex-column flex-lg-row">
            <a href="#" class="fs-base fw-bold mb-1 mb-lg-0 ">{{ l('همه املاک فروشی و اجاره ای(2500 آگهی)') }}</a>
            <a href="#" class="fs-base fw-bold mb-0 ">{{ l('همه مشتریان خرید و اجاره ملک(2500 آگهی)') }}</a>
        </div>
        <div class="row g-4">
            <!-- Item-->
            <div class=" col-md-4 col-lg-3">
                <div class="card shadow-sm card-hover border-0 h-100">
                    <div class="position-relative">
                        <div class="position-absolute start-0 top-0 pt-3 ps-3">
                            <span class="d-table badge bg-dark mb-1">{{ l('10 ملک مناسب') }}</span><span class="d-table badge bg-body">{{ l('2 روز پیش') }}</span>
                        </div>
                        <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('افزودن به علاقه مندی') }}" data-bs-original-title="{{ l('افزودن به علاقه مندی') }}"><i class="fi-heart"></i></button>
                        <img class="rounded-3" src="/img/site2/catalog/01.jpg" alt="Article img">
                    </div>
                    <div class="card-body position-relative pb-3">
                        <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">{{ l('مشتری اجاره') }}</h4>
                        <h3 class="h6 mb-2 fs-base d-flex justify-content-between">
                            <a class="nav-link stretched-link" href="site2-single-v1.html">{{ l('ویلا 2 طبقه | 150 متر مربع') }}</a>
                            <a class="">
                                <i class="fi-chat-circle"></i>
                            </a>
                        </h3>

                        <p class="mb-2 fs-sm text-muted">{{ l('آپارتمان مدرن در زنیبل آباد') }}</p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                                <span>{{ l('ودیعه از:') }}</span>
                                {{ l('140000000 ت') }}
                            </div>
                            <div>

                                <span>{{ l('تا:') }}</span>
                                {{ l('84000000 ت') }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                                <span>{{ l('اجاره از:') }}</span>
                                {{ l('400000 ت') }}
                            </div>
                            <div>

                                <span>{{ l('تا:') }}</span>
                                {{ l('5400000 ت') }}
                            </div>
                        </div>
                        <div>
                            <i class="fi-map-pin mt-n1 me-1 lead align-middle opacity-70"></i>
                            {{ l('قم ، زنبیل آباد ، جمهوری، یزدانشهر') }}
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap">
                        <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i>{{ l('3 خوابه') }}</span>
                        <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i>1398</span>
                        <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i>{{ l('270 متر') }}</span>
                    </div>
                </div>
            </div>
            <!-- Item-->
            <div class=" col-md-4 col-lg-3">
                <div class="card shadow-sm card-hover border-0 h-100">

                    <div class="position-relative">
                        <div class="position-absolute start-0 top-0 pt-3 ps-3">
                            <span class="d-table badge bg-primary mb-1">{{ l('10 مشتری مناسب') }}</span><span class="d-table badge bg-body">{{ l('5 روز پیش') }}</span>
                        </div>
                        <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('افزودن به علاقه مندی') }}" data-bs-original-title="{{ l('افزودن به علاقه مندی') }}"><i class="fi-heart"></i></button>
                        <img class="rounded-3" src="/img/site2/catalog/02.jpg" alt="Article img">
                    </div>
                    <div class="card-body position-relative pb-3">
                        <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">{{ l('ملک فروشی') }}</h4>
                        <h3 class="h6 mb-2 fs-base d-flex justify-content-between">
                            <a class="nav-link stretched-link" href="site2-single-v1.html">{{ l('ویلا 2 طبقه | 150 متر مربع') }}</a>
                            <a class="">
                                <i class="fi-chat-circle"></i>
                            </a>
                        </h3>
                        <p class="mb-2 fs-sm text-muted">{{ l('ویلا لوکس در یزدانشهر') }}</p>
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                                <span>{{ l('قیمت :') }}</span>
                                {{ l('140000 ت') }}
                            </div>

                        </div>
                        <div>
                            <i class="fi-map-pin mt-n1 me-1 lead align-middle opacity-70"></i>
                            {{ l('قم ، زنبیل آباد ، جمهوری، یزدانشهر') }}
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap">
                        <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i>{{ l('3 خوابه') }}</span>
                        <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i>1389</span>
                        <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i>{{ l('270 متر') }}</span>
                    </div>
                </div>
            </div>
            <!-- Item-->
            <div class=" col-md-4 col-lg-3">
                <div class="card shadow-sm card-hover border-0 h-100">
                    <div class="position-relative">
                        <div class="position-absolute start-0 top-0 pt-3 ps-3">
                            <span class="d-table badge bg-primary mb-1">{{ l('10 مشتری مناسب') }}</span><span class="d-table badge bg-body">{{ l('دیروز') }}</span>
                        </div>
                        <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('افزودن به علاقه مندی') }}" data-bs-original-title="{{ l('افزودن به علاقه مندی') }}"><i class="fi-heart"></i></button>
                        <img class="rounded-3" src="/img/site2/catalog/04.jpg" alt="Article img">
                    </div>
                    <div class="card-body position-relative pb-3 ">
                        <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">{{ l('ملک اجاره ای') }}</h4>
                        <h3 class="h6 mb-2 fs-base d-flex justify-content-between">
                            <a class="nav-link stretched-link" href="site2-single-v1.html">{{ l('ویلا 2 طبقه | 150 متر مربع') }}</a>
                            <a class="">
                                <i class="fi-chat-circle"></i>
                            </a>
                        </h3>
                        <p class="mb-2 fs-sm text-muted">{{ l('ویلا لوکس در زنبیل آباد') }}</p>
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                                <span>{{ l('رهن:') }}</span>
                                {{ l('140000000 ت') }}
                            </div>
                            <div>
                                <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                                <span>{{ l('اجاره:') }}</span>
                                {{ l('84000000 ت') }}
                            </div>
                        </div>
                        <div>
                            <i class="fi-map-pin mt-n1 me-1 lead align-middle opacity-70"></i>
                            {{ l('قم ، زنبیل آباد ، جمهوری، یزدانشهر') }}
                        </div>

                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap">
                        <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i>{{ l('3 خوابه') }}</span>
                        <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i>1390</span>
                        <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i>{{ l('270 متر') }}</span>
                    </div>
                </div>
            </div>


        </div>
    </section>
</main>




<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{ l('فیلترها') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body" id="sidebar" data-select2-id="select2-data-sidebar">
        <div class="pb-4 mb-2">
            <h3 class="h6 sidebar-item" tabindex="0" data-title="t0">{{ l('کد ملک') }}</h3>
            <input type="text" id="estate_id" name="estate_id" class="form-control" onchange="checkSend()">
        </div>
        <div class="pb-4 mb-2">
            <h3 class="h6 sidebar-item" data-title="t7" tabindex="0">{{ l('شهر') }}</h3>
            <select id="city_id" name="city_id" class="form-control">
                <option value="0">{{ l('انتخاب شهر') }}</option>
                <option value="7">
                    {{ l('لاهیجان') }}</option>
                <option value="58">
                    {{ l('رشت') }}</option>
                <option value="88">
                    {{ l('آستارا') }}</option>
                <option value="92">
                    {{ l('بندر انزلی') }}</option>
                <option value="145">
                    {{ l('آستانه اشرفیه') }}</option>
                <option value="146">
                    {{ l('ماسوله') }}</option>
                <option value="165">
                    {{ l('رودسر') }}</option>
                <option value="171">
                    {{ l('رانکوه') }}</option>
                <option value="196">
                    {{ l('فومن') }}</option>
                <option value="258">
                    {{ l('رودبار') }}</option>
                <option value="259">
                    {{ l('شفت') }}</option>
                <option value="260">
                    {{ l('صومعه‌سرا') }}</option>
                <option value="261">
                    {{ l('لنگرود') }}</option>
                <option value="262">
                    {{ l('تالش') }}</option>
                <option value="440">
                    {{ l('رضوان شهر') }}</option>
                <option value="585">
                    {{ l('خمام') }}</option>
                <option value="586">
                    {{ l('کیاشهر') }}</option>
                <option value="587">
                    {{ l('دیلمان') }}</option>
                <option value="588">
                    {{ l('اسالم') }}</option>
                <option value="590">
                    {{ l('رحیم‌آباد') }}</option>
                <option value="591">
                    {{ l('رستم‌آباد') }}</option>
                <option value="592">
                    {{ l('لشت نشا') }}</option>
                <option value="593">
                    {{ l('لوشان') }}</option>
                <option value="594">
                    {{ l('پره‌سر') }}</option>
                <option value="595">
                    {{ l('لوندویل') }}</option>
                <option value="596">
                    {{ l('رودبنه') }}</option>
                <option value="599">
                    {{ l('سیاهکل') }}</option>
                <option value="600">
                    {{ l('منجیل') }}</option>
                <option value="642">
                    {{ l('شلمان') }}</option>
                <option value="649">
                    {{ l('ماسال') }}</option>
                <option value="651">
                    {{ l('املش') }}</option>
            </select>
        </div>
        <div class="pb-4 mb-2">
            <h3 class="h6 sidebar-item" tabindex="0">{{ l('محله') }}</h3>
            <select id="city_id" name="city_id" class="form-control">
                <option value="1">{{ l('پردیسان') }}</option>
                <option value="2">{{ l('زنبیل آباد') }}</option>
                <option value="2">{{ l('جمهوری') }}</option>
                <option value="2">{{ l('بنیاد') }}</option>
            </select>
        </div>
        <div class="pb-4 mb-2">
            <h3 class="h6 sidebar-item" tabindex="0">{{ l('نوع ملک') }}</h3>
            <select class="form-select" name="estateTypes" id="estateTypes">
                <option value=""></option>
                <option value="2">{{ l('ویلایی') }}</option>
                <option value="1">{{ l('آپارتمان') }}</option>
                <option value="10">{{ l('زمین') }}</option>
                <option value="11">{{ l('تجاری') }}</option>
            </select>

        </div>
        <!-- <div class="pb-4 mb-2">
            <h3 class="h6 sidebar-item" data-title="t6" tabindex="0">{{ l('منطقه اقامتگاه') }}</h3>
            <select class="form-select" name="position_type" id="position_type">
                <option value=""></option>
                <option value="292">{{ l('ساحلی') }}</option>
                <option value="293">{{ l('جنگلی') }}</option>
                <option value="266">{{ l('بر خیابان اصلی') }}</option>
                <option value="267">{{ l('داخل کوچه') }}</option>
                <option value="268">{{ l('کنار جاده') }}</option>
                <option value="294">{{ l('داخل محدوده شهری') }}</option>
                <option value="295">{{ l('خارج محدوده شهری') }}</option>
                <option value="365">{{ l('ییلاقی') }}</option>
            </select>
        </div> -->
        <div class="pb-4 mb-2 js_rent">
            <h3 class="h6 sidebar-item active" data-title="t5" tabindex="0">{{ l('محدوده قیمت') }}</h3>
            <div class="d-flex align-items-center">
                <input class="form-control w-100" dir="rtl" type="tel" step="1" placeholder="{{ l('حداقل') }}" onchange="checkSend()">
                <div class="mx-2">—</div>
                <input class="form-control w-100" dir="rtl" type="tel" step="1" placeholder="{{ l('حداکثر') }}" onchange="checkSend()">
            </div>
        </div>

        <div class="pb-4 mb-2">
            <h3 class="h6 pt-1 sidebar-item" data-title="t8" tabindex="0">{{ l('متراژ (مترمربع)') }}</h3>
            <div class="d-flex align-items-center">
                <input class="form-control w-100" type="tel" dir="rtl" min="1" max="5000" step="1" placeholder="{{ l('حداقل') }}" id="minarea" onchange="checkSend()">
                <div class="mx-2">—</div>
                <input class="form-control w-100" type="tel" dir="rtl" min="1" max="5000" step="1" placeholder="{{ l('حداکثر') }}" id="maxarea" onchange="checkSend()">
            </div>
        </div>
        <div class="pb-4 mb-2">
            <h3 class="h6 sidebar-item pt-1" data-title="t9" tabindex="0">{{ l('تعداد اتاق') }}</h3>
            <div class="btn-group btn-group-sm" role="group" aria-label="Choose number of bedrooms">
                <input class="btn-check" type="radio" id="bedrooms-1" name="room_count" value="187" onchange="checkSend()">
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
            <h3 class="h6 sidebar-item pt-1" data-title="t10" tabindex="0">{{ l('سن بنا') }}</h3>
            <select class="form-control">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">+10</option>
            </select>
        </div>
        <div class="pb-4 mb-2">
            <h3 class="h6 sidebar-item pt-1" data-title="t1" tabindex="0">{{ l('طبقه') }}</h3>
            <select class="form-control">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">+10</option>
            </select>
        </div>


        <div class="pb-4 mb-2">
            <h3 class="h6">{{ l('امکانات') }}</h3>
            <div class="overflow-auto" data-simplebar="init" data-simplebar-auto-hide="false" data-simplebar-direction="rtl">
                <div class="simplebar-wrapper" style="margin: 0px;">
                    <div class="simplebar-height-auto-observer-wrapper">
                        <div class="simplebar-height-auto-observer"></div>
                    </div>
                    <div class="simplebar-mask">
                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;">
                                <div class="simplebar-content" style="padding: 0px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="closedoor" name="closedoor" value="352" onchange="checkSend()">
                                        <label class="form-check-label fs-sm" for="closedoor">{{ l('دربست') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="elevator" name="elevator" value="37" onchange="checkSend()">
                                        <label class="form-check-label fs-sm" for="elevator">{{ l('آسانسور') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="parking" name="parking" value="35" onchange="checkSend()">
                                        <label class="form-check-label fs-sm" for="parking">{{ l('پارکینگ') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="swimming" name="swimming" value="39" onchange="checkSend()">
                                        <label class="form-check-label fs-sm" for="swimming">{{ l('استخر') }}</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simplebar-placeholder" style="width: auto; height: 150px;"></div>
                </div>
                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar simplebar-visible" style="width: 0px; display: none;"></div>
                </div>
                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                    <div class="simplebar-scrollbar simplebar-visible" style="height: 0px; display: none;"></div>
                </div>
            </div>
        </div>
        <div class="sticky py-4">
            <button class=" btn btn-primary w-100" type="button" onclick="searched()">
                <i class=" me-2"></i>{{ l('جستجو') }}
            </button>
        </div>
    </div>
</div>


<button class="btn btn-primary btn-sm w-100 rounded-0 fixed-bottom d-lg-none zindex-0 d-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#filters-sidebar"><i class="fi-filter me-2"></i>{{ l('فیلترها') }}</button>
@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')

<script type="text/javascript">
    const swiper = new Swiper('.swiper', {
        // Optional parameters
        // direction: 'vertical',
        // freeMode: true,
        loop: false,
        spaceBetween: 50,
        slidesPerView: 1.5,
        spaceBetween: 17,

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
                slidesPerView: 15,
                spaceBetween: 60
            }
        }
    });
</script>

<script>
    $(document).ready(function() {
        $(".swiper-wrapper a").on("click", function() {
            const target = $(this).data("title");
            showSidebar(target);
        });
    });

    function showSidebar(target) {
        const $sidebar = $("#sidebar");
        const $sidebarItem = $(".sidebar-item[data-title='" + target + "']");
        // $sidebar.fadeIn();

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




@endsection