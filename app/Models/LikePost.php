<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikePost extends Model
{
    protected $table = 'liked_posts'; // ✅ FIX HERE

    protected $fillable = ['user_id', 'post_id'];
}
