@extends('frontend.layouts.intro.appnew',['title'=>'اعلان ها '])
@section('head')
<style>
  .bg-aqua {
    background-color: #00C0EF;
  }

  .notif-box {
    border-bottom: 1px solid #cdcdcd;
    border-width: 80%;
  }

  .notif-box:last-child {
    border: 0;
  }

  .notif-body {
    width:80%;
  }

  .notif-history {
    width: 20%;
  }

  .notif-titr {
    font-size: 16px;
    font-weight: 800;
  }

  .notif-content {
    font-size: 15px;
  }

  .notif-link {
    text-decoration: none;
    background-color: #cdcdcd;
    width: 28px;
    height: 28px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 4px;
    color: #fff;
  }

  .notif-link:hover {
    background-color: #a7a7a7;
    color: #fff !important;
  }

  .notif-history {
    font-size: 14px;
  }

  .notif-footer {
    font-size: 15px;
  }

  @media (max-width: 600px) {


    .notif-body {
      width: 100%;
    }

    .notif-history {
      width: 100%;
    }
  }
</style>
@endsection
@section('main_content')
@include('frontend.layouts.header1')
<div class="container content-box my-3">
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <ul class="breadcrumb">
        <li><a href="/">{{ l('خانه') }}</a></li>
        <li><a href="/dashboard_v2">{{ l('داشبورد') }}</a></li>
        <li>{{ l('اعلان ها') }}</li>
      </ul>
    </div>
    <div class="col-lg-12">
      <header class=" d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
          {{ l('اعلان ها') }}
          <span class="badge count bg-aqua ">3</span>
        </div>
      </header>
    </div>

    <div class="col-lg-10 col-12">
      <div class="notif-box flex-wrap d-flex m-3">
        <div class="notif-body">
          <span class="badge bg-warning">{{ l('ویرایش') }}</span>
          <h3 class="notif-titr my-2">{{ l('ویرایش پروفایل') }}</h3>
          <p class="notif-content my-2">{{ l('لطفا پروفایل خود را کامل کانید!!!') }}</p>
          <p class="notif-footer fw-bold text-danger">{{ l('ادمین سایت') }}</p>
        </div>
        <div class="notif-history mb-3 text-muted text-left">
          <span><i class="far fa-clock"></i></span>
          <span>{{ l('22 شهریور 1400') }}</span>
          <span>15:30</span>
        </div>
      </div>
      <div class="notif-box flex-wrap d-flex m-3">
        <div class="notif-body">
          <span class="badge bg-danger">{{ l('پیام فوری') }}</span>
          <h3 class="notif-titr my-2">{{ l('اصلاح قوانین سایت') }}</h3>
          <p class="notif-content my-2">{{ l('قوانین سایت در راستای مشتری مداری تغییر کرده و لطفا صفحه قوانین مرور کنید') }}</p>
          <p class="notif-footer fw-bold text-danger">{{ l('ادمین سایت') }}</p>
        </div>
        <div class="notif-history mb-3 text-muted text-left">
          <span><i class="far fa-clock"></i></span>
          <span>{{ l('22 شهریور 1400') }}</span>
          <span>15:30</span>
        </div>
      </div>
      <div class="notif-box flex-wrap d-flex m-3">
        <div class="notif-body">
          <span class="badge bg-primary">{{ l('پیام خصوصی') }}</span>
          <h3 class="notif-titr my-2">{{ l('خرید خانه') }}</h3>
          <p class="notif-content my-2">{{ l('لطفا شرایط خانه آگهی شده را ارسال کنید') }}</p>
          <p class="notif-footer fw-bold text-danger">{{ l('کارشناس') }}</p>
        </div>
        <div class="notif-history mb-3 text-muted text-left">
          <span><i class="far fa-clock"></i></span>
          <span>{{ l('22 شهریور 1400') }}</span>
          <span>16:30</span>
        </div>
      </div>
    </div>

  </div>
</div>


@include('frontend.layouts.footer1',['cssClass'=>'intro'])
@endsection
