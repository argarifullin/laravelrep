<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function submit(Request $request)
    {   $request->validate([
        'message'=>'required',
        'user_id'=>'required',
        'post_id'=>'required'
        ]);
        $data = $request->all();
        $user = User::where('id',$request->user_id)->get();
        foreach ($user as $item) {
           $username = $item->name;
        }
        $data['username'] = $username;
        Comment::create($data);
        return redirect()->back();
    }

    public function delete($id, $user_id)
    {
        $user = User::find(auth()->id());

        if ($user->is_admin)
        {
            $comment = Comment::find($id);
            $comment->delete();
            return redirect()->back();
        }
        elseif (auth()->id() == $user_id)
            {
                $comment = Comment::find($id);
                $comment->delete();
                return redirect()->back();
            }
        else
            abort('404');

    }
}
