@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',['title'=>'ثبت نام کارشناس | '])
@section('head')
<link rel="stylesheet" media="screen" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css" />
@endsection

@section('main_content')
<!-- main -->
<main class="page-wrapper">
    <!-- Navbar-->
    @include(ss('THEME').'.frontend.layouts.header_v2')

    <!-- Page container-->
    <div class="container mt-5 mb-md-4 py-5">
        <!-- Page content-->
        <div class=" mb-5 account add-property">
            <!-- Breadcrumb-->
            <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ l('ثبت نام کارشناس') }}</li>
                </ol>
            </nav>
            <!-- Title-->
            <div class="mb-4">
                <h1 class="h2 mb-0">{{ l('ثبت نام کارشناس') }}</h1>
            </div>
            @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
            <form class="container grid grid-cols-1 md:grid-cols-2 gap-6 " id="js_singup-expert" method="post" action="/agent/register">
                @csrf
            <!-- Basic info-->
            <section class="card card-body shadow-sm rounded p-4 mb-4" id="basic-info">
                <h2 class="h5 mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>
                    {{ l('اطلاعات کارشناس (اطلاعات هویتی مطابق با شناسنامه باید باشد)') }}
                </h2>
                @if(!empty($agent) && $agent->status==4)
            {{-- زمانی که کاربر احراز باشکست روبرو میگردد  --}}
            <div class="flex items-center justify-center border border-[#f9a51a75] min-h-[59px] py-2 px-4 bg-[#f9a51a0a] rounded-2xl">

                <p class="text-gray-500">
                    {{$agent->{{ l('fullname() . \' عزیز، اطلاعاتی که در زیر مشخص شده است، نیازمند ویرایش توسط شماست، بعد از انجام ویرایش و ثبت اطلاعات، کارشناسان ما دوباره اطلاعات شما را بررسی خواهند کرد.\'}}') }}
                    <br>
                    @if(!$agent_authentications->{{ l('IdCode) - کدملی') }}<br>
                    @endif
                    @if(!$agent_authentications->{{ l('Name) - نام') }}<br>
                    @endif
                    @if(!$agent_authentications->{{ l('Family) - نام‌خانوادگی') }}<br>
                    @endif
                    @if(!$agent_authentications->{{ l('FatherName) - نام‌پدر') }}<br>
                    @endif
                    @if(!$agent_authentications->{{ l('Mobile) - تلفن‌همراه') }}<br>
                    @endif
                </p>
            </div>
            @endif
            @if(!empty($agent) && $agent->status==1)
            {{-- زمانی که کاربر احراز هویت شده است  --}}
            <div class="flex items-center justify-center border border-green-600 min-h-[59px] py-2 px-4 bg-green-200/[.06] rounded-2xl">
                <p class="text-green-600">
                    {{$agent->{{ l('fullname() . \' عزیز ثبت نام شما با موفقیت انجام شد. ایّام پررونقی را برای شما آرزومندیم\'}}') }}
                </p>
            </div>
            @elseif(session()->has('hasBranch') && session('hasBranch') == 1)
            {{-- زمانی که کاربر درخواست ثبتنام شعبه هم داده باشد --}}
            <div class="flex flex-col items-center justify-center border border-green-600 min-h-[59px] py-2 px-4 bg-green-200/[.06] rounded-2xl ">
                <!-- <i class="fa fa-check-circle" style="display: inline-block;"></i> -->
                <p class="text-green-600">{{session('message')}}</p>
                <div class="text-gray-500 text-center" id="branch-register">
                    <span>{{ l('در صورت تمایل میتوانید بعنوان بنگاه همکار در کاما عضو شوید') }}</span>
                    <a class="text-blue-500" href="{{url('/branch/register')}}">{{ l('ثبت نام') }}</a>
                </div>
            </div>
            @elseif(!empty($agent) && $agent->status==-1)

            {{-- زمانی که کاربر قبلا بعنون کارشناس ثبت نام کرده است  --}}
            <div class="flex items-center justify-center border border-green-600 min-h-[59px] py-2 px-4 bg-green-200/[.06] rounded-2xl">
                <!-- <i class="fa fa-exclamation-circle" style="display: inline-block;"></i> -->
                <p class="text-green-600">
                    {{$agent->{{ l('fullname() . \' عزیز، اطلاعات شما توسط کارشناسان ما در حال بررسی است. به زودی نتیجه از طریق پیامک به اطلاع شما خواهد رسید.\'}}') }}
                </p>
            </div>

            @else

            {{-- شروع صفحه فرم ثبت نام کارشناس --}}

            {{-- نمایش خطاها بعد از ارسال فرم --}}
            @if ($errors->any())
            <div class="row">
                <div class="bg-danger mb-3">
                    @foreach ($errors->all() as $error)
                    <p class="text-[17px] font-medium text-red-500">{{ $error }}</p>
                    @endforeach
                </div>
            </div>


            @endif

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="form-label fw-bold" for="ap-name">{{ l('نام') }}<span
                                class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="first_name" id="first_name" value="{{$user->first_name ?? ''}}" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="form-label fw-bold" for="ap-lastName">{{ l('نام خانوادگی') }}<span
                                class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="last_name" id="last_name" value="{{$user->last_name ?? ''}}" required>
                    </div>
                    <!--div class="col-sm-6 mb-3">
                        <label class="form-label fw-bold" for="ap-fatherName">{{ l('نام پدر') }}<span
                                class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="father_name" id="father-name" value="{{$user->father_name ?? ''}}" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="form-label fw-bold" for="ap-fatherName">{{ l('کد ملی') }}<span
                                class="text-danger">*</span></label>
                        <input class="form-control" type="tel" name="national_code" id="national-code" value="{{$user->national_code ?? ''}}" required>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <label class="form-label fw-bold" for="ap-date">{{ l('تاریخ تولد') }}<span
                            class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ap-date" />
                    </div-->



                </div>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="form-label fw-bold">{{ l('استان محل فعالیت') }}<span
                            class="text-danger">*</span></label>
                        <select id="province_id" name="province_id" class="form-control " required cus-valid="true">
                            <option value="">{{ l('انتخاب استان') }}</option>
                            @foreach($provinces as $province)
                            <option value="{{$province->id}}" {{!empty($user)?($user->province_id==$province->id?'selected="true"':''):($province->id==19?'selected="true"':'')}}>{{$province->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="form-label fw-bold">{{ l('شهر محل فعالیت') }}<span
                            class="text-danger">*</span></label>
                        <select name="city_id" id="city_id" class="form-control " required cus-valid="true">
                            <option selected value="">{{ l('انتخاب شهر') }}
                            </option>
                        </select>
                    </div>
                </div>


            </section>

            <!-- Action buttons -->
            <section class="d-sm-flex justify-content-between pt-2">
                <button type="submit" class="btn btn-primary btn-lg d-block mb-2">
                     {{ l('ثبت کارشناس') }} </button>
            </section>
            </form>
            @endif
        </div>
    </div>
</main>

@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
@section('js')
    <!-- Main theme script-->
    <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js" ></script>
    <script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js" ></script>

<script>
    $(document).ready(function() {
        $("#ap-date").pDatepicker({
        initialValue: false,
        format: 'YYYY-MM-DD'
        });
    });

$(document).ready(function() {
    city_request($('#province_id').val());


    $("#js_btn_step_1").click(function() {
        var birthday = $('.js_year').val() + "/" + $('.js_month').val() + "/" + $('.js_day').val();
        $("#birthday").val(birthday);
    });



});
$('select#province_id').on('change', function() {
    var provinceId = this.value;

    city_request(provinceId);
});

function city_request(province_id, city_id) {
    $.get("/api/provinces/" + province_id + "/cities", function(data, status) {
        if (data.status) {
            $('select#city_id').append('<option value="" selected disabled>Ø§Ù†ØªØ®Ø§Ø¨ Ú©Ù†ÛŒØ¯</option>');
            var str = "";
            $.each(data.result, function(i, item) {
                str += "<option value=" + i + " >" + item + "</option>";
            });
            $('select#city_id').html(str);

            if (city_id) {
                $("select#city_id option[value='" + city_id + "']").prop('selected', true);
            }
        }
    });
}
</script>
@endsection
