<?php

namespace App\Modules\V1\Comment\Repositories;

use App\Models\Comment;
use App\Modules\V1\Comment\Actions\StoreImageAction;
use App\Modules\V1\Comment\DTO\CommentContent;
use App\Modules\V1\Comment\Exceptions\CommentNotFoundException;
use App\Modules\V1\Post\Repositories\PostRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function __construct(private PostRepositoryInterface $postRepository, private StoreImageAction $storeImage)
    {
    }

    public function findById($commentId)
    {
        $comment = Comment::with(['replies'])->find($commentId);

        if (!$comment) {
            throw new CommentNotFoundException();
        }

        return $comment;
    }

    public function findByIdWithPost($postId, $commentId)
    {
        $post = $this->postRepository->findById($postId);

        $comment = $post->comments()->where('id', $commentId)->with(['replies'])->first();

        if (!$comment) {
            throw new CommentNotFoundException();
        }

        return $comment;
    }

    public function all($postId)
    {
        $post = $this->postRepository->findById($postId);

        return $post->comments()->where('parent_id', null)->latest()->get();
    }

    public function create($postId, CommentContent $data)
    {
        $post = $this->postRepository->findById($postId);

        $comment = $post->comments()->create([
            'profile_id' => $data->profileId,
            'parent_id' => $data->parentId,
            'body' => $data->body,
        ]);

        if ($data->image) {
            $comment->update([
                'image' => $this->storeImage->handle($data->image)
            ]);
        }

        return $comment;
    }

    public function delete($postId, $commentId)
    {
        $comment = $this->findByIdWithPost($postId, $commentId);

        $comment->delete();
    }
}
