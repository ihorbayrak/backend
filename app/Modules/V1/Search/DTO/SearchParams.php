<?php

namespace App\Modules\V1\Search\DTO;

class SearchParams
{
    public function __construct(
        public readonly string $query,
        public readonly ?string $filter,
        public readonly ?string $followsFilter,
        public readonly ?string $locationFilter
    ) {
    }
}
