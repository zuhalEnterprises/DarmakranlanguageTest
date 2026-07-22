@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME')
])

@section('main_content')

<style>
@media (min-width: 992px)
{
.navbar-expand-lg .dropdown-menu-end {
    left: auto;
    /* right: 0; */
}

.collapse{
    visibility: unset;
}
}
.border-t {
    border-top-width: 1px;
}

.mobile-w-50 {
    width: 50%;
}
.img-expert-suggest {
    width: 130px;
    height: auto;
    object-fit: cover;
    border-radius: 100%;
}
.imgestate {
    height: 206px;
    width: 100%;
}
.object-cover {
    object-fit: cover;
}
.btn-estate {
    width: 100%;
}
@media (min-width: 768px) {
    .mobile-w-50 {
        width: 25%;
    }
    .btn-estate {
        width: auto;
    }
    .img-expert-suggest {
        width: 150px;
        height: 150px;
    }
}

</style>

<script src="/frontend/vendor/sweetalert2.all.js"></script>
<script>
    const toast = swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 2500
    });
</script>

<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2')
    <!-- Page content-->
    <section class="container pt-5 pb-lg-4 mt-5 mb-sm-2">

        <!-- Page content-->
        <div class="row">
            <!-- Page content-->
            <div class="col-lg-12 col-md-12 mb-3 account add-property">
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('جزئیات خریدار')}} </li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center py-3">
                    <h3 class="m-0">{{l('مشخصات متقاضی')}}</h3>
                </div>
                <div class="rounded-2 bg-white flex gap-2 py-3 px-4  md:px-6 border border-gray-200">

                    <div class="row g-3 align-items-lg-start">
                        @if($model->user != null)
                        <div class="col-12 col-md-4 px-0 px-lg-3">
                            <div class="d-flex justify-content-between flex-wrap gap-2 py-3 mt-3 d-none">
                                <a href="tel:+98{{substr($model->user->username,1)}}" class="btn btn-success rounded-pill">
                                    <i class="text-[20px] text-[#8DD781]  fa-thin fa-phone"></i>
                                    <span class="text-[20px] text-[#8DD781] font-medium"> {{l('تماس با مشاور')}}</span>
                                </a>
                            </div>
                            <div class="d-flex border rounded p-2 mb-3 gap-3" >
                                <img src="{{$model->user->photo()}}" class=" img-expert-suggest" alt="">
                                <div class="">
                                    <h5 class="card-title">
                                        {{$model->user->fullname()}}
                                    </h5>
                                    <p class="card-text">


                                        @foreach($model->user->roles as $role)
                                            @if($role->id == 9)
                                            {{l(($model->user->activity_type == 1 ? l('مشاور فروش') : ($model->user->activity_type == 2 ? l('مشاور اجاره') : l('مشاور فروش و اجاره'))))}}
                                            @endif
                                        @endforeach



                                    </p>
                                    <a href="tel:+98{{substr($model->user->username,1)}}" class="btn btn-primary">{{l('تماس با مشاور')}} </a>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-12 col-md-8 border border-gray-200 rounded-2 py-3 px-2 mb-3">
                            <div class="d-flex justify-content-around flex-wrap border-bottom border-text-200 pb-2">
                                <div class="flex flex-col py-1 md:gap-2 text-gray-500 font-light  mobile-w-50 border-b md:border-b-0 border-l  border-gray-200 px-2 mb-2">
                                    <p class="mb-0 fw-bold"> {{l('حداقل مساحت')}}: </p>
                                    <p class="mb-0">
                                        <span class="font-medium">{{toPersianNumbers($model->area_min)}}</span> {{l('متر')}}
                                    </p>
                                </div>

                                @if($model->estate_type == 1)
                                <div class="flex flex-col py-1 md:gap-2 text-gray-500 font-light  mobile-w-50 border-l  border-gray-200 px-2 mb-2">
                                    <p class="mb-0 fw-bold">{{l('حداقل مبلغ')}}: </p>
                                    <p class="mb-0">
                                        <span class="font-medium">{{toPersianNumbers($model->price_min)}}</span>
                                        {{l('تومان')}}
                                    </p>
                                </div>
                                <div class="flex flex-col py-1 md:gap-2 text-gray-500 font-light  mobile-w-50  border-gray-200 px-2 mb-2">
                                    <p class="mb-0 fw-bold">{{l('حداکثر مبلغ')}}: </p>
                                    <p class="mb-0">
                                        <span class="font-medium">{{toPersianNumbers($model->price_max)}}</span>
                                        {{l('تومان')}}
                                    </p>
                                </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-around flex-wrap border-text-200 pt-2">
                                <!--  -->
                                <div class="flex flex-col py-1 md:gap-2 text-gray-500 font-light mb-2  border-b  md:border-b-0 border-l border-gray-200 px-2 mobile-w-50">
                                    <p class="mb-0 fw-bold">{{l('نوع ملک')}}:</p>
                                    <p class="font-medium mb-0">
                                        {{l(estateTypes($model->estate_type ?? ''))}}
                                    </p>
                                </div>

                                <div class="flex flex-col py-1 md:gap-2 text-gray-500 font-light mb-2   px-2 mobile-w-50">
                                    <p class="mb-0 fw-bold">{{l('نوع درخواست')}} : </p>
                                    <p class="font-medium mb-0">
                                        {{l(estateTypes($model->estate_type ?? ''))}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <p class=" flex flex-col md:flex-row gap-1 text-gray-500 font-light mb-3 md:mb-5">
                                <span class="fw-bold text-black-50">{{l('محله های درخواستی')}}:</span>

                                <div class="my-slider">
                                    @foreach($model->districts as $district)
                                    <span class=" badge bg-primary m-1 ">{{$district->name}}</span>
                                    @endforeach
                                </div>
                            </p>
                        </div>
                        @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="javascript:void(0)" class="btn btn-primary btn-update">
                                    {{ l('تقاضای حذف یا ویرایش درخواست') }}
                                </a>
                                <a href="/add" class="btn btn-primary btn-estate">
                                    {{ l('اگر ملک فروش یا اجاره دارید کلیک کنید') }}
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container mb-5 pb-md-4">
        @if(count($relationEstates))
        @php
            $date = '';
        @endphp
        @foreach( $relationEstates as $estate)

        @if($estate->send_at != $date )
        @if($date == '')
        <div class="mb-5">
            <p class="fw-bold fs-5">{{l('املاک پیشنهادی در')}} {{toPersianDate($estate->send_at,true)}}</p>
            <div class="row g-3">
        @else
            </div>
        </div>
        <div class="mb-5">
            <p class="fw-bold fs-5">{{l('املاک پیشنهادی در')}} {{toPersianDate($estate->send_at,true)}}</p>
            <div class="row g-3">
        @endif
        @endif
                <div class="col-md-4 col-lg-3">
                    <div class="card shadow-sm rounded card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="img-overlay" target="_blank" href="/v/{{ $estate->id }}?he={{$estate->uid}}"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-info mb-1">{{ toPersianDate($estate->updated_at) }}</span>
                                <span class="d-table badge bg-primary">{{estateTypes($estate->estate_type)}}</span>
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
                                <a class="nav-link stretched-link" target="_blank" href="/v/{{ $estate->id }}?he={{$estate->uid}}"> {{ $estate->title }}</a>
                            </h3>
                            <div class="d-flex justify-content-between align-content-center">
                                @if ($estate->type == 2)
                                    <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('رهن')}}:
                                        {{ toPersianNumbers($estate->{{ l('mortgage) }} ت') }}</div>
                                    <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('اجاره')}}:
                                        {{ toPersianNumbers($estate->rent) }} {{l('ت')}}</div>
                                @else
                                    @if ($estate->price > 0)
                                        <div><i class="fi-cash lead align-middle opacity-70"></i>
                                            {{ toPersianNumbers($estate->price) }} {{l('ت')}}
                                        </div>
                                        @if(env('COUNTRY') != 'UAE')
                                        <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('متری')}}:
                                            {{ toPersianNumbers($estate->price_per_meter) }} {{l('ت')}}
                                        </div>
                                        @endif
                                    @else
                                        <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('قیمت: توافقی')}}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">
                            <div>
                                @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{$estate->area}}  {{l('متر مربع')}}
                                </span>
                                @if($estate->geography != null && env('COUNTRY') != 'UAE')
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ getFeatureValue($featureValues, $estate->geography)}}
                                </span>
                                @endif
                                @if($estate->built_year != null)
                                <span class="d-inline-block px-2 fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> {{l('ساخت')}}: {{buildYear($estate->built_year)}}
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
                    </div>
                </div>
            @php
            $date = $estate->send_at;
            @endphp

            @endforeach
                </div>
            </div>
            @endif
    </section>

</main>

@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])

@endsection
@section('js')

<script>

    $(document).ready(function() {

        $(".btn-update").on('click', function() {
            deleteclick();
        });
    })

    var CSRF_TOKEN = '{{csrf_token()}}';
    function deleteclick() {
        $.ajax({
                url: '/customer/changecustomerstatus/{{$model->guid}}',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                },
                dataType: 'json'
            })
            .done(function(response) {
                swal({
                    text: l('درخواست حذف یا ویرایش تقاضای شما برای مشاور ارسال گردید. منتظر تماس مشاور باشید.'),
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => { //location.reload(); }); }) .fail(function() { swal('خطا!', 'حذف با مشکل مواجه شد!', 'error'); }); }
</script>
@endsection
