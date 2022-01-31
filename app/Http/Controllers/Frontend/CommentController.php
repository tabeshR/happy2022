<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'commentable_id' => ['required','integer','exists:products,id'],
            'commentable_type' => ['required','string'],
            'comment' => 'required|max:1000|min:3',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        $request->user()->comments()->create($data);
        alert()->success('نظر شما با موفقیت ثبت شد و پس از تایید مدیر سایت به نمایش درمیآید');
        return back();
    }
}
