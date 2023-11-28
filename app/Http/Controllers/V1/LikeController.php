<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Modules\V1\Comment\Resources\CommentResource;
use App\Modules\V1\Comment\Services\CommentService;
use App\Modules\V1\Post\Resources\PostResource;
use App\Modules\V1\Post\Services\PostService;

class LikeController extends Controller
{
    public function __construct(private PostService $postService, private CommentService $commentService)
    {
    }

    public function likePost($postId)
    {
        $post = $this->postService->like($postId);

        return response()->json([
            'post' => new PostResource($post)
        ]);
    }

    public function unlikePost($postId)
    {
        $post = $this->postService->unlike($postId);

        return response()->json([
            'post' => new PostResource($post)
        ]);
    }

    public function likeComment($commentId)
    {
        $comment = $this->commentService->like($commentId);

        return response()->json([
            'comment' => new CommentResource($comment)
        ]);
    }

    public function unlikeComment($commentId)
    {
        $comment = $this->commentService->unlike($commentId);

        return response()->json([
            'comment' => new CommentResource($comment)
        ]);
    }
}
