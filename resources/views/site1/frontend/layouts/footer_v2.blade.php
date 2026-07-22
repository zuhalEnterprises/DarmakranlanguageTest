<footer class="footer bg-secondary pt-4">
    <div class="container pt-lg-2 pb-2">
        <!-- Links-->
        <div class="row pb-md-2 pb-lg-3">
            <div class="col-12">
                <div class="d-flex flex-sm-row flex-column justify-content-around mx-n2">
                    <div class="mb-sm-0 mb-4 px-2">

                        <ul class="nav flex-column mb-sm-4 mb-2">
                            <li class="nav-item">
                                <a class="nav-link p-0 fw-normal" href="tel:09196159181">
                                    <i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i>
                                    09196159181
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link p-0 fw-normal" href="mailto:arashsalmizade@gmail.com">
                                    <i class="fi-mail mt-n1 me-2 align-middle opacity-70"></i>arashsalmizade@gmail.com
                                </a>
                            </li>

                        </ul>
                        <div class="pt-2">
                            <a class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2" href="https://www.instagram.com/{{env('APP_URL')}}">
                                <i class="fi-instagram"></i>
                            </a>
                            <a class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2" href="#">
                                <i class="fi-twitter"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mb-sm-0 mb-4 px-2">

                        <ul class="nav flex-column">
                            <li class="nav-item mb-2">
                                <a class="nav-link p-0 fw-normal" href="/c/{{ $selectedCity }}?type=1">{{ l('جستجوی املاک فروشی') }}</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link p-0 fw-normal" href="/c/{{ $selectedCity }}?type=2">{{ l('جستجوی املاک اجاره‌ای') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="px-2">

                        <ul class="nav flex-column">
                            <li class="nav-item mb-2">
                                <a class="nav-link p-0 fw-normal" href=l("/page/درباره-ما")>{{ l('درباره ما') }}</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link p-0 fw-normal" href="/page/contact-us">{{ l('تماس با ما') }}</a>
                            </li>


                        </ul>
                    </div>

                    <div class="px-2">

                        <ul class="nav flex-column">

                            <li class="nav-item mb-2">
                                <a class="nav-link p-0 fw-normal" href="/blog">{{ l('وبلاگ') }}</a>
                            </li>


                        </ul>
                    </div>

                </div>
            </div>

        </div>
        <div class="text-center fs-sm pt-3 mt-2 pb-2">
            &copy; تمام حقوق این سایت متعلق به {{ss('SITE_NAME')}} است .
        </div>
    </div>
</footer>
