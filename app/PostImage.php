<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostImage extends Model
{
    protected $fillable = ['post_id', 'image', 'image_download'];


    public function post(){
        return $this->belongsTo(Post::class);
    }

    // public function getImageAttribute($value){
    //     return Storage::url($value);
    // }
}
