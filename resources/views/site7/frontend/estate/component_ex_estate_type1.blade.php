{{--
@foreach($estates as $estate)

    <!-- Item-->
    <div class="col-sm-6 col-xl-4 dfd">
        <div class="card card-hover border-1 h-100">
            <div class="tns-carousel-wrapper rounded-top card-img-hover">
                <a class="img-overlay" href="{{$estate->url()}}"></a>
                <div class="position-absolute start-0 top-0 pt-3 pe-3">
                    <span class="d-table badge bg-info">{{toPersianDate($estate->showdate)}}</span>
                </div>
                @if(\Auth::user())
                <div class="content-overlay end-0 top-0 pt-3 ps-3">
                    <button class="itemFavorite_{{$estate->id}} text-[20px]  {{count($estate->favorites)>0?'text-blue-500':'text-gray-200'}}  btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" onclick="addFavorite({{$estate->id}}) " data-id="{{$estate->id}}">
                        <i class=" fa-solid fa-bookmark"></i>
                    </button>
                </div>
                @endif
                <div>
                    <img src="{{$estate->coverImage()}}" alt="Image" class="imgestate object-cover">
                </div>
            </div>
            <div class="card-body position-relative pb-3">
                <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">
                    @if($estate->type==1) فروش @else رهن و اجاره @endif
                </h4>
                <h3 class="h6 mb-2 fs-base">
                    <a class="nav-link " href="{{$estate->url()}}">
                        @if($estate->title != '')
                            {{$estate->title}}
                        @else
                            {{estateTypes($estate->estate_type)}} | {{$estate->area}} متر مربع
                        @endif
                    </a>
                </h3>
                <p class="mb-2 fs-sm text-muted">{{$estate->city->name??""}}، {{$estate->district->name??""}}</p>
                <div class="d-flex justify-content-between align-content-center">
                    @if ($estate->type == 2)
                        <div><i class="fi-cash lead align-middle opacity-70"></i> رهن:
                            {{ toPersianNumbers($estate->{{ l('mortgage) }} ت') }}</div>
                        <div><i class="fi-cash lead align-middle opacity-70"></i> اجاره:
                            {{ toPersianNumbers($estate->{{ l('rent) }} ت') }}</div>
                    @else
                        @if ($estate->price > 0)
                            <div><i class="fi-cash lead align-middle opacity-70"></i>
                                {{ toPersianNumbers($estate->{{ l('price) }} ت') }}</div>
                            <div><i class="fi-cash lead align-middle opacity-70"></i> متری:
                                {{ toPersianNumbers($estate->{{ l('price_per_meter) }} ت') }}</div>
                        @else
                            <div><i class="fi-cash lead align-middle opacity-70"></i> {{ l('قیمت: توافقی') }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
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
        </div>
    </div>
    <!-- Item-->

@endforeach
--}}


@foreach($estates as $estate)

                <div class="col-12 col-md-6 col-xl-4 hm">
                    <!-- Static content overlay -->

                        <div class="card bg-size-cover bg-position-center border-0 overflow-hidden" style="background-image: url('{{ $estate->coverImage() }}'); max-width: 636px;height:310px;">
                        <a  class="img-gradient-overlay"></a>
                        <a href="{{ $estate->url() }}" class="img-over"></a>
                            <div class="card-body content-overlay pb-0"><span class="badge bg-info fs-sm">{{ toPersianDate($estate->showdate) }}</span>
                        </div>
                            <div class="card-footer content-overlay border-0 pt-0 pb-4">
                                <div class=" pt-5 mt-2 mt-sm-5 text-white">

                                    <div class="fs-sm text-uppercase pt-2 mb-1">{{ estateTypes($estate->estate_type) }}</div>
                                    <h3 class="h5 text-light mb-1">  {{ $estate->title }}</h3>
                                </div>
                                <div class="fs-sm opacity-70 text-white mb-2">
                                        <i class="fi-map-pin ms-1"></i>{{$estate->city->name??""}}، {{$estate->district->name??""}}
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                   @if($estate->type==1)
                                         <div class="fs-sm opacity-70 text-white">
                                            <i class="fi-cash  ms-1"></i>
                                            {{ toPersianNumbers($estate->{{ l('price) }} ت') }}
                                        </div>
                                        <div class="fs-sm opacity-70 text-white">
                                            <i class="fi-cash  ms-1"></i>
                                            {{ toPersianNumbers($estate->{{ l('price_per_meter) }} متری') }}
                                        </div>
                                    @else

                                        <div class="fs-sm opacity-70 text-white"><i class="fi-cash  ms-1">
                                            </i> {{ toPersianNumbers($estate->{{ l('mortgage) }} رهن') }}
                                        </div>
                                        <div class="fs-sm opacity-70 text-white">
                                            <i class="fi-cash  ms-1"></i>  {{ toPersianNumbers($estate->{{ l('rent) }} اجاره') }}
                                        </div>
                                     @endif
                                </div>

                                <div class="text-white opacity-70 mt-3 text-center">
                                    @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ getFeatureValue($featureValues, $estate->geography) }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> ساخت:
                                        {{ buildYear($estate->built_year) }}
                                    </span>
                                    @endif

                                    @if ($estate->estate_type == 3 || $estate->estate_type == 4)
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                        {{ getFeatureValue($featureValues, $estate->geography) }}
                                    </span>
                                    <span class="d-inline-block px-2 fs-sm">
                                        <i class="fi-real-estate-buy me-1 mt-n1 fs-lg text-muted"></i>
                                        @if ($estate->type == 1)
                                        {{ getFeatureValue($featureValues, $estate->document_type) }}
                                        @endif
                                        @if ($estate->type == 2)
                                        {{ getFeatureValue($featureValues, $estate->convertible) }}
                                        @endif
                                    </span>
                                    @endif



                                </div>
                            </div>
                        </div>
                </div>
            @endforeach

<script>
function addFavorite(id){ $.get("/estates/favorite/" + id, function (data, status) { if (data.result == 1) { /* toast({ type: 'success', text: 'ملک مورد نظر به لیست نشان شده های شما افزوده شد.' });*/ $(".itemFavorite_" + id).addClass("text-blue-500").removeClass("text-gray-200"); //$(".itemFavorite-" + id).addClass("favorited"); } else { /*toast({ type: 'error', text: 'ملک مورد نظر از لیست نشان شده های شما حذف شد.' });*/ $(".itemFavorite_" + id).removeClass("text-blue-500").addClass("text-gray-200"); //$(".itemFavorite-" + id).removeClass("favorited"); } }); }
</script>
