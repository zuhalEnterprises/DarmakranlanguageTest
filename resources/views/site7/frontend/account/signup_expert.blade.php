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

            <!-- Page content-->
            <div class="main col-12 position-relative overflow-hidden px-3">
                <!-- Breadcrumb-->
                <nav class="pt-2 pt-lg-5" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item"><a href="/">{{l('ثبت نام پنل املاک ')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{l('ثبت نام  مشاور املاک ')}}</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>
    <section class="container">
        <div class=" m-auto  border p-3 p-lg-4 col-lg-4 rounded">

            <p>{{ l('مشاور عزیز، با استفاده از پنل مشاور املاک دیوار از مزایای زیر بهره مند می شوید:') }}</p>
            <h3 class="fs-5">
                {{ l('ثبت نام آنی پنل') }}
            </h3>
            <p>
                {{ l('با صرف زمانی اندک در پنل مشاور ثبت نام و از همان لحظه شروع به فعالیت کنید.') }}
            </p>
            <h3 class="fs-5">
                {{ l('صفحه مشاور') }}
            </h3>
            <p>
                {{ l('امکان به اشتراک گذاری تمام آگهی ها و اطلاعات خود با مشتریان را خواهید داشت') }} <br>{{ l('و نام، عکس و لینک به صفحه شما در تمام آگهی های تان نمایش داده می شود.') }}
            </p>
            <a href="#" class="btn btn-primary w-100 w-lg-auto px-5" data-bs-toggle="modal" data-bs-target="#sigup">{{ l('ثبت نام') }}</a>

        </div>
    </section>

<!-- Modal -->
<div class="modal fade" id="sigup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ l('تایید هویت') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ l('قبل از ثبت نام پنل مشاور یا پنل املاک، لازم است هویت خود را تایید کنید.') }} <br>
        {{ l('برای جلو گیری از ورود شماره موبایل متخلف و افزایش سلامت تعاملات، تایید هویت در سایت کلبه انجام میشود.') }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ l('بستن') }}</button>
        <a href="" type="button" class="btn btn-primary">{{ l('تایید هویت') }}</a>
      </div>
    </div>
  </div>
</div>
    @endsection
    @section('js')




    @endsection