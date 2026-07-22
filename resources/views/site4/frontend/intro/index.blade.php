@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])

@section('main_content')
<style>
    .box-hero {
        height: 370px;
        -webkit-transition: background-image .3s ease-in-out;
        transition: background-image .3s ease-in-out;
        width: 100%;
        position: relative;
    }

    .width-hero {
        width: 100% !important;

    }

    .box-pic-hero {
        position: absolute;
        z-index: -2;
        overflow: hidden;
        height: 100%;
        width: 100%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }

    .pic-hero {
        height: 350px;
        -o-object-fit: cover;
        object-fit: cover;
        max-width: 100%;
        border-radius: 0;
    }

    .card-intro {
        border-radius: 1rem;
        border: none;
        cursor: pointer;
        position: relative;
        background-size: cover;
        background-position-x: 100%;
        height: 335px;
        display: block;
        border: 1px solid black
    }
    .card-intro {
        color:#000
    }
    @media (min-width: 768px) {
        .width-hero {
            width: calc(100% - 3.2rem) !important;
            margin: 0 1.6rem;
        }

        .box-hero {
            height: 700px;
            -webkit-transition: background-image .3s ease-in-out;
            transition: background-image .3s ease-in-out;
            width: 100%;
            position: relative;
        }

        .pic-hero {
            min-height: 36.9rem;
            max-height: 59.9rem;
            -o-object-fit: cover;
            object-fit: cover;
            max-width: 100%;
            border-radius: 1rem;
        }
    }

    .back_card_state {
        position: relative;
        padding-top: 35px;
        padding-bottom: 35px;
        background-color: rgb(54, 131, 191);
        background-image: linear-gradient(rgba(54, 131, 191, 0.75), rgb(54, 131, 191)), url('/img/site4/back-home.webp');
        background-size: 150px;

    }
