@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => l('لیست خریداران'),
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
                        <li class="breadcrumb-item active" aria-current="page"> {{l('خریدار من')}}</li>
                    </ol>
                </nav>
                <div class="card shadow-sm rounded">
                    <div class="card-header fw-bolder">{{l('جستجوی خریداران')}}</div>
                    <form  id="mySearch">
                    <input type="hidden" name="order" id="order" value="label">
                    <input type="hidden" name="orderby" id="orderby" value="asc">
                    <div class=" card-body border-0  pb-1 me-lg-1">
                        <div class="row">
                            <div class="col-12 col-lg-3 mt-3">
                                <label class="fw-bold">{{l('درخواست')}}</label>&nbsp;&nbsp;&nbsp;
                                <label class="form-label" >{{l('خرید')}}</label>
                                <input class="form-check-input" id="conditions15" checked value="1" type="radio" name="request_type">
                                &nbsp;&nbsp;
                                <label class="form-label" >{{l('اجاره')}}</label>
                                <input class="form-check-input" id="conditions15" value="2" type="radio" name="request_type">
                            </div>
                            @if($currentUser->isReferrer())
                            <div class="col-md-12 col-lg-3 col-sm-6 mt-3">
                                    <label class="fw-bold">{{l('وضعیت مشتری')}}</label>
                                    <select id="status" name="status" class="form-control " style="width: 100%;" >

                                        @foreach (CustomerStatus() as  $key=>$val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                            </div>


                            <div class="col-12 col-lg-6  col-sm-6 mt-3">
                                <label class="fw-bold">{{l('نوع ملک')}}</label>
                                <select class="form-control select2" id="estate_type" multiple name="estate_type[]">
                                    <option value="" disabled hidden></option>
                                    @foreach (estateTypes() as $id=>$name)
                                    <option value="{{ $id }}" @php @endphp>
                                        {{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if($currentUser->isReferrer())
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('کد مشتری')}}</label>
                                <input type="text" class="form-control" id="id" name="id" />
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('نام و نام خانوادگی')}}</label>
                                <input type="text" class="form-control" id="name" name="name" />
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('شماره همراه')}}</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" />
                            </div>
                            @if($currentUser->isExpert())
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('مشاور')}}</label>
                                <select class="form-control select2" name="user_id" id="user_id" style="width:100%">
                                    <option value="{{$currentUser->id}}">{{l('مشتری های خودم')}}</option>
                                    @if(env('PORTAL') && isset($branches))
                                    @foreach($branches as $branch)
                                    <option value="{{(int)$branch->id * -1}}" >{{$branch->name}}</option>
                                    @endforeach
                                    @endif

                                    <option value="-1">{{l('بدون مشاور')}}</option>

                                    <option value=""  {{$currentUser->isAdmin()?'selected':''}}>{{l('همه مشتری ها')}}</option>
                                    @foreach($users as $item)
                                    <option value="{{$item->id}}" {{(array_key_exists('expertid' , $_REQUEST) && $_REQUEST['expertid'] == $item->id) ? 'selected' : ''}} {{ (app('request')->input('user_id') == $item->id)?"selected":"" }}>{{$item->fullname()}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            @endif


                            <div class="col-md-3 col-lg-3 col-sm-6 mt-3 sale">
                                <label class="fw-bold">{{l('حداقل مبلغ خرید')}}</label>
                                <input type="text" class="form-control" id="price_min" name="price_min" />
                            </div>
                            @if(ss('SITE_ID') != 10 && ss('SITE_ID') != 11)
                            <div class="col-md-3 col-lg-3 col-sm-6 mt-3 sale">
                                <label class="fw-bold">{{l('حداکثر مبلغ خرید')}}</label>
                                <input type="text" class="form-control" id="price_max" name="price_max" />
                            </div>

                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3 rent" style="display:none">
                                <label class="fw-bold">{{l('رهن از')}}</label>
                                <input type="text" id="minrahn" onkeyup="SplitNumber($(this));"  name="minrahn" class="form-control">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3 rent" style="display:none">
                                <label class="fw-bold">{{l('رهن تا')}}</label>
                                <input type="text" id="maxrahn" onkeyup="SplitNumber($(this));" name="maxrahn" class="form-control">
                            </div>
                            @endif
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3 rent" style="display:none">
                                <label class="fw-bold">{{l('اجاره از')}}</label>
                                <input type="text" id="minrent" name="minrent" onkeyup="SplitNumber($(this));" class="form-control">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3 rent" style="display:none">
                                <label class="fw-bold">{{l('اجاره تا')}}</label>
                                <input type="text" id="maxrent" name="maxrent" onkeyup="SplitNumber($(this));" class="form-control">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('حداقل مساحت')}}</label>
                                <input type="text" class="form-control" id="area_min" name="area_min" />
                            </div>
                            @if(ss('SITE_ID') != 10 && ss('SITE_ID') != 11)
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('حداکثر مساحت')}}</label>
                                <input type="text" class="form-control" id="area_max" name="area_max" />
                            </div>
                            @endif
                            <div class="col-md-6 col-lg-6 col-sm-6 mt-3">
                                <label class="fw-bold" for="ap-city">
                                    {{l('شهر')}}
                                </label>
                                <select class="form-select select2" name="city_id" id="city_id">
                                    <option value=""> {{l('شهر')}}</option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if(ss('SITE_ID') == 3)
                            <script>
                                $('#city_id').val(1);
                            </script>
                            @endif
                            @if(ss('SITE_ID') != 10 && ss('SITE_ID') != 11)
                            <div class="col-md-6 col-lg-6 col-sm-12 mt-3 district">
                                <label class="fw-bold">{{l('محله های درخواست')}}</label>
                                <select class="form-control select2" id="districts" multiple name="district_id[]">
                                    <option value="" disabled hidden></option>
                                    @foreach ($districts as $id => $name)
                                    <option value="{{ $id }}" @php @endphp>
                                        {{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <style>
                                .district .select2-container--default .select2-selection--multiple
                                {
                                    display:table;
                                    width:100%
                                }
                            </style>
                            @include(ss('THEME').'.frontend.customer.index')
                            @if($currentUser->isExpert() && ss('SITE_ID') == 3)
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{ l('وضعیت نقدینگی') }}</label>
                                <select id="financial_liquidity_type" name="financial_liquidity_type" class="form-control select2 " style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option value="" selected>{{ l('انتخاب کنید') }}</option>
                                    <option value="1">{{ l('کاملا نقد') }}</option>
                                    <option value="2">{{ l('بخشی نقد') }}</option>
                                    <option value="3">{{ l('غیر نقد') }}</option>
                                </select>
                            </div>
                            @endif
                            @if (env('COUNTRY') == 'UAE')
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3 ">
                                <label class="fw-bold">{{l('تاریخ ایجاد از')}}</label>
                                <input name="create_date_of" id="create_date_of" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ ایجاد از')}}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('تاریخ ایجاد تا')}}</label>
                                <input name="create_date_to" id="create_date_to" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ ایجاد تا')}}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                            </div>
                            @else
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('تاریخ ایجاد از')}}</label>
                                <input type="text" name="create_date_of" id="create_date_of" onclick="Mh1PersianDatePicker.Show(this,'{{$dateto}}')" class="form-control text-muted pull-right" value="{{ app('request')->input('datefrom') }}">
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="fw-bold">{{l('تاریخ ایجاد تا')}} </label>
                                <input type="text" name="create_date_to" id="create_date_to" onclick="Mh1PersianDatePicker.Show(this,'{{$dateto}}')" class="form-control text-muted pull-right" value="{{ app('request')->input('dateto') }}">
                            </div>
                            @endif
                            @endif
                            <div class="col-md-6 col-lg-3 col-sm-6 mt-3 rent" >
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
                    <div class="@if(ss('SITE_ID') == 10 && 0) overflow-auto  @endif my-4 rounded" id="estate-wrapper">
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
    $(".select2").select2({
        closeOnSelect: false
    });
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
    function changeaccess(){
        $(".not").hide();
        $(".not").each(function(){
            var splaccess= $(this).attr('access').toString().split(",");
            for(var i=0;i<splaccess.length;i++){
                var dealtype=splaccess[i].substring(0,1);
                var estatetype=splaccess[i].substring(1,2);
                if( $('input[name="request_type"]').val()==dealtype){
                    var checkedVals = $('.theClass:checkbox:checked').map(function() {
                        return this.value;
                    }).get();
                    var spl=checkedVals.toString().split(',');
                    for(i=0;i<spl.length;i++){
                    if(spl[i]==estatetype){
                        //alert($(".theClass").val());
                        $(this).show();
                        $(this).find("select").select2({
                            closeOnSelect: false
                        });
                    }
                }
                }
            }
        });
    }
    $('input[name="request_type"]').change(function(){
        changeaccess();
        if($(this).val()==1)
            {
                $(".sale").show();
                $(".rent").hide();
            }
            else if($(this).val()==2)
            {
                $(".rent").show();
                $(".sale").hide();
            }
    });
    $(".theClass").change(function(){
        changeaccess();
    });
    function estatechange() {
        changeaccess();
        alert($('#estate_type1').val());
        var str = '';
        if ($('#estate_type1').is(":checked")) str += ',1';
        if ($('#estate_type2').is(":checked")) str += ',2';
        if ($('#estate_type3').is(":checked")) str += ',3';
        if ($('#estate_type4').is(":checked")) str += ',4';
        if ($('#estate_type5').is(":checked")) str += ',5';
        if ($('#estate_type6').is(":checked")) str += ',6';
        if ($('#estate_type7').is(":checked")) str += ',7';
        if ($('#estate_type8').is(":checked")) str += ',8';
        if ($('#estate_type9').is(":checked")) str += ',9';
        if ($('#estate_type10').is(":checked")) str += ',10';
        if ($('#estate_type11').is(":checked")) str += ',11';
        if ($('#estate_type12').is(":checked")) str += ',12';
        if ($('#estate_type13').is(":checked")) str += ',13';
        if ($('#estate_type14').is(":checked")) str += ',14';
        if ($('#estate_type15').is(":checked")) str += ',15';
        str = str.substring(1);
        if (str.length > 0)
            str = "estate_type=" + str + "&&";
        return str;
        //$(".estatetype1").html(list);
    }

    function conditioncheckbox() {
        var str = '';
        if ($('#js_pish').is(":checked")) str += ',15';
        if ($('#js_key').is(":checked")) str += ',304';
        if ($('#js_FacitiiesFull').is(":checked")) str += ',348';
        str = str.substring(1);
        if (str.length > 0)
            str = "conditions=" + str + "&&";
        return str;
        //$(".estatetype1").html(list);
    }
    $(".search").click(function() {
        $("#search").toggle();
    });
    $(".select2").select2({
        closeOnSelect: false
    });
    var pagin = 1;
    var str = "";
    var pageload = 0;
    CheckSend();
    $("#form_search").click(function() {
        str = "";
        CheckSend();
    });
    function sort(type)
    {
        if($("#orderby").val() == "desc"){
            $("#orderby").val("asc");
        }
        else
        {
            $("#orderby").val("desc");
        }
        if($("#order").val() == "price1")
        {
            if($("#request_type").is(':checked')){
                $("#order").val('price');
            }
            else
            {
                $("#order").val('mortgage');
            }
        }
        else if($("#order").val() == "price2")
        {
            if($("#request_type").is(':checked')){
                $("#order").val('price_per_meter');
            }
            else
            {
                $("#order").val('rent');
            }
        }
        else
        {
            $("#order").val(type);
        }
        CheckSend();
    }
    function CheckSend() {

        var array = [];
        if ($("#id").val() != undefined && $("#id").val().length > 0)
            str += "id=" + $("#id").val() + "&&";
        if ($("#name").val() != undefined && $("#name").val().length > 0)
            str += "name=" + $("#name").val() + "&&";
        if ($("#area_min").val() != undefined && $("#area_min").val().length > 0) {
            str += "area_min=" + $("#area_min").val() + "&&";;
        }
        if ($("#area_max").val() != undefined && $("#area_max").val().length > 0)
            str += "area_max=" + $("#area_max").val() + "&&";;
        if ($("#mobile").val() != undefined && $("#mobile").val().length > 0)
            str += "mobile=" + $("#mobile").val() + "&&";;
        if ($("#price_min").val() != undefined && $("#price_min").val().length > 0)
            str += "price_min=" + $("#price_min").val() + "&&";;
        if ($("#price_max").val() != undefined && $("#price_max").val().length > 0)
            str += "price_max=" + $("#price_max").val() + "&&";
        if ($("#minrahn").val() != undefined && $("#minrahn").val().length > 0)
            str += "mortgage_min=" + $("#minrahn").val() + "&&";;
        if ($("#maxrahn").val() != undefined && $("#maxrahn").val().length > 0)
            str += "mortgage_max=" + $("#maxrahn").val() + "&&";
        if ($("#minrent").val() != undefined && $("#minrent").val().length > 0)
            str += "rent_min=" + $("#minrent").val() + "&&";;
        if ($("#maxrent").val() != undefined && $("#maxrent").val().length > 0)
            str += "rent_max=" + $("#maxrent").val() + "&&";

        if ($("#districts").val() != undefined && $("#districts").val().length > 0)
            str += "districts=" + $("#districts").val() + "&&";;
        if ($("#name").val() != undefined && $("#status").val().length > 0)
            str += "status=" + $("#status").val() + "&&";;
        /*if($("#user_id1").val().length>0)
        str+="user_id1="+$("#user_id1").val()+"&&";;*/
        if ($("#residence_type").val() != undefined && $("#residence_type").val().length > 0)
            str += "residence_type=" + $("#residence_type").val() + "&&";;
        if ($("#education").val() != undefined && $("#education").val().length > 0)
            str += "education=" + $("#education").val() + "&&";
        if ($("#purchase_reason").val() != undefined && $("#purchase_reason").val().length > 0)
            str += "purchase_reason=" + $("#purchase_reason").val() + "&&";;
        if ($("#purchase_priority").val() != undefined && $("#purchase_priority").val().length > 0)
            str += "purchase_priority=" + $("#purchase_priority").val() + "&&";;
        if ($("#financial_liquidity_type").val() != undefined && $("#financial_liquidity_type").val().length > 0)
            str += "financial_liquidity_type=" + $("#financial_liquidity_type").val() + "&&";
        //str += estatechange();
        if ($("#estate_type").val() != undefined && $("#estate_type").val().length > 0)
            str += "estate_type=" + $('#estate_type').val() + "&&";
        str += conditioncheckbox();
        if ($("#label").val() != undefined && $("#label").val().length > 0)
            str += "label=" + $("#label").val() + "&&";
        if ($("#acquaintance_type").val() != undefined && $("#acquaintance_type").val().length > 0)
            str += "acquaintance_type=" + $("#acquaintance_type").val() + "&&";
        if ($("#max_room_count").val() != undefined && $("#max_room_count").val().length > 0)
            str += "max_room_count=" + $("#max_room_count").val() + "&&";
        if ($("#max_unit_in_floor").val() != undefined && $("#max_unit_in_floor").val().length > 0)
            str += "max_unit_in_floor=" + $("#max_unit_in_floor").val() + "&&";
        if ($("#max_building_age").val() != undefined && $("#max_building_age").val().length > 0)
            str += "max_building_age=" + $("#max_building_age").val() + "&&";
        if ($("#usage_type").val() != undefined && $("#usage_type").val().length > 0)
            str += "usage_type=" + $("#usage_type").val() + "&&";
        if ($("#floor_count").val() != undefined && $("#floor_count").val().length > 0)
            str += "floor_count=" + $("#floor_count").val() + "&&";
        if ($("#min_floor_count").val() != undefined && $("#min_floor_count").val().length > 0)
            str += "min_floor_count=" + $("#min_floor_count").val() + "&&";
        if ($("#floor_start").val() != undefined && $("#floor_start").val().length > 0)
            str += "floor_start=" + $("#floor_start").val() + "&&";
        if ($("#min_floor_area").val() != undefined && $("#min_floor_area").val().length > 0)
            str += "min_floor_area=" + $("#min_floor_area").val() + "&&";
        if ($("#min_front_area").val() != undefined && $("#min_front_area").val().length > 0)
            str += "min_front_area=" + $("#min_front_area").val() + "&&";
        if ($("#min_density").val() != undefined && $("#min_density").val().length > 0)
            str += "min_density=" + $("#min_density").val() + "&&";
        if ($("#min_street_width").val() != undefined && $("#min_street_width").val().length > 0)
            str += "min_street_width=" + $("#min_street_width").val() + "&&";
        if ($("#build_license").val() != undefined && $("#build_license").val().length > 0)
            str += "build_license=" + $("#build_license").val() + "&&";
        if ($("#geography").val() != undefined && $("#geography").val().length > 0)
            str += "geography=" + $("#geography").val() + "&&";
        if ($("#user_id").val() != undefined && $("#user_id").val().length != 0)
            str += "user_id=" + $("#user_id").val() + "&&";
        if ($("#referrer_id").val() != undefined && $("#referrer_id").val().length != 0)
            str += "referrer_id=" + $("#referrer_id").val() + "&&";

        if($("input[name='request_type']:checked").val() != undefined)
        {
            str += "request_type=" + $("input[name='request_type']:checked").val() + "&&";
        }

        if ($("#today").val() != undefined && $("#today").is(":checked"))
            str += "today=1&&";
        str+= "order="+$("#order").val()+"&";
        str+= "orderby="+$("#orderby").val()+"&";
        str+= "showcount="+$("#showcount").val()+"&";
        str+= (typeof $('#create_date_of').val()!=='undefined' && $('#create_date_of').val() != '') ? "create_date_of=" + $('#create_date_of').val() + "&" : "";
        str+= (typeof $('#create_date_to').val()!=='undefined' && $('#create_date_to').val() != '') ? "create_date_to=" + $('#create_date_to').val() + "&" : "";
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
                //alert('{{l('مشکلی در دریافت اطلاعات بوجود آمده است...')}}');
            });
    };
    $("#pagination").on("click", "a", function() {

        pagin = $(this).attr("pn");
        if(pagin>0){
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
