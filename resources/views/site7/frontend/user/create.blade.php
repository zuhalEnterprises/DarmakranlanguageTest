<div class="col-sm-12 mb-3">
    <label class="form-label fw-bold">{{ l('محل های فعالیت') }}</label>
    <select name="districts[]" class="form-control select2 district_id" id="district_id"  multiple style="width: 100%">
        @foreach( $districts as $item)
            <option value="{{$item->id}}" {{!empty($model) && array_key_exists($item->id , $model->selectedDistricts) ? 'selected' :''}}>{{$item->name}}</option>
        @endforeach
    </select>
</div>
<div class="col-sm-12 mb-3">
    <label class="form-label fw-bold">{{ l('همکار') }}</label>
    <select name="isbongah" id="isbongah" class="form-control">
        <option value="0" {{!empty($model) && $model->isbongah==0?"selected":""}}>{{ l('خیر') }}</option>
        <option value="1" {{!empty($model) && $model->isbongah==1?"selected":""}}>{{ l('بله') }}</option>

    </select>
</div>
<div class="col-sm-4 mb-3">
    <label for="operand" class="form-label fw-bold">{{ l('رنج قیمت') }}</label>
    <select name="operand" id="operand" class="day-calc colorful-select dropdown-primary" >
        <option value="1" {{!empty($model) && old('operand' , $model->operand) == "1" ? " selected " :''}}>{{ l('بیشتر یا مساوی') }}</option>
        <option value="2" {{!empty($model) && old('operand' , $model->operand) == "2" ? " selected " :''}}>{{ l('کمتر') }}</option>
    </select>
    <input type="number" id="price" name="price" class="day-calc colorful-select dropdown-primary" value="{{ !empty($model) ? $model->price : ''}}">
</div>

<div class="col-sm-4 mb-3">
    <label class="form-label fw-bold required">{{ l('نوع ملک فعالیت') }}</label>
    <select class="form-control select2" name="activity_estate_type[]" multiple id="activity_estate_type">
        <option value="" >{{ l('انتخاب کنید') }}</option>
        @foreach(estateTypes() as $key=>$val)
            <option value="{{$key}}" {{!empty($model)?selectValueCreate($model->activity_estate_type,$key):""}} >{{$val}}</option>
        @endforeach
    </select>
</div>

<div class="col-sm-4 mb-3">
    <label class="form-label fw-bold">
        {{ l('درصد کمیسیون') }}
    </label>
    <input class="form-control" type="number" min="0" max="100" value="{{!empty($model) && old('commission', $model->commission)}}" name="commission">
</div>
<input type="hidden" name="status" value="1">



<div class="col-sm-12 mb-3">
    <h4>{{ l('شبکه‌های اجتماعی') }}</h4>
</div>

<div class="col-sm-3 mb-3">
    <label class="form-label fw-bold ">{{ l('ایتا') }}</label>
    <input type="text" name="eitaa" value="{{!empty($model) ? $model->eitaa : ''}}" class="form-control"  style="width: 100%">
</div>
<div class="col-sm-3 mb-3">
    <label class="form-label fw-bold ">{{ l('واتساب') }}</label>
    <input type="text" name="whatsapp" value="{{!empty($model) ? $model->whatsapp : ''}}" class="form-control"  style="width: 100%">
</div>
<div class="col-sm-3 mb-3">
    <label class="form-label fw-bold ">{{ l('اینستاگرام') }}</label>
    <input type="text" name="instagram" value="{{!empty($model) ? $model->instagram : ''}}" class="form-control"  style="width: 100%">
</div>
<div class="col-sm-3 mb-3">
    <label class="form-label fw-bold ">{{ l('تلگرام') }}</label>
    <input type="text" name="telegram" value="{{!empty($model) ? $model->telegram : ''}}" class="form-control"  style="width: 100%">
</div>




