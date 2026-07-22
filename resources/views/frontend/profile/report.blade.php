@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
    'title' => l('آمار مشاورین'),
])

@section('main_content')
    <!-- main -->
    <style>
    .table-p {
        height: 500px;
        overflow: auto;
    }
    thead tr:nth-child(1) th{
        position: sticky;
        top: 0;
        z-index: 10;
    }
    </style>
    <main class="page-wrapper">
        @include(ss('THEME') . '.frontend.layouts.header_v2', ['isadmin' => true])
        <!-- Page content-->
        <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
            <!-- Page content-->
            <div class="row">
                @include('frontend.layouts.sidebar', ['menu' => '11'])
                <!-- Content-->
                <div class="col-lg-9 col-md-12 mb-5">
                    <!-- Breadcrumb-->
                    <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> {{l('مدیریت عملکرد مشاور')}}</li>
                            <li class="breadcrumb-item active" aria-current="page"> {{l('گزارش مشاورین')}}</li>
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h1 class="h2 mb-0">
                            {{l('گزارش مشاورین')}}
                        </h1>
                    </div>
                    <div class="card shadow-sm rounded mb-4">
                        <form  id="mySearch">
                        <div class=" card-body border-0  pb-1 me-lg-1">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 mt-2">
                                    <input type="hidden" name="confirmation" id="confirmation">
                                    <input type="hidden" name="order" id="order" value="updated_at">
                                    <input type="hidden" name="orderby" id="orderby" value="desc">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-lg-3 col-sm-12 mt-2">
                                    <label class="form-label fw-bold">{{l('نوع گزارش')}}</label>
                                    <select class="form-select select2" name="report_type" id="report_type" required>
                                        <option value="search">{{l('جستجو')}}</option>
                                        <option value="viewhouse">{{l('مشاهده ملک')}}</option>
                                        <option value="updatehouse">{{l('ویرایش ملک')}}</option>
                                        <option value="housing">{{l('ثبت ملک')}}</option>

                                        <option value="totalcustomer">{{l('ثبت مشتری')}} </option>
                                        <option value="time">{{l('زمان حضور')}} </option>
                                        <option value="ladder">{{l('نردبان')}} </option>
                                        @if(env('COUNTRY') != 'UAE')
                                        <option value="advertisment">{{l('آگهی کردن')}} </option>
                                        <option value="360deg">{{l('ثبت ملک با عکس 360')}}</option>
                                        @endif
                                        <option value="visit">{{l('بازدید ملک با مشتری')}} </option>
                                        @if(ss('SITE_ID') == 3)
                                        <option value="fullupdate">{{ l('ویرایش کامل ملک') }}</option>
                                        <option value="masters">{{ l('کارشناسی ملک') }}</option>
                                        <option value="delay">{{ l('تاخیر') }}</option>
                                        <option value="cover">{{ l('پوشش') }}</option>
                                        <option value="management">{{ l('امتیاز مدیریت') }}</option>
                                        <option value="session">{{ l('جلسه مذاکره حضوری') }}</option>
                                        <option value="inactivity">{{ l('عدم فعالیت') }}</option>
                                        <option value="buycontract">{{ l('قرارداد خرید و فروش') }}</option>
                                        <option value="commonbuycontract">{{ l('قرارداد خرید و فروش اشتراکی') }}</option>
                                        <option value="rentcontract">{{ l('قرارداد رهن و اجاره') }}</option>

                                        <option value="tahatorcontract">{{ l('قرارداد تهاتر') }}</option>
                                        <option value="commontahatorcontract">{{ l('قرارداد تهاتر مشارکتی') }}</option>
                                        <option value="mosharekatcontract">{{ l('قرارداد مشارکت در ساخت') }}</option>
                                        <option value="commonmosharekatcontract">{{ l('قرارداد مشارکت در ساخت مشارکتی') }}</option>

                                        <option value="commonrentcontract">{{ l('قرارداد رهن وا جاره اشتراکی') }}</option>
                                        <option value="unsuccesscontract">{{ l('قرارداد های ناموفق') }}</option>

                                        <option value="buyincome">{{ l('درآمد خرید و فروش') }}</option>
                                        <option value="rentincome">{{ l('درآمد رهن و اجاره') }}</option>
                                        <option value="advanced360">{{ l('تور مجازی ساده') }}</option>
                                        <option value="sentRelation">{{ l('پیامک املاک متناسب') }}</option>
                                        <option value="viewRelation">{{ l('مشاهده املاک متناسب توسط مشتری') }}</option>
                                        <option value="film">{{ l('فیلم') }}</option>
                                        <option value="image">{{ l('عکس') }}</option>
                                        @endif
                                        @if(ss('SITE_ID') == 5)
                                        <option value="contract">{{ l('تعداد قرارداد') }}</option>
                                        <option value="income">{{ l('درآمد') }}</option>
                                        @endif
                                        <option value="total">{{l('آمار کلی مشاورین')}} </option>
                                        @if(ss('SITE_ID') == 3)
                                        <option value="total2">{{ l('آمار قولنامه و درامد') }}</option>
                                        @endif
                                        <option value="relation">{{l('املاک متناسب')}} </option>
                                    </select>
                                </div>

                                <div class="col-md-6 col-lg-3 col-sm-12 mt-2">
                                    <label class="form-label fw-bold">{{l('مشاور')}}</label>
                                    <select class="form-control select2" name="user_id" id="user_id" style="width:100%">
                                        <option value="{{$currentUser->id}}">{{l('آمار خودم')}}</option>
                                        @if($currentUser->isAdmin())
                                        @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 8)
                                        @foreach($branches as $branch)
                                            <option value="{{(-1) * $branch->id}}">مشاورین شعبه {{$branch->name}}</option>
                                        @endforeach
                                        @endif
                                        <option value="" {{$currentUser->isAdmin()?'selected':''}}>{{l('همه مشاورین')}}</option>
                                        @foreach($users as $item)
                                            <option value="{{$item->id}}">{{$item->fullname()}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                @if (env('COUNTRY') == 'UAE')
                                <div class="col-md-6 col-lg-3 col-sm-12 mt-2">
                                    <label class="form-label fw-bold"> {{l('تاریخ از')}}</label>
                                    <input name="datefrom" id="datefrom" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ از')}}" value="{{$datefrom}}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                                </div>
                                <div class="col-md-6 col-lg-3 col-sm-12 mt-2">
                                    <label class="form-label fw-bold"> {{l('تاریخ تا')}}</label>
                                    <input name="dateto" id="dateto" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ تا')}}" value="{{$dateto}}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                                </div>
                                @else
                                <div class="col-md-6 col-lg-3 col-sm-12 mt-2">
                                    <label class="form-label fw-bold"> {{l('تاریخ از')}}</label>
                                    <input type="text" name="datefrom" id="datefrom" class="form-control" readonly value="{{$datefrom}}" style="cursor: pointer" />
                                </div>
                                <div class="col-md-6 col-lg-3 col-sm-12 mt-2">
                                    <label class="form-label fw-bold"> {{l('تاریخ تا')}}</label>
                                    <input type="text" name="dateto" id="dateto" class="form-control" readonly value="{{$dateto}}" style="cursor: pointer" />
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
                    <div class="tab-content1 table-p " id="state">
                    </div>

                </div>
            </div>
        </div>
    </main>
    @include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')

<script src="/vendor/highcharts/highcharts.js"></script>
<script src="/vendor/highcharts/exporting.js"></script>
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
        sr+=(typeof $('#user_id').val()!=='undefined' )?"user_id="+$("#user_id").val()+"&":"";
        sr+=(typeof $('#report_type').val()!=='undefined' )?"type="+$("#report_type").val()+"&":"";
        sr+=(typeof $('#datefrom').val()!=='undefined' )?"datefrom="+$("#datefrom").val()+"&":"";
        sr+=(typeof $('#dateto').val()!=='undefined' )?"dateto="+$("#dateto").val()+"&":"";
        loadMoreData(sr)
    }

    $("#form_search").click(function() {
        CheckSend();
    });
    var pagin = 1;
    var str="";
    function loadMoreData(type) {
        type1=type;
        $.ajax({
                url: "/profile/reportShow?"+type,
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
                $('.page-loading').removeClass('active');
            })
    }

    $(document).ready(function() {
        $('.select2').select2();
    })
</script>
@endsection
