
<?php
    $currentUser=Auth::user();
    //dd(Auth::user());
?>
@include('frontend.layouts.modal_city')
<header class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-lg" data-scroll-header dir="rtl">
    <div class="container gap-1" style="margin-top: 0 !important;">

        <a href="/" class="me-2">
            <img src="/img/site3/logo-b.jpg" style="height: 50px;width: 50px;" alt="{{ss('SITE_NAME')}}">
        </a>
        <a href="/" class="navbar-brand ms-auto ms-xl-4 logo " >
            {{ss('SITE_NAME')}}
        </a>
        @php
        $screen = new \Jenssegers\Agent\Agent;
        @endphp
        @if (!$screen->isMobile())
        <a href="tel:0253180" class="navbar-brand ms-auto ms-xl-4 logo  pe-lg-1" style="color:orange">
            025-3180
        </a>
        @endif
        @if(empty($currentUser))
        <a class="btn btn-primary d-lg-none order-lg-3" href="/login">
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
        <a class="btn btn-primary btn-sm ms-2 order-lg-3 d-none d-lg-block" href="/add"><i class="fi-plus me-2"></i>{{ l('ثبت ملک') }}</a>
        <a class="btn btn-info btn-sm ms-2 order-lg-3 d-none d-lg-block" href="/customers/create"><i class="fi-plus me-2"></i>{{ l('ثبت تقاضا') }}</a>

        @if(empty($currentUser))
        <a class="btn btn-sm text-primary d-none d-lg-block order-lg-3" href="/login">
            <i class="fi-user me-2"></i>{{ l('ورود') }}
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
                        </div>
                    </li>
                    @endif

                    @if(!empty($currentUser) && $currentUser->isExpert())
                    <li class="nav-item d-lg-none">
                        <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 border-0" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fi-building opacity-60 me-2 "></i>
                            <span class="ms-1  d-sm-inline">{{ l('مدیریت مشتریان') }}</span>
                            <i class="fi-chevron-down opacity-60  me-auto"></i>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body shadow-none mb-3 px-5 py-1">
                                <ul class=" nav flex-column ms-1">
                                    <li class="w-100">
                                        <a class="nav-link px-0 {{$menu==3?'active':''}}" href="/customer">
                                            <i class="fi-building opacity-60 me-2"></i>{{l('لیست مشتریان')}}
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <a class="nav-link px-0 {{$menu==4?'active':''}}" href="/customers/create">
                                            <i class="fi-check opacity-60 me-2"></i>{{l('ثبت مشتری')}}
                                        </a>
                                    </li>

                                    @if(!empty($currentUser) && $currentUser->isExpert())
                                    @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2)
                                    <li class="w-100">
                                        <a href="/profile/operationCustomer"  class="nav-link px-0 {{$menu==17?'active':''}}">
                                            <i class="fa fa-home opacity-60 me-2"></i> {{ l('عملکرد مشتریان') }}
                                        </a>
                                    </li>
                                    @endif
                                    @endif
                                </ul>

                            </div>
                        </div>
                    </li>
                    @endif

                    @if(!empty($currentUser) && $currentUser->isExpert())
                    @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2)
                    <li class="nav-item d-lg-none">
                        <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 border-0" data-bs-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample4">
                            <i class="fi-building opacity-60 me-2 "></i>
                            <span class="ms-1  d-sm-inline">{{ l('مدیریت عملکرد مشاور') }}</span>
                            <i class="fi-chevron-down opacity-60  me-auto"></i>
                        </a>
                        <div class="collapse" id="collapseExample4">
                            <div class="card card-body shadow-none mb-3 px-5 py-1">
                                <ul class=" nav flex-column ms-1">
                                    <li class="w-100">
                                    <a href="/profile/relationEstateCustomer"  class="nav-link px-0 {{$menu==10?'active':''}}">
                                        <i class="fa fa-building opacity-60 me-2"></i> {{ l('مشتریان و املاک متناسب') }}
                                    </a>
                                    </li>
                                    <li class="w-100">
                                    <a href="/profile/report" class="nav-link px-0 {{$menu==11?'active':''}}">
                                        <i class="fa fa-bar-chart opacity-60 me-2"></i> {{ l('آمار مشاوران') }}
                                    </a>
                                    </li>
                                    @if(ss('SITE_ID') != 2)
                                    <li class="w-100">
                                    <a href="/task" class="nav-link px-0 {{$menu==20?'active':''}}">
                                        <i class="fa fa-city opacity-60 me-2"></i> {{ l('تقویم کاری') }}
                                    </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif
                    @endif

                    @if(!empty($currentUser) && $currentUser->isAdmin())
                    <li class="nav-item d-lg-none">
                        <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 border-0" data-bs-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                            <i class="fi-building opacity-60 me-2 "></i>
                            <span class="ms-1  d-sm-inline">{{ l('مدیریت سیستم') }}</span>
                            <i class="fi-chevron-down opacity-60  me-auto"></i>
                        </a>
                        <div class="collapse" id="collapseExample3">
                            <div class="card card-body shadow-none mb-3 px-5 py-1">
                                <ul class=" nav flex-column ms-1">
                                    <li class="w-100">
                                        <a class="nav-link px-0 {{$menu==14?'active':''}}" href="/profile/sms">
                                            <i class="fa fa-user  opacity-60 me-2"></i> {{ l('پیامکهای ارسالی و دریافتی') }}
                                        </a>
                                    </li>

                                    @if(ss('SITE_ID') == 3)
                                    <li class="w-100">
                                        <a class="nav-link px-0" href="/profile/branches">
                                            <i class="fa fa-sitemap  opacity-60 me-2"></i>
                                            {{ l('شعبه ها') }}
                                        </a>
                                    </li>
                                    @endif
                                    <li class="w-100">
                                        <a href="/profile/settings" class="nav-link px-0">
                                            <i class="fa fa-gears opacity-60 me-2"></i>{{l('تنظیمات')}}
                                        </a>
                                    </li>
                                    @if(env('COUNTRY') != 'UAE')
                                    @if(ss('SITE_ID') != 2)
                                    <li class="w-100">
                                        <a href="/profile/province" class="nav-link px-0">
                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('استان ها') }}
                                        </a>
                                    </li>
                                    @endif
                                    <li class="w-100">
                                        <a href="/profile/city" class="nav-link px-0">
                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('شهرها') }}
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <a href="/profile/district" class="nav-link px-0">
                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('محله ها') }}
                                        </a>
                                    </li>

                                    @if(ss('SITE_ID') == '3' || ss('SITE_ID') == '5')
                                    <li class="w-100">
                                        <a href="/profile/street" class="nav-link px-0">
                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('زیرمحلات') }}
                                        </a>
                                    </li>
                                    @endif
                                    @endif
                                    @if(ss('SITE_ID') == '3' || ss('SITE_ID') == '2')
                                    <li class="w-100">
                                        <a href="/profile/posts" class="nav-link px-0 {{$menu=='article'?'active':''}}">
                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('مدیریت مطالب') }}
                                        </a>
                                    </li>
                                    @endif
                                    <li class="w-100">
                                        <a class="nav-link px-0" href="/admin/users"><i class="fa fa-user  opacity-60 me-2"></i>{{ l('اعضای سیستم') }}</a>
                                    </li>
                                    @if(ss('SITE_ID') == 5 || ss('SITE_ID') == 3)
                                    <li class="w-100">
                                        <a href="/profile/contract" class="nav-link px-0">
                                            <i class="fa fa-city opacity-60 me-2"></i> {{ l('مدیریت قولنامه') }}
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif

                    @if(!empty($currentUser))
                    @if($currentUser->isExpert())
                    <li class="nav-item d-lg-none">
                        <a class="nav-link {{$menu==6?'active':''}}" href="/profile/info_v2">
                            <i class="fi-edit opacity-60 me-2"></i>{{l('ویرایش مشخصات')}}
                        </a>
                    </li>
                    @endif
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="/admin/logout"><i class="fi-logout opacity-60 me-2"></i>{{l('خروج')}}</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="collapse navbar-collapse order-lg-2" id="navbarNav2">
            <ul class="navbar-nav navbar-nav-scroll m-0" style="max-height: 35rem;">
                <li class="nav-item dropdown d-lg-none d-flex align-items-center my-2 gap-2 py-1">
                    @if(!empty($currentUser))
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
                            مشاور
                            @else
                            {{l('کاربر عادی')}}
                            @endif
                        <?php } ?>
                        </span>
                    </div>
                    @endif
                </li>

                <li class="nav-item d-lg-none"><a class="nav-link" href="/add"><i class="fi-plus me-2"></i>{{ l('ثبت رایگان ملک') }}</a></li>
                <li class="nav-item py-2 me-lg-2 d-lg-none">
                    <a class="nav-link align-items-center border-end-lg py-1 pe-lg-4" href="/cities" aria-expanded="false">
                        <i class="fi-search me-2"></i>
                        {{ l('ﺟﺴﺘﺠﻮی ملک') }}
                    </a>
                </li>
                <li class="nav-item py-2 me-lg-2 d-lg-none">
                    <a class="nav-link align-items-center border-end-lg py-1 pe-lg-4" href="" aria-expanded="false">
                        <i class="fi-globe me-2"></i>
                         {{ l('مجله حقوقی') }}
                    </a>
                </li>
                <!--li class="nav-item py-2 me-lg-2 d-lg-none">
                    <a class="nav-link align-items-center border-end-lg py-1 pe-lg-4" href="" aria-expanded="false">
                        <i class="fi-globe me-2"></i>
                         {{ l('مجله املاک') }}
                    </a>
                </li-->
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
                        <a class="dropdown-item d-flex align-items-center gap-2" href="/profile/my-estate-ads">
                            <i class="fi-home opacity-60 me-2"></i>
                            {{ l('لیست املاک') }}
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
