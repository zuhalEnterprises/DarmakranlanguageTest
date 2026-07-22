@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
'title' => l('مشتریان ').($typelist == 'my')? l('من'):l('آژانس'),
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
    @include(ss('THEME') . '.frontend.layouts.header_v2')

    <!-- Page content-->
    <div class="container mt-5 pt-3 p-0">
        <!-- Page content-->
        <div class="row">
            @include(ss('THEME') . '.frontend.layouts.sidebar', ['menu' => '3' , 'menutype'=>($typelist == 'my')?'agent':'branch'])
            <!-- Content-->
            <div class="col-lg-9 col-md-12 mb-5">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('مشتریان ').(($typelist == 'my')? l('من'):l('آژانس'))}}</li>
                    </ol>
                </nav>
                <div class="card shadow-sm">
                    <div class="card-header fw-bolder">{{l('مشتریان ').(($typelist == 'my')? l('من'):l('آژانس'))}}</div>
                    @if($typelist != 'my')
                    <form  id="mySearch">
                    <input type="hidden" name="order" id="order" value="label">
                    <input type="hidden" name="orderby" id="orderby" value="asc">
                    <div class=" card-body border-0  pb-1 me-lg-1">
                        @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch|expert') )
                        <input type="hidden" name="user_id" id="user_id" value="{{$currentUser->isAdmin()?"":$currentUser->id}}">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
                                @if ($Agent->isMobile())
                                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                                    <button type="button" onclick="seluserid('{{$currentUser->id}}')" class="buser buser{{$currentUser->id}} btn btn-outline-secondary {{!$currentUser->isAdmin()?"active":''}}">{{l('مشتری های خودم')}}</button>
                                    <button type="button" onclick="seluserid('-1')" class="buser buser-1 btn btn-outline-secondary" >{{l('بدون مشاور')}}</button>
                                    @if($currentUser->isAdmin())
                                    <button type="button " onclick="seluserid('')" class="buser buser0  btn btn-outline-secondary {{$currentUser->isAdmin()?"active":''}}">{{l('همه مشتری ها')}}</button>
                                    @endif
                                </div>
                                @if($currentUser->isAdmin())
                                <div class="btn-group  btn-group-lg mt-2" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group " role="group">
                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Agent List
                                        </button>
                                        <div class="dropdown-menu my-1">
                                            @foreach($users as $item)
                                            <a href="#" onclick="seluserid('{{$item->id}}')" class="buser buser{{$item->id}} dropdown-item {{(array_key_exists('expertid' , $_REQUEST) && $_REQUEST['expertid'] == $item->id) ? 'active' : ''}}">{{$item->fullname()}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @else

                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button type="button" onclick="seluserid('{{$currentUser->id}}')" class="buser buser{{$currentUser->id}} btn btn-outline-secondary {{!$currentUser->isAdmin()?"active":''}}">{{l('مشتری های خودم')}}</button>
                                    <button type="button" onclick="seluserid('-1')" class="buser buser-1 btn btn-outline-secondary" >{{l('بدون مشاور')}}</button>
                                    @if($currentUser->isAdmin())
                                    <button type="button" onclick="seluserid('')" class="buser buser0  btn btn-outline-secondary {{$currentUser->isAdmin()?"active":''}}">{{l('همه مشتری ها')}}</button>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Agent List
                                        </button>
                                        <div class="dropdown-menu my-1">
                                            @foreach($users as $item)
                                            <a href="#" onclick="seluserid('{{$item->id}}')" class="buser buser{{$item->id}} dropdown-item {{(array_key_exists('expertid' , $_REQUEST) && $_REQUEST['expertid'] == $item->id) ? 'active' : ''}}">{{$item->fullname()}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endif

                            </div>
                        </div>
                        @endif


                        <div class="row">
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                                <label class="form-label">{{l('درخواست')}}</label>
                                <select name="request_type" id="request_type" class="form-select">
                                    <option value="1">{{l('خرید')}}</option>
                                    <option value="2">{{l('اجاره')}}</option>
                                </select>

                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-12 mt-3 usage_type1">
                                <label class="form-label" for="usage_type">{{l('نوع کاربری')}}</label>
                                <select name="usage_type" id="usage_type" class="form-select">
                                    <option value="">{{l('انتخاب نمایید')}}</option>
                                    @foreach (usage_type() as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                                <label class="form-label">{{l('وضعیت مشتری')}}</label>
                                <select id="status" name="status" class="form-control " style="width: 100%;" >
                                    <option value="1">{{l('جاری')}}</option>
                                    <option value="4">{{l('آرشیو')}}</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-12 mt-3">
                                <label class="form-label" for="grade">{{l('نوع مشتری')}}</label>
                                <select class="form-control" name="grade" id="grade">
                                    <option value=""></option>
                                    @foreach (CustomerGrade() as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                                <label class="form-label">{{l('نوع ملک')}}</label>
                                <select class="form-control select2" id="estate_type" name="estate_type">
                                    <option value="" disabled hidden></option>
                                    @foreach (estateTypes() as $id=>$name)
                                    <option value="{{ $id }}" @php @endphp>
                                        {{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch|expert') )
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                                <label class="form-label">{{l('کد مشتری')}}</label>
                                <input type="text" class="form-control" id="id" name="id" />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                                <label class="form-label">{{l('نام و نام خانوادگی')}}</label>
                                <input type="text" class="form-control" id="name" name="name" />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                                <label class="form-label">{{l('شماره همراه')}}</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" />
                            </div>

                            @endif
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                                <label class="form-label">{{l('حداقل مساحت')}}</label>
                                <input type="text" class="form-control" id="area_min" name="area_min" />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                                <label class="form-label">{{l('حداکثر مساحت')}}</label>
                                <input type="text" class="form-control" id="area_max" name="area_max" />
                            </div>
                            <div class=" col-6 col-md-6 col-lg-2 col-sm-6 mt-3 sale">
                                <label class="form-label">{{l('حداقل مبلغ خرید')}}</label>
                                <input type="text" class="form-control" id="price_min" name="price_min" />
                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3 sale">
                                <label class="form-label">{{l('حداکثر مبلغ خرید')}}</label>
                                <input type="text" class="form-control" id="price_max" name="price_max" />
                            </div>

                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3 rent" style="display:none">
                                <label class="form-label">{{l('رهن از')}}</label>
                                <input type="text" id="minrahn" onkeyup="SplitNumber($(this));"  name="minrahn" class="form-control">
                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3 rent" style="display:none">
                                <label class="form-label">{{l('رهن تا')}}</label>
                                <input type="text" id="maxrahn" onkeyup="SplitNumber($(this));" name="maxrahn" class="form-control">
                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3 rent" style="display:none">
                                <label class="form-label">{{l('اجاره از')}}</label>
                                <input type="text" id="minrent" name="minrent" onkeyup="SplitNumber($(this));" class="form-control">
                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3 rent" style="display:none">
                                <label class="form-label">{{l('اجاره تا')}}</label>
                                <input type="text" id="maxrent" name="maxrent" onkeyup="SplitNumber($(this));" class="form-control">
                            </div>

                            <div class="col-6 col-md-6 col-lg-3 col-sm-12 mt-3">
                                <label for="ap-city" class="form-label">
                                    {{l('شهر')}}
                                </label>
                                <select class="form-select select2" name="city_id" id="city_id">
                                    <option value=""> {{l('انتخاب شهر')}}</option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6 col-lg-9 col-sm-12 mt-3 district">
                                <label class="form-label">{{l('محله های درخواست')}}</label>
                                <select class="form-control select2" id="districts" multiple name="district_id[]">
                                    <option value="" disabled hidden></option>
                                    @foreach ($districts as $id => $name)
                                    <option value="{{ $id }}" @php @endphp>
                                        {{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <style>
                                .district .select2-container--default .select2-selection--multiple
                                {
                                    display:table;
                                    width:100%
                                }
                            </style>



                            <div class="col-md-6 col-lg-2 d-none col-sm-12 mt-3 rent" >
                                <label class="form-label ">{{l('تعداد نمایش')}}</label>
                                <select class="form-control" id="showcount" style="width:100%">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50" selected>50</option>
                                    <option value="100">100</option>
                                    <option value="150">150</option>
                                </select>
                            </div>
                        </div>
                        <div class="accordion my-4" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed bg-faded-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        {{l('جستجوی پیشرفته')}}
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse border-top" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">

                                            <div class="col-6 col-md-6 col-lg-2 col-sm-12 mt-3 ">
                                                <label class="form-label" for="max_room_count">{{l('حداقل تعداد خواب')}}</label>
                                                <select class="form-control" name="max_room_count" id="max_room_count">
                                                    <option value="">{{l('انتخاب کنید')}}</option>
                                                    <option value="1" >1</option>
                                                    <option value="2" >2</option>
                                                    <option value="3" >3</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 col-lg-2 col-sm-12 mt-3 ">
                                                <label class="form-label" for="max_building_age">{{l('حداکثر عمر بنا')}}</label>
                                                <select class="form-control" name="max_building_age" id="max_building_age">
                                                    <option value="">{{l('انتخاب کنید')}}</option>
                                                    <option value="1" >{{l('حداکثر 1 سال')}}</option>
                                                    <option value="2" >{{l('حداکثر 2 سال')}}</option>
                                                    <option value="3" >{{l('حداکثر 5 سال')}}</option>
                                                    <option value="4" >{{l('حداکثر 10 سال')}}</option>
                                                    <option value="5" >{{l('حداکثر 20 سال')}}</option>
                                                    <option value="6" >{{l('حداکثر 30 سال')}}</option>
                                                    <option value="7" >{{l('بیش از 30 سال')}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-lg-2 col-sm-12 mt-3 d-none min_floor_area1">
                                                <label class="form-label" for="min_floor_area">{{l('حداقل مساحت زمین')}}</label>
                                                <input class="form-control" type="number"  id="min_floor_area" name="min_floor_area" >
                                            </div>
                                            <div class="col-md-6 col-lg-2 col-sm-6 mt-3 ">
                                                <label class="form-label">{{l('تاریخ ایجاد از')}}</label>
                                                <input name="create_date_of" id="create_date_of" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ ایجاد از')}}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                                            </div>
                                            <div class="col-md-6 col-lg-2 col-sm-6 mt-3">
                                                <label class="form-label">{{l('تاریخ ایجاد تا')}}</label>
                                                <input name="create_date_to" id="create_date_to" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ ایجاد تا')}}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                                            </div>
                                            <div class="col-md-6 col-lg-2 col-sm-12 mt-5 d-none ">
                                                <label class="form-label" for="max_building_age">{{l('پیش فروش')}}</label>
                                                <input class="form-check-input" id="js_pish" value="15" type="checkbox" name="conditions[]">
                                            </div>
                                            <div class="col-md-6 col-lg-2 col-sm-12 mt-5 form-check form-switch">
                                                <label class="form-label" for="conditions304">
                                                    {{l('کلید نخورده')}}
                                                </label>
                                                <input class="form-check-input" id="js_key" value="304" type="checkbox" name="conditions[]">
                                            </div>
                                            <div class="col-md-6 col-lg-2 col-sm-12 mt-5 form-check form-switch">
                                                <label class="form-label" for="conditions348">
                                                    {{l('فول امکانات')}}
                                                </label>
                                                <input class="form-check-input" id="js_FacitiiesFull"  value="348" type="checkbox" name="conditions[]">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <button id="form_search" class="btn btn-primary w-auto w-lg-25">
                            {{l('جستجو')}}
                        </button>
                    </div>
                    </form>
                    @endif
                </div>
                <div class="mt-4">
                    <a name="content"></a>
                    <div class="  my-4 rounded" id="estate-wrapper">
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
                        $(this).find("select").select2();
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
        //alert($('#estate_type').val());
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
    $(".select2").select2();
    var pagin = 1;
    var str = "";
    var pageload = 0;
    CheckSend();
    $("#form_search").click(function() {
        str = "";
        CheckSend();
    });
    function seluserid(id)
    {

        $('#user_id').val(id);
        $('.buser').removeClass('active');
        if(id == '')
        {
            $('.buser0').addClass('active');
        }
        else
        {
            $('.buser'+id).addClass('active');
        }
        str = "";
        CheckSend();
    }
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
            str += "area_min=" + $("#area_min").val() + "&&";
        }
        if ($("#area_max").val() != undefined && $("#area_max").val().length > 0)
            str += "area_max=" + $("#area_max").val() + "&&";
        if ($("#mobile").val() != undefined && $("#mobile").val().length > 0)
            str += "mobile=" + $("#mobile").val() + "&&";
        if ($("#price_min").val() != undefined && $("#price_min").val().length > 0)
            str += "price_min=" + $("#price_min").val() + "&&";
        if ($("#price_max").val() != undefined && $("#price_max").val().length > 0)
            str += "price_max=" + $("#price_max").val() + "&&";
        if ($("#minrahn").val() != undefined && $("#minrahn").val().length > 0)
            str += "mortgage_min=" + $("#minrahn").val() + "&&";
        if ($("#maxrahn").val() != undefined && $("#maxrahn").val().length > 0)
            str += "mortgage_min=" + $("#maxrahn").val() + "&&";
        if ($("#minrent").val() != undefined && $("#minrent").val().length > 0)
            str += "rent_min=" + $("#minrent").val() + "&&";
        if ($("#maxrent").val() != undefined && $("#maxrent").val().length > 0)
            str += "rent_max=" + $("#maxrent").val() + "&&";

        if ($("#districts").val() != undefined && $("#districts").val().length > 0)
            str += "districts=" + $("#districts").val() + "&&";
        if ($("#name").val() != undefined && $("#status").val().length > 0)
            str += "status=" + $("#status").val() + "&&";
        /*if($("#user_id1").val().length>0)
        str+="user_id1="+$("#user_id1").val()+"&&";*/
        if ($("#residence_type").val() != undefined && $("#residence_type").val().length > 0)
            str += "residence_type=" + $("#residence_type").val() + "&&";
        if ($("#education").val() != undefined && $("#education").val().length > 0)
            str += "education=" + $("#education").val() + "&&";
        if ($("#purchase_reason").val() != undefined && $("#purchase_reason").val().length > 0)
            str += "purchase_reason=" + $("#purchase_reason").val() + "&&";
        if ($("#purchase_priority").val() != undefined && $("#purchase_priority").val().length > 0)
            str += "purchase_priority=" + $("#purchase_priority").val() + "&&";
        if ($("#financial_liquidity_type").val() != undefined && $("#financial_liquidity_type").val().length > 0)
            str += "financial_liquidity_type=" + $("#financial_liquidity_type").val() + "&&";
        if ($("#estate_type").val() != undefined && $("#estate_type").val().length > 0)
            str += "estate_type=" + $('#estate_type').val() + "&&";
        str += conditioncheckbox();
        if ($("#label").val() != undefined && $("#label").val().length > 0)
            str += "label=" + $("#label").val() + "&&";
        if ($("#grade").val() != undefined && $("#grade").val().length > 0)
            str += "grade=" + $("#grade").val() + "&&";
        if ($("#country").val() != undefined && $("#country").val().length > 0)
            str += "country=" + $("#country").val() + "&&";
        if ($("#language").val() != undefined && $("#language").val().length > 0)
            str += "language=" + $("#language").val() + "&&";
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
        if($("input[name='request_type']:checked").val() != undefined)
        {
            str += "request_type=" + $("input[name='request_type']:checked").val() + "&&";
        }
        if ($("#order").val() != undefined)
            str+= "order="+$("#order").val()+"&";
        if ($("#orderby").val() != undefined)
            str+= "orderby="+$("#orderby").val()+"&";
        if ($("#showcount").val() != undefined)
            str+= "showcount="+$("#showcount").val()+"&";
        else
        str+= "showcount=20&";
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
<script>
    $(document).ready(function(){
        $(".max_room_count1").removeClass('d-none');
        $(".max_building_age1").removeClass('d-none');
        $(".conditions151").removeClass('d-none');
        $("#estate_type").change(function(){
            $(".max_building_age1").addClass('d-none');
            $(".conditions151").addClass('d-none');

            $(".min_floor_area1").addClass('d-none');
            $(".max_room_count1").addClass('d-none');
            if($(this).val()==1 || $(this).val()==2){
            $(".max_room_count1").removeClass('d-none');
            }

            if($(this).val()==1){
                $(".max_building_age1").removeClass('d-none');
                $(".conditions151").removeClass('d-none');

            }
            if($(this).val()==2){
                $(".min_floor_area1").removeClass('d-none');
            }

        });

    });
</script>
@endsection
