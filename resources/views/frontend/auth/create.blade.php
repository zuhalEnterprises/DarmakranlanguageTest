@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => !empty($model)? l('ویرایش مشاور') :l('ثبت مشاور جدید')
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
                @include('frontend.layouts.sidebar', ['menu' => 'users'])
                <!-- Page content-->
                <div class="col-lg-9 col-md-12 mb-5 account add-property">
                    <!-- Breadcrumb-->
                    <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{!empty($model)? l('ویرایش مشاور') :l('ثبت مشاور جدید')}}</li>
                        </ol>
                    </nav>
                    <!-- Title-->
                    <div class="mb-4">
                        <h1 class="h2 mb-0">{{!empty($model)? l('ویرایش مشاور') :l('ثبت مشاور جدید')}} </h1>
                    </div>
                    <!-- Basic info-->
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <li class="fw-bold">{{ $error }}</li>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form  id="js_singup-expert" role="form"  method="POST" action="<?php if (!empty($model)) echo '/profile/users/update/' . $model->id; else echo '/profile/users/store'; ?>" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="photoshow" class="photo" value="{{!empty($currentUser)?0:1}}" />
                    <section class="card card-body shadow-sm rounded p-4 mb-4" id="basic-info">
                        <h2 class="h5 mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>{{l('اطلاعات مشاور')}}
                        </h2>
                        <div class="row">
                            <div class="col-sm-2 mb-3">
                                <label for="gender" class="form-label fw-bold">
                                    {{l('جنسیت')}}
                                </label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="male" {{!empty($model) && $model->gender == "male" ? 'selected' :''}}>{{l('آقا')}}</option>
                                    <option value="female" {{!empty($model) && $model->gender == "female" ? 'selected' :''}}>{{l('خانم')}}</option>
                                </select>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold" for="name">{{l('نام')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text"  id="name" name="name"  value="{{!empty($model)?$model->name:''}}" required>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold" for="last_name">{{l('نام خانوادگی')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text"  id="last_name" name="last_name"  value="{{!empty($model)?$model->last_name:''}}" required>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold" for="username"> {{l('نام کاربری (شماره موبایل)')}} </label>
                                @if (env('COUNTRY') == 'UAE')
                                <input class="form-control" type="text" id="username" name="username" required email value="{{!empty($model)?$model->username:''}}">
                                @else
                                <input class="form-control" type="text" id="username" name="username" required maxlength="15" value="{{!empty($model)?$model->username:''}}">
                                @endif
                            </div>

                            <div class="col-sm-5 mb-3">
                                <label for="password" class="form-label fw-bold required">{{l('رمز عبور')}}</label>
                                <input id="password" type="text" class="form-control" name="password" value="" >
                                <p class="help-block">{{l('برای رمز عبور حداقل 6 کاراکتر مورد نیاز است')}}</p>
                            </div>
                            @if (env('COUNTRY') == 'UAE')
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold" for="username"> {{l('تلفن')}} </label>
                                <input class="form-control" type="text" id="phone" name="phone" required maxlength="15" value="{{!empty($model)?$model->phone:''}}">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold" for="whatsapp"> Whatsapp </label>
                                <input class="form-control" type="text" id="whatsapp" name="whatsapp" maxlength="15" value="{{!empty($model)?$model->whatsapp:''}}">
                            </div>
                            @endif
                        </div>
                        @if(ss('SITE_ID') != 6)

                        <div class="row">
                            @if(env('COUNTRY') != 'UAE')
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold required">{{ l('استان') }}</label>
                                <select name="province_id" id="province_id" class="form-control select2">
                                    <option value="">{{ l('انتخاب کنید') }}</option>
                                    @foreach( $provinces as $item)
                                        <option value="{{$item->id}}"  {{!empty($model) && old('province_id',$model->province_id) == $item->id ? " selected " :''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-4 mb-3">
                            <label class="form-label fw-bold ">{{l('شهر')}}</label>
                                <select name="city_id" id="city_id" class="form-control select2" required>

                                    @foreach( $cities as $item)
                                        <option value="{{$item->id}}" {{!empty($model) && old('city_id',$model->city_id) == $item->id ? " selected " :''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            @include(ss('THEME').'.frontend.user.create')
                        </div>
                        @endif
                        <div class="row">
                            @if(ss('SITE_ID') != 6)
                            <div class="col-sm-12 mb-3">
                                <label for="bio" class="form-label fw-bold">{{l('بیوگرافی (درباره من)')}}</label>
                                <textarea class="form-control" name="bio" id="bio">{{ !empty($model) ? $model->bio : ''}}</textarea>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold required">{{l('تخصص فعالیت')}}</label>
                                <select class="form-control" name="activity_type" id="activity_type">
                                    <option value="">{{l('انتخاب کنید')}}</option>
                                    <option value="1" {{!empty($model) && old('activity_type' , $model->activity_type) == "1" ? " selected " :''}}>{{l('فروش')}}</option>
                                    <option value="2" {{!empty($model) && old('activity_type' , $model->activity_type) == "2" ? " selected " :''}}>{{l('اجاره')}}</option>
                                    <option value="3" {{!empty($model) && old('activity_type' , $model->activity_type) == "3" ? " selected " :''}}>{{l('هر دو')}}</option>
                                </select>
                            </div>
                            @endif
                            @if($currentUser->isAdminSuper())
                            <div class="col-sm-4 mb-3">
                                <label for="role" class="form-label fw-bold required">{{l('سطح دسترسی')}}</label>
                                <select name="role[]" id="role" class="form-control select2" multiple required >
                                    @foreach( $roles as $item)
                                        <option value="{{$item->name}}" {{!empty($model)?selectValueCreate($model->role_ids,$item->id):""}}>{{l($item->title)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="role" class="form-label fw-bold">{{l('وضعیت')}}</label>
                                <select class="form-control user-status" name="status" id="status">
                                    <option value="1" {{!empty($model) && old('status' , $model->status) == "1" ? " selected " :''}} class="text-success">{{l('فعال')}}</option>
                                    <option value="2" {{!empty($model) && old('status' , $model->status) == "2" ? " selected " :''}} class="text-warning">{{l('معلق')}}</option>
                                </select>
                            </div>

                            @endif
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="photo" class="form-label fw-bold">{{l('تصویر پروفایل')}}</label>
                                    <input type="file" name="photo" class="dropify" id="image" data-max-file-size="5M" data-height="300"
                                            data-default-file="{{ !empty($model) && old('photo',$model->photo()) }}" value="{{ !empty($model) && old('photo',$model->photo()) }}"/>
                                    @if(!empty($model) && !empty($model->photo()) && $model->photo != null)
                                    <div onclick="document.getElementById('photo1').click()" data-target="#photo1">
                                        <img src="{{ old('photo',$model->photo()) }}" id="preview" style="width: 100%" />
                                    </div>
                                    @endif
                                    @if(!empty($model) && empty($model->photo()) && $model->photo != null)
                                    <i class="fa-thin fa-cloud-arrow-up text-[36px]"></i>
                                    @else
                                    <a id="delete" style="cursor: pointer" class="cursor-pointer absolute bottom-7 left-0 text-blue-500 text-[14px] font-light {{(!empty($model) && !empty($model->photo))?'':'d-none'}}">{{ l('حذف') }}</a>
                                    @endif
                                </div>
                            </div>
                            <!--input type="hidden" name="status" value="1"-->
                        </div>
                    </section>
                    <!-- Action buttons -->
                    <section class="d-sm-flex justify-content-between pt-2">
                        <input type="hidden" name="user_id" value="{{$currentUser->id}}">
                        <button type="submit" class="btn btn-primary btn-lg d-block mb-2">
                            {{!empty($model)? l('ویرایش مشاور') :l('ثبت مشاور جدید')}}
                        </a>
                        </button>
                    </section>

                </form>
            </div>
        </div>
    </div>
</main>

    @include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
    <script src="/vendor/jquery-3.6.0.js"></script>
    <script src="/vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <!-- Main theme script-->
    <script src="{{asset('/assets/js/valid.js')}}"></script>
    <script>
        $('.select2').select2();
    </script>
    <script src="/admin2/dist/js/regions.js"></script>
<script>

$(document).ready(function()
{
    $('#js_singup-expert').validate({
        @if (env('COUNTRY') == 'UAE')
        rules: {
            username: {
              required: true,
              //email: true
            }
        },
        @endif
        errorPlacement: function (error, element) {
            var type = $(element).attr('cus-valid')
            if (type == 'true') {
                error.insertAfter(element.parent().parent());
            } else {
                error.insertAfter(element)
            }
        },
    });
    $("#delete").click(function(){
        $("#delete").addClass('d-none');
        $('#preview').attr("src", "");
        $(".photo").val(1);
    });
    getCities();
    getDistricts();
    getAreas();
    getAreaDistrict();
    @if(ss('SITE_ID') == 3)
        getStreets();
    @endif
});
</script>
@endsection
