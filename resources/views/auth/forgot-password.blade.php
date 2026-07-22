@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', ['title' => l('فراموشی رمز عبور')])
@section('body_class','login')
@section('head')
<link rel="stylesheet" href="/mainpage/css/login.css">
@endsection

@section('main_content')
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')
    <section class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card p-4">
                    <h4 class="mb-3 text-center">{{ l('بازیابی رمز عبور') }}</h4>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ l('ایمیل خود را وارد کنید') }}</label>
                            <input type="email" name="email" class="form-control" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ l('ارسال لینک بازیابی') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
