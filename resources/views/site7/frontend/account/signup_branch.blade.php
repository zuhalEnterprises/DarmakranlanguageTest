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
                        <li class="breadcrumb-item active" aria-current="page">{{l('ثبت نام  آژانس املاک ')}}</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>
    <section class="container">
        <div class=" m-auto  border p-3 p-lg-4 col-lg-4 rounded">

            <p>
                {{ l('کاربر محترم کلبه با استفاده از این پنل از مزایای زیر بهره مند می‌شوید:') }}
            </p>
            <h3 class="fs-5">
                {{ l('مدیریت مشاوران املاک') }}
            </h3>
            <p>
                {{ l('می توانید به تعداد نامحدود مشاور به پنل خود اضافه کنید و به آنها به صورت روزانه یا ماهانه سهمیه کیف پول اختصاص دهید.') }}
            </p>
            <h3 class="fs-5">
                {{ l('بررسی فوری آگهی های ثبت شده') }}
            </h3>
            <p>
                {{ l('آگهی های ثبت شده در پنل املاک سریع تر از بقیه آگهی ها بررسی و منتشر میشوند.') }}
            </p>
            <h3 class="fs-5">
                {{ l('نردبان گروهی آگهی ها') }}
            </h3>
            <p>
                {{ l('با نردبان گروهی آگهی ها تنها با یک کلیک آگهی های خود را در صدر لیست های دیوار نگه دارید.') }}
            </p>
            <h3 class="fs-5">
                {{ l('گزارش مصرف مشاوران') }}
            </h3>
            <p>
                {{ l('میزان مصرف آگهی و نردبان مشاوران و همینطور آمار بازدید آگهی های منتشر شده را بررسی کنیدو') }}
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
        {{ l('ثبت نام پنل آژانس فقط با شماره موبایل و اطلاعات شخصی مدیر آژانس املاک امکان پذیر است') }}
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ l('بستن') }}</button> -->
        <a href="" type="button" class="btn btn-primary">{{ l('متوجه شدم') }}</a>
      </div>
    </div>
  </div>
</div>
    @endsection
    @section('js')




    @endsection