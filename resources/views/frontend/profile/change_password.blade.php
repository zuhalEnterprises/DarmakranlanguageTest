@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('تغییر رمز عبور'),
])

    @section('main_content')

    <main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2')

        <div class="row mx-0"  >

            <div class="col-lg-6 px-0">
                <div class=" text-right">
                    <h3 class="h3-manage-head card-header"><span>{{ l('تعیین رمز عبور جدید') }}</span></h3>

                    <div class="card-body">
                        <form method="POST" action="{{url('/profile/change_password')}}" style="min-height:420px">
                            @csrf

                            <div class="row mx-0">
                                <div class="h-auto mt-5 p-2">
                                    <p class="text-muted"><i class="fa fa-info-circle d-inline"></i>{{ l('برای تعیین یا تغییر رمز عبور هر دو فیلد الزامیست') }}</p>
                                    <div class="row mx-0">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group px-2">
                                            <span class="col-title ">{{ l('رمز عبور جدید') }}</span>
                                            <span class="col-value form-check">
                                                <input type="password" id="password" name="password" autocomplete="off" class="form-control small" value="">
                                            </span>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group px-2 mt-3">
                                            <span class="col-title ">{{ l('تکرار رمز عبور جدید (تاییدیه)') }}</span>
                                            <span class="col-value form-check">
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control small" value="">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success" >
                                <i class="d-inline fa fa-check"></i> {{ l('ذخیره') }}
                            </button>

                        </form>
                        <div class="text-success font-weight-bold">
                        @if (\Session::has('success'))
                        {!! \Session::get('success') !!}
                    @endif
                        </div>
                        <div class="text-danger">
                    @if (\Session::has('errors'))
                        {!! \Session::get('errors') !!}
                    @endif
                        </div>
                        </div>


                    </div>

                </div>

            </div>

        </div>

        @include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
        @endsection
        @section('js')

        @endsection
