<?php

namespace App\Modules\V1\Comment\Services;

use App\Modules\V1\Comment\DTO\CommentContent;
use App\Modules\V1\Comment\Exceptions\CommentAlreadyLikedException;
use App\Modules\V1\Comment\Exceptions\InvalidParentCommentException;
use App\Modules\V1\Comment\Repositories\CommentRepositoryInterface;
use App\Modules\V1\Post\Actions\CalculateActivityAction;
use App\Modules\V1\User\Services\UserService;

class CommentService
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private UserService $userService,
        private CalculateActivityAction $calculateActivity
    ) {
    }

    public function all($postId)
    {
        return $this->commentRepository->all($postId);
    }

    public function create($postId, CommentContent $dto)
    {
        // Check if parent_id match with post
        if ($dto->parentId) {
            $mainComment = $this->commentRepository->findById($dto->parentId);

            if ($mainComment->post_id != $postId) {
                throw new InvalidParentCommentException();
            }
        }

        $comment = $this->commentRepository->create($dto, $postId);

        $comment->post()->update([
            'activity' => $this->calculateActivity->handle($comment->post)
        ]);

        return $comment;
    }

    public function delete($postId, $commentId)
    {
        $this->commentRepository->delete($postId, $commentId);
    }

    public function like($commentId)
    {
        $comment = $this->commentRepository->findById($commentId);
        $profile = $this->userService->currentUser()->profile->id;

        if ($comment->likedBy($profile)) {
            throw new CommentAlreadyLikedException();
        }

        $comment->profilesLiked()->attach($profile);

        return $comment;
    }

    public function unlike($commentId)
    {
        $comment = $this->commentRepository->findById($commentId);
        $profile = $this->userService->currentUser()->id;

        $comment->profilesLiked()->detach($profile);

        return $comment;
    }
}
