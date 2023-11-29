<?php

namespace App\Modules\V1\Search\Requests;

use App\Modules\V1\Base\Requests\BaseRequest;

class SearchRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'q' => ['required', 'string'], // query
            'f' => ['sometimes', 'string'], // filter by
            'lf' => ['sometimes', 'string'], // location filter
            'pf' => ['sometimes', 'string'] // profile follows filter
        ];
    }
}
