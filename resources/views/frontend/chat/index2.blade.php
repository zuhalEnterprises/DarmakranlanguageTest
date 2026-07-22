@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME')
])

@section('head')
<link rel="stylesheet" href="{{asset('/css/chats.css')}}">
<style>
a{color:unset;text-decoration: none}

</style>
@endsection
@section('main_content')

<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page container-->
    <div class="container mt-5 mb-md-4 py-5">
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => '7'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ l('گفتگو') }}</li>
                    </ol>
                </nav>
                <!-- Title-->

                <div>
                    @if(count($chats)>0)
                    <div class="card direct-chat direct-chat-primary" >
                        <div class="card-header">
                            <h3 class="card-title">{{ l('گفتگو') }}</h3>

                            <div class="card-tools">
                                <span data-toggle="tooltip" title="{{$chat_message_count}} پیام جدید" class="badge badge-primary"></span>
                                <!-- <button type="button" class="btn btn-tool btn-min" data-widget="collapse" data-toggle="collapse" href="#collapseHide" role="button" aria-expanded="true" aria-controls="collapseHide">
                                    <i class="fa fa-minus"></i>
                                </button> -->
                                <button type="button" class="btn btn-tool" data-toggle="tooltip" title="{{ l('مخاطبین') }}" data-widget="chat-pane-toggle">
                                    <i class="fa fa-comments"></i>
                                </button>
                                <!-- <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                                </button> -->
                            </div>
                            <div><span class='estateshow'></span></div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body collapse show" id="collapseHide">

                            <div class="direct-chat-messages">
                            </div>
                            <!--/.direct-chat-messages-->

                            <!-- Contacts are loaded here -->
                            <div class="direct-chat-contacts" style="background:#F7F7F7;">
                                <ul class="contacts-list">

                                @foreach($chats as $chat)
                                    <li class="chat-contact" id="chat-contact-{{$chat->id}}" data-chat-id="{{$chat->id}}" style="border-bottom:1px solid #6a6a6a;">
                                        <a href="#">

                                            <img class="contacts-list-img" src="{{$chat->photo??''}}" alt="">

                                            <div class="contacts-list-info">
                                                <span class="contacts-list-name text-body">

                                                    {{!empty($chat->user)?$chat->user->fullname():''}}

                                                    @if($chat->new_message_count > 0)
                                                        <span class="badge  message-count" style="background:red">{{toPersianNumbers($chat->new_message_count)}}</span>
                                                    @endif

                                                </span>
                                                <a target="_blank" href="/v/{{$chat->estate_id}}"><span class="contacts-list-msg text-body">{{$chat->subject}}</span></a>
                                                <br>
                                                <small class="contacts-list-date float-left">
                                                    {{$chat->updateDate}}
                                                </small>
                                                <br>
                                            </div>

                                        </a>
                                    </li>

                                @endforeach


                                    <!-- End Contact Item -->
                                </ul>
                                <!-- /.contacts-list -->
                            </div>
                            <!-- /.direct-chat-pane -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer " id="collapseHidetext">
                            <form action="#" method="post">
                                <div class="input-group">
                                    <input type="text" name="message" placeholder="{{ l('متن پیام...') }}" class="form-control">
                                    <span class="input-group-append" id="send-message" style="margin-right: 10px">
                                        <button type="button" class="btn btn-primary">{{ l('ارسال') }}</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!--/.direct-chat -->

                @else

                @endif
                </div>
            </div>
        </div>
    </div>
</main>

@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
@section('js')
<script>
 $(document).ready(function() {
    $(".direct-chat-primary").addClass('direct-chat-contacts-open');
    var CSRF_TOKEN = '{{csrf_token()}}';
    var chatID = 0;
    var userID = '{{$currentUser->id ?? 0}}';
    $('.chat-contact').on('click', function() {
        $("#collapseHidetext").addClass('show');
        chatID = $(this).data('chat-id');
        $('#chatbox').removeClass('direct-chat-contacts-open');
        $('#loading').fadeIn(500);
        $('#message-box').fadeIn(500);
        $('button#chat-users').fadeIn(500);
        $('.direct-chat-messages').empty();
        getMessages(chatID)
    });
    function getMessages(chat_id) {
        if (chat_id != 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '/chats/' + chat_id,
                type: "GET",
                success: function(data) {
                    var res = data.messages;
                    $(".estateshow").html(data.estatevalue);
                    var itemList = '';
                    if (res != null) {

                        $('#loading').hide();
                        $.each(res, function(key, value) {

                            var cssClass = userID == value.user.id ? 'right':'left' ;
                            var cssClass1 = userID == value.user.id ? 'left':'right' ;
                            var directionName = cssClass == 'right' ? 'pull-right' : 'pull-left';
                            var directionDate = cssClass == 'right' ? 'pull-left' : 'pull-right';
                            itemList += '<div class="direct-chat-msg ' + cssClass + '">' +
                                '<div class="direct-chat-info clearfix">' +
                                '<span class="direct-chat-name ' + directionName + '">' + value.user.name +'</span>' +
                                '<span class="direct-chat-timestamp ' + directionDate + '">' + value.date + '</span>' +
                                '</div>' +
                                '<img class="direct-chat-img" src="' + value.user.photo + '" alt="message user image">' +
                                '<div class="direct-chat-text">' +
                                '<span class="chat-message margin-r-5">' + value.body + '</span>' +
                                '<span class="float-left">' + value.seen + '</span>' +
                                '</div>' +
                                '</div>';
                            });
                    }
                    $('.direct-chat-messages').append(itemList).scrollTop($('.direct-chat-messages')[0].scrollHeight);
                    $(".direct-chat-primary").removeClass('direct-chat-contacts-open');

                    $('#chat-contact-' + chat_id + ' .message-count').remove();
                },
            });
        }
    }

    $('#send-message').on('click', function(e) {
            var message = $('input[name="message"]').val();
            if (message.trim().length == 0) {
                $('input[name="message"]').focus();
                return false;
            }

            sendMessage(chatID, message)
 });

 });

