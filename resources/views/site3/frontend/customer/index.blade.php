@if($currentUser->isExpert())
<!--div class="col-md-6 col-lg-3 col-sm-12 mt-3">

        <label  class=" fw-bold" for="purchase_priority">{{ l('میزان تعجیل در خرید/اجاره') }}</label>
        <select id="purchase_priority" name="purchase_priority" class="form-control">
            <option value="">{{ l('انتخاب کنید') }}</option>
            <option value="3">{{ l('زیاد') }}</option>
            <option value="2">{{ l('متوسط') }}</option>
            <option value="1">{{ l('کم') }}</option>
        </select>
</div-->

<div class="col-md-6 col-lg-3 col-sm-12 mt-3">

        <label  class=" fw-bold" for="label">{{ l('لیبل') }}</label>
        <select class="form-control" name="label" id="label">
            <option value="">{{ l('انتخاب کنید') }}</option>
            <option value="1" >{{ l('طلایی') }}</option>
            <option value="2" >{{ l('نقره ای') }}</option>
            <option value="3" >{{ l('برنزی') }}</option>
        </select>
</div>

<div class="col-md-6 col-lg-3 col-sm-12 mt-3">

        <label class=" fw-bold" class="required">{{ l('دلیل خرید') }}</label>
        <select id="purchase_reason" name="purchase_reason" class="form-control"  style="width: 100%;">
            <option value="">{{ l('انتخاب کنید') }}</option>
            @foreach(purchaseReasons() as $k=>$v)
                <option value="{{$k}}">{{$v}}</option>
            @endforeach
        </select>
</div>
<!--div class="col-md-6 col-lg-3 col-sm-12 mt-3">

        <label class=" fw-bold">{{ l('نحوه آشنایی') }}</label>
        <select id="acquaintance_type" name="acquaintance_type" class="form-control" style="width: 100%;">
            <option value="">{{ l('انتخاب کنید') }}</option>
            @foreach(acquaintanceTypes() as $k=>$v)
                <option value="{{$k}}">{{$v}}</option>
            @endforeach
        </select>

</div-->
@endif
<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none max_room_count1">

        <label  class=" fw-bold" for="max_room_count">{{ l('حداقل تعداد خواب') }}</label>
        <select class="form-control" name="max_room_count" id="max_room_count">
            <option value="">{{ l('انتخاب کنید') }}</option>
            <option value="1" >1</option>
            <option value="2" >2</option>
            <option value="3" >3</option>
        </select>
</div>
<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none max_unit_in_floor1">

        <label  class="fw-bold" for="max_unit_in_floor">{{ l('حداکثر تعداد واحد در طبقه') }}</label>
        <select class="form-control" name="max_unit_in_floor" id="max_unit_in_floor">
            <option value="">{{ l('انتخاب کنید') }}</option>
            <option value="1" >1</option>
            <option value="2" >2</option>
            <option value="3" >3</option>
            <option value="4" >4</option>
        </select>
</div>
<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none max_building_age1">

        <label  class="fw-bold" for="max_building_age">{{ l('حداکثر عمر بنا') }}</label>
        <select class="form-control" name="max_building_age" id="max_building_age">
            <option value="">{{ l('انتخاب کنید') }}</option>
            <option value="1" >{{ l('حداکثر 1 سال') }}</option>
            <option value="2" >{{ l('حداکثر 2 سال') }}</option>
            <option value="3" >{{ l('حداکثر 5 سال') }}</option>
            <option value="4" >{{ l('حداکثر 10 سال') }}</option>
            <option value="5" >{{ l('حداکثر 20 سال') }}</option>
            <option value="6" >{{ l('حداکثر 30 سال') }}</option>
            <option value="7" >{{ l('بیش از 30 سال') }}</option>
        </select>
</div>

<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none usage_type1">

        <label class="fw-bold" for="usage_type">{{ l('نوع کاربری') }}</label>
        <select name="usage_type" id="usage_type" class="form-select">
            <option value="">{{ l('انتخاب نمایید') }}</option>
            @foreach (usage_type() as $key=>$val)
            <option value="{{$key}}">{{$val}}</option>
            @endforeach
        </select>

</div>
<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none floor_count1">

        <label class="fw-bold" for="floor_count">{{ l('شماره طبقات') }}</label>
        <select id="floor_count" class="form-select" name="floor_count">
            <option value="">{{ l('انتخاب نمایید') }}</option>
            <option value="1" >{{ l('طبقه اول') }}</option>
            <option value="2" >{{ l('بجز طبقه اول') }}</option>
            <option value="3" >{{ l('طبقات وسط') }}</option>
            <option value="4" >{{ l('طبقات آخر') }}</option>

        </select>
</div>

<div class="col-md-6 col-lg-3 col-sm-12 mt-3 not" access="12,22">

        <label class="fw-bold" for="min_floor_count">{{ l('حداقل تعداد طبقات') }}</label>
        <select id="min_floor_count" class="form-select" name="min_floor_count">
            <option value="">{{ l('انتخاب نمایید') }}</option>
            <option value="1" >1</option>
            <option value="2" >2</option>
            <option value="3" >3</option>
            <option value="4" >4</option>

        </select>
