<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="utf-8">
    <title>{{$title}}</title>
    <!--meta charSet="utf-8" /-->
    @if(!empty($metaKeyword))
    <meta name="keywords" content="{{$metaKeyword}}" />
    @endif
    @if(isset($metaDescription))
    <meta name="description" content="{{$metaDescription}}" />
    @endif
    <meta name="subject" content="{{$title}}">
    <meta name="language" content="FA">
    <meta name="robots" content="index,follow" />
    @if(!empty($canonical))
    <meta name="url" content="@yield('canonical')">
    <meta name="identifier-URL" content="@yield('canonical')">
    @endif
    <meta name="category" content="agency">
    <meta name="rating" content="General">
    <meta name="revisit-after" content="7 days">
    <meta http-equiv="Content-Type" content="Type=text/html; charset=UTF-8" />
    <meta property="og:locale" content="fa_IR" />
    <meta http-equiv="Expires" content="0">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="geo.position" CONTENT="IRAN (ISLAMIC REPUBLIC OF)">
    <meta name="geo.placename" CONTENT="Qom">
    <meta name="geo.region" CONTENT="IR-21">
    <meta property="og:title" content="{{$title}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="@yield('canonical')" />
    <meta property="og:image" content="https://koomeh.ir/img/site3/logo.png" />
    @if(!empty($metaDescription))
    <meta property="og:description" content="{{$metaDescription}}" />
    @endif
    <meta property="og:type" content="website" />
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{$title}}">
    @if(!empty($canonical))
    <meta name="twitter:url" content="{{env('APP_URL').$canonical}}">
    @endif

    @if(!empty($metaDescription))
    <meta name="twitter:description" content="{{$metaDescription}}">
    @endif
    @if(!empty($canonical))
    <link rel="canonical" href="{{env('APP_URL').$canonical}}" />
    @endif
    <link rel="icon" type="favicon" href="/img/site{{ss('SITE_ID')}}/favicon.ico">
    <!-- Page loading styles-->
    <!-- Vendor Styles-->
    @if($currentUser)
    <link rel="stylesheet" href="/assets/vendors/fontawesome/css/all.min.css">
    @endif
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="/css/theme{{ss('SITE_ID')}}.min.css?seed=5">

    <!-- jQuery -->
    <script type="text/javascript" src="/frontend/js/jquery.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css">
    <style>
        body {
            overflow-x: hidden;
            max-width: 100vw;
          }
    </style>
    @yield('head')

    <script>
        (function () {
            window.onload = function () {
                var preloader = document.querySelector('.page-loading');
                if (preloader) {
                    preloader.classList.remove('active');
                    setTimeout(function () {
                        preloader.remove();
                    }, 500);
                }
            };
        })();
    </script>
</head>

<body class="@yield('body_class')">

    <div class="page-loading">
        <div class="page-loading-inner">
            <div class="page-spinner"></div><span>{{ l('لطفا منتظر باشید') }}</span>
        </div>
    </div>
    @yield('main_content')

    @yield('footer')
    <a class="btn-scroll-top" href="#top" data-scroll aria-label="{{ l('حرکت به بالا') }}"><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">{{ l('بالا') }}</span><i class="btn-scroll-top-icon fi-chevron-up"> </i></a>
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!--script src="/vendor/simplebar/dist/simplebar.min.js"></script-->
    <script src="/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <!--script src="/vendor/nouislider/dist/nouislider.min.js"></script-->
    <script src="/vendor/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <!-- Main theme script-->
    <script src="/js/theme.min.js"></script>
    <script src="/assets/vendors/validatejs/validate.min.js"></script>
    <script src="/assets/vendors/validatejs/validate-persian.js"></script>
    @yield('js')


    <script>
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }
        if ('{{isset($selectedCity)?$selectedCity:''}}' != getCookie('city') && '{{isset($selectedCity)?$selectedCity:''}}' != '') {
            setCookie('city', '{{$selectedCity}}', 365);
        }
        $('#selProvince').on('change', function() {
            setCookie('city', this.value, 365);
            window.location.replace("/c/" + this.value);
            getCookie();
        });
        $('#selProvinceMobile').on('change', function() {
            setCookie('city', this.value, 365);
            window.location.replace("/c/" + this.value);
            getCookie();
        });
        $('#selProvince').select2({

        });
        $('#selProvinceMobile').select2({

        });
    </script>
    <script type="application/ld+json"> {
        "@context": "http://schema.org",
        "@type": "Organization",
        "url": "https://koomeh.ir",
        "contactPoint": [{
          "@type": "ContactPoint",
          "telephone": "+98-25-3180",
          "email": "info@koomeh.ir"
        }]
      } </script>
    @if(ip_info("Visitor", "Country") == "Iran")
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8YF402CES3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-8YF402CES3');
    </script>

    @endif
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    once: true
                });
            }
        });
    </script>
</body>

</html>
