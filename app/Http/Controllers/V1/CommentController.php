<?php

namespace App\Http\Controllers\V1;

use App\Modules\V1\Comment\DTO\CommentContent;
use App\Modules\V1\Comment\Repositories\CommentRepositoryInterface;
use App\Modules\V1\Comment\Requests\CreateCommentRequest;
use App\Modules\V1\Comment\Resources\CommentResource;
use App\Modules\V1\Comment\Services\CommentService;
use App\Modules\V1\User\Services\UserService;

class CommentController extends ResponseController
{
    public function __construct(
        private CommentService $commentService,
        private CommentRepositoryInterface $commentRepository,
        private UserService $userService
    ) {
    }

    public function index($postId)
    {
        $comments = $this->commentService->all($postId);

        return $this->responseOk([
            'comments' => CommentResource::collection($comments)
        ]);
    }

    public function store(CreateCommentRequest $request, $postId)
    {
        $comment = $this->commentService->create(
            $postId,
            new CommentContent(
                profileId: $this->userService->currentUser()->id,
                parentId: $request->get('parent_id'),
                body: $request->get('body'),
                image: $request->file('image')
            )
        );

        return $this->responseCreated([
            'message' => "Comment created successfully",
            'comment' => new CommentResource($comment)
        ]);
    }

    public function show($postId, $commentId)
    {
        $comment = $this->commentRepository->findByIdWithPost($postId, $commentId);

        return $this->responseOk([
            'comment' => new CommentResource($comment)
        ]);
    }

    public function destroy($postId, $commentId)
    {
        $this->commentService->delete($postId, $commentId);

        return response()->noContent();
    }
}
