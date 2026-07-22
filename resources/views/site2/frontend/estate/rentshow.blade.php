@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', ['title' => l('اجاره ویلا در گیلان')])
@section('head')

<link
  rel="stylesheet"
  href="/assets/vendors/fancybox/fancybox.css"
/>

<style>

</style>
@endsection

@section('main_content')
<main class="page-wrapper" style="background-color:#fff;">
    @include(ss('THEME') . '.frontend.layouts.header_rent')
    <!-- Gallery with thumbnails  -->
    <section class="container overflow-auto pb-3 mt-5" >
        <div class="row g-2 g-md-3  mt-md-5" >
            <div class="col-12 col-md-6" >
                <a class="gallery-item rounded rounded-md-3" href="/img/site2/single/01.jpg" data-fancybox="gallery" data-caption=l("عکس شماره 1")>
                    <img src="/img/site2/single/01.jpg" alt="Gallery thumbnail">
                </a>
            </div>
            <div class="col-12 col-md-6">
                <div class="row g-2 g-md-3">
                    <div class="col-6">
                        <a class="gallery-item rounded rounded-md-3" href="/img/site2/single/02.jpg" data-fancybox="gallery" data-caption=l("عکس شماره 2")>
                            <img src="/img/site2/single/02.jpg" alt="Gallery thumbnail">
                        </a>
                    </div>
                    <div class="col-6">
                        <a class="gallery-item rounded rounded-md-3" href="/img/site2/single/03.jpg" data-fancybox="gallery" data-caption=l("عکس شماره 3")>
                            <img src="/img/site2/single/03.jpg" alt="Gallery thumbnail">
                        </a>
                    </div>
                    <div class="col-6">
                        <a class="gallery-item rounded rounded-md-3" href="/img/site2/single/04.jpg" data-fancybox="gallery" data-caption=l("عکس شماره 4")>
                            <img src="/img/site2/single/th04.jpg" alt="Gallery thumbnail">
                        </a>
                    </div>
                    <div class="col-6">
                        <a class="gallery-item more-item rounded rounded-md-3" href="/img/site2/single/05.jpg" data-fancybox="gallery" data-caption=l("عکس شماره 5")>
                            <img src="/img/site2/single/th05.jpg" alt="Gallery thumbnail">
                            <span class="gallery-item-caption fs-base"><span class="d-none d-md-inline">{{ l('سایر تصاویر') }}</span> +5 </span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- ادامه عکس ها -->
            <div  style="display: none;" >
                <a class="gallery-item" href="/img/site2/single/06.jpg" data-fancybox="gallery" data-caption=l("عکس شماره 6")>
                    <img src="/img/site2/single/th06.jpg" alt="Image 6">
                </a>

                <a class="gallery-item" href="/img/site2/single/07.jpg" data-fancybox="gallery" data-caption=l("عکس شماره 7")>
                    <img src="/img/site2/single/th07.jpg" alt="Image 7">
                </a>
                <a class="gallery-item" href="/img/site2/single/08.jpg" data-fancybox="gallery" data-caption=l("عکس شماره 8")>
                    <img src="/img/site2/single/th08.jpg" alt="Image 8">
                </a>
            </div>
        </div>
    </section>

    <section class="container mb-5 pb-1">
        <div class="row">
            <div class="col-md-7 mb-md-0 mb-4">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
                        <li class="breadcrumb-item"><a href="/str">{{ l('ملک برای اجاره') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ l('اقامتگاه ویلایی') }}</li>
                    </ol>
                </nav>
                <!-- Title -->
                <div class="d-flex align-items-center justify-content-between ">
                    <div>
                        <h1 class="h4 mb-2 font-vazir">{{ l('اقامتگاه ویلایی | 200 متر مربع') }}</h1>
                        <p class="mb-2 pb-1 fs-md">{{ l('ایران، تهران، میدان آزادی') }}</p>
                    </div>
                    <div>
                        <img src="/img/site2/avatars/17.png" class="img-thumbnail rounded-circle" alt="Circle image" width="75">
                    </div>
                </div>
                <!-- Code -->
                <div class=" d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-primary">{{ l('کد: 53274') }}</span>
                    <span class="badge bg-secondary">{{ l('+5 رزرو موفق') }}</span>
                    <div class="d-flex align-items-center gap-2">
                        <div class="star-rating">
                            <i class="star-rating-icon fi-star-filled active"></i>
                            <i class="star-rating-icon fi-star-filled active"></i>
                            <i class="star-rating-icon fi-star-filled active"></i>
                            <i class="star-rating-icon fi-star-filled active"></i>
                            <i class="star-rating-icon fi-star-filled active"></i>
                        </div>
                        <div class="text-muted fs-xs mt-1">{{ l('5 (7نظر)') }}</div>
                    </div>
                </div>
                <!--Box Details -->
                <div class="bg-secondary p-3 rounded-2 mb-4">
                    <div class="row">
                        <div class="col-3">
                            <div class="text-center">
                                <i class="fs-2 fi-real-estate-house"></i>
                                <p class="fw-bold fs-xs mb-0">{{ l('نیمه دربست') }}</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center">
                                <i class="fs-2 fi-users"></i>
                                <p class="fw-bold fs-xs mb-0">{{ l('تا 15 مهمان') }}</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center">
                                <i class="fs-2 fi-single-bed"></i>
                                <p class="fw-bold fs-xs mb-0">{{ l('2 اتاق خواب') }}</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center ">
                                <i class="fs-2 fi-route"></i>
                                <p class="fw-bold fs-xs mb-0">{{ l('160 متر') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Overview-->
                <div class="mb-4  border-top border-bottom py-3">
                    <h3 class="h5 mb-3">{{ l('درباره اقامتگاه') }}</h3>
                    <p class="mb-1 line-h18">{{ l('طرح‌نما یا لورم ایپسوم به نوشتاری آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود. طراح گرافیک از این نوشتار به‌عنوان عنصری از ترکیب‌بندی برای پُر کردن صفحه و ارائهٔ اولیهٔ شکل ظاهری و کلیِ طرح سفارش‌گرفته‌شده‌استفاده می‌کند، تا ازنظر گرافیکی نشانگر چگونگی نوع و اندازهٔ قلم و ظاهرِ متن باشد.') }}</p>
                    <div class="collapse" id="seeMoreOverview">
                        <p class="mb-1">{{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.') }}</p>
                    </div><a class="collapse-label collapsed" href="#seeMoreOverview" data-bs-toggle="collapse" data-bs-label-collapsed=l("مشاهده بیشتر") data-bs-label-expanded=l("بستن") role="button" aria-expanded="false" aria-controls="seeMoreOverview"></a>
                </div>
                <!-- Property Details-->
                <div class="mb-4 pb-md-3  border-bottom pb-3">
                    <h3 class="h5 mb-3">{{ l('مشخصات') }}</h3>
                    <ul class="list-unstyled mb-0 row row-cols-lg-3 row-cols-md-2 row-cols-2">
                        <li class="col"><b>{{ l('نوع ملک:') }}</b>{{ l('آپارتمان') }}</li>
                        <li class="col"><b>{{ l('متراژ (مترمربع):') }}</b>{{ l('250 مترمربع') }}</li>
                        <li class="col"><b>{{ l('سال ساخت:') }}</b> 1388</li>
                        <li class="col"><b>{{ l('تعداد اتاق:') }}</b> 4</li>
                        <li class="col"><b>{{ l('سرویس بهداشتی:') }}</b> 2</li>
                        <li class="col"><b>{{ l('پارکینگ:') }}</b>{{ l('دارد') }}</li>
                        <li class="col"><b>{{ l('حیوانات خانگی مجاز:') }}</b>{{ l('فقط گربه') }}</li>
                    </ul>
                </div>
                <!-- Room -->
                <div class="mb-4 pb-md-3 border-bottom pb-3">
                    <h3 class="h5 mb-3">
                        {{ l('فضای خواب') }}
                        <span class="badge bg-faded-dark fs-xs">{{ l('4 تا اتاق خواب') }}</span>
                    </h3>
                    <div class="row g-2 g-lg-3">
                        <div class="col-6 col-lg-3">
                            <div class="d-flex flex-column gap-1 border p-3 rounded align-items-center h-100">
                                <div class="d-flex gap-2">
                                    <i class="fs-4 fi-single-bed"></i>
                                </div>
                                <p class="mb-0 fs-xs fw-bold">{{ l('اتاق 1') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت یک نفره') }}</p>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="d-flex flex-column gap-1 border p-3 rounded align-items-center h-100">
                                <div class="d-flex gap-2">
                                    <i class="fs-4 fi-single-bed"></i>
                                    <i class="fs-4 fi-double-bed"></i>
                                </div>
                                <p class="mb-0 fs-xs fw-bold">{{ l('اتاق 2') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت یک نفره') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت دو نفره') }}</p>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="d-flex flex-column gap-1 border p-3 rounded align-items-center h-100">
                                <div class="d-flex gap-2">
                                    <i class="fs-4 fi-single-bed"></i>
                                </div>
                                <p class="mb-0 fs-xs fw-bold">{{ l('اتاق 1') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت یک نفره') }}</p>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="d-flex flex-column gap-1 border p-3 rounded align-items-center h-100">
                                <div class="d-flex gap-2">
                                    <i class="fs-4 fi-single-bed"></i>
                                    <i class="fs-4 fi-double-bed"></i>
                                </div>
                                <p class="mb-0 fs-xs fw-bold">{{ l('اتاق 2') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت یک نفره') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت دو نفره') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Amenities-->
                <div class="mb-4 pb-md-3 border-bottom pb-3">
                    <h3 class="h5 mb-3">{{ l('امکانات رفاهی') }}</h3>
                    <ul class="list-unstyled row row-cols-lg-3 row-cols-md-2 row-cols-2 gy-1 mb-1 text-nowrap">
                        <li class="col"><i class="fi-wifi mt-n1 me-2 fs-lg align-middle"></i>{{ l('وای فای') }}</li>
                        <li class="col"><i class="fi-thermometer mt-n1 me-2 fs-lg align-middle"></i>{{ l('سیستم گرمایشی') }}</li>
                        <li class="col"><i class="fi-dish mt-n1 me-2 fs-lg align-middle"></i>{{ l('استخر') }}</li>
                        <li class="col"><i class="fi-parking mt-n1 me-2 fs-lg align-middle"></i>{{ l('پارکینگ') }}</li>
                        <li class="col"><i class="fi-snowflake mt-n1 me-2 fs-lg align-middle"></i>{{ l('تهویه هوا') }}</li>
                        <li class="col"><i class="fi-iron mt-n1 me-2 fs-lg align-middle"></i>{{ l('گاز رومیزی') }}</li>
                        <li class="col"><i class="fi-tv mt-n1 me-2 fs-lg align-middle"></i>{{ l('تلویزیون') }}</li>
                        <li class="col"><i class="fi-laundry mt-n1 me-2 fs-lg align-middle"></i>{{ l('ماشین لباسشویی') }}</li>
                        <li class="col"><i class="fi-cctv mt-n1 me-2 fs-lg align-middle"></i>{{ l('دوربین مداربسته') }}</li>
                    </ul>
                    <div class="collapse" >
                        <ul class="list-unstyled row row-cols-lg-3 row-cols-md-2 row-cols-1 gy-1 mb-1 text-nowrap">
                            <li class="col"><i class="fi-no-smoke mt-n1 me-2 fs-lg align-middle"></i>{{ l('سیگار ممنوع') }}</li>
                            <li class="col"><i class="fi-pet mt-n1 me-2 fs-lg align-middle"></i>{{ l('گربه') }}</li>
                            <li class="col"><i class="fi-swimming-pool mt-n1 me-2 fs-lg align-middle"></i>{{ l('استخر') }}</li>
                            <li class="col"><i class="fi-double-bed mt-n1 me-2 fs-lg align-middle"></i>{{ l('2 خواب') }}</li>
                            <li class="col"><i class="fi-bed mt-n1 me-2 fs-lg align-middle"></i>{{ l('1 خواب') }}</li>
                        </ul>
                    </div><a class="collapse-label collapsed" href="#seeMoreAmenities" data-bs-toggle="collapse" data-bs-label-collapsed=l("مشاهده بیشتر") data-bs-label-expanded=l("بستن") role="button" aria-expanded="false" aria-controls="seeMoreAmenities"></a>
                </div>
                <!-- Cancel the reservation -->
                <div class="mb-4 pb-md-3 border-bottom pb-3">
                    <h3 class="h5 mb-3">{{ l('مقررات لغو رزرو') }}</h3>

                    <p>
                        <strong>{{ l('سیاست سختگیرانه:') }}</strong> {{ l('در صورتی که رزرو، بیش از 5 روز کامل از تاریخ ورود لغو گردد؛ 80 درصد مبلغ صورتحساب به میهمان عودت می‌شود. در غیر اینصورت اجاره شب اول بعلاوه 50 درصد شب‌های باقیمانده کسر می‌گردد.') }}
                    </p>
                </div>
                <!-- Regulation-->
                <div class="mb-4 pb-md-3 border-bottom pb-3">
                    <h3 class="h5 mb-3">{{ l('مقررات اقامتگاه') }}</h3>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="border rounded-2 p-3">
                            <p class="fs-xs mb-0"><i class="mx-1 fi-clock"></i>{{ l('ساعت ورود از') }}</p>
                            <p class="fw-bold fs-sm mb-0 text-center">{{ l('2 ظهر تا نامحدود') }}</p>
                        </div>
                        <div class="border rounded-2 p-3">
                            <p class="fs-xs mb-0"><i class="mx-1 fi-clock"></i>{{ l('ساعت خروج از') }}</p>
                            <p class="fw-bold fs-sm mb-0 text-center">{{ l('12 ظهر') }}</p>
                        </div>
                    </div>
                    <ul class="mx-3">
                        <li>{{ l('برگزاری مهمانی و پخش موزیک ممنوع است.') }}</li>
                        <li>{{ l('همراه داشتن حیوان خانگی ممنوع است.') }}</li>
                        <li>{{ l('استعمال دخانیات (سیگار، قلیان و ...) در داخل اقامتگاه ممنوع است.') }}</li>
                        <li><b>{{ l('مدارک مورد نیاز:') }}</b>{{ l('کارت ملی هوشمند یا شناسنامه') }}</li>
                        <li>{{ l('ویلا به صورت کاملا تمیز تحویل داده میشود و به همان صورت از شما مهمان عزیز تحویل گرفته میشود.') }}</li>
                        <li>{{ l('از پذیرش اکیپ مجردی پسرانه بیشتر از 2 نفر معذوریم.') }}</li>
                    </ul>
                </div>
                <!-- Map -->
                <div class="mb-4 pb-md-3 border-bottom pb-3">
                    <h3 class="h5 mb-3">{{ l('نقشه') }}</h3>
                    <div class="border rounded-2" style="height: 250px;"></div>

                </div>

            </div>
            <!-- Sidebar-->
            <aside class="col-lg-4 col-md-5 ms-lg-auto pb-1">
                <!-- Contact card-->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark d-flex justify-content-between align-items-center text-white">
                        <span class="fs-lg">{{ l('نرخ هر شب از:') }}</span>
                        <span class="fs-lg">2,400,000 <span class="fs-xs">{{ l('تومان') }}</span></span>
                    </div>
                    <div class="card-body">

                        <div>
                            <div class="d-flex align-items-center gap-3 mb-3">

                                <a class="text-decoration-none" href="/">
                                <img class="rounded-circle mb-2" src="/img/site2/avatars/17.png" width="80" height="80" alt="">
                                </a>
                                <div>
                                    <h5 class="mb-1">
                                    <a class="nav-link" href="/" target="_blank">
                                    {{ l('گیلند ملک') }}
                                    </a>
                                    </h5>
                                    <p class="text-body mb-2">
                                    {{ l('تماس در ساعات اداری') }}
                                    </p>
                                    <a href="tel:09129406124" class="text-primary text-decoration-none mb-1 fs-sm">
                                    <i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i>
                                    09129406124
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-lg btn-primary d-block w-100 mb-4" type="submit ">{{ l('ثبت درخواست رزرو') }}</button>
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <a href="#" class="btn btn-sm btn-outline-secondary "> <i class="fi-check-circle"></i>
                                {{ l('ضمانت تحویل') }}

                            </a>
                            <a href="#" class="btn btn-sm btn-outline-secondary "> <i class="fi-help"></i>
                                {{ l('راهنمای رزرو') }}
                            </a>
                        </div>
                    </div>
                </div>

            </aside>
        </div>
    </section>


    <section class="container mb-5">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
            <h2 class="h4 mb-sm-0 font-vazir">{{ l('سایر اقامتگاه های ماسال') }}</h2>

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
    <!-- </section> -->
    @include(ss('THEME') . '.frontend.layouts.footer_rent', ['cssClass' => 'intro'])
</main>
@endsection

@section('js')


    <script src="/assets/vendors/fancybox/fancybox.umd.js"></script>

    <script>
        Fancybox.bind("[data-fancybox]");
    </script>
@endsection
