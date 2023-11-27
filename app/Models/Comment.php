<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'profile_id',
        'parent_id',
        'body',
        'image'
    ];

    protected $with = [
        'profile'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function profilesLiked()
    {
        return $this->belongsToMany(Profile::class, 'comment_like', 'comment_id', 'profile_id');
    }

    // Check if profile liked comment
    public function likedBy($profileId)
    {
        return $this->profilesLiked()->whereKey($profileId)->exists();
    }
}
