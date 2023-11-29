<?php

namespace App\Http\Controllers\V1;

use App\Modules\V1\Post\Resources\PostResource;
use App\Modules\V1\Post\Services\PostService;

class RepostController extends ResponseController
{
    public function __construct(private PostService $postService)
    {
    }

    public function store($postId)
    {
        $post = $this->postService->repost($postId);

        return $this->responseOk([
            'post' => new PostResource($post)
        ]);
    }

    public function destroy($postId)
    {
        $post = $this->postService->removeRepost($postId);

        return $this->responseOk(
            ['post' => new PostResource($post)]
        );
    }
}
