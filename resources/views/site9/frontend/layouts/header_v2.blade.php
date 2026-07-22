<header class="navbar navbar-expand-lg navbar-light bg-white fixed-top flex-column pt-lg-0" data-scroll-header>

    <div class="container-fluid bg-secondary d-none d-lg-block">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between gap-2 py-2">
                <div class="d-flex gap-5">
                    <div class="text-dark d-flex gap-2 align-items-center fs-sm">
                        <span><i class="fi-globe"></i></span>
                        <span>Language: English</span>
                    </div>
                    <div class="text-dark d-flex gap-2 align-items-center fs-sm">
                        <a href="/blog" class="text-dark d-flex gap-2 align-items-center fs-sm text-decoration-none">
                            <span>{{ l('مجله املاک') }}</span>
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
                            <span>{{ l('ملک‌های مورد علاقه') }}</span>
                        </div>
                    </a>
                    @if(empty($currentUser))
                    <a href="/login" class="text-dark d-flex gap-2 align-items-center fs-sm text-decoration-none">
                        <span><i class="fi-user"></i></span>
                        <span>{{ l('ورود') }}</span>
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
        <a href="/" class="navbar-brand ms-auto ms-xl-4 logo">
            {{ss('SITE_NAME')}}
        </a>
        <button class="navbar-toggler ms-auto bg-faded-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="{{ l('نمایش منو') }}">
            <span class="fi-align-justify header-content2" style="color: #000 !important;"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                @if(empty($currentUser))
                <a class="btn btn-primary d-lg-none order-lg-3" href="/login">
                    <i class="fi-user me-2"></i>{{ l('ورود') }}
                </a>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="{{ l('بستن') }}"></button>
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
                        <a class="nav-link" style="font-size:13pt" href="/add">{{ l('افزودن ملک') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pe-0" style="font-size:13pt" href="/cities">{{ l('جستجو') }}</a>
                    </li>
                    @if(!empty($currentUser) && $currentUser->isExpert())
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="/dashboard">
                            <i class="fi-edit opacity-60 me-2"></i>{{ l('داشبورد') }}
                        </a>
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
                <a class="dropdown-item" href="/dashboard"><i class="fi-home opacity-60 me-2"></i>{{ l('داشبورد') }}</a>
                <a class="dropdown-item" href="/profile/my-estate-ads"><i class="fi-home opacity-60 me-2"></i>{{ l('لیست املاک') }}</a>
                <a class="dropdown-item" href="/profile/info_v2"><i class="fi-user opacity-60 me-2"></i>{{ l('ویرایش مشخصات') }}</a>
                <a class="dropdown-item" href="/favorite"><i class="fi-heart opacity-60 me-2"></i>{{ l('ملک‌های مورد علاقه') }}</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/logout">{{ l('خروج') }}</a>
            </div>
        </div>
        @endif
    </div>
</header>
