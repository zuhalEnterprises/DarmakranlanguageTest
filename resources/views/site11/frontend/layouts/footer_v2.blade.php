<footer class="footer  pt-4" style="background: #222222" @if(in_array($currentLocale, ['fa', 'ar'])) dir="rtl" @else dir="ltr" @endif>
    <div class="container pb-lg-4 pt-3 pt-lg-5">
        <!-- Links-->
        <div class="row pb-md-2 pb-lg-3 g-lg-5">

			    <div class="col-md-4 col-sm-12 col-12 footer1-1">
                    <section id="text-18" class="widget widget_text">
                        <h3 class="widget-title">{{ l('درباره ما') }}</h3>
                        <div class="textwidget">
                            <p>{{ l('گروه مشاورین املاک دارمکران با سال‌ها تجربه ارزشمند در حوزه خرید، فروش و سرمایه‌گذاری ملکی در دبی، مفتخر است همراه و مشاور مطمئن شما در این مسیر باشد. تیمی از کارشناسان باتجربه و آگاه به بازار املاک امارات، آماده‌اند تا با ارائه راهکارهای تخصصی، شما را در حفظ و افزایش سرمایه‌تان یاری رسانند.') }}</p>
                        </div>
                    </section>
                </div>
                <div class="col-md-4 col-sm-12 col-12 footer1-2">
                    <section id="text-19" class="widget widget_text">
                        <h3 class="widget-title">{{ l('تماس با ما') }}</h3>
                        <div class="textwidget">
                            <p>{{ l('آدرس :') }} <span class="Y2IQFc">
                                Downtown, Dubai</span></p>
                            <p>{{ l('تلفن :') }}  <a href="tel:+971557621019">971557621019+</a> </p>
                            <p>{{ l('ایمیل :') }} <a href="mailto:info@darmakran.com">info@darmakran.com</a></p>
                        </div>
                    </section>
                    <section id="nav_menu-3" class="widget widget_nav_menu">
                        <div class="menu-social-container">
                            <ul class="nav flex-row justify-content-center gap-3 text-white">
                                <li class="nav-item mb-2 fs-5">
                                    <a class="nav-link p-0 fw-normal opacity-80 text-warning" aria-label="instagram" href="https://www.instagram.com/aaa?igsh=eWl1eXdobDJzemJr">
                                        <i class="fi-instagram"></i>
                                    </a>
                                </li>
                                <!--li class="nav-item mb-2 fs-5">
                                    <a class="nav-link p-0 fw-normal opacity-80 text-warning" aria-label="telegram" href="javascript:void(0)">
                                        <i class="fi-telegram-circle"></i>
                                    </a>
                                </li-->
                                <li class="nav-item mb-2 fs-5">
                                    <a class="nav-link p-0 fw-normal opacity-80 text-warning" aria-label="whatsapp" href="https://wa.me/989124525207">
                                        <i class="fi-whatsapp"></i>
                                    </a>
                                </li>
                                <li class="nav-item mb-2 fs-5">
                                    <a class="nav-link p-0 fw-normal opacity-80 text-warning" aria-label="youtube" href="https://www.youtube.com/@hgolab?si=Hv0tT_2S8bJ1R0Ft">
                                        <i class="fi-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>
                <div class="col-md-4 col-sm-12 col-12 footer1-3">
                    <section id="text-20" class="widget widget_text">
                        <h3 class="widget-title">{{ l('لینک های مرتبط') }}</h3>
                        <div class="textwidget">
                            <p><a href=l("/page/درباره-ما")>{{ l('درباره ما') }}</a></p>
                            <p><a href="/cities" class="">{{ l('فایل های فروش ملک جدید') }}</a></p>
                            <p><a href="/blog">{{ l('مقالات مرتبط') }}</a></p>
                            <p><a href="/contactus">{{ l('تماس با ما') }}</a></p>
                        </div>
                    </section>
				</div>
         </div>
    </div>
    <div style="background-color: #222222;border-top:1px solid #3a3a3a">
        <div class="container">
            <p class="text-center fs-sm mt-2 py-4 mb-0">
                @if(($currentLocale ?? 'fa') === 'ar')
                    &copy; جميع الحقوق محفوظة لـ {{ ss('SITE_NAME') ?: l('دارمكران') }}. {{ l('تولید توسط') }} <a href="https://webcityco.com" target="_blank">{{ l('ويب سيتي') }}</a>
                @elseif(($currentLocale ?? 'fa') === 'en')
                    &copy; All rights reserved by {{ ss('SITE_NAME') ?: 'Darmakran' }}. {{ l('تولید توسط') }} <a href="https://webcityco.com" target="_blank">Web City</a>
                @else
                    &copy; {{ l('تمام حقوق این سایت متعلق به') }} {{ ss('SITE_NAME') ?: l('دارمکران') }} {{ l('است') }} . {{ l('تولید توسط') }} <a href="https://webcityco.com" target="_blank">{{ l('وب سیتی') }}</a>
                @endif
            </p>
        </div>
    </div>

</footer>
