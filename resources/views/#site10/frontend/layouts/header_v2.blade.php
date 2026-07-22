<header class="navbar navbar-expand-lg navbar-light bg-transparent fixed-top flex-column pt-lg-0" data-scroll-header>

    <div class="container-fluid bg-secondary d-none d-lg-block">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between gap-2 py-2">
                <div class="d-flex gap-5">
                    <div class="text-dark d-flex gap-2 align-items-center fs-sm">
                        <span><i class="fi-globe"></i></span>
                        <span>EN</span>
                    </div>
                    <div class="text-dark d-flex gap-2 align-items-center fs-sm">
                        <!--span><i class="fi-books"></i></span-->
                        <a href="/blog" class="text-dark d-flex gap-2 align-items-center fs-sm text-decoration-none">
                            <span>Real Estate Magazine</span>
                        </a>
                    </div>
                </div>
                <?php
                $listArray = [];
                if (!empty($currentUser)) {
                    $listArray = json_decode(Auth::user()->role_ids);
                }
                ?>
                <div class="d-flex gap-5">
                    <a href="/favorite" class="text-dark d-flex gap-2 align-items-center fs-sm text-decoration-none">
                        <div class="text-dark d-flex gap-2 align-items-center fs-sm">
                            <span><i class="fi-heart-filled"></i></span>
                            <span>Favourite properties</span>
                        </div>
                    </a>
                    <!--div class="text-dark d-flex gap-2 align-items-center fs-sm">
                        <span><i class="fi-star"></i></span>
                        <span>Saved searches</span>
                    </div-->
                    @if(empty($currentUser))
                    <a href="/login" class="text-dark d-flex gap-2 align-items-center fs-sm text-decoration-none">
                        <span><i class="fi-user"></i></span>
                        <span>Log in</span>
                    </a>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container pt-lg-2">
        <a href="/" class="me-2">
            <img src="/img/site4/logo.png" style="height: 40px;width: 50px;">
        </a>
        <a href="/" class="navbar-brand ms-auto ms-xl-4 logo " >
            {{ss('SITE_NAME')}}
        </a>
        <!--a class="navbar-brand me-3 me-xl-4 text-white header-content d-lg-none" href="">
            <img class="d-block" src="/img/site4/logo.png" width="116" alt="Finder">
            Cars & House
        </a>
        <a class="navbar-brand me-3 me-xl-4  d-none d-lg-block " href="">
            <img class="d-block" src="/img/site4/logo.png" width="116" alt="Finder">
            Cars & House
        </a-->
        <button class="navbar-toggler ms-auto bg-faded-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="fi-align-justify header-content2" style="color: #000 !important;"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                @if(empty($currentUser))

                        <a class="btn btn-primary d-lg-none order-lg-3" href="/login">
                            <i class="fi-user me-2"></i>Login
                        </a>

                    @endif
                    <?php
                        $menu=0;
                    ?>
                    @if(!empty($currentUser) && $currentUser->isExpert())

                        <div class="" style="width:48px">
                            <img class="rounded-circle" src="{{ !empty($currentUser) ? $currentUser->photo() : '' }}" alt="{{ !empty($currentUser) ? $currentUser->fullname() : '' }}" style="height: 48px">
                        </div>
                        <div class="pt-md-2 pt-lg-0 pe-md-0 ps-lg-3">
                            <h2 class="fs-base mb-0">{{ !empty($currentUser) ? $currentUser->fullname() : '' }}</h2>
                            <span class="star-rating">
                            <?php
                                if(!empty(Auth::user())){
                                $listArray = json_decode(Auth::user()->role_ids);
                                if(ss('SITE_ID') == 3 && $IpLogin == null){
                                    $listArray = null;
                                }
                                ?>
                                @if(!empty(Auth::user()) && Auth::user()->isExpert())
                                {{l('مشاور')}}
                                @else
                                {{l('کاربر عادی')}}
                                @endif
                            <?php } ?>
                            </span>
                        </div>

                    @endif
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1">
<li class="nav-item me-2">                                                                                <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle py-0 text-gold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fi-globe me-1"></i> {{ strtoupper(session('locale', app()->getLocale())) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="/lang/en">🇬🇧 English</a></li>
                            <li><a class="dropdown-item" href="/lang/ar">🇦🇪 العربية</a></li>
                            <li><a class="dropdown-item" href="/lang/fa">🇮🇷 فارسی</a></li>
                        </ul>
                    </div></li>

                    <li class="nav-item">
                        <a class="nav-link" style="font-size:13pt" href="/add">Add Property</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pe-0"  style="font-size:13pt" href="/cities">Search</a>
                    </li>

                    @if(!empty($currentUser) && $currentUser->isExpert())
                    <li class="nav-item d-lg-none">
                        <a class="nav-link {{$menu==13?'active':''}}" href="/dashboard">
                            <i class="fi-edit opacity-60 me-2"></i>{{l('داشبورد')}}
                        </a>
                    </li>
                    @endif
                    @if(!empty($currentUser) && $currentUser->isExpert())
                    @if(env('COUNTRY') != 'UAE')
                    <li class="nav-item d-lg-none">
                        <a class="nav-link {{$menu==7?'active':''}}" href="/chats">
                            <i class="fi-messenger opacity-60 me-2 "></i>{{l('پیام')}}
                        </a>
                    </li>
                    @endif
                    @endif

                    @if(!empty($currentUser) && $currentUser->isExpert())
                        <!-- ساب منو -->
                        <li class="nav-item d-lg-none">
                        <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 border-0" data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                            <i class="fi-home opacity-60 me-2 "></i>
                            <span class="ms-1 d-sm-inline">{{l('مدیریت املاک')}}</span>
                            <i class="fi-chevron-down opacity-60  me-auto"></i>
                        </a>
                        <div class="collapse" id="collapseExample2">
                            <div class="card card-body shadow-none mb-3 px-5 py-1">
                                <ul class=" nav flex-column ms-1 ">
                                    <li class="w-100">
                                        <a class="nav-link  px-0 {{$menu==2?'active':''}}" href="/profile/my-estate-ads">
                                            <i class="fi-home opacity-60 me-2"></i>{{l('لیست املاک')}}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link  px-0" href="/add">
                                            <i class="fi-home opacity-60 me-2"></i>{{l('ثبت ملک')}}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link px-0 {{$menu==5?'active':''}}" href="/favorite"><i class="fi-heart opacity-60 me-2"></i>{{l('موردعلاقه ها')}}</a>
                                    </li>
                                    <li>
                                        <a class="nav-link px-0 {{$menu==8?'active':''}}" href="/compare"><i class="fa-solid fa-code-compare opacity-60 me-2"></i>{{l('مقایسه املاک')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif

                    @if(!empty($currentUser) && $currentUser->isExpert())
                    <li class="nav-item d-lg-none">
                        <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 border-0" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fi-building opacity-60 me-2 "></i>
                            <span class="ms-1  d-sm-inline">{{l('مدیریت مشتریان')}}</span>
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
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif



                    @if(!empty($currentUser) && $currentUser->isAdmin())
                    <li class="nav-item d-lg-none">
                        <a class="card-nav-link  px-0 align-middle rotate d-flex align-items-center gap-2 border-0" data-bs-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                            <i class="fi-building opacity-60 me-2 "></i>
                            <span class="ms-1  d-sm-inline">{{l('مدیریت سیستم')}}</span>
                            <i class="fi-chevron-down opacity-60  me-auto"></i>
                        </a>
                        <div class="collapse" id="collapseExample3">
                            <div class="card card-body shadow-none mb-3 px-5 py-1">
                                <ul class=" nav flex-column ms-1">

                                    <li class="w-100">
                                        <a href="/profile/settings" class="nav-link px-0">
                                            <i class="fa fa-gears opacity-60 me-2"></i>{{l('تنظیمات')}}
                                        </a>
                                    </li>

                                    <li class="w-100">
                                        <a class="nav-link px-0" href="/profile/users"><i class="fa fa-user  opacity-60 me-2"></i>{{l('اعضای سیستم')}}</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif

                    @if(!empty($currentUser) && $currentUser->isExpert())
                    <li class="nav-item d-lg-none">
                        <a class="nav-link {{$menu==6?'active':''}}" href="/profile/info_v2">
                            <i class="fi-edit opacity-60 me-2"></i>{{l('ویرایش مشخصات')}}
                        </a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="/admin/logout"><i class="fi-logout opacity-60 me-2"></i>{{l('خروج')}}</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        @if(!empty($currentUser))
            <div class="dropdown d-none d-lg-block order-lg-3 my-n2 ms-4">
                <a class="d-block py-2" ref="" style="width:40px">
                    <img class="rounded-circle w-100" src="{{!empty($currentUser)?$currentUser->photo():''}}" alt="{{!empty($currentUser) ? $currentUser->fullname():''}}" style="height: 40px">
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="d-flex align-items-start border-bottom px-3 py-1 mb-2"><img class="rounded-circle" src="{{!empty($currentUser)?$currentUser->photo():''}}" width="48" alt="{{!empty($currentUser) ? $currentUser->fullname():''}}">
                        <div class="pe-2 text-right d-none d-lg-block ps-lg-1">
                            <h6 class="fs-base mb-0"> {{!empty($currentUser) ? ($currentUser->isExpert()?$currentUser->fullname():$currentUser->username):''}}</h6>
                            <div class="fs-xs py-2 d-none d-lg-block">
                                @if(!empty($currentUser) && is_array($listArray) && (@in_array(9 , $listArray) || @in_array(1 , $listArray)))
                                Agent
                                @else
                                User
                                @endif

                            </div>
                        </div>
                    </div>
                    @if(!empty($currentUser) && is_array($listArray) && (@in_array(9 , $listArray) || @in_array(1 , $listArray)))
                    <a class="dropdown-item" href="/dashboard"><i class="fi-home opacity-60 me-2"></i>Dashboard</a>
                    <a class="dropdown-item" href="/profile/my-estate-ads"><i class="fi-home opacity-60 me-2"></i>Properties List</a>
                    <a class="dropdown-item" href="/customer"><i class="fi-home opacity-60 me-2"></i>Leads List</a>
                    @else
                    <a class="dropdown-item" href="/profile/my-estate-ads"><i class="fi-home opacity-60 me-2"></i>Properties List</a>
                    <a class="dropdown-item" href="/customer"><i class="fi-home opacity-60 me-2"></i>Leads List</a>
                    @endif
                    <a class="dropdown-item" href="/profile/info_v2"><i class="fi-user opacity-60 me-2"></i>Profile Update</a>
                    <a class="dropdown-item" href="/favorite"><i class="fi-heart opacity-60 me-2"></i>Favorite List</a>

                    <div class="dropdown-divider"></div><a class="dropdown-item" href="/logout"> Log Out</a>
                </div>
            </div>
        @endif
    </div>
</header>
