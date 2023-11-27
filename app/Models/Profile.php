<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    const MAX_BIO_CHARS = 180;

    protected $fillable = [
        'user_id',
        'username',
        'bio',
        'avatar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function follows()
    {
        return $this->belongsToMany(Profile::class, 'follow_profile', 'profile_id', 'follows_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(Profile::class, 'follow_profile', 'follows_id', 'profile_id')->withTimestamps();
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_like', 'profile_id', 'post_id');
    }

    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_like', 'profile_id', 'comment_id');
    }

    public function reposts()
    {
        return $this->belongsToMany(Post::class, 'reposts', 'profile_id', 'post_id');
    }

    // Check if you are following someone
    public function isFollowing($profileId)
    {
        return $this->follows()->whereKey($profileId)->exists();
    }

    // Check if you are followed by someone
    public function isFollower($followerId)
    {
        return $this->followers()->whereKey($followerId)->exists();
    }
}
