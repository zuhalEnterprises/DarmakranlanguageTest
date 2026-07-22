@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME')
])
@section('head')
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

    table{color:black!important}
    @media (min-width: 1000px){
        .modal-dialog {
        max-width: 800px!important;
        margin: 1.75rem auto;
        }
    }
</style>
<link rel="stylesheet" media="screen" href="/vendor/select2/select2.min.css" />
<link href="/css/Mh1PersianDatePicker.css" rel="stylesheet" />
@endsection
@section('main_content')

<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => 'contract'])
            <!-- Content-->
            <div class="col-lg-9 col-md-12 mb-5">
                <!-- Breadcrumb-->
            <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> {{l('نمایش قرارداد')}}</li>
                </ol>
            </nav>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="h2 mb-0">
                        {{l('نمایش قرارداد')}}
                    </h1>
                    <a class="btn btn-primary btn-sm ms-2 order-lg-3" href="/profile/contract/add"><i class="fi-plus me-2"></i>{{ l('ثبت قرارداد جدید') }}</a>

                </div>
                <div class="card shadow-sm rounded mb-4">
                    <form  id="mySearch">
                    <div class=" card-body border-0 me-lg-1">

                        <div class="row">
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                    <label class="form-label fw-bold" for="code-title">{{ l('کد قرارداد') }}</label>
                                    <input type="text" id="contractid" name="contractid" class="form-control">
                            </div>

                            <!-- <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                    <label class="fw-bold" for="time">{{ l('تاریخ ثبت') }}</label>
                                    <input type="text" id="time" name="time" class="form-control">
                            </div> -->
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                    <label class="form-label fw-bold">{{ l('تاریخ ایجاد از') }}</label>
                                    <input type="text" name="create_date_of" id="create_date_of" value="{{ app('request')->input('datefrom') }}" onclick="Mh1PersianDatePicker.Show(this,'{{gregorian_to_jalali(date('Y'),date('m'),date('d'),'/')}}')" class="form-control text-muted pull-right">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3 ">
                                <label class="form-label fw-bold">{{ l('تاریخ ایجاد تا') }}</label>
                                <input type="text" name="create_date_to" id="create_date_to" value="{{ app('request')->input('dateto') }}" onclick="Mh1PersianDatePicker.Show(this,'{{gregorian_to_jalali(date('Y'),date('m'),date('d'),'/')}}')" class="form-control text-muted pull-right">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                    <label class="fw-bold form-label" for="code-register">{{ l('کد ملی(فروشنده/موجر)') }}</label>
                                    <input type="text" id="estate_nationalId" name="estate_nationalId" class="form-control">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                    <label class="fw-bold form-label" for="lastname">{{ l('نام و نام خانوداگی(فروشنده/موجر)') }}</label>
                                    <input type="text" id="estate_name" name="estate_name" class="form-control">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                    <label class="fw-bold form-label" for="mobile">{{ l('شماره موبایل(فروشنده/موجر)') }}</label>
                                    <input type="text" id="estate_phone" name="estate_phone" class="form-control">
                            </div>

                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label class="fw-bold form-label" for="code-register">{{ l('کد ملی(خریدار/مستاجر)') }}</label>
                                <input type="text" id="customer_nationalId" name="customer_nationalId" class="form-control">
                        </div>
                        <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label class="fw-bold form-label" for="lastname">{{ l('نام و نام خانوداگی(خریدار/مستاجر)') }}</label>
                                <input type="text" id="customer_name" name="customer_name" class="form-control">
                        </div>
                        <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label class="fw-bold form-label" for="mobile">{{ l('شماره موبایل(خریدار/مستاجر)') }}</label>
                                <input type="text" id="customer_phone" name="customer_phone" class="form-control">
                        </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label class="fw-bold form-label" for="expert">{{ l('مشاور') }}</label>
                                <select class="form-select select2" dir="rtl" name="expert" id="expert">
                                    <option selected></option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ (app('request')->input('user_id') == $user->id)?"selected":"" }}>
                                        {{ $user->fullname() }}
                                    </option>
                                     @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label for="type" class="fw-bold form-label">{{ l('نوع قرارداد') }}</label>
                                <select class="form-select" name="type" id="type">
                                    <option value="">{{ l('انتخاب نوع قرارداد') }}</option>
                                    <option value="1" {{ (app('request')->input('type') == 1)?"selected":"" }}>{{ l('فروش') }}</option>
                                    <option value="2" {{ (app('request')->input('type') == 2)?"selected":"" }}>{{ l('اجاره') }}</option>
                                    <option value="3" {{ (app('request')->input('type') == 3)?"selected":"" }}>{{ l('ناموفق') }}</option>
                                    <option value="4" {{ (app('request')->input('type') == 4)?"selected":"" }}>{{ l('مشارکت در ساخت') }}</option>
                                    <option value="5" {{ (app('request')->input('type') == 5)?"selected":"" }}>{{ l('تهاتر') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label for="estate_type" class="fw-bold form-label">{{ l('نوع ملک') }}</label>
                                <select class="form-select" name="estate_type" id="estate_type">
                                    <option value="">{{ l('انتخاب نوع ملک') }}</option>
                                    <option value="1">{{ l('آپارتمان') }}</option>
                                    <option value="2">{{ l('منزل ویلایی') }}</option>
                                    <option value="3">{{ l('مغازه') }}</option>
                                    <option value="4">{{ l('زمین و باغ') }}</option>
                                    <option value="5">{{ l('صنعتی-تجاری') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-12 col-sm-12 mt-3">
                                    <label class="fw-bold" for="adress">{{ l('آدرس') }}</label>
                                    <input type="text" id="estate_address" name="estate_address" class="form-control">
                            </div>
                            @if(ss('SITE_ID') == 5 || ss('SITE_ID') == 8)
                            <div class="col-md-6 col-lg-6 col-sm-6 mt-3">
                                <label class="fw-bold" for="adress">{{ l('قولنامه ها در این تاریخ') }}</label>
                                <input type="checkbox" id="reminder" name="reminder" value="1" class="">
                            </div>
                            @endif
                            <div class="d-flex justify-content-center my-4 ">
                                <button id="form_search" class="btn btn-primary">
                                    {{ l('جستجو') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="card shadow-sm rounded mb-4">
                    <div class=" card-body border-0  pb-1 me-lg-1 table-p" id="estate-wrapper">
                    </div>
                    <nav class="border-top pb-md-4 pt-4 mt-2" aria-label="Pagination" id="pagination">
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="my_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <form role="form" method="POST" id="frm-history" action="">
            <input type="hidden" name="type" value="archive">
            @csrf
            <div class="modal-content" style="width: 650px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel"></h4>
                </div>
                <div class="modal-body" id="modal-body">
                    <div class="form-group ">
                        <label for="modal-description" class="required">{{ l('توضیحات') }}</label>
                        <textarea class="form-control" name="description" id="modal-description" required></textarea>
                        <p class="text-red" id="description-error" style="display: none">{{ l('فیلد توضیحات الزامیست!') }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-right">
                        <i class="fa fa-save"></i> {{ l('ذخیره') }}
                    </button>
                    <button class="btn btn-danger pull-left" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i> {{ l('انصراف') }}
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<div class="modal fade" id="modal-history" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 750px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel"></h4>
            </div>
            <div class="modal-body" id="modal-body" style="background-color: #ecf0f5;">
                <p class="text-center" id="loading">{{ l('در حال دریافت اطلاعات ...') }}</p>
                <ul class="timeline">
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="estatecheck" style="background:white" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel"> {{l('پرداخت کمیسیون')}} </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="estatecheck1">
        </div>
      </div>
    </div>
  </div>

@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection

@section('js')
<script src="/frontend/js/paging.js"></script>
<script src="/js/Mh1PersianDatePicker.js"></script>
<script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#mySearch').on('submit', function(e){
            e.preventDefault();
            return false;
        });
    });
    $(".select2").select2();
    var route = 'contracts';
    var CSRF_TOKEN = '{{csrf_token()}}';
    var page = 1;
        var pagin = 1;

    $("#form_search").click(function(){
        loadMoreData_v2(1,str);
    })
    loadMoreData_v2(1);
    function loadMoreData_v2(page) {
        var str="";
        if($("#contractid").val().length>0){
            str+="contractid="+$("#contractid").val()+"&&";
        }
        if($("#create_date_of").val().length>0){
            str+="create_date_of="+$("#create_date_of").val()+"&&";
        }
        if($("#create_date_to").val().length>0){
            str+="create_date_to="+$("#create_date_to").val()+"&&";
        }
        if($("#estate_nationalId").val().length>0){
            str+="estate_nationalId="+$("#estate_nationalId").val()+"&&";
        }
        if($("#estate_name").val().length>0){
            str+="estate_name="+$("#estate_name").val()+"&&";
        }
        if($("#customer_nationalId").val().length>0){
            str+="customer_nationalId="+$("#customer_nationalId").val()+"&&";
        }
        if($("#customer_name").val().length>0){
            str+="customer_name="+$("#customer_name").val()+"&&";
        }
        if($("#customer_phone").val().length>0){
            str+="customer_phone="+$("#customer_phone").val()+"&&";
        }
        if($("#expert").val()){
            str+="expert="+$("#expert").val()+"&&";
        }
        if($("#estate_phone").val().length>0){
            str+="estate_phone="+$("#estate_phone").val()+"&&";
        }
        if($("#estate_type").val()){
            str+="estate_type="+$("#estate_type").val()+"&&";
        }
        if($("#type").val()){
            str+="type="+$("#type").val()+"&&";
        }
        if($("#estate_address").val().length>0){
            str+="estate_address="+$("#estate_address").val()+"&&";
        }
        if($('#reminder').is(":checked")){
            str+="reminder=1&&";
        }
        $('.page-loading').addClass('active');
        if (page == 1) {
            $("#estate-wrapper").empty();
        }
        $.ajax({
                url: `?page=${page}&${str}`,
                type: "get",
                beforeSend: function() {

                }
            }).done(function(data) {
                if (data.totalCount < 15)
                    hasPage = false;
                else
                    hasPage = data.hasPage;

                if (data.length == 0) {
                    return;
                }
                //$(".btnmore1").addClass('d-none').removeClass('d-block');
                var htmlpage = data.html;
                $("#estate-wrapper").html(htmlpage);
                if(data.totalCount>10){
                var result = Paging(pagin, 10, data.totalCount, "myClass", "myDisableClass");
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
                //alert('{{l('مشکلی در دریافت اطلاعات بوجود آمده است...')}}');
            });
    };
    $("#pagination").on("click", "a", function() {

        pagin = $(this).attr("pn");
        if(pagin>0){
        window.scrollTo(0, 250);
        loadMoreData_v2($(this).attr("pn"));
        }
    });
    function ContractEarn(id)
    {
        $.ajax({
            type: 'POST',
            url: '/profile/contractearn',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            data: {
                _method:'post',
                contract_id:id,
            },
            error: function (xhr, status, error) {
            },
            success: function (response) {
                if(response.count>0){ $('#estatecheck').modal('toggle') $("#estatecheck1").html(response.html); } } }); } $(document).ready(function() { $(".close").click(function(){ $('#estatecheck').modal('toggle') }) // show search $(".search-admin").on("click", function() { $(".form-search").toggleClass("hide-search"); }) // show detail $("a.detail").on("click", function() { var id = $(this).data('id'); location.href = "/profile/" + route + "/" + id; }); // edit $("a.edit").on("click", function() { var id = $(this).data('id'); location.href = "/admin/" + route + "/" + id + "/edit"; }); // archive item $("a.archive").on("click", function() { var id = $(this).data('id'); var archiveStatus = $(this).data('archive'); archiveStatus == 1 ? $('.modal-title').text('خروج از بایگانی') : $('.modal-title').text('بایگانی قرارداد') $("#frm-history").attr('action', '/admin/contracts/history/' + id + '/archive'); }); $('#modal-history').on('submit', function(e) { if ($('#modal-description').val().trim().length == 0) { $('#modal-description').focus(); $('#description-error').show(); return false; } return true; e.preventDefault(); }); $("#modal-history").on('show.bs.modal', function(e) { $('ul.timeline').empty(); var id = $(e.relatedTarget).data('id'); var code = $(e.relatedTarget).data('code'); var htmlContent = '<div>{{ l('کد قرارداد: \' + \'') }}<span class="text-aqua">' + code + '</span>&emsp;';
            $('#modal-history h4.modal-title').html(htmlContent);
            $('#loading').fadeIn(500);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '/admin/contracts/history/' + id,
                type: "GET",
                success: function(data) {
                    var res = data.data.result;
                    console.log(res);
                    var itemList = '';
                    if (res != null) {
                        //$.each(res, function (i) {
                        $.each(res, function(key, value) {
                            console.log(value);
                            itemList += '<li>' +
                                '<i class="bg-orange fa fa-user"></i>' +
                                '<div class="timeline-item">' +
                                '<span class="time"><i class="fa fa-clock-o"></i> ' +
                                '<span id="history-datetime">' + value.date + '</span>' +
                                '</span>' +
                                '<h3 class="timeline-header">' +
                                '<a href="#" id="history-user" class="iranYekanLight text-black">' + value.user + '</a> : ' +
                                '<span id="history-action" class="text-green">' + value.action + '</span>' +
                                '</h3>' +
                                '<div class="timeline-body" id="history-description">' + value.description + '</div>' +
                                '</div>' +
                                '</li>';
                        });
                        //});

                    }
                    $('ul.timeline').append(itemList)
                    $('#loading').hide();
                },
            });
        });

        // remove item




        $("a.remove").on("click", function() {
            var id = $(this).data('id');
            var name = $(this).data('name');

                        $.ajax({
                                url: '/admin/' + route + '/' + id,
                                type: 'POST',
                                data: {
                                    _token: CSRF_TOKEN,
                                    _method: 'DELETE'
                                },
                                dataType: 'json'
                            })
                            .done(function(response) {
                                swal({
                                    text: l('گزینه مورد نظر با موفقیت حذف شد.'),
                                    type: 'success',
                                    allowOutsideClick: false,
                                }).then((result) => { location.reload(); }); }) .fail(function() { swal('خطا!', 'حذف با مشکل مواجه شد!', 'error'); }); }); });
</script>
@endsection
