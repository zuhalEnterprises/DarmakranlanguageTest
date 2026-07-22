@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => (!empty($model)? l('ویرایش پروژه') :l('ثبت پروژه')),
])
@section('main_content')
<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">
<!-- Vendor Styles-->
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
<!-- Main Theme Styles + Bootstrap-->
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2')
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => 'project'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{!empty($model)? l('ویرایش پروژه') :l('ثبت پروژه')}}</li>
                    </ol>
                </nav>
                <form method="post" id="js_singup" action="{{empty($model)?"/profile/project/store":"/profile/project/update/".$model->id}}">
                    @csrf
                    @method('post')
                <!-- Page content-->
                <div class="mb-4">
                    <h1 class="h2">{{!empty($model)? l('ویرایش پروژه') :l('ثبت پروژه')}}</h1>
                </div>
                <div class="card card-body shadow-sm rounded p-4 mb-4">
                    <div class="row">
                        <div class="col-6 col-md-6 mb-4">
                            <label for="name" class="form-label fw-bold required">{{l('نام')}}</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{!empty($model)?$model->name:""}}" required>
                        </div>

                        <div class="col-6 col-md-6 mb-4">
                            <label for="name_en" class="form-label fw-bold ">{{l('کد مقاله')}}</label>
                            <input id="post_id" type="text" class="form-control number" name="post_id" value="{{!empty($model)?$model->post_id:""}}" >
                        </div>
                        <div class="col-6 col-md-6 mb-4">
                            <label for="manufacturer_id" class="form-label fw-bold required">{{l('سازنده')}}</label>
                            <select id="manufacturer_id" name="manufacturer_id"  class="form-control select2" required>
                                <option></option>
                                @foreach ($manufacturers as $manufacturer)
                                <option value="{{$manufacturer->id}}" {{$manufacturer->id == (!empty($model)?$model->manufacturer_id : '') ? 'selected' :''}}>
                                    {{$manufacturer->name}}
                                </option>
                                @endforeach
                            <select>
                        </div>

                        <div class="col-6 col-md-6 mb-4">
                            <label class="form-label" for="ap-city"> {{l('انتخاب شهر')}}
                            </label>
                            <select class="form-select"  name="city_id" id="city_id">
                                <option value="" >{{l('انتخاب شهر')}}</option>
                                @foreach($cities as $city2)
                                <option value="{{$city2->id}}" {{$city2->id == (!empty($model)?$model->city_id : $city->id) ? 'selected' :''}}>{{$city2->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-6 mb-4">
                            <label class="form-label" for="ap-district"> {{l('انتخاب محله‌ درخواستی')}} </label>
                            <select class="form-select js-example-disabled-results select2" name="district_id" id="district_id" aria-placeholder="test">
                                <option value="" >{{l('انتخاب محله')}}</option>
                                @if(isset($districts))
                                @foreach($districts as $district)
                                <option value="{{$district->id}}" {{!empty($model) && $district->id == $model->district_id ? "selected" : ''}}>{{$district->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="  fa-light fa-save"></i>
                                {{!empty($model)? l('ویرایش پروژه') :l('ثبت پروژه')}}
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
<script src="/admin2/dist/js/regions.js"></script>
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
    getCities();
    getDistricts();
    getAreas();
    getAreaDistrict();
</script>

@endsection
