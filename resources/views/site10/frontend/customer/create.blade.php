<div class="col-lg-4 col-sm-6 mb-3 buyer-content d-none max_room_count1">
    <div>
        <label  class="form-label" for="max_room_count">{{l('تعداد خواب')}}</label>
        <select class="form-control" name="max_room_count" id="max_room_count">
            <option value="">{{l('استودیو فلت')}}</option>
            <option value="1" {{!empty($model)?($model->max_room_count== 1 ? 'selected' : ''):''}}>1</option>
            <option value="2" {{!empty($model)?($model->max_room_count== 2 ? 'selected' : ''):''}}>2</option>
            <option value="3" {{!empty($model)?($model->max_room_count== 3 ? 'selected' : ''):''}}>3</option>
            <option value="4" {{!empty($model)?($model->max_room_count== 4 ? 'selected' : ''):''}}>4</option>
            <option value="5" {{!empty($model)?($model->max_room_count== 5 ? 'selected' : ''):''}}>5</option>
            <option value="6" {{!empty($model)?($model->max_room_count== 6 ? 'selected' : ''):''}}>6</option>
            <option value="7" {{!empty($model)?($model->max_room_count== 7 ? 'selected' : ''):''}}>7</option>
        </select>
    </div>
</div>

<div class="col-sm-12 mb-3 buyer-content">
    <div class="row">
        <div class="col-lg-4 col-sm-12 mb-3 buyer-content d-none conditions151">
            <div>
                <label  class="form-label" for="max_building_age">{{l('پیش خرید')}}</label>
                <input class="form-check-input" id="conditions15" {{!empty($model)?checkValueCreate($model->conditions,15):""}} value="15" type="checkbox" name="conditions[]">
            </div>
        </div>
        <div class="col-lg-4 col-sm-12 mb-3 buyer-content">
            <div>
                <label class="form-label" for="existing_document">{{l('آماده تحویل')}}</label>
                <input class="form-check-input" name="existing_document" value="1" type="checkbox" id="existing_document" {{!empty($model)?(($model->existing_document == 1)?"checked":""):""}}>
            </div>
        </div>
    </div>
</div>






