<?php

namespace App\Modules\V1\Search\Repositories\Posts;

use App\Modules\V1\Search\DTO\SearchFilters;

interface PostSearchRepositoryInterface
{
    public function search($query, SearchFilters $filters);
}
