<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;
use App\Models\ChatMessage;
use App\Models\Notification;
use App\Models\User;
use App\Models\Estate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
class ChatController extends Controller
{
    protected $model, $route, $viewPath;
    public function __construct()
    {
        $this->model = new Chat();
        $this->route = 'chats';
        $this->viewPath = '';
        //$this->middleware('role:admin_super');
    }
    public function chat_v2(Request $request)
    {
        return view('frontend.chat.new');
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $chats = QueryBuilder::for(
            Chat::whereHas('messages')
                ->with([
//                    'sender:id,name,last_name,username,photo',
  //                  'receiver:id,name,last_name,username,photo',
                    'estate',
                    'customer',
                    'messages',
                ]))
            ->allowedIncludes(['sender', 'receiver', 'estate', 'customer', 'messages'])
            ->allowedFilters(array_merge(['id', 'messages.body', 'messages.created_at'], $this->model->getFillable()))
            ->defaultSort('-updated_at')
            ->allowedSorts(array_merge(['id'], $this->model->getFillable()));
        //$chats = !empty($request->input_created_at) ? $chats->whereDate('created_at',Carbon::createFromTimestamp($request->input_created_at) ) : $chats;
        if(!$user->isAdmin())
        {
            $chats = $chats->where(function ($q) use ($user) {
                $q->orWhere('sender_id', $user->id)->orWhere('receiver_id', $user->id);
            });
        }
        $chats = $chats->paginate(100);
        //dd(getQuery($chats));
        $chat_message_count= ChatMessage::with(['chat' =>
        function ($query) {
            $query->where('receiver_id', '!=', $user->id);
        }])->where('user_id', '!=', $user->id)->where('is_seen',0)->count() ?? 0;
        if ($chats) {
            $chats->map(function ($chat)use($user) {
                // get new messages
                $chat->new_message_count = $chat->messages->where('user_id', '!=', $user->id)->where('is_seen',0)->count() ?? 0;
               // $chat_message_count+=$chat->new_message_count;
                $chatUser = $chat->sender_id != $user->id ? $chat->sender : $chat->receiver;
                $chat->photo=!empty($chatUser->photo) ?'/upload/images/profile/': '/upload/images/avatar.jpg';
                //$chatUser->photo=
                //$chatUser->photo =$item->user->photo();
                $chat->user = $chatUser;
                $lastMessage = $chat->messages->sortByDesc('id')->first();
                if ($lastMessage) $chat->updateDate = toPersianDate($lastMessage->created_at,true);
             // dd($chat->user->has_role);
             if(!empty($chat->user)){
                if(empty($chat->user->isMember())){
                    $chat->user->name=$chat->user->username;
                }
                else
                {
                    $chat->user->name = $chat->user->fullname();
                }}
            });
        }
        return view('frontend.chat.index2', compact('chats','chat_message_count'));
    }
    public function show(Request $request, $id)
    {
        $user = Auth::user();
        //if($id!=1){
            $chat = Chat::with(['messages', 'messages.user'])->where('id', $id);//->where('sender_id', $user->id);
            $chat = $chat->first();
        /*}
        else if($id==1){
            $chat =  $this->model->where(function ($q) use ($user) {
                $q->orWhere('sender_id', $user->id)->orWhere('receiver_id', $user->id);
            })->where('estate_id',$estate_id)->first();
        }*/

        $estatvalue="";
        $messages = [];
        if ($chat) {
            // update seen status
            ChatMessage::where('chat_id',$chat->id)->where('user_id','!=',$user->id)->update(['is_seen'=>1]);
            $messages = $chat->messages;
            $estate=Estate::where('id',$chat->estate_id)->first() ;
            if(!$estate){
                return response(['status' => 'success']);
            }
            if($estate->estate_type){
                $type=estateTypes($estate->estate_type);
            }
            else
            {
                $type="";
            }
            //$estatvalue="<a target='_blank' href='/v/".$chat->estate_id."'>".($estate->type==1?"فروش":"رهن و اجاره")." ".$type." ".$estate->area." متری در ".$estate->district->name??''." ".$estate->city->name??''."</a>";
            $estatvalue="<a target='_blank' href='/v/".$chat->estate_id."'>"
            .($estate->type == 1 ? "فروش" : "رهن و اجاره")
            ." ".$type." ".$estate->area." متری در "
            .($estate->district->name ?? '') // جلوگیری از خطا اگر مقدار district مقدار null باشد
            ." "
            .($estate->city->name ?? '') // جلوگیری از خطا اگر مقدار city مقدار null باشد
            ."</a>";

            $chat->messages->map(function ($item) {
                $item->date = toPersianDate($item->created_at,true);
                $item->user->photo = '';
                $item->user->photo =  $item->user->photo();
                if(!$item->user->isMember()){
                    $item->user->name='<a target="_blank" href="tel:+98'.substr($item->user->username,1).'">'.$item->user->username.'</a>';
                }
                else
                {
                    $item->user->name='<a target="_blank" href="/agents/'.$item->user->id.'">'. $item->user->fullname() .'</a>';
                }
                $user = Auth::user();
                $item->seen ='';
                if($item->user_id==$user->id){
                    $item->seen=$item->seen();
                }
            });
        }
        return response(['status' => 'success', 'chat' => $chat, 'messages' => $messages,'estatevalue'=>$estatvalue], config('StatusCode.SUCCESS'));
    }
    public function chatsEstate(Request $request,$estate_id)
    {
        $user = Auth::user();
        $chat =  $this->model->where(function ($q) use ($user) {
            $q->orWhere('sender_id', $user->id)->orWhere('receiver_id', $user->id);
        })->where('estate_id',$estate_id)->first();
        //$chat = $request->type == 'customer' ? $chat->where('customer_id', $request->customer_id) : $chat->where('estate_id', $request->estate_id);
        $estatvalue="";
        $messages = [];
        if ($chat) {
            // update seen status
            ChatMessage::where('chat_id',$chat->id)->where('user_id','!=',$user->id)->update(['is_seen'=>1]);
            $messages = $chat->messages;
            $estate=Estate::where('id',$chat->estate_id)->first() ;
            $type=estateTypes($estate->estate_type);
            $estatvalue="<a target='_blank' href='/v/".$chat->estate_id."'>".($estate->type==1?"فروش":"رهن و اجاره")." ".$type." ".$estate->area." متری در ".(($estate->district != null)?$estate->district->name:'')." ".(($estate->city != null)?$estate->city->name:'')."</a>";
            $chat->messages->map(function ($item) {
                $item->date =toPersianTime($item->created_at);
                $item->user->photo = '';
                $item->user->photo =  $item->user->photo();
                if(!$item->user->isMember()){
                    $item->user->name='<a target="_blank" href="tel:+98'.substr($item->user->username,1).'">'.$item->user->username.'</a>';
                }
                else
                {
                    $item->user->name='<a target="_blank" href="/agents/'.$item->user->id.'">'. $item->user->fullname().'</a>';
                }
                $user = Auth::user();
                $item->seen ='';
                if($item->user_id==$user->id){
                    $item->seen=$item->seen();
                }
            });
        }
        return response(['status' => 'success', 'chat' => $chat, 'messages' => $messages,'estatevalue'=>$estatvalue], config('StatusCode.SUCCESS'));
    }
    public function chatsEstate2(Request $request,$chat_id,$estate_id)
    {
        $user = Auth::user();
        $chat =  $this->model->where('id',$chat_id)->where('estate_id',$estate_id)->first();
        $estatvalue="";
        $messages = [];
        if ($chat) {
            // update seen status
            ChatMessage::where('chat_id',$chat->id)->update(['is_seen'=>1]);
            $messages = $chat->messages;
            $estate=Estate::where('id',$chat->estate_id)->first() ;
            $type=estateTypes($estate->estate_type);
            $estatvalue="<a target='_blank' href='/v/".$chat->estate_id."'>".($estate->type==1?"فروش":"رهن و اجاره")." ".$type." ".$estate->area." متری در ".(($estate->district != null)?$estate->district->name:'')." ".(($estate->city != null)?$estate->city->name:'')."</a>";
            $chat->messages->map(function ($item) {
                $item->date =toPersianTime($item->created_at);
                $item->user->photo = '';
                 $item->user->photo =  $item->user->photo();
                 if(!$item->user->isMember()){
                     $item->user->name='<a target="_blank" href="tel:+98'.substr($item->user->username,1).'">'.$item->user->username.'</a>';
                 }
                 else
                 {
                     $item->user->name='<a target="_blank" href="/agents/'.$item->user->id.'">'. $item->user->fullname().'</a>';
                 }
                 $user = Auth::user();
                 $item->seen ='';
                //  if($item->user_id==$user->id){
                //      $item->seen=$item->seen();
                //  }
            });
        }
        return response(['status' => 'success', 'chat' => $chat, 'messages' => $messages,'estatevalue'=>$estatvalue], config('StatusCode.SUCCESS'));
    }
    public function getConversation($id)
    {
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $estateuser=Estate::where('id',$request->estate_id)->first();
        $modelType = $request->type == 'customer' ? ['customer_id' => $request->customer_id] : ['estate_id' => $request->estate_id];
        //$chat = Chat::
        $chat = Chat::firstOrCreate([
            'estate_id' => $request->estate_id,
            'customer_id' => $request->customer_id,
            'sender_id' => $user->id,
            'receiver_id' =>$estateuser->expert_id
        ]);
        $chat->update([
            'sender_id' => $user->id,
            'receiver_id' => $estateuser->expert_id,
            'subject' => $request->subject,
        ]);
        $msg = ChatMessage::create([
            'chat_id' => $chat->id,
            'user_id' => $user->id,
            'type' => 1,
            'body' => $request->message,
            'is_seen' => 0,
        ]);
       // setNotificationLog($user->id,"chat","شما یک پیام جدید در گفتگوها دارید");
        if(!$msg){
            return success_false('خطا در ارسال پیام!');
        }
        // send a notification to the branch manager
        $user_id = $user->id != $chat->sender_id ? $chat->sender_id : $chat->receiver_id;
        Notification::create([
            'city_id' => null,
            'user_id' => $user_id,
            'role_id' => null,
            'title' => 'پیام جدید از : '.$user->name,
            'body' => 'موضوع: '.$request->subject,
            'systemic' => 1,
            'validity' => 10,
            'url' => 'admin/chats',
            'send_to_all' => 0,
            'send_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays(10),
        ]);
        $msg->date = toPersianDate($msg->created_at,true);
        $msg->user->photo = '';
        $msg->seen = $msg->seen();
        return success_true(['chat_id'=>$chat->id,'msg'=>$msg], 'پیام شما با موفقیت ارسال شد');
    }
    public function sendMessage(Request $request)
    {

        $user = Auth::user();
        $chat = Chat::find($request->chat_id);
        if(!$chat){
            return notFound();
        }
        $chat->updated_at = Date('Y-m-d H:i:s');
        $chat->save();
        //dd($chat);
        $msg = ChatMessage::create([
            'chat_id' => $chat->id,
            'user_id' => $user->id,
            'type' => 1,
            'body' => $request->message,
            'is_seen' => 0,
        ]);
        if(!$msg){
            return success_false('خطا در ارسال پیام!');
        }
        else
        {

            if(ss('SITE_ID') == 3)
            {

                $viewexpert = getsetting('sms','sendMessage');
                $arrSearch = array("{0}" , "{1}");
                $arrReplace = array($chat->estate_id , $chat->id);
                $text = str_replace($arrSearch, $arrReplace, $viewexpert);
                //dd($viewexpert);
                sendSms($chat->sender->username , $text);
            }
        }
        // send a notification to the branch manager
        $user_id = $user->id != $chat->sender_id ? $chat->sender_id : $chat->receiver_id;
        Notification::create([
            'city_id' => null,
            'user_id' => $user_id,
            'role_id' => null,
            'title' => 'پیام جدید از : '.$user->name,
            'body' => 'موضوع: '.$chat->subject,
            'systemic' => 1,
            'validity' => 10,
            'url' => 'admin/chats',
            'send_to_all' => 0,
            'send_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays(10),
        ]);
        $msg->date = toPersianDate($msg->created_at,true);
        $msg->user->photo = '';
        if(!$user->isMember()){
            $msg->user->name='<a target="_blank" href="tel:+98'.substr($msg->user->username,1).'">'.$msg->user->username.'</a>';
        }
        else
        {
            $msg->user->name='<a target="_blank" href="/agents/'.$user->id.'">'. $user->fullname().'</a>';
        }
        $msg->seen = $msg->seen();
        return success_true($msg, 'پیام شما با موفقیت ارسال شد');
    }
    public function seen(Request $request)
    {
        $chat = Chat::find($request->chat_id);
        if(!$chat){
            return notFound();
        }
        $chat->messages->update(['is_seen'=>1]);
        return success_true(null, '');
    }
}