/*
     var CSRF_TOKEN = '{{csrf_token()}}';
        var reciverID = 0;


            function getMessages1(reciverID) {

            if (reciverID != 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                });
                $.ajax({
                    url: '/chatsUser/'+reciverID,
                    type: "GET",
                    success: function(data) {
                        var res = data.chat;


                        var itemList = '';
                        if (res != null) {

                            $('#loading').hide();
                            $.each(res, function(key, value) {
                                var float='';
                                var float_left='float-left';
                                var float_right='float-right';
                                if(value.sender==2)
                                {
                                    var float='float';
                                    var float_left='float-right';
                                    var float_right='float-left';
                                }
                                itemList+='<div class="direct-chat-msg '+float+'">'+
                                    '<div class="direct-chat-info clearfix">'+
                                        '<span class="direct-chat-name '+float_left+'">'+value.name+'</span>'+
                                        '<span class="direct-chat-timestamp '+float_right+'">'+value.date+'</span>'+
                                    '</div>'+
                                    '<img class="direct-chat-img" src="'+value.photo+'" alt="message user image">'+
                                    '<div class="direct-chat-text">'+
                                    value.body
                                    +'</div>'
                                +'</div>'

                            });
                        }
                        $('.direct-chat-messages').append(itemList).scrollTop($('.direct-chat-messages')[0].scrollHeight)

                    },
                });
            }
        }



*/

    $(document).ready(function(){
        $(".chatclick").click(function(){
            $('.direct-chat-messages').empty();
            getMessages1($(this).attr('receive_id'))
        });

        $('input[name="message"]').keydown(function(event) {
            if (event.keyCode == 13) {
                $('#send-message').trigger('click');
                //event.preventDefault();
            }
        });

        $('#send-message').on('click', function(e) {
            var message = $('input[name="message"]').val();
            if (message.trim().length == 0) {
                $('input[name="message"]').focus();
                return false;
            }

            sendMessage(chatID, message);
        })
    });

    function sendMessage(chatID, message) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '/chats/sendmsg',
                type: "POST",
                data: {
                    chat_id: chatID,
                    message: message
                },
                success: function(data) {
                    var res = data.data;
                    //console.log(res)
                    if (res != null) {
                        $('input[name="message"]').val('');
                        var msg = '<div class="direct-chat-msg right">' +
                            '<div class="direct-chat-info clearfix">' +
                            '<span class="direct-chat-name pull-right">' + res.user.name + '</span>' +
                            '<span class="direct-chat-timestamp pull-left">' + res.date + '</span>' +
                            '</div>' +
                            '<img class="direct-chat-img" src="{{$currentUser->photo()}}" alt="message user image">' +
                            '<div class="direct-chat-text">' +
                            '<span class="chat-message margin-r-5">' + res.body + '</span>' +
                            '<span class="float-left">' + res.seen + '</span>' +
                            '</div>' +
                            '</div>';

                        $('.direct-chat-messages').append(msg).scrollTop($('.direct-chat-messages')[0].scrollHeight)
                    }

                    toast({
                        type: 'success',
                        title: data.message
                    });
                },
            });
        }

    function ConvertNumberToPersion() {

        function traverse(el) {
            if (el.nodeType == 3) {
                var list = el.data.match(/[0-9]/g);
                // if (list != null && list.length != 0) {
                //     for (var i = 0; i < list.length; i++)
                //         el.data = el.data.replace(list[i], persian[list[i]]);
                // }
            }
            for (var i = 0; i < el.childNodes.length; i++) {
                traverse(el.childNodes[i]);
            }
        }
        traverse(document.body);
    }

    ConvertNumberToPersion()

    $('[data-widget="chat-pane-toggle"]').click(function() {
        $(this).closest('.card').toggleClass('direct-chat-contacts-open')
    });
</script>

@endsection
