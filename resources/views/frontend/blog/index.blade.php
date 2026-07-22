@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', ['title' => isset($category) ? $category->name : l('وبلاگ')])
@section('head')

@endsection
@section('main_content')
@include(ss('THEME').'.frontend.layouts.header_v2')
<style>
    body{direction: rtl}
</style>
<main class="page-wrapper">
<div class="container mt-5 mb-md-4 py-5">
    <!-- Breadcrumb + page title-->
    @if(isset($category) && $category != null)
    <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
        </ol>
    </nav>
    <h1 class="h3 d-flex align-items-end justify-content-between font-vazir">
        {{$category->name}}
    </h1>
    @else

    @endif
    <!-- Search bar + filters-->
    <div class="row gy-3 mb-4 pb-2 d-none">
        <div class="col-lg-3 order-md-1 order-2">

        </div>
       <div class="col-lg-3 order-md-2 order-1 me-auto">
            <div class="d-flex flex-sm-row flex-column align-items-sm-center">

            </div>

        </div>
    </div>
    <!-- Articles grid-->
    <div class="row row-cols-md-3 row-cols-1 gy-md-5 gy-4 mb-lg-5 mb-4 blog-list mt-1"  id="agent-list-wrapper">
    </div>
    <!-- Pagination-->
    <nav class="" aria-label="Pagination"  id="pagination">
    </nav>

</div>
</main>
@section('js')
<script src="{{asset('/frontend/js/paging.js')}}"></script>
<script>



    function sort(){
        var type1 = "";

        return "";
    }
    var page = 1;
    var pagin = 1;
      $("#pagination").on("click", "a", function() {
        pagin = $(this).attr("pn");
        if(pagin>0){
            loadMoreData_v2($(this).attr("pn"), sort());
        }
    });


    loadMoreData_v2(1,sort());
function loadMoreData_v2(page,str) {

        $("#agent-list-wrapper").html("");

    $.ajax({
            url: "?page="+(page),
            type: "get",
            beforeSend: function() {
                //$("#spiner").removeClass("d-none");
            }
        })
        .done(function(data) {
            if (data.length == 0) {
                return;
            }
           // $("#spiner").addClass("d-none");
            if (data.count <= 0 || data.count == undefined) {
                hasData = false;
                return;
            }
            $(".btnmore1").addClass('d-none').removeClass('d-block');

                $("#agent-list-wrapper").append(data.html);

            var result = Paging(pagin, 21, data.count, "myClass", "myDisableClass");
                $("#pagination").html(result);
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            $("#spiner").addClass("d-none");
            //alert(l('مشکلی در دریافت اطلاعات بوجود آمده است...'));
        });
}
</script>
@endsection
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
