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
    @include(ss('THEME').'.frontend.layouts.header_v2')
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
                    <h1 class="h2 mb-0">{{ l('داشبورد') }}</h1>
                </div>
                <div class="row g-4">
                <div class="col-12 d-none">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="card card-raised p-3 rounded-1 h-100">
                                    <h3>{{ l('جمله روز:') }}</h3>
                                    <figure>
                                        <blockquote class="blockquote">
                                            <p>{{ l('در انسان صاحب نبوغ اگر دست کم دو چیز دیگر وجود نداشته باشد، وجودش تاب‌آوردنی نیست: شکرگزاری و پاکی') }}</p>
                                        </blockquote>
                                        <figcaption class="blockquote-footer">
                                             <cite title="Source Title">{{ l('فردریش نیچه') }}</cite>
                                        </figcaption>
                                        </figure>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="card card-raised p-3 rounded-1 h-100">
                                        <h3>{{ l('پیام مدیریت:') }}</h3>
                                        <figure>
                                            <blockquote class="blockquote">
                                                <p>{{ l('مرگ به‌همگی ما لبخند می‌زند، تنها کاری که می‌توان انجام داد این است که لبخندش را با لبخند پاسخ گوییم.') }}</p>
                                            </blockquote>

                                        </figure>
                                </div>
                            </div>
                        </div>
                    </div>
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

                    <div class="col-12 col-md-6 d-none">
                        <div class="card  h-100 ">
                            <div class="m-3 h-100">
                                <p class="fw-bold fs-lg m-0">{{ l('چک لیست') }}</p>
                                <div class="h-100 d-flex justify-content-between flex-column pb-2">
                                    <div class="card-body">
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item">
                                                <i class="far fa-square done-icon"></i>
                                                <i class="far fa-check-square done-icon"></i>
                                                <span class="todo-text">{{ l('خرید') }}</span>
                                                <i class="far fa-trash-alt"></i>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer px-0">
                                        <form id="form">
                                            <div class="input-group gap-1" dir="rtl">
                                                <input type="text" class="form-control rounded-1" id="todo" placeholder="{{ l('اقدام خود را بنویسید') }}">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-1" id="button-addon2">
                                                        <i class="fas fa-plus"></i>
                                                        <span>{{ l('افزودن') }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card expert-list">
                            <div class="card-header fw-bold fs-lg m-0 bg-secondary">{{ l('عملکرد شما در ماه جاری') }}</div>
                            <div class="card-body py-2">
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                                <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#">{{ l('مشاهده ملک') }}</a>
                                    <p class="m-0 fw-bold">
                                        {{$reportViewhouseCount}} ملک
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#">{{ l('ویرایش ملک') }}</a>
                                    <p class="m-0 fw-bold">
                                        {{$reportUpdateHousingCount}} ملک
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('ثبت ملک') }}</a>
                                    <p class="m-0 fw-bold">
                                        {{$reportHousingCount}} ملک
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('ثبت ملک با عکس 360') }}</a>
                                    <p class="m-0 fw-bold">
                                        {{$report360DegCount}} ملک
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('ثبت مشتری') }}</a>
                                    <p class="m-0 fw-bold">
                                        {{$reportTotalcustomerCount}} مشتری
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('زمان حضور') }}</a>
                                    <p class="m-0 fw-bold">
                                        {{(int)$reportTimeCount}} ساعت
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('نردبان') }}</a>
                                    <p class="m-0 fw-bold">
                                        {{$reportLadderCount}} ملک
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('آگهی کردن') }}</a>
                                    <p class="m-0 fw-bold">
                                        {{$reportAdvertismentCount}} ملک
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('بازدید ملک با مشتری') }}</a>
                                    <p class="m-0 fw-bold">
                                        {{$reportVisitCount}} ملک
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('کارشناسی ملک') }}</a>
                                    <p class="m-0 fw-bold">
                                        {{$reportMastersCount}} ملک
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card expert-list">
                            <div class="card-header fw-bold fs-lg m-0 bg-secondary">{{ l('امتیاز مشاورین در ماه جاری') }}</div>
                            <div class="card-body py-2">
                                @foreach ($reportShow['search'] as $key=>$val)
                                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                                    <div class="d-flex align-items-center flex-shrink-0 me-3">
                                        <div class="fs-6 fw-bold me-3">
                                            {{$reportShow['searchRnk'][$key]}}
                                        </div>
                                        <div class="avatar avatar-xl me-3 bg-gray-200 rounded-circle overflow-hidden">
                                            <img class="avatar-img img-fluid" src="{{$reportShow['pic'][$key]}}" alt="" />
                                        </div>
                                        <div class="d-flex flex-column fw-bold">
                                            <a class=" text-decoration-none text-dark line-height-normal mb-1" href="/agents/{{$key}}">{{$reportShow['name'][$key]}}</a>
                                        </div>
                                    </div>
                                    <p class="m-0 fw-bold">
                                        {{$val}} امتیاز
                                    </p>

                                </div>
                                @endforeach



                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-none">
                        <div class="card card-raised p-3 rounded-1 h-100">
                            <h3 class="mb-4">{{ l('نمودار آماری مشاورین شعبه') }}</h3>
                            <script type="text/javascript">
                                var example = 'bar-basic',
                                    theme = 'default';
                                (function($){ // encapsulate jQuery
                                    $(function () {
                                        Highcharts.setOptions({
                                            lang: {
                                                thousandsSep: ','
                                            }
                                        });
                                        $('#container3').highcharts({
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
                                                text: l('نمودار آماری مشاورین شعبه')
                                            },
                                            subtitle: {
                                                text: ''
                                            },
                                            xAxis: {
                                                categories: ['@php echo implode("','",$reportShow['name']) @endphp'],
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
                                                    name: l('امتیاز') ,
                                                    data: [@php echo implode(',',$reportShow['search']) @endphp],
                                                    tooltip: {
                                                        valueSuffix: l('امتیاز')
                                                    }
                                                },
                                                {
                                                    name: l('رتبه در کل مجموعه'),
                                                    data: [@php echo implode(',',$reportShow['searchRnk'])@endphp]
                                                }
                                            ]
                                        });
                                    });
                                })(jQuery);
                            </script>

                            <div style="direction: ltr">
                                <div id="container3" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
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
                                    {{ l('عملکرد کارشناسان') }}
                                </h2>

                            </div>
                            <div class="mx-n2 table-p">
                                <table class="table table-bordered table-striped table-hover" dir="rtl">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center" scope="col">{{ l('مشاور') }}</th>
                                            <th class="text-center" scope="col">{{ l('املاک متناسب') }}</th>
                                            <th class="text-center" scope="col">{{ l('مشتریان متناسب') }}</th>
                                            <th class="text-center" scope="col">{{ l('تائید شده') }}</th>

                                            <th class="text-center" scope="col">{{ l('املاک رد شده') }}</th>

                                            <th class="text-center" scope="col">{{ l('املاک ارسال شده') }}</th>

                                            <th class="text-center" scope="col">{{ l('املاک نامشخص') }}</th>


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
                                                {{$report[1]}}
                                            </td>

                                            <td class="text-center" scope="row">
                                                {{$report[2]}}
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
                                {{ l('عملکرد امروز') }}
                            </h2>

                        </div>
                        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2 table-p" dir="ltr">
                            <table class="table table-bordered table-striped table-hover "  dir="rtl">
                                <thead class="table-primary ">
                                    <tr>
                                        <th valign="middle" style="text-align:center" scope="col" class="sortable  align-items-center gap-1" onclick="sort('id')">
                                        <span>{{ l('کد مشتری') }}</span>
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

                                    <th class="text-center" scope="col">{{ l('املاک متناسب') }}</th>
                                    <th class="text-center" scope="col">{{ l('تائید شده') }}</th>

                                    <th class="text-center" scope="col">{{ l('املاک رد شده') }}</th>

                                    <th class="text-center" scope="col">{{ l('املاک ارسال شده') }}</th>

                                    <th class="text-center" scope="col">{{ l('املاک نامشخص') }}</th>

                                        <th valign="middle" style="text-align:center" scope="col">{{ l('جزئیات') }}</th>
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
                                                <i class="fa-light fa-eye opacity-60 me-2"></i>{{ l('مشاهده جزئیات') }}
                                            </a>
                                        </li>
                                        @if($item->user_id == Auth::user()->id || $currentUser->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch'))
                                        <li>
                                            <a class="dropdown-item"  target="_blank" href="/customer/{{$item->id}}/edit_v2" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                                {{ l('ویرایش تقاضا') }}
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
                    <div class="col-12 my-5">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h2 class="h3 mb-0 ">
                                {{ l('مشتریان منتظر حذف یا ویرایش') }}
                            </h2>

                        </div>
                        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2 table-p" dir="ltr">
                            <table class="table table-bordered table-striped table-hover "  dir="rtl">
                                <thead class="table-primary ">
                                    <tr>
                                        <th valign="middle" style="text-align:center" scope="col" class="align-items-center gap-1">
                                            {{ l('کد مشتری') }}

                                        </th>
                                        <th valign="middle" style="text-align:center"  class="align-items-center gap-1" scope="col">
                                            {{l('نام خریدار')}}
                                        </th>

                                        <th valign="middle" style="text-align:center" scope="col"  class="align-items-center gap-1">
                                            {{ l('نوع ملک') }}
                                        </th>
                                        <th valign="middle" style="text-align:center" scope="col" class="align-items-center gap-1">
                                            {{ l('محلات') }}
                                        </div>
                                    </th>



                                        <th valign="middle" style="text-align:center" scope="col">{{ l('جزئیات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                            @foreach($specialCustomers as $item)
                            <?php
                                $bgcolor =  ($item->updated_at < date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-58 day" ) ))?'#d5ddff':'';
                            ?>

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


                                <td valign="middle" align="center">
                                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                                        <li>
                                            <a class="dropdown-item" target="_blank" href="/customer/{{$item->id}}">
                                                <i class="fa-light fa-eye opacity-60 me-2"></i>{{ l('مشاهده جزئیات') }}
                                            </a>
                                        </li>
                                        @if($item->user_id == Auth::user()->id || $currentUser->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch'))
                                        <li>
                                            <a class="dropdown-item"  target="_blank" href="/customer/{{$item->id}}/edit_v2" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                                {{ l('ویرایش تقاضا') }}
                                            </a>
                                        </li>

                                        @endif
                                    </ul>
                                </td>
                            </tr>

                            @endforeach
                            </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<script>

    // const todoList = document.querySelector('.list-group');
    // const form = document.querySelector('#form');
    // const todoInput = document.querySelector('#todo');

    // const search = document.querySelector('#search');

    // // Load all event listners
    // allEventListners();


    // // Functions of all event listners
    // function allEventListners() {
    //     // Add todo event
    //     form.addEventListener('submit', addTodo);
    //     // Remove and complete todo event
    //     todoList.addEventListener('click', removeTodo);
    //     // Search todo event
    //     search.addEventListener('keyup', searchTodo);
    // }


    // // Add todo item function
    // function addTodo(e) {
    //     if (todoInput.value !== '') {
    //         // Create li element
    //         const li = document.createElement('li');
    //         // Add class
    //         li.className = 'list-group-item';
    //         // Add complete and remove icon
    //         li.innerHTML = `<i class="far fa-square done-icon"></i>
    //                     <i class="far fa-check-square done-icon"></i>
    //                     <i class="far fa-trash-alt"></i>`; // // Create span element // const span = document.createElement('span'); // // Add class // span.className = 'todo-text'; // // Create text node and append to span // span.appendChild(document.createTextNode(todoInput.value)); // // Append span to li // li.appendChild(span); // // Append li to ul (todoList) // todoList.appendChild(li); // // Clear input // todoInput.value = ''; // } else { // alert('Please add todo'); // } // e.preventDefault(); // } // // Remove and complete todo item function // function removeTodo(e) { // // Remove todo // if (e.target.classList.contains('fa-trash-alt')) { // if (confirm('آیا از حذف اقدام مطمئنید؟')) { // e.target.parentElement.remove(); // } // } // // Complete todo // if (e.target.classList.contains('todo-text')) { // e.target.parentElement.classList.toggle('done'); // } // if (e.target.classList.contains('done-icon')) { // e.target.parentElement.classList.toggle('done'); // } // } // // Clear or remove all todos function // function clearTodoList() { // todoList.innerHTML = ''; // } // // Search todo function // function searchTodo(e) { // const text = e.target.value.toLowerCase(); // const allItem = document.querySelectorAll('.list-group-item'); // for (let task of allItem) { // const item = task.textContent; // if (item.toLowerCase().indexOf(text) != -1) { // task.style.display = 'flex'; // } else { // task.style.display = 'none'; // } // }; // }
</script>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])

@endsection
@section('js')
<script src="/vendor/highcharts/highcharts.js"></script>


@endsection
