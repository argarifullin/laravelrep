<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Comment extends Model
{
    protected $fillable = ['message', 'user_id', 'post_id','username'];

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function getCommentDate()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->created_at)->format('d F Y');
    }
    //
}
