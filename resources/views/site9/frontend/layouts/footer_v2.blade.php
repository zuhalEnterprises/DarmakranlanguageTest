<style>
    {{ l('.footer-background { flex-shrink: 0; /* جلوگیری از کوچک شدن اندازه */ background: url(\'/img/site4/footer1.jpg\'); /* تصویر پس‌زمینه */ background-color: #000; /* رنگ پس‌زمینه */ background-repeat: repeat; /* تکرار تصویر پس‌زمینه */ background-size: 28px 28px; /* اندازه تصویر پس‌زمینه */ }') }}
</style>
<footer class="footer pt-5 footer-background">
    <div class="container">
        <!-- لینک‌ها -->
        <div class="row pb-md-2 pb-lg-3 g-lg-5">
            <div class="col-lg-3 mb-4">
                <a class="d-inline-block mb-4 fs-2 text-decoration-none text-white" href="/">
                    <!-- <img src="/img/site4/logo.jpg" alt="{{ l('لوگو') }}" width="116"> -->
                    {{ss('SITE_NAME')}} <!-- نام سایت -->
                </a>

                <div class="pt-2">
                    <a class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2" href="#">
                        <i class="fi-facebook"></i> <!-- آیکون فیسبوک -->
                    </a>
                    <a class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2" href="#">
                        <i class="fi-twitter"></i> <!-- آیکون توییتر -->
                    </a>
                    <a class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2" href="https://www.instagram.com/{{ env('APP_URL') }}">
                        <i class="fi-instagram"></i> <!-- آیکون اینستاگرام -->
                    </a>
                    <a class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2" href="#">
                        <i class="fi-telegram"></i> <!-- آیکون تلگرام -->
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-6 mb-4 text-lg-center">
                <h4 class="h5 text-white">{{ l('لینک‌های سریع') }}</h4>
                <ul class="">
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0 fw-normal" href="/add">{{ l('افزودن ملک') }}</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0 fw-normal" href="/c/dubai?type=1">{{ l('فروش ملک') }}</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0 fw-normal" href="/c/dubai?type=1">{{ l('اجاره ملک') }}</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 mb-4 text-left">
                <h4 class="h5 text-white">{{ l('درباره ما') }}</h4>
                <p class="mb-0  text-justify text-white">
                    {{ l('ما تلاش کرده‌ایم نیازهای ملکی مشتریان خود را با استفاده از روش‌های پیشرفته، از جمله آموزش‌های تخصصی برای مشاوران، بهره‌گیری از کارشناسان حقوقی باتجربه و ارائه امکانات به‌روز در وب‌سایت خود، آسان، لذت‌بخش و سریع برآورده کنیم.') }}
                </p>
            </div>
         </div>
    </div>
    <div class="text-center fs-sm pt-4 pb-2 text-white-50">{{ l('© تمامی حقوق این سایت محفوظ است.') }}
    </div>
</footer>
