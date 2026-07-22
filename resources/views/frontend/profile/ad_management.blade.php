@section('title', l('مدیریت ملک - پیشنمایش ملک'))
@extends('frontend.profile.ad_management.layouts.main')
@section('tab_content')
    <div class="tab-pane fade show active" id="ad-preview" role="tabpanel" aria-labelledby="ad-preview-tab">
        @include('frontend.profile.ad_management.preview')
    </div>
{{--
    <div class="tab-pane fade" id="Upgrade" role="tabpanel" aria-labelledby="Upgrade-tab">
        @include('frontend.profile.ad_management.upgrade')
    </div>

    <div class="tab-pane fade" id="Edit" role="tabpanel" aria-labelledby="Edit-tab">
        @include('frontend.profile.ad_management.edit')
    </div>
--}}

@endsection
