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
    <link rel="stylesheet" media="screen" href="/vendor/lightgallery.js/dist/css/lightgallery.min.css"/>
    <link rel="stylesheet" media="screen" href="/vendor/tiny-slider/dist/tiny-slider.css"/>
    <link rel="stylesheet" media="screen" href="/vendor/flatpickr/dist/flatpickr.min.css"/>
    <link rel="stylesheet" media="screen" href="/vendor/expandable/jquery.expandable.css" />
    <script src="/vendor/lightgallery.js/dist/js/lightgallery.min.js"></script>
    <script src="/vendor/lg-fullscreen.js/dist/lg-fullscreen.min.js"></script>
    <script src="/vendor/lg-zoom.js/dist/lg-zoom.min.js"></script>
    <script src="/vendor/lg-thumbnail.js/dist/lg-thumbnail.min.js"></script>
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
        <!-- Gallery-->
        <style>
        .more {
            color: red;
            font-weight: bold;
        }
        .lg-outer{direction:rtl}
        </style>
        <section class="container">
            <!-- Features + Sharing-->
            <div class="d-flex justify-content-between align-items-center">
                <ul class="d-flex mb-4 list-unstyled">
                    <li class="me-3 pe-3 border-end">
                        <b class="me-1">
                            {{ $estate->room_count == 0 || $fieldList['room_count'][$estate->room_count] == l('بدون اتاق')  ? 'Studio' : l($fieldList['room_count'][$estate->room_count])}}
                        </b>
                        <i class="fi-bed mt-n1 lead align-middle text-muted"></i>
                    </li>
                    @if($estate->bed_count>0)
                    <li class="me-3 pe-3 border-end">
                        <b class="me-1">{{$estate->bed_count}}</b>
                        <i class="fi-bath mt-n1 lead align-middle text-muted"></i>
                    </li>
                    @endif
                    <li><b class="areaval">{{$estate->area}}</b> <span class="areakey">{{l('فوت مربع')}}</span></li>
                </ul>
                <div class="text-nowrap">

                    @if (Auth::check())
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
                            @if($currentUser && $currentUser->isReferrer())
                                <button class="dropdown-item copy-referral-link"
                                        type="button"
                                        data-link="{{ url('/v/' . $estate->id . '?refid=' . $currentUser->id) }}">
                                    <i class="fas fa-bullhorn fs-base opacity-75 me-2"></i>{{ l('لینک بازاریابی') }}
                                </button>
                            @endif

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
                        </div>
                    </div>
                    <button class="btn-primary btn shadow-sm ms-2 mb-2" type="button" data-bs-toggle="modal" data-bs-target="#modalCentered">
                        <i class="fi-settings"></i>
                    </button>
                </div>
            </div>
        </section>

        @if($images->where("360","=",0)->count() > 0)
        <section dir="rtl" class="container overflow-auto mb-4 pb-3" data-simplebar>
            <div class="row g-2 g-md-3 gallery" data-thumbnails="true">
                @php
                    $count = 1;
                @endphp

                @foreach ($images->where("360","=",0) as $url)
                @if($count == 1)
                <div class="col-8">
                    <a class="gallery-item rounded rounded-md-3" href="{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}">
                        <img src="{{crop('/upload/images/estate/'.$url->url(),855,855)}}" alt="Gallery thumbnail" class="gallery-main-img">
                    </a>
                </div>
                @endif
                @if($count == 2 || $count == 3)

                @if($count == 2)
                <div class="col-4">
                    <a class="gallery-item rounded rounded-md-3 mb-2 mb-md-3" href="{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}">
                        <img src="{{crop('/upload/images/estate/'.$url->url(),855,855)}}" class="gallery-img">
                    </a>
                    @endif
                    @if($count == 3)
                    <a class="gallery-item rounded rounded-md-3" href="{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}">
                        <img src="{{crop('/upload/images/estate/'.$url->url(),855,855)}}" class="gallery-img">
                        @php
                            $co = $images->where("360","=",0)->count() - 3;
                        @endphp
                        @if($co>0)
                        <span class="gallery-item-caption fs-base"><span class='d-none d-md-inline'>{{ l('سایر تصاویر') }}</span> +{{$co}} </span>
                        @endif
                    </a>
                </div>
                    @endif
                @endif
                @if($count > 3)
                <a style="display:none" class="gallery-item rounded-1 rounded-md-2" href="{{getDomainImg($url->id)}}/upload/images/estate/{{ $url->url() }}" >
                    <img src="{{crop('/upload/images/estate/'.$url->url(),855,855)}}" alt="Gallery thumbnail">
                </a>
                @endif
                @php
                $count++;
                @endphp
                @endforeach
            </div>
        </section>

        <style>
        @media (min-width: 768px) {
            .gallery-main-img {
                display: block;
                max-height: 577px;
            }

            .gallery-img {
                height: 280px;
                width: 100%;
                object-fit: cover;
            }
        }
        @media (max-width: 768px) {
            .gallery-main-img {
                display: block;
                height: 231px;
                width: 100%;
                object-fit: cover;
            }

            .gallery-img {
                height: 111px;
                width: 100%;
                object-fit: cover;
            }
        }
        </style>
        @endif
        <section class="container mb-5 pb-1">
            <div class="row">
                <div class="col-md-7 mb-md-0 mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-md-0 mb-4">
                            <h2 class="h4">
                                @if ($estate->type == 1)
                                @if ($estate->price > 0)
                                <span class="d-inline-block ms-1 fs-base fw-normal text-body">{{ l('قیمت:') }}</span>
                                @if(isValueShow($estate->conditions,15) && !isValueShow($estate->{{ l('conditions,384)) از') }} <span class="priceval">{{ toPersianNumbers($estate->price) }}</span>
                                {{ l('تا') }} <span class="pricetoval">{{ toPersianNumbers($estate->mortgage) }}</span>
                                @else
                                <span class="priceval">{{ toPersianNumbers($estate->price) }}</span>
                                @endif
                                <span class="d-inline-block ms-1 fs-base fw-normal text-body pricekey">{{l('درهم')}}</span>
                                @else
                                {{l('توافقی')}}
                                @endif
                                @endif
                                @if ($estate->type == 2)
                                <span class="priceval">
                                    {{ toPersianNumbers($estate->rent) }}
                                </span>

                                <span class="d-inline-block ms-1 fs-base fw-normal text-body">
                                    <span class="pricekey">{{l('درهم')}}</span>
                                    @php
                                    switch($estate->rentfrequency)
                                    {
                                        case "1": $rentfrequency = l('/روزانه'); break;
                                        case "7": $rentfrequency = l('/هفتگی'); break;
                                        case "30": $rentfrequency = l('/ماهانه'); break;
                                        case "365": $rentfrequency = l('/سالانه'); break;
                                        default: $rentfrequency = '';
                                    }
                                    echo $rentfrequency;
                                    @endphp
                                </span>
                                @endif
                            </h2>
                            <p class="mb-2 fs-sm text-muted">
                                {{ $estate->city->name ?? '' }} {{ $estate->district->name ?? '' }}
                            </p>
                        </div>

                    </div>
                    <!-- Property Details-->
                    <div class="mb-4 pb-md-3 border-top  mt-2 pt-4">
                        <h3 class="h4">{{ l('جزئیات ملک') }}</h3>
                        <ul class="list-unstyled mt-n2 mb-0 row row-cols-2 row-cols-sm-1">
                            <li class="mt-2 mb-0 col"><b>{{l('نوع')}}: </b>
                                {{ estateTypes($estate->estate_type) }}
                                @if(isValueShow($estate->conditions,15))
                                <span class="badge bg-info me-2 mb-2">{{ l('پیش فروش') }}</span>
                                @endif
                            </li>
                            <li class="mt-2 mb-0 col"><b>{{l('شماره آگهی')}}:</b> {{ $estate->id }}</li>
                            <li class="mt-2 mb-0 col"><b>{{l('متراژ زمین')}}: </b>

                                @if(isValueShow($estate->conditions,15) && !isValueShow($estate->{{ l('conditions,384)) از') }} <span class="areaval">{{ $estate->area }}</span>
                                {{ l('تا') }} <span class="areatoval">{{$estate->front_area}}</span>
                                @else
                                <span class="areaval">{{ $estate->area }}</span>
                                @endif

                                <span class="areakey">{{l('فوت مربع')}}</span></li>

                            @if (!empty($estate->project_id) && isset($estate->project))
                                <li class="mt-2 mb-0 col"><b>{{l('پروژه')}}: </b>
                                    <a target="_blank" href="{{$estate->project->post_id>0 && isset($estate->project->post) ? $estate->project->post->url() : 'javascript:void(0)'}}">
                                    {{ $estate->project->name }}
                                    </a>
                                </li>
                            @endif
                            @if (!empty($estate->manufacturer_id))
                                <li class="mt-2 mb-0 col"><b>{{l('سازنده')}}: </b>
                                    <a target="_blank" href="{{$estate->manufacturer->post_id>0 && isset($estate->project->post) ? $estate->manufacturer->post->url() : 'javascript:void(0)'}}">
                                    {{ $estate->manufacturer->name }}
                                    </a>
                                </li>
                            @endif
                            @if (!empty($estate->brand_id))
                                <li class="mt-2 mb-0 col"><b>{{l('برند')}}: </b>
                                    <a target="_blank" href="{{$estate->brand->post_id>0 && isset($estate->brand->post) ? $estate->brand->post->url() : 'javascript:void(0)'}}">
                                    {{ $estate->brand->name }}
                                    </a>
                                </li>
                            @endif
                            @if(isValueShow($estate->conditions,15))
                                <li class="mt-2 mb-0 col"><b>{{l('زمان تحویل')}}: </b>
                                    {{ getoffplanyear($estate->built_year) }} </li>
                            @endif
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
                        <ul class="list-unstyled row row-cols-lg-2 row-cols-md-2 row-cols-2 gy-1 mb-1 text-nowrap">
                            @if (!empty($estate->facilities))
                            @foreach (json_decode($estate->facilities, true) as $value)
                            <li class="col">

                                @if (!empty(IconFacility($fieldList['facilities'][$value])))
                                    <img class="mt-n1 me-2 fs-lg align-middle" src="/frontend/show/svg/{{ IconFacility($fieldList['facilities'][$value]) ?? '' }}.svg"
                                        alt="{{l($fieldList['facilities'][$value]) }}"  width="18px" height="18px" />
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
                    @if (!empty($estate->conditions))
                    <div class="card border-0 bg-secondary mb-4">
                        <div class="card-body">
                            <h3 class="h5">{{l('شرایط ملک')}}</h3>
                            <ul class="list-unstyled row row-cols-lg-3 row-cols-md-2 row-cols-2 gy-1 mb-1 text-nowrap">
                                @foreach (json_decode($estate->conditions, true) as $value)
                                    <li class="col">
                                        @if (!empty($fieldList['conditions'][$value]) &&  !empty(IconFacility($fieldList['conditions'][$value])))
                                            <img src="/frontend/show/svg/{{ IconFacility($fieldList['conditions'][$value]) ?? '' }}.svg"
                                                width="18px" height="18px" />
                                        @endif
                                        {{l($fieldList['conditions'][$value]) }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    @php
                        $previewable = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                        $pdfTypes = ['pdf'];
                        $wordTypes = ['doc', 'docx'];
                        $excelTypes = ['xls', 'xlsx'];
                        $videoTypes = ['mp4', 'webm', 'ogg'];
                        $fileExtension = function($item) {
                            return strtolower(pathinfo($item->name, PATHINFO_EXTENSION));
                        };
                    @endphp

                    @if($estate != null && $estate->images->count() > 0)
                        <div id="images" class="card mb-3">

                            <div class="card-body d-flex flex-wrap justify-content-around gap-3">
                                @foreach($estate->images->where("plan", "=", 1) as $item)
                                @php $ext = $fileExtension($item); @endphp
                                <div id="media-{{$item->id}}" data-id="{{$item->id}}" class="card p-2 rounded dz-preview text-center" style="width: 160px;">
                                    <a href="{{ $item->url() }}" target="_blank">
                                        @if(in_array($ext, $previewable))
                                            <img src="{{ $item->url() }}" class="w-100 rounded" style="height: 120px; object-fit: cover;">
                                        @elseif(in_array($ext, $pdfTypes))
                                            <img src="/img/icon/pdf.png" style="height: 80px;"><br>
                                            <span class="small text-muted">PDF</span>
                                        @elseif(in_array($ext, $wordTypes))
                                            <img src="/img/icon/word.png" style="height: 80px;"><br>
                                            <span class="small text-muted">Word</span>
                                        @elseif(in_array($ext, $excelTypes))
                                            <img src="/img/icon/excel.png" style="height: 80px;"><br>
                                            <span class="small text-muted">Excel</span>
                                        @elseif(in_array($ext, $videoTypes))
                                            <video src="{{ $item->url() }}" controls style="width: 100%; height: 120px; object-fit: cover;"></video>
                                        @else
                                            <img src="/img/icon/file.png" style="height: 80px;"><br>
                                            <span class="small text-muted">{{ strtoupper($ext) }}</span>
                                        @endif
                                    </a>
                                    <!-- عنوان فایل و URL -->
                                    <div class="mt-2 small text-break">
                                        <strong>{{ $item->name }}</strong><br>
                                        <strong>{{ $item->extension }}</strong>
                                    </div>
                                </div>
                            @endforeach

                            </div>
                        </div>
                    @endif
                    <!-- Overview-->
                    <div class="mb-4 pb-md-3">
                        <h3 class="h5">{{ l('توضیحات') }}</h3>
                        <p class="mb-1 line-h18 fulldescription">
                            <?php echo nl2br($estate->description); ?>
                        </p>
                    </div>
                    @if($currentUser && $currentUser->isAdmin())
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
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="menu-social-container">
                                    <ul class="nav flex-row justify-content-center gap-3">
                                        @if($estate->audio)
                                        <li class="nav-item mb-2 fs-5">
                                            <a class="nav-link fw-normal btn-primary btn shadow-sm ms-2" aria-label="instagram" href="{{$estate->audio}}">
                                                <i class="fi-instagram"></i> Instagram
                                            </a>
                                        </li>
                                        @endif
                                        @if($estate->video)
                                        <li class="nav-item mb-2 fs-5">
                                            <a class="nav-link fw-normal btn-primary btn shadow-sm ms-2" aria-label="youtube" href="{{$estate->video}}">
                                                <i class="fi-youtube"></i> Youtube
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($estate->expert))
                    <!-- Contact card-->
                    @if(app('request')->input('he') == '')
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <a class="text-decoration-none" href="/agents/{{!empty($estate->expert)?$estate->expert->id:''}}">
                                    <div class="d-flex gap-3 justify-content-left">
                                        <img class="rounded-circle mb-2" src="{{ !empty($estate->expert) ? ($estate->expert->photo() ? $estate->expert->photo() : noImage()) : noImage() }}" width="60" alt="{{!empty($estate->expert)?$estate->expert->fullname():''}}">
                                        <div class="text-body">
                                            <h5 class="mb-1">
                                                {{!empty($estate->expert)?$estate->expert->fullname():''}}
                                            </h5>
                                            <div class="mb-1">
                                            @if(!empty($estate->expert))
                                                @foreach($estate->expert->roles as $role)
                                                    @if($role->id == 9)
                                                    {{($estate->expert->activity_type == 1 ? l('مشاور فروش') : ($estate->expert->activity_type == 2 ? l('مشاور اجاره') : l('مشاور فروش و اجاره')))}}
                                                    @endif
                                                @endforeach
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex gap-1 justify-content-center mt-5">
                                @if($estate->expert->phone != '')
                                <a class="btn btn-secondary fw-bold" style="color:red" href="tel:{{!empty($estate->expert)?$estate->expert->phone:''}}">
                                    <i class="fi-phone mt-n1 me-2 align-middle opacity-60"></i>
                                    Call
                                </a>
                                @endif

                                @if($estate->expert->whatsapp != '')
                                <a class="btn btn-secondary fw-bold" style="color:green" href="https://wa.me/{{$estate->expert->whatsapp}}">
                                    <i class="fi-whatsapp mt-n1 me-2 align-middle opacity-60" ></i>
                                    Whatsapp
                                </a>
                                @endif
                            </div>

                        </div>
                    </div>
                    @endif
                    @endif
                    <!-- Location (Map)-->
                    <div class="pt-2">
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

                                var map = L.map('map').setView([{{ $estate->latitude }} , {{ $estate->longitude }}], 13);
                                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                }).addTo(map);
                                L.marker([{{ $estate->latitude }} , {{ $estate->longitude }}]).bindPopup('I am a green leaf.').addTo(map);

                        </script>
                        @endif
                        @if($estate->city)
                        <div class="mb-4 pb-md-3 mt-5">
                            <h3 class="h4">{{ l('لینک‌های مفید') }}</h3>

                            <ul class="list-unstyled mt-n2 mb-0 row row-cols-1">

                                <li class="mt-2 mb-0 col">
                                    <a href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}">- املاک در {{$estate->city->name}}</a>
                                </li>
                                <li class="mt-2 mb-0 col">
                                    <a href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}&&districts={{($estate->district->id ?? '')}}">- املاک در {{($estate->district->name ?? '')}}</a>
                                </li>
                                <li class="mt-2 mb-0 col">
                                    <a href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&type={{$estate->type}}">- املاک {{($estate->type == 2 ? l('برای اجاره') : l('فروشی'))}} در {{$estate->city->name}}</a>
                                </li>
                                <li class="mt-2 mb-0 col">
                                    <a href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&type={{$estate->type}}">- املاک {{($estate->type == 2 ? l('برای اجاره') : l('فروشی'))}} در {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                                </li>
                                <li class="mt-2 mb-0 col">
                                    <a href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&type={{$estate->type}}&estateTypes={{$estate->estate_type}}">- {{estateTypes($estate->estate_type)}} {{($estate->type == 2 ? l('برای اجاره') : l('فروشی'))}} در {{$estate->city->name}}</a>
                                </li>
                                <li class="mt-2 mb-0 col">
                                    <a href="/c/{{$selectedCity}}?city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&type={{$estate->type}}&estateTypes={{$estate->estate_type}}">- {{estateTypes($estate->estate_type)}} {{($estate->type == 2 ? l('برای اجاره') : l('فروشی'))}} در {{($estate->district->name ?? '')}} {{$estate->city->name}}</a>
                                </li>
                                <li class="mt-2 mb-0 col">
                                    <a href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&estateTypes={{$estate->estate_type}}">- املاک {{estateTypes($estate->estate_type)}} در {{$estate->city->name}}</a>
                                </li>
                                <li class="mt-2 mb-0 col">
                                    <a href="/c/{{$selectedCity}}?type={{$estate->type}}&&city_id={{$estate->city->id}}&districts={{($estate->district->id ?? '')}}&estateTypes={{$estate->estate_type}}">- املاک {{estateTypes($estate->estate_type)}} در {{($estate->district->name ?? '')}}</a>
                                </li>

                            </ul>
                        </div>
                        @endif
                    </div>
                </aside>
            </div>
        </section>

        <div class="modal fade" id="modalCentered" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{l('تنظمیات')}}</h4>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="mb-3 row align-items-center">
                                <label class="col-md-3 col-form-label" for="currency">{{l('واحد پولی')}}</label>
                                <div class="col-md-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="currency-dollar" type="radio" name="currency" value="dollar">
                                        <label class="form-check-label" for="currency-dollar">{{l('دلار')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="currency-dirham" type="radio" name="currency" value="dirham" checked>
                                        <label class="form-check-label" for="currency-dirham">{{l('درهم')}}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                            <label class="col-md-3 col-form-label" for="area-unit">{{l('واحد مساحت')}}</label>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="area-meter" type="radio" name="area" value="meter">
                                    <label class="form-check-label" for="area-meter">{{l('مترمربع')}}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="area-feet" type="radio" name="area" value="feet" checked>
                                    <label class="form-check-label" for="area-feet">{{l('فوت مربع')}}</label>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">{{l('بستن')}}</button>
                        <button class="btn btn-primary btn-shadow btn-sm" type="button" id="saveSettings">{{l('ذخیره')}}</button>
                    </div>
                </div>
            </div>
        </div>



        @if (count($similarEstates) > 0)
        <!-- Recently viewed-->
        <section class="container mb-5 pb-2 pb-lg-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h3 mb-0">Similar Properties</h2>
                <a class="btn btn-link fw-normal p-0" href="/cities">View all<i class="fi-arrow-long-right ms-2"></i></a>
            </div>
            <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
                <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                    @foreach ($similarEstates as $estate)
                    <div class="col">
                        @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate])
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </main>


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
    <script>
        const toast = Swal.mixin({
            toast: true,
            position: 'top-center',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        });
        $(document).ready(function(){

            $('#others_text').hide()
            $('.flexRadioDefault').on('change',function(){
                var currentTest = $(this).val();
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
    function changevahed(currency , areaUnit)
    {
        if(areaUnit != null)
        {
            var area = {{(int)$estate->area}};
            var areato = {{(int)$estate->front_area}};
            var areakey = '';
            if(areaUnit == 'feet')
            {
                areakey = '{{l('فوت مربع')}}';
            }
            else
            {
                areakey = '{{l('مترمربع')}}';
                area = area / 10.7639;
                areato = areato / 10.7639;
            }
            $('.areaval').html(Math.floor(area).toLocaleString());
            $('.areatoval').html(Math.floor(areato).toLocaleString());
            $('.areakey').html(areakey);
        }
        if(currency != null)
        {
            @if ($estate->type == 1)
                var price = {{$estate->price}};
                var priceto = {{$estate->mortgage}};
            @else
                var price = {{$estate->rent}};
            @endif

            var pricekey = '';
            if(currency == 'dirham')
            {
                pricekey = '{{l('درهم')}}';
            }
            else
            {
                pricekey = '{{l('دلار')}}';
                price = price / 3.67;
                priceto = priceto / 3.67;
            }

            $('.priceval').html(Math.floor(price).toLocaleString());
            $('.pricetoval').html(Math.floor(priceto).toLocaleString());
            $('.pricekey').html(pricekey);
        }
    }

    // تابع برای تنظیم کوکی با زمان انقضای طولانی (100 سال)
    /*function setCookie(name, value, days = 365 * 100) {
        const expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/';
    }*/

    document.getElementById("saveSettings").addEventListener("click", function () {
        const currency = document.querySelector('input[name="currency"]:checked').value;
        const areaUnit = document.querySelector('input[name="area"]:checked').value;

        setCookie("currency_unit", currency);
        setCookie("area_unit", areaUnit);

        changevahed(currency , areaUnit);

        //alert(l("تنظیمات ذخیره شد."));
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalCentered'));
        modal.hide(); // بستن مدال
    });
</script>
<script src="/vendor/expandable/jquery.expandable.js"></script>
<script type="text/javascript">
    /*function getCookie(name) {
    return document.cookie.split('; ').reduce((r, v) => {
        const parts = v.split('=');
        return parts[0] === name ? decodeURIComponent(parts[1]) : r
    }, '');
    }*/

    $(document).on('click', '.copy-referral-link', function (e) {
            e.preventDefault();
            const link = $(this).data('link');

            if (!link) {
                Swal.fire({
                    icon: 'error',
                    title: '{{l('خطا')}}',
                    text: '{{l('لینک پیدا نشد')}}!',
                });
                return;
            }

            navigator.clipboard.writeText(link).then(() => {
                toast.fire({
                    icon: 'success',
                    title: '{{l('لینک بازاریابی در کلیپ‌بورد کپی شد')}}'
                });
            }).catch((err) => {
                toast.fire({
                    icon: 'error',
                    title: '{{l('خطا در کپی کردن لینک')}}'
                });
                console.error(err);
            });
        });
    jQuery(document).ready(function() {
        const currency = getCookie('currency_unit'); // مثلا "dirham"
        const area = getCookie('area_unit'); // مثلا "feet"


        if (currency) {
            let currencyRadio = document.querySelector(`input[name="currency"][value="${currency}"]`);
            if (currencyRadio) currencyRadio.checked = true;
        }

        if (area) {
            let areaRadio = document.querySelector(`input[name="area"][value="${area}"]`);
            if (areaRadio) areaRadio.checked = true;
        }
        changevahed(currency , area);

        $('.fulldescription').expandable({
            height: 350,
            offset:120,

            more: l("مشاهده توضیحات بیشتر"),
            less: l("مشاهده توضیحات محدود")
        });


    });
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
