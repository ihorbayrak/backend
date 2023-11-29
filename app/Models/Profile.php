<?php

namespace App\Models;

use App\Modules\V1\Search\Services\Elasticsearch\Searchable;
use App\Modules\V1\Search\Services\Elasticsearch\SearchableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Profile
 *
 * @property int $id
 * @property int $user_id
 * @property string $username
 * @property string|null $bio
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Profile> $followers
 * @property-read int|null $followers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Profile> $follows
 * @property-read int|null $follows_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $likedComments
 * @property-read int|null $liked_comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $likedPosts
 * @property-read int|null $liked_posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $reposts
 * @property-read int|null $reposts_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile withoutTrashed()
 * @mixin \Eloquent
 */
class Profile extends Model implements Searchable
{
    use HasFactory, SoftDeletes, SearchableTrait;

    const MAX_BIO_CHARS = 180;
    const AVATAR_WIDTH = 180;
    const AVATAR_HEIGHT = 180;

    protected $fillable = [
        'user_id',
        'username',
        'bio',
        'avatar',
    ];

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn(?string $path) => $path ? Storage::url($path) : Storage::url(
                config('aws-s3-folders.profiles.placeholders')
            ),
        );
    }

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

    public function toArray(): array
    {
        $profile = parent::toArray();

        return array_merge($profile, $this->user->toArray());
    }
}
