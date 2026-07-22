@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => l('تقاضاهای اجاره'),
])
@section('main_content')
<link href="/css/Mh1PersianDatePicker.css" rel="stylesheet" />
<style>
.help-table-color {
    display: block;
    width: 20px;
    height: 20px;
    background-color: red;
    border-radius: 100px;
}
.not{
        display: none
    }
    </style>
<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => '3'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('تقاضاهای اجاره')}}</li>
                    </ol>
                </nav>
                <div class="card shadow-sm">
                    <div class="card-header fw-bolder">{{l('جستجوی متقاضیان')}}</div>
                    <form  id="mySearch">
                    <input type="hidden" name="order" id="order" value="label">
                    <input type="hidden" name="orderby" id="orderby" value="asc">
                    <div class=" card-body border-0  pb-1 me-lg-1">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('وضعیت مشتری')}}</label>
                                <select id="status" name="status" class="form-control " style="width: 100%;" >
                                    <option></option>
                                    <option value="1">{{ l('در انتظار تائید') }}</option>
                                    <option value="2">{{ l('تائید شده مالک') }}</option>
                                    <option value="3">{{ l('تائید') }}</option>
                                    <option value="4">{{ l('آرشیو') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('کد مشتری')}}</label>
                                <input type="text" class="form-control" id="id" name="id" />
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('کد ملک')}}</label>
                                <input type="text" class="form-control" id="estate_id" name="estate_id" />
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('نام و نام خانوادگی')}}</label>
                                <input type="text" class="form-control" id="name" name="name" />
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('شماره همراه')}}</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" />
                            </div>


                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label fw-bold">{{ l('تاریخ سکونت از') }}</label>
                                <input type="text" name="stay_from" id="stay_from" onclick="Mh1PersianDatePicker.Show(this,'{{$dateto}}')" class="form-control text-muted pull-right">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label fw-bold">{{ l('تاریخ سکونت تا') }}</label>
                                <input type="text" name="stay_to" id="stay_to" onclick="Mh1PersianDatePicker.Show(this,'{{$dateto}}')" class="form-control text-muted pull-right">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3 rent" >
                                <label class="fw-bold">{{l('تعداد نمایش')}}</label>
                                <select class="form-control" id="showcount" style="width:100%">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50" selected>50</option>
                                    <option value="100">100</option>
                                    <option value="150">150</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <button id="form_search" class="btn btn-primary">
                            {{l('جستجو')}}
                        </button>
                    </div>
                    </form>
                </div>
                <div class="mt-4">
                    <a name="content"></a>
                    <div class="overflow-auto  my-4 rounded" id="estate-wrapper">
                    </div>
                    <!-- Pagination-->
                    <nav class="border-top pb-md-4 pt-4 mt-2" aria-label="Pagination" id="pagination">
                    </nav>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</main>

@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script src="/js/Mh1PersianDatePicker.js"></script>
<script src="/vendor/select2/select2.min.js"></script>
<script src="/frontend/js/paging.js"></script>
<link rel="stylesheet" href="/assets/css/sweetalert.css" />
<script src="/assets/js/sweetalert.min.js"></script>
<script src="/frontend/vendor/sweetalert2.all.js"></script>
<script>
    const toast = swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 2500
    });
</script>
<script>
    $(".search").click(function() {
        $("#search").toggle();
    })
    $(".select2").select2();
    var pagin = 1;
