@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => l('بازیابی رمز عبور')
])

@section('main_content')
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2')
    <section class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <div class="row justify-content-center">
            <div class="col-md-6">


                    <div class="card p-4 mt-5 rounded">
                        <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">{{ l('ایمیل') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">{{ l('رمز عبور') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">{{ l('تکرار رمز عبور') }}</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ l('ویرایش رمز عبور') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

            </div>
        </div>
    </section>

</main>
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
