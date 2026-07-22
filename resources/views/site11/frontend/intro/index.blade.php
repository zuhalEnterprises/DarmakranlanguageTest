
@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
'canonical' => 'https://cafoo.ae'
])
@section('main_content')
<!-- main -->
<main class="page-wrapper">

    @include(ss('THEME') . '.frontend.layouts.header_v2')
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
        @php
            $rand = rand(1,11);
        @endphp
        .object-fit {
            object-fit: cover;
        }
        .image_v {
            background-image: url({{crop('/img/site11/'.$rand.'.jpg' , 1650 , 650)}});
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
                background-image: url({{crop('/img/site11/'.$rand.'.jpg' , 1650 , 650)}});
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
    <section class="container-fluid px-0">
        <div class="jarallax card align-items-center image_v justify-content-md-center border-0 p-md-5 p-4 bg-secondary mt-n3 height-hero" style="border-radius:unset; " data-jarallax data-speed="0.5">
            @php
            $screen = new \Jenssegers\Agent\Agent;
            @endphp
            <!-- <span class="img-overlay opacity-40"></span> -->
            <div class="content-overlay" style="max-width: 856px;">
                <h1 class="display-5 mt-md-5 pt-md-5 text-white text-center">
                    <span style="color:#fffd38">
                    {{ l('دارمکران') }}
                    </span>
                    {{ l('سرمایه‌گذاری امروز، آرامش فردا') }}
                </h1>
                <div class="box box1 d-flex flex-wrap align-items-center gap-3 justify-content-center mt-4">
                    <div class="widget-property-type-banner">
                        <a class="type-banner-property style2 text-warning" href="/c/dubai?type=1">
                            <i class="fi-cash fs-2"></i>
                            <h4 class="text-warning mb-0 mt-1">
                                {{ l('فروش') }}
                            </h4>
                        </a>
                    </div>
                    <div class="widget-property-type-banner">
                        <a class="type-banner-property style2 text-warning" href="/c/dubai?type=2">
                            <i class="fi-rent fs-2"></i>
                            <h4 class="text-warning mb-0 mt-1">
                                {{ l('اجاره') }}
                            </h4>
                        </a>
                    </div>
                    <div class="widget-property-type-banner">
                        <a class="type-banner-property style2 text-warning" href="/add">
                            <i class="fi-house-chosen fs-2"></i>
                            <h4 class="text-warning mb-0 mt-1">
                                {{ l('ثبت ملک') }}
                            </h4>
                        </a>
                    </div>
                    <div class="widget-property-type-banner">
                        <a class="type-banner-property style2 text-warning" href="javascript:void(0)" onclick="leadrequest()">
                            <i class="fi-billboard-house fs-2"></i>
                            <h4 class="text-warning mb-0 mt-1">
                                {{ l('ثبت تقاضا') }}
                            </h4>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="container pb-4 pt-3" data-aos="fade-up">
        <div class="d-flex align-items-center justify-content-between mb-3 mt-3">
            <h2 class="h3 mb-0 ">{{ l('املاک فروشی') }}</h2>
            <a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?type=1">
                {{ l('مشاهده همه') }} <i class="fi-arrow-long-left ms-2"></i>
            </a>
        </div>
        <div class="" dir="rtl" >
            <div class="row">
                <!-- Item-->
                @php
                $co = 0;
                @endphp
                @foreach ($estates as $estate)
                @php
                $co++;
                @endphp
                <div class="col-lg-3 col-sm-12 p-2 m-0 ">
                    @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Top offers (carousel)-->

        <section class="bg-primary mb-5" data-aos="fade-up">
            <div class="container py-5">
                <div class="d-flex flex-column flex-lg-row gap-4 justify-content-between align-items-center">
                    <h2 class="mb-0 text-white mt-4 mt-md-0">{{ l('مشاوره رایگان خرید و اجاره ملک') }}</h2>
                    <div class="d-flex align-items-center gap-4">
                        <div class="text-white">
                            <p class="mb-2 text-white fs-5">{{ l('همین حالا تماس بگیرید') }}</p>
                            <a class="text-white text-decoration-none fs-6" href="tel:00971557621019">971557621019+ </a>
                            &nbsp;

                        </div>
                        <i class="fi-phone text-white fs-3"></i>
                    </div>
                </div>
            </div>
        </section>
    @if($estateurgent != null)
    <!-- Top offers (carousel)-->
    <section class="container pb-4" data-aos="fade-up">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0 ">{{ l('املاک فروش فوری') }}</h2>
            <a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?type=2">
                {{ l('مشاهده همه') }} <i class="fi-arrow-long-left ms-2"></i></a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2 " dir="rtl">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                <!-- Item-->
                @foreach ($estateurgent as $estate)
                <div class="col">
                    @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <section data-aos="fade-up">
        <div class="container">
            <div class=" mb-5 mt-n3 mt-lg-0 py-5">
                <h3 class="fs-2 text-center">{{ l('چرا دارمکران برای شما انتخاب خوبی است؟') }}</h3>
                <p class="fs-lg text-justify text-lg-center">
                    {{ l('املاک دارمکران یک بنگاه معاملات ملکی در دبی است که به‌طور تخصصی خدمات خرید، فروش و اجاره ملک را به سرمایه‌گذاران ایرانی ارائه می‌دهد. با آشنایی کامل با بازار املاک امارات، املاک دارمکران مسیر مطمئنی برای سرمایه‌گذاری، خرید خانه و دریافت اقامت در دبی فراهم می‌کند.') }}
                </p>
            </div>
        </div>
    </section>

    <section class="container mt-n3 mt-lg-0 mb-5" data-aos="fade-up">
        <div class="overflow-hidden rounded-3  bg-secondary g-0 row flex-column-reverse flex-lg-row align-items-center">
            <div class="col-12 col-lg-6 p-0">
                <div class="mx-5 py-3">
                    <h2 class="fs-2 mb-3">{{ l('مالک هستید؟') }}</h2>
                    <p class="fs-6 mb-3 text-justify">{{ l('هر کجای کشور امارات که ملکی برای فروش دارید می تونید با چند کلیک ساده ملکتان را به صورت رایگان در دارمکران آگهی و در سریع ترین زمان ممکن معامله کنید') }}</p>
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
    @if($estatespecial != null)
    <!-- Top offers (carousel)-->
    <section class="container  pb-4 " >
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0 ">{{ l('املاک اکازیون') }}</h2>
            <a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?type=2">
                {{ l('مشاهده همه') }} <i class="fi-arrow-long-left ms-2"></i></a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2 " dir="rtl">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                <!-- Item-->
                @foreach ($estatespecial as $estate)
                <div class="col">
                    @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    @if($experts != null)
    <section class="container pb-md-4">
        <div class="d-flex align-items-center justify-content-center mb-3">
            <h2 class="h3 mb-4 mt-4 mt-lg-0"> {{ l('کارشناسان دارمکران') }}</h2>

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
                                        <img decoding="async" class="rounded img_expert" style="object-fit: cover;width:238px;height:238px"  width="420" height="420" src="{{ crop($expert->photo(),250,250) }}" class="attachment-large size-large object-fit" alt="{{ $expert->fullname() }}" />
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

                            </div>
                        </div>
                        <h2 class="agent-title mt-2 mb-0 text-center">
                            <a href="/agents/{{$expert->id}}" class="text-decoration-none fs-6">{{ $expert->fullname() }}</a>
                        </h2>
                        <div class="agent-information-bottom flex-middle">
                            <div class="property-job text-center">

                                @foreach($expert->roles as $role)
                                    @if($role->id == 9)
                                    {{($expert->activity_type == 1 ? l('مشاور فروش') : ($expert->activity_type == 2 ? l('مشاور اجاره') : l('مشاور فروش و اجاره')))}}
                                    @endif
                                @endforeach

                            </div>
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
    @endif

    <!-- Blog-->
    <section class="container pb-lg-5 pb-4 mb-4">
        <div class="d-flex flex-column flex-md-row gap-3 gap-lg-0 align-items-lg-center align-items-start justify-content-between mb-3">
            <h2 class="h3 mb-0">{{ l('مجله املاک امارات') }}</h2>
            <a class="btn btn-link fw-normal p-0" href="/blog">
                {{ l('مقالات بیشتر') }} <i class="fi-arrow-long-left ms-2"></i>
            </a>
        </div>
        <div class="row g-4">
                <!-- Post-->
                @foreach( $articlesArea as $item)
                <div class="col-lg-6">
                    <article class="card border-0 shadow-sm card-hover card-horizontal mb-4 h-100">
                        <a class="card-img-top" href="{{$item->url()}}" style="background-image: url({{crop($item->img(),379,379)}});"></a>
                        <div class="card-body d-flex flex-column">
                            <h3 class="fs-base pt-1 mb-2">
                                <a class="nav-link" href="{{$item->url()}}">
                                    {{$item->title}}
                                </a>
                            </h3>
                            <p class="fs-sm text-muted mt-3">
                                {!!$item->description!!}
                            </p>

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


    </style>

    <section class="container pb-md-4 mb-4">
        <h2 class="h3">{{ l('سوالات متداول (FAQ)') }}</h2>

        <div class="accordion qaa  to-expand" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('1. آیا اتباع ایرانی می‌توانند در دبی ملک خریداری کنند؟') }}
                </button>
                </h2>
                <div id="collapse10" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('بله. در بسیاری از مناطق آزاد دبی، اتباع خارجی از جمله ایرانیان می‌توانند مالکیت 100 درصدی ملک داشته باشند.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('2. حداقل مبلغ لازم برای خرید ملک در دبی چقدر است؟') }}
                </button>
                </h2>
                <div id="collapse11" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('قیمت ملک بسته به موقعیت، متراژ و امکانات متفاوت است، اما معمولاً از حدود 500,000 درهم آغاز می‌شود.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('3. آیا با خرید ملک می‌توان اقامت دبی را گرفت؟') }}
                </button>
                </h2>
                <div id="collapse12" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('بله. خرید ملک با حداقل ارزش مشخص (معمولاً 750,000 درهم به بالا) می‌تواند منجر به دریافت اقامت دو ساله قابل تمدید امارات شود.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse13" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('4. هزینه‌های جانبی خرید ملک شامل چه مواردی است؟') }}
                </button>
                </h2>
                <div id="collapse13" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('تنها شامل 4 درصد هزینه انتقال سند میباشد.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse14" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('5. آیا امکان پرداخت اقساطی برای خرید ملک در دبی وجود دارد؟') }}
                </button>
                </h2>
                <div id="collapse14" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('بله. بسیاری از پروژه‌های پیش‌فروش و برخی ملک‌های آماده، شرایط پرداخت اقساطی متنوعی ارائه می‌دهند.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse15" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('6. چرا باید از مشاوران املاک دارمکران کمک بگیرم؟') }}
                </button>
                </h2>
                <div id="collapse15" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('زیرا تیم ما با آشنایی کامل به بازار املاک دبی، شما را از ابتدا تا انتهای مسیر همراهی کرده و بهترین پیشنهادات را مطابق با نیازتان ارائه می‌دهد.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse16" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('7. مدت زمان انجام مراحل خرید ملک در دبی چقدر است؟') }}
                </button>
                </h2>
                <div id="collapse16" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('در صورت آماده بودن مدارک و توافق طرفین، فرآیند خرید ملک در دبی فقط 1 روز زمان می‌برد.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse17" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('8. آیا مالکیت ملک در دبی دائمی است؟') }}
                </button>
                </h2>
                <div id="collapse17" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('بله، در مناطق فری‌هولد (Freehold) مالکیت کامل و دائمی به خریدار داده می‌شود و قابل انتقال به وراث نیز هست.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse18" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('9. آیا خرید ملک در دبی نیاز به حضور فیزیکی دارد؟') }}
                </button>
                </h2>
                <div id="collapse18" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('خیر. امکان خرید ملک به‌صورت غیرحضوری و از راه دور با اعطای وکالت قانونی وجود دارد.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse19" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('10. آیا امکان اجاره دادن ملک خریداری‌شده وجود دارد؟') }}
                </button>
                </h2>
                <div id="collapse19" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('بله، خریدار می‌تواند ملک خود را به صورت کوتاه‌مدت یا بلندمدت اجاره دهد و از درآمد ارزی بهره‌مند شود.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse20" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('11. آیا مالیات سالانه بر املاک در دبی وجود دارد؟') }}
                </button>
                </h2>
                <div id="collapse20" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('خیر. در حال حاضر در دبی مالیات بر درآمد یا مالیات سالانه ملک دریافت نمی‌شود، اما هزینه‌هایی مانند هزینه خدمات ساختمان (service charge) وجود دارد.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    {{ l('12. تفاوت بین مناطق فری‌هولد و لیزهولد چیست؟') }}
                </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('در مناطق فری‌هولد مالکیت کامل به خریدار داده می‌شود، اما در مناطق لیزهولد مالکیت برای مدت معینی (مثلاً 99 سال) در اختیار خریدار قرار می‌گیرد.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse27" aria-expanded="false" aria-controls="collapse27">
                    {{ l('13. آیا برای خرید ملک باید حساب بانکی در امارات داشته باشم؟') }}
                </button>
                </h2>
                <div id="collapse27" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body text-justify">
                    {{ l('خیر. داشتن حساب بانکی الزامی نیست، اما برای دریافت اقامت یا انجام برخی پرداخت‌ها، افتتاح حساب بانکی توصیه می‌شود.') }}
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse28" aria-expanded="false" aria-controls="collapse28">
                    {{ l('14. آیا امکان دریافت وام برای خرید ملک در دبی وجود دارد؟') }}
                </button>
                </h2>
                <div id="collapse28" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('بله. اتباع خارجی می‌توانند با شرایط خاص از بانک‌های اماراتی یا موسسات مالی معتبر وام مسکن دریافت کنند.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse29" aria-expanded="false" aria-controls="collapse29">
                    {{ l('15. آیا دارمکران فقط در دبی فعالیت می‌کند یا در سایر امارات هم خدمات دارد؟') }}
                </button>
                </h2>
                <div id="collapse29" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('در حال حاضر تمرکز ما بر املاک دبی است، اما در صورت نیاز، پروژه‌ها و مشاوره‌هایی در سایر مناطق مانند شارجه و ابوظبی و سایر امارت ها نیز ارائه می‌دهیم.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse30" aria-expanded="false" aria-controls="collapse30">
                    {{ l('16. آیا دارمکران خدمات پس از خرید هم ارائه می‌دهد؟') }}
                </button>
                </h2>
                <div id="collapse30" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('بله. ما در دارمکران خدماتی مانند مدیریت ملک، اجاره دادن، نظارت بر تعمیرات و تمدید اقامت را نیز به مشتریان عزیز ارائه می‌دهیم.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse31" aria-expanded="false" aria-controls="collapse31">
                    {{ l('17. چگونه می‌توانم با کارشناسان دارمکران مشاوره رایگان داشته باشم؟') }}
                </button>
                </h2>
                <div id="collapse31" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('از طریق فرم تماس در سایت، واتساپ یا تماس مستقیم می‌توانید با ما ارتباط بگیرید و مشاوره اولیه کاملاً رایگان دریافت کنید.') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse32" aria-expanded="false" aria-controls="collapse32">
                    {{ l('18. دارمکران چه نوع املاکی را ارائه می‌دهد؟') }}
                </button>
                </h2>
                <div id="collapse32" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body text-justify">
                        {{ l('دارمکران در زمینه فروش آپارتمان‌، ویلا، واحدهای لوکس، املاک تجاری، پیش‌فروش و پروژه‌های در حال ساخت در مناطق مختلف دبی فعالیت دارد.') }}
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

@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
