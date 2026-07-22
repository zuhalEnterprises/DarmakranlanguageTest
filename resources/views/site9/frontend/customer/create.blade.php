@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => !empty($model)? l('ویرایش تقاضا') :l('ثبت تقاضای جدید')
])
@section('main_content')
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" media="screen" href="/vendor/leaflet/dist/leaflet.css" />
<link rel="stylesheet" media="screen" href="/vendor/filepond/dist/filepond.min.css" />
<style>
    @media (min-width: 700px){
    .modal-dialog {
        max-width: 730px;
        margin: 1.75rem auto;
    }
}
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
    </style>
<!-- Main Theme Styles + Bootstrap-->
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
        <!-- Page content-->
        <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
            <!-- Page content-->
            <div class="row">
                @include('frontend.layouts.sidebar', ['menu' => '4'])
                <!-- Page content-->
                <div class="col-lg-9 col-md-12 mb-5 account add-property">
                    <!-- Breadcrumb-->
                    <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{!empty($model)? l('ویرایش تقاضا') :l('ثبت تقاضای جدید')}}</li>
                        </ol>
                    </nav>
                    <!-- Title-->
                    <div class="mb-4">
                        <h2 class="h5 mb-0">{{!empty($model)? l('ویرایش تقاضا') :l('ثبت تقاضای جدید')}} </h2>
                    </div>
                    <!-- Basic info-->
                    <form  id="js_singup-expert" role="form"  method="POST" action="<?php if (!empty($model)) echo '/customer/update/' . $model->id; else echo '/customer/store'; ?>">
                    @if(!empty($model))
                        @method('put')
                    @endif
                    @csrf
                    <section class="card card-body shadow-sm p-4 mb-4" id="basic-info">

                            <div class="row">

                                <div class="col-sm-6 mb-3">
                                    <label for="gender" class="form-label">
                                        {{l('جنسیت')}}
                                    </label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="male" {{!empty($model) && $model->gender == "male" ? 'selected' :''}}>{{l('آقا')}}</option>
                                        <option value="female" {{!empty($model) && $model->gender == "female" ? 'selected' :''}}>{{l('خانم')}}</option>
                                    </select>
                                </div>
                                @if(empty($model) || $currentUser->isAdmin())
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="name">{{l('نام متقاضی')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text"  id="name" name="name"  value="{{!empty($model)?$model->name:''}}" required>
                                </div>
                                @if($currentUser->isExpert())
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="mobile"> {{l('تلفن همراه')}}
                                    <span class="text-danger">*</span></label>
                                    <input class="form-control " type="text" id="mobile" name="mobile"  value="{{!empty($model)?$model->mobile:$currentUser->mobile}}" required>
                                </div>
                                @else
                                <input type="hidden" value="{{$currentUser->username}}" name="mobile" id="mobile" />
                                @endif

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="mobile"> {{l('شماره واتساپ')}} </label>
                                    <input class="form-control" type="text" id="mobile2" name="mobile2" value="{{!empty($model)?$model->mobile2:''}}">
                                </div>
                                @endif
                                <div class="col-sm-6 mb-3">
                                    <div class="form-label">{{l('نوع درخواست')}}
                                    </div>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="1" id="ap-buyer" name="request_type"  {{!empty($model)?($model->request_type==1?'checked':''):'checked'}}>
                                            <label class="form-check-label" for="ap-buyer">{{l('خرید')}} </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="2" id="ap-rent" name="request_type"  {{!empty($model)?($model->request_type==2?'checked':''):''}} >
                                            <label class="form-check-label" for="ap-rent">{{l('اجاره')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 buyer-content  usage_type1">
                                    <div>
                                        <label class="form-label" for="usage_type">{{l('نوع کاربری')}}</label>
                                        <select name="usage_type" id="usage_type" class="form-select">
                                            @foreach (usage_type() as $key=>$val)
                                            <option value="{{$key}}" {{!empty($model)?($model->usage_type==$key ? 'selected':''):""}}>{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="ap-type">{{l('نوع ملک')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="estate_type" name="estate_type" required>
                                        <option value="" >{{l('انتخاب کنید')}}</option>
                                        <optgroup label="Residential" id="g107">
                                            @foreach (estateTypesResidential() as $key=>$val)
                                            <option value="{{$key}}" {{!empty($model)?($model->estate_type==$key ? 'selected':''):""}} attr="107">{{$val}}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Commercial" id="g109">
                                            @foreach (estateTypesCommercial() as $key=>$val)
                                            <option value="{{$key}}" {{!empty($model)?($model->estate_type==$key ? 'selected':''):""}} attr="109">{{$val}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>

                                @if (!empty($model) && $currentUser->isAdmin())
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="ap-max-buy">{{l('وضعیت تائید مشتری')}}</label>
                                    <select class="form-control" name="status" id="status" style="width:100%">
                                        @foreach (CustomerStatus() as  $key=>$val)
                                        <option value="{{$key}}"  {{!empty($model) && $model->status == $key ? 'selected' :''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if ($currentUser->isAdmin())
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="grade">
                                        {{l('نوع مشتری')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control" name="grade" id="grade" style="width:100%" required>
                                        <option>{{l('انتخاب کنید')}}</option>
                                        @foreach (CustomerGrade() as  $key=>$val)
                                        <option value="{{$key}}"  {{!empty($model) && $model->grade == $key ? 'selected' :''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="country">
                                        {{l('کشور')}}

                                    </label>
                                    <select class="form-control select2" name="country_id" id="country_id" style="width:100%" >
                                        <option value="">{{l('انتخاب کنید')}}</option>
                                        @foreach (country_list() as  $country)
                                        <option value="{{$country->id}}"  {{!empty($model) && $model->country_id == $country->id ? 'selected' : ''}}>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="language">
                                        {{l('زبان')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control select2" name="language_id" id="language_id" style="width:100%" required>
                                        <option value="">{{l('انتخاب کنید')}}</option>
                                        @foreach (language_list() as  $language)
                                        <option value="{{$language->id}}"  {{!empty($model) && $model->language_id == $language->id ? 'selected' : ($language->id == 41?'selected':'')}}>{{$language->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(ss('SITE_ID') != 6)
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="ap-city"> {{l('انتخاب شهر')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select"  name="city_id" id="city_id">
                                        <option value="" >{{l('انتخاب شهر')}}</option>
                                        @foreach($cities as $city2)
                                        <option value="{{$city2->id}}" {{$city2->id == (!empty($model)?$model->city_id : $city->id) ? 'selected' :''}}>{{$city2->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 5)
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" >{{l('منطقه')}}</label>
                                    <select class="form-control select2 area_id" name="area_id" id="area_id" multiple style="width:100%">
                                        @if(isset($city))
                                        <option value="" >{{l('انتخاب کنید')}}</option>
                                        @for($i = 1 ; $i <= $city->count_area ; $i++)
                                            <option value="{{$i}}">منطقه {{$i}}</option>
                                        @endfor
                                        @endif
                                    </select>
                                </div>
                                @endif
                                <div class="col-sm-12 mb-3 district">
                                    <label class="form-label" for="ap-district"> {{l('انتخاب محله‌ درخواستی')}} </label>
                                    <select class="form-select js-example-disabled-results select2" multiple name="districts[]" id="district_id" aria-placeholder="test">
                                        @if(isset($districts))
                                        @foreach($districts as $district)
                                        <option value="{{$district->id}}"  {{!empty($model)?(($model->districts->where('id','=',$district->id)->first() != null)?"selected":''):''}}>{{$district->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <style>
                                    .district .select2-container--default .select2-selection--multiple
                                    {
                                        display:table;
                                        width:100%
                                    }
                                </style>
                                @if(ss('SITE_ID') == 3 && 0)
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="ap-district"> {{l('خیابان')}}
                                    </label>
                                    <select class="form-select js-example-disabled-results"  name="street_id" id="street_id" aria-placeholder="test">
                                    </select>
                                </div>
                                @endif
                                <div class="col-sm-6 mb-3">
                                    <div class="">
                                        <label class="form-label" for="ap-min-area">
                                            {{l('حداقل مساحت')}}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" type="tel" min="1"  id="area_min" name="area_min"  value="{{!empty($model)?$model->area_min:''}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="">
                                        <label class="form-label" for="area_max">
                                            {{l('حداکثر مساحت')}}
                                        </label>
                                        <input class="form-control js_valid_number number" type="tel" id="area_max" name="area_max"  value="{{!empty($model)?$model->area_max:''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 buyer-content d-none min_floor_area1">
                                    <div>
                                        <label class="form-label" for="min_floor_area">{{l('حداقل مساحت زمین')}}</label>
                                        <input class="form-control" type="number"  id="min_floor_area" name="min_floor_area" value="{{$model->min_floor_area??''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 rent-content" style="display: none;">
                                    <div class="">
                                        <label class="form-label" for="rent_min">
                                            {{l('حداقل مبلغ اجاره')}}
                                        </label>
                                        <input class="form-control " type="tel" id="rent_min"   name="rent_min"  onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));" value="{{!empty($model)?toPersianNumbers($model->rent_min):''}}" >
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 rent-content" style="display: none;">
                                    <div class="">
                                        <label class="form-label" for="rent_max">{{l('حداکثر مبلغ اجاره')}}</label>
                                        <input class="form-control " type="tel" id="rent_max"   name="rent_max"  onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));" value="{{!empty($model)?toPersianNumbers($model->rent_max):''}}" >
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3 buyer-content">
                                    <div class="">
                                        <label class="form-label" for="price_min">
                                            {{l('حداقل مبلغ خرید')}}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control first-letter:number"  id="price_min" name="price_min"
                                        placeholder="{{l('حداقل مبلغ را وارد کنید')}}" onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"   value="{{!empty($model)?toPersianNumbers($model->price_min):''}}" required>
                                        <div class="divprice"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 buyer-content">
                                    <div class="">
                                        <label class="form-label" for="price_max">
                                            {{l('حداکثر مبلغ خرید')}}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control " id="price_max" name="price_max"
                                            placeholder="{{l('حداکثر مبلغ را وارد کنید')}}" onkeypress="OnlyNumber(event,false)"  onkeyup="SplitNumber($(this));"  value="{{!empty($model)?toPersianNumbers($model->price_max):''}}" >
                                            <div class="divprice"></div>
                                    </div>
                                </div>
                                <!--div class="col-sm-6 mb-3 buyer-content  form-check form-switch">
                                    <label  class="form-label" for="compensation">{{l('قابلیت معاوضه')}}</label>
                                    <input class="form-check-input" id="compensation" {{!empty($model)?($model->compensation==1?"checked":""):""}} value="1" type="checkbox" name="compensation">
                                </div-->
                                @endif

                                <div class="col-sm-4 mb-3 buyer-content d-none max_room_count1">
                                    <div>
                                        <label  class="form-label" for="max_room_count">{{l('حداقل تعداد خواب')}}</label>
                                        <select class="form-control" name="max_room_count" id="max_room_count">
                                            <option value="">{{l('انتخاب کنید')}}</option>
                                            <option value="0" {{!empty($model)?($model->max_room_count== 0 ? 'selected' : ''):''}}>{{l('سوئیت')}}</option>
                                            <option value="1" {{!empty($model)?($model->max_room_count== 1 ? 'selected' : ''):''}}>1</option>
                                            <option value="2" {{!empty($model)?($model->max_room_count== 2 ? 'selected' : ''):''}}>2</option>
                                            <option value="3" {{!empty($model)?($model->max_room_count== 3 ? 'selected' : ''):''}}>3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 mb-3 buyer-content d-none max_building_age1">
                                    <div>
                                        <label  class="form-label" for="max_building_age">{{l('حداکثر عمر بنا')}}</label>
                                        <select class="form-control" name="max_building_age" id="max_building_age">
                                            <option value="">{{l('انتخاب کنید')}}</option>
                                            <option value="1" {{!empty($model)?($model->max_building_age== 1 ? 'selected' : ''):''}}>{{l('حداکثر 1 سال')}}</option>
                                            <option value="2" {{!empty($model)?($model->max_building_age== 2 ? 'selected' : ''):''}}>{{l('حداکثر 2 سال')}}</option>
                                            <option value="3" {{!empty($model)?($model->max_building_age== 3 ? 'selected' : ''):''}}>{{l('حداکثر 5 سال')}}</option>
                                            <option value="4" {{!empty($model)?($model->max_building_age== 4 ? 'selected' : ''):''}}>{{l('حداکثر 10 سال')}}</option>
                                            <option value="5" {{!empty($model)?($model->max_building_age== 5 ? 'selected' : ''):''}}>{{l('حداکثر 20 سال')}}</option>
                                            <option value="6" {{!empty($model)?($model->max_building_age== 6 ? 'selected' : ''):''}}>{{l('حداکثر 30 سال')}}</option>
                                            <option value="7" {{!empty($model)?($model->max_building_age== 7 ? 'selected' : ''):''}}>{{l('بیش از 30 سال')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3 buyer-content d-none">
                                    <label  class="form-label" for="max_building_age">{{l('پیش فروش')}}</label>
                                    <select class="form-control" name="conditions[]">
                                        <option value="">{{l('انتخاب کنید')}}</option>
                                        <option value="15" {{!empty($model)?selectValueCreate($model->conditions,15):""}}>{{l('پیش فروش')}}</option>
                                        <option value="371" {{!empty($model)?selectValueCreate($model->conditions,371):""}}>{{l('آماده')}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 mb-3 buyer-content d-none">
                                    <label class="form-label">{{l('تاریخ تکمیل')}}</label>
                                    <input name="completion_date" id="completion_date" class="form-control date-picker rounded pe-5" type="text" value="{{!empty($model)?$model->completion_date:''}}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                                </div>
                                <div class="col-sm-6 mb-3 buyer-content">
                                    <div class="mb-4">
                                        <label class="form-label" for="conditions304">
                                            {{l('کلید نخورده')}}
                                        </label>
                                        <select class="form-control" name="conditions[]">
                                            <option value="">{{l('انتخاب کنید')}}</option>
                                            <option value="304" {{!empty($model)?selectValueCreate($model->conditions,304):""}}>{{l('کلید نخورده')}}</option>
                                            <option value="349" {{!empty($model)?selectValueCreate($model->conditions,349):""}}>{{l('استفاده شده')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 buyer-content" style="{{(isset($model) && $model->request_type==2)?'display: none;':''}}">
                                    <div class="mb-4">
                                        <label class="form-label" for="purchase_reason">{{l('دلیل خرید')}}</label>
                                        <select id="select-location" class="form-control" name="purchase_reason">
                                            <option value="">{{l('انتخاب نمایید')}}</option>
                                            @foreach(purchaseReasons() as $k=>$v)
                                            <option value="{{$k}}" {{!empty($model)?($model->purchase_reason == $k ? 'selected':''):'selected'}}>{{l($v)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3  buyer-content form-check form-switch">
                                    <div class="mb-4" style="padding-left:10px">

                                        <input class="form-check-input" id="conditions348" {{!empty($model)?checkValueCreate($model->conditions,348):""}} value="348" type="checkbox" name="conditions[]">
                                        <label class="form-label" for="conditions348">
                                            {{l('فول امکانات')}}
                                        </label>
                                    </div>
                                </div>



                                <div class="col-sm-12 mb-3 buyer-content">
                                    <label class="form-label">{{l('وضعیت نقدینگی')}}</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="full-cash" name="financial_liquidity_type"
                                                name="ap-cash-type" {{!empty($model)?($model->financial_liquidity_type==1?'checked':''):'checked'}} value="1">
                                            <label class="form-check-label" for="ap-full-cash">{{l('کاملا نقد')}} </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="part-cash" name="financial_liquidity_type"
                                                name="ap-cash-type" {{!empty($model)?($model->financial_liquidity_type==2?'checked':''):'checked'}} value="2">
                                            <label class="form-check-label" for="ap-cash">{{l('بخشی نقد')}}</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="none-cash" name="financial_liquidity_type"
                                                name="ap-cash-type" {{!empty($model)?($model->financial_liquidity_type==3?'checked':''):'checked'}} value="3">
                                            <label class="form-check-label" for="ap-non-cash">{{l('غیر نقد')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <div>
                                        <label  class="form-label" for="label">{{l('منبع')}}</label>
                                        <select class="form-control" name="acquaintance_type" id="acquaintance_type">
                                            @foreach($acquaintancelist as $acquaintance)
                                            <option value="{{$acquaintance->id}}" {{!empty($model)?($model->acquaintance_type == $acquaintance->id ? 'selected':''):'selected'}}>{{$acquaintance->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <div>
                                        <label  class="form-label" for="label">{{l('توضیح منبع')}}</label>
                                        <input class="form-control" type="text"  id="acquaintance" name="acquaintance"  value="{{!empty($model)?$model->acquaintance:''}}" >
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <div>
                                        <label  class="form-label" for="label">{{l('لیبل')}}</label>
                                        <select class="form-control" name="label" id="label">
                                            <option value="0" {{!empty($model)?($model->label== 0 ? 'selected' : ''):''}}>Beginer</option>
                                            <option value="1" {{!empty($model)?($model->label== 1 ? 'selected' : ''):''}}>{{l('برنزی')}}</option>
                                            <option value="2" {{!empty($model)?($model->label== 2 ? 'selected' : ''):''}}>{{l('نقره ای')}}</option>
                                            <option value="3" {{!empty($model)?($model->label== 3 ? 'selected' : ''):''}}>{{l('طلایی')}}</option>
                                            <option value="4" {{!empty($model)?($model->label== 4 ? 'selected' : ''):''}}>{{l('الماس')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="">
                                        <label class="form-label" for="ap-max-buy">{{l('یادداشت')}}</label>
                                        <textarea  name="note" id="desc-state" class="form-control" rows="6" required="">{{!empty($model)?$model->note:''}}</textarea>
                                    </div>
                                </div>
                                @if((ss('SITE_ID') == 2 || ss('SITE_ID') == 3 || ss('SITE_ID') == 5) && $currentUser->isExpert() && !empty($model))
                                <div class="col-sm-6 mb-3">
                                    <div class="">
                                        @if($model->resenddate <= date('Y-m-d'))
                                        <label class="form-label" for="resenddate">{{l('وضعیت ارسال پیامک املاک متناسب')}} </label>
                                        <select name="resenddate">
                                            <option value="">{{ l('ارسال طبق زمانبندی') }}</option>
                                            <option value="{{date('Y-m-d', time() + 86400)}}">{{l('توقف به مدت 1 روز')}}</option>
                                            <option value="{{date('Y-m-d', time() + (2*86400))}}">{{l('توقف به مدت 2 روز')}}</option>
                                            <option value="{{date('Y-m-d', time() + (3*86400))}}">{{l('توقف به مدت 3 روز')}}</option>
                                            <option value="{{date('Y-m-d', time() + (4*86400))}}">{{l('توقف به مدت 4 روز')}}</option>
                                            <option value="{{date('Y-m-d', time() + (5*86400))}}">{{l('توقف به مدت 5 روز')}}</option>
                                            @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 2)
                                            <option value="{{date('Y-m-d', time() + (1000*86400))}}">{{l('توقف کامل')}}</option>
                                            @endif
                                        </select>
                                        @else
                                        <label class="form-label" for="resenddate">{{l('ارسال دوباره پیامک املاک متناسب')}}</label>
                                        <input type="checkbox" name="resenddate" value="{{date('Y-m-d')}}">
                                        @endif
                                    </div>
                                </div>
                                @if(ss('SITE_ID') != 5)
                                <div class="col-sm-6 mb-3">
                                    <div class="">
                                        <label class="form-label" for="countSms">{{l('تعداد املاک ارسالی در هر بار ارسال پیامک املاک متناسب')}} </label>
                                        <select name="countSms">
                                            <option value="">{{l('پیش فرض')}}</option>
                                            <option value="1" {{!empty($model) && $model->countSms == 1 ? 'selected':''}}>1</option>
                                            <option value="2" {{!empty($model) && $model->countSms == 2 ? 'selected':''}}>2</option>
                                            <option value="3" {{!empty($model) && $model->countSms == 3 ? 'selected':''}}>3</option>
                                            <option value="4" {{!empty($model) && $model->countSms == 4 ? 'selected':''}}>4</option>
                                            <option value="5" {{!empty($model) && $model->countSms == 5 ? 'selected':''}}>5</option>
                                            <option value="6" {{!empty($model) && $model->countSms == 6 ? 'selected':''}}>6</option>
                                            <option value="7" {{!empty($model) && $model->countSms == 7 ? 'selected':''}}>7</option>
                                            <option value="8" {{!empty($model) && $model->countSms == 8 ? 'selected':''}}>8</option>
                                            <option value="9" {{!empty($model) && $model->countSms == 9 ? 'selected':''}}>9</option>
                                            <option value="10" {{!empty($model) && $model->countSms == 10 ? 'selected':''}}>10</option>
                                            <option value="11" {{!empty($model) && $model->countSms == 11 ? 'selected':''}}>11</option>
                                            <option value="12" {{!empty($model) && $model->countSms == 12 ? 'selected':''}}>12</option>
                                            <option value="13" {{!empty($model) && $model->countSms == 13 ? 'selected':''}}>13</option>
                                            <option value="14" {{!empty($model) && $model->countSms == 14 ? 'selected':''}}>14</option>
                                            <option value="15" {{!empty($model) && $model->countSms == 15 ? 'selected':''}}>15</option>
                                            <option value="16" {{!empty($model) && $model->countSms == 16 ? 'selected':''}}>16</option>
                                            <option value="17" {{!empty($model) && $model->countSms == 17 ? 'selected':''}}>17</option>
                                            <option value="18" {{!empty($model) && $model->countSms == 18 ? 'selected':''}}>18</option>
                                            <option value="19" {{!empty($model) && $model->countSms == 19 ? 'selected':''}}>19</option>
                                            <option value="20" {{!empty($model) && $model->countSms == 20 ? 'selected':''}}>20</option>
                                        </select>
                                    </div>
                                </div>
                                @endif
                                @endif
                                @if ($currentUser->isAdmin())
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label" for="ap-max-buy">{{l('انتخاب مشاور')}}</label>
                                    <select class="form-control select2" name="expertid" id="expertid" style="width: 100%;">
                                        <option value="">{{l('انتخاب کنید')}}</option>
                                        @foreach($users as $item)
                                            <option value="{{$item->id}}" {{!empty($model) && $model->user_id == $item->id ? 'selected' :''}}>{{$item->fullname()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @elseif($currentUser->isExpert())
                                <input type="hidden" name="expertid" value="{{$currentUser->id}}">
                                @endif
                                <div class="col-sm-12 mb-3">
                                    <input type="hidden" name="user_id" value="{{$currentUser->id}}">
                                    <button type="submit" onclick="customercheck1()" class="btn btn-primary btn-lg d-block mb-2">
                                        {{!empty($model)? l('ویرایش تقاضا') :l('ثبت تقاضای جدید')}}
                                    </button>
                                </div>
                            </div>

                    </section>

                    </form>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="estatecheck"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> {{l('مشتری های مشابه')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="estatecheck1" style="max-height:550px;overflow:auto">
            </div>
          </div>
        </div>
      </div>
      <div class="modal1 fade" id="estatecheck11"  tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> {{l('مشتری های مشابه شماره تلفن اول ')}} </h5>
            </div>
            <div class="modal-body" id="estatecheck111" style="max-height:550px;overflow:auto">
            </div>
            <div class="modal-footer d-flex justify-content-center" id="estatecheck11">
                @if(ss('SITE_ID') != 6)
                <div class="btn btn-primary checkaccept1">{{l('ثبت کن')}}</div>
                @endif
                <div class="btn btn-danger close1">{{l('بستن')}}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal1 fade" id="estatecheck2"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"> {{l('مشتری های مشابه شماره تلفن دوم ')}} </h5>
            </div>
            <div class="modal-body" id="estatecheck22" style="max-height:500px;overflow:auto">
            </div>
            <div class="modal-footer d-flex justify-content-center" id="estatecheck11">
                @if(ss('SITE_ID') != 6)
                <div class="btn btn-primary checkaccept2">{{l('ثبت کن')}}</div>
                @endif
                <div class="btn btn-danger close2">{{l('بستن')}}</div>
            </div>
        </div>
    </div>
</div>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
<script src="/vendor/jquery-3.6.0.js"></script>
<script src="/vendor/simplebar/dist/simplebar.min.js"></script>
<script src="/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
<script src="/vendor/leaflet/dist/leaflet.js"></script>
<script src="/vendor/filepond/dist/filepond.min.js"></script>
<script src="/vendor/cleave.js/dist/cleave.min.js"></script>
<script src="/vendor/select2/select2.min.js"></script>
<!-- Main theme script-->
<script src="/js/theme.min.js"></script>
<script src="{{asset('/assets/js/valid.js')}}"></script>
<script>
function changeusagetype(id)
{
    if(id == 107)
    {
        $('#g107').show();
        $('#g109').hide();
    }
    else
    {
        $('#g109').show();
        $('#g107').hide();
    }
}
$(document).ready(function() {
    $("#usage_type").change(function(){
        $("#estate_type").val('');
        changeusagetype($("#usage_type").val());
    });
});
changeusagetype($("#usage_type").val());
var mobilecheck1=true;
var mobilecheck2=true;
function customercheck(id,val)
{
    if(val==1){
     mobilecheck1=true;
    }
    else if(val==2)
    {
         mobilecheck2=true;
    }
    if(id.length>=11){
        $.ajax({
            type: 'POST',
            url: '/customer/customercheck',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            data: {
                _method:'post',
                mobile:id,
            },
            error: function (xhr, status, error) {
            },
            success: function (response) {
                if(response.count>0){
                    if(val==1)
                        mobilecheck1=false;
                    else if(val==2)
                        mobilecheck2=false;
                    $('#estatecheck').modal('show')
                    $("#estatecheck1").html(response.html);
                }
                else
                {
                    if(val==1)
                        mobilecheck1=true;
                    else if(val==2)
                        mobilecheck2=true;
                }
            }
        });
    }
}
function changeaccess(){
    $(".not").hide();
    $(".not").each(function(){
        var splaccess= $(this).attr('access').toString().split(",");
        for(var i=0;i<splaccess.length;i++){
            var dealtype=splaccess[i].substring(0,1);
            var estatetype=splaccess[i].substring(1,2);
            var estate_type = $("#estate_type").val();
            @if (env('COUNTRY') == 'UAE')
            if(estate_type>4)
            {
                estate_type = 4;
            }
            @endif
            if($("#deal_type").val()==dealtype){
                if(estate_type == estatetype){
                    $(this).show();
                    $(this).find(".select2").select2({
                        closeOnSelect: false
                    });
                }
            }
        }
    });
}
function customercheck1(){
    if(mobilecheck1==false){
        $.ajax({
            type: 'POST',
            url: '/customer/customercheck',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            data: {
                _method:'post',
                mobile:$("#mobile").val(),
            },
            error: function (xhr, status, error) {
            },
            success: function (response) {
                if(response.count>0){
                    $('#estatecheck11').modal('show')
                    $("#estatecheck111").html(response.html);
                }
            }
        });
    }
    if(mobilecheck2==false){
        $.ajax({
            type: 'POST',
            url: '/customer/customercheck',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            data: {
                _method:'post',
                mobile:$("#mobile2").val(),
            },
            error: function (xhr, status, error) {
            },
            success: function (response) {
                if(response.count>0){
                    $('#estatecheck2').modal('show')
                    $("#estatecheck22").html(response.html);
                }
            }
        });
    }
    if(mobilecheck2==true && mobilecheck1==true)
    {
        $("#js_singup-expert").submit();
    }
}
$(".checkaccept1").click(function()
{
    $('#estatecheck11').modal('hide')
    mobilecheck1=true;
    if(mobilecheck2==true)
    {
        $("#js_singup-expert").submit();
    }
});
$(".checkaccept2").click(function()
{
    $('#estatecheck2').modal('hide')
    mobilecheck2=true;
    if(mobilecheck1==true)
    {
        $("#js_singup-expert").submit();
    }
})
$('.select2').select2({
    closeOnSelect: false
});
function OnlyNumber(event,HasBullet){
    if(HasBullet){
        var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,<>+\/?-]/;
    }
    else{
        var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,.<>+\\/?-]/; } var key = String.fromCharCode(!event.charCode ? event.which : event.charCode); if (blockSpecialRegex.test(key)) { event.preventDefault(); } } "use strict";var delimiter=l("و"),zero=l("صفر"),negative=l("منفی"),letters=[["",l("یک"),l("دو"),l("سه"),l("چهار"),l("پنج"),l("شش"),l("هفت"),l("هشت"),l("نه")],["ده",l("یازده"),l("دوازده"),l("سیزده"),l("چهارده"),l("پانزده"),l("شانزده"),l("هفده"),l("هجده"),l("نوزده"),l("بیست")],["","",l("بیست"),l("سی"),l("چهل"),l("پنجاه"),l("شصت"),l("هفتاد"),l("هشتاد"),l("نود")],["",l("یکصد"),l("دویست"),l("سیصد"),l("چهارصد"),l("پانصد"),l("ششصد"),l("هفتصد"),l("هشتصد"),l("نهصد")],["",l("هزار"),l("میلیون"),l("میلیارد"),l("بیلیون"),l("بیلیارد"),l("تریلیون"),l("تریلیارد"),l("کوآدریلیون"),l("کادریلیارد"),l("کوینتیلیون"),l("کوانتینیارد"),l("سکستیلیون"),l("سکستیلیارد"),l("سپتیلیون"),l("سپتیلیارد"),l("اکتیلیون"),l("اکتیلیارد"),l("نانیلیون"),l("نانیلیارد"),l("دسیلیون"),l("دسیلیارد")]],decimalSuffixes=["",l("دهم"),l("صدم"),l("هزارم"),l("ده‌هزارم"),l("صد‌هزارم"),l("میلیونوم"),l("ده‌میلیونوم"),l("صدمیلیونوم"),l("میلیاردم"),l("ده‌میلیاردم"),l("صد‌‌میلیاردم")],prepareNumber=function(e){var t=e;return"number"==typeof t&&(t=t.toString()),t.length%3==1?t="00".concat(t):t.length%3==2&&(t="0".concat(t)),t.replace(/\\d{3}(?=\\d)/g,"$&*").split("*")},tinyNumToWord=function(e){if(0===parseInt(e,0))return"";var t=parseInt(e,0);if(t<10)return letters[0][t];if(t<=20)return letters[1][t-10];if(t<100){var r=t%10,n=(t-r)/10;return r>0?letters[2][n]+delimiter+letters[0][r]:letters[2][n]}var i=t%10,u=(t-t%100)/100,s=(t-(100*u+i))/10,a=[letters[3][u]],o=10*s+i;return 0===o?a.join(delimiter):(o<10?a.push(letters[0][o]):o<=20?a.push(letters[1][o-10]):(a.push(letters[2][s]),i>0&&a.push(letters[0][i])),a.join(delimiter))},convertDecimalPart=function(e){return""===(e=e.replace(/0*$/,""))?"":(e.length>11&&(e=e.substr(0,11)),l("ممیز")+Num2persian(e)+" "+decimalSuffixes[e.length])},Num2persian=function(e){e=e.toString().replace(/[^0-9.-]/g,"");var t=!1,r=parseFloat(e);if(isNaN(r))return zero;if(0===r)return zero;r<0&&(t=!0,e=e.replace(/-/g,""));var n="",i=e,u=e.indexOf(".");if(u>-1&&(i=e.substring(0,u),n=e.substring(u+1,e.length)),i.length>66)return"خارج از محدوده";for(var s=prepareNumber(i),a=[],o=0;o<s.length;o+=1){var l=tinyNumToWord(s[o]);""!==l&&a.push(l+letters[4][s.length-(o+1)])}return n.length>0&&(n=convertDecimalPart(n)),(t?negative:"")+a.join(delimiter)+n};String.prototype.toPersianLetter=function(){return Num2persian(this)},Number.prototype.toPersianLetter=function(){return Num2persian(parseFloat(this).toString())},String.prototype.num2persian=function(){return Num2persian(this)},Number.prototype.num2persian=function(){return Num2persian(parseFloat(this).toString())}; function toEnglishNumber(strNum) { var pn = ["۰", l("۱"), l("۲"), l("۳"), l("۴"), l("۵"), l("۶"), l("۷"), l("۸"), l("۹")]; var en = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]; var cache = strNum; for (var i = 0; i < 10; i++) {
        //var regex_fa = new RegExp(pn[i], 'g');
        cache = cache.replace(pn[i], en[i]);
    }
    return cache;
}
    function SplitNumber(obj){
        var Getnumber= toEnglishNumber(obj.val()).replace(/,/g,'');
        obj.val(Getnumber.split("").reverse().join("").replace(/(.{3}\B)/g, "$1,").split("").reverse().join(""));
        @if(env('COUNTRY') != 'UAE')
        obj.parent().find(".divprice").html(obj.val().num2persian()+" تومان");
        @endif
    }
    window.SplitNumber=SplitNumber;
    @if(ss('SITE_ID') != 6)
    const buyer = document.getElementById('ap-buyer')
    const rent = document.getElementById('ap-rent')
    const buyerContent = document.querySelectorAll('.buyer-content')
    const rentContent = document.querySelectorAll('.rent-content')
    buyer.addEventListener('click', () => {
        $('#price_min').prop('required',true);
        $('#price_max').prop('required',true);
        rentContent.forEach(item => {
            item.style.display = 'none'
        })
        buyerContent.forEach(item => {
            item.style.display = 'block'
        })
    });
    if($("#ap-buyer").prop('checked')==true){
        $('#price_min').prop('required',true);
        $('#price_max').prop('required',true);
        rentContent.forEach(item => {
            item.style.display = 'none'
        })
        buyerContent.forEach(item => {
            item.style.display = 'block'
        })
    }
    if($("#ap-rent").prop('checked')==true){
        $('#price_min').prop('required',false);
        $('#price_max').prop('required',false);
        buyerContent.forEach(item => {
            item.style.display = 'none'
        })
        rentContent.forEach(item => {
            item.style.display = 'block'
        })
    }
    rent.addEventListener('click', () => {
        $('#price_min').prop('required',false);
        $('#price_max').prop('required',false);
        buyerContent.forEach(item => {
            item.style.display = 'none'
        })
        rentContent.forEach(item => {
            item.style.display = 'block'
        })
    })
    @endif
    changeaccess();
    estate_type_change();
    function estate_type_change(){
        changeaccess();
        $(".min_front_area1").addClass('d-none');
        $(".max_unit_in_floor1").addClass('d-none');
        $(".max_building_age1").addClass('d-none');
        $(".conditions151").addClass('d-none');
        $(".floor_count1").addClass('d-none');
        $(".floor_start1").addClass('d-none');
        $(".min_floor_area1").addClass('d-none');
        $(".min_street_width1").addClass('d-none');
        $(".min_density1").addClass('d-none');
        $(".build_license1").addClass('d-none');
        $(".geography1").addClass('d-none');
        $(".max_room_count1").addClass('d-none');
        if($("#estate_type").val()==1 || $("#estate_type").val()==2 || $("#estate_type").val()==6)
        {
            $(".max_room_count1").removeClass('d-none');
            $(".min_floor_count1").removeClass('d-none');
            $(".parking1").removeClass('d-none');
            $(".hair-dryer1").removeClass('d-none');
            $(".warehouse1").removeClass('d-none');
        }
        if($("#estate_type").val()==3 || $("#estate_type").val()==2){
            $(".min_front_area1").removeClass('d-none');
        }
        if($("#estate_type").val()==1)
        {
            $(".max_unit_in_floor1").removeClass('d-none');
            $(".max_building_age1").removeClass('d-none');
            $(".conditions151").removeClass('d-none');
            $(".floor_count1").removeClass('d-none');
        }
        if($("#estate_type").val()==6)
        {
            $(".max_unit_in_floor1").removeClass('d-none');
            $(".max_building_age1").removeClass('d-none');
            $(".conditions151").removeClass('d-none');
            $(".floor_count1").removeClass('d-none');
        }
        if($("#estate_type").val()==2)
        {
            $(".floor_start1").removeClass('d-none');
            $(".min_floor_area1").removeClass('d-none');
            $(".min_street_width1").removeClass('d-none');
            $(".min_density1").removeClass('d-none');
            $(".geography1").removeClass('d-none');
            $(".build_license1").removeClass('d-none');
        }
        if($("#estate_type").val()==4)
        {
            $(".build_license1").removeClass('d-none');
            $(".min_density1").removeClass('d-none');
        }
    }
    $(document).ready(function(){
        $(".max_room_count1").removeClass('d-none');
        $(".min_floor_count1").removeClass('d-none');
        $(".max_unit_in_floor1").removeClass('d-none');
        $(".max_building_age1").removeClass('d-none');
        $(".conditions151").removeClass('d-none');
        $(".floor_count1").removeClass('d-none');
        $("#estate_type").change(function ()
        {
            estate_type_change();
        });
        estate_type_change();
    });
</script>
<script src="/admin2/dist/js/regions.js"></script>
<script>
$(document).ready(function() {
    $("#mobile").change(function(){
        customercheck($(this).val(),1);
    });
    $(".close").click(function(){
        $('#estatecheck').modal('hide')
    })
    $(".close1").click(function(){
        $('#estatecheck11').modal('hide')
    })
    $(".close2").click(function(){
        $('#estatecheck2').modal('hide')
    })
    $("#mobile2").change(function(){
        customercheck($(this).val(),2);
    });
    getCities();
    getDistricts();
    getAreas();
    getAreaDistrict();
    @if(ss('SITE_ID') == 3)
        getStreets();
    @endif
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
});
$("#deal_type").change(function(){
    changeaccess();
});
function changeaccess(){
        $(".not").hide();
        $(".not").each(function(){
            var splaccess= $(this).attr('access').toString().split(",");
            for(var i=0;i<splaccess.length;i++){
                var dealtype=splaccess[i].substring(0,1);
                var estatetype=splaccess[i].substring(1,2);
                if( $('input[name="request_type"]').val()==dealtype){
                    if($("#estate_type").val()==estatetype){
                        $(this).show();
                        $(this).find("select").select2({
                            closeOnSelect: false
                        });
                    }
                }
            }
        });
    }
    changeaccess();
</script>
@endsection











