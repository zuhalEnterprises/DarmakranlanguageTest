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
    <section class="container ">
        <div class="w-lg-50 rounded border p-4 p-lg-5 m-auto mb-5">
            <p>
                {{ l('برای جلوگیری از ورود شماره موبایل متخلف و افزایش سلامت تعاملات، تایید هوییت در سایت کلبه انجام میشود.') }} <br>
                {{ l('حساب شما در سایت کلبه با شماره') }} <span>09377512584</span> {{ l('فعال است.') }}

            </p>
            <form id="singupBranch">
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center flex-wrap flex-lg-nowrap gap-lg-3">
                        <label for="nameMangement" class="form-label fw-bold w-100 w-lg-25">{{ l('نام مدیر آژانس') }}</label>
                        <input class="form-control form-control-sm w-100 w-lg-75" type="text" id="nameMangement" placeholder="{{ l('مثال: امین عارف زاده قمی') }}">
                    </div>
                    <div class="form-text">
                        {{ l('نام خود را طبق اطلاعات کارت ملی وارد کنید.') }}
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center flex-wrap flex-lg-nowrap gap-lg-3">
                        <label for="idNationality" class="form-label fw-bold w-100 w-lg-25">
                             {{ l('کد ملی') }}
                            </label>
                        <input class="form-control form-control-sm w-100 w-lg-75" type="number" id="idNationality" placeholder="{{ l('مثال: 0123456789') }}">
                    </div>
                    <div class="form-text">
                        {{ l('کد ملی 10 رقمی خود را وارد کنید.') }}
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center flex-wrap flex-lg-nowrap gap-lg-3">
                        <label for="telMangement" class="form-label fw-bold w-100 w-lg-25">
                             {{ l('شماره موبایل مدیر آژانس') }}
                        </label>
                        <input class="form-control form-control-sm w-100 w-lg-75" type="tel`" id="telMangement" placeholder="{{ l('مثال: 09384063644') }}">
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <label for="parvaneh" class="form-label fw-bold w-50 w-lg-25">{{ l('وضعیت پروانه کسب') }}</label>
                        <select class="form-select form-select-sm w-50 w-lg-75" id="parvaneh">
                            <option>{{ l('وضعیت پروانه کسب') }}</option>
                            <option>{{ l('به نام مدیر آژانس') }}</option>
                            <option>{{ l('به نام شخص دیگر') }}</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center flex-wrap flex-lg-nowrap gap-lg-3">
                        <label for="numberID" class="form-label fw-bold w-100 w-lg-25">{{ l('شناسه صنفی') }}</label>
                        <input class="form-control form-control-sm w-100 w-lg-75" type="text" id="numberID" placeholder="{{ l('مثال: 9876543210') }}">
                    </div>
                    <div class="form-text">
                        {{ l('شناسه صنفی آژانس املاک را وارد کنید. شناسه عددی 10 رقمی است که روی پروانه کسب نوشته شده است.') }}
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center flex-wrap flex-lg-nowrap gap-lg-3">
                        <label for="nameBranch" class="form-label fw-bold w-100 w-lg-25">{{ l('نام آژانس') }}</label>
                        <input class="form-control form-control-sm w-100 w-lg-75" type="text" id="nameBranch" placeholder="{{ l('مثال: دیوار') }}">
                    </div>
                    <div class="form-text">
                        {{ l('نام آژانس املاک خود را وارد کنید.') }}
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
                        <label for="typeBranch" class="form-label fw-bold w-50 w-lg-25">{{ l('نوع آژانس') }}</label>
                        <select class="form-select form-select-sm w-50 w-lg-75" id="typeBranch">
                            <option>{{ l('کفی') }}</option>
                            <option>{{ l('دپارتمانی') }}</option>
                            <option>{{ l('کفی / دپارتمانی') }}</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center flex-wrap flex-lg-nowrap gap-lg-3">
                        <label for="telBranch" class="form-label fw-bold w-100 w-lg-25">
                             {{ l('شماره تلفن ثابت آژانس') }}
                        </label>
                        <input class="form-control form-control-sm w-100 w-lg-75" type="tel`" id="telBranch" placeholder="{{ l('مثال: 02532886270') }}">
                    </div>
                    <div class="form-text">
                        {{ l('شماره تلفن ثابت آژانس را با کد شهر وارد کنید.') }}
                    </div>
                </div>
                
                <div class="mb-4 pb-2">
                    <div class="d-flex flex-wrap flex-lg-nowrap align-items-center gap-lg-3">
                        <label for="code-posti" class="form-label fw-bold w-100 w-lg-25">{{ l('آدرس پستی آژانس املاک') }}</label>
                        <textarea class="form-control form-control-sm w-100 w-lg-75" type="text" id="code-posti"></textarea>
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <label  class="form-label fw-bold w-50 w-lg-25">{{ l('موقعیت آژانس') }}</label>
                    </div>
                    <div class="form-text" >
                        {{ l('شهر و محله خود را انتخاب کنید. اگر در فهرست وجود ندارد، نزدیک ترین را انتخاب نمایید.') }}
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <label for="city" class="form-label fw-bold w-50 w-lg-25">{{ l('شهر') }}</label>
                        <select class="form-select form-select-sm w-50 w-lg-75" id="city">
                            <option>{{ l('قم') }}</option>
                            <option>{{ l('تهران') }}</option>
                            <option>{{ l('گیلان') }}</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <label for="city" class="form-label fw-bold w-50 w-lg-25">{{ l('محله') }}</label>
                        <select class="form-select form-select-sm w-50 w-lg-75" id="city">
                            <option>{{ l('زنبیل آباد') }}</option>
                            <option>{{ l('انسجام') }}</option>
                            <option>{{ l('صفاییه') }}</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <label  class="form-label fw-bold w-50 w-lg-25">{{ l('لوگو') }}</label>
                    </div>
                    <div class="form-text" >
                        {{ l('لوگوی آژانس املاک خود را برای نمایش در صفحه آگهی ها اضافه کنید. (اختیاری)') }}

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