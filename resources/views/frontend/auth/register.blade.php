
@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',['title'=> l('ثبت نام')])
@section('body_class','login')
@section('head')
<!--meta http-equiv="refresh" content="300;{{ route('login') }}" /-->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/mainpage/css/login.css">
@endsection
@section('main_content')
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2')
    <section class="d-flex container-fluid my-5 pt-5 pb-lg-4 px-xxl-4 justify-content-center align-items-center">
        <div class="card card-body rounded" style="max-width: 940px">
            <div class="row mx-0 align-items-center">
                <div class="col-md-6 border-end-md p-4 p-sm-5">
                    <h2 class="h3 mb-4 mb-sm-5">{{ l('در سایت ما با اطمینان ثبت نام کنید.') }}</h2>
                    <img class="d-block mx-auto rotate-img" src="/img/signin-modal/signup.svg" width="344" alt="Illustartion">
				    <div class="mt-sm-4 pt-md-3">{{ l('ثبت نام کرده اید؟') }} <a href="/login">{{ l('ورود به حساب کاربری') }}</a></div>
                </div>
                <div class="col-md-6 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">
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
                    <form id="registerForm" class="needs-validation" novalidate method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="mb-4">
                        <label class="form-label" for="name">{{ l('نام و نام خانوادگی') }}</label>
                        <input class="form-control" type="text" id="name" name="name"
                        value="{{ old('name') }}"
                        required placeholder="{{ l('نام و نام خانوادگی خود را وارد کنید') }}">

                        <div class="invalid-feedback">{{ l('نام را وارد کنید.') }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="signup-email">{{ l('پست الکترونیکی') }}</label>
                        <input class="form-control" type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        required placeholder="{{ l('ایمیل') }}">

                        <div class="invalid-feedback">{{ l('ایمیل معتبر وارد کنید.') }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="signup-password">{{ l('رمز عبور') }} <span class="fs-sm text-muted">{{ l('حداقل ۸ کاراکتر') }}</span></label>
                        <div class="password-toggle">
                            <input class="form-control" type="password" id="signup-password" name="password" minlength="8" required>
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                            <div class="invalid-feedback">{{ l('رمز عبور باید حداقل ۸ کاراکتر باشد.') }}</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="signup-password-confirm">{{ l('تایید رمز عبور') }}</label>
                        <div class="password-toggle">
                            <input class="form-control" type="password" id="signup-password-confirm" minlength="8" required>
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                            <div class="invalid-feedback">{{ l('رمز عبور با تاییدیه هم‌خوانی ندارد.') }}</div>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-lg w-100" type="submit">{{ l('ثبت نام') }}</button>
                </form>

                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@section('js')
<script>
$(function () {
    $('#registerForm').on('submit', function (e) {
        let valid = true;
        let form = $(this);

        // فیلدها
        let name = $('#name');
        let email = $('#email');
        let password = $('#signup-password');
        let confirmPassword = $('#signup-password-confirm');

        // بررسی نام
        if ($.trim(name.val()) === '') {
            name.addClass('is-invalid');
            valid = false;
        } else {
            name.removeClass('is-invalid').addClass('is-valid');
        }

        // بررسی ایمیل
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.val())) {
            email.addClass('is-invalid');
            valid = false;
        } else {
            email.removeClass('is-invalid').addClass('is-valid');
        }

        // بررسی رمز
        if (password.val().length < 8) {
            password.addClass('is-invalid');
            valid = false;
        } else {
            password.removeClass('is-invalid').addClass('is-valid');
        }

        // تایید رمز
        if (password.val() !== confirmPassword.val() || confirmPassword.val().length < 8) {
            confirmPassword.addClass('is-invalid');
            valid = false;
        } else {
            confirmPassword.removeClass('is-invalid').addClass('is-valid');
        }

        // جلوگیری از ارسال فرم
        if (!valid) {
            e.preventDefault();
        }
    });
});
</script>


@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
