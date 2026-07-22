





<div class="col-md-6 col-lg-3 col-sm-6 mt-3 d-none usage_type1">

        <label class="fw-bold" for="usage_type">{{l('نوع کاربری')}}</label>
        <select name="usage_type" id="usage_type" class="form-select">
            <option value="">{{l('انتخاب نمایید')}}</option>
            @foreach (usage_type() as $key=>$val)
            <option value="{{$key}}">{{l($val)}}</option>
            @endforeach
        </select>

</div>

<div class="col-md-6 col-lg-3 col-sm-6 mt-3  d-none ">

    <label  class="fw-bold" for="max_building_age">{{l('پیش خرید')}}</label>
    <input class="form-check-input" id="js_pish" value="15" type="checkbox" name="conditions[]">
</div>

<div class="col-md-6 col-lg-3 col-sm-6 mt-3  buyer-content">
    <div>
        <label class="fw-bold" for="existing_document">{{l('آماده تحویل')}}</label>
        <input class="form-check-input" name="existing_document" value="1" type="checkbox" id="existing_document">
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".max_room_count1").removeClass('d-none');
        $(".min_floor_count1").removeClass('d-none');
        $(".max_unit_in_floor1").removeClass('d-none');
        $(".max_building_age1").removeClass('d-none');
        $(".conditions151").removeClass('d-none');
        $(".floor_count1").removeClass('d-none');
        $("#estate_type").change(function(){
            $(".min_front_area1").addClass('d-none');
            $(".max_unit_in_floor1").addClass('d-none');
            $(".max_building_age1").addClass('d-none');
            $(".conditions151").addClass('d-none');
            $(".floor_count1").addClass('d-none');
            $(".floor_start1").addClass('d-none');
            $(".min_floor_area1").addClass('d-none');
            $(".min_street_width1").addClass('d-none');
            $(".min_density1").addClass('d-none');
            $(".build_license1").addClass('d-none');
            $(".geography1").addClass('d-none');


            $(".max_room_count1").addClass('d-none');
            if($(this).val()==1 || $(this).val()==2){
            $(".max_room_count1").removeClass('d-none');
            $(".min_floor_count1").removeClass('d-none');


            }
            if($(this).val()==3 || $(this).val()==2){
                $(".min_front_area1").removeClass('d-none');
            }
            if($(this).val()==1){
                $(".max_unit_in_floor1").removeClass('d-none');
                $(".max_building_age1").removeClass('d-none');
                $(".conditions151").removeClass('d-none');
                $(".floor_count1").removeClass('d-none');

            }
            if($(this).val()==2){
                $(".floor_start1").removeClass('d-none');
                $(".min_floor_area1").removeClass('d-none');
                $(".min_street_width1").removeClass('d-none');
                $(".min_density1").removeClass('d-none');
                $(".geography1").removeClass('d-none');
                $(".build_license1").removeClass('d-none');
            }

        });

    });
</script>
