@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => l('لیست نظرات'),
])
@section('main_content')
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
            @include('frontend.layouts.sidebar', ['menu' => 'comment'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{l('لیست نظرات')}}</li>
                    </ol>
                </nav>

                <div class="card shadow-sm rounded mb-4">

                    <form  id="mySearch">
                    <div class=" card-body border-0  pb-1 me-lg-1">
                        <input type="hidden" name="order" id="order" value="id">
                        <input type="hidden" name="orderby" id="orderby" value="desc">
                        <div class="row">
                            <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                <label>{{l('نوع نظر')}}</label>
                                <select id="commentable_type" name="commentable_type"  class="form-control">

                                    <option value='estate'>
                                        {{l('املاک')}}
                                    </option>
                                <select>
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                <label>{{l('کد')}}</label>
                                <input id="commentable_id" name="commentable_id"  class="form-control">
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                <label>{{l('وضعیت')}}</label>
                                <select id="status" name="status"  class="form-control">
                                    <option></option>
                                    <option value='pending'>
                                        {{l('در حال بررسی')}}
                                    </option>
                                    <option value='verified'>
                                        {{l('تایید شده')}}
                                    </option>
                                    <option value='rejected'>
                                        {{l('رد شده')}}
                                    </option>

                                <select>
                            </div>

                        </div>
                        <div class="d-flex justify-content-center my-4 ">
                            <button id="form_search" class="btn btn-primary">
                                {{l('جستجو')}}
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="my-3 table-responsive table-p" id="comment-wrapper">
                </div>
                <!-- Pagination-->
                <nav class="border-top pb-md-4 pt-4 mt-2" aria-label="Pagination" id="pagination">
                </nav>

            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script src="/frontend/js/paging.js"></script>
<script>
$(document).ready(function(){
    $('#mySearch').on('submit', function(e){
        e.preventDefault();
        return false;
    });
});
function CheckSend()
{
    var sr = "";
    sr += ($('#commentable_type').val() != '') ? "commentable_type=" + $('#commentable_type').val() + "&" : "";
    sr += ($('#commentable_id').val() != '') ? "commentable_id=" + $('#commentable_id').val() + "&" : "";
    sr += ($('#status').val() != '') ? "status=" + $('#status').val() + "&" : "";
    sr+= "order="+$("#order").val()+"&";
    sr+= "orderby="+$("#orderby").val()+"&";
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
            $(".tab-content1").html("");
        }
        $.ajax({
                url: `?page=${page}&${type}`,
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
                $("#comment-wrapper").html(data.html);
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
$("#comment-wrapper").on('click',".status1",function () {
    statusItem($(this).parent().parent().attr("id"));
});
function deleteTodoItem(id)
{
    $.get("/comment/destroy/"+id, function (data, status) {
        if (data.result)
        {
            swal({
                title:"{{l('نظر مورد نظر با موفقیت حذف شد.')}}",
                text: "",
                type: 'success',
                allowOutsideClick: false,
            });
            CheckSend();
        }
        else
        {
            swal({
                title:"{{l('مشکلی در حذف اطلاعات وجود دارد')}}",
                text: "",
                type: 'error',
                allowOutsideClick: false,
            });

        }
    });
}

function statusVerified(id) {
    var state="";
    $.get("/comment/statusVerified/"+id, function (data, status)
    {
        swal({
            title:"{{l('نظر مورد نظر با موفقیت تائید شد.')}}",
            text: "",
            type: 'success',
            allowOutsideClick: false,
        });
        $('.status'+id).html('{{l('تایید شده')}}');
    });
}

function statusRejected(id) {
    $.get("/comment/statusRejected/"+id, function (data, status)
    {
        swal({
            title:"{{l('نظر مورد نظر با موفقیت غیرفعال شد.')}}",
            text: "",
            type: 'success',
            allowOutsideClick: false,
        });
        $('.status'+id).html('{{l('رد شده')}}');
    });
}

</script>
@endsection
