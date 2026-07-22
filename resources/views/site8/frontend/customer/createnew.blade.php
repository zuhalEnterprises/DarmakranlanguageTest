@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME')
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
        @include(ss('THEME').'.frontend.layouts.header_v2')
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
                            <li class="breadcrumb-item active" aria-current="page">{{l('ثبت خریدار')}}</li>
                        </ol>
                    </nav>
                    <!-- Title-->
                    <div class="mb-4">
                        <h1 class="h2 mb-0">{{l('ثبت خریدار جدید')}}</h1>
                    </div>
                    <!-- Basic info-->
                    <form  id="js_singup-expert" role="form"  method="POST" action="/customer/store">
                    @csrf
                    <section class="card card-body shadow-sm p-4 mb-4" id="basic-info">
                        <h2 class="h5 mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>{{l('اطلاعات خریدار')}}
                        </h2>
                            <div class="row">
                                @if(env('COUNTRY') != 'UAE')
                                <div class="col-sm-6 mb-3">
                                    <label for="gender" class="form-label fw-bold">{{ l('جنسیت') }}

                                    </label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="male">{{ l('آقا') }}</option>
                                        <option value="female">{{ l('خانم') }}</option>
                                    </select>
                                </div>
                                @endif
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="name">{{l('نام و نام خانوداگی خریدار')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text"  id="name" name="name" value="" required>
                                </div>
                                @if($currentUser->isExpert() || $currentUser->isAdmin())
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="mobile"> {{l('تلفن همراه')}}
                                    <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="mobile" name="mobile" maxlength="11" minlength="11" value="{{$currentUser->mobile}}" required>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="mobile"> {{l('تلفن همراه 2')}} </label>
                                    <input class="form-control" type="text" id="mobile2" name="mobile2" maxlength="11" value="{{$currentUser->mobile2}}">
                                </div>
                                @endif
                                   <div class="col-sm-4 mb-3">
                                            <div class="form-label fw-bold">{{l('نوع درخواست')}}
                                            </div>
                                            <div class="d-flex gap-3 mt-3">
                                                <div class="form-check">

                                                    <input class="form-check-input" type="radio" value="1" id="ap-buyer" name="request_type" checked>
                                                    <label class="form-check-label" for="ap-buyer">{{l('خرید')}} </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="2" id="ap-rent"
                                                        name="request_type" @php $currentUser->req_type == 2 ?? 'checked' @endphp>
                                                    <label class="form-check-label" for="ap-rent">{{l('اجاره')}}</label>
                                                </div>
                                            </div>
                                        </div>

                                <div class="col-sm-4 mb-3">
                                    <label class="form-label fw-bold" for="ap-city"> {{l('انتخاب شهر')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select"  name="city_id" id="city_id" required>
                                        <option value="">{{l('انتخاب شهر')}}</option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}" >{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                                <div class="col-md-4 col-lg-4 col-sm-12 mt-2">
                                    <label>{{l('منطقه')}}</label>
                                    <select class="form-control select2 area_id" name="area_id" id="area_id" multiple style="width:100%">
                                        <option value="" >{{l('انتخاب کنید')}}</option>
                                        @for($i = 1 ; $i <= $city->count_area ; $i++)
                                            <option value="{{$i}}">منطقه {{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                @endif
                                <div class="col-sm-12 mb-3 district">
                                    <label class="form-label fw-bold" for="ap-district"> {{l('انتخاب محله‌ درخواستی')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select js-example-disabled-results select2" multiple name="districts[]" id="district_id" aria-placeholder="test" required>
                                        @if(isset($districts))
                                        @foreach($districts as $district)
                                        <option value="{{$district->id}}"  {{$district->id == (!empty($estate)?$estate->district_id:'') ? 'selected' :''}}>{{$district->name}}</option>
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

                                <div class="col-sm-6 mb-3 rent-content" style="display: none;">
                                    <div class="">
                                        <label class="form-label fw-bold" for="rent_min">
                                            {{l('حداقل مبلغ اجاره')}}
                                        </label>
                                        <input class="form-control js_valid_number" type="tel" id="rent_min" onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"  name="rent_min" value="{{$currentUser->rent_min}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 rent-content" style="display: none;">
                                    <div class="">
                                        <label class="form-label fw-bold" for="rent_max">{{l('حداکثر مبلغ اجاره')}}</label>
                                        <input class="form- js_valid_number" type="tel" id="rent_max" onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"  name="rent_max" value="{{$currentUser->rent_max}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 rent-content" style="display: none;">
                                    <div class="">
                                        <label class="form-label fw-bold" for="deposit_min">{{l('حداقل مبلغ ودیعه')}}
                                            </label>
                                        <input class="form-control js_valid_number" type="tel" id="deposit_min" onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));" name="mortgage_min" value="{{$currentUser->deposit_min}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 rent-content" style="display: none;">
                                    <div class="">
                                        <label class="form-label fw-bold" for="deposit_max">{{l('حداکثر مبلغ ودیعه')}}</label>
                                        <input class="form-control js_valid_number" type="tel"  id="deposit_max" onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));" name="mortgage_max" value="{{$currentUser->deposit_max}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 buyer-content">
                                    <div class="">
                                        <label class="form-label fw-bold" for="price_min">
                                            {{l('حداقل مبلغ خرید')}}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control js_valid_number"  id="price_min" name="price_min"
                                        placeholder="{{l('حداقل مبلغ را وارد کنید')}}"  onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"  value="{{$currentUser->price_min}}"  required>
                                        <div class="divprice"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 buyer-content">
                                    <div class="">
                                        <label class="form-label fw-bold" for="price_max">
                                            {{l('حداکثر مبلغ خرید')}}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control js_valid_number" id="price_max" name="price_max"
                                            placeholder="{{l('حداکثر مبلغ را وارد کنید')}}" onkeypress="OnlyNumber(event,false)"  onkeyup="SplitNumber($(this));"  value="{{$currentUser->price_max}}"  required>
                                            <div class="divprice"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="accordion " id="accordionExample" >
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        {{ l('مشخصات تکمیلی') }}
                                    </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">


                                        <div class="row">

                                                <div class="col-sm-4 mb-3">
                                                    <div class="form-label fw-bold">{{l('وضعیت نقدینگی')}}
                                                    </div>
                                                    <div class="d-flex gap-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="full-cash" name="financial_liquidity_type"
                                                                name="ap-cash-type" @php $currentUser->financial_liquidity_type == 1 ?? 'checked' @endphp value="1">
                                                            <label class="form-check-label" for="ap-full-cash">{{l('کاملا نقد')}} </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="part-cash" name="financial_liquidity_type"
                                                                name="ap-cash-type" @php $currentUser->financial_liquidity_type == 2 ?? 'checked' @endphp value="2">
                                                            <label class="form-check-label" for="ap-cash">{{l('بخشی نقد')}}</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="none-cash" name="financial_liquidity_type"
                                                                name="ap-cash-type" @php $currentUser->financial_liquidity_type == 3 ?? 'checked' @endphp value="3">
                                                            <label class="form-check-label" for="ap-non-cash">{{l('غیر نقد')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3">
                                                    <label class="form-label fw-bold" for="ap-type">{{l('نوع ملک')}} <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="estate_type" name="estate_type" required>
                                                        <option value="" disabled hidden>{{l('انتخاب نوع ملک')}}</option>
                                                        @foreach (estateTypes() as $key=>$val)
                                                        <option value="{{$key}}" @php $currentUser->estate_type == $key ?? 'selected' @endphp>{{$val}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 mb-3">
                                                    <div class="">
                                                        <label class="form-label fw-bold" for="ap-min-area">
                                                            {{l('حداقل متراژ درخواستی')}}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input class="form-control js_valid_number" type="tel" min="1"  id="area_min" name="area_min"  value="{{$currentUser->area_min}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3">
                                                    <div class="">
                                                        <label class="form-label fw-bold" for="area_max">
                                                            {{l('حداکثر متراژ درخواستی')}}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input class="form-control js_valid_number" type="tel"  id="area_max" name="area_max"  value="{{$currentUser->area_max}}" required>
                                                    </div>
                                                </div>
                                                @if($currentUser->isExpert())

                                                <div class="col-sm-4 mb-3 buyer-content">
                                                    <div>
                                                        <label  class="form-label fw-bold" for="label">{{ l('اولویت') }}</label>
                                                        <select class="form-control" name="label" id="label">
                                                            <option value="">{{ l('انتخاب کنید') }}</option>
                                                            <option value="1" {{!empty($model)?($model->label== 1 ? 'selected' : ''):''}}>{{ l('طلایی') }}</option>
                                                            <option value="2" {{!empty($model)?($model->label== 2 ? 'selected' : ''):''}}>{{ l('نقره ای') }}</option>
                                                            <option value="3" {{!empty($model)?($model->label== 3 ? 'selected' : ''):''}}>{{ l('برنزی') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @else
                                                <input type="hidden" name="label" value="1">
                                                @endif

                                                <div class="col-sm-4 mb-3 buyer-content d-none max_room_count1">
                                                    <div>
                                                        <label  class="form-label fw-bold" for="max_room_count">{{ l('حداقل تعداد خواب') }}</label>
                                                        <select class="form-control" name="max_room_count" id="max_room_count">
                                                            <option value="">{{ l('انتخاب کنید') }}</option>
                                                            <option value="1" {{!empty($model)?($model->max_room_count== 1 ? 'selected' : ''):''}}>1</option>
                                                            <option value="2" {{!empty($model)?($model->max_room_count== 2 ? 'selected' : ''):''}}>2</option>
                                                            <option value="3" {{!empty($model)?($model->max_room_count== 3 ? 'selected' : ''):''}}>3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3 buyer-content d-none max_unit_in_floor1">
                                                    <div>
                                                        <label  class="form-label fw-bold" for="max_unit_in_floor">{{ l('حداکثر تعداد واحد در طبقه') }}</label>
                                                        <select class="form-control" name="max_unit_in_floor" id="max_unit_in_floor">
                                                            <option value="">{{ l('انتخاب کنید') }}</option>
                                                            <option value="1" {{!empty($model)?($model->max_unit_in_floor== 1 ? 'selected' : ''):''}}>1</option>
                                                            <option value="2" {{!empty($model)?($model->max_unit_in_floor== 2 ? 'selected' : ''):''}}>2</option>
                                                            <option value="3" {{!empty($model)?($model->max_unit_in_floor== 3 ? 'selected' : ''):''}}>3</option>
                                                            <option value="4" {{!empty($model)?($model->max_unit_in_floor== 4 ? 'selected' : ''):''}}>4</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3 buyer-content d-none max_building_age1">
                                                    <div>
                                                        <label  class="form-label fw-bold" for="max_building_age">{{ l('حداکثر عمر بنا') }}</label>
                                                        <select class="form-control" name="max_building_age" id="max_building_age">
                                                            <option value="">{{ l('انتخاب کنید') }}</option>
                                                            <option value="1" {{!empty($model)?($model->max_building_age== 1 ? 'selected' : ''):''}}>{{ l('حداکثر 1 سال') }}</option>
                                                            <option value="2" {{!empty($model)?($model->max_building_age== 2 ? 'selected' : ''):''}}>{{ l('حداکثر 2 سال') }}</option>
                                                            <option value="3" {{!empty($model)?($model->max_building_age== 3 ? 'selected' : ''):''}}>{{ l('حداکثر 5 سال') }}</option>
                                                            <option value="4" {{!empty($model)?($model->max_building_age== 4 ? 'selected' : ''):''}}>{{ l('حداکثر 10 سال') }}</option>
                                                            <option value="5" {{!empty($model)?($model->max_building_age== 5 ? 'selected' : ''):''}}>{{ l('حداکثر 20 سال') }}</option>
                                                            <option value="6" {{!empty($model)?($model->max_building_age== 6 ? 'selected' : ''):''}}>{{ l('حداکثر 30 سال') }}</option>
                                                            <option value="7" {{!empty($model)?($model->max_building_age== 7 ? 'selected' : ''):''}}>{{ l('بیش از 30 سال') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3 buyer-content  usage_type1">
                                                    <div>
                                                        <label class="form-label fw-bold" for="usage_type">{{ l('نوع کاربری') }}</label>
                                                        <select name="usage_type" id="usage_type" class="form-select">
                                                            <option value="">{{ l('انتخاب نمایید') }}</option>
                                                            <option value="107" {{!empty($model)?($model->usage_type==107?'selected':''):''}}>{{ l('مسکونی') }}</option>
                                                            <option value="108" {{!empty($model)?($model->usage_type==108?'selected':''):''}}>{{ l('اداری') }}</option>
                                                            <option value="109" {{!empty($model)?($model->usage_type==109?'selected':''):''}}>{{ l('تجاری') }}</option>
                                                            <option value="111" {{!empty($model)?($model->usage_type==111?'selected':''):''}}>{{ l('گردشگری') }}</option>
                                                            <option value="285" {{!empty($model)?($model->usage_type==285?'selected':''):''}}>{{ l('کشاورزی') }}</option>
                                                            <option value="286" {{!empty($model)?($model->usage_type==286?'selected':''):''}}>{{ l('باغ') }}</option>
                                                            <option value="287" {{!empty($model)?($model->usage_type==287?'selected':''):''}}>{{ l('دامپروری') }}</option>
                                                            <option value="288" {{!empty($model)?($model->usage_type==288?'selected':''):''}}>{{ l('صنعتی') }}</option>
                                                            <option value="341" {{!empty($model)?($model->usage_type==341?'selected':''):''}}>{{ l('بدون توافق') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 mb-3 buyer-content d-none conditions151">
                                                    <div>
                                                        <label  class="form-label fw-bold" for="conditions15">{{ l('پیش فروش') }}</label>
                                                        <input class="form-check-input" id="conditions15" {{!empty($model)?checkValueCreate($model->conditions,15):""}} value="15" type="checkbox" name="conditions[]">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 mb-3 buyer-content ">
                                                    <div>
                                                        <label  class="form-label fw-bold" for="compensation">{{ l('قابلیت معاوضه') }}</label>
                                                        <input class="form-check-input" id="compensation" {{!empty($model)?($model->compensation==1?"checked":""):""}} value="1" type="checkbox" name="compensation">
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 mb-3 buyer-content">
                                                    <div>
                                                        <label class="form-label fw-bold" for="conditions304">
                                                            {{ l('کلید نخورده') }}
                                                        </label>
                                                        <input class="form-check-input" id="conditions304" {{!empty($model)?checkValueCreate($model->conditions,304):""}} value="304" type="checkbox" name="conditions[]">
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 mb-3 buyer-content">
                                                    <div>
                                                        <label class="form-label fw-bold" for="conditions348">
                                                            {{ l('فول امکانات') }}
                                                        </label>
                                                        <input class="form-check-input" id="conditions348" {{!empty($model)?checkValueCreate($model->conditions,348):""}} value="348" type="checkbox" name="conditions[]">
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 mb-3 buyer-content d-none floor_count1">
                                                    <div>
                                                        <label class="form-label fw-bold" for="floor_count">{{ l('شماره طبقات') }}</label>
                                                        <select id="floor_count" class="form-select" name="floor_count">
                                                            <option value="">{{ l('انتخاب نمایید') }}</option>
                                                            <option value="1" {{!empty($model)?($model->floor_count==1?'selected':''):''}}>{{ l('طبقه اول') }}</option>
                                                            <option value="2" {{!empty($model)?($model->floor_count==2?'selected':''):''}}>{{ l('بجز طبقه اول') }}</option>
                                                            <option value="3" {{!empty($model)?($model->floor_count==3?'selected':''):''}}>{{ l('طبقات وسط') }}</option>
                                                            <option value="4" {{!empty($model)?($model->floor_count==4?'selected':''):''}}>{{ l('طبقات آخر') }}</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3 buyer-content d-none floor_start1">
                                                    <div>
                                                        <label class="form-label fw-bold"  for="floor_start">{{ l('شروع طبقات از') }}</label>
                                                        <select class="form-select" name="floor_start">
                                                            <option value="">{{ l('انتخاب نمایید') }}</option>
                                                            <option title="{{ l('شروع طبقه از') }}" value="257" {{!empty($model)?($model->floor_start==257?'selected':''):''}}>{{ l('زیرزمین') }}</option>
                                                            <option title="{{ l('شروع طبقه از') }}" value="258" {{!empty($model)?($model->floor_start==258?'selected':''):''}}>{{ l('همکف') }}</option>
                                                            <option title="{{ l('شروع طبقه از') }}" value="259" {{!empty($model)?($model->floor_start==259?'selected':''):''}}>{{ l('پیلوت بدون سوئیت') }}</option>
                                                            <option title="{{ l('شروع طبقه از') }}" value="260" {{!empty($model)?($model->floor_start==260?'selected':''):''}}>{{ l('پیلوت با سوئیت') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3 buyer-content d-none min_floor_area1">
                                                    <div>
                                                        <label class="form-label fw-bold" for="min_floor_area">{{ l('حداقل متراژ زمین') }}</label>
                                                        <input class="form-control" type="number"  id="min_floor_area" name="min_floor_area" value="{{$model->min_floor_area??''}}">
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 mb-3 buyer-content d-none min_front_area1">
                                                    <div>
                                                        <label class="form-label fw-bold" for="min_front_area">{{ l('حداقل متراژ بر') }}</label>
                                                        <input class="form-control" type="number"  id="min_front_area" name="min_front_area" value="{{$model->min_front_area??''}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3 buyer-content d-none min_street_width1">
                                                    <div>
                                                        <label class="form-label fw-bold" for="min_street_width">{{ l('حداقل عرض گذر') }}</label>
                                                        <input class="form-control" type="number"  id="min_street_width" name="min_street_width" value="{{$model->min_street_width??''}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3 buyer-content d-none min_density1">
                                                    <div>
                                                        <label class="form-label fw-bold" for="min_density">{{ l('حداقل تراکم') }}</label>
                                                        <input class="form-control" type="number"  id="min_density" name="min_density" value="{{$model->min_density??''}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3 buyer-content d-none geography1">
                                                    <div>
                                                        <label  class="form-label fw-bold" for="geography">{{ l('جهت جغرافیایی') }}</label>
                                                        <select name="geography" class="form-select">
                                                            <option value="">{{ l('انتخاب نمایید') }}</option>
                                                            <option value="113" {{!empty($model->geography)?($model->geography==113?'selected':''):''}}>{{ l('شمالی') }}</option>
                                                            <option value="114" {{!empty($model->geography)?($model->geography==114?'selected':''):''}}>{{ l('جنوبی') }}</option>
                                                            <option value="115" {{!empty($model->geography)?($model->geography==115?'selected':''):''}}>{{ l('شرقی') }}</option>
                                                            <option value="116" {{!empty($model->geography)?($model->geography==116?'selected':''):''}}>{{ l('غربی') }}</option>
                                                            <option value="117" {{!empty($model->geography)?($model->geography==117?'selected':''):''}}>{{ l('دوبر') }}</option>
                                                            <option value="118" {{!empty($model->geography)?($model->geography==118?'selected':''):''}}>{{ l('سه بر') }}</option>
                                                            <option value="119" {{!empty($model->geography)?($model->geography==119?'selected':''):''}}>{{ l('چهاربر') }}</option>
                                                            <option value="120" {{!empty($model->geography)?($model->geography==120?'selected':''):''}}>{{ l('دوکله') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3 buyer-content">
                                                    <div>
                                                        <label class="input-title form-label fw-bold" for="ap-type-document">{{ l('نوع سند') }}</label>
                                                        <select class="form-select" id="type-document" name="document_type">
                                                            <option value="" disabled selected></option>
                                                            <option value="20" {{!empty($model)?($model->document_type==20?'selected':''):''}}>{{ l('شش دانگ') }}</option>
                                                            <option value="21" {{!empty($model)?($model->document_type==21?'selected':''):''}}>{{ l('سرقفلی') }}</option>
                                                            <option value="22" {{!empty($model)?($model->document_type==22?'selected':''):''}}>{{ l('مشاع') }}</option>
                                                            <option value="23" {{!empty($model)?($model->document_type==23?'selected':''):''}}>{{ l('اوقافی') }}</option>
                                                            <option value="24" {{!empty($model)?($model->document_type==24?'selected':''):''}}>{{ l('مسکن مهر') }}</option>
                                                            <option value="25" {{!empty($model)?($model->document_type==25?'selected':''):''}}>{{ l('وکالتی') }}</option>
                                                            <option value="26" {{!empty($model)?($model->document_type==26?'selected':''):''}}>{{ l('قولنامه ای') }}</option>
                                                            <option value="27" {{!empty($model)?($model->document_type==27?'selected':''):''}}>{{ l('بنیادی') }}</option>
                                                            <option value="28" {{!empty($model)?($model->document_type==28?'selected':''):''}}>{{ l('زمین شهری') }}</option>
                                                            <option value="29" {{!empty($model)?($model->document_type==29?'selected':''):''}}>{{ l('شورایی') }}</option>
                                                            <option value="30" {{!empty($model)?($model->document_type==30?'selected':''):''}}>{{ l('در دست اقدام') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 mb-3 buyer-content d-none build_license1">
                                                    <div>
                                                        <label class="input-title" role="button">{{ l('پروانه ساخت') }}</label>
                                                        <select name="build_license" class="form-select" style="width:100%" tabindex="-1" aria-d-none="true">
                                                            <option value="">{{ l('انتخاب نمایید') }}</option>
                                                            <option value="290" {{!empty($model->build_license)?($model->build_license==290?'selected':''):''}}>{{ l('دارد') }}</option>
                                                            <option value="291" {{!empty($model->build_license)?($model->build_license==291?'selected':''):''}}>{{ l('ندارد') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @if ($currentUser->isAdmin())
                                                <div class="col-sm-4 mb-3">
                                                    <label class="form-label fw-bold" for="ap-max-buy">{{l('انتخاب کارشناس')}}</label>
                                                    <select class="form-control select2" name="expertid" id="expertid" style="width: 100%;">

                                                        @foreach($users as $item)
                                                            <option value="{{$item->id}}">{{$item->fullname()}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @elseif($currentUser->isExpert())
                                                <input type="hidden" name="expertid" value="{{$currentUser->id}}">
                                                @endif
                                                <div class="col-sm-12 mb-3">
                                                    <div class="">
                                                        <label class="form-label fw-bold" for="ap-max-buy">{{l('یادداشت')}}</label>
                                                        <textarea name="note" id="desc-state" class="form-control" rows="6">{!!$currentUser->note!!}</textarea>
                                                    </div>
                                                </div>


                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-0 mt-2 mx-2 fs-base">
                                {{ l('در صورتی تمایل بخش مشخصات تکمیلی را پر کنید') }}
                            </p>
                    </section>
                    <!-- Action buttons -->
                    <section class="d-sm-flex justify-content-between pt-2">
                        <input type="hidden" name="user_id" value="{{$currentUser->id}}">
                        <button type="button" onclick="customercheck1()" class="btn btn-primary btn-lg d-block mb-2">
                            {{l('ثبت خریدار')}}
                        </a>
                    </button>
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
                <div class="btn btn-primary checkaccept1">{{ l('ثبت کن') }}</div>
                <div class="btn btn-danger close1">{{ l('بستن') }}</div>
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
                <div class="btn btn-primary checkaccept2">{{ l('ثبت کن') }}</div>
                <div class="btn btn-danger close2">{{ l('بستن') }}</div>
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
var mobilecheck1=true;
var mobilecheck2=true;
function customercheck(id,val){
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
        $('.select2').select2();
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
    })
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
    $(document).ready(function(){

        $(".max_room_count1").removeClass('d-none');
        $(".min_floor_count1").removeClass('d-none');
        $(".max_unit_in_floor1").removeClass('d-none');
        $(".max_building_age1").removeClass('d-none');
        $(".conditions151").removeClass('d-none');
        $(".floor_count1").removeClass('d-none');
        $("#estate_type").change(function(){
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
            if($(this).val()==1 || $(this).val()==2)
            {
                $(".max_room_count1").removeClass('d-none');
                $(".min_floor_count1").removeClass('d-none');
            }
            if($(this).val()==3 || $(this).val()==2){
                $(".min_front_area1").removeClass('d-none');
            }
            if($(this).val()==1)
            {
                $(".max_unit_in_floor1").removeClass('d-none');
                $(".max_building_age1").removeClass('d-none');
                $(".conditions151").removeClass('d-none');
                $(".floor_count1").removeClass('d-none');
            }
            if($(this).val()==2)
            {
                $(".floor_start1").removeClass('d-none');
                $(".min_floor_area1").removeClass('d-none');
                $(".min_street_width1").removeClass('d-none');
                $(".min_density1").removeClass('d-none');
                $(".geography1").removeClass('d-none');
                $(".build_license1").removeClass('d-none');
            }
            if($(this).val()==4)
            {
                $(".min_density1").removeClass('d-none');
            }
        });
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

</script>
@endsection




