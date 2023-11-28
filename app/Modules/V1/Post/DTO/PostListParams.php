<?php

namespace App\Modules\V1\Post\DTO;

class PostListParams
{
    public function __construct(public readonly ?string $liked, public readonly ?string $profile)
    {
    }
}
