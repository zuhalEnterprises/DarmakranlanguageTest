<style>
    footer .text-center,footer a{color:#fff !important}
    footer .btn{background-color:unset  !important}

</style>
<footer class="footer pt-4" style="background:#5a8d5d;">
    <div class="container pb-lg-4 pt-3 pt-lg-5">
        <!-- Links-->
        <div class="row pb-md-2 pb-lg-3 g-lg-5">
            <div class="col-lg-3 mb-4">
                <div class="d-flex align-items-center mb-2">
                    <a href="/" class="">
                    <img src="/img/site2/logo.png" style="height: 50px;width:50px"  alt="{{ l('املاک گیلان') }}"/>
                    </a>
                    <a href="/" class="navbar-brand ms-3 ms-xl-4 logo" alt="{{ l('املاک گیلان') }}" style="color:#b1111c;">
                        {{ l('املاک گیلان') }}
                    </a>
                </div>
                <p class="mb-0 text-white">
                    {{ l('در گیلند ملک تلاش کردیم تا با استفاده از متد روز از جمله آموزش تخصصی مشاورین، استفاده از وکلای حقوقی با تجربه و همچنین ایجاد امکانات به روز در سایت، نیازهای ملکی مشتریان را آسان، جذاب و سریع مرتفع نماییم') }}
                </p>
            </div>
            <div class="col-lg-3 mb-4 ">
                <h6 class=" mb-lg-3 text-white">{{ l('دسترسی سریع') }}</h6>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link p-0 fw-normal" href="#">{{ l('چگونه مهمان شوم') }}</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link p-0 fw-normal" href="/rent/rules">{{ l('قوانین و مقررات') }}</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link p-0 fw-normal" href="#">{{ l('فرصت های شغلی') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 mb-4 ">
                <h6 class=" mb-lg-3 text-white">{{ l('لینک های سریع') }}</h6>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link p-0 fw-normal" href="/rental/host">{{ l('چگونه میزبان شوم') }}</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link p-0 fw-normal" href="/rental/rules">{{ l('مقررات رزرو') }}</a>
                    </li>


                </ul>
            </div>

            <div class="col-lg-3 mb-4">
                <h6 class="text-white mb-lg-3">{{ l('آدرس ما') }}</h6>
                <div class="border w-100  rounded" id="branch-map" style="height: 180px;"></div>
            </div>


            <link rel="stylesheet" href="/vendor/map/leaflet.css" />
            <script src="/frontend/js/modules/leaflet/leaf.js"></script>



        <script>
            var defaultZoom=12;
            var defaultLocation= ['37.560705','49.153474'];
            var map = L.map('branch-map').setView(defaultLocation, defaultZoom);
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1Ijoicm1kZXY2NyIsImEiOiJja3F0a3F6N3cyNXg4MnVvNGQ0bGVubGR3In0.MCnbfbG3ix5IHdXa6CBTRg'
            }).addTo(map);
            var marker = L.marker(defaultLocation).addTo(map);
            //marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();

            // marker map
            var latitude = null;
            var longitude = null;
            map.on('dblclick',function(e){
                latitude = e.latlng.lat;
                longitude = e.latlng.lng;
            });
        </script>


        </div>

    </div>
    <div style="background:#1d531d94;">
        <div class="container">
            <div class="text-center fs-sm py-4 mt-2">
                &copy; تمام حقوق این سایت متعلق به {{ss('SITE_NAME')}} است .
            </div>
        </div>
    </div>
</footer>
