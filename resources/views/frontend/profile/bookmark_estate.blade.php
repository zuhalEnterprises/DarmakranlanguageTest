@section('title', l('ملک های نشان شده'))
@extends('frontend.profile.layouts.panel')
@section('head')
<link rel="stylesheet" href="{{asset('/mainpage/css/estate.css')}}">
<style>
    #share .jssocials-shares {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
    }

    #share .jssocials-shares a {
        color: #f78900 !important;
    }

    #share .jssocials-shares a:hover {
        color: #333 !important;
    }

    .jssocials-share {
        flex-basis: 20%;
        margin: 5px;
        height: 80px;
        background: #f3f3f3;
        border-radius: 50%;
    }

    .jssocials-share-logo {
        font-size: 2rem;
        line-height: 4.5rem !important;
        text-shadow: 0px 2px #fff;
    }

    #pin {
        position: absolute;
        top: -7px;
        left: -7px;
        cursor: pointer;
        background: #fff
    }

    .pin-btn {
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        ;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        align-content: center;
    }

    .card-favorite-estate {
        margin-bottom: 10px;
        padding: 16px;
    }
</style>

<!-- <link rel="stylesheet" href="/frontend/css/style.css"> -->
@endsection
@section('panel_content')
<div class="row">
    <div class="col-lg-12">
        <ul class="breadcrumb">
            <li><a href="/">{{ l('خانه') }}</a></li>
            <li>{{ l('ملک های نشان شده') }}</li>
        </ul>
    </div>
</div>
@if(count($estates) == 0)
<p class="p-top text-center">{{ l('شما ملک نشان شده ای ندارید!') }}</p>
@else
<div class="alert bg1-primary btn col-lg-12 col-sm-12 m-0 mb-3 shadow-none waves-effect waves-light" data-toggle="modal" data-target="#modal-share">
    <p class=" m-0">
        <span class="fa-share-alt fal pol"></span> {{ l('اشتراک کل صفحه') }}
    </p>
</div>
<div class="row">
    @foreach($estates as $estate)
    <div class="col-lg-6 col-md-6 col-sm-12" id="fav-{{$estate->id}}">
        <div class="card card-favorite-estate" >
            <a href="{{ $estate->url() }}" class="card-group card-link" title="{{$estate->type==1? l("فروش"):l("رهن و اجاره")}} {{estateTypes($estate->estate_type)}} {{$estate->area}}
                            متری
                            در {{$estate->district->name??""}} {{$estate->city->name??""}}">
                <div class="card-body " style="padding: 0rem;">
                    <img class="img-c" src="{{$estate->coverImage()}}" alt="{{$estate->type==1? l("فروش"):l("رهن و اجاره")}} {{estateTypes($estate->estate_type)}} {{$estate->area}}
                                متری
                                در {{$estate->district->name??""}} {{$estate->city->name??""}}">
                    <div class="c-1">
                        <h6 class="card-title text-dark txt-c1 fw-bold">{{$estate->type==1? l("فروش"):l("رهن و اجاره")}} {{estateTypes($estate->estate_type)}} {{$estate->area}}
                            متری
                            در {{$estate->district->name??""}} {{$estate->city->name??""}}</h6>
                        <p class="card-text txt-c2">
                            @if($estate->type == 2)
                            ودیعه: {{toPersianNumbers($estate->{{ l('mortgage)}} تومان') }}<br>
                            اجاره ماهیانه:{{toPersianNumbers($estate->{{ l('rent)}} تومان') }}<br>
                            @else
                            {{toPersianNumbers($estate->{{ l('price)}} تومان') }}<br>
                            @endif
                            <span style="font-size: 12px;">در {{$estate->district->name ?? ''}}</span>
                        </p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
