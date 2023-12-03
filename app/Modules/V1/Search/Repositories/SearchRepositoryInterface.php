<?php

namespace App\Modules\V1\Search\Repositories;

use App\Modules\V1\Search\DTO\SearchFilters;

interface SearchRepositoryInterface
{
    public function search($query, SearchFilters $filters);
}
