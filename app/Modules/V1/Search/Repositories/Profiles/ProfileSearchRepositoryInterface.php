<?php

namespace App\Modules\V1\Search\Repositories\Profiles;

use App\Modules\V1\Search\DTO\SearchFilters;

interface ProfileSearchRepositoryInterface
{
    public function search($query, SearchFilters $filters);
}
