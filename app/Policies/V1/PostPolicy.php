<?php

namespace App\Policies\V1;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post): bool
    {
        return $user->profile->id === $post->profile_id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->profile->id === $post->profile_id;
    }
}
