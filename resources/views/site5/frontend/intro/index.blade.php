@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])

@section('main_content')
<style>
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
.object-fit {
            object-fit: cover;
        }
        .image_v {
            background-image: url(/img/real-estate/{{ $selectedCity }}.jpg);
            background-position: center;
            background-size: cover;
        }

        .videodesktop {
            min-width: 100%;
            min-height: 100%;
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateX(0) translateY(-50%);
            z-index: -1;
        }

        .videomobile {
            min-width: 100%;
            min-height: 100%;
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateX(0) translateY(-50%);
            z-index: -1;
        }

        .hero-box {
            position: absolute;
            z-index: 100;
            width: 100%;
            bottom: 20%;
            transform: translateY(30%);
            max-width: 300px;
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
        }

        .height-hero {
            min-height: 65vh;
            background-image: url('img/site5/hero.jpg');
            background-position: bottom;
            background-size: cover;

        }

        @media (min-width: 768px) {
            .height-hero {
                min-height: 100vh;
                background-position: bottom;
                 background-size: auto;
            }
        }

        .socials-member {
            position: absolute;
            bottom: 0;
            width: 100%;
            display: flex;
            gap: 15px;
            align-items: end;
            justify-content: center;
        }

        .agent-before::before {
            border-radius: 6px;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            -ms-border-radius: 6px;
            -o-border-radius: 6px;
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #0a0a5b8c;
            -webkit-transition: all .2s ease-in-out 0s;
            -o-transition: all .2s ease-in-out 0s;
            transition: all .2s ease-in-out 0s;
            opacity: 1;
            filter: alpha(opacity=0);
        }
        .type-banner-property.style2 {

            transition: all .3s ease-in-out 0s;
            background-color: rgba(255,255,255,.15);
            display: inline-block;
            text-align: center;
            min-width: 123px;
            padding: 10px;
            border-radius: 6px;

        }
        .type-banner-property:hover{
            background-color: rgba(255,255,255,.35);
        }
        @media (min-width: 430px) {
            .type-banner-property.style2 {
                min-width: 135px;
            }
        }
        @media (min-width: 768px) {
            .type-banner-property.style2 {
                padding: 22px;
            }
        }
    </style>
