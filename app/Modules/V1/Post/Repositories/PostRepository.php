<?php

namespace App\Modules\V1\Post\Repositories;

use App\Models\Post;
use App\Modules\V1\Base\DTO\PaginateQueryParams;
use App\Modules\V1\Post\Actions\StoreImageAction;
use App\Modules\V1\Post\DTO\PostContent;
use App\Modules\V1\Post\DTO\PostListParams;
use App\Modules\V1\Post\Exceptions\PostNotFoundException;
use App\Modules\V1\User\Repositories\ProfileRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository,
        private StoreImageAction $storeImage
    ) {
    }

    public function list(PaginateQueryParams $paginateDto, PostListParams $postListDto): LengthAwarePaginator
    {
        $posts = Post::query()->latest();
        $this->filter($posts, $postListDto);

        return $posts->paginate(perPage: $paginateDto->count, page: $paginateDto->page);
    }

    public function feed(PaginateQueryParams $paginateDto, $ownerId): LengthAwarePaginator
    {
        $owner = $this->profileRepository->findById($ownerId);

        $posts = Post::query()->latest();
        $posts->whereHas(
            'profile',
            fn($query) => $query->whereIn('id', $owner->follows->pluck('id'))
        );

        return $posts->paginate(perPage: $paginateDto->count, page: $paginateDto->page);
    }

    public function findById($postId, ?array $with = null): Post
    {
        $query = Post::query();

        if (!empty($with)) {
            $query->with($with);
        }

        $post = $query->find($postId);

        if (!$post) {
            throw new PostNotFoundException();
        }

        return $post;
    }

    public function create(PostContent $data): Post
    {
        $post = Post::create([
            'profile_id' => $data->profileId,
            'body' => $data->body,
        ]);

        if ($data->image) {
            $post->update([
                'image' => $this->storeImage->handle($post, $data->image)
            ]);
        }

        return $post;
    }

    public function update($postId, PostContent $data): Post
    {
        $post = $this->findById($postId);

        $post->body = $data->body;
        $post->image = null;

        if ($data->image) {
            $post->image = $this->storeImage->handle($post, $data->image);
        }

        $post->save();
        return $post;
    }

    public function delete($postId)
    {
        $post = $this->findById($postId);

        $post->delete();
    }

    private function filter(Builder $qb, PostListParams $filters)
    {
        // Get posts liked by profile
        if ($filters->liked) {
            $qb->whereHas('profilesLiked', fn($query) => $query->where('username', $filters->liked));
        }

        // Get posts associated with specific profile
        if ($filters->profile) {
            $qb->whereHas('profile', fn($query) => $query->where('username', $filters->profile))
                ->orWhereHas('profilesReposted', fn($query) => $query->where('username', $filters->profile));
        }
    }
}
