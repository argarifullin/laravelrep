<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Post extends Model
{ use Sluggable;

  protected $fillable = ['title', 'description', 'content', 'category_id', 'thumbnail'];

  public function tags()
  {
    return $this->belongsToMany(Tag::class)->withTimestamps();
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function comments()
  {
      return $this->hasMany(Comment::class);
  }
  /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function uploadImage (Request $request, $image=null)
    {
      if ($request->hasFile('thumbnail')){
        if ($image){
        Storage::delete($image);}
        $folder=date('Y-m-d');
      return $request->file('thumbnail')->store("images/{$folder}");
      }
      return null;
    }

    public function getImage()
    {
      if (!$this->thumbnail){
        return asset("public/noimage.png");
      }
      return asset("public/uploads/{$this->thumbnail}");
    }

    public function getPostDate()
    {
      return Carbon::createFromFormat('Y-m-d H:i:s',$this->created_at)->format('d F Y');
    }

    public function scopeLike($query,$s)
    {
      return $query->where('title','LIKE',"%{$s}%");
    }

}
