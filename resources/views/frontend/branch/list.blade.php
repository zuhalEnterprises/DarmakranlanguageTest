@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => l('مدیریت شعبه ها'),
])
@section('main_content')
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
            @include('frontend.layouts.sidebar', ['menu' => 'branches'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('مدیریت شعبه ها')}}</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="h2 mb-0">
                        {{l('مدیریت شعبه ها')}}
                    </h1>
                    <div>
                        <a href="/profile/branches/create">
                            <span class="btn btn-lg btnAdd btn-primary w-100 mb-2">
                                {{l('افزودن')}}
                            </span>
                        </a>
                    </div>
                </div>
                <div class="card shadow-sm rounded">
                    <form  id="mySearch">
                    <input type="hidden" name="order" id="order" value="id">
                    <input type="hidden" name="orderby" id="orderby" value="desc">
                    <div class=" card-body border-0  pb-1 me-lg-1">
                        <div class="row">

                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label class="form-label fw-bold">{{l('نام')}}</label>
                                <input type="text" class="form-control" id="name" name="name" />
                            </div>

                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label class="form-label fw-bold">{{l('وضعیت')}}</label>
                                <select id="status" name="status" class="form-control " style="width: 100%;" >
                                    <option value="">{{l('انتخاب کنید')}}</option>
                                    <option value="1" class="green">{{ l('فعال') }}</option>
                                    <option value="0" class="orange">{{ l('غیرفعال') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label class="form-label fw-bold">{{l('تعداد نمایش')}}</label>
                                <select id="showcount" name="showcount" class="form-control " style="width: 100%;" >
                                    <option value="10" class="green">10</option>
                                    <option value="20" class="orange">20</option>
                                    <option value="50" class="orange">50</option>
                                    <option value="100" class="orange">100</option>
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
                    <div class="overflow-auto  my-4 rounded" id="branch-wrapper">
                    </div>
                    <!-- Pagination-->
                    <nav class="border-top pb-md-4 pt-4 mt-2" aria-label="Pagination" id="pagination">
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>
@include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script src="/vendor/select2/select2.min.js"></script>
<script src="/frontend/js/paging.js"></script>
<link rel="stylesheet" href="/assets/css/sweetalert.css" />
<script src="/assets/js/sweetalert.min.js"></script>
<script src="/frontend/vendor/sweetalert2.all.js"></script>
<script>
    $(document).ready(function(){
        $('#mySearch').on('submit', function(e){
            e.preventDefault();
            return false;
        });
    });
    var CSRF_TOKEN = '{{ csrf_token() }}';

    function destroy(id) {
        swal({
            text: " {{l('آیا از حذف شعبه مورد نظر اطمینان دارید؟')}}",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: l('لغو'),
            confirmButtonText: l('بله'),
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                                url: '/profile/branches/' + id,
                                type: 'DELETE',
                                data: {_token: CSRF_TOKEN},
                                dataType: 'json'
                            })
                            .done(function (response) {
                                swal({
                                    text: '{{l('َشعبه با موفقیت حذف شد.')}}',
                                    type: 'success',
                                    allowOutsideClick: false
                                }).then((result) => {
                                    CheckSend();
                            });

                            })
                            .fail(function () {
                                swal('{{l('خطا!')}}', '{{l('حذف با مشکل مواجه شد!')}}', 'error');
                            });
                });
            },
            allowOutsideClick: false
        });
    }

    $(document).ready(function () {

        // set user status
        $('select.user-status').on('change', function () {
            var branch_id = $(this).data('id');
            var branch_status = this.value;

            $.get("/profile/branches/status/" + branch_id + "/" + branch_status, function (data, status) {
                if (data.status) {
                    toast({
                        type: 'success',
                        title: data.result
                    });
                } else {
                    toast({
                        type: 'error',
                        title: '{{l('عملیات با مشکل مواجه شد!')}}'
                    });
                }
            });
        });




        // go to panel


        // remove user

    });
</script>
<script>
    const toast = swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 2500
    });

    $(".select2").select2();
    var pagin = 1;
    var str = "";
    CheckSend();
    $("#form_search").click(function() {
        str = "";
        CheckSend();
    });

    function CheckSend() {

        var array = [];
        if ($("#id").val() != undefined && $("#id").val().length > 0)
            str += "id=" + $("#id").val() + "&&";
        if ($("#name").val() != undefined && $("#name").val().length > 0)
            str += "name=" + $("#name").val() + "&&";

        if ($("#status").val().length > 0)
            str += "status=" + $("#status").val() + "&&";
        str+= "order="+$("#order").val()+"&";
        str+= "orderby="+$("#orderby").val()+"&";
        str+= "showcount="+$("#showcount").val()+"&";

        var checkedVals = $('.theClass:checkbox:checked').map(function() {
            return this.value;
        }).get();
        for (var d in checkedVals) {
            array.push(d);
        }
        loadMoreData(1, str);
    };

    function loadMoreData(page, type2) {
        $('.page-loading').addClass('active');
        if (page == 1) {
            $("#branch-wrapper").empty();
        }
        $.ajax({
                url: `?page=${page}&&${type2}`,
                type: "get",
                beforeSend: function() {
                    $("#spiner").removeClass("d-none");
                }
            }).done(function(data) {
                if (data.totalCount < $("#showcount").val())
                    hasPage = false;
                else
                    hasPage = data.hasPage;
                $("#spiner").addClass("d-none");
                if (data.length == 0) {
                    return;
                }
                var htmlpage = data.html;
                $("#branch-wrapper").html(htmlpage);
                if(data.totalCount>parseInt($("#showcount").val()))
                {
                    var result = Paging(pagin, $("#showcount").val(), data.totalCount, "myClass", "myDisableClass");
                    $("#pagination").html(result);
                }
                else
                {
                    $("#pagination").html("");
                }
                pageflag = true;
                $('.page-loading').removeClass('active');
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                $("#spiner").addClass("d-none");
                $('.page-loading').removeClass('active');
            });
    };
    $("#pagination").on("click", "a", function() {
        pagin = $(this).attr("pn");
        if(pagin>0){
        window.scrollTo(0, 250);
            loadMoreData($(this).attr("pn"), str);
        }
    });

</script>

@endsection
