<!DOCTYPE html>
<html lang="{{ $currentLocale ?? 'fa' }}" @if(in_array($currentLocale ?? 'fa', ['fa', 'ar'])) dir="rtl" @else dir="ltr" @endif>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="@yield('metaDescription')">
{{--    <meta name="keyword" content="{{config('app.title_fa')}}|@yield('metaKeyword')">--}}
    <title>@yield('title')</title>
    <!-- MDB icon -->
    <link rel="icon" href="#" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/frontend/css/all.min.css')}}">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{asset('/frontend/css/bootstrap.min.css')}}">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="{{asset('/frontend/css/mdb.min.css')}}">
    <!-- RTL -->
    <link rel="stylesheet" href="{{asset('/mainpage/css/bootstrap.rtl.min.css')}}">
    <link rel="stylesheet" href="{{asset('/mainpage/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/mainpage/css/owl.carousel.min.css')}}">
    <!-- jQuery -->
    <script type="text/javascript" src="/frontend/js/jquery.min.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
    <!-- Your custom styles (optional) -->

    <link rel="icon" type="favicon" href="{{asset('favicon.ico')}}">

    @yield('head')

    <link rel="stylesheet" href="{{asset('/frontend/css/style.css')}}">

    @if(($currentLocale ?? 'fa') === 'ar')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">
    @endif

    <style>
        .leaflet-top, .leaflet-bottom {z-index: 998 !important;}
        .btn-details {margin-top: 5px;}
        .city-search .list-group .list-group-item {padding: 0.5rem .25rem !important;}
        .radius-5 {border-radius: 5px;}
        .select-wrapper>label.mdb-main-label {right: 2px;}
        .text-ads .text-info {font-size: 1rem;}
        .text-ads .text-body {font-size: .92rem;text-align: justify;margin-top: 10px;}
        button.group-share{border-radius: 0 3px 3px 0;padding: .375rem 1.3rem;border: 1px solid teal !important;}
        input.group-share {
            border-top-right-radius: 0!important;
            border-bottom-right-radius: 0!important;
            border-right-color: transparent!important;
            background-color: #f5f5f5!important;
            text-align: center!important;
            padding: 1.25rem .9rem !important;
        }
        .img-cover{
            border: 2px solid #faa61a;
            border-radius: 25px;
            padding: 2px;
            width: auto !important;
            background: #fff;
        }
        .dz-filename{display: none}

        .leaflet-popup-content-wrapper, .leaflet-popup-tip { background: #faa61a !important;}
        .leaflet-popup-content {
            margin: 5px 15px !important;
            line-height: 1.3 !important;
            font-size: 1rem !important;
            text-align: center !important;
            color: #ffffff !important;
            font-family: 'IRANSans' !important;
            max-width: 120px;
        }
        .Areas--Served{
            flex-basis: 20%;
        }
        @if(($currentLocale ?? 'fa') === 'ar')
        html[lang="ar"] body,
        html[lang="ar"] body * {
            font-family: 'Cairo', 'IRANSans', sans-serif !important;
        }
        html[lang="ar"] .leaflet-popup-content {
            font-family: 'Cairo', 'IRANSans', sans-serif !important;
        }
        @endif

    </style>
</head>

<body class="@yield('body_class')">

    @yield('main_content')

    @include('frontend.layouts.modal_login')
    @include('frontend.layouts.modal_city')

    <!-- jQuery -->
    {{--<script type="text/javascript" src="{{asset('/frontend/js/jquery.min.js')}}"></script>--}}
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="{{asset('/frontend/js/popper.min.js')}}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{asset('/frontend/js/bootstrap.min.js')}}"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="{{asset('/frontend/js/mdb.js')}}"></script>

    @yield('js')

    <script type="text/javascript">
        // if redirected from the expert search

        // Material Select Initialization
        $(document).ready(function () {
            $("#stickerMe").sticky({
                bottomSpacing: 40
            });
            ///alert(window.location.href)
            var redirectUrl = '{{$redirectUrl ?? ''}}';


            // Material Select Initialization
            $('.mdb-select,.mdb-select1').materialSelect();

            $("#cityListSearch").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".city-search li").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // get last city
            var defaultCity = getCookie('city');
            if(typeof defaultCity === 'undefined' || defaultCity === null || defaultCity === ''){
                defaultCity = 'tehran';
            }

            $('.navbar-select-city').on('click', function () {
                $('ul#modal-city-box').hide();
            });

            $('.modal-province-item').on('click', function () {
                var provinceId = $(this).data('id');
                city_request(provinceId);
            });

            function city_request(province_id){
                $.get("/api/provinces/"+province_id+"/get_cities" , function (data, status) {
                    if (data.result != null || data.result != '') {
                        $('#modal-city-box').fadeOut(300);
                        $('ul#cityList').empty();

                        var cityList = '';
                        $.each(data.result, function (i, item) {
                            cityList += '<li class="list-group-item border-primary city-item" id="' + item.id + '" data-city="' + item.name_en + '"><a>' + item.name + '</a></li>';
                        });

                        $('ul#cityList').append(cityList);
                        $('#modal-city-box').fadeIn(300);
                    }
                });
            }

            // selected city
            $("body").on("click",'.city-item', function () {
                var referrerUrl = '{{\Request::is('*agents/search*') ? '/agents/search' : (\Request::is('*add*') ? '/add' : '')}}';
                var city = $(this).attr('data-city');
                if(city == ''){
                    city = defaultCity;
                }

                // set default city
                setCookie('city',city,365);

                if(redirectUrl == '' && referrerUrl== ''){
                    //alert(['estate',redirectUrl, expertSearchUrl]);
                   window.location.href = '/c/'+city;
                }else if(redirectUrl != ''){
                    //alert(['expert1',redirectUrl, expertSearchUrl]);
                    window.location.href = redirectUrl;
                }else if(referrerUrl != ''){
                    //alert(['expert2',redirectUrl, expertSearchUrl]);
                   window.location.href = referrerUrl;
                }
            });

            $('#mobileCityList').change(function(){
                var referrerUrl = '{{\Request::is('*agents/search*') ? '/agents/search' : (\Request::is('*add*') ? '/add' : '')}}';
                var cityId = $(this).val();
                var city = $(this).find(':selected').attr('data-city');

                if(city == ''){
                    city = defaultCity;
                }

                // set default city
                setCookie('city',city,365);

                if(redirectUrl == '' && referrerUrl== ''){
                    //alert(['estate',redirectUrl, expertSearchUrl]);
                    window.location.href = '/c/'+city;
                }else if(redirectUrl != ''){
                    //alert(['expert1',redirectUrl, expertSearchUrl]);
                    window.location.href = redirectUrl;
                }else if(referrerUrl != ''){
                    //alert(['expert2',redirectUrl, expertSearchUrl]);
                    window.location.href = referrerUrl;
                }
            });



            var latinNum = 0;
            $('#signup').on('click',function () {
                mobile = $('input#mobile').val();
                latinNum = parseArabic(mobile);
                latinNum = '0'+latinNum;

                if(latinNum == 0 || latinNum == ''){
                    alert('{{ l('لطفا شماره موبایل معتبر وارد نمایید!') }}');
                    return false;
                }

                var name = $('#name').val();
                var father_name = $('#father_name').val();
                var national_code = $('#national_code').val();
                var gender = $('#gender').val();
                var military_status = $('#military_status').val();
                var marital_status = $('#marital_status').val();
                var birthday = $('#birthday').val();
                var experience = $('#experience').val();
                var acquaintance_type = $('#acquaintance_type').val();
                var reagent_username = $('#reagent_username').val();
                $.ajax({
                    type: 'POST',
                    url: '/agent/register',
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    data: {
                        _method:'post',
                        mobile: latinNum,
                        province_id:provinceId,
                        city_id:cityId,
                        name:name,
                        father_name:father_name,
                        national_code:national_code,
                        birthday:birthday,
                        gender:gender,
                        military_status:military_status,
                        marital_status:marital_status,
                        experience:experience,
                        acquaintance_type:acquaintance_type,
                        reagent_username:reagent_username
                    },
                    error: function (xhr, status, error) {
                        var obj = JSON.parse(xhr.responseText);
                        console.log(obj);
                        if(obj.status==='Error'){
                            return false;
                        }

                        return true;
                    },
                    success: function (response) {
                        console.log(response);
                        var status = response.status;
                        if(status==='Success'){
                            var res = response.data;

                            $('#page-content .register-alert p').text(response.message);

                            $('footer').addClass('intro');
                            $('#form').addClass('done disabled');

                            $('#horizontal-stepper').fadeOut(500);
                            $('#page-content .register-alert').fadeIn(500);

                            return true;
                        }

                        return false;
                    }
                });

            });

        });

        // set cookie
        function setCookie(name,value,days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }

        // get cookie
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

        // update cookie
        function updateCookie(key,val,days,removeStatus) {
            // get current items
            var esIds = getCookie(key);

            // pars item list
            var esIdsObj = [];
            if(esIds){
                esIdsObj = JSON.parse(esIds);
            }

            // remove|add item
            if(removeStatus){// remove
                var idIndex = esIdsObj.indexOf(val);
                esIdsObj.splice(idIndex, 1);
            }else{// add
                esIdsObj.push(val);
            }

            // unique
            var uniqueIds = [];
            $.each(esIdsObj, function(i, el){
                if($.inArray(el, uniqueIds) === -1) uniqueIds.push(el);
            });

            // replace list (update|add)
            setCookie(key,JSON.stringify(uniqueIds),days);

            return true;
        }
    </script>
    <script src="{{asset('/frontend/vendor/sweetalert2.all.js')}}"></script>
    <script src="{{asset('/frontend/mainpage/js/jquery-3.6.0.slim.min.js')}}"></script>
    <script src="{{asset('/frontend/mainpage/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('/frontend/mainpage/js/app.js')}}"></script>

    <script>
        const toast = swal.mixin({
            toast: true,
            position: 'bottom-left',
            showConfirmButton: false,
            timer: 2500
        });
    </script>
</body>
</html>
