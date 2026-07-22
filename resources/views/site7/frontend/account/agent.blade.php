@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])
@section('head')



@endsection
@section('main_content')

<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')

    
    <div class="container mt-5 pt-5 p-0" style="">
        <div class="row g-0 ">
            <!-- Filters sidebar (Offcanvas on mobile)-->
            <input type="hidden" name="type" id="type" value="1">
            <input type="hidden" name="view" id="view" value="1">
            <input type="hidden" name="districts" id="districts" value="">
            <input type="hidden" id="js_HiddenMapDrawPoints" style="width:0px;height:0px;overflow:hidden;border:0px" value="">

            <!-- Page content-->
            <div class="main col-12 position-relative overflow-hidden px-3">
                <!-- Breadcrumb-->
                <nav class="pt-2 pt-lg-5" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{l('نمایش کارشناس')}}</li>
                    </ol>
                </nav>



            </div>

        </div>
    </div>
    <section class="container mb-5">
        <div class="row gap-2 gap-lg-0">
            <div class="col-lg-8 ">

                <div class="card card-horizontal">
                    <div class="card-img-top" style="background-image: url('https://kolbeh.ir/upload/images/profile/img_kxisxYjVQtv8aBjQ.jpg');"></div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h2 class="fs-4 m-0">
                                {{ l('سید مهدی غضنفری') }}
                            </h2>
                            <a href="#">
                                <img src="https://kolbeh.ir/img/site3/logo-sha.webp" class="rounded" alt="logo" style="width: 35px;height:35px;">
                            </a>
                        </div>

                        <p class="fw-light m-0 fs-sm text-black-50 mb-2">
                            {{ l('کارشناس فروش') }}

                        </p>
                        <p class="m-0 mb-2">
                            {{ l('سید مهدی غضنفری هستم کارشناس فروش شهر املاک وسایت کلبه') }}
                        </p>
                        <p class="m-0 mb-2">
                            <b>{{ l('شماره تماس:') }}</b>
                            09127481169
                        </p>
                        <p class="m-0 mb-2">
                            <b>{{ l('آژانس:') }}</b>
                            {{ l('املاک بنفشه') }}
                        </p>

                        <p class="m-0 d-flex align-items-center gap-3 ">
                            <a href="4" class="opacity-60" target="_blank" tabindex="-1">
                                <i class="fi-telegram"></i>
                            </a>
                            <a href="2" class="opacity-60" target="_blank" tabindex="-1">
                                <i class="fi-whatsapp"></i>
                            </a>
                            <a href="3" class="opacity-60" target="_blank" tabindex="-1">
                                <i class="fi-instagram"></i>
                            </a>
                            <a href="1" class="opacity-60" target="_blank" tabindex="-1">
                                <img src="/img/logo/eitaaa.png" width="20px">
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <!-- <div class="card">
                    <div class="card-body pb-0">
                        <h4 class="card-title fs-6">{{ l('آمار کارشناس') }}</h4>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="opacity-70 fi-real-estate-house"></i>
                            <b>{{ l('تعداد املاک فروشی :') }}</b> 100
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="opacity-70 fi-apartment"></i>
                            <b>{{ l('تعداد املاک اجاره ای:') }}</b> 254
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="opacity-70 fi-shop"></i>
                            <b>{{ l('تعداد مشتریان خرید ملک:') }}</b> 14
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="opacity-70 fi-rent"></i>
                            <b>{{ l('تعداد مشتریان اجاره ملک:') }}</b> 47
                        </a>
                    </div>

                </div> -->
                <!-- List group with icons and badges -->
                <ul class="list-group">
                    <li class="list-group-item ">
                        <a href="#" class="d-flex justify-content-between align-items-center text-dark">
                            <span>
                                <i class="fi-real-estate-house text-muted me-2"></i>
                                {{ l('تعداد املاک فروشی') }}
                            </span>
                            <span class="badge bg-success">14</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="d-flex justify-content-between align-items-center text-dark">
                            <span>
                                <i class="fi-apartment fs-lg mt-n1 text-muted me-2"></i>
                                {{ l('تعداد املاک اجاره ای') }}
                            </span>
                            <span class="badge bg-secondary">2</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="d-flex justify-content-between align-items-center text-dark">
                            <span>
                                <i class="fi-shop fs-lg mt-n1 text-muted me-2"></i>
                                {{ l('تعداد مشتریان خرید ملک') }}
                            </span>
                            <span class="badge bg-warning">2</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="d-flex justify-content-between align-items-center text-dark">
                            <span>
                                <i class="fi-rent text-muted me-2"></i>
                                {{ l('تعداد مشتریان اجاره ملک') }}
                            </span>
                            <span class="badge bg-danger">6</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0 ">{{ l('لیست ملک های فعال') }}</h2>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2" dir="ltr">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="img-overlay" href="/v/410768"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">
                                    {{ l('۱۸:۳۶ ۱۴۰۳/۰۲/۰۳') }}
                                </span>
                                <span class="d-table badge bg-primary">{{ l('آپارتمان') }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">
                                <!--button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Wishlist">
                                            <i class="fi-heart"></i>
                                        </button-->
                            </div>
                            <img src="https://kolbeh.ir/img/site5/estate12.jpg" style="height: 200px;width:100%;object-fit:cover" data-src="https://kolbeh.ir/img/site5/estate12.jpg" alt="">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a class="nav-link stretched-link" href="/v/410768"> </a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div><i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۱۲,۳۷۵,۰۰۰,۰۰۰ ت') }}</div>
                                <div><i class="fi-cash lead align-middle opacity-70"></i> {{ l('متری: ۵۵,۰۰۰,۰۰۰ ت') }}</div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{ l('225 متر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ l('دوبر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{ l('ساخت: 1403') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="img-overlay" href="/v/410768"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">
                                    {{ l('۱۸:۳۶ ۱۴۰۳/۰۲/۰۳') }}
                                </span>
                                <span class="d-table badge bg-primary">{{ l('آپارتمان') }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">
                                <!--button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Wishlist">
                                            <i class="fi-heart"></i>
                                        </button-->
                            </div>
                            <img src="https://kolbeh.ir/img/site5/estate12.jpg" style="height: 200px;width:100%;object-fit:cover" data-src="https://kolbeh.ir/img/site5/estate12.jpg" alt="">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a class="nav-link stretched-link" href="/v/410768"> </a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div><i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۱۲,۳۷۵,۰۰۰,۰۰۰ ت') }}</div>
                                <div><i class="fi-cash lead align-middle opacity-70"></i> {{ l('متری: ۵۵,۰۰۰,۰۰۰ ت') }}</div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{ l('225 متر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ l('دوبر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{ l('ساخت: 1403') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="img-overlay" href="/v/410768"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">
                                    {{ l('۱۸:۳۶ ۱۴۰۳/۰۲/۰۳') }}
                                </span>
                                <span class="d-table badge bg-primary">{{ l('آپارتمان') }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">
                                <!--button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Wishlist">
                                            <i class="fi-heart"></i>
                                        </button-->
                            </div>
                            <img src="https://kolbeh.ir/img/site5/estate12.jpg" style="height: 200px;width:100%;object-fit:cover" data-src="https://kolbeh.ir/img/site5/estate12.jpg" alt="">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a class="nav-link stretched-link" href="/v/410768"> </a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div><i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۱۲,۳۷۵,۰۰۰,۰۰۰ ت') }}</div>
                                <div><i class="fi-cash lead align-middle opacity-70"></i> {{ l('متری: ۵۵,۰۰۰,۰۰۰ ت') }}</div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{ l('225 متر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ l('دوبر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{ l('ساخت: 1403') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="img-overlay" href="/v/410768"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">
                                    {{ l('۱۸:۳۶ ۱۴۰۳/۰۲/۰۳') }}
                                </span>
                                <span class="d-table badge bg-primary">{{ l('آپارتمان') }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">
                                <!--button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Wishlist">
                                            <i class="fi-heart"></i>
                                        </button-->
                            </div>
                            <img src="https://kolbeh.ir/img/site5/estate12.jpg" style="height: 200px;width:100%;object-fit:cover" data-src="https://kolbeh.ir/img/site5/estate12.jpg" alt="">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a class="nav-link stretched-link" href="/v/410768"> </a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div><i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۱۲,۳۷۵,۰۰۰,۰۰۰ ت') }}</div>
                                <div><i class="fi-cash lead align-middle opacity-70"></i> {{ l('متری: ۵۵,۰۰۰,۰۰۰ ت') }}</div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{ l('225 متر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ l('دوبر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{ l('ساخت: 1403') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="img-overlay" href="/v/410768"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">
                                    {{ l('۱۸:۳۶ ۱۴۰۳/۰۲/۰۳') }}
                                </span>
                                <span class="d-table badge bg-primary">{{ l('آپارتمان') }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">
                                <!--button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Wishlist">
                                            <i class="fi-heart"></i>
                                        </button-->
                            </div>
                            <img src="https://kolbeh.ir/img/site5/estate12.jpg" style="height: 200px;width:100%;object-fit:cover" data-src="https://kolbeh.ir/img/site5/estate12.jpg" alt="">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a class="nav-link stretched-link" href="/v/410768"> </a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div><i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۱۲,۳۷۵,۰۰۰,۰۰۰ ت') }}</div>
                                <div><i class="fi-cash lead align-middle opacity-70"></i> {{ l('متری: ۵۵,۰۰۰,۰۰۰ ت') }}</div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{ l('225 متر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ l('دوبر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{ l('ساخت: 1403') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="img-overlay" href="/v/410768"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">
                                    {{ l('۱۸:۳۶ ۱۴۰۳/۰۲/۰۳') }}
                                </span>
                                <span class="d-table badge bg-primary">{{ l('آپارتمان') }}</span>
                            </div>
                            <div class="content-overlay end-0 top-0 pt-3 ps-3">
                                <!--button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Wishlist">
                                            <i class="fi-heart"></i>
                                        </button-->
                            </div>
                            <img src="https://kolbeh.ir/img/site5/estate12.jpg" style="height: 200px;width:100%;object-fit:cover" data-src="https://kolbeh.ir/img/site5/estate12.jpg" alt="">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h3 class="h6 mb-2 fs-base">
                                <a class="nav-link stretched-link" href="/v/410768"> </a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                <div><i class="fi-cash lead align-middle opacity-70"></i>
                                    {{ l('۱۲,۳۷۵,۰۰۰,۰۰۰ ت') }}</div>
                                <div><i class="fi-cash lead align-middle opacity-70"></i> {{ l('متری: ۵۵,۰۰۰,۰۰۰ ت') }}</div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{ l('225 متر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ l('دوبر') }}
                                </span>
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{ l('ساخت: 1403') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')

@endsection