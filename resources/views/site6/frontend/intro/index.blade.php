@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('گیلند ملک | املاک رضوانشهر و پره سر'),
    'metaDescription' => l('خرید ملک در گیلان چگونه سرمایه گذاری پرسودی به حساب می آید؟ زمانی که با مشاور ملکی و کارشناس املاک معتبر مشورت کنید و تمام اسناد و مدارک را بررسی کنید که در این راستا گیلند ملک با مهارت و تخصص خود در کنار شماست تا خریدی مطمعن را تجربه کنید.'),
    'canonical' => '/'
])
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <link rel="stylesheet" media="screen" href="/vendor/expandable/jquery.expandable.css" />
        <style>
            .object-fit {
                        object-fit: cover;
            }
            .image_v {
                background-image: url(/img/site2/gisom.jpg);
                background-attachment: inherit;
                background-size: cover;
            }

            .hero-box {
            position: absolute;
            z-index: 100;
            width: 100%;
            bottom: 20%;
            transform: translateY(30%);
            max-width: 300px;
            }

            .h1-hero {
                background-color: none;
                padding-bottom: 100px !important;
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
            /* .form-home {
                background-color: #ffffff70;
            } */

            /* .form-home select, .form-home i {
                color:#fff !important;
            } */

            @media (min-width: 776px) {
                /* .form-home {
                  background-color: #ffffff;
               }

               .form-home select, .form-home i {
                color: #9691a4 !important;
               } */
               .image_v {
                background-image: url(/img/site2/gisom.jpg);


              }
            }
            .back-komeh{
                background-color: #fff;
                background-image: url(/img/site3/banner-h-6.jpg.webp);
                background-position: top center;
                background-repeat: no-repeat;

            }
        </style>

        <section class="container-fluid my-0 my-lg-5 pt-3 pt-lg-5 pb-lg-4 px-xxl-4" style="padding-left: 0px !important;padding-right:0px !important">
            <div class="jarallax card align-items-center justify-content-center border-0 p-md-5 p-4 bg-secondary mt-n3 image_v" style="min-height: 500px;border-radius:unset " data-jarallax data-speed="0.5">

                <span class="img-overlay opacity-40"></span>
                <h1 class="display-5 mb-5 pb-5 py-md-3 px-md-3  text-white text-center zindex-1 bg-opacity-50  rounded-2 h1-hero">
                    {{ l('املاک گیلان، خرید ملک در شمال') }}
                </h1>
                <div class="content-overlay hero-box" style="">
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
        </section>
        <hr class="mt-n1 mb-5 d-md-none">
        <section class="container mb-5 pb-md-4 mt-lg-0 pt-lg-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h3 mb-0 ">{{ l('جدیدترین خانه های خرید و فروش') }}</h2><a class="btn btn-link fw-normal p-0"
                    href="/c/{{ $selectedCity }}?type=1">{{ l('مشاهده همه') }}<i class="fi-arrow-long-left ms-2"></i></a>
            </div>
            <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2"
                dir="ltr">
                <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4"
                    data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                    <!-- Item-->
                    @foreach ($estates as $estate)
                        <div class="col">
                            <div class="card shadow-sm card-hover border-0 h-100">
                                <div class="card-img-top card-img-hover">
                                    <a class="img-overlay" href="/v/{{ $estate->id }}"></a>
                                    <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                        <span class="d-table badge bg-info mb-1">{{ toPersianDate($estate->created_at) }}</span>
                                        <span class="d-table badge bg-primary">{{estateTypes($estate->estate_type)}}</span>
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
                                        <a class="nav-link stretched-link" href="/v/{{ $estate->id }}"> {{ $estate->title }}</a>
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
                                            <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{!empty($estate->area)?$estate->{{ l('area." متر":""}}') }}
                                        </span>
                                        @if($estate->geography != null)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ getFeatureValue($featureValues, $estate->geography)}}
                                        </span>
                                        @endif
                                        @if($estate->built_year != null)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> ساخت: {{buildYear($estate->built_year)}}
                                        </span>
                                        @endif
                                        @endif
                                        @if($estate->estate_type == 3 || $estate->estate_type == 4)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{!empty($estate->area)?$estate->{{ l('area." متر":""}}') }}
                                        </span>
                                        @if($estate->geography != null)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ getFeatureValue($featureValues, $estate->geography)}}
                                        </span>
                                        @endif
                                        @if($estate->document_type != null || $estate->convertible != null)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-real-estate-buy me-1 mt-n1 fs-lg text-muted"></i>
                                            @if ($estate->type == 1)
                                                {{getFeatureValue($featureValues, $estate->document_type)}}
                                            @endif
                                            @if ($estate->type == 2)
                                                {{getFeatureValue($featureValues, $estate->convertible)}}
                                            @endif
                                        </span>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        <section class="bg-primary mb-5">
            <div class="container py-5">
                <div class="d-flex flex-column flex-lg-row gap-4 justify-content-between align-items-center">
                    <h2 class="mb-0 text-white mt-4 mt-md-0">{{ l('مشاوره رایگان خرید و اجاره ملک') }}</h2>
                    <div class="d-flex align-items-center gap-4">
                        <div class="text-white">
                            <p class="mb-2 text-white fs-5">{{ l('همین حالا تماس بگیرید') }}</p>
                            <a class="text-white text-decoration-none fs-6" href="">09129406124 </a>
                        </div>
                        <i class="fi-phone text-white fs-3"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Top offers (carousel)-->
        <section class="container mb-5 pb-md-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h3 mb-0 ">{{ l('جدیدترین خانه های رهن و اجاره') }}</h2>
                <a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?type=2">
                    {{ l('مشاهده همه') }} <i class="fi-arrow-long-left ms-2"></i></a>
            </div>
            <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2 ">
                <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4"
                    data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                    <!-- Item-->
                    @foreach ($estatesr as $estate)
                    <div class="col">
                        <div class="card shadow-sm card-hover border-0 h-100">
                            <div class="card-img-top card-img-hover">
                                <a class="img-overlay" href="/v/{{ $estate->id }}"></a>
                                <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                    <span class="d-table badge bg-info mb-1">{{ toPersianDate($estate->created_at) }}</span>
                                    <span class="d-table badge bg-primary">{{estateTypes($estate->estate_type)}}</span>
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
                                    <a class="nav-link stretched-link" href="/v/{{ $estate->id }}"> {{ $estate->title }}</a>
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
                                        <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{!empty($estate->area)?$estate->{{ l('area." متر":""}}') }}
                                    </span>
                                    @if($estate->geography != null)
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ getFeatureValue($featureValues, $estate->geography)}}
                                    </span>
                                    @endif
                                    @if($estate->built_year != null)
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> ساخت: {{buildYear($estate->built_year)}}
                                    </span>
                                    @endif
                                    @endif
                                    @if($estate->estate_type == 3 || $estate->estate_type == 4)
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{!empty($estate->area)?$estate->{{ l('area." متر":""}}') }}
                                    </span>
                                    @if($estate->geography != null)
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ getFeatureValue($featureValues, $estate->geography)}}
                                    </span>
                                    @endif
                                    @if($estate->document_type != null || $estate->convertible != null)
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-real-estate-buy me-1 mt-n1 fs-lg text-muted"></i>
                                        @if ($estate->type == 1)
                                            {{getFeatureValue($featureValues, $estate->document_type)}}
                                        @endif
                                        @if ($estate->type == 2)
                                            {{getFeatureValue($featureValues, $estate->convertible)}}
                                        @endif
                                    </span>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="back-komeh">
            <div class="container mb-5 mt-n3 mt-lg-0 py-5">
                <h3 class="fs-2 text-center">{{ l('چرا گیلند ملک برای شما انتخاب خوبی است ؟') }}</h3>
                <p class="fs-lg text-center">{{ l('در گل گیلند ملک با تمرکز بر ارزش ها و نیازهای مشتریان ، تخصص و حرفه ای بودن و تمام تلاش برای حفظ منافع شما ، به عنوان انتخاب خوبی در صنعت ملکی استان گیلان مطرح است.') }}</p>
                <div class="row">
                        <div class="col-12 col-lg-6 mb-3">
                            <div class="card card-hover shadow-sm border-0 h-100 pb-2 pb-sm-3 px-sm-3 text-center">

                                <div class="card-body">
                                    <p class="mb-2 text-justify">
                                    <b>{{ l('1-تجربه و حرفه :') }}</b> {{ l('گیلند ملک یک تیم با تجربه واقعی و متخصص در زمینه صنعت ملکی می باشد که به شما این امکان را می دهد بهترین خدمات را در خرید، فروش، و سرمایه گذاری در املاک و مستغلات دریافت کنید.') }}
                                    </p>

                                    <p class="m-0 text-justify">
                                        <b>{{ l('2-دانش قابل اعتماد:') }}</b> {{ l('گیلند ملک با داشتن دانش گسترده در زمینه قوانین ملکی و مشاوره تخصصی ، به شما اطمینان می دهد که تمام مراحل خرید یا فروش ملک خود را بدون هیچ ابهامی و بسیار واضح وروشن و در کمال آرامش انجام دهید.') }}
                                    </p>
                                    <p class="mb-2 text-justify">
                                    <b>{{ l('4- تمرکز بر نیازها:') }}</b> {{ l('گیلند ملک با توجه به نیازها و مهارت های شما و با شناخت دقیق از بازار ملکی ، به شما راهنمایی حرفه ای می دهد تا بهترین تصمیم را در مورد خرید یا فروش ملک خود بگیرید.') }}
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <div class="card card-hover shadow-sm border-0 h-100 pb-2 pb-sm-3 px-sm-3 text-center">

                            <div class="card-body">
                                    <p class="mb-2 text-justify">
                                    <b>{{ l('3- ارتباطات و همکاری :') }}</b> {{ l('گیلند ملک با داشتن رابطه ای صمیمانه و دوستانه با کارشناسان ملکی ، توسعه دهندگان و سازندگان و سایر عوامل صنعت ملک ، به شما کمک می کند تا بهترین به معاملات ، فرصت ها و نتایج ممکن دست پیدا کنید.') }}
                                    </p>

                                    <p class="m-0 text-justify">
                                    <b>{{ l('5- حفظ منافع شما :') }}</b> {{ l('گیلند ملک با تضمین حفظ منافع شما به عنوان مشتری ، مسیری مطمعن و امن برای خرید یا فروش ملک برای شما فراهم می کند. همچنین با توجه بازخورد مثبت مشتریان قبلی و مشاهده ارزیابی های مثبت درباره گیلند ملک می تواند تاثیر مستقیمی در تصمیم شما برای انتخاب آنها بگذارد.') }}
                                    </p>
                                </div>

                            </div>
                        </div>

                </div>
            </div>
        </section>

        <section class="container mt-n3 mt-lg-0 mb-5">
            <div class="overflow-hidden rounded-3  bg-secondary g-0 row flex-column-reverse flex-lg-row align-items-center">
                <div class="col-12 col-lg-6 p-0">
                    <div class="mx-5 py-3">
                        <h2 class="fs-2 mb-3">{{ l('مالک هستید؟') }}</h2>
                        <p class="fs-6 mb-3">{{ l('با چند کلیک ساده، ملک‌تون رو به‌صورت رایگان در گیلندملک آگهی و در سریع‌ترین زمان ممکن معامله کنید.') }}</p>
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

        <section class="container mb-5 pb-md-4">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <h2 class="h3 mb-4 mt-4 mt-lg-0">{{ l('کارشناسان  گلیند ملک') }}</h2>

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
                        <img class="w-100" src="https://www.2nabsh.com/_img/landings/realtor.jpg" alt="img" >
                    </div>
                </div>
                <div class="col-12 col-lg-6 p-0 order-first order-lg-last">
                    <div class="mx-5 py-3">
                        <h2 class="fs-2 mb-3">{{ l('مشاور املاک هستید؟') }}</h2>
                        <p class="fs-6 mb-3">{{ l('گیلند ملک باعث توسعۀ کسب‌وکار بیش از ۱۵۰۰۰ مشاور املاک متخصص شده.شانس‌تون رو در پیوستن به این مجموعه و توسعۀ کسب‌وکارتون امتحان کنید.') }}</p>
                        <button class="btn btn-primary">{{ l('ثبت رایگان آگهی') }}</button>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog-->
        <section class="container pb-lg-5 pb-4 mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
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
                            <a class="card-img-top" href="{{$item->url()}}" style="background-image: url({{$item->img()}});"></a>
                            <div class="card-body d-flex flex-column">
                                <h3 class="fs-base pt-1 mb-2">
                                    <a class="nav-link" href="{{$item->url()}}">
                                        {{$item->title}}
                                    </a>
                                </h3>
                                <p class="fs-sm text-muted">
                                    {!!$item->description!!}
                                </p>
                                <a class="d-flex align-items-center text-decoration-none mt-auto" href="#">
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
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('چرا باید در گیلان زمین یا ویلا بخرم؟') }}
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    {{ l('خرید زمین یا ویلا در گیلان میتواند یک سرمایه گذاری پر سودی باشد و به عنوان محل اقامت دوم مزایای زیادی برای شما داشته باشد از جمله اینکه') }} <br>

                    {{ l('از طبیعت زیبا و سرسبز و آب و هوای خنک و معتدل و جنگل های لذت بخش و مهم تر از همه دریای زیبای خزر و سواحل شمالی استفاده می کنید و آرامش را برای خود به ارمغان می آورید.و همچنین به علت توریستی بودن استان گیلان و حجم بالای مسافران در طول فواصل مختلف در این استان می توانید حتی در غیاب خود کسب درامد کنید.') }} <br>

                    {{ l('با توجه به استقبال متداوم از گردشگران و علاقه مندان به این استان بازار ملک در گیلان رشد قابل توجهی داشته است که موجب شده تا خریداران ملک در این منطقه با افزایش ارزش ملک از سرمایه گذاری خود سودهای خوبی به دست بیاورند.') }}
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    {{ l('آیا خرید ملک در گیلان سرمایه گذاری خوبی حساب می شود؟') }}
                    </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    {{ l('خرید ملک در گیلان زمانی سرمایه گذاری پر سودی حساب می شود زمانی با مشاور ملکی و یا کارشناس املاک معتبر مشورت کنید و تمام اسناد و مدارک را بررسی کنید تا بتوانید یک ملک پرسودخریداری کنید که در این راستا تیم گیلند ملک با کارشناسان معتبر و آموزش دیده آماده ارایه خدمات به شما عزیزان می باشد.') }} <br>

                    {{ l('اما در کل استان گیلان به علت رشد صنعت گردشگری و هجوم گردشگران داخلی و خارجی به این منطقه تقاضا برای اقامت و خدمات افزایش پیدا کرده و در نتیجه ارزش ملک هاهر ساله چندین برابر افزایش دارد.') }}
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    {{ l('آیا در شمال زمین بخرم یا ویلا؟') }}
                    </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                                        {{ l('خرید زمین یا ویلا به شما بستگی دارد که چه نیازها و هدفی دارید') }}<br>

                        {{ l('هر دومزایای خوب و منحصر به فرد خود را دارد مثلا با خریدن زمین در شمال می توانید خانه یا ویلای مورد علاقه خود با طراحی منحصر به فرد و مورد علاقه خود را داشته باشید کما این که حتی اگر علاقه ای به ساخت زمین هم نداشته باشید در طولانی مدت یک منبع سرمایه گذاریست که با گذشت زمان ارزش خود را افزایش می دهدو اگر زمین نزدیک دریا یا جنگل باشد می توان از آن به عنوان اقامت گاه های توریستی و یا تفریحگاه استفاده کرد و هم آرامش را تجربه کنید هم کسب درآمد کنید') }}<br>

                        {{ l('اما خرید ویلا هم در کنار زمین مزایای خوب دیگری دارد از جمله اینکه می تواند اقامت گاه دوم باشدو فرصتی باشد تا برای فرار از شلوغی استراحت و تفریح کرد و همچنین در نبود خود می توان از ویلا کسب درآمد داشت البته که باید با توجه به نیازها و اولویت های خود تصمیم بگیرید') }}
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                    {{ l('ویلاهای جنگلی چه مزیت هایی دارند؟') }}
                    </button>
                    </h2>
                    <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    {{ l('این نوع ویلاها معمولا در کنار جنگل ها و مناطق طبیعی واقع می شن. یکی از بزرگترین مزیت هاشون اینه که بهت امکان آرامش و تماشای طبیعت بینهایت رو میده . وقتی از شهر به جنگلی ترین منطقه منتقل می شی ، حس و حال دیگه ای بهت دست میده ، صدای آب روانه ها ،بوی هوای تازه ، و یه احساس عجیب و غریب آزادی انگار قلبت باز میشه') }}<br>

                    {{ l('اما در کنار همه این زیبایی ها باید یک سری نکته ها هم در نظر گرفته بشه . از جمله اینکه ویلاهای جنگلی ممکنه از شهر و امکانات ضروری دور باشن پس باید مطمعن بشی که راه دسترسی بهتری دارن. همچنین بررسی کن که زمانی که خارج از فصل تعطیلات به جنگل می روی ، امکانات تفریحی و خدماتی اون منطقه موجوده یا نه') }}
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                    {{ l('ویلاهای ساحلی چه مزیت هایی دارند؟') }}
                    </button>
                    </h2>
                    <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('ویلاهای ساحلی بیشتر در نزدیک سواحل و دریا واقع می شن . این نوع ویلاها معمولا امکانات بهتری نسبت به جنگلی ها دارن و تماشای دریا و آفتاب غروب بهت احساس آرامش و شادابی می دهد. همچنین امکانات تفریحی و ورزشی در نزدیکی این نوع معمولا بیشتر هستن. اگر قصد سرمایه گذاری در ویلاهای ساحلی یا جنگلی را داری حتما با مشاوران متخصصان ملکی از جمله تیم گیلند ملک مشورت کن تا اونها با توجه به نیازها و اهدافت بهترین پیشنهاد رو برای سرمایه گذاری به شما بدهند.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                    {{ l('ثبت ملک در سایت گیلند ملک چگونه است؟') }}
                    </button>
                    </h2>
                    <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('برای فروش ملک خود در سایت گیلند ملک در قسمت ثبت رایگان ملک در سایت، ملک خود را ثبت کنید و تمام مشخصات ملک را با جزییات کامل بنویسید و با یکی از کارشناسان ارتباط بگیرید تا بصورت تخصصی برای فروش ملک شما اقدام کنند.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                    {{ l('چگونه می توان متوجه شد که سند مربوط به همان ملک می باشد؟') }}
                    </button>
                    </h2>
                    <div id="collapse7" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('برای متوجه شدن اینکه سند مربوط به یک ملک خاص تعلق دارد یا نه می توانی ببینی که آیا اسم و آدرس مالک سند و آدرس فردی که در معامله اصلی قرارداد بستید همخوانی دارد یا نه') }} <br>

                        {{ l('همچنین هر سند ثبتی شماره ی پلاک منحصر به فردی دارد و اگر پلاک ملک موجود در سند با پلاک مورد نظر همخوانی داشته باشد به احتمال زیاد سند متعلق به آن ملک می باشد.') }}<br>

                        {{ l('از دیگر راه های تشخیص سند این است که با مشاورین املاک معتبر صحبت کنید تا آنها بر اساس بررسی سند و مدارک مربوطه تایید به شما بدهند.') }}<br>

                        {{ l('در صورت نیاز برای اطمینان بیشتر و در صورت نیاز به موارد حقوقی می توانید با وکیل مشورت کنید و آنها می توانند با بررسی سند و مدارک مربوطه تایید بدهند.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                    {{ l('آیا ثبت ملک در سایت گیلندملک هزینه ای دارد؟') }}
                    </button>
                    </h2>
                    <div id="collapse8" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('در حال حاضر ثبت ملک در سایت گیلند ملک توسط افراد عادی وکارشناسان رایگان هست تا همه افراد بتوانند از این فرصت استفاده کنند و در کمترین زمان ملک خود را بفروش برسانند') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                    {{ l('گیلند ملک چیست و در چه شهرهایی فعالیت می کند؟') }}
                    </button>
                    </h2>
                    <div id="collapse9" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('گیلند ملک یک تیم متخصص و آموزش دیده در زمینه املاک هست که به صورت متمرکز فقط در استان گیلان و مخصوصا شهر رضوانشهر (بهشت ایران) فعالیت می کنند.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                    {{ l('اهداف گیلند ملک چیست ؟') }}
                    </button>
                    </h2>
                    <div id="collapse10" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('گیلند ملک مجوعه ای آموزش دیده از کارشناسان و مشاوران املاک با تجربه هستند که با هدف خدمت رسانی درست و اصولی فعالیت خود را در سال های اخیر به صورت گسترده و در فضای مجازی آغاز کرده است .') }} <br>

                        {{ l('از دیگر اهداف گیلند ملک به عنوان یک مجموعه در زمینه املاک و مستغلات در منطقه گیلان ، ارایه خدماتی حرفه ای و کارآمد در زمینه معاملات ملکی در استان گیلان می باشد و تمام تلاش خود را می کند تا با صداقت تمام به سرمایه گذاران و مشتریان بهترین خدمات را ارایه دهد و شما بتوانید خرید امن و مطمعن در کنار آرامش داشته باشید.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                    {{ l('چه عواملی بر قیمت ویلا و زمین در گیلان تاثیر گذار است؟') }}
                    </button>
                    </h2>
                    <div id="collapse11" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('قیمت ویلاها و زمین در گیلان بستگی به عوامل مختلفی دارد از جمله :') }}<br>

                            {{ l('1- موقعیت جغرافیایی که برخی مناطق به علت دارا بودن در منظره های طبیعی مثل کوهستان ها ، دریاها و جنگل ها دارای قیمت بالاتری هستند.') }}<br>

                            {{ l('2-امکانات و خدمات: معمولا در مناطقی که امکانات و خدمات کامل تری از جمله دریا، مراکز تجاری،شهرها و …در دسترس می باشد زمین و ویلا قیمت بالاتری دارد.') }}<br>

                            {{ l('3-ورود سرمایه گذاران و بازار ملک: اگر بازار ملک در یک منطقه روند رشدی دارد و جذاب برای سرمایاه گذاران به نظر می رسد قیمت ها در این منطقه افزایش می یابند.') }}<br>

                            {{ l('4-امکانات داخل ویلا و درون زمین : امکانات و ویژگی هایی که در داخل هر ویلا و زمین قرار دارد بر قیمت تاثیر گذار می باشد هر چقدر زمین یا ویلا امکانات بیشتری داشته باشد ممکن است قیمت بالاتری داشته باشد.') }}<br>

                            {{ l('5- عوامل اقتصادی : افزایش قوت خرید جامعه ، شرایط اقتصادی و اصولا عرضه و تقاضای بازار ملک در منطقه می تواند باعث افزایش یا کاهش قیمت ها شود.') }}<br>

                            {{ l('برای اطلاعات دقیق تر از موقعیت و قیمت ملک و زمین خود می توانید با کارشناسان آموزش دیده گیلند ملک در ارتباط باشید.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                    {{ l('سودآورترین ملک ها در گیلان کدامند؟') }}
                    </button>
                    </h2>
                    <div id="collapse12" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('برخی از ملک ها و زمین ها در گیلان پر سودتر می باشد از جمله :') }} <br>

                            {{ l('ویلاهای دریاچه ای و زمین های جنگلی و ساحلی که به توجه به حجم بالای مسافران و گردشگری در این مناطق می تواند به طور طبیعی سودهای زیادی هم بر ارزش ملک و هم کسب درآمد داشته باشد.') }}<br>

                            {{ l('همچنین ملک های تجاری و خدماتی در شهرهایی مثل رشت، لاهیجان، منطقه آزاد بندر انزلی به عنوان مراکز اقتصادی و تجاری ارایه دهنده انواعفرصت های سرمایه گذاری و کسب و کار می باشد.') }}<br>

                            {{ l('در کل برای بهره برداری حداکثری و داشتن ملک سودآور در گیلان باید تحقیقات دقیقی انجام دهید و بازار ملک را ب ه خوبی بررسی کنید و نیاز بازار و تقاضا و همچنین شرایط اقتصادی را در نظر بگیرید و از مشاورین املاک با تجربه و آموزش دیده کمک بگیرید. جهت ارتباط با کارشناسان ما در این زمینه می توانید به قسمت کارشناسان در سایت مراجعه نمایید یا با دفتر گیلند ملک به شماره 01344624078 تماس حاصل فرمایید.') }}

                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
                    {{ l('من مشاور املاک هستم چگونه می توانم با گیلند ملک همکاری کنم و ملک های خود را ثبت کنم ؟') }}
                    </button>
                    </h2>
                    <div id="collapse13" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('از قسمت ثبت رایگان ملک می توانید ملک های خود را با شماره همراه خود قرار دهید تا مشتریان به شما ارتباط بگیرند . حتی می توانید با مدیر مجموعه گیلندملک ارتباط بگیرید و بعد از گذراندن مراحلی در سایت به عنوان کارشناس فروش فعالیت خود را گسترده تر کنید.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse14" aria-expanded="false" aria-controls="collapse14">
                    {{ l('اگر ملکی که مد نظر من هست در سایت موجود نبود آیا راهکار دیگری برای پیدا کردن ملک دارید ؟') }}                </button>
                    </h2>
                    <div id="collapse14" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('با توجه به نیاز شما در صورتی که ملک مورد نظرتان در سایت موجود نبود می توانید با کارشناسان گیلند ملک ارتباط بگیرید و تمام جزییات و مشخصات ملک مورد نظر را ذکر کنید تا یادداشت شود و به محض موجود شدن ملک شما در سایت یا ملک های مشابه آن پیامک برای شما ارسال می شود و شما مطلع می شوید.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse15" aria-expanded="false" aria-controls="collapse15">
                    {{ l('آیا گیلند ملک در شهرهای دیگر نیز نمایندگی دارد؟') }}
                    </button>
                    </h2>
                    <div id="collapse15" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('در حال حاضر دفتر گیلند ملک در رضوانشهر می باشد و نمایندگی هایی در استان های مختلف به صورت دورکاری در حال فعالیت و همکاری با مجموعه هستند در صورتی که شما هم تمایل به همکاری با مجموعه را دارید می توانید با دفتر تماس بگیرید تا راهنمایی های لازم انجام شود.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
                    {{ l('آیا گیلند ملک مشاوره برای سرمایه گذاری پرسود به من می دهد؟') }}
                    </button>
                    </h2>
                    <div id="collapse16" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('بله گیلند ملک با توجه به تجربه و دانش خود در زمینه بازار ملک گیلان و با تحلیل و بررسی موثر روند بازار می تواند پیشنهادات قابل اعتمادی در زمینه سرمایه گذاری به شما بدهد.') }}<br>

                            {{ l('همچنین گیلند ملک می تواند به شما در ارزیابی سودآوری و ریسک ها ، درک قوانین مربوط به سرمایه گذاری در ملک ها در گیلان ، راهنمایی در معاملات و مراحل قانونی، و تامین اطلاعات کامل و معتبر در مورد بازار ملک گیلان به شما کمک کند.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
                    {{ l('آیا گیلند ملک مشاوره برای ساخت و ساز و مشارکت در ساخت هم دارد؟') }}
                    </button>
                    </h2>
                    <div id="collapse17" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('بله گیلند ملک می تواند در ساخت و ساز و مشارکت در پروژه های ساختمانی همکاری کند. مشارکت در ساخت معمولا به معنی همکاری با سرمایه گذاران به منظور ساخت یا توسعه پروژه های ساختمانی است. این همکاری می تواند شامل مشارکت در ساخت و توسعه ویلا، آپارتمان ، هتل ، مجتمع تجاری و … باشد.') }} <br>

                        {{ l('با همکاری گیلند ملک شما می توانید به عنوان سرمایه گذار در پروژه های ساختمانی شرکت کرده و به منظور احداث یک واحد مسکونی یا تجاری از تجربه و دانش این مجموعه بهره برداری کنید.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
                    {{ l('آیا گیلند ملک اجاره روزانه و اقامتگاه هم دارد؟') }}
                    </button>
                    </h2>
                    <div id="collapse17" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        {{ l('بله گیلند ملک امکانات اجاره روزانه و اقامتگاه را نیز در گیلان در اختیار دارد. این مجموعه می تواند به شما در اجاره و مدیریت ویلاها ، آپارتمان ها ، سوییت ها و کلبه ها و دیگر اقامتگاه های تعطیلاتی در مناطق گیلان به شما کمک کند.') }} <br>

                        {{ l('علاوه بر اجاره روزانه ،گیلند ملک می تواند به شما در کشف ، مدیریت و بهره برداری از اقامتگاه ها بر حسب نیازها و بودجه مشتریان به شما کمک کند تا از اقامت مطلوب و راحتی در گیلان برخوردار شوید.') }}
                        </div>
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
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
    <script src="/vendor/expandable/jquery.expandable.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() { $('.tags').expandable({ height: 100, more: l("نمایش بیشتر"), less: l("نمایش کمتر") }); $('.qaa').expandable({ height: 400, more: l("نمایش بیشتر"), less: l("نمایش کمتر") }); });
    </script>
@endsection
