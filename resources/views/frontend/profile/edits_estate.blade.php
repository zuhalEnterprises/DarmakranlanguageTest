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
                @include('frontend.layouts.sidebar', ['menu' => '16'])
                <!-- Content-->
                <div class="col-lg-9 col-md-12 mb-5">
                    <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ l('ویرایش های املاک') }}</li>
                    </ol>
                </nav>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h1 class="h2 mb-0">
                            {{ l('ویرایش های املاک') }}
                        </h1>
                    </div>
                    <div class="card shadow-sm rounded mb-4">
                        <form  id="mySearch">
                        <div class=" card-body border-0  pb-1 me-lg-1">
                            <input type="hidden" name="order" id="order" value="id">
                            <input type="hidden" name="orderby" id="orderby" value="desc">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('کدملک') }}</label>
                                    <input type="text" class="form-control" id="estate_id" name="estate_id" value="<?php echo !empty($_REQUEST["estate_id"])?$_REQUEST["estate_id"]:"" ?>" />
                                </div>
                                @if($currentUser->isAdmin())
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('مشاور') }}</label>
                                    <select class="form-control select2" name="user_id" id="user_id" style="width:100%">
                                        <option value="" {{$currentUser->isAdmin()?'selected':''}}>{{l('همه مشاورین')}}</option>
                                        @foreach($users as $item)
                                            <option value="{{$item->id}}" {{ (app('request')->input('user_id') == $item->id)?"selected":"" }}>{{$item->fullname()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('نوع تغییر') }}</label>
                                    <select class="form-control select2" name="type" id="type" style="width:100%">
                                        <option value="" {{$currentUser->isAdmin()?'selected':''}}>{{ l('همه تغییرات') }}</option>
                                        @foreach($typeName as $key=>$val)
                                            <option value="{{$key}}" @php if(!empty($_REQUEST["type"]) && $_REQUEST['type'] == $key) echo 'selected'; @endphp {{ (app('request')->input('type') == $key)?"selected":"" }}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if (env('COUNTRY') == 'UAE')
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold"> {{l('تاریخ از')}}</label>
                                    <input name="datefrom" id="datefrom" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ از')}}" value="{{ app('request')->input('datefrom') }}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                                </div>
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold"> {{l('تاریخ تا')}}</label>
                                    <input name="dateto" id="dateto" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ تا')}}" value="{{ app('request')->input('dateto') }}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                                </div>
                                @else
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold"> {{l('تاریخ از')}}</label>
                                    <input type="text" name="datefrom" id="datefrom" class="form-control" readonly value="{{ app('request')->input('datefrom') }}" style="cursor: pointer" />
                                </div>
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold"> {{l('تاریخ تا')}}</label>
                                    <input type="text" name="dateto" id="dateto" class="form-control" readonly value="{{ app('request')->input('dateto') }}" style="cursor: pointer" />
                                </div>
                                @endif
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
<script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>
<script src="/frontend/js/paging.js"></script>
<link rel="stylesheet" href="/admin2/dist/css/persian-datepicker-0.4.5.min.css" />
<!-- custom css -->
<link href="/admin/css/date_picker/kamadatepicker.css" rel="stylesheet">
<script src="/admin/js/date_picker/kamadatepicker.js"></script>
<script>
    $(document).ready(function(){
        $('#mySearch').on('submit', function(e){
            e.preventDefault();
            return false;
        });
    });
    var customOptions = {
        placeholder: "{{l('روز / ماه / سال')}}"
        , twodigit: false
        , closeAfterSelect: true
        , nextButtonIcon: "fa fa-angle-right"
        , previousButtonIcon: "fa fa-angle-left"
        , buttonsColor: "#37b5b5"
        , forceFarsiDigits: true
        , markToday: true
        , markHolidays: true
        , highlightSelectedDay: true
        , sync: true
        , gotoToday: true
    };
    kamaDatepicker('datefrom', customOptions);
    kamaDatepicker('dateto', customOptions);
    function CheckSend()
    {
        var sr = "";
        sr += ($('#estate_id').val() != '') ? "estate_id=" + $('#estate_id').val() + "&" : "";
        sr+=(typeof $('#user_id').val()!=='undefined' && $('#user_id').val()>0)?"user_id="+$("#user_id").val()+"&":"";
        sr+=($('#type').val() != '')?"type="+$("#type").val()+"&":"";
        sr+=(typeof $('#datefrom').val()!=='undefined' )?"datefrom="+$("#datefrom").val()+"&":"";
        sr+=(typeof $('#dateto').val()!=='undefined' )?"dateto="+$("#dateto").val()+"&":"";
        sr+= "order="+$("#order").val()+"&";
        sr+= "orderby="+$("#orderby").val()+"&";
        loadMoreData(1,sr)
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
        $("#order").val(type);
        CheckSend();
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
                url: "/profile/editsEstateShow?page="+page+"&&"+type,
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

</script>
@endsection
