<?php

namespace App\Modules\V1\Search\DTO;

class SearchFilters
{
    public function __construct(
        public readonly bool $latest,
        public readonly bool $profile,
        public readonly bool $location,
        public readonly bool $followings
    ) {
    }
}
