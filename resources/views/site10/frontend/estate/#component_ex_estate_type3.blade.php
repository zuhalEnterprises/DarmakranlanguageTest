
<div class="col-12 col-lg-8">
@foreach($estates as $estate)
<!-- Item-->

        <div class="d-flex flex-column flex-lg-row shadow-sm  border-0 gap-2 p-3 mb-3 rounded-1">
            <div class="tns-carousel-wrapper card-img-top card-img-hover w-lg-50 w-100">
                <a class="img-overlay" href="{{$estate->url()}}">
                </a>
                <div class="content-overlay end-0 top-0 pt-3 ps-3">
                    <button class="itemFavorite_{{$estate->id}} text-[20px]  {{count($estate->favorites)>0?'text-blue-500':'text-gray-200'}}  btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" onclick="addFavorite({{$estate->id}}) " data-id="{{$estate->id}}">
                        <i class=" fa-solid fa-bookmark"></i>
                    </button>
                </div>
                <div>
                    <img src="{{ crop($estate->coverImage() , 400 , 400) }}" class=" rounded-1 imgestate object-cover" alt="Image">
                </div>
            </div>
            <div class="d-flex flex-column gap-2 px-2 w-100">
                <div class="d-flex justify-content-between align-items-center  m-0">
                    <p class="d-flex align-items-center gap-1 m-0">
                        <span class="d-table badge bg-success l(">@if($estate->type==1) فروش @else رهن و اجاره @endif</span>
                        <span class=")d-table badge bg-info">{{ l('جدید') }}</span>
                    </p>
                    <div class="d-table badge bg-primary">
                        {{toPersianDate($estate->showdate)}}
                    </div>
                </div>
                <h4 class="fs-sm fw-normal text-uppercase text-primary m-0">{{estateTypes($estate->estate_type)}}</h4>
                <h3 class="h6 m-0 fs-base">
                    <a class="nav-link" href="{{$estate->url()}}">
                        @if($estate->title != '')
                            {{$estate->title}}
                        @else
                            {{estateTypes($estate->estate_type)}} | {{$estate->area}} متر مربع
                        @endif
                    </a>
                </h3>
                <p class="m-0 fs-sm text-muted">
                    {{$estate->city->name??""}}، {{$estate->district->name??""}}
                </p>
                <div class="d-flex align-items-center justify-content-between text-nowrap">
                <div class="fw-bold">
                        @if ($estate->type == 2)
                        <div> رهن:
                            {{ toPersianNumbers($estate->{{ l('mortgage) }} تومان') }}</div>
                        <div> اجاره:
                            {{ toPersianNumbers($estate->{{ l('rent) }} تومان') }}</div>
                    @else
                        @if ($estate->price > 0)
                            <div>قیمت :
                                {{ toPersianNumbers($estate->{{ l('price) }} تومان') }}</div>
                            <div>قیمت متری :
                                {{ toPersianNumbers($estate->{{ l('price_per_meter) }} تومان') }}</div>
                        @else
                            <div>{{ l('قیمت: توافقی') }}
                            </div>
                        @endif
                    @endif

                    </div>

                    <!-- <div class="fw-bold"><i
                        class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>{{ l('680000 تومان') }}
                </div> -->
                </div>
            </div>
        </div>

@endforeach
</div>
<div class="col-lg-4 d-none d-lg-block" >
    <div class="card text-primary shadow">
        <div class="card-header ">{{ l('لینک های مرتبط') }}</div>
        <div class="card-body">
            <ul class="list-unstyled">
                <li>
                    <a class="flex align-items-center gap-2 mb-2 opacity-80" href="/test" >
                        <i class="fi-external-link"></i>{{ l('لینک شماره 1') }}
                    </a>
                </li>
                <li>
                    <a class="flex align-items-center gap-2 mb-2 opacity-80" href="/test" >
                        <i class="fi-external-link"></i>{{ l('لینک شماره 2') }}
                    </a>
                </li>
                <li>
                    <a class="flex align-items-center gap-2 mb-2 opacity-80" href="/test" >
                        <i class="fi-external-link"></i>{{ l('لینک شماره 3') }}
                    </a>
                </li>
            </ul>
         </div>
    </div>
</div>


