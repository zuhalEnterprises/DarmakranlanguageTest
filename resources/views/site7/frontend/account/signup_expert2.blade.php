@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])
@section('head')
<style>

    .select2-hidden-accessible {
        width: auto !important;
    }
</style>
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
    <section class="container ">
        <div class="w-lg-50 rounded border p-4 p-lg-5 m-auto mb-5">
            <p>
                {{ l('برای جلوگیری از ورود شماره موبایل متخلف و افزایش سلامت تعاملات، تایید هوییت در سایت کلبه انجام میشود.') }} <br>
                {{ l('حساب شما در سایت کلبه با شماره') }} <span>09377512584</span> {{ l('فعال است.') }}

            </p>
            <form id="singupExpert">
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center flex-wrap flex-lg-nowrap gap-lg-3">
                        <label for="fullname" class="form-label fw-bold w-100 w-lg-25">{{ l('نام و نام خانوادگی') }}</label>
                        <input class="form-control form-control-sm w-100 w-lg-75" type="text" id="fullname">
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <label for="number-input" class="form-label fw-bold w-50 w-lg-25">{{ l('تایید با کد ملی') }}</label>
                        <input class="form-control form-control-sm w-50 w-lg-75" type="number" id="number-input">
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <label for="select-input" class="form-label fw-bold w-50 w-lg-25">{{ l('ملیت') }}</label>
                        <select class="form-select form-select-sm w-50 w-lg-75" id="select-input">
                            <option>{{ l('انتخاب ملیت') }}</option>
                            <option>{{ l('ایرانی') }}</option>
                            <option>{{ l('اتباع خارجی') }}</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex  align-items-center gap-lg-3 flex-wrap flex-lg-nowrap">
                        <label for="area-activity" class="form-label fw-bold w-100 w-lg-25">{{ l('محدوده فعالیت') }}</label>
                        <select class="select2 form-select form-select-sm w-100 w-lg-75" id="area-activity" multiple>
                            <option>{{ l('انتخاب محدوده') }}</option>
                            <option>{{ l('زنبیل آباد') }}</option>
                            <option>{{ l('پردیسان') }}</option>
                            <option>{{ l('صفاییه') }}</option>
                            <option>{{ l('باجک') }}</option>
                        </select>
                    </div>
                    <div class="form-text" >
                        {{ l('محدوده فعالیت خود را مشخص کنید. محدوده مشخص شده محل حدودی فعالیت شما را نشان میدهد.') }}
                    </div>
                </div>
                <div class="mb-4 pb-2 d-flex flex-wrap flex-lg-nowrap align-items-center gap-lg-3">
                    <label for="area-activity" class="form-label fw-bold w-100 w-lg-25">{{ l('ساعت کاری') }}</label>
                    <div class="d-flex flex-wrap flex-lg-nowrap align-items-center gap-3 w-100 w-lg-75">
                        <div class="d-flex align-items-center gap-3 w-100">
                            <label for="from-date" class="form-label fw-bold mb-0">{{ l('از') }}</label>
                            <select class="form-select form-select-sm " id="from-date">
                                <option>{{ l('7 صبح') }}</option>
                                <option>{{ l('8 صبح') }}</option>
                                <option>{{ l('9 صبح') }}</option>
                                <option>{{ l('10 صبح') }}</option>
                                <option>{{ l('11 صبح') }}</option>
                                <option>{{ l('12 ظهر') }}</option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center gap-3 w-100">
                            <label for="from-date" class="form-label fw-bold mb-0">{{ l('تا') }}</label>
                            <select class="form-select form-select-sm " id="from-date">
                                <option>{{ l('4 عصر') }}</option>
                                <option>{{ l('5 عصر') }}</option>
                                <option>{{ l('6 عصر') }}</option>
                                <option>{{ l('7 عصر') }}</option>
                                <option>{{ l('8 عصر') }}</option>
                                <option>{{ l('9 عصر') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex flex-wrap flex-lg-nowrap align-items-center gap-lg-3">
                        <label for="about-expert" class="form-label fw-bold w-100 w-lg-25">{{ l('درباره مشاور') }}</label>
                        <textarea class="form-control form-control-sm w-100 w-lg-75" type="text" id="about-expert"></textarea>
                    </div>
                    <div class="form-text" >
                        {{ l('در چند جمله فعالیت حرفه ای خود را به دیگران معرفی کنید.') }}
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <label  class="form-label fw-bold w-50 w-lg-25">{{ l('عکس') }}</label>
                    </div>
                    <div class="form-text" >
                        {{ l('عکس حرفه ای خود را برای نمایش در صفحه آگهی ها اضافه کنید.') }}

                    </div>
                </div>
                <div>
                    <button class="btn btn-primary w-100 w-lg-auto">{{ l('تایید و ثبت نام') }}</button>
                </div>
                
            </form>
        </div>
    </section>

    @endsection
    @section('js')
    
    <script>
        $('.select2').select2({})
    </script>

    @endsection