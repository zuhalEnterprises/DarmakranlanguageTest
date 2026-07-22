@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',
[
    'title'=>'ثبت نام در گیلند ملک'
])

@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <!-- Page content-->
        <!-- Breadcrumb-->
        <div class="container mt-5 mb-md-4 pt-5">
            <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ l('ثبت نام در گیلند ملک') }}</li>
                </ol>
            </nav>
        </div>
        <!-- Hero-->
        <section class="container mb-5 pb-2 pb-lg-4">
            <div class="mb-4">
                    <h1 class="h2 mb-0">{{ l('ثبت نام در گیلند ملک') }}</h1>
            </div>
            <p class="fw-bold">
                {{ l('چنانچه قصد دارید با گیلند ملک همکاری کنید لطفا فرم زیر را پر کنید تا همکاران ما با شما تماس بگیرند.') }}
            </p>
        @if($estateAppraisalId > 0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <span class="fw-bold">
                {{ l('اطلاعات با موفقیت ذخیره گردید. به زودی همکاران ما با شما تماس میگیرند.') }}
            </span>
        </div>
        @endif
          <div class="p-4 rounded-2 shadow">
            <!-- Form validation: status tooltips -->
            <form action="/property_appraisal/store" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold" for="name">{{ l('نام و نام خانوادگی') }}</label>
                        <input class="form-control" type="text" name="name" id="name" />
                    </div>
                    <div class="col-md-4 mb-3 d-none">
                        <label class="form-label fw-bold" for="estate_type">{{ l('نوع ملک') }}</label>
                        <select class="form-select" name="estate_type" id="estate_type">
                            @foreach (estateTypes() as $key=>$val)
                            <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold" for="tel">{{ l('تلفن') }}</label>
                        <input class="form-control" type="tel" name="tel" id="tel" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold" for="address">{{ l('آدرس') }}</label>
                        <input class="form-control" type="text" name="address" id="address" />
                    </div>
                </div>

                <button class="btn btn-primary px-5" type="submit">{{ l('ارسال') }}</button>
            </form>
          </div>
      </section>

    </main>

@section('js')


@endsection
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
