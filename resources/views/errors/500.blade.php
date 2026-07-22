@section('title', l('خطای سرور!'))
@extends('admin.layouts.app')
@section('main_content')

    <body class="body-500">

    <div class="container">

        <section class="error-wrapper">
            <i class="icon-500"></i>
            <h1>{{ l('خطا !!!') }}</h1>
            <h2>{{ l('پیام خطا 500') }}</h2>
            <p class="page-500">{{ l('لطفا بعدا مراجعه کنید') }}<a href="" onclick="window.history.go(-1); return false;">{{ l('بازگشت به صفحه اصلی') }}</a></p>
        </section>

    </div>


    </body>

@endsection



