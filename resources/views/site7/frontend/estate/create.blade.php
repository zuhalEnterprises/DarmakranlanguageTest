@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',
[
    'title'=>(!empty($estate)? l('ویرایش ملک') :l('ثبت ملک'))
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
<main class="page-wrapper bg-secondary">
    @include(ss('THEME') . '.frontend.layouts.header_v2')

    <!-- Page container-->
    <div class="container mt-4 mb-md-4 py-5">
        <div class="row">
            <!-- Page content-->
            <div class="col-lg-12 add-property">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{!empty($estate)? l('ویرایش ملک') :l('ثبت ملک جدید')}}</li>
                    </ol>
                </nav>
            </div>

            <form  enctype="multipart/form-data" id="js_form_add_state" action="<?php echo empty($estate) ? '/add' : '/estates/update1/' . $estate->id ?>" method="post">
                @csrf
                <input type="hidden" name="default_image" id="default_image">
                <input type="hidden" id="estatelatitude" value="{{!empty($estate)?$estate->latitude:''}}">
                <input type="hidden" id="estatelongitude" value="{{!empty($estate)?$estate->longitude:''}}">
                <input type="hidden" name="latitude"  id="latitude" value="{{!empty($estate)?$estate->latitude:''}}">
                <input type="hidden" name="longitude" id="longitude" value="{{!empty($estate)?$estate->longitude:''}}">
                <input type="hidden" name="latitude_secondary" id="latitude_secondary">
                <input type="hidden" name="longitude_secondary" id="longitude_secondary">
                <input type="hidden" name="esatateid" id="esatateid" value='{{!empty($estate)?$estate->id:""}}'>
                <input type="hidden" name="parameters" id="parameters" value='{{!empty($estate)?$parameters:""}}'>


                <section class="card card-body p-4 mb-4" id="basic-info">
                    <h2 class="h5 mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>{{l('اطلاعات پایه')}}</h2>
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="ap-title">{{l('عنوان آگهی')}}</label>
                        <input class="form-control js_input_max" value="{{!empty($estate)?$estate->title:""}}" name="title" placeholder="{{l('عنوان آگهی')}}" />
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-category">
                                {{l('نوع معامله')}} <span class="text-danger" >*</span>
                            </label>
                            <select class="form-select"  name="type" id="deal_type" required >
                                <option value="" disabled hidden>{{l('دسته بندی')}}</option>
                                <option value="1" {{!empty($estate)?($estate->type==1?'selected':''):""}}>{{l('فروش')}}</option>
                                <option value="2" {{!empty($estate)?($estate->type==2?'selected':''):""}}>{{l('اجاره')}}</option>
                                <option value="3" {{!empty($estate)?($estate->type==3?'selected':''):""}}>{{l('اجاره کوتاه مدت')}}</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-type">{{l('نوع ملک')}} <span class="text-danger">*</span></label>
                            <select class="form-select"  name="estate_type" id="estate_type" required  >
                                <optgroup label=l("فروش مسکونی") id="sale1">
                                    <option value="1"  @php echo (!empty($estate) && $estate->estate_type == 1 ? "selected" :'') @endphp>{{ l('آپارتمان') }}</option>
                                    <option value="2"  @php echo (!empty($estate) && $estate->estate_type == 2 ? "selected" :'') @endphp>{{ l('منزل ویلایی') }}</option>
                                    <option value="3"  @php echo (!empty($estate) && $estate->estate_type == 3 ? "selected" :'') @endphp>{{ l('زمین و خانه کلنگی') }}</option>
                                    <option value="6"  @php echo (!empty($estate) && $estate->estate_type == 6 ? "selected" :'') @endphp>{{ l('آپارتمان یک جا') }}</option>
                                    <option value="7"  @php echo (!empty($estate) && $estate->estate_type == 7 ? "selected" :'') @endphp>{{ l('باغ و ویلا') }}</option>
                                </optgroup>
                                <optgroup label=l("فروش اداری و تجاری") id="sale2">
                                    <option value="5"  @php echo (!empty($estate) && $estate->estate_type == 5 ? "selected" :'') @endphp>{{ l('صنعتی') }}</option>
                                    <option value="8"  @php echo (!empty($estate) && $estate->estate_type == 8 ? "selected" :'') @endphp>{{ l('زمین کشاورزی و باغ') }}</option>
                                    <option value="9"  @php echo (!empty($estate) && $estate->estate_type == 9 ? "selected" :'') @endphp>{{ l('مغازه و غرفه') }}</option>
                                    <option value="10" @php echo (!empty($estate) && $estate->estate_type == 10 ? "selected" :'') @endphp>{{ l('کارگاه و کارخانه') }}</option>
                                    <option value="11" @php echo (!empty($estate) && $estate->estate_type == 11 ? "selected" :'') @endphp>{{ l('آپارتمان تجاری یک جا') }}</option>
                                    <option value="12" @php echo (!empty($estate) && $estate->estate_type == 12 ? "selected" :'') @endphp>{{ l('اداری, دفتر کار و مطب') }}</option>
                                    <option value="13" @php echo (!empty($estate) && $estate->estate_type == 13 ? "selected" :'') @endphp>{{ l('زمین تجاری') }}</option>
                                </optgroup>
                                <optgroup label=l("پروژه‌های ساخت و ساز") id="sale3">
                                    <option value="14"  @php echo (!empty($estate) && $estate->estate_type == 14 ? "selected" :'') @endphp>{{ l('مشارکت در ساخت و ساز') }}</option>
                                    <option value="15"  @php echo (!empty($estate) && $estate->estate_type == 15 ? "selected" :'') @endphp>{{ l('پیش فروش') }}</option>
                                </optgroup>
                                <optgroup label=l("اجاره مسکونی") id="rent1">
                                    <option value="1"  @php echo (!empty($estate) && $estate->estate_type == 1 ? "selected" :'') @endphp>{{ l('آپارتمان') }}</option>
                                    <option value="2"  @php echo (!empty($estate) && $estate->estate_type == 2 ? "selected" :'') @endphp>{{ l('منزل ویلایی') }}</option>
                                    <option value="3"  @php echo (!empty($estate) && $estate->estate_type == 3 ? "selected" :'') @endphp>{{ l('زمین و خانه کلنگی') }}</option>
                                    <option value="6"  @php echo (!empty($estate) && $estate->estate_type == 6 ? "selected" :'') @endphp>{{ l('آپارتمان یک جا') }}</option>
                                    <option value="7"  @php echo (!empty($estate) && $estate->estate_type == 7 ? "selected" :'') @endphp>{{ l('باغ و ویلا') }}</option>
                                </optgroup>
                                <optgroup label=l("اجارهٔ اداری و تجاری") id="rent2">
                                    <option value="5"  @php echo (!empty($estate) && $estate->estate_type == 5 ? "selected" :'') @endphp>{{ l('صنعتی') }}</option>
                                    <option value="8"  @php echo (!empty($estate) && $estate->estate_type == 8 ? "selected" :'') @endphp>{{ l('زمین کشاورزی و باغ') }}</option>
                                    <option value="9"  @php echo (!empty($estate) && $estate->estate_type == 9 ? "selected" :'') @endphp>{{ l('مغازه و غرفه') }}</option>
                                    <option value="10" @php echo (!empty($estate) && $estate->estate_type == 10 ? "selected" :'') @endphp>{{ l('کارگاه و کارخانه') }}</option>
                                    <option value="11" @php echo (!empty($estate) && $estate->estate_type == 11 ? "selected" :'') @endphp>{{ l('آپارتمان تجاری یک جا') }}</option>
                                    <option value="12" @php echo (!empty($estate) && $estate->estate_type == 12 ? "selected" :'') @endphp>{{ l('اداری, دفتر کار و مطب') }}</option>
                                    <option value="13" @php echo (!empty($estate) && $estate->estate_type == 13 ? "selected" :'') @endphp>{{ l('زمین تجاری') }}</option>
                                </optgroup>
                                <optgroup label=l("اجارهٔ کوتاه مدت") id="room">
                                    <option value="1"  @php echo (!empty($estate) && $estate->estate_type == 1 ? "selected" :'') @endphp>{{ l('آپارتمان') }}</option>
                                    <option value="2"  @php echo (!empty($estate) && $estate->estate_type == 2 ? "selected" :'') @endphp>{{ l('منزل ویلایی') }}</option>
                                    <option value="3"  @php echo (!empty($estate) && $estate->estate_type == 3 ? "selected" :'') @endphp>{{ l('زمین و خانه کلنگی') }}</option>
                                    <option value="6"  @php echo (!empty($estate) && $estate->estate_type == 6 ? "selected" :'') @endphp>{{ l('آپارتمان یک جا') }}</option>
                                    <option value="7"  @php echo (!empty($estate) && $estate->estate_type == 7 ? "selected" :'') @endphp>{{ l('باغ و ویلا') }}</option>
                                </optgroup>
                                <!--<option value=""  hidden>{{l('نوع ملک')}}</option>-->
                                @foreach (estateTypes() as $key=>$val)
                                <!--option value="{{$key}}" {{!empty($estate)?($estate->estate_type==$key ? 'selected':''):""}}>{{$val}}</option-->
                                @endforeach
                            </select>
                            <input type="hidden" id="hide_estate_type" value="{{!empty($estate)?$estate->estate_type:''}}"/>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-owner_name"> {{l('نام مالک')}}
                            <span class="text-danger">*</span></label>
                            <input class="necessary form-control" type="text" value="{{!empty($estate)?$estate->owner_name:''}}"  id="owner_name" name="owner_name" required/>
                        </div>
                        @if($currentUser->isExpert())
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-tel"> {{l('شماره تماس')}} ({{l('مالک')}})
                                <span class="text-danger">*</span>
                            </label>
                            <input class="necessary form-control js_valid_number number" placeholder="09103511135" type="tel" value="{{!empty($estate)?$estate->phone:''}}" required maxlength="11" minlength="11"   name="phone" id="phone" />
                        </div>
                        @else
                        <input type="hidden" value="{{$currentUser->username}}" name="phone" id="phone" />
                        @endif

                        @if ($currentUser->isAdmin() || $currentUser->isAdminBranch())
                            <div class="col-sm-6 col-md-3 mb-3">
                                <label class="form-label fw-bold" for="ap-max-buy">{{l('انتخاب مشاور')}}</label>
                                <select class="form-control select2" name="expert_id" id="expertid" style="width: 100%;" dir="rtl">
                                    <option value="">{{l('بدون مشاور')}}</option>
                                    @foreach($users as $item)
                                        <option value="{{$item->id}}" {{!empty($estate) && $estate->expert_id == $item->id  && $estate->haveExpert() ? 'selected' :''}}>{{$item->fullname()}}</option>
                                    @endforeach
                                </select>
                            </div>

                        @else
                            @if(empty($estate))
                            <input type="hidden" name="expert_id" value="{{$currentUser->id}}">
                            @endif
                        @endif
                        @if ($currentUser->isAdmin() || $currentUser->isExpert())
                        @if(empty($estate))
                        <input type="hidden" name="confirmation" value="verified">
                        @else
                        <div class="col-sm-6 col-md-3 mb-3">
                            <label class="form-label fw-bold" for="ap-max-buy">{{ l('وضعیت ملک') }}</label>
                            <select class="form-control" name="confirmation" id="confirmation" style="width:100%">
                                @foreach (confirmStatuses() as  $key=>$val)
                                <option value="{{$key}}" {{!empty($estate) && $estate->confirmation == $key ? 'selected' :''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        @endif


                    </div>
                </section>
                <!-- Price-->
                <section class="card card-body p-4 mb-4" id="price">
                    <h2 class="h5 mb-4"><i class="fi-cash text-primary fs-5 mt-n1 me-2"></i>{{l('قیمت و مساحت')}}</h2>
                    <div class="row">
                        <div class="col-sm-6 col-md-3 col-lg-2 fw-bold">
                            <label class="form-label fw-bold" for="ap-meterage">{{l('مساحت')}} <span class="text-danger">*</span></label>
                            <div class="d-sm-flex">
                                <input class="necessary form-control w-100 mb-2 js_valid_number_float required  number" type="tel"  value="{{old('area',!empty($estate)?$estate->area:'')}}"  id="area" name="area" >
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3 col-lg-2 fw-bold not" access="12,22,16,26,14,24,17,27">
                            <label class="form-label fw-bold" for="ap-meterage">{{l('متراژ بر')}} </label>
                            <div class="d-sm-flex">
                                <input class="necessary form-control w-100 mb-2 js_valid_number_float number" type="tel"  value="{{old('front_area',!empty($estate)?$estate->front_area:'')}}"   id="front_area" name="front_area">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-2 fw-bold not" access="12,22,16,26,17,27">
                            <label class="form-label fw-bold" for="ap-meterage">{{l('مساحت زیربنا')}} </label>
                            <div class="d-sm-flex">
                                <input class="necessary form-control w-100 mb-2 js_valid_number_float number" type="tel"  value="{{old('built_area',!empty($estate)?$estate->built_area:'')}}"   id="built_area" name="built_area">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-2 fw-bold  not" access="13,23">
                            <label class="form-label fw-bold" for="ap-meterage">{{l('مساحت بالکن')}}</label>
                            <div class="d-sm-flex">
                                <input class="form-control w-100 mb-2 js_valid_number_float number" type="tel"  value="{{old('balconmetraj',!empty($estate)?$estate->balconmetraj:'')}}"  id="balconmetraj" name="balconmetraj"  >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-2 fw-bold d not" access="13,23">
                            <label class="form-label fw-bold" for="ap-meterage">{{l('مساحت زیرزمین')}} </label>
                            <div class="d-sm-flex">
                                <input class="form-control w-100 mb-2 js_valid_number_float number" type="tel"  value="{{old('undermetraj',!empty($estate)?$estate->undermetraj:'')}}"  id="undermetraj" name="undermetraj"  >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-2 fw-bold  not" access="13,23">
                            <label class="form-label fw-bold" for="ap-meterage">{{l('ارتفاع مغازه')}} </label>
                            <div class="d-sm-flex">
                                <input class="form-control w-100 mb-2 js_valid_number_float number" type="tel"  value="{{old('shopheight',!empty($estate)?$estate->shopheight:'')}}"  id="shopheight" name="shopheight"  >
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3 col-lg-2 not " access="11,12,13,14,15,16,17,18" id="sale-inputs">
                            <label class="form-label fw-bold" for="ap-price">{{l('قیمت کل')}} <span class="text-danger">*</span></label>
                            <div class="d-sm-flex">
                                <input class="necessary form-control w-100 mb-2 number js_number js_Splitnumber1" type="text"   onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"   id="price" name="price"  value="{{old('price',!empty($estate)?$estate->price:'')}}" required  >
                            </div>
                            <div id="divprice"  class="w-100"></div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-2 not" access="21,22,23,24,25" >
                            <label class="form-label fw-bold">
                                {{l('آیا تخلیه است؟')}}
                            </label>
                            <select class="form-select"  name="evacuation" id="evacuation">
                            <option value="">{{ l('انتخاب کنید') }}</option>
                                <option value="0" {{!empty($estate)?($estate->evacuation==0?'selected':''):'selected'}}>{{ l('هست') }}</option>
                                <option value="1" {{!empty($estate)?($estate->evacuation==1?'selected':''):''}}>{{ l('نیست') }}</option>
                            </select>
                        </div>


                        <input type="hidden" id="hideconvertible" value="{{!empty($estate)?$estate->convertible:''}}"/>
                        <div class="col-sm-6 col-md-3 col-lg-2 not" access="21,22,23,24,25,17,27" id="sale-inputs">
                            <label class="form-label fw-bold">
                                {{l('قابلیت تبدیل')}}
                            </label>
                            <select class="form-select"  name="convertible" id="convertible">
                                <option value="">{{ l('انتخاب کنید') }}</option>
                                <option value="0" > {{l('ندارد')}}</option>
                                <option value="1" {{!empty($estate)?($estate->convertible==1?'':'selected'):'selected'}}>{{l('دارد')}}</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-2 not" access="11,12,13,14,15,16" id="sale-inputs">
                            <label class="form-label fw-bold">
                                {{l('قابلیت معاوضه')}}
                            </label>
                            <select class="form-select"  name="exchange" id="exchange">
                                <option value="">{{l('انتخاب کنید')}}</option>
                                <option value="0" {{!empty($estate)?(checkValueCreate($estate->conditions,16)!='checked'?'':'selected'):'selected'}}> {{l('ندارد')}}</option>
                                <option value="1" {{!empty($estate)?(checkValueCreate($estate->conditions,16)=='checked'?'selected':''):''}}>{{l('دارد')}}</option>
                            </select>
                        </div>
                        <div class="col-sm-12 not  {{!empty($estate)?(checkValueCreate($estate->conditions,16)=='checked'?'':'d-none'):'d-none'}}" access="11,12,13,14,15,16" id="exchangetext1">
                            <label class="form-label fw-bold">
                                {{l('توضیحات معاوضه')}}
                            </label>
                            <textarea name="exchange_comment" id="exchangetext" class="form-control">{{!empty($estate)?$estate->exchange_comment:""}}</textarea>
                        </div>

                        <div class="col-sm-6 col-md-3 col-lg-2 not" access="21,22,23,24,25,27">
                            <label class="form-label fw-bold" for="ap-price">{{l('مبلغ رهن')}} <span class="text-danger">*</span></label>
                            <div class="d-sm-flex">
                                <input class="form-control w-100 me-2 mb-2 number js_number necessary " type="text" onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"   id="mortgage" name="mortgage" value="{{old('mortgage',!empty($estate)?$estate->mortgage:'')}}"  >
                            </div>
                            <div id="divmortgage"  class="w-100"></div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-2 not" access="21,22,23,24,25,27">
                            <label class="form-label fw-bold" for="ap-price">{{l('مبلغ اجاره')}} <span class="text-danger">*</span></label>
                            <div class="d-sm-flex">
                                <input class="form-control w-100 me-2 mb-2 number js_number necessary " onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"  value="{{old('rent',!empty($estate)?$estate->rent:'')}}" type="text"  id="rent" name="rent"  >
                            </div>
                            <div id="divrent"  class="w-100"></div>
                        </div>

                    </div>
                </section>
                <section class="card card-body p-4 mb-4" id="location">
                    <h2 class="h5 mb-4"><i class="fi-map-pin text-primary fs-5 mt-n1 me-2"></i>{{l('موقعیت مکانی')}}</h2>
                    <div class="row">
                        <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                            <label class="form-label fw-bold" for="ap-city"> {{l('شهر')}}
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select  select2"  name="city_id" id="city_id">
                                <option value="" disabled>{{l('شهر')}}</option>
                                @foreach($cities as $ci)
                                <option value="{{$ci->id}}" {{!empty($estate) && $estate->city_id == $ci->id ? 'selected' :''}}>{{$ci->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="hide_cityId" value="{{!empty($estate)?$estate->city_id:''}}"/>
                        <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                            <label class="form-label fw-bold" for="ap-district"> {{l('محله‌')}}
                            </label>
                            <select class="form-select js-example-disabled-results  select2"  name="district_id" id="district_id" aria-placeholder="test">
                                <option value="" >&nbsp;</option>
                                @foreach($districts as $district)
                                <option value="{{$district->id}}" {{!empty($estate) && $estate->district_id == $district->id ? 'selected' :''}}>{{$district->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="hide_district" value="{{!empty($estate)?$estate->district_id:''}}"/>

                        <div class="col-sm-6 col-md-6  mb-3">
                            <label class="form-label fw-bold" for="ap-address">{{l('آدرس ')}} </label>
                            <input class="necessary form-control" type="text" id="ap-address" name="address" value="{{!empty($estate)?($estate->address):""}}" >
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                            <label class="form-label fw-bold">{{l('شماره پلاک / واحد')}}</label>
                            <input class="necessary form-control" name="unit_no" id="unit_no" value="{{!empty($estate)?($estate->unit_no):""}}"  >
                        </div>
                    </div>
                    <div class="necessary form-label fw-bold pt-3 pb-2">{{l('نمایش روی نقشه')}}</div>
                    <div class="necessary rounded-3"  id="estate-map" style="height: 400px;"></div>
                </section>
                <section class="card card-body p-4 mb-4" id="details">
                    <h2 class="h5 mb-4"><i class="fi-edit text-primary fs-5 mt-n1 me-2"></i>{{l('جزئیات ملک')}}</h2>
                    <div class="row">
                        <div class="col-sm-3 col-lg-2 mb-3 not" access="11,12,13,15,16,21,22,23,25,26">
                            <label class="form-label fw-bold" for="ap-floors"> {{l('تعداد طبقات')}} </label>
                            <select class="necessary form-select" id="floor_count" name="floor_count" >
                                <option value=""  selected>{{l('انتخاب')}} </option>
                                <option value="155" {{!empty($estate)?($estate->floor_count==155?'selected':''):''}}>1</option>
                                <option value="156" {{!empty($estate)?($estate->floor_count==156?'selected':''):''}}>2</option>
                                <option value="157" {{!empty($estate)?($estate->floor_count==157?'selected':''):''}}>3</option>
                                <option value="158" {{!empty($estate)?($estate->floor_count==158?'selected':''):''}}>4</option>
                                <option value="159" {{!empty($estate)?($estate->floor_count==159?'selected':''):''}}>5</option>
                                <option value="160" {{!empty($estate)?($estate->floor_count==160?'selected':''):''}}>6</option>
                                <option value="161" {{!empty($estate)?($estate->floor_count==161?'selected':''):''}}>7</option>
                                <option value="162" {{!empty($estate)?($estate->floor_count==162?'selected':''):''}}>8</option>
                                <option value="163" {{!empty($estate)?($estate->floor_count==163?'selected':''):''}}>9</option>
                                <option value="164" {{!empty($estate)?($estate->floor_count==164?'selected':''):''}}>10</option>
                                <option value="165" {{!empty($estate)?($estate->floor_count==165?'selected':''):''}}>11</option>
                                <option value="166" {{!empty($estate)?($estate->floor_count==166?'selected':''):''}}>12</option>
                                <option value="167" {{!empty($estate)?($estate->floor_count==167?'selected':''):''}}>13</option>
                                <option value="168" {{!empty($estate)?($estate->floor_count==168?'selected':''):''}}>14</option>
                                <option value="169" {{!empty($estate)?($estate->floor_count==169?'selected':''):''}}>15</option>
                                <option value="170" {{!empty($estate)?($estate->floor_count==170?'selected':''):''}}>16</option>
                                <option value="171" {{!empty($estate)?($estate->floor_count==171?'selected':''):''}}>17</option>
                                <option value="172" {{!empty($estate)?($estate->floor_count==172?'selected':''):''}}>18</option>
                                <option value="173" {{!empty($estate)?($estate->floor_count==173?'selected':''):''}}>19</option>
                                <option value="174" {{!empty($estate)?($estate->floor_count==174?'selected':''):''}}>20</option>
                                <option value="175" {{!empty($estate)?($estate->floor_count==175?'selected':''):''}}>21</option>
                                <option value="176" {{!empty($estate)?($estate->floor_count==176?'selected':''):''}}>22</option>
                                <option value="177" {{!empty($estate)?($estate->floor_count==177?'selected':''):''}}>23</option>
                                <option value="178" {{!empty($estate)?($estate->floor_count==178?'selected':''):''}}>24</option>
                                <option value="179" {{!empty($estate)?($estate->floor_count==179?'selected':''):''}}>25</option>
                                <option value="180" {{!empty($estate)?($estate->floor_count==180?'selected':''):''}}>26</option>
                                <option value="181" {{!empty($estate)?($estate->floor_count==181?'selected':''):''}}>27</option>
                                <option value="182" {{!empty($estate)?($estate->floor_count==182?'selected':''):''}}>28</option>
                                <option value="183" {{!empty($estate)?($estate->floor_count==183?'selected':''):''}}>29</option>
                                <option value="184" {{!empty($estate)?($estate->floor_count==184?'selected':''):''}}>30</option>
                                <option value="185" {{!empty($estate)?($estate->floor_count==185?'selected':''):''}}>{{l('بیشتر از')}} 30</option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-lg-2 mb-3 not" access="12,22">
                            <label class="form-label fw-bold" for="ap-floors"> {{l('شروع طبقات از')}} </label>
                            <select class="necessary form-select" id="floor_start" name="floor_start">
                                <option value="">{{ l('انتخاب نمایید') }}</option>
                                <option value="257" {{!empty($estate)?($estate->floor_start==257?'selected':''):''}}>{{ l('زیرزمین') }}</option>
                                <option value="258" {{!empty($estate)?($estate->floor_start==258?'selected':''):''}}>{{ l('همکف') }}</option>
                                <option value="259" {{!empty($estate)?($estate->floor_start==259?'selected':''):''}}>{{ l('پیلوت') }}</option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-lg-2 mb-3 not" access="11,12,13,15,16,21,22,23,25,26">
                            <label class="form-label fw-bold" for="ap-room"> {{l('تعداد اتاق')}} </label>
                            <select class="necessary form-select" id="room_count" name="room_count">
                                <option value="" disabled selected>{{l('انتخاب')}} </option>
                                <option value="186" {{!empty($estate)?($estate->room_count==186?'selected':''):''}}>{{l('بدون اتاق')}}</option>
                                <option value="187" {{!empty($estate)?($estate->room_count==187?'selected':''):''}}>1</option>
                                <option value="188" {{!empty($estate)?($estate->room_count==188?'selected':''):''}}>2</option>
                                <option value="189" {{!empty($estate)?($estate->room_count==189?'selected':''):''}}>3</option>
                                <option value="190" {{!empty($estate)?($estate->room_count==190?'selected':''):''}}>4</option>
                                <option value="191" {{!empty($estate)?($estate->room_count==191?'selected':''):''}}>{{l('بیشتر از')}} 4</option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-lg-2 mb-3 not" access="11,21,22,16,26">
                            <label class="form-label fw-bold" for="ap-number-room"> {{l('شماره طبقه')}} </label>
                            <select class="necessary form-select" id="ap-number-room"  name="floor">
                                <option value="" selected>{{l('انتخاب')}} </option>
                                <option title="{{ l('طبقه') }}" value="121" {{!empty($estate)?($estate->floor==121?'selected':''):''}}>{{l('زیر همکف')}}</option>
                                <option title="{{ l('طبقه') }}" value="122" {{!empty($estate)?($estate->floor==122?'selected':''):''}}>{{l('همکف')}}</option>
                                <option title="{{ l('طبقه') }}" value="123" {{!empty($estate)?($estate->floor==123?'selected':''):''}}>1</option>
                                <option title="{{ l('طبقه') }}" value="124" {{!empty($estate)?($estate->floor==124?'selected':''):''}}>2</option>
                                <option title="{{ l('طبقه') }}" value="125" {{!empty($estate)?($estate->floor==125?'selected':''):''}}>3</option>
                                <option title="{{ l('طبقه') }}" value="126" {{!empty($estate)?($estate->floor==126?'selected':''):''}}>4</option>
                                <option title="{{ l('طبقه') }}" value="127" {{!empty($estate)?($estate->floor==127?'selected':''):''}}>5</option>
                                <option title="{{ l('طبقه') }}" value="128" {{!empty($estate)?($estate->floor==128?'selected':''):''}}>6</option>
                                <option title="{{ l('طبقه') }}" value="129" {{!empty($estate)?($estate->floor==129?'selected':''):''}}>7</option>
                                <option title="{{ l('طبقه') }}" value="130" {{!empty($estate)?($estate->floor==130?'selected':''):''}}>8</option>
                                <option title="{{ l('طبقه') }}" value="131" {{!empty($estate)?($estate->floor==131?'selected':''):''}}>9</option>
                                <option title="{{ l('طبقه') }}" value="132" {{!empty($estate)?($estate->floor==132?'selected':''):''}}>10</option>
                                <option title="{{ l('طبقه') }}" value="133" {{!empty($estate)?($estate->floor==133?'selected':''):''}}>11</option>
                                <option title="{{ l('طبقه') }}" value="134" {{!empty($estate)?($estate->floor==134?'selected':''):''}}>12</option>
                                <option title="{{ l('طبقه') }}" value="135" {{!empty($estate)?($estate->floor==135?'selected':''):''}}>13</option>
                                <option title="{{ l('طبقه') }}" value="136" {{!empty($estate)?($estate->floor==136?'selected':''):''}}>14</option>
                                <option title="{{ l('طبقه') }}" value="137" {{!empty($estate)?($estate->floor==137?'selected':''):''}}>15</option>
                                <option title="{{ l('طبقه') }}" value="138" {{!empty($estate)?($estate->floor==138?'selected':''):''}}>16</option>
                                <option title="{{ l('طبقه') }}" value="139" {{!empty($estate)?($estate->floor==139?'selected':''):''}}>17</option>
                                <option title="{{ l('طبقه') }}" value="140" {{!empty($estate)?($estate->floor==140?'selected':''):''}}>18</option>
                                <option title="{{ l('طبقه') }}" value="141" {{!empty($estate)?($estate->floor==141?'selected':''):''}}>19</option>
                                <option title="{{ l('طبقه') }}" value="142" {{!empty($estate)?($estate->floor==142?'selected':''):''}}>20</option>
                                <option title="{{ l('طبقه') }}" value="143" {{!empty($estate)?($estate->floor==143?'selected':''):''}}>21</option>
                                <option title="{{ l('طبقه') }}" value="144" {{!empty($estate)?($estate->floor==144?'selected':''):''}}>22</option>
                                <option title="{{ l('طبقه') }}" value="145" {{!empty($estate)?($estate->floor==145?'selected':''):''}}>23</option>
                                <option title="{{ l('طبقه') }}" value="146" {{!empty($estate)?($estate->floor==146?'selected':''):''}}>24</option>
                                <option title="{{ l('طبقه') }}" value="147" {{!empty($estate)?($estate->floor==147?'selected':''):''}}>25</option>
                                <option title="{{ l('طبقه') }}" value="148" {{!empty($estate)?($estate->floor==148?'selected':''):''}}>26</option>
                                <option title="{{ l('طبقه') }}" value="149" {{!empty($estate)?($estate->floor==149?'selected':''):''}}>27</option>
                                <option title="{{ l('طبقه') }}" value="150" {{!empty($estate)?($estate->floor==150?'selected':''):''}}>28</option>
                                <option title="{{ l('طبقه') }}" value="151" {{!empty($estate)?($estate->floor==151?'selected':''):''}}>29</option>
                                <option title="{{ l('طبقه') }}" value="152" {{!empty($estate)?($estate->floor==152?'selected':''):''}}>30</option>
                                <option title="{{ l('طبقه') }}" value="153" {{!empty($estate)?($estate->floor==153?'selected':''):''}}> {{l('بیشتر از')}}30</option>
                                <option title="{{ l('طبقه') }}" value="154" {{!empty($estate)?($estate->floor==154?'selected':''):''}}>{{l('پنت هاوس')}} </option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-lg-2 mb-3 not" access="11,21,16,26">
                            <label class="form-label fw-bold" for="ap-number-floor"> {{l('تعداد واحد در طبقه')}} </label>
                            <select class="form-select" id="ap-number-floor"  name="unit_in_floor" >
                                <option value="" disabled selected>{{l('انتخاب')}} </option>
                                <option title="{{ l('واحد در طبقه') }}" value="305" {{!empty($estate)?($estate->unit_in_floor==305?'selected':''):''}}>1</option>
                                <option title="{{ l('واحد در طبقه') }}" value="306" {{!empty($estate)?($estate->unit_in_floor==306?'selected':''):''}}>2</option>
                                <option title="{{ l('واحد در طبقه') }}" value="307" {{!empty($estate)?($estate->unit_in_floor==307?'selected':''):''}}>3</option>
                                <option title="{{ l('واحد در طبقه') }}" value="308" {{!empty($estate)?($estate->unit_in_floor==308?'selected':''):''}}>4</option>
                                <option title="{{ l('واحد در طبقه') }}" value="309" {{!empty($estate)?($estate->unit_in_floor==309?'selected':''):''}}>5</option>
                                <option title="{{ l('واحد در طبقه') }}" value="310" {{!empty($estate)?($estate->unit_in_floor==310?'selected':''):''}}>6</option>
                                <option title="{{ l('واحد در طبقه') }}" value="311" {{!empty($estate)?($estate->unit_in_floor==311?'selected':''):''}}>7</option>
                                <option title="{{ l('واحد در طبقه') }}" value="312" {{!empty($estate)?($estate->unit_in_floor==312?'selected':''):''}}>8</option>
                                <option title="{{ l('واحد در طبقه') }}" value="313" {{!empty($estate)?($estate->unit_in_floor==313?'selected':''):''}}>9</option>
                                <option title="{{ l('واحد در طبقه') }}" value="314" {{!empty($estate)?($estate->unit_in_floor==314?'selected':''):''}}>10</option>
                                <option title="{{ l('واحد در طبقه') }}" value="315" {{!empty($estate)?($estate->unit_in_floor==315?'selected':''):''}}>11</option>
                                <option title="{{ l('واحد در طبقه') }}" value="316" {{!empty($estate)?($estate->unit_in_floor==316?'selected':''):''}}>12</option>
                                <option title="{{ l('واحد در طبقه') }}" value="317" {{!empty($estate)?($estate->unit_in_floor==317?'selected':''):''}}>13</option>
                                <option title="{{ l('واحد در طبقه') }}" value="318" {{!empty($estate)?($estate->unit_in_floor==318?'selected':''):''}}>14</option>
                                <option title="{{ l('واحد در طبقه') }}" value="319" {{!empty($estate)?($estate->unit_in_floor==319?'selected':''):''}}>15</option>
                                <option title="{{ l('واحد در طبقه') }}" value="320" {{!empty($estate)?($estate->unit_in_floor==320?'selected':''):''}}>16</option>
                                <option title="{{ l('واحد در طبقه') }}" value="321" {{!empty($estate)?($estate->unit_in_floor==321?'selected':''):''}}>17</option>
                                <option title="{{ l('واحد در طبقه') }}" value="322" {{!empty($estate)?($estate->unit_in_floor==322?'selected':''):''}}>18</option>
                                <option title="{{ l('واحد در طبقه') }}" value="323" {{!empty($estate)?($estate->unit_in_floor==323?'selected':''):''}}>19</option>
                                <option title="{{ l('واحد در طبقه') }}" value="324" {{!empty($estate)?($estate->unit_in_floor==324?'selected':''):''}}>20</option>
                                <option title="{{ l('واحد در طبقه') }}" value="325" {{!empty($estate)?($estate->unit_in_floor==325?'selected':''):''}}>21</option>
                                <option title="{{ l('واحد در طبقه') }}" value="326" {{!empty($estate)?($estate->unit_in_floor==326?'selected':''):''}}>22</option>
                                <option title="{{ l('واحد در طبقه') }}" value="327" {{!empty($estate)?($estate->unit_in_floor==327?'selected':''):''}}>23</option>
                                <option title="{{ l('واحد در طبقه') }}" value="328" {{!empty($estate)?($estate->unit_in_floor==328?'selected':''):''}}>24</option>
                                <option title="{{ l('واحد در طبقه') }}" value="329" {{!empty($estate)?($estate->unit_in_floor==329?'selected':''):''}}>25</option>
                                <option title="{{ l('واحد در طبقه') }}" value="330" {{!empty($estate)?($estate->unit_in_floor==330?'selected':''):''}}>26</option>
                                <option title="{{ l('واحد در طبقه') }}" value="331" {{!empty($estate)?($estate->unit_in_floor==331?'selected':''):''}}>27</option>
                                <option title="{{ l('واحد در طبقه') }}" value="332" {{!empty($estate)?($estate->unit_in_floor==332?'selected':''):''}}>28</option>
                                <option title="{{ l('واحد در طبقه') }}" value="333" {{!empty($estate)?($estate->unit_in_floor==333?'selected':''):''}}>29</option>
                                <option title="{{ l('واحد در طبقه') }}" value="334" {{!empty($estate)?($estate->unit_in_floor==334?'selected':''):''}}>30</option>
                                <option title="{{ l('واحد در طبقه') }}" value="335" {{!empty($estate)?($estate->unit_in_floor==335?'selected':''):''}}>{{l('بیشتر از')}} 30</option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-lg-2 mb-3 not" access="11,12,13,14,15,16">
                            <label class="form-label fw-bold" for="ap-account-type"> {{l('نوع کاربری')}}</label>
                            <select class="necessary form-select"  id="account-type" name="usage_type"  cus-valid="true">
                                <option value="" disabled selected>{{l('انتخاب')}} </option>
                                @foreach (usage_type() as $key=>$val)
                                <option value="{{$key}}" {{!empty($estate)?($estate->usage_type==$key ? 'selected':''):""}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-sm-3 col-lg-2 mb-3 not" access="11,12,13,14,15,16">
                            <label class="form-label fw-bold" for="ap-type-document">{{ l('نوع سند') }}</label>
                            <select class="necessary form-select" id="type-document" name="document_type">
                                <option value="" disabled selected></option>
                                <option value="20" {{!empty($estate)?($estate->document_type==20?'selected':''):''}}>{{ l('شش دانگ') }}</option>
                                <option value="21" {{!empty($estate)?($estate->document_type==21?'selected':''):''}}>{{ l('سرقفلی') }}</option>
                                <option value="22" {{!empty($estate)?($estate->document_type==22?'selected':''):''}}>{{ l('مشاع') }}</option>
                                <option value="23" {{!empty($estate)?($estate->document_type==23?'selected':''):''}}>{{ l('اوقافی') }}</option>
                                <option value="24" {{!empty($estate)?($estate->document_type==24?'selected':''):''}}>{{ l('مسکن مهر') }}</option>
                                <option value="25" {{!empty($estate)?($estate->document_type==25?'selected':''):''}}>{{ l('وکالتی') }}</option>
                                <option value="26" {{!empty($estate)?($estate->document_type==26?'selected':''):''}}>{{ l('قولنامه ای') }}</option>
                                <option value="28" {{!empty($estate)?($estate->document_type==28?'selected':''):''}}>{{ l('زمین شهری') }}</option>
                                <option value="29" {{!empty($estate)?($estate->document_type==29?'selected':''):''}}>{{ l('شورایی') }}</option>
                                <option value="30" {{!empty($estate)?($estate->document_type==30?'selected':''):''}}>{{ l('در دست اقدام') }}</option>

                            </select>
                        </div>


                        <div class="col-sm-3 col-lg-2 mb-3 not year-build" access="11,12,13,15,16,21,22,23,25,26">
                            <label class="form-label fw-bold" for="ap-made-year">{{l('سال ساخت')}}</label>
                            <select id="year-build" class="necessary form-select"  name="built_year"  cus-valid="true">
                                <option value="" disabled selected>{{l('انتخاب')}} </option>
                                <?php for ($i = date('Y')-620; $i >= 1360; $i--) { ?>
                                    @php
                                        $j = $i;

                                    @endphp
                                    <option value="<?= $j; ?>" {{!empty($estate)?($estate->built_year==$j?'selected':''):''}}><?= $j ?></option>
                                <?php } ?>

                                <option value="1359" {{!empty($estate)?($estate->built_year==1359?'selected':''):''}}>{{ l('کمتر از 1360') }}</option>
                            </select>
                        </div>

                        <div class="col-sm-3 col-lg-2  not"  access="14"  id="sale-inputs">
                            <label class="form-label">
                                {{l('پروانه ساخت')}}
                            </label>
                            <select class="form-select  " name="build_license" id="build_license">
                                <option value="" >{{l('انتخاب کنید')}}</option>
                                <option value="290" {{!empty($estate)?($estate->build_license==290?'selected':''):''}}>{{ l('دارد') }}</option>
                                <option value="291" {{!empty($estate)?($estate->build_license==291?'selected':''):''}}>{{ l('ندارد') }}</option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-lg-2 mb-3">
                            <label class="form-label fw-bold" for="ap-location">{{ l('موقعیت جغرافیایی') }}</label>
                            <select class="necessary form-select" id="select-location" name="geography">
                                <option value="" ></option>
                                <option value="113" {{!empty($estate)?($estate->geography==113?'selected':''):''}}>{{ l('شمالی') }}</option>
                                <option value="114" {{!empty($estate)?($estate->geography==114?'selected':''):''}}>{{ l('جنوبی') }}</option>
                                <option value="117" {{!empty($estate)?($estate->geography==117?'selected':''):''}}>{{ l('دوبر') }}</option>
                                <option value="118" {{!empty($estate)?($estate->geography==118?'selected':''):''}}>{{ l('سه بر') }}</option>
                                <option value="119" {{!empty($estate)?($estate->geography==119?'selected':''):''}}>{{ l('چهاربر') }}</option>
                                <option value="120" {{!empty($estate)?($estate->geography==120?'selected':''):''}}>{{ l('دوکله') }}</option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-lg-2 mb-3 not"  access="13,14,23,24">
                            <label class="form-label fw-bold" for="ap-location">{{ l('موقعیت مکانی') }}</label>
                            <select class="form-select" name="position_type">
                                <option value=""></option>
                                <option value="266" {{!empty($estate)?($estate->position_type==266?'selected':''):''}}>{{ l('بر خیابان اصلی') }}</option>
                                <option value="267" {{!empty($estate)?($estate->position_type==267?'selected':''):''}}>{{ l('داخل کوچه') }}</option>
                                <option value="268" {{!empty($estate)?($estate->position_type==268?'selected':''):''}}>{{ l('کنار جاده') }}</option>
                                <option value="269" {{!empty($estate)?($estate->position_type==269?'selected':''):''}}>{{ l('دور میدان') }}</option>
                                <option value="270" {{!empty($estate)?($estate->position_type==70?'selected':''):''}}>{{ l('داخل بازار') }}</option>
                                <option value="272" {{!empty($estate)?($estate->position_type==272?'selected':''):''}}>{{ l('داخل شهرک صنعتی') }}</option>
                                <option value="292" {{!empty($estate)?($estate->position_type==292?'selected':''):''}}>{{ l('ساحلی') }}</option>
                                <option value="293" {{!empty($estate)?($estate->position_type==293?'selected':''):''}}>{{ l('جنگلی') }}</option>
                                <option value="294" {{!empty($estate)?($estate->position_type==294?'selected':''):''}}>{{ l('داخل محدوده شهری') }}</option>
                                <option value="295" {{!empty($estate)?($estate->position_type==295?'selected':''):''}}>{{ l('خارج محدوده شهری') }}</option>
                                <option value="345" {{!empty($estate)?($estate->position_type==345?'selected':''):''}}>{{ l('داخل طرح هادی') }}</option>
                                <option value="273" {{!empty($estate)?($estate->position_type==273?'selected':''):''}}>{{ l('سایر') }}</option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-lg-2 mb-3 not"  access="11,12,14,16,22,24">
                            <label class="form-label fw-bold" for="ap-location">{{ l('عرض گذر') }}</label>
                            <input class="form-control digits"  id="street_width" name="street_width" value="{{!empty($estate)?$estate->street_width:''}}" />
                        </div>
                        <div class="col-sm-3 col-lg-2 mb-3 not" access="21,22,23,25,26">
                            <label class="form-label" for="ap-housing"> {{l('وضعیت سکونت')}} </label>
                            <select name="residence_type" class="form-select"  id="ap-housing">
                                <option value="" disabled selected>{{l('انتخاب')}} </option>
                                <option value="247" {{!empty($estate)?($estate->heating_cooling == 247??"selected"):''}}> {{l('سکونت مالک')}}</option>
                                <option value="248" {{!empty($estate)?($estate->heating_cooling == 248??"selected"):''}}> {{l('سکونت مستاجر')}}</option>
                                <!--<option value="249" {{!empty($estate)?($estate->heating_cooling == 249??"selected"):''}}> {{l('تخلیه')}}</option>-->
                            </select>
                        </div>
                        <div class="col-sm-3 col-lg-2 mb-3 not" access="11,12,13,15,16">
                            <label class="form-label fw-bold" for="ap-type-structure">{{ l('نوع سازه') }}</label>
                            <select class="form-select" id="ap-type-structure"  name="structure_type">
                                <option value="" disabled selected></option>
                                <option value="31" title="{{ l('سازه') }}" {{!empty($estate)?($estate->structure_type==31?'selected':''):''}}>{{ l('فلزی') }}</option>
                                <option value="32" title="{{ l('سازه') }}" {{!empty($estate)?($estate->structure_type==32?'selected':''):''}}>{{ l('بتنی') }}</option>
                                <option value="33" title="{{ l('سازه') }}" {{!empty($estate)?($estate->structure_type==33?'selected':''):''}}>{{ l('بتنی – فلزی') }}</option>
                                <option value="34" title="{{ l('سازه') }}" {{!empty($estate)?($estate->structure_type==34?'selected':''):''}}>{{ l('غیره') }}</option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-lg-2 mb-3 not" access="14">
                            <label class="form-label" for="build_density">{{ l('تراکم ساخت (طبقات روی پیلوت)') }}</label>
                            <input class="form-control  number js_number"  id="build_density" value="{{!empty($estate)?($estate->build_density):""}}" name="build_density"  >
                        </div>

                        <div class="col-sm-12 mb-4 not" access="11,12,13,15,16,21,22,23,25,26">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <label class="form-label d-block fw-bold mb-2 pb-1">{{l('امکانات')}} </label>
                                        <div class="col-6 col-sm-3 col-md-2 not" access="22">
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
                                                <input class="form-check-input" name="facilities[]" value="36" type="checkbox" id="warehouse" {{!empty($estate)?checkValueCreate($estate->facilities,36):""}}>
                                                <label class="form-check-label" for="warehouse">{{l('انباری')}}</label>
                                            </div>
                                        </div>

                                        <div class="col-6 col-sm-3 col-md-2  not" access="11,12,13,15,16,21,22,23,25,26">
                                            <div class="form-check">
                                                <input class="form-check-input" name="facilities[]" id="balcon" type="checkbox" value="351" {{!empty($estate)?checkValueCreate($estate->facilities,351):""}} />
                                                <label class="form-check-label" for="balcon">{{ l('بالکن') }}</label>
                                            </div>
                                        </div>


                                        <div class="col-6 col-sm-3 col-md-2  not" access="11,12,13,15,16,21,22,23,25,26">
                                            <div class="form-check">
                                                <input class="form-check-input" name="keynot" id="keynot" type="checkbox" value="1" {{!empty($estate)?($estate->keynot==1?"checked":""):""}} />
                                                <label class="form-check-label" for="water_cooler">{{ l('کلید نخورده') }}</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 mb-3 ">
                                    <label class="form-label fw-bold">
                                        {{ l('شرایط') }}
                                    </label>
                                    <div class="row">
                                    <div class="col-6 col-sm-3 col-md-2 not" access="11,12,13,15">
                                        <div class="form-check">
                                            <input class="form-check-input"  id="condition15" value="15" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,15):""}} name="conditions[]">
                                            <label class="form-check-label" for="condition15">{{ l('پیش فروش') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input"  id="condition17" value="17" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,17):""}} name="conditions[]">
                                            <label class="form-check-label" for="condition17">{{ l('وام دار') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input"  id="condition250" value="250" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,250):""}} name="conditions[]">
                                            <label class="form-check-label" for="condition250">{{ l('مشارکت در ساخت') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input"  id="condition250" value="251" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,251):""}} name="conditions[]">
                                            <label class="form-check-label" for="condition250">{{ l('کلنگی') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input"  id="condition302" value="302" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,302):""}} name="conditions[]">
                                            <label class="form-check-label" for="condition302">{{ l('مناسب مطب و دفتر کار') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input"  id="condition340" value="340" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,340):""}} name="conditions[]">
                                            <label class="form-check-label" for="condition340">{{ l('درب مجزا') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input"  id="condition344" value="344" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,344):""}} name="conditions[]">
                                            <label class="form-check-label" for="condition344">{{ l('بازسازی شده') }}</label>
                                        </div>
                                    </div>
                                </div>

                                </div>
                                <div class="col-sm-12 mb-3 not" access="11,12,16,21,22,26">
                                    <label class="form-label d-block fw-bold ">
                                        {{ l('آشپزخانه') }}
                                    </label>
                                    <div class="row">
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" id="kitchen74" value="74" {{!empty($estate)?checkValueCreate($estate->kitchen,74):""}} type="checkbox" name="kitchen[]">
                                            <label class="form-check-label" for="kitchen74">
                                                {{ l('هود') }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" id="kitchen75" value="75" {{!empty($estate)?checkValueCreate($estate->kitchen,75):""}} type="checkbox" name="kitchen[]">
                                            <label class="form-check-label" for="kitchen75">
                                                {{ l('گاز صفحه ای') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" id="kitchen76" value="76" {{!empty($estate)?checkValueCreate($estate->kitchen,76):""}} type="checkbox" name="kitchen[]">
                                            <label class="form-check-label" for="kitchen76">
                                                {{ l('آب شیرین کن') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" id="kitchen77" value="77" {{!empty($estate)?checkValueCreate($estate->kitchen,77):""}} type="checkbox" name="kitchen[]">
                                            <label class="form-check-label" for="kitchen77">
                                                {{ l('فضای ماشین ظرفشویی') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" id="kitchen78" value="78" {{!empty($estate)?checkValueCreate($estate->kitchen,78):""}} type="checkbox" name="kitchen[]">
                                            <label class="form-check-label" for="kitchen78">
                                                {{ l('فضای ماشین لباسشویی') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" id="kitchen79" value="79" {{!empty($estate)?checkValueCreate($estate->kitchen,79):""}} type="checkbox" name="kitchen[]">
                                            <label class="form-check-label" for="kitchen79">
                                                {{ l('کابینت MDF') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" id="kitchen83" value="83" {{!empty($estate)?checkValueCreate($estate->kitchen,83):""}} type="checkbox" name="kitchen[]">
                                            <label class="form-check-label" for="kitchen83">
                                                {{ l('کابینت فلز و MDF') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" id="kitchen81" value="81" {{!empty($estate)?checkValueCreate($estate->kitchen,81):""}} type="checkbox" name="kitchen[]">
                                            <label class="form-check-label" for="kitchen81">
                                                {{ l('کابینت فلزی') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" id="kitchen82" value="82" {{!empty($estate)?checkValueCreate($estate->kitchen,82):""}} type="checkbox" name="kitchen[]">
                                            <label class="form-check-label" for="kitchen82">
                                                {{ l('کابینت چوب') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" id="kitchen80" value="80" {{!empty($estate)?checkValueCreate($estate->kitchen,80):""}} type="checkbox" name="kitchen[]">
                                            <label class="form-check-label" for="kitchen80">
                                                {{ l('کابینت ممبران') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" id="kitchen84" value="84" {{!empty($estate)?checkValueCreate($estate->kitchen,84):""}} type="checkbox" name="kitchen[]">
                                            <label class="form-check-label" for="kitchen74">
                                                {{ l('مطبخ') }}
                                            </label>
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
                                <div class="col-12 mb-3">
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

                            </div>
                        </div>
                    <label class="form-label fw-bold" for="ap-description">{{l('توضیحات')}} </label>
                    <textarea  name="description" id="desc-state" class="js_input_max form-control mb-3 " rows="5" placeholder="{{l('ملک خود را شرح دهید')}}">{{old('description',!empty($estate)?$estate->description:'')}}</textarea>

                </section>

                <section class="card card-body p-4 mt-4" id="photos">
                    <h2 class="h5 mb-4"><i class="fi-camera-plus text-primary fs-5 mt-n1 me-2"></i>{{l('بارگزاری تصاویر')}}</h2>
                       <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{ l('تصاویر ملک') }}</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">{{ l('عکس پلان') }}</button>

                            <button class="nav-link" id="nav-link-tab" data-bs-toggle="tab" data-bs-target="#nav-link" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">{{ l('لینک ویدئوی ملک') }}</button>
                        </div>
                       </nav>
                        <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <!-- Photos / video-->
                                    <div class=" my-4" id="photos">
                                        {{-- current images --}}
                                        <?php
                                        if($estate!=null){
                                            $imageCount = $estate->images->count();
                                            if($estate->images->count() > 0){
                                                ?>
                                            <div id="images" class=" card mb-3">
                                                <div class="border-bottom card-header">
                                                    <strong class="mb-0">{{l('تصاویر فعلی')}}</strong>
                                                </div>
                                                <div class="card-body align-content-center align-items-center d-flex flex-row flex-wrap justify-content-around">
                                                    @foreach($estate->images->where("360","=",0)->where("plan","=",0)->where("hidden","=",0) as $item)
                                                        <div id="media-{{$item->id}}" data-id="{{$item->id}}" class="card p-1 rounded dz-preview {{$defaultImage && $defaultImage->id == $item->id ? 'img-cover' : ''}}">
                                                            <div class="mb-0 est-container" style="cursor:pointer">
                                                                <div class="middle">
                                                                    <div class="text bg-primary rounded"><i class="fi fi-check"></i></div>

                                                                    {{ l('تصویر شاخص') }}

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
                                                    <span class="text-[16px] text-gray-500 font-light">{{l('تصاویر')}}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-gray-500 text-[14px] font-light mb-3">{{ l('عکس‌هایی از فضای داخل و بیرون ملک اضافه کنید. آگهی‌های دارای عکس تا «۳ برابر» بیشتر توسط کاربران دیده می‌شوند. حداقل اندازه تصویر 600x600 و حداکثر میزان حجم هر تصویر 10 مگابایت می باشد') }}
                                        </div>

                                    </div>
                        </div>


                </div>
                <div class="tab-pane fade" id="nav-link" role="tabpanel" aria-labelledby="nav-link-tab">
                    <div class="">
                        <div>
                            <input type="text" name="video"    value="{{!empty($estate)?$estate->video:''}}" class="form-control" placeholder="https://www.aparat.com/v/iyEZx">
                        </div>
                    </div>
                </div>
            </div>

            </section>
                <!-- Action buttons -->
                <section class="d-sm-flex justify-content-between pt-2 my-4">
                    <button type="submit" class="btn btn-primary btn-lg d-block mb-2">
                        {{!empty($estate)? l('ویرایش ملک') :l('ثبت ملک')}}
                    </button>
                </section>
                <input type="hidden" id="js_csrf_token" value="{{ csrf_token() }}">
                <input type="hidden" id="js_estates_storeMedia" value="{{ route('estates.storeMedia') }}">



            </form>
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
            @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || env('COUNTRY') == 'UAE')
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
function changerequesttype(id)
{
    if(id == 1)
    {
        $('#sale1').show();
        $('#sale2').show();
        $('#sale3').show();
        $('#rent1').hide();
        $('#rent2').hide();
        $('#room').hide();
    }
    else if(id==2)
    {
        $('#sale1').hide();
        $('#sale2').hide();
        $('#sale3').hide();
        $('#rent1').show();
        $('#rent2').show();
        $('#room').hide();
    }
    else
    {
        $('#sale1').hide();
        $('#sale2').hide();
        $('#sale3').hide();
        $('#rent1').hide();
        $('#rent2').hide();
        $('#room').show();
    }
}
    $(document).ready(function() {
        $("#deal_type").change(function(){
            changerequesttype($("#deal_type").val());
        });
    });
    changerequesttype($("#deal_type").val());
    if($("#hideconvertible").val().length>0){
        $("#convertible").val($("#hideconvertible").val());
    }

    if($("#hide_district").val().length>0){
        $("#district_id").val($("#hide_district").val()).trigger("change");
    }
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
    changeaccess();
});

$(document).ready(function() {

    changeaccess();
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
if ($('#img-upload1').length) {
var myDropzone = new Dropzone('#img-upload1' , {
    uploadMultiple:false,
    acceptedFiles: ".jpeg,.jpg,.png",// "image/*"
      parallelUploads: 1,
      maxFiles:1,
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
        $('form#js_form_add_state').append('<input type="hidden" name="document1[]" value="' + response.name + '">')
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
        $('form#add').find('input[name="document1[]"][value="' + name + '"]').remove()
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

        });
        // default image
        this.on("addedfile", function(file) {
            file.previewElement.addEventListener("click", function() {
                $('#img-upload').find('.dz-preview').removeClass('img-cover');
                $(this).addClass('img-cover');
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
}

$(".close").click(function(){
    $('#estatecheck').modal('hide')
})
$(".close1").click(function(){
    $('#estatecheck11').modal('hide')
})
$(".close2").click(function(){
    $('#estatecheck2').modal('hide')
})
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
function changeaccess(){
    $(".not").hide();
    $(".not").each(function(){
        var splaccess= $(this).attr('access').toString().split(",");
        for(var i=0;i<splaccess.length;i++)
        {
            var dealtype=splaccess[i].substring(0,1);
            var estatetype=splaccess[i].substring(1,2);
            var estate_type = $("#estate_type").val();

            if($("#deal_type").val() == dealtype){
                if(estate_type == estatetype){
                    $(this).show();
                    $(this).find(".select2").select2();
                }
            }
        }
    });
}
$("#deal_type").change(function(){
    changeaccess();
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

                            $('#images #media-'+id).remove();

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
$("#exchange").change(function(){
    if($(this).val()==1)
        $("#exchangetext1").removeClass('d-none');
    else
        $("#exchangetext1").addClass('d-none');
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