</div>

<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none floor_start1">

        <label class="fw-bold"  for="floor_start">{{ l('شروع طبقات از') }}</label>
        <select class="form-select" name="floor_start" id="floor_start">
            <option value="">{{ l('انتخاب نمایید') }}</option>
            <option title="{{ l('شروع طبقه از') }}" value="257">{{ l('زیرزمین') }}</option>
            <option title="{{ l('شروع طبقه از') }}" value="258">{{ l('همکف') }}</option>
            <option title="{{ l('شروع طبقه از') }}" value="259">{{ l('پیلوت بدون سوئیت') }}</option>
            <option title="{{ l('شروع طبقه از') }}" value="260">{{ l('پیلوت با سوئیت') }}</option>
        </select>
</div>
<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none min_floor_area1">

        <label class="fw-bold" for="min_floor_area">{{ l('حداقل مساحت زمین') }}</label>
        <input class="form-control" type="number"  id="min_floor_area" name="min_floor_area" >
</div>

<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none min_front_area1">

        <label class="fw-bold" for="min_front_area">{{ l('حداقل متراژ بر') }}</label>
        <input class="form-control" type="number"  id="min_front_area" name="min_front_area" >
</div>
<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none min_street_width1">
        <label class="fw-bold" for="min_street_width">{{ l('حداقل عرض گذر') }}</label>
        <input class="form-control" type="number"  id="min_street_width" name="min_street_width">
</div>
<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none min_density1">
        <label class="fw-bold" for="min_density">{{ l('حداقل تراکم') }}</label>
        <input class="form-control" type="number"  id="min_density" name="min_density" >
</div>
<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none geography1">
        <label  class="fw-bold" for="geography">{{ l('جهت جغرافیایی') }}</label>
        <select name="geography" id="geography" class="form-select">
            <option value="">{{ l('انتخاب نمایید') }}</option>
            <option value="113" >{{ l('شمالی') }}</option>
            <option value="114" >{{ l('جنوبی') }}</option>
            <option value="115" >{{ l('شرقی') }}</option>
            <option value="116" >{{ l('غربی') }}</option>
            <option value="117" >{{ l('دوبر') }}</option>
            <option value="118" >{{ l('سه بر') }}</option>
            <option value="119" >{{ l('چهاربر') }}</option>
            <option value="120" >{{ l('دوکله') }}</option>
        </select>
</div>
<div class="col-md-6 col-lg-3 col-sm-12 mt-3 d-none build_license1">
        <label class="input-title" role="button">{{ l('پروانه ساخت') }}</label>
        <select id="build_license" name="build_license" class="form-select" style="width:100%" tabindex="-1" aria-d-none="true">
            <option value="">{{ l('انتخاب نمایید') }}</option>
            <option value="290" >{{ l('دارد') }}</option>
            <option value="291"  >{{ l('ندارد') }}</option>
        </select>
  </div>
  <div class="col-md-6 col-lg-3 col-sm-12 mt-5 d-none ">

    <label  class="fw-bold" for="max_building_age">{{ l('پیش فروش') }}</label>
    <input class="form-check-input" id="js_pish" value="15" type="checkbox" name="conditions[]">
</div>

<div class="col-md-6 col-lg-3 col-sm-12 mt-5">

    <label class="fw-bold" for="conditions304">
        {{ l('کلید نخورده') }}
    </label>
    <input class="form-check-input" id="js_key" value="304" type="checkbox" name="conditions[]">
</div>
<div class="col-md-6 col-lg-3 col-sm-12 mt-5">
    <label class="fw-bold" for="conditions348">
        {{ l('فول امکانات') }}
    </label>
    <input class="form-check-input" id="js_FacitiiesFull"  value="348" type="checkbox" name="conditions[]">
</div>
<div class="col-md-6 col-lg-3 col-sm-12 mt-5">
    <label class="fw-bold" for="today">
        {{ l('مشتریان امروز') }}
    </label>
    <input class="form-check-input" id="today"  value="1" type="checkbox" name="today">
</div>

<script>
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
            if($(this).val()==1 || $(this).val()==2){
            $(".max_room_count1").removeClass('d-none');
            $(".min_floor_count1").removeClass('d-none');


            }
            if($(this).val()==3 || $(this).val()==2){
                $(".min_front_area1").removeClass('d-none');
            }
            if($(this).val()==1){
                $(".max_unit_in_floor1").removeClass('d-none');
                $(".max_building_age1").removeClass('d-none');
                $(".conditions151").removeClass('d-none');
                $(".floor_count1").removeClass('d-none');

            }
            if($(this).val()==2){
                $(".floor_start1").removeClass('d-none');
                $(".min_floor_area1").removeClass('d-none');
                $(".min_street_width1").removeClass('d-none');
                $(".min_density1").removeClass('d-none');
                $(".geography1").removeClass('d-none');
                $(".build_license1").removeClass('d-none');
            }

        });

    });
</script>
