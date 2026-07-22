@extends('frontend.layouts.intro.appnew',['title'=>' ویرایش خریدار'])
@section('head')
<style>
.form-title {
    font-size: 20px;
    font-weight: 800;
}
</style>
@endsection
@section('main_content')
@include('frontend.layouts.header1')
<?php $route = 'customers'; ?>
<link href="{{asset('/admin/plugin/select2/4.0.3/css/select2.min.css')}}" rel="stylesheet" type="text/css">
<form role="form" method="POST" id="form-cus" action="<?php if (!empty($model)) echo '/customer/update/' . $model->id ?>">
    @method('put')
    @csrf
    <input type="hidden" name="user_id" value="{{$currentUser->id}}">
    <div class="container mb-5">

        <div class="row mt-4">
            <div class="col-lg-12">
                <ul class="breadcrumb">
                    <li><a href="/">{{ l('خانه') }}</a></li>
                    <li><a href="/customer">{{ l('جستجوری خریداران') }}</a></li>
                    <li>{{ l('ویرایش خریدار') }}</li>
                </ul>
            </div>
        </div>
        <h2 class="text-right mt-3 mb-5 form-title">{{ l('فرم ویرایش خریدار') }}</h2>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="mb-3">
                    <label for="gender" class="form-label">{{ l('جنسیت') }}
                        <span class="required" style="color: red;"> * </span>
                    </label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="male" {{!empty($model)?($model->gender=="male"?'seleted':''):''}}>{{ l('مرد') }}</option>
                        <option value="female" {{!empty($model)?($model->gender=="female"?'seleted':''):''}}>{{ l('زن') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="mb-3">
                    <label for="name" class="form-label">{{ l('نام خریدار') }}
                        <span class="required" style="color: red;"> * </span>
                    </label>
                    <input type="text" class="form-control" id="name" name="name" value="{{!empty($model)?$model->name:''}}" required>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="mb-3">
                    <label for="phone" class="form-label">{{ l('تلفن همراه خریدار') }}
                        <span class="required" style="color: red;"> * </span>
                    </label>
                    <input type="tel" class="form-control" id="mobile" name="mobile" value="{{!empty($model)?$model->mobile:''}}" required maxlength="12" minlength="11">
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="mb-3">
                    <label for="Financial_situation" class="form-label">{{ l('وضعیت نقدینگی') }}
                        <span class="required" style="color: red;"> * </span>
                    </label>
                    <select class="form-select" id="financial_liquidity_type" name="financial_liquidity_type" required>
                        <option value="">{{ l('انتخاب کنید') }}</option>
                        @foreach(financialLiquidityTypes() as $k=>$v)
                        <option value="{{$k}}" {{!empty($model)?($model->financial_liquidity_type==$k?'selected':''):''}}>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="mb-3">
                    <label for="req_type" class="form-label">{{ l('نوع درخواست') }}
                        <span class="required" style="color: red;"> * </span>
                    </label>
                    <select class="form-select" id="req_type" name="req_type" required>
                        <option value="1" {{!empty($model)?($model->req_type=="1"?'seleted':''):''}}>{{ l('خرید') }}</option>
                        <option value="2" {{!empty($model)?($model->req_type=="2"?'seleted':''):''}}>{{ l('اجاره') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="mb-3">
                    <label for="estate_type" class="form-label">{{ l('نوع ملک') }}
                        <span class="required" style="color: red;"> * </span>
                    </label>
                    <select class="form-select" id="estate_type" name="estate_type" required>
                        @foreach(estateTypes() as $key=>$value)
                        <option value="{{$key}}" {{old('estate_type') == $key ? 'selected' : ''}}>{{$value}}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="mb-3">
                    <label for="districts" class="form-label">{{ l('محله های درخواستی') }}
                        <span class="required" style="color: red;"> * </span>
                    </label>
                    <select class="form-select select2" id="districts" name="districts[]" multiple required>
                        <option value="">{{ l('همه') }}</option>
                        @foreach($districts as $id=>$name)
                        <option value="{{$id}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="mb-3">
                    <label for="min_area" class="form-label">{{ l('حداقل متراژ درخواستی') }}
                    <span class="required" style="color: red;"> * </span>
                    </label>
                    <input type="tel" class="form-control seperate" id="area_min" name="area_min" value="{{!empty($model)?$model->area_min:''}}" required>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="mb-3">
                    <label for="max_area" class="form-label">{{ l('حداکثر متراژ درخواستی') }}
                    </label>
                    <input type="tel" class="form-control seperate" id="area_max" name="area_max" value="{{!empty($model)?$model->area_max:''}}">
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6" id="buy_min_div">
                <label for="min_buy_price" class="form-label">{{ l('حداقل مبلغ خرید') }}</label>
                <div class="input-group mb-3">
                    <input type="tel" class="form-control seperate" id="price_min" name="price_min" value="{{!empty($model)?$model->price_min:''}}">
                    <span class="input-group-text">{{ l('تومان') }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6" id="buy_max_div">
                <label for="max_buy_price" class="form-label">{{ l('حداکثر مبلغ خرید') }}
                    <span class="required" style="color: red;"> * </span>
                </label>
                <div class="input-group mb-3">
                    <input type="tel" class="form-control seperate" id="price_max" name="price_max" value="{{!empty($model)?$model->price_max:''}}" required>
                    <span class="input-group-text">{{ l('تومان') }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 hidden" id="rent_min_div">
                <label for="min_rent_price" class="form-label">{{ l('حداقل مبلغ اجاره') }}</label>
                <div class="input-group mb-3">
                    <input type="tel" class="form-control seperate" id="rent_min" name="rent_min" value="{{!empty($model)?$model->price_max:''}}">
                    <span class="input-group-text">{{ l('تومان') }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 hidden" id="rent_max_div">
                <label for="max_rent_price" class="form-label">{{ l('حداکثر مبلغ اجاره') }}
                    <span class="required" style="color: red;"> * </span>
                </label>
                <div class="input-group mb-3">
                    <input type="tel" class="form-control seperate" id="rent_max" name="rent_max" required value="{{!empty($model)?$model->rent_max:''}}">
                    <span class="input-group-text">{{ l('تومان') }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 hidden" id="rent_min_div">
                <label for="min_rent_price" class="form-label">{{ l('حداقل مبلغ ودیعه') }}</label>
                <div class="input-group mb-3">
                    <input type="tel" class="form-control seperate" id="mortgage_min" name="mortgage_min" value="{{!empty($model)?$model->mortgage_min:''}}">
                    <span class="input-group-text">{{ l('تومان') }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 hidden" id="rent_max_div">
                <label for="max_rent_price" class="form-label">{{ l('حداکثر مبلغ ودیعه') }}
                    <span class="required" style="color: red;"> * </span>
                </label>
                <div class="input-group mb-3">
                    <input type="tel" class="form-control seperate" id="mortgage_max" name="mortgage_max" value="{{!empty($model)?$model->mortgage_max:''}}" required>
                    <span class="input-group-text">{{ l('تومان') }}</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="mb-3">
                    <label class="required" class="form-label">{{ l('میزان تعجیل در خرید/اجاره') }}</label>
                    <select id="purchase_priority" name="purchase_priority" class="form-control" required style="width: 100%;">
                        <option value="">{{ l('انتخاب کنید') }}</option>
                        <option value="3" {{!empty($model)?($model->purchase_priority== 3 ? 'selected' : ''):''}}>{{ l('زیاد') }}</option>
                        <option value="2" {{!empty($model)?($model->purchase_priority== 2 ? 'selected' : ''):''}}>{{ l('متوسط') }}</option>
                        <option value="1" {{!empty($model)?($model->purchase_priority== 1 ? 'selected' : ''):''}}>{{ l('کم') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="mb-3">
                    <label class="required" class="form-label">{{ l('وضعیت سکونت') }}</label>
                    <select id="residence_type" name="residence_type" class="form-control" required style="width: 100%;">
                        <option value="">{{ l('انتخاب کنید') }}</option>
                        @foreach(residenceTypes_Customer() as $k=>$v)
                        <option value="{{$k}}" {{!empty($model)?($model->residence_type== $k ? 'selected' : ''):''}}>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 purchase_reason">
                <div class="mb-3">
                    <label for="purchase_reason" class="form-label">{{ l('دلیل خرید') }}</label>
                    <select class="form-select" id="purchase_reason" name="purchase_reason">
                        <option value="">{{ l('انتخاب کنید') }}</option>
                        @foreach(purchaseReasons() as $k=>$v)
                        <option value="{{$k}}" {{!empty($model)?($model->purchase_reason == $k ? 'selected' : ''):''}}>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="mb-3">
                    <label for="acquaintance_type" class="form-label">{{ l('نحوه آشنایی') }}</label>
                    <select class="form-select" id="acquaintance_type" name="acquaintance_type">
                        <option value="">{{ l('انتخاب کنید') }}</option>
                        @foreach(acquaintanceTypes() as $k=>$v)
                        <option value="{{$k}}" {{!empty($model)?($model->acquaintance_type== $k ? 'selected' : ''):''}}>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="note" class="form-label">{{ l('یادداشت') }}</label>
                    <textarea class="form-control" id="note" name="note" rows="9" style="min-height:100px"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-primary" type="submit">{{ l('ویرایش تغییرات') }}</button>
            </div>
        </div>
    </div>
</form>
<script src="{{asset('/admin2/plugins/select2/4.0.3/js/select2.min.js')}}"></script>
<script>
    $('.select2').select2();
    $(document).ready(function() {
        $("#form-cus").validate({
            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('div'));
            }
        });
    })
    $("#req_type").on("change", (e) => {
        if ($(e.target).val() == "2") {
            $("#rent_min_div,#rent_max_div").show();
            $("#buy_min_div,#buy_max_div").hide();
            $(".purchase_reason").hide();
        } else {
            $("#buy_min_div,#buy_max_div").show();
            $("#rent_min_div,#rent_max_div").hide();
            $(".purchase_reason").show();
        }
    });
    var selected_districts = <?php echo !empty($model) ? json_encode($model->district_ids) : ''; ?>;
    $('select#districts').select2().val(selected_districts).trigger('change');
</script>
@include('frontend.layouts.footer1'/*,['cssClass'=>'intro']*/)
@endsection
