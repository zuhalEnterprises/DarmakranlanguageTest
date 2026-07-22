@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => l('داشبورد مدیریت')
])

@section('main_content')

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


    .card {
        box-shadow: 0px 0px 3px 1px #ddd;
    }

    .list-group-item {
        padding: .5rem .75rem;
        border: 1px solid rgba(0, 0, 0, .07);
        display: flex;
        align-items: center;
    }

    .list-group-item:first-child {
        border-radius: 0;
    }

    .list-group-item:last-child {
        border-radius: 0;
    }

    .list-group-item i.fa-square {
        flex-grow: 0;
        cursor: pointer;
        order: 1;
    }

    .list-group-item i.fa-check-square {
        display: none;
    }

    .list-group-item i.fa-trash-alt {
        flex-grow: 0;
        cursor: pointer;
        color: #dc3545;
        order: 3;
    }

    .list-group-item i.fa-trash-alt:hover {
        color: #af1e2c;
    }

    .list-group-item .todo-text {
        flex-grow: 1;
        margin: 0 10px;
        order: 2;
    }

    .list-group-item.done i.fa-check-square {
        flex-grow: 0;
        cursor: pointer;
        color: #28a745;
        display: block;
    }

    .list-group-item.done i.fa-square {
        display: none;
    }

    .list-group-item.done .todo-text {
        text-decoration: line-through;
        color: #888;
    }

    .avatar {
        /*display: inline-table;*/
        height: 2rem;
        width: 2rem;
        border-radius: 50%;
        position: relative;
        align-items: center;
        justify-content: center;
    }

    .avatar-xl {
        height: 3rem;
        width: 3rem;
    }

    .expert-list {
        max-height: 450px;
        overflow-y: auto;
    }
</style>
<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">

        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => '13'])

            <!-- Content-->
            <div class="col-lg-9 col-md-12 pt-4">
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('داشبورد')}}</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2">
                    <h1 class="h2 mb-0">{{l('داشبورد')}}</h1>
                </div>
                <div class="row g-4 d-none">

                    <div class="col-12">
                        <div class="row g-3">

                            <div class="col-12 col-md-4">
                                <div class="card card-raised border-start border-primary border-4 rounded-1" style="border:0; border-right: 1px solid;">
                                    <div class="card-body px-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="me-2">
                                                <div class="display-6">{{$estate_count}}</div>
                                                <div class="card-text fw-bold">
                                                    تعداد املاک
                                                    @if(!$currentUser->isAdmin())
                                                    من
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="icon-circle bg-primary text-white d-flex justify-content-center align-items-center rounded-circle p-3"><i class="fa fa-home opacity-90"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card card-raised  border-4 rounded-1" style="border:0; border-right: 1px solid #3c76f2 ;">
                                    <div class="card-body px-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="me-2">
                                                <div class="display-6">{{$user_customers_count}}</div>
                                                <div class="card-text fw-bold">
                                                    تعداد مشتریان
                                                    @if(!$currentUser->isAdmin())
                                                    من
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="icon-circle  text-white d-flex justify-content-center align-items-center rounded-circle p-3" style="background: #3c76f2 ;"><i class="fa fa-user-tie-hair opacity-90"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card card-raised border-start border-warning border-4 rounded-1" style="border:0; border-right: 1px solid;">
                                    <div class="card-body px-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="me-2">
                                                <div class="display-6">{{$countEstatesNow}}</div>
                                                <div class="card-text fw-bold">
                                                    {{ l('تعداد املاک ثبت شده امروز') }}
                                                </div>
                                            </div>
                                            <div class="icon-circle bg-warning text-white d-flex justify-content-center align-items-center rounded-circle p-3"><i class="fa fa-heart  opacity-90"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
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
        var sr = "ajax=1&";
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
                url: "/dashboard?"+type,
                type: "get",
                beforeSend: function() {
                    $('.page-loading').addClass('active');
                }
            })
            .done(function(data) {
                $('.page-loading').removeClass('active');

                $(".tab-content1").html(data.html);
                $('.page-loading').removeClass('active');
            })
    }

</script>
@endsection
