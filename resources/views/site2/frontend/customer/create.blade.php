@if($currentUser->isExpert())
<div class="col-sm-3 mb-3 buyer-content">
    <div>
        <label  class="form-label fw-bold" for="purchase_priority">{{ l('میزان تعجیل در خرید/اجاره') }}</label>
        <select id="purchase_priority" name="purchase_priority" class="form-control">
            <option value="">{{ l('انتخاب کنید') }}</option>
            <option value="3" {{!empty($model)?($model->purchase_priority == 3 ? 'selected' : ''):''}}>{{ l('زیاد') }}</option>
            <option value="2" {{!empty($model)?($model->purchase_priority == 2 ? 'selected' : ''):''}}>{{ l('متوسط') }}</option>
            <option value="1" {{!empty($model)?($model->purchase_priority == 1 ? 'selected' : ''):''}}>{{ l('کم') }}</option>
        </select>
    </div>
</div>

<div class="col-sm-3 mb-3 buyer-content">
    <div>
        <label  class="form-label fw-bold" for="label">{{ l('لیبل') }}</label>
        <select class="form-control" name="label" id="label">
            <option value="3" {{!empty($model)?($model->label== 3 ? 'selected' : ''):''}}>{{ l('برنزی') }}</option>
            <option value="2" {{!empty($model)?($model->label== 2 ? 'selected' : ''):''}}>{{ l('نقره‌ای') }}</option>
            <option value="1" {{!empty($model)?($model->label== 1 ? 'selected' : ''):''}}>{{ l('طلایی') }}</option>
        </select>
    </div>
</div>
@endif
<div class="col-sm-3 mb-3 buyer-content">
    <div>
        <label class="fw-bold form-label required">{{ l('دلیل خرید') }}</label>
        <select id="purchase_reason" name="purchase_reason" class="form-control"  style="width: 100%;">
            <option value="">{{ l('انتخاب کنید') }}</option>
            @foreach(purchaseReasons() as $k=>$v)
                <option value="{{$k}}" {{!empty($model)?($model->purchase_reason== $k ? 'selected' : ''):''}}>{{$v}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-3 mb-3 buyer-content">
    <div>
        <label class="form-label fw-bold">{{ l('نحوه آشنایی') }}</label>
        <select id="acquaintance_type" name="acquaintance_type" class="form-control" style="width: 100%;">
            <option value="">{{ l('انتخاب کنید') }}</option>
            @foreach(acquaintanceTypes() as $k=>$v)
                <option value="{{$k}}" {{!empty($model)?($model->acquaintance_type== $k ? 'selected' : ''):''}}>{{$v}}</option>
            @endforeach
        </select>
    </div>
</div>
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
<div class="col-sm-4 mb-3 buyer-content d-none conditions151">
    <div>
        <label  class="form-label fw-bold" for="max_building_age">{{ l('پیش فروش') }}</label>
        <input class="form-check-input" id="conditions15" {{!empty($model)?checkValueCreate($model->conditions,15):""}} value="15" type="checkbox" name="conditions[]">
    </div>
</div>

<div class="col-sm-4 mb-3 buyer-content">
    <div>
        <label class="form-label fw-bold" for="conditions304">
            {{ l('کلید نخورده') }}
        </label>
        <input class="form-check-input" id="conditions304" {{!empty($model)?checkValueCreate($model->conditions,304):""}} value="304" type="checkbox" name="conditions[]">
    </div>
</div>

<div class="col-sm-4 mb-3 buyer-content">
    <div>
        <label class="form-label fw-bold" for="conditions348">
            {{ l('فول امکانات') }}
        </label>
        <input class="form-check-input" id="conditions348" {{!empty($model)?checkValueCreate($model->conditions,348):""}} value="348" type="checkbox" name="conditions[]">
    </div>
</div>
<div class="col-sm-6 mb-3 buyer-content  usage_type1">
    <div>
        <label class="form-label fw-bold" for="usage_type">{{ l('نوع کاربری') }}</label>
        <select name="usage_type" id="usage_type" class="form-select">
            <option value="">{{ l('انتخاب نمایید') }}</option>
            @foreach (usage_type() as $key=>$val)
            <option value="{{$key}}" {{!empty($model)?($model->usage_type==$key ? 'selected':''):""}}>{{$val}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-6 mb-3 buyer-content d-none floor_count1">
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

<div class="col-sm-6 mb-3 buyer-content d-none min_floor_count1">
    <div>
        <label class="form-label fw-bold" for="min_floor_count">{{ l('حداکثر تعداد طبقات') }}</label>
        <select id="min_floor_count" class="form-select" name="min_floor_count">
            <option value="">{{ l('انتخاب نمایید') }}</option>
            <option value="1" {{!empty($model)?($model->min_floor_count==1?'selected':''):''}}>1</option>
            <option value="2" {{!empty($model)?($model->min_floor_count==2?'selected':''):''}}>2</option>
            <option value="3" {{!empty($model)?($model->min_floor_count==3?'selected':''):''}}>3</option>
            <option value="4" {{!empty($model)?($model->min_floor_count==4?'selected':''):''}}>4</option>

        </select>
    </div>
</div>

<div class="col-sm-6 mb-3 buyer-content d-none floor_start1">
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
<div class="col-sm-6 mb-3 buyer-content d-none min_floor_area1">
    <div>
        <label class="form-label fw-bold" for="min_floor_area">{{ l('حداقل مساحت زمین') }}</label>
        <input class="form-control" type="number"  id="min_floor_area" name="min_floor_area" value="{{$model->min_floor_area??''}}">
    </div>
</div>

<div class="col-sm-6 mb-3 buyer-content d-none min_front_area1">
    <div>
        <label class="form-label fw-bold" for="min_front_area">{{ l('حداقل متراژ بر') }}</label>
        <input class="form-control" type="number"  id="min_front_area" name="min_front_area" value="{{$model->min_front_area??''}}">
    </div>
</div>
<div class="col-sm-6 mb-3 buyer-content d-none min_street_width1">
    <div>
        <label class="form-label fw-bold" for="min_street_width">{{ l('حداقل عرض گذر') }}</label>
        <input class="form-control" type="number"  id="min_street_width" name="min_street_width" value="{{$model->min_street_width??''}}">
    </div>
</div>
<div class="col-sm-6 mb-3 buyer-content d-none min_density1">
    <div>
        <label class="form-label fw-bold" for="min_density">{{ l('حداقل تراکم') }}</label>
        <input class="form-control" type="number"  id="min_density" name="min_density" value="{{$model->min_density??''}}">
    </div>
</div>
<div class="col-sm-6 mb-3 buyer-content d-none geography1">
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
<div class="col-sm-6 mb-3 buyer-content d-none build_license1">
    <div>
        <label class="input-title" role="button">{{ l('پروانه ساخت') }}</label>
        <select name="build_license" class="form-select" style="width:100%" tabindex="-1" aria-d-none="true">
            <option value="">{{ l('انتخاب نمایید') }}</option>
            <option value="290" {{!empty($model->build_license)?($model->build_license==290?'selected':''):''}}>{{ l('دارد') }}</option>
            <option value="291" {{!empty($model->build_license)?($model->build_license==291?'selected':''):''}}>{{ l('ندارد') }}</option>
        </select>
    </div>
  </div>


