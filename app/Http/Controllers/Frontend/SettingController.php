<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
class SettingController extends Controller
{
    protected $model, $viewPath, $routeName;
    public function __construct()
    {
        $this->model = new Setting();
        $this->viewPath = 'profile.setting';
        $this->middleware('role:admin_super');
    }
    public function index(Request $request)
    {
        $model = QueryBuilder::for($this->model::orderBy('group', 'asc'))
            ->allowedFilters(array_merge(['id'], $this->model->getFillable()))
            ->defaultSort('-id')
            ->allowedSorts(array_merge(['id'], $this->model->getFillable()));
        $models = $model->get();
        return view('frontend.profile.setting', compact('models'));
    }
    public function create()
    {
        return view('frontend.profile.setting.create');
    }
    public function store(SettingRequest $request)
    {
        $inputs = $request->all();
        $model = Setting::create($inputs);
        session()->flash('عملیات ثبت با موفقیت انجام شد.', 'success');
        return redirect('frontend.profile.setting');
    }
    public function edit($id)
    {
        $model = Setting::find($id);
        if (empty($model)) {
            return back()->with(['errors' => 'یافت نشد!']);
        }
        return view('frontend.profile.settings.edit', compact('model'));
    }
    public function update(Request $request)
    {
        $model = Setting::find($request->id);
        if (empty($model)) {
            return back()->with(['errors' => 'یافت نشد!']);
        }
        $inputs = $request->all();
        $inputs['count'] = 0;
        //dd($inputs);
        $model->update($inputs);
        return response()->json( ['status' => 'ok'] );
    }
    public function destroy($id)
    {
        $ids = explode(',', $id);
        $ids = count($ids) > 1 ? $ids : implode('', $ids);
        if (is_array($ids)) {
            $model = Setting::whereIn('id', $ids)->get();
            foreach ($model as $item) {
                $item->delete();
            }
            return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
        }
        $model = Setting::find($ids);
        if (!$model) {
            return notFound();
        }
        $model->delete();
        return response()->json(['status' => 'ok', 'result' => 'deleted!'], config('StatusCode.SUCCESS'));
    }
}
