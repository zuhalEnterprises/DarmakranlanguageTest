<style>
    ul.login-tabs{border-radius: .3rem .3rem 0 0; overflow: hidden;}
    ul.login-tabs li a{
        background: #f5f5f5 !important;
    }
    ul.login-tabs li a.active{
        background: #fff !important;
    }
    #pills-tabContent input{font-size: .95rem !important;}
    #pills-tabContent input[type="checkbox"]{
        position: relative !important;
        pointer-events: auto;
        opacity: 1;
        width: 1rem;
        height: 1rem;
    }
    .form-control-lg {
        height: auto !important;
        padding: .5rem 1rem !important;
        font-size: 1rem !important;
        /* border-radius: .3rem !important; */
    }
    .dir-left{
        direction: ltr !important;
    }
</style>
    <!-- Modal Login-Register -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel"
         aria-hidden="true" style="z-index: 99999;">
        <div class="modal-dialog shadow-5-strong" role="document">
            <div class="modal-content">
                <ul class="nav login-tabs" id="pills-tab" role="tablist">
                    <li class="nav-item mx-0 text-center w-50">
                        <a class="active font-weight-bolder nav-link py-3 text-black text-body" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                           aria-controls="pills-home" aria-selected="true">{{ l('ورود') }}</a>
                    </li>
                    <li class=" nav-item mx-0 text-center w-50">
                        <a class="font-weight-bolder nav-link py-3 text-black text-body" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                           aria-controls="pills-profile" aria-selected="false">{{ l('ثبت نام') }}</a>
                    </li>
                </ul>

                <div class="tab-content w-100 p-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                        <form id="frm-login" class="form-horizontal" method="post" action="{{ route('login') }}">
                                @csrf
                                <div class="col-xs-12 form-control-lg input-group-sm">
                                    <label class="form-label">{{ l('شماره موبایل (نام کاربری)') }}</label>
                                    <input type="tel" name="username"
                                           class="form-control dir-left username-tel" id="inputEmail"
                                           pattern="[0-9]{11}" maxlength="11"
                                           placeholder="{{ l('شماره موبایل') }}" autocomplete="off"
                                           autocorrect="off" autocapitalize="off" spellcheck="false" required
                                           oninvalid="this.setCustomValidity('{{ l('شماره موبایل نامعتبر است!') }}')"
                                           oninput="setCustomValidity('')">
                                </div>

                                <div class="col-xs-12 form-control-lg input-group-sm">
                                    <label class="form-label">{{ l('رمز ورود') }}</label>
                                    <input type="password" name="password" class="form-control dir-left"
                                           id="inputPass" placeholder="{{ l('رمز ورود') }}"
                                           autocomplete="off" autocorrect="off" autocapitalize="off"
                                           spellcheck="false" required
                                           oninvalid="this.setCustomValidity('{{ l('رمز ورود الزامیست!') }}')"
                                           oninput="setCustomValidity('')">
                                </div>

                                <div class="col-xs-12 form-control-lg input-group-sm">
                                    <div class="form-check">
                                        <label class="form-check-label" for="gridCheck">
                                            <a href="/forget_password/create" style="border-bottom: 1px dashed #80aeff;">
                                                 {{ l('رمز ورود خود را فراموش کرده اید؟') }}</a>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-12 form-control-lg">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">{{ l('ورود به حساب کاربری') }}</button>
                                </div>
                            </form>


                    </div>

                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                            <form id="frm-signup" class="form-horizontal" method="POST" action="{{ url('/confirm') }}">
                                @csrf
                                <div class="col-xs-12 form-control-lg input-group-sm">
                                    <label class="form-label">{{ l('نام و نام خانوادگی') }}</label>
                                    <input type="text" name="name" id="inputName"
                                           class="form-control" placeholder="{{ l('نام و نام خانوادگی') }}" required
                                           oninvalid="this.setCustomValidity('{{ l('نام الزامیست!') }}')"
                                           oninput="setCustomValidity('')">
                                </div>

                                <div class="col-xs-12 form-control-lg input-group-sm">
                                    <label class="form-label">{{ l('شماره موبایل (نام کاربری)') }}</label>
                                    <input type="tel" name="username"
                                           class="form-control dir-left username-tel" id="inputEmail"
                                           pattern="[0-9]{11}" maxlength="11"
                                           placeholder="{{ l('شماره موبایل') }}" autocomplete="off"
                                           autocorrect="off" autocapitalize="off" spellcheck="false" required
                                           oninvalid="this.setCustomValidity('{{ l('شماره موبایل نامعتبر است!') }}')"
                                           oninput="setCustomValidity('')">
                                </div>

                                <div class="col-xs-12 form-control-lg input-group-sm">
                                    <label class="form-label">{{ l('رمز ورود') }}</label>
                                    <input type="password" name="password" class="form-control dir-left"
                                           id="inputPass" placeholder="{{ l('رمز ورود') }}"
                                           autocomplete="off" autocorrect="off" autocapitalize="off"
                                           spellcheck="false" required
                                           oninvalid="this.setCustomValidity('{{ l('رمز ورود الزامیست!') }}')"
                                           oninput="setCustomValidity('')">
                                </div>

                                <div class="col-xs-12 form-control-lg input-group-sm">
                                    <input class="" type="checkbox" id="gridCheck" required
                                           oninvalid="this.setCustomValidity('{{ l('پذیرفتن قوانین و مقررات الزامیست!') }}')"
                                           oninput="setCustomValidity('')">
                                    <label class="form-check-label p-0" for="gridCheck">
                                        <a href=l("/page/قوانین-و-مقررات") target="_blank"
                                           style="border-bottom: 1px dashed #80aeff;">{{ l('قوانین و مقررات را قبول دارم') }}</a>
                                    </label>
                                </div>

                                <div class="col-xs-12 form-control-lg">
                                    <button type="submit" id="btn-signup" class="btn btn-block btn-lg btn-primary">{{ l('ثبت نام') }}</button>
                                </div>
                            </form>

                    </div>
                </div>

                {{--<div class="modal-header">
                    <h5 class="modal-title" id="exampleModalPreviewLabel">{{ l('ورود و ثبت نام') }}</h5>
                    <button type="button" id="btn-close" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-5">
                    <!-- Material outline input with prefix-->

                    <div id="tel" class="text-center">
                        <div class="md-form md-outline input-with-pre-icon">
                            <span class="input-prefix">+98</span>

                            <input dir="ltr" type="text" class="form-control mb-3" name="mobile" id="mobile" autocomplete="off"
                                   placeholder="9xxxxxxxxx" pattern="[0-9]{10}" minlength="10" maxlength="10"
                                   oninvalid="this.setCustomValidity(l('شماره موبایل نامعتبر است!'))" oninput="setCustomValidity('')">
                        </div>
                        <small id="mobile" class="form-text text-danger text-center mb-3"></small>


                        <button class="btn btn-primary d-block m-auto" id="submit-mobile" disabled="disabled" type="button">{{ l('دریافت کد تایید') }}</button>
                    </div>

                    <div class="row md-form md-outline" id="code" style="display: none">
                        <div class="col">
                            <!-- Phone number -->

                            <input type="text" name="verification" id="verification" class="form-control" placeholder="{{ l('کد فعال سازی') }}" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" maxlength="5">
                            <small id="verification" class="form-text text-danger mb-0"></small>

                            <button class="btn btn-primary mb-2 mt-1 btn-block" id="verifycode" type="button">{{ l('تایید') }}</button>
                            <center>
                                <a href="javascript:;" id="change-mobile" class="p-0 font-small d-block">{{ l('تغییر شماره موبایل') }}</a>
                                <a class="button text-danger" href="javascript:;" id="send-again" style="display: none;">{{ l('ارسال مجدد کد فعالسازی') }}</a>
                                <div id="mdtimer">
                                    <b></b>
                                    <div style="font-size: 10px"><b>{{ l('ارسال مجدد کد پس از') }} <span>90</span> {{ l('ثانیه') }}</b></div>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
<script>
    var timer;
    var latinNum = 0;
    function parseArabic(str) {
        return Number( str.replace(/[٠١٢٣٤٥٦٧٨٩]/g, function(d) {
            return d.charCodeAt(0) - 1632; // Convert Arabic numbers
        }).replace(/[۰۱۲۳۴۵۶۷۸۹]/g, function(d) {
            return d.charCodeAt(0) - 1776; // Convert Persian numbers
        }) );
    }

    // login|register
    $("body").on("click",'#profile', function () {
        var userId = '{{$currentUser->id ?? 0}}';
        if(userId == 0){
            // prevent close modal when click outside or press escape key

            // $('#loginModal').modal({
            //     backdrop: 'static',
            //     keyboard: false
            // })
        }

        return true;
    });

    $('#submit-mobile').on('click',function () {
        var regex ="/^9\d{9}$/";
        mobile = $('input#mobile').val();
        latinNum = parseArabic(mobile);
        latinNum = '0'+latinNum;


        if(mobile.trim() == '' || mobile == null){
            $('input#mobile').focus();
            alert('{{ l('شماره موبایل الزامیست!') }}');
            return false;
        }

        if(!latinNum.match(/^0(9|4)\d{9}$/)){
            $('input#mobile').val('');
            alert('{{ l('شماره موبایل نامعتبر است!') }}');

            return false;
        }

        $('small#verification').text('');
        $('#send-again').hide();

        // verify mobile
        verifyMobile(latinNum,0);

    });

    $('#change-mobile').on('click',function () {
        $("#mdtimer span").text('90');
        clearInterval(timer);
        $('#btn-close').show();
        $('input#mobile').val('');
        $('#tel').show();
        $('#code').hide();
    });

    $('#send-again').on('click',function () {
        verifyMobile(latinNum,0);
    });

    $("#mobile").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^\d|\u06F0-\u06F9].+/, ""));

        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }

        if($(this).val().length == 10){
            $('#submit-mobile').removeAttr('disabled');
        }else{
            $('#submit-mobile').attr('disabled','disabled');
        }
    });

    $('#verifycode').on('click',function () {
        var verificationCode = $("input#verification");
        if(verificationCode.val().trim().length == 5){
            verifyCode(latinNum,verificationCode.val());
        }
    });

    $("input#verification").on("keyup",function (event) {
        $(this).val($(this).val().replace(/[^\d|\u06F0-\u06F9].+/, ""));

        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }

        if($(this).val().length === 5){
            //verifyCode(latinNum,$(this).val());
            $('#verifycode').removeAttr('disabled');
        }else{
            $('#verifycode').attr('disabled','disabled');
        }
    });

    $('input#verification').keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    function verifyMobile(telNum,forgetStatus){
        $.ajax({
            type: 'POST',
            url: '/login_mobile',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            data: {_method:'post', mobile: telNum,forget_pass: forgetStatus},
            error: function (xhr, status, error) {
                var obj = JSON.parse(xhr.responseText);

                if(obj.status==='Error'){
                    console.log(obj);
                    $('input#mobile').val('');
                    $('small#mobile').text(obj.message);


                    return false;
                }

                return true;
            },
            success: function (response) {
                $('small#mobile').text('');
                var status = response.status;
                if(status==='Success'){
                    var res = response.data;
                    var registerStatus = res.register;
                    var forgetStatus = res.forget_status;

                    //if(registerStatus === 1 || res.forget_status === '1'){


                    $('#tel').hide();
                    $('#btn-close').hide();
                    $('#code').show();

                    clearInterval(timer);
                    $("#send-again").hide();
                    $("#mdtimer span").text(90)
                    $("#mdtimer").show();
                    var sec = 90;
                    timer = setInterval(function() {
                        $("#mdtimer span").text(sec--);
                        if (sec == 0) {
                            $("#send-again").delay(1000).fadeIn(1000);
                            $("#mdtimer").hide(1000) .fadeOut('fast');}
                    },1000);

                    return true;
                }

                return false;
            }
        });
    }

    function verifyCode(telNum,code){
        $.ajax({
            type: 'POST',
            url: '/verify_code',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            data: {_method:'post', mobile: telNum, code: code},
            error: function (xhr, status, error) {
                var obj = JSON.parse(xhr.responseText);
                console.log(obj);
                if(obj.status==='Error'){
                    $("input#verification").val('');
                    $('small#verification').text(obj.message);
                    return false;
                }

                return true;
            },
            success: function (response) {
                $('small#verification').hide();
                var status = response.status;
                var callback = response.data.callback;
                console.log(response);
                if(status==='Success'){

                    var baseUrl = window.location.origin;
                    var targetUrl = '/profile';
                    window.location.href =`${baseUrl}${targetUrl}`;

                }

                return false;
            }
        });
    }
</script>
