<?php

namespace App\Modules\V1\Comment\Services;

use App\Modules\V1\Comment\DTO\CommentContent;
use App\Modules\V1\Comment\Exceptions\InvalidParentCommentException;
use App\Modules\V1\Comment\Repositories\CommentRepositoryInterface;

class CommentService
{
    public function __construct(private CommentRepositoryInterface $commentRepository)
    {
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

        return $comment;
    }


    public function delete($postId, $commentId)
    {
        $this->commentRepository->delete($postId, $commentId);
    }
}
