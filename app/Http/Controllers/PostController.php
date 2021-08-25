<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index()
    { $posts=Post::with('category')->orderBy('id','desc')->paginate(2);
      return view('posts.index',compact('posts'));
    }

    public function show($slug)
   {
       $post = Post::where('slug', $slug)->firstOrFail();
       $comments = Comment::where('post_id',$post->id)->orderBy('id','desc')->get();
       $post->views += 1;
       $post->update();
       return view('posts.show', compact('post','comments'));
   }
}
