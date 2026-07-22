@extends('frontend.layouts.intro.appnew',['title'=>'بازیابی رمز ورود'])
@section('body_class','confirmation')
@section('head')
    <style>
        input{font-size: .95rem !important;}
        .dir-left{ direction: ltr !important;}
        .border-bottom-dashed{border-bottom:1px dashed #1ca2bd;}
    </style>
@endsection
@section('main_content')
    @include('frontend.layouts.header1')

    <div class="container py-4" style="min-height: 480px">
        <div class="row">

            <div class="border-0 card col-xl-4 col-lg-6 col-md-6 offset-xl-4 offset-lg-3 offset-md-3 py-4 shadow-lg">

                <div class="content">
                    <h5 class="mb-4 mt-2 text-center text-warning">{{ l('بازیابی رمز ورود') }}</h5>

                    <form id="frm-forget" class="form-horizontal" method="POST" action="{{ ('/forget_password') }}">
                        @csrf

                        <div class="col-xs-12 form-control-lg input-group-sm">

                            <label class="form-label text-muted" for="username">{{ l('شماره موبایل (نام کاربری)') }}</label>
                            <input type="tel" name="username"
                                   class="form-control form-control-lg dir-left username-tel" id="username"
                                   pattern="[0-9]{11}" maxlength="11"
                                   placeholder="{{ l('شماره موبایل') }}" autocomplete="off"
                                   autocorrect="off" autocapitalize="off" spellcheck="false" required
                                   oninvalid="this.setCustomValidity(l('شماره موبایل نامعتبر است!'))"
                                   oninput="setCustomValidity('')">

                            @if ($errors->has('user'))
                                <span class="border-0 form-control help-block text-danger">{{ $errors->first('user') }}</span>
                            @endif

                            <div class="d-flex justify-content-around">
                                <button type="submit" class="btn btn-primary mt-2">{{ l('ارسال کد') }}</button>
                            </div>
                        </div>
                    </form>

                    <div class="col-xs-12 form-control-lg input-group-sm">
                    <div class="mt-1" style="display:flex;flex-direction: row;justify-content: space-between;align-items: center">
                        <div class="font_10 headline"><i class="fa-sign-in far text-info"></i> <a href="/login" class="border-bottom-dashed">{{ l('ورود به حساب کاربری') }}</a></div>
                        <div class="font_10 headline"><i class="far fa-plus text-info"></i> <a href="/login" class="border-bottom-dashed">{{ l('ایجاد حساب کاربری') }}</a></div>
                    </div>
                    </div>

                </div>


            </div>

        </div>
    </div>

    @include('frontend.layouts.footer1')

@endsection
@section('js')
    <script type="text/javascript">
        function parseArabic(str) { return Number( str.replace(/[٠١٢٣٤٥٦٧٨٩]/g, function(d) { return d.charCodeAt(0) - 1632; // Convert Arabic numbers }).replace(/[۰۱۲۳۴۵۶۷۸۹]/g, function(d) { return d.charCodeAt(0) - 1776; // Convert Persian numbers }) ); } function toPersianNum( num, dontTrim ) { var i = 0, dontTrim = dontTrim || false, num = dontTrim ? num.toString() : num.toString().trim(), len = num.length, res = '', pos, persianNumbers = typeof persianNumber == 'undefined' ? ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'] : persianNumbers; for (; i < len; i++)
                if (( pos = persianNumbers[num.charAt(i)] ))
                    res += pos;
                else
                    res += num.charAt(i);

            return res;
        }

        // validate mobile number
        $('form').submit(function(){
            var formId = $(this).attr('id');
            var mobile = $('#'+formId+' .username-tel').val();

            if(mobile.trim() == '' || mobile == null){
                $('#'+formId+' .username-tel').focus();
                alert(l('شماره موبایل الزامیست!'));
                return false;
            }

            var latinNum = parseArabic(mobile);
            latinNum = '0'+latinNum;
            if(!latinNum.match(/^0(9|4)\d{9}$/)){
                $('#'+formId+' .username-tel').val('');
                alert(l('شماره موبایل نامعتبر است!'));
                return false;
            }
        });

        $('form#frm-forget').on('submit', function() {
            var mob = $("#mobtel").val();
            var latinNum = convertNumbers2English(mob);
            $("#username").val(latinNum);

            e.preventDefault();
        });

        $(".username-tel").on("keypress keyup blur",function (event) {
            $(this).val($(this).val().replace(/[^\d|\u06F0-\u06F9].+/, ""));

            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

    </script>
@endsection
