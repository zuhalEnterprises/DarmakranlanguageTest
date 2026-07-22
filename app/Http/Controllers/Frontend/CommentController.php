<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        if(ss('SITE_ID') == 10 || ss('SITE_ID') == 11)
        {
            Config::set('app.locale' , 'en');
        }
        $user = Auth::user();
        if($user->isAdmin())
        {
            $comment = Comment::orderBy('id', 'desc');
            if(!empty($request->name))
            {
                $comment = $comment->where('name', 'like' , '%'.$request->name.'%');
            }

            if (!empty($request->commentable_type))
            {
                $comment = $comment->where('commentable_type', $request->commentable_type);
            }

            if (!empty($request->commentable_id))
            {
                $comment = $comment->where('commentable_id', $request->commentable_id);
            }

            if (!empty($request->status))
            {
                $comment = $comment->where('status', $request->status);
            }

            $totalCount = $comment->count();
            $model = $comment->paginate(20);

            if ($request->ajax() && $totalCount > 0)
            {
                $couter=$totalCount/20;
                $counter1= round($couter);
                if($counter1>=$couter) $couter=$counter1;
                else $couter=$counter1+1;
                $hasPage = ($couter==$request->page)? false : true;
                $view = view('frontend.comment.commentlist', compact('model'))->render();
                return response()->json(['html' => $view, 'hasPage' => $hasPage, 'totalCount' => $totalCount]);
            }
            return view('frontend.comment.comment', compact('model'));
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer',
            'body' => 'required|string',
        ]);

        $comment = new Comment($validated);
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->body = $request->body;
        $comment->status = 'pending';
        $comment->commentable_id = $request->commentable_id;
        $comment->commentable_type = $request->commentable_type;
        $comment->lang = $request->lang;
        $comment->save();
        return success_true([], 'کامنت با موفقیت ثبت شد و در انتظار بررسی است.');
    }

    public function show($id)
    {
        $comment = Comment::with('children')->findOrFail($id);
        return response()->json($comment);
    }

    public function update(Request $request, $id)
    {

        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'شما اجازه ویرایش این کامنت را ندارید.'], 403);
        }

        $comment->update($request->only('body', 'rate'));
        return response()->json(['message' => 'کامنت با موفقیت ویرایش شد.', 'data' => $comment]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $comment = Comment::findOrFail($id);

            if ($comment->user_id !== auth()->id() && !auth()->user()->is_admin) {
                return response()->json(['message' => 'شما اجازه حذف این کامنت را ندارید.'], 403);
            }

            $comment->delete();
            return response()->json(['message' => 'کامنت حذف شد.']);
        }
    }

    public function approve($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $comment = Comment::findOrFail($id);
            $comment->status = 'verified';
            $comment->save();

            return response()->json(['message' => 'کامنت تایید شد.']);
        }
    }

    public function reject($id)
    {
        $user = Auth::user();
        if($user->isAdmin())
        {
            $comment = Comment::findOrFail($id);
            $comment->status = 'rejected';
            $comment->save();

            return response()->json(['message' => 'کامنت رد شد.']);
        }
    }
}
