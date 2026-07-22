@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => l('گیلند ملک | املاک رضوانشهر و پره سر')])

@section('head')
<style>
    .pic-fast {
        height: 120px;
    }

    /* Icon style with animation */
    .mobile-icon {
        display: inline-block;
        margin-right: 10px;
        font-size: 24px;
        animation: iconAnimation 1s infinite alternate;
        /* 1s duration, alternate direction */
    }

    /* Define the animation keyframes */
    @keyframes iconAnimation {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.2);
            /* You can adjust the scale factor */
        }
    }
</style>
@endsection

@section('main_content')
<main class="page-wrapper" style="background-color:#fff;">
    @include(ss('THEME') . '.frontend.layouts.header_rent')

    <section class="container py-5 mt-5 mb-lg-3">
        <div class="row align-items-center mt-md-2">
            <div class="col-lg-7 order-lg-2 mb-lg-0 mb-4 pb-2 pb-lg-0">
                <img class="d-block mx-auto" src="/img/site2/hero-img.jpg" width="746" alt="Hero image">
            </div>
            <div class="col-lg-5 order-lg-1 pe-lg-0">
                <h1 class="display-5 mb-4 ms-lg-n5 text-lg-start text-right ">{{ l('اجاره ویلا در بهشت ایران استان') }}
                    <span class="dropdown d-inline-block">
                        <a class="dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ l('گیلان') }}</a>
                        <!--span class="dropdown-menu dropdown-menu-end my-1" style="">
                            <a class="dropdown-item fs-base fw-bold" href="#">{{ l('مازندران') }}</a>
                            <a class="dropdown-item fs-base fw-bold" href="#">{{ l('گلستان') }}</a>
                            <a class="dropdown-item fs-base fw-bold" href="#">{{ l('تهران') }}</a>
                            <a class="dropdown-item fs-base fw-bold" href="#">{{ l('البرز') }}</a>
                            <a class="dropdown-item fs-base fw-bold" href="#">{{ l('آذربایجان شرقی') }}</a>
                        </span-->
                    </span>
                </h1>
                <p class="text-lg-start text-right mb-4 mb-lg-3 fs-lg">{{ l('جستجوی خود را آغاز کنید - مقصدتان کجاست؟') }}</p>
                <!-- Search form-->
                <div class="ms-lg-n5">
                    <form class="form-group d-block d-md-flex position-relative rounded-md-pill me-lg-n5">
                        <div class="input-group input-group-lg border-end-md"><span class="input-group-text text-muted rounded-pill pe-3"><i class="fi-search"></i></span>
                            <input class="form-control" type="text" placeholder="{{ l('میخوای کجا بری؟') }}">
                        </div>
                        <hr class="d-md-none my-2">
                        <div class="d-sm-flex">
                            <div class="dropdown w-100 mb-sm-0 mb-3" data-bs-toggle="select">
                                <button class="btn btn-link btn-lg dropdown-toggle ps-2 ps-sm-3" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-friends me-2"></i><span class="dropdown-toggle-label">{{ l('چند نفرید؟') }}</span></button>
                                <input type="hidden">
                                <ul class="dropdown-menu" style="">
                                    <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">1</span></a></li>
                                    <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">2</span></a></li>
                                    <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">3</span></a></li>
                                    <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">4</span></a></li>
                                    <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">5</span></a></li>
                                    <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">6</span></a></li>
                                    <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">7</span></a></li>
                                    <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">8</span></a></li>
                                    <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">9</span></a></li>
                                    <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">+10</span></a></li>
                                </ul>
                            </div>
                            <button class="btn btn-primary btn-lg rounded-pill w-100 w-md-auto me-sm-3" type="button">{{ l('جستجو') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-primary mb-5">
        <div class="container py-5">
            <div class="d-flex flex-column flex-lg-row gap-4 justify-content-between align-items-center">
                <h2 class="mb-0 text-white mt-4 mt-md-0">{{ l('با معرفی دوستانتان به سایت ما، درآمد کسب کنید') }}</h2>
                <div class="d-flex align-items-center gap-4">
                    <div class="text-white d-flex gap-2">
                        <a href="" class="btn btn-light fw-bold ">{{ l('کسب درآمد') }}</a>
                        <a href="" class="btn btn-light fw-bold ">{{ l('شماره تماس') }}</a>

                    </div>
                    <a href="#" class="text-decoration-none">
                        <i class="fi-phone text-white fs-3 mobile-icon"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="container pt-3 mb-5">
        <div>
            <h2 class="fs-5 mb-4 d-none">{{ l('دسترسی های سریع') }}</h2>
            <div>
                <!-- Responsive with multiple items + Controls and nav outside -->
                <div class="tns-carousel-wrapper  tns-nav-outside">
                    <div class="tns-carousel-inner" data-carousel-options="{&quot;nav&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1, &quot;gutter&quot;: 16},&quot;420&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 16},&quot;700&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20},&quot;850&quot;:{&quot;items&quot;:4, &quot;gutter&quot;: 20},&quot;1300&quot;:{&quot;nav&quot;: false, &quot;items&quot;:5, &quot;gutter&quot;: 24}}}">
                        <div class="">
                            <div class="position-relative">
                                <div class="rounded-3 mb-3 position-relative">
                                    <span class="img-gradient-overlay rounded-3"></span>
                                    <img class="d-block mx-auto rounded-3 w-100 h-100" src="/img/site2/card/cottageForest.jpg" alt="New York">
                                    <div class="start-0 bottom-0 text-center end-0 mb-3 zindex-1" style="position: absolute;">
                                        <a class="nav-link stretched-link p-0 text-white fw-bold" href="job-board-catalog.html">{{ l('جنگلی') }}</a>
                                        <span class="fs-sm text-white fw-bold opacity-60 fs-xs">{{ l('15 اقامتگاه') }}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="">
                            <div class="position-relative">
                                <div class="rounded-3 mb-3 position-relative">
                                    <span class="img-gradient-overlay rounded-3"></span>
                                    <img class="d-block mx-auto rounded-3 w-100 h-100" src="/img/site2/card/waterfront.jpg" alt="New York">
                                    <div class="start-0 bottom-0 text-center end-0 mb-3 zindex-1" style="position: absolute;">
                                        <a class="nav-link stretched-link p-0 text-white fw-bold" href="job-board-catalog.html">{{ l('ساحلی') }}</a>
                                        <span class="fs-sm text-white fw-bold opacity-60 fs-xs">{{ l('113 اقامتگاه') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="">
                            <div class="position-relative">
                                <div class="rounded-3 mb-3 position-relative">
                                    <span class="img-gradient-overlay rounded-3"></span>
                                    <img class="d-block mx-auto rounded-3 w-100 h-100" src="/img/site2/card/jacuzzi.jpg" alt="New York">
                                    <div class="start-0 bottom-0 text-center end-0 mb-3 zindex-1" style="position: absolute;">
                                        <a class="nav-link stretched-link p-0 text-white fw-bold" href="job-board-catalog.html">{{ l('ویلا استخردار') }}</a>
                                        <span class="fs-sm text-white fw-bold opacity-60 fs-xs">{{ l('17 اقامتگاه') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="">
                            <div class="position-relative">
                                <div class="rounded-3 mb-3 position-relative">
                                    <span class="img-gradient-overlay rounded-3"></span>
                                    <img class="d-block mx-auto rounded-3 w-100 h-100" src="/img/site2/card/ruralhome.jpg" alt="New York">
                                    <div class="start-0 bottom-0 text-center end-0 mb-3 zindex-1" style="position: absolute;">
                                        <a class="nav-link stretched-link p-0 text-white fw-bold" href="job-board-catalog.html">{{ l('جشن و تولد') }}</a>
                                        <span class="fs-sm text-white fw-bold opacity-60 fs-xs">{{ l('17 اقامتگاه') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="">
                            <div class="position-relative">
                                <div class="rounded-3 mb-3 position-relative">
                                    <span class="img-gradient-overlay rounded-3"></span>
                                    <img class="d-block mx-auto rounded-3 w-100 h-100" src="/img/site2/card/mountain.jpg" alt="New York">
                                    <div class="start-0 bottom-0 text-center end-0 mb-3 zindex-1" style="position: absolute;">
                                        <a class="nav-link stretched-link p-0 text-white fw-bold" href="job-board-catalog.html">{{ l('آرامش و طبیعت') }}</a>
                                        <span class="fs-sm text-white fw-bold opacity-60 fs-xs">{{ l('17 اقامتگاه') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="container mb-5">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
            <h2 class="h4 mb-sm-0 font-vazir">{{ l('ویلاهای اکازیون') }}</h2><a class="btn btn-link fw-normal ms-sm-3 p-0" href="city-guide-catalog.html">{{ l('مشاهده همه') }}<i class="fi-arrow-long-left ms-2"></i></a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside">
            <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 3, &quot;gutter&quot;: 24, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1400&quot;:{&quot;items&quot;:3,&quot;nav&quot;:false}}}">
                <!-- Item-->
                <div>
                    <div class="position-relative">
                        <div class="position-relative mb-3">
                            <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ l('نشان کردن') }}"><i class="fi-heart"></i></button><img class="rounded-3" src="/img/site2/catalog/01.jpg" alt="Image">
                        </div>
                        <h3 class="mb-2 fs-lg"><a class="nav-link stretched-link" href="site2-single.html">{{ l('هتل تجاری گیلان') }}</a></h3>
                        <ul class="list-inline mb-0 fs-sm">
                            <li class="list-inline-item ps-1"><i class="fi-star-filled mt-n1 ms-1 fs-base text-warning align-middle"></i><b>5.0</b><span class="text-muted">&nbsp;(48)</span></li>
                            <li class="list-inline-item ps-1"><i class="fi-credit-card mt-n1 ms-1 fs-base text-muted align-middle"></i>{{ l('150000 تومان') }}</li>
                            <li class="list-inline-item ps-1"><i class="fi-map-pin mt-n1 ms-1 fs-base text-muted align-middle"></i>{{ l('1.4 کیلومتر از فرودگاه') }}</li>
                        </ul>
                    </div>
                </div>
                <!-- Item-->
                <div>
                    <div class="position-relative">
                        <div class="position-relative mb-3">
                            <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ l('نشان کردن') }}"><i class="fi-heart"></i></button><img class="rounded-3" src="/img/site2/catalog/02.jpg" alt="Image">
                        </div>
                        <h3 class="mb-2 fs-lg"><a class="nav-link stretched-link" href="site2-single.html">{{ l('کلبه درختی بزرگ') }}</a></h3>
                        <ul class="list-inline mb-0 fs-sm">
                            <li class="list-inline-item ps-1"><i class="fi-star-filled mt-n1 ms-1 fs-base text-warning align-middle"></i><b>4.8</b><span class="text-muted">&nbsp;(24)</span></li>
                            <li class="list-inline-item ps-1"><i class="fi-credit-card mt-n1 ms-1 fs-base text-muted align-middle"></i>{{ l('1850000 تومان') }}</li>
                            <li class="list-inline-item ps-1"><i class="fi-map-pin mt-n1 ms-1 fs-base text-muted align-middle"></i>{{ l('0.5 کیلومتر از مرکز شهر') }}</li>
                        </ul>
                    </div>
                </div>
                <!-- Item-->
                <div>
                    <div class="position-relative">
                        <div class="position-relative mb-3">
                            <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ l('نشان کردن') }}"><i class="fi-heart"></i></button><img class="rounded-3" src="/img/site2/catalog/03.jpg" alt="Image">
                        </div>
                        <h3 class="mb-2 fs-lg"><a class="nav-link stretched-link" href="site2-single.html">{{ l('باغ ویلای شب بهشت') }}</a></h3>
                        <ul class="list-inline mb-0 fs-sm">
                            <li class="list-inline-item ps-1"><i class="fi-star-filled mt-n1 ms-1 fs-base text-warning align-middle"></i><b>4.9</b><span class="text-muted">&nbsp;(43)</span></li>
                            <li class="list-inline-item ps-1"><i class="fi-credit-card mt-n1 ms-1 fs-base text-muted align-middle"></i>{{ l('750000 تومان') }}</li>
                            <li class="list-inline-item ps-1"><i class="fi-map-pin mt-n1 ms-1 fs-base text-muted align-middle"></i>{{ l('1.8 کیلومتر از فرودگاه') }}</li>
                        </ul>
                    </div>
                </div>
                <!-- Item-->
                <div>
                    <div class="position-relative">
                        <div class="position-relative mb-3">
                            <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ l('نشان کردن') }}"><i class="fi-heart"></i></button><img class="rounded-3" src="/img/site2/catalog/04.jpg" alt="Image">
                        </div>
                        <h3 class="mb-2 fs-lg"><a class="nav-link stretched-link" href="site2-single.html">{{ l('اقامتگاه آلند ویلا') }}</a></h3>
                        <ul class="list-inline mb-0 fs-sm">
                            <li class="list-inline-item ps-1"><i class="fi-star-filled mt-n1 ms-1 fs-base text-warning align-middle"></i><b>4.5</b><span class="text-muted">&nbsp;(13)</span></li>
                            <li class="list-inline-item ps-1"><i class="fi-credit-card mt-n1 ms-1 fs-base text-muted align-middle"></i>{{ l('852000 تومان') }}</li>
                            <li class="list-inline-item ps-1"><i class="fi-map-pin mt-n1 ms-1 fs-base text-muted align-middle"></i>{{ l('0.4 کیلومتر از فرودگاه') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5 pt-2 pt-lg-4">
        <h2 class="fs-5 mb-4">{{ l('چرا از گیلند ملک ویلا اجاره کنیم؟') }}</h2>
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4 justify-content-center">
            <!-- Feature item-->
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-accent text-accent rounded-circle mb-3">
                                <i class="fi-bed"></i>
                            </div>
                            <h3 class="h5 card-title">{{ l('سفری ایمن') }}</h3>
                        </div>
                        <p class="card-text fs-sm">{{ l('با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد.') }}</p>
                    </div>
                </div>
            </div>
            <!-- Feature item-->
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-warning text-warning rounded-circle mb-3"><i class="fi-cash"></i></div>
                            <h3 class="h5 card-title">{{ l('قیمت منصفانه') }}</h3>
                        </div>
                        <p class="card-text fs-sm">{{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.') }}</p>
                    </div>
                </div>
            </div>
            <!-- Feature item-->
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3"><i class="fi-heart"></i></div>
                            <h3 class="h5 card-title">{{ l('آسایش خاطر') }}</h3>
                        </div>
                        <p class="card-text fs-sm">{{ l('با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد.') }}</p>
                    </div>
                </div>
            </div>
            <!-- Feature item-->
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-success text-success rounded-circle mb-3"><i class="fi-users"></i></div>
                            <h3 class="h5 card-title">{{ l('تیم با تجربه') }}</h3>
                        </div>
                        <p class="card-text fs-sm">{{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.') }}</p>
                    </div>
                </div>
            </div>
            <!-- Feature item-->
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3"><i class="fi-briefcase"></i></div>
                            <h3 class="h5 card-title">{{ l('عملکرد بالا') }}</h3>
                        </div>
                        <p class="card-text fs-sm">{{ l('با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد.') }}</p>
                    </div>
                </div>
            </div>
            <!-- Feature item-->
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-success text-success rounded-circle mb-3"><i class="fi-chat-left"></i></div>
                            <h3 class="h5 card-title">{{ l('ارتباط قوی') }}</h3>
                        </div>
                        <p class="card-text fs-sm">{{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.') }}</p>
                    </div>
                </div>
            </div>
            <!-- Feature item-->
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-info text-info rounded-circle mb-3"><i class="fi-like"></i></div>
                            <h3 class="h5 card-title">{{ l('بهترین تورها') }}</h3>
                        </div>
                        <p class="card-text fs-sm">{{ l('با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد.') }}</p>
                    </div>
                </div>
            </div>
            <!-- Feature item-->
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-warning text-warning rounded-circle mb-3"><i class="fi-checkbox-checked-alt"></i></div>
                            <h3 class="h5 card-title">{{ l('ارائه راه حل ساده') }}</h3>
                        </div>
                        <p class="card-text fs-sm">{{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container my-5 py-lg-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
            <h2 class="h4 mb-sm-0 font-vazir">{{ l('جاذبه های دیدنی بهشت ایران استان گیلان') }}</h2><a class="btn btn-link fw-normal ms-sm-3 p-0" href="city-guide-blog.html">{{ l('لیست مقالات') }}<i class="fi-arrow-long-left ms-2"></i></a>
        </div>
        <!-- Carousel-->
        <div class="tns-carousel-wrapper tns-nav-outside mb-md-2">
            <div class="tns-carousel-inner d-block" data-carousel-options="{&quot;controls&quot;: false, &quot;gutter&quot;: 24, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:3}}}">
                <!-- Item-->
                <article>

                    <a class="d-block mb-3 " href="city-guide-blog-single.html">
                        <img class="rounded-3" src="/img/site2/blog/01.jpg" alt="Post image">
                    </a>

                    <a class="text-uppercase text-decoration-none fs-xs" href="#">{{ l('گردشگری') }}</a>
                    <h3 class="fs-lg pt-1 mb-2">
                        <a class="nav-link" href="city-guide-blog-single.html">{{ l('سفر هوایی در زمان کووید-19') }}</a>
                    </h3>


                    <a class="d-flex align-items-center text-decoration-none" href="#"><img class="rounded-circle" src="/img/site2/avatars/16.png" width="44" alt="Avatar">
                        <div class="pe-2">
                            <h6 class="fs-sm text-nav lh-base mb-1">{{ l('زهرا سعیدی') }}</h6>
                            <div class="d-flex text-body fs-xs">
                                <span class="me-2 pe-1">
                                    <i class="fi-calendar-alt opacity-70 mt-n1 ms-1 align-middle"></i>{{ l('24 اردیبهشت') }}
                                </span>
                                <span>
                                    <i class="fi-chat-circle opacity-70 mt-n1 ms-1 align-middle"></i>{{ l('0 نظر') }}
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
                <article>

                    <a class="d-block mb-3 " href="city-guide-blog-single.html">
                        <img class="rounded-3" src="/img/site2/blog/02.jpg" alt="Post image">
                    </a>

                    <a class="text-uppercase text-decoration-none fs-xs" href="#">{{ l('تفریحی و سرگرمی') }}</a>
                    <h3 class="fs-lg pt-1 mb-2">
                        <a class="nav-link" href="city-guide-blog-single.html">{{ l('10 موزه دیدنی بر شهر رشت') }}</a>
                    </h3>


                    <a class="d-flex align-items-center text-decoration-none" href="#"><img class="rounded-circle" src="/img/site2/avatars/17.png" width="44" alt="Avatar">
                        <div class="pe-2">
                            <h6 class="fs-sm text-nav lh-base mb-1">{{ l('علی بندری') }}</h6>
                            <div class="d-flex text-body fs-xs">
                                <span class="me-2 pe-1">
                                    <i class="fi-calendar-alt opacity-70 mt-n1 ms-1 align-middle"></i>{{ l('24 اردیبهشت') }}
                                </span>
                                <span>
                                    <i class="fi-chat-circle opacity-70 mt-n1 ms-1 align-middle"></i>{{ l('0 نظر') }}
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
                <article>

                    <a class="d-block mb-3 " href="city-guide-blog-single.html">
                        <img class="rounded-3" src="/img/site2/blog/03.jpg" alt="Post image">
                    </a>

                    <a class="text-uppercase text-decoration-none fs-xs" href="#">{{ l('گردشگری') }}</a>
                    <h3 class="fs-lg pt-1 mb-2">
                        <a class="nav-link" href="city-guide-blog-single.html">{{ l('7 نکته برای مسافران انفرادی در کویر ایران') }}
                        </a>
                    </h3>


                    <a class="d-flex align-items-center text-decoration-none" href="#"><img class="rounded-circle" src="/img/site2/avatars/18.png" width="44" alt="Avatar">
                        <div class="pe-2">
                            <h6 class="fs-sm text-nav lh-base mb-1">{{ l('مهناز مشایخی') }}</h6>
                            <div class="d-flex text-body fs-xs">
                                <span class="me-2 pe-1">
                                    <i class="fi-calendar-alt opacity-70 mt-n1 ms-1 align-middle"></i>{{ l('24 اردیبهشت') }}
                                </span>
                                <span>
                                    <i class="fi-chat-circle opacity-70 mt-n1 ms-1 align-middle"></i>{{ l('0 نظر') }}
                                </span>
                            </div>
                        </div>
                    </a>
                </article>

            </div>
        </div>
    </section>

    <section class="container mb-5 pb-lg-5">
        <div class="py-md-4 py-5 bg-secondary rounded-3">
            <div class="col-sm-10 col-11 d-flex flex-md-row flex-column align-items-center justify-content-between mx-auto px-0">
                <div class="order-md-1 order-2 text-md-start text-center" style="max-width: 524px;">
                    <h2 class="mb-4 pb-md-3 ">{{ l('پاسخ سوال خود را هنوز پیدا نکرده اید؟') }}<br>{{ l('ما میتوانیم به شما کمک کنیم.') }}</h2><a class="btn btn-lg btn-primary rounded-pill w-sm-auto w-100" href="city-guide-contacts.html">{{ l('تماس با ما') }}</a>
                </div>
                <img class="order-md-2 order-1 ms-md-4 rotate-img" src="/img/site2/support.svg" alt="Illustration">
            </div>
        </div>
    </section>

    @include(ss('THEME') . '.frontend.layouts.footer_rent', ['cssClass' => 'intro'])
</main>
@endsection

@section('js')
@endsection
