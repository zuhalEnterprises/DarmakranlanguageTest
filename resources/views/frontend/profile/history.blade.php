@section('title', l('بازدیدهای اخیر'))
@extends('frontend.profile.layouts.panel')
@section('head')
<style>
    .c-1 {
        width: calc(100% - 140px) !important;
        float: left;
    }

    .card-box-shadow {
        box-shadow: 0 0 10px 0 rgb(7 95 255 / 30%) !important;
    }
    input.form-control {
    height: auto;
}
</style>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script> -->
<!-- <link rel="stylesheet" href="{{asset('/frontend/css/mdb.min.css')}}"> -->
<!-- <link rel="stylesheet" href="{{asset('/frontend/css/style.css')}}"> -->
<link rel="stylesheet" href="{{asset('/mainpage/css/estate.css')}}">
@endsection
@section('panel_content')
<div class="row">
    <div class="col-lg-12">
        <ul class="breadcrumb">
            <li><a href="/">{{ l('خانه') }}</a></li>
            <li><a href="/dashboard_v2">{{ l('داشبورد') }}</a></li>
            <li>{{ l('بازدید های اخیر') }}</li>
        </ul>
    </div>
</div>

@if(count($estates) == 0)
<p class="p-top text-center">{{ l('اطلاعاتی جهت نمایش وجود ندارد!') }}</p>
@else

<div class="row">
    @foreach($estates as $estate)

    <div class="col-lg-6 col-md-6 col-sm-12 mb-3" id="item-{{$estate->id}}">
        <div class="card card-box-shadow">
            <a href="{{url($estate->url)}}" class="card-group card-link" title="{{$estate->title}}">
                <div class="card-body p-3">
                    <img class="img-c" src="{{$estate->coverImage()}}" alt="{{$estate->title}}">
                    <div class="c-1" style="float:left">
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
                            <span style="font-size: 12px;">{{toPersianDate($estate->published_at,true,false)}} در {{$estate->district->name ?? ''}}</span>
                        </p>
                    </div>



                </div>
            </a>

            <div class="end-row-card h-auto ty py-2 px-3">
                <div class="dropdown">
                    <button class="btn btn-primary waves-effect waves-light d-flex gap-2 px-3" type="button" aria-haspopup="true" aria-expanded="false" style="font-size: .9rem;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <span class="fa-share-alt fal pol"></span> {{ l('اشتراک') }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="http://www.facebook.com/sharer.php?u={{url($estate->url)}}" target="_blank">{{ l('فیسبوک') }}</a>
                        <a class="dropdown-item" href="http://twitter.com/share?url={{url($estate->url)}}&text={{$estate->title}}&hashtags={{ss('SITE_NAME')}}" target="_blank">{{ l('توییتر') }}</a>
                        <a class="dropdown-item" href="https://plus.google.com/share?url={{url($estate->url)}}" target="_blank">{{ l('گوگل پلاس') }}</a>
                        <a class="dropdown-item" href="http://www.linkedin.com/shareArticle?mini=true&url={{url($estate->url)}}" target="_blank">{{ l('لینکدین') }}</a>
                    </div>
                </div>
                <!-- <a href="javascript:;" class="btn-delete item-del dell" data-id="{{$estate->id}}">
                                    <span class="d-inline fa fa-eraser pl-2"></span>{{ l('حذف از تاریخچه') }}
                                </a> -->
            </div>
        </div>
    </div>

    @endforeach
</div>

@endif
<!-- Share Modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ l('اشتراک‌گذاری ملک‌') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body my-4">
                <div class="input-group mb-3">
                    <button class="btn btn-info" type="button" id="button-addon1">
                    <i aria-hidden="true" class="fa-copy far pl-2"></i>
                    {{ l('کپی') }}</button>
                    <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // remove from history
    $(".item-del").on("click", function() {
        var id = $(this).data('id');

        var updateStatus = updateCookie('esids', id, 30, true);
        if (updateStatus) {
            $('#item-' + id).remove();
        }
    });
</script>
@endsection
