<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Modules\V1\Post\Resources\PostResource;
use App\Modules\V1\Post\Services\PostService;

class RepostController extends Controller
{
    public function __construct(private PostService $postService)
    {
    }

    public function store($postId)
    {
        $post = $this->postService->repost($postId);

        return response()->json([
            'post' => new PostResource($post)
        ]);
    }

    public function destroy($postId)
    {
        $post = $this->postService->removeRepost($postId);

        return response()->json([
            'post' => new PostResource($post)
        ]);
    }
}
