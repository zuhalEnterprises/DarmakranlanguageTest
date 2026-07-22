@if($request->type == 'relation')
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
<table class="table table-bordered table-striped table-hover">
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
</table>
@elseif($request->type == 'total' && $request->user_id > 0 && ss('SITE_ID') != 5)
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card expert-list">
            <div class="card-body py-2">
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#">{{l('مشاهده ملک')}}</a>
                    <p class="m-0 fw-bold">
                        {{$reportViewhouseCount}} {{l('ملک')}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{getsetting('statictis','viewhouse')}})
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="/profile/editsEstate?&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">{{l('ویرایش ملک')}}</a>
                    <p class="m-0 fw-bold">
                        <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="/profile/editsEstate?&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">
                            {{$reportUpdateHousingCount}} {{l('ملک')}}
                            @if(ss('SITE_ID') == 3)
                            (ضریب {{getsetting('statictis','updatehouse')}})
                            @endif
                        </a>
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{l('ثبت ملک')}}</a>
                    <p class="m-0 fw-bold">
                        {{$reportHousingCount}} {{l('ملک')}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','housing')}})
                        @endif
                    </p>
                </div>
                @if(env('COUNTRY') != 'UAE')
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!"> {{l('ثبت ملک با عکس 360')}}</a>
                    <p class="m-0 fw-bold">
                        {{$report360DegCount}} {{l('ملک')}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','360Deg')}})
                        @endif
                    </p>
                </div>
                @endif
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!"> {{l('ثبت مشتری')}}</a>
                    <p class="m-0 fw-bold">
                        {{$reportTotalcustomerCount}} {{l('مشتری')}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','totalcustomer')}})
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">  {{l('زمان حضور')}}</a>
                    <p class="m-0 fw-bold">
                        {{(int)$reportTimeCount}} {{l('ساعت')}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','time')}})
                        @endif
                    </p>
                </div>
                @if(env('COUNTRY') != 'UAE')
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">   {{l('نردبان')}}</a>
                    <p class="m-0 fw-bold">
                        {{$reportLadderCount}} {{l('ملک')}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','ladder')}})
                        @endif

                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="/profile/operationEstate?type=3&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">   {{l('آگهی کردن')}}</a>
                    <p class="m-0 fw-bold">
                        <a href="/profile/operationEstate?type=3&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">
                            {{$reportAdvertismentCount}} {{l('ملک')}}

                            @if(ss('SITE_ID') == 3)
                            (ضریب {{(int)getsetting('statictis','advertisment')}})
                            @endif
                        </a>
                    </p>
                </div>
                @endif
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="/profile/operationEstate?type=2&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">{{l('بازدید ملک با مشتری')}}</a>
                    <p class="m-0 fw-bold">
                        <a href="/profile/operationEstate?type=2&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">
                            {{$reportVisitCount}} {{l('ملک')}}

                            @if(ss('SITE_ID') == 3)
                            (ضریب {{(int)getsetting('statictis','visit')}})
                            @endif
                        </a>
                    </p>
                </div>
                @if(ss('SITE_ID') == 3)
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">

                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="/profile/operationEstate?type=1&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank"> {{l('کارشناسی ملک')}} </a>
                    <p class="m-0 fw-bold">
                        <a href="/profile/operationEstate?type=1&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">
                            {{$reportMastersCount}} {{l('ملک')}}

                            @if(ss('SITE_ID') == 3)
                            (ضریب {{(int)getsetting('statictis','masters')}})
                            @endif
                        </a>
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('تعداد قرارداد خرید و فروش') }}</a>
                    <p class="m-0 fw-bold">
                        {{$reportBuyContractCount}} {{l('ملک')}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','buycontract')}})
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('تعداد قرارداد رهن و اجاره') }}</a>
                    <p class="m-0 fw-bold">
                        {{$reportRentContractCount}} {{l('ملک')}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','rentcontract')}})
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('تعداد قرارداد اشتراکی خرید و فروش') }}</a>
                    <p class="m-0 fw-bold">
                        {{$reportCommonBuyContractCount}} {{l('ملک')}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','commonbuycontract')}})
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('تعداد قرارداد اشتراکی رهن و اجاره') }}</a>
                    <p class="m-0 fw-bold">
                        {{$reportCommonRentContractCount}} {{l('ملک')}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','commonrentcontract')}})
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('تعداد قرارداد ناموفق') }}</a>
                    <p class="m-0 fw-bold">
                        {{$reportUnsuccessContractCount}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','unsuccesscontract')}})
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('تعداد قرارداد تهاتر') }}</a>
                    <p class="m-0 fw-bold">
                        {{$reportTahatorContractCount}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','tahatorcontract')}})
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('تعداد قرارداد مشارکت') }}</a>
                    <p class="m-0 fw-bold">
                        {{$reportMosharekatContractCount}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','mosharekatcontract')}})
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('درآمد خرید و فروش') }}</a>
                    <p class="m-0 fw-bold">
                        {{$reportBuyIncomeCount}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','buyincome')}})
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="#!">{{ l('درآمد رهن و اجاره') }}</a>
                    <p class="m-0 fw-bold">
                        {{$reportRentIncomeCount}}
                        @if(ss('SITE_ID') == 3)
                        (ضریب {{(int)getsetting('statictis','rentincome')}})
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="/profile/operationUser?type=2&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">{{ l('تاخیر') }}</a>
                    <p class="m-0 fw-bold">
                        <a href="/profile/operationUser?type=2&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">
                        {{$reportDelayCount}}
                        </a>

                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="/profile/operationUser?type=1&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}">{{ l('پوشش') }}</a>
                    <p class="m-0 fw-bold">
                        <a href="/profile/operationUser?type=1&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">
                        {{$reportCoverCount}}
                        </a>
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="/profile/operationUser?type=4&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}">{{ l('جلسه مذاکره حضوری') }}</a>
                    <p class="m-0 fw-bold">
                        <a href="/profile/operationUser?type=4&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">
                        {{$reportSessionCount}}
                        </a>
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2 border-bottom pb-2">
                    <a class=" text-decoration-none text-dark line-height-normal mb-1 fw-bold py-1" href="/profile/operationUser?type=3&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}">{{ l('عدم فعالیت') }}</a>
                    <p class="m-0 fw-bold">
                        <a href="/profile/operationUser?type=3&user_id={{$request->user_id}}&datefrom={{$request->datefrom}}&dateto={{$request->dateto}}" target="_blank">
                        {{$reportInactivityCount}}
                        </a>
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@else
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
            $('#container').highcharts({
                color: {
                    linearGradient: { x1: 0, x2: 0, y1: 0, y2: 1 },
                    stops: [
                        [0, '#003399'],
                        [1, '#3366AA']
                    ]
                },
                chart: {
                    type: 'bar'
                },
                title: {
                    text: '{{$title}}'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: ['@php echo implode("','",$report['name']) @endphp'],
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
                        name: '{{$title}}' ,
                        data: [@php echo implode(',',$report['search']) @endphp],
                        tooltip: {
                            valueSuffix: ' {{$unit}}'
                        }
                    },
                    {
                        name: '{{l('معدل')}} ',
                        data: [@php echo implode(',',$report['searchAve']) @endphp],
                        tooltip: {
                            valueSuffix: ' {{$unit}}'
                        }
                    },
                    {
                        name: '{{l('رتبه در کل مجموعه')}}',
                        data: [@php echo implode(',',$report['searchRnk'])@endphp]
                    }
                ]
            });
        });
    })(jQuery);
</script>

<div style="direction: ltr">
    <div id="container" style="min-width: 100%; height: {{$height}}px; margin: 0 auto"></div>
</div>

@endif
