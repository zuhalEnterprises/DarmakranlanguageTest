<div class="col-sm-3 sidemenu hidden-xs">
    <div id="stickerMe">
        <div class="mr-3 mt-5 select-filters">
            <h5>{{ l('فیلتر ها') }}</h5>
            <span>{{ l('حذف فیلتر ها') }}<i class="close fas fa-times"></i></span>
            <div class="chip waves-effect">{{ l('فقط عکس دار ها') }}<i class="close fas fa-times"></i></div>
            <div class="chip waves-effect">{{ l('فقط عکس دار ها') }}<i class="close fas fa-times"></i></div>
            <div class="chip waves-effect">{{ l('فقط عکس دار ها') }}<i class="close fas fa-times"></i></div>
        </div>
        <ul class="nav flex-column nav1 sidemenu">
            <li class="nav-item mr-3 mt-3">
                <h5>{{ l('دسته بندی ها') }}</h5>
            </li>
            <li class="nav-item ">
                <a class="nav-link text-secondary" href="#"><i class="far fa-home"></i>{{ l('املاک') }}</a>
                <ul class="sidemenu-child">
                    <li><a href="#" class="active">{{ l('فروش مسکونی') }}</a>
                        <ul>
                            <li><a href="#">{{ l('آپارتمان') }}</a></li>
                            <li><a href="#">{{ l('خانه') }}</a></li>
                            <li><a href="#">{{ l('ویلا') }}</a></li>
                        </ul>

                    </li>
                    <li><a href="#">{{ l('فروش اداری') }}</a></li>
                    <li><a href="#">{{ l('فروش تجاری') }}</a></li>
                    <li><a href="#">{{ l('اجاره مسکونی') }}</a></li>
                    <li><a href="#">{{ l('خرید مسکونی') }}</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link text-secondary" href="#"><i class="far fa-car"></i>{{ l('وسایل نقلیه') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-secondary" href="#"><i class="far fa-mobile-alt"></i>{{ l('لوازم الکترونیکی') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-secondary" href="#"><i class="far fa-home"></i>{{ l('مربوط به خانه') }}</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link text-secondary" href="#"><i class="far fa-home"></i>{{ l('املاک') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-secondary" href="#"><i class="far fa-car"></i>{{ l('وسایل نقلیه') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-secondary" href="#"><i class="far fa-mobile-alt"></i>{{ l('لوازم الکترونیکی') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-secondary" href="#"><i class="far fa-home"></i>{{ l('مربوط به خانه') }}</a>
            </li>
        </ul>
        <!--Accordion wrapper-->
        <div class="accordion md-accordion mt-2 sidefilter" id="accordionEx" role="tablist" aria-multiselectable="true">

            <!-- Accordion card -->
            <div class="card">

                <!-- Card header -->


                <div class="card-header" role="tab" id="headingOne1">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                        <h5 class="mb-0">
                            {{ l('محل') }} <i class="far fa-angle-down rotate-icon"></i>
                        </h5>
                    </a>
                </div>

                <!-- Card body -->
                <div id="collapseOne1" class="collapse" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                    <div class="card-body">
                        <select class="mdb-select md-form colorful-select dropdown-primary" searchable=l("نام محل...")>
                            <option value="1" selected disabled>{{ l('نام محل') }}</option>
                            <option value="1">{{ l('باجک') }}</option>
                            <option value="2">{{ l('توحید') }}</option>
                            <option value="3">{{ l('زنبیل آباد') }}</option>
                            <option value="4">{{ l('قدس') }}</option>
                            <option value="5">{{ l('سالاریه') }}</option>
                        </select>
                    </div>
                </div>

            </div>
            <!-- Accordion card -->

            <!-- Accordion card -->
            <div class="card">

                <!-- Card header -->
                <div class="card-header" role="tab" id="headingTwo2">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                        <h5 class="mb-0">
                            {{ l('قیمت') }} <i class="far fa-angle-down rotate-icon"></i>
                        </h5>
                    </a>
                </div>

                <!-- Card body -->
                <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2" data-parent="#accordionEx">
                    <div class="card-body">
                        <select class="mdb-select md-form colorful-select dropdown-primary">
                            <option value="1" selected disabled>{{ l('حداقل') }}</option>
                            <option value="1">1,500,000</option>
                            <option value="2">1,700,000</option>
                            <option value="3">1,800,000</option>
                            <option value="4">1,900,000</option>
                            <option value="5">2,500,000</option>
                        </select>
                        <select class="mdb-select md-form colorful-select dropdown-primary">
                            <option value="1" selected disabled>{{ l('حداکثر') }}</option>
                            <option value="1">1,500,000</option>
                            <option value="2">1,700,000</option>
                            <option value="3">1,800,000</option>
                            <option value="4">1,900,000</option>
                            <option value="5">2,500,000</option>
                        </select>
                    </div>
                </div>

            </div>
            <!-- Accordion card -->



        </div>
        <!-- Accordion wrapper -->

        <div>

            <div class="custom-control custom-switch border-bottom pt-2 pb-3" dir="ltr">
                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                <label class="custom-control-label" for="customSwitch1">{{ l('فقط عکس دار') }}</label>
            </div>
            <div class="custom-control custom-switch border-bottom pt-2 pb-3" dir="ltr">
                <input type="checkbox" class="custom-control-input" id="customSwitch2">
                <label class="custom-control-label" for="customSwitch2">{{ l('فقط فوری ها') }}</label>
            </div>

        </div>
    </div>
</div>
