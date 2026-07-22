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
        display: inline-flex;
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
                    <h1 class="h2 mb-0"> {{l('داشبورد')}}</h1>
                </div>
                <div class="row g-4">

                    <div class="col-12">
                        <div class="row g-3">

                            <div class="col-12 col-md-4">
                                <div class="card card-raised border-start border-primary border-4 rounded-1" style="border:0; border-right: 1px solid;">
                                    <div class="card-body px-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="me-2">
                                                <div class="display-6">{{$estate_count}}</div>
                                                <div class="card-text fw-bold">
                                                    {{l('تعداد املاک')}}
                                                    @if(!$currentUser->isAdmin())
                                                    {{l('من')}}
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
                                                    {{l('تعداد مشتریان')}}
                                                    @if(!$currentUser->isAdmin())
                                                    {{l('من')}}
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
                                                    {{l('تعداد املاک ثبت شده امروز')}}
                                                </div>
                                            </div>
                                            <div class="icon-circle bg-warning text-white d-flex justify-content-center align-items-center rounded-circle p-3"><i class="fa fa-heart  opacity-90"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card card-raised p-3 rounded-1 h-100">
                            <script type="text/javascript">
                                (function($){ // encapsulate jQuery
                                    $(function () {
                                        $('#container2').highcharts({
                                            color: {
                                                linearGradient: { x1: 0, x2: 0, y1: 0, y2: 1 },
                                                stops: [
                                                    [0, '#003399'],
                                                    [1, '#3366AA']
                                                ]
                                            },
                                            chart: {
                                                type: 'column'
                                            },
                                            title: {
                                                text: '{{l('امتیاز مشاورین کل مجموعه')}}'
                                            },
                                            subtitle: {
                                                text: ''
                                            },
                                            xAxis: {
                                                categories: ['@php if(isset($reportShow)) { echo implode("','",$reportShow['name']); } @endphp'],
                                                title: {
                                                    text: null
                                                }
                                            },
                                            yAxis: {
                                                min: 0,
                                                title: {
                                                    text: '',
                                                    align: 'high'
                                                },
                                                labels: {
                                                    overflow: 'justify'
                                                }
                                            },

                                            plotOptions: {
                                                bar: {
                                                    dataLabels: {
                                                        enabled: true
                                                    }
                                                }
                                            },
                                            legend: {
                                                layout: 'vertical',
                                                align: 'right',
                                                verticalAlign: 'top',
                                                x: -40,
                                                y: 300,
                                                floating: true,
                                                borderWidth: 1,
                                                backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFffff'),
                                                shadow: true
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            series: [
                                                {
                                                    name: '{{l('امتیاز مشاور')}}' ,
                                                    data: [@php echo implode(',',$reportShow['search']) @endphp],
                                                    tooltip: {
                                                        valueSuffix: ' {{l('امتیاز')}}'
                                                    }
                                                },
                                                {
                                                    name: '{{l('رتبه در کل مجموعه')}}',
                                                    data: [@php echo implode(',',$reportShow['searchRnk'])@endphp]
                                                }
                                            ]
                                        });
                                    });
                                })(jQuery);
                            </script>

                            <div style="direction: ltr">
                                <div id="container2" style="min-width: 100%; height: 500px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>

                    @if($currentUser->isAdmin())
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
                        <div class="col-12 my-5">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h2 class="h3 mb-0 ">
                                    {{l('عملکرد کارشناسان')}}
                                </h2>

                            </div>
                            <div class="mx-n2 table-p">
                                <table class="table table-bordered table-striped table-hover" dir="rtl">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center" scope="col">{{l('مشاور')}}</th>
                                            <th class="text-center" scope="col"> {{l('املاک متناسب')}} </th>
                                            <th class="text-center" scope="col"> {{l('مشتریان متناسب')}} </th>
                                            <th class="text-center" scope="col">  {{l('تائید شده')}} </th>
                                            <th class="text-center" scope="col"> {{l('املاک رد شده')}} </th>
                                            <th class="text-center" scope="col"> {{l('املاک ارسال شده')}} </th>
                                            <th class="text-center" scope="col"> {{l('املاک نامشخص')}} </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($reports as $report)
                                        @if(array_key_exists('name', $report))
                                        <tr>
                                            <td class="text-center" scope="row">
                                                <a href="/customer?expertid={{$report['expertid']>0 ? $report['expertid'] : ''}}">{{$report['name']}}</a>
                                            </td>
                                            <td class="text-center" scope="row">
                                                {{$report['sum']}}
                                            </td>
                                            <td class="text-center" scope="row">
                                                {{$report['customer']}}
                                            </td>
                                            <td class="text-center" scope="row">
                                                {{$report[2]}}
                                            </td>
                                            <td class="text-center" scope="row">
                                                {{$report[1]}}
                                            </td>
                                            <td class="text-center" scope="row">
                                                {{$report[3]}}
                                            </td>
                                            <td class="text-center" scope="row">
                                                {{$report[0]}}
                                            </td>

                                        </tr>
                                        @endif
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    @else
                    <div class="col-12 my-5">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h2 class="h3 mb-0 ">
                                {{l('عملکرد امروز')}}
                            </h2>

                        </div>
                        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2 table-p" dir="ltr">
                            <table class="table table-bordered table-striped table-hover "  dir="rtl">
                                <thead class="table-primary ">
                                    <tr>
                                        <th valign="middle" style="text-align:center" scope="col" class="sortable  align-items-center gap-1" onclick="sort('id')">
                                        <span>{{l('کد مشتری')}}</span>
                                        <div class="d-flex flex-column gap-2">


                                        </div>
                                        </th>
                                        <th valign="middle" style="text-align:center" class="" scope="col">
                                        <div class="d-flex align-items-center gap-1">
                                            <span>{{l('نام خریدار')}}</span>
                                            <span class="d-flex flex-column gap-2">


                                            </span>
                                        </div>
                                    </th>

                                        <th valign="middle" style="text-align:center" scope="col">

                                        <div class="d-flex align-items-center gap-1">
                                            <span>{{l('نوع ملک')}}</span>
                                            <span class="d-flex flex-column gap-2">


                                            </span>
                                        </div>
                                    </th>
                                        <th valign="middle" style="text-align:center" scope="col">

                                        <div class="d-flex align-items-center gap-1">
                                            <span>{{l('محلات')}}</span>
                                            <span class="d-flex flex-column gap-2">


                                            </span>
                                        </div>
                                    </th>

                                    <th class="text-center" scope="col"> {{l('املاک متناسب')}} </th>
                                    <th class="text-center" scope="col">  {{l('تائید شده')}} </th>

                                    <th class="text-center" scope="col"> {{l('املاک رد شده')}} </th>

                                    <th class="text-center" scope="col"> {{l('املاک ارسال شده')}} </th>

                                    <th class="text-center" scope="col"> {{l('املاک نامشخص')}} </th>

                                        <th valign="middle" style="text-align:center" scope="col"> {{l('جزئیات')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                            @foreach($customers as $item)
                            <?php
                                $bgcolor =  ($item->updated_at < date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-58 day" ) ))?'#d5ddff':'';
                            ?>
                            @if($reports[$item->id]['sum']>0)
                            <tr style="background-color:{{$bgcolor}}">
                                <td valign="middle" align="center" data-href="/customer/{{$item->id}}" class='clickable-row'>
                                    {{$item->id}}
                                </td>
                                <td valign="middle" align="center" data-href="/customer/{{$item->id}}" class='clickable-row'>
                                    @if(!$currentUser->isAdmin() && $currentUser->id != $item->user_id )
                                        {{$item->user->fullname() ?? ''}}
                                    @else
                                        {{$item->name}}
                                    @endif
                                </td>

                                <td valign="middle" align="center" data-href="/customer/{{$item->id}}" class='clickable-row'>
                                    {{l(mapEstateCategoryName($item->estate_type))}}
                                </td>
                                <td valign="middle" align="center" data-href="/customer/{{$item->id}}" class='clickable-row'>
                                    <div style="width: 150px;height:50px;overflow:auto">
                                    @php
                                    $_districtList = array();
                                    @endphp
                                    @foreach($item->districts as $district)
                                    @php
                                    $_districtList[] = $district->name
                                    @endphp

                                    @endforeach
                                    {{implode(' , ',$_districtList)}}
                                    </div>
                                </td>
                                <td class="text-center"  valign="middle" align="center">
                                    {{$reports[$item->id]['sum']}}
                                </td>

                                <td class="text-center"  valign="middle" align="center">
                                    {{$reports[$item->id][2]}}
                                </td>

                                <td class="text-center"  valign="middle" align="center">
                                    {{$reports[$item->id][1]}}
                                </td>

                                <td class="text-center"  valign="middle" align="center">
                                    {{$reports[$item->id][3]}}
                                </td>

                                <td class="text-center"  valign="middle" align="center">
                                    {{$reports[$item->id][0]}}
                                </td>


                                <td valign="middle" align="center">
                                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                                        <li>
                                            <a class="dropdown-item" target="_blank" href="/customer/{{$item->id}}">
                                                <i class="fa-light fa-eye opacity-60 me-2"></i>{{l('مشاهده جزئیات')}}
                                            </a>
                                        </li>
                                        @if($item->user_id == Auth::user()->id || $currentUser->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch'))
                                        <li>
                                            <a class="dropdown-item"  target="_blank" href="/customer/{{$item->id}}/edit_v2" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                                {{l('ویرایش تقاضا')}}
                                            </a>
                                        </li>

                                        @endif
                                    </ul>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            </tbody>
                            </table>
                        </div>

                    </div>
                    @endif



                    </div>

                </div>
            </div>
        </div>
    </div>
</main>


<script>

</script>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])

@endsection
@section('js')
<script src="/vendor/highcharts/highcharts.js"></script>


@endsection
