@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => l('بلاگ'),
])
@section('main_content')
<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">
<!-- Vendor Styles-->
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
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
<!-- Main Theme Styles + Bootstrap-->
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => 'article'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{l('مدیریت مطالب')}}</li>
                    </ol>
                </nav>
                <!-- Page content-->
                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <h1 class="h2">{{l('مدیریت مطالب')}}</h1>
                    <a href="/profile/posts/create" class="btn btn-primary" >
                        <i class="fi fi-plus"></i> {{l('افزودن')}}
                    </a>
                </div>

                <div class="card shadow-sm rounded mb-4">
                    <div class=" card-body border-0 me-lg-1">
                        <form  id="mySearch">
                        <div class="row">
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                    <label class="form-label fw-bold" for="post_id"> {{l('کد مطلب')}}</label>
                                    <input type="text" id="post_id" name="post_id" class="form-control">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                    <label class="form-label fw-bold" for="title"> {{l('عنوان')}}</label>
                                    <input type="text" id="title" name="title" class="form-control">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label class="fw-bold form-label" for="category_id"> {{l('دسته بندی')}}</label>
                                <select class="form-select" name="category_id" id="category_id">
                                    <option value=""></option>
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label class="fw-bold form-label" for="visible">  {{l('وضعیت')}}</label>
                                <select class="form-select" name="active" id="active">
                                    <option value="1"> {{l('آشکار')}}</option>
                                    <option value="0"> {{l('مخفی')}}</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label for="name" class="form-label fw-bold">{{l('صفحات مستقل')}}</label>
                                <input type="checkbox" name="type" id="type" value="1">
                            </div>
                            <div class="d-flex justify-content-center my-4 ">
                                <button id="form_search" class="btn btn-primary">
                                    {{l('جستجو')}}
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="my-3 table-responsive table-p blog-list" id="blog-list">
                </div>
                <!-- Pagination-->
                <nav class="border-top pb-md-4 pt-4 mt-2" aria-label="Pagination"  id="pagination">
                </nav>
            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<link rel="stylesheet" href="/assets/css/sweetalert.css" />
<script src="/assets/js/sweetalert.min.js"></script>
<script src="{{asset('/frontend/js/paging.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#mySearch').on('submit', function(e){
            e.preventDefault();
            //CheckSend();
            return false;
        });
    });
    function CheckSend()
    {
        var sr = "";
        sr += ($('#post_id').val() != '') ? "id=" + $('#post_id').val() + "&" : "";
        sr += ($('#title').val() != '') ? "title=" + $('#title').val() + "&" : "";
        sr += (typeof $('#category_id').val()!=='undefined' && $('#category_id').val()>0)?"category_id="+$("#category_id").val()+"&":"";
        sr += (typeof $('#active').val()!=='undefined' && $('#active').val() != '')?"active="+$("#active").val()+"&":"";
        if($('#page').is(":checked")){
            sr+="type=page&&";
        }
        loadMoreData(1,sr)
    }


    $("#form_search").click(function() {
        CheckSend();
    });
    var pagin = 1;
    var str="";
    function loadMoreData(page,type) {
        type1=type;
        if(page==1){
            $(".blog-list").html("");
        }
        $.ajax({
                url: "?page="+page+"&&"+type,
                type: "get",
                beforeSend: function() {
                    $('.page-loading').addClass('active');
                }
            })
            .done(function(data) {
                $('.page-loading').removeClass('active');
                if (data.length == 0) {
                    return;
                }
                $(".blog-list").html(data.html);
                var result = Paging(pagin ,20,data.totalCount, "myClass", "myDisableClass");
                $("#pagination").html(result);
                $('.page-loading').removeClass('active');
            })
        }
        $("#pagination").on("click", "a", function () {
            pagin=$(this).attr("pn");
            if(pagin>0){
            loadMoreData($(this).attr("pn"),type1);
            }
        }
    );
    $(document).ready(function() {
        CheckSend();
    });
    function setVisible(id) {
        $.get("/profile/posts/status/" + id, function(data, status) {
            swal({
                title:"",
                text: "",
                type: 'success',
                allowOutsideClick: false,
            });
            CheckSend();
        });
    };
</script>

@endsection

