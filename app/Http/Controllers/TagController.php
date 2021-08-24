<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;

class TagController extends Controller
{
  public function show($slug)
  { $tag=Tag::where('slug',$slug)->firstOrFail();
    $posts=$tag->posts()->with('category')->orderBy('id','desc')->paginate(2);
    return view('tags.show',compact('tag','posts'));
  }
}
