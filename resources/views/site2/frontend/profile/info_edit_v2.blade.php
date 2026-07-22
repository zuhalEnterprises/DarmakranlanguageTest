
<input type="hidden" name="photocover" class="photoCover" value="{{!empty($currentUser)?0:1}}" />
<div class="col-sm-6 mb-3">
    <label for="profile_cover" class="form-label fw-bold">{{ l('تصویر کارت ملی') }}</label>
    <input type="file" name="profile_cover" class="dropify" id="image2" data-max-file-size="5M" data-height="300"
            data-default-file="{{ !empty($currentUser) && old('profile_cover',$currentUser->cover()) }}" value="{{ !empty($currentUser) && old('profile_cover',$currentUser->cover()) }}"/>

    @if(!empty($model) && empty($currentUser->cover()) && $currentUser->profile_cover != null)
    <i class="fa-thin fa-cloud-arrow-up text-[36px]"></i>
    @else
    <div onclick="document.getElementById('profile_cover1').click()" data-target="#profile_cover1">
        <img src="{{ old('profile_cover',$currentUser->cover()) }}" id="previewCover" style="width: 100%" />
    </div>
    <a id="deleteCover" style="cursor: pointer" class="cursor-pointer absolute bottom-7 left-0 text-blue-500 text-[14px] font-light {{(!empty($currentUser) && !empty($currentUser->profile_cover))?'':'d-none'}}">{{ l('حذف') }}</a>
    @endif
</div>
<div class="col-sm-6 mb-3">
    <label class="form-label fw-bold" for="message">{{ l('شماره شبا') }}</label>
    <input class="form-control" type="text"  id="message" name="message"  value="{{old('message',$currentUser->message)}}">
</div>
<script>
    $(document).ready(function()
    {
        $("#deleteCover").click(function(){
            $("#deleteCover").addClass('d-none');
            $('#previewCover').attr("src", "");
            $(".photoCover").val(1);
        });
    });
 </script>