</script>
<script src="/vendor/select2/select2.min.js"></script>
<script src="{{asset('/frontend/js/paging.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#mySearch').on('submit', function(e){
            e.preventDefault();
            return false;
        });
    });



    $(".search").click(function() {
        $("#search").toggle();
    });
    $(".select2").select2();
    var pagin = 1;
    var str = "";
    var pageload = 0;
    CheckSend();
    $("#form_search").click(function() {
        str = "";
        CheckSend();
    });

    function CheckSend()
    {
        var array = [];
        if ($("#id").val() != undefined && $("#id").val().length > 0)
            str += "id=" + $("#id").val() + "&&";
        if ($("#name").val() != undefined && $("#name").val().length > 0)
            str += "name=" + $("#name").val() + "&&";
        if ($("#estate_id").val() != undefined && $("#estate_id").val().length > 0)
            str += "estate_id=" + $("#estate_id").val() + "&&";
        if ($("#mobile").val() != undefined && $("#mobile").val().length > 0)
            str += "mobile=" + $("#mobile").val() + "&&";;
        if ($("#name").val() != undefined && $("#status").val().length > 0)
            str += "status=" + $("#status").val() + "&&";;
        if ($("#user_id").val() != undefined && $("#user_id").val().length != 0)
            str += "user_id=" + $("#user_id").val() + "&&";

        str+= "showcount="+$("#showcount").val()+"&";
        str+= (typeof $('#stay_from').val()!=='undefined' && $('#stay_from').val() != '') ? "stay_from=" + $('#stay_from').val() + "&" : "";
        str+= (typeof $('#stay_to').val()!=='undefined' && $('#stay_to').val() != '') ? "stay_to=" + $('#stay_to').val() + "&" : "";
        var checkedVals = $('.theClass:checkbox:checked').map(function() {
            return this.value;
        }).get();
        for (var d in checkedVals) {
            array.push(d);
        }
        loadMoreData_v2(1, str);
    };

    function loadMoreData_v2(page, type2) {
        $('.page-loading').addClass('active');
        if (page == 1) {
            $("#estate-wrapper").empty();
        }
        $.ajax({
                url: `?page=${page}&&${type2}`,
                type: "get",
                beforeSend: function() {
                    $("#spiner").removeClass("d-none");
                }
            }).done(function(data) {
                if (data.totalCount < 15)
                    hasPage = false;
                else
                    hasPage = data.hasPage;
                $("#spiner").addClass("d-none");
                if (data.length == 0) {
                    return;
                }
                //$(".btnmore1").addClass('d-none').removeClass('d-block');
                var htmlpage = data.html;
                $("#estate-wrapper").html(htmlpage);
                if(data.totalCount>parseInt($("#showcount").val())){
                var result = Paging(pagin, $("#showcount").val(), data.totalCount, "myClass", "myDisableClass");
                $("#pagination").html(result);
                }
                else
                {
                    $("#pagination").html("");
                }
                if (data.totalCount == 0) {
                    $(".js_stateCount2").addClass("d-none").removeClass("d-block");
                    $(".js_stateCount1").addClass("d-block").removeClass("d-none");
                    //$(".js_stateCount1").html(data.totalCount);
                } else {
                    $(".js_stateCount2").addClass("d-block").removeClass("d-none");
                    $(".js_stateCount1").addClass("d-none").removeClass("d-block");
                    $(".js_stateCount").html(data.totalCount);
                }
                pageflag = true;
                $('.page-loading').removeClass('active');
                if(pageload == 1)
                {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=content]');
                    // Does a scroll target exist?
                    if (target.length) {
                        // Only prevent default if animation is actually gonna happen
                        //event.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top-70
                        }, 1000, function() {
                            // Callback after animation
                            // Must change focus!
                            var $target = $(target);
                            $target.focus();
                            if ($target.is(":focus")) { // Checking if the target was focused
                                return false;
                            } else {
                                $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
                                $target.focus(); // Set focus again
                            };
                        });
                    }
                }
                pageload = 1;
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                $("#spiner").addClass("d-none");
                $('.page-loading').removeClass('active');
            });
    };
    $("#pagination").on("click", "a", function()
    {
        pagin = $(this).attr("pn");
        if(pagin>0)
        {
            window.scrollTo(0, 250);
            loadMoreData_v2($(this).attr("pn"), str);
        }
    });
    $('form#search-customer').on('submit', function() {
        $('form#search-customer').find("input.number").each(function(i, v) {
            this.value = this.value.replace(/,/g, '');
        });
    });
</script>
@endsection
