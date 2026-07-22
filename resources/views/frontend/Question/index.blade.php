@extends('frontend.layouts.intro.appnew',['title'=>'پرسش و پاسخ '])

@section('head')
<link rel="stylesheet" href="{{asset('/mainpage/css/faq.css')}}">

@endsection
@section('main_content')
@include('frontend.layouts.header1')

<section class="search-box">
  <div class="search">
    <div class="container content-box my-3">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <ul class="breadcrumb">
            <li class="fw-bold"><a href="/">{{ l('خانه') }}</a></li>
            <li class="fw-bold">{{ l('پاسخ به سوالات پر تکرار') }}</li>
          </ul>
        </div>
        <div class="col-12 my-2">
          <div class="d-flex flex-column align-items-center">
            <i class="icon-faq icon-faq1 far fa-question-circle"></i>
            <h2 class="faq-title mb-3">{{ l('موضوع پرسش شما چیست؟') }}</h2>
            <p class="faq-sub">
              {{ l('موضوع موردنظرتان را جستجو کرده یا از دسته‌بندی زیر انتخاب کنید') }}
            </p>
          </div>
        </div>
        <div class="col-12">
          <form class="row row justify-content-center">
            <div class="col-md-6 col-sm-8 col-10 search-item">
              <input type="text" class="form-control input-faq" placeholder="{{ l('جستجو') }}">
              <button type="submit" class="btn-faq"><i class="fas fa-search"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="container">
  <div class="row justify-content-center">

    <div class="col-12 my-4">
      <div class="d-flex flex-column align-items-center">
        <i class="icon-faq fab fa-buromobelexperte"></i>
        <h2 class="faq-title">{{ l('دسته بندی پرسش ها') }}</h2>
      </div>
    </div>
  </div>
  <div class="container mb-4">
    <div class="row justify-content-center">
      <div class="col-md-3 col-sm-4 col-6 border faq-part">
        <a class="faq-box">
          <i class="far fa-user"></i>
          <h6>
            {{ l('ورود و ثبت نام') }}
          </h6>
        </a>
      </div>
      <div class="col-md-3 col-sm-4 col-6 border faq-part">
        <a class="faq-box">
          <i class="fas fa-house-user"></i>
          <h6>
            {{ l('ثبت نام شعبه') }}
          </h6>
        </a>
      </div>
      <div class="col-md-3 col-sm-4 col-6 border faq-part">
        <a class="faq-box">
          <i class="fas fa-id-card"></i>
          <h6>
            {{ l('ثبت نام کارشناس') }}
          </h6>
        </a>
      </div>
      <div class="col-md-3 col-sm-4 col-6 border faq-part">
        <a class="faq-box">
          <i class="fas fa-check-square"></i>
          <h6>
            {{ l('معاملات') }}
          </h6>
        </a>
      </div>
      <div class="col-md-3 col-sm-4 col-6 border faq-part">
        <a class="faq-box">
          <i class="fas fa-percentage"></i>
          <h6>
            {{ l('کارمزد') }}
          </h6>
        </a>
      </div>
      <div class="col-md-3 col-sm-4 col-6 border faq-part">
        <a class="faq-box">
          <i class="fas fa-users"></i>
          <h6>
            {{ l('دعوت از دوستان') }}
          </h6>
        </a>
      </div>
      <div class="col-md-3 col-sm-4 col-6 border faq-part">
        <a class="faq-box">
          <i class="fas fa-phone"></i>
          <h6>
            {{ l('پشتیبانی') }}
          </h6>
        </a>
      </div>
      <div class="col-md-3 col-sm-4 col-6 border faq-part">
        <a class="faq-box">
          <i class="fas fa-user-graduate"></i>
          <h6>
            {{ l('آکادمی') }}
          </h6>
        </a>
      </div>
    </div>
  </div>
  <div class="row mb-4 justify-content-center">
    <div class="col-12 my-4">
      <div class="d-flex flex-column align-items-center">
        <i class="icon-faq far fa-question-circle"></i>
        <h2 class="faq-title">{{ l('پرسش های متداول') }}</h2>
      </div>
    </div>
    <div class="col-12 mb-5">
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button class="fw-bold accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              {{ l('چرا به شماره سفارش (DKC) نیاز داریم؟') }}
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body text-muted2">
                {{ l('برای افزایش سرعت پاسخ گویی به مشتریان با دریافت کد سفارش یا همان کد "DKC " این امکان رو ایجاد کرده که بتونید در زمان کمتری به نتیجه مورد نظر خود برسید...') }}
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingTwo">
            <button class="fw-bold accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              {{ l('چطور درخواست خود را جهت بازگرداندن کالا (مرجوعی کالا) به شما اطلاع دهم؟') }}
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body text-muted2">
              {{ l('شما میتوانید از طریق فرم درخواست مرجوعی در حساب کاربری ، صفحه تماس با ما و تلفن درخواست خود را ثبت نمایید.') }}
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingThree">
            <button class="fw-bold accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              {{ l('شرایط گارانتی') }}  
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body text-muted2">
              {{ l('امروزه توجه به کیفیت کالا از مهمترین وظایف فروشندگان کالا است و خدمات پس از فروش ضامن حفظ این کیفیت می باشد. در همین راستا شرکت دیجی کالا مفتخر به ارائه سرویس در اسرع وقت به مشتریان گرامی می باشد. جهت سهولت در پیگیری گارانتی دستگاه خود می توانید از طریق شماره اقدام نمائید.') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@include('frontend.layouts.footer1',['cssClass'=>'intro'])
@endsection