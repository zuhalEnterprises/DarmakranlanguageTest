@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
    'title' => !empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) . l('در') . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? ''),
    'metaDescription' => substr(str_replace(array('✅️' , "\n") , ' ' , $estate->description),0,250),
    'canonical' => $estate->url(),
    'metaKeyword' => str_replace(' ',',' , !empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) . l('در') . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? ''))
])
@section('head')
    @if (!empty($estate) && !empty($estate->latitude))
    <link rel="stylesheet" href="/vendor/map/leaflet.css" />
    <link rel="stylesheet" href="/assets/css/popper.css">
    <script src="/frontend/js/modules/leaflet/leaf.js"></script>
    @endif
    @if($currentUser)
    <script src="/assets/vendors/validatejs/validate.min.js"></script>
    <script src="/assets/vendors/validatejs/validate-persian.js"></script>
    <link rel="stylesheet" href="/assets/css/sweetalert.css" />
    <script src="/assets/js/sweetalert.min.js"></script>
    @endif
    <link href="/vendor/fancybox/style.css" type="text/css" rel="stylesheet">
    <script src="/vendor/fancybox/jquery.fancybox.min.js"></script>

<style>
.img-mohr{
    position: absolute;
    bottom: 0;
    left: 0;
}
    </style>
@endsection
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME') . '.frontend.layouts.header_v2')
        <section class="container mt-5 mb-lg-5 mb-4 pt-5 pb-lg-5">
            <!-- Breadcrumb-->
            <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                    <li class="breadcrumb-item"><a href="/c/{{ $selectedCity }}"> {{l('جستجوی ملک')}}</a></li>
                </ol>
            </nav>
            <div class="row gy-5 pt-lg-2">
                <div class="col-lg-7">
                    <div class="d-none d-lg-flex flex-column">
                        @if (count($images->where("is_360","=",0)) > 0 || count($images->where("is_360","=",1)) > 0 || !empty($estate->video) || $estate->vrhouse)
                            <!-- Carousel with slides count-->
                            <div class="order-lg-1 order-2">
                                <div class="tns-carousel-wrapper">
                                    <div class="tns-slides-count text-light"><i class="fi-image fs-lg me-2"></i>
                                        <div class="ps-1">
                                            <span class="tns-current-slide fs-5 fw-bold"></span>
                                            <span class="fs-5 fw-bold">/</span>
                                            <span class="tns-total-slides fs-5 fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="tns-carousel-inner"
                                        data-carousel-options="{&quot;navAsThumbnails&quot;: true, &quot;navContainer&quot;: &quot;#thumbnails&quot;, &quot;gutter&quot;: 12, &quot;responsive&quot;: {&quot;0&quot;:{&quot;controls&quot;: false},&quot;500&quot;:{&quot;controls&quot;: true}}}">
                                        @foreach ($images->where("is_360","=",0) as $url)
                                        <a href="{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}" class="fancybox.image"  data-fancybox-group="thumb" data-fancybox="gallery">
                                            <div class="rounded-3" style="background-image: url('{{getDomainImg($url->id) != 'https://file.cafoo.ae' ? crop('/upload/images/estate/'.$url->url(),850,850) : getDomainImg($url->id).'/upload/images/estate/'.$url->url() }}')"></div>
                                        </a>
                                        @endforeach
                                        @if (!empty($estate->video))
                                            <div>
                                                <div class="ratio ratio-16x9">
                                                    <iframe class="rounded-3"
                                                        src="https://www.aparat.com/embed/{{ $estate->video }}?data[rnddiv]=19399915890&data[responsive]=yes"
                                                        title="$estate->title"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Thumbnails nav-->
                                <!-- Thumbnails nav-->
                                <ul class="tns-thumbnails" id="thumbnails">
                                    @foreach ($images->where("is_360","=",0)->where("plan","=",0)->where("hidden","=",0) as $url)
                                        <li class="tns-thumbnail" >
                                                <img alt="{{ $estate->title }}" src="{{getDomainImg($url->id) != 'https://file.cafoo.ae' ? crop('/upload/images/estate/'.$url->url() , 200 , 200): getDomainImg($url->id).'/upload/images/estate/'.$url->url()}}" class="pic-estate-small">
                                        </li>
                                    @endforeach
                                    @foreach ($images->where("is_360","=",1) as $url1)
                                <li class="panorma20" name="{{ $url1->name}}" src="{{ $url1->url() }}" style="cursor:pointer;position: relative;padding: 0.4375rem;">
                                    <div style=";; position: absolute;top:8px;border-radius:10px;right:8px;;padding:5px;  background: linear-gradient(180deg,rgba(28,28,28,.6),#2c2c2c 180%);
                                };color:white">{{ l('تور مجازی') }}</div>
                                    <img  src="{{ $url1->url() }}"
                                        style="width:138px;height:138px;border-radius:10px;"></li>
                                    @endforeach
                                    @if (!empty($estate->vrhouse))
                                    <a href="{{ $estate->vrhouse}}" target="_blank">
                                        <li  style="cursor:pointer;position: relative;padding: 0.4375rem;">
                                            <img  src="/img/image360.webp" style="width:138px;height:138px;border-radius:10px;">
                                        </li>
                                    </a>
                                    @endif
                                    @if (!empty($estate->video))
                                        <li class="tns-thumbnail">
                                            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                                <i class="fi-play-circle fs-4 mb-1"></i>
                                                <span>{{l('مشاهده')}}</span>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="container  p-0 mt-4">
                        @if(app('request')->input('he') == '')
                        <div class="card">
                            <div class="card-body ">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($estate->phone()->type == 'expert')
                                        <a class="text-decoration-none" href="/agents/{{!empty($estate->expert)?$estate->expert->id:''}}">
                                            <img class="rounded-circle mb-2" src="{{ !empty($estate->expert) ? ($estate->expert->photo() ? $estate->expert->photo() : noImage()) : noImage() }}" width="80" height="80" alt="{{!empty($estate->expert)?$estate->expert->fullname():''}}">
                                        </a>
                                        <div>
                                            <h5 class="mb-1">
                                                <a class="nav-link" href="/agents/{{!empty($estate->expert)?$estate->expert->id:''}}" target="_blank">
                                                    {{$estate->expert->fullname()}}
                                                </a>
                                            </h5>
                                            <p class="text-body mb-2">
                                                @if(!empty($estate->expert))
                                                    مشاور
                                                    @foreach($estate->expert->roles as $role)
                                                        @if($role->id == 9)
                                                        {{l(($estate->expert->activity_type == 1 ? l('فروش') : ($estate->expert->activity_type == 2 ? l('اجاره') : l('فروش و اجاره'))))}}
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </p>
                                            <a href="tel:{{!empty($estate->expert)?$estate->expert->username:''}}" class="text-primary text-decoration-none mb-1 fs-sm">
                                                <i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i>
                                                {{$estate->expert->username}}
                                            </a>
                                        </div>
                                    @elseif($estate->phone()->type == 'user')
                                        <div>
                                            <h5 class="mb-1">
                                                {{$estate->phone()->name}}
                                            </h5>
                                            <p class="text-body">
                                                {{ l('مالک') }}
                                            </p>
                                            <a href="tel:{{$estate->phone()->phone}}" class="text-primary text-decoration-none mb-1 fs-sm">
                                                <i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i>
                                                {{$estate->phone()->phone}}
                                            </a>
                                        </div>
                                    @elseif($estate->phone()->type == 'both')
                                        @if($estate->expert)
                                        <a class="text-decoration-none" href="/agents/{{!empty($estate->expert)?$estate->expert->id:''}}">
                                            <img class="rounded-circle mb-2" src="{{ $estate->expert ? ($estate->expert->photo() ? $estate->expert->photo() : noImage()) : noImage() }}" width="80" height="80" alt="{{!empty($estate->expert)?$estate->expert->fullname():''}}">
                                        </a>
                                        <div>
                                            <h5 class="mb-1">
                                                <a class="nav-link" href="/agents/{{!empty($estate->expert)?$estate->expert->id:''}}" target="_blank">
                                                    {{$estate->phone()->name}}
                                                </a>
                                            </h5>
                                            <p class="text-body mb-2">
                                                {{ l('مشاور') }}
                                            </p>
                                            <a href="tel:{{!empty($estate->expert)?$estate->expert->username:''}}" class="text-primary text-decoration-none mb-1 fs-sm">
                                                <i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i>
                                                {{$estate->phone()->phone}}
                                            </a>
                                        </div>
                                        @endif
                                        <div class="mx-auto">
                                            <h5 class="mb-1"> {{$estate->phone()->name2}} </h5>
                                            <p class="text-body mb-2">
                                                {{ l('مالک') }}
                                            </p>
                                            <a href="tel:{{$estate->phone()->phone2}}" class="text-primary text-decoration-none mb-1 fs-sm">
                                                <i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i>
                                                {{$estate->phone()->phone2}}
                                                @if($estate->phone()->phone3 != '')
                                                <br>
                                                {{$estate->phone()->phone3}}
                                                @endif
                                            </a>
                                        </div>
                                    @elseif($estate->phone()->type == 'bongah')
                                    <a class="text-decoration-none" href="/">
                                        <img class="rounded-circle mb-2" src="/img/site10/logo.jpg" width="80" height="80" alt="">
                                    </a>
                                    <div>
                                        <h5 class="mb-1">
                                            <a class="nav-link" href="/" target="_blank">
                                            {{ss('SITE_NAME')}}
                                            </a>
                                        </h5>
                                        <p class="text-body mb-2">
                                           {{ l('تماس در ساعات اداری') }}
                                        </p>
                                        <a href="tel:00971525041810" class="text-primary text-decoration-none mb-1 fs-sm">
                                            <i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i>
                                            +971 52 504 1810
                                        </a>
                                    </div>
                                    @endif
                                    </div>
                                </div>
                                    <!-- <span class="btn btn-lg btncall btn-primary w-100 mb-2"> {{l('اطلاعات تماس')}} </span> -->
                                    <ul class="list-unstyled border-bottom mb-4 pb-4">
                                    </ul>
                                    <!-- Contact form-->
                                    @if (!empty($estate->expert) && $estate->expert->isExpert())
                                    <div class="js_chat_box"></div>
                                    <form class="needs-validation " novalidate="">
                                        <div class="position-relative">
                                            @if(!\Auth::user())
                                            <div class="blur">
                                            @endif
                                                <textarea type="text" class="form-control  text-[16px] focus:outline-none shrink my-3" name="message"  rows="3" placeholder="{{l('سوال خود را بپرسید')}}" id="js_chat_input" style="resize: none;"></textarea>
                                                <button class="btn btn-lg btn-primary d-block px-5 chat-{{ $estate->expert_id }}" data-chatid="{{ $estate->expert_id }}" data-expertid="{{ $estate->expert_id }}"
                                                        data-estateid="{{ $estate->id }}" data-expertcode="{{ $estate->expert->code ?? '' }}" id="js_chat_button"  type="button">{{l('ارسال')}} </button>
                                            @if(!\Auth::user())
                                            </div>
                                            @endif
                                            @if(!\Auth::user())
                                            <div class="position-absolute top-0 bottom-0 end-0 start-0 bg-transparent zindex-5 text-center pt-2 mt-2" >
                                                <a href="/login" class="btn btn-info" >
                                                    {{l('برای چت با مشاور وارد شوید')}}
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    <!-- Rental agent-->
                    <!-- @if (!empty($estate->expert) && $estate->expert->isExpert())
                        <div class="card card-horizontal">
                            @if (!empty($estate->expert) && $estate->expert->isExpert())
                                <div class="card-img-top bg-position-center-x"
                                    style="background: url({{$estate->expert ? ($estate->expert->photo() ? $estate->expert->photo() : noImage()) : noImage() }});background-size: contain;background-repeat: no-repeat;margin:5px">
                                </div>
                            @endif
                            <blockquote class="blockquote card-body p-4">
                                <p class="mb-4">{{ $estate->expert->bio }}</p>
                                <footer class="d-flex justify-content-between">
                                    <div class="pe-3">
                                        <h3 class="mb-0">
                                            {{ isset($estate->expert) && $estate->expert->fullname() ?? '' }}
                                        </h3>
                                        <div class="text-muted fw-normal fs-sm mb-3">
                                                                                   </div>
                                        <span class="btn btn-lg btncall btn-primary w-100 mb-3"> {{l('تماس با مشاور')}} </span>
                                    </div>
                                    <div>
                                    </div>
                                </footer>
                            </blockquote>
                        </div>
                    @endif -->
                    @if(env('COUNTRY') != 'UAE')
                    <div class="d-none d-lg-flex align-items-center  py-md-4 py-3">
                        <div class="d-flex flex-wrap">
                            @if($estate->city->name)
                                @if($estate->city->post != null)
                                @foreach ($estate->city->post->tags() as $tag)
                                <a class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2"  href="{{$estate->city->post->url()}}" target="_blank">
                                    {{$tag->name}}
                                </a>
                                @endforeach
                                @endif
                            @endif

                            @if($estate->district && $estate->district->name)
                                @if($estate->district->post_id != null)
                                @foreach ($estate->district->post->tags() as $tag)
                                <a class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2"  href="{{$estate->district->post->url()}}" target="_blank">
                                    {{$tag->name}}
                                </a>
                                @endforeach
                                @endif
                            @endif
                            @if($estate->street && $estate->street->name)
                                @if($estate->street->post_id != null)
                                @foreach ($estate->street->post->tags() as $tag)
                                <a class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2"  href="{{$estate->street->post->url()}}" target="_blank">
                                    {{$tag->name}}
                                </a>
                                @endforeach
                                @endif
                            @endif
                        </div>
                    </div>
                    @endif
                    <!-- Post meta-->
                    <!-- Reviews-->
                    @if(ss('SITE_ID') == 3 && $currentUser && ($currentUser->isExpert() || $currentUser->isAdmin()))
                    <div class="mb-4 pb-4 border-bottom" >
                        <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch justify-content-between">
                            <a class="btn btn-outline-primary mb-sm-0 mb-3" href="#modal-review" data-bs-toggle="modal">
                                <i class="fi-edit ms-1"></i>{{ l('ثبت عملکرد') }}</a>
                            <div class="d-flex align-items-center ms-sm-4">
                            </div>
                        </div>
                    </div>
                    <!-- Review-->
                    <div class="opertionlogs" style="height: 200px;overflow-y: scroll;">
                    </div>
                    @endif
                </div>
                <!-- Sidebar with details-->
                <aside class="col-lg-5 order-first">
                    <div>
                        <div class="position-relative">
                            @php
                            $now = time(); // or your date as well
                            $your_date = strtotime($estate->updated_at);
                            $datediff = $now - $your_date;

                            $dateupdated =  round($datediff / (60 * 60 * 24));

                            @endphp
                            @if($estate->confirmation != 'verified')
                            <div class="img-mohr">
                                @if($estate->confirmation == 'tradedoutsideoffice' || $estate->confirmation == 'tradedoffice')
                                <img src="/img/mohr/{{$estate->confirmation}}{{$estate->type}}.png" alt="mohr">
                                @else
                                <img src="/img/mohr/{{$estate->confirmation}}.png" alt="mohr">
                                @endif
                            </div>
                            @elseif ($dateupdated > 180)
                            <div class="img-mohr">
                                <img src="/img/mohr/expired.png" alt="mohr">
                            </div>
                            @endif
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge bg-success me-2 mb-2">@if(env('COUNTRY') != 'UAE'){{ toPersianDate($estate->created_at) }} @else {{$estate->created_at}} @endif</span>
                                    <span class="badge bg-info me-2 mb-2">{{ estateTypes($estate->estate_type) }}</span>
                                </div>
                                <div class="text-nowrap">
                                    @if (Auth::check())
                                    @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2)
                                    @if($currentUser && $currentUser->isAdmin())
                                    <a href="/profile/editsEstate?estate_id={{$estate->id}}" class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle ms-2 mb-2 edit-estate"
                                        type="button" data-bs-toggle="tooltip"  aria-label="{{ l('ویرایش های انجام شده روی ملک') }}" title="{{l('ویرایش های انجام شده روی ملک')}}">
                                        <i class="fi-edit"></i>
                                    </a>
                                    @endif
                                    @if(

                                        $estate->user_id == Auth::user()->id ||
                                        $estate->percent_expert == 0 ||
                                        $currentUser->isAdmin() ||
                                        ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $currentUser->id == $estate->expert_id) ||
                                        ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s')))
                                    )

                                    <a target="_blank" href="/estates/{{$estate->id}}/edit"
                                        class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle ms-2 mb-2 edit-estate"
                                        type="button" data-bs-toggle="tooltip"  aria-label="{{ l('ویرایش ملک') }}" title="{{l(' ویرایش ملک')}}">
                                        <i class="fi-pencil"></i>
                                    </a>

                                    @endif
                                    <button class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle ms-2 mb-2 compare"
                                        type="button" data-bs-toggle="tooltip"  aria-label="{{ l('مقایسه') }}" title="{{l('مقایسه')}}">
                                        <i class="fa-solid fa-code-compare"></i>
                                    </button>
                                    @endif
                                    <button
                                        class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle ms-2 mb-2 bookmark {{ $estate->isFavorite == 1 ? 'active' : '' }}"
                                        type="button" data-bs-toggle="tooltip"  aria-label="{{ l('نشان کردن') }}" title="{{l('نشان کردن')}}">
                                        <i class="fi-heart"></i>
                                    </button>
                                    @endif
                                    <div class="dropdown d-inline-block" data-bs-toggle="tooltip" title="{{l('اشتراک گذاری')}}">
                                        <button class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle ms-2 mb-2"
                                            type="button" data-bs-toggle="dropdown"  aria-label="{{ l('اشتراک گذاری') }}"><i class="fi-share"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end my-1">
                                            <a style="text-decoration: none"
                                                href="whatsapp://send/?text={{ env('APP_URL') }}/v/{{ $estate->id }}">
                                                <button class="dropdown-item" type="button">
                                                    <i class="fi-whatsapp fs-base opacity-75 me-2"></i>{{l('واتساپ')}}
                                                </button>
                                            </a>
                                            <a style="text-decoration: none"
                                                href="https://t.me/share/url?url={{ env('APP_URL') }}/v/{{ $estate->id }}">
                                                <button class="dropdown-item" type="button">
                                                    <i class="fi-telegram fs-base opacity-75 me-2"></i>{{l('تلگرام')}}
                                                </button>
                                            </a>
                                            <a style="text-decoration: none"
                                                href="https://eitaa.com/share/url?url={{ env('APP_URL') }}/v/{{ $estate->id }}">
                                                <button class="dropdown-item" type="button"><img alt="eitaa" id="eita"
                                                        src="/img/logo/eitaaa.png" width="18px">{{ l('ایتا') }}</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(
                                $currentUser && (
                                $estate->user_id == Auth::user()->id ||
                                $estate->percent_expert == 0 ||
                                $currentUser->isAdmin() ||
                                ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $currentUser->id == $estate->expert_id) ||
                                ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s')))
                                ))
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="row">
                                    <div class="col-sm-9 col-md-9 mb-3">
                                        <label class="form-label fw-bold" for="ap-max-buy">{{ l('وضعیت ملک') }}</label>
                                        <select class="form-control" name="confirmation" id="confirmation" style="width:100%">
                                            @foreach (confirmStatuses() as  $key=>$val)
                                            <option value="{{$key}}" {{!empty($estate) && $estate->confirmation == $key ? 'selected' :''}}>{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-md-3 mb-3">
                                        <label class="form-label fw-bold" for="ap-max-buy">  </label>
                                        <button type="submit" class="btn btn-primary btn-sh d-block mt-1" onclick="return savecheck()" >
                                            {{ l('تغییر وضعیت') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- Page title + Features-->
                            <div class="order-lg-2 order-1">
                                <ul class="d-flex mb-1 pb-lg-2 list-unstyled">
                                    {{ l('کد ملک:') }}<b> {{ $estate->id }}</b>
                                </ul>
                                <h1 class="h2 mb-2" style="margin-top: 20px">
                                    @if (!empty($estate->title))
                                        {{ $estate->title }}
                                    @else
                                    {{ estateTypes($estate->estate_type) }}
                                    در
                                    {{ $estate->city->name ?? '' }}
                                    {{ $estate->district && $estate->district->name ? "،".$estate->district->name:"" }}
                                    @endif
                                </h1>
                                @if ($estate->room_count)
                                    <ul class="d-flex mb-3 pb-lg-2 list-unstyled">
                                        <li class="me-3 ps-3 border-end"><b
                                                class="ms-1">{{ !empty($fieldList['room_count'][$estate->room_count]) && $fieldList['room_count'][$estate->room_count] != l('بدون اتاق') ? $fieldList['room_count'][$estate->{{ l('room_count] . l(\'اتاق\') : l(\'بدون اتاق\')}}') }} </b><i
                                                class="fi-bed mt-n1 lead align-middle text-muted"></i></li>
                                        <li><b>{{ $estate->area }} </b>{{l('مترمربع')}}</li>
                                    </ul>
                                @endif
                            </div>
                            <p class="mb-4 fs-5 fw-bold">
                                @if(!empty(Auth::User()) && (!empty($estate->expert_id==Auth::User()->id) || $currentUser->isExpert()))
                                آدرس:
                                {{ $estate->city->name ?? '' }}
                                {{ $estate->district && $estate->district->name ? " - ".$estate->district->name:"" }}
                                {{!empty($estate->address)?" - ".$estate->address:""}}
                                {{!empty($estate->buildingname)? l("- نام مجتمع:").$estate->buildingname:""}}
                                {{!empty($estate->unit_no)? l("- پلاک").$estate->unit_no:""}}
                                @else
                                آدرس:
                                @if($estate->city->name)
                                    @if($estate->city->post_id == null)
                                        {{ $estate->city->name}}
                                    @else
                                        <a href="{{$estate->city->post->url()}}" target="_blank" title="املاک {{ $estate->city->name}}">
                                            {{ $estate->city->name}}
                                        </a>
                                    @endif
                                @endif
                                @if($estate->district && $estate->district->name)
                                    @if($estate->district->post_id == null)
                                        {{ " - ".$estate->district->name}}
                                    @else
                                        - <a href="{{$estate->district->post->url()}}" target="_blank"  title="املاک {{ $estate->district->name}}">
                                            {{ $estate->district->name}}
                                        </a>
                                    @endif
                                @endif
                                @if($estate->street && $estate->street->name)
                                    @if($estate->street->post_id == null)
                                        {{ " - ".$estate->street->name}}
                                    @else
                                        - <a href="{{$estate->street->post->url()}}" target="_blank"  title="املاک {{ $estate->street->name}}">
                                            {{ $estate->street->name}}
                                        </a>
                                    @endif
                                @endif
                                @endif
                            </p>
                            @if ($estate->type == 1)
                            <div class="d-flex align-items-center gap-2">
                                <div class="fs-5 mb-2">{{l('قیمت ملک')}}:</div>
                                <h2 class="fs-5 mb-2">
                                    @if ($estate->price > 0)
                                        {{ toPersianNumbers($estate->price) }} {{l('تومان')}}
                                    @else
                                    {{l('توافقی')}}
                                    @endif
                                </h2>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <h3 class="fs-5 mb-2">{{l('قیمت متری')}}:</h3>
                                <h4 class="fs-5 mb-2">
                                    {{ $estate->price_per_meter == 0 ? '' : toPersianNumbers($estate->price_per_meter) }} {{ l('تومان') }}
                                </h4>
                            </div>
                            @endif
                        </div>
                        @if ($estate->type == 2)
                        <div class="d-flex align-items-center gap-2">
                            <h3 class="fs-5 mb-2">{{l('ودیعه')}}:</h3>
                            <h2 class="fs-5 mb-2">
                                {{ toPersianNumbers($estate->mortgage) }} {{l('تومان')}}
                            </h2>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <h3 class="fs-5 mb-2">{{l('اجاره ماهیانه')}}:</h3>
                            <h2 class="fs-5 mb-2">
                                {{ toPersianNumbers($estate->rent) }} {{l('تومان')}}
                            </h2>
                        </div>
                        @endif
                        <!-- Button trigger modal -->
                        <div class="text-start">
                            <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                {{ l('گزارش مشکل این آگهی') }}
                            </button>
                        </div>
                        <div class=" d-flex d-lg-none flex-column">
                        @if (count($images->where("is_360","=",0)) > 0 || 1)
                            <!-- Carousel with slides count-->
                            <div class="order-lg-1 order-2">
                                <div class="tns-carousel-wrapper">
                                    <div class="tns-slides-count text-light"><i class="fi-image fs-lg me-2"></i>
                                        <div class="ps-1">
                                            <span class="tns-current-slide fs-5 fw-bold"></span>
                                            <span class="fs-5 fw-bold">/</span>
                                            <span class="tns-total-slides fs-5 fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="tns-carousel-inner"
                                        data-carousel-options="{&quot;navAsThumbnails&quot;: true, &quot;navContainer&quot;: &quot;#thumbnails&quot;, &quot;gutter&quot;: 12, &quot;responsive&quot;: {&quot;0&quot;:{&quot;controls&quot;: false},&quot;500&quot;:{&quot;controls&quot;: true}}}">
                                        @foreach ($images->where("is_360","=",0) as $url)
                                            <div class="rounded-3"
                                                style="background-image: url('{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}')">
                                            </div>
                                        @endforeach
                                        @if (!empty($estate->video))
                                            <div>
                                                <div class="ratio ratio-16x9">
                                                    <iframe class="rounded-3"
                                                    src="https://www.aparat.com/video/video/embed/videohash/{{$estate->video}}/vt/frame"
                                                        title="$estate->title"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Thumbnails nav-->
                                <ul class="tns-thumbnails" id="thumbnails">
                                    @foreach ($images->where("is_360","=",0) as $url)
                                        <li class=" tns-thumbnail "><a class="lightbox_trigger" href="{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}"><img alt="{{ $estate->title }}" src="/upload/images/estate/{{ $url->url() }}" class="pic-estate-small"></a></li>
                                    @endforeach
                                    @foreach ($images->where("is_360","=",1) as $url1)
                                    <li class="panorma20" name="{{ $url1->name}}" src="{{ $url1->url() }}" style="cursor:pointer;position: relative;padding: 0.4375rem;">
                                        <div style=";; position: absolute;top:8px;border-radius:10px;right:8px;;padding:5px;  background: linear-gradient(180deg,rgba(28,28,28,.6),#2c2c2c 180%);
                                    };color:white">{{ l('تور مجازی') }}</div>
                                        <img  src="{{ $url1->url() }}"
                                            style="width:138px;height:138px;border-radius:10px;"></li>
                                    @endforeach
                                    @if (!empty($estate->vrhouse))
                                        <a href="{{ $estate->vrhouse}}" target="_blank">
                                            <li  style="cursor:pointer;position: relative;padding: 0.4375rem;">
                                                <img  src="/upload/images/photography-360.jpg" style="width:138px;height:138px;border-radius:10px;">
                                            </li>
                                        </a>
                                    @endif
                                    @if (!empty($estate->video))
                                        <li class="tns-thumbnail">
                                            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                                <i class="fi-play-circle fs-4 mb-1"></i>
                                                <span>{{l('مشاهده')}}</span>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                        <!-- Property details-->
                        <div class="card border-0 bg-secondary mb-4 mt-3">
                            <div class="card-body">
                                <h5 class="mb-0 pb-3">{{l('مشخصات')}}</h5>
                                <ul class="list-unstyled mt-n2 mb-0 row  row-cols-2">
                                    <li class="mt-2 mb-0 col"><b>{{ l('مساحت :') }}</b> {{ $estate->area }} {{l('مترمربع')}}</li>
                                    @if (!empty($estate->usage_type))
                                        <li class="mt-2 mb-0 col"><b>{{ l('کاربری:') }}</b>
                                            {{ $fieldList['usage_type'][$estate->usage_type] }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->built_year))
                                        <li class="mt-2 mb-0 col"><b>{{l('سال ساخت')}}: </b> {{ buildYear($estate->built_year) }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->document_type))
                                        <li class="mt-2 mb-0 col"><b> {{l('سند')}}: </b>
                                            {{ $fieldList['document_type'][$estate->document_type] }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->room_count))
                                        <li class="mt-2 mb-0 col"><b>{{l('تعداد اتاق')}}:</b>
                                            {{ !empty($fieldList['room_count'][$estate->room_count]) && $fieldList['room_count'][$estate->room_count] != l('بدون اتاق') ? $fieldList['room_count'][$estate->{{ l('room_count] .\' \'. l(\'اتاق\') : l(\'بدون اتاق\') }}') }}
                                        </li>
                                    @endif
                                    @if ($estate->estate_type == 8)
                                    @if($estate->delivery_date != null)
                                    <li class="mt-2 mb-0 col"><b>{{ l('تاریخ تحویل') }}</b>
                                        {{toPersianDate($estate->delivery_date)}}
                                    </li>
                                    @endif
                                    @if($estate->construction_status != '')
                                    <li class="mt-2 mb-0 col"><b>{{ l('مرحله ساخت') }}</b>
                                        {{$estate->construction_status}}
                                    </li>
                                    @endif
                                    @if($estate->money_paid > 0)
                                    <li class="mt-2 mb-0 col"><b>{{ l('مبلغ پرداختی') }}</b>
                                        {{toPersianNumbers($estate->money_paid)}}
                                    </li>
                                    @endif
                                    @endif
                                    @if (!empty($estate->build_density))
                                    <li class="mt-2 mb-0 col"><b>{{ l('تراکم ساخت (طبقات روی پیلوت) :') }}</b>
                                        {{ $estate->build_density }}
                                    </li>
                                    @endif
                                    @if (!empty($estate->floor_area))
                                        <li class="mt-2 mb-0 col"><b>{{ l('مساحت کف:') }}</b> {{ $estate->floor_area }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->built_area))
                                        <li class="mt-2 mb-0 col"><b>{{ l('مساحت بنا:') }}</b> {{ $estate->built_area }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->front_area))
                                        <li class="mt-2 mb-0 col"><b>{{ l('متراژ بر:') }}</b> {{ $estate->front_area }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->street_width))
                                        <li class="mt-2 mb-0 col"><b>{{ l('عرض گذر:') }}</b> {{ $estate->{{ l('street_width }} متر') }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->build_license))
                                        <li class="mt-2 mb-0 col"><b>{{ l('پروانه ساخت:') }}</b>
                                            {{ $fieldList['build_license'][$estate->build_license] }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->floor_count))
                                        <li class="mt-2 mb-0 col"><b>{{ l('تعداد طبقات:') }}</b>
                                            {{ $fieldList['floor_count'][$estate->floor_count] }} </li>
                                    @endif
                                    @if (!empty($estate->unit_in_floor))
                                        <li class="mt-2 mb-0 col"><b> {{l('واحد در طبقه')}}: </b> {{ $fieldList['unit_in_floor'][$estate->unit_in_floor] }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->floor))
                                        <li class="mt-2 mb-0 col"><b>{{l('شماره طبقه')}}:</b>
                                            {{ $fieldList['floor'][$estate->floor] }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->floor_start))
                                        <li class="mt-2 mb-0 col"><b>{{l('شروع طبقات از')}}:</b>
                                            {{ $fieldList['floor_start'][$estate->floor_start] }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->floor_type))
                                        <li class="mt-2 mb-0 col"><b>{{l('نوع طبفات')}}:</b>
                                            {{ getvalueMeta($fieldList, $estate->floor_type, 'floor_type') }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->position_type))
                                        <li class="mt-2 mb-0 col"><b>{{ l('موقعیت مکانی:') }}</b>
                                            {{ $fieldList['position_type'][$estate->position_type] }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->residence_type))
                                        <li class="mt-2 mb-0 col"><b>{{ l('وضعیت سکونت:') }}</b>
                                            {{ $fieldList['residence_type'][$estate->residence_type] }}
                                        </li>
                                    @endif
                                    @if (false && $estate->type == 2 && !empty($estate->rent_type))
                                        <li class="mt-2 mb-0 col"><b>{{l('نوع اجاره')}}:</b>
                                            {{ $fieldList['rent_type'][$estate->rent_type] }}
                                        </li>
                                    @endif
                                    @if (!empty($estate->geography))
                                        <li class="mt-2 mb-0 col"><b>{{l('موقعیت')}}: </b>
                                            {{ $fieldList['geography'][$estate->geography] }} </li>
                                    @endif
                                    @if (!empty($estate->structure_type))
                                        <li class="mt-2 mb-0 col"><b>{{ l('نوع سازه:') }}</b>
                                            {{ $fieldList['structure_type'][$estate->structure_type] }}
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!-- Amenities-->
                        @if (!empty($estate->facilities) || !empty($estate->wc) || !empty($estate->kitchen))
                            <div class="card border-0 bg-secondary mb-4">
                                <div class="card-body">
                                    <h5>{{l('امکانات ملک')}}</h5>
                                    <ul class="list-unstyled row row-cols-md-2 row-cols-1 gy-2 mb-0 text-nowrap">
                                        @if (!empty($estate->facilities))
                                            @foreach (json_decode($estate->facilities, true) as $value)
                                                <li class="col">
                                                    <!--<i class="text-[36px] text-gray-400 fa-thin fa-car-garage"></i>-->
                                                    @if (!empty(IconFacility($fieldList['facilities'][$value])))
                                                        <img src="/frontend/show/svg/{{ IconFacility($fieldList['facilities'][$value]) ?? '' }}.svg"
                                                          alt="{{ l('امکانات ملک') }}"  width="32px" height="32px" />
                                                    @endif
                                                    {{l($fieldList['facilities'][$value]) }}
                                                </li>
                                            @endforeach
                                        @endif
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
                                </div>
                            </div>
                        @endif
                        @if (!empty($estate->conditions))
                            <div class="card border-0 bg-secondary mb-4">
                                <div class="card-body">
                                    <h5>{{l('شرایط ملک')}}</h5>
                                    <ul class="list-unstyled row row-cols-md-2 row-cols-1 gy-2 mb-0 text-nowrap">
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
                            </div>
                        @endif
                        <!-- Overview-->
                        <div class="card border-0 bg-secondary mb-4">
                            <div class="card-body">
                                <h2 class="h5">{{l('توضیحات')}}</h2>
                                <p class="mb-4 pb-2">
                                    <?php echo nl2br($estate->description); ?>
                                    @if($estate->exchange)
                                    <br>
                                    {{ l('قابلیت معاوضه') }}
                                    <br>
                                    <?php echo nl2br($estate->exchange_comment); ?>
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if (count($images->where("plan","=",1)) > 0)
                        <div class="card border-0 bg-secondary mb-4">
                            <div class="card-body">
                                <h5>{{l('پلان')}}</h5>
                        @foreach ($images->where("plan","=",1) as $url)
                            <img src="/upload/images/estate/{{ $url->url() }}" style="height: 200px;width:100%;object-fit:cover" data-src="" alt="">
                        @endforeach
                            </div>
                        </div>
                        @endif
                        @if (!empty($estate) && !empty($estate->latitude))
                            <div class="card border-0 bg-secondary mb-4">
                                <div class="card-body">
                                    <h5>{{l('نقشه')}}</h5>
                                    <ul class="list-unstyled row row-cols-md-2 row-cols-1 gy-2 mb-0 text-nowrap"
                                        style="padding:0px">
                                        @if (!empty($estate->latitude) && !empty($estate->longitude))
                                            <div id="map" style="width: 100%;height:300px;"
                                                class="leaflet-container leaflet-fade-anim leaflet-grab leaflet-retina leaflet-touch leaflet-touch-drag leaflet-touch-zoom map-container-show part--map z-depth-1-half h-[200px] w-full">
                                            </div>
                                        @endif
                                    </ul>
                                </div>
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
                        @endif
                        <!-- Overview-->
                        @if($currentUser && ($currentUser->isExpert() || $currentUser->isAdmin()))
                        <div class="card border-0 bg-secondary mb-4">
                            <div class="card-body">
                                <h2 class="h5">{{ l('تاریخ') }}</h2>
                                <div class="m-0">
                                    <p class="mb-1"> <span class="fw-bold">{{ l('تاریخ ثبت') }}</span>: {{toPersianDate($estate->created_at)}} </p>
                                    <p class="mb-1"> <span class="fw-bold">{{ l('تاریخ آخرین ویرایش') }}</span>: {{toPersianDate($estate->updated_at)}} </p>
                                    <p class="mb-1"> <span class="fw-bold">{{ l('تاریخ آخرین بروزرسانی') }}</span> : {{toPersianDate($estate->showdate)}} </p>
                                </div>
                            </div>
                        </div>
                        @endif

        </div>
    </aside>
            </div>
        </section>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header px-4 py-3">
                        <input type="hidden" id="copymobile"
                            value="{{ !empty($estate->expert) && $estate->expert->isExpert() ? (!empty(Auth::user()) && Auth::user()->isExpert() && $estate->expert_id == Auth::user()->id ? $estate->phone : $estate->expert->username) :" $estate->phone" }}">
                        <h4 class="modal-title" id="exampleModalLabel"></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding:40px 30px;">
                        <div class="d-flex " style="justify-content: space-between!important;">
                            <div class="d-flex justify-content-between" style="justify-content: space-between!important;width:100%">
                                <div class="font-size1">
                                    @if($estate->phone()->type == 'expert' || $estate->phone()->type == 'both')
                                        اطلاعات مشاور
                                    @endif
                                    @if($estate->phone()->type == 'user')
                                        اطلاعات مالک
                                    @endif
                                </div>
                                <div class="js_showtele font-size1 text-danger font-weight-bold">
                                    <a class="text-decoration-none" href="tel:{{$estate->phone()->phone}}">{{$estate->phone()->phone}} ({{$estate->phone()->name}})</a>
                                </div>
                            </div>
                            <!--div class="fa fa-copy font-size1-5 pr-2 pl-2 cursor-pointer " style="cursor:pointer"
                                onclick="copy2()">
                            </div-->
                        </div>
                        @if($estate->phone()->type == 'both')
                        <div class="d-flex " style="justify-content: space-between!important;">
                            <div class="d-flex justify-content-between" style="justify-content: space-between!important;width:100%">
                                <div class="font-size1">
                                    {{ l('اطلاعات مالک') }}
                                </div>
                                <div class="js_showtele font-size1 text-danger font-weight-bold">
                                    <a class="text-decoration-none" href="tel:{{$estate->phone()->phone2}}">{{$estate->phone()->phone2}} ({{$estate->phone()->name2}})</a>
                                </div>
                            </div>
                            <!--div class="fa fa-copy font-size1-5 pr-2 pl-2 cursor-pointer " style="cursor:pointer"
                                onclick="copy2()">
                            </div-->
                        </div>
                        @endif
                        <div class="font-size1-1 text-justify"
                            style="background-color: #f0faff;border-radius: 4px;box-sizing: border-box;color: rgba(0,0,0,.56);padding: 16px;line-height:300%;margin-top:20px">
                            <div style="width:100%;clear:both;height:50px">
                                <div class="d-flex justify-content-center">
                                    <div class="btngh btn btn-danger">
                                        <a class="text-white" style="text-decoration: none"
                                            href="tel:{{$estate->phone()->phone}}">
                                            @if($estate->phone()->type == 'expert' || $estate->phone()->type == 'both')
                                                تماس با مشاور
                                            @endif
                                            @if($estate->phone()->type == 'user')
                                                تماس با مالک
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(count($relationCustomers)>0 && env('COUNTRY') != 'UAE')
        <section class="container mb-5 pb-md-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h3 mb-0 ">{{l('خریداران متناسب')}}</h2>
            </div>
            <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
                <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4"
                    data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                    <!-- Item-->
                    @foreach($relationCustomers as $item)
                    <div class="col-md-6">
                        <div class="card card-hover border-0 shadow-sm mb-4">
                            <div class="card-header bg-secondary">
                                <span class="fw-bold">{{l('نام خریدار')}}:</span>
                                <span class="">
                                    @if(!$currentUser->isAdmin() && $currentUser->id != $item->user_id )
                                    {{$item->user->name ?? ''}}
                                    @else
                                    {{$item->name}}
                                    @endif
                                </span>
                            </div>
                            <div class="card-body">
                                <p class="fw-bold mb-2">
                                    {{$item->request_type == 1 ? l('خرید') : l('اجاره')}}
                                    {{l(mapEstateCategoryName($item->estate_type))}}
                                </p>
                                @php
                                $_districtList = array();
                                @endphp
                                <p class="col-11 d-inline-block text-truncate"> @if(count($item->districts))
                                    {{l('در')}}
                                    @endif
                                    @foreach($item->districts as $district)
                                    @php
                                    $_districtList[] = $district->name
                                    @endphp
                                    @endforeach
                                    {{implode(' , ',$_districtList)}}
                                </p>
                                <div class="d-flex gap-5 align-items-center mb-2">
                                    <div>
                                        @if($item->area_min>0) {{l('از')}}<span>{{$item->area_min}}</span>{{l('متر به بالا')}} @endif
                                    </div>
                                    @if($item->request_type == 1)
                                    <div>
                                        @if($item->price_max>0)
                                        {{l('تا')}} <span>{{toPersianNumbers($item->price_max)}}</span> {{l('تومان')}}
                                        @endif
                                    </div>
                                    @else
                                        @if($item->mortgage_max>0 )
                                        <div>
                                        {{l('رهن تا')}} <span>{{toPersianNumbers($item->mortgage_max)}}</span> {{l('تومان')}}
                                        </div>
                                        @endif
                                        @if($item->rent_max>0 )
                                        <div>
                                        {{l('اجاره تا')}} <span>{{toPersianNumbers($item->rent_max)}}</span> {{l('تومان')}}
                                        </div>
                                        @endif
                                    @endif
                                    </div>
                                <a href="/customer/{{$item->id}}" class="btn btn-primary btn-sm">{{l('جزییات خریدار')}} </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        @if (count($similarEstates) > 0)
            <!-- Recently viewed-->
            <section class="container mb-2 pb-2 pb-lg-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h3 mb-0">{{l('ملک های مشابه')}}</h2>
                </div>
                <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
                    <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4"
                        data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                        <!-- Item-->
                        @foreach ($similarEstates as $estat)
                            <div class="col">
                                @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estat])
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <section class="container my-2">
        @if(env('COUNTRY') != 'UAE')
                    <div class="d-flex d-lg-none align-items-center  py-md-4 py-3">
                        <div class="d-flex flex-wrap">
                            @if($estate->city->name)
                                @if($estate->city->post_id == null)
                                    <a class="btn btn-sm btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2" href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}">املاک {{$estate->city->name}}</a>
                                    <a class="btn btn-xs btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2" href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&type={{$estate->type}}">املاک {{($estate->type == 2 ? l('اجاره') : l('خرید و فروش'))}} در شهر {{$estate->city->name}}</a>
                                    <a class="btn btn-xs btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2" href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&type={{$estate->type}}&estateTypes={{$estate->estate_type}}">{{estateTypes($estate->estate_type)}} {{($estate->type == 2 ? l('اجاره ای') : l('خرید و فروشی'))}} در شهر {{$estate->city->name}}</a>
                                    <a class="btn btn-xs btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2" href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&estateTypes={{$estate->estate_type}}">املاک {{estateTypes($estate->estate_type)}} در شهر {{$estate->city->name}}</a>
                                @else
                                    <a href="{{$estate->city->post->url()}}" target="_blank">
                                        املاک {{$estate->city->name}}
                                    </a>
                                    <a href="{{$estate->city->post->url()}}" target="_blank">
                                        املاک {{($estate->type == 2 ? l('اجاره') : l('خرید و فروش'))}} در شهر {{$estate->city->name}}
                                    </a>
                                    <a href="{{$estate->city->post->url()}}" target="_blank">{{estateTypes($estate->estate_type)}} {{($estate->type == 2 ? l('اجاره ای') : l('خرید و فروشی'))}} در شهر {{$estate->city->name}}</a>
                                    <a href="{{$estate->city->post->url()}}" target="_blank">املاک {{estateTypes($estate->estate_type)}} در شهر {{$estate->city->name}}</a>
                                @endif
                            @endif
                            @if($estate->district && $estate->district->name)
                                @if($estate->district->post_id == null)
                                    <a class="btn btn-xs btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2" href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}&&districts={{($estate->district->id ?? '')}}">املاک {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                                    <a class="btn btn-xs btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2" href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&type={{$estate->type}}">املاک {{($estate->type == 2 ? l('اجاره') : l('خرید و فروش'))}} در {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                                    <a class="btn btn-xs btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2" href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&type={{$estate->type}}&estateTypes={{$estate->estate_type}}">{{estateTypes($estate->estate_type)}} {{($estate->type == 2 ? l('اجاره ای') : l('خرید و فروشی'))}} در {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                                    <a class="btn btn-xs btn-outline-secondary rounded-pill fs-xs fw-normal me-2 mb-2" href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&estateTypes={{$estate->estate_type}}">املاک {{estateTypes($estate->estate_type)}} در {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                                @else
                                    <a href="{{$estate->district->post->url()}}" target="_blank">املاک {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                                    <a href="{{$estate->district->post->url()}}" target="_blank">املاک {{($estate->type == 2 ? l('اجاره') : l('خرید و فروش'))}} در {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                                    <a href="{{$estate->district->post->url()}}" target="_blank">{{estateTypes($estate->estate_type)}} {{($estate->type == 2 ? l('اجاره ای') : l('خرید و فروشی'))}} در {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                                    <a href="{{$estate->district->post->url()}}" target="_blank">املاک {{estateTypes($estate->estate_type)}} در {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                                    <a href="{{$estate->district->post->url()}}" target="_blank">
                                            {{ $estate->district->name}}
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                    @endif
        </section>
    </main>
    <div id="panorma" style="position: fixed;z-index:5000;background:black;width:100%;height:100%;display:none">
        <div style="width: 80%;margin:0 auto" >
        <div style="float: left;color:red;font-size:20px;padding-top:50px;cursor:pointer" id="close1">{{l('بستن')}}</div>
        </div>
        <div style="width: 80%;margin:0 auto" id="pa1">
        </div>
    </div>
    @include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
    @if($currentUser)
    <!-- Review modal-->
    <div class="modal fade" id="modal-review" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header d-block position-relative border-0 pb-0 px-sm-5 px-4">
              <h4 class="modal-title mt-4 text-center font-vazir">{{ l('ثبت عملکرد برای ملک') }}</h4>
              <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 px-4">
                <div class="mb-3">
                  <label class="form-label" for="type">{{ l('نوع') }}</label>
                  <select class="form-control form-select" id="type" name="type">
                    @if(
                        !($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $currentUser->id == $estate->expert_id)
                    )
                    <option value="1" >{{ l('کارشناسی') }}</option>
                    @endif
                    <option value="4" >{{ l('توضیحات') }}</option>
                    <option value="2" >{{ l('سرویس') }}</option>
                    <option value="3" >{{ l('آگهی') }}</option>

                    <option value="6" >{{ l('فروش ویژه') }}</option>
                  </select>
                </div>
                <div class="mb-3 " id="customer_id" style="display:none">
                    <label class="form-label" for="customer_id">{{ l('مشتری') }}</label>
                    <select class="form-control form-select" id="customer_id" name="customer_id">
                    <option></option>
                    @if($customers)
                    @foreach ($customers as $customer)
                    <option value="{{$customer->id}}" >{{$customer->name}}</option>
                    @endforeach
                    @endif
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="comment">{{ l('توضیحات') }}</label>
                    <textarea class="form-control" id="comment" name="comment" rows="5" placeholder="{{ l('توضیحات') }}" required></textarea>
                    <div class="invalid-feedback">{{ l('نظر خود را ثبت کنید') }}</div>
                </div>
                <button class="btn btn-primary d-block w-100 mb-4 btnOperation" type="submit">{{ l('ثبت عملکرد') }}</button>
            </div>
          </div>
        </div>
    </div>
    @endif
      <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-5" id="exampleModalLabel">{{ l('ثبت تخلف و مشکل آگهی') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div id="options">
                        @foreach(estateReportReasons() as $key=>$val)
                            <div class="form-check mb-3">
                                <input class="form-check-input reason-item flexRadioDefault" type="radio" name="reason" id="r{{$key}}" value="{{$key}}" />
                                <label class="form-check-label" for="r{{$key}}">{{$val['group']}}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="others_text" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ l('انصراف') }}</button>
                <button type="button" class="btn btn-primary js_report_submit">{{ l('تایید') }}</button>
            </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

    @if($currentUser && $currentUser->id > 0)
    <script src="/frontend/vendor/sweetalert2.all.js"></script>

    <script>
        function savecheck(){
            var estate_id = {{ $estate->id }};
            var status = $('#confirmation').val();
            var CSRF_TOKEN = '{{ csrf_token() }}';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '/estates/changeConfirmation/'+estate_id+'/'+status,
                type: "get",
                success: function(data) {

                    swal({
                        title: "{{l('ملک با موفقیت تغییر وضعییت داده شد')}}",
                        message: "",
                        confirmButtonColor: '#025EC6',
                        confirmButtonText: l('باشه'),
                        type: "success",
                        timer: 2000
                    });

                },
            });
        }
        const toast = swal.mixin({
            toast: true,
            position: 'bottom-left',
            showConfirmButton: false,
            timer: 2500
        });
        $(document).ready(function(){
            $('#others_text').hide()
            $('.flexRadioDefault').on('change',function(){
                var currentTest = $(this).val();
                console.log(currentTest);
                if($('#r9').prop('checked')){
                    console.log('ok');
                    $('#others_text').show()
                }else{
                    $('#others_text').hide()
                }
            })
        })
        var userID = '{{ isset($currentUser) && $currentUser->id > 0 ? $currentUser->id : 0 }}';
        @if($currentUser && ($currentUser->isExpert() || $currentUser->isAdmin()))
        getOperations({{ $estate->id }});
        @endif
        @if($currentUser || app('request')->input('chatid')>0)
        getMessages({{ $estate->id }});
        @endif
        var CSRF_TOKEN = '{{ csrf_token() }}';
        function getMessages(chat_id) {
            if (chat_id != 0) {
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});
                $.ajax({
                    @if(app('request')->input('chatid') > 0)
                    url: '/chatsEstate2/{{app('request')->input('chatid')}}/' + chat_id,
                    @else
                    url: '/chatsEstate/' + chat_id,
                    @endif
                    type: "GET",
                    success: function(data) {
                        var res = data.messages
                        var itemList = '';
                        if (res != null) {
                            $('#loading').hide();
                            $.each(res, function(key, value) {
                                var cssClass = userID == value.user.id ? '' : 'flex-row-reverse';
                                var cssClass1 = userID == value.user.id ? (
                                    'bg-white pr-2 pl-2 p-1 w-fit text-gray-500 text-18px border border-gray-200 rounded-25 rounded-tr-none'
                                    ) : (
                                    'bg-F8F5EE pr-2 pl-2 p-1 w-34 text-gray-500 text-18px border border-orange-500 rounded-25 rounded-tl-none'
                                    );
                                itemList += '<div class="flex gap-2 mb-3 ' + cssClass + ' ">' +
                                    '<div class="w-66px h-[66px] rounded-full overflow-hidden">' +
                                    '<img class="" src="' + value.user.photo +
                                    '" alt="profile-chat"/>' +
                                    '</div>' +
                                    '<div class="' + cssClass1 + '">' +
                                    ' <p id=" js_chat_user">' + value.body + '</p>' +
                                    ' <span class="flex justify-end">' + value.date + '</span>' +
                                    '</div>' +
                                    '</div>';
                            });
                            $(".js_chat_box").html(itemList);
                        }
                    }
                });
            }
        }
        $(document).ready(function() {
            $('#customer_id').hide()
            $("#type").on( "change", function() {
                var currentValue = $(this).val();
                switch (currentValue) {
                    case '1':
                        $('#customer_id').hide()
                        break;
                    case '2':
                        $('#customer_id').show()
                        break;
                    case '3':
                        $('#customer_id').hide()
                        break;
                    case '4':
                        $('#customer_id').hide()
                        break;
                    default:
                    $('#customer_id').hide()
                }
            })
            $(".panorma20").click(function(){
                $.ajax({
                    url:"/panorma1?panorama="+$(this).attr('src')+"&title=&author="+$(this).attr('name')+"&preview="+$(this).attr('src'),
                    type: "get",
                    beforeSend: function() {
                        $("#spiner").removeClass("d-none");
                    }
                }).done(function(data) {
                    $("#pa1").html(data);
                });
            $("#panorma").show();
            //$("panormasrc").attr("src",")
        });
        $("#close1").click(function(){
            $("#panorma").hide();
        })
        var chatID = 0;
        // send a chat message
        $('input[name="message"]').keydown(function(event) {
            if (event.keyCode == 13) {
                $('#send-message').trigger('click');
                //event.preventDefault();
            }
        });
        var chat_id, expertCode, receiver_id, subject, estateid;
        $('#js_chat_button').on('click', function(e) {
            e.preventDefault()
            chat_id = $(this).attr('data-chatid');
            receiver_id = $(this).data('expertid');
            expertCode = $(this).data('expertcode');
            estateid = $(this).data('estateid')
            subject = " {{l('گفتگوی ملک')}} " + estateid;
            var message = $('#js_chat_input').val();
            if (message.length == 0) {
                $('#js_chat_input').focus();
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '/chats',
                type: "POST",
                data: {
                    'type': 'expert',
                    'receiver_id': receiver_id,
                    'subject': subject,
                    'message': message,
                    'estate_id': estateid
                },
                success: function(data) {
                    var res = data.data;
                    var chatMsg = res.msg;
                    $(".chat-" + receiver_id).attr('data-chatid', '' + res.chat_id).trigger(
                        "refresh");
                    if (chatMsg != null) {
                        $('#js_chat_input').val('');
                        swal({
                            title: "{{l('سوال شما با موفقیت ثبت شد')}}",
                            message: "",
                            confirmButtonColor: '#025EC6',
                            confirmButtonText: l('باشه'),
                            type: "success",
                            timer: 2000
                        });
                        getMessages({{ $estate->id }});
                    }
                },
            });
        });
        $(".btncall").click(function() {
            @if (
                $estate->phone == '09120000000' &&
                    $estate->divar != '' &&
                    !empty(Auth::user()) &&
                    $estate->expert_id == Auth::user()->id)
                $.get('/api/divar/tel/{{ $estate->divar }}', function(data, status) {
                    if (data.status) {
                        $('.js_showtele ').html(data.result)
                    }
                });
            @endif
            $("#myModal").modal('show');
        });
        $(".btnOperation").click(function() {
            estate_id = {{ $estate->id }};
            comment = $('#comment').val();
            type = $('#type').val();
            customer_id = $('.customer_id').val();
            if (comment.length == 0) {
                $('#comment').focus();
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '/estate/addOperation',
                type: "POST",
                data: {
                    'type': type,
                    'customer_id': customer_id,
                    'subject': subject,
                    'comment': comment,
                    'estate_id': estate_id
                },
                success: function(data) {
                    var res = data.data;
                    var operation = res.operation_id;
                    $('#comment').val('');
                    $('.customer_id').val('');
                    $('#modal-review').modal('toggle');
                    swal({
                        title: "{{l('عملکرد با موفقیت ثبت شد')}}",
                        message: "",
                        confirmButtonColor: '#025EC6',
                        confirmButtonText: l('باشه'),
                        type: "success",
                        timer: 2000
                    });
                    getOperations({{ $estate->id }});
                },
            });
        });
        $(".close").click(function() {
            $("#myModal").modal('hide');
        });
    });
    function getOperations(estate_id)
    {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});
        $.ajax({
            url: '/operationsEstate/' + estate_id,
            type: "GET",
            success: function(data) {
                //console.log(data.html);
                $(".opertionlogs").html(data.html);
            }
        });
    }
    function copy2() {
        navigator.clipboard.writeText($('#copymobile').val());
    }
    function changeeita() {
        $("#eita").attr("src", "/img/logo/eitaaa1.png");
    }
    function changeeita1() {
        $("#eita").attr("src", "/img/logo/eitaaa.png");
    }
    $(".bookmark").click(function() {
        var id = "{{ $estate->id }}"
        $.get("/estates/favorite/" + id, function(data, status) {
            if (data.result == 1) {
                $(".bookmark").addClass("active");
            } else {
                $(".bookmark").removeClass("active");
            }
        });
    });
    var reasonsObj = <?php echo json_encode(estateReportReasons())?>;
    var reason, reasonChild, desc = null;
    // select reason group
    $('.reason-item').on('click',function () {
        if ($(this).is(':checked')) {
            reason = $(this).val();
            //reasonLevel2(reason);
        }
    });
    function reasonLevel2(reason){
        var childesItems = getReasonChildes(reason);
        $('#btn-report-submit').prop('disabled',false);
        if(childesItems != ''){
            $('#options').hide();
            $('#options-childes').empty().append(childesItems).show();
            $('#btn-report-back').show();
            $('#btn-report-cancel').hide();
        }
    }
    // get reason childes
    function getReasonChildes(reason) {
        var childes = reasonsObj[reason]['subgroup'];
        var childesItems = '';
        $.each(childes,function (index,item) {
            childesItems +='<div class="form-check mb-3">' +
                '<input class="form-check-input reason-child" type="radio" name="reason_subgroup" id="c'+index+'" value="'+index+'" />' +
                '<label class="form-check-label" for="c'+index+'">'+item+'</label>' +
                '</div>';
        });
        return childesItems;
    }
    $(".compare").click(function() {
        var id = "{{ $estate->id }}"
        $.get("/estates/compare/" + id, function(data, status) {
            window.location = "/compare"
        });
    });
    $(".js_report_submit").click(function() {
        var valueStore = [];
        $.each($(".flexRadioDefault:checked"), function () {
           valueStore.push($(this).val());
        });
        //alert("My favourites are: " + valueStore.join(","));
        //alert($('.flexRadioDefault').val());
        $('#exampleModal').modal('toggle');
        toast({
            type: 'success',
            text: l('در حال ذخیره اطلاعات ...'),
        });
        var eid = '{{$estate->id}}';
        $.ajax({
            type: 'POST',
            url: '/estates/report',
            data: {
                _token: '{{csrf_token()}}',
                estate_id: eid,
                reason_group: valueStore[0],
                reason_description: $("#others_text").val()
            },
            error: function(response) {
                toast({
                    type: 'error',
                    text: l('مشکل در ثبت اطلاعات!'),
                });
            },
            success: function(response) {
                if (response.status == 'true') {
                    toast({
                        type: 'success',
                        text: l('گزارش شما با موفقیت ثبت شد.'),
                    });
                }
            }
        });
    })

</script>
@endif
<script type="application/ld+json">
    [
        {
        "@context":"https://schema.org",
        "url":"{{$estate->url()}}",
        @if(!empty($fieldList['room_count'][$estate->room_count]) && $estate->room_count>0)
        "numberOfRooms":"{{ $fieldList['room_count'][$estate->room_count] != l('بدون اتاق') ? $fieldList['room_count'][$estate->room_count] : 0}}",
        @endif
        "floorSize":{
            "value":{{ $estate->area }},
            "unitCode":"MTK",
            "@type":"QuantitativeValue"
        },
        "accommodationCategory":"{{ estateTypes($estate->estate_type) }}",
        "name":"{{!empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) . l('در') . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? '')}}",
        @if(isset($url))
        "image":"{{env('APP_URL')}}/upload/images/estate/{{ $url->url() }}",
        @endif
        "@type":"{{ $estate->estate_type }}",
        "description":"{{$estate->description}}"
        },{
            "itemListElement":[
                {
                "@type":"ListItem",
                "item":{"@type":"Thing","name":"{{ss('SITE_NAME')}}","@id":"{{env('APP_URL')}}"},
                "position":1
                },
                {
                    "position":2,
                    "@type":"ListItem",
                    "item":{
                        "@id":"/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}",
                        "name":"{{$estate->city->name}}",
                        "@type":"Thing"
                    }
                },
                {
                    "@type":"ListItem",
                    "item":{
                        "name": l("املاک {{$estate->city->name}}"),
                        "@id":"/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}",
                        "@type":"Thing"
                    },
                    "position":3
                },
                {
                    "@type":"ListItem",
                    "position":4,
                    "item":{
                        "@type":"Thing",
                        "@id":"/c/{{$selectedCity}}?city_id={{$estate->city->id}}&type={{$estate->type}}",
                        "name":"{{($estate->type == 1)? l('فروش'):l('اجاره')}} {{$estate->city->name}}"
                    }
                },
                {
                    "item":{
                        "@id":"/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&estateType={{$estate->estate_type}}",
                        "name":"{{($estate->type == 1)? l('فروش'):l('اجاره')}} {{ estateTypes($estate->estate_type) }} در {{$estate->city->name}}",
                        "@type":"Thing"
                    },
                    "@type":"ListItem",
                    "position":5
                },
                {
                    "@type":"ListItem",
                    "item":{
                        "@id":"{{$estate->url()}}",
                        "name":"{{!empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) . l('در') . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? '')}}",
                        "@type":"Thing"
                    },
                    "position":6
                }
                ],
                "@context":"https://schema.org",
                "@type":"BreadcrumbList"
            }
        ]</script>
@endsection
