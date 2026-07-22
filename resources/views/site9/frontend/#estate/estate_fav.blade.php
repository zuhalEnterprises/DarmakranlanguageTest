@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => ss('SITE_NAME'),
])

@section('main_content')

<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')

    <!-- Search Estate -->
    <section class="bg-dark pt-5 mb-3">
        <div class="container py-4">
            <h1 class="  pt-1 pt-md-3">Find Estate</h1>
            <!-- Search form-->
            <form class="form-group form-group-light d-block rounded-lg-pill mb-4">
                <div class="row align-items-center g-0 ms-n2">
                    <div class="col-lg-3 col-xl-4">
                        <div class="input-group  border-end-lg border-light"><span class="input-group-text   rounded-pill opacity-50 ps-3"><i class="fi-search"></i></span>
                            <input class="form-control" type="text" placeholder="Search Estate...">
                        </div>
                    </div>
                    <hr class="hr-light d-lg-none my-2">
                    <div class="col-lg-5 d-sm-flex">
                        <div class="dropdown w-sm-50 border-end-sm border-light" data-bs-toggle="select">
                            <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown"><i class="fi-list me-2"></i><span class="dropdown-toggle-label">Category</span></button>
                            <input type="hidden">
                            <ul class="dropdown-menu dropdown-menu-dark my-3">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <span class="dropdown-item-label">Sale</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <span class="dropdown-item-label">Rent </span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <hr class="hr-light d-sm-none my-2">
                        <div class="dropdown w-sm-50 border-end-lg border-light" data-bs-toggle="select">
                            <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown"><i class="fi-map-pin me-2"></i><span class="dropdown-toggle-label">Location</span></button>
                            <input type="hidden">
                            <ul class="dropdown-menu dropdown-menu-dark my-3">
                                <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">Dubai</span></a></li>
                                <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">Qatar</span></a></li>
                                <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">Iran</span></a></li>
                                <li><a class="dropdown-item" href="#"><span class="dropdown-item-label">Iraq</span></a></li>

                            </ul>
                        </div>
                    </div>
                    <hr class="hr-light d-lg-none my-2">
                    <div class="col-lg-4 col-xl-3 d-flex align-items-center">
                        <div class=" w-lg-100">
                            <button class="btn btn-dislike" type="button" data-bs-toggle="modal" data-bs-target="#filters-sidebar">
                                <i class="fi-filter-alt-horizontal me-2"></i><span class="">More Filters</span>
                            </button>


                        </div>
                        <button class="btn btn-primary btn-lg w-lg-auto rounded-pill" type="button">Find Estate</button>
                    </div>
                </div>
            </form>

        </div>
    </section>

    <section>
        <div class="container mb-3">
            <div class="row py-md-1">
                <!-- Filers sidebar (Offcanvas on mobile)-->
                <div class="col-lg-9 col-12">

                    <!-- Page title-->
                    <div class="d-flex align-items-center justify-content-between pb-4 mb-2">
                        <h1 class="fs-5  me-3 mb-0">Properties for rent in UAE </h1>
                        <div class=" d-none d-lg-block"><i class="fi-home fs-lg me-2"></i><span class="align-middle">249 estate</span></div>
                    </div>
                    <!-- Sorting + View-->
                    <div class="d-flex flex-column align-items-baseline gap-3 flex-lg-row align-items-center justify-content-between pb-4 mb-2">
                        <div class="d-flex flex-column align-items-lg-center flex-lg-row gap-2">
                            <span class="fs-sm">Furnish Type:</span>

                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic">
                                <button type="button" class="btn btn-primary">All</button>
                                <button type="button" class="btn btn-primary">Furnished</button>
                                <button type="button" class="btn btn-primary">Unfurnished</button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center ms-auto">
                            <label class="fs-sm   me-2 pe-1 text-nowrap" for="sorting1"><i class="fi-arrows-sort mt-n1 me-2"></i>Sort by:</label>
                            <select class="form-select  form-select-sm me-sm-4" id="sorting1">
                                <option>Newest</option>
                                <option>Popular</option>
                                <option>Price: Low - High</option>
                                <option>Price: Hight - Low</option>
                            </select>
                            <div class="d-none d-md-block border-end border-light" style="height: 1.25rem;"></div>

                        </div>

                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                    <i class="fi-list"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                                    <i class="fi-grid"></i>
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                            <!-- Item-->
                            <div class="card card-hover card-horizontal mb-4 border">
                                <div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="car-finder-single.html"></a>
                                    <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-info">New</span></div>
                                    <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                        <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i>
                                        </button>
                                    </div>
                                    <div class="tns-carousel-inner position-absolute top-0 h-100">
                                        <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url(/img/site2/catalog/01.jpg);">
                                        </div>
                                        <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url(/img/site2/catalog/02.jpg);">
                                        </div>
                                        <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url(/img/site2/catalog/03.jpg);">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column gap-3">
                                    <div class="d-flex align-items-center gap-2 text-dark fw-bold">
                                        <span>AED</span>
                                        <span class="fs-4 ">360,000</span>
                                        <span class="fs-sm ">Yearly</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-dark">
                                        <b class="pe-2" href="">Apartment</b>
                                        <p class="px-3 mb-0 d-flex align-items-center gap-2 border-start border-end" href="">
                                            <span class="d-flex align-items-center gap-1">
                                                <i class="fi-home"></i> <span>3</span>
                                            </span>
                                            <span class="d-flex align-items-center gap-1">
                                                <i class="fi-home"></i> <span>4</span>
                                            </span>
                                        </p>
                                        <span class="ps-2" href="">
                                            <b>Area:</b>
                                            118 <span class="fs-sm">sqft</span>
                                        </span>
                                    </div>
                                    <a href="# " class="text-decoration-none text-dark">
                                        Full Marina View | High Floor | Spacious Layout
                                    </a>
                                    <div class="fs-sm  "><i class="fi-map-pin me-1"></i>Marina Gate 2, Marina Gate, Dubai Marina, Dubai</div>

                                    <div class="d-flex align-items-center gap-2">
                                        <a href="" class="btn btn-primary">
                                            <i class="fi-phone "></i>
                                            <span>Call</span>
                                        </a>
                                        <a href="" class="btn btn-primary">
                                            <i class="fi-mail "></i>
                                            <span>Email</span>
                                        </a>
                                        <a href="" class="btn btn-primary">
                                            <i class="fi-whatsapp "></i>

                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Item-->
                            <div class="card card-hover card-horizontal mb-4 border">
                                <div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="car-finder-single.html"></a>
                                    <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-info">New</span></div>
                                    <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                        <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i>
                                        </button>
                                    </div>
                                    <div class="tns-carousel-inner position-absolute top-0 h-100">
                                        <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url(/img/site2/catalog/04.jpg);">
                                        </div>
                                        <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url(/img/site2/catalog/05.jpg);">
                                        </div>
                                        <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url(/img/site2/catalog/06.jpg);">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column gap-3">
                                    <div class="d-flex align-items-center gap-2 text-dark fw-bold">
                                        <span>AED</span>
                                        <span class="fs-4 ">360,000</span>
                                        <span class="fs-sm ">Yearly</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-dark">
                                        <b class="pe-2" href="">Apartment</b>
                                        <p class="px-3 mb-0 d-flex align-items-center gap-2 border-start border-end" href="">
                                            <span class="d-flex align-items-center gap-1">
                                                <i class="fi-home"></i> <span>3</span>
                                            </span>
                                            <span class="d-flex align-items-center gap-1">
                                                <i class="fi-home"></i> <span>4</span>
                                            </span>
                                        </p>
                                        <span class="ps-2" href="">
                                            <b>Area:</b>
                                            118 <span class="fs-sm">sqft</span>
                                        </span>
                                    </div>
                                    <a href="# " class="text-decoration-none text-dark">
                                        Full Marina View | High Floor | Spacious Layout
                                    </a>
                                    <div class="fs-sm  "><i class="fi-map-pin me-1"></i>Marina Gate 2, Marina Gate, Dubai Marina, Dubai</div>

                                    <div class="d-flex align-items-center gap-2">
                                        <a href="" class="btn btn-primary">
                                            <i class="fi-phone "></i>
                                            <span>Call</span>
                                        </a>
                                        <a href="" class="btn btn-primary">
                                            <i class="fi-mail "></i>
                                            <span>Email</span>
                                        </a>
                                        <a href="" class="btn btn-primary">
                                            <i class="fi-whatsapp "></i>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">

                            <!-- Carousel inside card -->
                            <div class="row g-3">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class=" card shadow-sm card-hover border-0">
                                        <div class="tns-carousel-wrapper card-img-top card-img-hover">
                                            <a href="#" class="img-overlay"></a>
                                            <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                                <span class="d-table badge bg-success mb-1">Verified</span>
                                                <span class="d-table badge bg-info">New</span>
                                            </div>
                                            <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist">
                                                    <i class="fi-heart"></i>
                                                </button>
                                            </div>
                                            <div class="tns-carousel-inner">
                                                <img src="/img/site2/catalog/01.jpg" alt="Image">
                                                <img src="/img/site2/catalog/02.jpg" alt="Image">
                                                <img src="/img/site2/catalog/03.jpg" alt="Image">
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column gap-2 p-3">
                                            <div class="d-flex align-items-center gap-2 text-dark fw-bold fs-5">
                                                <span>AED</span>
                                                <span class=" ">360,000</span>
                                                <span class="fs-sm ">Yearly</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 text-dark">

                                                <p class=" mb-0 d-flex align-items-center gap-2" href="">
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>3</span>
                                                    </span>
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>4</span>
                                                    </span>
                                                </p>

                                                <span class="d-flex align-items-center gap-1 ms-3">
                                                    <i class="fi-grid"></i> <span>4123 sqft</span>
                                                </span>
                                            </div>

                                            <div class="fs-sm  text-truncate"><i class="fi-map-pin me-1"></i>Marina Gate 2, Marina Gate, Dubai Marina, Dubai</div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class=" card shadow-sm card-hover border-0">
                                        <div class="tns-carousel-wrapper card-img-top card-img-hover">
                                            <a href="#" class="img-overlay"></a>
                                            <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                                <span class="d-table badge bg-success mb-1">Verified</span>
                                                <span class="d-table badge bg-info">New</span>
                                            </div>
                                            <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist">
                                                    <i class="fi-heart"></i>
                                                </button>
                                            </div>
                                            <div class="tns-carousel-inner">
                                                <img src="/img/site2/catalog/01.jpg" alt="Image">
                                                <img src="/img/site2/catalog/02.jpg" alt="Image">
                                                <img src="/img/site2/catalog/03.jpg" alt="Image">
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column gap-2 p-3">
                                            <div class="d-flex align-items-center gap-2 text-dark fw-bold fs-5">
                                                <span>AED</span>
                                                <span class=" ">360,000</span>
                                                <span class="fs-sm ">Yearly</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 text-dark">

                                                <p class=" mb-0 d-flex align-items-center gap-2" href="">
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>3</span>
                                                    </span>
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>4</span>
                                                    </span>
                                                </p>

                                                <span class="d-flex align-items-center gap-1 ms-3">
                                                    <i class="fi-grid"></i> <span>4123 sqft</span>
                                                </span>
                                            </div>

                                            <div class="fs-sm  text-truncate"><i class="fi-map-pin me-1"></i>Marina Gate 2, Marina Gate, Dubai Marina, Dubai</div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class=" card shadow-sm card-hover border-0">
                                        <div class="tns-carousel-wrapper card-img-top card-img-hover">
                                            <a href="#" class="img-overlay"></a>
                                            <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                                <span class="d-table badge bg-success mb-1">Verified</span>
                                                <span class="d-table badge bg-info">New</span>
                                            </div>
                                            <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist">
                                                    <i class="fi-heart"></i>
                                                </button>
                                            </div>
                                            <div class="tns-carousel-inner">
                                                <img src="/img/site2/catalog/01.jpg" alt="Image">
                                                <img src="/img/site2/catalog/02.jpg" alt="Image">
                                                <img src="/img/site2/catalog/03.jpg" alt="Image">
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column gap-2 p-3">
                                            <div class="d-flex align-items-center gap-2 text-dark fw-bold fs-5">
                                                <span>AED</span>
                                                <span class=" ">360,000</span>
                                                <span class="fs-sm ">Yearly</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 text-dark">

                                                <p class=" mb-0 d-flex align-items-center gap-2" href="">
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>3</span>
                                                    </span>
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>4</span>
                                                    </span>
                                                </p>

                                                <span class="d-flex align-items-center gap-1 ms-3">
                                                    <i class="fi-grid"></i> <span>4123 sqft</span>
                                                </span>
                                            </div>

                                            <div class="fs-sm  text-truncate"><i class="fi-map-pin me-1"></i>Marina Gate 2, Marina Gate, Dubai Marina, Dubai</div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class=" card shadow-sm card-hover border-0">
                                        <div class="tns-carousel-wrapper card-img-top card-img-hover">
                                            <a href="#" class="img-overlay"></a>
                                            <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                                <span class="d-table badge bg-success mb-1">Verified</span>
                                                <span class="d-table badge bg-info">New</span>
                                            </div>
                                            <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist">
                                                    <i class="fi-heart"></i>
                                                </button>
                                            </div>
                                            <div class="tns-carousel-inner">
                                                <img src="/img/site2/catalog/01.jpg" alt="Image">
                                                <img src="/img/site2/catalog/02.jpg" alt="Image">
                                                <img src="/img/site2/catalog/03.jpg" alt="Image">
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column gap-2 p-3">
                                            <div class="d-flex align-items-center gap-2 text-dark fw-bold fs-5">
                                                <span>AED</span>
                                                <span class=" ">360,000</span>
                                                <span class="fs-sm ">Yearly</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 text-dark">

                                                <p class=" mb-0 d-flex align-items-center gap-2" href="">
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>3</span>
                                                    </span>
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>4</span>
                                                    </span>
                                                </p>

                                                <span class="d-flex align-items-center gap-1 ms-3">
                                                    <i class="fi-grid"></i> <span>4123 sqft</span>
                                                </span>
                                            </div>

                                            <div class="fs-sm  text-truncate"><i class="fi-map-pin me-1"></i>Marina Gate 2, Marina Gate, Dubai Marina, Dubai</div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class=" card shadow-sm card-hover border-0">
                                        <div class="tns-carousel-wrapper card-img-top card-img-hover">
                                            <a href="#" class="img-overlay"></a>
                                            <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                                <span class="d-table badge bg-success mb-1">Verified</span>
                                                <span class="d-table badge bg-info">New</span>
                                            </div>
                                            <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist">
                                                    <i class="fi-heart"></i>
                                                </button>
                                            </div>
                                            <div class="tns-carousel-inner">
                                                <img src="/img/site2/catalog/01.jpg" alt="Image">
                                                <img src="/img/site2/catalog/02.jpg" alt="Image">
                                                <img src="/img/site2/catalog/03.jpg" alt="Image">
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column gap-2 p-3">
                                            <div class="d-flex align-items-center gap-2 text-dark fw-bold fs-5">
                                                <span>AED</span>
                                                <span class=" ">360,000</span>
                                                <span class="fs-sm ">Yearly</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 text-dark">

                                                <p class=" mb-0 d-flex align-items-center gap-2" href="">
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>3</span>
                                                    </span>
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>4</span>
                                                    </span>
                                                </p>

                                                <span class="d-flex align-items-center gap-1 ms-3">
                                                    <i class="fi-grid"></i> <span>4123 sqft</span>
                                                </span>
                                            </div>

                                            <div class="fs-sm  text-truncate"><i class="fi-map-pin me-1"></i>Marina Gate 2, Marina Gate, Dubai Marina, Dubai</div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class=" card shadow-sm card-hover border-0">
                                        <div class="tns-carousel-wrapper card-img-top card-img-hover">
                                            <a href="#" class="img-overlay"></a>
                                            <div class="position-absolute start-0 top-0 pt-3 ps-3">
                                                <span class="d-table badge bg-success mb-1">Verified</span>
                                                <span class="d-table badge bg-info">New</span>
                                            </div>
                                            <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist">
                                                    <i class="fi-heart"></i>
                                                </button>
                                            </div>
                                            <div class="tns-carousel-inner">
                                                <img src="/img/site2/catalog/01.jpg" alt="Image">
                                                <img src="/img/site2/catalog/02.jpg" alt="Image">
                                                <img src="/img/site2/catalog/03.jpg" alt="Image">
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column gap-2 p-3">
                                            <div class="d-flex align-items-center gap-2 text-dark fw-bold fs-5">
                                                <span>AED</span>
                                                <span class=" ">360,000</span>
                                                <span class="fs-sm ">Yearly</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 text-dark">

                                                <p class=" mb-0 d-flex align-items-center gap-2" href="">
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>3</span>
                                                    </span>
                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fi-home"></i> <span>4</span>
                                                    </span>
                                                </p>

                                                <span class="d-flex align-items-center gap-1 ms-3">
                                                    <i class="fi-grid"></i> <span>4123 sqft</span>
                                                </span>
                                            </div>

                                            <div class="fs-sm  text-truncate"><i class="fi-map-pin me-1"></i>Marina Gate 2, Marina Gate, Dubai Marina, Dubai</div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-lg-3 pe-xl-4 d-none d-lg-block">
                    <div class="mb-3">
                        <h2 class="fs-base bg-secondary fw-bold p-1">Recommended searches</h2>
                        <ul class="list-unstyled px-3">
                            <li>
                                <a href="" class="text-dark opacity-70 fs-sm text-decoration-none">
                                    Studio Properties for rent in UAE
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-dark opacity-70 fs-sm text-decoration-none">
                                    1 Bedroom Properties for rent in UAE
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-dark opacity-70 fs-sm text-decoration-none">
                                    2 Bedroom Properties for rent in UAE
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-dark opacity-70 fs-sm text-decoration-none">
                                    3 Bedroom Properties for rent in UAE
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-dark opacity-70 fs-sm text-decoration-none">
                                    4 Bedroom Properties for rent in UAE
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <h2 class="fs-base bg-secondary fw-bold p-1">Useful links</h2>
                        <ul class="list-unstyled px-3">
                            <li>
                                <a href="" class="text-dark opacity-70 fs-sm text-decoration-none">
                                    Properties for sale in UAE
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="mb-3">
                        <h2 class="fs-base bg-secondary fw-bold p-1">Short Term Residential Rentals</h2>
                        <ul class="list-unstyled px-3">
                            <li>
                                <a href="" class="text-dark opacity-70 fs-sm text-decoration-none">
                                    Cheap properties for monthly rent in UAE
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-dark opacity-70 fs-sm text-decoration-none">
                                    Properties for rent in UAE weekly
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-dark opacity-70 fs-sm text-decoration-none">
                                    Properties for daily rent in UAE
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-dark opacity-70 fs-sm text-decoration-none">
                                    Properties for rent in UAE monthly
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
                <!-- Catalog list view-->

            </div>
        </div>
    </section>

    <!-- Modal Filters -->
    <div class="modal fade" id="filters-sidebar">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header">
                    <h2 class="h5 mb-0">Filters</h2>
                    <button class="btn-close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-lg-4">
                    <div class="pb-4 mb-2">
                        <h3 class="h6">Location</h3>
                        <select class="form-select mb-2">
                            <option value="" disabled>Choose city</option>
                            <option value="Chicago">Chicago</option>
                            <option value="Dallas">Dallas</option>
                            <option value="Los Angeles">Los Angeles</option>
                            <option value="New York" selected>New York</option>
                            <option value="San Diego">San Diego</option>
                        </select>
                        <select class="form-select">
                            <option value="" selected disabled>Choose district</option>
                            <option value="Brooklyn">Brooklyn</option>
                            <option value="Manhattan">Manhattan</option>
                            <option value="Staten Island">Staten Island</option>
                            <option value="The Bronx">The Bronx</option>
                            <option value="Queens">Queens</option>
                        </select>
                    </div>
                    <div class="pb-4 mb-2">
                        <h3 class="h6">Property type</h3>
                        <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" style="height: 11rem;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="house">
                                <label class="form-check-label fs-sm" for="house">House</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="apartment" checked>
                                <label class="form-check-label fs-sm" for="apartment">Apartment</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="room">
                                <label class="form-check-label fs-sm" for="room">Room</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="office">
                                <label class="form-check-label fs-sm" for="office">Office</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="commercial">
                                <label class="form-check-label fs-sm" for="commercial">Commercial</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="land">
                                <label class="form-check-label fs-sm" for="land">Land</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="daily">
                                <label class="form-check-label fs-sm" for="daily">Daily rental</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="new-building">
                                <label class="form-check-label fs-sm" for="new-building">New building</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="parking-lot">
                                <label class="form-check-label fs-sm" for="parking-lot">Parking lot</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-4 mb-2">
                        <h3 class="h6">Price per month</h3>
                        <div class="range-slider" data-start-min="1100" data-start-max="3000" data-min="200" data-max="5000" data-step="100">
                            <div class="range-slider-ui"></div>
                            <div class="d-flex align-items-center">
                                <div class="w-50 pe-2">
                                    <div class="input-group"><span class="input-group-text fs-base">$</span>
                                        <input class="form-control range-slider-value-min" type="text">
                                    </div>
                                </div>
                                <div class="text-muted">&mdash;</div>
                                <div class="w-50 ps-2">
                                    <div class="input-group"><span class="input-group-text fs-base">$</span>
                                        <input class="form-control range-slider-value-max" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-4 mb-2">
                        <h3 class="h6 pt-1">Beds &amp; baths</h3>
                        <label class="d-block fs-sm mb-1">Bedrooms</label>
                        <div class="btn-group btn-group-sm" role="group" aria-label="Choose number of bedrooms">
                            <input class="btn-check" type="radio" id="studio" name="bedrooms">
                            <label class="btn btn-outline-secondary fw-normal" for="studio">Studio</label>
                            <input class="btn-check" type="radio" id="bedrooms-1" name="bedrooms" checked>
                            <label class="btn btn-outline-secondary fw-normal" for="bedrooms-1">1</label>
                            <input class="btn-check" type="radio" id="bedrooms-2" name="bedrooms">
                            <label class="btn btn-outline-secondary fw-normal" for="bedrooms-2">2</label>
                            <input class="btn-check" type="radio" id="bedrooms-3" name="bedrooms">
                            <label class="btn btn-outline-secondary fw-normal" for="bedrooms-3">3</label>
                            <input class="btn-check" type="radio" id="bedrooms-4" name="bedrooms">
                            <label class="btn btn-outline-secondary fw-normal" for="bedrooms-4">4+</label>
                        </div>
                        <label class="d-block fs-sm pt-2 my-1">Bathrooms</label>
                        <div class="btn-group btn-group-sm" role="group" aria-label="Choose number of bathrooms">
                            <input class="btn-check" type="radio" id="bathrooms-1" name="bathrooms">
                            <label class="btn btn-outline-secondary fw-normal" for="bathrooms-1">1</label>
                            <input class="btn-check" type="radio" id="bathrooms-2" name="bathrooms">
                            <label class="btn btn-outline-secondary fw-normal" for="bathrooms-2">2</label>
                            <input class="btn-check" type="radio" id="bathrooms-3" name="bathrooms">
                            <label class="btn btn-outline-secondary fw-normal" for="bathrooms-3">3</label>
                            <input class="btn-check" type="radio" id="bathrooms-4" name="bathrooms">
                            <label class="btn btn-outline-secondary fw-normal" for="bathrooms-4">4</label>
                        </div>
                    </div>
                    <div class="pb-4 mb-2">
                        <h3 class="h6 pt-1">Square metres</h3>
                        <div class="d-flex align-items-center">
                            <input class="form-control w-100" type="number" min="20" max="500" step="10" placeholder="Min">
                            <div class="mx-2">&mdash;</div>
                            <input class="form-control w-100" type="number" min="20" max="500" step="10" placeholder="Max">
                        </div>
                    </div>
                    <div class="pb-4 mb-2">
                        <h3 class="h6">Amenities</h3>
                        <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" style="height: 11rem;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="air-condition" checked>
                                <label class="form-check-label fs-sm" for="air-condition">Air conditioning</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="balcony">
                                <label class="form-check-label fs-sm" for="balcony">Balcony</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="garage" checked>
                                <label class="form-check-label fs-sm" for="garage">Garage</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gym">
                                <label class="form-check-label fs-sm" for="gym">Gym</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="parking">
                                <label class="form-check-label fs-sm" for="parking">Parking</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pool">
                                <label class="form-check-label fs-sm" for="pool">Pool</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="camera">
                                <label class="form-check-label fs-sm" for="camera">Security cameras</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="wifi" checked>
                                <label class="form-check-label fs-sm" for="wifi">WiFi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="laundry">
                                <label class="form-check-label fs-sm" for="laundry">Laundry</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="dishwasher">
                                <label class="form-check-label fs-sm" for="dishwasher">Dishwasher</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-4 mb-2">
                        <h3 class="h6">Pets</h3>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="allow-cats">
                            <label class="form-check-label fs-sm" for="allow-cats">Cats allowed</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="allow-dogs">
                            <label class="form-check-label fs-sm" for="allow-dogs">Dogs allowed</label>
                        </div>
                    </div>
                    <div class="pb-4 mb-2">
                        <h3 class="h6">Additional options</h3>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="verified">
                            <label class="form-check-label fs-sm" for="verified">Verified</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featured">
                            <label class="form-check-label fs-sm" for="featured">Featured</label>
                        </div>
                    </div>
                    <div class="border-top py-4">
                        <button class="btn btn-outline-primary" type="button"><i class="fi-rotate-right me-2"></i>Reset filters</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection