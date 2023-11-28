<?php

namespace App\Modules\V1\Post\Services;

use App\Modules\V1\Base\DTO\PaginateQueryParams;
use App\Modules\V1\Post\DTO\PostContent;
use App\Modules\V1\Post\DTO\PostListParams;
use App\Modules\V1\Post\Exceptions\PostAlreadyLikedException;
use App\Modules\V1\Post\Exceptions\PostAlreadyRepostedException;
use App\Modules\V1\Post\Repositories\PostRepositoryInterface;
use App\Modules\V1\User\Services\UserService;

class PostService
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private UserService $userService
    ) {
    }

    public function list(PaginateQueryParams $paginateDto, PostListParams $postListDto)
    {
        return $this->postRepository->list($paginateDto, $postListDto);
    }

    public function feed(PaginateQueryParams $paginateDto)
    {
        return $this->postRepository->feed($paginateDto, $this->userService->currentUser()->id);
    }

    public function create(PostContent $dto)
    {
        $post = $this->postRepository->create($dto);

        return $post;
    }

    public function update($postId, PostContent $dto)
    {
        $post = $this->postRepository->update($postId, $dto);

        return $post;
    }

    public function delete($postId)
    {
        $this->postRepository->delete($postId);
    }

    public function repost($postId)
    {
        $post = $this->postRepository->findById($postId);
        $profile = $this->userService->currentUser()->id;

        if ($post->respostedBy($profile)) {
            throw new PostAlreadyRepostedException();
        }

        $post->profilesReposted()->attach($profile);

        return $post;
    }

    public function removeRepost($postId)
    {
        $post = $this->postRepository->findById($postId);
        $profile = $this->userService->currentUser()->id;

        $post->profilesReposted()->detach($profile);

        return $post;
    }

    public function like($postId)
    {
        $post = $this->postRepository->findById($postId);
        $profile = $this->userService->currentUser()->id;

        if ($post->likedBy($profile)) {
            throw new PostAlreadyLikedException();
        }

        $post->profilesLiked()->attach($profile);

        return $post;
    }

    public function unlike($postId)
    {
        $post = $this->postRepository->findById($postId);
        $profile = $this->userService->currentUser()->id;

        $post->profilesLiked()->detach($profile);

        return $post;
    }
}
