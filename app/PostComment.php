<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = ['post_id', 'title', 'user_id', 'message', 'approved'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
