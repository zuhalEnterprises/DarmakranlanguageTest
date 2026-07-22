@section('title', l('حساب کاربری-مدیریت آگهی ملک'))
@extends('frontend.layouts.app')
@section('body_class',$templatePage->page_id)
@section('main_content')
    @include('frontend.layouts.header')

    @if(\Session::has('success'))
        <div class="c-message-light alert alert-success">
            <div class="c-message-light__justify">
                <span>{{\Session::get('success')}}</span>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger c-message-light c-message-light--info mb-1">
            <div class="c-message-light__justify">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="c-message-light--text">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="container">

        <div class="login-manage-text">
            <div class="pt-1 tab-content" id="myTabContent">

                <div class="row">
                    @include('frontend.profile.ad_management.layouts.sidebar_right')

                    <div class="col-lg-8">

                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="bg--zebra-stipe-gray mb-4 p-2 rounded">
                                    <h2 class="h2-manage-head pt-2">{{ l('مدیریت ملک') }}</h2>

                                    @if($estate->isExpired==1)
                                        <h3 class="h3-manage-head mr-3"><span style="color: #b33c3c;">{{ l('منقضی شده') }}</span></h3>
                                        <p class="p-manage-head mr-3">آگهی ملک شما منقضی شده و از لیست {{ss('SITE_NAME')}} خارج شده است.</p>
                                    @elseif($estate->confirmation == 'verified')
                                        <h3 class="h3-manage-head mr-3"><span class="text-success">{{ l('منتشر شده') }}</span></h3>
                                        <p class="p-manage-head mr-3">آگهی ملک شما منتشر شده و در لیست {{ss('SITE_NAME')}} قرار گرفته است.</p>
                                    @elseif($estate->confirmation == 'pending')
                                        <h3 class="h3-manage-head mr-3"><span class="text-warning">{{ l('در انتظار تایید') }}</span></h3>
                                        <p class="p-manage-head mr-3">آگهی ملک شما در انتظار تایید است، پس از بازبینی و تایید، در لیست {{ss('SITE_NAME')}} قرار خواهد گرفت.</p>
                                    @elseif($estate->confirmation == 'rejected')
                                        <h3 class="h3-manage-head mr-3"><span style="color: #b33c3c;">{{ l('رد شده') }}</span></h3>
                                        <p class="p-manage-head mr-3">{{ l('آگهی ملک شما رد شده است!') }}</p>
                                    @endif

                                </div>
                            </div>
                        </div>

                        @yield('tab_content')

                    </div>

                    @include('frontend.profile.ad_management.layouts.sidebar_left')
                </div>


            </div>
        </div>

    </div>
    <!--------end ad-management-------->


    @include('frontend.layouts.footer'/*,['cssClass'=>'intro']*/)
@endsection
