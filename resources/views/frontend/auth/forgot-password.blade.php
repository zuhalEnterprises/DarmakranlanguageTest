@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', ['title' => l('فراموشی رمز عبور')])

@section('main_content')
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')
    <section class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
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
                <div class="card p-4 mt-5 rounded">
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
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection

