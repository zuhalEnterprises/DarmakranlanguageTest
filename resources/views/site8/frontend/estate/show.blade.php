@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
    'title' => !empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) . ' - ' . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? ''),
    'metaDescription' => substr(str_replace(array('✅️' , "\n") , ' ' , $estate->description),0,250),
    'canonical' => $estate->url(),
    'metaKeyword' => str_replace(' ',',' , !empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) .' - '
     . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? ''))
])
@section('head')
    <link rel="stylesheet" href="/vendor/map/leaflet.css" />
    <link rel="stylesheet" href="/assets/css/popper.css">
    <script src="/frontend/js/modules/leaflet/leaf.js"></script>
    <script src="/assets/vendors/validatejs/validate.min.js"></script>
    <script src="/assets/vendors/validatejs/validate-persian.js"></script>
    <link rel="stylesheet" href="/assets/css/sweetalert.css" />
    <script src="/assets/js/sweetalert.min.js"></script>
    <link href="/vendor/fancybox/style.css" type="text/css" rel="stylesheet">
    <script src="/vendor/fancybox/jquery.fancybox.min.js"></script>
    <link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css"/>
    <link rel="stylesheet" media="screen" href="/vendor/lightgallery/css/lightgallery-bundle.min.css"/>
    <link rel="stylesheet" media="screen" href="/vendor/tiny-slider/dist/tiny-slider.css"/>
    <link rel="stylesheet" media="screen" href="/vendor/flatpickr/dist/flatpickr.min.css"/>
@endsection
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME') . '.frontend.layouts.header_v2')
        <section class="container pt-5 mt-5">
            <!-- Breadcrumb-->
            <nav class="pt-md-3" aria-label="breadcrumb">

              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                <li class="breadcrumb-item active"><a href="/c/{{ $selectedCity }}"> {{l('جستجوی ملک')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    @if (!empty($estate->title))
                        {{ $estate->title }}
                    @else
                        {{ estateTypes($estate->estate_type) }}
                        {{ $estate->district->name ?? '' }} {{ $estate->city->name ?? '' }}
                    @endif
                </li>
              </ol>
            </nav>

        </section>

        <!-- Post content-->
        <section class="container mb-5 pb-1">
            <div class="row">
                <div class="col-md-8 mb-md-0 mb-4">
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
                            @if(count($images->where("360","=",0))>0)
                            <div class="tns-carousel-inner"
                                data-carousel-options="{&quot;navAsThumbnails&quot;: true, &quot;navContainer&quot;: &quot;#thumbnails&quot;, &quot;gutter&quot;: 12, &quot;responsive&quot;: {&quot;0&quot;:{&quot;controls&quot;: false},&quot;500&quot;:{&quot;controls&quot;: true}}}">
                                @foreach ($images->where("360","=",0)->where("plan","=",0)->where("hidden","=",0) as $url)

                                <a href="{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}" class="fancybox.image"  data-fancybox-group="thumb" data-fancybox="gallery">
                                    <div class="rounded-3" style="background-image: url('{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}')"></div>
                                </a>
                                @endforeach
                                @if(ss('SITE_ID') == 8 && $currentUser && ($currentUser->isExpert() || $currentUser->isAdmin()))
                                @foreach ($images->where("hidden","=",1) as $url)
                                <div class="rounded-3" style="background-image: url('{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}')"></div>
                                @endforeach
                                @endif

                                @if (!empty($estate->video))

                                <div>
                                    <div class="ratio ratio-16x9">
                                        @php
                                        $v='';
                                        $video = explode("/" , $estate->video);
                                        if(count($video)>3){
                                            $v = $video[count($video)-1];
                                        }
                                        @endphp
                                        @if($v != '')
                                        <iframe src="https://www.aparat.com/video/video/embed/videohash/{{$v}}/vt/frame?titleShow=true" title="{{ l('فروش واحد 85متری') }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"  allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                        <style>
                            .rounded-3 {
                                background-size: contain;
                                height: 450px;
                                background-position-y: center;
                                background-repeat: no-repeat;
                                background-color: black;
                                background-position-x: center;
                            }
                        </style>
                        <!-- Thumbnails nav-->
                        <ul class="tns-thumbnails" id="thumbnails">
                            @foreach ($images->where("360","=",0)->where("plan","=",0)->where("hidden","=",0) as $url)
                                <li class="tns-thumbnail" >

                                        <img alt="{{ $estate->title }}" src="{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}" class="pic-estate-small">

                                </li>
                            @endforeach
                            @if(ss('SITE_ID') == 8 && $currentUser && ($currentUser->isExpert() || $currentUser->isAdmin()))
                            @foreach ($images->where("hidden","=",1) as $url)
                            <li class="tns-thumbnail" >

                                <img alt="{{ $estate->title }}" src="{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}" class="pic-estate-small">

                        </li>

                            @endforeach
                            @endif
                            @foreach ($images->where("360","=",1) as $url1)
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
                    <span class="badge bg-success me-2 mb-2">@if(env('COUNTRY') != 'UAE'){{ toAgoTime($estate->created_at) }} @else {{$estate->created_at}} @endif</span>
                    <span class="badge bg-info me-2 mb-2">{{ estateTypes($estate->estate_type) }}</span>

                    <section>

                        <h1 class="h2 mb-2">{{ $estate->title }}</h1>
                        <span>
                            <div class="d-flex align-items-center justify-content-between mb-3 d-none d-lg-block">

                                <div class="d-flex flex-wrap text-nowrap mt-3">
                                    @if (Auth::check())
                                    @if(ss('SITE_ID') == 8)
                                    @if($currentUser && $currentUser->isAdmin())

                                    <a  href="/profile/editsEstate?estate_id={{$estate->id}}" class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2 edit-estate"
                                        type="button" data-bs-toggle="tooltip"  aria-label="{{ l('ویرایش های گذشته') }}" title="{{ l('ویرایش های گذشته') }}">

                                        <i class="fi-edit"></i>

                                    </a>

                                    @endif
                                    @if(
                                    $estate->user_id == Auth::user()->id ||
                                    $currentUser->isAdmin() ||
                                    ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $currentUser->id == $estate->expert_id && $currentUser->isExpert()) ||
                                    ($currentUser->isExpert() && ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s'))))
                                    )
                                    <a target="_blank" href="/estates/{{$estate->id}}/edit"
                                        class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2 edit-estate"
                                        type="button" data-bs-toggle="tooltip"  aria-label="{{ l('ویرایش ملک') }}" title="{{l(' ویرایش ملک')}}">
                                        <i class="fi-pencil"></i>
                                    </a>

                                    <button
                                        class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2 archive"
                                        type="button" data-bs-toggle="modal" data-bs-target="#modalarchive" aria-label="{{ l('آرشیو کردن ملک') }}" title="{{ l('آرشیو کردن ملک') }}">
                                        <i class="fi-archive"></i>
                                    </button>
                                    @endif
                                    <button class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2 compare"
                                        type="button" data-bs-toggle="tooltip"  aria-label="{{ l('مقایسه') }}" title="{{l('مقایسه')}}">
                                        <i class="fa-solid fa-code-compare"></i>
                                    </button>
                                    @endif
                                    <button
                                        class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2 bookmark {{ $estate->isFavorite == 1 ? 'active' : '' }}"
                                        type="button" data-bs-toggle="tooltip"  aria-label="{{ l('نشان کردن') }}" title="{{l('نشان کردن')}}">
                                        <i class="fi-heart"></i>
                                    </button>
                                    @endif
                                    <div class="dropdown d-inline-block" data-bs-toggle="tooltip" title="{{l('اشتراک گذاری')}}">
                                        <button class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2"
                                            type="button" data-bs-toggle="dropdown"  aria-label="{{ l('اشتراک گذاری') }}"><i class="fi-share"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end my-1">
                                            <a style="text-decoration: none"
                                                href="https://wa.me/98{{ !empty($estate->expert) && $estate->expert->isExpert() ? (!empty(Auth::user()) && Auth::user()->isExpert() && $estate->expert_id == Auth::user()->id ? $estate->phone : $estate->expert->username) :$estate->phone }}?text={{ env('APP_URL') }}/v/{{ $estate->id }}">
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

                                            @if($customers && $currentUser && $currentUser->isExpert())
                                            <a style="text-decoration: none"  href="#modalrelationsms" data-bs-toggle="modal">
                                                <button class="dropdown-item " type="button" >
                                                    <i class="fas fa-sms fs-base opacity-75 me-2"></i> {{ l('پیامک') }}
                                                </button>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </span>
                        <p class="mb-2 pb-1 fs-lg">
                            @if(!empty(Auth::User()) && (!empty($estate->expert_id==Auth::User()->id) || $currentUser->isAdmin()))
                           {{ $estate->city->name ?? '' }}
                            {{ $estate->district && $estate->district->name ? " ".$estate->district->name:"" }}
                            {{!empty($estate->address)?" ".$estate->address:""}}
                            {{!empty($estate->unit_no)?" Unit ".$estate->unit_no:""}}
                            @else
                            {{ $estate->city->name ?? '' }}
                            {{ $estate->district && $estate->district->name ? " ".$estate->district->name:"" }}
                            @endif
                        </p>
                        <!-- Features + Sharing-->
                        <div class="d-flex justify-content-between align-items-center">
                          <ul class="d-flex mb-4 list-unstyled">
                            <li class="me-3 ps-3 border-end">
                                <i class="fi-bed mt-n1 lead align-middle text-muted"></i>
                                <b class="me-1">
                                    {{ $estate->room_count == 0 || $fieldList['room_count'][$estate->room_count] == l('بدون اتاق')  ? 'Studio' : l($fieldList['room_count'][$estate->room_count])}}
                                </b>

                            </li>

                            <li><b>{{$estate->area}} </b> {{l('متر مربع')}}</li>
                          </ul>

                        </div>
                        <!-- Features + Sharing-->

                    </section>
                    <div class="h3 mb-4 pb-4 border-bottom">
                        @if ($estate->type == 1)
                                <h3 class="h5 mb-2">{{l('قیمت ملک')}}:

                                    @if ($estate->price > 0)
                                        {{ toPersianNumbers($estate->price) }} {{l('تومان')}}
                                    @else
                                    {{l('توافقی')}}
                                    @endif
                                </h3>
                                <h3 class="h5 mb-2">{{l('قیمت متری')}}:
                                    {{ $estate->price_per_meter == 0 ? '' : toPersianNumbers($estate->price_per_meter) }} {{ l('تومان') }}
                                </h3>
                            @endif
                            @if ($estate->type == 2)
                                <h3 class="h5 mb-2">{{l('ودیعه')}}:</h3>
                                <h2 class="h3 mb-4 pb-2">
                                    {{ toPersianNumbers($estate->mortgage) }} {{l('تومان')}}
                                </h2>
                                <h3 class="h5 mb-2">{{l('اجاره ماهیانه')}}:</h3>
                                <h2 class="h3 mb-4 pb-2">
                                    {{ toPersianNumbers($estate->rent) }} {{l('تومان')}}
                                </h2>
                            @endif
                            </div>
                <!-- Overview-->

                <div class="mb-4 pb-md-3">
                  <h3 class="h4">{{ l('اطلاعات کلی') }}</h3>
                  <p class="mb-1">
                    <?php echo nl2br($estate->description); ?>
                  </p>
                </div>
                <!-- Property Details-->
                <div class="mb-4 pb-md-3">
                    <h3 class="h4">{{ l('جزئیات آگهی') }}</h3>
                    <ul class="list-unstyled mt-n2 mb-0 row  row-cols-2">
                        <li class="mt-2 mb-0 col"><b>{{l('نوع')}}: </b> {{ estateTypes($estate->estate_type) }}</li>
                        <li class="mt-2 mb-0 col"><b>{{l('شماره آگهی')}}:</b> {{ $estate->id }}</li>
                        <li class="mt-2 mb-0 col"><b>{{l('متراژ زمین')}}: </b> {{ $estate->area }} {{l('مترمربع')}}</li>

                        @if (!empty($estate->floor_count))
                            <li class="mt-2 mb-0 col"><b>{{l('طبقه')}}: </b>
                                {{ l($fieldList['floor_count'][$estate->floor_count]) }} </li>
                        @endif
                        @if(ss('SITE_ID')!= 4)
                        @if (!empty($estate->geography))
                            <li class="mt-2 mb-0 col"><b>{{l('موقعیت')}}: </b>
                                {{ $fieldList['geography'][$estate->geography] }} </li>
                        @endif
                        @endif
                        @if (!empty($estate->built_year))
                        @if(env('COUNTRY') != 'UAE')
                            <li class="mt-2 mb-0 col"><b>{{l('سال ساخت')}}: </b> {{ buildYear($estate->built_year) }}
                            </li>
                        @endif
                        @endif
                        @if (!empty($estate->document_type))
                        @if(env('COUNTRY') != 'UAE')
                            <li class="mt-2 mb-0 col"><b> {{l('سند')}}: </b>
                                {{ $fieldList['document_type'][$estate->document_type] }}
                            </li>
                            @endif
                        @endif
                        @if (!empty($estate->room_count))
                            <li class="mt-2 mb-0 col"><b>{{l('تعداد اتاق')}}:</b>
                                {{ $fieldList['room_count'][$estate->room_count] != l('بدون اتاق') ? l($fieldList['room_count'][$estate->{{ l('room_count]) : l(\'بدون اتاق\') }}') }}
                            </li>
                        @endif
                        @if (!empty($estate->structure_type))
                            <li class="mt-2 mb-0 col"><b>{{ l('نوع سازه:') }}</b>
                                {{ $fieldList['structure_type'][$estate->structure_type] }}
                            </li>
                        @endif
                        @if(env('COUNTRY') != 'UAE')
                        @if (!empty($estate->floor_area))
                            <li class="mt-2 mb-0 col"><b>{{ l('متراژ کف:') }}</b> {{ $estate->floor_area }}
                            </li>
                        @endif
                        @if (!empty($estate->built_area))
                            <li class="mt-2 mb-0 col"><b>{{ l('متراژ بنا:') }}</b> {{ $estate->built_area }}
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
                        @endif
                        @if (!empty($estate->unit_in_floor))
                            <li class="mt-2 mb-0 col"><b> {{l('واحد در طبقه')}}: </b> {{ l($fieldList['unit_in_floor'][$estate->unit_in_floor]) }}
                            </li>
                        @endif
                        @if (!empty($estate->floor))
                            <li class="mt-2 mb-0 col"><b>{{l('شماره طبقه')}}:</b>
                                {{ l($fieldList['floor'][$estate->floor]) }}
                            </li>
                        @endif
                        @if (!empty($estate->floor_start))
                            <li class="mt-2 mb-0 col"><b>{{l('شروع طبقات از')}}:</b>
                                {{ $fieldList['floor_start'][$estate->floor_start] }}
                            </li>
                        @endif
                        @if (!empty($estate->residence_type))
                            <li class="mt-2 mb-0 col"><b>{{l('وضعیت سکونت')}}:</b>
                                {{ l($fieldList['residence_type'][$estate->residence_type]) }}
                            </li>
                        @endif
                        @if (!empty($estate->floor_type))
                            <li class="mt-2 mb-0 col"><b>{{l('نوع طبفات')}}:</b>
                                {{ getvalueMeta($fieldList, $estate->floor_type, 'floor_type') }}
                            </li>
                        @endif
                        @if (!empty($estate->position_type))
                            <li class="mt-2 mb-0 col"><b>{{l('موقعیت مکانی')}}:</b>
                                {{ l($fieldList['position_type'][$estate->position_type]) }}
                            </li>
                        @endif
                        @if (!empty($estate->usage_type))
                            <li class="mt-2 mb-0 col"><b>{{l('کاربری')}}:</b>
                                {{ l($fieldList['usage_type'][$estate->usage_type]) }}
                            </li>
                        @endif
                        @if (false && $estate->type == 2 && !empty($estate->rent_type))
                            <li class="mt-2 mb-0 col"><b>{{l('نوع اجاره')}}:</b>
                                {{ l($fieldList['rent_type'][$estate->rent_type]) }}
                            </li>
                        @endif

                  </ul>
                </div>
                <!-- Amenities-->
                @if (!empty($estate->facilities) || !empty($estate->wc) || !empty($estate->kitchen))
                <div class="mb-4 pb-md-3">
                    <h3 class="h4">{{ l('امکانات') }}</h3>
                    <ul class="list-unstyled row row-cols-lg-3 row-cols-md-2 row-cols-1 gy-1 mb-1 text-nowrap">
                        @if (!empty($estate->facilities))
                        @foreach (json_decode($estate->facilities, true) as $value)
                        <li class="col">
                            @if (!empty(IconFacility($fieldList['facilities'][$value])))
                                <img class="mt-n1 me-2 fs-lg align-middle" src="/frontend/show/svg/{{ IconFacility($fieldList['facilities'][$value]) ?? '' }}.svg"
                                    alt="{{l($fieldList['facilities'][$value]) }}"  width="25px" height="25px" />
                            @endif
                            {{l($fieldList['facilities'][$value]) }}
                        </li>
                        @endforeach
                        @endif
                        @if (!empty($estate->wc))
                            <li class="col">
                                @if (!empty(IconFacility($fieldList['wc'][$estate->wc] ?? '')))
                                    <img class="mt-n1 me-2 fs-lg align-middle"  src="/frontend/show/svg/{{ IconFacility($fieldList['wc'][$estate->wc] ?? '') }}.svg"
                                        width="16px" height="16px" alt="{{ $fieldList['wc'][$estate->wc] }}"/>
                                @endif
                                {{ $fieldList['wc'][$estate->wc] }}
                            </li>
                        @endif
                        @if (!empty($estate->kitchen))
                            @foreach (json_decode($estate->kitchen, true) as $value)
                                <li class="col">
                                    @if (!empty(IconFacility($fieldList['kitchen'][$value])))
                                        <img class="mt-n1 me-2 fs-lg align-middle"  src="/frontend/show/svg/{{ IconFacility($fieldList['kitchen'][$value]) ?? '' }}.svg"
                                            width="16px" height="16px"  alt="{{ $fieldList['kitchen'][$value] }}"/>
                                    @endif
                                    {{ $fieldList['kitchen'][$value] }}
                                </li>
                            @endforeach
                        @endif
                        @if (!empty($estate->heating_cooling))
                            @foreach (json_decode($estate->heating_cooling, true) as $value)
                                <li class="col">
                                    @if (!empty(IconFacility($fieldList['heating_cooling'][$value])))
                                        <img class="mt-n1 me-2 fs-lg align-middle"  src="/frontend/show/svg/{{ IconFacility($fieldList['heating_cooling'][$value]) ?? '' }}.svg"
                                            width="16px" height="16px" alt="{{ $fieldList['heating_cooling'][$value] }}" />
                                    @endif
                                    {{ $fieldList['heating_cooling'][$value] }}
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                @endif
                @if($currentUser && ($currentUser->isExpert() || $currentUser->isAdmin()))
                <div class="mb-4 pb-4 border-bottom" >
                    <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch justify-content-between">
                        <a class="btn btn-outline-primary mb-sm-0 mb-3" href="#modal-review" data-bs-toggle="modal">
                            <i class="fi-edit ms-1"></i>
                            {{l('ثبت عملکرد')}}

                        </a>
                        <div class="d-flex align-items-center ms-sm-4">
                        </div>
                    </div>
                </div>
                <!-- Review-->
                <div class="opertionlogs">
                </div>
                @endif
              </div>
              <!-- Sidebar-->
              <aside class="col-lg-4 col-md-5 ms-lg-auto pb-1">

                @if(app('request')->input('he') != 1)
            <div class="card shadow-sm">
                <div class="card-body ">
                        <div class="d-flex align-items-center gap-3 mb-3">
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
                                            کارشناس
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
                                        @if($estate->phone()->phone2 != '')
                                        <br>
                                        {{$estate->phone()->phone2}}
                                        @endif
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
                                        {{ l('کارشناس') }}
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
                                <img class="rounded-circle mb-2" src="/img/site8/logo-markazi.png" width="80" height="80" alt="">
                            </a>
                            <div>
                                <h5 class="mb-1">
                                    <a class="nav-link" href="/" target="_blank">
                                        {{ l('شبکه املاک مرکزی') }}
                                    </a>
                                </h5>
                                <p class="text-body mb-2">
                                    {{ l('تماس در ساعات اداری') }}
                                </p>
                                <a href="tel:02532908181" class="text-primary text-decoration-none mb-1 fs-sm">
                                    <i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i>
                                    025-32908181
                                </a>
                                <a href="tel:02532900275" class="text-primary text-decoration-none mb-1 fs-sm">
                                    <i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i>
                                    025-32900275
                                </a>
                            </div>
                            @endif
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
                            @if((!empty(Auth::user()) && Auth::user()->isAdmin()) || (!empty(Auth::user()) && Auth::user()->isExpert() && Auth::user()->id==$estate->expert_id && $estate->percent_expert>0 && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s'))))
                            @if($estate->expert)
                            <div class="">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modealmoarefi" class="text-decoration-none d-flex align-items-center gap-2">
                                <input class="btn btn-primary"  type="button" value="{{ l('معرفی کارشناس') }}" />
                                </a>
                            </div>
                            @endif
                            @endif
                            @if( (!empty(Auth::user()) && Auth::user()->isAdmin()) || (!empty(Auth::user()) && Auth::user()->isExpert() ))

                            <div class="">

                                <a href="#" data-bs-toggle="modal" data-bs-target="#modelsms" class="text-decoration-none d-flex align-items-center gap-2">
                                <input class="btn btn-primary" type="button" value="{{ l('ارسال پیامک عدم پاسخ فروشنده') }}" />
                                </a>

                            </div>

                            @endif
                        </div>
                        <!--span class="btn btn-lg btncall btn-primary w-100 mb-2"> {{l('اطلاعات تماس')}} </span-->


                        <!-- Contact form-->
                        @if (!empty($estate->expert) && $estate->expert->isExpert())
                        <div class="js_chat_box"></div>
                        <form class="needs-validation " novalidate="">
                            <div class="position-relative">
                                @if(!\Auth::user())
                                <div class="blur">
                                @endif
                                    <textarea type="text" class="form-control  text-[16px] focus:outline-none shrink my-3" name="message"  rows="3" placeholder="{{l('سوال خود را بپرسید')}}" id="js_chat_input" style="resize: none;"></textarea>
                                    <button class="btn btn-lg btn-primary d-block w-100 chat-{{ $estate->expert_id }}" data-chatid="{{ $estate->expert_id }}" data-expertid="{{ $estate->expert_id }}"
                                            data-estateid="{{ $estate->id }}" data-expertcode="{{ $estate->expert->code ?? '' }}" id="js_chat_button"  type="button">{{l('ارسال')}} </button>
                                @if(!\Auth::user())
                                </div>
                                @endif
                                @if(!\Auth::user())
                                <div class="position-absolute top-0 bottom-0 end-0 start-0 bg-transparent zindex-5 text-center pt-2 mt-2" >
                                    <a href="/login" class="btn btn-info" >
                                        {{l('برای چت با کارشناس وارد شوید')}}
                                    </a>
                                </div>
                                @endif
                            </div>
                        </form>
                        @endif

                    </div>

                </div>
                @endif

                @if($estate->district && $estate->district->name && $estate->district->post_id>0 && isset($estate->district->post))
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <a href="" target="_blank">
                                <img src="{{$estate->district->post->img()}}" style="width: 100px">

                                <div>
                                    <h3>
                                    {{$estate->district->name}}
                                    </h3>
                                    <div>
                                        See the community attractions and lifestyle
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                <!-- Location (Map)-->
                @if (!empty($estate) && !empty($estate->latitude))
                    <div class="pt-2">
                        <div id="map" style="width: 100%;height:300px;"
                            class="leaflet-container leaflet-fade-anim leaflet-grab leaflet-retina leaflet-touch leaflet-touch-drag leaflet-touch-zoom map-container-show part--map z-depth-1-half h-[200px] w-full">
                        </div>
                        <p class="mb-0 fs-sm text-center">
                            @if(!empty(Auth::User()) && (!empty($estate->expert_id==Auth::User()->id) || $currentUser->isAdmin()))
                        {{ $estate->city->name ?? '' }}
                            {{ $estate->district && $estate->district->name ? " ".$estate->district->name:"" }}
                            {{!empty($estate->address)?" ".$estate->address:""}}
                            {{!empty($estate->unit_no)?" Unit ".$estate->unit_no:""}}
                            @else
                            {{ $estate->city->name ?? '' }}
                            {{ $estate->district && $estate->district->name ? " ،".$estate->district->name:"" }}
                            @endif
                        </p>
                    </div>
                    <script>
                        var map = $('#map').kamaMap({
                            zoom: 14,
                            maxZoom: 18,
                            click_zoom: 14,
                            zoomControl: true,
                            lat: {{ $estate->latitude }},
                            lng: {{ $estate->longitude }}
                        });
                        map.showCircle({{ $estate->latitude }}, {{ $estate->longitude }}, 15, 100);
                    </script>
                @endif
                @if($estate->city)
                <div class="mb-4 pb-md-3 mt-5">
                    <h3 class="h4">{{ l('لینکهای مفید') }}</h4>

                    <ul class="list-unstyled mt-n2 mb-0 row row-cols-1">

                        <li class="mt-2 mb-0 col">
                            <a  href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}">املاک {{$estate->city->name}}</a>
                        </li>
                        <li class="mt-2 mb-0 col">
                            <a  href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}&&districts={{($estate->district->id ?? '')}}">املاک {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                        </li>
                        <li class="mt-2 mb-0 col">
                            <a  href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&type={{$estate->type}}">املاک {{($estate->type == 2 ? l('اجاره') : l('خرید و فروش'))}} در شهر {{$estate->city->name}}</a>
                        </li>
                        <li class="mt-2 mb-0 col">
                            <a  href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&type={{$estate->type}}">املاک {{($estate->type == 2 ? l('اجاره') : l('خرید و فروش'))}} در {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                        </li>
                        <li class="mt-2 mb-0 col">
                            <a  href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&type={{$estate->type}}&estateTypes={{$estate->estate_type}}">{{estateTypes($estate->estate_type)}} {{($estate->type == 2 ? l('اجاره ای') : l('خرید و فروشی'))}} در شهر {{$estate->city->name}}</a>
                        </li>
                        <li class="mt-2 mb-0 col">
                            <a  href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&type={{$estate->type}}&estateTypes={{$estate->estate_type}}">{{estateTypes($estate->estate_type)}} {{($estate->type == 2 ? l('اجاره ای') : l('خرید و فروشی'))}} در {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                        </li>
                        <li class="mt-2 mb-0 col">
                            <a  href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&estateTypes={{$estate->estate_type}}">املاک {{estateTypes($estate->estate_type)}} در شهر {{$estate->city->name}}</a>
                        </li>
                        <li class="mt-2 mb-0 col">
                            <a  href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&estateTypes={{$estate->estate_type}}">املاک {{estateTypes($estate->estate_type)}} در {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                        </li>


                    </ul>
                </div>
                @endif
              </aside>
            </div>
          </section>
          @if (count($similarEstates) > 0)
          <!-- Recently viewed-->
          <section class="container mb-5 pb-2 pb-lg-4">
              <div class="d-flex align-items-center justify-content-between mb-3">
                  <h2 class="h3 mb-0">{{l('ملک های مشابه')}}</h2>
              </div>
              <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
                  <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4"
                  data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:3}}}">
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
      @if(!empty($similar) && $similar->count()>0)
      <section class="mb-4 py-4">
            <div class="container">
                <h2 class="mb-0 pb-2">{{l('املاک مالک')}}</h2>
                <div class="card  bg-white  p-4">
                    <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
                        <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4"
                                data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                            @foreach($similar as $estate1)
                            <div class="col">
                                @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate1])
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
      </section>
      @endif




    </main>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Video</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        @php
                            $videourl = '';
                            if (!empty($estate->video))
                            {
                                $vide = explode("/" , $estate->video);
                                if(is_array($vide))
                                {
                                    $videourl = $vide[count($vide) - 1];
                                }
                            }
                        @endphp
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$videourl}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
    <!-- Review modal-->
    <div class="modal fade" id="modal-review" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-block position-relative border-0 pb-0 px-sm-5 px-4">
                    <h4 class="modal-title mt-4 text-center font-vazir">{{l('ثبت عملکرد برای ملک')}}</h4>
                    <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 px-4">
                    <div class="mb-3">
                        <label class="form-label" for="type">{{l('نوع')}} </label>
                        <select class="form-control form-select" id="type" name="type">
                            <option value="1" >{{l('کارشناسی')}}</option>
                            <option value="2" >{{l('سرویس')}}</option>
                            <option value="4" >{{l('توضیحات')}}</option>
                            <option value="6" >{{l('فروش ویژه')}}</option>
                        </select>
                    </div>
                    <div class="mb-3 " id="customer_id" style="display:none">
                        <label class="form-label" for="customer_id"> {{l('مشتری')}} </label>
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
                        <label class="form-label" for="comment">{{l('توضیحات')}} </label>
                        <textarea class="form-control" id="comment" name="comment" rows="5" placeholder="{{l('توضیحات')}}" required></textarea>
                        <div class="invalid-feedback">{{l('نظر خود را ثبت کنید')}}</div>
                    </div>
                    <button class="btn btn-primary d-block w-100 mb-4 btnOperation" type="submit">{{l('ثبت عملکرد')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="/frontend/vendor/sweetalert2.all.js"></script>

    <script>
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
        var userID = '{{ $currentUser->id ?? 0 }}';
        @if($currentUser && ($currentUser->isExpert() || $currentUser->isAdmin()))
        getOperations({{ $estate->id }});
        @endif
        @if($currentUser)
        getMessages({{ $estate->id }});
        @endif
        var CSRF_TOKEN = '{{ csrf_token() }}';
        function getMessages(chat_id) {
            if (chat_id != 0) {
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});
                $.ajax({
                    url: '/chatsEstate/' + chat_id,
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
                            confirmButtonText: '{{l('باشه')}}',
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
                        confirmButtonText: '{{l('باشه')}}',
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
<script type="application/ld+json">
    [
        {
        "@context":"https://schema.org",
        "url":"{{$estate->url()}}",
        @if($estate->room_count>0)
        "numberOfRooms":"{{ $fieldList['room_count'][$estate->room_count] != 'studio' ? $fieldList['room_count'][$estate->room_count] : 0}}",
        @endif
        "floorSize":{
            "value":{{ $estate->area }},
            "unitCode":"MTK",
            "@type":"QuantitativeValue"
        },
        "accommodationCategory":"{{ estateTypes($estate->estate_type) }}",
        "name":"{{!empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) . ' in ' . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? '')}}",
        @if(isset($url))
        "image":"{{env('APP_URL')}}/upload/images/estate/{{ $url->url() }}",
        @endif
        "@type":"{{ estateTypes($estate->estate_type) }}",
        "description":"{{$estate->description}}"
        },{
            "itemListElement":[
                {
                "@type":"ListItem",
                "item":{"@type":"Thing","name":"{{ss('SITE_NAME')}}","@id":"{{env('APP_URL')}}"},
                "position":1
                },
                @if($estate->city)
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
                        "name":"{{$estate->city->name}} properties",
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
                        "name":"{{($estate->type == 1)?'Rent in ':'Buy in '}} {{$estate->city->name}}"
                    }
                },
                {
                    "item":{
                        "@id":"/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&estateType={{$estate->estate_type}}",
                        "name":"{{($estate->type == 1)?'Buy of  ':'Rent of '}} {{ estateTypes($estate->estate_type) }} in {{$estate->city->name}}",
                        "@type":"Thing"
                    },
                    "@type":"ListItem",
                    "position":5
                },
                {
                    "@type":"ListItem",
                    "item":{
                        "@id":"{{$estate->url()}}",
                        "name":"{{!empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) . ' in ' . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? '')}}",
                        "@type":"Thing"
                    },
                    "position":6
                }
                @endif
                ],
                "@context":"https://schema.org",
                "@type":"BreadcrumbList"
            }
        ]</script>

@endsection
