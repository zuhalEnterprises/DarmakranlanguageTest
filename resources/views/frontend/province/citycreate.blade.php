@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => (!empty($model)? l('ویرایش شهر') :l('ثبت شهر')),
])
@section('main_content')
<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">
<!-- Vendor Styles-->
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
<!-- Main Theme Styles + Bootstrap-->
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => 'city'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{!empty($model)? l('ویرایش شهر') :l('ثبت شهر')}}</li>
                    </ol>
                </nav>
                <form method="post" id="js_singup" action="{{empty($model)?"/profile/city/store":"/profile/city/update/".$model->id}}">
                    @csrf
                    @method('post')
                <!-- Page content-->
                <div class="mb-4">
                    <h1 class="h2">{{!empty($model)? l('ویرایش شهر') :l('ثبت شهر')}}</h1>
                </div>
                <div class="card card-body shadow-sm rounded p-4 mb-4">
                    <div class="row">
                        <div class="col-6 col-md-6 mb-4">
                            <label for="name" class="form-label fw-bold required">{{l('نام شهر (فارسی)')}}</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{!empty($model)?$model->getOriginalName():""}}" required>
                        </div>

                        <div class="col-6 col-md-6 mb-4">
                            <label for="name_en" class="form-label fw-bold required">{{l('نام شهر (انگلیسی)')}}</label>
                            <input id="name_en" type="text" class="form-control" name="name_en" value="{{!empty($model)?$model->getOriginalNameEn():""}}" >
                        </div>
                        @if(env('COUNTRY') != 'UAE')
                        <div class="col-6 col-md-6 mb-4">
                            <label for="name" class="form-label fw-bold ">{{l('طول جغرافیایی')}}</label>
                            <input id="posx" type="text" class="form-control" name="posx" value="{{!empty($model)?$model->posx:""}}" >
                        </div>
                        <div class="col-6 col-md-6 mb-4">
                            <label for="name_en" class="form-label fw-bold ">{{l('عرض جغرافیایی')}}</label>
                            <input id="posy" type="text" class="form-control" name="posy" value="{{!empty($model)?$model->posy:""}}" >
                        </div>
                        @endif
                        @if(ss('SITE_ID') == 2 || env('COUNTRY') == 'UAE' || ss('SITE_ID') == 3)
                        <div class="col-6 col-md-6 mb-4">
                            <label for="name_en" class="form-label fw-bold ">{{l('کد مقاله')}}</label>
                            <select id="post_id" name="post_id" class="select2 form-control" >
                                <option value="">&nbsp;</option>
                                @foreach( $posts as $item)
                                <option value="{{$item->id}}" {{$item->id == (!empty($model)?$model->post_id : '') ? 'selected' :''}}>{{$item->title}}</option>
                                @endforeach
                            </select>
                            <!--input id="post_id" type="text" class="form-control" name="post_id" value="{{!empty($model)?$model->post_id:""}}" -->
                        </div>
                        @endif

                        <!--div class="col-6 col-md-6 mb-4">
                            <label for="province_id" class="form-label fw-bold required">Country</label>
                            <select id="province_id" name="province_id"  class="form-control select2" required>
                                @foreach ($provinces as $province)
                                <option value="{{$province->id}}" {{$province->id == (!empty($model)?$model->province_id : '') ? 'selected' :''}}>
                                    {{$province->name}}
                                </option>
                                @endforeach
                            <select>
                        </div-->

                        @if (env('COUNTRY') != 'UAE')
                        <div class="col-6 col-md-6 mb-4">
                            <label for="province_id" class="form-label fw-bold required">{{ l('استان') }}</label>
                            <select id="province_id" name="province_id"  class="form-control select2" required>
                                <option></option>
                                @foreach ($provinces as $province)
                                <option value="{{$province->id}}" {{$province->id == (!empty($model)?$model->province_id : '') ? 'selected' :''}}>
                                    {{$province->name}}
                                </option>
                                @endforeach
                            <select>
                        </div>
                        <div class="col-6 col-md-6 mb-4">
                            <label for="region_number" class="form-label fw-bold required">{{ l('تعداد مناطق') }}</label>
                            <input id="count_area" type="text" class="form-control number" name="count_area" value="{{!empty($model)?$model->count_area:"0"}}" required>
                        </div>
                        @endif


                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="  fa-light fa-save"></i>
                                {{!empty($model)? l('ویرایش شهر') :l('ثبت شهر')}}
                            </button>
                        </div>
                     </div>
                </div>
                </form>
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script src="/vendor/select2/select2.min.js"></script>
<script>
    $('.select2').select2();
    $(document).ready(function() {
        $('#js_singup').validate({
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
