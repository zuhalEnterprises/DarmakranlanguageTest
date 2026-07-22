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
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <!-- Page content-->
        <div class="container pt-3 pb-lg-4 mt-5 mb-sm-2">
            <!-- Page content-->
            <div class="row">

                <!-- Page content-->
                <div class="col-lg-12 col-md-12 mb-5 account add-property">
                    <!-- Breadcrumb-->
                    <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{!empty($model)? l('ویرایش مشاور') :l('ثبت مشاور جدید')}}</li>
                        </ol>
                    </nav>

                    <!-- Basic info-->
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <li class="fw-bold">{{ $error }}</li>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="w-lg-50 rounded border p-4 p-lg-5 m-auto mb-5">
                        <p>

                        </p>
                        <form  id="js_singup-expert" role="form"  method="POST" action="<?php if (!empty($model)) echo '/profile/users/update/' . $model->id; else echo '/profile/users/store'; ?>" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="photoshow" class="photo" value="{{!empty($currentUser)?0:1}}" />
                            <div class="mb-4 pb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <label for="gender" class="form-label fw-bold w-50 w-lg-25">
                                        {{l('جنسیت')}}
                                    </label>
                                    <select class="form-select form-control form-control-sm w-100 w-lg-75" id="gender" name="gender" required>
                                        <option value="">{{ l('انتخاب کنید') }}</option>
                                        <option value="male" {{!empty($model) && $model->gender == "male" ? 'selected' :''}}>{{l('آقا')}}</option>
                                        <option value="female" {{!empty($model) && $model->gender == "female" ? 'selected' :''}}>{{l('خانم')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4 pb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <label class="form-label fw-bold w-50 w-lg-25" for="name">{{l('نام')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control form-control-sm w-50 w-lg-75" type="text"  id="name" name="name"  value="{{!empty($model)?$model->name:''}}" required>
                                </div>
                            </div>
                            <div class="mb-4 pb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <label class="form-label fw-bold w-50 w-lg-25" for="last_name">{{l('نام خانوادگی')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control form-control-sm w-50 w-lg-75" type="text"  id="last_name" name="last_name"  value="{{!empty($model)?$model->last_name:''}}" required>
                                </div>
                            </div>



                            <div class="mb-4 pb-2">
                                <div class="d-flex flex-wrap flex-lg-nowrap align-items-center gap-lg-3">
                                    <label for="about-expert" class="form-label fw-bold w-100 w-lg-25">{{ l('درباره مشاور') }}</label>
                                    <textarea class="form-control form-control-sm w-100 w-lg-75" name="bio" id="bio">{{ !empty($model) ? $model->bio : ''}}</textarea>
                                </div>
                                <div class="form-text" >
                                    {{ l('در چند جمله فعالیت حرفه ای خود را به دیگران معرفی کنید.') }}
                                </div>
                            </div>
                            <div class="mb-4 pb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <label for="photo" class="form-label fw-bold w-50 w-lg-25">{{l('تصویر پروفایل')}}</label>
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
                                <div class="form-text" >
                                    {{ l('عکس حرفه ای خود را برای نمایش در صفحه آگهی ها اضافه کنید.') }}

                                </div>
                            </div>
                            <div class="mb-4 pb-2">
                                <div class="d-flex flex-wrap flex-lg-nowrap align-items-center gap-lg-3">
                                    <label class="form-label fw-bold w-100 w-lg-25">{{ l('استان') }}</label>
                                    <select name="province_id" id="province_id" class="form-control select2">
                                        <option value="">{{ l('انتخاب کنید') }}</option>
                                        @foreach( $provinces as $item)
                                            <option value="{{$item->id}}"  {{!empty($model) && old('province_id',$model->province_id) == $item->id ? " selected " :''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4 pb-2">
                                <div class="d-flex flex-wrap flex-lg-nowrap align-items-center gap-lg-3">
                                    <label class="form-label fw-bold w-100 w-lg-25">{{l('شهر')}}</label>
                                    <select name="city_id" id="city_id" class="form-control select2" required>
                                        @foreach( $cities as $item)
                                            <option value="{{$item->id}}" {{!empty($model) && old('city_id',$model->city_id) == $item->id ? " selected " :''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4 pb-2">
                                <div class="d-flex flex-wrap flex-lg-nowrap align-items-center gap-lg-3">
                                    <label class="form-label fw-bold w-100 w-lg-25">{{ l('محل های فعالیت') }}</label>
                                    <select name="districts[]" class="form-control select2 district_id" id="district_id"  multiple style="width: 100%">
                                        @foreach( $districts as $item)
                                            <option value="{{$item->id}}" {{!empty($model) && array_key_exists($item->id , $model->selectedDistricts) ? 'selected' :''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if($currentUser->isAdminSuper() || $currentUser->isAdmin())
                            <div class="mb-4 pb-2">
                                <div class="d-flex  align-items-center gap-lg-3 flex-wrap flex-lg-nowrap">
                                    <label for="role" class="form-label fw-bold w-50 w-lg-25 required">{{l('سطح دسترسی')}}</label>
                                    <select name="role[]" id="role" class="form-select form-select-sm w-100 w-lg-75 select2" multiple required >
                                        @foreach( $roles as $item)
                                            <option value="{{$item->name}}" {{!empty($model)?selectValueCreate($model->role_ids,$item->id):""}}>{{l($item->title)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4 pb-2">
                                <div class="d-flex  align-items-center gap-lg-3 flex-wrap flex-lg-nowrap">
                                    <label for="role" class="form-label fw-bold w-50 w-lg-25">{{l('وضعیت')}}</label>
                                    <select class="form-select form-select-sm w-100 w-lg-75 user-status" name="status" id="status">
                                        <option value="1" {{!empty($model) && old('status' , $model->status) == "1" ? " selected " :''}} class="text-success">{{l('فعال')}}</option>
                                        <option value="2" {{!empty($model) && old('status' , $model->status) == "2" ? " selected " :''}} class="text-warning">{{l('معلق')}}</option>
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="role[]" id="role" value="expert">
                            <input type="hidden" name="status" id="status" value="1">
                            @endif

                            <div>
                                <input type="hidden" name="user_id" value="{{$currentUser->id}}">
                                <button type="submit" class="btn btn-primary w-100 w-lg-auto">
                                    {{!empty($model)? l('ویرایش مشاور') :l('ثبت مشاور جدید')}}
                                </button>
                            </div>

                        </form>
                    </div>

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
              email: true
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
