@section('title', l('مدیریت ملک - پیشنمایش ملک'))

@section('head')
    <link rel="stylesheet" href="{{asset('/vendor/map/leaflet.css')}}"/>
    <script src="{{asset('/vendor/map/leaflet.js')}}"></script>
    <script src="{{asset('/frontend/js/slick.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/frontend/css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/css/slick.css')}}">
@endsection


{{--estate-preview--}}

<div class="row">

    <div class="col-lg-5 col-sm-12">
        <div class="title-tab-right">
            <h1 class="title-tab"><a href="/v/{{$estate->id}}" class="title-tab-a">{{$estate->title}}</a></h1>
            <p class="title-tab-p" style="font-size: .9rem;">
                {{toPersianDate($estate->created_at,true,false)}} در
                {{$estate->city->name ?? ''}}،
                {{$estate->district->name ?? ''}} |
                {{$estate->type == 1 ? l('فروش') : l('اجاره')}}
                {{estateTypes($estate->estate_type)}}
            </p>
        </div>

        <div class="post-action">
            <button class="action-btn" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><span class="text-btn">{{ l('اطلاعات تماس') }}</span></button>
        </div>

        <div class="collapse" id="collapseExample">

            <div class="card card-body border-0">

                <div class="card-collapse-main">

                    @if(!empty($estate->expert))
                        <div class="col-xl-12 col-md-12 adress-area my-2 px-2 kama-agent-tile " id="adress1">
                        <div class="adress-card rounded-sm pt-2 px-3 border primary-agent">
                            <div>
                                <div class="img-area"><img alt="" class="rounded-circle" src="{{$estate->expert ? $estate->expert->photo() : noImage()}}"></div>
                                <div class="customer-info p-2">
                                    @if(!empty($estate->expert))
                                        <h3>{{$estate->expert->name ?? ''}}</h3>
                                        <h4>{{$estate->expert->getRoleTitle() ?? ''}}</h4>
                                    @endif
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row adress-footer">
                                <div class="col-lg-6 p-0"><a class="px-1" href="/agents_v2/{{$estate->expert->code ?? '0'}}"><i class="fa fa-eye"></i>{{ l('مشاهده پروفایل') }}</a></div>
                                <div class="col-lg-6 p-0"><a class="px-1" href="tel:{{$estate->phone}}"><i class="fa fa-phone"></i> {{$estate->phone}}</a></div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                    @else
                        <div class="base-row bg--zebra-stipe-gray px-2 w-100">
                            <div class="base-row-start">
                                <p class="base-p">{{ l('شماره تماس') }}</p>
                            </div>
                            <div class="base-row-end">
                                <p class="base-price">{{$estate->phone}}</p>
                            </div>
                        </div>
                    @endif

                </div>

                {{--<div class="box-warning-card">
                    <span class="warning-head">{{ l('هشدار پلیس') }}</span>
                    <span class="warning-text">{{ l('لطفاً پیش از انجام معامله و هر نوع پرداخت وجه، از صحت کالا یا خدمات ارائه شده، به صورت حضوری اطمینان حاصل نمایید.') }}</span>
                </div>--}}

            </div>
        </div>



        <!----start group-row---->
        @if($attributesText)
            <div>
                <div class="group-row">
                    @foreach($attributesText as $key=>$value)
                        <div class="group-row-item">
                            <span class="group-row-title">{{$key}}</span>
                            <span class="group-row-value">{{$value}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <hr class="divider">

        @if($attributesText2)
            @foreach($attributesText2 as $key=>$value)
                <div class="base-row">
                    <div class="base-row-start">
                        <p class="base-p">{{$key}}</p>
                    </div>
                    <div class="base-row-end">
                        <p class="base-price">{{number_format($value)}} </p>
                    </div>
                </div>
                <hr class="divider">
            @endforeach
        @endif

        @if($estate->type == 2)
            <div class="base-row">
                <div class="base-row-start">
                    <p class="base-p">{{ l('ودیعه') }}</p>
                </div>
                <div class="base-row-end">
                    <p class="base-price">{{number_format($estate->{{ l('mortgage)}} تومان') }}</p>
                </div>
            </div>

            <hr class="divider">

            <div class="base-row">
                <div class="base-row-start">
                    <p class="base-p">{{ l('اجاره ماهانه') }}</p>
                </div>
                <div class="base-row-end">
                    <p class="base-price">{{number_format($estate->{{ l('rent)}} تومان') }}</p>
                </div>
            </div>

            @if($estate->convertible == 1)
                <hr class="divider">
                <div class="base-row">
                    <div class="base-row-start">
                        <p class="base-p">{{ l('ودیعه و اجاره') }}</p>
                    </div>
                    <div class="base-row-end">
                        <p class="base-price">{{ l('قابل تبدیل') }}</p>
                    </div>
                </div>
            @endif

        @else
            <div class="base-row">
                <div class="base-row-start">
                    <p class="base-p">{{ l('قیمت') }}</p>
                </div>
                <div class="base-row-end">
                    <p class="base-price">{{number_format($estate->{{ l('price)}} تومان') }}</p>
                </div>
            </div>
        @endif

        <hr class="divider">

        @if($features)
        <!----start section-title----->
            <div class="section-title">
                <div>
                    <div class="section-title-1">
                        <span class="section-title-p">{{ l('ویژگی ها و امکانات') }}</span>
                    </div>
                </div>
            </div>
            <!----end base-row-title----->
            <!----start group-row---->
            <div>
                <div class="group-row">
                    @foreach($features as $key=>$icon)
                        <div class="group-row-item">
                            <span class="group-row-icon"><i class="fas {{$icon}}"></i></span>
                            <span class="group-row-value">{{$key}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <hr>
        <div class="explain">
            <h2>{{ l('توضیحات') }}</h2>
            <p>{{$estate->description}}</p>
        </div>
    </div>

    <div class="col-lg-7 col-sm-12">
        <div class="post-share-main">
            <div class="post-share">
                <span>آگهی ملک شما در {{ss('SITE_NAME')}}:</span>
                <a href="/v/{{$estate->id}}" target="_blank">{{env('APP_URL')}}/v/{{$estate->id}}</a>
            </div>

            <div class="main-ads-show-gallery hidden-xs">
                <section class="lazy slider" data-sizes="50vw" >
                    @foreach($estate->images as $image)
                        <div class="show-lightbox">
                            <img data-lazy="{{asset('/upload/images/estate/'.$image->url())}}"
                                 data-srcset="{{asset('/upload/images/estate/'.$image->url())}}" data-sizes="100vw" >
                        </div>
                    @endforeach
                </section>

                <div>
                    <section class="center slider">
                        @foreach($estate->images as $key=>$image)
                            @if($key <= 4)
                                @if($estate->images->count() > 5 && $key == 4)
                                    <div class="slidemore show-lightbox">
                                        <img src="{{asset('upload/images/estate/'.$image['dimension']['small'])}}">
                                        <span>+{{$estate->images->count()}}</span>
                                    </div>
                                @else
                                    <div data-id="img{{$image->id}}">
                                        <img src="{{asset('upload/images/estate/'.$image['dimension']['small'])}}">
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </section>
                </div>
            </div>

            {{--map--}}
            @if(!empty($estate->latitude) && !empty($estate->longitude))
                <div id="estate-map" class="z-depth-1-half map-container-show part--map" style="margin-top: 25px; width: 100%;">
                </div>
                <script>
                    var defaultZoom=15;
                    var defaultLocation= ['{{$estate->latitude}}','{{$estate->longitude}}'];
                    var map = L.map('estate-map').setView(defaultLocation, defaultZoom);

                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
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
                    map.on('dblclick',function(e){
                        latitude = e.latlng.lat;
                        longitude = e.latlng.lng;
                    });


                </script>
            @endif

        </div>
    </div>

</div>


{{--estate-visits-chart--}}
<div class="box-4 clearfix h-auto m-0 mt-2 row">

        <div class="col-lg-12 col-sm-12">
            <div class="post-stats">
                <h2 class="pb-0">{{ l('آمار بازدید') }}</h2>
                <p>{{ l('آمار تعداد بازدید روزانه آگهی شما از زمان انتشار آگهی در این نمودار قابل مشاهده است.') }}</p>
                <span>بازدید کلی: {{number_format($hits['total'] ?? 0)}}</span>
            </div>
        </div>

        {{--chart--}}
        <div class="col-lg-12 col-sm-12">
            <div class="clearfix" id="chart" style="">
                @isset($hits['chart'])
                    @include('frontend.profile.ad_management.layouts.chart',['chart' => $hits['chart']])
                @endisset
            </div>
        </div>

</div>



    <script src="{{asset('/frontend/js/lightgallery.min.js')}}"></script>
    <script src="{{asset('/frontend/js/picturefill.min.js')}}"></script>
    <script src="{{asset('/frontend/js/lightgallery-all.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/frontend/js/mdb.min.js')}}"></script>
    <script type="text/javascript">
        $('#aniimated-thumbnials').lightGallery({
            thumbnail: true,
            animateThumb: true,
            showThumbByDefault: true

        });

        $('#aniimated-thumbnials-media').lightGallery({
            thumbnail: true,
            animateThumb: true,
            showThumbByDefault: true

        });

        function check(a) {
            x = document.getElementById(a);
            if (x.check = true) {
                document.getElementById('btn-select-none').style.display = "block";
                document.getElementById('btn-select-blcok').style.display = "none";
            }
        }



        function isMobile(width) {
            if (width == undefined) {
                width = 719;
            }
            if (window.innerWidth <= width) {
                return true;
            } else {
                return false;
            }
        }

        $(".lazy").slick({
            lazyLoad: 'ondemand', // ondemand progressive anticipated
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: true,
            fade: true,
            asNavFor: '.center',
            rtl:true


        });
        $(".center").slick({
            arrows: false,
            infinite: false,
            centerMode: true,
            focusOnSelect: true,
            slidesToShow: 5,
            slidesToScroll: 0,
            asNavFor: '.lazy',
            rtl:true


        });
        $(".center").click({
            asNavFor: '.center',

        });
    </script>
