@section('title', l('کارشناسان نشان شده'))
@extends('frontend.profile.layouts.panel')
@section('head')
<!-- <link rel="stylesheet" href="{{asset('/frontend/css/mdb.min.css')}}"> -->
<link rel="stylesheet" href="{{asset('/frontend/css/style.css')}}">
<style>
    #pin, #remove{
        position: absolute;
        top: 4px;
        left: 12px;
        cursor: pointer;
    }
    #remove{
        top: 4px;
        right: 12px;
        left: auto;
    }
    .pin-btn, .rm-btn{
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
        width: 28px;
        height: 28px;
        border-radius: 50%;
    }
    .rm-btn{
        transform: none;
    }
</style>

@endsection
@section('panel_content')
<div class="row">
    <div class="col-lg-12">
        <ul class="breadcrumb">
            <li><a href="/">{{ l('خانه') }}</a></li>
            <li><a href="/dashboard_v2">{{ l('داشبورد') }}</a></li>
            <li>{{ l('کارشناسان نشان شده') }}</li>
        </ul>
    </div>
</div>

        @if(count($favoriteExperts) == 0)
            <p class="p-top text-center">{{ l('شما کارشناس نشان شده ای ندارید!') }}</p>
        @else

            <div class="row">
                @foreach($favoriteExperts as $favoriteExpert)

                    <div class="col-lg-6 col-sm-6 col-sm-12 adress-area my-2 px-2 kama-agent-tile e-{{$favoriteExpert->expert_id}}" id="e-{{$favoriteExpert->id}}">
                        {{--pin--}}
                        <span data-id="{{$favoriteExpert->id}}" id="pin" class="pin">
                            <i id="pin-item-{{$favoriteExpert->id}}" class="{{$favoriteExpert->pin == 1 ? 'btn-amber' : 'btn-white'}} border d-flex fa fa-thumbtack pin-btn"></i>
                        </span>
                        {{--delete--}}
                        <span data-id="{{$favoriteExpert->expert_id}}" id="remove" class="remove fav-del">
                            <i class="btn-white border d-flex fa fa-trash rm-btn text-danger"></i>
                        </span>
{{--                        <a href="javascript:;" class="btn-delete fav-del dell" data-id="{{$favoriteExpert->id}}"><span class="fa fa-eraser "></span>{{ l('حذف') }}</a>--}}

                        <div class="adress-card border primary-agent pt-2 px-3 rounded-sm shadow-sm">
                            <div>
                                <div class="img-area" ><img alt="" class="rounded-circle" src="{{$favoriteExpert->expert->photo() ?? noImage()}}" style="height: 90px;"></div>
                                <div class="customer-info p-2">
                                    <h4>{{$favoriteExpert->expert->name ?? ''}}</h4>
                                    <p class="text-small">{{$favoriteExpert->expert->getRoleTitle() ?? ''}}</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row adress-footer">
                                <div class="col-lg-6 px-1"><a class="px-0 small" href="/agents/{{$favoriteExpert->expert->id}}"><i class="fa fa-eye"></i>{{ l('مشاهده پروفایل') }}</a></div>
                                <div class="col-lg-6 px-1"><a class="px-0 small" href="tel:{{$favoriteExpert->expert->username}}"><i class="fa fa-phone"></i> {{$favoriteExpert->expert->username}}</a></div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>

                @endforeach
            </div>

        @endif

    <script type="text/javascript">

        // remove favorite $(".fav-del").on("click", function () { var expertId = $(this).data('id'); $.get("/agents/favorite/" + expertId, function (data, status) { if (data.result == 0) { toast({ type: 'error', text: 'کارشناس مورد نظر از لیست نشان شده های شما حذف شد.' }); $(".e-" + expertId).remove(); } }); }); $(".pin").on("click", function () { var id = $(this).data('id'); $.get("/agents/favorite_pin/" + id, function (data, status) { if (data.result == 1) { $('#pin-item-'+id).removeClass('btn-white').addClass("btn-amber"); } else { $('#pin-item-'+id).removeClass('btn-amber').addClass("btn-white"); } }); });
    </script>
@endsection


