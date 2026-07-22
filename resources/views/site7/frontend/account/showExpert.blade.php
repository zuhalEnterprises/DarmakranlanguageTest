@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])
@section('head')



@endsection
@section('main_content')
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')
    <div class="container mt-5 pt-5 p-0">
        <div class="row g-0 ">
            <!-- Filters sidebar (Offcanvas on mobile)-->
            <input type="hidden" name="type" id="type" value="1">
            <input type="hidden" name="view" id="view" value="1">
            <input type="hidden" name="districts" id="districts" value="">
            <input type="hidden" id="js_HiddenMapDrawPoints" style="width:0px;height:0px;overflow:hidden;border:0px" value="">
        </div>
    </div>
    <section class="container mt-lg-5">
        <div class="w-lg-75 mx-auto">
            <div class="d-flex mb-4">
                <div class=" d-flex gap-3">
                   <div>
                      <img class="rounded" src="https://kolbeh.ir/img/site3/logo-sha.webp" alt="pic" style="width:60px;height:60px;" />
                   </div> 
                   <h1 class="fs-5">{{ l('شهر املاک علی نبی پور') }}</h1>
                </div>
                <a href="" class="btn d-lg-none me-auto pt-0">
                    <i class="fi fi-share"></i>
                </a>
            </div>
                
            <!-- Nav tabs -->
            <ul class="nav nav-tabs border-bottom" role="tablist">
                <li class="nav-item">
                    <a href="#advertisements" class="nav-link " data-bs-toggle="tab" role="tab">
                    {{ l('آگهی‌ها') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link active" data-bs-toggle="tab" role="tab">
                    {{ l('دربارهٔ مشاور') }}
                    </a>
                </li>
                
                <li class="mb-0 me-auto d-none d-lg-block">
                    <a href="#" class="btn">
                        <span><i class="fi fi-share"></i></span>
                        <span>{{ l('اشتراک‌گذاری صفحه') }}</span>
                    </a>
                </li>
            </ul>

            <!-- Tabs content -->
            <div class="tab-content">
                <div class="tab-pane fade " id="advertisements" role="tabpanel">
                        <div class="row align-items-start">
                            <aside class="d-none d-lg-block col-md-3 position-sticky rounded" style="top: 130px;background:#fff;">
                                <div class="px-4  fs-xs mb-3">{{ l('دسته ها') }}</div>
                                <ul class="nav nav-pills flex-column mb-sm-auto align-items-center align-items-sm-start p-4  fs-sm cursor-pointer py-0 border-bottom border-dark" style="" id="menu">
                                    <li class="item  opacity-90 w-100 border-0 mb-3 fw-bold" >
                                                <i class="fi-real-estate-buy mb-1"></i>
                                                <span>{{ l('جستجوی املاک فروشی') }}</span>
                                                <ul class="sub-items list-unstyled me-4 ps-0 pe-2 mt-2">
                                                    <li class="sub-item">{{ l('مسکونی') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="sub-item">{{ l('تجاری') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('تجاری آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('تجاری ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="sub-item">{{ l('ساخت و ساز') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('ساخت و ساز آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('ساخت و ساز ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                    </li>
                                    <li class="item  opacity-90 w-100 border-0 mb-3 fw-bold" >
                                                <i class="fi-rent mb-1"></i>
                                                <span>{{ l('جستجوی املاک اجاره') }}</span>
                                                <ul class="sub-items list-unstyled me-4 ps-0 pe-2 mt-2">
                                                    <li class="sub-item">{{ l('اجاره مسکونی') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('اجاره آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('اجاره ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="sub-item">{{ l('اجاره تجاری') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('اجاره تجاری آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('اجاره تجاری ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="sub-item">{{ l('اجاره ساخت و ساز') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('اجاره ساخت و ساز آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('اجاره ساخت و ساز ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                    </li>
                                    <li class="item  opacity-90 w-100 border-0 mb-3 fw-bold" >
                                                <i class="fi-building mb-1"></i>
                                                <span>{{ l('جستجوی تقاضاهای خرید اجاره') }}</span>
                                                <ul class="sub-items list-unstyled me-4 ps-0 pe-2 mt-2">
                                                    <li class="sub-item">{{ l('تقاضا خرید مسکونی') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضا خرید آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضا خرید ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="sub-item">{{ l('تقاضای خرید تجاری') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضای خرید آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضای خرید ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="sub-item">{{ l('تقاضای خرید ساخت و ساز') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضای خرید ساخت و ساز آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضای خرید ساخت و ساز ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                    </li>
                                    <li class="item  opacity-90 w-100 border-0 mb-3 fw-bold" >
                                                <i class="fi-billboard-house mb-1"></i>
                                                <span>{{ l('جستجوی تقاضاهای اجاره') }}</span>
                                                <ul class="sub-items list-unstyled me-4 ps-0 pe-2 mt-2">
                                                    <li class="sub-item">{{ l('تقاضا اجاره مسکونی') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضا اجاره آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضا اجاره ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="sub-item">{{ l('تقاضای اجاره تجاری') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضای اجاره آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضای اجاره ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="sub-item">{{ l('تقاضای اجاره ساخت و ساز') }}
                                                        <ul class="sub-sub-items list-unstyled me-5 mt-2 border-danger border-start fs-xs list-unstyled pe-2 ps-0" >
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضای اجاره ساخت و ساز آپارتمان') }}</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="">{{ l('تقاضای اجاره ساخت و ساز ویلایی') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                    </li>
                                </ul>
                                

                                <div class="px-4 border-bottom border-dark"> 
                                    <div class="accordion " id="side2">
                                        <div class="accordion-item border-0" style="background:#fff;">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse2" aria-expanded="true" aria-controls="panelsStayOpen-collapse2" style="background:#fff;">
                                                    {{ l('امکانات') }}
                                                </button>
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
                                <div class="px-4 border-bottom border-dark" id="filter_sidebar" style="display:none;"> 
                                    <div class="accordion " >
                                        <div class="accordion-item border-0" style="background:#fff;">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-filters" aria-expanded="true" aria-controls="panelsStayOpen-filters" style="background:#fff;">
                                                    {{ l('فیلتر') }}
                                                </button>
                                            </h2>
                                            <div id="panelsStayOpen-filters" class="accordion-collapse collapse ">
                                                <div class="accordion-body fs-sm">
                                                    {{ l('آیتم های فیلتر (به زودی...)') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                   
                            </aside>
                            <main class="col-12 col-md-9">
                                <div class="row g-4">
                                    <!-- Item-->
                                    <div class=" col-md-6">
                                        <div class="card shadow-sm card-hover border-0 h-100 rounded-1">
                                            <div class="position-relative">
                                                <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                                    <span class="d-table badge bg-dark mb-1 rounded-0 rounded-start">{{ l('10 ملک مناسب') }}</span>
                                                    <span class="d-table badge bg-body rounded-0 rounded-start">{{ l('2 روز پیش') }}</span>
                                                </div>
                                                <div class="position-absolute top-0 end-0 zindex-5 rounded-circle m-3 border border-dark" >
                                                    <img src="https://kolbeh.ir/img/site3/logo-sha.webp" alt="expert" class="rounded-circle"  style="width:40px; height: 40px;object-fit:cover;">
                                                </div>
                                                <img class="rounded-1" src="/img/site2/catalog/01.jpg" alt="Article img" style="width: 100%; height: 220px;object-fit:cover;">
                                            </div>
                                            <div class="card-body position-relative pb-3">
                                                <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">{{ l('مشتری اجاره') }}</h4>
                                                <h3 class="h6 mb-2 fs-base d-flex justify-content-between">
                                                    <a class="nav-link stretched-link" href="site2-single-v1.html">{{ l('ویلا 2 طبقه | 150 متر مربع') }}</a>
                                                    <div class="position-relative ms-4">
                                                        
                                                        

                                                        <button class="btn btn-icon btn-light-primary btn-xs position-absolute top-0 zindex-5 text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('افزودن به علاقه مندی') }}" data-bs-original-title="{{ l('افزودن به علاقه مندی') }}">
                                                            <i class="fi-heart"></i>
                                                        </button>
                                                        <button class="btn btn-icon btn-light-primary btn-xs position-absolute top-0 end-0  zindex-5 text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('گفت و گو') }}" data-bs-original-title="{{ l('گفت و گو') }}">
                                                            <i class="fi-chat-circle"></i>
                                                        </button>
                                                    </div>
                                                </h3>

                                                <p class="mb-2 fs-sm text-muted">{{ l('آپارتمان مدرن در زنیبل آباد') }}</p>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                                                        <span>{{ l('ودیعه از:') }}</span>
                                                        {{ l('140000000 ت') }}
                                                    </div>
                                                    <div>

                                                        <span>{{ l('تا:') }}</span>
                                                        {{ l('84000000 ت') }}
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div>
                                                        <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                                                        <span>{{ l('اجاره از:') }}</span>
                                                        {{ l('400000 ت') }}
                                                    </div>
                                                    <div>

                                                        <span>{{ l('تا:') }}</span>
                                                        {{ l('5400000 ت') }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <i class="fi-map-pin mt-n1 me-1 lead align-middle opacity-70"></i>
                                                    {{ l('قم ، زنبیل آباد ، جمهوری، یزدانشهر') }}
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!-- Item-->
                                    <div class=" col-md-6">
                                        <div class="card shadow-sm card-hover border-0 h-100 rounded-1">
                                            <div class="position-relative">
                                                <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                                    <span class="d-table badge bg-primary mb-1 rounded-0 rounded-start">{{ l('10 مشتری مناسب') }}</span>
                                                    <span class="d-table badge bg-body rounded-0 rounded-start">{{ l('2 روز پیش') }}</span>
                                                </div>
                                                
                                                <img class="rounded-1" src="https://kolbeh.ir/upload/images/profile/img_kxisxYjVQtv8aBjQ.jpg" alt="Article img" style="width: 100%;height: 220px;object-fit:cover;">
                                            </div>
                                            <div class="card-body position-relative pb-3">
                                                <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">{{ l('مشتری اجاره') }}</h4>
                                                <h3 class="h6 mb-2 fs-base d-flex justify-content-between">
                                                    <a class="nav-link stretched-link" href="site2-single-v1.html">{{ l('ویلا 2 طبقه | 150 متر مربع') }}</a>
                                                    <div class="position-relative ms-4">
                                                        <button class="btn btn-icon btn-light-primary btn-xs position-absolute top-0 zindex-5 text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('افزودن به علاقه مندی') }}" data-bs-original-title="{{ l('افزودن به علاقه مندی') }}">
                                                            <i class="fi-heart"></i>
                                                        </button>
                                                        <button class="btn btn-icon btn-light-primary btn-xs position-absolute top-0 end-0  zindex-5 text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('گفت و گو') }}" data-bs-original-title="{{ l('گفت و گو') }}">
                                                            <i class="fi-chat-circle"></i>
                                                        </button>
                                                    </div>
                                                </h3>

                                                <p class="mb-2 fs-sm text-muted">{{ l('آپارتمان مدرن در زنیبل آباد') }}</p>
                                                
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div>
                                                        <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                                                        <span>{{ l('قیمت :') }}</span>
                                                        {{ l('140000 ت') }}
                                                    </div>

                                                </div>
                                                <div>
                                                    <i class="fi-map-pin mt-n1 me-1 lead align-middle opacity-70"></i>
                                                    {{ l('قم ، زنبیل آباد ، جمهوری، یزدانشهر') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Item-->
                                    <div class=" col-md-6">
                                        <div class="card shadow-sm card-hover border-0 h-100 rounded-1">
                                            <div class="position-relative">
                                                <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                                    <span class="d-table badge bg-dark mb-1 rounded-0 rounded-start">{{ l('10 ملک مناسب') }}</span>
                                                    <span class="d-table badge bg-body rounded-0 rounded-start">{{ l('2 روز پیش') }}</span>
                                                </div>
                                                <div class="position-absolute top-0 end-0 zindex-5 rounded-circle m-3 border border-dark" >
                                                    <img src="https://kolbeh.ir/img/site3/logo-sha.webp" alt="expert" class="rounded-circle"  style="width:40px; height: 40px;object-fit:cover;">
                                                </div>
                                                <img class="rounded-1" src="/img/site2/catalog/01.jpg" alt="Article img" style="width: 100%; height: 220px;object-fit:cover;">
                                            </div>
                                            <div class="card-body position-relative pb-3">
                                                <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">{{ l('مشتری اجاره') }}</h4>
                                                <h3 class="h6 mb-2 fs-base d-flex justify-content-between">
                                                    <a class="nav-link stretched-link" href="site2-single-v1.html">{{ l('ویلا 2 طبقه | 150 متر مربع') }}</a>
                                                    <div class="position-relative ms-4">
                                                        
                                                        

                                                        <button class="btn btn-icon btn-light-primary btn-xs position-absolute top-0 zindex-5 text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('افزودن به علاقه مندی') }}" data-bs-original-title="{{ l('افزودن به علاقه مندی') }}">
                                                            <i class="fi-heart"></i>
                                                        </button>
                                                        <button class="btn btn-icon btn-light-primary btn-xs position-absolute top-0 end-0  zindex-5 text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('گفت و گو') }}" data-bs-original-title="{{ l('گفت و گو') }}">
                                                            <i class="fi-chat-circle"></i>
                                                        </button>
                                                    </div>
                                                </h3>

                                                <p class="mb-2 fs-sm text-muted">{{ l('آپارتمان مدرن در زنیبل آباد') }}</p>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                                                        <span>{{ l('ودیعه از:') }}</span>
                                                        {{ l('140000000 ت') }}
                                                    </div>
                                                    <div>

                                                        <span>{{ l('تا:') }}</span>
                                                        {{ l('84000000 ت') }}
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div>
                                                        <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                                                        <span>{{ l('اجاره از:') }}</span>
                                                        {{ l('400000 ت') }}
                                                    </div>
                                                    <div>

                                                        <span>{{ l('تا:') }}</span>
                                                        {{ l('5400000 ت') }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <i class="fi-map-pin mt-n1 me-1 lead align-middle opacity-70"></i>
                                                    {{ l('قم ، زنبیل آباد ، جمهوری، یزدانشهر') }}
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    

                                </div>
                            </main>
                        </div>
                </div>
                <div class="tab-pane fade show active" id="about" role="tabpanel">
                    <div class="w-lg-50 mx-auto ">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="">
                                <h6>
                                    {{ l('علی نبی پور') }}
                                </h6>
                                <p class="opacity-60 mb-0">
                                    {{ l('آخرین فعالیت ۲ روز پیش') }}
                                </p>
                            </div>
                            <div>
                                <img class="rounded" src="https://kolbeh.ir/img/site3/logo-sha.webp" alt="pic" style="width:60px;height:60px;" />
                            </div>
                        </div>
                        
                        
                        <ul class="px-2 ">
                            <li class="d-flex justify-content-around py-2 border-bottom">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <span class="opacity-60 fs-sm">{{ l('آگهی‌های فعال') }}</span>
                                    <span class="">5</span>
                                </div>
                                <div class="border"></div>
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <span class="opacity-60 fs-sm">{{ l('عضویت در دیوار') }}</span>
                                    <span class="">{{ l('بیشتر از 2 ماه') }}</span>
                                </div>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="opacity-60">{{ l('موبایل') }}</span>
                                <span>09124513159</span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="opacity-60">{{ l('ساعات کاری') }}</span>
                                <span>{{ l('8 صبح تا 9 شب') }}</span>
                            </li>
                        </ul>
                        <h4 class="fs-lg mb-4">{{ l('محدودهٔ فعالیت') }}</h4>
                        <p>{{ l('پردیسان - شهرک قدس') }}</p>
                        <h4 class="fs-lg mb-4">{{ l('دربارهٔ مشاور') }}</h4>
                        <p>{{ l('خرید خوب هنری است که باید مشاور شما داشته باشد✅') }}</p>
                    </div>
                </div>
                         
            </div>

        </div>
    </section>


    @endsection
    @section('js')


    <script>
    // Sidebar desktop
      $(document).ready(function () {
        $(".sub-items, .sub-sub-items").hide();
        $(".item").click(function () {
            $('#filter_sidebar').hide()
          if ($(this).children(".sub-items").is(":visible")) {
            $(this).children(".sub-items").hide();
            $(".item").show();
          } else {
            $(".item").not(this).hide();
            $(this).children(".sub-items").show();
            $(this).siblings().hide();
          }
          $(".sub-item").show();
          $(".sub-sub-items").hide();
        });

        $(".sub-item").click(function (e) {
          e.stopPropagation();
          $('#filter_sidebar').show()
          if ($(this).children(".sub-sub-items").is(":visible")) {
            $(this).children(".sub-sub-items").hide();
            $(".sub-item").show();
          } else {
            $(this).siblings().hide();
            $(this).children(".sub-sub-items").show();
          }
        });

        $(".sub-sub-items li").click(function (e) {
          e.stopPropagation();
        });
      });
    </script>

    @endsection