@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME'),
    'canonical' => '/'
])

@section('main_content')
<style>
    .gradient-bg {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.3));
            padding: 10px;

    }
    .card-est{
        height: 250px;
        width: 100%;
        object-fit:cover;
    }
    .img_expert {
        height: 330px;
    }
    .apart {
        background: #ffb900;
        z-index: 1000;
        position: relative;
        padding: 10px 18px;
        width: 55%;
        color: #000;
        font-size: 16px;
    }
    .apart:after {
        content: "";
        background: #ffb900;
        z-index: -1;
        width: 40px;
        height: 100%;
        transform: skew(30deg);
        position: absolute;
        top: 0;
        left: -15px;
    }
    .sale {
        background: #2b2727;
        padding: 10px;
        text-align: center;
        color: #fff;
        width: 45%;
        font-size: 16px;
        font-weight: 300;
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
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <link rel="stylesheet" media="screen" href="/vendor/expandable/jquery.expandable.css" />
        <style>
            @php
                $rand = rand(1,7);
            @endphp
            .object-fit {
                object-fit: cover;
            }
            .image_v {
                background-image: url({{crop('/img/site8/qom'.$rand.'.jpg' , 1000 , 650)}});
                background-attachment: inherit;
                background-size: cover;
                background-position: center;
            }
            .image_x {
                background-image: url({{crop('/img/site8/qom'.$rand.'.jpg' , 1000 , 650)}});
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
                    background-image: url({{crop('/img/site8/qom'.$rand.'.jpg' , 1272 , 1272)}});
                }
              .image_x {
                    background-image: url({{crop('/img/site8/qom'.$rand.'.jpg' , 1272 , 1272)}});
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
                <div class="">
                    <div class="" >
                        <div>
                            <div class=" text-center rounded">
                                <div class="jarallax card align-items-center justify-content-center border-0 p-md-5 p-4 mt-n3 bg-transparent" style="min-height: 530px;border-radius:unset " data-jarallax data-speed="0.5">
                                    <!-- Video Background -->
                                    <video autoplay muted loop class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="z-index: 0;">
                                        @php
                                        $screen = new \Jenssegers\Agent\Agent;
                                        @endphp

                                        @if ($screen->isMobile())
                                            <source src="/img/site8/backmobile.mp4" type="video/mp4">

                                        @else
                                        <source src="/img/site8/back.mp4" type="video/mp4">
                                        @endif
                                        مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                                    </video>
                                    <h1 class="display-5  px-md-3  text-white text-center zindex-1 bg-opacity-50  rounded-2 h1-hero from-top">
                                        {{ l('بر قله های اعتماد و اعتبار ایستاده ایم') }}
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

                    </div>
                </div>
        </section>
        <hr class="mt-n1 mb-5 d-md-none  d-lg-none">

        <section class="container ">
            <div class="row m-1">
                <div class="col-lg-3 col-md-6 col-6 mb-2">
                    <a href="/c/{{ $selectedCity }}?type=1&view=1&maxprice=3000000000">
                        <img src="/img/site8/price1.jpg" class="rounded-1" style="width: 100%">
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-2">
                    <a href="/c/{{ $selectedCity }}?type=1&view=1&minprice=3000000000&maxprice=6000000000">
                        <img src="/img/site8/price2.jpg" class="rounded-1" style="width: 100%">
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-2">
                    <a href="/c/{{ $selectedCity }}?type=1&view=1&minprice=6000000000&maxprice=10000000000">
                        <img src="/img/site8/price3.jpg" class="rounded-1" style="width: 100%">
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-2">
                    <a href="/c/{{ $selectedCity }}?type=1&view=1&minprice=10000000000&maxprice=15000000000">
                        <img src="/img/site8/price4.jpg" class="rounded-1" style="width: 100%">
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
        @if(count($estates)>0)
        <section class="container mb-5 pb-md-4 mt-lg-0 pt-lg-3">
            <div class="d-flex flex-column flex-md-row gap-3 gap-lg-0 align-items-lg-center align-items-start justify-content-between mb-3">
                <h2 class="h3 mb-0 ">{{ l('جدیدترین خانه های خرید و فروش') }}</h2>
                <a class="btn btn-link fw-normal p-0"
                    href="/c/{{ $selectedCity }}?type=1">{{ l('مشاهده همه') }}<i class="fi-arrow-long-left ms-2"></i>
                </a>
            </div>
            <div>
                <div class="row">
                    @foreach ($estates as $estate)
                    <div class="col-lg-4 col-sm-12 mt-3">
                        @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate])
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif



        <!-- Top offers (carousel)-->

        <section class="bg-primary mb-5">
            <div class="container py-5">
                <div class="d-flex flex-column flex-lg-row gap-4 justify-content-between align-items-center">
                    <h2 class="mb-0 text-white mt-4 mt-md-0">{{ l('مشاوره رایگان در زمینه خرید و اجاره املاک و مستغلات، تهاتر و مشارکت در ساخت، با هدف ارائه بهترین راهکارهای ملکی به شما') }}</h2>
                    <div class="d-flex align-items-center gap-4">
                        <div class="text-white">
                            <p class="mb-2 text-white fs-5">{{ l('همین حالا تماس بگیرید') }}</p>
                            <a class="text-white text-decoration-none fs-6" href="tel:09122517572">09122517572 </a>
                            &nbsp;
                            <a class="text-white text-decoration-none fs-6" href="tel:0999994609">0999994609 </a>
                        </div>
                        <i class="fi-phone text-white fs-3"></i>
                    </div>
                </div>
            </div>
        </section>
        @if(count($estatesr)>0)
        <section class="container  pb-4 ">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h3 mb-0 ">{{ l('جدیدترین املاک رهن و اجاره') }}</h2>
                <a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?type=2">
                    {{ l('مشاهده همه') }} <i class="fi-arrow-long-left ms-2"></i></a>
            </div>
            <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2 " dir="rtl">
                <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:3}}}">
                    <!-- Item-->
                    @foreach ($estatesr as $estate)
                    <div class="col">
                        @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate])

                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <section class="back-komeh">
            <div class="container">
                <div class=" mb-5 mt-n3 mt-lg-0 py-5">
                    <h3 class="fs-2 text-center">{{ l('چرا شبکه املاک مرکزی برای شما انتخاب خوبی است ؟') }}</h3>
                    <p class="fs-lg text-justify text-lg-center">{{ l('شبکه املاک مرکزی قم، با تکیه بر تخصص و تجربه تیم حرفه‌ای خود و بهره‌گیری از یک سایت تخصصی پیشرفته، خدمات ملکی را به صورت سریع و مطمئن ارائه می‌دهد و نیازهای متنوع مشتریان را در حوزه املاک برآورده می‌سازد.') }}</p>
                </div>
            </div>
        </section>



        <section class="container mb-5 pb-md-4">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <h2 class="h3 mb-4 mt-4 mt-lg-0">{{ l('کارشناسان شبکه املاک مرکزی') }}</h2>

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



        <style>

            .expandable .expand-bar {
                font-size: 9px;
            }

            .to-expand {
                padding-bottom: 50px;
            }
        </style>



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
