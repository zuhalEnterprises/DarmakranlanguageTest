@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => l('منابع'),
])
@section('main_content')
<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">
<!-- Vendor Styles-->
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
<link rel="stylesheet" href="/assets/css/sweetalert.css" />
<script src="/assets/js/sweetalert.min.js"></script>
<!-- Main Theme Styles + Bootstrap-->
<style>

.table-p{
    max-height:600px;
    overflow:auto;
    }

    thead tr:nth-child(1) th{
        position: sticky;
        top: 0;
        z-index: 10;
    }
</style>
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2')
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => 'province'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{l('منابع')}}</li>
                    </ol>
                </nav>
                <!-- Page content-->
                <div class="mb-4">
                    <h1 class="h2">{{l('منابع')}}</h1>
                </div>
                <div class="card card-body shadow-sm p-4 mb-4">
                    <form method="POST" action="{{empty($model)?'/acquaintance/store':'/acquaintance/update/'.$model->id}}">
                    @csrf
                    @method('post')
                    <div class="mb-4 fs-6">
                        <p class="fw-bold">{{!empty($model)? l('ویرایش منبع') :l('ثبت منبع')}}</p>
                        <div class="row align-items-end g-3">
                            <div class="col-md-10 ">
                                <label for="province" class="form-label fw-bold required">{{l('نام منبع')}}</label>
                                <input id="name" type="text" class="form-control" value="{{!empty($model)?$model->name:""}}" name="name" required placeholder="{{ l('تهران') }}">
                            </div>
                            <div class="col-md-2">
                                <button  type="submit" class=" btn btn-primary">
                                    <i class="  fa-light fa-save"></i>
                                    {{!empty($model)? l('ویرایش منبع') :l('ثبت منبع')}}
                                </button>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script>
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
