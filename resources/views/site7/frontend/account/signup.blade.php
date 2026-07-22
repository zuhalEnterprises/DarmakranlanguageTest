@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])
@section('head')
@endsection
@section('main_content')
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')
    <div class="container mt-5 pt-2 p-0">
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
                        <li class="breadcrumb-item active" aria-current="page">{{l('ثبت نام پنل املاک ')}}</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>
    <section class="container">
        <div class="d-flex flex-column gap-4 align-items-center">
            <a href="/profile/branches/create" class="d-inline-flex align-items-center gap-2 gap-lg-3 border rounded p-3 col-12 col-lg-5">
                <div class="icon-box p-2">
                    <div class="icon-box-media mb-3" style="background-image: url('/img/site7/agency1.1c62ce59.svg');"></div>
                </div>
                <div>
                    <h3 class="icon-box-title fs-base icon-box-title">{{ l('پنل آژانس املاک') }}</h3>
                    <p class="fs-sm mb-0 text-dark">{{ l('این پنل برای آژانس‌های املاک کفی و دپارتمانی که حداقل ۲ مشاور دارند مناسب است.') }}</p>
                </div>
                <i class="fi-chevron-right me-auto text-dark"></i>
            </a>
            <a href="/profile/users/create" class="d-inline-flex align-items-center gap-2 gap-lg-3 border rounded p-3 col-12 col-lg-5">
                <div class="icon-box p-2">
                    <div class="icon-box-media mb-3" style="background-image: url('/img/site7/agency1.1c62ce59.svg');"></div>
                </div>
                <div>
                    <h3 class="icon-box-title fs-base icon-box-title">{{ l('پنل مشاور املاک') }}</h3>
                    <p class="fs-sm mb-0 text-dark">{{ l('این پنل برای مشاوران املاک مستقل و کاربران پرمصرف کلبه مناسب است.') }}</p>
                </div>
                <i class="fi-chevron-right me-auto text-dark"></i>
            </a>
        </div>
    </section>

    @endsection
    @section('js')




    @endsection
