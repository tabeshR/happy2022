<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $confirmed = $request->confirmed ?? 1;
        $comments = Comment::query();
        if($key = $request->search){
            $comments->where('comment','like',"%{$key}%")->orWhereHas('user',function ($query) use ($key){
                $query->where('name','like',"%{$key}%");
            });
        }
        $comments = $comments->where('confirmed',$confirmed)->latest()->paginate(10);

        return view('admin.comments.index',compact('comments'));
    }


    public function edit(Comment $comment)
    {
        return view('admin.comments.edit',compact('comment'));
    }

    public function update(Request $request,Comment $comment)
    {
        $this->validate($request,[
            'comment'=>'required|min:3|max:1000'
        ]);
        if(isset($request->confirmed)){
            $comment->update(['confirmed'=>1]);
        }
        if(isset($request->reply)){
            $this->validate($request,[
                'reply'=>'required|min:3|max:1000'
            ]);
            $request->user()->comments()->create([
                'comment' => $request->reply,
                'parent_id' => $comment->parent_id ?: $comment->id,
                'confirmed' => 1,
                'commentable_id' => $comment->commentable_id,
                'commentable_type' => $comment->commentable_type,
            ]);
        }
        alert()->success('عملیات با موفقیت انجام شد');
        return redirect(route('admin.comments.index'));
    }

    public function destroy(Comment $comment)
    {

    }
}
