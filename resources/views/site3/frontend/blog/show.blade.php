@php
    $_ = null;
@endphp
@foreach ($tags as $tag)
@php
$_[] = $tag->name;
@endphp
@endforeach

@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => $model->title,
    'metaDescription' => substr($model->description , 0 , 150),
    'metaKeyword' => is_array($_) ? implode(' - ' , $_) : ' - ',
    'canonical' => $model->url(),
    ])
@section('head')
@if ($posx)
    <link rel="stylesheet" href="/vendor/map/leaflet.css" />
    <link rel="stylesheet" href="/assets/css/popper.css">
    <script src="/frontend/js/modules/leaflet/leaf.js"></script>
    @endif
<style>
.card-body {
    flex: 1 1 auto !important;
    padding: 1.25rem 1.25rem;
}
    </style>
@endsection
@section('main_content')
    <main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2')
    <div class="container mt-5 mb-md-4 py-5">
        <!-- Breadcrumb-->
        @if($model->type == 'post')
        <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                <li class="breadcrumb-item"><a href="/blog">{{l('وبلاگ')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{$model->title}}
                </li>
            </ol>
        </nav>
        @endif


        <!-- Post content-->

        <div class="row mt-4 pt-3 TextContentArticle">
            <div class="{{$recentposts != null && $model->type != 'page' ? 'col-lg-8' : 'col-lg-12'}}">
                <h1 class="h2 mb-4 font-vazir">{{$model->title}}</h1>
                @if($model->img() != '' && $model->image != '')
                <div class="mb-4 pb-md-3" style="text-align: center">
                    <img class="rounded-3" src="{{crop($model->img() , 850 , 500)}}"  alt="{{$model->title}}">
                </div>
                @endif
                <div class="d-flex flex-wrap border-bottom pb-3 mb-4">
                    <a class="text-uppercase text-decoration-none border-end px-3 me-3 mb-2" href="#">{{$model->title}}</a>
                    <div class="d-flex align-items-center border-end px-3 me-3 mb-2">
                        <i class="fi-calendar-alt opacity-70 me-2"></i>
                        <span>{{toPersianDate($model->created_at)}}</span>
                    </div>
                </div>
                <!-- Post content-->
                <p class="line-h18 text-justify ">
                    {!!$model->body!!}

                </p>

                @if($posx != '' && $posy != '')
                <div class="card border-0 bg-secondary mb-4">
                    <div class="card-body">
                        <h5>{{l('نقشه')}}</h5>
                        <ul class="list-unstyled row row-cols-md-2 row-cols-1 gy-2 mb-0 text-nowrap"
                            style="padding:0px">

                            <div id="map" style="width: 100%;height:300px;"
                                class="leaflet-container leaflet-fade-anim leaflet-grab leaflet-retina leaflet-touch leaflet-touch-drag leaflet-touch-zoom map-container-show part--map z-depth-1-half h-[200px] w-full">
                            </div>

                        </ul>
                    </div>
                </div>
                <script>

                        var map = L.map('map').setView([{{ $posx }} , {{ $posy }}], 13);
                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);
                        L.marker([{{ $posx }} , {{ $posy }}]).bindPopup('I am a green leaf.').addTo(map);

                </script>
                @endif

                @if (!empty($estateBuy) && count($estateBuy)>0)
                <h2> املاک {{$model->title}}</h2>
                <div class="row gx-4 mx-0 pt-3 pb-4">

                    @foreach ($estateBuy as $estate)
                    <div class="col-lg-6 col-sm-12 mt-2"  data-aos-once="true" data-aos="zoom-in" data-aos-duration="1000"  data-aos-delay="300">
                        <!-- Static content overlay -->
                        @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate])
                    </div>
                    @endforeach

                </div>
                @endif
                @if($avgLand>0)
                <h2 class="mt-4">زمین در {{$model->title}}</h3>
                <h3 class="mt-4">متوسط قیمت زمین در {{$model->title}}:</h3>
                متوسط قیمت متری زمین در {{$model->title}} مبلغ {{toPersianNumbers($avgLand)}} تومان می باشد.
                @endif
                @if($avgApartment>0 || $avgApartment5>0 || $avgApartment10>0)
                @if($avgApartment>0)
                <h2 class="mt-4">آپارتمان در {{$model->title}}</h3>
                <h3 class="mt-4">متوسط قیمت آپارتمان نوساز در {{$model->title}}:</h3>
                <p>متوسط قیمت متری آپارتمان نوساز در {{$model->title}} مبلغ {{toPersianNumbers($avgApartment)}} تومان می باشد.</p>
                @endif
                @if($avgApartment5>0)
                <h3 class="mt-4">متوسط قیمت آپارتمان کمتر از 5 سال ساخت در {{$model->title}}:</h3>
                <p>متوسط قیمت متری آپارتمان کمتر از 5 سال ساخت در {{$model->title}} مبلغ {{toPersianNumbers($avgApartment5)}} تومان می باشد.</p>
                @endif
                @if($avgApartment10>0)
                <h3 class="mt-4">متوسط قیمت آپارتمان بین 5 تا 10 سال ساخت در {{$model->title}}:</h3>
                <p>متوسط قیمت متری آپارتمان بین 5 تا 10 سال ساخت در {{$model->title}} مبلغ {{toPersianNumbers($avgApartment10)}} تومان می باشد.</p>
                @endif
                @endif
                @if($model->video != '')
                <div class="text-center mx-auto">
                    <style>.h_iframe-aparat_embed_frame{position:relative;}.h_iframe-aparat_embed_frame .ratio{display:block;width:100%;height:auto;}.h_iframe-aparat_embed_frame iframe{position:absolute;top:0;left:0;width:100%;height:100%;}</style><div class="h_iframe-aparat_embed_frame"><span style="display: block;padding-top: calc(57% + 65px)"></span><iframe src="https://www.aparat.com/video/video/embed/videohash/{{$model->video}}/vt/frame"  allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div>

                </div>
                @endif
                <div class="d-flex align-items-center  py-md-4 py-3">
                    <div class="d-flex flex-wrap">
                        @foreach ($tags as $tag)
                        <a class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2" href="{{$model->url()}}">{{$tag->name}}</a>
                        @endforeach
                    </div>
                </div>

            </div>
            @if($recentposts != null && $model->type != 'page')
            <aside class="col-lg-4">
                <div>
                    <div>
                        <!-- Recent posts widget-->
                        <div class="card card-flush pb-3 pb-lg-0 mb-4">
                            <div class="card-body">
                                <h3 class="h5">{{l('پست های اخیر')}}</h3>
                                @foreach ($recentposts as $item)
                                <div class="d-flex align-items-start border-bottom border-light pb-3 mb-3">
                                    @if($item->img() != '')
                                    <a class="flex-shrink-0" href="{{$item->url()}}">
                                        <img class="rounded-3" src="{{crop($item->img() , 150 , 150)}}" alt="{{$item->title}}" style="width: 100px;height: 100px" width="100" height="100">
                                    </a>
                                    @endif
                                    <div class="px-3">
                                        <b><a class=" mt-2 fs-base text-uppercase text-primary text-decoration-none" href="{{$item->url()}}">{{$item->title}}</a></b>

                                        <div class="d-flex fs-xs mt-3">
                                            <span class="">
                                                <i class="fi-calendar-alt opacity-70 mt-n1 align-middle"></i>
                                                {{toPersianDate($item->created_at)}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </aside>
            @endif
        </div>


    </div>
<style>
    td{border-width:1px}
    p , .text-justify{text-align: justify ; font-size: 13pt}
</style>
</main>
<style>
.TextContentArticle h2,
.TextContentArticle h2 * {
    font-size: 16px !important;
    font-weight: bold;
    color: maroon
}

.TextContentArticle h3,
.TextContentArticle h3 * {
    font-size: 15px !important;
    font-weight: bold;
    color: #C64645
}

.TextContentArticle h4,
.TextContentArticle h4 * {
    font-weight: bold
}

.ContentArticle * {
    font-size: 15px
}

.ContentArticle a {
    color: blue;
    font-weight: bold
}
</style>

<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "NewsArticle",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{env('APP_URL')}}{{$model->url()}}"
        },
        "headline": "{{str_replace('"','\"',$model->title) }}",
        @if($model->img() != '')
        "image": "{{env('APP_URL')}}{{$model->img()}}",
        @endif
        "datePublished": "{{$model->updated_at}}",
        "dateModified": "{{$model->created_at}}",
        "author": {
            "@type": "Person",
            "name": "{{ss('SITE_NAME')}}"
        },
        "publisher": {
            "@type": "Organization",
            "name": "{{ss('SITE_NAME')}}"
        }
    }
    </script>
    <script type="application/ld+json" class="rank-math-schema-pro">
    {
    "@context":"https://schema.org","@graph":[
        {
            "@type":"Place",
            "@id":"https://koomeh.ir/#place",
            "geo":{"@type":"GeoCoordinates",
            "latitude":"34.644022",
            "longitude":" 50.8047539"},
            "hasMap":"https://www.google.com/maps/search/?api=1&amp;query=34.644022,50.8047539",
            "address":
            {
                "@type":"PostalAddress",
                "streetAddress":"{{json_encode(l('قم، بلوار جمهوری، نبش خیابان قیام'))}}"
            }
        },
        {
            "@type":"Organization",
            "@id":"https://koomeh.ir/#organization",
                "name":"{{json_encode(l('املاک کومه'))}}",
                "url":"https://koomeh.ir",
                "sameAs":
                [
                    "https://www.instagram.com/koomeh.amlak"
                ],
                "email":"info@koomeh.ir",
                "address":{
                    "@type":"PostalAddress",
                    "streetAddress":"{{json_encode(l('قم، بلوار جمهوری، نبش خیابان قیام'))}}"},
                    "logo":{
                        "@type":"ImageObject",
                        "@id":"https://koomeh.ir/#logo",
                        "url":"https://koomeh.ir/img/site3/logo-b.jpg",
                        "contentUrl":"https://koomeh.ir/img/site3/logo-b.jpg",
                        "caption":"{{json_encode(l('املاک کومه'))}}",
                        "inLanguage":"fa-IR",
                        "width":"200",
                        "height":"200"
                    },
                    "contactPoint":[
                        {
                            "@type":"ContactPoint",
                            "telephone":"+98253180",
                            "contactType":"customer support"
                        }
                        ],
                        "location":{
                            "@id":"https://koomeh.ir/#place"
                        }
                    },
                    {
                        "@type":"WebSite",
                        "@id":"https://koomeh.ir/#website",
                        "url":"https://koomeh.ir",
                        "name":"{{json_encode(l('املاک کومه'))}}",
                        "publisher":
                        {
                            "@id":"https://koomeh.ir/#organization"
                        },
                        "inLanguage":"fa-IR"
                    },
                    @if($model->img() != '')
                    {
                        "@type":"ImageObject",
                        "@id":"{{$model->img()}}",
                        "url":"{{$model->img()}}",

                        "caption":"{{json_encode($model->title)}}",
                        "inLanguage":"fa-IR"
                    },
                    @endif
                    {
                        "@type":"WebPage",
                        "@id":"{{$model->url()}}",
                        "url":"{{$model->url()}}",
                        "name":"{{json_encode($model->title)}}",
                        "datePublished":"{{$model->created_at}}+03:30",
                        "dateModified":"{{$model->updated_at}}+03:30",
                        "isPartOf":{"@id":"https://koomeh.ir/#website"},
                        @if($model->img() != '')
                        "primaryImageOfPage":
                        {
                            "@id":"{{$model->img()}}"
                        },
                        @endif
                        "inLanguage":"fa-IR"},

                    {
                        "@type":"BlogPosting",
                        "headline":"{{json_encode($model->title)}}",
                        "keywords":"{{json_encode($model->title)}}",
                        "datePublished":"{{$model->created_at}}+03:30",
                        "dateModified":"{{$model->updated_at}}+03:30",
                        "publisher":{"@id":"https://koomeh.ir/#organization"
                    },
                    "description":"{{$model->description}}",
                    "name":"{{json_encode($model->title)}}",
                    "@id":"{{$model->url()}}",
                    "isPartOf":{"@id":"{{$model->url()}}"},
                    @if($model->img() != '')
                    "image":{"@id":"{{$model->img()}}"},
                    @endif
                    "inLanguage":"fa-IR",

                    "mainEntityOfPage":
                    {
                        "@id":"{{$model->url()}}"}}]
                    }

    </script>
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
