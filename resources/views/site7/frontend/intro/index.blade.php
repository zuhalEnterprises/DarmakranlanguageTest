@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])
@section('head')
<link rel="stylesheet" href="/vendor/swiper/swiper-bundle.min.css" />
<script src="/vendor/swiper/swiper-bundle.min.js"></script>
<script src="/js/theme7.js"></script>
<style>
        {{ l('#map { height: 0; /* ارتفاع پیش‌فرض */ overflow: hidden; transition: height 0.3s ease; } .h-260 { height: 260px !important; }') }}
    </style>
@endsection
@section('main_content')
<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')
    <section class="container mt-lg-5 pt-2 p-0" style="">
        <div class="row g-0 mt-n3">
            <input type="hidden" id="js_HiddenMapDrawPoints" style="width:0px;height:0px;overflow:hidden;border:0px" value="">
        </div>
    </section>
    <section class="mt-3 pt-3 mt-lg-none mb-2 d-lg-none">
        <div class="swiper  border-top border-bottom px-3 px-md-5">
            <!-- Additional required wrapper -->
            <div class="filter-box swiper-wrapper h-auto w-100 py-3 {{ (int)app('request')->input('kind') == 0 && (int)app('request')->input('type') == 0  ? 'd-none' : '' }}" id="filter" style="background:#f9f9f9;">
                <!-- Slides -->
                <a class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1" data-bs-toggle="offcanvas" data-title="t17" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: auto !important; border: 2px solid #c3c3c3;">
                    <i class="fi-filter-alt-horizontal"></i>
                    {{ l('فیلتر') }}
                </a>
                @php
                    $a11 = false;
                    $a12 = false;
                    $a21 = false;
                    $a22 = false;
                @endphp
                @if((int)app('request')->input('kind') > 0 && (int)app('request')->input('type') > 0)
                @php
                    if((int)app('request')->input('kind') == 1)
                    {
                        if((int)app('request')->input('type') == 1)
                        {
                            $nameEl="real-estate-sale";
                            $valueEl=l("املاک فروشی");
                            if(app('request')->input('estateTypes') == '')
                            {
                                $a11 = true;
                            }
                        }
                        else
                        {
                            $nameEl="real-estate-rental";
                            $valueEl=l("املاک اجاره");
                            if(app('request')->input('estateTypes') == '')
                            {
                                $a12 = true;
                            }
                        }
                    }
                    else
                    {
                        if((int)app('request')->input('type') == 1)
                        {
                            $nameEl="purchase-req";
                            $valueEl=l("تقاضاهای خرید");
                            if(app('request')->input('estateTypes') == '')
                            {
                                $a21 = true;
                            }
                        }
                        else
                        {
                            $nameEl="rent-req";
                            $valueEl=l("تقاضاهای اجاره");
                            if(app('request')->input('estateTypes') == '')
                            {
                                $a22 = true;
                            }
                        }
                    }
                @endphp
                <button class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1 btn-close-el" nameBtn="{{$nameEl}}" style="width: auto !important; border: 2px solid #c3c3c3;">{{$valueEl}} <i class="fi-x" onclick="search(0)"></i> </button>
                @endif
                @php
                    $a111 = false;
                    $a112 = false;
                    $a113 = false;
                    $a121 = false;
                    $a122 = false;
                    $a123 = false;
                    $a211 = false;
                    $a212 = false;
                    $a213 = false;
                    $a221 = false;
                    $a222 = false;
                    $a223 = false;

                    $parent = '0';
                @endphp
                @if(app('request')->input('estateTypes') != '')
                @php
                if((int)app('request')->input('kind') == 1)
                {
                    if((int)app('request')->input('type') == 1)
                    {
                        switch(app('request')->input('estateTypes'))
                        {
                            case '1,2,4,6,7':
                                $nameEl="sale-residential";
                                $valueEl=l("مسکونی");
                                $a111 = true;
                                $parent = '11';
                                break;
                            case '8,9,10,11,12,13':
                                $nameEl="sale-business";
                                $valueEl=l("تجاری");
                                $a112 = true;
                                $parent = '11';
                                break;
                            case '14,15':
                                $nameEl="sale-construction";
                                $valueEl=l("ساخت و ساز");
                                $a113 = true;
                                $parent = '11';
                                break;
                        }
                    }
                    else
                    {
                        switch(app('request')->input('estateTypes'))
                        {
                            case '1,2,4,7':
                                $nameEl="rental-residential";
                                $valueEl=l("مسکونی");
                                $a121 = true;
                                $parent = '12';
                                break;
                            case '8,9,10,11,12,13':
                                $nameEl="rental-business";
                                $valueEl=l("تجاری");
                                $a122 = true;
                                $parent = '12';
                                break;
                            case '1,2,4,6,7':
                                $nameEl="rental-construction";
                                $valueEl=l("کوتاه مدت");
                                $a122 = true;
                                $parent = '12';
                                break;
                        }

                    }
                }
                else
                {
                    if((int)app('request')->input('type') == 1)
                    {
                        switch(app('request')->input('estateTypes'))
                        {
                            case '1,2,4,6,7':
                                $nameEl="purchase-req-residential";
                                $valueEl=l("مسکونی");
                                $a211 = true;
                                $parent = '21';
                                break;
                            case '8,9,10,11,12,13':
                                $nameEl="purchase-req-business";
                                $valueEl=l("تجاری");
                                $a212 = true;
                                $parent = '21';
                                break;
                            case '14,15':
                                $nameEl="purchase-req-construction";
                                $valueEl=l("ساخت و ساز");
                                $a213 = true;
                                $parent = '21';
                                break;
                        }
                    }
                    else
                    {
                        switch(app('request')->input('estateTypes'))
                        {
                            case '1,2,4,7':
                                $nameEl="rent-req-residential";
                                $valueEl=l("مسکونی");
                                $a221 = true;
                                $parent = '22';
                                break;
                            case '8,9,10,11,12,13':
                                $nameEl="rent-req-business";
                                $valueEl=l("تجاری");
                                $a222 = true;
                                $parent = '22';
                                break;
                            case '1,2,4,6,7':
                                $nameEl="rent-req-construction";
                                $valueEl=l("ساخت و ساز");
                                $a223 = true;
                                $parent = '22';
                                break;
                        }
                    }
                }
                @endphp
                <button class="btn btn-primary btn-sm text-dark btn-light-primary fs-xs swiper-slide rounded-4 me-2 py-1 btn-close-el" nameBtn="{{$nameEl}}" style="width: auto !important; border: 2px solid #c3c3c3;">{{$valueEl}} <i class="fi-x" onclick="search({{$parent}})"></i> </button>
                @endif
            </div>
        </div>
    </section>
    <section class="container d-lg-none">
        <nav aria-label="breadcrumb" class="breadcrumb-box {{((int)app('request')->input('kind') > 0 && (int)app('request')->input('type') > 0)?'':'d-none'}}">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><div onclick="search(0)">{{ l('خانه') }}</div></li>
                @if((int)app('request')->input('kind') > 0 && (int)app('request')->input('type') > 0)
                <li class="breadcrumb-item"><a href="#">{{$valueEl}}</a></li>
                @endif
            </ol>
        </nav>
    </section>
    <section class="container mb-3 d-lg-none mt-2">
        <input type="hidden" name="kind" id="kind" value="{{ app('request')->input('kind') }}">
        <input type="hidden" name="type" id="type" value="{{ app('request')->input('type') }}">
        <input type="hidden" name="estateTypes" id="estateTypes" value="{{ app('request')->input('estateTypes') }}">
        <div>
            <!-- item -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{ (int)app('request')->input('kind') > 0 || (int)app('request')->input('type') >0  ? 'd-none' : '' }}" id="item2">
                <div class="item2 icon-box text-center estate-w" onclick="search(11)" codeid="11" parentEl="0" nameEl="real-estate-sale" valueEl=l("املاک فروشی")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <!-- <i class="fi-real-estate-buy"></i> -->
                        <img src="img/site7/residential-sell.png" alt="logo" style="width:55px;">
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('جستجوی') }}</span>
                        <span>{{ l('املاک فروشی') }}</span>
                    </p>
                </div>
                <div class="item2 icon-box text-center estate-w" onclick="search(12)" codeid="12" parentEl="0" nameEl="real-estate-rental" valueEl=l("املاک اجاره")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <!-- <i class="fi-apartment"></i> -->
                        <img src="img/site7/residential-rent.png" alt="logo" style="width:55px;">
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('جستجوی') }}</span>
                        <span>{{ l('املاک اجاره') }}</span>
                    </p>
                </div>
                <div class="item2 icon-box text-center estate-w" onclick="search(21)" codeid="21" parentEl="0" nameEl="purchase-req" valueEl=l("تقاضاهای خرید")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <!-- <i class="fi-shop"></i> -->
                        <img src="img/site7/commercial-sell.png" alt="logo" style="width:55px;">
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('جستجوی') }}</span>
                        <span>{{ l('تقاضای خرید') }}</span>
                    </p>
                </div>
                <div class="item2 icon-box text-center estate-w" onclick="search(22)" codeid="22" parentEl="0" nameEl="rent-req" valueEl=l("تقاضاهای اجاره")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <!-- <i class="fi-rent"></i> -->
                        <img src="img/site7/commercial-rent.png" alt="logo" style="width:55px;">
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('جستجوی') }}</span>
                        <span>{{ l('تقاضای اجاره') }}</span>
                    </p>
                </div>
            </div>
             <!-- sub-item -->
             <!-- املاک فروشی -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a11?'':'d-none'}}" nameEl="real-estate-sale">
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(111)" codeid="111" parentEl="11" nameEl="sale-residential" valueEl=l("مسکونی")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-building"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('املاک فروشی') }}</span>
                        <span>{{ l('مسکونی') }}</span>
                    </p>
                </div>
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(112)" codeid="112" parentEl="11" nameEl="sale-business" valueEl=l("تجاری")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-accounting"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('املاک فروشی') }}</span>
                        <span>{{ l('تجاری') }}</span>
                    </p>
                </div>
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(113)" codeid="113" parentEl="11" nameEl="sale-construction" valueEl=l("ساخت و ساز")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-billboard-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('املاک فروشی') }}</span>
                        <span>{{ l('ساخت و ساز') }}</span>
                    </p>
                </div>
            </div>
            <!-- املاک اجاره -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a12?'':'d-none'}}" nameEl="real-estate-rental">
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(121)" codeid="121" parentEl="12" nameEl="rental-residential" valueEl=l("مسکونی")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-building"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('املاک اجاره') }}</span>
                        <span>{{ l('مسکونی') }}</span>
                    </p>
                </div>
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(122)" codeid="122" parentEl="12" nameEl="rental-business" valueEl=l("تجاری")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-accounting"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('املاک اجاره') }}</span>
                        <span>{{ l('تجاری') }}</span>
                    </p>
                </div>
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(123)" codeid="123" parentEl="12" nameEl="rental-construction" valueEl=l("کوتاه مدت")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-accounting"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('املاک اجاره') }}</span>
                        <span>{{ l('کوتاه مدت') }}</span>
                    </p>
                </div>
            </div>
            <!-- تقاضاهای خرید -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a21?'':'d-none'}}" nameEl="purchase-req">
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(211)" codeid="211" parentEl="21" nameEl="purchase-req-residential" valueEl=l("مسکونی")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-building"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('تقاضای خرید') }}</span>
                        <span>{{ l('مسکونی') }}</span>
                    </p>
                </div>
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(212)" codeid="212" parentEl="21" nameEl="purchase-req-business" valueEl=l("تجاری")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-accounting"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('تقاضای خرید') }}</span>
                        <span>{{ l('تجاری') }}</span>
                    </p>
                </div>
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(213)" codeid="213" parentEl="21"  nameEl="purchase-req-construction" valueEl=l("ساخت و ساز")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-billboard-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('تقاضای خرید') }}</span>
                        <span>{{ l('ساخت و ساز') }}</span>
                    </p>
                </div>
            </div>
            <!-- تقاضاهای اجاره -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a22?'':'d-none'}}" nameEl="rent-req">
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(221)" codeid="221" parentEl="22"  nameEl="rent-req-residential" valueEl=l("مسکونی")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-building"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('تقاضای اجاره') }}</span>
                        <span>{{ l('مسکونی') }}</span>
                    </p>
                </div>
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(222)" codeid="222" parentEl="22"  nameEl="rent-req-business" valueEl=l("تجاری")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-accounting"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('تقاضای اجاره') }}</span>
                        <span>{{ l('تجاری') }}</span>
                    </p>
                </div>
                <div class="sub-item2 icon-box text-center estate-w" onclick="search(223)" codeid="223" parentEl="22" nameEl="rent-req-construction" valueEl=l("ساخت و ساز")>
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-billboard-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('تقاضای اجاره') }}</span>
                        <span>{{ l('کوتاه مدت') }}</span>
                    </p>
                </div>
            </div>
            <!-- sub-sub-item -->
            <!-- املاک فروشی مسکونی -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a111?'':'d-none'}}" nameEl="sale-residential">
                <div onclick="search(1111)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1111" valueEl=l("فروش آپارتمان") parentEl="111">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-apartment"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان') }}</span>
                    </p>
                </div>
                <div onclick="search(1112)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1112" valueEl=l("فروش آپارتمان") parentEl="111">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('منزل ویلایی') }}</span>
                    </p>
                </div>
                <div onclick="search(1114)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1114" valueEl=l("فروش زمین و خانه کلنگی") parentEl="111">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین و خانه کلنگی') }}</span>
                    </p>
                </div>
                <div onclick="search(1116)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1116" valueEl=l("فروش آپارتمان یک جا") parentEl="111">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان یک جا') }}</span>
                    </p>
                </div>
                <div onclick="search(1117)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1117" valueEl=l("فروش باغ و ویلا") parentEl="111">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('باغ و ویلا') }}</span>
                    </p>
                </div>
            </div>
            <!-- املاک فروشی تجاری -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a112?'':'d-none'}}" nameEl="sale-business">
                <div onclick="search(1128)"  class="sub-sub-item2 icon-box text-center estate-w" codeid="1128" valueEl=l("فروش زمین کشاورزی و باغ") parentEl="112">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-apartment"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین کشاورزی و باغ') }}</span>
                    </p>
                </div>
                <div onclick="search(1129)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1129" valueEl=l("فروش مغازه و غرفه") parentEl="112">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('مغازه و غرفه') }}</span>
                    </p>
                </div>

                <div onclick="search(11210)" class="sub-sub-item2 icon-box text-center estate-w" codeid="11210" valueEl=l("فروش زمین کشاورزی و باغ") parentEl="112">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('کارگاه و کارخانه') }}</span>
                    </p>
                </div>
                <div onclick="search(11211)" class="sub-sub-item2 icon-box text-center estate-w" codeid="11211" valueEl=l("فروش آپارتمان تجاری یک جا") parentEl="112">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان تجاری یک جا') }}</span>
                    </p>
                </div>
                <div onclick="search(11212)" class="sub-sub-item2 icon-box text-center estate-w" codeid="11212" valueEl=l("فروش دفتر کار و مطب") parentEl="112">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اداری, دفتر کار و مطب') }}</span>
                    </p>
                </div>
                <div onclick="search(11213)" class="sub-sub-item2 icon-box text-center estate-w" codeid="11213" valueEl=l("فروش زمین تجاری") parentEl="112">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین تجاری') }}</span>
                    </p>
                </div>
            </div>
             <!-- املاک فروشی ساخت و ساز -->
             <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a113?'':'d-none'}}" nameEl="sale-construction">
                <div onclick="search(11314)"  class="sub-sub-item2 icon-box text-center estate-w" codeid="11314" valueEl=l("مشارکت در ساخت و ساز") parentEl="113">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-apartment"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('مشارکت در ساخت و ساز') }}</span>
                    </p>
                </div>
                <div onclick="search(11315)"  class="sub-sub-item2 icon-box text-center estate-w" codeid="11315" valueEl=l("فروش پیش فروش") parentEl="113">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('پیش فروش') }}</span>
                    </p>
                </div>
            </div>
            <!-- املاک اجاره مسکونی -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a121?'':'d-none'}}" nameEl="rental-residential">
                <div onclick="search(1211)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1211" valueEl=l("اجاره آپارتمان") parentEl="121">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-apartment"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اجاره آپارتمان') }}</span>
                    </p>
                </div>
                <div onclick="search(1212)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1212" valueEl=l("اجاره ویلایی") parentEl="121">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اجاره ویلایی') }}</span>
                    </p>
                </div>
                <div onclick="search(1214)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1214" valueEl=l("اجاره زمین") parentEl="121">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اجاره زمین') }}</span>
                    </p>
                </div>
                <div onclick="search(1217)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1217" valueEl=l("اجاره باغ و ویلا") parentEl="121">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اجاره باغ و ویلا') }}</span>
                    </p>
                </div>
            </div>
            <!-- املاک اجاره تجاری -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a122?'':'d-none'}}" nameEl="rental-business">
                <div onclick="search(1228)"  class="sub-sub-item2 icon-box text-center estate-w" codeid="1228" valueEl=l("اجاره زمین کشاورزی و باغ") parentEl="122">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-apartment"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین کشاورزی و باغ') }}</span>
                    </p>
                </div>
                <div onclick="search(1229)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1229" valueEl=l("اجاره مغازه و غرفه") parentEl="122">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('مغازه و غرفه') }}</span>
                    </p>
                </div>
                <div onclick="search(12210)" class="sub-sub-item2 icon-box text-center estate-w" codeid="12210" valueEl=l("اجاره کارگاه و کارخانه") parentEl="122">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('کارگاه و کارخانه') }}</span>
                    </p>
                </div>
                <div onclick="search(12211)" class="sub-sub-item2 icon-box text-center estate-w" codeid="12211" valueEl=l("اجاره آپارتمان تجاری یک جا") parentEl="122">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان تجاری یک جا') }}</span>
                    </p>
                </div>
                <div onclick="search(12212)" class="sub-sub-item2 icon-box text-center estate-w" codeid="12212" valueEl=l("اجاره دفتر کار و مطب") parentEl="122">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اداری, دفتر کار و مطب') }}</span>
                    </p>
                </div>
                <div onclick="search(12213)" class="sub-sub-item2 icon-box text-center estate-w" codeid="12213" valueEl=l("اجاره زمین تجاری") parentEl="122">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین تجاری') }}</span>
                    </p>
                </div>
            </div>
             <!-- املاک اجاره کوتاه مدت -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a123?'':'d-none'}}" nameEl="rental-construction">
                <div onclick="search(1231)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1231" valueEl=l("اجاره روزانه آپارتمان") parentEl="123">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان') }}</span>
                    </p>
                </div>
                <div onclick="search(1232)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1232" valueEl=l("اجاره روزانه ویلایی") parentEl="123">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('منزل ویلایی') }}</span>
                    </p>
                </div>
                <div onclick="search(1234)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1234" valueEl=l("اجاره روزانه زمین") parentEl="123">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین') }}</span>
                    </p>
                </div>
                <div onclick="search(1236)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1236" valueEl=l("اجاره روزانه آپارتمان  یک جا") parentEl="123">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان یک جا') }}</span>
                    </p>
                </div>
                <div onclick="search(1237)" class="sub-sub-item2 icon-box text-center estate-w" codeid="1237" valueEl=l("اجاره روزانه باغ و ویلا") parentEl="123">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('باغ و ویلا') }}</span>
                    </p>
                </div>
            </div>
            <!-- sub-sub-item -->
            <!-- تقاضاهای خرید مسکونی -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a211?'':'d-none'}}" nameEl="purchase-req-residential">
                <div onclick="search(2111)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2111" valueEl=l("تقاضای خرید آپارتمان") parentEl="211">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-apartment"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان') }}</span>
                    </p>
                </div>
                <div onclick="search(2112)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2112" valueEl=l("تقاضای خرید ویلایی") parentEl="211">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('منزل ویلایی') }}</span>
                    </p>
                </div>
                <div onclick="search(2114)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2114" valueEl=l("تقاضای خرید زمین") parentEl="211">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین و خانه کلنگی') }}</span>
                    </p>
                </div>
                <div onclick="search(2116)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2116" valueEl=l("تقاضای خرید آپارتمان  یک جا") parentEl="211">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان یک جا') }}</span>
                    </p>
                </div>
                <div onclick="search(2117)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2117" valueEl=l("تقاضای خرید باغ و ویلا") parentEl="211">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('باغ و ویلا') }}</span>
                    </p>
                </div>
            </div>
            <!-- تقاضاهای خرید تجاری -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a212?'':'d-none'}}" nameEl="purchase-req-business">
                <div onclick="search(2128)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2128" valueEl=l("تقاضای خرید زمین کشاورزی و باغ") parentEl="212">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-apartment"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین کشاورزی و باغ') }}</span>
                    </p>
                </div>
                <div onclick="search(2129)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2129" valueEl=l("تقاضای خرید مغازه و غرفه") parentEl="212">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('مغازه و غرفه') }}</span>
                    </p>
                </div>

                <div onclick="search(21210)" class="sub-sub-item2 icon-box text-center estate-w" codeid="21210" valueEl=l("تقاضای خرید کارگاه و کارخانه") parentEl="212">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('کارگاه و کارخانه') }}</span>
                    </p>
                </div>
                <div onclick="search(21211)" class="sub-sub-item2 icon-box text-center estate-w" codeid="21211" valueEl=l("تقاضای خرید آپارتمان تجاری یک جا") parentEl="212">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان تجاری یک جا') }}</span>
                    </p>
                </div>
                <div onclick="search(21212)" class="sub-sub-item2 icon-box text-center estate-w" codeid="21212" valueEl=l("تقاضای خرید دفتر کار و مطب") parentEl="212">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اداری, دفتر کار و مطب') }}</span>
                    </p>
                </div>
                <div onclick="search(21213)" class="sub-sub-item2 icon-box text-center estate-w" codeid="21213" valueEl=l("تقاضای خرید زمین تجاری") parentEl="212">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین تجاری') }}</span>
                    </p>
                </div>


            </div>
             <!-- تقاضاهای خرید ساخت و ساز -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a213?'':'d-none'}}" nameEl="purchase-req-construction">
                <div onclick="search(21314)" class="sub-sub-item2 icon-box text-center estate-w" codeid="21314" valueEl=l("تقاضای مشارکت در ساخت و ساز") parentEl="213">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-apartment"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('مشارکت در ساخت و ساز') }}</span>
                    </p>
                </div>
                <div onclick="search(21315)" class="sub-sub-item2 icon-box text-center estate-w" codeid="21315" valueEl=l("تقاضای خرید پیش فروش") parentEl="213">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('پیش فروش') }}</span>
                    </p>
                </div>

            </div>
            <!-- sub-sub-item -->
            <!-- تقاضاهای اجاره مسکونی -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a221?'':'d-none'}}" nameEl="rent-req-residential">
                <div onclick="search(2211)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2211" valueEl=l("تقاضای اجاره آپارتمان") parentEl="221">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-apartment"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اجاره آپارتمان') }}</span>
                    </p>
                </div>
                <div onclick="search(2212)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2212" valueEl=l("تقاضای اجاره ویلایی") parentEl="221">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اجاره ویلایی') }}</span>
                    </p>
                </div>
                <div onclick="search(2214)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2214" valueEl=l("تقاضای اجاره زمین") parentEl="221">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اجاره زمین') }}</span>
                    </p>
                </div>
                <div onclick="search(2217)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2217" valueEl=l("تقاضای اجاره باغ و ویلا") parentEl="221">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اجاره باغ و ویلا') }}</span>
                    </p>
                </div>
            </div>
            <!-- تقاضاهای اجاره تجاری -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a222?'':'d-none'}}" nameEl="rent-req-business">
                <div onclick="search(2228)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2228" valueEl=l("تقاضای اجاره زمین کشاورزی و باغ") parentEl="222">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-apartment"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین کشاورزی و باغ') }}</span>
                    </p>
                </div>
                <div onclick="search(2229)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2229" valueEl=l("تقاضای اجاره مغازه و غرفه") parentEl="222">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('مغازه و غرفه') }}</span>
                    </p>
                </div>
                <div onclick="search(22210)" class="sub-sub-item2 icon-box text-center estate-w" codeid="22210" valueEl=l("تقاضای اجاره کارگاه و کارخانهر") parentEl="222">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('کارگاه و کارخانه') }}</span>
                    </p>
                </div>
                <div onclick="search(22211)" class="sub-sub-item2 icon-box text-center estate-w" codeid="22211" valueEl=l("تقاضای اجاره آپارتمان تجاری یک جا") parentEl="222">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان تجاری یک جا') }}</span>
                    </p>
                </div>
                <div onclick="search(22212)" class="sub-sub-item2 icon-box text-center estate-w" codeid="22212" valueEl=l("تقاضای اجاره دفتر کار و مطب") parentEl="222">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('اداری, دفتر کار و مطب') }}</span>
                    </p>
                </div>
                <div onclick="search(22213)" class="sub-sub-item2 icon-box text-center estate-w" codeid="22213" valueEl=l("تقاضای اجاره زمین تجاری") parentEl="222">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین تجاری') }}</span>
                    </p>
                </div>
            </div>
             <!-- تقاضاهای اجاره کوتاه مدت -->
            <div class="d-flex align-items-center justify-content-center gap-3 gap-lg-5 flex-wrap {{$a223?'':'d-none'}}" nameEl="rent-req-construction">
                <div onclick="search(2231)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2231" valueEl=l("تقاضای اجاره روزانه آپارتمان") parentEl="223">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-apartment"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان') }}</span>
                    </p>
                </div>
                <div onclick="search(2232)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2232" valueEl=l("تقاضای اجاره روزانه ویلایی") parentEl="223">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('منزل ویلایی') }}</span>
                    </p>
                </div>
                <div onclick="search(2234)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2234" valueEl=l("تقاضای اجاره روزانه زمین") parentEl="223">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('زمین') }}</span>
                    </p>
                </div>
                <div onclick="search(2236)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2236" valueEl=l("تقاضای اجاره روزانه آپارتمان یک جا") parentEl="223">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('آپارتمان یک جا') }}</span>
                    </p>
                </div>
                <div onclick="search(2237)" class="sub-sub-item2 icon-box text-center estate-w" codeid="2237" valueEl=l("تقاضای اجاره روزانه باغ و ویلا") parentEl="223">
                    <div class="icon-box-media bg-icons text-primary mb-2 mx-auto position-relative">
                        <i class="fi-real-estate-house"></i>
                    </div>
                    <p class="icon-box-title fs-base mb-0 fs-xs d-flex flex-column">
                        <span>{{ l('باغ و ویلا') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="container mb-5 pb-md-4  pt-2 mt-2 mt-lg-2">
        <div class="row align-items-start ">
            <aside class="d-none d-lg-block col-lg-3 position-sticky rounded pb-4 px-0" style="top: 130px;background:#fff;">
                <div class="px-3  fs-xs mb-3">{{ l('دسته ها') }}</div>
                <ul class="nav nav-pills flex-column mb-sm-auto align-items-center align-items-sm-start p-3  fs-sm cursor-pointer py-0 border-sidebar mx-2 " style="" id="menu">
                    <li class="item opacity-70 w-100 border-0 mb-3" style="display:{{ (int)app('request')->input('kind') != 2 && (int)app('request')->input('type') != 2 ? '' : 'none' }}">
                        <!-- <i class="fs-lg fi-real-estate-buy  mb-1"></i> -->
                        <img src="img/site7/residential-sell.png" alt="logo" style="width:32px;">
                        <span class="ms-2" onclick="search(11)">{{ l('جستجوی املاک فروشی') }}</span>
                        <ul class="sub-items list-unstyled me-4 ps-0 pe-2 mt-2" style="display:{{ app('request')->input('kind') != 1 || app('request')->input('type') != 1 ? 'none' : 'block' }}">
                            <li class="sub-item" onclick="search(111)" style="display:{{ app('request')->input('estateTypes') != '1,2,4,6,7' ? 'none' : 'block' }}">{{ l('مسکونی') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1111)" class="">{{ l('آپارتمان') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1112)" class="">{{ l('منزل ویلایی') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1114)" class="">{{ l('زمین و خانه کلنگی') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1116)" class="">{{ l('آپارتمان یک جا') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1117)" class="">{{ l('باغ و ویلا') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-item" onclick="search(112)" style="display:{{ app('request')->input('estateTypes') != '8,9,10,11,12,13' ? 'none' : 'block' }}">{{ l('تجاری') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1128)" class="">{{ l('زمین کشاورزی و باغ') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1129)" class="">{{ l('مغازه و غرفه') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(11210)" class="">{{ l('کارگاه و کارخانه') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(11211)" class="">{{ l('آپارتمان تجاری یک جا') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(11212)" class="">{{ l('اداری, دفتر کار و مطب') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(11213)" class="">{{ l('زمین تجاری') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-item" onclick="search(113)" style="display:{{ app('request')->input('estateTypes') != '11314,11315' ? 'none' : 'block' }}">{{ l('ساخت و ساز') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(11314)" class="">{{ l('مشارکت در ساخت و ساز') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(11315)" class="">{{ l('پیش فروش') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="item opacity-70 w-100 border-0 mb-3"  style="display:{{ app('request')->input('kind') != 2 && app('request')->input('type') != 1 ? '' : 'none' }}">
                        <img src="img/site7/residential-rent.png" alt="logo" style="width:32px;">
                        <span class="ms-2" onclick="search(12)">{{ l('جستجوی املاک اجاره') }}</span>
                        <ul class="sub-items list-unstyled me-4 ps-0 pe-2 mt-2" style="display:{{ app('request')->input('kind') != 1 || app('request')->input('type') != 2 ? 'none' : 'block' }}">
                            <li class="sub-item" onclick="search(121)" style="display:{{ app('request')->input('estateTypes') != '1,2,4,7' ? 'none' : 'block' }}">{{ l('اجاره مسکونی') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1211)" class="">{{ l('اجاره آپارتمان') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1212)" class="">{{ l('اجاره ویلایی') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1214)" class="">{{ l('اجاره زمین') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1217)" class="">{{ l('اجاره باغ و ویلا') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-item" onclick="search(122)" style="display:{{ app('request')->input('estateTypes') != '8,9,10,11,12,13' ? 'none' : 'block' }}">{{ l('اجاره تجاری') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1228)" class="">{{ l('زمین کشاورزی و باغ') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1229)" class="">{{ l('مغازه و غرفه') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(12210)" class="">{{ l('کارگاه و کارخانه') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(12211)" class="">{{ l('آپارتمان تجاری یک جا') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(12212)" class="">{{ l('اداری, دفتر کار و مطب') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(12213)" class="">{{ l('زمین تجاری') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-item" onclick="search(123)" style="display:{{ app('request')->input('estateTypes') != '1,2,4,6,7' ? 'none' : 'block' }}">{{ l('اجاره کوتاه مدت') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1231)" class="">{{ l('آپارتمان') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1232)" class="">{{ l('منزل ویلایی') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1234)" class="">{{ l('زمین') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1236)" class="">{{ l('آپارتمان یک جا') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(1237)" class="">{{ l('باغ و ویلا') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="item opacity-70 w-100 border-0 mb-3"  style="display:{{ app('request')->input('kind') != 1 && app('request')->input('type') != 2 ? '' : 'none' }}">

                        <img src="img/site7/commercial-sell.png" alt="logo" style="width:32px;">
                        <span class="ms-2" onclick="search(21)">{{ l('جستجوی تقاضاهای خرید') }}</span>
                        <ul class="sub-items list-unstyled me-4 ps-0 pe-2 mt-2" style="display:{{ app('request')->input('kind') != 2 || app('request')->input('type') != 1 ? 'none' : 'block' }}">
                            <li class="sub-item" onclick="search(211)" style="display:{{ app('request')->input('estateTypes') != '1,2,4,6,7' ? 'none' : 'block' }}">{{ l('تقاضای خرید مسکونی') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2111)" class="">{{ l('آپارتمان') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2112)" class="">{{ l('منزل ویلایی') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2114)" class="">{{ l('زمین و خانه کلنگی') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2116)" class="">{{ l('آپارتمان یک جا') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2117)" class="">{{ l('باغ و ویلا') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-item" onclick="search(212)" style="display:{{ app('request')->input('estateTypes') != '8,9,10,11,12,13' ? 'none' : 'block' }}">{{ l('تقاضای خرید تجاری') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0"  style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2128)" class="">{{ l('زمین کشاورزی و باغ') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2129)" class="">{{ l('مغازه و غرفه') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(21210)" class="">{{ l('کارگاه و کارخانه') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(21211)" class="">{{ l('آپارتمان تجاری یک جا') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(21212)" class="">{{ l('اداری, دفتر کار و مطب') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(21213)" class="">{{ l('زمین تجاری') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-item" onclick="search(213)" style="display:{{ app('request')->input('estateTypes') != '14,15' ? 'none' : 'block' }}">{{ l('تقاضای خرید ساخت و ساز') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(21314)" class="">{{ l('مشارکت در ساخت و ساز') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(21315)" class="">{{ l('پیش فروش') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="item opacity-70 w-100 border-0 mb-3"  style="display:{{ app('request')->input('kind') != 1 && app('request')->input('type') != 1 ? '' : 'none' }}">
                        <img src="img/site7/commercial-rent.png" alt="logo" style="width:32px;">
                        <span class="ms-2" onclick="search(22)">{{ l('جستجوی تقاضاهای اجاره') }}</span>
                        <ul class="sub-items list-unstyled me-4 ps-0 pe-2 mt-2" style="display:{{ app('request')->input('kind') != 2 || app('request')->input('type') != 2 ? 'none' : 'block' }}">
                            <li class="sub-item" onclick="search(221)" style="display:{{ app('request')->input('estateTypes') != '1,2,4,7' ? 'none' : 'block' }}">{{ l('تقاضا اجاره مسکونی') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2211)" class="">{{ l('اجاره آپارتمان') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2212)" class="">{{ l('اجاره ویلایی') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2214)" class="">{{ l('اجاره زمین') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2217)" class="">{{ l('اجاره باغ و ویلا') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-item" onclick="search(222)" style="display:{{ app('request')->input('estateTypes') != '8,9,10,11,12,13' ? 'none' : 'block' }}">{{ l('تقاضای اجاره تجاری') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2228)" class="">{{ l('زمین کشاورزی و باغ') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2229)" class="">{{ l('مغازه و غرفه') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(22210)" class="">{{ l('کارگاه و کارخانه') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(22211)" class="">{{ l('آپارتمان تجاری یک جا') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(22212)" class="">{{ l('اداری, دفتر کار و مطب') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(22213)" class="">{{ l('زمین تجاری') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sub-item" onclick="search(223)" style="display:{{ app('request')->input('estateTypes') != '1,2,4,6,7' ? 'none' : 'block' }}">{{ l('تقاضای اجاره ساخت و ساز') }}
                                <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" style="display:{{ app('request')->input('estateTypes') == '' ? 'none' : 'block' }}">
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2231)" class="">{{ l('آپارتمان') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2232)" class="">{{ l('منزل ویلایی') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2234)" class="">{{ l('زمین') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2236)" class="">{{ l('آپارتمان یک جا') }}</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="search(2237)" class="">{{ l('باغ و ویلا') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="border-sidebar mx-2">
                    <div class="accordion " id="side2">
                        <div class="accordion-item border-0" style="background:#fff;">
                            <h2 class="accordion-header">
                                <div class="accordion-button collapsed fs-sm opacity-75 px-1 "  data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse2" aria-expanded="true" aria-controls="panelsStayOpen-collapse2" style="background:#fff;">
                                    {{ l('امکانات') }}
                                </div>
                            </h2>
                            <div id="panelsStayOpen-collapse2" class="accordion-collapse collapse ">
                                <div class="accordion-body fs-sm">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="form-switch-1" type="checkbox">
                                        <label class="form-check-label" for="form-switch-1">{{ l('فقط فوری') }}</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="form-switch-2" type="checkbox" checked>
                                        <label class="form-check-label" for="form-switch-2">{{ l('عکس دار') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter_sidebar border-sidebar mx-2"  style="display:none;">
                    <div class="accordion " id="side_mahdode">
                        <div class="accordion-item border-0" style="background:#fff;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fs-sm opacity-75 px-1 " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-mahdode" aria-expanded="true" aria-controls="panelsStayOpen-collapse-mahdode" style="background:#fff;">
                                {{ l('محدوده قیمت') }}
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapse-mahdode" class="accordion-collapse collapse ">
                                <div class="accordion-body fs-sm">
                                        <div class="d-flex align-items-center">
                                            <input class="form-control w-100" dir="rtl" type="tel"  step="1" placeholder="{{ l('حداقل') }}" onchange="checkSend()">
                                            <div class="mx-2">—</div>
                                            <input class="form-control w-100" dir="rtl" type="tel"  step="1" placeholder="{{ l('حداکثر') }}" onchange="checkSend()">
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter_sidebar border-sidebar mx-2"  style="display:none;">
                    <div class="accordion " id="side_metr">
                        <div class="accordion-item border-0" style="background:#fff;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fs-sm opacity-75 px-1 " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-metr" aria-expanded="true" aria-controls="panelsStayOpen-collapse-metr" style="background:#fff;">
                                {{ l('متراژ (مترمربع)') }}
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapse-metr" class="accordion-collapse collapse ">
                                <div class="accordion-body fs-sm">
                                        <div class="d-flex align-items-center">
                                            <input class="form-control w-100" type="tel" dir="rtl" min="1" max="5000" step="1" placeholder="{{ l('حداقل') }}" id="minarea" onchange="checkSend()">
                                            <div class="mx-2">—</div>
                                            <input class="form-control w-100" type="tel" dir="rtl" min="1" max="5000" step="1" placeholder="{{ l('حداکثر') }}" id="maxarea" onchange="checkSend()">
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter_sidebar border-sidebar mx-2"  style="display:none;">
                    <div class="accordion " id="side_room">
                        <div class="accordion-item border-0" style="background:#fff;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fs-sm opacity-75 px-1 " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-room" aria-expanded="true" aria-controls="panelsStayOpen-collapse-room" style="background:#fff;">
                                {{ l('تعداد اتاق') }}
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapse-room" class="accordion-collapse collapse ">
                                <div class="accordion-body fs-sm">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter_sidebar border-sidebar mx-2"  style="display:none;">
                    <div class="accordion " id="side_age">
                        <div class="accordion-item border-0" style="background:#fff;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fs-sm opacity-75 px-1 " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-age" aria-expanded="true" aria-controls="panelsStayOpen-collapse-age" style="background:#fff;">
                                {{ l('سن بنا') }}
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapse-age" class="accordion-collapse collapse ">
                                <div class="accordion-body fs-sm">
                                        <select  class="form-control">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 mt-3">
                    <div class="d-flex flex-wrap gap-3 justify-content-center mb-3">
                        <a href="" class="opacity-60 text-dark fs-xs" >{{ l('درباره کلبه') }}</a>
                        <a href="" class="opacity-60 text-dark fs-xs">{{ l('تماس با ما') }}</a>
                        <a href="" class="opacity-60 text-dark fs-xs">{{ l('دریافت برنامه') }}</a>
                        <a href="" class="opacity-60 text-dark fs-xs">{{ l('پشتیبانی') }}</a>
                        <a href="" class="opacity-60 text-dark fs-xs">{{ l('قوانین') }}</a>
                    </div>
                    <div class="d-flex flex-wrap gap-4 justify-content-center">
                        <a href="" class="opacity-60 text-dark fs-6" ><i class="fi fi-whatsapp"></i></a>
                        <a href="" class="opacity-60 text-dark fs-6" ><i class="fi fi-telegram"></i></a>
                        <a href="" class="opacity-60 text-dark fs-6" ><i class="fi fi-skype"></i></a>
                        <a href="" class="opacity-60 text-dark fs-6" ><i class="fi fi-youtube"></i></a>
                    </div>
                </div>
            </aside>
            <main class="col-12 col-lg-9">
                <div class=" bg-primary rounded h-0 mb-4" id="map-el">

                </div>
                <div class="row g-4 {{ app('request')->input('kind')>0?'':'d-none' }}" id="loadingdiv">
                    @for ($i = 1 ; $i<=20 ; $i++)
                        <div class="col-md-6 col-lg-4">
                        <!-- Item-->
                            <div class="card border-0 shadow" aria-hidden="true">
                                <div class="position-relative placeholder-wave">
                                    <div class="card-img-top placeholder ratio ratio-4x3"></div>
                                    <i class="fi-image position-absolute top-50 start-50 translate-middle fs-1 opacity-40"></i>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title placeholder-glow">
                                        <span class="placeholder col-6"></span>
                                    </h5>
                                    <p class="card-text placeholder-glow">
                                        <span class="placeholder placeholder-sm col-7 me-2"></span>
                                        <span class="placeholder placeholder-sm col-4"></span>
                                        <span class="placeholder placeholder-sm col-4 me-2"></span>
                                        <span class="placeholder placeholder-sm col-6"></span>
                                        <span class="placeholder placeholder-sm col-8"></span>
                                    </p>

                                </div>
                            </div>
                        </div>
                    @endfor

                </div>
                <div class="row g-4" id="estate-wrapper">


                </div>
            </main>
        </div>
    </section>
    <!--div class="mb-4 container ">
        <div class="text-center fixed-button bg-faded-dark rounded p-2" style="bottom: 10% !important;">
            <button class="btn btn-lg btn-primary rounded-4 btn-sm order-lg-3 px-4 fs-6" id="toggleMap">
                <i class="fi-map me-2"></i>{{ l('نمایش نقشه') }}</button>
        </div>
    </div-->
</main>

@include(ss('THEME') . '.frontend.layouts.footer_v2')

<!-- Filters -->
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
@endsection
@section('js')

    <script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>

    <script>

        $(document).ready(function() { $('#toggleMap').click(function() { var $map = $('#map-el'); var $button = $(this); $map.toggleClass('h-260'); if ($map.hasClass('h-260')) { $button.text('بستن نقشه'); } else { $button.text('نمایش نقشه'); } }); });
    </script>
@endsection
