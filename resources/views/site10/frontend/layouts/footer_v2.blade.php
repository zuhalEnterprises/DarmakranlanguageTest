<footer class="footer  pt-4" style="background: #222222">
    <div class="container pb-lg-4 pt-3 pt-lg-5">
        <!-- Links-->
        <div class="row pb-md-2 pb-lg-3 g-lg-5">

			    <div class="col-md-4 col-sm-12 col-12 footer1-1">
                    <section id="text-18" class="widget widget_text">
                        <h3 class="widget-title">{{l('درباره ما')}}</h3>
                        <div class="textwidget">
                            <p>{{l('گروه مشاورین املاک کفو با سال‌ها تجربه ارزشمند در حوزه خرید، فروش و سرمایه‌گذاری ملکی در دبی، مفتخر است همراه و مشاور مطمئن شما در این مسیر باشد. تیمی از کارشناسان باتجربه و آگاه به بازار املاک امارات، آماده‌اند تا با ارائه راهکارهای تخصصی، شما را در حفظ و افزایش سرمایه‌تان یاری رسانند.')}}</p>
                        </div>
                    </section>
                </div>
                <div class="col-md-4 col-sm-12 col-12 footer1-2">
                    <section id="text-19" class="widget widget_text">
                        <h3 class="widget-title">{{l('تماس با ما')}}</h3>
                        <div class="textwidget">
                            <p>{{l('آدرس :')}} <span class="Y2IQFc">
                                3202, boulevard plaza tower 1, Downtown, Dubai</span></p>
                            <p>{{l('تلفن :')}}  {{ss('SITE_PHONE')}} </p>
                            <p>{{l('ایمیل :')}} {{ss('SITE_EMAIL')}}</p>
                        </div>
                    </section>
                    <section id="nav_menu-3" class="widget widget_nav_menu">
                        <div class="menu-social-container">
                            <ul class="nav flex-row justify-content-center gap-3 text-white">
                                <li class="nav-item mb-2 fs-5">
                                    <a class="nav-link p-0 fw-normal opacity-80 text-warning" aria-label="instagram" href="https://www.instagram.com/isa_ghavasi?igsh=eWl1eXdobDJzemJr">
                                        <i class="fi-instagram"></i>
                                    </a>
                                </li>
                                <!--li class="nav-item mb-2 fs-5">
                                    <a class="nav-link p-0 fw-normal opacity-80 text-warning" aria-label="telegram" href="javascript:void(0)">
                                        <i class="fi-telegram-circle"></i>
                                    </a>
                                </li-->
                                <li class="nav-item mb-2 fs-5">
                                    <a class="nav-link p-0 fw-normal opacity-80 text-warning" aria-label="whatsapp" href="https://wa.me/971505507466">
                                        <i class="fi-whatsapp"></i>
                                    </a>
                                </li>
                                <li class="nav-item mb-2 fs-5">
                                    <a class="nav-link p-0 fw-normal opacity-80 text-warning" aria-label="youtube" href="https://www.youtube.com/@isaghavasi?si=Hv0tT_2S8bJ1R0Ft">
                                        <i class="fi-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>
                <div class="col-md-4 col-sm-12 col-12 footer1-3">
                    <section id="text-20" class="widget widget_text">
                        <h3 class="widget-title">{{l('لینک های مرتبط')}}</h3>
                        <div class="textwidget">
                            <p><a href=l("/page/درباره-ما")>{{l('درباره ما')}}</a></p>
                            <p><a href="/cities" class="">{{l('فایل های فروش ملک جدید')}}</a></p>
                            <p><a href="/blog">{{l('مقالات مرتبط')}}</a></p>
                            <p><a href="/contactus">{{l('تماس با ما')}}</a></p>
                        </div>
                    </section>
				</div>
         </div>
    </div>
    <div style="background-color: #222222;border-top:1px solid #3a3a3a">
        <div class="container">
            <p class="text-center fs-sm mt-2 py-4 mb-0">
                &copy; {{l('تمام حقوق این سایت متعلق به')}} {{ss('SITE_NAME')}} {{l('است')}} .
                {{l('تولید توسط')}}
                <a href="https://webcityco.com" target="_blank">Webcity</a>
            </p>
        </div>
    </div>
    <!-- Modal دریافت نام و تلفن -->
    <div class="modal fade" id="leadModal" tabindex="-1" aria-labelledby="leadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content rounded-4 shadow-sm">
                <form id="leadForm">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title text-primary fw-bold" id="leadModalLabel">
                            {{l('ثبت درخواست مشاوره')}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ l('بستن') }}"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4 text-center">
                            <p class="mb-1 fw-semibold text-dark">
                                {{l('فقط یک قدم تا ملک دلخواهت فاصله داری')}}!
                            </p>
                            <small class="text-muted">
                                {{l('اطلاعاتت رو وارد کن تا در کوتاه‌ترین زمان باهات تماس بگیریم')}}.
                            </small>
                        </div>
                        <div class="mb-3">
                            <input type="hidden" id="referrer_id">
                            <label for="leadName" class="form-label">{{l('نام شما')}}</label>
                            <input type="text" class="form-control rounded-pill text-center" id="name" required placeholder="{{l('مثلاً: علی رضایی')}}">
                        </div>

                        <div class="row g-2 align-items-end mb-3">
                            <div class="col-7">
                                <label for="mobile" class="form-label">{{l('شماره تماس')}}</label>
                                <input type="tel" class="form-control rounded-pill text-center" id="mobile" required placeholder="{{l('مثلاً')}}: 9121234567">
                            </div>
                            <div class="col-5">
                                <label class="form-label" for="country_id">{{ l('کشور') }}</label>
                                <select class="form-select select2 rounded-pill" name="country_id" id="country_id">
                                    <option value="">{{ l('انتخاب') }}</option>
                                    @foreach (country_list() as $country)
                                        <option value="{{ $country->id }}">
                                            {{ l($country->name) }} ({{ $country->phone_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer justify-content-center border-top-0 pt-0">
                        <button type="submit" class="btn btn-success w-100 rounded-pill">
                            <i class="fas fa-paper-plane me-1"></i> {{l('ارسال درخواست')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</footer>
