@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => (!empty($model)? l('ویرایش شماره تلفن') :l('ثبت شماره تلفن')),
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
            @include('frontend.layouts.sidebar', ['menu' => 'phonebook'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{!empty($model)? l('ویرایش شماره تلفن') :l('ثبت شماره تلفن')}}</li>
                    </ol>
                </nav>
                <form method="post" id="js_singup" action="{{empty($model)?"/profile/phonebook/store":"/profile/phonebook/update/".$model->id}}">
                    @csrf
                    @method('post')
                <!-- Page content-->
                <div class="mb-4">
                    <h1 class="h2">{{!empty($model)? l('ویرایش شماره تلفن') :l('ثبت شماره تلفن')}}</h1>
                </div>
                <div class="card card-body shadow-sm rounded p-4 mb-4">
                    <div class="row">
                        <div class="col-6 col-md-6 mb-4">
                            <label for="name" class="form-label fw-bold required">{{ l('نام') }}</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{!empty($model)?$model->name:""}}" required>
                        </div>

                        <div class="col-6 col-md-6 mb-4">
                            <label for="phone" class="form-label fw-bold ">{{ l('تلفن') }}</label>
                            <input id="phone" type="text" class="form-control" name="phone" value="{{!empty($model)?$model->phone:""}}" >
                        </div>
                        <div class="col-6 col-md-6 mb-4">
                            <label for="description" class="form-label fw-bold ">{{ l('توضیحات') }}</label>
                            <input id="description" type="text" class="form-control" name="description" value="{{!empty($model)?$model->description:""}}" >
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="  fa-light fa-save"></i>
                                {{!empty($model)? l('ویرایش شماره تلفن') :l('ثبت شماره تلفن')}}
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
