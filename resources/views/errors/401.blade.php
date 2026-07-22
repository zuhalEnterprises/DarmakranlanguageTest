@section('title', l('عدم دسترسی!'))
@extends('admin.layouts.app')
@section('main_content')

    <body class="body-401">

    <div class="container">

        <section class="error-wrapper">
            <i class="icon-404"></i>
            <h2>{{ l('شما مجوز دسترسی به این صفحه را ندارید!') }}</h2>
            <p class="page-404"><a href="/dashboard_v2">{{ l('بازگشت به صفحه اصلی سایت') }}</a></p>
        </section>

    </div>


    </body>

@endsection



