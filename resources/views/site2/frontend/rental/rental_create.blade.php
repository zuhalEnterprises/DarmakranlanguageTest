@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME')
])
@section('main_content')
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link href="/css/Mh1PersianDatePicker.css" rel="stylesheet" />
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
                @include('frontend.layouts.sidebar', ['menu' => 'rentaladdcustomer'])
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
                        <h1 class="h2 mb-0">{{!empty($model)? l('ویرایش تقاضا') :l('ثبت تقاضای جدید')}} </h1>
                    </div>
                    <!-- Basic info-->
                    <form  id="js_singup-expert" role="form"  method="POST" action="<?php if (!empty($model)) echo '/rental/customer/update/' . $model->id; else echo '/rental/customer/store'; ?>">
                    @if(!empty($model))
                        @method('put')
                    @endif
                    @csrf
                    <section class="card card-body shadow-sm p-4 mb-4" id="basic-info">
                        <h2 class="h5 mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>{{l('اطلاعات متقاضی')}}
                        </h2>
                            <div class="row">

                                <div class="col-sm-6 mb-3">
                                    <label for="gender" class="form-label fw-bold">
                                        {{ l('جنسیت') }}
                                    </label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="male" {{!empty($model) && $model->gender == "male" ? 'selected' :''}}>{{ l('آقا') }}</option>
                                        <option value="female" {{!empty($model) && $model->gender == "female" ? 'selected' :''}}>{{ l('خانم') }}</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="name">{{l('نام متقاضی')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text"  id="name" name="name"  value="{{!empty($model)?$model->name:''}}" required>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="mobile"> {{l('تلفن همراه')}}
                                    <span class="text-danger">*</span></label>
                                    <input class="form-control number" type="text" id="mobile" name="mobile" maxlength="11" minlength="11"  value="{{!empty($model)?$model->mobile:$currentUser->mobile}}" required>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="name">{{ l('تعداد افراد') }}</label>
                                    <input class="form-control" type="text"  id="person_count" name="person_count"  value="{{!empty($model)?$model->person_count:''}}" >
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="price">{{ l('قیمت (تومان)') }}</label>
                                    <input class="form-control" type="text"  id="price" name="price"  value="{{!empty($model)?$model->price:''}}" >
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold">{{ l('تاریخ سکونت از') }}</label>
                                    <input type="text" name="stay_from" id="stay_from"
                                    onclick="Mh1PersianDatePicker.Show(this,'{{$dateto}}')"
                                                    value="{{ !empty($model) ? toPersianDateYdm($model->stay_from) : '' }}"
                                    class="form-control text-muted pull-right">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold">{{ l('تاریخ سکونت تا') }}</label>
                                    <input type="text" name="stay_to" id="stay_to"
                                    onclick="Mh1PersianDatePicker.Show(this,'{{$dateto}}')"
                                                    value="{{ !empty($model) ? toPersianDateYdm($model->stay_to) : '' }}"
                                    class="form-control text-muted pull-right">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="name">{{ l('کد ملک') }}</label>
                                    <input class="form-control" type="text"  id="estate_id" name="estate_id"  value="{{!empty($model)?$model->estate_id:''}}" >
                                </div>
                                @if (!empty($model))
                                    <div class="col-sm-6 mb-3">
                                        <label class="form-label fw-bold" for="ap-max-buy">{{ l('وضعیت') }}</label>
                                        <select class="form-control" name="status" id="status" style="width:100%">
                                            <option value="1" {{!empty($model) && $model->status == "1" ? 'selected' :''}}>{{ l('در انتظار تائید') }}</option>
                                            <option value="2" {{!empty($model) && $model->status == "2" ? 'selected' :''}}>{{ l('تائید شده مالک') }}</option>
                                            <option value="3" {{!empty($model) && $model->status == "3" ? 'selected' :''}}>{{ l('تائید') }}</option>
                                            <option value="4" {{!empty($model) && $model->status == "4" ? 'selected' :''}}>{{ l('آرشیو') }}</option>
                                        </select>
                                    </div>
                                @endif

                                <div class="col-sm-12 mb-3">
                                    <div class="">
                                        <label class="form-label fw-bold" for="ap-max-buy">{{l('یادداشت')}}</label>
                                        <textarea  name="description" id="description" class="form-control" rows="6">{{!empty($model)?$model->description:''}}</textarea>
                                    </div>
                                </div>

                            </div>
                    </section>
                    <!-- Action buttons -->
                    <section class="d-sm-flex justify-content-between pt-2">
                        <input type="hidden" name="user_id" value="{{$currentUser->id}}">
                        <button type="submit" onclick="customercheck1()" class="btn btn-primary btn-lg d-block mb-2">
                            {{!empty($model)? l('ویرایش تقاضا') :l('ثبت تقاضای جدید')}}
                        </a>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

</div>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
<script src="/js/Mh1PersianDatePicker.js"></script>
<script src="/vendor/jquery-3.6.0.js"></script>
<script src="/vendor/select2/select2.min.js"></script>
<!-- Main theme script-->

<script src="{{asset('/assets/js/valid.js')}}"></script>
<script>
$('.select2').select2();
$(document).ready(function() {
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
