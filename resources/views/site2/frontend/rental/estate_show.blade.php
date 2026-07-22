@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => $estate->title ?? l('اجاره اقامتگاه').estateTypes($estate->estate_type) .' در '.($estate->city->name ?? '')])

@section('head')
<link rel="stylesheet" href="/vendor/map/leaflet.css" />
<link rel="stylesheet" href="/assets/css/popper.css">
<script src="/frontend/js/modules/leaflet/leaf.js"></script>
<link rel="stylesheet" href="/assets/vendors/fancybox/fancybox.css"/>
@endsection
@section('main_content')
<main class="page-wrapper" style="background-color:#fff;">
    @include(ss('THEME') . '.frontend.layouts.header_rent')
    <!-- Gallery with thumbnails  -->
    @if (count($images->where("plan","=",0)) > 0 )
    <section class="container overflow-auto pb-3 mt-5" >
        <div class="row g-2 g-md-3  mt-md-5" >
            @php
            $count = 0;
            $len = count($images->where("360","=",0));
            @endphp
            @foreach ($images->where("360","=",0) as $url)
            @php
                $count++;
            @endphp
            @if($count == 1)
            <div class="col-12 col-md-6" >
                <a class="gallery-item rounded rounded-md-3" href="/upload/images/estate/{{ $url->url() }}" data-fancybox="gallery" data-caption="اجاره اقامتگاه {{ estateTypes($estate->estate_type) }} در {{($estate->city->name ?? '')}}">
                    <img src="/upload/images/estate/{{ $url->url() }}" alt="{{$estate->title ?? l('اجاره اقامتگاه').estateTypes($estate->estate_type).' در '.($estate->city->name ?? '')}}" style="object-fit: cover;width:100%">
                </a>
            </div>
            @endif
            @if($count == 2)
            <div class="col-12 col-md-6">
                <div class="row g-2 g-md-3">
            @endif
            @if($count == 2 || $count == 3 || $count == 4)
                    <div class="col-6">
                        <a class="gallery-item rounded rounded-md-3" href="/upload/images/estate/{{ $url->url() }}" data-fancybox="gallery" data-caption="اجاره اقامتگاه {{ estateTypes($estate->estate_type) }} در {{($estate->city->name ?? '')}}">
                            <img src="/upload/images/estate/{{ $url->url() }}" alt="{{$estate->title ?? l('اجاره اقامتگاه').estateTypes($estate->estate_type).' در '.($estate->city->name ?? '')}}" style="height: 250px;
                            object-fit: cover;width:100%">
                        </a>
                    </div>

            @endif
            @if($count == 5)
                    <div class="col-6">
                        <a class="gallery-item more-item rounded rounded-md-3" href="/upload/images/estate/{{ $url->url() }}" data-fancybox="gallery" data-caption="اجاره اقامتگاه {{ estateTypes($estate->estate_type) }} در {{($estate->city->name ?? '')}}">
                            <img src="/upload/images/estate/{{ $url->url() }}" alt="{{$estate->title ?? l('اجاره اقامتگاه').estateTypes($estate->estate_type).' در '.($estate->city->name ?? '')}}" style="height: 250px;
                            object-fit: cover;width:100%">
                            <span class="gallery-item-caption fs-base"><span class="d-none d-md-inline">{{ l('سایر تصاویر') }}</span>  </span>
                        </a>
                    </div>
            @endif

            @if(($len<=5 && $count == $len) || ($len>5 && $count == 5))
                </div>
            </div>
            @endif
            @if($count == 6)
            <!-- ادامه عکس ها -->
            <div  style="display: none;" >
            @endif
            @if($count > 6)
                <a class="gallery-item" href="/upload/images/estate/{{ $url->url() }}" data-fancybox="gallery" data-caption="اجاره اقامتگاه {{ estateTypes($estate->estate_type) }} در {{($estate->city->name ?? '')}}">
                    <img src="/upload/images/estate/{{ $url->url() }}" alt="{{$estate->title ?? l('اجاره اقامتگاه').estateTypes($estate->estate_type).' در '.($estate->city->name ?? '')}}">
                </a>
            @endif
            @if($len>6 && $count == $len)
            </div>
            @endif
            @endforeach
        </div>
    </section>
    <section class="container mb-5 pb-1">
    @else
    <section class="container pb-3 mt-6" >
    @endif
        <div class="row">
            <div class="col-md-7 mb-md-0 mb-4">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
                        <li class="breadcrumb-item"><a href="/rental">{{ l('جستجوی در اجاره کوتاه مدت') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$estate->title ?? l('اجاره اقامتگاه').estateTypes($estate->estate_type).' در '.($estate->city->name ?? '')}}</li>
                    </ol>
                </nav>
                <!-- Title -->
                <div class="d-flex align-items-center justify-content-between ">
                    <div>
                        <h1 class="h4 mb-2 font-vazir">کدملک: {{$estate->id}} | {{$estate->title ?? l('اجاره اقامتگاه').estateTypes($estate->estate_type).' در '.($estate->city->name ?? '')}} | {{$estate->{{ l('area}} متر مربع') }}</h1>
                        <p class="mb-2 pb-1 fs-md">&nbsp;</p>
                    </div>
                    <!--div>
                        <img src="/img/site2/avatars/17.png" class="img-thumbnail rounded-circle" alt="Circle image" width="75">
                    </div-->
                </div>
                <!-- Code -->
                <div class=" d-flex align-items-center gap-2 mb-3 d-none">
                    <span class="badge bg-primary">کد: {{$estate->id}}</span>
                    <!--span class="badge bg-secondary">{{ l('+5 رزرو موفق') }}</span>
                    <div class="d-flex align-items-center gap-2">
                        <div class="star-rating">
                            <i class="star-rating-icon fi-star-filled active"></i>
                            <i class="star-rating-icon fi-star-filled active"></i>
                            <i class="star-rating-icon fi-star-filled active"></i>
                            <i class="star-rating-icon fi-star-filled active"></i>
                            <i class="star-rating-icon fi-star-filled active"></i>
                        </div>
                        <div class="text-muted fs-xs mt-1">{{ l('5 (7نظر)') }}</div>
                    </div-->
                </div>
                <!--Box Details -->
                <div class="bg-secondary p-3 rounded-2 mb-4">
                    <div class="row">
                        <div class="col-3">
                            <div class="text-center">
                                <i class="fs-2 fi-real-estate-house"></i>
                                <p class="fw-bold fs-xs mb-0">{{estateTypesRental($estate->estate_type)}}</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center">
                                <i class="fs-2 fi-users"></i>
                                <p class="fw-bold fs-xs mb-0"> تا {{$estate->{{ l('max_person}} مهمان') }}</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center">
                                <i class="fs-2 fi-single-bed"></i>
                                <p class="fw-bold fs-xs mb-0"> {{ !empty($fieldList['room_count'][$estate->room_count]) && $fieldList['room_count'][$estate->room_count] != l('سوئیت') ? $fieldList['room_count'][$estate->{{ l('room_count] . l(\' اتاق\') : l(\'سوئیت\')}}') }}</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center ">
                                <i class="fs-2 fi-route"></i>
                                <p class="fw-bold fs-xs mb-0"> {{$estate->{{ l('area}} متر') }}</p>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- Overview-->
                <div class="mb-4  border-top border-bottom py-3">
                    <h3 class="h5 mb-3">{{ l('درباره اقامتگاه') }}</h3>
                    <p class="mb-1 line-h18">{{$estate->description}}</p>

                </div>
                <!-- Property Details-->
                <div class="mb-4 pb-md-3  border-bottom pb-3">
                    <h3 class="h5 mb-3">{{ l('مشخصات') }}</h3>
                    <ul class="list-unstyled mb-0 row row-cols-lg-3 row-cols-md-2 row-cols-2">
                        <li class="col"><b>{{ l('نوع ملک:') }}</b> {{estateTypes($estate->estate_type)}}</li>
                        <li class="col"><b>{{ l('متراژ زمین و محوطه اقامتگاه:') }}</b> {{$estate->{{ l('area}} مترمربع') }}</li>
                        <li class="col"><b>{{ l('مساحت زیربنا:') }}</b> {{$estate->{{ l('built_area}} مترمربع') }}</li>
                        <li class="col"><b>{{ l('تعداد اتاق:') }}</b> {{ !empty($fieldList['room_count'][$estate->room_count]) && $fieldList['room_count'][$estate->room_count] != l('سوئیت') ? $fieldList['room_count'][$estate->{{ l('room_count] . l(\' اتاق\') : l(\'سوئیت\')}}') }}</li>
                        @if (!empty($estate->wc))
                        <li class="col"><b>{{ l('سرویس بهداشتی:') }}</b> {{ $fieldList['wc'][$estate->wc] }}</li>
                        @endif
                        <!--li class="col"><b>{{ l('پارکینگ:') }}</b>{{ l('دارد') }}</li>
                        <li class="col"><b>{{ l('حیوانات خانگی مجاز:') }}</b>{{ l('فقط گربه') }}</li-->
                    </ul>
                </div>
                <!-- Room -->
                <div class="mb-4 pb-md-3 border-bottom pb-3 d-none">
                    <h3 class="h5 mb-3">
                        {{ l('فضای خواب') }}
                        <span class="badge bg-faded-dark fs-xs">{{ l('4 تا اتاق خواب') }}</span>
                    </h3>
                    <div class="row g-2 g-lg-3">
                        <div class="col-6 col-lg-3">
                            <div class="d-flex flex-column gap-1 border p-3 rounded align-items-center h-100">
                                <div class="d-flex gap-2">
                                    <i class="fs-4 fi-single-bed"></i>
                                </div>
                                <p class="mb-0 fs-xs fw-bold">{{ l('اتاق 1') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت یک نفره') }}</p>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="d-flex flex-column gap-1 border p-3 rounded align-items-center h-100">
                                <div class="d-flex gap-2">
                                    <i class="fs-4 fi-single-bed"></i>
                                    <i class="fs-4 fi-double-bed"></i>
                                </div>
                                <p class="mb-0 fs-xs fw-bold">{{ l('اتاق 2') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت یک نفره') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت دو نفره') }}</p>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="d-flex flex-column gap-1 border p-3 rounded align-items-center h-100">
                                <div class="d-flex gap-2">
                                    <i class="fs-4 fi-single-bed"></i>
                                </div>
                                <p class="mb-0 fs-xs fw-bold">{{ l('اتاق 1') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت یک نفره') }}</p>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="d-flex flex-column gap-1 border p-3 rounded align-items-center h-100">
                                <div class="d-flex gap-2">
                                    <i class="fs-4 fi-single-bed"></i>
                                    <i class="fs-4 fi-double-bed"></i>
                                </div>
                                <p class="mb-0 fs-xs fw-bold">{{ l('اتاق 2') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت یک نفره') }}</p>
                                <p class="mb-0 fs-xs">{{ l('1 تخت دو نفره') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Amenities-->
                <div class="mb-4 pb-md-3 border-bottom pb-3">
                    <h3 class="h5 mb-3">{{ l('امکانات رفاهی') }}</h3>
                    <ul class="list-unstyled row row-cols-lg-3 row-cols-md-2 row-cols-2 gy-1 mb-1 text-nowrap">
                        @if (!empty($estate->facilities))
                        @foreach (json_decode($estate->facilities, true) as $value)
                        @if (!empty(IconFacility($fieldList['facilities'][$value])))
                        <li class="col">
                            <!--<i class="text-[36px] text-gray-400 fa-thin fa-car-garage"></i>-->
                            @if (!empty(IconFacility($fieldList['facilities'][$value])))
                                <img src="/frontend/show/svg/{{ IconFacility($fieldList['facilities'][$value]) ?? '' }}.svg"
                                  alt="{{ l('امکانات ملک') }}"  width="32px" height="32px" />
                            @endif
                            {{l($fieldList['facilities'][$value]) }}
                        </li>
                        @endif
                        @endforeach
                        @endif
                        <!--li class="col"><i class="fi-wifi mt-n1 me-2 fs-lg align-middle"></i>{{ l('وای فای') }}</li-->
                        @if (!empty($estate->wc))
                        <li class="col">
                            @if (!empty(IconFacility($fieldList['wc'][$estate->wc] ?? '')))
                                <img src="/frontend/show/svg/{{ IconFacility($fieldList['wc'][$estate->wc] ?? '') }}.svg"
                                    width="28px" height="28px" alt="{{ l('امکانات ملک') }}"/>
                            @endif
                            {{ $fieldList['wc'][$estate->wc] }}
                        </li>
                    @endif
                    @if (!empty($estate->kitchen))
                        @foreach (json_decode($estate->kitchen, true) as $value)
                            <li class="col">
                                @if (!empty(IconFacility($fieldList['kitchen'][$value])))
                                    <img src="/frontend/show/svg/{{ IconFacility($fieldList['kitchen'][$value]) ?? '' }}.svg"
                                        width="28px" height="28px"  alt="{{ l('امکانات ملک') }}"/>
                                @endif
                                {{ $fieldList['kitchen'][$value] }}
                            </li>
                        @endforeach
                    @endif
                    @if (!empty($estate->heating_cooling))
                        @foreach (json_decode($estate->heating_cooling, true) as $value)
                            <li class="col">
                                @if (!empty(IconFacility($fieldList['heating_cooling'][$value])))
                                    <img src="/frontend/show/svg/{{ IconFacility($fieldList['heating_cooling'][$value]) ?? '' }}.svg"
                                        width="28px" height="28px" alt="{{ l('امکانات ملک') }}" />
                                @endif
                                {{ $fieldList['heating_cooling'][$value] }}
                            </li>
                        @endforeach
                    @endif
                    </ul>
                    @if (!empty($estate->conditions))
                    <div class="collapse" >
                        <ul class="list-unstyled row row-cols-lg-3 row-cols-md-2 row-cols-1 gy-1 mb-1 text-nowrap">
                            @foreach (json_decode($estate->conditions, true) as $value)
                                <li class="col">
                                    @if (!empty($fieldList['conditions'][$value]) &&  !empty(IconFacility($fieldList['conditions'][$value])))
                                        <img src="/frontend/show/svg/{{ IconFacility($fieldList['conditions'][$value]) ?? '' }}.svg"
                                            width="28px" height="28px" />
                                    @endif
                                </li>
                            @endforeach

                        </ul>
                    </div>

                    @endif
                </div>
                <!-- Cancel the reservation -->
                <div class="mb-4 pb-md-3 border-bottom pb-3">
                    <h3 class="h5 mb-3">{{ l('مقررات لغو رزرو') }}</h3>
                    @if($estate->sale_priority == 3)

                    <p>
                        <strong>{{ l('سیاست سختگیرانه:') }}</strong>
                        {{ l('در صورتی که رزرو, بیش از 5 روز کامل از تاریخ ورود لغو گردد, 10% صورتحساب به میزبان پرداخت می‏شود. درصورت لغو کمتر از 5 روز به تاریخ ورود، اجاره شب اول بعلاوه 40 درصد از شب‌های باقیمانده به میزبان پرداخت می شود.') }}
                    </p>
                    @elseif($estate->sale_priority == 2)
                    <p>
                        <strong>{{ l('سیاست متعادل:') }}</strong>
                        {{ l('در صورتی که رزرو, بیش از 3 روز کامل از تاریخ ورود لغو گردد, میزبان دریافتی ندارد. درصورت لغو کمتر از 3 روز به تاریخ ورود، اجاره شب اول به میزبان پرداخت می شود.') }}
                    </p>
                    @else
                    <p>
                        <strong>{{ l('سیاست سهلگیرانه:') }}</strong>
                      {{ l('در صورتی که رزرو، بیش از ۲۴ ساعت از تاریخ ورود لغو گردد میزبان دریافتی ندارد. درصورت لغو کمتر از 24 ساعت به تاریخ ورود، اجاره شب اول به میزبان پرداخت می شود.') }}
                    </p>
                    @endif
                </div>
                <!-- Regulation-->
                <div class="mb-4 pb-md-3 border-bottom pb-3">
                    <h3 class="h5 mb-3">{{ l('مقررات اقامتگاه') }}</h3>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="border rounded-2 p-3">
                            <p class="fs-xs mb-0"><i class="mx-1 fi-clock"></i>{{ l('ساعت ورود از') }}</p>
                            <p class="fw-bold fs-sm mb-0 text-center">{{ l('2 ظهر تا نامحدود') }}</p>
                        </div>
                        <div class="border rounded-2 p-3">
                            <p class="fs-xs mb-0"><i class="mx-1 fi-clock"></i>{{ l('ساعت خروج از') }}</p>
                            <p class="fw-bold fs-sm mb-0 text-center">{{ l('12 ظهر') }}</p>
                        </div>
                    </div>
                    <ul class="mx-3 d-none">
                        <li>{{ l('برگزاری مهمانی و پخش موزیک ممنوع است.') }}</li>
                        <li>{{ l('همراه داشتن حیوان خانگی ممنوع است.') }}</li>
                        <li>{{ l('استعمال دخانیات (سیگار، قلیان و ...) در داخل اقامتگاه ممنوع است.') }}</li>
                        <li><b>{{ l('مدارک مورد نیاز:') }}</b>{{ l('کارت ملی هوشمند یا شناسنامه') }}</li>
                        <li>{{ l('ویلا به صورت کاملا تمیز تحویل داده میشود و به همان صورت از شما مهمان عزیز تحویل گرفته میشود.') }}</li>
                        <li>{{ l('از پذیرش اکیپ مجردی پسرانه بیشتر از 2 نفر معذوریم.') }}</li>
                    </ul>
                </div>
                <!-- Map -->
                <div class="mb-4 pb-md-3 border-bottom pb-3">
                    <h3 class="h5 mb-3">{{ l('نقشه') }}</h3>
                    <div class="border rounded-2" style="height: 250px;">
                        @if (!empty($estate->latitude) && !empty($estate->longitude))
                            <div id="map" style="width: 100%;height:250px;"
                                class="leaflet-container leaflet-fade-anim leaflet-grab leaflet-retina leaflet-touch leaflet-touch-drag leaflet-touch-zoom map-container-show part--map z-depth-1-half h-[200px] w-full">
                            </div>
                        @endif
                    </div>
                    <script>
                        @if(!empty(Auth::User()) && (!empty($estate->expert_id==Auth::User()->id) || $currentUser->isAdmin()))
                            var map = L.map('map').setView([{{ $estate->latitude }} , {{ $estate->longitude }}], 13);
                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);
                            L.marker([{{ $estate->latitude }} , {{ $estate->longitude }}]).bindPopup('I am a green leaf.').addTo(map);

                        @else
                        var map = $('#map').kamaMap({
                            zoom: 14,
                            maxZoom: 18,
                            click_zoom: 14,
                            zoomControl: true,
                            lat: {{ $estate->latitude }},
                            lng: {{ $estate->longitude }}
                        });
                        map.showCircle({{ $estate->latitude }}, {{ $estate->longitude }}, 15, 100);
                        @endif
                    </script>
                </div>

                <!-- Comments -->
                <div class="d-none">
                    <div class="mb-4 pb-4 border-bottom">
                        <h3 class="h5 pb-3 font-vazir">
                            <i class="fi-star-filled mt-n1 me-2 lead align-middle text-warning"></i>{{ l('4,9 (32 نظر ثبت شده)') }}
                        </h3>
                        <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch justify-content-between ">
                            <a class="btn btn-outline-primary mb-sm-0 mb-3 d-flex align-items-center
                             gap-2" href="#modal-review" data-bs-toggle="modal">
                                <i class="fi-edit me-1"></i>{{ l('ثبت نظر') }}
                            </a>
                            <div class="d-flex align-items-center ms-sm-4">
                            <label class="me-2 pe-1 text-nowrap" for="reviews-sorting"><i class="fi-arrows-sort text-muted mt-n1 me-2"></i>{{ l('مرتب سازی براساس :') }}</label>
                            <select class="form-select" id="reviews-sorting">
                                <option>{{ l('جدیدترین') }}</option>
                                <option>{{ l('قدیمی ترین') }}</option>
                                <option>{{ l('پربازدید') }}</option>
                                <option>{{ l('امتیاز بالا') }}</option>
                                <option>{{ l('امتیاز پایین') }}</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex align-items-center pe-2 gap-2">
                                <img class="rounded-circle me-1" src="/img/site2/avatars/39.jpg" width="48" alt="Avatar" />
                              <div class="ps-2">
                                    <h6 class="fs-base mb-0">{{ l('علی رحیمی') }}</h6>
                                    <span class="star-rating">
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                    </span>
                               </div>
                            </div>
                            <span class="text-muted fs-sm">{{ l('14 شهریور , 1400') }}</span>
                        </div>
                        <p>{{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.') }}</p>
                        <div class="d-flex align-items-center">
                            <button class="btn-like" type="button"><i class="fi-like"></i><span>(3)</span></button>
                            <div class="border-end me-1">&nbsp;</div>
                            <button class="btn-dislike" type="button"><i class="fi-dislike"></i><span>(0)</span></button>
                        </div>
                    </div>
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex align-items-center pe-2 gap-2">
                                <img class="rounded-circle me-1" src="/img/site2/avatars/41.jpg" width="48" alt="Avatar" />
                              <div class="ps-2">
                                    <h6 class="fs-base mb-0">{{ l('فریبزر عرب نیا') }}</h6>
                                    <span class="star-rating">
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                    </span>
                               </div>
                            </div>
                            <span class="text-muted fs-sm">{{ l('14 شهریور , 1400') }}</span>
                        </div>
                        <p>{{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.') }}</p>
                        <div class="d-flex align-items-center">
                            <button class="btn-like" type="button"><i class="fi-like"></i><span>(3)</span></button>
                            <div class="border-end me-1">&nbsp;</div>
                            <button class="btn-dislike" type="button"><i class="fi-dislike"></i><span>(0)</span></button>
                        </div>
                    </div>
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex align-items-center pe-2 gap-2">
                                <img class="rounded-circle me-1" src="/img/site2/avatars/17.png" width="48" alt="Avatar" />
                              <div class="ps-2">
                                    <h6 class="fs-base mb-0">{{ l('مهدی رسولی اصل') }}</h6>
                                    <span class="star-rating">
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                        <i class="star-rating-icon fi-star-filled active"></i>
                                    </span>
                               </div>
                            </div>
                            <span class="text-muted fs-sm">{{ l('14 شهریور , 1400') }}</span>
                        </div>
                        <p>{{ l('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.') }}</p>
                        <div class="d-flex align-items-center">
                            <button class="btn-like" type="button"><i class="fi-like"></i><span>(3)</span></button>
                            <div class="border-end me-1">&nbsp;</div>
                            <button class="btn-dislike" type="button"><i class="fi-dislike"></i><span>(0)</span></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar-->
            <aside class="col-lg-4 col-md-5 ms-lg-auto pb-1">
                <!-- Contact card-->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark d-flex justify-content-between align-items-center text-white">
                        @if($estate->rent != 0)
                        <span class="fs-lg">{{ l('نرخ هر شب از:') }}</span>
                        <span class="fs-lg">
                            {{ toPersianNumbers($estate->rent) }} <span class="fs-xs">{{ l('تومان') }}</span>
                        </span>
                        @else
                        <b>{{ l('توافقی') }}</b>
                        @endif

                    </div>
                    <div class="card-body">
                        <div>
                            <div class="d-flex align-items-center gap-3 mb-3">

                                <a class="text-decoration-none" href="/">
                                <img class="rounded-circle mb-2" src="/img/site2/avatars/17.png" width="80" height="80" alt="">
                                </a>
                                <div>
                                    <h5 class="mb-1">
                                    <a class="nav-link" href="/" target="_blank">
                                    {{ l('گیلند ملک') }}
                                    </a>
                                    </h5>
                                    <p class="text-body mb-2">
                                    {{ l('تماس در ساعات اداری') }}
                                    </p>
                                    <a href="tel:09129406124" class="text-primary text-decoration-none mb-1 fs-sm">
                                        <i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i>
                                        09129406124
                                    </a>
                                    <a href="tel:09133386608" class="text-primary text-decoration-none mb-1 fs-sm">
                                        <i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i>
                                        09133386608
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a href="tel:09129406124" >
                        <button class="btn btn-lg btn-primary d-block w-100 mb-4" type="submit ">{{ l('درخواست رزرو') }}</button>
                        </a>
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <a href="#" class="btn btn-sm btn-outline-secondary "> <i class="fi-check-circle"></i>
                                {{ l('ضمانت تحویل') }}

                            </a>
                            <a href="#" class="btn btn-sm btn-outline-secondary "> <i class="fi-help"></i>
                                {{ l('راهنمای رزرو') }}
                            </a>
                        </div>
                    </div>
                </div>

            </aside>
        </div>
    </section>

    @if (count($similarEstates) > 0)
    <section class="container mb-5">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
            <h2 class="h4 mb-sm-0 font-vazir"> سایر اقامتگاه‌های {{ $estate->city->name ?? '' }}</h2>

        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside">
            <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 3, &quot;gutter&quot;: 24, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1400&quot;:{&quot;items&quot;:3,&quot;nav&quot;:false}}}">
                @foreach ($similarEstates as $estate)
                <!-- Item-->
                <div>
                    <div class="position-relative">
                        <div class="position-relative mb-3">
                            <button class="d-none btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ l('نشان کردن') }}"><i class="fi-heart"></i></button>
                            <img class="rounded-3" src="{{$estate->coverImage()}}" alt="اجاره روزانه {{ estateTypes($estate->estate_type) }} در {{($estate->city->name ?? '')}}" style="height: 250px;
                            object-fit: cover;width:100%">
                        </div>
                        <h3 class="mb-2 fs-lg"><a class="nav-link stretched-link" href="/room/{{ $estate->id }}">اجاره روزانه {{ estateTypes($estate->estate_type) }} در {{($estate->city->name ?? '')}}</a></h3>
                        <ul class="list-inline mb-0 fs-sm">
                            <li class="list-inline-item pe-1">
                                {{ !empty($fieldList['room_count'][$estate->room_count]) && $fieldList['room_count'][$estate->room_count] != l('سوئیت') ? $fieldList['room_count'][$estate->room_count] .' '. l('خوابه') : l('سوئیت') }} . {{$estate->area}} متر . تا {{$estate->{{ l('max_person}} مهمان') }}
                            </li>
                            <!--li class="list-inline-item pe-1"><i class="fi-star-filled mt-n1 me-1 fs-base text-warning align-middle"></i><b>5.0</b>
                                <span class="text-muted">{{ l('&nbsp;(48نظر)') }}</span>
                            </li-->
                            <li class="list-inline-item pe-1">
                                @if($estate->rent != 0)
                                <span class="fs-lg">{{ l('نرخ هر شب از:') }}</span>
                                <span class="fs-lg">
                                    {{ toPersianNumbers($estate->rent) }} <span class="fs-xs">{{ l('تومان') }}</span>
                                </span>
                                @else
                                <b>{{ l('توافقی') }}</b>
                                @endif

                            </li>

                        </ul>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    @endif

    <!-- Modal  -->
    <!-- Review modal-->
    <div class="modal fade" id="modal-review" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header d-block position-relative border-0 pb-0 px-sm-5 px-4">
              <h4 class="modal-title mt-4 text-center font-vazir">{{ l('ثبت نظر برای ملک') }}</h4>
              <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 px-4">
              <form class="needs-validation" novalidate>
                <div class="mb-3">
                  <label class="form-label" for="review-rating">{{ l('امتیازدهی') }}<span class='text-danger'>*</span></label>
                  <select class="form-control form-select" id="review-rating" required>
                    <option value="" selected disabled hidden>{{ l('امتیاز') }}</option>
                    <option value="5 stars">{{ l('5 ستاره') }}</option>
                    <option value="4 stars">{{ l('4 ستاره') }}</option>
                    <option value="3 stars">{{ l('3 ستاره') }}</option>
                    <option value="2 stars">{{ l('2 ستاره') }}</option>
                    <option value="1 star">{{ l('1 ستاره') }}</option>
                  </select>
                  <div class="invalid-feedback">{{ l('لطفاً به ملک امتیاز دهید.') }}</div>
                </div>
                <div class="mb-4">
                  <label class="form-label" for="review-text">{{ l('ثبت نظر') }}<span class='text-danger'>*</span></label>
                  <textarea class="form-control" id="review-text" rows="5" placeholder="{{ l('توضیحات') }}" required></textarea>
                  <div class="invalid-feedback">{{ l('نظر خود را ثبت کنید') }}</div>
                </div>
                <button class="btn btn-primary d-block w-100 mb-4" type="submit">{{ l('ثبت نظر') }}</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <!-- </section> -->
    @include(ss('THEME') . '.frontend.layouts.footer_rent', ['cssClass' => 'intro'])
</main>
@endsection

@section('js')


    <script src="/assets/vendors/fancybox/fancybox.umd.js"></script>

    <script>
        Fancybox.bind("[data-fancybox]");
    </script>
@endsection
