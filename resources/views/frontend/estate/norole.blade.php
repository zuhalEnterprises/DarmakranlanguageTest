@extends('frontend.layouts.intro.appnew',['title'=>'جستجوی ملک'])
@section('head')

@endsection
@section('main_content')
@include('frontend.layouts.header1')
<div style="width:100%">
<table style="width:500px;height:300px;background:red;float:left;">
@foreach($estates as $estate)
<tr>

    <td>{{$estate->id}}</td>
</tr>
@endforeach
</table>
</div>

@endsection
