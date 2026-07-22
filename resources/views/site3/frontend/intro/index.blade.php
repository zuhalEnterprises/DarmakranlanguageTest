@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => l('کومه - خرید و فروش املاک قم'),
'metaDescription' => l('املاک خرید و فروش در قم - املاک خرید و فروش در پردیسان, جمهوری, شهرک قدس, سالاریه, کریمی, انسجام, زنبیل آباد و فردوسی قم'),
'canonical' => 'https://hoomeh.ir',
'metaKeyword' => l('املاک قم, آپارتمان قم, ویلایی در قم, املاک پردیسان, قیمت ملک در قم, خرید ملک در قم, اجاره در قم,')
])
@section('head')


@endsection
@section('main_content')
<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')
    <section class="container-fluid pt-0 pt-lg-5 pb-lg-4 px-xxl-4 my-5" style="padding-left: 0px !important;padding-right:0px !important">
        <div class="jarallax card align-items-center  justify-content-md-center border-0 p-md-5 p-4 bg-secondary mt-n3 height-hero" style="border-radius:unset; " data-jarallax data-speed="0.5">
            @php
            $screen = new \Jenssegers\Agent\Agent;
            @endphp

            @if ($screen->isMobile())
            <video class="videomobile " autoplay="" muted="" loop="" width="320" height="190">
                <source src="/img/site3/{{rand(1,8)}}.mp4" type="video/mp4">
            </video>
            @else
            <video class="videodesktop" autoplay="" muted="" loop="" style="width:100%">
                <source src="/img/site3/{{rand(1,8)}}.mp4" type="video/mp4">
            </video>
            @endif

            <!-- <span class="img-overlay opacity-40"></span> -->
            <div class="content-overlay" style="max-width: 856px;">
                <h1 class="display-5 mb-md-5 pb-md-5 pb-md-3 px-md-3 text-white text-center">
                    <span style="color:gold">
                        {{ l('کومه') }}
                    </span>
                    {{ l('میانبری به سمت ملک دلخواه شما') }}
                </h1>
                <div class="box box1 animate__animated animate__bounceIn d-flex flex-wrap align-items-center gap-3 justify-content-center mt-3 ">
                    <div class="widget-property-type-banner ">
                        <a class="type-banner-property style2 text-warning" href="/c/qom?type=1">
                            <i class="fi-cash fs-2"></i>
                            <h4 class="text-warning">
                                {{ l('فروش') }}
                            </h4>
                        </a>
                    </div>
                    <div class="widget-property-type-banner ">
                        <a class="type-banner-property style2 text-warning" href="/c/qom?type=2">
                            <i class="fi-rent fs-2"></i>
                            <h4 class="text-warning">
                                {{ l('اجاره') }}
                            </h4>
                        </a>
                    </div>
                    <div class="widget-property-type-banner ">
                        <a class="type-banner-property style2 text-warning" href="/add">
                            <i class="fi-house-chosen fs-2"></i>
                            <h4 class="text-warning">
                                {{ l('ثبت ملک') }}
                            </h4>
                        </a>
                    </div>
                    <div class="widget-property-type-banner ">
                        <a class="type-banner-property style2 text-warning" href="/customers/create">
                            <i class="fi-billboard-house fs-2"></i>
                            <h4 class="text-warning">
                                {{ l('ثبت تقاضا') }}
                            </h4>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="container  pb-4 new-estate" style="display:none">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0 ">{{ l('املاک دارای تور مجازی') }}</h2>
            <a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?vr=1">
                {{ l('مشاهده همه') }} <i class="fi-arrow-long-left ms-2"></i>
            </a>
        </div>
        <div class="row g-4">
            @php
            $count = 0;
            @endphp
            @if(count($estatespecial)>=3)
            @foreach ($estatespecial as $estate)
            @php
            $count++;
            @endphp
            @if($count == 1)
            <div class="col-md-6">
                <div class="card bg-size-cover bg-position-center border-0 overflow-hidden mb-4" style="background-image: url({{$estate->coverImage()}});">
                    <span class="img-gradient-overlay"></span>
                    <a class="bg-none img-gradient-overlay zindex-10" href="{{$estate->url()}}" title="{{$estate->title}}"></a>
                    <div class="card-body  pb-0">
                        <span class="badge bg-info fs-sm">{{toPersianDate($estate->showdate)}}</span>
                    </div>
                    <div class="card-footer content-overlay border-0 pt-0 pb-4" style="transform: translateY(0px) !important;">
                        <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5">
                            <a class="text-decoration-none text-light pe-2" href="{{$estate->url()}}" title="{{$estate->title}}">
                                <div class="fs-sm text-uppercase pt-2 mb-1">
                                    @if($estate->type==1) {{l('فروش')}} @else {{l('رهن و اجاره')}} @endif
                                    {{estateTypes($estate->estate_type)}}
                                </div>
                                <h3 class="h5 text-light mb-1">
                                    {{!empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) . l('در') . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? '')}}
                                </h3>
                                <div class="fs-sm opacity-70">
                                    <i class="fi-map-pin ms-1"></i>{{$estate->city->name??""}}، {{$estate->district->name??""}}
                                </div>
                            </a>
                            <div class="btn-group ms-n2 ms-sm-0 mt-3"><a class="btn btn-primary px-3" href="{{$estate->url()}}" title="{{$estate->title}}" style="height: 2.75rem;">قیمت: {{ toPersianNumbers($estate->price) }} {{l('تومان')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($count == 2)
                <div class="card bg-size-cover bg-position-center border-0 overflow-hidden" style="background-image: url({{$estate->coverImage()}});">
                    <span class="img-gradient-overlay"></span>
                    <a class="bg-none img-gradient-overlay zindex-10" href="{{$estate->url()}}" title="{{$estate->title}}"></a>
                    <div class="card-body  pb-0">
                        <span class="badge bg-info fs-sm">{{toPersianDate($estate->showdate)}}</span>
                    </div>
                    <div class="card-footer content-overlay border-0 pt-0 pb-4" style="transform: translateY(0px) !important;">
                        <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5">
                            <a class="text-decoration-none text-light pe-2" href="{{$estate->url()}}" title="{{$estate->title}}">
                                <div class="fs-sm text-uppercase pt-2 mb-1">
                                    @if($estate->type==1) {{l('فروش')}} @else {{l('رهن و اجاره')}} @endif
                                    {{estateTypes($estate->estate_type)}}
                                </div>
                                <h3 class="h5 text-light mb-1">{{!empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) . l('در') . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? '')}}</h3>
                                <div class="fs-sm opacity-70">
                                    <i class="fi-map-pin ms-1"></i>{{$estate->city->name??""}}، {{$estate->district->name??""}}
                                </div>
                            </a>
                            <div class="btn-group ms-n2 ms-sm-0 mt-3">
                                <a class="btn btn-primary px-3" href="{{$estate->url()}}" title="{{$estate->title}}" style="height: 2.75rem;">قیمت: {{ toPersianNumbers($estate->price) }} {{l('تومان')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($count == 3)
            <div class="col-md-6">
                <div class="card bg-size-cover bg-position-center border-0 overflow-hidden h-100" style="background-image: url({{$estate->coverImage()}});">
                    <span class="img-gradient-overlay"></span>
                    <a class="bg-none img-gradient-overlay zindex-10" href="{{$estate->url()}}" title="{{$estate->title}}"></a>
                    <div class="card-body  pb-0">
                        <div class="d-flex">
                            <span class="badge bg-success fs-sm me-2"></span>
                            <span class="badge bg-info fs-sm">{{toPersianDate($estate->showdate)}}</span>
                        </div>
                    </div>
                    <div class="card-footer content-overlay border-0 pt-0 pb-4" style="transform: translateY(0px) !important;">
                        <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5">
                            <a class="text-decoration-none text-light pe-2" href="{{$estate->url()}}" title="{{$estate->title}}">
                                <div class="fs-sm text-uppercase pt-2 mb-1">
                                    @if($estate->type==1) {{l('فروش')}} @else {{l('رهن و اجاره')}} @endif
                                    {{estateTypes($estate->estate_type)}}
                                </div>
                                <h3 class="h5 text-light mb-1">{{!empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) . l('در') . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? '')}}</h3>
                                <div class="fs-sm opacity-70">
                                    <i class="fi-map-pin ms-1"></i>{{$estate->city->name??""}}، {{$estate->district->name??""}}
                                </div>
                            </a>
                            <div class="btn-group ms-n2 ms-sm-0 mt-3">
                                <a class="btn btn-primary px-3" href="{{$estate->url()}}" title="{{$estate->title}}" style="height: 2.75rem;">قیمت: {{ toPersianNumbers($estate->price) }} {{l('تومان')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endif
        </div>
    </section>
    <section class="container  pb-4" >
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0 ">{{ l('جدیدترین املاک خرید و فروش') }}</h2>
            <a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?type=1">
                {{ l('مشاهده همه') }} <i class="fi-arrow-long-left ms-2"></i>
            </a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2" dir="ltr">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                <!-- Item-->
                @foreach ($estates as $estate)
                <div class="col">
                    @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="bg-primary mb-5" >
        <div class="container py-5">
            <div class="d-flex flex-column flex-lg-row gap-4 justify-content-between align-items-center">

                <p class="mb-2 text-white fs-5">
                    <a href=l("/blog/346/کومه-یعنی-چه؟") style="color: unset">
                    {{ l('درباره واژه') }}
                    <span class="fs-4" style="color:gold">
                    {{ l('کومه') }}
                    </span>
                     {{ l('بیشتر بدانیم:') }}
                    </a>
                </p>
                <p class="mb-2 text-white fs-6 text-center">
                    <a href=l("/blog/346/کومه-یعنی-چه؟") style="color: unset">
                        {{ l('ریشه نام شهر قم به') }}
                        <span class="fs-4" style="color:gold">
                        {{ l('کومه') }}
                        </span>
                        {{ l('(به معنای اتاقک‌ کلبه‌مانندی که در کنار مراتع و مزارع برای استراحت ساخته می شد)، بازمی‌گردد.') }}     <br><br>
                        {{ l('با الهام از واژه') }}
                        <span class="fs-4" style="color:gold">
                        {{ l('کومه') }}
                        </span>
                        {{ l('، این شهر به نام l("کُم") خوانده شد و سپس معرب گردید و به l("قم") تغییر یافت.') }}
                        <br>
                        <br>
                        <span class="fs-4 text-left" style="color:gold;font-weight:bold">
                        {{ l('ادامه مطلب') }}
                        </span>
                    </a>
                </p>

            </div>
        </div>
    </section>
    <!-- Top offers (carousel)-->
    <section class="container  pb-4 " >
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0 ">{{ l('جدیدترین املاک رهن و اجاره') }}</h2>
            <a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?type=2">
                {{ l('مشاهده همه') }} <i class="fi-arrow-long-left ms-2"></i></a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2 " dir="rtl">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                <!-- Item-->
                @foreach ($estatesr as $estate)
                <div class="col">
                    @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate])

                </div>
                @endforeach
            </div>
        </div>
    </section>
    </div>
    <section class="container  pb-4" >
        <div class="d-flex align-items-center mb-3">
            @php
            $tt4 = array(0=>'' , 1=>'فروردین' , 2=>'اردیبهشت' , 3=>'خرداد' , 4=>'تیر' , 5=>'مرداد' , 6=>'شهریور' , 7=>'مهر' , 8=>'آبان' , 9=>'آذر' , 10=>'دی' , 11=>'بهمن' , 12=>'اسفند')
            @endphp
            <h2 class="h3 mb-4 mt-4 mt-lg-0"> مشاور برتر {{$tt4[(int)$month]}} ماه </h2>
        </div>
        <div class="w-100 w-lg-75 mx-auto">
            <div class="tns-carousel-wrapper tns-nav-outside tns-nav-outside-flush mx-n2">
                <div class="tns-carousel-inner row gx-4 mx-0" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:3},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:3}}}">
                    @php
                    $count = 1;
                    $tt = array(0=>'' , 1=>'gold' , 2=>'silver' , 3=>'bronze');
                    $tt2 = array(0=>'' , 1=>'اول' , 2=>'دوم' , 3=>'سوم');
                    $tt3 = array(0=>'' , 18=>'پردیسان' , 19=>'جمهوری', 37=>'صدوقی', 38=>'زمرد');
                    @endphp
                    @if(isset($reportShow['searchRnk']) && is_array($reportShow['searchRnk']))
                    @foreach ($reportShow['searchRnk'] as $key=>$val)
                    <div class="col">
                        <div class="agent-grid-v1">
                            <div class="position-relative agent-pic">
                                <div class="agent-logo-wrapper">
                                    <a class="agent-logo " href="/agents/{{$key}}" tabindex="-1">
                                        <div class="image-wrapper">
                                            <img decoding="async" class="rounded image-expert-index" width="420" height="420" src="{{ crop($reportShow['pic'][$key] , 500 , 500) }}" class="attachment-large size-large object-fit" alt="{{ $reportShow['name'][$key] }}" />
                                        </div>
                                    </a>
                                </div>
                                <div class="position-absolute  position-absolute bottom-0">
                                    <i class="fa-medal fa-solid  text-{{$tt[$reportShow['searchRnk'][$key]]}} m-1" style="font-size:40px;"></i>
                                </div>
                            </div>
                            <h2 class="agent-title mt-2 mb-0 text-center">
                                <p class="mb-1 pt-1 text-center opacity-60 fs-sm">رتبه {{$tt2[$reportShow['searchRnk'][$key]]}} کومه</p>
                                <a href="/agents/{{$key}}" class=" mt-2 text-decoration-none fs-6">{{ $reportShow['name'][$key] }}</a>
                                <p class="mb-1 mt-2 text-center opacity-60 fs-sm">شعبه {{ array_key_exists($key , $reportShow['branch']) && array_key_exists($reportShow['branch'][$key] , $tt3) ? $tt3[$reportShow['branch'][$key]] : ''}}</p>
                                <p class="mb-1 mt-1 text-center opacity-60 fs-sm"> امتیاز کسب شده: {{$reportShow['search'][$key]}} </p>
                            </h2>
                            <div class="agent-information-bottom flex-middle">
                                <div class="property-job"></div>
                            </div>
                        </div>
                    </div>
                    @php
                    $count++;
                    if($count == 4)
                    {
                    break;
                    }
                    @endphp
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <!-- Carousel custom controls-->
        <div class="tns-carousel-controls justify-content-center pt-md-2 mt-4" id="carousel-controls-tp">
            <button class="me-3" type="button"><i class="fi-chevron-left fs-xs"></i></button>
            <button type="button"><i class="fi-chevron-right fs-xs"></i></button>
        </div>
    </section>
    <section class="container  pb-4">
        <div class="d-flex flex-column flex-md-row gap-3 gap-lg-0 align-items-lg-center align-items-start justify-content-between mb-3">
            <h2 class="h3 mb-4 mt-4 mt-lg-0">{{ l('مجله املاک کومه') }}</h2>
            <a class="btn btn-link fw-normal p-0" href="/blogs/3">
                {{ l('مقالات بیشتر') }} <i class="fi-arrow-long-left ms-2"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach( $articles as $item)
            <!-- Post-->
            <div class="col-lg-6">
                <article class="card border-0 shadow-sm card-hover card-horizontal mb-4 h-100">
                    <a class="card-img-top" href="{{$item->url()}}" style="background-image: url({{ crop($item->img() , 350 , 250) }});"></a>
                    <div class="card-body d-flex flex-column">
                        <h3 class="fs-base pt-1 mb-2">
                            <a class="nav-link" href="{{$item->url()}}">
                                {{$item->title}}
                            </a>
                        </h3>
                        <p class="fs-sm text-muted">
                            {{substr($item->description,0,250)}}
                        </p>
                        <a class="d-flex align-items-center text-decoration-none mt-auto" href="{{$item->url()}}">
                            <div class="pe-2">
                                <div class="d-flex text-body fs-xs">
                                    <span class="me-2 pe-1">
                                        <i class="fi-calendar-alt opacity-70 ms-1"></i>
                                        {{$item->publish_date}}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </section>
    <section class="container  pb-2">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0 ">{{ l('محلات') }}</h2>
            <a class="btn btn-link fw-normal ms-md-3 pb-0 px-0" href="/blogs/9">{{ l('مشاهده همه') }}<i class="fi-arrow-long-left ms-2"></i>
            </a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2" dir="ltr">
            <div class="tns-carousel-inner row gx-4 mx-0 py-md-4 py-3" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                @foreach( $articlesArea as $item)
                <!-- Item -->
                <div class="col">
                    <a class="card shadow-sm card-hover border-0" href="{{$item->url()}}">
                        <div class="card-img-top card-img-hover">
                            <img class="image-localities" src="{{ crop($item->img() , 350 , 250) }}" alt="{{$item->title}} " />
                        </div>
                        <div class="card-body text-center">
                            <h3 class="mb-0 fs-base text-nav">{{$item->title}}</h3>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="container  pb-4">
        <div class="mb-5 position-relative">
            <img src="/img/site3/maps.png" class="w-100 rounded" style="height: 200px;    object-fit: cover;" alt="maps">
            <a href="/c/qom" class="position-absolute d-block  top-0 bottom-0 right-0 left-0 w-100 h-100 text-white rounded text-decoration-none fs-1 p-5 ms-3 mt-4 fw-bold">
                {{ l('جستجوی دقیق در نقشه') }}
            </a>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0 ">{{ l('شعب املاک کومه در قم') }}</h2>
        </div>
        <div class="row g-4">
                @foreach ($branches as $branch)
                <!-- Carousel item-->
                <div class="col-lg-3">
                    <div class="row gy-md-0 gy-sm-4 gy-3 gx-sm-4 gx-0">
                        <div class="col-md-12">
                            <a target="_blank" class="text-decoration-none text-light card bg-size-cover bg-position-center border-0 overflow-hidden h-100" href="/branch/{{$branch->id}}" style="background-image: url({{ crop($branch->coverImage(1) , 700 , 700) }}); min-height: 18.75rem;">
                                <span class="img-gradient-overlay"></span>
                                <div class="card-body content-overlay pb-0"></div>
                                <div class="card-footer content-overlay border-0 pt-0 pb-4" style="transform: translateY(0%);">
                                    <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5">
                                        <div class="pe-2">
                                            <h3 class="h5 text-light mb-1">{{$branch->name}}</h3>
                                            <div class="fs-sm opacity-70">
                                                <i class="fi-map-pin ms-1"></i>{{$branch->address}}
                                            </div>
                                            <div class=" d-flex align-items-center mt-3">
                                                @php
                                                $count = 1;
                                                $tt = array(0=>'' , 1=>'gold' , 2=>'silver' , 3=>'bronze')
                                                @endphp
                                                @if(isset($branch) && is_array($branch->report) &&  is_array($branch->report['searchRnk']))
                                                @foreach ($branch->report['searchRnk'] as $key=>$val)
                                                <div class="position-relative">
                                                    <img class="card-img-top rounded-circle" src="{{ crop($branch->report['pic'][$key] , 70 , 70) }}" alt="{{$branch->report['name'][$key]}}" style="object-fit:cover;width:50px; height:50px;">
                                                    <div class="position-absolute  position-absolute" style="bottom: -7px;">
                                                        <i class="fa-medal fa-solid fs-base text-{{$tt[$branch->report['searchRnk'][$key]]}}"></i>
                                                    </div>
                                                </div>
                                                @php
                                                $count++;
                                                if($count == 4)
                                                {
                                                break;
                                                }
                                                @endphp
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

        </div>
        <!-- Carousel custom controls-->
        <div class="tns-carousel-controls justify-content-center pt-md-2 mt-4" id="carousel-controls-tp">
            <button class="me-3" type="button"><i class="fi-chevron-left fs-xs"></i></button>
            <button type="button"><i class="fi-chevron-right fs-xs"></i></button>
        </div>
    </section>
</main>
<style>
    .shadow-sm {
        box-shadow: 0 0.125rem 0.125rem -0.125rem #bbbbbb, 0 0.25rem 0.75rem #bbbbbb !important;
    }
</style>
  
@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection


