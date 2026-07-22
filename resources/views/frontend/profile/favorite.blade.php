@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME')
])

@section('main_content')
<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">

        <!-- Page content-->
        <div class="row g-2">
            @include('frontend.layouts.sidebar', ['menu' => '5'])

            <!-- Content-->
            <div class="col-lg-9 col-md-12 pt-4">
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('لیست مورد علاقه ها')}}</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2">
                    <h1 class="h2 mb-0">{{l('لیست مورد علاقه ها')}}</h1>
                </div>
                <div class="row">
                @foreach($estates as $estate)
                <!-- Item-->
                <div class="mb-4 col-12 col-md-6">
                    <div id="itemFavoriteEstate-{{$estate->id}}" class="card card-hover card-horizontal border-0 shadow-sm ">
                        <div class="card-img-top position-relative" style="background-image: url({{$estate->coverImage()}});">
                            <a class="stretched-link" href="{{ $estate->url() }}"></a>
                            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                                <span class="d-table badge bg-success mb-1">{{toPersianDate($estate->showdate)}}</span>
                            </div>
                            <div class="position-absolute end-0 top-0 pt-3 ps-3 zindex-5">
                                <button class="js_heart  btn btn-icon btn-light btn-xs text-primary rounded-circle shadow-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ l('حذف از مورد علاقه') }}" onclick="addFavoriteEstate({{$estate->id}}) " data-id="{{$estate->id}}">
                                    <i class="fi-heart-filled"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body position-relative py-3 px-2">
                        <h4 class="mb-1 fs-sm fw-normal text-uppercase text-primary">{{$estate->{{ l('type==1?l("فروش"):l("رهن و اجاره")}}') }}</h4>
                            <h3 class="h6 mb-2 fs-base">
                                <a class="nav-link stretched-link" href="{{ $estate->url() }}">{{estateTypes($estate->estate_type)}} | {{$estate->area}} {{l('مترمربع')}}</a>
                            </h3>
                            <p class="mb-2 fs-sm text-muted">{{$estate->title}}</p>
                            <div>
                                <i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>
                                @if($estate->type == 2)
                                {{l('ودیعه')}}: {{toPersianNumbers($estate->mortgage)}} {{l('تومان')}}<br>
                                {{l('اجاره ماهیانه')}}:{{toPersianNumbers($estate->rent)}} {{l('تومان')}}<br>
                                @else
                                {{toPersianNumbers($estate->price)}} {{l('تومان')}}<br>
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-center justify-content-sm-start border-top pt-3 pb-2 mt-3 text-nowrap">
                                @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                                <span class="d-inline-block fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{!empty($estate->area)?$estate->{{ l('area.l("متر"):""}}') }}
                                </span>
                                @if(ss('SITE_ID') !=4)
                                <span class="d-inline-block fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ getFeatureValue($featureValues, $estate->geography)}}
                                </span>

                                <span class="d-inline-block fs-sm">
                                    <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> ساخت: {{buildYear($estate->built_year)}}
                                </span>
                                @endif
                                @endif

                                @if($estate->estate_type == 3 || $estate->estate_type == 4)
                                <span class="d-inline-block fs-sm">
                                    <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i> {{!empty($estate->area)?$estate->{{ l('area.l("متر"):""}}') }}
                                </span>

                                @if(ss('SITE_ID') !=4)
                                <span class="d-inline-block fs-sm">
                                    <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i> {{ getFeatureValue($featureValues, $estate->geography)}}
                                </span>
                                <span class="d-inline-block fs-sm">
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
                @endforeach
                </div>
            </div>
        </div>
    </div>
</main>


@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])

@endsection
@section('js')
<link rel="stylesheet" href="/assets/vendors/swiperjs/css/swiper.css">
<style>
    .overme {
        width: 100px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>
<script src="/assets/vendors/swiperjs/js/swiper.js"></script>
<script src="/frontend/vendor/sweetalert2.all.js"></script>
<script>
    const toast = swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 2500
    });
</script>
<script>
    var swiper = new Swiper(".js_filter_search", {
        slidesPerView: "auto",
        spaceBetween: 16,
        freeMode: true,
    });
    $(".js_active_tab").click(function(e) {
        e.preventDefault()
        $(".js_active_tab").removeClass("active_fav");
        $(this).addClass("active_fav");
    });
    function active_section(section) {
        $('.js_element').addClass('hidden')
        $(`.${section}`).removeClass('hidden')
    }
    $("#js_estate_fav").click(function(e) {
        $('.js_estate_fav').show();

    })
    $('.js_detail').click(function(e) {
        $(this).addClass('ok')
        $(this).parent().next().fadeIn(500)
    })
    function addFavoriteEstate(id) {
        $.get("/estates/favorite/" + id, function(data, status) {
            if (data.result == 1) {
                toast({
                    type: 'success',
                    text: "{{l('ملک مورد نظر به لیست نشان شده های شما افزوده شد.')}}"
                });
                $(".itemFavorite-" + id).addClass("favorited");
            } else {
                toast({
                    type: 'success',
                    text: "{{l('ملک مورد نظر از لیست نشان شده های شما حذف شد.')}}"
                });
                $("#itemFavoriteEstate-" + id).hide();
            }
        });
    }
</script>
@endsection
