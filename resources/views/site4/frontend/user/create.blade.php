<div class="col-sm-4 mb-3">
    <label class="form-label fw-bold">{{l('زبان')}}</label>
    <select name="languages[]" id="languages" class="form-select select-lang select2" aria-label="Default select " multiple="multiple">
        @foreach(language_list() as $item)
        <option value="{{$item->id}}"  {{!empty($model)?(in_array($item->id , $language_ids)?'selected':''):''}}>{{$item->name}}</option>
        @endforeach
    </select>
</div>
<div class="col-sm-4 mb-3">
    <label class="form-label fw-bold">{{l('لیبل')}}</label>
    <select class="form-control" name="label" id="label">
        <option value="0" {{!empty($model)?($model->label== 0 ? 'selected' : ''):''}}>Beginer</option>
        <option value="1" {{!empty($model)?($model->label== 1 ? 'selected' : ''):''}}>{{l('برنزی')}}</option>
        <option value="2" {{!empty($model)?($model->label== 2 ? 'selected' : ''):''}}>{{l('نقره ای')}}</option>
        <option value="3" {{!empty($model)?($model->label== 3 ? 'selected' : ''):''}}>{{l('طلایی')}}</option>
        <option value="4" {{!empty($model)?($model->label== 4 ? 'selected' : ''):''}}>{{l('الماس')}}</option>
    </select>
</div>
