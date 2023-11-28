<?php

namespace App\Modules\V1\Comment\Repositories;

use App\Modules\V1\Comment\DTO\CommentContent;

interface CommentRepositoryInterface
{
    public function findById($commentId);

    public function findByIdWithPost($postId, $commentId);

    public function all($postId);

    public function create($postId, CommentContent $data);

    public function delete($postId, $commentId);
}
