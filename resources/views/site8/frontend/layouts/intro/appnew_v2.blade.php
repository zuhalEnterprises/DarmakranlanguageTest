<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <title>{{$title}}</title>
    <!--meta charSet="utf-8" /-->
    @if(!empty($metaKeyword))
    <meta name="keywords" content="{{$metaKeyword}}" />
    @endif
    @if(!empty($metaDescription))
    <meta name="description" content="{{$metaDescription}}" />
    @else
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
    <meta name="geo.placename" CONTENT="Gilan">
    <meta name="geo.region" CONTENT="IR-21">
    <meta property="og:title" content="{{$title}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="@yield('canonical')" />
    <meta property="og:image" content="https://shmarkazi.ir/img/site8/logo-markazi.png"/>
    @if(!empty($metaDescription))
    <meta property="og:description" content="{{$metaDescription}}" />
    @else


    @endif
    <meta property="og:type" content="website" />
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{$title}}">
    @if(!empty($canonical))
    <meta name="twitter:url" content="{{$canonical}}">
    @endif
    @if(!empty($metaDescription))
    <meta name="twitter:description" content="{{$metaDescription}}">
    @else

    @endif
    @if(!empty($canonical))
    <link rel="canonical" href="{{$canonical}}" />
    @endif
    <!-- Page loading styles-->
    <style>
        .page-loading {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            -webkit-transition: all .4s .2s ease-in-out;
            transition: all .4s .2s ease-in-out;
            background-color: #1f1b2d;
            opacity: 0;
            visibility: hidden;
            z-index: 9999;
        }

        .page-loading.active {
            opacity: 0.3;
            visibility: visible;
        }

        .page-loading-inner {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            text-align: center;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            -webkit-transition: opacity .2s ease-in-out;
            transition: opacity .2s ease-in-out;
            opacity: 0;
        }

        .page-loading.active>.page-loading-inner {
            opacity: 1;
        }

        .page-loading-inner>span {
            display: block;
            font-size: 1rem;
            font-weight: normal;
            color: #fff;
            ;
        }

        .page-spinner {
            display: inline-block;
            width: 2.75rem;
            width: 2.75rem;
            height: 2.75rem;
            margin-bottom: .75rem;
            vertical-align: text-bottom;
            border: .15em solid #9691a4;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: spinner .75s linear infinite;
            animation: spinner .75s linear infinite;
        }



        @-webkit-keyframes spinner {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        label.error {
            color: red;
            font-size: 13px;
            font-weight: 300;
            white-space: nowrap;
            padding-right: 10px;
        }
        input.error {
            border-color: red;
        }
        @media (min-width: 992px){
            .navbar-expand-lg .dropdown-menu-end {
                left: 0!important;
            }
        }
        main , footer{
            direction: rtl;
        }

    </style>

    <!-- Vendor Styles-->
    <link rel="stylesheet" href="/assets/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
    <link rel="stylesheet" media="screen" href="/vendor/nouislider/dist/nouislider.min.css" />
    <link rel="stylesheet" media="screen" href="/files/tiny-slider.css" />
    <link rel="stylesheet" media="screen" href="/vendor/select2/select2.min.css" />
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="/css/site8.min.css">
    <link rel="stylesheet" media="screen" href="/css/style.css">

    <!-- jQuery -->
    <script type="text/javascript" src="/frontend/js/jquery.min.js"></script>

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
    @include('frontend.layouts.modal_city')
    @yield('footer')
    <!-- <a class="btn-scroll-top" href="#top" data-scroll><span
        class="btn-scroll-top-tooltip text-muted fs-sm me-2">{{ l('بالا') }}</span><i
        class="btn-scroll-top-icon fi-chevron-up"> </i></a> -->
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
    if ("serviceWorker" in navigator) {
        // Register a service worker hosted at the root of the
        // site using the default scope.
        navigator.serviceWorker.register("/sw.js").then(
        (registration) => {
            console.log("Service worker registration succeeded:", registration);
        },
        (error) => {
            console.error(`Service worker registration failed: ${error}`);
        },
        );
    } else {
        console.error("Service workers are not supported.");
    }
    </script>
    <script src="/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="/vendor/nouislider/dist/nouislider.min.js"></script>
    <script src="/vendor/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <!-- Main theme script-->
    <script src="/js/theme.min.js"></script>
    <script src="/assets/vendors/validatejs/validate.min.js"></script>
    <script src="/assets/vendors/validatejs/validate-persian.js"></script>
    @yield('js')
    <script>
        function setCookie(name,value,days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }
        if('{{$selectedCity}}' != getCookie('city')){
            setCookie('city', '{{$selectedCity}}', 365);
        }
        $('#selProvince').on('change', function() {
            setCookie('city', this.value, 365);
            window.location.replace("/c/"+this.value);
            getCookie();
        });
        $('#selProvinceMobile').on('change', function() {
            setCookie('city', this.value, 365);
            window.location.replace("/c/"+this.value);
            getCookie();
        });
        $('#selProvince').select2({

        });
        $('#selProvinceMobile').select2({

        });
    </script>



</body>

</html>
