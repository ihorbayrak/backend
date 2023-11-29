<?php

namespace App\Http\Controllers\V1;

use App\Modules\V1\Base\DTO\PaginateQueryParams;
use App\Modules\V1\Base\Requests\PaginateRequest;
use App\Modules\V1\Post\DTO\PostContent;
use App\Modules\V1\Post\DTO\PostListParams;
use App\Modules\V1\Post\Repositories\PostRepositoryInterface;
use App\Modules\V1\Post\Requests\CreatePostRequest;
use App\Modules\V1\Post\Requests\ListPostRequest;
use App\Modules\V1\Post\Requests\UpdatePostRequest;
use App\Modules\V1\Post\Resources\PostResource;
use App\Modules\V1\Post\Resources\PostsCollection;
use App\Modules\V1\Post\Services\PostService;
use App\Modules\V1\User\Services\UserService;
use App\Policies\Abilities;

class PostController extends ResponseController
{
    public function __construct(
        private PostService $postService,
        private PostRepositoryInterface $postRepository,
        private UserService $userService
    ) {
    }

    public function list(ListPostRequest $request)
    {
        $paginateDto = new PaginateQueryParams(
            count: $request->getCount(),
            page: $request->getPage()
        );
        $postListDto = new PostListParams(
            liked: $request->get('liked'),
            profile: $request->get('profile')
        );

        $posts = $this->postService->list($paginateDto, $postListDto);

        return $this->responseOk(
            ['data' => new PostsCollection($posts)]
        );
    }

    public function feed(PaginateRequest $request)
    {
        $paginateDto = new PaginateQueryParams(
            count: $request->getCount(),
            page: $request->getPage()
        );

        $posts = $this->postService->feed($paginateDto);

        return $this->responseOk([
            'data' => new PostsCollection($posts)
        ]);
    }

    public function show($postId)
    {
        $post = $this->postRepository->findById($postId, ['profilesLiked', 'profilesReposted']);

        return $this->responseOk([
            'post' => new PostResource($post)
        ]);
    }

    public function store(CreatePostRequest $request)
    {
        $post = $this->postService->create(
            new PostContent(
                profileId: $this->userService->currentUser()->id,
                body: $request->get('body'),
                image: $request->file('image'),
                ip: $request->ip()
            )
        );

        return $this->responseCreated(
            [
                'message' => 'Post created successfully',
                'post' => new PostResource($post)
            ]
        );
    }

    public function update(UpdatePostRequest $request, $postId)
    {
        $this->authorize(Abilities::UPDATE, $this->postRepository->findById($postId));

        $post = $this->postService->update(
            $postId,
            new PostContent(
                profileId: $this->userService->currentUser()->id,
                body: $request->get('body'),
                image: $request->file('image'),
                ip: $request->ip()
            )
        );

        return $this->responseOk(
            ['post' => new PostResource($post)]
        );
    }

    public function destroy($postId)
    {
        $this->authorize(Abilities::DELETE, $this->postRepository->findById($postId));

        $this->postService->delete($postId);

        return response()->noContent();
    }
}
