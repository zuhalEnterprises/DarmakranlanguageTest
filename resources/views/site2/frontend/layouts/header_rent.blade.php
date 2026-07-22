<style>
    .nav-item .select2-selection.select2-selection--single {
        border: 1px solid transparent !important;
    }
    .nav-item .select2-selection__arrow {
        display: none
    }
    .logo-name {
        font-size: 14px;
    }
    @media (min-width:768px) {
        .logo-name
        {
            font-size: 24px;
        }
    }
    @media (max-width:768px) {
        .container {padding-top: 2px !important;margin-top:1rem !important}
        .fixed-top{position: unset}
    }
</style>
<?php
    $currentUser=Auth::user();
    //dd(Auth::user());
?>
@include('frontend.layouts.modal_city')
<header class="navbar navbar-expand-lg navbar-light  fixed-top bg-white" data-scroll-header>
    <div class="container gap-1" style="margin-top: 0 !important;">
        <div class="d-flex flex-column flex-lg-row align-items-center">
            <a href="/" class="navbar-brand m-0 ms-xl-4 logo" style="color:#3a4936">
                <img src="/img/site2/logo.png" style="height: 50px" alt="{{ss('SITE_NAME')}}">
            </a>
            <a href="/" class="navbar-brand m-0 ms-xl-4 logo logo-name" style="color:#3a4936">
                {{ l('گیلند ملک') }}
            </a>
        </div>

        <a class="btn fw-bold btn-sm ms-2 d-none d-lg-block" href="/rental">
            {{ l('اجاره روزانه و کوتاه مدت') }}
        </a>
        <a class="btn fw-bold btn-sm ms-2 d-none d-lg-block" href="/rental/search">
            {{ l('جستجو در اقامتگاه‌ها') }}
        </a>
        <a class="btn fw-bold btn-sm ms-2 d-none d-lg-block" href="/rental/host">
            {{ l('میزبان شوید') }}
        </a>
        <a class="btn fw-bold btn-sm ms-2 d-none d-lg-block" href="/rental/rules">
            {{ l('قوانین و مقررات') }}
        </a>

        <a class="btn fw-bold btn-secondary btn-sm ms-2 d-none d-lg-block" href="tel:09129406124">
            {{ l('پشتیبانی 24 ساعته') }}
        </a>
        @if(empty($currentUser))
        <a class="btn btn-primary  d-lg-none order-lg-3 me-auto" href="/login">
            <i class="fi-user me-2"></i>{{ l('ورود') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @else
        <button class="navbar-toggler  " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <img class="rounded-circle" src="{{!empty($currentUser)?$currentUser->photo():''}}" width="40" alt="{{!empty($currentUser)?$currentUser->fullname():''}}">
        </button>
        @endif
        <?php
        $listArray = [];
        if (!empty($currentUser)) {
            $listArray = json_decode(Auth::user()->role_ids);
        }
        ?>
        @if(empty($currentUser))
        <a class="btn btn-sm btn-secondary fw-bold d-none d-lg-block order-lg-3" href="/login">
            <i class="fi-user me-2 fw-bold"></i>{{ l('ورود') }}
        </a>
        @else
                            <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle py-0 text-gold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fi-globe me-1"></i> {{ strtoupper(session('locale', app()->getLocale())) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="/lang/en">🇬🇧 English</a></li>
                            <li><a class="dropdown-item" href="/lang/ar">🇦🇪 العربية</a></li>
                            <li><a class="dropdown-item" href="/lang/fa">🇮🇷 فارسی</a></li>
                        </ul>
                    </div>
        @endif
        </div>
        <div class="collapse navbar-collapse order-lg-2" id="navbarNav2">
            <ul class="navbar-nav navbar-nav-scroll m-0" style="max-height: 35rem;">
                <li class="nav-item dropdown d-lg-none d-flex align-items-center my-2 gap-2 py-1">
                    <div class="" style="width:48px">
                        <img class="rounded-circle" src="{{ !empty($currentUser) ? $currentUser->photo() : '' }}" alt="{{ !empty($currentUser) ? $currentUser->fullname() : '' }}" style="height: 48px">
                    </div>
                    <div class="pt-md-2 pt-lg-0 pe-md-0 ps-lg-3">
                        <h2 class="fs-lg mb-0">{{ !empty($currentUser) ? $currentUser->fullname() : '' }}</h2>
                        <span class="star-rating">
                         <?php
                            if(!empty(Auth::user())){
                            $listArray = json_decode(Auth::user()->role_ids);
                            if(ss('SITE_ID') == 3 && $IpLogin == null){
                                $listArray = null;
                            }
                            ?>
                            @if(!empty(Auth::user()) && Auth::user()->isExpert())
                            {{l('کارشناس')}}
                            @else
                            {{l('کاربر عادی')}}
                            @endif
                        <?php } ?>
                        </span>
                    </div>
                </li>
                <li class="nav-item d-lg-none"><a class="nav-link" href="/customers/create"><i class="fi-plus me-2"></i>{{ l('ثبت خریدار') }}</a></li>
                <li class="nav-item d-lg-none"><a class="nav-link" href="/add"><i class="fi-plus me-2"></i>{{ l('ثبت رایگان ملک') }}</a></li>
                <li class="nav-item py-2 me-lg-2 d-lg-none"><a class="nav-link align-items-center border-end-lg py-1 pe-lg-4" href="/cities" aria-expanded="false">
                <i class="fi-search me-2"></i>
                {{ l('ﺟﺴﺘﺠﻮی ملک') }}
                </a></li>
                <li class="nav-item dropdown d-lg-none px-0">
                    <a class="dropdown-item d-flex align-items-center gap-2" href="/dashboard">
                        <i class="fi-home opacity-60 me-2"></i>
                            {{ l('داشبورد من') }}
                        </a>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="/profile/my-estate-ads">
                            <i class="fi-home opacity-60 me-2"></i>
                            {{ l('لیست املاک') }}
                        </a>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="/customer">
                            <i class="fi-home opacity-60 me-2"></i>
                            {{ l('لیست مشتریان') }}
                        </a>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="/profile/info_v2">
                            <i class="fi-user opacity-60 me-2"></i>
                            {{ l('ویرایش مشخصات') }}
                        </a>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="/favorite">
                            <i class="fi-heart opacity-60 me-2"></i>
                            {{ l('موردعلاقه ها') }}
                        </a>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="/logout">
                            <i class="fi-logout opacity-60 me-2"></i>
                            {{ l('خروج') }}
                        </a>
                </li>
            </ul>
        </div>
    </header>
<script>
    var str = "";
    $(document).ready(function(){
    })
        // get province and cities
        var city_data = <?php echo json_encode($cityData) ?>;
        $(document).ready(function() {
            $('.select_city').on('click',function(){
                // var hhhh = $(this).val();
                // console.log(hhhh);
                alert('ttt')
            })
            $("#cityListSearch").on("keyup", function() {
                var searchValue = $(this).val();
                $("#province1 .item-name").filter(function() {
                    // $(this).parent().toggle($(this).text().indexOf(value) > -1);
                    if (!($(this).text().indexOf(searchValue) > -1)) {
                        $(this).parent().attr('style', 'display :none !important');
                    } else {
                        $(this).parent().removeAttr('style');
                    }
                });
            });
            $(document).on("click", ".province1", function() {
                var data = $.parseJSON(city_data); //$.parseJSON($("#cityData").val()) ;
                for (var i = 0; i < data.length; i++) {
                    if (data[i].id == $(this).attr('value')) {
                        $("#returnpr").addClass('d-block').removeClass('d-none');
                        str = '';
                        var province = data[i];
                        for (var j = 0; j < province.cities.length; j++) {
                            //str += '<div id="' + province.cities[j].id + '" data-city="' + province.cities[j].name_en + '" class="border-bottom d-flex justify-content-around py-3 province1 city-item"><span class="item-name" style="width:90%;display:inline;cursor:pointer">' + province.cities[j].name + '</span></div>';
                            //old str += '<div class="form-check select_city" id="' + province.cities[j].id + '" data-city="' + province.cities[j].name_en + '" style="border-bottom: 1px solid #f9f2f2;padding: 8px 2rem;"><input class="form-check-input" type="checkbox" value="" id="' + province.cities[j].name_en + '"><label class="form-check-label" for="' + province.cities[j].name_en + '">' + province.cities[j].name + '</label></div>';
                        }
                    }
                }
                $("#province1").html(str)
            });
            $("#returnpr").click(function() {
                $("#returnpr").addClass('d-none').removeClass('d-block');
                showprovince()
            });
        });
        showprovince();
        function showprovince() {
            var str = "";
            var data = $.parseJSON(city_data); //$.parseJSON($("#cityData").val()) ;
            console.log(data);
            for (var i = 0; i < data.length; i++) {
                str += '<div onclick=setProvince("' + data[i].name_en + '") value="' + data[i].id + '" class="border-bottom d-flex justify-content-around py-3 province11"><span  class="item-name" style="width:80%;display:inline;cursor:pointer"><a href="/c/'+data[i].name_en+'">' + data[i].name + '</a></span><i class="far fa-chevron-left" aria-hidden="true" style="display:inline"></i></div>'
            }
            $("#province1").html(str);
        }
</script>
