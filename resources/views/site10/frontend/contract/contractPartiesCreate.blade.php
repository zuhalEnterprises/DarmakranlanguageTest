<div class="row">
    @if(!empty($model))
    <input type="hidden" id="id" name="id" value="{{$model->id}}"/>
    @endif
    <input type="hidden"  class="form-control" name="contract_id" value="{{$contractid}}"/>

    <div class="col-md-6 col-sm-12"><label class="form-label fw-bold">{{ l('نام کاربر') }}<span class="text-danger">*</span></label><input type="text" class="form-control" name="name" value="{{!empty($model)?$model->name:''}}" required/></div>
    <div class="col-md-6 col-sm-12"><label class="form-label fw-bold">{{ l('نوع کاربر') }}</label><select name="type" class="form-control" style="width: 100%"><option {{!empty($model)?($model->type==1?'selected':''):''}} value="1">{{ l('فروشنده') }}</option><option {{!empty($model)?($model->type==2?'selected':''):''}} value="2">{{ l('خریدار') }}</option></select></div>
    <div class="col-md-6 col-sm-12"><label class="form-label fw-bold">{{ l('مبلغ کمیسیون دریافتی') }}<span class="text-danger">*</span></label><input type="text" value="{{!empty($model)?$model->commission:''}}" class="js_number form-control" name="commission" required/></div>
    <div class="col-md-6 col-sm-12"<label class="form-label fw-bold">{{ l('شماره رسید') }}</label><input type="text" class="form-control" name="receipt_number"  value="{{!empty($model)?$model->receipt_number:''}}" /></div>
    <div class="col-md-6 col-sm-12"><label class="form-label fw-bold">{{ l('سند رسید') }}</label><input type="text" class="form-control" name="receipt_doc" value="{{!empty($model)?$model->receipt_doc:''}}"/></div>
    <div class="col-md-12 col-sm-12"><label class="form-label fw-bold">{{ l('توضیحات') }}</label><textarea class="form-control" name="description">{{!empty($model)?$model->description:''}}</textarea></div>
</div>
<section class="d-sm-flex justify-content-between pt-2">
    <input type="submit" class="btn btn-primary btn-lg d-block mb-2" value="{{ l('ثبت پرداخت کمیسیون') }}"/></div>
</section>
