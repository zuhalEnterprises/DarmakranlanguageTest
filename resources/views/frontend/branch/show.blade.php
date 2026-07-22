@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2',['title'=>$branch->name])

@section('head')
<link rel="stylesheet" href="{{asset('/vendor/map/leaflet.css')}}" />
<script src="{{asset('/frontend/js/modules/leaflet/leaf.js')}}"></script>
<link rel="stylesheet" href="{{asset('/vendor/map/leaflet.css')}}" />
<script src="{{asset('/vendor/map/leaflet.js')}}"></script>
<link rel="stylesheet" href="/assets/css/sweetalert.css" />
<link rel="stylesheet" href="/assets/css/popper.css">
<script src="/assets/js/sweetalert.min.js"></script>
@endsection
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')
    <div class="container mt-5 mb-md-4 pt-5">
        <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page"> {{$branch->name}}</li>
          </ol>
        </nav>
      </div>
      <!-- Page header-->
      <section class="container mb-5 pb-2">
        <div class="row align-items-center justify-content-center">
          <!-- Hero content-->
          <div class="col-lg-4 col-md-5 col-sm-9 order-md-1 order-2 ">
            <h1 class="mb-4 "> {{$branch->name}} </h1>
            <p class="mb-3  fs-lg"><b>{{$branch->address}}</b></p>
            <p class="mb-3  fs-lg line-h18 text-justify">@php echo nl2br(e($branch->description)) @endphp</p>
            <div class="d-flex justify-content-between align-items-center">
                <p class="m-0">
                    {{ l('تلفن:') }}
                    <b>{{$branch->phone}}</b>
                </p>
                <a class="btn btn-lg btn-primary" href="/contactus">{{ l('تماس با ما') }}</a>
            </div>
          </div>
          <!-- Hero carousel-->
          <div class="col-lg-7 col-md-6 offset-md-1 col-12 order-md-2 order-1">
            <div class="tns-carousel-wrapper tns-controls-static tns-nav-outside">
              <div class="tns-carousel-inner" data-carousel-options="{&quot;loop&quot;: true, &quot;gutter&quot;: 16}">
                @foreach ($branch->images as $img)
                <div style="max-height: 550px;"><img class="rounded-3 w-100 h-100" style="object-fit: cover;"  src="/upload/images/branch/{{$img->dimension['large']}}" alt="Carousel image" ></div>    
                @endforeach
                
              </div>
            </div>
          </div>
          </div>
        </div>
      </section>

      <section class="container mb-5 pb-2 pb-lg-4">
      <h2 class="h3 mb-lg-5 mb-sm-4 text-center">{{ l('نقاط قوت ما') }}</h2>
        <div class="row gy-4">
          <div class="col-md-6 col-12">
          <div class="steps steps-vertical">
              <div class="step active">
                <div class="step-progress"><span class="step-number">1</span></div>
                <div class="step-label me-4">
                  <h3 class="h5 mb-2 pb-1">{{ l('مشاورین مجرب') }}</h3>
                  <p class="mb-0">{{ l('استفاده از مشاورین کارآزموده و متخصص در زمینه کاری خود جهت ارائه مشاوره دقیق و کامل (این فقط یک تعریف نیست، در این مجموعه مشاوران در زمینه های کاری مختلف تفکیک بندی شده و به صورت تخصصی در زمینه کاری خاص خود فعالیت می کنند).') }}</p>
                </div>
              </div>
              <div class="step active">
                <div class="step-progress"><span class="step-number">2</span></div>
                <div class="step-label me-4">
                  <h3 class="h5 mb-2 pb-1">{{ l('سایت کاربر پسند') }}</h3>

                  <p class="mb-0">{{ l('داشتن فایلینگ قوی تعداد بالای ملک و همچنین دارا بودن فایل های اختصاصی که جز در کومه نمی توان در محل دیگری آنها را یافت.') }}</p>
                </div>
              </div>

            </div>
          </div>
          <div class="col-lg-6 col-12">

            <div class="steps steps-vertical">

              <div class="step active">
                <div class="step-progress"><span class="step-number">3</span></div>
                <div class="step-label me-4">
                  <h3 class="h5 mb-2 pb-1">{{ l('فایلینگ بالا') }}</h3>
                  <p class="mb-0">{{ l('سهولت یافتن ملک مناسب با استفاده از امکانات سایت، که ما را از دیگران متمایز کرده از جمله استفاده از عکس های 360 درجه و پلان ساختمان (در صورت امکان) و استفاده از جست و جو در نقشه که خیلی در زمان مشتریان صرفه جویی می کند.') }}</p>
                </div>
              </div>
              <div class="step active">
                <div class="step-progress"><span class="step-number">4</span></div>
                <div class="step-label me-4">
                  <h3 class="h5 mb-2 pb-1">{{ l('بررسی قراردادها توسط وکیل') }}</h3>
                  <p class="mb-0">{{ l('کتابت قرارداد ها توسط وکیل پایه یک دادگستری جهت ایجاد امنیت حقوقی و آرامش در معاملات') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Maps -->
      <section class="container mb-5 pb-sm-3 pb-lg-4">
        <h2 class="h3 mb-3 "> آدرس نقشه {{$branch->name}} </h2>
        @if(!empty($branch) && !empty($branch->latitude))
        <div  style="height: 300px" id="branch-map"  class="rounded-2xl border-[1px] border-orange-500">
        </div>
        <script>
            var defaultZoom=16;
            var defaultLocation= ['{{$branch->latitude}}', '{{$branch->longitude}}'];//qom
            var map = L.map('branch-map').setView(defaultLocation, defaultZoom);
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                //attribution: '2021 &copy; <a href="https://ekama.ir">Kama</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1Ijoicm1kZXY2NyIsImEiOiJja3F0a3F6N3cyNXg4MnVvNGQ0bGVubGR3In0.MCnbfbG3ix5IHdXa6CBTRg'
            }).addTo(map);
            var marker = L.marker(defaultLocation).addTo(map);
            //marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();

            // marker map
            var latitude = null;
            var longitude = null;
            map.on('click',function(e){
                window.location = "https://www.google.com/maps/search/"+latitude+","+longitude+"?entry=tts&shorturl=1";
                //latitude = e.latlng.lat;
                //longitude = e.latlng.lng;
                //var popLocation= e.latlng;
                //.setLatLng(popLocation)
                //.openOn(map);
            });



        </script>
        @endif
      </section>
      <!-- Meet our professional team-->
      <section class="container mb-5 pb-2 pb-lg-4">
        <div class="d-flex align-items-end justify-content-sm-between justify-content-center mb-3">
          <h2 class="h3 mb-0 text-sm-start text-center"> مشاوران با تجربه {{$branch->name}}</h2>
          <div class="tns-carousel-controls tns-controls-static d-sm-flex d-none ms-4" id="external-controls">
            <button class="mx-2" type="button"><i class="fi-chevron-left"></i></button>
            <button class="mx-2" type="button"><i class="fi-chevron-right"></i></button>
          </div>
        </div>
        <!-- Team carousel-->

        <div class="tns-carousel-wrapper tns-nav-outside tns-nav-outside-flush mx-n2">
          <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;controlsContainer&quot;: &quot;#external-controls&quot;, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4, &quot;nav&quot;: false}}}">
            @foreach($experts as $expert)
            <!-- Team slide-->
            <div class="col">

                    <div class="card border-0 shadow-sm mt-md-4">
                        <div class="position-relative">
                          <img class="card-img-top" src="{{$expert->photo()}}" alt="{{$expert->fullname()}}" style="object-fit:cover;width:325px; height:325px;"  />
                          <!--div class="position-absolute  position-absolute start-0 bottom-0 m-3">
                            <i class="fa-solid fa-medal fs-1 text-gold"></i>
                          </div-->
                        </div>
                        <div class="card-body text-center">

                                <h3 class="h5 card-title mb-2"><a class="btn " href="/agents/{{$expert->id}}">{{$expert->fullname()}}</a></h3>

                            <span class="d-inline-block mb-3 fs-sm">
                               مشاور {{$expert->activity_type == 1 ? l('فروش') : ($expert->{{ l('activity_type == 2 ? \'اجاره\' : \'فروش و اجاره\')}}') }}
                            </span>
                            <!--div class="pt-1">
                                <a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm mx-2" href="#">
                                    <i class="fi-facebook"></i>
                                </a>
                                <a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm mx-2" href="#">
                                    <i class="fi-twitter"></i>
                                </a>
                                <a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm mx-2" href="#">
                                    <i class="fi-instagram"></i>
                                </a>
                            </div-->
                        </div>
                    </div>

            </div>
            @endforeach

          </div>
        </div>
    </section>
</main>
@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection


