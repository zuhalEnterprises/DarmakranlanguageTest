@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',['title'=> l('ورود و ثبت نام')])
@section('body_class','login')
@section('head')
<meta http-equiv="refresh" content="300;{{ route('login') }}" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/mainpage/css/login.css">
@endsection
@section('main_content')
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2')

    <section class="d-flex container-fluid my-5 pt-5 pb-lg-4 px-xxl-4 justify-content-center align-items-center">

        <div class="card card-body" style="max-width: 940px">
            <div class="row mx-0 align-items-center">
                <div class="col-md-6 border-end-md p-2 p-sm-5">
                    <h2 class="h3 mb-4 mb-sm-5">Hey there!<br>Welcome back.</h2>
                    <img class="d-block mx-auto" src="img/signin-modal/signin.svg" width="344" alt="Illustartion">
                    <!--div class="mt-4 mt-sm-5 ">Don't have an account? <a href="#">Sign up here</a></div-->
                </div>
                <div class="col-md-6 px-2 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">

                    <!--a class="btn btn-outline-info w-100 mb-3" href="#">
                        <i class="fi-google fs-lg me-1"></i>Sign in with Google
                    </a>
                    <a class="btn btn-outline-info w-100 mb-3" href="#">
                        <i class="fi-facebook fs-lg me-1"></i>Sign in with Facebook
                    </a>
                    <div class="d-flex align-items-center py-3 mb-3">
                    <hr class="w-100">
                    <div class="px-3">Or</div>
                    <hr class="w-100">
                    </div-->
                    <form class="needs-validation" novalidate method="POST" action="{{ route('login2') }}">
                        {{ csrf_field() }}
                        <div class="mb-4">
                            <label class="form-label mb-2" for="username">Email address</label>
                            <input class="form-control" type="email" id="username" name="username" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label mb-0" for="password">Password</label>
                                <!--a class="fs-sm" href="#">Forgot password?</a-->
                            </div>
                            <div class="password-toggle">
                                <input class="form-control" type="password" id="password" name="password" placeholder="Enter password" required>
                                <label class="password-toggle-btn" aria-label="Show/hide password">
                                    <input class="password-toggle-check" type="checkbox">
                                    <span class="password-toggle-indicator"></span>
                                </label>
                            </div>
                        </div>
                        @if ($errors->any())
                        <div class="py-2">


                                @foreach ($errors->all() as $error)
                                <div class="error">{{ $error }}</div>
                                @endforeach

                        </div>
                        @endif
                        <button class="btn btn-primary btn-lg w-100" type="submit">Sign in</button>
                    </form>
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
