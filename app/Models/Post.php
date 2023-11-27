<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $profile_id
 * @property string|null $body
 * @property string|null $image
 * @property float $activity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Profile> $profilesLiked
 * @property-read int|null $profiles_liked_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Profile> $profilesReposted
 * @property-read int|null $profiles_reposted_count
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
