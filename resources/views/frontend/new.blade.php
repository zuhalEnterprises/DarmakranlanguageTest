@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',['title'=>' پیشخوان'])

@section('head')

@endsection
@section('main_content')
@include(ss('THEME').'.frontend.layouts.header_v2')

@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
