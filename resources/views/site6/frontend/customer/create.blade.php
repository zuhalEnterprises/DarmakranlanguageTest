@if($currentUser->isExpert())
<div class="col-sm-6 mb-3 buyer-content">
    <div>
        <label  class="form-label fw-bold" for="purchase_priority">{{ l('میزان تعجیل') }}</label>
        <select id="purchase_priority" name="purchase_priority" class="form-control">
            <option value="">{{ l('انتخاب کنید') }}</option>
            <option value="3" {{!empty($model)?($model->purchase_priority == 3 ? 'selected' : ''):''}}>{{ l('زیاد') }}</option>
            <option value="2" {{!empty($model)?($model->purchase_priority == 2 ? 'selected' : ''):''}}>{{ l('متوسط') }}</option>
            <option value="1" {{!empty($model)?($model->purchase_priority == 1 ? 'selected' : ''):''}}>{{ l('کم') }}</option>
        </select>
    </div>
</div>

<div class="col-sm-6 mb-3 buyer-content">
    <div>
        <label  class="form-label fw-bold" for="label">{{ l('لیبل') }}</label>
        <select class="form-control" name="label" id="label">
            <option value="3" {{!empty($model)?($model->label== 3 ? 'selected' : ''):''}}>{{ l('برنزی') }}</option>
            <option value="2" {{!empty($model)?($model->label== 2 ? 'selected' : ''):''}}>{{ l('نقره ای') }}</option>
            <option value="1" {{!empty($model)?($model->label== 1 ? 'selected' : ''):''}}>{{ l('طلایی') }}</option>


        </select>
    </div>
</div>
@endif
<div class="col-sm-6 mb-3 buyer-content d-none">
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




