@include('frontend.profile.ad_management.layouts.chart_requirements')
<style>
    .highcharts-root{
        /*font-family: 'Vazir' !important;*/
    }
    .chart-section{
        direction: ltr;
    }
    .chart-section .charts{
    }

    .chart-section,
    .chart-section .highcharts-title,
    .highcharts-label,
    .highcharts-tooltip,
    .highcharts-tooltip span,
    .highcharts-axis-labels,
    .highcharts-yaxis-labels,
    .highcharts-axis,
    .highcharts-xaxis,
    .chart-tooltips-date,
    .chart-tooltips-name,
    .chart-tooltips-value,
    .highcharts-legend-item{
        font-family: inherit !important
    }
    .chart-section .highcharts-title{
        font-size: 1.2em !important;
    }
    .chart-tooltips-date{
        text-align: left;
    }
    .chart-tooltips-name{
        text-align: right;
        direction:rtl
    }
    .chart-tooltips-value{
        text-align: left;
        direction:ltr;
        color: #000;
    }
    .chart-section p.not-found{
        right: 25%;
        direction: rtl;
        text-align: center;
        position: absolute;
        top: 50%;
        left: 25%;
        color: #aaa;
    }
    .vazir{font-family:IRANSans !important}
</style>
@isset($chart)
<div class="col-lg-12 chart-section">
<div class="chart-block">
    {!! $chart->html() !!}
    @if(empty(empty($chart->datasets[0]['values'])))
        <p class="not-found" style="display: none">{{ l('اطلاعاتی جهت نمایش وجود ندارد!') }}</p>
    @endif
    {!! $chart->script() !!}
</div>
</div>
@endisset

{{--@isset($charts)
    <div class="row">
@foreach($charts as $key=>$chart)

        <div class="{{$chart['box_css_col'] ?? 'col-lg-12'}} chart-section">
        <section class="box">
            <header class="box-header clearfix"></header>
            <div class="box-body" >
                <div id="chart-{{$key}}" class="col-lg-12 chart-block">
                    {!! $chart['chart']->html() !!}
                    --}}{{--@if(empty($chart->datasets[0]['values']))
                            <p class="not-found">{{ l('اطلاعاتی جهت نمایش وجود ندارد!') }}</p>
                    @endif--}}{{--
                    {!! $chart['chart']->script() !!}
                </div>
            </div>
        </section>
        </div>

@endforeach
    </div>
@endisset--}}
