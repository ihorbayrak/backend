<?php

namespace App\Modules\V1\Post\Repositories;

use App\Modules\V1\Base\DTO\PaginateQueryParams;
use App\Modules\V1\Post\DTO\PostContent;
use App\Modules\V1\Post\DTO\PostListParams;

interface PostRepositoryInterface
{
    public function list(PaginateQueryParams $paginateDto, PostListParams $postListDto);

    public function feed(PaginateQueryParams $paginateDto, $ownerId);

    public function findById($postId);

    public function create(PostContent $data);

    public function update($postId, PostContent $data);

    public function delete($postId);
}
