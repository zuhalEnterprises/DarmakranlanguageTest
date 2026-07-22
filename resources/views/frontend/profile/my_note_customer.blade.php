@section('title', l('یادداشت های من'))
@extends('frontend.profile.layouts.panel')
@section('head')
<link rel="stylesheet" href="{{asset('/mainpage/css/estate.css')}}">
@endsection
@section('panel_content')

@if(count($estates) == 0)
<p class="p-top text-center">{{ l('اطلاعاتی جهت نمایش وجود ندارد!') }}</p>
@else

<div class="row">
    @foreach($estates as $estate)
    <div class="col-12 box-comment " id="note-{{$estate->note->id ?? ''}}">
        <img src="{{$estate->coverImage()}}"  alt="{{$estate->title}}" class="comment-img" alt="user profile image">
        <div class="comment-des">
            <a class="comment-titr" href="{{url($estate->url())}}" title="{{$estate->title}}">
                <span>{{$estate->{{ l('type==1? l("فروش"):l("رهن و اجاره")}}') }}</span>
                <span> {{estateTypes($estate->estate_type)}}</span>
                <span>{{$estate->{{ l('area.\' متری\'}}') }}</span>
            </a>
            <p class="text-muted time">
                <span>{{toPersianDate($estate->published_at,true,false)}} پیش در {{$estate->district->name ?? ''}}</span>
            </p>
            <p class="text-muted des">{{$estate->title}}</p>
        </div>
        <a class="comment-trash"  data-id="{{$estate->note->id ?? ''}}" href="javascript:;">
            <i class="fas fa-trash"  aria-hidden="true"></i>
        </a>
    </div>
    @endforeach
</div>

@endif


<script type="text/javascript">
    // remove item $(".note-del").on("click", function() { var id = $(this).data('id'); $.get("/profile/notes/" + id + "/delete", function(data, status) { if (data.result == 1) { toast({ type: 'error', text: 'یادداشت مورد نظر با موفقیت حذف شد.' }); $("#note-" + id).remove(); } }); });
</script>
@endsection
