<div class=" rounded-2 py-3 mb-4">
    <!--  -->
    <div class="px-2 row">
        @if($model->grade > 0)
        <div class="col-6 col-sm-3 mb-4">
            <p class=" mb-2">{{l('نوع مشتری')}}:</p>
            <p class="fw-bold mb-0">
                {{CustomerGrade((int)$model->grade)}}
            </p>
        </div>
        @endif
        @if($model->language != null)
        <div class="col-6 col-sm-3 mb-4">
            <p class=" mb-2">{{l('زبان')}}:</p>
            <p class="fw-bold mb-0">
                {{$model->language->name}}
            </p>
        </div>
        @endif
        @if($model->country != null)
        <div class="col-6 col-sm-3 mb-4">
            <p class=" mb-2">{{l('کشور')}}:</p>
            <p class="fw-bold mb-0">
                {{$model->country->name}}
            </p>
        </div>
        @endif

        @if($model->max_room_count)
        <div class="col-6 col-sm-3 mb-4">
            <p class=" mb-2">{{l('حداقل تعداد خواب')}}:</p>
            <p class="fw-bold mb-0">
                {{$model->max_room_count}}
            </p>
        </div>
        @endif
        @if($model->max_unit_in_floor)
        <div class="col-6 col-sm-3 mb-4">
            <p class=" mb-2">
                {{l('حداکثر تعداد واحد در طبقه')}}:
            </p>
            <p class="fw-bold mb-0">
                {{$model->max_unit_in_floor}}
            </p>
        </div>
        @endif
        @if($model->max_building_age)
        <div class="col-6 col-sm-3 mb-4">
            <p class=" mb-2">
                {{l('حداکثر عمر بنا')}}:
            </p>
            <p class="fw-bold mb-0">
            <?php
                switch($model->max_building_age){
                    case '1':
                        echo l('حداکثر 1 سال');
                        break;
                    case '2':
                        echo l('حداکثر 2 سال');
                        break;
                        case '3':
                        echo l('حداکثر 5 سال');
                        break;
                        case '4':
                        echo l('حداکثر 10 سال');
                        break;
                        case '5':
                        echo l('حداکثر 20 سال');
                        break;
                        case '6':
                        echo l('حداکثر 30 سال');
                        break;
                        case '7':
                        echo l('بیش از 30 سال');
                        break;
                }
            ?>
            </p>
        </div>
        @endif
        @if($model->usage_type)
        <div class="col-6 col-sm-3 mb-4">
            <p class=" mb-2"> {{l('نوع کاربری')}}: </p>
            <p class="fw-bold mb-0">
                {{l(getFeatureValue($featureValues, $model->usage_type))}}
            </span>
        </div>
        @endif
        @if($model->min_built_area)
        <div class="col-6 col-sm-3 mb-4">
            <p class=" mb-2">
                  {{l('حداقل زیر بنا')}}:
            </p>
            <p class="fw-bold mb-0">
                {{$model->min_built_area}}
            </p>
        </div>
        @endif
        @if($model->acquaintance_type>0)
        <div class="col-6 col-sm-3 mb-4">
            <p class=" mb-2">
                  Lead Source:
            </p>
            <p class="fw-bold mb-0">
                {{$model->get_acquaintance_type != null ? $model->get_acquaintance_type->name : ""}}
            </p>
        </div>
        @endif
        @if($model->acquaintance != '')
        <div class="col-6 col-sm-3 mb-4">
            <p class=" mb-2">
                  Lead Source Comment:
            </p>
            <p class="fw-bold mb-0">
                {{$model->acquaintance}}
            </p>
        </div>
        @endif
        <div class="col-12 col-sm-12 mt-3">
            <p class="fw-bold mb-0">
            <?php
            if(!empty($model->facilities)){
                foreach(json_decode($model->facilities,true) as $value){
                    if($value==35)
                        echo l('پارکینگ')."، ";
                    if($value==36)
                        echo l('انباری')."، ";
                    if($value==37)
                        echo l('آسانسور')."، ";
                }
            }
            if(!empty($model->conditions)){
                foreach(json_decode($model->conditions,true) as $value){
                    if($value==15)
                        echo l('پیش فروش').", ";
                    if($value==304)
                        echo l('کلید نخورده').", ";
                    if($value==348)
                        echo l('فول امکانات');
                }
            }
            ?>
            </p>
        </div>
    </div>
</div>
