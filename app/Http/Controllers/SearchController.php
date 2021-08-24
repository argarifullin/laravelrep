<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class SearchController extends Controller
{
    public function index(Request $request)
    {
      $request->validate([
        's'=>'required'
      ]);
      $s=$request->s;
      $posts=Post::like($s)->with('category')->paginate(2);
      return view('posts.search',compact('posts','s'));
    }
}
