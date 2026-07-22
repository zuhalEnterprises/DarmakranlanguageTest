@extends('frontend.layouts.app',['title'=> l('انتخاب شهر')])
@section('body_class',$templatePage->page_id)
@section('main_content')

    @include('frontend.layouts.header')

    <div class="container-fluid">
        <div class="row">

            <div class="sidebar col-xl-4 col-lg-4 col-md-12 col-sm-12">

                <div class="search-form">
                    <h6 class="mahdod">{{ l('شهر') }}</h6>
                    <select class="mdb-select md-form colorful-select dropdown-primary" searchable=l("نام شهر...")>
                        @foreach($cities as $city)
                            <option class="city-item" id="{{$city->id}}" data-redirect-url="{{$redirectUrl ?? ''}}" data-city="{{$city->name_en ?? ''}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="download-box visible-xs">
                    <a href="#"><img src="{{asset('/frontend/img/cofe.png')}}" alt=""></a>
                    <a href="#"><img src="{{asset('/frontend/img/sibche.png')}}" alt=""></a>
                    <div class="clearfix"></div>
                </div>

                <div class="page-desc py-5">
                    <?php echo $templatePage->description;?>
                </div>

                <hr class="line1">

                @if($templatePage->ads->count() > 0)
                    @foreach($templatePage->ads as $ad)
                        @if($ad->type == 1)
                            <div class="img-ads mt-2">
                                <a href="{{$ad->url ?? 'javascript:void(0)'}}">
                                    <img src="{{$ad->image()}}" alt="{{$ad->title}}">
                                </a>
                            </div>
                        @else
                            <div class="border mt-2 text-ads" style="background: #fcfcfc;">
                                <a href="{{$ad->url ?? 'javascript:void(0)'}}">
                                    <h5 class="text-info">{{$ad->title}}</h5>
                                    <p class="text-body">{{$ad->description}}</p>
                                </a>
                            </div>
                        @endif
                    @endforeach
                @endif

            </div>

            <div class="main col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <div class="city-search">

                    <input class="form-control" id="citySearch" type="text" placeholder="{{ l('جستجوی سریع نام شهر...') }}">

                    <p class="text-4">{{ l('مراکز استان ها') }}</p>

                    <ul class="list-group">
                        @foreach($provinces as $province)
                            <li class="list-group-item border-primary province-item" data-id="{{$province->id}}"><a>{{$province->name}}</a></li>
                        @endforeach
                    </ul>

                    <div id="city-box" style="display: none">
                        <p class="text-4">{{ l('شهرهای فعال') }}</p>

                        <ul class="list-group cities" id="cities">
                            {{--@foreach($cities as $city)
                                <li class="list-group-item border-primary city-item" id="{{$city->id}}" data-city="{{$city->name_en ?? ''}}"><a>{{$city->name}}</a></li>
                            @endforeach--}}
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>

    @include('frontend.layouts.footer')

@endsection
@section('js')
    <script type="text/javascript">
        $("#citySearch").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".city-search li").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('.province-item').on('click', function () {
            var provinceId = $(this).data('id');
            city_request(provinceId);
        });

        function city_request(province_id){
            $.get("/api/provinces/"+province_id+"/get_cities" , function (data, status) {
                if (data.result != null || data.result != '') {
                    $('#city-box').fadeOut(300);
                    $('ul.cities').empty();

                    var cityList = '';
                    $.each(data.result, function (i, item) {
                        cityList += '<li class="list-group-item border-primary city-item" id="' + item.id + '" data-city="' + item.name_en + '" ><a>' + item.name + '</a></li>';
                    });

                    $('ul.cities').append(cityList);
                    $('#city-box').fadeIn(300);
                }
            });
        }
    </script>
@endsection