<!-- main -->
<main class="page-wrapper">

    @include(ss('THEME') . '.frontend.layouts.header_v2')

    <section class="container-fluid my-3 pb-lg-4 px-xxl-4 mt-5 pt-5" style="padding-left: 0px !important;padding-right:0px !important">
        <div class="jarallax card align-items-center justify-content-center border-0  p-5 bg-secondary  mt-n3 height-hero" style="border-radius:unset " data-jarallax data-speed="0.5">


                <span class="img-overlay " style="z-index: -1 !important;"></span>
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-4">

                    <div>
                        <h1 class="display-5  pb-md-3 px-md-3 text-white text-center zindex-1 mb-5 mb-lg-0">
                            {{ l('راه آسان برای پیدا کردن یک ملک مناسب') }}
                        </h1>
                        <div class="fw-5 text-white">
                        {{ l('به دنبال چه چیزی هستید؟') }}
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-2 justify-content-between justify-content-lg-start
                         mt-3 ">
                            <div class="widget-property-type-banner ">
                                <a class="type-banner-property style2 text-white" href="/c/{{ $selectedCity }}?type=1&estateTypes=1&view=1">

                                <i class="fi-apartment fs-2"></i>
                                <h4 class="text-white">
                                     {{ l('آپارتمان') }}</h4>
                                </a>
                            </div>
                            <div class="widget-property-type-banner ">
                                <a class="type-banner-property style2 text-white" href="/c/{{ $selectedCity }}?type=1&estateTypes=2&view=1">

                                <i class="fi-real-estate-house fs-2"></i>
                                <h4 class="text-white">
                                     {{ l('ویلایی') }}</h4>
                                </a>
                            </div>
                            <div class="widget-property-type-banner ">
                                <a class="type-banner-property style2 text-white" href="/c/{{ $selectedCity }}?type=1&estateTypes=3&view=1">

                                <i class="fi-real-estate-buy fs-2"></i>
                                <h4 class="text-white">
                                     {{ l('مغازه') }}</h4>
                                </a>
                            </div>
                            <div class="widget-property-type-banner ">
                                <a class="type-banner-property style2 text-white" href="/c/{{ $selectedCity }}?type=1&estateTypes=4&view=1">

                                <i class="fi-billboard-house fs-2"></i>
                                <h4 class="text-white">
                                     {{ l('زمین و باغ') }}</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                <div class="content-overlay w-100 w-md-50">
                    <form class="shadow-sm form-group d-block" style="border:0" method="get" action="/c/{{ $selectedCity }}">

                            <div class=" d-flex flex-column gap-4 p-3">
                                <div class="dropdown border rounded d-flex align-items-center" data-bs-toggle="select">
                                    <i class="fi-home me-2" style="margin-right:10px"></i>
                                    <select name="type" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 text-dark text-end w-100 me-2">
                                        <option value="1">{{ l('فروش') }}</option>
                                        <option value="2">{{ l('اجاره') }}</option>
                                    </select>

                                </div>
                                <div class="dropdown border rounded d-flex align-items-center" data-bs-toggle="select">
                                    <i class="fi-map-pin me-2" style="margin-right:10px"></i>
                                    <select id="city_id" name="city_id" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 text-dark text-end w-100 me-2" style="width:122px">
                                        <option value="">{{ l('انتخاب شهر') }}</option>
                                        @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="dropdown border rounded d-flex align-items-center" data-bs-toggle="select">
                                    <i class="fi-list me-2" style="margin-right:10px"></i>
                                    <select name="estateType" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 text-dark text-end w-100 me-2">
                                        <option value="">{{ l('انتخاب نوع ملک') }}</option>
                                        <option value="1">{{ l('آپارتمان') }}</option>
                                        <option value="2">{{ l('ویلایی') }}</option>
                                        <option value="3">{{ l('مغازه') }}</option>
                                        <option value="4">{{ l('زمین و باغ') }}</option>
                                        <option value="5">{{ l('صنعتی و تجاری') }}</option>
                                    </select>

                                </div>
                                <button class="btn  btn-icon btn-primary px-3 w-100" type="submit">{{ l('جستجو') }}</button>
                            </div>
                            <!-- <div class="col-md-2 d-sm-flex align-items-center pt-3 pt-md-0">

                            </div> -->

                    </form>
                </div>
            </div>
        </div>
    </section>



    <section class="container mb-5 pb-md-4 ">
        <div class="d-flex flex-column  align-items-center justify-content-center gap-3 mb-3">
            <a class="h3 mb-0 btn text-dark fs-4 mt-3 mt-lg-0" href="/c/{{ $selectedCity }}?type=1">{{ l('جدیدترین خانه های خرید و فروش') }}</a>
            <!-- <a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?type=1">{{ l('مشاهده همه') }}
            </a> -->
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2" dir="ltr">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:3}}}">
                <!-- Item-->
    {{--
                @foreach ($estates as $estate)
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="img-overlay" href="/v/{{ $estate->id }}"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">{{ toPersianDate($estate->showdate) }}</span>
                                <span class="d-table badge bg-primary">{{ estateTypes($estate->estate_type) }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">
                                <!--button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Wishlist">
                                                <i class="fi-heart"></i>
                                            </button-->
                            </div>
                            <img src="{{ $estate->coverImage() }}" style="height: 200px;width:100%;object-fit:cover" data-src="{{ $estate->coverImage() }}" alt="{{ $estate->title }}">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a class="nav-link stretched-link" href="/v/{{ $estate->id }}">
                                    {{ $estate->title }}</a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ toPersianNumbers($estate->{{ l('price) }} ت') }}
                                </div>
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ toPersianNumbers($estate->{{ l('price_per_meter) }} متری') }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">

                            <div>
                                @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ getFeatureValue($featureValues, $estate->geography) }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> ساخت:
                                    {{ buildYear($estate->built_year) }}
                                </span>
                                @endif

                                @if ($estate->estate_type == 3 || $estate->estate_type == 4)
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ getFeatureValue($featureValues, $estate->geography) }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
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
                    </div>
                </div>
                @endforeach
                --}}
                @foreach ($estates as $estate)

                <div class="col">
                    <!-- Static content overlay -->

                        <div class="card bg-size-cover bg-position-center border-0 overflow-hidden" style="background-image: url('{{$estate->coverImage() }}'); max-width: 636px;height:310px;">
                        <a  class="img-gradient-overlay"></a>
                        <a href="{{ $estate->url() }}" class="img-over"></a>
                            <div class="card-body content-overlay pb-0">
                                <span class="badge bg-info fs-sm">{{ toPersianDate($estate->showdate) }}</span>
                            </div>
                            <div class="card-footer content-overlay border-0 pt-0 pb-4">
                                <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5"><a class="text-decoration-none text-light pe-2" href="#">
                                    <div class="fs-sm text-uppercase pt-2 mb-1">{{ estateTypes($estate->estate_type) }}</div>
                                    <h3 class="h5 text-light mb-1">  {{ $estate->title }}</h3>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="fs-sm opacity-70 text-white"><i class="fi-cash  ms-1"></i> {{ toPersianNumbers($estate->{{ l('price) }} ت') }}</div></a>
                                    <div class="fs-sm opacity-70 text-white"><i class="fi-cash  ms-1"></i> {{ toPersianNumbers($estate->{{ l('price_per_meter) }} متری') }}</div></a>

                                </div>
                                <div class="text-white opacity-70 mt-3 text-center">
                                    @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ getFeatureValue($featureValues, $estate->geography) }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> ساخت:
                                        {{ buildYear($estate->built_year) }}
                                    </span>
                                    @endif

                                    @if ($estate->estate_type == 3 || $estate->estate_type == 4)
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ getFeatureValue($featureValues, $estate->geography) }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
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
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="bg-info mb-5">
        <div class="container py-5">
            <div class="d-flex flex-column flex-lg-row gap-4 justify-content-between align-items-center">
                <h2 class="mb-0 text-white">{{ l('مشاوره رایگان خرید و اجاره ملک') }}</h2>
                <div class="d-flex align-items-center gap-4">
                    <div class="text-white">
                        <p class="mb-2 text-white fs-5">{{ l('همین حالا تماس بگیرید') }}</p>
                        <a class="text-white text-decoration-none fs-6" href="">09125538044 - 02532611515</a>
                    </div>
                    <i class="fi-phone text-white fs-3"></i>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="d-flex align-items-center justify-content-center mb-4">
            <a class="h3 mb-0 btn text-dark fs-4" href="/c/{{ $selectedCity }}?type=2">{{ l('جدیدترین خانه های رهن و اجاره') }}</a>
            <!-- <a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?type=2">
                {{ l('مشاهده همه') }} <i class="fi-arrow-long-left ms-2"></i></a> -->
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2 " dir="rtl">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:3}}}">
            {{--
                <!-- Item-->
                @foreach ($estatesr as $estate)
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="img-overlay" href="/v/{{ $estate->id }}"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">{{ toPersianDate($estate->showdate) }}</span>
                                <span class="d-table badge bg-primary">{{ estateTypes($estate->estate_type) }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">
                                <!--button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Wishlist">
                                            <i class="fi-heart"></i>
                                        </button-->
                            </div>
                            <img src="{{ $estate->coverImage() }}" style="height: 200px;width:100%;object-fit:cover" data-src="{{ $estate->coverImage() }}" alt="{{ $estate->title }}">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a class="nav-link stretched-link" href="/v/{{ $estate->id }}">
                                    {{ $estate->title }}</a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
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
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">

                            <div>
                                @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ getFeatureValue($featureValues, $estate->geography) }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> ساخت:
                                    {{ buildYear($estate->built_year) }}
                                </span>
                                @endif

                                @if ($estate->estate_type == 3 || $estate->estate_type == 4)
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ getFeatureValue($featureValues, $estate->geography) }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
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
                    </div>
                </div>
                @endforeach

                    --}}
                    @foreach ($estatesr as $estate)
                <div class="col">
                    <!-- Static content overlay -->

                        <div class="card bg-size-cover bg-position-center border-0 overflow-hidden" style="background-image: url('{{ $estate->coverImage() }}'); max-width: 636px;height:310px;">
                        <span class="img-gradient-overlay"></span>
                        <a href="{{ $estate->url() }}" class="img-over"></a>
                            <div class="card-body content-overlay pb-0"><span class="badge bg-info fs-sm">{{ toPersianDate($estate->showdate) }}</span>
                        </div>
                            <div class="card-footer content-overlay border-0 pt-0 pb-4">
                                <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5">
                                    <a class="text-decoration-none text-light pe-2" href="#">
                                    <div class="fs-sm text-uppercase pt-2 mb-1">{{ estateTypes($estate->estate_type) }}</div>
                                    <h3 class="h5 text-light mb-1">  {{ $estate->title }}</h3>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="fs-sm opacity-70 text-white"><i class="fi-cash  ms-1"></i> {{ toPersianNumbers($estate->{{ l('mortgage) }} رهن') }}</div></a>
                                    <div class="fs-sm opacity-70 text-white"><i class="fi-cash  ms-1"></i>  {{ toPersianNumbers($estate->{{ l('rent) }} اجاره') }}</div></a>

                                </div>
                                <div class="text-white opacity-70 mt-3 text-center">
                                    @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ getFeatureValue($featureValues, $estate->geography) }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> ساخت:
                                        {{ buildYear($estate->built_year) }}
                                    </span>
                                    @endif

                                    @if ($estate->estate_type == 3 || $estate->estate_type == 4)
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ getFeatureValue($featureValues, $estate->geography) }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
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
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Services-->
    <!-- <section class="container mt-n3 mt-lg-0">
        <div class="tns-carousel-wrapper tns-nav-outside tns-nav-outside-flush mx-n2" dir="ltr">
            <div class="tns-carousel-inner row gx-4 mx-0 py-3" data-carousel-options="{&quot;items&quot;: 3, &quot;controls&quot;: false, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3}}}">
                <div class="col">
                    <div class="card card-hover border-0 h-100 pb-2 pb-sm-3 px-sm-3 text-center"><img class="d-block mx-auto my-3" src="/img/real-estate/illustrations/buy.svg" width="256" alt="Illustration">
                        <div class="card-body">
                            <h2 class="h5 card-title">{{ l('ثبت یک ملک') }}</h2>
                            <p class="card-text fs-sm">با ثبت ملک خود در {{ ss('SITE_NAME') }}،
                                سریع تر از حد انتظار، ملک
                                خود را بفروشید. </p>
                        </div>
                        <div class="card-footer pt-0 border-0"><a class="btn btn-outline-primary stretched-link" href="/add">{{ l('جستجوی خانه') }}</a></div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-hover border-0 h-100 pb-2 pb-sm-3 px-sm-3 text-center"><img class="d-block mx-auto my-3" src="/img/real-estate/illustrations/sell.svg" width="256" alt="Illustration">
                        <div class="card-body">
                            <h2 class="h5 card-title">{{ l('خرید یک ملک') }}</h2>
                            <p class="card-text fs-sm">
                                {{ l('از میان املاک فعال در شهر خودتان بهترین ملک را برای خرید انتخاب کنید.') }}
                            </p>
                        </div>
                        <div class="card-footer pt-0 border-0"><a class="btn btn-outline-primary stretched-link" href="/c/{{ $selectedCity }}?type=1">{{ l('املاک خرید و فروش') }}</a></div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-hover border-0 h-100 pb-2 pb-sm-3 px-sm-3 text-center"><img class="d-block mx-auto my-3" src="/img/real-estate/illustrations/rent.svg" width="256" alt="Illustration">
                        <div class="card-body">
                            <h2 class="h5 card-title">{{ l('اجاره یک ملک') }}</h2>
                            <p class="card-text fs-sm">
                                بهترین و مناسبترین ملک را از میان املاک اجاره ای ثبت شده در {{ ss('SITE_NAME') }}
                                انتخاب کنید
                            </p>
                        </div>
                        <div class="card-footer pt-0 border-0"><a class="btn btn-outline-primary stretched-link" href="/c/{{ $selectedCity }}?type=2">{{ l('یافتن اجاره خانه') }}</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <section class="container mt-n3 mt-lg-0 mb-5">
        <div class="overflow-hidden rounded-3  bg-secondary g-0 row flex-column-reverse flex-lg-row align-items-center">
            <div class="col-12 col-lg-6 p-0">
                <div class="mx-5 py-3">
                    <h2 class="fs-2 mb-3">{{ l('مالک هستید؟') }}</h2>
                    <p class="fs-6 mb-3">{{ l('با چند کلیک ساده، ملک‌تون رو به‌صورت رایگان در شهر املاک آگهی و در سریع‌ترین زمان ممکن معامله کنید.') }}</p>
                    <button class="btn btn-primary">{{ l('ثبت رایگان آگهی') }}</button>
                </div>
            </div>
            <div class="col-12 col-lg-6 p-0">
                <div class="w-100">
                    <img class="w-100" src="/img/site5/banner1.jpg" alt="img" >
                </div>
            </div>
        </div>
    </section>




    <!-- Links-->
    <section class="container mb-5 pb-lg-5" style="display: none">
        <div class="row row-cols-md-3 row-cols-1 gy-3">
            <!-- Calculate property cost-->
            <div class="col">
                <div class="card card-hover h-100 border-0 bg-faded-warning position-relative">
                    <div class="card-body pb-2">
                        <h5 class="mb-2 pb-1 ">{{ l('ثبت نام کارشناس') }}</h5>
                        <p class="mb-0">{{ l('در کمتر از 3 دقیقه ثبت نام کنید و کارشناس شوید') }}</p>
                    </div>
                    <div class="card-footer py-1 border-0">
                        <a class="stretched-link btn btn-link mb-3 px-0 text-warning" href="/agent/register" data-bs-toggle="modal">{{ l('ثبت نام') }}</a>
                    </div>
                </div>
            </div>
            <!-- Help center link-->
            <div class="col">
                <div class="card card-hover h-100 border-0 bg-faded-accent position-relative">
                    <div class="card-body pb-2">
                        <h5 class="mb-2 pb-1 ">{{ l('جستجوی ملک') }}</h5>
                        <p class="mb-0">
                            {{ l('از میان املاک فعال در شهر خودتان بهترین ملک را انتخاب کنید.') }}
                        </p>
                    </div>
                    <div class="card-footer py-1 border-0">
                        <a class="stretched-link btn btn-link mb-3 px-0 text-accent" href="/c/{{ $selectedCity }}">{{ l('جستجو') }}</a>
                    </div>
                </div>
            </div>
            <!-- How it works link-->
            <div class="col">
                <div class="card card-hover h-100 border-0 bg-faded-success position-relative">
                    <div class="card-body pb-2">
                        <h5 class="mb-2 pb-1 ">{{ l('ثبت ملک') }}</h5>
                        <p class="mb-0">
                            {{ l('با ثبت ملک خود سریع تر از حد انتظار، ملک خود را بفروشید.') }}
                        </p>
                    </div>
                    <div class="card-footer py-1 border-0"><a class="stretched-link btn btn-link mb-3 px-0 text-success" href="/add">{{ l('شروع کنید') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5 pb-md-4">
        <div class="d-flex align-items-center justify-content-center mb-3">
            <h2 class="h3 mb-4 mt-4 mt-lg-0"> کارشناسان {{ss('SITE_NAME')}}</h2>

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
                                        <img decoding="async" class="rounded" style="height:230px;object-fit: cover;"  width="420" height="420" src="{{ $expert->photo() }}" class="attachment-large size-large object-fit" alt="{{ $expert->fullname() }}" />
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
                    <img class="w-100" src="/img/site5/realtor.jpg" alt="img" >
                </div>
            </div>
            <div class="col-12 col-lg-6 p-0 order-first order-lg-last">
                <div class="mx-5 py-3">
                    <h2 class="fs-2 mb-3">{{ l('مشاور املاک هستید؟') }}</h2>
                    <p class="fs-6 mb-3">{{ l('شهر املاک باعث توسعۀ کسب‌وکار بیش از ۱۵۰۰۰ مشاور املاک متخصص شده. شانس‌تون رو در پیوستن به این مجموعه و توسعۀ کسب‌وکارتون امتحان کنید.') }}</p>
                    <button class="btn btn-primary">{{ l('ثبت رایگان آگهی') }}</button>
                </div>
            </div>
        </div>
    </section>

</main>
<style>
    .shadow-sm {
        box-shadow: 0 0.125rem 0.125rem -0.125rem #bbbbbb, 0 0.25rem 0.75rem #bbbbbb !important;
    }
</style>

<script>

    $('.agent-pic').on('mouseenter',function(){
        $(this).children().first().addClass('agent-before')
        $(this).children().last().removeClass('d-none')
    })

    $('.agent-pic').on('mouseleave',function(){
        $(this).children().first().removeClass('agent-before')
        $(this).children().last().addClass('d-none')
    })

</script>

@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
