@section('title', l('پیشنهاد املاک'))
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
            <li>{{ l('پیشنهاد املاک') }}</li>
        </ul>
    </div>
</div>

@if(count($query) == 0)
<p class="p-top text-center">{{ l('شما ملک ثبت شده معتبری ندارید!') }}</p>
@else

@foreach($query as $estate)
<div class="row border-bottom mb-2 pb-2 content-box ">
    <div class="col-lg-8 col-sm-12">
        <div class=" text-myad-right">
            <div class="ads-img">
                <img src="{{$estate->coverImage()}}" class="mw-100" alt="{{$estate->title}}">
            </div>
            <h3 class="ads-header">{{$estate->estates->type==1? l("فروش"):l("رهن و اجاره")}} {{estateTypes($estate->estates->estate_type)}} {{$estate->estates->area}}
                متری
                در {{$estate->estates->district->name??""}} {{$estate->estates->city->name??""}}</h3>
            <span class="price">
                @if($estate->estates->type == 2)
                ودیعه: {{toPersianNumbers($estate->estates->{{ l('mortgage)}} تومان') }}<br>
                اجاره ماهیانه:{{toPersianNumbers($estate->estates->{{ l('rent)}} تومان') }}<br>
                @else
                {{toPersianNumbers($estate->estates->{{ l('price)}} تومان') }}<br>
                @endif
            </span>
            <span class="time">{{toPersianDate($estate->estates->created_at,true,false)}} در {{$estate->estates->district->name ?? ''}}</span>
        </div>
    </div>


    <div class="col-lg-4 col-sm-12">
        <div class=" text-myad-left">

            <a href="{{$estate->estates->url()}}" class="btn btn-outline-amber btn-outline-primary m-0 p p-1 px-2 waves-effect waves-light shadow-5-strong" style="border-width: 1px !important;">
                <i class="fas fa-eye"></i>{{ l('پیشنمایش ملک') }}</a>

                <span  onclick="OfferEstate({{$estate->estates->id}})" class="mt-1 btn btn-outline-success m-0 p p-1 px-2 shadow-5-strong" style="border-width: 1px !important;">
                <i class="fas fa-check"></i>{{ l('تایید') }}</span>

        </div>
    </div>
</div>
@endforeach

@endif

@endsection


<script>
  function OfferEstate(estateid) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            url: '/Offer/Estate',
            type: "POST",
            data: {
                estate_id: estateid
            },
            success: function(data) {
                alert(data);
            }
        });
  }

</script>
