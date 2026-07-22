<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;


class NotificationController extends Controller
{
    public function __construct()
    {
        $this->model = new Notification();
        $this->route = 'notification';
        $this->viewPath = 'notification';
        $this->middleware('role:admin_super', [
            'except' => [
                'index'
            ]
        ]);
    }

    public function index(Request $request)
    {
                $user = Auth::user();
        $model = QueryBuilder::for(Notification::with(['city:id,code,name', 'user:id,name,username', 'role']))
            ->allowedIncludes(['city', 'user', 'role'])
            ->allowedFilters(array_merge(['id', 'city.id', 'user.id', 'role.id'], $this->model->getFillable()))
            ->defaultSort('-id')
            ->allowedSorts(array_merge(['id'], $this->model->getFillable()));

        $model = !empty($request->input_created_at) ? $model->whereDate('created_at', Carbon::createFromTimestamp($request->input_created_at)) : $model;

        if (!$user->isAdmin() || !$user->hasRole('admin_super')) {
            $dt = Carbon::now();
            //$model = getNotifications($user,true);
            $model = $model->where(function ($q) use ($user,$dt) {
                $q->orWhere('send_to_all', 1)
                    ->orWhere('city_id', $user->city_id)
                    ->orWhereIn('role_id', [$user->role_ids]);
            })->whereDate('expired_at', '>=', $dt)
                ->paginate(15);

            return view($this->viewPath . '.user_notifs', compact('model'));
        }

        $model = $model->paginate(15);

        $cities = City::pluck('name', 'id');
        $roles = Role::pluck('title', 'id');

        return view('frontend.notification.index', compact('model', 'cities', 'roles'));
    }
    public function notificationGet(Request $request){
        $user = Auth::user();
        $view="";
        if(!empty($user)){
            $NotificationLog=NotificationLog::where('userId',$user->id)->where('seen',0)->get();
            $view = view('frontend.intro.notification',compact('NotificationLog'))->render();
        }
        return response()->json( [ 'html' => $view ] );
    }

    public function NotificationLogUpdate(Request $request )
    {
        $user = Auth::user();
        $model=  $NotificationLog=NotificationLog::where('userId',$user->id)->where('seen',0)->get();

        foreach($model as $model1){
            $inputs["seen"]=1;
            $update1= $model1->update($inputs);
   
        }
        
        return $model1;
    }
}
