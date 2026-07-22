@section('title', l('یادداشت های من'))
@extends('frontend.profile.layouts.panel')
@section('head')
<link rel="stylesheet" href="{{asset('/mainpage/css/estate.css')}}">
@endsection
@section('panel_content')
<div class="row">
    <div class="col-lg-12">
        <ul class="breadcrumb">
            <li><a href="/">{{ l('خانه') }}</a></li>
            <li><a href="/dashboard_v2">{{ l('داشبورد') }}</a></li>
            <li>{{ l('یادداشت های من') }}</li>
        </ul>
    </div>
</div>
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


    <!--div class="col-lg-12" id="note-{{$estate->note->id ?? ''}}">
        <div class="border-0 card mb-3 p-1 shadow">

            <a href="{{url($estate->url())}}" class="card-group card-link" title="{{$estate->title}}">
                <div class="card-body">
                    <img class="float-right img-c ml-0 mr-3" src="{{$estate->coverImage()}}" alt="{{$estate->title}}">
                    <div class="c-1">
                        <h6 class="card-title text-dark txt-c1">{{$estate->title}}</h6>
                        <p class="card-text mt-3 txt-c2">
                            {{--@if($estate->type == 2)
                                                ودیعه: {{toPersianNumbers($estate->{{ l('mortgage)}} تومان') }}<br>
                            اجاره ماهیانه:{{toPersianNumbers($estate->{{ l('rent)}} تومان') }}<br>
                            @else
                            {{toPersianNumbers($estate->{{ l('price)}} تومان') }}<br>
                            @endif--}}
                            <span style="font-size: 12px;">{{toPersianDate($estate->published_at,true,false)}} پیش در {{$estate->district->name ?? ''}}</span>
                        </p>

                        {{--note--}}
                        <hr>
                        <p class="card-text mt-3 txt-c2">
                            <span class="font-weight-bold p-1">{{$estate->note->note ?? ''}}</span>
                        </p>

                    </div>

                </div>
            </a>

            <div class="row">
                <div class="col-lg-12" id="note-action">
                    <a class="border btn h-auto note-del text-danger w-auto" data-id="{{$estate->note->id ?? ''}}" href="javascript:;">
                        <i class="d-inline fa fa-trash" aria-hidden="true"></i> {{ l('حذف') }}
                    </a>
                </div>
            </div>
        </div>
    </div-->

    @endforeach
</div>

@endif


<script type="text/javascript">
    // remove item $(".note-del").on("click", function() { var id = $(this).data('id'); $.get("/profile/notes/" + id + "/delete", function(data, status) { if (data.result == 1) { toast({ type: 'error', text: 'یادداشت مورد نظر با موفقیت حذف شد.' }); $("#note-" + id).remove(); } }); });
</script>
@endsection
