@foreach ($lists as $key=>$list)
@if($list['t'] == 'customer')
@if(isset($list->created_at))
<!-- Item-->
<div class=" col-md-6 col-lg-4">
    <div class="card  card-hover border-0 h-100 rounded-1">
        <div class="position-relative">
            <div class="position-absolute start-0 top-0 pt-3 ps-3">
                @if($list['relate'] > 0)
                <span class="d-table badge bg-dark mb-1 rounded-0 rounded-start">{{$list['relate']}} ملک مناسب</span>
                @endif
                <span class="d-table badge bg-body rounded-0 rounded-start">{{ toPersianDate($list->created_at) }}</span>
            </div>
            <div class="position-absolute top-0 end-0 zindex-5 rounded-circle m-3 border border-dark" >
                <img src="{{$list->user->photo()}}" alt="{{$list->user->fullname()}}" class="rounded-circle"  style="width:40px; height: 40px;object-fit:cover;">
            </div>
            @if(isset($list->user) && isset($list->user->branch) && $list->user->branch->coverImage(1))
            <img class="rounded-top rounded-bottom-0" src="{{$list->user->branch->coverImage(1)}}" alt="{{$list->user->branch->name}}" style="width: 100%; height: 220px;object-fit:cover;">
            @endif
        </div>
        <div class="border rounded-bottom card-body position-relative pb-3">
            <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">مشتری @if($list->type==1) {{l('فروش')}} @else {{l('رهن و اجاره')}} @endif</h4>
            <h3 class="h6 mb-2 fs-base d-flex justify-content-between">
                <a class="nav-link stretched-link" href="{{$list->url()}}">
                    {{$list->title}}
                </a>
                <div class="position-relative ms-4">
                    <button class="btn btn-icon btn-light-primary btn-xs position-absolute top-0 zindex-5 text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('افزودن به علاقه مندی') }}" data-bs-original-title="{{ l('افزودن به علاقه مندی') }}">
                        <i class="fi-heart"></i>
                    </button>
                    <!--button class="btn btn-icon btn-light-primary btn-xs position-absolute top-0 end-0  zindex-5 text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('گفت و گو') }}" data-bs-original-title="{{ l('گفت و گو') }}">
                        <i class="fi-chat-circle"></i>
                    </button-->
                </div>
            </h3>
            <p class="mb-2 fs-sm text-muted">{{$list->title}}</p>
            @if ($list->type == 1)
            <div class="d-flex justify-content-between">
                @if($list->price_min > 0)
                <div>
                    <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                    <span>{{ l('مبلغ از:') }}</span>
                    {{toPersianNumbers($list->{{ l('price_min)}} ت') }}
                </div>
                @endif
            </div>
            <div class="d-flex justify-content-between mb-2">
                @if($list->rent_min > 0)
                <div>
                    <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                    <span>{{ l('اجاره از:') }}</span>
                    {{toPersianNumbers($list->{{ l('rent_min)}} ت') }}
                </div>
                @endif

            </div>
            @else
            <div class="d-flex justify-content-between">
                @if($list->mortgage_min > 0)
                <div>
                    <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                    <span>{{ l('ودیعه از:') }}</span>
                    {{toPersianNumbers($list->{{ l('mortgage_min)}} ت') }}
                </div>
                @endif
                @if($list->mortgage_max > 0)
                <div>
                    <span>{{ l('تا:') }}</span>
                    {{toPersianNumbers($list->{{ l('mortgage_max)}} ت') }}
                </div>
                @endif
            </div>
            <div class="d-flex justify-content-between mb-2">
                @if($list->rent_min > 0)
                <div>
                    <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                    <span>{{ l('اجاره از:') }}</span>
                    {{toPersianNumbers($list->{{ l('rent_min)}} ت') }}
                </div>
                @endif
                @if($list->rent_max > 0)
                <div>
                    <span>{{ l('تا:') }}</span>
                    {{toPersianNumbers($list->{{ l('rent_max)}} ت') }}
                </div>
                @endif
            </div>
            @endif

            <div>
                <i class="fi-map-pin mt-n1 me-1 lead align-middle opacity-70"></i>
                @php
                    $count = 0;
                @endphp
                @foreach($list->districts as $district)
                @php
                    $count++;
                @endphp
                {{$district->name}} -
                @php
                if($count == 3)
                    break;
                @endphp
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
@else
<!-- Item-->
<div class=" col-md-6 col-lg-4">
    <div class="card  card-hover border-0 h-100 rounded-1">
        <div class="position-relative">
            <div class="position-absolute start-0 top-0 pt-3 ps-3">
                @if($list['relate'] > 0)
                    <span class="d-table badge bg-primary mb-1 rounded-0 rounded-start">{{$list['relate']}} مشتری مناسب</span>
                @endif
                <span class="d-table badge bg-body rounded-0 rounded-start">{{ toPersianDate($list->created_at) }}</span>
            </div>
            <img class="rounded-top rounded-bottom-0" src="{{$list->coverImage()}}" alt="{{$list->title}}" style="width: 100%;height: 220px;object-fit:cover;">
        </div>
        <div class="border rounded-bottom card-body position-relative pb-3">
            <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">املاک @if($list->type==1) {{l('فروش')}} @else {{l('رهن و اجاره')}} @endif</h4>
            <h3 class="h6 mb-2 fs-base d-flex justify-content-between">
                <a class="nav-link stretched-link" href="{{$list->url()}}">ویلا 2 طبقه | {{$list->{{ l('area}} متر مربع') }}</a>
                <div class="position-relative ms-4">
                    <button class="btn btn-icon btn-light-primary btn-xs position-absolute top-0 zindex-5 text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('افزودن به علاقه مندی') }}" data-bs-original-title="{{ l('افزودن به علاقه مندی') }}">
                        <i class="fi-heart"></i>
                    </button>
                    <button class="d-none btn btn-icon btn-light-primary btn-xs position-absolute top-0 end-0  zindex-5 text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="{{ l('گفت و گو') }}" data-bs-original-title="{{ l('گفت و گو') }}">
                        <i class="fi-chat-circle"></i>
                    </button>
                </div>
            </h3>
            <p class="mb-2 fs-sm text-muted">{{$list->title}}</p>
            @if ($list->type == 1)
            <div class="d-flex justify-content-between mb-2">
                <div>
                    <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                    <span>{{ l('قیمت :') }}</span>
                    @if ($list->price > 0)
                    {{ toPersianNumbers($list->price) }} ت
                    @else
                    توافقی
                    @endif
                </div>
            </div>
            @else

            <div class="d-flex justify-content-between mb-2">
                <div>
                    <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                    <span>{{ l('ودیعه:') }}</span>
                    {{ toPersianNumbers($list->mortgage) }} {{l('ت')}}
                </div>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <div>
                    <i class="fi-cash mt-n1 me-1 lead align-middle opacity-70"></i>
                    <span>{{ l('اجاره:') }}</span>
                    {{ toPersianNumbers($list->rent) }} {{l('ت')}}
                </div>

            </div>
            @endif

            <div>
                <i class="fi-map-pin mt-n1 me-1 lead align-middle opacity-70"></i>
                {{($list->city->name ?? '').' '.($list->district->name ?? '')}}
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

