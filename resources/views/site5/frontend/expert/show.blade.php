@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',['title'=>$user->fullname()])
@section('head')
<style>
    .object-fit-cover {
        object-fit: cover;
    }

    .pic-expert {
        width: 165px;
        height: 165px;
    }

    @media (min-width: 768px) {
                .pic-expert {
                width: 200px;
                height: 200px;
            }
        }
</style>
@endsection
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')

        <!-- Page content-->
        <div class="bg-secondary mt-5 pt-5">
            <section class="container mb-4">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item"><a href="/{{$selectedCity}}/agents/search">{{l('کارشناسان')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('نمایش کارشناس')}}</li>
                    </ol>
                </nav>
            </section>
            <section class="container my-4 border rounded-1 p-4 bg-white">
                <div class="d-flex gap-2 gap-md-3">
                    <div class="avatar-export">
                        <img class="rounded-1 object-fit-cover pic-expert" style="max-height:200px" alt="{{$user ? $user->name:''}}" src="{{$user ? $user->photo():''}}">
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <h2 class="m-0">
                            {{$user->fullname()}}
                        </h2>
                        <p class="fw-light m-0 fs-sm text-black-50">
                            @foreach($user->roles as $role)
                            @if($role->id == 9)
                            {{l('کارشناس '.($user->activity_type == 1 ? l('فروش') : ($user->activity_type == 2 ? l('اجاره') : l('فروش و اجاره'))))}}

                            @endif
                            @endforeach
                        </p>
                        <p class="m-0">
                            {{$user->temp_bio}}
                        </p>
                        <p class="m-0">
                            <b>{{l('شماره تماس')}}:</b>
                            {{$user->username}}
                        </p>
                        <!--<p class="m-0">
                            <b>{{ l('ایمیل:') }}</b>
                            abor@gmail.com
                        </p>
                        <p class="m-0">
                            <b>{{ l('وب سایت') }}</b>
                            www.abor.com
                        </p>-->
                        <p class="m-0 d-flex align-items-center gap-3">
                            @if($user->telegram)
                            <a href="{{$user->telegram}}" class="opacity-60" target="_blank" tabindex="-1">
                                <i class="fi-telegram"></i>
                            </a>
                            @endif
                            @if($user->whatsapp)
                            <a href="{{$user->whatsapp}}" class="opacity-60" target="_blank" tabindex="-1">
                                <i class="fi-whatsapp"></i>
                            </a>
                            @endif
                            @if($user->instagram)
                            <a href="{{$user->instagram}}" class="opacity-60" target="_blank" tabindex="-1">
                            <i class="fi-instagram"></i>
                            </a>
                            @endif
                            @if($user->eitaa)
                            <a href="{{$user->eitaa}}" class="opacity-60" target="_blank" tabindex="-1">
                               <img src="/img/logo/eitaaa.png" width="20px"/>
                            </a>
                            @endif


                        </p>
                    </div>
                </div>
            </section>
            <section class="container pb-md-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h3 mb-0 ">{{l('لیست ملک های فعال')}}</h2>
                </div>
                <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2"
                    dir="ltr">
                    <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4"
                        data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                        <!-- Item-->
                        @foreach( $user->estates as $estate)
                        <div class="col">
                            <div class="card shadow-sm card-hover border-0 h-100">
                                <div class="card-img-top card-img-hover">
                                    <a class="img-overlay" href="{{ $estate->url() }}"></a>
                                    <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                        <span class="d-table badge bg-info mb-1">
                                        @if (env('COUNTRY') == 'UAE')
                                            {{$estate->showdate}}
                                        @else
                                            {{toPersianDate($estate->showdate)}}
                                        @endif
                                        </span>
                                        <span class="d-table badge bg-primary">{{l(estateTypes($estate->estate_type))}}</span>
                                    </div>
                                    <div class="content-overlay end-0 top-0 pt-3 ps-3">
                                        <!--button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Wishlist">
                                            <i class="fi-heart"></i>
                                        </button-->
                                    </div>
                                    <img src="{{ $estate->coverImage() }}" style="height: 200px;width:100%;object-fit:cover" data-src="{{ $estate->coverImage() }}" alt="{{ $estate->title }}">
                                </div>
                                <div class="card-body position-relative pb-3">
                                    <h3 class="h6 mb-2 fs-base">
                                        <a class="nav-link stretched-link" href="{{ $estate->url() }}"> {{ $estate->title }}</a>
                                    </h3>
                                    <div class="d-flex justify-content-between align-content-center">
                                        @if ($estate->type == 2)
                                            <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('رهن')}}:
                                                {{ toPersianNumbers($estate->mortgage) }} {{l('ت')}}</div>
                                            <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('اجاره')}}:
                                                {{ toPersianNumbers($estate->rent) }} {{l('ت')}}</div>
                                        @else
                                            @if ($estate->price > 0)
                                                <div><i class="fi-cash lead align-middle opacity-70"></i>
                                                    {{ toPersianNumbers($estate->price) }} {{l('ت')}}</div>
                                                <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('متری')}}:
                                                    {{ toPersianNumbers($estate->price_per_meter) }} {{l('ت')}}</div>
                                            @else
                                                <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('قیمت')}}: {{l('توافقی')}}
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                @if(env('COUNTRY') != 'UAE')
                                <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                                    <div>
                                        @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{!empty($estate->area)?$estate->{{ l('area." متر":""}}') }}
                                        </span>
                                        @if($estate->geography != null)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ getFeatureValue($featureValues, $estate->geography)}}
                                        </span>
                                        @endif
                                        @if($estate->built_year != null)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> ساخت: {{buildYear($estate->built_year)}}
                                        </span>
                                        @endif
                                        @endif
                                        @if($estate->estate_type == 3 || $estate->estate_type == 4)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{!empty($estate->area)?$estate->{{ l('area." متر":""}}') }}
                                        </span>
                                        @if($estate->geography != null)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ getFeatureValue($featureValues, $estate->geography)}}
                                        </span>
                                        @endif
                                        @if($estate->document_type != null || $estate->convertible != null)
                                        <span class="d-inline-block px-2 fs-sm">
                                            <i class="fi-real-estate-buy me-1 mt-n1 fs-lg text-muted"></i>
                                            @if ($estate->type == 1)
                                                {{getFeatureValue($featureValues, $estate->document_type)}}
                                            @endif
                                            @if ($estate->type == 2)
                                                {{getFeatureValue($featureValues, $estate->convertible)}}
                                            @endif
                                        </span>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            </div>
    </main>
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
