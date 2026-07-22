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
        color: #0d6efd !important;
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

    .dell {
        position: absolute;
        left: 3px;
        top: 23px;
    }

    .btn-amber {
        color: var(--main-orange);
    }

    .modal-fav-title {
        font-size: 17px;
        font-weight: 700;
    }
    .modal-fav-link{
        border: 1px solid #d1d1d1;
        border-radius: 7px;
        overflow: hidden;
    }
    .btn-teal {
        border-radius: 0;
    }
    .modal-fav-input{
        border: 0;
        height: auto;
    }
    .jssocials-share {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

<!-- <link rel="stylesheet" href="/frontend/css/style.css"> -->

@endsection
@section('panel_content')
<div class="row">
    <div class="col-lg-12">
        <ul class="breadcrumb">
            <li><a href="/">{{ l('خانه') }}</a></li>
            <li><a href="/dashboard_v2">{{ l('داشبورد') }}</a></li>
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
        <div class="card card-favorite-estate">
            <a href="{{ $estate->url() }}" class="card-group card-link mb-2" title="{{$estate->type==1? l("فروش"):l("رهن و اجاره")}} {{estateTypes($estate->estate_type)}} {{$estate->area}}
                            متری
                            در {{$estate->district->name??""}} {{$estate->city->name??""}}">
                <div class="card-body" style="padding:0">
                    <img class="img-c" src="{{$estate->coverImage()}}" alt="{{$estate->type==1? l("فروش"):l("رهن و اجاره")}} {{estateTypes($estate->estate_type)}} {{$estate->area}}
                                متری
                                در {{$estate->district->name??""}} {{$estate->city->name??""}}">
                    <div class="c-1">
                        <h6 class="card-title text-dark txt-c1 fw-bold  ">{{$estate->type==1? l("فروش"):l("رهن و اجاره")}} {{estateTypes($estate->estate_type)}} {{$estate->area}}
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

            {{--pin--}}
            <span data-id="{{$estate->id}}" id="pin" class="pin">
                <i id="pin-item-{{$estate->id}}" class="{{$estate->pin == 1 ? 'btn-amber' : 'btn-white'}} pin-btn fa fa-thumbtack border fa fa-thumbtack pin-btn"></i>
            </span>

            <div class="end-row-card h-auto ty pt-2">
                <div class="dropdown">
                    <button class="btn btn-primary waves-effect waves-light float-right gap-2" type="button" aria-haspopup="true" aria-expanded="false" style="font-size: .9rem;margin:2px" data-toggle="modal" data-target="#modal-share">
                        <span class="fa-share-alt fal pol"></span> {{ l('اشتراک') }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="http://www.facebook.com/sharer.php?u={{url($estate->url())}}" target="_blank">{{ l('فیسبوک') }}</a>
                        <a class="dropdown-item" href="http://twitter.com/share?url={{url($estate->url())}}&text={{$estate->title}}&hashtags={{ss('SITE_NAME')}}" target="_blank">{{ l('توییتر') }}</a>
                        <a class="dropdown-item" href="https://plus.google.com/share?url={{url($estate->url())}}" target="_blank">{{ l('گوگل پلاس') }}</a>
                        <a class="dropdown-item" href="http://www.linkedin.com/shareArticle?mini=true&url={{url($estate->url())}}" target="_blank">{{ l('لینکدین') }}</a>
                    </div>
                </div>
                {{--<span class="share">
                                <button class="btn btn-outline-info bt-ma btn-bookmark" type="button" data-toggle="modal" data-target="#modal-share" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="far fa-share-alt" title="{{ l('اشتراک') }}"></span>
                                </button>
                            </span>--}}
                <a href="javascript:;" class="btn-delete fav-del dell" data-id="{{$estate->id}}"><span class="d-inline fa fa-eraser pl-2"></span>{{ l('حذف از تاریخچه') }}</a>
            </div>
        </div>
    </div>

    @endforeach
</div>

@endif

<!-- Share Modal -->
<div class="modal fade" id="modal-share" tabindex="-1" role="dialog" aria-labelledby="modal-4" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-fav-title" id="exampleModalLongTitle">{{ l('اشتراک‌گذاری لیست ملک‌های نشان‌شده‌') }}</h5>
            </div>
            <div class="modal-body text-center">

                <div class="d-flex flex-center modal-fav-link">
                    <button class="btn btn-primary btn-teal group-share m-0 py-2 copy-text" data-clipboard-text="{{$sharedUrl ?? ''}}">
                        <i aria-hidden="true" class="fa-copy far pl-2"></i>{{ l('کپی') }}
                    </button>
                    <input dir="ltr" type="text" class="form-control group-share w-100 modal-fav-input" tabindex="-1" value="{{$sharedUrl ?? ''}}">
                </div>

                <div id="share" class="mb-3 p-2"></div>

            </div>
        </div>
    </div>
</div>



@endsection
@section('js')
<script src="{{asset('frontend/vendor/jssocials/jssocials.min.js')}}"></script>
<script type="text/javascript">
    $("#share").jsSocials({
        url: '{{$sharedUrl ?? "" }}',
        text: "",
        showLabel: false,
        shares: ["linkedin", "facebook", "googleplus", "whatsapp", "telegram"]
    });

    // remove from favorite
    $(".fav-del").on("click", function() {
        var id = $(this).data('id');
        $.get("/estates/favorite/" + id, function(data, status) {
            if (data.result == 0) {
                toast({
                    type: 'error',
                    text: l('ملک مورد نظر از لیست نشان شده های شما حذف شد.')
                });
                $("#fav-" + id).remove();
            }
        });

    });

    $(".pin").on("click", function() {
        var id = $(this).data('id');
        $.get("/estates/favorite_pin/" + id, function(data, status) {
            if (data.result == 1) {
                $('#pin-item-' + id).removeClass('btn-white').addClass("btn-amber");
            } else {
                $('#pin-item-' + id).removeClass('btn-amber').addClass("btn-white");
            }
        });
    });

    $('.copy-text').tooltip({
        trigger: 'click',
        placement: 'top'
    });

    function setTooltip(btn, message) {
        btn.tooltip('hide')
            .attr('data-original-title', message)
            .tooltip('show');
    }

    function hideTooltip(btn) {
        setTimeout(function() {
            btn.tooltip('hide');
        }, 1000);
    }
    var clipboard = new Clipboard('.copy-text');
    clipboard.on('success', function(e) {
        var btn = $(e.trigger);
        setTooltip(btn, l('آدرس صفحه کپی شد'));
        hideTooltip(btn);
    });
</script>
@endsection
