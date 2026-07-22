@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => l('منبع مشتری'),
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
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
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
                        <li class="breadcrumb-item active" aria-current="page">{{l('منبع مشتری')}}</li>
                    </ol>
                </nav>
                <!-- Page content-->
                <div class="mb-4">
                    <h1 class="h2">{{l('منبع مشتری')}}</h1>
                </div>
                <div class="card card-body shadow-sm p-4 mb-4">
                    <form  id="js_singup-expert" method="POST" action="/acquaintance/store">
                        @csrf
                        @method('post')
                        <div class="mb-4 fs-6">
                            <p class="fw-bold">{{l('ایجاد منبع جدید')}}</p>
                            <div class="row align-items-end g-3">
                                <div class="col-md-10 ">
                                    <label for="province" class="form-label fw-bold required">{{l('نام منبع')}}</label>
                                    <input id="name" type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-2">
                                    <button  type="submit" class=" btn btn-primary">
                                        <i class="  fa-light fa-save"></i>
                                        {{l('ذخیره')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card card-body shadow-sm p-4 mb-4">
                    <p class="fs-6 fw-bold">{{l('لیست منابع')}}</p>
                    <div class="my-3 table-responsive table-p" id="estate-wrapper">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th valign="middle" class="header" style="text-align:center" scope="col">{{l('شناسه')}}</th>
                                    <th valign="middle" class="header" style="text-align:center" scope="col">{{l('نام منبع')}}</th>
                                    <th valign="middle" class="header" style="text-align:center" scope="col">{{l('ابزار')}}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach( $model as $item)

                                <tr id="{{$item->id}}">
                                    <td valign="middle" align="center">{{$item->id}}</td>
                                    <td valign="middle" align="center">
                                        {{$item->name}}
                                    </td>

                                    <td valign="middle" align="center">
                                        <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fi-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                                            <li>
                                                <a class="dropdown-item"  href="/acquaintance/edit/{{$item->id}}">
                                                    <i class="fa-light fa-edit opacity-60 me-2"></i> {{l('ویرایش')}}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item del" href="javascript:void(0)" onclick="deleteTodoItem({{$item->id}})">
                                                    <i class="fa-light fa-trash-can opacity-60 me-2"></i> {{l('حذف')}}
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script>
$(document).ready(function()
{
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
$("#estate-wrapper").on('click',".status1",function () {
    statusItem($(this).parent().parent().attr("id"));
});
function deleteTodoItem(id) {
    //var id =$(item).attr('ids');
    //alert(id);
    $.get("/acquaintance/destroy/"+id, function (data, status) {
        if (data.result) {
            swal({
                title:"{{l('گزینه ی مورد نظر با موفقیت حذف شد.')}}",
                text: "",
                type: 'success',
                allowOutsideClick: false,
            });
            $("#"+id).remove();


        } else {
            swal({
                title:"{{l('مشکلی در حذف اطلاعات وجود دارد')}}",
                text: "",
                type: 'error',
                allowOutsideClick: false,
            });

        }
    });
}

</script>
@endsection
