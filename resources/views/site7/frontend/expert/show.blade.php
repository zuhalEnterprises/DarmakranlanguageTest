@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',['title'=>$user->fullname()])
@section('head')
@endsection
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <div class="container mt-5 pt-5 p-0">
            <div class="row g-0 ">
                <!-- Filters sidebar (Offcanvas on mobile)-->
                <input type="hidden" name="type" id="type" value="1">
                <input type="hidden" name="view" id="view" value="1">
                <input type="hidden" name="districts" id="districts" value="">
                <input type="hidden" id="js_HiddenMapDrawPoints" style="width:0px;height:0px;overflow:hidden;border:0px" value="">
            </div>
        </div>
        <section class="container mt-lg-5">
            <div class="w-lg-75 mx-auto">
                <div class="d-flex mb-4">
                    <div class=" d-flex gap-3">
                       <div>
                          <img class="rounded" alt="{{$user ? $user->name:''}}" src="{{$user ? $user->photo():''}}" style="width:100px;height:100px;" />
                       </div>
                       <h1 class="fs-5"> {{$user->fullname()}} </h1>
                    </div>
                    <a href="" class="btn d-lg-none me-auto pt-0">
                        <i class="fi fi-share"></i>
                    </a>
                </div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs border-bottom" role="tablist">
                    <li class="nav-item">
                        <a href="#advertisements" class="nav-link " data-bs-toggle="tab" role="tab">
                        {{ l('آگهی‌ها') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link active" data-bs-toggle="tab" role="tab">
                        {{ l('دربارهٔ مشاور') }}
                        </a>
                    </li>

                    <li class="mb-0 me-auto d-none d-lg-block">
                        <a href="#" class="btn">
                            <span><i class="fi fi-share"></i></span>
                            <span>{{ l('اشتراک‌گذاری صفحه') }}</span>
                        </a>
                    </li>
                </ul>

                <!-- Tabs content -->
                <div class="tab-content">
                    <div class="tab-pane fade " id="advertisements" role="tabpanel">
                            <div class="row align-items-start">

                                <main class="col-12">
                                    <div class="row g-4">
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
                                </main>
                            </div>
                    </div>
                    <div class="tab-pane fade show active" id="about" role="tabpanel">
                        <div class="w-lg-50 mx-auto ">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="">
                                    <h6>
                                        {{$user->fullname()}}
                                    </h6>

                                </div>
                                <div>
                                    <img class="rounded" alt="{{$user ? $user->name:''}}" src="{{$user ? $user->photo():''}}" style="width:60px;height:60px;" />
                                </div>
                            </div>


                            <ul class="px-2 ">

                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="opacity-60">{{ l('موبایل') }}</span>
                                    <span>
                                        <a href="tel:{{$user->phone}}">
                                        {{$user->phone}}
                                        </a>
                                    </span>
                                </li>
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="opacity-60">{{ l('نوع کارشناس') }}</span>
                                    <span>
                                        @foreach($user->roles as $role)
                                        @if($role->id == 9)
                                        {{l('مشاور '.($user->activity_type == 1 ? l('فروش') : ($user->activity_type == 2 ? l('اجاره') : l('فروش و اجاره'))))}}

                                        @endif
                                        @endforeach
                                    </span>
                                </li>
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="opacity-60">{{ l('محدودهٔ فعالیت') }}</span>
                                    <span>
                                        @foreach($user->districts as $item)
                                        {{$item->name}} -
                                        @endforeach
                                    </span>
                                </li>
                                @if(isset($list->user) && isset($list->user->branch))
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="opacity-60">{{ l('آژانس') }}</span>
                                    <span>
                                        {{$list->user->branch->title}}
                                    </span>
                                </li>
                                @endif
                            </ul>


                            <h4 class="fs-lg mb-4">{{ l('دربارهٔ مشاور') }}</h4>
                            <p>
                                {{$user->temp_bio}}
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </section>


    </main>
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
