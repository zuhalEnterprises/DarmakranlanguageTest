@extends('frontend.layouts.intro.appnew',['title'=>'تایید کد'])
@section('body_class','confirmation')
@section('head')
    <style>
        input{font-size: .95rem !important;}
        .dir-left{ direction: ltr !important;}
    </style>
@endsection
@section('main_content')
    @php($username = session('user')->username)
    @include('frontend.layouts.header1')

    <div class="container py-4" style="min-height: 480px">
        <div class="row">

            <div class="border-0 card col-xl-4 col-lg-6 col-md-6 offset-xl-4 offset-lg-3 offset-md-3 py-4 shadow-lg">

                <div class="content">

                    <form class="form-horizontal" method="POST" action="{{('/check_validation')}}">
                        @csrf

                        <div class="col-xs-12 form-control-lg input-group-sm">

                            <div>
                                <span class="font_12 hint">{{ l('برای شماره') }}<strong>{{toPersianNumbers($username,false)}}</strong>{{ l('کد تایید ارسال گردید') }}</span>
                            </div>

                            <div id="verify-input" class="my-3">
                                <input name="username" value="{{$username}}" hidden class="hidden" />
                                <label class="form-label text-muted" for="pwd">{{ l('کد تایید') }}</label>
                                <input class="form-control form-control-lg dir-left" name='code' id="verification" maxlength="5" minlength="5" placeholder="" autofocus>
                                @if ($errors->has('code'))
                                    <span class="help-block text-danger">{{ $errors->first('code') }}</span>
                                @endif

                                <div class="mt-1" style="display:flex;flex-direction: row;justify-content: space-between;align-items: center">
                                    <div class="headline"><label><a id="sendAgainLink" data-username="{{$username}}">{{ l('ارسال مجدد کد تایید') }}</a></label></div>
                                    <div class="headline"><div id='theTarget'>90</div></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-around">
                                <button type="submit" id="login-submit" disabled class="btn btn-primary mt-2">{{ l('تایید') }}</button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

    @include('frontend.layouts.footer1')

@endsection
@section('js')
    <script type="text/javascript">
        function parseArabic(str) { return Number( str.replace(/[٠١٢٣٤٥٦٧٨٩]/g, function(d) { return d.charCodeAt(0) - 1632; // Convert Arabic numbers }).replace(/[۰۱۲۳۴۵۶۷۸۹]/g, function(d) { return d.charCodeAt(0) - 1776; // Convert Persian numbers }) ); } function toPersianNum( num, dontTrim ) { var i = 0, dontTrim = dontTrim || false, num = dontTrim ? num.toString() : num.toString().trim(), len = num.length, res = '', pos, persianNumbers = typeof persianNumber == 'undefined' ? ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'] : persianNumbers; for (; i < len; i++)
                if (( pos = persianNumbers[num.charAt(i)] ))
                    res += pos;
                else
                    res += num.charAt(i);

            return res;
        }

        $("input#verification").on("keypress keyup blur",function (event) {
            $(this).val($(this).val().replace(/[^\d|\u06F0-\u06F9].+/, ""));

            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }

            if($(this).val().length === 5){
                $('#login-submit').removeAttr('disabled');
            }else{
                $('#login-submit').attr('disabled','disabled');
            }
        });


        $('#sendAgainLink').click(function(e){

            var existCount = parseInt($('#theTarget').html());
            e.preventDefault();
            if (existCount !==0){
                return false; // Do something else in here if required
            }else{
                var username = $(this).data('username');
                var baseUrl = window.location.origin;
                var sendUrl = '/send_again/';
                window.location.href =`${baseUrl}${sendUrl}${username}`;
            }
        });

        var timer = setInterval(function() {
            var count = parseInt($('#theTarget').html());
            if (count !== 0) {
                $('#theTarget').html(count - 1);
                $("#sendAgainLink").css({
                    'color' : '#ccc',
                    'border-bottom':'0'
                });
            } else {
                $("#sendAgainLink").css({
                    'color' : '#1ca2bd',
                    'border-bottom':'1px dashed #1ca2bd'
                });
                clearInterval(timer);
            }
        }, 1000);
    </script>
@endsection
