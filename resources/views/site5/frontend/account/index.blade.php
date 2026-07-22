@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])

@section('main_content')
<style>
  .icon-box-media-2 {
    display: block;
    width: 5rem;
    height: 5rem;
  }

  .img-over {
    position: absolute;
    display: block;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
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
    background-color: rgba(255, 255, 255, .15);
    display: inline-block;
    text-align: center;
    min-width: 123px;
    padding: 10px;
    border-radius: 6px;

  }

  .type-banner-property:hover {
    background-color: rgba(255, 255, 255, .35);
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

  .fixed-button {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
  }

  .offcanvas-bottom {
        height: auto !important;
    }
</style>
<!-- main -->
<main class="page-wrapper">
  @include(ss('THEME') . '.frontend.layouts.header_v2')

  <section class="container mb-md-3 categories-guid py-lg-5 py-3 mt-5">
    <div class=" d-none d-lg-block">
      <div class="row  row-cols-md-4 row-cols-2 g-3 g-xl-4 pt-lg-5">
        <div class="col">
          <a class="icon-box card card-body h-100 border-0 shadow-sm card-hover h-100 text-center" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3 mx-auto">
              <i class="fi-real-estate-house"></i></div>
            <h3 class="icon-box-title fs-base mb-0">{{ l('جستجوی املاک فروشی') }}</h3>
          </a>
        </div>
        <div class="col">
          <a class="icon-box card card-body h-100 border-0 shadow-sm card-hover h-100 text-center" href="#" data-bs-toggle="modal" data-bs-target="#rentModal">
            <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3 mx-auto">
              <i class="fi-apartment"></i>
            </div>
            <h3 class="icon-box-title fs-base mb-0">{{ l('جستجوی املاک اجاره ای') }}</h3>
          </a>
        </div>
        <div class="col">
          <a class="icon-box card card-body h-100 border-0 shadow-sm card-hover h-100 text-center" href="/" data-bs-toggle="modal" data-bs-target="#buyModal">
            <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3 mx-auto">
              <i class="fi-shop"></i>
            </div>
            <h3 class="icon-box-title fs-base mb-0">{{ l('جستجوی مشتریان خرید ملک') }}</h3>
          </a>
        </div>
        <div class="col">
          <a class="icon-box card card-body h-100 border-0 shadow-sm card-hover h-100 text-center" href="/" data-bs-toggle="modal" data-bs-target="#demandModal">
            <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3 mx-auto">
              <i class="fi-rent"></i>
            </div>
            <h3 class="icon-box-title fs-base mb-0">{{ l('جستجوی مشتریان اجاره ملک') }}</h3>
          </a>
        </div>
      </div>
      <div class="row g-3 mt-2 justify-content-center">
        <div class=" col-md-3">
          <a class=" icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 shadow-sm " href="city-guide-catalog.html">
            <div class="icon-box-media icon-box-media-2 bg-faded-primary text-primary me-2 d-flex align-items-center justify-content-center">
              <i class="fi-entertainment fs-3"></i>
            </div>
            <div>
              <h3 class="icon-box-title fs-base ps-1 pe-2 mb-0">{{ l('فهرست مشاوران') }}</h3>
              <p class="mb-0 ps-1 pe-2 fs-sm">{{ l('همه اطلاعات و آگهی ها') }}</p>
            </div>
          </a>
        </div>
        <div class=" col-md-3">
          <a class=" icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 shadow-sm " href="city-guide-catalog.html">
            <div class="icon-box-media icon-box-media-2 bg-faded-primary text-primary me-2 d-flex align-items-center justify-content-center">
              <i class="fi-entertainment fs-3"></i>
            </div>
            <div>
              <h3 class="icon-box-title fs-base ps-1 pe-2 mb-0">{{ l('فهرست آژانس ها') }}</h3>
              <p class="mb-0 ps-1 pe-2 fs-sm">{{ l('همه اطلاعات و آگهی ها') }}</p>
            </div>
          </a>
        </div>
        <div class=" col-md-3">
          <a class=" icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 shadow-sm " href="city-guide-catalog.html">
            <div class="icon-box-media icon-box-media-2 bg-faded-success text-success me-2 d-flex align-items-center justify-content-center">
              <i class="fi-museum fs-3"></i>
            </div>
            <h3 class="icon-box-title fs-base ps-1 pe-2 mb-0">{{ l('عضویت مشاورین املاک') }}</h3>
          </a>
        </div>
      </div>
    </div>

    <div class=" row g-3 d-lg-none mt-1">
      <div class="col-4">
        <a class="btn btn-primary btn-sm fs-xxs" href="/">
          {{ l('فهرست مشاورین') }}
        </a>
      </div>
      <div class="col-4">
        <a class="btn btn-primary btn-sm fs-xxs" href="/">
          {{ l('فهرست آژانس ها') }}
        </a>
      </div>
      <div class="col-4">
        <a class="btn btn-primary btn-sm fs-xxs" href="/">
          {{ l('عضویت مشاورین') }}
        </a>
      </div>
    </div>

    <div class="d-lg-none row">


      <div class="col-3 p-0">
        <a class="icon-box card card-body h-100 border-0 card-hover h-100 text-center" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
          <div class="icon-box-media bg-faded-primary text-primary mb-2 mx-auto">
            <i class="fi-real-estate-house"></i></div>
          <span class="icon-box-title fs-xs mb-0">{{ l('املاک فروشی') }}</span>
        </a>
      </div>
      <div class="col-3 p-0">
        <a class="icon-box card card-body h-100 border-0 card-hover h-100 text-center" href="#" data-bs-toggle="modal" data-bs-target="#rentModal">
          <div class="icon-box-media bg-faded-primary text-primary mb-2 mx-auto">
            <i class="fi-apartment"></i>
          </div>
          <span class="icon-box-title fs-xs mb-0">{{ l('املاک اجاره ای') }}</span>
        </a>
      </div>
      <div class="col-3 p-0">
        <a class="icon-box card card-body h-100 border-0 card-hover h-100 text-center" href="/">
          <div class="icon-box-media bg-faded-primary text-primary mb-2 mx-auto">
            <i class="fi-shop"></i>
          </div>
          <span class="icon-box-title fs-xs mb-0">{{ l('مشتریان خرید') }}</span>
        </a>
      </div>
      <div class="col-3 p-0">
        <a class="icon-box card card-body h-100 border-0 card-hover h-100 text-center" href="/">
          <div class="icon-box-media bg-faded-primary text-primary mb-2 mx-auto">
            <i class="fi-rent"></i>
          </div>
          <span class="icon-box-title fs-xs mb-0">{{ l('مشتریان اجاره') }}</span>
        </a>
      </div>

    </div>
  </section>

  <!-- Banner -->
  <section class="container mb-5 d-none d-lg-block">
    <div class="w-100 w-lg-75 m-auto d-flex align-items-center bg-success rounded px-3 py-4 justify-content-around flex-column flex-lg-row mb-3 ">
      <h1 class="text-center text-white fs-5">
        {{ l('با عضویت در املاکیار کلبه ، به کسب و کارت رونق بده') }}
      </h1>
      <button class="btn btn-primary">{{ l('عضویت در کلبه موفقیت') }}</button>
    </div>

    <div class="w-100 w-lg-75 m-auto d-flex align-items-center bg-secondary rounded px-3 py-4 justify-content-around">
      <a href="#" class="text-center fs-5 text-dark fw-bold">
        {{ l('روی نقشه ملک، مشتری یا مشتری املاک مورد نظرت رو جستجو کن') }}
      </a>
    </div>

  </section>

  <section class="container mb-5 pb-md-4">
    <div class="d-flex align-items-lg-center justify-content-start justify-content-lg-between mb-3 flex-column flex-lg-row d-none d-lg-flex">
      <a href="#" class="fs-base fw-bold mb-1 mb-lg-0 ">{{ l('همه املاک فروشی و اجاره ای(2500 آگهی)') }}</a>
      <a href="#" class="fs-base fw-bold mb-0 ">{{ l('همه مشتریان خرید و اجاره ملک(2500 آگهی)') }}</a>

    </div>
    <div class="row g-4">
      <!-- Item-->
      <div class=" col-md-4 col-lg-3">
        <div class="card shadow-sm card-hover border-0 h-100">
          <div class="position-relative">
            <div class="position-absolute start-0 top-0 pt-3 ps-3">
              <span class="d-table badge bg-dark mb-1">{{ l('10 ملک مناسب') }}</span><span class="d-table badge bg-body">{{ l('2 روز پیش') }}</span>
            </div>
            <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('افزودن به علاقه مندی') }}" data-bs-original-title="{{ l('افزودن به علاقه مندی') }}"><i class="fi-heart"></i></button>
            <img class="rounded-3" src="img/site2/catalog/01.jpg" alt="Article img">
          </div>
          <div class="card-body position-relative pb-3">
            <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">{{ l('مشتری اجاره') }}</h4>
            <h3 class="h6 mb-2 fs-base d-flex justify-content-between">
              <a class="nav-link stretched-link" href="site2-single-v1.html">{{ l('ویلا 2 طبقه | 150 متر مربع') }}</a>
              <a class="">
                <i class="fi-chat-circle"></i>
              </a>
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
          <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap">
            <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i>{{ l('3 خوابه') }}</span>
            <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i>1398</span>
            <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i>{{ l('270 متر') }}</span>
          </div>
        </div>
      </div>
      <!-- Item-->
      <div class=" col-md-4 col-lg-3">
        <div class="card shadow-sm card-hover border-0 h-100">

          <div class="position-relative">
            <div class="position-absolute start-0 top-0 pt-3 ps-3">
              <span class="d-table badge bg-primary mb-1">{{ l('10 مشتری مناسب') }}</span><span class="d-table badge bg-body">{{ l('5 روز پیش') }}</span>
            </div>
            <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('افزودن به علاقه مندی') }}" data-bs-original-title="{{ l('افزودن به علاقه مندی') }}"><i class="fi-heart"></i></button>
            <img class="rounded-3" src="img/site2/catalog/02.jpg" alt="Article img">
          </div>
          <div class="card-body position-relative pb-3">
            <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">{{ l('ملک فروشی') }}</h4>
            <h3 class="h6 mb-2 fs-base d-flex justify-content-between">
              <a class="nav-link stretched-link" href="site2-single-v1.html">{{ l('ویلا 2 طبقه | 150 متر مربع') }}</a>
              <a class="">
                <i class="fi-chat-circle"></i>
              </a>
            </h3>
            <p class="mb-2 fs-sm text-muted">{{ l('ویلا لوکس در یزدانشهر') }}</p>
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
          <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap">
            <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i>{{ l('3 خوابه') }}</span>
            <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i>1389</span>
            <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i>{{ l('270 متر') }}</span>
          </div>
        </div>
      </div>
      <!-- Item-->
      <div class=" col-md-4 col-lg-3">
        <div class="card shadow-sm card-hover border-0 h-100">
          <div class="position-relative">
            <div class="position-absolute start-0 top-0 pt-3 ps-3">
              <span class="d-table badge bg-primary mb-1">{{ l('10 مشتری مناسب') }}</span><span class="d-table badge bg-body">{{ l('دیروز') }}</span>
            </div>
            <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('افزودن به علاقه مندی') }}" data-bs-original-title="{{ l('افزودن به علاقه مندی') }}"><i class="fi-heart"></i></button>
            <img class="rounded-3" src="img/site2/catalog/04.jpg" alt="Article img">
          </div>
          <div class="card-body position-relative pb-3 ">
            <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">{{ l('ملک اجاره ای') }}</h4>
            <h3 class="h6 mb-2 fs-base d-flex justify-content-between">
              <a class="nav-link stretched-link" href="site2-single-v1.html">{{ l('ویلا 2 طبقه | 150 متر مربع') }}</a>
              <a class="">
                <i class="fi-chat-circle"></i>
              </a>
            </h3>
            <p class="mb-2 fs-sm text-muted">{{ l('ویلا لوکس در زنبیل آباد') }}</p>
            <div class="d-flex justify-content-between mb-2">
              <div>
                <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                <span>{{ l('رهن:') }}</span>
                {{ l('140000000 ت') }}
              </div>
              <div>
                <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                <span>{{ l('اجاره:') }}</span>
                {{ l('84000000 ت') }}
              </div>
            </div>
            <div>
              <i class="fi-map-pin mt-n1 me-1 lead align-middle opacity-70"></i>
              {{ l('قم ، زنبیل آباد ، جمهوری، یزدانشهر') }}
            </div>

          </div>
          <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap">
            <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i>{{ l('3 خوابه') }}</span>
            <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i>1390</span>
            <span class="d-inline-block mx-1 px-2 fs-sm"><i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i>{{ l('270 متر') }}</span>
          </div>
        </div>
      </div>


    </div>
  </section>

  <div class="mb-4 container ">
    <div class="text-center fixed-button bg-faded-dark rounded p-2" style="bottom: 10% !important;">
      <a class="btn btn-lg btn-primary rounded-4 btn-sm order-lg-3 px-4 fs-6" href="/">
        <i class="fi-map me-2"></i>{{ l('نقشه') }}</a>
    </div>
  </div>

  <div class="bg-white position-fixed bottom-0 right-0 left-0 w-100 p-2 border-top border-2 d-lg-none zindex-10">
    <div class="d-flex align-items-center justify-content-between">
      <a href="" class="d-flex flex-column align-items-center justify-content-center fs-xs text-dark opacity-75">
        <i class="fs-4 fi-plus"></i>
        <span class="">{{ l('ثبت مشتری') }}</span>
      </a>
      <a href="" class="d-flex flex-column align-items-center justify-content-center fs-xs text-dark opacity-75">
        <i class="fs-4 fi-plus"></i>
        <span class=" ">{{ l('ثبت ملک') }}</span>
      </a>
      <a href="" class="d-flex flex-column align-items-center justify-content-center fs-xs text-dark opacity-75">
        <i class="fs-4 fi-heart"></i>
        <span class="">{{ l('مورد علاقه') }}</span>
      </a>
      <a href="" class="d-flex flex-column align-items-center justify-content-center fs-xs text-dark opacity-75">
        <i class="fs-4 fi-chat-circle"></i>
        <span class="">{{ l('پیام ها') }}</span>
      </a>
      <a href="" class="d-flex flex-column align-items-center justify-content-center fs-xs text-dark opacity-75"  data-bs-toggle="offcanvas" data-bs-target="#myAccount" aria-controls="myAccount">
        <i class="fs-4 fi-user"></i>
        <span class="">{{ l('حساب من') }}</span>
      </a>
    </div>
  </div>


  <!-- Modal Sell -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ l('املاک فروشی') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-body-main">
          <button type="button" class=" btn btn-secondary mb-2 btn-xs" id="backButton-sell" style="display: none;" onclick="showMainlist('sell')">
            <i class="fi-arrow-long-right"></i>
            {{ l('برگشت') }}</button>
          <!-- Main list -->
          <ul class="list-group" id="main-list-sell">
            <li class="list-group-item cursor-pointer" onclick="showSublist(1,'sell')">{{ l('فروش مسکونی') }}</li>
            <li class="list-group-item cursor-pointer" onclick="showSublist(2,'sell')">{{ l('فروش تجاری، اداری، صنعتی') }}</li>
            <li class="list-group-item cursor-pointer" onclick="showSublist(3,'sell')">{{ l('پروژه های ساخت و ساز') }}</li>

          </ul>

          <!-- Sublists (hidden by default) -->
          <ul class="list-group" id="sublist-sell1" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش آپارتمان') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش خانه و ویلا') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش زمین و خانه کلنگی') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش آپارتمان به صورت یکجا(تمام طبقات)') }}
              </a>
            </li>
          </ul>

          <ul class="list-group" id="sublist-sell2" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش اداری(دفترکار،مطب)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش تجاری(مغازه و غرفه)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش صنعتی(کارگاه و کارخنجات)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش زمین کشاورزی و باغ') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش زمین تجاری') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش آپارتمان یکجا(تمام ظبقات)') }}
              </a>
            </li>
          </ul>

          <ul class="list-group" id="sublist-sell3" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('مشارکت در ساخت') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('پیش فروش') }}
              </a>
            </li>

        </div>

      </div>
    </div>
  </div>

  <!-- Modal Rent -->
  <div class="modal fade" id="rentModal" tabindex="-1" aria-labelledby="rentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rentModalLabel">{{ l('املاک اجاره ای') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-body-main">
          <button type="button" class="btn btn-secondary mb-2 btn-xs" id="backButton-rent" style="display: none;" onclick="showMainlist('rent')">
            <i class="fi-arrow-long-right"></i>
            {{ l('برگشت') }}</button>
          <!-- Main list -->
          <ul class="list-group" id="main-list-rent">
            <li class="list-group-item cursor-pointer" onclick="showSublist(1,'rent')">{{ l('اجاره مسکونی') }}</li>
            <li class="list-group-item cursor-pointer" onclick="showSublist(2,'rent')">{{ l('اجاره تجاری، اداری، صنعتی') }}</li>
            <li class="list-group-item cursor-pointer" onclick="showSublist(3,'rent')">{{ l('اجاره کوتاه مدت') }}</li>
          </ul>

          <!-- Sublists (hidden by default) -->
          <ul class="list-group" id="sublist-rent1" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('اجاره آپارتمان') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('اجاره خانه و ویلا') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('اجاره باغ ویلا') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('اجاره زمین و خانه کلنگی') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('اجاره آپارتمان یکجا(تمام طبقات)') }}
              </a>
            </li>
          </ul>

          <ul class="list-group" id="sublist-rent2" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش اداری(دفترکار،مطب)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش تجاری(مغازه و غرفه)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش صنعتی(کارگاه و کارخنجات)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش زمین کشاورزی و باغ') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش زمین تجاری') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('فروش آپارتمان یکجا(تمام ظبقات)') }}
              </a>
            </li>
          </ul>

          <ul class="list-group" id="sublist-rent3" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('مشارکت در ساخت') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('پیش فروش') }}
              </a>
            </li>

        </div>

      </div>
    </div>
  </div>

  <!-- Modal buy -->
  <div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="buyModalLabel">{{ l('مشتریان خرید ملک') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-body-main">
          <button type="button" class="btn btn-secondary mb-2 btn-xs" id="backButton-buy" style="display: none;" onclick="showMainlist('buy')">
            <i class="fi-arrow-long-right"></i>
            {{ l('برگشت') }}</button>
          <!-- Main list -->
          <ul class="list-group" id="main-list-buy">
            <li class="list-group-item cursor-pointer" onclick="showSublist(1,'buy')">{{ l('خرید مسکونی') }}</li>
            <li class="list-group-item cursor-pointer" onclick="showSublist(2,'buy')">{{ l('خرید تجاری، اداری، صنعتی') }}</li>
            <li class="list-group-item cursor-pointer" onclick="showSublist(3,'buy')">{{ l('پروژه های ساخت و ساز') }}</li>
          </ul>

          <!-- Sublists (hidden by default) -->
          <ul class="list-group" id="sublist-buy1" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('خرید آپارتمان') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('خرید خانه و ویلا') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('خرید باغ ویلا') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('خرید زمین و خانه کلنگی') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('خرید آپارتمان یکجا(تمام طبقات)') }}
              </a>
            </li>
          </ul>

          <ul class="list-group" id="sublist-buy2" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('خرید اداری(دفترکار،مطب)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('خرید تجاری(مغازه و غرفه)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('خرید صنعتی(کارگاه و کارخنجات)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('خرید زمین کشاورزی و باغ') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('خرید زمین تجاری') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('خرید آپارتمان یکجا(تمام ظبقات)') }}
              </a>
            </li>
          </ul>

          <ul class="list-group" id="sublist-buy3" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('مشارکت در ساخت') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('پیش فروش') }}
              </a>
            </li>

        </div>

      </div>
    </div>
  </div>

  <!-- Modal demand -->
  <div class="modal fade" id="demandModal" tabindex="-1" aria-labelledby="demandLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="demandLabel">{{ l('مشتریان اجاره ملک') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-body-main">
          <button type="button" class="btn btn-secondary mb-2 btn-xs" id="backButton-demand" style="display: none;" onclick="showMainlist('demand')">
            <i class="fi-arrow-long-right"></i>
            {{ l('برگشت') }}</button>
          <!-- Main list -->
          <ul class="list-group" id="main-list-demand">
            <li class="list-group-item cursor-pointer" onclick="showSublist(1,'demand')">{{ l('تقاضا مسکونی') }}</li>
            <li class="list-group-item cursor-pointer" onclick="showSublist(2,'demand')">{{ l('تقاضا تجاری، اداری، صنعتی') }}</li>
            <li class="list-group-item cursor-pointer" onclick="showSublist(3,'demand')">{{ l('تقاضا اجاره کوتاه مدت') }}</li>
          </ul>

          <!-- Sublists (hidden by default) -->
          <ul class="list-group" id="sublist-demand1" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره مسکونی') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره آپارتمان') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره خانه و ویلا') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره باغ ویلا') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره زمین و خانه کلنگی') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره آپارتمان یکجا(تمام طبقات)') }}
              </a>
            </li>
          </ul>

          <ul class="list-group" id="sublist-demand2" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره اداری(دفترکار،مطب)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره تجاری(مغازه و غرفه)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره صنعتی(کارگاه و کارخنجات)') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره زمین کشاورزی و باغ') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره آپارتمان یکجا(تمام ظبقات)') }}
              </a>
            </li>
          </ul>

          <ul class="list-group" id="sublist-demand3" style="display: none;">
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره کوتاه مدت آپارتمان و سوئیت') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره کوتاه مدت ویلا و باغ') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره کوتاه مدت دفترکار و فضای آموزشی') }}
              </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="text-dark text-decoration-none">
                {{ l('تقاضا اجاره کوتاه مدت آپارتمان یکجا (تمام طبقات)') }}
              </a>
            </li>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal My Account -->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="myAccount" aria-labelledby="myAccountLabel">
    <div class="offcanvas-header pb-0">
        <h5 class="offcanvas-title" id="myAccountLabel">{{ l('حساب من') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <ul class="nav nav-pills flex-column mb-sm-auto  align-items-sm-start p-4 rounded" style="background:#f9f9f9;" id="menu">
            <li class="nav-item opacity-90">
                <a href="#" class="align-middle px-0 text-dark d-flex align-items-center gap-2">
                    <i class="fi-home"></i>
                    <span>{{ l('صفحه نخست') }}</span>
                </a>
            </li>
            <li href="#list1" class="d-flex align-items-center gap-2 nav-item cursor-pointer opacity-90" data-bs-toggle="collapse">
                <i class="fi-real-estate-buy"></i>
                <div>
                    <span>{{ l('املاک فروشی') }}</span>
                    <i class="fi-chevron-down"></i>
                </div>
            </li>
            <div class="collapse " id="list1">
                <a href="#" class="d-block ms-2 text-dark">{{ l('املاک 1') }}</a>
                <a href="#" class="d-block ms-2 text-dark">{{ l('املاک 2') }}</a>
                <a href="#" class="d-block ms-2 text-dark">{{ l('املاک 3') }}</a>
            </div>
            <li href="#list2" class="d-flex align-items-center gap-2 nav-item cursor-pointer opacity-90" data-bs-toggle="collapse">
                <i class="fi-rent"></i>
                <div>
                    <span>{{ l('املاک اجاره') }}</span>
                    <i class="fi-chevron-down"></i>
                </div>
            </li>
            <div class="collapse " id="list2">
                <a href="#" class="d-block ms-2 text-dark">{{ l('املاک اجاره 1') }}</a>
                <a href="#" class="d-block ms-2 text-dark">{{ l('املاک اجاره 2') }}</a>
                <a href="#" class="d-block ms-2 text-dark">{{ l('املاک اجاره 3') }}</a>
            </div>
            <li href="#list3" class="d-flex align-items-center gap-2 nav-item cursor-pointer opacity-90" data-bs-toggle="collapse">
                <i class="fi-building"></i>
                <div>
                    <span>{{ l('تقاضاهای خرید') }}</span>
                    <i class="fi-chevron-down"></i>
                </div>
            </li>
            <div class="collapse " id="list3">
                <a href="#" class="d-block ms-2 text-dark">{{ l('تقاضاهای خرید 1') }}</a>
                <a href="#" class="d-block ms-2 text-dark">{{ l('تقاضاهای خرید 2') }}</a>
                <a href="#" class="d-block ms-2 text-dark">{{ l('تقاضاهای خرید 3') }}</a>
            </div>
            <li href="#list4" class="d-flex align-items-center gap-2 nav-item cursor-pointer opacity-90" data-bs-toggle="collapse">
                <i class="fi-billboard-house"></i>
                <div>
                    <span>{{ l('تقاضاهای اجاره') }}</span>
                    <i class="fi-chevron-down"></i>
                </div>
            </li>
            <div class="collapse " id="list4">
                <a href="#" class="d-block ms-2 text-dark">{{ l('تقاضاهای اجاره 1') }}</a>
                <a href="#" class="d-block ms-2 text-dark">{{ l('تقاضاهای اجاره 2') }}</a>
                <a href="#" class="d-block ms-2 text-dark">{{ l('تقاضاهای اجاره 3') }}</a>
            </div>
            <li href="#list5" class="d-flex align-items-center gap-2 nav-item cursor-pointer opacity-90" data-bs-toggle="collapse">
                <i class="fi-house-chosen"></i>
                <div>
                    <span>{{ l('صفحه املاک من') }}</span>
                    <i class="fi-chevron-down"></i>
                </div>
            </li>
            <div class="collapse " id="list5">
                <a href="#" class="d-block ms-2 text-dark">{{ l('صفحه املاک من 1') }}</a>
                <a href="#" class="d-block ms-2 text-dark">{{ l('صفحه املاک من 2') }}</a>
                <a href="#" class="d-block ms-2 text-dark">{{ l('صفحه املاک من 3') }}</a>
            </div>
            <li class="nav-item">
                <a href="#" class="align-middle px-0 text-dark d-flex align-items-center gap-2 opacity-90">
                    <i class="fi-home"></i>
                    <span>{{ l('صفحه املاک بنفش') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="align-middle px-0 text-dark d-flex align-items-center gap-2 opacity-90">
                    <i class="fi-users"></i>
                    <span>{{ l('فهرست مشاورین املاک') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="align-middle px-0 text-dark d-flex align-items-center gap-2 opacity-90">
                    <i class="fi-shop"></i>
                    <span>{{ l('فهرست آژانس های املاک') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>

</main>

<script>
  function showSublist(index, el) {
    document.getElementById("main-list-" + el).style.display = "none";
    document.getElementById("sublist-" + el + index).style.display = "block";
    document.getElementById("backButton-" + el).style.display = "block";
  }

  function showMainlist(el) {
    document.getElementById("main-list-" + el).style.display = "block";
    document.querySelectorAll('[id^="sublist-"]').forEach(function(elem) {
      elem.style.display = "none";
    });
    document.getElementById("backButton-" + el).style.display = "none";
  }

  function resetMainlist() {
    document.querySelector('[id^="main-list"]').style.display = "block";
    document.querySelectorAll('[id^="sublist-"]').forEach(function(elem) {
      elem.style.display = "none";
    });
    // document.querySelectorAll('[id^="backButton-"]').forEach(function(elem) {
    //   elem.style.display = "none";
    // });
  }
  var modalElement = document.getElementById('exampleModal');
  var modalRent = document.getElementById('rentModal');
  var modalBuy = document.getElementById('buyModal');
  modalElement.addEventListener('hidden.bs.modal', function() {
    showMainlist('sell')
  });
  modalRent.addEventListener('hidden.bs.modal', function() {
    showMainlist('rent')
  });
  modalBuy.addEventListener('hidden.bs.modal', function() {
    showMainlist('buy')
  });



  var modalRentElement = document.getElementById('rentModal');
</script>

@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection