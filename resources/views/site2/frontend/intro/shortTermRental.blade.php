@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => l('اجاره ویلای روزانه و کوتاه مدت در گیلان'),
'metaDescription' => l('اجاره روزانه و کوتاه‌مدت در گیلان | اجاره ویلا، سوئیت و آپارتمان مبله در تمام نقاط گیلان | قیمت مناسب | پشتیبانی 24 ساعته | جستجو و مقایسه اقامتگاه‌ها'),
'canonical' => '/rental'
])

@section('head')
<style>
    .pic-fast {
        height: 120px;
    }

    /* Icon style with animation */
    .mobile-icon {
        display: inline-block;
        margin-right: 10px;
        font-size: 24px;
        animation: iconAnimation 1s infinite alternate;
        /* 1s duration, alternate direction */
    }

    /* Define the animation keyframes */
    @keyframes iconAnimation {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.2);
            /* You can adjust the scale factor */
        }
    }

    .back_card_state {
        position: relative;
        padding-top: 35px;
        padding-bottom: 35px;
        background-color: rgb(204, 0, 1);
        background-image: linear-gradient(rgba(204, 0, 1, 0.75), rgb(204, 0, 1)), url(/img/site2/home-discounted-rooms-bg.webp);
        background-size: 150px;
    }
    .tns3-item0 *{color:#fff !important}
</style>
@endsection

@section('main_content')
<main class="page-wrapper" style="background-color:#fff;">
    @include(ss('THEME') . '.frontend.layouts.header_rent')

    <section class="container py-5 mt-5 mb-lg-3">
        <div class="row align-items-center mt-md-2">
            <div class="col-lg-7 order-lg-2 mb-lg-0 mb-4 pb-2 pb-lg-0">
                <img class="d-block mx-auto" src="/img/site2/hero-img.jpg" width="746" alt="Hero image">
            </div>
            <div class="col-lg-5 order-lg-1 pe-lg-0">
                <a href="/rental" title="{{ l('اجاره ویلای روزانه و کوتاه مدت در گیلان') }}">
                    <h1 class="display-4 mb-4 ms-lg-n5 text-lg-start text-right" style="line-height: unset;font-weight:500">{{ l('اجاره ویلای روزانه و کوتاه مدت در گیلان') }}

                    </h1>
                </a>
                <p class="text-lg-start text-right mb-4 mb-lg-3 fs-lg">{{ l('جستجوی خود را آغاز کنید - مقصدتان کجاست؟') }}</p>
                <!-- Search form-->
                <div class="ms-lg-n5">
                    <form class="form-group d-block d-md-flex position-relative rounded-md-pill me-lg-n5" method="get" action="/rental/search">
                        <div class="input-group input-group-lg border-end-md">
                            <span class="input-group-text text-muted rounded-pill ps-3"><i class="fi-search"></i></span>
                            <select id="city_id" name="city_id" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 ">
                                <option value="">{{ l('میخواهید کجا بری؟') }}</option>
                                @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr class="d-md-none my-2">
                        <div class="input-group input-group-lg border-end-md">
                            <span class="input-group-text text-muted rounded-pill ps-3"><i class="fi-friends"></i></span>
                            <select id="max_person" name="max_person" class="btn btn-sm btn-link dropdown-toggle p-0 p-lg-2 ps-2 ps-sm-3 ">
                                <option value="">{{ l('چند نفرید؟') }}</option>
                                <option value="1">{{ l('1 نفر') }}</option>
                                <option value="2">{{ l('2 نفر') }}</option>
                                <option value="3">{{ l('3 نفر') }}</option>
                                <option value="4">{{ l('4 نفر') }}</option>
                                <option value="5">{{ l('5 نفر') }}</option>
                                <option value="6">{{ l('6 نفر') }}</option>
                                <option value="7">{{ l('7 نفر') }}</option>
                                <option value="8">{{ l('8 نفر') }}</option>
                                <option value="9">{{ l('9 نفر') }}</option>
                                <option value="10">{{ l('10 نفر') }}</option>
                                <option value="11">{{ l('11 نفر') }}</option>
                                <option value="12">{{ l('12 نفر') }}</option>
                                <option value="13">{{ l('13 نفر') }}</option>
                                <option value="14">{{ l('14 نفر') }}</option>
                                <option value="15">{{ l('15 نفر') }}</option>
                            </select>
                            <button class="btn btn-primary btn-lg rounded-pill w-100 w-md-auto me-sm-3" type="submit">{{ l('جستجو') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-primary mb-5">
        <div class="container py-5">
            <div class="d-flex flex-column flex-lg-row gap-4 justify-content-between align-items-center">
                <h2 class="mb-0 text-white mt-4 mt-md-0">{{ l('با ثبت ملک خود در گیلندملک درآمد کسب کنید') }}</h2>
                <div class="d-flex align-items-center gap-4">
                    <div class="text-white d-flex gap-2">
                        <a href="/rental/host" class="btn btn-light fw-bold ">{{ l('ثبت اقامتگاه') }}</a>
                        <a href="tel:09133386608" class="btn btn-light fw-bold ">{{ l('شماره تماس') }}</a>

                    </div>
                    <a href="#" class="text-decoration-none">
                        <i class="fi-phone text-white fs-3 mobile-icon"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="container pt-3 mb-5">
        <div>
            <h2 class="fs-5 mb-4 d-none">{{ l('دسترسی های سریع') }}</h2>
            <div>
                <!-- Responsive with multiple items + Controls and nav outside -->
                <div class="tns-carousel-wrapper  tns-nav-outside">
                    <div class="tns-carousel-inner" data-carousel-options="{&quot;nav&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1, &quot;gutter&quot;: 16},&quot;420&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 16},&quot;700&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20},&quot;850&quot;:{&quot;items&quot;:4, &quot;gutter&quot;: 20},&quot;1300&quot;:{&quot;nav&quot;: false, &quot;items&quot;:5, &quot;gutter&quot;: 24}}}">
                        <div class="">
                            <div class="position-relative">
                                <div class="rounded-3 mb-3 position-relative">
                                    <span class="img-gradient-overlay rounded-3"></span>
                                    <a class="nav-link stretched-link p-0 text-white fw-bold" href="/rental/search?position_type=293">
                                        <img class="d-block mx-auto rounded-3 w-100 h-100" src="/img/site2/card/cottageForest.jpg" alt="{{ l('اجاره روزانه ویلای جنگلی در گیلان') }}">
                                    </a>
                                    <div class="start-0 bottom-0 text-center end-0 mb-3 zindex-1" style="position: absolute;">
                                        <a class="nav-link stretched-link p-0 text-white fw-bold" href="/rental/search?position_type=293">{{ l('جنگلی') }}</a>
                                        <!--span class="fs-sm text-white fw-bold opacity-60 fs-xs">{{ l('15 اقامتگاه') }}
                                        </span-->
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="">
                            <div class="position-relative">
                                <div class="rounded-3 mb-3 position-relative">
                                    <span class="img-gradient-overlay rounded-3"></span>
                                    <a class="nav-link stretched-link p-0 text-white fw-bold" href="/rental/search?position_type=292">
                                        <img class="d-block mx-auto rounded-3 w-100 h-100" src="/img/site2/card/waterfront.jpg" alt="{{ l('اجاره روزانه ویلای ساحلی در گیلان') }}">
                                    </a>
                                    <div class="start-0 bottom-0 text-center end-0 mb-3 zindex-1" style="position: absolute;">
                                        <a class="nav-link stretched-link p-0 text-white fw-bold" href="/rental/search?position_type=292">{{ l('ساحلی') }}</a>
                                        <!--span class="fs-sm text-white fw-bold opacity-60 fs-xs">{{ l('113 اقامتگاه') }}</span-->
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="">
                            <div class="position-relative">
                                <div class="rounded-3 mb-3 position-relative">
                                    <span class="img-gradient-overlay rounded-3"></span>
                                    <a class="nav-link stretched-link p-0 text-white fw-bold" href="/rental/search?facilities=39">
                                        <img class="d-block mx-auto rounded-3 w-100 h-100" src="/img/site2/card/jacuzzi.jpg" alt="{{ l('اجاره روزانه ویلای استخردار در گیلان') }}">
                                    </a>
                                    <div class="start-0 bottom-0 text-center end-0 mb-3 zindex-1" style="position: absolute;">
                                        <a class="nav-link stretched-link p-0 text-white fw-bold" href="/rental/search?facilities=39">{{ l('ویلای استخردار') }}</a>
                                        <!--span class="fs-sm text-white fw-bold opacity-60 fs-xs">{{ l('17 اقامتگاه') }}</span-->
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="">
                            <div class="position-relative">
                                <div class="rounded-3 mb-3 position-relative">
                                    <span class="img-gradient-overlay rounded-3"></span>
                                    <a class="nav-link stretched-link p-0 text-white fw-bold" href="/rental/search?condition=361">
                                        <img class="d-block mx-auto rounded-3 w-100 h-100" src="/img/site2/card/ruralhome.jpg" alt="{{ l('اجاره روزانه ویلای مناسب جشن و تولد در گیلان') }}">
                                    </a>
                                    <div class="start-0 bottom-0 text-center end-0 mb-3 zindex-1" style="position: absolute;">
                                        <a class="nav-link stretched-link p-0 text-white fw-bold" href="/rental/search?condition=361">{{ l('جشن و تولد') }}</a>
                                        <!--span class="fs-sm text-white fw-bold opacity-60 fs-xs">{{ l('17 اقامتگاه') }}</span-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="position-relative">
                                <div class="rounded-3 mb-3 position-relative">
                                    <span class="img-gradient-overlay rounded-3"></span>
                                    <a class="nav-link stretched-link p-0 text-white fw-bold" href="/rental/search?estate_type=10">
                                        <img class="d-block mx-auto rounded-3 w-100 h-100" src="/img/site2/card/mountain.jpg" alt="{{ l('اجاره روزانه هتل و مهمان پذیر در گیلان') }}">
                                    </a>
                                    <div class="start-0 bottom-0 text-center end-0 mb-3 zindex-1" style="position: absolute;">
                                        <a class="nav-link stretched-link p-0 text-white fw-bold" href="/rental/search?estate_type=10">{{ l('هتل و مهمان پذیر') }}</a>
                                        <!--span class="fs-sm text-white fw-bold opacity-60 fs-xs">{{ l('17 اقامتگاه') }}</span-->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (!empty($estateAnzal) && count($estateAnzal)>0)
    <section class="container my-5 ">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
            <h2 class="h4 mb-sm-0 font-vazir">{{ l('اجاره روزانه در بندرانزلی') }}</h2>
            <a class="btn btn-link fw-normal ms-sm-3 p-0" href="/rental/search?city_id=92">{{ l('مشاهده همه') }}<i class="fi-arrow-long-left ms-2"></i></a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside">
            <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 3, &quot;gutter&quot;: 24, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1400&quot;:{&quot;items&quot;:3,&quot;nav&quot;:false}}}">
                @foreach($estateAnzal as $estate)
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
                                @if($estate->{{ l('rent != 0) هر شب از') }}
                                <b>{{toPersianNumbers($estate->{{ l('rent)}} تومان') }}</b>
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
    @if (!empty($estateRezvan) && count($estateRezvan)>0)
    <section class=" mb-5 back_card_state py-5 tns3-item0">
        <div class="container">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
                <h2 class="h4 mb-sm-0 font-vazir text-white">{{ l('اجاره روزانه در رضوانشهر') }}</h2>
                <a class="btn btn-link fw-normal ms-sm-3 p-0 text-white" href="/rental/search?city_id=440">{{ l('مشاهده همه') }}<i class="fi-arrow-long-left ms-2"></i></a>
            </div>
            <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside">
                <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 3, &quot;gutter&quot;: 24, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1400&quot;:{&quot;items&quot;:3,&quot;nav&quot;:false}}}">
                    @foreach($estateRezvan as $estate)
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
                                @if($estate->{{ l('rent != 0) هر شب از') }}
                                <b>{{toPersianNumbers($estate->{{ l('rent)}} تومان') }}</b>
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
        </div>
    </section>
    @endif
    @if (!empty($estatePareh) && count($estatePareh)>0)
    <section class="container my-5">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
            <h2 class="h4 mb-sm-0 font-vazir">{{ l('اجاره روزانه در پره‌سر') }}</h2>
            <a class="btn btn-link fw-normal ms-sm-3 p-0" href="/rental/search?city_id=594">{{ l('مشاهده همه') }}<i class="fi-arrow-long-left ms-2"></i></a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside">
            <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 3, &quot;gutter&quot;: 24, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1400&quot;:{&quot;items&quot;:3,&quot;nav&quot;:false}}}">
                @foreach($estatePareh as $estate)
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
                                @if($estate->{{ l('rent != 0) هر شب از') }}
                                <b>{{toPersianNumbers($estate->{{ l('rent)}} تومان') }}</b>
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
    <section class="container mb-5 pt-2 pt-lg-4">
        <h2 class="fs-5 mb-4">{{ l('چرا از گیلندملک ویلا اجاره روزانه کنیم؟') }}</h2>
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4 justify-content-center">
            <!-- Feature item-->
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-success text-success rounded-circle mb-3"><i class="fi-users"></i></div>
                            <h3 class="h5 card-title">{{ l('پشتیبانی 24 ساعته') }}</h3>
                        </div>
                        <p class="card-text fs-sm text-justify">
                            {{ l('در هر ساعت از شبانه ‌روز می‌توانید از طریق تلفن با پشتیبانی گیلند ملک برای اجاره کوتاه مدت ارتباط برقرار کنید.') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-info text-info rounded-circle mb-3"><i class="fi-like"></i></div>
                            <h3 class="h5 card-title">{{ l('خدمات تضمین شده') }}</h3>
                        </div>
                        <p class="card-text fs-sm text-justify">
                            {{ l('امکانات و خدمات اقامتگاه ها به صورت منظم بررسی می شود تا مطابق با شرایط اعلام شده باشند. علاوه بر اجاره ویلا می توانید') }} <a href="/">{{ l('سرمایه گذاری در شمال') }}</a> {{ l('را نیز تجربه کنید.') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-warning text-warning rounded-circle mb-3"><i class="fi-checkbox-checked-alt"></i></div>
                            <h3 class="h5 card-title">{{ l('میزبان های تایید شده') }}</h3>
                        </div>
                        <p class="card-text fs-sm text-justify">
                            {{ l('قبل از تایید یک اقامتگاه برای نمایش در سایت، مدارک هویتی میزبان و اقامتگاه به صورت دقیق بررسی می شوند.') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body icon-box">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3"><i class="fi-heart"></i></div>
                            <h3 class="h5 card-title">{{ l('متمرکز در گیلان') }}</h3>
                        </div>
                        <p class="card-text fs-sm text-justify">
                            {{ l('گیلند ملک اولین سایت تخصصی می باشد که به صورت متمرکز در') }} <a href="/rental">{{ l('اجاره کوتاه مدت') }}</a> {{ l('و املاک در گیلان فعالیت می کند.') }}
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </section>
    <section class="container my-5 py-lg-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
            <h2 class="h4 mb-sm-0 font-vazir">{{ l('جاذبه های دیدنی بهشت ایران استان گیلان') }}</h2>
            <a class="btn btn-link fw-normal ms-sm-3 p-0" href="/blog">{{ l('لیست مقالات') }}<i class="fi-arrow-long-left ms-2"></i></a>
        </div>
        <!-- Carousel-->
        <div class="tns-carousel-wrapper tns-nav-outside mb-md-2">
            <div class="tns-carousel-inner d-block" data-carousel-options="{&quot;controls&quot;: false, &quot;gutter&quot;: 24, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:3}}}">
                <!-- Item-->
                @foreach( $articles as $item)
                <article>
                    <a class="d-block mb-3 " href="{{$item->url()}}">
                        <img class="rounded-3" src="{{$item->img()}}" alt="{{$item->title}}" style="height: 250px; object-fit: cover;">
                    </a>
                    <a class="text-uppercase text-decoration-none fs-xs" href="/blog">{{ l('گردشگری') }}</a>
                    <h3 class="fs-lg pt-1 mb-2">
                        <a class="nav-link" href="{{$item->url()}}">
                            {{$item->title}}
                        </a>
                    </h3>
                    <a class="d-flex align-items-center text-decoration-none" href="{{$item->url()}}">
                        <img class="rounded-circle d-none" src="{{$item->img()}}" width="44" alt="{{$item->title}}">
                        <div class="pe-2">
                            <!--h6 class="fs-sm text-nav lh-base mb-1">{{ l('زهرا سعیدی') }}</h6>
                            <div class="d-flex text-body fs-xs">
                                <span class="me-2 pe-1">
                                    <i class="fi-calendar-alt opacity-70 mt-n1 ms-1 align-middle"></i>{{ l('24 اردیبهشت') }}
                                </span>
                                <span>
                                    <i class="fi-chat-circle opacity-70 mt-n1 ms-1 align-middle"></i>{{ l('0 نظر') }}
                                </span>
                            </div-->
                        </div>
                    </a>
                </article>
                @endforeach


            </div>
        </div>
    </section>
    <!-- FAQ-->
    <section class="container">
        <img class="rounded-3" src="/img/site2/gisom.jpg" alt="Cover">
        <div class="col-md-10 mx-md-auto mx-3 mt-sm-0 mt-5 py-sm-5 py-4 px-0 rounded-3 bg-white shadow-sm" style="transform: translateY(-100px);">
            <div class="col-md-10 mx-md-auto mx-3 py-lg-4 px-0">
                <h2 class="h3 mb-4 pb-lg-2 text-center">{{ l('سوالات متداول') }}</h2>
                <div class="accordion" id="accordionFAQ">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                            {{ l('چطور ویلا رزرو کنم؟') }}
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse show" aria-labelledby="heading-1" data-bs-parent="#accordionFAQ" id="collapse-1">
                            <div class="accordion-body text-justify">
                            {{ l('پس از مشخص کردن تاریخ ورود و خروج و تعداد نفرات، درخواست رزرو خود را به‌صورت رایگان با تماس با کارشناس مربوطه ثبت کنید. میزبان در صورت خالی بودن و مهیا بودن اقامتگاه، رزرو را تایید می‌کند. سپس پیامکی مبنی بر تایید رزرو برای شما ارسال می‌شود و شما حداکثر 30 دقیقه فرصت خواهید داشت تا با پرداخت مبلغ صورتحساب، رزرو را قطعی کرده و سند رزرو حاوی صورتحساب، شماره تماس میزبان، آدرس اقامتگاه و سایر اطلاعات رزرو را دریافت کنید. در صورت خالی بودن و مهیا بودن اقامتگاه رزرو تائید می شود. سپس پیامکی مبنی بر تائید ملک برای شما ارسال می شود و شما حداکثر 15 دقیقه فرصت دارید که با پرداخت مبلغ صورتحساب رزرو را قطعی کنید.') }}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">{{ l('چطور می‌توانم با میزبان تماس بگیرم؟') }}</button>
                        </h2>
                        <div class="accordion-collapse collapse" aria-labelledby="heading-2" data-bs-parent="#accordionFAQ" id="collapse-2">
                            <div class="accordion-body text-justify">
                            {{ l('در هنگام ثبت l("درخواست رزرو") می‌توانید با کارشناسان گیلند ملک در مورد اقامتگاه صحبت کنید و همچنین پس از پرداخت صورتحساب و قطعی شدن رزرو در یک سند که حاوی مشخصات, شماره تماس میزبان و آدرس اقامتگاه می باشد, برای شما صادر می شود و شما می توانید با میزبان خود تماس بگیرید. همچنین پس از پرداخت صورتحساب و قطعی شدن رزرو، یک سند رزرو حاوی مشخصات، شماره تماس میزبان و آدرس اقامتگاه برای شما صادر می‌شود و میتوانید با میزبان خود تماس بگیرید.') }}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                            {{ l('با رد یا لغو شدن درخواست رزرو چه می‌شود؟') }}
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse" aria-labelledby="heading-3" data-bs-parent="#accordionFAQ" id="collapse-3">
                            <div class="accordion-body text-justify">
                            {{ l('زمانی که اقامگاه پر باشد بعد از تماس با کارشناس گیلند ملک می توانید برای اقامتگاه دیگری درخواست رزرو ثبت کنید. همچنین شما می توانید همزمان دو یا چند اقامتگاه باهم درخواست رزرو بدهید و تماس بگیرید.') }}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                            {{ l('تایید یا رد درخواست رزرو چقدر طول می‌کشد؟') }}
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse" aria-labelledby="heading-4" data-bs-parent="#accordionFAQ" id="collapse-4">
                            <div class="accordion-body text-justify">
                            {{ l('به‌طور میانگین در کمتر از 15 دقیقه به درخواست ها پاسخ داده می‌شود. سابقه زمان پاسخگویی هر کارشناس به درخواست میهمان و هماهنگی با میزبان در کمتر از 30 دقیقه انجام می شود. حداکثر مهلت پاسخگویی میزبانان به درخواست رزرو در ساعات کاری 30 دقیقه است و در ساعات نیمه شب مهلت پاسخگویی تا صبح روز بعد تمدید می‌گردد.') }}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                                {{ l('چه ضمانتی برای تحویل اقامتگاه وجود دارد؟') }}
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse" aria-labelledby="heading-5" data-bs-parent="#accordionFAQ" id="collapse-5">
                            <div class="accordion-body text-justify">
                            {{ l('بطور خلاصه کل مبلغ رزرو به شماره کارت مجموعه گیلند ملک پرداخت می شود و گیلند ملک مبلغ رزرو را در روز بعد از شروع رزرو به میزبان پرداخت میکند. لذا مهمان فرصت کافی دارد تا مشکلاتی از قبیل عدم تحویل اقامتگاه رزرو شده و یا عدم مطابقت اقامتگاه تحویل داده شده را از طریق سایت به مجموعه گیلند ملک گزارش دهد. همچین مقررات سختگیرانه ای برای میزبان شدن در گیلند ملک وجود دارد که احتمال بروز مشکلات این چنینی را به حداقل کاهش میدهد.') }}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-6" aria-expanded="false" aria-controls="collapse-6">
                            {{ l('آیا می‌توانم رزرو را قبل یا بعد از تأیید کنسل کنم؟') }}
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse" aria-labelledby="heading-6" data-bs-parent="#accordionFAQ" id="collapse-6">
                            <div class="accordion-body text-justify">
                            {{ l('بله، شما می‌توانید «یک مرتبه» درخواست رزرو خود را قبل یا پس از تایید میزبان لغو کنید و درخواست دیگری را ثبت کنید ولی در صورت تکرار لغو رزرو برای بار دوم دیگر قادر به ثبت درخواست نخواهید بود. لذا در ثبت درخواست رزرو دقت لازم را به عمل آورید و با لغو رزرو مکرر موجب بی‌اعتمادی میزبان‌ها نشوید.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container mb-5 pb-lg-5">
        <div class="py-md-4 py-5 bg-secondary rounded-3">
            <div class="col-sm-10 col-11 d-flex flex-md-row flex-column align-items-center justify-content-between mx-auto px-0">
                <div class="order-md-1 order-2 text-md-start text-center" style="max-width: 524px;">
                    <h2 class="mb-4 pb-md-3 ">{{ l('پاسخ سوال خود را هنوز پیدا نکرده اید؟') }}<br>{{ l('ما میتوانیم به شما کمک کنیم.') }}</h2>
                    <a class="btn btn-lg btn-primary rounded-pill w-sm-auto w-100" href="tel:09133386608">{{ l('تماس با ما') }}</a>
                </div>
                <img class="order-md-2 order-1 ms-md-4 rotate-img" src="/img/site2/support.svg" alt="Illustration">
            </div>
        </div>
    </section>

    <section class="container">
        <h2 class="h3 mb-4 pb-lg-2 text-center">{{ l('اجاره ویلا، آنلاین و مطمئن در گیلندملک') }}</h2>
        <div class="mb-5">
            <p class="w-75 text-justify m-auto ">
                {{ l('وقتی در سفر به شمالی یا حال خوب داری یا به دنبال حال خوب هستی و دنبال اقامتی راحت و لذت بخش در طبیعت زیبای شمال می گردی. اجاره ویلا در گیلان با گیلندملک بهترین گزینه برای تجربه یک سفر شمالی خوشایند و لذت بخش است. اینجا دستت برای اجاره ویلا در هر جای بهشت ایران استان گیلان و با هر امکاناتی بازه ؛ به فکر اجاره ویلا در شمال برای خوشگذرانی لب دریا هستی؟ یک کلبه جنگلی دنج یا ویلا استخردار برای سفر با دوستان می‌خواهی؟ شاید هم یک کلبه سوییسی در دل جنگل می خوای برای سفر خانوادگی؟گیلندملک اینجاست که به شما کمک کند به همراه عزیزانتان لحظاتی شاد و خاطره‌انگیز را در آغوش طبیعت زیبای بهشت ایران استان گیلان سپری کنید و از این سفر به یاد ماندنی لذت ببرید و هم سرمایه گذاری سودآوری تجربه کنید.') }}

            </p>
        </div>
    </section>
    @include(ss('THEME') . '.frontend.layouts.footer_rent', ['cssClass' => 'intro'])
</main>
@endsection

@section('js')
@endsection
