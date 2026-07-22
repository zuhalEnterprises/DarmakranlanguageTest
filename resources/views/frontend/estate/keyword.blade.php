@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => 'ddddd'
])
@section('head')
<link rel="stylesheet" media="screen" href="/vendor/expandable/jquery.expandable.css" />

<style>
    .cover-keyword {
        height: 170px;
        background: url("/img/site3/banner-estate.jpg");
        background-repeat: round;
        width: 100%;
    }

    #lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #3b3939c7;
        text-align: center;
        z-index: 10000;
        padding: 0 15px;
    }

    #lightbox p {
        text-align: right;
        color: #fff;
        /* margin-right: 20px; */
        margin-top: 111px;
        font-size: 12px;
    }

    #lightbox img {
        box-shadow: 0 0 25px #111;
        max-width: 940px;
    }

    #content img{
        width: 100%;
        border-radius: 10px;
    }

    @media (min-height:780px) {
        .cover-keyword {
            height: 350px;
        }

        #content img{
            width: auto;

        }
    }
</style>
@endsection
@section('main_content')
<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')
    <section class="container mt-5 pt-5 ">
        <!-- Breadcrumb-->
        <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
                <li class="breadcrumb-item"><a href="/c/{{ $selectedCity }}"> {{ l('ملک') }}</a></li>
            </ol>
        </nav>

    </section>
    <section class="container">
        <div class="w-100 overflow-hidden cover-keyword mb-5">
        </div>
        <div>
            <h1 class="my-5 text-center">{{ l('آپارتمان 220 متری قیطریه') }}</h1>
            <div class="my-4 text-center">
                <img src="https://roag.ir/wp-content/uploads/2021/11/M-R_7.jpg" alt="pic" style="width: 740px;">
            </div>
            <p class="text-justify paragraf">
                {{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.') }}
            </p>
        </div>
        <div class=" my-5 row g-3">
            <a class="col-6 col-lg-2 lightbox_trigger" href="/img/site3/estate11.jpg"><img class="rounded-3" src="/img/site3/estate11.jpg" alt="pic" title="" /></a>
            <a class="col-6 col-lg-2 lightbox_trigger" href="/img/site3/estate12.jpg"><img class="rounded-3" src="/img/site3/estate12.jpg" alt="pic" title="" /></a>
            <a class="col-6 col-lg-2 lightbox_trigger" href="/img/site3/estate11.jpg"><img class="rounded-3" src="/img/site3/estate11.jpg" alt="pic" title="" /></a>
            <a class="col-6 col-lg-2 lightbox_trigger" href="/img/site3/estate12.jpg"><img class="rounded-3" src="/img/site3/estate12.jpg" alt="pic" title="" /></a>
            <a class="col-6 col-lg-2 lightbox_trigger" href="/img/site3/estate11.jpg"><img class="rounded-3" src="/img/site3/estate11.jpg" alt="pic" title="" /></a>
            <a class="col-6 col-lg-2 lightbox_trigger" href="/img/site3/estate12.jpg"><img class="rounded-3" src="/img/site3/estate12.jpg" alt="pic" title="" /></a>
            <a class="col-6 col-lg-2 lightbox_trigger" href="/img/site3/estate11.jpg"><img class="rounded-3" src="/img/site3/estate11.jpg" alt="pic" title="" /></a>
            <a class="col-6 col-lg-2 lightbox_trigger" href="/img/site3/estate12.jpg"><img class="rounded-3" src="/img/site3/estate12.jpg" alt="pic" title="" /></a>
        </div>
    </section>
    <section class="container my-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0 ">{{ l('املاک متناسب') }}</h2>
            <a class="btn btn-link fw-normal p-0" href="#">
                {{ l('مشاهده همه') }} <i class="fi-arrow-long-left ms-2"></i>
            </a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2" dir="ltr">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                <div class="col">
                    <div class="card shadow-sm rounded card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="link-img p-0" href="/v/9101" target="_blank" style="padding:0;"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">{{ l('3 ماه پیش') }}</span>
                                <span class="d-table badge bg-primary">{{ l('آپارتمان') }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">

                            </div>
                            <img src="https://koomeh.ir/upload/images/estate/2023/05/img_646e0f431e8e2_medium.jpg" style="height: 200px;width:100%;object-fit:cover" data-src="https://koomeh.ir/upload/images/estate/2023/05/img_646e0f431e8e2_medium.jpg" alt="{{ l('103 متری مجتمع فردوس') }}">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a target="_blank" class="nav-link stretched-link" href="/v/9101">
                                    {{ l('103 متری مجتمع فردوس') }}</a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۴,۲۰۰,۰۰۰,۰۰۰ ت') }}
                                </div>
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۴۰,۷۷۶,۰۰۰ متری') }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ l('103 متر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>

                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{ l('ساخت: 1402') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm rounded card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="link-img p-0" href="/v/9101" target="_blank" style="padding:0;"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">{{ l('3 ماه پیش') }}</span>
                                <span class="d-table badge bg-primary">{{ l('آپارتمان') }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">

                            </div>
                            <img src="https://koomeh.ir/upload/images/estate/2023/05/img_646e0f431e8e2_medium.jpg" style="height: 200px;width:100%;object-fit:cover" data-src="https://koomeh.ir/upload/images/estate/2023/05/img_646e0f431e8e2_medium.jpg" alt="{{ l('103 متری مجتمع فردوس') }}">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a target="_blank" class="nav-link stretched-link" href="/v/9101">
                                    {{ l('103 متری مجتمع فردوس') }}</a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۴,۲۰۰,۰۰۰,۰۰۰ ت') }}
                                </div>
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۴۰,۷۷۶,۰۰۰ متری') }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ l('103 متر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>

                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{ l('ساخت: 1402') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm rounded card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="link-img p-0" href="/v/9101" target="_blank" style="padding:0;"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">{{ l('3 ماه پیش') }}</span>
                                <span class="d-table badge bg-primary">{{ l('آپارتمان') }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">

                            </div>
                            <img src="https://koomeh.ir/upload/images/estate/2023/05/img_646e0f431e8e2_medium.jpg" style="height: 200px;width:100%;object-fit:cover" data-src="https://koomeh.ir/upload/images/estate/2023/05/img_646e0f431e8e2_medium.jpg" alt="{{ l('103 متری مجتمع فردوس') }}">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a target="_blank" class="nav-link stretched-link" href="/v/9101">
                                    {{ l('103 متری مجتمع فردوس') }}</a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۴,۲۰۰,۰۰۰,۰۰۰ ت') }}
                                </div>
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۴۰,۷۷۶,۰۰۰ متری') }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ l('103 متر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>

                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{ l('ساخت: 1402') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm rounded card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="link-img p-0" href="/v/9101" target="_blank" style="padding:0;"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">{{ l('3 ماه پیش') }}</span>
                                <span class="d-table badge bg-primary">{{ l('آپارتمان') }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">

                            </div>
                            <img src="https://koomeh.ir/upload/images/estate/2023/05/img_646e0f431e8e2_medium.jpg" style="height: 200px;width:100%;object-fit:cover" data-src="https://koomeh.ir/upload/images/estate/2023/05/img_646e0f431e8e2_medium.jpg" alt="{{ l('103 متری مجتمع فردوس') }}">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a target="_blank" class="nav-link stretched-link" href="/v/9101">
                                    {{ l('103 متری مجتمع فردوس') }}</a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۴,۲۰۰,۰۰۰,۰۰۰ ت') }}
                                </div>
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۴۰,۷۷۶,۰۰۰ متری') }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ l('103 متر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>

                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{ l('ساخت: 1402') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm rounded card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="link-img p-0" href="/v/9101" target="_blank" style="padding:0;"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">{{ l('3 ماه پیش') }}</span>
                                <span class="d-table badge bg-primary">{{ l('آپارتمان') }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">

                            </div>
                            <img src="https://koomeh.ir/upload/images/estate/2023/05/img_646e0f431e8e2_medium.jpg" style="height: 200px;width:100%;object-fit:cover" data-src="https://koomeh.ir/upload/images/estate/2023/05/img_646e0f431e8e2_medium.jpg" alt="{{ l('103 متری مجتمع فردوس') }}">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a target="_blank" class="nav-link stretched-link" href="/v/9101">
                                    {{ l('103 متری مجتمع فردوس') }}</a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۴,۲۰۰,۰۰۰,۰۰۰ ت') }}
                                </div>
                                <div>
                                    <i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۴۰,۷۷۶,۰۰۰ متری') }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                    {{ l('103 متر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>

                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{ l('ساخت: 1402') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container pb-lg-5 pb-4 mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0">{{ l('مقالات مرتبط') }}</h2>
            <a class="btn btn-link fw-normal p-0" href="/blog">
                {{ l('مقالات بیشتر') }} <i class="fi-arrow-long-left ms-2"></i>
            </a>
        </div>
        <div class="row g-4">
            <!-- Post-->
            <div class="col-lg-6">
                <article class="card border-0 shadow-sm card-hover card-horizontal mb-4 h-100">
                    <a class="card-img-top" href="/blog/show/12" style="background-image: url(https://gilandmelk.com/upload/images/blog/img_dPkx3TieiYcHiHlb.jpg);"></a>
                    <div class="card-body d-flex flex-column">
                        <h3 class="fs-base pt-1 mb-2">
                            <a class="nav-link" href="/blog/show/12">
                                {{ l('سفر به تالش، بهشت رویایی، جاذبه ها و تفریحات &nbsp;+ عکس های دیدنی') }}
                            </a>
                        </h3>
                        <p class="fs-sm text-muted">
                            {{ l('برای سفر به&nbsp; تالش هر زمانی که اراده کنید و حرکت کنید خوب است زیرا هر فصلی از آن طبیعت زیبا و منحصر به فرد خود را دارد اما اگر هدف از سفر به تالش دیدن ییلاقات مشهور سوباتان است بهتر است در تابستان و بهار به این شهر رویایی سفر کنید.') }}
                        </p>
                        <a class="d-flex align-items-center text-decoration-none mt-auto" href="#">
                            <div class="pe-2">
                                <div class="d-flex text-body fs-xs">
                                    <span class="me-2 pe-1">
                                        <i class="fi-calendar-alt opacity-70 ms-1"></i>
                                        {{ l('3 هفته پیش') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
            </div>
            <div class="col-lg-6">
                <article class="card border-0 shadow-sm card-hover card-horizontal mb-4 h-100">
                    <a class="card-img-top" href="/blog/show/11" style="background-image: url(https://gilandmelk.com/upload/images/blog/img_dPkx3TieiYcHiHlb.jpg);"></a>
                    <div class="card-body d-flex flex-column">
                        <h3 class="fs-base pt-1 mb-2">
                            <a class="nav-link" href="/blog/show/11">
                                {{ l('معرفی رضوانشهر گیلان+سرمایه گذاری پرسود') }}
                            </a>
                        </h3>
                        <p class="fs-sm text-muted">
                            {{ l('رضوانشهر که در امتداد خط ساحلی خیره کننده استان گیلان در شمال ایران قرار دارد، گوهر پنهانی است که منتظر کشف است.') }}
                        </p>
                        <a class="d-flex align-items-center text-decoration-none mt-auto" href="#">
                            <div class="pe-2">
                                <div class="d-flex text-body fs-xs">
                                    <span class="me-2 pe-1">
                                        <i class="fi-calendar-alt opacity-70 ms-1"></i>
                                        {{ l('3 هفته پیش') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
            </div>
            <div class="col-lg-6">
                <article class="card border-0 shadow-sm card-hover card-horizontal mb-4 h-100">
                    <a class="card-img-top" href="/blog/show/10" style="background-image: url(https://gilandmelk.com/upload/images/blog/img_dPkx3TieiYcHiHlb.jpg);"></a>
                    <div class="card-body d-flex flex-column">
                        <h3 class="fs-base pt-1 mb-2">
                            <a class="nav-link" href="/blog/show/10">
                                {{ l('شهر آرامش ، شهر ماسال') }}
                            </a>
                        </h3>
                        <p class="fs-sm text-muted">
                            {{ l('استان گیلان جاذبه‌های گردشگری و مناطق سرسبز و خوش‌آب‌وهوای زیادی دارد که هر کدام از آن‌ها می‌توانند تجربه بی‌نظیری را برایتان رقم بزنند؛ اما باز هم ماسال با همه آن‌ها فرق دارد.') }}
                        </p>
                        <a class="d-flex align-items-center text-decoration-none mt-auto" href="#">
                            <div class="pe-2">
                                <div class="d-flex text-body fs-xs">
                                    <span class="me-2 pe-1">
                                        <i class="fi-calendar-alt opacity-70 ms-1"></i>
                                        {{ l('1 ماه پیش') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
            </div>
            <div class="col-lg-6">
                <article class="card border-0 shadow-sm card-hover card-horizontal mb-4 h-100">
                    <a class="card-img-top" href="/blog/show/9" style="background-image: url(https://gilandmelk.com/upload/images/blog/img_dPkx3TieiYcHiHlb.jpg);"></a>
                    <div class="card-body d-flex flex-column">
                        <h3 class="fs-base pt-1 mb-2">
                            <a class="nav-link" href="/blog/show/9">
                                {{ l('بهترین سرمایه گذاری در سال 1402') }}
                            </a>
                        </h3>
                        <p class="fs-sm text-muted">
                            {{ l('قطعا برای شما هم پیش آمده که می خواهید سرمایه گذاری خوب و پرسودی داشته باشید اما در بازار دلار و طلا و بورس در ایران نه تنها سودی نکردید بلکه متضرر هم شده اید ما در این محتوا تلاش کرده ایم که یکی از بهترین بازارهای پرسود و کم ریسک برای سرمایه گذاری را به شما معرفی کنیم پس با ما همراه باشید.') }}
                        </p>
                        <a class="d-flex align-items-center text-decoration-none mt-auto" href="#">
                            <div class="pe-2">
                                <div class="d-flex text-body fs-xs">
                                    <span class="me-2 pe-1">
                                        <i class="fi-calendar-alt opacity-70 ms-1"></i>
                                        {{ l('1 ماه پیش') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="container pb-md-4">
        <h2 class="h3 mb-3">{{ l('پرسش و پاسخ') }}</h2>

        <div class="expandable expanded" style="overflow: hidden; position: relative; height: auto;">
            <div class="accordion qaa to-expand expandable-init" id="accordionExample" style="padding-top: 1px;">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            {{ l('تولید کننده لورم ایپسوم') }}
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            {{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            {{ l('تولید کننده لورم ایپسوم') }}
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            {{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.') }}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            {{ l('تولید کننده لورم ایپسوم') }}
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            {{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.') }}
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="container my-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0 ">{{ l('کارشناسان محل') }}</h2>

        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2" dir="ltr">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                <div class="col">
                    <div class="card border-0 shadow-sm mt-md-4">
                        <img class="card-img-top" src="https://koomeh.ir/upload/images/profile/64dc76afa5b9b.png" alt="{{ l('محمد رمضانیان') }}" style="object-fit:cover;width:325px; height:325px;">

                        <div class="card-body text-center">

                            <h3 class="h5 card-title mb-2"><a class="btn " href="/agents/17593">{{ l('محمد رمضانیان') }}</a></h3>

                            <span class="d-inline-block mb-3 fs-sm">
                                {{ l('کارشناس فروش') }}
                            </span>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0 shadow-sm mt-md-4">

                        <img class="card-img-top" src="https://koomeh.ir/upload/images/profile/6489eff1dbf4f.png" alt="{{ l('حمیدرضا خالقی نژاد') }}" style="object-fit:cover;width:325px; height:325px;">

                        <div class="card-body text-center">

                            <h3 class="h5 card-title mb-2"><a class="btn " href="/agents/17592">{{ l('حمیدرضا خالقی نژاد') }}</a></h3>

                            <span class="d-inline-block mb-3 fs-sm">
                                {{ l('کارشناس فروش') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0 shadow-sm mt-md-4">

                        <img class="card-img-top" src="https://koomeh.ir/upload/images/profile/64d1dba621859.png" alt="{{ l('صادق توانا') }}" style="object-fit:cover;width:325px; height:325px;">

                        <div class="card-body text-center">

                            <h3 class="h5 card-title mb-2"><a class="btn " href="/agents/17589">{{ l('صادق توانا') }}</a></h3>

                            <span class="d-inline-block mb-3 fs-sm">
                                {{ l('کارشناس فروش') }}
                            </span>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0 shadow-sm mt-md-4">

                        <img class="card-img-top" src="https://koomeh.ir/upload/images/profile/64d2693ae591c.png" alt="{{ l('محسن زمانی') }}" style="object-fit:cover;width:325px; height:325px;">

                        <div class="card-body text-center">

                            <h3 class="h5 card-title mb-2"><a class="btn " href="/agents/17586">{{ l('محسن زمانی') }}</a></h3>

                            <span class="d-inline-block mb-3 fs-sm">
                                {{ l('کارشناس فروش') }}
                            </span>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0 shadow-sm mt-md-4">

                        <img class="card-img-top" src="https://koomeh.ir/upload/images/profile/64d2619b931d3.png" alt="{{ l('رضا احمدپور') }}" style="object-fit:cover;width:325px; height:325px;">

                        <div class="card-body text-center">

                            <h3 class="h5 card-title mb-2"><a class="btn " href="/agents/17598">{{ l('رضا احمدپور') }}</a></h3>

                            <span class="d-inline-block mb-3 fs-sm">
                                {{ l('کارشناس فروش') }}
                            </span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container my-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0 ">{{ l('بنگاه های مرتبط') }}</h2>

        </div>
        <div class="tns-carousel-wrapper tns-nav-outside tns-nav-outside-flush mx-n2">
            <div class="tns-carousel-inner row gx-4 mx-0" data-carousel-options="{&quot;nav&quot;: false, &quot;autoHeight&quot;: true, &quot;controlsContainer&quot;: &quot;#carousel-controls-tp&quot;, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;1320&quot;:{&quot;items&quot;:2}}}">
                <div class="col">
                    <div class="row gy-md-0 gy-sm-4 gy-3 gx-sm-4 gx-0">
                        <div class="col-md-12">
                            <a target="_blank" class="text-decoration-none text-light card bg-size-cover bg-position-center border-0 overflow-hidden h-100" href="/branch/19" style="background-image: url(https://koomeh.ir/upload/images/branch/img_D7Cbrf79ityJgXkP.jpg); min-height: 18.75rem;">
                                <span class="img-gradient-overlay"></span>
                                <div class="card-body content-overlay pb-0"></div>
                                <div class="card-footer content-overlay border-0 pt-0 pb-4" style="transform: translateY(0%);">
                                    <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5">
                                        <div class="pe-2">
                                            <h3 class="h5 text-light mb-1">{{ l('شعبه جمهوری') }}</h3>
                                            <div class="fs-sm opacity-70">
                                                <i class="fi-map-pin ms-1"></i>{{ l('قم، بلوار جمهوری، نبش خیابان قیام') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="row gy-md-0 gy-sm-4 gy-3 gx-sm-4 gx-0">
                        <div class="col-md-12">
                            <a target="_blank" class="text-decoration-none text-light card bg-size-cover bg-position-center border-0 overflow-hidden h-100" href="/branch/18" style="background-image: url(https://koomeh.ir/upload/images/branch/img_8til94thg7VtrMWd.jpg); min-height: 18.75rem;">
                                <span class="img-gradient-overlay"></span>
                                <div class="card-body content-overlay pb-0"></div>
                                <div class="card-footer content-overlay border-0 pt-0 pb-4" style="transform: translateY(0%);">
                                    <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5">
                                        <div class="pe-2">
                                            <h3 class="h5 text-light mb-1">{{ l('شعبه پردیسان') }}</h3>
                                            <div class="fs-sm opacity-70">
                                                <i class="fi-map-pin ms-1"></i>{{ l('قم، پردیسان، بلوار سلمان، روبروی مسجد حضرت فاطمه‌الزهرا، هویزه2') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container ">
        <div class="d-flex align-items-center  py-md-4 py-3">
            <div class="expandable expanded" style="overflow: hidden; position: relative; height: auto;">
                <div class="d-flex flex-wrap tags to-expand expandable-init" style="padding-top: 1px;">
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">{{ l('خرید ملک در گیلان') }}</span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('خرید ملک در گیلان دیوار') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('خرید زمین در گیلان') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('خرید خانه در گیلان دیوار') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('فروش ملک در گیلان') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('قیمت زمین در گیلان') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('خرید زمین در گیلان') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('خرید خانه در گیلان دیوار') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('فروش ملک در گیلان') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('قیمت زمین در گیلان') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('خرید زمین در گیلان') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('خرید خانه در گیلان دیوار') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('فروش ملک در گیلان') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('قیمت زمین در گیلان') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('خرید زمین در گیلان') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('خرید خانه در گیلان دیوار') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('فروش ملک در گیلان') }}
                    </span>
                    <span class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2">
                        {{ l('قیمت زمین در گیلان') }}
                    </span>
            </div>
        </div>
    </section>
</main>

@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
<!-- Review modal-->

@endsection
@section('js')
<script src="/vendor/expandable/jquery.expandable.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function() {

        $('.lightbox_trigger').click(function(e) {

            e.preventDefault();

            var image_href = $(this).attr("href");


            if ($('#lightbox').length > 0) {

                $('#content').html('<img src="' + image_href + '" />');

                $('#lightbox').show();
            } else {
                var lightbox =
                    '<div id="lightbox">' +
                    '<p><i class="fs-4 fi fi-x-circle"></i></p>' +
                    '<div id="content">' +
                    '<img  src="' + image_href + '" />' +
                    '</div>' +
                    '</div>'; //insert lightbox HTML into page $('body').append(lightbox); } }); $('body').on('click', '#lightbox', function() { $('#lightbox').hide(); }); $(document).keydown(function(e) { // ESCAPE key pressed if (e.keyCode == 27) { $('#lightbox').hide(); } }); $('.paragraf').expandable({ height: 100, more: l("نمایش بیشتر"), less: l("نمایش کمتر") }); });
</script>
@endsection
