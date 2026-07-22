@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',['title'=> l('ورود و ثبت نام')])
@section('body_class','login')
@section('head')
<!--meta http-equiv="refresh" content="300;{{ route('login') }}" /-->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/mainpage/css/login.css">
@endsection
@section('main_content')
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2')
    <section class="container-fluid my-5 pt-5 pb-lg-4 px-xxl-4">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 p-0">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <button data-dismiss="alert" class="btn-close pull-left" type="button"></button>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
        <div class="card-login-box">
            <div class="card-login">
                <header id="frm-head" class="header-holder pos-abs pt-4 px-4" style="display: none">
                    <button class="anc-rtn bg-white border-0 p-0"><i class="far fa-arrow-right icon-back"></i></button>
                </header>
                <div class=" my-2 text-center">
                    <div id="frm-title" class=" login-form-header mt-3 px-4">
                        {{l('ورود')}} / {{l('ثبت‌نام')}}
                    </div>
                    <div id="frm-title2" class="login-form-header2 mt-3 px-4"></div>
                </div>
                <div id="frm-register" class="form-horizontal">
                    {{-- step login --}}
                    <div class="step-login">
                        <div class="col-xs-12 form-control-lg input-group-sm mb-3">
                            <label class="form-label form-login-label">{{l('لطفا شماره موبایل خود را وارد کنید')}}</label>
                            <input type="text" name="username" class="form-control form-control-lg dir-left username-tel border-raduis" maxlength="20" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
                            <div id="login-error" class="error login-error text-danger"><span></span></div>
                        </div>
                        <div class="col-xs-12 form-control-lg text-center mb-3">
                            <button type="submit" id="login-submit" class="btn btn-block btn-primary justify-content-center text-center w-100 border-raduis">
                                <span class="login-enter"  id="login-enter">{{l('ورود')}}</span>
                                <span class="spinner-border spinner-border-sm me-2" style="display: none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    {{-- step password --}}
                    <div class="step-password" style="display: none">
                        <div class="col-xs-12 form-control-lg input-group-sm">
                            <label class="form-label form-login-label">{{l('رمز عبور شماره')}} <label id="txtmobile"></label> {{l('را وارد کنید')}}</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg dir-left codepass" minlength="6" autocomplete="off" autocapitalize="off" spellcheck="false">
                            <div id="password-error" class="error input-error text-danger"><span></span></div>
                        </div>
                        <!--div class="col-xs-12 form-control-lg input-group-sm">
                            <button type="button" class="btn  acn-code">
                                <i class="fa-chevron-left far" style="color: #A3A3A3;margin-left:10px"></i>
                                <span class="pl-2 link-info">{{l('ورود با رمز یک‌بار مصرف')}}</span>
                            </button>
                        </div>
                        <div class="col-xs-12 form-control-lg input-group-sm">
                            <button type="button" class="btn  acn-forget">
                                <i class="fa-chevron-left far" style="color: #A3A3A3;margin-left:10px"></i>
                                <span class="pl-2 link-info">{{l('بازیابی رمز عبور')}}</span>
                            </button>
                        </div-->
                        <div class="col-xs-12 form-control-lg text-center">
                            <button type="submit" id="btn-password" class="btn-submit btn btn-block btn-primary d-block text-center w-100 login-enter border-raduis" disabled>{{l('ادامه')}}</button>
                        </div>
                    </div>
                    {{-- step verify cde --}}
                    <div class="step-code" style="display: none">
                        <div class="col-xs-12 form-control-lg input-group-sm">
                            <label class="form-label text-muted">{{l('کد تایید را وارد کنید')}}</label>
                            <input type="tel" name="code" id="verify-code" class="form-control form-control-lg dir-left codepass" autocomplete="off" autocapitalize="off" spellcheck="false">
                            <div id="code-error" class="error input-error text-danger"><span></span></div>
                            <div class="mt-1" style="display:flex;flex-direction: row;justify-content: space-between;align-items: center">
                                <div class="headline"><button id="sendAgainLink" class="acn-code font_11 btn link-info m-0 p-0 text-black-50 border-raduis" type="button" disabled>{{ l('ارسال مجدد کد تایید') }}</button></div>
                                <div class="headline">
                                    <div id='theTarget'></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 form-control-lg text-center">
                            <button type="submit" id="btn-code" class="btn-submit btn btn-block btn-primary d-block text-center w-100 login-enter border-raduis" disabled>{{l('ادامه')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@section('js')
<script>
    var timer,
        latinMobile = 0,
        stepLogin = $('.step-login'),
        stepPassword = $('.step-password'),
        stepCode = $('.step-code'),
        formHeader = $('#frm-head'),
        loginMethod = 0,
        currentStep = 'password',
        inputLength; //min length
    $(document).ready(function() {
        $('.username-tel').focus();
        //elm.val('').addClass('border-danger').focus();
        $('.codepass').val('');
    });
    @if(env('COUNTRY') != 'UAE')
    $(".username-tel,input#verify-code").on("keypress keyup blur", function(event) {
        $(this).val($(this).val().replace(/[^\d|\u06F0-\u06F9].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if (loginMethod == '2' && $(this).val().trim().length > inputLength) {
            $('.btn-submit').prop('disabled', false);
        } else {
            $('.btn-submit').prop('disabled', true);
        }
    });
    @endif
    $("input#password").on("keypress keyup blur", function(event) {
        if (loginMethod == '1' && $(this).val().trim().length > inputLength) {
            $('.btn-submit').prop('disabled', false);
        } else {
            $('.btn-submit').prop('disabled', true);
        }
    });
    $('#password').keyup(function(e) {
        if (e.keyCode == 13) {
            $("#btn-password").trigger('click');
        }
    });
    $('.username-tel').keyup(function(e) {
        if (e.keyCode == 13) {
            $("#login-enter").trigger('click');
        }
    });
    $('#verify-code').keyup(function(e) {
        if (e.keyCode == 13) {
            $("#btn-code").trigger('click');
        }
    });
    $(document).on('click', '#login-submit', function() {
        $('.input-error span').text('');
        $(this).prop('disabled', true);
        $('.spinner-border').show();
        $("#txtmobile").html($(".username-tel").val());
        // }
        //$(this).children('span').text(l('در حال ارسال ...'));
        // var userTel = $('.username-tel')
        // if (userTel.val() == 0){
        //     $('.input-error span').text(l('خالی است'))
        // }
        var elm = $('.username-tel');
        loginByMobile(elm);
    });
    $(document).on('click', '.anc-rtn', function() {
        formHeader.hide();
        stepLogin.show();
        stepPassword.hide();
        stepCode.hide();
        $('.username-tel,.codepass').val('');
        $('.input-error span').text('');
        $('.spinner-loader').hide();
        $('#login-submit').prop('disabled', false);
        $('.btn-submit').prop('disabled', true);
        $('#frm-title').html('{{l('ورود / ثبت‌نام')}}');
    });
    // send code
    $(document).on('click', '.acn-code', function() {
        $('.input-error span').text('');
        $(this).prop('disabled', true).removeClass('text-decoration-underline').addClass('text-black-50');
        verifyMobile(latinMobile, 0, 2);
    });
    // forget password
    $(document).on('click', '.acn-forget', function() {
        $('.input-error span').text('');
        $(this).prop('disabled', true);
        verifyMobile(latinMobile, 1, 2);
    });
    $(document).on('click', '.btn-submit', function(event) {
        $(this).prop('disabled', true);
        var inputTarget = $('input[name="' + (loginMethod == '1' ? 'password' : 'code') + '"]');
        if (inputTarget.val().trim().length > inputLength) {
            verifyCode(latinMobile, inputTarget.val(), loginMethod);
        }
    });
    function verifyMobile(telNum, forgetStatus, loginType) {
        $.ajax({
            type: 'POST',
            url: '/verify_mobile',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            data: {
                _method: 'post',
                mobile: telNum,
                forget_pass: forgetStatus,
                login_type: loginType
            },
            error: function(xhr, status, error) {
                var obj = JSON.parse(xhr.responseText);
                console.log('error', obj);
                if (obj.status === 'Error') {
                    $('.login-error span').text(obj.message);
                    $('.username-tel').val('');
                    $('#login-submit').prop('disabled', false);
                    return false;
                }
                return true;
            },
            success: function(response) {
                console.log('success', response);
                $('.spinner-loader').hide();
                $('#login-submit').prop('disabled', false);
                $('.login-error span').text('');
                var status = response.status;
                if (status === 'Success') {
                    var res = response.data;
                    var registerStatus = res.register;
                    var forgetStatus = res.forget_status;
                    var hasPassword = res.has_password;
                    var loginType = res.login_type;
                    loginMethod = res.login_type;
                    inputLength = loginMethod == '1' ? 5 : 4;
                    $('.codepass').val('');

                    $('.btn-submit').prop('disabled', true);
                    stepLogin.hide();
                    stepPassword.hide();
                    stepCode.hide();
                    if (registerStatus == '1' || hasPassword == '0' || loginType == 2) {
                        stepCode.show();
                        var telNumber = $('.username-tel').val()
                        $('#frm-title').html('{{l('کد تایید')}}');
                        @if (env('COUNTRY') == 'UAE')
                        $('#frm-title2').html('{{l('کد تایید ارسال شد')}}');
                        @else
                        $('#frm-title2').html('کد تایید به شماره ' + telNumber + l('ارسال شد'));
                        @endif
                        // timer for send again
                        clearInterval(timer);
                        setTimer(90);
                    }
                    else if (registerStatus == '0' && hasPassword == '1' || loginType == 1) {
                        stepPassword.show();
                        $('#frm-title').html('{{l('رمز عبور را وارد کنید')}}');
                        $(".step-password .acn-code,.step-password .acn-forget").prop('disabled', false).removeClass('text-black-50');
                    }
                    // form header contains back button
                    formHeader.show();
                    $('.codepass').focus();
                    return true;
                }
                return false;
            }
        });
    }
    function verifyCode(telNum, code, loginType) {
        $.ajax({
            type: 'POST',
            url: '/verify_code',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            data: {
                _method: 'post',
                mobile: telNum,
                code: code,
                login_type: loginType
            },
            error: function(xhr, status, error) {
                var obj = JSON.parse(xhr.responseText);
                console.log(obj);
                if (obj.status === 'Error') {
                    $('.input-error span').text(obj.message);
                    $('.codepass').val('');
                    return false;
                }
                return true;
            },
            success: function(response) {
                $('.input-error span').text('');
                var status = response.status;
                var hasPassword = response.data.has_password;
                var callback = response.data.callback;
                console.log(response);
                if (status === 'Success') {
                    if (callback != '' && callback !== undefined && callback !== null) {
                        window.location.href = callback;
                        return true;
                    }
                    return true;
                }
                return false;
            }
        });
    }
    function validMobileNumber(mobileNum) {
        @if(env('COUNTRY') != 'UAE')
        if (mobileNum.replace(/\s/g, "").length < 11) {
            return false;
        }
        @endif
        latinMobile = parseArabic(mobileNum);
        @if(env('COUNTRY') != 'UAE')
        latinMobile = '0' + latinMobile;
        if (!latinMobile.match(/^0(9|4)\d{9}$/)) {
            return false;
        }
        @else
        latinMobile = '+' + latinMobile;
        @endif
        return true;
    }
    function loginByMobile(elm) {
        var mobile = elm.val();
        var validateStatus = validMobileNumber(mobile);
        if (mobile == 0) {
            elm.val('').addClass('border-danger').focus();
            $('.login-error span').text('{{l('لطفا شماره موبایل خود را وارد کنید !')}}');
            $('#login-submit').prop('disabled', false);
            $('.spinner-loader').hide();
            return false;
        }
        if (validateStatus == false) {
            //elm.val('').addClass('border-danger').focus();
            $('.login-error span').text('{{l('شماره موبایل نامعتبر است!')}}');
            $('#login-submit').prop('disabled', false);
            $('.spinner-loader').hide();
            return false;
        }
        verifyMobile(mobile, 0)
    }
    function toPersianNum(num, dontTrim) {
        var i = 0,
            dontTrim = dontTrim || false,
            num = dontTrim ? num.toString() : num.toString().trim(),
            len = num.length,
            res = '',
            pos,
            persianNumbers = typeof persianNumber == 'undefined' ? ['۰', l('۱'), l('۲'), l('۳'), l('۴'), l('۵'), l('۶'), l('۷'), l('۸'), l('۹')] :
            persianNumbers;
        for (; i < len; i++)
            if ((pos = persianNumbers[num.charAt(i)]))
                res += pos;
            else
                res += num.charAt(i);
        return res;
    }
    function parseArabic(str) {
        return Number(str.replace(/[٠١٢٣٤٥٦٧٨٩]/g, function(d) {
            return d.charCodeAt(0) - 1632; // Convert Arabic numbers
        }).replace(/[۰۱۲۳۴۵۶۷۸۹]/g, function(d) {
            return d.charCodeAt(0) - 1776; // Convert Persian numbers
        }));
    }
    var counter=90;
    function setTimer(counter) {
        setTimeout(function () {
            $("#theTarget").html(counter+' ثانیه زمان باقی مانده است. ');
            counter= parseInt(counter) - 1;
            if (counter!=0) {
                setTimer(counter);
            }
            else {
                $("#sendAgainLink").prop('disabled', false).removeClass('text-black-50').addClass('text-decoration-underline');
                clearInterval(timer);
            }
            }, 1000);
    }
</script>
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
