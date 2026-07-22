@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',['title'=>$user->fullname()])
@section('head')
@endsection
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <!-- Background Image -->
        <section class="container d-none">
            <div class="backImg">
                <!-- <img class="w-100" src="./img/real-estate/catalog/08.jpg" alt=""> -->
            </div>
        </section>
        <!-- Page content-->
        <section class="container pt-5 mt-5 mb-4">
            <!-- Breadcrumb-->
            <nav class="mb-3 pt-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                    <li class="breadcrumb-item"><a href="#">{{l('مشاورین')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> {{l('پروفایل مشاور')}}</li>
                </ol>
            </nav>
        </section>
        <section class="container my-4 ">
            <div class="d-flex gap-2 gap-md-3">
                <div class="avatar-export">
                    <img class="rounded-1" style="max-height:200px" alt="{{$user ? $user->name:''}}" src="{{$user ? $user->photo():''}}">
                </div>
                <div class="d-flex flex-column gap-2">
                    <h2 class="m-0">
                        {{$user->fullname()}}
                    </h2>
                    <p class="fw-light m-0 fs-sm text-black-50">
                        @foreach($user->roles as $role)
                        @if($role->id == 9)
                        {{l('مشاور '.($user->activity_type == 1 ? l('فروش') : ($user->activity_type == 2 ? l('اجاره') : l('فروش و اجاره'))))}}

                        @endif
                        @endforeach
                    </p>
                    <p class="m-0">
                        {{$user->temp_bio}}
                    </p>
                    <p class="m-0">
                        <b>{{l('شماره تماس')}}:</b>
                        <a href="tel:{{$user->username}}">{{$user->username}}</a>
                    </p>
                    @if (env('COUNTRY') == 'UAE')
                    <p class="m-0">
                        <b>Email:</b>
                        {{$user->username}}
                    </p>
                    @else
                    <div class="text-center text-md-start mt-3">
                        <a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm " href="#">
                            <i class="fi-whatsapp"></i>
                        </a>
                        <a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm" href="#">
                            <i class="fi-instagram"></i>
                        </a>
                        <a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm" href="#">
                            <i class="fi-telegram"></i>
                        </a>
                        <a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm opacity-80" rel="nofollow"  style="width: 32px;">
                                            <svg class="opacity-80" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3584.55 3673.6" style="width: 15px;">
                                                <g id="Isolation_Mode" data-name="Isolation Mode">
                                                    <path d="M1071.43,2.75H2607.66C3171,2.75,3631.82,462.91,3631.82,1026.2v493.93c-505,227-1014.43,1348.12-1756.93,1104.51-61.16,43.46-202.11,222.55-212,358.43-257.11-34.24-553.52-328.88-517.95-646.62C717,2026.91,1070.39,1455.5,1409.74,1225.51c727.32-492.94,1737.05-69,1175.39,283.45-341.52,214.31-1071.84,355.88-995.91-170.24-200.34,57.78-328.58,431.34-87.37,626-223.45,219.53-180.49,623.07,58.36,755.57,241.56-625.87,1082.31-544.08,1422-1291.2,255.57-562-123.34-1202.37-880.91-1104C1529.56,399.34,993.64,881.63,725.62,1453.64,453.68,2034,494.15,2811.15,1052.55,3202.82c657.15,460.92,1356.78,34.13,1780.52-523.68,249.77-328.78,468-693,798.75-903.37v875.72c0,563.28-460.88,1024.86-1024.16,1024.86H1071.43c-563.29,0-1024.16-460.87-1024.16-1024.16V1026.9C47.27,463.61,508.14,2.74,1071.43,2.74Z" transform="translate(-47.27 -2.74)" fill="#000" fill-rule="evenodd"></path>
                                                </g>
                                            </svg>



                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <section class="container mb-5 pb-md-4">
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
                        <div class="card shadow-sm rounded card-hover border-0 h-100">
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
    </main>
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
