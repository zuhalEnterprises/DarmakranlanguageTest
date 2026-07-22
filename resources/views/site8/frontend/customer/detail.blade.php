<div class="border border-gray-200 rounded-2 py-3 px-2 mb-3 ">
    <!--  -->
    <div class="row row-cols-2">
    @if($model->max_room_count)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">

        <span class="fw-bold">{{ l('حداقل تعداد خواب:') }}</span>
        <span>
            {{$model->max_room_count}}
            </span>

    </div>
    @endif
    @if($model->max_unit_in_floor)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light ">
      <span class="fw-bold">{{ l('حداکثر تعداد واحد در طبقه:') }}</span>

            {{$model->max_unit_in_floor}}

    </div>
    @endif
    @if($model->max_building_age)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">
        <span class="fw-bold">
     {{ l('حداکثر عمر بنا:') }}
     </span>
            <?php
                switch($model->max_building_age){
                    case '1':
                        echo l("حداکثر 1 سال");
                        break;
                    case '2':
                        echo l("حداکثر 2 سال");
                        break;
                        case '3':
                        echo l("حداکثر 5 سال");
                        break;
                        case '4':
                        echo l("حداکثر 10 سال");
                        break;
                        case '5':
                        echo l("حداکثر 20 سال");
                        break;
                        case '6':
                        echo l("حداکثر 30 سال");
                        break;
                        case '7':
                        echo l("بیش از 30 سال");
                        break;
                }
            ?>

    </div>
    @endif
    @if($model->floor_min)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">
        <span class="fw-bold">
     حداقل تعداد طبقات: {{$model->floor_min}}
     </span>
    </div>
    @endif

    @if($model->usage_type)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">
    <span class="fw-bold">{{ l('نوع کاربری :') }}</span>
            {{getFeatureValue($featureValues, $model->usage_type)}}
    </div>
    @endif

    @if($model->floor_count)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">
    <span class="fw-bold">{{ l('شماره طبقات:') }}</span>

            <?php
            switch ($model->floor_count) {
                case '1':
                    echo l("طبقه اول");
                    break;
                    case '2':
                    echo l("بجز طبقه اول");
                    break;
                    case '3':
                    echo l("طبقات وسط");
                    break;
                    case '4':
                    echo l("طبقات آخر");
                    break;

                default:

                    break;
            }

            ?>
    </div>
    @endif
    @if($model->min_floor_count)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">
    <span class="fw-bold">{{ l('حداقل تعداد طبقات :') }}</span>
            {{$model->min_floor_count}}
    </div>
    @endif
    @if($model->floor_start)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">
    <span class="fw-bold">{{ l('شروع طبقات از :') }}</span>

            {{getFeatureValue($featureValues, $model->floor_start)}}
    </div>
    @endif
    @if($model->min_built_area)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">
    <span class="fw-bold">  حداقل زیر بنا : {{$model->min_built_area}} </span>

    </div>
@endif
@if($model->min_front_area)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">
    <span class="fw-bold">{{ l('حداقل متراژ بر :') }}</span>

            {{$model->min_front_area}}

    </div>
@endif
@if($model->min_street_width)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">
    <span class="fw-bold">{{ l('حداقل عرض گذر :') }}</span>

            {{$model->min_street_width}}

    </div>
@endif
@if($model->min_density)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">
    <span class="fw-bold">{{ l('حداقل تراکم :') }}</span>

            {{$model->min_density}}

    </div>
@endif
@if($model->geography)
<div class="flex  py-3 md:gap-2 text-gray-500 font-light">
    <span class="fw-bold">{{ l('جهت جغرافیایی:') }}</span>
    {{getFeatureValue($featureValues, $model->geography)}}
</div>
@endif
@if($model->build_license)
<div class="flex  py-3 md:gap-2 text-gray-500 font-light">
<span class="fw-bold">{{ l('پروانه ساخت :') }}</span>

            {{!empty($model->build_license)?($model->build_license==290? l('دارد'):''):''}}
            {{!empty($model->build_license)?($model->{{ l('build_license==290?\'ندارد\':\'\'):\'\'}}') }}

    </div>
    @endif
    <div class="flex flex-col py-3 md:gap-2 text-gray-500 font-light">
    <span class="fw-bold">
    <?php
        if(!empty($model->facilities)){
            foreach(json_decode($model->facilities,true) as $value){
                if($value==35)
                    echo l("پارکینگ ،");
                if($value==36)
                    echo l("انباری ،");
                if($value==37)
                    echo l("آسانسور ,");
            }
        }
        if(!empty($model->conditions)){
            foreach(json_decode($model->conditions,true) as $value){
                if($value==15)
                    echo l("پیش فروش ،");
                if($value==304)
                    echo l("کلید نخورده ،");
                if($value==348)
                    echo l("فول امکانات ,");
            }
        }
    ?>
    </span>
    </div>
    </div>
</div>
