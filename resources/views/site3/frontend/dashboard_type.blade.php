<div class="col-12 ">
    <div class="card card-raised p-3 rounded-1 h-100">
        <script type="text/javascript">
            (function($) { // encapsulate jQuery
                $(function() {
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
                            type: 'column',
                        },
                        title: {
                            text: l('معدل امتیازات شعب')
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            categories: ['@php if(isset($reportShow4)) {echo implode("','",$reportShow4['branchname']); } @endphp'],
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
                            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                            shadow: true
                        },
                        credits: {
                            enabled: false
                        },
                        series: [{
                            name: l('معدل شعبه'),
                            data: [@php if(isset($reportShow2)) { echo implode(',',$reportShow4['avg']); } @endphp]
                        }]
                    });
                });
            })(jQuery);

        </script>

        <div style="direction: ltr">
            <div id="container" style="min-width: 100%; height: 500px; margin: 0 auto"></div>
        </div>

    </div>
</div>
<div class="col-12 col-md-12 mt-2">
    <div class="card">
        <div class="card-header fw-bold fs-lg m-0 bg-secondary">{{ l('لیگ ستارگان') }}</div>
        <div class="card-body py-2">
            <table class="table table-bordered table-striped table-hover" dir="rtl">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center" scope="col" style="width:50px">{{ l('رتبه') }}</th>
                        <th class="text-center" scope="col" style="width:50px">{{ l('عکس') }}</th>
                        <th class="text-center" scope="col">{{ l('کارشناس') }}</th>
                        <th class="text-center" scope="col">{{ l('شعبه') }}</th>
                        <th class="text-center" scope="col">{{ l('امتیاز موفقیت') }}</th>
                        <th class="text-center" scope="col">{{ l('امتیاز تلاش') }}</th>
                        <th class="text-center" scope="col" style="width:40%"></th>
                    </tr>
                </thead>
                @php
                $first = 0;
            @endphp

            @if(isset($reportShow3['searchRnk2']) && is_array($reportShow3['searchRnk2']))
                @foreach ($reportShow3['searchRnk2'] as $key => $val)
                    @php
                        if ($first == 0) {
                            $first = $key;
                        }
                    @endphp

                    @if(isset($reportShow3['search'][$key]) && $reportShow3['search'][$key] > 0)
                        <tr style="background:#{{ isset($reportShow3['searchRnk'][$key]) && $reportShow3['searchRnk'][$key] > 0 && $reportShow3['searchRnk'][$key] <= 3 ? 'ffc750' : 'baffba' }}">
                            <td class="text-center" scope="row">
                                {{$reportShow3['searchRnk2'][$key]}}
                            </td>
                            <td class="text-center" scope="row" style="padding: 3px">
                                <div class="avatar avatar-xl bg-gray-200 rounded-circle overflow-hidden">
                                    <img class="avatar-img img-fluid" src="{{ $reportShow['pic'][$key] ?? '' }}" alt="" />
                                </div>
                            </td>
                            <td class="text-center" scope="row">
                                <a class="text-decoration-none text-dark line-height-normal mb-1" href="/agents/{{$key}}">
                                    {{ $reportShow['name'][$key] ?? l('نامشخص') }}
                                </a>
                            </td>
                            <td class="text-center" scope="row">
                                {{ $reportShow['branch'][$key] ?? '-' }}
                            </td>
                            <td class="text-center" scope="row">
                                {{ $reportShow3['search'][$key] ?? 0 }}
                            </td>
                            <td class="text-center" scope="row">
                                {{ $reportShow['search'][$key] ?? 0 }}
                            </td>
                            <td class="text-center" scope="row">
                                <div class="progress mb-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                                        style="width: {{ isset($reportShow3['search'][$key]) && isset($reportShow3['search'][$first]) && $reportShow3['search'][$first] > 0 ? ($reportShow3['search'][$key] / $reportShow3['search'][$first]) * 100 : 0 }}%"
                                        aria-valuemin="0" aria-valuemax="50">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif

            </table>


        </div>
    </div>
</div>
<div class="col-12 col-md-12 mt-2">
    <div class="card">
        <div class="card-header fw-bold fs-lg m-0 bg-secondary">{{ l('لیگ پایه') }}</div>
        <div class="card-body py-2">

            <table class="table table-bordered table-striped table-hover" dir="rtl">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center" scope="col" style="width:50px">{{ l('رتبه') }}</th>
                        <th class="text-center" scope="col" style="width:50px">{{ l('عکس') }}</th>
                        <th class="text-center" scope="col">{{ l('کارشناس') }}</th>
                        <th class="text-center" scope="col">{{ l('شعبه') }}</th>
                        <th class="text-center" scope="col">{{ l('امتیاز موفقیت') }}</th>
                        <th class="text-center" scope="col">{{ l('امتیاز تلاش') }}</th>
                    </tr>
                </thead>
                @php
                $count = 0;
            @endphp
            @if(isset($reportShow['search']) && is_array($reportShow['search']))
                @foreach ($reportShow['search'] as $key => $val)

                    @if(isset($reportShow3['search'][$key]) && $reportShow3['search'][$key] == 0)
                        <tr style="background:#ffbaba">
                            <td class="text-center" scope="row">
                                @php
                                    echo ++$count;
                                @endphp
                            </td>
                            <td class="text-center" scope="row" style="padding: 5px">
                                <div class="avatar avatar-xl bg-gray-200 rounded-circle overflow-hidden">
                                    <img class="avatar-img img-fluid" src="{{ $reportShow['pic'][$key] ?? '' }}" alt="" />
                                </div>
                            </td>
                            <td class="text-center" scope="row">
                                <a class=" text-decoration-none text-dark line-height-normal mb-1" href="/agents/{{$key}}">
                                    {{ $reportShow['name'][$key] ?? l('نامشخص') }}
                                </a>
                            </td>
                            <td class="text-center" scope="row">
                                {{ $reportShow['branch'][$key] ?? '-' }}
                            </td>
                            <td class="text-center" scope="row">
                                {{ l('0 امتیاز') }}
                            </td>
                            <td class="text-center" scope="row">
                                {{ $val }} امتیاز
                            </td>
                        </tr>
                    @endif

                @endforeach
            @endif
            </table>


        </div>
    </div>
</div>
