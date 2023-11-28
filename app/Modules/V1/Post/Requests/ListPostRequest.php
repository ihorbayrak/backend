<?php

namespace App\Modules\V1\Post\Requests;

use App\Modules\V1\Base\Requests\PaginateRequest;

class ListPostRequest extends PaginateRequest
{
    protected const DEFAULT_COUNT = 10;
    protected const MAX_RESULT = 50;

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                'liked' => ['sometimes', 'string'],
                'profile' => ['sometimes', 'string']
            ]
        );
    }
}
