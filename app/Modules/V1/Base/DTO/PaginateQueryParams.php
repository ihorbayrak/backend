<?php

namespace App\Modules\V1\Base\DTO;

class PaginateQueryParams
{
    public function __construct(public readonly int $count, public readonly int $page)
    {
    }
}
