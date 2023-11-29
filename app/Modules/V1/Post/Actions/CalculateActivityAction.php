<?php

namespace App\Modules\V1\Post\Actions;

use App\Models\Post;

class CalculateActivityAction
{
    public function handle(Post $post)
    {
        $likes = $post->profilesLiked()->count();
        $comments = $post->comments()->count();
        $reposts = $post->profilesReposted()->count();

        return $likes + ($comments * 2) + ($reposts * 1.5);
    }
}
