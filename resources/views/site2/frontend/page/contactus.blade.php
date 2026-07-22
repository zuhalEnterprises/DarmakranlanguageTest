@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
    'title' => l('تماس با ما'),
])
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')

        <div class="container mt-5 mb-md-4 pt-5">
            <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="real-estate-home-v1.html">{{ l('خانه') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ l('تماس با ما') }}</li>
              </ol>
            </nav>
          </div>
          <!-- Hero-->
          <section class="container mb-5 pb-2">
            <div class="row align-items-md-start align-items-center gy-4">
              <div class="col-lg-5 col-md-6">
                <div class="mx-md-0 mx-auto mb-4 text-md-start text-center" style="max-width: 416px;">
                  <h1 class="mb-4 ">{{ l('با ما در ارتباط باشید!') }}</h1>
                </div><img class="d-block mx-auto rotate-img" src="img/real-estate/illustrations/contact.svg" alt="Illustration">
              </div>
              <div class="col-md-6 offset-lg-1">
                <div class="card border-0 bg-secondary p-sm-3 p-2">
                  <div class="card-body m-1">
                    <p style="margin-left:0px; margin-right:0px; text-align:start">
                        {{ l('آدرس دفتر: گیلان ، رضوانشهر ، جنب بانک ملی') }}
                        <br><br>
                        {{ l('شماره واتساپ : 09129406124') }}
                        <br><br>
                        {{ l('کانال تلگرام:') }} <a href="https://t.me/gilandmelk" target="_blank">https://t.me/gilandmelk</a>
                        <br><br>
                        {{ l('صفحه اینستاگرام :') }} <a href="https://instagram.com/gilandmelk.ir" target="_blank">https://instagram.com/gilandmelk.ir</a>
                        <br><br>
                        {{ l('کانال ایتا :') }} <a href="https://eitaa.com/gilandmelk" target="_blank">https://eitaa.com/gilandmelk</a>
                        <br><br>
                        {{ l('کانال ایتا :') }} <a href="https://ble.ir/gilandmelk" target="_blank">https://ble.ir/gilandmelk</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Contact cards-->
          <section class="container mb-5 pb-2 pb-md-4 pb-lg-5">
            <div class="row g-4">
              <!-- Item-->
              <div class="col-md-4"><a class="icon-box card card-hover h-100" href="mailto:info gilandmelk@gmail.com">
                  <div class="card-body">
                    <div class="icon-box-media text-primary rounded-circle shadow-sm mb-3"><i class="fi-mail"></i></div><span class="d-block mb-1 text-body">{{ l('ارسال ایمیل') }}</span>
                    <h3 class="h5 icon-box-title mb-0 opacity-90">info gilandmelk@gmail.com</h3>
                  </div></a></div>
              <!-- Item-->
              <div class="col-md-4"><a class="icon-box card card-hover h-100" href="tel:09129406124">
                  <div class="card-body">
                    <div class="icon-box-media text-primary rounded-circle shadow-sm mb-3"><i class="fi-device-mobile"></i></div><span class="d-block mb-1 text-body">{{ l('تماس از 9 الی 21') }}</span>
                    <h3 class="h5 icon-box-title mb-0 opacity-90 ltr">09129406124</h3>
                  </div></a></div>
              <!-- Item-->
              <div class="col-md-4"><a class="icon-box card card-hover h-100" href="#">
                  <div class="card-body">
                    <div class="icon-box-media text-primary rounded-circle shadow-sm mb-3"><i class="fi-instagram"></i></div><span class="d-block mb-1 text-body">{{ l('ما را دنبال کنید') }}</span>
                    <h3 class="h5 icon-box-title mb-0 opacity-90 ltr">@gilandmelk.ir</h3>
                  </div></a></div>
            </div>
          </section>
    </main>
    @include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
