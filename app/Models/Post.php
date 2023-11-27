<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    const MAX_CHAR = 320;

    protected $fillable = [
        'profile_id',
        'body',
        'image',
        'activity'
    ];

    protected $with = [
        'profile'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function profilesLiked()
    {
        return $this->belongsToMany(Profile::class, 'post_like', 'post_id', 'profile_id');
    }

    public function profilesReposted()
    {
        return $this->belongsToMany(Profile::class, 'reposts', 'post_id', 'profile_id');
    }

    // Check if user liked post
    public function likedBy($profileId)
    {
        return $this->profilesLiked()->whereKey($profileId)->exists();
    }

    // Check if user reposted post
    public function repostedBy($profileId)
    {
        return $this->profilesReposted()->whereKey($profileId)->exists();
    }
}
