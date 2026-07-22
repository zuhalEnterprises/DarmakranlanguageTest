<div class="border border-gray-200 rounded-2 py-3 px-2 mb-3 ">


    @if($model->usage_type)
    <div class="flex  py-3 md:gap-2 text-gray-500 font-light">
        <span class="fw-bold"> {{l('نوع کاربری')}} : </span>
        {{l(getFeatureValue($featureValues, $model->usage_type))}}
    </div>
    @endif


    <div class="flex flex-col py-3 md:gap-2 text-gray-500 font-light">
        <span class="fw-bold">
        <?php

            if(!empty($model->conditions)){
                foreach(json_decode($model->conditions,true) as $value){
                    if($value==15)
                        echo l('پیش فروش')." ,";
                    if($value==304)
                        echo l('کلید نخورده')." ,";
                    if($value==348)
                        echo l('فول امکانات');

                }
            }
        ?>
        </span>
    </div>
</div>

