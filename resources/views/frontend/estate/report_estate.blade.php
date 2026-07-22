@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME')
])
@section('head')
<link rel="stylesheet" media="screen" href="/vendor/select2/select2.min.css" />
@endsection
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
        <!-- Page content-->
        <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
            <!-- Page content-->
            <div class="row">
                @include('frontend.layouts.sidebar', ['menu' => '15'])
                <!-- Content-->
                <div class="col-lg-9 col-md-12 mb-5">
                    <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ l('گزارشهای مشکل در املاک') }}</li>
                    </ol>
                </nav>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h1 class="h2 mb-0">
                            {{ l('گزارشهای مشکل در املاک') }}
                        </h1>
                    </div>
                    <div class="card shadow-sm rounded mb-4">
                        <form  id="mySearch">
                        <div class=" card-body border-0  pb-1 me-lg-1">
                            <input type="hidden" name="order" id="order" value="id">
                            <input type="hidden" name="orderby" id="orderby" value="desc">
                            <div class="row">


                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('کد ملک') }}</label>
                                    <input type="text" class="form-control" id="estate_id" name="estate_id" />
                                </div>
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('وضعیت') }}</label>
                                    <select class="form-control" name="status" id="status" style="width:100%">
                                        <option value="pending" class="text-warning">{{ l('در حال بررسی') }}</option>
                                        <option value="verified" class="text-success">{{ l('بررسی شده') }}</option>
                                        <option value="rejected" class="text-red">{{ l('رد شده') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('وضعیت') }}</label>
                                    <select class="form-control" name="status" id="status" style="width:100%">
                                    @foreach(estateReportReasons() as $key=>$val)
                                        <option value="{{$key}}" class="text-warning">{{$val['group']}}</option>
                                    @endforeach
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
                    <div class="tab-content1" id="state">
                    </div>
                    <nav class="pt-4 pb-2 border-top" aria-label="Blog pagination" id="pagination">
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
        sr += ($('#estate_id').val() != '') ? "estate_id=" + $('#estate_id').val() + "&" : "";
        sr += (typeof $('#reason_group').val()!=='undefined' && $('#reason_group').val()>0)?"type="+$("#reason_group").val()+"&":"";
        sr += (typeof $('#status').val()!=='undefined' && $('#status').val()>0)?"type="+$("#status").val()+"&":"";

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
                url: "/profile/reportEstateShow?page="+page+"&&"+type,
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
                $(".tab-content1").html(data.html);
                var result = Paging(pagin ,9,data.totalCount, "myClass", "myDisableClass");
                $("#pagination").html(result);
                $('.page-loading').removeClass('active');
            })
        }
        $("#pagination").on("click", "a", function () {
            pagin=$(this).attr("pn");
            if(pagin>0){
            loadMoreData($(this).attr("pn"),type1)
            }
        }
    );
    $(document).ready(function() {
        CheckSend();
    });
</script>
@endsection
