@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => (!empty($model)? l('ویرایش محله') :l('ثبت محله')),
])
@section('main_content')
<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">
<!-- Vendor Styles-->
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />

<link rel="stylesheet" href="/vendor/map/leaflet.css" />
<script src="/vendor/map/leaflet.js"></script>
<link rel="stylesheet" media="screen" href="/vendor/filepond/dist/filepond.min.css" />
<!-- Main Theme Styles + Bootstrap-->
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => '6'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{!empty($model)? l('ویرایش محله') :l('ثبت محله')}}</li>
                    </ol>
                </nav>
                <!-- Page content-->
                <div class="mb-4">
                    <h1 class="h2">{{!empty($model)? l('ویرایش محله') :l('ثبت محله')}}</h1>
                </div>
                <form id="js_singup" method="post" action="{{empty($model)?"/profile/district/store":"/profile/district/update/".$model->id}}">
                    @csrf
                    @method('post')
                    <div class="card card-body shadow-sm rounded p-4 mb-4">
                        <div class="row">
                            <div class="col-6 col-md-6 mb-4">
                                <label for="city" class="form-label fw-bold required">{{l('نام محله')}}</label>
                                <input id="city" type="text" class="form-control" name="name"  value="{{!empty($model)?$model->getOriginalName():''}}" required>
                            </div>
                            <div class="col-6 col-md-6 mb-4">
                                <label for="name_en" class="form-label fw-bold required">{{l('نام محله (انگلیسی)')}}</label>
                                <input id="name_en" type="text" class="form-control" name="name_en" value="{{!empty($model)?$model->getOriginalNameEn():""}}" >
                            </div>

                            <div class="col-6 col-md-6 mb-4">
                                <label for="province_id" class="form-label fw-bold required">{{l('استان')}}</label>
                                <select id="province_id" name="province_id" class="select2 form-control" dir="rtl" required>
                                    <option>&nbsp;</option>
                                    @foreach( $provinces as $item)
                                    <option value="{{$item->id}}"  {{$item->id == (!empty($model)?$model->province_id : '') ? 'selected' :''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6 col-md-6 mb-4">
                                <label for="city_id" class="form-label fw-bold required">{{l('شهر')}}</label>
                                <select id="city_id" name="city_id" class="select2 form-control" required>
                                    @if(isset($cities2))
                                    @foreach( $cities2 as $item)
                                    <option value="{{$item->id}}" {{$item->id == (!empty($model)?$model->city_id : '') ? 'selected' :''}}>{{l($item->name)}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            @if(env('COUNTRY') != 'UAE')
                            <div class="col-6 col-md-6 mb-4">
                                <label for="region_number" class="form-label fw-bold required">{{ l('منطقه جغرافیایی') }}</label>
                                <input id="region_number" type="text" class="form-control number" name="area" value="{{!empty($model)?$model->area:0}}" required="">
                            </div>




                            <div class="col-sm-12 mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <p class="help-block">{{ l('برای مشخص کردن موقعیت شعبه روی نقشه، در محل موردنظر کلیک کنید') }}</p>
                                        <div id="branch-map" style="height: 300px"></div>
                                    </div>
                                    <input type="hidden" name="posx" id="latitude" value="{{!empty($model) ?$model->posx:''}}">
                                    <input type="hidden" name="posy" id="longitude" value="{{!empty($model) ?$model->posy:''}}">
                                    <script>
                                        var defaultLatitude = '{{$model->posx ?? $defaultCity->posx}}';
                                        var defaultLongitude = '{{$model->posy ?? $defaultCity->posy}}';
                                        var defaultZoom = 15;
                                        var defaultLocation = [defaultLatitude, defaultLongitude];
                                        var map = L.map('branch-map').setView(defaultLocation, defaultZoom);
                                        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                                            attribution: '',
                                            maxZoom: 18,
                                            id: 'mapbox/streets-v11',
                                            tileSize: 512,
                                            zoomOffset: -1,
                                            accessToken: 'pk.eyJ1Ijoicm1kZXY2NyIsImEiOiJja3F0a3F6N3cyNXg4MnVvNGQ0bGVubGR3In0.MCnbfbG3ix5IHdXa6CBTRg'
                                        }).addTo(map);
                                        if (defaultLatitude != '{{$defaultCity->posx}}') {
                                            var marker = L.marker(defaultLocation).addTo(map);
                                            marker.bindPopup("<h5 class='text-bold text-maroon' style='width: max-content;'>{{ l('موقعیت انتخابی شما اینجاست!') }}</h5>").openPopup();
                                        }
                                        var popup = L.popup();

                                        function onMapClick(e) {
                                            popup
                                                .setLatLng(e.latlng)
                                                .setContent("<h5 class='text-bold text-maroon'>{{ l('مکان انتخابی') }}</h5>")
                                                .openOn(map);
                                            var latitude = e.latlng.lat.toString();
                                            var longitude = e.latlng.lng.toString();
                                            $('input[name="posx"]').val(latitude);
                                            $('input[name="posy"]').val(longitude);
                                        }
                                        map.on('click', onMapClick);
                                    </script>
                                </div>
                            </div>

                            <div class="col-6 col-md-6 mb-4">
                                <label class="form-label fw-bold" >{{ l('مناطق همسایه') }}</label>
                                <select class="form-control select2 adjacent_districts" name="adjacent_districts[]" id="adjacent_districts" multiple style="width:100%">
                                    @if(isset($districts))
                                    @foreach($districts as $district)
                                    <option value="{{$district->id}}"  {{!empty($model)?(($model->adjacentDistricts->where('adjacent_district_id','=',$district->id)->first() != null)?"selected":''):''}}>{{$district->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            @endif
                            @if(ss('SITE_ID') == 3)
                            <div class="col-6 col-md-6 mb-4">
                                <label for="city" class="form-label fw-bold required">{{ l('متوسط قیمت متری زمین') }}</label>
                                <input id="avgLand" type="text" class="form-control" name="avgLand"  value="{{!empty($model)?$model->avgLand:''}}" >
                                @if(!empty($model))
                                <span>{{$suggestAvgLand}}</span>
                                @endif
                            </div>
                            <div class="col-6 col-md-6 mb-4">
                                <label for="city" class="form-label fw-bold required">{{ l('متوسط قیمت متری آپارتمان نوساز') }}</label>
                                <input id="avgApartment" type="text" class="form-control" name="avgApartment"  value="{{!empty($model)?$model->avgApartment:''}}" >
                                @if(!empty($model))
                                <span>{{$suggestAvgApartment}}</span>
                                @endif
                            </div>
                            <div class="col-6 col-md-6 mb-4">
                                <label for="city" class="form-label fw-bold required">{{ l('متوسط قیمت متری آپارتمان زیر 5 سال') }}</label>
                                <input id="avgApartment5" type="text" class="form-control" name="avgApartment5"  value="{{!empty($model)?$model->avgApartment5:''}}" >
                                @if(!empty($model))
                                <span>{{$suggestAvgApartment5}}</span>
                                @endif
                            </div>
                            <div class="col-6 col-md-6 mb-4">
                                <label for="city" class="form-label fw-bold required">{{ l('متوسط قیمت متری آپارتمان بین 5 تا 10 سال') }}</label>
                                <input id="avgApartment10" type="text" class="form-control" name="avgApartment10"  value="{{!empty($model)?$model->avgApartment10:''}}" >
                                @if(!empty($model))
                                <span>{{$suggestAvgApartment10}}</span>
                                @endif
                            </div>
                            @endif
                            @if(ss('SITE_ID') == 2 || env('COUNTRY') == 'UAE' || ss('SITE_ID') == 3)
                            <div class="col-6 col-md-6 mb-4">
                                <label for="name_en" class="form-label fw-bold ">{{l('کد مقاله')}}</label>
                                @if (env('COUNTRY') == 'UAE')
                                <select id="post_id" name="post_id" class="select2 form-control" >
                                    <option value="">&nbsp;</option>
                                    @foreach( $posts as $item)
                                    <option value="{{$item->id}}" {{$item->id == (!empty($model)?$model->post_id : '') ? 'selected' :''}}>{{$item->title}}</option>
                                    @endforeach
                                </select>
                                @else
                                <input id="post_id" type="text" class="form-control" name="post_id" value="{{!empty($model)?$model->post_id:""}}" >
                                @endif
                            </div>
                            @endif
                            @if(env('COUNTRY') != 'UAE')
                            <div class="col-6 col-md-6 mb-4">
                                <label for="village" class="form-label fw-bold ">{{ l('روستا') }}</label>
                                <input type="CheckBox" id="village" name="village" value="1"  {{!empty($model)?($model->village==1?"checked":""):""}} />
                            </div>
                            @endif
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="  fa-light fa-save"></i>
                                    {{!empty($model)? l('ویرایش محله') :l('ثبت محله')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script src="/admin2/dist/js/regions.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <!-- Main theme script-->
    <script src="{{asset('/assets/js/valid.js')}}"></script>


    <script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#js_singup').validate({
            errorPlacement: function (error, element) {
                var type = $(element).attr('cus-valid')
                if (type == 'true') {
                    error.insertAfter(element.parent().parent());
                } else {
                    error.insertAfter(element)
                }
            },
        });
    });
    getCities();
    getAreas();

    function district_request(city_id, district_id){
        $.get("/api/cities/"+city_id+"/districts", function (data, status) {
            if (data.status) {
                //$('select#city_id').append('<option value="" disabled>{{ l('انتخاب کنید') }}</option>');
                $.each(data.result, function (i, item) {
                    $('select#adjacent_districts').append($('<option>', {
                        value: i,
                        text: item
                    }));
                });

                if( district_id !== '' ) {
                    //$("select#district_id option[value='" + district_id + "']").prop('selected', true);
                    $("select#adjacent_districts").select2().val(district_id).trigger('change');
                    $("#adjacent_districts").select2({closeOnSelect: false});
                }
            }
        });
    }
    function removeSelectOptions(elmID){
        console.log(elmID);
        var i;
        var selectElm = document.getElementById(elmID);
        if(selectElm != null){
            for (i = selectElm.options.length - 1; i >= 0; i--) {
                selectElm.remove(i);
            }

            selectElm.append('<option value="" disabled>{{ l('انتخاب کنید') }}</option>');
        }
    }
    function getDistricts2(){
        $('select#city_id').on('change', function () {
            var cityId = this.value;
            removeSelectOptions("adjacent_districts");
            console.log(cityId);
            district_request(cityId);
        });
    }
    getDistricts2();

    //$("#province_id").val({{!empty($model)?$model->province_id:''}} );
    //$("#city_id").val({{!empty($model)?$model->city_id:''}} );
</script>
@endsection
