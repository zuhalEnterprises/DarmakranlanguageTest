@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('املاک رضوان شهر | خرید ملک در رضوان شهر و پره سر | املاک گیلان'),
    'metaDescription' => l('گیلند ملک فعالترین مشاور املاک گیلان در شمال, جهت خرید و فروش ویلا جنگلی، ساحلی، ییلاقی، باغ، زمین، آپارتمان و ملک در رضوانشهر با کارشناسان با تجربه'),
    'canonical' => '/'
])

@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <link rel="stylesheet" media="screen" href="/vendor/expandable/jquery.expandable.css" />
        <style>

            .gradient-bg {
                    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.3));
                    padding: 10px;

            }

            .img_expert {
                height: 330px;
            }
            @media (min-width:768px) {
                .img_expert {
                height: 230px;
            }
            }
            .back_card_state {
                position: relative;
                padding-top: 35px;
                padding-bottom: 35px;
                background-color: #5C0262;
                background-image: linear-gradient(rgba(92, 2, 98, 0.75), rgb(92, 2, 98)), url(/img/site2/home-discounted-rooms-bg.webp);
                background-size: 150px;
            }
            .tns3-item0 *{color:#fff !important}
            </style>
        <style>
            @php
                $rand = rand(1,19);
            @endphp
            .object-fit {
                object-fit: cover;
            }
            .image_v {
                background-image: url({{crop('/img/site2/gilan'.$rand.'.jpg' , 1000 , 650)}});
                background-attachment: inherit;
                background-size: cover;
                background-position: center;
            }
            .image_x {
                background-image: url({{crop('/img/site2/gilan'.$rand.'.jpg' , 1000 , 650)}});
                background-attachment: inherit;
                background-size: cover;
                background-position: center;
            }

            .hero-box {
                position: absolute;
                z-index: 100;
                width: 100%;
                bottom: 0;
                transform: translateY(0) ;
                max-width: 300px;

            }

            .h1-hero {
                background-color: none;
                padding-bottom: 100px !important;
            }

            @media (min-width: 776px) {
                .hero-box {
                    bottom: 13%;
                }
               .image_v {
                    background-image: url({{crop('/img/site2/gilan'.$rand.'.jpg' , 1272 , 1272)}});
                }
              .image_x {
                    background-image: url({{crop('/img/site2/gilan'.$rand.'.jpg' , 1272 , 1272)}});
               }
             }

            @media (min-width: 500px) {
                .hero-box {
                    max-width: 360px;
                }
            }

            @media (min-width: 768px) {
                .hero-box {
                    transform: translateY(50%);
                    max-width: 856px;
                }
                .h1-hero {
                background-color: #00000078;
                padding-bottom: 20px !important;
                }
            }


            .back-komeh{
                background-color: #fff;
                background-image: url(/img/site3/banner-h-6.jpg.webp);
                background-position: top center;
                background-repeat: no-repeat;
            }
        </style>


        <section class="container mt-5 mb-lg-3 my-lg-5 pt-3 pt-lg-5 pb-lg-4 px-xxl-4">
                <div class="tns-carousel-wrapper">
                    <div class="tns-carousel-inner" data-carousel-options='{"mode": "gallery", "nav": true , "autoplay":false , "interval":10000}'>
                        <div>
                            <div class="bg-faded-primary text-center py-5 px-3 image_v rounded">
                                <div class="jarallax card align-items-center justify-content-center border-0 p-md-5 p-4 mt-n3 bg-transparent" style="min-height: 500px;border-radius:unset " data-jarallax data-speed="0.5">
                                    <span class="img-overlay opacity-40"></span>
                                    <h1 class="display-5  px-md-3  text-white text-center zindex-1 bg-opacity-50  rounded-2 h1-hero from-top">
                                        {{ l('املاک گیلان، خرید ملک در رضوانشهر') }}
                                    </h1>
                                    <div class="content-overlay hero-box from-bottom delay-2" style="">
                                        <form class="shadow-sm form-group d-block" style="border:0" method="get" action="/c/{{ $selectedCity }}">
                                            <div class="row g-0" >
                                                <div class="col-md-10 d-sm-flex align-items-center">
                                                    <div class="dropdown w-sm-50 border-end-sm" data-bs-toggle="select">
                                                        <i class="fi-home me-2" style="margin-right:10px"></i>
                                                        <select name="type" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 text-dark">
                                                            <option value="1">{{ l('فروش') }}</option>
                                                            <option value="2">{{ l('اجاره') }}</option>
                                                        </select>

                                                    </div>
                                                    <hr class="d-sm-none my-2">
                                                    <div class="dropdown w-sm-50 border-end-sm" data-bs-toggle="select">
                                                        <i class="fi-map-pin me-2" style="margin-right:10px"></i>
                                                        <select id="city_id" name="city_id" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 text-dark" style="width:122px">
                                                            <option value="">{{ l('انتخاب شهر') }}</option>
                                                            @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <hr class="d-sm-none my-2">
                                                    <div class="dropdown w-sm-50" data-bs-toggle="select">
                                                        <i class="fi-list me-2" style="margin-right:10px"></i>
                                                        <select name="estateType" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 text-dark">
                                                            <option value="">{{ l('انتخاب نوع ملک') }}</option>
                                                            <option value="1">{{ l('آپارتمان') }}</option>
                                                            <option value="2">{{ l('ویلایی') }}</option>
                                                            <option value="3">{{ l('مغازه') }}</option>
                                                            <option value="4">{{ l('زمین و باغ') }}</option>
                                                            <option value="5">{{ l('صنعتی و تجاری') }}</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <hr class="d-md-none mt-2">
                                                <div class="col-md-2 d-sm-flex align-items-center pt-3 pt-md-0">
                                                    <button class="btn btn-sm btn-icon btn-primary px-3 w-100" type="submit">{{ l('جستجو') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="bg-faded-primary text-center py-5 px-3 image_x rounded" style="">

                                <div class="jarallax card align-items-center justify-content-center border-0 p-md-5 p-4 mt-n3 bg-transparent" style="min-height: 500px;border-radius:unset " data-jarallax data-speed="0.5">

                                    <span class="img-overlay opacity-40"></span>
                                    <a href="/rental" >
                                        <h2 class="display-5  px-md-3  text-white text-center zindex-1 bg-opacity-50  rounded-2 h1-hero from-start">
                                        {{ l('اجاره ویلای روزانه و کوتاه مدت در گیلان') }}
                                        </h2>
                                    </a>
                                    <div class="content-overlay hero-box from-end delay-2" style="">
                                        <form class="form-group d-block d-md-flex position-relative rounded-md-pill me-lg-n5" method="get" action="/rental/search">
                                            <div class="input-group input-group-lg border-end-md">
                                                <span class="input-group-text text-muted rounded-pill ps-3"><i class="fi-search"></i></span>
                                                <select id="city_id" name="city_id" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 " >
                                                    <option value="">{{ l('میخواهید کجا بری؟') }}</option>
                                                    @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <hr class="d-md-none my-2">
                                            <div class="input-group input-group-lg border-end-md">
                                                <span class="input-group-text text-muted rounded-pill ps-3"><i class="fi-friends"></i></span>
                                                <select id="max_person" name="max_person" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 " >
                                                    <option value="">{{ l('چند نفرید؟') }}</option>
                                                    <option value="1">{{ l('1 نفر') }}</option>
                                                    <option value="2">{{ l('2 نفر') }}</option>
                                                    <option value="3">{{ l('3 نفر') }}</option>
                                                    <option value="4">{{ l('4 نفر') }}</option>
                                                    <option value="5">{{ l('5 نفر') }}</option>
                                                    <option value="6">{{ l('6 نفر') }}</option>
                                                    <option value="7">{{ l('7 نفر') }}</option>
                                                    <option value="8">{{ l('8 نفر') }}</option>
                                                    <option value="9">{{ l('9 نفر') }}</option>
                                                    <option value="10">{{ l('10 نفر') }}</option>
                                                    <option value="11">{{ l('11 نفر') }}</option>
                                                    <option value="12">{{ l('12 نفر') }}</option>
                                                    <option value="13">{{ l('13 نفر') }}</option>
                                                    <option value="14">{{ l('14 نفر') }}</option>
                                                    <option value="15">{{ l('15 نفر') }}</option>
                                                </select>
                                                <button class="btn btn-primary btn-lg rounded-pill w-100 w-md-auto me-sm-3" type="submit">{{ l('جستجو') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <hr class="mt-n1 mb-5 d-md-none  d-lg-none">

        <section class="container ">
            <div class="row m-1">
                <div class="col-lg-3 col-md-6 col-6 mb-2">
                    <a href="/c/rezvanshahr?type=1&view=1&maxprice=3000000000">
                        <img src="/img/site2/price1.jpg" class="rounded-1" style="width: 100%">
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-2">
                    <a href="/c/rezvanshahr?type=1&view=1&minprice=3000000000&maxprice=6000000000">
                        <img src="/img/site2/price2.jpg" class="rounded-1" style="width: 100%">
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-2">
                    <a href="/c/rezvanshahr?type=1&view=1&minprice=6000000000&maxprice=10000000000">
                        <img src="/img/site2/price3.jpg" class="rounded-1" style="width: 100%">
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-2">
                    <a href="/c/rezvanshahr?type=1&view=1&minprice=10000000000&maxprice=15000000000">
                        <img src="/img/site2/price4.jpg" class="rounded-1" style="width: 100%">
                    </a>
                </div>
            </div>
        </section>
        <section class="container d-lg-none mt-0">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-4 mb-2">
                    <a class="nav-link p-0 fw-normal opacity-80 text-accent" style="text-align: center" aria-label="instagram" href="https://www.instagram.com/gilanmelk_.ir">
                        <i class="fi-instagram" style="font-size:3rem"></i>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-4 mb-2">
                    <a class="nav-link p-0 fw-normal opacity-80 text-info" style="text-align: center"  rel="nofollow" aria-label="telegram" href="https://t.me/gilandmelk">
                        <i class="fi-telegram-circle" style="font-size:3rem"></i>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-4 mb-2">
                        <a class="nav-link p-0 fw-normal opacity-80 text-primary"  style="text-align: center"  rel="nofollow" aria-label="whatsapp" href="javascript:void(0)">
                            <i class="fi-whatsapp" style="font-size:3rem"></i>
                        </a>
                </div>

            </div>
        </section>
        <section class="container mb-5 pb-md-4 mt-lg-0 pt-lg-3">
            <div class="d-flex flex-column flex-md-row gap-3 gap-lg-0 align-items-lg-center align-items-start justify-content-between mb-3">
                <h2 class="h3 mb-0 ">{{ l('جدیدترین خانه های خرید و فروش') }}</h2>
                <a class="btn btn-link fw-normal p-0"
                    href="/c/{{ $selectedCity }}?type=1">{{ l('مشاهده همه') }}<i class="fi-arrow-long-left ms-2"></i>
                </a>
            </div>
            <div class="" dir="ltr">
                <div class="row">
                    <!-- Item-->
                    @foreach ($estates as $estate)
                    <div class="col-lg-4 col-sm-12 mt-3">
                        <!-- Static content overlay -->
                        <div class="card bg-size-cover bg-position-center border-0 overflow-hidden" style="background-image: url('{{crop($estate->coverImage(),416,416) }}'); max-width: 636px;height:310px;">
                            <a href="{{$estate->url()}}" class="img-over"></a>
                                <div class="card-body content-overlay pb-0">
                                    <span class="badge bg-info fs-sm">{{ toPersianDate($estate->showdate) }}</span>
                                </div>
                                <div class="card-footer  border-0  pb-4 gradient-bg">
                                    <h3 class="h6 mb-2 fs-base">
                                        <a target="_blank" class="nav-link stretched-link text-white" href="{{$estate->url()}}">
                                            {{ estateTypes($estate->estate_type) . l('در') . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? '') }}</a>
                                    </h3>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="fs-sm opacity-70 text-white"><i class="fi-cash  ms-1"></i> {{ toPersianNumbers($estate->{{ l('price) }} ت') }}</div></a>
                                        <div class="fs-sm opacity-70 text-white"><i class="fi-cash  ms-1"></i> {{ toPersianNumbers($estate->{{ l('price_per_meter) }} متری') }}</div></a>

                                    </div>
                                    <div class="text-white opacity-70 mt-3 text-center">
                                        @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-layers me-1 mt-n1 fs-lg"></i>
                                            {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                        </span>
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-geo me-1 mt-n1 fs-lg"></i>
                                            {{ getFeatureValue($featureValues, $estate->geography) }}
                                        </span>
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-clock me-1 mt-n1 fs-lg"></i> ساخت:
                                            {{ buildYear($estate->built_year) }}
                                        </span>
                                        @endif

                                        @if ($estate->estate_type == 3 || $estate->estate_type == 4)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-layers me-1 mt-n1 fs-lg"></i>
                                            {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                        </span>
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-geo me-1 mt-n1 fs-lg"></i>
                                            {{ getFeatureValue($featureValues, $estate->geography) }}
                                        </span>
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-real-estate-buy me-1 mt-n1 fs-lg"></i>
                                            @if ($estate->type == 1)
                                            {{ getFeatureValue($featureValues, $estate->document_type) }}
                                            @endif
                                            @if ($estate->type == 2)
                                            {{ getFeatureValue($featureValues, $estate->convertible) }}
                                            @endif
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="container py-5 mt-5 mb-lg-3">
            <div class="row align-items-center mt-md-2">
                <div class="col-lg-7 order-lg-2 mb-lg-0 mb-4 pb-2 pb-lg-0">
                    <img class="d-block mx-auto" src="/img/site2/hero-img.jpg" width="746" alt="Hero image">
                </div>
                <div class="col-lg-5 order-lg-1 pe-lg-0">
                    <a href="/rental" title="{{ l('اجاره ویلای روزانه و کوتاه مدت در گیلان') }}">
                        <h2 class="display-4 mb-4 ms-lg-n5 text-lg-start text-right" style="line-height: unset;font-weight:500">{{ l('اجاره ویلای روزانه و کوتاه مدت در گیلان') }}

                        </h2>
                    </a>
                    <p class="text-lg-start text-right mb-4 mb-lg-3 fs-lg">{{ l('جستجوی خود را آغاز کنید - مقصدتان کجاست؟') }}</p>
                    <!-- Search form-->
                    <div class="ms-lg-n5">
                        <form class="form-group d-block d-md-flex position-relative rounded-md-pill me-lg-n5" method="get" action="/rental/search">
                            <div class="input-group input-group-lg border-end-md">
                                <span class="input-group-text text-muted rounded-pill ps-3"><i class="fi-search"></i></span>
                                <select id="city_id" name="city_id" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 ">
                                    <option value="">{{ l('میخواهید کجا بری؟') }}</option>
                                    @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr class="d-md-none my-2">
                            <div class="input-group input-group-lg border-end-md">
                                <span class="input-group-text text-muted rounded-pill ps-3"><i class="fi-friends"></i></span>
                                <select id="max_person" name="max_person" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 ">
                                    <option value="">{{ l('چند نفرید؟') }}</option>
                                    <option value="1">{{ l('1 نفر') }}</option>
                                    <option value="2">{{ l('2 نفر') }}</option>
                                    <option value="3">{{ l('3 نفر') }}</option>
                                    <option value="4">{{ l('4 نفر') }}</option>
                                    <option value="5">{{ l('5 نفر') }}</option>
                                    <option value="6">{{ l('6 نفر') }}</option>
                                    <option value="7">{{ l('7 نفر') }}</option>
                                    <option value="8">{{ l('8 نفر') }}</option>
                                    <option value="9">{{ l('9 نفر') }}</option>
                                    <option value="10">{{ l('10 نفر') }}</option>
                                    <option value="11">{{ l('11 نفر') }}</option>
                                    <option value="12">{{ l('12 نفر') }}</option>
                                    <option value="13">{{ l('13 نفر') }}</option>
                                    <option value="14">{{ l('14 نفر') }}</option>
                                    <option value="15">{{ l('15 نفر') }}</option>
                                </select>
                                <button class="btn btn-primary btn-lg rounded-pill w-100 w-md-auto me-sm-3" type="submit">{{ l('جستجو') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>



        <!-- Top offers (carousel)-->

        <section class="bg-primary mb-5">
            <div class="container py-5">
                <div class="d-flex flex-column flex-lg-row gap-4 justify-content-between align-items-center">
                    <h2 class="mb-0 text-white mt-4 mt-md-0">{{ l('مشاوره رایگان خرید و اجاره ملک') }}</h2>
                    <div class="d-flex align-items-center gap-4">
                        <div class="text-white">
                            <p class="mb-2 text-white fs-5">{{ l('همین حالا تماس بگیرید') }}</p>
                            <a class="text-white text-decoration-none fs-6" href="tel:09129406124">09129406124 </a>
                            &nbsp;
                            <a class="text-white text-decoration-none fs-6" href="tel:09133386608">09133386608 </a>
                        </div>
                        <i class="fi-phone text-white fs-3"></i>
                    </div>
                </div>
            </div>
        </section>
        <section class="container mb-5 pb-md-4 ">
            <div class="d-flex flex-column flex-md-row gap-3 gap-lg-0 align-items-lg-center align-items-start justify-content-between mb-3">
                <h2 class="h3 mb-0 ">{{ l('جدیدترین املاک رهن و اجاره') }}</h2>
                <a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?type=2">
                    {{ l('مشاهده همه') }} <i class="fi-arrow-long-left ms-2"></i></a>
            </div>
            <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2 "
                dir="rtl">
                <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4"
                    data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                    <!-- Item-->

                    @foreach ($estatesr as $estate)
                        <div class="col">
                            <div class="card shadow-sm card-hover border-0 h-100">
                                <div class="card-img-top card-img-hover">
                                    <a class="link-img img-gradient-overlay"  target="_blank" href="{{$estate->url()}}"></a>
                                    <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                        <span
                                            class="d-table badge bg-info mb-1">{{ toPersianDate($estate->created_at) }}</span>
                                        <span
                                            class="d-table badge bg-primary">{{ estateTypes($estate->estate_type) }}</span>
                                    </div>
                                    <div class="content-overlay end-0 top-0 pt-3 ps-3">

                                    </div>
                                    <img src="{{ $estate->coverImage() }}"
                                        style="height: 200px;width:100%;object-fit:cover"
                                        data-src="{{ crop($estate->coverImage(),304,304) }}" alt="{{ $estate->title }}">

                                        <div class="position-absolute bottom-0 pb-2 px-3 zindex-10">
                                        <h3 class="h6 mb-2 fs-base">
                                        <a target="_blank" class="nav-link stretched-link text-white" href="{{$estate->url()}}">
                                            {{ $estate->title }}</a>
                                        </h3>
                                       @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                                            <span class="d-inline-block px-2 fs-sm text-white">
                                                <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                                {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                            </span>
                                            <span class="d-inline-block px-2 fs-sm text-white">
                                                <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                                {{ getFeatureValue($featureValues, $estate->geography) }}
                                            </span>
                                            <span class="d-inline-block px-2 fs-sm text-white">
                                                <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> ساخت:
                                                {{ buildYear($estate->built_year) }}
                                            </span>
                                        @endif
                                        @if ($estate->estate_type == 3 || $estate->estate_type == 4)
                                            <span class="d-inline-block px-2 fs-sm text-white">
                                                <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                                {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                            </span>
                                            <span class="d-inline-block px-2 fs-sm text-white">
                                                <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                                {{ getFeatureValue($featureValues, $estate->geography) }}
                                            </span>
                                            <span class="d-inline-block px-2 fs-sm text-white">
                                                <i class="fi-real-estate-buy me-1 mt-n1 fs-lg text-muted"></i>
                                                @if ($estate->type == 1)
                                                    {{ getFeatureValue($featureValues, $estate->document_type) }}
                                                @endif
                                                @if ($estate->type == 2)
                                                    {{ getFeatureValue($featureValues, $estate->convertible) }}
                                                @endif
                                            </span>
                                        @endif
                                </div>

                                </div>

                                <div
                                    class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">

                                        <div class="d-flex justify-content-between align-content-center w-100">
                                            <div>
                                                <i class="fi-cash lead align-middle opacity-70"></i>
                                                {{ toPersianNumbers($estate->{{ l('mortgage) }} رهن') }}
                                            </div>
                                            <div>
                                                <i class="fi-cash lead align-middle opacity-70"></i>
                                                {{ toPersianNumbers($estate->{{ l('rent) }} اجاره') }}
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @if (!empty($estateGilan) && count($estateGilan)>0)
        <section class=" mb-5 back_card_state py-5 tns3-item0">
            <div class="container">
                <div class="d-flex flex-column flex-md-row gap-3 gap-lg-0 align-items-lg-center align-items-start justify-content-between mb-4 pb-2">
                    <h2 class="h4 mb-sm-0 font-vazir text-white">{{ l('اجاره روزانه ویلا در رضوانشهر') }}</h2>
                    <a class="btn btn-link fw-normal ms-sm-3 p-0 text-white" href="/rental/search">{{ l('مشاهده همه') }}<i class="fi-arrow-long-left ms-2"></i></a>
                </div>
                <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside">
                    <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 3, &quot;gutter&quot;: 24, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1400&quot;:{&quot;items&quot;:3,&quot;nav&quot;:false}}}">
                        @foreach($estateGilan as $estate)
                        <!-- Item-->
                    <div>
                        <div class="position-relative">
                            <div class="position-relative mb-3">
                                <button class="d-none btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ l('نشان کردن') }}"><i class="fi-heart"></i></button>
                                <img class="rounded-3" src="{{crop($estate->coverImage(),416,416)}}" style="height: 250px;
                                object-fit: cover;width:100%" alt="اجاره روزانه {{ estateTypes($estate->estate_type) }} در {{($estate->city->name ?? '')}}">
                            </div>
                            <h3 class="mb-2 fs-lg"><a class="nav-link stretched-link" href="/room/{{ $estate->id }}">اجاره روزانه {{ estateTypes($estate->estate_type) }} در {{($estate->city->name ?? '')}}</a></h3>
                            <ul class="list-inline mb-0 fs-sm">
                                <li class="list-inline-item pe-1">
                                    {{ !empty($fieldList['room_count'][$estate->room_count]) && $fieldList['room_count'][$estate->room_count] != l('سوئیت') ? $fieldList['room_count'][$estate->room_count] .' '. l('خوابه') : l('سوئیت') }} . {{$estate->area}} متر . تا {{$estate->{{ l('max_person}} مهمان') }}
                                </li>
                                <!--li class="list-inline-item pe-1"><i class="fi-star-filled mt-n1 me-1 fs-base text-warning align-middle"></i><b>5.0</b>
                                    <span class="text-muted">{{ l('&nbsp;(48نظر)') }}</span>
                                </li-->
                                <li class="list-inline-item pe-1">
                                    @if($estate->{{ l('rent != 0) هر شب از') }}
                                    <b>{{toPersianNumbers($estate->{{ l('rent)}} تومان') }}</b>
                                    @else
                                    <b>{{ l('توافقی') }}</b>
                                    @endif
                                </li>

                            </ul>
                        </div>
                    </div>
                    @endforeach

                    </div>
                </div>
            </div>
        </section>
        @endif

        <section class="back-komeh">
            <div class="container">
                <div class=" mb-5 mt-n3 mt-lg-0 py-5">
                    <h3 class="fs-2 text-center">{{ l('چرا گیلند ملک برای شما انتخاب خوبی است ؟') }}</h3>
                    <p class="fs-lg text-justify text-lg-center">{{ l('گیلند ملک یعنی سرزمین ملک گیلان و تخصصی ترین سایت املاک در استان گیلان می باشد که برگرفته شده از تیم با سابقه آموزش دیده و وکلای حقوقی می باشد و به شما این امکان را می دهد تا در سریع ترین زمان ممکن بهترین خدمات ملکی را دریافت کنید') }}</p>
                </div>
            </div>
        </section>

        <section class="container mt-n3 mt-lg-0 mb-5">
            <div class="overflow-hidden rounded-3  bg-secondary g-0 row flex-column-reverse flex-lg-row align-items-center">
                <div class="col-12 col-lg-6 p-0">
                    <div class="mx-5 py-3">
                        <h2 class="fs-2 mb-3">{{ l('مالک هستید؟') }}</h2>
                        <p class="fs-6 mb-3 text-justify">{{ l('هر کجای استان گیلان که ملکی برای فروش دارید می تونید با چند کلیک ساده ملکتان را به صورت رایگان در گیلند ملک آگهی و در سریع ترین زمان ممکن معامله کنید') }}</p>
                        <a href="/add" class="btn btn-primary">{{ l('ثبت رایگان آگهی') }}</a>
                    </div>
                </div>
                <div class="col-12 col-lg-6 p-0">
                    <div class="w-100">
                        <img class="w-100" src="/img/site5/banner1.jpg" alt="img" >
                    </div>
                </div>
            </div>
        </section>

        <section class="container mb-5 pb-md-4">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <h2 class="h3 mb-4 mt-4 mt-lg-0">{{ l('کارشناسان  گیلند ملک') }}</h2>

            </div>
            <div class="tns-carousel-wrapper tns-nav-outside tns-nav-outside-flush mx-n2">
                <div class="tns-carousel-inner row gx-4 mx-0" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:3},&quot;768&quot;:{&quot;items&quot;:4},&quot;992&quot;:{&quot;items&quot;:5}}}">
                    @foreach ($experts as $expert)
                    <div class="col">
                        <div class="agent-grid-v1">
                            <div class="position-relative agent-pic">
                                <div class="agent-logo-wrapper">
                                    <a class="agent-logo " href="/agents/{{$expert->id}}" tabindex="-1">
                                        <div class="image-wrapper">
                                            <img decoding="async" class="rounded img_expert" style="object-fit: cover;"  width="420" height="420" src="{{ crop($expert->photo(),250,250) }}" class="attachment-large size-large object-fit" alt="{{ $expert->fullname() }}" />
                                        </div>
                                    </a>
                                </div>
                                <div class="socials-member pb-3 rounded d-none">
                                    @if($expert->telegram)
                                    <a href="{{$expert->telegram}}" class="text-white" target="_blank" tabindex="-1">
                                        <i class="fi-telegram"></i>
                                    </a>
                                    @endif
                                    @if($expert->whatsapp)
                                    <a href="{{$expert->whatsapp}}" class="text-white" target="_blank" tabindex="-1">
                                        <i class="fi-whatsapp"></i>
                                    </a>
                                    @endif
                                    @if($expert->instagram)
                                    <a href="{{$expert->instagram}}" class="text-white" target="_blank" tabindex="-1">
                                    <i class="fi-instagram"></i>
                                    </a>
                                    @endif
                                    @if($expert->eitaa)
                                    <a href="{{$expert->eitaa}}" class="text-white" target="_blank" tabindex="-1">
                                    <img src="/img/logo/eita.svg" width="20px"/>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <h2 class="agent-title mt-2 mb-0">
                                <a href="/agents/{{$expert->id}}" class="text-decoration-none fs-6">{{ $expert->fullname() }}</a>
                            </h2>
                            <div class="agent-information-bottom flex-middle">
                                <div class="property-job"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

            <!-- Carousel custom controls-->
            <div class="tns-carousel-controls justify-content-center pt-md-2 mt-4" id="carousel-controls-tp">
                <button class="me-3" type="button"><i class="fi-chevron-left fs-xs"></i></button>
                <button type="button"><i class="fi-chevron-right fs-xs"></i></button>
            </div>
        </section>

        <section class="container mt-n3 mt-lg-0 mb-5">
            <div class="overflow-hidden rounded-3  bg-secondary g-0 row flex-column-reverse flex-lg-row align-items-center">
                <div class="col-12 col-lg-6 p-0">
                    <div class="w-100">
                        <img class="w-100" src="https://www.2nabsh.com/_img/landings/realtor.jpg" alt="img" >
                    </div>
                </div>
                <div class="col-12 col-lg-6 p-0 order-first order-lg-last">
                    <div class="mx-5 py-3">
                        <h2 class="fs-2 mb-3">{{ l('مشاور املاک هستید؟') }}</h2>
                        <p class="fs-6 mb-3 text-justify">{{ l('گیلند ملک در تمام شهرهای استان گیلان از همکاران فعال و پرانرژی جهت همکاری استقبال می کند در صورت تمایل به همکاری ثبت نام کنید.') }}</p>
                        <a href="/property_appraisal" class="btn btn-primary">{{ l('ثبت نام کنید') }}</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog-->
        <section class="container pb-lg-5 pb-4 mb-4">
            <div class="d-flex flex-column flex-md-row gap-3 gap-lg-0 align-items-lg-center align-items-start justify-content-between mb-3">
                <h2 class="h3 mb-0">{{ l('مجله املاک گیلان') }}</h2>
                <a class="btn btn-link fw-normal p-0" href="/blog">
                    {{ l('مقالات بیشتر') }} <i class="fi-arrow-long-left ms-2"></i>
                </a>
            </div>
            <div class="row g-4">
                    <!-- Post-->
                    @foreach( $articles as $item)
                    <div class="col-lg-6">
                        <article class="card border-0 shadow-sm card-hover card-horizontal mb-4 h-100">
                            <a class="card-img-top" href="{{$item->url()}}" style="background-image: url({{crop($item->img(),379,379)}});"></a>
                            <div class="card-body d-flex flex-column">
                                <h3 class="fs-base pt-1 mb-2">
                                    <a class="nav-link" href="{{$item->url()}}">
                                        {{$item->title}}
                                    </a>
                                </h3>
                                <p class="fs-sm text-muted">
                                    {!!$item->description!!}
                                </p>
                                <a class="d-flex align-items-center text-decoration-none mt-auto" href="{{$item->url()}}">
                                    <div class="pe-2">
                                        <div class="d-flex text-body fs-xs">
                                            <span class="me-2 pe-1">
                                                <i class="fi-calendar-alt opacity-70 ms-1"></i>
                                                {{$item->publish_date}}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                    </div>
                    @endforeach





            </div>
        </section>
        <style>

            .expandable .expand-bar {
                font-size: 9px;
            }

            .to-expand {
                padding-bottom: 50px;
            }
        </style>

        <section class="container pb-md-4 mb-4">
            <h2 class="h3 ">{{ l('پرسش و پاسخ های متداول') }}</h2>

            <div class="accordion qaa  to-expand" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="true" aria-controls="collapseOne">

                        {{ l('چرا رضوانشهر گیلان؟') }}
                    </button>
                    </h2>
                    <div id="collapse10" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('رضوانشهر از زیباترین شهرستان‌های استان گیلان می باشد که فاصله‌ی کمی با رشت دارد. این شهربهشت بین رشته کوه‌های تالش و سواحل دریای خزرقرار گرفته است و بخاطر اینکه جنگل و دریا دررضوانشهر در فاصله بسیار کمی از همدیگر قرار دارند، با سفر به رضوانشهرگیلان و یا سرمایه گذاری هم از دریای زیبا استفاده می کنید و هم از طبیعت بکر وجنگل های گیسوم بهره می برید. شهرهایی چون خلخال، تالش، صومعه سرا، ماسال و بندر انزلی در مجاورت رضوانشهر قرار دارند.رضوانشهرگیلان هر ساله میزبان تعداد زیادی از مسافران از سراسر کشور می باشد و همین امر باعث شده تا افراد زیادی به رضوانشهر مهاجرت کنند و بازار خرید و فروش زمین و ویلا تغییر کند.') }}
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="true" aria-controls="collapseOne">
                        {{ l('خرید و فروش و قیمت خانه و ویلا در رضوانشهر گیلان چگونه است؟') }}
                    </button>
                    </h2>
                    <div id="collapse11" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('با توجه به مهاجرت های فراوان و افزایش جمعیت دررضوانشهرگیلان باعث شده است تا بازار ملک این منطقه رشد چشمگیری داشته باشد و افراد زیادی دنبال خرید خانه و ویلا در رضوانشهر و روستاهای اطراف آن باشند تا از این طبیعت بکر و دریای زیبای خزر و آرامش شمال لذت ببرند. خرید و فروش املاک در رضوانشهر گیلان در سال های اخیر به سطح بالاتری ارتقا پیدا کرده است. برای اینکه بتوانید قیمت خانه و ویلا دررضوانشهرگیلان بدست بیاورید حتما از کارشناسان و مشاورین املاک مطمعن کمک بگیرید.') }}
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="true" aria-controls="collapseOne">
                        {{ l('قیمت رهن و اجاره آپارتمان در رضوانشهرگیلان چگونه است؟') }}
                    </button>
                    </h2>
                    <div id="collapse12" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('قیمت آپارتمان در رضوانشهر بستگی به نوع آپارتمان، متراژ ساختمان و امکانات ساختمان و اینکه چندسال ساخت است و دسترسی راحت تر به مراکز رفاهی، درمانی،خدماتی و گردشگری تعیین می گردد. همچنین بودن امکانات در نزدیکی آپارتمان و موقعبت مکانی در قیمت رهن و اجاره آپارتمان تاثیر می گذارد. توصیه می شود برای قیمت رهن و اجاره آپارتمان در رضوانشهر از افراد متخصص همان منطقه و مشاورین املاک معتبر کمک بگیرید.') }}
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse13" aria-expanded="true" aria-controls="collapseOne">
                        {{ l('قیمت خرید و فروش اپارتمان در رضوانشهرگیلان') }}
                    </button>
                    </h2>
                    <div id="collapse13" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('آپارتمان در رضوانشهرگیلان از نظر اقتصادی مقرون به صرفه تر می باشد و با توجه به امنیت و امکانات و شبکه ارتباطی که دارد می تواند گزینه خوبی برای خرید و فروش آپارتمان در رضوانشهر باشد آپارتمان‌های مدرن با امکانات متنوع، معمولا هزینه و زمان کمتری نسبت به ویلاهای ساخته شده دارد و این امر می‌تواند یک گزینه جذاب برای خریداران با بودجه محدود باشد. همچنین افرادی که به رضوانشهر گیلان مهاجرت می کنند به دلیل وجود امنیت بالا و داشتن آب و هوای مطبوع و دسترسی های راحت تر می توانند به راحتی ازخرید آپارتمان در رضوانشهر گیلان استفاده کنند مطلع شوند و با توجه به این سالهای اخیر که قیمت آپارتمان روند صعودی داشته است می توانند از مزایای گرفتن وام و خرید آپارتمان نیز استفاده کنند.') }}

                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse14" aria-expanded="true" aria-controls="collapseOne">
                        {{ l('قیمت خرید و فروش زمین و باغ دررضوانشهرگیلان') }}

                    </button>
                    </h2>
                    <div id="collapse14" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('وجود جنگل‌های غنی و پوشیده از درختان باعث ایجاد اقلیمی سرسبز و مطبوع در رضوان شهر شده است. این جنگلها به عنوان یکی از جاذبه‌های گردشگری مهم این منطقه محسوب می‌شوند و به افراد این امکان را تا در میان طبیعت زیبا و آرامش بخش این منطقه به زندگی بپردازند. همچنین، زیبایی‌های طبیعی و محیط سبز این شهر، آن را به یک مقصد آرامش بخش برای ساکنان و گردشگران تبدیل کرده است. رضوانشهر همچنین به دلیل اقلیم معتدل و خاک حاصلخیز، برای کشاورزی و باغداری نیز بسیار مناسب است. در این شهر، باغات مختلفی وجود دارد که انواع محصولات باغی از جمله کیوی، گردو، مرکبات متنوع، خرمالو، ازگیل، به، سیب و سایر میوه‌ها تولید می شود. این محصولات با کیفیت بالا و تازگی طعم و عطر خود را حفظ کرده و به بازارهای داخلی و حتی خارجی عرضه می‌شوند. از طرفی، وجود این باغات و زمین‌های کشاورزی، تأثیر مستقیمی بر بازار خرید و فروش زمین و باغ در این منطقه گذاشته و کشاورزان و سرمایه گذاران بسیاری را به سوی خود جذب کرده است که این امیر تاثیر مستقیمی بر پیشرفت خرید و فروش زمین و باغ در این شهر داشته و بر افزایش قیمت خرید وفروش تاثیر بسزایی گذاشته است') }}

                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse15" aria-expanded="true" aria-controls="collapseOne">
                        {{ l('خرید و فروش و قیمت زمین مسکونی در رضوانشهرگیلان') }}
                    </button>
                    </h2>
                    <div id="collapse15" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('. خرید و فروش و قیمت زمین‌های مسکونی در رضوانشهر گیلان ، بستگی به عواملی مانند موقعیت، متراژ، امکانات محیطی و ویژگی‌های زمین دارد. به طور کلی، قیمت‌ها به این صورت متغیر است: در بافت شهری، قیمت زمین‌ها در مرکز شهر بین7 تا 30 میلیون تومان هر متر مربع، در مناطق متوسط بین 5/3 تا 7 میلیون تومان هر متر مربع و در مناطق حاشیه‌ای بین 5/1 تا 6 میلیون تومان هر متر مربع متغیر است. اما زمین‌های خارج از بافت شهری، به مناطق نزدیک به جاده‌های اصلی و امکانات، در بازه 5/1 تا 5 میلیون تومان هر متر مربع و به مناطق دورتر با قیمت‌های 1میلیون تا 2 میلیون تومان هر متر مربع به فروش می‌رسند. این تنوع در قیمت‌ها نشان دهنده تأثیر عوامل مختلف اقتصادی و جغرافیایی بر بازار زمین‌های مسکونی در این منطقه است') }}
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse16" aria-expanded="true" aria-controls="collapseOne">
                        {{ l('خرید و فروش و قیمت زمین‌های تجاری در رضوانشهر گیلان') }}

                    </button>
                    </h2>
                    <div id="collapse16" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('خرید و فروش و قیمت زمین های تجاری در رضوانشهر گیلان بستگی به عواملی از جمله مکان (مرکزیت در شهر یا نزدیکی به جاذبه‌های توریستی و مراکز تجاری)، متراژ، امکانات (آب، برق، گاز، تلفن، فاضلاب)، نوع کاربری و وضعیت سند بستگی دارد. به عنوان مثال، یک زمین تجاری 45 متری دو دهنه در محدوده قیمت 1 میلیارد و 800 تومان و مغازه‌های مختلف با قیمت‌های توافقی و یا مشخص مانند 2 میلیارد و 500 هزار تومان موجود است. این قیمت‌ها بر اساس قیمت روز بازار هستند و بستگی به ویژگی‌های خاص هر ملک، ممکن است تغییر کند.') }}

                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse17" aria-expanded="true" aria-controls="collapseOne">
                        {{ l('خرید و فروش و قیمت ویلا استخردار در رضوانشهر گیلان') }}


                    </button>
                    </h2>
                    <div id="collapse17" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('خرید و فروش و قیمت ویلاهای استخردار در رضوانشهر گیلان، بستگی به عواملی از جمله موقعیت مکانی (ساحلی، جنگلی، دارای چشم‌انداز دریا یا کوه)، متراژویلا، تعداد اتاق خواب و حمام، امکانات (استخر، جکوزی، سونا، سالن بازی و محوطه سازی)، نوع بنا (نوساز یا قدیمی) و وضعیت سند ویلا تعیین می‌شود. مثلا قیمت ویلاهای 300 متری استخردار در پره سر به 3 میلیارد و 500 میلیون تومان و ویلاهای دیگر با قیمت‌های متفاوت می باشد. این قیمت‌ها تحت تأثیر شرایط خاص هر ویلا قرار می‌گیرند وتغییر می کند. .') }}

                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse18" aria-expanded="true" aria-controls="collapseOne">
                        {{ l('خرید و فروش و قیمت آپارتمان مسکونی در رضوانشهر گیلان') }}
                    </button>
                    </h2>
                    <div id="collapse18" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('خرید و فروش و قیمت آپارتمان‌های مسکونی در رضوانشهرگیلان، به عوامل مختلفی از جمله مکان (مرکزیت، نزدیکی به جاذبه‌های گردشگری و مراکز تجاری)، متراژ، تعداد اتاق خواب، طبقه، امکانات (آسانسور، پارکینگ، انباری، استخر، سونا و ...)، سن بنا و وضعیت سند بستگی دارد. به طور مثال آپارتمان‌های 90 متری دو خواب در مرکز شهر با قیمت 2 میلیارد و آپارتمان‌های دیگر با قیمت‌های مختلف خرید وفروش می شوند. این قیمت‌ها تحت تأثیر شرایط هر آپارتمان قرار می‌گیرند و قابل تغییر می باشد.') }}
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse19" aria-expanded="true" aria-controls="collapseOne">
                        {{ l('خرید و فروش و قیمت آپارتمان های تجاری در رضوانشهر گیلان') }}

                    </button>
                    </h2>
                    <div id="collapse19" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('خرید و فروش وقیمت آپارتمان‌های تجاری در رضوانشهرگیلان، به عواملی از جمله مکان (مرکزیت، نزدیکی به جاذبه‌های گردشگری و مراکز تجاری)، متراژآپارتمان، تعداد اتاق ها، تعداد طبقه، امکانات (آسانسور، پارکینگ، انباری، سرویس بهداشتی و ...)، سن بنا، وضعیت سند، و کاربری ملک بستگی دارد. مثلا آپارتمان‌های 50 متری تجاری در مرکز شهر با قیمت 2 میلیارد تومان و آپارتمان‌های دیگر با قیمت‌های متفاوت ذکرخرید و فروش می شود که قیمت ها با توجه به ویژگی‌ها و شرایط خاص هر آپارتمان تغییر می کند و ممکن است مختلف باشند.') }}
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse20" aria-expanded="true" aria-controls="collapseOne">
                        {{ l('خرید و فروش و قیمت آپارتمان های اداری در رضوانشهرگیلان') }}


                    </button>
                    </h2>
                    <div id="collapse20" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('خرید و فروش و قیمت آپارتمان‌های اداری در رضوانشهرگیلان، به عواملی مختلفی از جمله (نزدیکی به اداره ها و مراکزخرید و تجاری، منطقه مرکزی شهر)، متراژآپارتمان، تعداد اتاق، تعداد طبقه، امکانات (مانند آسانسور، پارکینگ، انباری، سرویس بهداشتی و ...)، سن بنا، وضعیت سندآپارتمان و همچنین کاربری آن بستگی دارد. مثلا آپارتمان‌های اداری در مرکز شهر با متراژ 50متر مربع با قیمت 2 میلیارد تومان و آپارتمان‌های با متراژ و ویژگی‌های مختلف دیگر ذکر شده‌اند. این قیمت‌ها بسته به شرایط خاص هر آپارتمان متغیر بوده و ممکن است مختلف باشند.') }}

                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                        {{ l('چرا در گیلان زمین یا ویلا بخریم؟') }}
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('خرید زمین یا ویلا در گیلان میتواند یک سرمایه گذاری سودآوری باشد و به عنوان محل اقامت دوم مزایای زیادی برای شما داشته باشد از جمله اینکه از طبیعت زیبا و سرسبز و آب و هوای خنک و معتدل و جنگل های لذت بخش و مهم تر از همه دریای زیبای خزر و سواحل شمالی استفاده می کنید و آرامش را برای خود به ارمغان می آورید.و همچنین به علت توریستی بودن استان گیلان و حجم بالای مسافران در طول فواصل مختلف در این استان می توانید حتی در غیاب خود کسب درامد کنید') }}
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        {{ l('چگونه در گیلان سرمایه گذاری سودآور داشته باشیم؟') }}
                    </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('خرید ملک در گیلان زمانی سرمایه گذاری پر سودی حساب می شود که با مشاور ملکی و یا کارشناس املاک معتبر مشورت کنید و تمام اسناد و مدارک را بررسی کنید') }}

                    </div>
                    </div>
                </div>


                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                        {{ l('چه عواملی بر قیمت ویلا و زمین در گیلان تاثیر گذار است؟') }}
                    </button>
                    </h2>
                    <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body text-justify">
                            {{ l('قیمت ویلاها و زمین در گیلان بستگی به عوامل مختلفی دارد از جمله :') }}<br>
                            {{ l('1- موقعیت جغرافیایی که برخی مناطق به علت دارا بودن در منظره های طبیعی مثل کوهستان ها ، دریاها و جنگل ها دارای قیمت بالاتری هستند.') }}<br>
                            {{ l('2-امکانات و خدمات: معمولا در مناطقی که امکانات و خدمات کامل تری از جمله دریا، مراکز تجاری،شهرها و …در دسترس می باشد زمین و ویلا قیمت بالاتری دارد.') }}<br>
                            {{ l('3-ورود سرمایه گذاران و بازار ملک: اگر بازار ملک در یک منطقه روند رشدی دارد و جذاب برای سرمایاه گذاران به نظر می رسد قیمت ها در این منطقه افزایش می یابند.') }}<br>
                            {{ l('4-امکانات داخل ویلا و درون زمین : امکانات و ویژگی هایی که در داخل هر ویلا و زمین قرار دارد بر قیمت تاثیر گذار می باشد هر چقدر زمین یا ویلا امکانات بیشتری داشته باشد ممکن است قیمت بالاتری داشته باشد.') }}<br>
                            {{ l('5- عوامل اقتصادی : افزایش قوت خرید جامعه ، شرایط اقتصادی و اصولا عرضه و تقاضای بازار ملک در منطقه می تواند باعث افزایش یا کاهش قیمت ها شود.') }}<br>
                            {{ l('برای اطلاعات دقیق تر از موقعیت و قیمت ملک و زمین خود می توانید با کارشناسان آموزش دیده گیلند ملک در ارتباط باشید.') }}<br>
                        </div>
                    </div>
                </div>


            </div>
        </section>
        @if(isset($articlesCustomer))
        <!-- Blog: Articles -->
        <section class="container my-5 py-lg-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
                <h2 class="h3 mb-sm-0">{{ l('برخی مشتریان ما') }}</h2>
            </div>
            <!-- Carousel-->
            <div class="tns-carousel-wrapper tns-nav-outside mb-md-2">
                <div class="tns-carousel-inner d-block" data-carousel-options="{&quot;controls&quot;: false, &quot;gutter&quot;: 24, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:3}}}">
                    @foreach($articlesCustomer as $item)
                    <!-- Item-->
                    <article>
                        <a class="d-block mb-3" href="{{$item->url()}}">
                            @if($item->video != '')
                            <div class="text-center mx-auto">
                                <style>.h_iframe-aparat_embed_frame{position:relative;}.h_iframe-aparat_embed_frame .ratio{display:block;width:100%;height:auto;}.h_iframe-aparat_embed_frame iframe{position:absolute;top:0;left:0;width:100%;height:100%;}</style><div class="h_iframe-aparat_embed_frame"><span style="display: block;padding-top: calc(57% + 65px)"></span><iframe src="https://www.aparat.com/video/video/embed/videohash/{{$item->video}}/vt/frame"  allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div>
                            </div>
                            @endif
                        </a>

                        <h3 class="fs-base pt-1">
                            <a class="nav-link" href="{{$item->url()}}">{{$item->title}}</a>
                        </h3>
                        <div class="ps-2">
                            <div class="d-flex text-body fs-xs">
                                <p>
                                    {{$item->description}}
                                </p>
                            </div>
                        </div>
                    </article>
                    @endforeach

                </div>
            </div>
        </section>
        @endif
    </main>
<style>
    .shadow-sm {
        box-shadow: 0 0.125rem 0.125rem -0.125rem #bbbbbb, 0 0.25rem 0.75rem #bbbbbb !important;
      }
</style>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')

@endsection
