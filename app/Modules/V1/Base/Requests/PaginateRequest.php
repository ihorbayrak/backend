<?php

namespace App\Modules\V1\Base\Requests;

class PaginateRequest extends BaseRequest
{
    protected const DEFAULT_COUNT = 5;
    protected const DEFAULT_PAGE = 1;
    protected const MAX_RESULT = 100;

    public function rules(): array
    {
        return [
            'count' => ['sometimes', 'integer', 'min:1', 'max:'.static::MAX_RESULT],
            'page' => ['sometimes', 'integer', 'min:1']
        ];
    }

    public function getCount(): int
    {
        return $this->get('count', static::DEFAULT_COUNT);
    }

    public function getPage(): int
    {
        return $this->get('page', static::DEFAULT_PAGE);
    }
}
