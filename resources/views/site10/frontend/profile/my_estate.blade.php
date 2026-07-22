@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('لیست املاک')
])
@section('main_content')
@if(ss('SITE_ID') == 3)
<link href="/frontend/js/modules/leaflet/leaflet.css" rel="stylesheet" type="text/css">
<link href="/frontend/js/modules/leaflet/markercluster/MarkerCluster.css" rel="stylesheet" type="text/css">
<link href="/frontend/js/modules/leaflet/leaflet.draw.css" rel="stylesheet" type="text/css">
@endif
<link href="/css/Mh1PersianDatePicker.css" rel="stylesheet" />
<style>
    .hidden {
        display: none
    }
    .text-center {
        text-align: center;
    }
    .px-18px {
        padding-left: 5px;
        padding-right: 5px;
    }
    .input-price:focus {
        outline: none;
    }
    .bg-white {
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
    }
    .border-gray-400 {
        --tw-border-opacity: 1;
        border-color: rgb(163 163 163 / var(--tw-border-opacity));
    }
    .border-1px {
        border-width: 1px;
    }
    .rounded-25 {
        border-radius: 25px;
    }
    .select2-dropdown {
        z-index: 100000000;
    }
    .justify-between {
        justify-content: space-between;
    }
    .items-center {
        align-items: center;
    }
    .w-full {
        width: 100%;
    }
    .h-59px {
        height: 39px;
    }
    .flex {
        display: flex;
    }
    button,
    [role="button"] {
        cursor: pointer;
    }
    .duration-300 {
        transition-duration: 300ms;
    }
    .text-gray-500 {
        --tw-text-opacity: 1;
        color: rgb(92 92 92 / var(--tw-text-opacity));
    }
    .font-light {
        font-weight: 300;
    }
    .text-right {
        text-align: right;
    }
    .overflow-auto {
        overflow: auto;
    }
    .scroll-p-4 {
        scroll-padding: 1rem;
    }
    .h-260px {
        height: 260px !important;
    }
    .text-gray-500 {
        --tw-text-opacity: 1;
        color: rgb(92 92 92 / var(--tw-text-opacity));
    }
    .text-lg {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }
    .text-right {
        text-align: right;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .h-0 {
        height: 0px;
    }
    .object-cover {
        object-fit: cover;
    }
    .page-loading {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        -webkit-transition: all .4s .2s ease-in-out;
        transition: all .4s .2s ease-in-out;
        background-color: #fff;
        opacity: 0;
        visibility: hidden;
        z-index: 9999;
    }
    .page-loading-inner {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        text-align: center;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        -webkit-transition: opacity .2s ease-in-out;
        transition: opacity .2s ease-in-out;
        opacity: 0;
    }
    .page-loading-inner>span {
        display: block;
        font-size: 1rem;
        font-weight: normal;
        color: #666276;
        ;
    }
    .page-spinner {
        display: inline-block;
        width: 2.75rem;
        height: 2.75rem;
        margin-bottom: .75rem;
        vertical-align: text-bottom;
        border: .15em solid #bbb7c5;
        border-right-color: transparent;
        border-radius: 50%;
        -webkit-animation: spinner .75s linear infinite;
        animation: spinner .75s linear infinite;
    }
    @-webkit-keyframes spinner {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes spinner {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    .imgestate {
        height: 206px;
        width: 100%
    }
    .range-slider .align-items-center {
        display: none !important
    }
    .noUi-handle-upper .noUi-tooltip {
        bottom: -150% !important;
    }
    .nav-pills .nav-link {
        background: none;
        border: 0;
        border-radius: .1rem;
    }
</style>
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" media="screen" href="/vendor/tiny-slider/dist/tiny-slider.css" />
<style>
    .checkmap {
        --tw-bg-opacity: 1;
        background-color: rgb(2 94 198 / var(--tw-bg-opacity));
    }
    #js_overlay {
        z-index: 1001
    }
    html {
        scroll-behavior: smooth;
    }
    .aside-search {
        width:280px;
        position: fixed;
        top: 50px;
        overflow: auto;
        height: calc(100vh - 64px);
    }
    .main-search{
        width: auto;
        margin-right: 280px;
    }
    .search {
        background: #E7E7E7;
        width: 100%;
        height: 40px;
        cursor: pointer
    }
    #search {
        background: #E7E7E7;
        width: 100%;
        border-top: 3px solid #D2D6DE
    }
    .not{
        display: none
    }
    .pending {color:orange !important}
    .verified {color:green !important}
    .rejected {color:gray !important}
    .withdrawal {color:red  !important}
    .tradedoutsideoffice {color:#666276 !important}
    .tradedoffice {color:#666276 !important}
    .hidden2 {color:#666276 !important}
</style>
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <!-- Page content-->
        <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
            <!-- Page content-->
            <div class="row">
                @include('frontend.layouts.sidebar', ['menu' => '2'])
                <!-- Content-->
                <div class="col-lg-9 col-md-12 mb-5">
                    <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('لیست املاک')}}</li>
                    </ol>
                </nav>
                <h3 class="mb-3">{{l('لیست املاک')}} </h3>
                <form  id="mySearch">
                <input type="hidden" name="confirmation" id="confirmation" value="verified">
                <input type="hidden" name="order" id="order" value="showdate">
                <input type="hidden" name="orderby" id="orderby" value="desc">
                <input type="hidden" id="js_HiddenMapDrawPoints" style="width:0px;height:0px;overflow:hidden;border:0px" value="">
                @if($currentUser->isExpert())
                <div class="card shadow-sm mb-4">
                    <div class=" card-body border-0  pb-1 me-lg-1">

                        @if(0 && ($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch|expert') ))
                        <input type="hidden" name="user_id" id="user_id" value="{{$currentUser->isAdmin()?"":$currentUser->id}}">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
                                @if ($Agent->isMobile())
                                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                                    <button type="button" onclick="seluserid('{{$currentUser->id}}')" class="buser buser{{$currentUser->id}} btn btn-outline-secondary {{!$currentUser->isAdmin()?"active":''}}">{{l('املاک من')}}</button>
                                    <button type="button" onclick="seluserid('2')" class="buser buser-1 btn btn-outline-secondary" >{{l('بدون مشاور')}}</button>
                                    <button type="button " onclick="seluserid('')" class="buser buser0  btn btn-outline-secondary {{$currentUser->isAdmin()?"active":''}}">{{l('همه املاک')}}</button>
                                </div>
                                <div class="btn-group  btn-group-lg mt-2" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group " role="group">
                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{l('لیست مشاورین')}}
                                        </button>
                                        <div class="dropdown-menu my-1">
                                            @foreach($users as $item)
                                            <a href="#" onclick="seluserid('{{$item->id}}')" class="buser buser{{$item->id}} dropdown-item {{(array_key_exists('expertid' , $_REQUEST) && $_REQUEST['expertid'] == $item->id) ? 'active' : ''}}">{{$item->fullname()}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                @else

                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button type="button" onclick="seluserid('{{$currentUser->id}}')" class="buser buser{{$currentUser->id}} btn btn-outline-secondary {{!$currentUser->isAdmin()?"active":''}}">{{l('املاک من')}}</button>
                                    <button type="button" onclick="seluserid('2')" class="buser buser-1 btn btn-outline-secondary" >{{l('بدون مشاور')}}</button>
                                    <button type="button" onclick="seluserid('')" class="buser buser0  btn btn-outline-secondary {{$currentUser->isAdmin()?"active":''}}">{{l('همه املاک')}}</button>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Agent List
                                        </button>
                                        <div class="dropdown-menu my-1">
                                            @foreach($users as $item)
                                            <a href="#" onclick="seluserid('{{$item->id}}')" class="buser buser{{$item->id}} dropdown-item {{(array_key_exists('expertid' , $_REQUEST) && $_REQUEST['expertid'] == $item->id) ? 'active' : ''}}">{{$item->fullname()}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="row">


                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('درخواست')}}</label>
                                <select name="request_type" id="request_type" class="form-select">
                                    <option></option>
                                    <option value="1">{{l('خرید')}}</option>
                                    <option value="2">{{l('اجاره')}}</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('کد ملک')}}</label>
                                <input class="form-control" name="id" value="" id="id" type="tel">
                            </div>
                            @if(env('COUNTRY') != 'UAE')
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('عبارت جستجو')}}</label>
                                <input type="text" id="title" name="title" class="form-control" >
                            </div>
                            @endif
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('نوع ملک')}}</label>
                                <select class="form-select"  name="estate_type" id="estate_type"  >
                                    <option value="">{{l('انتخاب نوع ملک')}}</option>
                                    @foreach (estateTypes() as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if(($currentUser->isAdmin() || $currentUser->isExpert()) )
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('مشاور')}}</label>
                                <select class="form-control select2" name="user_id" id="user_id" style="width:100%">
                                    <option value="">{{l('همه املاک')}}</option>
                                    <option value="{{$currentUser->id}}">{{l('املاک خودم')}}</option>
                                    <option value="2">{{l('بدون مشاور')}}</option>
                                    @foreach($users as $item)
                                        <option value="{{$item->id}}">{{$item->fullname()}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if(env('COUNTRY') != 'UAE')
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{ l('نوع مشاور') }}</label>
                                <select class="form-control" name="expert_type" id="expert_type" style="width:100%">
                                    <option>&nbsp;</option>
                                    <option value="1">{{ l('مشاور اصلی') }}</option>
                                    <option value="2">{{ l('مشاور راهنما') }}</option>
                                </select>
                            </div>
                            @endif
                            @endif
                            @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch|expert') )
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label"> {{l('موبایل مالک')}}</label>
                                <input type="text" id="username" name="username" value=""
                                        class="form-control">
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label"> {{l('نام مالک')}}</label>
                                <input type="text" id="name" name="name" value=""
                                        class="form-control">
                            </div>
                            @endif
                            @if(env('COUNTRY') != 'UAE')
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('استان')}}</label>
                                <select class="form-control number select2" name="province_id" id="province_id" style="width:100%">
                                    <option value="" >{{l('انتخاب کنید')}}</option>
                                    @foreach($provinces as $item)
                                        <option value="{{$item->id}}"  {{$citySelected && $citySelected->province_id == $item->id?'selected':''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('شهر')}}</label>
                                <select class="form-control select2" name="city_id" id="city_id" style="width:100%">
                                    <option value="" >{{l('انتخاب کنید')}}</option>
                                    @foreach($citiesSelected as $item)
                                        <option value="{{$item->id}}" {{$citySelected && $citySelected->id == $item->id?'selected':''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 5)
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('منطقه')}}</label>
                                <select class="form-control select2 area_id" name="area_id" id="area_id" multiple style="width:100%">
                                    <option value="" >{{l('انتخاب کنید')}}</option>
                                    @for($i=1 ; $i<=$citySelected->count_area ; $i++)
                                        <option value="{{$i}}">منطقه {{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            @endif
                            <style>
                                .district .select2-container--default .select2-selection--multiple
                                {
                                    display:table;
                                    width:100%
                                }
                            </style>
                            <div class="col-md-12 col-lg-12 col-sm-12 mt-3 district">
                                <label class="form-label">{{l('محله')}}</label>
                                <select class="form-control select2 " name="district_id[]" id="district_id" multiple style="width:100%">
                                    <option value="" >{{l('انتخاب کنید')}}</option>
                                    @foreach($citySelected->districts as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if(env('COUNTRY') != 'UAE')
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="11,12" >
                                <label class="form-label">{{l('نام مجتمع')}}</label>
                                <input type="text" id="buildingname"   name="buildingname"
                                            class="form-control">
                            </div>
                            @endif
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 sale">
                                <label class="form-label" for="price_min">{{l('مبلغ از')}}</label>
                                <input type="text" id="minprice" name="minprice" dir="ltr"   onkeyup="SplitNumber($(this));"  class="form-control number text-left">
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 sale">
                                <label class="form-label sale" for="price_max"> {{l('مبلغ تا')}}</label>
                                <input type="text" id="maxprice" name="maxprice" dir="ltr"  onkeyup="SplitNumber($(this));"  class="form-control number text-left">
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="11,13,14,15">
                                <label  class="form-label" for="price_per_meter_min">{{l('قیمت متری از')}}</label>
                                <input type="text" id="minprice_per_meter" name="minprice_per_meter" dir="ltr"   onkeyup="SplitNumber($(this));"  class="form-control number text-left">
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="11,13,14,15">
                                <label class="form-label sale" for="price_per_meter_max"> {{l('قیمت متری تا')}}</label>
                                <input type="text" id="maxprice_per_meter" name="maxprice_per_meter" dir="ltr"  onkeyup="SplitNumber($(this));"  class="form-control number text-left">
                            </div>
                            {{--rent--}}
                            @if(env('COUNTRY') != 'UAE')
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 rent" style="display:none">
                                <label class="form-label">{{l('رهن از')}}</label>
                                <input type="text" id="minrahn"   onkeyup="SplitNumber($(this));"   name="minrahn"
                                            class="form-control number"
                                            style="direction : ltr">
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 rent" style="display:none">
                                <label class="form-label">{{l('رهن تا')}}</label>
                                <input type="text" id="maxrahn"   onkeyup="SplitNumber($(this));"   name="maxrahn"
                                            class="form-control number "
                                            style="direction : ltr">
                            </div>
                            @endif
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 rent" style="display:none">
                                <label class="form-label">{{l('اجاره از')}}</label>
                                <input type="text" id="minrent" name="minrent"   onkeyup="SplitNumber($(this));"   class="form-control number "
                                            style="direction : ltr">
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 rent" style="display:none">
                                <label class="form-label">{{l('اجاره تا')}}</label>
                                <input type="text" id="maxrent" name="maxrent"   onkeyup="SplitNumber($(this));"   class="form-control number "
                                            style="direction : ltr">
                            </div>
                            {{--end rent--}}
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label" for="areamin">{{l('مساحت از')}}</label>
                                <input type="text" id="areamin" name="areamin" class="form-control number "
                                        style="direction : ltr">
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label" for="areamax">{{l('مساحت تا')}} </label>
                                <input type="text" id="areamax" name="areamax" class="form-control number "
                                        style="direction : ltr">
                            </div>

                        @if(env('COUNTRY') != 'UAE')
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="12,13,14,22,23,24">
                                <label class="form-label">{{l('حداقل متراژ بر')}} </label>
                                <input type="text" id="front_area" name="front_area"
                                        class="form-control text-left number" value="">
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="12,14,22,24">
                                <label class="form-label">{{l('عرض گذر')}}</label>
                                <input type="text" id="street_width" name="street_width"
                                        class="form-control text-left number" value="">
                            </div>
                        @endif
                        @if(ss('SITE_ID') == 3)
                        <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="18">
                            <label  class="form-label" for="delivery_date_from">{{l('تاریخ تحویل از')}}</label>
                            <input type="text" name="delivery_date_from" id="delivery_date_from" onclick="Mh1PersianDatePicker.Show(this,'1402/05/01')" class="form-control text-muted pull-right">

                        </div>
                        <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="18">
                            <label  class="form-label" for="delivery_date_to">{{l('تاریخ تحویل تا')}}</label>
                            <input type="text" name="delivery_date_to" id="delivery_date_to" onclick="Mh1PersianDatePicker.Show(this,'1402/05/01')" class="form-control text-muted pull-right">
                        </div>
                        <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not"  access="11,18">
                            <div class="col-6 col-md-4 col-lg-2 col-sm-6 mt-4 ">
                                <input class="form-check-input unit_in_complex" type="checkbox" id="unit_in_complex" name="unit_in_complex" value="1">
                                <label class="form-check-label fs-sm" for="unit_in_complex">{{ l('واحد در مجتمع') }}</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not"  access="11,12,13,14,15,16">
                            <div class="col-6 col-md-4 col-lg-2 col-sm-6 mt-4 ">
                                <input class="form-check-input existing_document" type="checkbox" id="existing_document" name="existing_document" value="1">
                                <label class="form-check-label fs-sm" for="existing_document">{{ l('سند موجود') }}</label>
                            </div>
                        </div>
                        @endif
                        @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch|expert') )
                        @if(ss('SITE_ID') != 5)
                        {{--
                        <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="11">
                            <label class="form-label">{{ l('تعداد واحد تفکیکی') }}</label>
                            <input type="text" id="SeparateVilla" name="SeparateVilla"
                                    class="form-control text-left number" value="">
                        </div>
                        --}}
                        @endif
                        @endif
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="12,22,16,26">
                                <label class="form-label">{{l('زیربنا از')}}</label>
                                <input type="text" id="built_area_min" name="built_area_min"
                                    class="form-control text-left number" value="">
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="12,22,16,26">
                                <label class="form-label">{{l('زیربنا تا')}}</label>
                                <input type="text" id="built_area_max" name="built_area_max"
                                    class="form-control text-left number" value="">
                            </div>
                            @if(env('COUNTRY') != 'UAE')
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3  not" access="12,14">
                                <label >{{ l('حداقل تراکم ساخت') }}</label>
                                <input class="form-control" id="build_density"  name="build_density">
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{ l('حداقل عمر بنا') }}</label>
                                <input type="text" id="built_year_min" name="built_year_min"
                                        class="form-control text-left number" value="">
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{ l('حداکثر عمر بنا') }}</label>
                                <input type="text" id="built_year_max" name="built_year_max"
                                        class="form-control text-left number" value="">
                            </div>

                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('موقعیت جغرافیایی')}}</label>
                                <select class="form-select" name="geography" id="geography">
                                    <option value=""  ></option>
                                    <option value="113" >{{l('شمالی')}}</option>
                                    <option value="114" >{{l('جنوبی')}}</option>
                                    <option value="117" >{{l('دوبر')}}</option>
                                    <option value="118" >{{l('سه بر')}}</option>
                                    <option value="119" >{{l('چهاربر')}}</option>
                                    <option value="120" >{{l('دوکله')}}</option>
                                </select>
                            </div>
                            @endif


                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('حداقل تعداد اتاق')}}</label>
                                <select class="form-control select2" id="room_count" style="width:100%">
                                    <option></option>
                                    <option value="187">1</option>
                                    <option value="188">2</option>
                                    <option value="189">3</option>
                                    <option value="190">4</option>
                                    <option value="191">5</option>
                                </select>
                            </div>
                            @if(env('COUNTRY') != 'UAE')
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="11,12,13,14,15" id="sale-inputs">
                                <label  class="form-label">
                                    {{l('قابلیت معاوضه')}}
                                </label>
                                <select class="form-control"  name="exchange" id="exchange">
                                    <option value="" >{{l('انتخاب کنید')}}</option>
                                    <option value="0">{{l('ندارد')}}</option>
                                    <option value="1">{{l('دارد')}}</option>
                                </select>
                            </div>

                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not"  access="14"  id="sale-inputs">
                                <div class="col-6 col-md-4 col-lg-2 col-sm-6 mt-4 ">
                                    <input class="form-check-input build_license" type="checkbox" id="build_license" name="build_license" value="290">
                                    <label class="form-check-label fs-sm" for="build_license">{{ l('پروانه ساخت') }}</label>
                                </div>
                            </div>

                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('نوع کاربری')}}</label>
                                <select class="form-control" id="usage_type" style="width:100%">
                                    <option value="">{{ l('انتخاب نمایید') }}</option>
                                    @foreach (usage_type() as $key=>$val)
                                    <option value="{{$key}}" {{!empty($estate)?($estate->usage_type==$key ? 'selected':''):""}}>{{$val}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-sm-3 mb-3 not" access="11,12,13,14,15">
                                <label  class="form-label" for="ap-type-document">{{ l('نوع سند') }}</label>
                                <select class="form-control select2" id="document_type" name="document_type">
                                    <option value=""  selected></option>
                                    <option value="20" {{!empty($estate)?($estate->document_type==20?'selected':''):''}}>{{ l('شش دانگ') }}</option>
                                    <option value="21" {{!empty($estate)?($estate->document_type==21?'selected':''):''}}>{{ l('سرقفلی') }}</option>
                                    <option value="22" {{!empty($estate)?($estate->document_type==22?'selected':''):''}}>{{ l('مشاع') }}</option>
                                    <option value="23" {{!empty($estate)?($estate->document_type==23?'selected':''):''}}>{{ l('اوقافی') }}</option>
                                    <option value="24" {{!empty($estate)?($estate->document_type==24?'selected':''):''}}>{{ l('مسکن مهر') }}</option>
                                    <option value="25" {{!empty($estate)?($estate->document_type==25?'selected':''):''}}>{{ l('وکالتی') }}</option>
                                    <option value="26" {{!empty($estate)?($estate->document_type==26?'selected':''):''}}>{{ l('قولنامه ای') }}</option>
                                    <option value="28" {{!empty($estate)?($estate->document_type==28?'selected':''):''}}>{{ l('زمین شهری') }}</option>
                                    <option value="29" {{!empty($estate)?($estate->document_type==29?'selected':''):''}}>{{ l('شورایی') }}</option>
                                    <option value="30" {{!empty($estate)?($estate->document_type==30?'selected':''):''}}>{{ l('در دست اقدام') }}</option>
                                    @if(ss('SITE_ID') ==2)
                                    <option value="349" {{!empty($estate)?($estate->document_type==349?'selected':''):''}}>{{ l('نسخ') }}</option>
                                    <option value="350" {{!empty($estate)?($estate->document_type==350?'selected':''):''}}>{{ l('نسخ مادر') }}</option>
                                    @endif
                                </select>
                            </div>
                            @endif
                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <label class="form-label">{{l('وضعیت')}}</label>
                                <select class="form-select"  name="confirmation" id="confirmation"  >
                                    <option value="">{{l('همه')}}</option>
                                    @foreach (confirmStatuses() as  $key=>$val)
                                    <option  {{$key=='verified'?"selected":''}} value="{{$key}}">{{l($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                                <label class="form-label">{{l('وضعیت تائید ملک')}}</label>
                                <select class="form-select"  name="visibility" id="visibility">
                                    <option value="1">{{l('تائید شده')}}</option>
                                    <option value="0">{{l('تائید نشده')}}</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                                <label class="form-label">{{l('تعداد نمایش')}}</label>
                                <select class="form-control" id="pagesize" style="width:100%">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50" selected>50</option>
                                    <option value="100">100</option>
                                    <option value="150">150</option>
                                </select>
                            </div>
                        </div>
                        <div class="accordion my-4" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed bg-faded-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        {{l('جستجوی پیشرفته')}}
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse border-top" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                                <label class="form-label">{{l('سازنده')}}</label>
                                                <select class="form-select"  name="manufacturer_id" id="manufacturer_id" onchange="changeManufacturer()">
                                                    <option value="">{{l('انتخاب')}}</option>
                                                    @foreach ($manufacturers as $manufacturer)
                                                    <option value="{{$manufacturer->id}}">{{$manufacturer->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                                <label class="form-label">{{l('پروژه')}}</label>
                                                <select class="form-select"  name="project_id" id="project_id">
                                                    <option value="">{{l('انتخاب')}}</option>
                                                </select>
                                            </div>


                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="11,12,21,22">
                                                <label  class="form-label" for="ap-floors"> {{l('تعداد طبقات')}} </label>
                                                <select class="form-select" id="floor_count" name="floor_count" style="width: 100%">
                                                    <option value=""  selected>{{l('انتخاب')}} </option>
                                                    <option value="155" {{!empty($estate)?($estate->floor_count==155?'selected':''):''}}>1</option>
                                                    <option value="156" {{!empty($estate)?($estate->floor_count==156?'selected':''):''}}>2</option>
                                                    <option value="157" {{!empty($estate)?($estate->floor_count==157?'selected':''):''}}>3</option>
                                                    <option value="158" {{!empty($estate)?($estate->floor_count==158?'selected':''):''}}>4</option>
                                                    <option value="159" {{!empty($estate)?($estate->floor_count==159?'selected':''):''}}>5</option>
                                                    <option value="160" {{!empty($estate)?($estate->floor_count==160?'selected':''):''}}>6</option>
                                                    <option value="161" {{!empty($estate)?($estate->floor_count==161?'selected':''):''}}>7</option>
                                                    <option value="162" {{!empty($estate)?($estate->floor_count==162?'selected':''):''}}>8</option>
                                                    <option value="163" {{!empty($estate)?($estate->floor_count==163?'selected':''):''}}>9</option>
                                                    <option value="164" {{!empty($estate)?($estate->floor_count==164?'selected':''):''}}>10</option>
                                                    <option value="165" {{!empty($estate)?($estate->floor_count==165?'selected':''):''}}>11</option>
                                                    <option value="166" {{!empty($estate)?($estate->floor_count==166?'selected':''):''}}>12</option>
                                                    <option value="167" {{!empty($estate)?($estate->floor_count==167?'selected':''):''}}>13</option>
                                                    <option value="168" {{!empty($estate)?($estate->floor_count==168?'selected':''):''}}>14</option>
                                                    <option value="169" {{!empty($estate)?($estate->floor_count==169?'selected':''):''}}>15</option>
                                                    <option value="170" {{!empty($estate)?($estate->floor_count==170?'selected':''):''}}>16</option>
                                                    <option value="171" {{!empty($estate)?($estate->floor_count==171?'selected':''):''}}>17</option>
                                                    <option value="172" {{!empty($estate)?($estate->floor_count==172?'selected':''):''}}>18</option>
                                                    <option value="173" {{!empty($estate)?($estate->floor_count==173?'selected':''):''}}>19</option>
                                                    <option value="174" {{!empty($estate)?($estate->floor_count==174?'selected':''):''}}>20</option>
                                                    <option value="175" {{!empty($estate)?($estate->floor_count==175?'selected':''):''}}>21</option>
                                                    <option value="176" {{!empty($estate)?($estate->floor_count==176?'selected':''):''}}>22</option>
                                                    <option value="177" {{!empty($estate)?($estate->floor_count==177?'selected':''):''}}>23</option>
                                                    <option value="178" {{!empty($estate)?($estate->floor_count==178?'selected':''):''}}>24</option>
                                                    <option value="179" {{!empty($estate)?($estate->floor_count==179?'selected':''):''}}>25</option>
                                                    <option value="180" {{!empty($estate)?($estate->floor_count==180?'selected':''):''}}>26</option>
                                                    <option value="181" {{!empty($estate)?($estate->floor_count==181?'selected':''):''}}>27</option>
                                                    <option value="182" {{!empty($estate)?($estate->floor_count==182?'selected':''):''}}>28</option>
                                                    <option value="183" {{!empty($estate)?($estate->floor_count==183?'selected':''):''}}>29</option>
                                                    <option value="184" {{!empty($estate)?($estate->floor_count==184?'selected':''):''}}>30</option>
                                                    <option value="185" {{!empty($estate)?($estate->floor_count==185?'selected':''):''}}>{{l('بیشتر از')}} 30</option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="11,21">
                                                <label class="form-label"> {{l('شماره طبقه از')}}</label>
                                                <select class="form-select select2"   id="floor_min" name="floor_min" style="width: 100%">
                                                    <option value="" selected>{{l('انتخاب')}} </option>
                                                    <option title="{{ l('طبقه') }}" value="121" {{!empty($estate)?($estate->floor==121?'selected':''):''}}>{{l('زیر همکف')}}</option>
                                                    <option title="{{ l('طبقه') }}" value="122" {{!empty($estate)?($estate->floor==122?'selected':''):''}}>{{l('همکف')}}</option>
                                                    <option title="{{ l('طبقه') }}" value="123" {{!empty($estate)?($estate->floor==123?'selected':''):''}}>1</option>
                                                    <option title="{{ l('طبقه') }}" value="124" {{!empty($estate)?($estate->floor==124?'selected':''):''}}>2</option>
                                                    <option title="{{ l('طبقه') }}" value="125" {{!empty($estate)?($estate->floor==125?'selected':''):''}}>3</option>
                                                    <option title="{{ l('طبقه') }}" value="126" {{!empty($estate)?($estate->floor==126?'selected':''):''}}>4</option>
                                                    <option title="{{ l('طبقه') }}" value="127" {{!empty($estate)?($estate->floor==127?'selected':''):''}}>5</option>
                                                    <option title="{{ l('طبقه') }}" value="128" {{!empty($estate)?($estate->floor==128?'selected':''):''}}>6</option>
                                                    <option title="{{ l('طبقه') }}" value="129" {{!empty($estate)?($estate->floor==129?'selected':''):''}}>7</option>
                                                    <option title="{{ l('طبقه') }}" value="130" {{!empty($estate)?($estate->floor==130?'selected':''):''}}>8</option>
                                                    <option title="{{ l('طبقه') }}" value="131" {{!empty($estate)?($estate->floor==131?'selected':''):''}}>9</option>
                                                    <option title="{{ l('طبقه') }}" value="132" {{!empty($estate)?($estate->floor==132?'selected':''):''}}>10</option>
                                                    <option title="{{ l('طبقه') }}" value="133" {{!empty($estate)?($estate->floor==133?'selected':''):''}}>11</option>
                                                    <option title="{{ l('طبقه') }}" value="134" {{!empty($estate)?($estate->floor==134?'selected':''):''}}>12</option>
                                                    <option title="{{ l('طبقه') }}" value="135" {{!empty($estate)?($estate->floor==135?'selected':''):''}}>13</option>
                                                    <option title="{{ l('طبقه') }}" value="136" {{!empty($estate)?($estate->floor==136?'selected':''):''}}>14</option>
                                                    <option title="{{ l('طبقه') }}" value="137" {{!empty($estate)?($estate->floor==137?'selected':''):''}}>15</option>
                                                    <option title="{{ l('طبقه') }}" value="138" {{!empty($estate)?($estate->floor==138?'selected':''):''}}>16</option>
                                                    <option title="{{ l('طبقه') }}" value="139" {{!empty($estate)?($estate->floor==139?'selected':''):''}}>17</option>
                                                    <option title="{{ l('طبقه') }}" value="140" {{!empty($estate)?($estate->floor==140?'selected':''):''}}>18</option>
                                                    <option title="{{ l('طبقه') }}" value="141" {{!empty($estate)?($estate->floor==141?'selected':''):''}}>19</option>
                                                    <option title="{{ l('طبقه') }}" value="142" {{!empty($estate)?($estate->floor==142?'selected':''):''}}>20</option>
                                                    <option title="{{ l('طبقه') }}" value="143" {{!empty($estate)?($estate->floor==143?'selected':''):''}}>21</option>
                                                    <option title="{{ l('طبقه') }}" value="144" {{!empty($estate)?($estate->floor==144?'selected':''):''}}>22</option>
                                                    <option title="{{ l('طبقه') }}" value="145" {{!empty($estate)?($estate->floor==145?'selected':''):''}}>23</option>
                                                    <option title="{{ l('طبقه') }}" value="146" {{!empty($estate)?($estate->floor==146?'selected':''):''}}>24</option>
                                                    <option title="{{ l('طبقه') }}" value="147" {{!empty($estate)?($estate->floor==147?'selected':''):''}}>25</option>
                                                    <option title="{{ l('طبقه') }}" value="148" {{!empty($estate)?($estate->floor==148?'selected':''):''}}>26</option>
                                                    <option title="{{ l('طبقه') }}" value="149" {{!empty($estate)?($estate->floor==149?'selected':''):''}}>27</option>
                                                    <option title="{{ l('طبقه') }}" value="150" {{!empty($estate)?($estate->floor==150?'selected':''):''}}>28</option>
                                                    <option title="{{ l('طبقه') }}" value="151" {{!empty($estate)?($estate->floor==151?'selected':''):''}}>29</option>
                                                    <option title="{{ l('طبقه') }}" value="152" {{!empty($estate)?($estate->floor==152?'selected':''):''}}>30</option>
                                                    <option title="{{ l('طبقه') }}" value="153" {{!empty($estate)?($estate->floor==153?'selected':''):''}}> {{l('بیشتر از')}}30</option>
                                                    <option title="{{ l('طبقه') }}" value="154" {{!empty($estate)?($estate->floor==154?'selected':''):''}}>{{l('پنت هاوس')}} </option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3  not" access="11,21" >
                                                <label class="form-label">{{l('شماره طبقه تا')}}</label>
                                                <select class="form-select select2"   id="floor_max" name="floor_max" style="width: 100%">
                                                    <option value="" selected>{{l('انتخاب')}} </option>
                                                    <option title="{{ l('طبقه') }}" value="121" {{!empty($estate)?($estate->floor==121?'selected':''):''}}>{{l('زیر همکف')}}</option>
                                                    <option title="{{ l('طبقه') }}" value="122" {{!empty($estate)?($estate->floor==122?'selected':''):''}}>{{l('همکف')}}</option>
                                                    <option title="{{ l('طبقه') }}" value="123" {{!empty($estate)?($estate->floor==123?'selected':''):''}}>1</option>
                                                    <option title="{{ l('طبقه') }}" value="124" {{!empty($estate)?($estate->floor==124?'selected':''):''}}>2</option>
                                                    <option title="{{ l('طبقه') }}" value="125" {{!empty($estate)?($estate->floor==125?'selected':''):''}}>3</option>
                                                    <option title="{{ l('طبقه') }}" value="126" {{!empty($estate)?($estate->floor==126?'selected':''):''}}>4</option>
                                                    <option title="{{ l('طبقه') }}" value="127" {{!empty($estate)?($estate->floor==127?'selected':''):''}}>5</option>
                                                    <option title="{{ l('طبقه') }}" value="128" {{!empty($estate)?($estate->floor==128?'selected':''):''}}>6</option>
                                                    <option title="{{ l('طبقه') }}" value="129" {{!empty($estate)?($estate->floor==129?'selected':''):''}}>7</option>
                                                    <option title="{{ l('طبقه') }}" value="130" {{!empty($estate)?($estate->floor==130?'selected':''):''}}>8</option>
                                                    <option title="{{ l('طبقه') }}" value="131" {{!empty($estate)?($estate->floor==131?'selected':''):''}}>9</option>
                                                    <option title="{{ l('طبقه') }}" value="132" {{!empty($estate)?($estate->floor==132?'selected':''):''}}>10</option>
                                                    <option title="{{ l('طبقه') }}" value="133" {{!empty($estate)?($estate->floor==133?'selected':''):''}}>11</option>
                                                    <option title="{{ l('طبقه') }}" value="134" {{!empty($estate)?($estate->floor==134?'selected':''):''}}>12</option>
                                                    <option title="{{ l('طبقه') }}" value="135" {{!empty($estate)?($estate->floor==135?'selected':''):''}}>13</option>
                                                    <option title="{{ l('طبقه') }}" value="136" {{!empty($estate)?($estate->floor==136?'selected':''):''}}>14</option>
                                                    <option title="{{ l('طبقه') }}" value="137" {{!empty($estate)?($estate->floor==137?'selected':''):''}}>15</option>
                                                    <option title="{{ l('طبقه') }}" value="138" {{!empty($estate)?($estate->floor==138?'selected':''):''}}>16</option>
                                                    <option title="{{ l('طبقه') }}" value="139" {{!empty($estate)?($estate->floor==139?'selected':''):''}}>17</option>
                                                    <option title="{{ l('طبقه') }}" value="140" {{!empty($estate)?($estate->floor==140?'selected':''):''}}>18</option>
                                                    <option title="{{ l('طبقه') }}" value="141" {{!empty($estate)?($estate->floor==141?'selected':''):''}}>19</option>
                                                    <option title="{{ l('طبقه') }}" value="142" {{!empty($estate)?($estate->floor==142?'selected':''):''}}>20</option>
                                                    <option title="{{ l('طبقه') }}" value="143" {{!empty($estate)?($estate->floor==143?'selected':''):''}}>21</option>
                                                    <option title="{{ l('طبقه') }}" value="144" {{!empty($estate)?($estate->floor==144?'selected':''):''}}>22</option>
                                                    <option title="{{ l('طبقه') }}" value="145" {{!empty($estate)?($estate->floor==145?'selected':''):''}}>23</option>
                                                    <option title="{{ l('طبقه') }}" value="146" {{!empty($estate)?($estate->floor==146?'selected':''):''}}>24</option>
                                                    <option title="{{ l('طبقه') }}" value="147" {{!empty($estate)?($estate->floor==147?'selected':''):''}}>25</option>
                                                    <option title="{{ l('طبقه') }}" value="148" {{!empty($estate)?($estate->floor==148?'selected':''):''}}>26</option>
                                                    <option title="{{ l('طبقه') }}" value="149" {{!empty($estate)?($estate->floor==149?'selected':''):''}}>27</option>
                                                    <option title="{{ l('طبقه') }}" value="150" {{!empty($estate)?($estate->floor==150?'selected':''):''}}>28</option>
                                                    <option title="{{ l('طبقه') }}" value="151" {{!empty($estate)?($estate->floor==151?'selected':''):''}}>29</option>
                                                    <option title="{{ l('طبقه') }}" value="152" {{!empty($estate)?($estate->floor==152?'selected':''):''}}>30</option>
                                                    <option title="{{ l('طبقه') }}" value="153" {{!empty($estate)?($estate->floor==153?'selected':''):''}}> {{l('بیشتر از')}}30</option>
                                                    <option title="{{ l('طبقه') }}" value="154" {{!empty($estate)?($estate->floor==154?'selected':''):''}}>{{l('پنت هاوس')}} </option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="11,21" >
                                                <label class="form-label">{{l('تعداد واحد در طبقه')}}</label>
                                                <select class="form-select " id="unit_in_floor"  name="unit_in_floor" style="width: 100%">
                                                    <option value="" selected>{{l('انتخاب')}} </option>
                                                    <option title="{{ l('واحد در طبقه') }}" value="305">{{ l('حداکثر یک واحد') }}</option>
                                                    <option title="{{ l('واحد در طبقه') }}" value="306">{{ l('حداکثر دو واحد') }}</option>
                                                    <option title="{{ l('واحد در طبقه') }}" value="307">{{ l('حداکثر سه واحد') }}</option>

                                                </select>
                                            </div>

                                            <!--
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3  not" access="11,12,21,22,23,13">
                                                <label class="form-label">{{l('وضعیت سکونت')}}</label>
                                                <select id="residence_type" name="residence_type" class="form-control select2"
                                                        style="width: 100%">
                                                    <option value="" selected>{{l('انتخاب کنید')}}</option>
                                                    @foreach(residenceTypes() as $k=>$v)
                                                        <option value="{{$k}}">{{l($v)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        -->
                                        </div>
                                        @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch|expert') )
                                        <div class="row">
                                            @if (env('COUNTRY') == 'UAE')
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 ">
                                                <label  class="form-label">{{l('تاریخ ایجاد از')}}</label>
                                                <input type="text" name="create_date_of" id="create_date_of" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ ایجاد از')}}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 ">
                                                <label  class="form-label">{{l('تاریخ ایجاد تا')}}</label>
                                                <input type="text" name="create_date_to" id="create_date_to" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ ایجاد از')}}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                                            </div>

                                            @else
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 ">
                                                <label  class="form-label">{{l('تاریخ ایجاد از')}}</label>
                                                <input type="text" name="create_date_of" id="create_date_of" onclick="Mh1PersianDatePicker.Show(this,'1402/05/01')" class="form-control text-muted pull-right">
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 ">
                                                <label  class="form-label">{{l('تاریخ ایجاد تا')}}</label>
                                                <input type="text" name="create_date_to" id="create_date_to" onclick="Mh1PersianDatePicker.Show(this,'1402/05/01')" class="form-control text-muted pull-right">
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 ">
                                                <label  class="form-label">{{l('تاریخ بروزرسانی از')}}</label>
                                                <input type="text" name="show_date_of" id="show_date_of" onclick="Mh1PersianDatePicker.Show(this,'1402/05/01')" class="form-control text-muted pull-right">
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 ">
                                                <label  class="form-label">{{l('تاریخ بروزرسانی تا')}}</label>
                                                <input type="text" name="show_date_to" id="show_date_to" onclick="Mh1PersianDatePicker.Show(this,'1402/05/01')" class="form-control text-muted pull-right">
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                        @if(env('COUNTRY') != 'UAE')
                                        <div class="row">
                                            <!--div class="col-6 mt-3">
                                                <div>{{l('آدرس')}}</div>
                                                <input type="text" id="address" name="address" class=" form-control">
                                            </div-->
                                            <div class="col-md-2 col-lg-4 col-sm-12 mt-3">
                                                <label class="">{{ l('آگهی دیوار') }}</label>
                                                <select id="divar" name="divar" class="form-control">
                                                    <option value="">{{ l('همه موارد') }}</option>
                                                    <option value="1">{{ l('ملکهای دیوار') }}</option>
                                                    <option value="2">{{ l('غیر از ملکهای دیوار') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 ">
                                                <input class="form-check-input photo" type="checkbox" id="photo" nama="photo" value="1">
                                                <label class="form-label form-check-label fs-sm" for="photo">{{l('دارای عکس')}}</label>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 " >
                                                <input class="form-check-input video" type="checkbox" id="video" nama="video" value="1">
                                                <label class="form-label form-check-label fs-sm" for="video">{{l('دارای فیلم')}}</label>
                                            </div>
                                            @if(env('COUNTRY') != 'UAE')
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 " >
                                                <input class="form-check-input vr1" type="checkbox" id="vr" nama="vr" value="1" @if(app('request')->input('vr')) checked @endif>
                                                <label class="form-check-label fs-sm" for="vr1">{{ l('دارای تور مجازی') }}</label>
                                            </div>
                                            @endif
                                            @if(ss('SITE_ID') == 5)
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3">
                                                <input class="form-check-input" type="checkbox" id="urgent" name="urgent" value="1">
                                                <label class="form-check-label fs-sm" for="urgent">{{ l('ملک ویژه(فوری)') }}</label>
                                            </div>
                                            @endif
                                            @if(env('COUNTRY') != 'UAE')
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3  not" access="11,12,13,15,21,22,23,25">
                                                <input class="form-check-input facilities" type="checkbox" id="facilities352"  name="facilities[]" value="352">
                                                <label class="form-check-label fs-sm" for="facilities352">{{l('دربست')}}</label>
                                            </div>
                                            @endif
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="22">
                                                <input class="form-check-input" type="checkbox" id="keynot" name="keynot" value="1">
                                                <label class="form-check-label fs-sm" for="keynot">{{l('کلید نخورده')}}</label>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="11,12,13,14,15">
                                                <input class="form-check-input condition" type="checkbox" id="condition15" name="condition[]" value="15">
                                                <label class="form-check-label fs-sm" for="condition15">{{l('پیش فروش')}}</label>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-3 not" access="11,12,13,14,15">
                                                <input class="form-check-input  condition" id="js_FacitiiesFull"  value="348" type="checkbox" name="condition[]">
                                                <label class="form-label" for="conditions348">
                                                    {{l('فول امکانات')}}
                                                </label>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center my-4 ">
                            <button id="form_search" class="btn btn-primary">
                                {{l('جستجو')}}
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                </form>
                <a name="content"></a>
                <div class="tab-content1" id="state">
                </div>
                <nav class="pt-4 pb-2 border-top" aria-label="Blog pagination" id="pagination">
                </nav>
            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script src="/frontend/js/paging.js"></script>
<script src="/admin2/dist/js/regions.js"></script>
<link rel="stylesheet" href="/assets/css/sweetalert.css" />
<script src="/assets/js/sweetalert.min.js"></script>
<script>

    getCities();
    getAreas();
    getDistricts();
    getAreaDistrict();
    function ladder(id) {
        $.get("/estates/ladder/" + id, function(data, status) {
            swal({
                title:"{{l('ملک با موفقیت نردبان شد')}}",
                text: "",
                type: 'success',
                allowOutsideClick: false,
            });
            pagin = 1;
            $("#pagination").html("");
            CheckSend();
        });
    };
    function archived(id) {
        $.get("/estates/archived/" + id, function(data, status) {
            swal({
                title:"{{l('ملک با موفقیت آرشیو شد')}}",
                text: "",
                type: 'success',
                allowOutsideClick: false,
            });
            pagin = 1;
            CheckSend();
        });
    };
    function verified(id) {
        $.get("/estates/verified/" + id, function(data, status) {
            swal({
                title:"{{l('ملک با موفقیت از آرشیو خارج شد')}}",
                text: "",
                type: 'success',
                allowOutsideClick: false,
            });
            pagin = 1;
            CheckSend();
        });
    };
    function setVisible(id) {
        $.get("/estates/visible/" + id, function(data, status) {
            swal({
                title:"{{l('ملک با موفقیت تائید شد')}}",
                text: "",
                type: 'success',
                allowOutsideClick: false,
            });
            pagin = 1;
            CheckSend();
        });
    };

    function changeManufacturer() {
        $("select#project_id").html('<option value="" >Select</option>');
        var id = $('#manufacturer_id').val();
        $.get("/estate/projects/"+id, function (data, status) {
            if (data.status) {
                //$('select#project_id').append('<option value="" >Select</option>');
                $.each(data.result, function (i, item) {
                    $('select#project_id').append($('<option>', {
                        value: i,
                        text: item
                    }));
                });

            }
        });
    }
    $('#request_type').change(function(){
        changeaccess();
        if($(this).val()==1)
            {
                $(".sale").show();
                $(".rent").hide();
            }
            else if($(this).val()==2)
            {
                $(".rent").show();
                $(".sale").hide();
            }
    });
    function seluserid(id)
    {

        $('#user_id').val(id);
        $('.buser').removeClass('active');
        if(id == '')
        {
            $('.buser0').addClass('active');
        }
        else
        {
            $('.buser'+id).addClass('active');
        }
        str = "";
        CheckSend();
    }

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });

    function CheckSend()
    {
        var sr = "";
        var estatetype=$('#estate_type').val();
        var rtype=$('#request_type').val();
        var myexpert=$('#myexpert:checked').val();
        sr += (typeof myexpert!=='undefined' && myexpert  == 1) ? "myexpert=1&" : "";

        sr += (typeof $('#confirmation').val()!=='undefined' && $('#confirmation').val() != '') ? "confirmation=" + $('#confirmation').val() + "&" : "";
        sr += (typeof $('#floor_start').val()!=='undefined' && $('#floor_start').val() != '') ? "floor_start=" + $('#floor_start').val() + "&" : "";
        sr +=(typeof $('#geography').val()!=='undefined' &&  $('#geography').val()) > 0 ? "geography=" + $('#geography').val() + "&" : "";
        sr +=(typeof $('#build_density').val()!=='undefined' &&  $('#build_density').val() > 0) ? "build_density=" + $('#build_density').val() + "&" : "";
        sr +=(typeof $('#SeparateVilla').val()!=='undefined' &&  $('#SeparateVilla').val() > 0 )? "SeparateVilla=" + $('#SeparateVilla').val() + "&" : "";
        sr+=(typeof balconmetraj!=='undefined' &&  balconmetraj>0) ? "balconmetraj=" + balconmetraj + "&" : "";
        sr+=(typeof undermetraj!=='undefined' &&  undermetraj>0) ? "undermetraj=" + undermetraj + "&" : "";
        var onebuilding1=$('input[name = "onebuilding"]:checked').val();
        sr+=(typeof onebuilding1!=='undefined' &&  onebuilding1>0) ? "onebuilding=" + onebuilding1 + "&" : "";
        var urgent1=$('input[name = "urgent"]:checked').val();
        sr+=(typeof urgent1!=='undefined' &&  urgent1>0) ? "urgent=" + urgent1 + "&" : "";
        var keynot=$('input[name = "keynot"]:checked').val();
        sr +=(typeof keynot!=='undefined' &&  keynot>0) ? "keynot=" + keynot + "&" : "";
        sr +=(typeof $('#built_area_min').val()!=='undefined' &&  $('#built_area_min').val()) > 0 ? "built_area_min=" + $('#built_area_min').val() + "&" : "";
        sr +=(typeof $('#built_area_max').val()!=='undefined' &&  $('#built_area_max').val()) > 0 ? "built_area_max=" + $('#built_area_max').val() + "&" : "";
        sr +=(typeof $('#built_year_min').val()!=='undefined' &&  $('#built_year_min').val()) > 0 ? "built_year_min=" + $('#built_year_min').val() + "&" : "";
        sr +=(typeof $('#built_year_max').val()!=='undefined' &&  $('#built_year_max').val()) > 0 ? "built_year_max=" + $('#built_year_max').val() + "&" : "";
        sr += (typeof $('#province_id').val()!=='undefined' && $('#province_id').val()>0) ? "province_id=" + $('#province_id').val() + "&" : "";
        sr += (typeof $('#city_id').val()!=='undefined' && $('#city_id').val()>0) ? "city_id=" + $('#city_id').val() + "&" : "";
        sr += (typeof rtype!=='undefined' && rtype > 0) ? "type=" +rtype + "&" : "";
        sr += (estatetype!=='undefined' && estatetype > 0) ? "estateTypes=" +estatetype + "&" : "";
        sr += (typeof $('#areamin').val()!=='undefined' && $('#areamin').val().length  > 0) ? "minArea=" + $('#areamin').val() + "&" : "";
        sr += (typeof $('#id').val()!=='undefined' && $('#id').val().length > 0) ? "id=" + $('#id').val() + "&" : "";
        sr += (typeof $('#areamax').val()!=='undefined' && $('#areamax').val().length > 0) ? "maxArea=" + $('#areamax').val() + "&" : "";
        sr +=(typeof $('#district_id').val()!=='undefined' && $('#district_id').val().length>0) ? "districts=" + $('#district_id').val() + "&" : "";
        sr +=(typeof  $('#area_id').val()!=='undefined' && $('#area_id').val()>0) ? "area=" + $('#area_id').val() + "&" : "";
        sr += (typeof $('#username').val()!=='undefined' && $('#username').val() != '') ? "username=" + $('#username').val() + "&" : "";
        sr+=(typeof $('#user_id').val()!=='undefined' && $('#user_id').val()>0)?"user_id="+$("#user_id").val()+"&":"";
        sr+=(typeof $('#expert_type').val()!=='undefined' && $('#expert_type').val()>0)?"expert_type="+$("#expert_type").val()+"&":"";
        sr+=(typeof $('#street_width').val()!=='undefined' && $('#street_width').val()>0)?"street_width="+$("#street_width").val()+"&":"";
        sr+=(typeof $('#position_type').val()!=='undefined' && $('#position_type').val()>0)?"position_type="+$("#position_type").val()+"&":"";
        sr+=(typeof $('#room_count').val()!=='undefined' && $('#room_count').val()>0)?"room_count="+$("#room_count").val()+"&":"";
        sr+=(typeof $('#favorite').val()!=='undefined' && $('#favorite').val()>0)?"favorite="+$("#favorite").val()+"&":"";
        sr+=(typeof $('#name').val()!=='undefined' && $('#name').val().length>0)?"name="+$("#name").val()+"&":"";
        sr+=(typeof $('#divar').val()!=='undefined' && $('#divar').val()>0) ? "divar="+$('#divar').val()+"&" : "";
        sr+=(typeof $('#visibility').val()!=='undefined') ? "visibility="+$('#visibility').val()+"&" : "";
        sr+=(typeof $('#usage_type').val()!=='undefined' && $('#usage_type').val()>0) ? "usage_type="+$('#usage_type').val()+"&" : "";
        sr+=(typeof $('#floor_min').val()!=='undefined' && $('#floor_min').val()>0) ? "floor_min="+$('#floor_min').val()+"&" : "";
        sr+=(typeof $('#floor_max').val()!=='undefined' && $('#floor_max').val()>0) ? "floor_max="+$('#floor_max').val()+"&" : "";
        sr+=(typeof $('#unit_in_floor').val()!=='undefined' && $('#unit_in_floor').val()>0) ? "unit_in_floor="+$('#unit_in_floor').val()+"&" : "";
        sr+=(typeof $('#title').val()!=='undefined' && $('#title').val()!= '') ? "title="+$('#title').val()+"&" : "";
        sr+=(typeof $('#document_type').val()!=='undefined' && $('#document_type').val()>0) ? "document_type="+$('#document_type').val()+"&" : "";
        sr+=(typeof $('#exchange').val()!=='undefined' && $('#exchange').val()>0) ? "exchange="+$('#exchange').val()+"&" : "";
        sr += (typeof $('#buildingname').val()!=='undefined' && $('#buildingname').val() != '') ? "buildingname=" + $('#buildingname').val() + "&" : "";
        sr += (typeof $('#show_date_of').val()!=='undefined' && $('#show_date_of').val() != '') ? "show_date_of=" + $('#show_date_of').val() + "&" : "";
        sr += (typeof $('#show_date_to').val()!=='undefined' && $('#show_date_to').val() != '') ? "show_date_to=" + $('#show_date_to').val() + "&" : "";
        sr += (typeof $('#create_date_of').val()!=='undefined' && $('#create_date_of').val() != '') ? "create_date_of=" + $('#create_date_of').val() + "&" : "";
        sr += (typeof $('#create_date_to').val()!=='undefined' && $('#create_date_to').val() != '') ? "create_date_to=" + $('#create_date_to').val() + "&" : "";
        sr += ($('#money_paid').val() != undefined && $('#money_paid').val().length > 0 )? "money_paid=" + ($('#money_paid').val().length>0?$('#money_paid').val().replace(/[^0-9]/g, ""):0) : "";
        sr+=(typeof $('#construction_status').val()!=='undefined' && $('#construction_status').val()>0) ? "construction_status="+$('#construction_status').val()+"&" : "";
        sr += (typeof $('#delivery_date_from').val()!=='undefined' && $('#delivery_date_from').val() != '') ? "delivery_date_from=" + $('#delivery_date_from').val() + "&" : "";
        sr += (typeof $('#delivery_date_to').val()!=='undefined' && $('#delivery_date_to').val() != '') ? "delivery_date_to=" + $('#delivery_date_to').val() + "&" : "";

        sr += (typeof $('#manufacturer_id').val()!=='undefined' && $('#manufacturer_id').val() != '') ? "manufacturer_id=" + $('#manufacturer_id').val() + "&" : "";
        sr += (typeof $('#project_id').val()!=='undefined' && $('#project_id').val() != '') ? "project_id=" + $('#project_id').val() + "&" : "";
        var unit_in_complex=$('input[name = "unit_in_complex"]:checked').val();
        sr +=(typeof unit_in_complex!=='undefined' &&  unit_in_complex>0) ? "unit_in_complex=" + unit_in_complex + "&" : "";
        var existing_document=$('input[name = "existing_document"]:checked').val();
        sr +=(typeof existing_document!=='undefined' &&  existing_document>0) ? "existing_document=" + existing_document + "&" : "";
        if(typeof $('#pagesize').val()!=='undefined' && $('#pagesize').val() != '')
        {
            sr+= "pagesize="+$('#pagesize').val()+"&";
        }
        else
        {
            sr+= "pagesize=10&";
        }
        var codition=[];
        var facilities=[];
        $(".condition").each(function()
        {
            //console.log($(this).val());
            if($(this).is(':checked')){
                codition.push($(this).val());
            }
        });
        $(".balconmetraj2").each(function() {
            if($(this).is(':checked')){
                sr+="balconmetraj="+$(this).val()+"&";
            }
        });
        $(".undermetraj2").each(function() {
            if($(this).is(':checked')){
                sr+="undermetraj="+$(this).val()+"&";
            }
        });
        $(".photo").each(function() {
            if($(this).is(':checked')){
                sr+="photo="+$(this).val()+"&";
            }
        });
        $(".video").each(function() {
            if($(this).is(':checked')){
                sr+="video="+$(this).val()+"&";
            }
        });
        if($("#build_license").is(':checked'))
        {
            sr+="build_license="+$('#build_license').val()+"&";
        };
        $("#vr").each(function() {
            if($(this).is(':checked')){
                sr+="vr="+$(this).val()+"&";
            }
        });
        sr +=codition.length>0?"conditions="+codition+"&":""
        $(".facilities").each(function() {
            //console.log($(this).val());
            if($(this).is(':checked')){
                facilities.push($(this).val());
            }
        });
        sr +=facilities.length>0?"facilities="+facilities+"&":""
        if(rtype == 1){
            sr+=($('#minprice').val().length > 0 || $('#maxprice').val().length > 0)?("price=" + ($('#minprice').val().length>0?$('#minprice').val().replace(/[^0-9]/g, ""):0)+","+($('#maxprice').val().replace(/[^0-9]/g, "")) +"&"): "";
            sr+=($('#minprice_per_meter').val().length > 0 || $('#maxprice_per_meter').val().length > 0)?("price_per_meter=" + ($('#minprice_per_meter').val().length>0?$('#minprice_per_meter').val().replace(/[^0-9]/g, ""):0)+","+($('#maxprice_per_meter').val().replace(/[^0-9]/g, "")) +"&"): "";
        }
        else
        {
            @if(env('COUNTRY') != 'UAE')
            sr +=(($('#minrahn').val() != undefined && $('#minrahn').val().length > 0) || ($('#maxrahn').val() != undefined && $('#maxrahn').val().length > 0))?("mortgage=" + ($('#minrahn').val().length>0?$('#minrahn').val().replace(/[^0-9]/g, ""):0)+","+($('#maxrahn').val().replace(/[^0-9]/g, "")) +"&"): "";
            @endif
            sr +=(($('#minrent').val() != undefined && $('#minrent').val().length > 0) || ($('#maxrent').val() != undefined && $('#maxrent').val().length > 0))?("rent=" + ($('#minrent').val().length>0?$('#minrent').val().replace(/[^0-9]/g, ""):0)+","+($('#maxrent').val().replace(/[^0-9]/g, "")) +"&"): "";
        }
        sr+= "order="+$("#order").val()+"&";
        sr+= "orderby="+$("#orderby").val()+"&";
        @if(ss('SITE_ID') == 3 && $currentUser->isExpert())
        SetMapCluster(sr);
        @endif
        loadMoreData(1,sr)
    }
    "use strict";var delimiter=l("و"),zero=l("صفر"),negative=l("منفی"),letters=[["",l("یک"),l("دو"),l("سه"),l("چهار"),l("پنج"),l("شش"),l("هفت"),l("هشت"),l("نه")],["ده",l("یازده"),l("دوازده"),l("سیزده"),l("چهارده"),l("پانزده"),l("شانزده"),l("هفده"),l("هجده"),l("نوزده"),l("بیست")],["","",l("بیست"),l("سی"),l("چهل"),l("پنجاه"),l("شصت"),l("هفتاد"),l("هشتاد"),l("نود")],["",l("یکصد"),l("دویست"),l("سیصد"),l("چهارصد"),l("پانصد"),l("ششصد"),l("هفتصد"),l("هشتصد"),l("نهصد")],["",l("هزار"),l("میلیون"),l("میلیارد"),l("بیلیون"),l("بیلیارد"),l("تریلیون"),l("تریلیارد"),l("کوآدریلیون"),l("کادریلیارد"),l("کوینتیلیون"),l("کوانتینیارد"),l("سکستیلیون"),l("سکستیلیارد"),l("سپتیلیون"),l("سپتیلیارد"),l("اکتیلیون"),l("اکتیلیارد"),l("نانیلیون"),l("نانیلیارد"),l("دسیلیون"),l("دسیلیارد")]],decimalSuffixes=["",l("دهم"),l("صدم"),l("هزارم"),l("ده‌هزارم"),l("صد‌هزارم"),l("میلیونوم"),l("ده‌میلیونوم"),l("صدمیلیونوم"),l("میلیاردم"),l("ده‌میلیاردم"),l("صد‌‌میلیاردم")],prepareNumber=function(e){var t=e;return"number"==typeof t&&(t=t.toString()),t.length%3==1?t="00".concat(t):t.length%3==2&&(t="0".concat(t)),t.replace(/\d{3}(?=\d)/g,"$&*").split("*")},tinyNumToWord=function(e){if(0===parseInt(e,0))return"";var t=parseInt(e,0);if(t<10)return letters[0][t];if(t<=20)return letters[1][t-10];if(t<100){var r=t%10,n=(t-r)/10;return r>0?letters[2][n]+delimiter+letters[0][r]:letters[2][n]}var i=t%10,u=(t-t%100)/100,s=(t-(100*u+i))/10,a=[letters[3][u]],o=10*s+i;return 0===o?a.join(delimiter):(o<10?a.push(letters[0][o]):o<=20?a.push(letters[1][o-10]):(a.push(letters[2][s]),i>0&&a.push(letters[0][i])),a.join(delimiter))},convertDecimalPart=function(e){return""===(e=e.replace(/0*$/,""))?"":(e.length>11&&(e=e.substr(0,11)),l("ممیز")+Num2persian(e)+" "+decimalSuffixes[e.length])},Num2persian=function(e){e=e.toString().replace(/[^0-9.-]/g,"");var t=!1,r=parseFloat(e);if(isNaN(r))return zero;if(0===r)return zero;r<0&&(t=!0,e=e.replace(/-/g,""));var n="",i=e,u=e.indexOf(".");if(u>-1&&(i=e.substring(0,u),n=e.substring(u+1,e.length)),i.length>66)return"خارج از محدوده";for(var s=prepareNumber(i),a=[],o=0;o<s.length;o+=1){var l=tinyNumToWord(s[o]);""!==l&&a.push(l+letters[4][s.length-(o+1)])}return n.length>0&&(n=convertDecimalPart(n)),(t?negative:"")+a.join(delimiter)+n};String.prototype.toPersianLetter=function(){return Num2persian(this)},Number.prototype.toPersianLetter=function(){return Num2persian(parseFloat(this).toString())},String.prototype.num2persian=function(){return Num2persian(this)},Number.prototype.num2persian=function(){return Num2persian(parseFloat(this).toString())};
    function SplitNumber(obj){
        var Getnumber= toEnglishNumber(obj.val()).replace(/,/g,'');
        obj.val(Getnumber.split("").reverse().join("").replace(/(.{3}\B)/g, "$1,").split("").reverse().join(""));
        obj.parent().parent().find("#divprice").html(obj.val().num2persian()+" تومان");
    }
    window.SplitNumber=SplitNumber;
    function sort(type)
    {
        if($("#orderby").val() == "desc"){
            $("#orderby").val("asc");
        }
        else
        {
            $("#orderby").val("desc");
        }
        if(type == "price1")
        {
            if($("#request_type").is(':checked')){
                $("#order").val('price');
            }
            else
            {
                $("#order").val('mortgage');
            }
        }
        else if(type == "price2")
        {
            if($("#request_type").is(':checked')){
                $("#order").val('price_per_meter');
            }
            else
            {
                $("#order").val('rent');
            }
        }
        else
        {
            $("#order").val(type);
        }
        CheckSend();
    }
    function search1(type)
    {
        $('.nav-link').removeClass('active');
        if(type == 'rejected')
        {
            $('#confirmation').val('rejected');
            $('.rejected').addClass('active');
        }
        else if(type == 'verified'){
            $('#confirmation').val('verified');
            $('.verified').addClass('active');
        }
        else if(type == 'pending'){
            $('#confirmation').val('pending');
            $('.pending').addClass('active');
        }
        else if(type == 'withdrawal'){
            $('#confirmation').val('withdrawal');
            $('.withdrawal').addClass('active');
        }
        else if(type == 'tradedoutsideoffice'){
            $('#confirmation').val('tradedoutsideoffice');
            $('.tradedoutsideoffice').addClass('active');
        }
        else if(type == 'tradedoffice'){
            $('#confirmation').val('tradedoffice');
            $('.tradedoffice').addClass('active');
        }
        else if(type == 'hidden'){
            $('#confirmation').val('hidden');
            $('.hidden2').addClass('active');
        }
        else
        {
            $('#confirmation').val('');
            $('.all').addClass('active');
        }
        CheckSend();
    }
    $(".select2").select2({
        closeOnSelect: false
    });
    /*$("#form_search").click(function() {
        console.log("#form_search");
        CheckSend();
    });*/
    $(document).ready(function(){
        $('#mySearch').on('submit', function(e){
            e.preventDefault();
            pagin = 1;
            CheckSend();
            return false;
        });
    });
    var pagin = 1;
    var str="";
    var pageload = 0;
    function loadMoreData(page,type)
    {
        //window.history.pushState("object or string", "Title", "/profile/my-estate-ads?page="+page+"&&"+type);
        type1=type;
        if(page==1){
            $(".tab-content1").html("");
        }
        $.ajax({
                url: "/profile/myEstateShow?page="+page+"&&"+type,
                type: "get",
                beforeSend: function() {
                    $('.page-loading').addClass('active');
                }
            })
            .done(function(data) {
                $('.page-loading').removeClass('active');
                if (data.length == 0) {
                    return;
                }
                $(".tab-content1").html(data.html);
                $("#pagination").html("");
                var result = Paging(pagin ,$('#pagesize').val(),data.totalCount, "myClass", "myDisableClass");
                $("#pagination").html(result);
                //$('.page-loading').removeClass('active');
                if(pageload == 1)
                {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=content]');
                    // Does a scroll target exist?
                    if (target.length) {
                        // Only prevent default if animation is actually gonna happen
                        //event.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top-70
                        }, 1000, function() {
                            // Callback after animation
                            // Must change focus!
                            var $target = $(target);
                            $target.focus();
                            if ($target.is(":focus")) { // Checking if the target was focused
                                return false;
                            } else {
                                $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
                                $target.focus(); // Set focus again
                            };
                        });
                    }
                }
                pageload = 1;
            })
        }
        $("#pagination").on("click", "a", function () {
            pagin=$(this).attr("pn");
            if(pagin>0){
                loadMoreData($(this).attr("pn"),type1);
            }
        }
    );
    $(document).ready(function() {
        CheckSend();

        changeaccess();
    });
    function destroy(id) {
        $.get("/estates/destroy/" + id, function(data, status) {
            pagin = 1;
            CheckSend();
        });
    };
    function changeaccess(){
        console.log($('#request_type').val());
        console.log($("#estate_type").val());
        $(".not").hide();
        $(".not").each(function(){
            var splaccess= $(this).attr('access').toString().split(",");
            for(var i=0;i<splaccess.length;i++){
                var dealtype=splaccess[i].substring(0,1);
                var estatetype=splaccess[i].substring(1,2);
                if( $('#request_type').val()==dealtype){
                    if($("#estate_type").val()==estatetype){
                        $(this).show();
                        $(this).find("select").select2();
                    }
                }
            }
        });
    }
    function toEnglishNumber(strNum) {
        var pn = ["۰", l("۱"), l("۲"), l("۳"), l("۴"), l("۵"), l("۶"), l("۷"), l("۸"), l("۹")];
        var en = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        var cache = strNum;
        for (var i = 0; i < 10; i++) {
            //var regex_fa = new RegExp(pn[i], 'g');
            cache = cache.replace(pn[i], en[i]);
        }
        return cache;
    }
    $("#estate_type").change(function(){
        changeaccess();
    });
</script>
<script>
    var addressPoints;
    var mp;
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0-beta.2/leaflet.js"></script>
<script src="/js/Mh1PersianDatePicker.js"></script>
@if(ss('SITE_ID') == 3)
<script src="/frontend/js/modules/leaflet/kama.js"></script>
<script src="/frontend/js/modules/leaflet/leaflet.draw-src.js"></script>
<script src="/frontend/js/modules/leaflet/turf.min.js"></script>
<script src="/frontend/js/modules/leaflet/markercluster/markercluster-src.js"></script>
@endif
<script>
    var refreshIntervalId;
    function mapClick(id){
        $('#estate_id').val(id);
        searched();
        //clearInterval(refreshIntervalId);
    }
    function SetMapCluster(sr) {
        $.ajax({
                url: `/profile/myEstateShow?mapexists=1&&${sr}`,
                type: "get",
                beforeSend: function() {
                    $("#spiner").removeClass("d-none");
                }
            })
            .done(function(data) {
                addressPoints = eval(data.map);
                mp.setCluster();
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                $("#spiner").addClass("d-none");
            });
    }
    @if($citySelected)
    var defaultLocation = [{{ $citySelected->posx }}, {{ $citySelected->posy }}]; //tehran azadi
    @endif
    @if(ss('SITE_ID') == 3 && $currentUser->isExpert())
    mp = $('#map').kamaMap({
        zoom: 12,
        minZoom: 1,
        lat: defaultLocation[0],
        lng: defaultLocation[1]
    }).setPen().PenDrawBoundry(function(data) {
        $('#js_HiddenMapDrawPoints').val(data.points);
        $('#js_PenIsActive').val(1);
        searched();
    }, function() {
        ClearPenBoundry();
        $('#js_PenIsActive').val(0);
    });
    //mp.drawBoundary($('#js_boundary').val(), '#00f', 0.0);
    function ClearPenBoundry() {
        $('#js_HiddenMapDrawPoints').val('');
        $('#js_PenIsActive').val('');
        searched();
    }
    @endif
</script>
<!--script src="/vendor/expandable/jquery.expandable.js"></script>
<script type="text/javascript">
    {{ l('jQuery(document).ready(function() { $(\'#map\').expandable({ height: 350, offset:120, more: l("مشاهده نقشه در محدوده بزرگتر"), less: l("مشاهده نقشه در محدوده کوچکتر") }); });') }}
</script-->
@endsection
