@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => l('دفترچه تلفن'),
])
@section('main_content')
<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">
<!-- Vendor Styles-->
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
<script src="/vendor/jquery-3.6.0.js"></script>
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
            @include('frontend.layouts.sidebar', ['menu' => 'phonebook'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{l('دفترچه تلفن')}}</li>
                    </ol>
                </nav>
                <!-- Page content-->
                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <h1 class="h2">{{l('دفترچه تلفن')}}</h1>
                    <a href="/profile/phonebook/create" class="btn btn-primary" >
                        <i class="fi fi-plus"></i> {{l('افزودن')}}
                    </a>
                </div>
                <div class="card shadow-sm rounded mb-4">
                    <form  id="mySearch">
                    <div class=" card-body border-0  pb-1 me-lg-1">
                        <input type="hidden" name="order" id="order" value="id">
                        <input type="hidden" name="orderby" id="orderby" value="desc">
                        <div class="row">

                            <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                <label>{{l('نام')}}</label>
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                            @if(env('COUNTRY') != 'UAE')
                            <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                <label>{{ l('تلفن') }}</label>
                                <input id="phone" type="text" class="form-control" name="phone">
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                <label>{{ l('شماره خصوصی') }}</label>
                                <input id="private" type="checkbox" value="1" name="private">
                            </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-center my-4 ">
                            <button id="form_search" class="btn btn-primary">
                                {{l('جستجو')}}
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="my-3 table-responsive table-p" id="phonebook-wrapper">
                </div>
                <!-- Pagination-->
                <nav class="pb-md-4 pt-4 mt-2" aria-label="Pagination" id="paginationPhonebook">
                </nav>


                <div class="my-3 table-responsive table-p" id="estate-wrapper">
                </div>
                <!-- Pagination-->
                <nav class="pb-md-4 pt-4 mt-2" aria-label="Pagination" id="paginationEstate">
                </nav>

                <div class="my-3 table-responsive table-p" id="customer-wrapper">
                </div>
                <!-- Pagination-->
                <nav class="pb-md-4 pt-4 mt-2" aria-label="Pagination" id="paginationCustomer">
                </nav>


                <div class="my-3 table-responsive table-p" id="user-wrapper">
                </div>
                <!-- Pagination-->
                <nav class="pb-md-4 pt-4 mt-2" aria-label="Pagination" id="paginationUser">
                </nav>
            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script src="/frontend/js/paging.js"></script>
<script src="/vendor/select2/select2.min.js"></script>
<script>
$('.select2').select2();
$(document).ready(function(){
    $('#mySearch').on('submit', function(e){
        e.preventDefault();
        return false;
    });
});
function CheckSend()
{
    var sr = "";
    sr += ($('#name').val() != '') ? "name=" + $('#name').val() + "&" : "";
    sr += ($('#phone').val() != '') ? "phone=" + $('#phone').val() + "&" : "";
    sr += ($('#private').val() != '') ? "private=" + $('#private').is(':checked') + "&" : "";

    loadMoreData(1,1,1,1,sr)
}
$("#form_search").click(function() {
    CheckSend();
});

var paginEstate = 1;
var paginCustomer = 1;
var paginUser = 1;
var paginPhonebook = 1;
var str="";
function loadMoreData(pageEstate , pageCustomer , pageUser , pagePhonebook , type) {
    type1 = type;
    /*if(pageEstate == 1){
        $("#estate-wrapper").html("");
    }
    if(pageCustomer == 1){
        $("#customer-wrapper").html("");
    }
    if(pageUser == 1){
        $("#user-wrapper").html("");
    }
    if(pagePhonebook == 1){
        $("#phonebook-wrapper").html("");
    }*/
    $.ajax({
            url: `?pageEstate=${pageEstate}&pageCustomer=${pageCustomer}&pageUser=${pageUser}&pagePhonebook=${pagePhonebook}&${type}`,
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

            if($('#private').is(':checked') == 0)
            {
                $("#estate-wrapper").html(data.htmlEstate);
                var resultEstate = Paging(paginEstate , 20 , data.totalCountEstate, "myClass", "myDisableClass");
                $("#paginationEstate").html(resultEstate);

                $("#customer-wrapper").html(data.htmlCustomer);
                var resultCustomer = Paging(paginCustomer , 20 , data.totalCountCustomer, "myClass", "myDisableClass");
                $("#paginationCustomer").html(resultCustomer);

                $("#user-wrapper").html(data.htmlUser);
                var resultUser = Paging(paginUser , 20 , data.totalCountUser, "myClass", "myDisableClass");
                $("#paginationUser").html(resultUser);
            }
            else
            {
                $("#estate-wrapper").html('');
                $("#customer-wrapper").html('');
                $("#user-wrapper").html('');
                $("#paginationEstate").html('');
                $("#paginationCustomer").html('');
                $("#paginationUser").html('');
            }

            $("#phonebook-wrapper").html(data.htmlPhonebook);
            var resultPhonebook = Paging(paginPhonebook , 20 , data.totalCountPhonebook, "myClass", "myDisableClass");
            $("#paginationPhonebook").html(resultPhonebook);
        })
    }
    $("#paginationEstate").on("click", "a", function () {
        paginEstate = $(this).attr("pn");
        if(paginEstate > 0){
            loadMoreData(paginEstate , paginCustomer , paginUser , paginPhonebook ,type1);
        }
    });
    $("#paginationCustomer").on("click", "a", function () {
        pagin = $(this).attr("pn");
        if(pagin>0){
            loadMoreData(paginEstate , paginCustomer , paginUser , paginPhonebook ,type1);
        }
    });
    $("#paginationUser").on("click", "a", function () {
        pagin=$(this).attr("pn");
        if(pagin>0){
            loadMoreData(paginEstate , paginCustomer , paginUser , paginPhonebook ,type1);
        }
    });
    $("#paginationPhonebook").on("click", "a", function () {
        pagin=$(this).attr("pn");
        if(pagin>0){ loadMoreData(paginEstate , paginCustomer , paginUser , paginPhonebook ,type1); } }); $(document).ready(function() { CheckSend(); }); function deleteTodoItem(id) { //var id =$(item).attr('ids'); //alert(id); $.get("/profile/phonebook/destroy/"+id, function (data, status) { if (data.result) { swal({ title:l("گزینه ی مورد نظر با موفقیت حذف شد."), text: "", type: 'success', allowOutsideClick: false, }); $("#"+id).remove(); } else { swal({ title:l("مشکلی در حذف اطلاعات وجود دارد"), text: "", type: 'error', allowOutsideClick: false, }); } }); }

</script>
@endsection