</style>
<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')
    <section class="box-hero  mb-lg-0 mt-lg-5">

        <div class="box-pic-hero width-hero mt-lg-5">
            <picture class="">
                <source media="(min-width: 1200px)" srcset="/img/site4/banner.jpg" />
                <source media="(min-width: 800px) and (max-width: 1200px)" srcset="/img/site4/banner1200.jpg" />
                <source media="(min-width: 400px) and (max-width: 800px)" srcset="/img/site4/banner800.jpg" />
                <source media="(max-width: 400px)" srcset="/img/site4/banner400.jpg" />
                <img class="pic-hero" src="/img/site4/banner1200.jpg" alt="wallpaper">
            </picture>

        </div>
        <div class="container mt-lg-5" aria-label="Home Title">
            <div class=" pt-5 text-center d-lg-none">
                <!--h1 class="text-white mt-5 mb-0 bg-opacity-50 bg-dark mb-1">Real homes live here</h1-->
            </div>
            <div class=" pt-5 text-center d-none d-lg-block">
                <h1 class="text-white mt-5 mb-0 ">
                 <span class=" px-4">   Real homes live here</span>
                </h1>
                <h2 class="text-white  ">
                   <span class=" px-4 py-2 fs-5"> Real Prices. Real Photos. Real Properties </span>
                </h2>
            </div>
        </div>
        <div class="container mt-lg-5 mt-4 mb-lg-0">
            <form class="form-group d-lg-block m-auto p-3 border-0" style="max-width: 756px;background: rgba(34,34,34,.85);"  method="get" action="/c/{{ $selectedCity }}">
                <div class="row g-2">
                    <div class="col-6 col-lg-6 rounded-2 ">
                        <select id="district_id" name="district_id" class="form-control select2" cus-valid="true">
                            <option value="">Location</option>
                            @foreach ($districts as $district2)
                            <option value="{{ $district2->id }}">
                                {{ $district2->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-3 rounded-2 ">
                        <select name="type" class="form-select select2 btn btn-lg btn-light-primary dropdown-toggle">
                            <option value="1">Sale</option>
                            <option value="2">Rent</option>
                            <option value="3">Off Plan</option>
                        </select>
                    </div>
                    <div class="dropdown order-first order-lg-0 col-6 col-lg-3 rounded-2" data-bs-toggle="select">
                        <select class="form-select select2 btn btn-lg btn-light-primary dropdown-toggle  w-100" id="estate_type" name="estate_type">
                            <option value="" >{{l('نوع ملک')}}</option>
                            <optgroup label="Residential" id="g107">
                                @foreach (estateTypesResidential() as $key=>$val)
                                <option value="{{$key}}" {{!empty($model)?($model->estate_type==$key ? 'selected':''):""}} attr="107">{{$val}}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Commercial" id="g109">
                                @foreach (estateTypesCommercial() as $key=>$val)
                                <option value="{{$key}}" {{!empty($model)?($model->estate_type==$key ? 'selected':''):""}} attr="109">{{$val}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>



                    <div class="dropdown col-6 col-lg-3 rounded-2" data-bs-toggle="select">
                        <button class="btn btn-lg btn-light-primary text-bg-light dropdown-toggle  w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-money me-2"></i><span class="dropdown-toggle-label">Price Since</span></button>
                        <input type="hidden" name="pricefrom">
                        <ul class="dropdown-menu" style="">
                            <li><a class="dropdown-item" href="0"><span class="dropdown-item-label">0 AED</span></a></li>
                            <li><a class="dropdown-item" href="100000"><span class="dropdown-item-label">100,000 AED</span></a></li>
                            <li><a class="dropdown-item" href="200000"><span class="dropdown-item-label">200,000 AED</span></a></li>
                            <li><a class="dropdown-item" href="300000"><span class="dropdown-item-label">300,000 AED</span></a></li>
                        </ul>
                    </div>
                    <div class="dropdown col-6 col-lg-3 rounded-2" data-bs-toggle="select">
                        <button class="btn btn-lg btn-light-primary text-bg-light dropdown-toggle  w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-money me-2"></i><span class="dropdown-toggle-label">Price To</span></button>
                        <input type="hidden" name="priceto">
                        <ul class="dropdown-menu" style="">
                            <li><a class="dropdown-item" href="0"><span class="dropdown-item-label">0 AED</span></a></li>
                            <li><a class="dropdown-item" href="100000"><span class="dropdown-item-label">100,000 AED</span></a></li>
                            <li><a class="dropdown-item" href="200000"><span class="dropdown-item-label">200,000 AED</span></a></li>
                            <li><a class="dropdown-item" href="300000"><span class="dropdown-item-label">300,000 AED</span></a></li>
                        </ul>
                    </div>
                    <div class="dropdown col-6 col-lg-3 rounded-2" data-bs-toggle="select">
                        <button class="btn btn-lg btn-light-primary text-bg-light dropdown-toggle  w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-money me-2"></i><span class="dropdown-toggle-label">{{l('حداقل اتاق')}}</span></button>
                        <input type="hidden" name="room_count">
                        <ul class="dropdown-menu" style="">
                            <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">Stdio</span></a></li>
                            <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">1</span></a></li>
                            <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">2</span></a></li>
                            <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">3</span></a></li>
                            <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">4</span></a></li>
                            <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">5</span></a></li>
                        </ul>
                    </div>
                    <div class=" col-12 col-lg-3">
                        <button class="btn btn-lg btn-primary px-3 w-100" type="submit">Find</button>
                    </div>

                    <div class=" col-12 d-none">
                        <button class="btn btn-lg btn-light-primary px-3 w-100 text-white" type="submit" style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(34,150,93,1) 0%, rgba(0,212,255,1) 100%);">Find</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="mb-5 container">
        <div class="">
            <div  class="align-items-center">
                <p class="fs-3 fw-bold" style="text-align:center">
                    We have the most listings and constant updates.
                </p>
                <p class="fs-3 fw-bold" style="text-align:center">
                    So you’ll never miss out.
                </p>
            </div>
            <div class="row g-4 mt-1">

                <div class="col-12 col-md-6 col-lg-4">
                    <div class=" px-4 py-2 border rounded">
                        <div class="justify-content-center">
                            <img src='/img/site4/Buy_a_home.png' class="w-100" alt="">
                        </div>
                        <p class="fs-4 fw-bold mt-3" style="text-align:center">Browse Homes</p>
                        <p class="fs-6 px-3">Find your place with an immersive photo experience and the most listings, including things you won’t find anywhere else.</p>
                        <div class="justify-content-center d-flex my-3">
                            <a href="/c/{{ $selectedCity }}?type=1" class="btn btn-secondary fw-bold">Browse Homes</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class=" px-4 py-2 border rounded">
                        <div class="justify-content-center">
                            <img src='/img/site4/Rent_a_home.png' class="w-100" alt="">
                        </div>
                        <p class="fs-4 fw-bold mt-3" style="text-align:center">Rent a Home</p>
                        <p class="fs-6 px-3">We’re creating a seamless online experience – from shopping on the largest rental network, to applying, to paying rent.</p>
                        <div class="justify-content-center d-flex my-3">
                            <a href="/c/{{ $selectedCity }}?type=2" class="btn btn-secondary fw-bold">Fint Rental</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class=" px-4 py-2 border rounded">
                        <div class="justify-content-center">
                            <img src='/img/site4/Sell_a_home.png' class="w-100" alt="">
                        </div>
                        <p class="fs-4 fw-bold mt-3" style="text-align:center">Sell a Home</p>
                        <p class="fs-6 px-3">No matter what path you take to sell your home, we can help you navigate a successful sale.<br><br></p>
                        <div class="justify-content-center d-flex my-3">
                            <a href="/add" class="btn btn-secondary fw-bold">Sell a Home</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <style>
            .card-intro-main {
                object-fit: cover;
                height: 100px;
                width: 100%;
            }
        </style>

    </section>
    @if(isset($estates) && count($estates)>0)
    <!-- Top offers -->
    <section class="container mb-5 pb-md-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0">Top offers</h2><a class="btn btn-link fw-normal p-0" href="/cities">View all<i class="fi-arrow-long-right ms-2"></i></a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                @foreach ($estates as $estate)
                    <!-- Item-->
                    <div class="col">
                        <div class="card shadow-sm card-hover border-0 h-100">
                            <div class="card-img-top card-img-hover">
                                <a class="img-overlay" href="{{ $estate->url() }}"></a>
                                <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                    <span class="d-table badge bg-info">{{toPersianDate($estate->showdate)}}</span>
                                </div>
                                @if(\Auth::user())
                                <div class="content-overlay end-0 top-0 p-3 ps-3">
                                    <button class="itemFavorite_{{$estate->id}} text-[20px]  {{count($estate->favorites)>0?'text-blue-500':'text-gray-200'}}  btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" onclick="addFavorite({{$estate->id}}) " data-id="{{$estate->id}}">
                                        <i class=" fa-solid fa-bookmark"></i>
                                    </button>
                                </div>
                                @endif
                                <img src="{{$estate->coverImage()}}" alt="{{$estate->title}}">
                            </div>
                            <div class="card-body position-relative pb-3">
                                <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For sale</h4>
                                <h3 class="h6 mb-2 fs-base">
                                    <a class="nav-link stretched-link" href="{{ $estate->url() }}">{{estateTypes($estate->estate_type)}} | {{$estate->area}} {{l('متر مربع')}}</a>
                                </h3>
                                <p class="mb-2 fs-sm text-muted">
                                    {{ $estate->city->name ?? '' }}
                                    {{ $estate->district && $estate->district->name ? " ".$estate->district->name:"" }}
                                </p>
                                <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>{{ toPersianNumbers($estate->price) }} {{l('ت')}}</div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap">
                                <span class="d-inline-block mx-1 px-2 fs-sm">
                                    {{ (int)getFeatureValue($featureValues, $estate->room_count) == 0 ? l(getFeatureValue($featureValues, $estate->room_count)) : getFeatureValue($featureValues, $estate->room_count)}}<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i>
                                </span>
                                @if($estate->bed_count>0)
                                <span class="d-inline-block mx-1 px-2 fs-sm">{{$estate->bed_count}}<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
    </section>
    @endif
    <!-- Amazing Properties -->
    <section class="container mb-5 pb-md-4 d-none">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0">Amazing Properties</h2><a class="btn btn-link fw-normal p-0" href="/cities">View all<i class="fi-arrow-long-right ms-2"></i></a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                <!-- Item-->
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover"><a class="img-overlay" href="real-estate-single-v1.html"></a>
                            <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-success mb-1">Verified</span><span class="d-table badge bg-info">New</span></div>
                            <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                            </div><img src="/img/site2/catalog/01.jpg" alt="Image">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For rent</h4>
                            <h3 class="h6 mb-2 fs-base"><a class="nav-link stretched-link" href="real-estate-single-v1.html">3-bed Apartment | 67 sq.m</a></h3>
                            <p class="mb-2 fs-sm text-muted">3811 Ditmars Blvd Astoria, NY 11105</p>
                            <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>$1,629</div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap"><span class="d-inline-block mx-1 px-2 fs-sm">3<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i></span></div>
                    </div>
                </div>
                <!-- Item-->
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover"><a class="img-overlay" href="real-estate-single-v1.html"></a>
                            <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-success mb-1">Verified</span><span class="d-table badge bg-danger">Featured</span></div>
                            <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                            </div><img src="/img/site2/catalog/02.jpg" alt="Image">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For sale</h4>
                            <h3 class="h6 mb-2 fs-base"><a class="nav-link stretched-link" href="real-estate-single-v1.html">Family Home| 120 sq.m</a></h3>
                            <p class="mb-2 fs-sm text-muted">67-04 Myrtle Ave Glendale, NY 11385</p>
                            <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>$84,000</div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap"><span class="d-inline-block mx-1 px-2 fs-sm">4<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i></span></div>
                    </div>
                </div>
                <!-- Item-->
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover"><a class="img-overlay" href="real-estate-single-v1.html"></a>
                            <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-success">Verified</span></div>
                            <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                            </div><img src="/img/site2/catalog/03.jpg" alt="Image">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For rent</h4>
                            <h3 class="h6 mb-2 fs-base"><a class="nav-link stretched-link" href="real-estate-single-v1.html">Greenpoint Rentals | 85 sq.m</a></h3>
                            <p class="mb-2 fs-sm text-muted">1510 Castle Hill Ave Bronx, NY 10462</p>
                            <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>$1,330</div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap"><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i></span></div>
                    </div>
                </div>
                <!-- Item-->
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover"><a class="img-overlay" href="real-estate-single-v1.html"></a>
                            <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-success mb-1">Verified</span><span class="d-table badge bg-info">New</span></div>
                            <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                            </div><img src="/img/site2/catalog/04.jpg" alt="Image">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For sale</h4>
                            <h3 class="h6 mb-2 fs-base"><a class="nav-link stretched-link" href="real-estate-single-v1.html">Studio | 32 sq.m</a></h3>
                            <p class="mb-2 fs-sm text-muted">140-60 Beech Ave Flushing, NY 11355</p>
                            <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>$65,000</div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap"><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i></span></div>
                    </div>
                </div>
                <!-- Item-->
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover"><a class="img-overlay" href="real-estate-single-v1.html"></a>
                            <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-success mb-1">Verified</span></div>
                            <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                            </div><img src="/img/site2/catalog/05.jpg" alt="Image">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For sale</h4>
                            <h3 class="h6 mb-2 fs-base"><a class="nav-link stretched-link" href="real-estate-single-v1.html">Cottage | 120 sq.m</a></h3>
                            <p class="mb-2 fs-sm text-muted">42 Broadway New York, NY 10004</p>
                            <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>$184,000</div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap"><span class="d-inline-block mx-1 px-2 fs-sm">4<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if(isset($estateurgent) && count($estateurgent)>0)
    <!-- Properties Immediate sale -->
    <section class=" mb-5 pb-md-4 back_card_state">
        <div class="container py-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h3 mb-0 text-white">Properties Immediate sale</h2><a class="btn btn-link fw-normal p-0 text-white" href="/cities">View all<i class="fi-arrow-long-right ms-2 text-white"></i></a>
            </div>
            <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
                <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                    @foreach ($estateurgent as $estate)
                    <!-- Item-->
                    <div class="col">
                        <div class="card shadow-sm card-hover border-0 h-100">
                            <div class="card-img-top card-img-hover">
                                <a class="img-overlay" href="{{ $estate->url() }}"></a>
                                <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                    <span class="d-table badge bg-info">{{toPersianDate($estate->showdate)}}</span>
                                </div>
                                @if(\Auth::user())
                                <div class="content-overlay end-0 top-0 p-3 ps-3">
                                    <button class="itemFavorite_{{$estate->id}} text-[20px]  {{count($estate->favorites)>0?'text-blue-500':'text-gray-200'}}  btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" onclick="addFavorite({{$estate->id}}) " data-id="{{$estate->id}}">
                                        <i class=" fa-solid fa-bookmark"></i>
                                    </button>
                                </div>
                                @endif
                                <img src="{{$estate->coverImage()}}" alt="{{$estate->title}}">
                            </div>
                            <div class="card-body position-relative pb-3">
                                <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For sale</h4>
                                <h3 class="h6 mb-2 fs-base">
                                    <a class="nav-link stretched-link" href="{{ $estate->url() }}">{{estateTypes($estate->estate_type)}} | {{$estate->area}} {{l('متر مربع')}}</a>
                                </h3>
                                <p class="mb-2 fs-sm text-muted">
                                    {{ $estate->city->name ?? '' }}
                                    {{ $estate->district && $estate->district->name ? " ".$estate->district->name:"" }}
                                </p>
                                <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>{{ toPersianNumbers($estate->price) }} {{l('ت')}}</div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap">
                                <span class="d-inline-block mx-1 px-2 fs-sm">
                                    {{ (int)getFeatureValue($featureValues, $estate->room_count) == 0 ? l(getFeatureValue($featureValues, $estate->room_count)) : getFeatureValue($featureValues, $estate->room_count)}}<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i>
                                </span>
                                @if($estate->bed_count>0)
                                <span class="d-inline-block mx-1 px-2 fs-sm">{{$estate->bed_count}}<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
    @if(isset($estatesr) && count($estatesr)>0)
    <!-- The newest properties for rental -->
    <section class="container mb-5 pb-md-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0">The newest properties for rental</h2><a class="btn btn-link fw-normal p-0" href="/c/{{ $selectedCity }}?type=2">View all<i class="fi-arrow-long-right ms-2"></i></a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                @foreach ($estatesr as $estate)
                <!-- Item-->
                <div class="col">
                    <div class="card shadow-sm card-hover border-0 h-100">
                        <div class="card-img-top card-img-hover">
                            <a class="img-overlay" href="{{ $estate->url() }}"></a>
                            <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                <span class="d-table badge bg-info">{{toPersianDate($estate->showdate)}}</span>
                            </div>
                            @if(\Auth::user())
                            <div class="content-overlay end-0 top-0 p-3 ps-3">
                                <button class="itemFavorite_{{$estate->id}} text-[20px]  {{count($estate->favorites)>0?'text-blue-500':'text-gray-200'}}  btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" onclick="addFavorite({{$estate->id}}) " data-id="{{$estate->id}}">
                                    <i class=" fa-solid fa-bookmark"></i>
                                </button>
                            </div>
                            @endif
                            <img src="{{$estate->coverImage()}}" alt="{{$estate->title}}">
                        </div>
                        <div class="card-body position-relative pb-3">
                            <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For rent</h4>
                            <h3 class="h6 mb-2 fs-base">
                                <a class="nav-link stretched-link" href="{{ $estate->url() }}">{{estateTypes($estate->estate_type)}} | {{$estate->area}} {{l('متر مربع')}}</a>
                            </h3>
                            <p class="mb-2 fs-sm text-muted">
                                {{ $estate->city->name ?? '' }}
                                {{ $estate->district && $estate->district->name ? " ".$estate->district->name:"" }}
                            </p>
                            <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>{{ toPersianNumbers($estate->rent) }} {{l('ت')}}
                                @php
                                switch($estate->rentfrequency)
                                {
                                    case "1": $rentfrequency = ' /Daily'; break;
                                    case "7": $rentfrequency = ' /Weekly'; break;
                                    case "30": $rentfrequency = ' /Montly'; break;
                                    case "365": $rentfrequency = ' /Yearly'; break;
                                    default: $rentfrequency = '';
                                }
                                echo $rentfrequency;
                                @endphp
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap">
                            <span class="d-inline-block mx-1 px-2 fs-sm">
                                {{ (int)getFeatureValue($featureValues, $estate->room_count) == 0 ? l(getFeatureValue($featureValues, $estate->room_count)) : getFeatureValue($featureValues, $estate->room_count)}}<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i>
                            </span>
                            @if($estate->bed_count>0)
                            <span class="d-inline-block mx-1 px-2 fs-sm">{{$estate->bed_count}}<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    @endif
    @if(isset($areas))
    <!-- Popular Areas -->
    <section class="container mb-5 pb-2">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0">Popular Areas</h2>
            <a class="btn btn-link fw-normal ms-md-3 pb-0 d-none" href="/cities">View all<i class="fi-arrow-long-right ms-2"></i></a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
            <div class="tns-carousel-inner row gx-4 mx-0 py-md-4 py-3" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                @foreach ($areas as $key=>$area)
                <!-- Item-->
                <div class="col">
                    <a class="card shadow-sm card-hover border-0" href="{{$area['url']}}">
                        <div class="card-img-top card-img-hover">
                            <span class="img-overlay opacity-65"></span>
                            <img src="/img/site4/area/{{$key}}.webp" alt="{{$area['name']}}">
                            <div class="content-overlay start-0 top-0 d-flex align-items-center justify-content-center w-100 h-100 p-3">
                                <div class="w-100 p-1">
                                    <div class="mb-2">
                                        <h4 class="mb-2 fs-xs fw-normal text-light">
                                            <i class="fi-wallet mt-n1 me-2 fs-sm align-middle"></i>Property for buy
                                        </h4>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-light w-100">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{$area['1'] / ($area['1'] + $area['2'] + 0.00001)}}%" aria-valuenow="{{$area['1'] / ($area['1'] + $area['2'] + 0.00001)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div><span class="text-light fs-sm ps-1 ms-2">{{$area['1']}}</span>
                                        </div>
                                    </div>
                                    <div class="pt-1">
                                        <h4 class="mb-2 fs-xs fw-normal text-light">
                                            <i class="fi-home mt-n1 me-2 fs-sm align-middle"></i>Property for rent
                                        </h4>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-light w-100">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$area['2'] / ($area['1'] + $area['2'] + 0.00001)}}%" aria-valuenow="{{$area['2'] / ($area['1'] + $area['2'] + 0.00001)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div><span class="text-light fs-sm ps-1 ms-2">{{$area['2']}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h3 class="mb-0 fs-base text-nav">{{$area['name']}}</h3>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    @if(isset($projects))
    <!-- Current Projects -->
    <section class="container mb-5 pb-2">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h3 mb-0">Current Projects</h2>
        </div>
        <div class="row gy-4">
            @foreach ($projects as $project)
            @if($project->post != null)
            <!-- Article-->
            <article class="col-md-6 pb-2 pb-md-0">
                <div class="card border-0 h-100">
                    <a class="d-block position-relative mb-3" href="{{$project->post->url()}}">
                        <img class="rounded-3" src="{{$project->post->img()}}" alt="Post image">
                    </a>
                    <div class="card-body p-0">
                        <a class="fs-sm text-uppercase text-decoration-none" href="{{$project->manufacturer->post->url()}}">
                            {{$project->manufacturer->name}}
                        </a>
                        <h2 class="h5 pt-1 mb-2">
                            <a class="nav-link" href="{{$project->post->url()}}">
                                {{$project->name}}
                            </a>
                        </h2>
                        <p class="mb-md-4 text-truncate">
                            {{$project->post->description}}
                        </p>
                    </div>

                </div>
            </article>
            @endif
            @endforeach
        </div>
    </section>
    @endif
    <!-- Luxury Properties-->
    @if(is_array($estatespecials))
    <section class="container pb-4 mb-5">
        <div class="d-flex align-items-end align-items-lg-center justify-content-between mb-4 pb-md-2">
            <div class="d-flex w-100 align-items-center justify-content-between justify-content-lg-start">
                <h2 class="h3 mb-0 me-md-4">Luxury Properties</h2>
            </div>
            <a class="btn btn-link fw-normal d-none d-lg-block p-0" href="/cities">View all<i class="fi-arrow-long-right ms-2"></i>
            </a>
        </div>
        <div class="row g-4">
            @if($estatespecials[0] != null)
            <div class="col-md-6">
                <div class="card bg-size-cover bg-position-center border-0 overflow-hidden h-100" style="height:300px;object-fit: cover;background-image: url('{{$estatespecials[0]->coverImage()}}');"><span class="img-gradient-overlay"></span>
                    <div class="card-body content-overlay pb-0">
                        <div class="d-flex">
                            <span class="badge bg-info fs-sm">{{toPersianDate($estatespecials[0]->showdate)}}</span>
                        </div>
                    </div>
                    <div class="card-footer content-overlay border-0 pt-0 pb-4">
                        <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5">
                            <a class="text-decoration-none text-light pe-2" href="{{$estatespecials[0]->url()}}">
                                <div class="fs-sm text-uppercase pt-2 mb-1">For sale</div>
                                <h3 class="h5 text-light mb-1">{{$estatespecials[0]->title}}</h3>
                                <div class="fs-sm opacity-70">
                                    <i class="fi-map-pin me-1"></i>
                                    {{ $estatespecials[0]->city->name ?? '' }}
                                    {{ $estatespecials[0]->district && $estatespecials[0]->district->name ? " ".$estatespecials[0]->district->name:"" }}
                                </div>
                            </a>
                            <div class="btn-group ms-n2 ms-sm-0 mt-3">
                                <a class="btn btn-primary px-3" href="{{$estatespecials[0]->url()}} style="height: 2.75rem;">
                                    {{ toPersianNumbers($estatespecials[0]->price) }} {{l('ت')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-6">
                @if(count($estatespecials) > 1)
                <div class="card bg-size-cover bg-position-center border-0 overflow-hidden mb-4" style="height:300px;object-fit: cover;background-image: url('{{$estatespecials[1]->coverImage()}}');">
                    <span class="img-gradient-overlay"></span>
                    <div class="card-body content-overlay pb-0">
                        <span class="badge bg-info fs-sm">{{toPersianDate($estatespecials[1]->showdate)}}</span>
                    </div>
                    <div class="card-footer content-overlay border-0 pt-0 pb-4">
                        <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5">
                            <a class="text-decoration-none text-light pe-2" href="{{$estatespecials[1]->url()}}">
                                <div class="fs-sm text-uppercase pt-2 mb-1">For sale</div>
                                <h3 class="h5 text-light mb-1">{{$estatespecials[1]->title}}</h3>
                                <div class="fs-sm opacity-70"><i class="fi-map-pin me-1"></i>
                                    {{ $estatespecials[1]->city->name ?? '' }}
                                    {{ $estatespecials[1]->district && $estatespecials[1]->district->name ? " ".$estatespecials[1]->district->name:"" }}
                                </div>
                            </a>
                            <div class="btn-group ms-n2 ms-sm-0 mt-3">
                                <a class="btn btn-primary px-3" href="{{$estatespecials[1]->url()}}" style="height: 2.75rem;">
                                    {{ toPersianNumbers($estatespecials[1]->price) }} {{l('ت')}}
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(0 && count($estatespecials) > 2)
                <div class="card bg-size-cover bg-position-center border-0 overflow-hidden" style="background-image: url(/img/site2/single/03.jpg);">
                    <span class="img-gradient-overlay"></span>
                    <div class="card-body content-overlay pb-0">
                        <span class="badge bg-info fs-sm">{{toPersianDate(estatespecials[2]->showdate)}}</span>
                    </div>
                    <div class="card-footer content-overlay border-0 pt-0 pb-4">
                        <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5">
                            <a class="text-decoration-none text-light pe-2" href="{{$estatespecials[2]->url()}}">
                                <div class="fs-sm text-uppercase pt-2 mb-1">For sale</div>
                                <h3 class="h5 text-light mb-1">{{$estatespecials[2]->title}}</h3>
                                <div class="fs-sm opacity-70"><i class="fi-map-pin me-1"></i>
                                    {{ $estatespecials[2]->city->name ?? '' }}
                                    {{ $estatespecials[2]->district && $estatespecials[2]->district->name ? " ".$estatespecials[2]->district->name:"" }}
                                </div>
                            </a>
                            <div class="btn-group ms-n2 ms-sm-0 mt-3">
                                <a class="btn btn-primary px-3" href="{{$estatespecials[2]->url()}}" style="height: 2.75rem;">
                                    {{ toPersianNumbers($estatespecials[2]->price) }} {{l('ت')}}
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    @if(isset($experts))
    <!-- List of Experts-->
    <section class="container mb-5 pb-2 pb-lg-5">
        <h2 class="mb-4">List of Experts</h2>
        <!-- Team carousel-->
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
            <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                @foreach ($experts as $expert)
                <!-- Team slide-->
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <img class="card-img-top" src="{{ $expert->photo() }}" alt="{{ $expert->fullname() }}" style="height:250px;object-fit: cover;">
                        <div class="card-body text-center">
                            <h3 class="h5 card-title mb-2">
                                <a href="/agents/{{$expert->id}}" class="text-decoration-none fs-6">
                                    {{ $expert->fullname() }}
                                </a>
                            </h3>
                            <span class="d-inline-block mb-3 fs-sm"></span>
                            <div class="pt-1">
                                @if($expert->telegram)
                                <a href="{{$expert->telegram}}" class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm mx-2" target="_blank" tabindex="-1">
                                    <i class="fi-telegram"></i>
                                </a>
                                @endif
                                @if($expert->whatsapp)
                                <a href="{{$expert->whatsapp}}" class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm mx-2" target="_blank" tabindex="-1">
                                    <i class="fi-whatsapp"></i>
                                </a>
                                @endif
                                @if($expert->instagram)
                                <a href="{{$expert->instagram}}" class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm mx-2" target="_blank" tabindex="-1">
                                <i class="fi-instagram"></i>
                                </a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    @endif
    <!-- Developers (article)-->
    <!--section class="container mb-5 pb-lg-5 pb-md-4 d-none">
        <div class="card py-lg-5 py-4 border-0 bg-secondary">
          <div class="card-body p-4 text-center">
            <h2>Developers (article)</h2>
            <p class="mx-auto mb-md-5 mb-4 pb-lg-3" style="max-width: 53.125rem;">We have the most comprehensive directory of estate agents to help you with all your property needs. Whether buying, selling or renting start your search to find the right local expertise.</p>
            <div class="d-flex align-items-center justify-content-center flex-wrap mb-md-5 mb-4 pb-lg-3 ps-3 pt-4">
              <div class="border border-5 border-white rounded-circle bg-white ms-n3 mt-n4"><img class="rounded-circle" src="/img/site2/avatars/39.jpg" width="110" alt="Avatar"></div>
              <div class="border border-5 border-white rounded-circle bg-white ms-n3 mt-n4"><img class="rounded-circle" src="/img/site2/avatars/40.jpg" width="110" alt="Avatar"></div>
              <div class="border border-5 border-white rounded-circle bg-white ms-n3 mt-n4"><img class="rounded-circle" src="/img/site2/avatars/41.jpg" width="110" alt="Avatar"></div>
              <div class="border border-5 border-white rounded-circle bg-white ms-n3 mt-n4"><img class="rounded-circle" src="/img/site2/avatars/42.jpg" width="110" alt="Avatar"></div>
              <div class="border border-5 border-white rounded-circle bg-white ms-n3 mt-n4"><img class="rounded-circle" src="/img/site2/avatars/39.jpg" width="110" alt="Avatar"></div>
              <div class="border border-5 border-white rounded-circle bg-white ms-n3 mt-n4"><img class="rounded-circle" src="/img/site2/avatars/40.jpg" width="110" alt="Avatar"></div>
              <div class="border border-5 border-white rounded-circle bg-white ms-n3 mt-n4"><img class="rounded-circle" src="/img/site2/avatars/41.jpg" width="110" alt="Avatar"></div>
              <div class="border border-5 border-white rounded-circle bg-white ms-n3 mt-n4"><img class="rounded-circle" src="/img/site2/avatars/42.jpg" width="110" alt="Avatar"></div>
              <div class="border border-5 border-white rounded-circle bg-white ms-n3 mt-n4"><img class="rounded-circle" src="/img/site2/avatars/39.jpg" width="110" alt="Avatar"></div>
              <div class="border border-5 border-white rounded-circle bg-white ms-n3 mt-n4"><img class="rounded-circle" src="/img/site2/avatars/40.jpg" width="110" alt="Avatar"></div>
              <div class="border border-5 border-white rounded-circle bg-white ms-n3 mt-n4"><img class="rounded-circle" src="/img/site2/avatars/41.jpg" width="110" alt="Avatar"></div>
            </div><a class="btn btn-lg btn-primary w-sm-auto w-100" href="#">Developers<i class="fi-chevron-right ms-2"></i></a>
          </div>
        </div>
    </section-->

    <!-- List of Properties Demands -->
    <section class=" mb-5 pb-md-4 back_card_state d-none">
        <div class="container py-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h3 mb-0 text-white">List of Properties Demands</h2><a class="btn btn-link fw-normal p-0 text-white" href="/cities">View all<i class="fi-arrow-long-right ms-2 text-white"></i></a>
            </div>
            <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
                <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
                    <!-- Item-->
                    <div class="col">
                        <div class="card shadow-sm card-hover border-0 h-100">
                            <div class="card-img-top card-img-hover"><a class="img-overlay" href="real-estate-single-v1.html"></a>
                                <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-success mb-1">Verified</span><span class="d-table badge bg-info">New</span></div>
                                <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                    <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                                </div><img src="/img/site2/catalog/01.jpg" alt="Image">
                            </div>
                            <div class="card-body position-relative pb-3">
                                <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For rent</h4>
                                <h3 class="h6 mb-2 fs-base"><a class="nav-link stretched-link" href="real-estate-single-v1.html">3-bed Apartment | 67 sq.m</a></h3>
                                <p class="mb-2 fs-sm text-muted">3811 Ditmars Blvd Astoria, NY 11105</p>
                                <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>$1,629</div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap"><span class="d-inline-block mx-1 px-2 fs-sm">3<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i></span></div>
                        </div>
                    </div>
                    <!-- Item-->
                    <div class="col">
                        <div class="card shadow-sm card-hover border-0 h-100">
                            <div class="card-img-top card-img-hover"><a class="img-overlay" href="real-estate-single-v1.html"></a>
                                <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-success mb-1">Verified</span><span class="d-table badge bg-danger">Featured</span></div>
                                <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                    <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                                </div><img src="/img/site2/catalog/02.jpg" alt="Image">
                            </div>
                            <div class="card-body position-relative pb-3">
                                <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For sale</h4>
                                <h3 class="h6 mb-2 fs-base"><a class="nav-link stretched-link" href="real-estate-single-v1.html">Family Home| 120 sq.m</a></h3>
                                <p class="mb-2 fs-sm text-muted">67-04 Myrtle Ave Glendale, NY 11385</p>
                                <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>$84,000</div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap"><span class="d-inline-block mx-1 px-2 fs-sm">4<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i></span></div>
                        </div>
                    </div>
                    <!-- Item-->
                    <div class="col">
                        <div class="card shadow-sm card-hover border-0 h-100">
                            <div class="card-img-top card-img-hover"><a class="img-overlay" href="real-estate-single-v1.html"></a>
                                <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-success">Verified</span></div>
                                <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                    <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                                </div><img src="/img/site2/catalog/03.jpg" alt="Image">
                            </div>
                            <div class="card-body position-relative pb-3">
                                <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For rent</h4>
                                <h3 class="h6 mb-2 fs-base"><a class="nav-link stretched-link" href="real-estate-single-v1.html">Greenpoint Rentals | 85 sq.m</a></h3>
                                <p class="mb-2 fs-sm text-muted">1510 Castle Hill Ave Bronx, NY 10462</p>
                                <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>$1,330</div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap"><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i></span></div>
                        </div>
                    </div>
                    <!-- Item-->
                    <div class="col">
                        <div class="card shadow-sm card-hover border-0 h-100">
                            <div class="card-img-top card-img-hover"><a class="img-overlay" href="real-estate-single-v1.html"></a>
                                <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-success mb-1">Verified</span><span class="d-table badge bg-info">New</span></div>
                                <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                    <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                                </div><img src="/img/site2/catalog/04.jpg" alt="Image">
                            </div>
                            <div class="card-body position-relative pb-3">
                                <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For sale</h4>
                                <h3 class="h6 mb-2 fs-base"><a class="nav-link stretched-link" href="real-estate-single-v1.html">Studio | 32 sq.m</a></h3>
                                <p class="mb-2 fs-sm text-muted">140-60 Beech Ave Flushing, NY 11355</p>
                                <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>$65,000</div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap"><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i></span></div>
                        </div>
                    </div>
                    <!-- Item-->
                    <div class="col">
                        <div class="card shadow-sm card-hover border-0 h-100">
                            <div class="card-img-top card-img-hover"><a class="img-overlay" href="real-estate-single-v1.html"></a>
                                <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-success mb-1">Verified</span></div>
                                <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                    <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                                </div><img src="/img/site2/catalog/05.jpg" alt="Image">
                            </div>
                            <div class="card-body position-relative pb-3">
                                <h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">For sale</h4>
                                <h3 class="h6 mb-2 fs-base"><a class="nav-link stretched-link" href="real-estate-single-v1.html">Cottage | 120 sq.m</a></h3>
                                <p class="mb-2 fs-sm text-muted">42 Broadway New York, NY 10004</p>
                                <div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>$184,000</div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap"><span class="d-inline-block mx-1 px-2 fs-sm">4<i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">2<i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i></span><span class="d-inline-block mx-1 px-2 fs-sm">1<i class="fi-car ms-1 mt-n1 fs-lg text-muted"></i></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if(isset($articles))
    <!-- Blog: Articles -->
    <section class="container my-5 py-lg-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
            <h2 class="h3 mb-sm-0">Articles</h2><a class="btn btn-link fw-normal ms-sm-3 p-0" href="/blog">Go to blog<i class="fi-arrow-long-right ms-2"></i></a>
        </div>
        <!-- Carousel-->
        <div class="tns-carousel-wrapper tns-nav-outside mb-md-2">
            <div class="tns-carousel-inner d-block" data-carousel-options="{&quot;controls&quot;: false, &quot;gutter&quot;: 24, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:3}}}">
                @foreach( $articles as $item)
                <!-- Item-->
                <article>
                    <a class="d-block mb-3" href="{{$item->url()}}">
                        <img class="rounded-3" src="{{$item->img()}}" alt="{{$item->title}}"  style="height:250px;object-fit: cover;">
                    </a>
                    @if(isset($item->category))
                    <a class="fs-xs text-uppercase text-decoration-none" href="/blogs/{{$item->category->id}}">{{$item->category->name}}</a>
                    @endif
                    <h3 class="fs-base pt-1">
                        <a class="nav-link" href="{{$item->url()}}">{{$item->title}}</a>
                    </h3>
                    <div class="ps-2">
                        <div class="d-flex text-body fs-xs">
                            <span class="me-2 pe-1">
                                <i class="fi-calendar-alt opacity-70 mt-n1 me-1 align-middle"></i>{{$item->publish_date}}
                            </span>
                        </div>
                    </div>
                </article>
                @endforeach

            </div>
        </div>
    </section>
    @endif
    <section class="container mb-5 d-none">
        <h3 class="text-center mb-4 ">Popular searches in the UAE</h3>

        <ul class="nav nav-pills  justify-content-center mb-5" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-sale" type="button" role="tab" aria-controls="pills-sale" aria-selected="true">For Sale</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-rent" type="button" role="tab" aria-controls="pills-rent" aria-selected="false">To Rent</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-sale" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="fs-5 mb-3">
                            <a href="/to-rent/apartments/dubai/" title="Apartments for rent in Dubai" class="text-dark ">
                                Dubai Apartments sale
                            </a>
                        </div>
                        <ul class="list-unstyled">
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Dubai Marina</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Village Circle</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Lake Towers</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Downtown Dubai</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Business Bay</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="fs-5 mb-3">
                            <a href="/to-rent/apartments/dubai/" title="Apartments for rent in Dubai" class="text-dark ">
                                Dubai Apartments sale
                            </a>
                        </div>
                        <ul class="list-unstyled">
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Dubai Marina</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Village Circle</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Lake Towers</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Downtown Dubai</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Business Bay</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="fs-5 mb-3">
                            <a href="/to-rent/apartments/dubai/" title="Apartments for rent in Dubai" class="text-dark ">
                                Dubai Apartments sale
                            </a>
                        </div>
                        <ul class="list-unstyled">
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Dubai Marina</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Village Circle</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Lake Towers</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Downtown Dubai</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Business Bay</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-rent" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="fs-5 mb-3">
                            <a href="/to-rent/apartments/dubai/" title="Apartments for rent in Dubai" class="text-dark ">
                                Dubai Apartments rent
                            </a>
                        </div>
                        <ul class="list-unstyled">
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Dubai Marina</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Village Circle</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Lake Towers</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Downtown Dubai</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Business Bay</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="fs-5 mb-3">
                            <a href="/to-rent/apartments/dubai/" title="Apartments for rent in Dubai" class="text-dark ">
                                Dubai Apartments rent
                            </a>
                        </div>
                        <ul class="list-unstyled">
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Dubai Marina</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Village Circle</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Lake Towers</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Downtown Dubai</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Business Bay</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="fs-5 mb-3">
                            <a href="/to-rent/apartments/dubai/" title="Apartments for rent in Dubai" class="text-dark ">
                                Dubai Apartments rent
                            </a>
                        </div>
                        <ul class="list-unstyled">
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Dubai Marina</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Village Circle</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Jumeirah Lake Towers</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Downtown Dubai</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="" class="text-decoration-none fw-bold" style="color:#004377;">Business Bay</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>


@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
<style>
    .select2-selection
    {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important
    }
    .select2-selection__rendered{
        margin:0 auto;

    }
</style>
<script src="/vendor/select2/select2.min.js"></script>
<script>
    $(".select2").select2()
</script>
@endsection
