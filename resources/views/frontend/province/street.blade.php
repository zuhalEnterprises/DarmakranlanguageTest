@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => l('لیست خیابان‌ها'),
])
@section('main_content')
<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">
<script src="/assets/js/sweetalert.min.js"></script>
<link rel="stylesheet" href="/assets/css/sweetalert.css" />
<!-- Vendor Styles-->
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
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
            @include('frontend.layouts.sidebar', ['menu' => 'street'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{l('لیست خیابان‌ها')}}</li>
                    </ol>
                </nav>
                <!-- Page content-->
                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <h1 class="h2">{{l('لیست خیابان‌ها')}}</h1>
                    <a href="/profile/street/create" class="btn btn-primary">
                        <i class="fi fi-plus"></i> {{ l('افزودن') }}
                    </a>
                </div>
                <div class="card shadow-sm rounded mb-4">
                    <form  id="mySearch">
                    <div class=" card-body border-0  pb-1 me-lg-1">
                        <input type="hidden" name="order" id="order" value="id">
                        <input type="hidden" name="orderby" id="orderby" value="desc">
                        <div class="row">
                            <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                <label>{{ l('نام خیابان') }}</label>
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                <label>{{ l('استان') }}</label>
                                <select id="province_id" name="province_id" class="select2 form-control">
                                    <option value="">&nbsp</option>
                                    @foreach( $provinces as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                <label>{{ l('شهر') }}</label>
                                <select id="city_id" name="city_id" class="select2 form-control">
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                <label>{{ l('محله') }}</label>
                                <select id="district_id" name="district_id" class="select2 form-control">
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center my-4 ">
                            <button id="form_search" class="btn btn-primary">
                                {{ l('جستجو') }}
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="my-3 table-responsive table-p" id="estate-wrapper">
                </div>
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
<script src="/vendor/select2/select2.min.js"></script>
<script src="/admin2/dist/js/regions.js"></script>
<script>
getCities();
getAreas();
getDistricts();
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
    sr += (typeof $('#district_id').val()!=='undefined' && $('#district_id').val()>0)?"district_id="+$("#district_id").val()+"&":"";
    sr += (typeof $('#city_id').val()!=='undefined' && $('#city_id').val()>0)?"city_id="+$("#city_id").val()+"&":"";
    sr += (typeof $('#province_id').val()!=='undefined' && $('#province_id').val()>0)?"province_id="+$("#province_id").val()+"&":"";
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
                    //$('.page-loading').addClass('active');
                }
            })
            .done(function(data) {
                $('.page-loading').removeClass('active');
                if (data.length == 0) {
                    return;
                }
                $("#estate-wrapper").html(data.html);
                var result = Paging(pagin ,20,data.totalCount, "myClass", "myDisableClass");
                $("#pagination").html(result);
                //$('.page-loading').removeClass('active');
            })
        }
        $("#pagination").on("click", "a", function () {
            pagin=$(this).attr("pn");
            if(pagin>0){ loadMoreData($(this).attr("pn"),type1); } } ); $(document).ready(function() { CheckSend(); }); function deleteTodoItem(id) { //var id =$(item).attr('ids'); //alert(id); $.get("/profile/street/destroy/"+id, function (data, status) { if (data.result) { swal({ title:l("خیابان با موفقیت حذف شد."), text: "", type: 'success', allowOutsideClick: false, }); CheckSend(); } else { swal({ title:l("مشکلی در حذف اطلاعات وجود دارد"), text: "", type: 'error', allowOutsideClick: false, }); } }); }
</script>
@endsection
