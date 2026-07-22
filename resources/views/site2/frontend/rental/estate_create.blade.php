@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',
[
'title'=>l('ثبت اقامتگاه')
])
@section('head')
<link href="{{asset('/frontend/js/modules/leaflet/leaflet.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/basic.min.css')}}" />
<link rel="stylesheet" media="screen" href="/vendor/persian-datepicker/persian-datepicker.min.css" />
@endsection
@section('main_content')
    <link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
    <link rel="stylesheet" media="screen" href="/vendor/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" media="screen"
        href="/vendor/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" />
    <link rel="stylesheet" media="screen" href="/vendor/filepond/dist/filepond.min.css" />
    <style>
.modal1 {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1055;
  display: none;
  width: 100%;
  height: 100%;
  overflow-x: hidden;
  overflow-y: auto;
  outline: 0;
}
.land{display:none}
.dropzone.dz-started .dz-message {
    border:1px solid gray;
  display: block!important;display: inline-table;
    width: 120px !important;
    height: 125px !important;
    float: right;
}
.not{display:none}
.form-select{
    width:100%
}
.rent{display: none}
.dropzone {
  min-height: 150px;
  border: 2px solid rgba(0,0,0,0.1);
  background: white;
  padding: 20px 20px;
}
.dropzone .dz-message {
  text-align: center;
  margin: .5em 0;
}
.dz-preview{
    float: right;
    flex-basis: 100%;
}
@media (min-width: 500px){
.modal-dialog {
  max-width: 80%!important;
  margin: 1.75rem auto;
  }
}
@media (min-width: 500px){
    .dz-preview{
    float: right;
    flex-basis: 50%;
  }
}
@media (min-width: 900px){
    .dz-preview{
    float: right;
    flex-basis: 30%;
  }
}
@media (min-width: 1200px){
    .dz-preview{
    float: right;
    flex-basis: 19%;
  }
}
.est-container{
    position: relative;
}
.est-img {
    opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
  object-fit: cover;
}
.est-container:hover .est-img {
  opacity: 0.3;
}
.est-container:hover .middle {
  opacity: 1;
}
.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}
.text {
  background-color: red;
  color: white;
  font-size: 16px;
  padding: 16px 32px;
}
    </style>
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
        <!-- Page container-->
        <div class="container mt-5 mb-md-4 py-5">
            <div class="row">
                @include('frontend.layouts.sidebar', ['menu' => ''])
                <!-- Page content-->
                <div class="col-lg-9 col-md-12 mb-5">
                    <!-- Breadcrumb-->
                    <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{!empty($estate)? l('ویرایش اقامتگاه') :l('ثبت اقامتگاه')}}</li>
                        </ol>
                    </nav>
                    <!-- Title-->
                    <div class="mb-4">
                        <h1 class="h2 mb-0">{{!empty($estate)? l('ویرایش اقامتگاه') :l('ثبت اقامتگاه')}}</h1>
                    </div>


                <form  enctype="multipart/form-data" id="js_form_add_state" action="<?php echo empty($estate) ? '/rental/estate/store' : '/rental/estate/update/' . $estate->id ?>" method="post">
                    @csrf
                    <input type="hidden" name="default_image" id="default_image">
                    <input type="hidden" id="estatelatitude" value="{{!empty($estate)?$estate->latitude:''}}">
                    <input type="hidden" id="estatelongitude" value="{{!empty($estate)?$estate->longitude:''}}">
                    <input type="hidden" name="latitude"  id="latitude" value="{{!empty($estate)?$estate->latitude:''}}">
                    <input type="hidden" name="longitude" id="longitude" value="{{!empty($estate)?$estate->longitude:''}}">
                    <input type="hidden" name="latitude_secondary" id="latitude_secondary">
                    <input type="hidden" name="longitude_secondary" id="longitude_secondary">
                    <input type="hidden" name="esatateid" id="esatateid" value='{{!empty($estate)?$estate->id:""}}'>


                <section class="card card-body shadow-sm p-4 mb-4" id="location">
                    <h2 class="h5 mb-4"><i class="fi-map-pin text-primary fs-5 mt-n1 me-2"></i>{{ l('آدرس اقامتگاه') }}</h2>
                    <div class="text-gray-500 text-[14px] font-light mb-3">
                        {{ l('آدرس اقامتگاه را با جزییات کامل وارد کنید تا میهمان پس از رزرو به راحتی بتوانند اقامتگاه را پیدا کنند.') }}
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-price">{{ l('شهر') }}<span class="text-danger">*</span></label>
                            <select class="form-select  select2"  name="city_id" id="city_id">
                                <option value="" disabled>{{l('شهر')}}</option>
                                @foreach($cities as $ci)
                                <option value="{{$ci->id}}" {{!empty($estate) && $estate->city_id == $ci->id ? 'selected' :''}}>{{$ci->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="hide_cityId" value="{{!empty($estate)?$estate->city_id:''}}"/>


                        <div class="col-sm-12 col-md-9  mb-3">
                            <label class="form-label fw-bold" for="ap-address">{{l('آدرس ')}} </label>
                            <textarea style="width:100%" class="necessary form-control" type="text" id="ap-address" name="address" >{{!empty($estate)?($estate->address):""}}</textarea>

                        </div>
                    </div>
                    <div class="necessary form-label fw-bold pt-3 pb-2">{{ l('انتخاب موقعیت در نقشه') }}</div>
                    <div class="text-gray-500 text-[14px] font-light mb-3">
                        {{ l('موقعیت مکانی (لوکیشن) را به دقت مشخص کنید.') }}
                        <br>
                        {{ l('لوکیشن ثبت شده برای مسیریابی به مهمانان ارسال می‌شود. طبق ضمانت تحویل گیلندملک، هرگونه مغایرت می‌تواند باعث لغو رزرو و عودت وجه به مهمان شود.') }}
                    </div>
                    <div class="necessary rounded-3"  id="estate-map" style="height: 400px;"></div>
                </section>
                <section class="card card-body shadow-sm p-4 mb-4" id="location">
                    <h2 class="h5 mb-4"><i class="fi-map-pin text-primary fs-5 mt-n1 me-2"></i>{{ l('فضای اقامتگاه') }}</h2>
                    <div class="row">
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-type">{{ l('نوع اقامتگاه') }}<span class="text-danger">*</span></label>
                            <select class="form-select"  name="estate_type" id="estate_type" required  >
                                @foreach (estateTypesRental() as $key=>$val)
                                <option value="{{$key}}" {{!empty($estate)?($estate->estate_type==$key ? 'selected':''):""}}>{{$val}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="hide_estate_type" value="{{!empty($estate)?$estate->estate_type:''}}"/>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-location">{{ l('منطقه اقامتگاه') }}</label>
                            <select class="form-select" name="position_type">
                                <option value=""></option>
                                <option value="292" {{!empty($estate)?($estate->position_type==292?'selected':''):''}}>{{ l('ساحلی') }}</option>
                                <option value="293" {{!empty($estate)?($estate->position_type==293?'selected':''):''}}>{{ l('جنگلی') }}</option>
                                <option value="266" {{!empty($estate)?($estate->position_type==266?'selected':''):''}}>{{ l('بر خیابان اصلی') }}</option>
                                <option value="267" {{!empty($estate)?($estate->position_type==267?'selected':''):''}}>{{ l('داخل کوچه') }}</option>
                                <option value="268" {{!empty($estate)?($estate->position_type==268?'selected':''):''}}>{{ l('کنار جاده') }}</option>
                                <option value="294" {{!empty($estate)?($estate->position_type==294?'selected':''):''}}>{{ l('داخل محدوده شهری') }}</option>
                                <option value="295" {{!empty($estate)?($estate->position_type==295?'selected':''):''}}>{{ l('خارج محدوده شهری') }}</option>
                                <option value="365" {{!empty($estate)?($estate->position_type==365?'selected':''):''}}>{{ l('ییلاقی') }}</option>

                            </select>
                        </div>
                    </div>
                </section>
                <section class="card card-body shadow-sm p-4 mb-4" id="location">
                    <h2 class="h5 mb-4"><i class="fi-map-pin text-primary fs-5 mt-n1 me-2"></i>{{ l('ظرفیت اقامتگاه') }}</h2>
                    <div class="row">
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-meterage">{{ l('متراژ زمین و محوطه اقامتگاه') }}<span class="text-danger">*</span></label>
                            <div class="d-sm-flex">
                                <input class="necessary form-control w-100 mb-2 js_valid_number_float required  number" type="tel"  value="{{old('area',!empty($estate)?$estate->area:'')}}"  id="area" name="area" >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-meterage">{{l('مساحت زیربنا')}} </label>
                            <div class="d-sm-flex">
                                <input class="form-control w-100 mb-2 js_valid_number_float number" type="tel"  value="{{old('built_area',!empty($estate)?$estate->built_area:'')}}"   id="built_area" name="built_area">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-room"> {{l('تعداد اتاق')}} </label>
                            <select class="necessary form-select" id="room_count" name="room_count">
                                <option value="" disabled selected>{{l('انتخاب')}} </option>
                                <option value="186" {{!empty($estate)?($estate->room_count==186?'selected':''):''}}>{{ l('سوئیت') }}</option>
                                <option value="187" {{!empty($estate)?($estate->room_count==187?'selected':''):''}}>1</option>
                                <option value="188" {{!empty($estate)?($estate->room_count==188?'selected':''):''}}>2</option>
                                <option value="189" {{!empty($estate)?($estate->room_count==189?'selected':''):''}}>3</option>
                                <option value="190" {{!empty($estate)?($estate->room_count==190?'selected':''):''}}>4</option>
                                <option value="191" {{!empty($estate)?($estate->room_count==191?'selected':''):''}}>{{l('بیشتر از')}} 4</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-location">{{ l('حداکثر افراد مجاز') }}</label>
                            <input class="form-control digits"  id="max_person" name="max_person" value="{{!empty($estate)?$estate->max_person:''}}" />
                        </div>
                    </div>
                </section>
                <section class="card card-body shadow-sm p-4 mb-4" id="details">
                    <h2 class="h5 mb-4"><i class="fi-edit text-primary fs-5 mt-n1 me-2"></i>{{ l('مقررات اقامتگاه') }}</h2>
                    <div class="row">
                        <label class="form-label fw-bold" for="ap-location">{{ l('مقررات لغو رزرو') }}</label>
                        <div class="sc-de3ce021-0 jhTTtj">
                            <p class="sc-795c56f4-0 aclcz">{{ l('مقررات سه گانه لغو رزرو را مطالعه کنید و سپس سیاست لغو مناسب شرایط اقامتگاه خود را از میان 3 گزینه زیر، انتخاب کنید:') }}</p>
                            <div class="mb-4">
                                <input name="sale_priority" type="radio"  value="1"  {{!empty($estate)?($estate->sale_priority==1?'checked':''):'checked'}}> {{ l('سیاست سهلگیرانه: در صورتی که رزرو، بیش از ۲۴ ساعت از تاریخ ورود لغو گردد میزبان دریافتی ندارد. درصورت لغو کمتر از 24 ساعت به تاریخ ورود، اجاره شب اول به میزبان پرداخت می شود.') }}
                            </div>
                            <div class="mb-4">
                                <input name="sale_priority" type="radio" value="2"  {{!empty($estate)?($estate->sale_priority==2?'checked':''):''}}> {{ l('سیاست متعادل: در صورتی که رزرو, بیش از 3 روز کامل از تاریخ ورود لغو گردد, میزبان دریافتی ندارد. درصورت لغو کمتر از 3 روز به تاریخ ورود، اجاره شب اول به میزبان پرداخت می شود.') }}
                            </div>
                            <div class="mb-4">
                                <input name="sale_priority" type="radio" value="3"  {{!empty($estate)?($estate->sale_priority==3?'checked':''):''}}> {{ l('سیاست سختگیرانه: در صورتی که رزرو, بیش از 5 روز کامل از تاریخ ورود لغو گردد, 10% صورتحساب به میزبان پرداخت می‏شود. درصورت لغو کمتر از 5 روز به تاریخ ورود، اجاره شب اول بعلاوه 40 درصد از شب‌های باقیمانده به میزبان پرداخت می شود.') }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="form-label fw-bold" for="ap-location">{{ l('مقررات اقامتگاه') }}</label>
                        <div class="col-12 mb-4">
                            <div class="form-check">
                                <input class="form-check-input"  id="condition361" value="361" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,361):""}} name="conditions[]">
                                <label class="form-check-label">{{ l('برگزاری جشن و پخش موزیک') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="form-check">
                                <input class="form-check-input"  id="condition362" value="362" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,362):""}} name="conditions[]">
                                <label class="form-check-label">{{ l('همراه داشتن حیوان خانگی') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <div class="form-check ">
                                <input class="form-check-input"  id="condition363" value="363" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,363):""}} name="conditions[]">
                                <label class="form-check-label">{{ l('استعمال دخانیات (سیگار، قلیان و ...) در فضای داخلی ساختمان') }}</label>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="card card-body shadow-sm p-4 mb-4" id="details">
                    <h2 class="h5 mb-4"><i class="fi-edit text-primary fs-5 mt-n1 me-2"></i>{{ l('اجاره بها') }}</h2>
                    <div class="row">
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-price">{{ l('وسط هفته') }}<span class="text-danger">*</span></label>
                            <div class="d-sm-flex">
                                <input class="form-control w-100 me-2 mb-2 number js_number necessary " onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"  value="{{old('rent',!empty($estate)?$estate->rent:'')}}" type="text"  id="rent" name="rent"  >
                            </div>
                            <div id="divrent"  class="w-100"></div>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-price">{{ l('آخر هفته و ایام پیک') }}<span class="text-danger">*</span></label>
                            <div class="d-sm-flex">
                                <input class="form-control w-100 me-2 mb-2 number js_number necessary " type="text" onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"   id="mortgage" name="mortgage" value="{{old('mortgage',!empty($estate)?$estate->mortgage:'')}}"  >
                            </div>
                            <div id="divmortgage"  class="w-100"></div>
                        </div>
                    </div>
                </section>
                <section class="card card-body shadow-sm p-4 mb-4" id="details">
                    <h2 class="h5 mb-4"><i class="fi-edit text-primary fs-5 mt-n1 me-2"></i>{{ l('امکانات') }}</h2>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="text-gray-500 text-[14px] font-light mb-3">
                                {{ l('امکانات و تجهیزات موجود در اقامتگاه خود را مشخص کنید') }}
                            </div>
                            <div class="row">
                                <label class="form-label d-block fw-bold mb-2 pb-1">{{l('امکانات')}} </label>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" name="facilities[]" value="352" type="checkbox" id="closedoor" {{!empty($estate)?checkValueCreate($estate->facilities,352):""}}>
                                        <label class="form-check-label" for="closedoor">{{l('دربست')}} </label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check">
                                        <input class="form-check-input" name="facilities[]" value="35" type="checkbox" id="parking" {{!empty($estate)?checkValueCreate($estate->facilities,35):""}}>
                                        <label class="form-check-label" for="parking">{{l('پارکینگ')}} </label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check ">
                                        <input class="form-check-input" name="facilities[]" value="37" type="checkbox" id="hair-dryer" {{!empty($estate)?checkValueCreate($estate->facilities,37):""}}>
                                        <label class="form-check-label" for="hair-dryer">{{l('آسانسور')}}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check ">
                                        <input class="form-check-input" name="facilities[]" value="39" type="checkbox" id="swimming-svgrepo-com" {{!empty($estate)?checkValueCreate($estate->facilities,39):""}}>
                                        <label class="form-check-label" for="swimming-svgrepo-com">{{ l('استخر') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check ">
                                        <input class="form-check-input" name="facilities[]" value="40" type="checkbox" id="sauna-svgrepo-com" {{!empty($estate)?checkValueCreate($estate->facilities,40):""}}>
                                        <label class="form-check-label" for="sauna-svgrepo-com">{{ l('سونا') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check ">
                                        <input class="form-check-input" name="facilities[]" value="41" type="checkbox" id="person-enjoying-jacuzzi-hot-water-bath-svgrepo-com" {{!empty($estate)?checkValueCreate($estate->facilities,41):""}}>
                                        <label class="form-check-label" for="person-enjoying-jacuzzi-hot-water-bath-svgrepo-com">{{ l('جکوزی') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check ">
                                        <input class="form-check-input" name="facilities[]" value="356" type="checkbox" id="internet-connection-svgrepo-com" {{!empty($estate)?checkValueCreate($estate->facilities,356):""}}>
                                        <label class="form-check-label" for="internet-connection-svgrepo-com">{{ l('اینترنت') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check ">
                                        <input class="form-check-input" name="facilities[]" value="357" type="checkbox" id="grill-svgrepo-com" {{!empty($estate)?checkValueCreate($estate->facilities,357):""}}>
                                        <label class="form-check-label" for="grill-svgrepo-com">{{ l('کباب پز') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check ">
                                        <input class="form-check-input" name="facilities[]" value="358" type="checkbox" id="furniture-svgrepo-com" {{!empty($estate)?checkValueCreate($estate->facilities,358):""}}>
                                        <label class="form-check-label" for="furniture-svgrepo-com">{{ l('مبلمان') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check ">
                                        <input class="form-check-input" name="facilities[]" value="359" type="checkbox" id="bath-and-shower-svgrepo-com" {{!empty($estate)?checkValueCreate($estate->facilities,359):""}}>
                                        <label class="form-check-label" for="bath-and-shower-svgrepo-com">{{ l('حمام') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check ">
                                        <input class="form-check-input" name="facilities[]" value="360" type="checkbox" id="tap-water-drink-water-tap-svgrepo-com" {{!empty($estate)?checkValueCreate($estate->facilities,360):""}}>
                                        <label class="form-check-label" for="tap-water-drink-water-tap-svgrepo-com">{{ l('آب لوله کشی') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check ">
                                        <input class="form-check-input" name="facilities[]" value="54" type="checkbox" id="negahban" {{!empty($estate)?checkValueCreate($estate->facilities,54):""}}>
                                        <label class="form-check-label" for="negahban">{{ l('نگهبانی') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 ">
                                    <div class="form-check ">
                                        <input class="form-check-input" name="facilities[]" value="72" type="checkbox" id="alachigh" {{!empty($estate)?checkValueCreate($estate->facilities,72):""}}>
                                        <label class="form-check-label" for="alachigh">{{ l('آلاچیق') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="row">
                                <label class="form-label d-block fw-bold">{{ l('سیستم سرمایش و گرمایش') }}
                                </label>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input"  id="heating_cooling86" value="86" type="checkbox" {{!empty($estate)?checkValueCreate($estate->heating_cooling,86):""}} name="heating_cooling[]">
                                        <label class="form-check-label" for="heater">{{ l('بخاری') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="heating_cooling90" value="90" type="checkbox" {{!empty($estate)?checkValueCreate($estate->heating_cooling,90):""}} name="heating_cooling[]">
                                        <label class="form-check-label" for="chiller">{{ l('چیلر') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="heating_cooling92" value="92" type="checkbox" {{!empty($estate)?checkValueCreate($estate->heating_cooling,92):""}} name="heating_cooling[]">
                                        <label class="form-check-label" for="water_cooler">{{ l('کولر گازی') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="heating_cooling102" value="102" type="checkbox" name="heating_cooling[]" {{!empty($estate)?checkValueCreate($estate->heating_cooling,102):""}}>
                                        <label class="form-check-label" for="wall_water_heater">{{ l('آب گرمکن') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="heating_cooling95" value="95" type="checkbox" name="heating_cooling[]" {{!empty($estate)?checkValueCreate($estate->heating_cooling,95):""}}>
                                        <label class="form-check-label">{{ l('موتورخانه مرکزی') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="heating_cooling88" value="88" type="checkbox" {{!empty($estate)?checkValueCreate($estate->heating_cooling,88):""}} name="heating_cooling[]">
                                        <label class="form-check-label" for="package">{{ l('پکیج') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="heating_cooling94" value="94" type="checkbox" name="heating_cooling[]" {{!empty($estate)?checkValueCreate($estate->heating_cooling,94):""}}>
                                        <label class="form-check-label" for="air_conditioner"> {{ l('کولر آبی') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="heating_cooling96" value="96" type="checkbox" name="heating_cooling[]" {{!empty($estate)?checkValueCreate($estate->heating_cooling,96):""}}>
                                        <label class="form-check-label" for="fireplace">{{ l('شومینه') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="heating_cooling89" value="89" type="checkbox" {{!empty($estate)?checkValueCreate($estate->heating_cooling,89):""}} name="heating_cooling[]">
                                        <label class="form-check-label" for="fan">{{ l('فن کوئل') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="heating_cooling93" value="93" type="checkbox" name="heating_cooling[]" {{!empty($estate)?checkValueCreate($estate->heating_cooling,93):""}}>
                                        <label class="form-check-label" for="duck_split">{{ l('داکت اسپیلت') }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="heating_cooling97" value="97" type="checkbox" name="heating_cooling[]" {{!empty($estate)?checkValueCreate($estate->heating_cooling,97):""}}>
                                        <label class="form-check-label" for="underfloor_heating"> {{ l('گرمایش از کف') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="heating_cooling87" value="87" type="checkbox" name="heating_cooling[]" {{!empty($estate)?checkValueCreate($estate->heating_cooling,87):""}}>
                                        <label class="form-check-label" for="underfloor_heating">{{ l('رادیات') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <label class="form-label d-block fw-bold">
                            {{ l('نوع سرویس بهداشتی') }} </label>
                            <select class="form-select" name="wc" id="js_wc">
                                <option value="" disabled selected> </option>
                                <option value="104" title="{{ l('سرویس') }}" {{!empty($estate)?($estate->wc==104?'selected':''):''}}>{{ l('ایرانی') }}</option>
                                <option value="105" title="{{ l('سرویس') }}" {{!empty($estate)?($estate->wc==105?'selected':''):''}}>{{ l('فرنگی') }}</option>
                                <option value="106" title="{{ l('سرویس') }}" {{!empty($estate)?($estate->wc==106?'selected':''):''}}>{{ l('ایرانی-فرنگی') }}</option>
                            </select>
                        </div>
                    </div>
                </section>
                <section class="card card-body shadow-sm p-4 mt-4" id="photos">
                    <h2 class="h5 mb-4"><i class="fi-edit text-primary fs-5 mt-n1 me-2"></i>{{ l('درباره اقامتگاه') }}</h2>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="text-gray-500 text-[14px] font-light mb-3">
                                {{ l('در اینجا نکاتی را که میهمان شما باید بداند بنویسید، از نقاط قوت و ضعف اقامتگاه، بعنوان مثال از تعداد زیاد پله ها که برای سالمندان مناسب نیست و ورودی تنگ پارکینگ، از چشم انداز زیبای منزل یا از جاذبه های گردشگری ‏اطراف همچون ساحل دریا/رودخانه/کوهستان/ اماکن تاریخی/بازار محلی بگویید و فاصله اقامتگاه از هر یک را بنویسید. وجود فروشگاههای مواد غذایی و نانوایی در مجاورت منزل خود را مشخص ‏کنید.‏‎ از حال و هوای محله و رفتار احتمالی همسایه ها بنویسید. هر آنچه میهمان شما لازم است بداند را اینجا بنویسید.‏‎') }}
                            </div>
                            <textarea  name="description" id="desc-state" class="js_input_max form-control mb-3 " rows="5" placeholder="{{l('ملک خود را شرح دهید')}}">{{old('description',!empty($estate)?$estate->description:'')}}</textarea>

                        </div>
                    </div>
                </section>
                <section class="card card-body shadow-sm p-4 mt-4" id="photos">
                    <h2 class="h5 mb-4"><i class="fi-camera-plus text-primary fs-5 mt-n1 me-2"></i>{{ l('تصاویر اقامتگاه') }}</h2>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="text-gray-500 text-[14px] font-light mb-3">
                                {{ l('ارائه تصاویر زیبا و واقعی از اقامتگاه شما می تواند نقش بسیار مهمی در جلب نظر میهمانان ایفا نماید.‏‎‏ لذا:') }}<ul style="list-style-type: disc; padding-right: 1rem;"><li>{{ l('حداقل 10 عکسِ باکیفیت، از پذیرایی، اتاق خواب ها، آشپزخانه، سرویس بهداشتی، حیاط و نمای ساختمان آپلود کنید.') }}</li><li>{{ l('ترجیحاً از تصاویر افقی (Landscape) استفاده کنید.') }}</li></ul>
                            </div>
                        <!-- Photos / video-->
                            <div class=" my-4" id="photos">
                                {{-- current images --}}
                                <?php
                                if(!empty($estate)){
                                    $imageCount = $estate->images->count();
                                    if($estate->images->count() > 0){
                                        ?>
                                    <div id="images" class=" card mb-3">
                                        <div class="border-bottom card-header">
                                            <strong class="mb-0">{{l('تصاویر فعلی')}}</strong>
                                        </div>
                                        <div class="card-body align-content-center align-items-center d-flex flex-row flex-wrap justify-content-around">
                                            @foreach($estate->images->where("360","=",0)->where("plan","=",0)->where("hidden","=",0) as $item)
                                                <div id="media-{{$item->id}}" data-id="{{$item->id}}" class="card p-1 rounded dz-preview {{$defaultImage && $defaultImage->id == $item->id ? 'img-cover' : ''}}"
                                                >
                                                    <div class="mb-0 est-container">
                                                    <div class="middle">
                                                                <div class="text bg-primary rounded"><i class="fi fi-check"></i></div>
                                                            </div>
                                                            <img src="/upload/images/estate/{{ $item->url() }}" class="w-100 est-img" style="height:250px;margin-bottom:10px">
                                                    </div>
                                                    <button type="button" data-toggle="tooltip" title="{{l('حذف')}}" data-id="{{$item->id}}"
                                                            id="itemID-{{$item->id}}" data-name="{{$item->name}}"
                                                            data-route="images" class="btn btn-danger remove-img rounded-0">
                                                        <i class="d-inline fa fa-trash me-2"></i>{{l('حذف')}}
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <?php
                                    }
                                }
                                ?>
                                    <div id="img-upload" class="dropzone uploader text-center dz-clickable rounded mb-2" data-bs-toggle="dropzone" style="width: 100%;z-index:0">
                                        <div class="dz-message" data-dz-message="" style="width:120px;height:120px;border:1px solid;border-radius:25%;padding-top:35px">
                                            <i class="text-[50px] text-gray-500 fa-thin fa-camera" style="font-size:25px"></i>
                                            <div class="uploader-text">
                                                <span class="text-[16px] text-gray-500 font-light">{{ l('انتخاب تصویر') }}</span>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>

                        </div>
                    </section>
                    <section class="card card-body shadow-sm p-4 mt-4" id="photos">
                        <h2 class="h5 mb-4"><i class="fi-camera-plus text-primary fs-5 mt-n1 me-2"></i>{{ l('مدارک مالکیت') }}</h2>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="text-gray-500 text-[14px] font-light mb-3">
                                    <p class="sc-795c56f4-0 aclcz">{{ l('برای سرعت بخشیدن به فرایند ثبت اقامتگاه حتما') }}

                                        <span class="sc-795c56f4-0 kmtndF">{{ l('تصویر مدارک مالکیت را آپلود نمایید') }}</span>
                                    </p>
                                    <p class="sc-795c56f4-0 fXxjl">{{ l('سند مالکیت یا قولنامه را آپلود نمایید:') }}</p>
                                    <p class="sc-795c56f4-0 hwsLtd sc-ba38449c-0 elZhJZ"><li>{{ l('تصویر می‌باید با کیفیت مناسب و واضح باشد') }}</li></p>
                                </div>
                                <div class="my-4" id="photos">
                                    {{-- current images --}}
                                    <?php
                                    if($estate!=null && $currentUser->isExpert()){
                                        $imageCount = $estate->images->count();
                                        if($estate->images->count() > 0){
                                            ?>
                                        <div id="images" class=" card mb-3">
                                            <div class="border-bottom card-header">
                                                <strong class="mb-0">{{l('تصاویر فعلی')}}</strong>
                                            </div>
                                            <div class="card-body align-content-center align-items-center d-flex flex-row flex-wrap justify-content-around">
                                                @foreach($estate->images->where("hidden","=",1) as $item)
                                                    <div id="media-{{$item->id}}" data-id="{{$item->id}}" class="card p-1 rounded dz-preview ">
                                                        <div class="mb-0 est-container">
                                                        <div class="middle">
                                                                    <div class="text bg-primary rounded"><i class="fi fi-check"></i></div>
                                                                </div>
                                                                <img src="/upload/images/estate/{{ $item->url() }}" class="w-100 est-img" style="height:250px;margin-bottom:10px">
                                                        </div>
                                                        <button type="button" data-toggle="tooltip" title="{{l('حذف')}}" data-id="{{$item->id}}"
                                                                id="itemID-{{$item->id}}" data-name="{{$item->name}}"
                                                                data-route="images" class="btn btn-danger remove-img rounded-0">
                                                            <i class="d-inline fa fa-trash me-2"></i>{{l('حذف')}}
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <?php
                                        }
                                    }
                                    ?>
                                    <div id="img-uploadhidden" class="dropzone uploader text-center dz-clickable rounded mb-2" data-bs-toggle="dropzone" style="width: 100%;z-index:0;display:table">
                                        <div class="dz-message" data-dz-message="" style="width:120px;height:120px;border:1px solid;border-radius:25%;padding-top:35px">
                                            <i class="text-[50px] text-gray-500 fa-thin fa-camera" style="font-size:25px"></i>
                                            <div class="uploader-text">
                                                <span class="text-[16px] text-gray-500 font-light">{{l('تصاویر')}}</span>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </section>

                    <section class="card card-body shadow-sm p-4 mt-4" id="basic-info">
                        <h2 class="h5 mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>{{l('اطلاعات پایه')}}
                        (مالکیت)
                        </h2>
                        <div class="row">

                            @if ($currentUser->isAdmin())
                                @if(!empty($estate) && $estate->expert !== null && $estate->expert->fullname() !== null)
                                <div class="col-sm-6 col-md-3 mb-3">
                                    <label class="form-label fw-bold" for="ap-max-buy">{{ l('انتخاب موجر') }}</label>
                                    <select class="form-control select2" name="expert_id" id="expertid" style="width: 100%;" dir="rtl">
                                        <option value="">{{ l('انتخاب کنید') }}</option>
                                        @foreach($users as $item)
                                            <option value="{{$item->id}}" {{!empty($estate) && $estate->expert_id == $item->id  ? "selected" :''}}>{{$item->fullname()}} - {{$item->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @else

                                <div class="col-sm-6 col-md-3 mb-3">
                                    <label class="form-label fw-bold" for="ap-owner_name"> {{ l('نام مالک اقامتگاه') }}
                                    <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" value="{{!empty($estate)?$estate->owner_name:''}}"  id="owner_name" name="owner_name" required/>
                                </div>
                                <div class="col-sm-6 col-md-3 mb-3">
                                    <label class="form-label fw-bold" for="ap-tel"> {{l('شماره تماس')}} ({{l('مالک')}})</label>
                                    <input class="form-control js_valid_number number" placeholder="09103511135" type="tel" value="{{!empty($estate)?$estate->phone:''}}" required maxlength="11" minlength="11"   name="phone" id="phone" />
                                </div>
                                @endif
                            @elseif($currentUser->isRenter() || !empty($estate))
                                @if(empty($estate))
                                <input type="hidden" name="expert_id" value="{{$currentUser->id}}">
                                @endif

                            @else
                            <div class="text-gray-500 text-[14px] font-light mb-3">
                                {{ l('برای تکمیل اطلاعات مالک به صفحه ویرایش پروفایل منتقل می شوید') }}
                            </div>
                            <div class="col-sm-6 col-md-3 mb-3">
                                <label class="form-label fw-bold" for="ap-owner_name"> {{ l('نام مالک اقامتگاه') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="necessary form-control" type="text" value="{{!empty($estate)?$estate->owner_name:$currentUser->last_name}}"  id="owner_name" name="owner_name" required/>
                            </div>

                            @endif
                            @if ($currentUser->isAdmin() )
                                @if(empty($estate))
                                <input type="hidden" name="confirmation" value="verified">
                                @else
                                <div class="col-sm-6 col-md-3 mb-3">
                                    <label class="form-label fw-bold" for="ap-max-buy">{{ l('وضعیت ملک') }}</label>
                                    <select class="form-control" name="confirmation" id="confirmation" style="width:100%">
                                        <option value="verified" {{!empty($estate) && $estate->confirmation == "verified" ? 'selected' :''}}>{{ l('جاری') }}</option>
                                        <option value="rejected" {{!empty($estate) && $estate->confirmation == "rejected" ? 'selected' :''}}>{{l('آرشیو شده')}}</option>
                                    </select>
                                </div>

                            @endif
                            <div class="col-sm-6 col-md-3 mb-3">
                                <label class="form-label fw-bold" for="ap-category">
                                    {{l('اکازیون')}}
                                </label>
                                <select class="form-select"  name="special" id="special">
                                    <option value="0" {{!empty($estate)?($estate->special==0?'selected':''):"selected"}}>{{l('خیر')}}</option>
                                    <option value="1" {{!empty($estate)?($estate->special==1?'selected':''):""}}>{{l('بله')}}</option>
                                </select>
                            </div>
                            @endif


                        </div>
                    </section>
                    <!-- Action buttons -->
                    <section class="d-sm-flex justify-content-between pt-2 my-4">
                        <button type="submit" class="btn btn-primary btn-lg d-block mb-2" >
                            {{!empty($estate)? l('ویرایش اقامتگاه') :l('ثبت اقامتگاه')}}
                        </button>
                    </section>
                    <input type="hidden" id="js_csrf_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="js_estates_storeMedia" value="{{ route('estates.storeMedia') }}">

                </form>
            </div>
            </div>
        </div>
    </main>
    @include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
    <script src="/vendor/jquery-3.6.0.js"></script>
    <script src="/vendor/persian-datepicker/persian-date.min.js" ></script>
    <script src="/vendor/persian-datepicker/persian-datepicker.min.js" ></script>
    <script src="/vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="/vendor/cleave.js/dist/cleave.min.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <!-- Main theme script-->
    <script src="/js/theme.min.js"></script>
    <script src="/frontend/js/modules/leaflet/leaf.js"></script>
    <script src="/frontend/js/modules/leaflet/leaflet.draw-src.js"></script>
    <script src="/admin2/dist/js/regions.js"></script>
    <script>
        // delete image
$(".remove-img").on("click", function () {
    var estateId = '{{!empty($estate)?$estate->id:''}}';
    var id = $(this).data('id');
    swal({
        text: " {{l('آیا از حذف گزینه مورد نظر اطمینان دارید')}} ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "{{l('لغو')}}",
        confirmButtonText: "{{l('بله')}}",
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    url: '/estates/media/' + id,
                    type: 'DELETE',
                    data: {_token: '{{csrf_token()}}',estate_id:estateId},
                    dataType: 'json'
                })
                    .done(function (response) {
                        swal({
                            title: "",
                            text: "{{l('گزینه مورد نظر با موفقیت حذف شد')}}.",
                            type: 'success',
                            allowOutsideClick: false,
                        }).then((result)=>{
                            $('#images #media-'+id).remove();
                    });
                    })
                    .fail(function () {
                        swal("{{l('خطا')}}!", "{{l('حذف با مشکل مواجه شد')}}!", 'error');
                    });
            });
        },
        allowOutsideClick: ()=>!swal.isLoading()
    });
});
        var i=0;
        $("#create").click(function(){
            i=i+1;
             $("#appendimage").append('<div class="form-group gap-3">'+
                        '<input class="hidden js_National_card_upload" type="file" id="js_National_card_upload'+(i)+'" name="js_National_card_upload[]" class="dropify" accept="image/*" data-max-file-size="5M">'+
                        '<label  class="btn btn-info labelupload"  for="js_National_card_upload'+(i)+'">'+
                            ' {{l("آپلود فایل")}} '+
                        '</label>'+
                        '<input type="text" name="title1[]" class="w-100 border rounded-1 p-2" style="height:42px" placeholder="{{l('عنوان عکس')}}">'+
                        '<label class="del btn btn-link">{{l('حذف')}}</label>'+
                    '</div>'
                    );
        })
        $('.select2').select2();
        function map(posx , posy) {
            var defaultZoom = 10;
            var defaultLocation = [posx, posy]; //tehran azadi
            var map = $('#estate-map').kamaMap({
                zoom: defaultZoom,
                maxZoom: 18,
                click_zoom: 14,
                zoomControl: true,
                lat: defaultLocation[0],
                lng: defaultLocation[1]
            });
            map.clickMap(true, function(e) {
                $('input[name="latitude"]').val(e.markerPoint[0]);
                $('input[name="longitude"]').val(e.markerPoint[1]);
                $('input[name="latitude_secondary"]').val(e.circlePoint[0]);
                $('input[name="longitude_secondary"]').val(e.circlePoint[1]);
            });
            // map.showCircle(x,y);
        }
        function mapedit(x,y){
            var defaultZoom=13;
            var defaultLocation= [x,y];//tehran azadi
                var map = $('#estate-map').kamaMap({zoom:14,maxZoom:18,click_zoom:14,zoomControl:true,lat:defaultLocation[0],lng:defaultLocation[1]});
                map.clickMap(true,function(e){
                    $('input[name="latitude"]').val(e.markerPoint[0]);
                    $('input[name="longitude"]').val(e.markerPoint[1]);
                    $('input[name="latitude_secondary"]').val(e.circlePoint[0]);
                    $('input[name="longitude_secondary"]').val(e.circlePoint[1]);
                });
            map.showCircle(x,y);
        }
        $(document).ready(function() {
            $("#evacuationdate").pDatepicker({
            initialValue: false,
            format: 'YYYY-MM-DD'
            });
            @if($city->posx != '' && $city->posy != '')
            map({{$city->posx}}, {{$city->posy}});
            @endif
            getCities();
            getDistricts();
            @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || ss('SITE_ID') == 4)
                getStreets();
            @endif
        });
    </script>
@endsection
@section('js')
<script src="{{asset('/frontend/vendor/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>
<script src="{{asset('/assets/js/valid.js')}}"></script>
<script>


    if($("#estatelatitude").val().length>0){
        mapedit($("#estatelatitude").val(), $("#estatelongitude").val());
    }
     if($("#hide_cityId").val().length>0){
        $("#city_id").val($("#hide_cityId").val()).trigger("change");
     }
    if($("#hide_estate_type").val().length>0){
        $("#estate_type").val($("#hide_estate_type").val()).trigger("change");
    }
    $("#estate_type").change(function(){
        $(".metrajbar").addClass("d-none");
        $(".metrajzir").addClass("d-none");
        if($(this).val()==2 || $(this).val()==4){
            $(".metrajbar").removeClass("d-none");
        }
        if($(this).val()==2){
            $(".metrajzir").removeClass("d-none");
        }
        //changeaccess();
    });

    $(document).ready(function() {

        //changeaccess();
        $("#condition1").change(function(){
            $(".year-build").show();
            var spl= $(this).val().toString().split(',');
            if(jQuery.inArray("251", spl) !== -1)
            {
                $(".year-build").hide();
            }
        })
        $("#appendimage").on('click','.del',function(){
            $(this).parent().remove();
        });
        $("#appendimage").on('change','.js_National_card_upload',function(){
            $(this).parent().find('.labelupload').html("{{l('بارگزاری شد')}}");
            $(this).parent().find('.labelupload').css("background","red");
        })
    });
    function OnlyNumber(event,HasBullet){
        if(HasBullet){
            var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,<>+\/?-]/;
        }
        else{
            var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,.<>+\\/?-]/; } var key = String.fromCharCode(!event.charCode ? event.which : event.charCode); if (blockSpecialRegex.test(key)) { event.preventDefault(); } } function toEnglishNumber(strNum) { var pn = ["۰", l("۱"), l("۲"), l("۳"), l("۴"), l("۵"), l("۶"), l("۷"), l("۸"), l("۹")]; var en = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]; var cache = strNum; for (var i = 0; i < 10; i++) {
            //var regex_fa = new RegExp(pn[i], 'g');
            cache = cache.replace(pn[i], en[i]);
        }
        return cache;
    }
    "use strict";var delimiter=l("و"),zero=l("صفر"),negative=l("منفی"),letters=[["",l("یک"),l("دو"),l("سه"),l("چهار"),l("پنج"),l("شش"),l("هفت"),l("هشت"),l("نه")],["ده",l("یازده"),l("دوازده"),l("سیزده"),l("چهارده"),l("پانزده"),l("شانزده"),l("هفده"),l("هجده"),l("نوزده"),l("بیست")],["","",l("بیست"),l("سی"),l("چهل"),l("پنجاه"),l("شصت"),l("هفتاد"),l("هشتاد"),l("نود")],["",l("یکصد"),l("دویست"),l("سیصد"),l("چهارصد"),l("پانصد"),l("ششصد"),l("هفتصد"),l("هشتصد"),l("نهصد")],["",l("هزار"),l("میلیون"),l("میلیارد"),l("بیلیون"),l("بیلیارد"),l("تریلیون"),l("تریلیارد"),l("کوآدریلیون"),l("کادریلیارد"),l("کوینتیلیون"),l("کوانتینیارد"),l("سکستیلیون"),l("سکستیلیارد"),l("سپتیلیون"),l("سپتیلیارد"),l("اکتیلیون"),l("اکتیلیارد"),l("نانیلیون"),l("نانیلیارد"),l("دسیلیون"),l("دسیلیارد")]],decimalSuffixes=["",l("دهم"),l("صدم"),l("هزارم"),l("ده‌هزارم"),l("صد‌هزارم"),l("میلیونوم"),l("ده‌میلیونوم"),l("صدمیلیونوم"),l("میلیاردم"),l("ده‌میلیاردم"),l("صد‌‌میلیاردم")],prepareNumber=function(e){var t=e;return"number"==typeof t&&(t=t.toString()),t.length%3==1?t="00".concat(t):t.length%3==2&&(t="0".concat(t)),t.replace(/\d{3}(?=\d)/g,"$&*").split("*")},tinyNumToWord=function(e){if(0===parseInt(e,0))return"";var t=parseInt(e,0);if(t<10)return letters[0][t];if(t<=20)return letters[1][t-10];if(t<100){var r=t%10,n=(t-r)/10;return r>0?letters[2][n]+delimiter+letters[0][r]:letters[2][n]}var i=t%10,u=(t-t%100)/100,s=(t-(100*u+i))/10,a=[letters[3][u]],o=10*s+i;return 0===o?a.join(delimiter):(o<10?a.push(letters[0][o]):o<=20?a.push(letters[1][o-10]):(a.push(letters[2][s]),i>0&&a.push(letters[0][i])),a.join(delimiter))},convertDecimalPart=function(e){return""===(e=e.replace(/0*$/,""))?"":(e.length>11&&(e=e.substr(0,11)),l("ممیز")+Num2persian(e)+" "+decimalSuffixes[e.length])},Num2persian=function(e){e=e.toString().replace(/[^0-9.-]/g,"");var t=!1,r=parseFloat(e);if(isNaN(r))return zero;if(0===r)return zero;r<0&&(t=!0,e=e.replace(/-/g,""));var n="",i=e,u=e.indexOf(".");if(u>-1&&(i=e.substring(0,u),n=e.substring(u+1,e.length)),i.length>66)return"خارج از محدوده";for(var s=prepareNumber(i),a=[],o=0;o<s.length;o+=1){var l=tinyNumToWord(s[o]);""!==l&&a.push(l+letters[4][s.length-(o+1)])}return n.length>0&&(n=convertDecimalPart(n)),(t?negative:"")+a.join(delimiter)+n};String.prototype.toPersianLetter=function(){return Num2persian(this)},Number.prototype.toPersianLetter=function(){return Num2persian(parseFloat(this).toString())},String.prototype.num2persian=function(){return Num2persian(this)},Number.prototype.num2persian=function(){return Num2persian(parseFloat(this).toString())};
    function SplitNumber(obj){
        var Getnumber= toEnglishNumber(obj.val()).replace(/,/g,'');
        obj.val(Getnumber.split("").reverse().join("").replace(/(.{3}\B)/g, "$1,").split("").reverse().join(""));
        @if(env('COUNTRY') != 'UAE')
        obj.parent().parent().find("#divprice").html(obj.val().num2persian()+" تومان");
        obj.parent().parent().find("#divrent").html(obj.val().num2persian()+" تومان");
        obj.parent().parent().find("#divmortgage").html(obj.val().num2persian()+" تومان");
        @endif
    }
    window.SplitNumber=SplitNumber;
        const toast = swal.mixin({
            toast: true,
            position: 'bottom-left',
            showConfirmButton: false,
            timer: 2500
        });
        var uploadedDocumentMap = {}
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone('#img-upload' , {
        uploadMultiple:false,
        acceptedFiles: ".jpeg,.jpg,.png",// "image/*"
        parallelUploads: 500,
        maxFiles:500,
        maxFilesize: 5,
        maxThumbnailFilesize: 5,
        addRemoveLinks: true,
        dictRemoveFile:"{{l('حذف')}}",
        dictCancelUpload:"{{l('لغو آپلود')}}",
        url: $('#js_estates_storeMedia').val(),
        headers: {'X-CSRF-TOKEN': $('#js_csrf_token').val()},
        type: 'POST',
        success: function (file, response) {
            file.imgID = response.name;
            $(".dz-preview:last-child").attr('data-id', file.imgID);
            $('form#js_form_add_state').append('<input type="hidden" name="document[]" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name
        },
        removedfile: function (file) {
            remove1(file.name);
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name]
            }
            $('form#add').find('input[name="document[]"][value="' + name + '"]').remove()
        },
        init: function() {
            console.log('init');
            // check file size
            this.on("maxfilesexceeded", function(file){
                this.removeFile(file);
                alert("{{l('حداکثر تعداد تصاویر 10 عدد میباشد')}}!");
            });
            this.on("error", function(file, message){
                if(message.indexOf('too big')>0){
                alert("{{l('حجم عکس بیش از 5 مگابایت می باشد')}}.");
                this.removeFile(file);
                }
                if(message=="Invalid JSON response from server."){
                this.removeFile(file);
                alert("{{l('حجم عکس بیش از 10 مگابایت می باشد')}}.");
                }
            });
            // check dimensions
            this.on("thumbnail", function (file) {
                /*if (file.height < 600 || file.width < 600) {
                    this.removeFile(file);
                    alert(l("حداقل ابعاد تصویر باید 600 در 600 باشد!"));
                }*/
            });
            // default image
            this.on("addedfile", function(file) {
                file.previewElement.addEventListener("click", function() {
                    $('#img-upload').find('.dz-preview').removeClass('img-cover');
                    $(this).addClass('img-cover');
                    var defaultImageId = $(this).attr('data-id');
                    $('input[name="default_image"]').val(defaultImageId);
                    toast({type: 'success',title: '{{l('تصویر پیش فرض تغییر یافت')}}'});
                });
            });
            if (typeof drop !== 'undefined'){
            for(var c=0;c<drop.length;c++){
                //alert();
                var mockFile = { name: drop[c][0], size: 200000 };
                this.emit("addedfile", mockFile);
                this.emit("thumbnail", mockFile, "/upload/images/estate/"+drop[c][2]);
                this.emit("complete", mockFile);
            }
        }
        },
    });
    if ($('#img-uploadhidden').length) {
    var myDropzone = new Dropzone('#img-uploadhidden' , {
        uploadMultiple:false,
        acceptedFiles: ".jpeg,.jpg,.png",// "image/*"
          parallelUploads: 1000,
          maxFiles: 1000,
          maxFilesize: 5,
          maxThumbnailFilesize: 5,
          addRemoveLinks: true,
          dictRemoveFile:"{{l('حذف')}}",
          dictCancelUpload:"{{l('لغو آپلود')}}",
        url: $('#js_estates_storeMedia').val(),
        headers: {'X-CSRF-TOKEN': $('#js_csrf_token').val()},
        type: 'POST',
        success: function (file, response) {
            file.imgID = response.name;
            $(".dz-preview:last-child").attr('data-id', file.imgID);
            $('form#js_form_add_state').append('<input type="hidden" name="documenthidden[]" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name
        },
        removedfile: function (file) {
            remove1(file.name);
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name]
            }
            $('form#add').find('input[name="documenthidden[]"][value="' + name + '"]').remove()
        },
        init: function() {
            console.log('init');
            // check file size
            this.on("maxfilesexceeded", function(file){
                this.removeFile(file);
                alert("{{l('حداکثر تعداد تصاویر 10 عدد میباشد')}}!");
            });
            this.on("error", function(file, message){
                if(message.indexOf('too big')>0){
                alert("{{l('حجم عکس بیش از 5 مگابایت می باشد')}}.");
                this.removeFile(file);
                }
                if(message=="Invalid JSON response from server."){
                this.removeFile(file);
                alert("{{l('حجم عکس بیش از 10 مگابایت می باشد')}}.");
                }
            });
            // check dimensions
            this.on("thumbnail", function (file) {
                /*if (file.height < 600 || file.width < 600) {
                    this.removeFile(file);
                    alert(l("حداقل ابعاد تصویر باید 600 در 600 باشد!"));
                }*/
            });
            // default image
            this.on("addedfile", function(file) {
            });
            if (typeof drop !== 'undefined'){
            for(var c=0;c<drop.length;c++){
                //alert();
                var mockFile = { name: drop[c][0], size: 200000 };
                this.emit("addedfile", mockFile);
                this.emit("thumbnail", mockFile, "/upload/images/estate/"+drop[c][2]);
                this.emit("complete", mockFile);
            }
        }
        },
    });
    }

    // change default image
    $('#images .dz-preview').on("click", function() {
        // current images
        $('#images').find('.dz-preview').removeClass('img-cover');
        // uploaded images
        $('#img-upload').find('.dz-preview').removeClass('img-cover');
        $(this).addClass('img-cover');
        var defaultImageId = $(this).attr('data-id');
        $('input[name="default_image"]').val(defaultImageId);
        toast({type: 'success',title: '{{l('تصویر پیش فرض تغییر یافت')}}'});
    });
    $('#images .dz-preview button').click(function(e) {
        e.stopPropagation();
    });

    function remove1(id1){
        var estateId = '{{!empty($estate)?$estate->id:''}}';
        var id = id1;
                    $.ajax({
                        url: '/estates/media/' + id,
                        type: 'DELETE',
                        data: {_token: '{{csrf_token()}}',estate_id:estateId},
                        dataType: 'json'
                    })
                        .done(function (response) {
                            /*swal({
                                title: "",
                                text: l('گزینه مورد نظر با موفقیت حذف شد.'),
                                type: 'success',
                                allowOutsideClick: false,
                            }).then((result)=>{*/
                                $('#images #media-'+id).remove();
                        /*});*/
                        })
                        .fail(function () {
                            swal("{{l('خطا')}}!", "{{l('حذف با مشکل مواجه شد')}}!", 'error');
                        });
                /*});
            },
            allowOutsideClick: ()=>!swal.isLoading()
    });*/
    }
    $('#js_form_add_state').validate({
        errorPlacement: function (error, element) {
            var type = $(element).attr('cus-valid')
            if (type == 'true') {
                error.insertAfter(element.parent().parent());
            } else {
                error.insertAfter(element)
            }
        },
    });
    function OnlyNumber(event,HasBullet){
    if(HasBullet){
        var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,<>+\/?-]/;
    }
    else{
        var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,.<>+\/?-]/;
    }
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (blockSpecialRegex.test(key))
    {
        event.preventDefault();
    }
    }
    function ReplaceAll(stri, from, to) {
    var str = stri.toString();
    var idx = str.indexOf(from);
    while (idx > -1) {
        str = str.replace(from, to);
        idx = str.indexOf(from);
    }
    return str;
    }
    $("#condition1").change(function(){
        if($(this).val()==251){
            $("#year-build").removeAttr("required");
            $("#error_built_year").remove();
        }
    })
    $("#evacuation").change(function(){
        if($(this).val()==1)
            $("#evacuationdate1").removeClass('d-none');
        else
            $("#evacuationdate1").addClass('d-none');
    });
    $('#js_singup-expert').validate({
        errorPlacement: function (error, element) {
            var type = $(element).attr('cus-valid')
            if (type == 'true') {
                error.insertAfter(element.parent().parent());
            } else {
                error.insertAfter(element)
            }
        },
    });
</script>
@endsection
