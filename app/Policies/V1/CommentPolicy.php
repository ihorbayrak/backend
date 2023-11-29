<?php

namespace App\Policies\V1;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function delete(User $user, Comment $comment): bool
    {
        return $user->profile->id === $comment->profile_id;
    }
}
