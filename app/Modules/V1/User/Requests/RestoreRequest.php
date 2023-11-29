<?php

namespace App\Modules\V1\User\Requests;

use App\Modules\V1\Base\Requests\BaseRequest;

class RestoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required'
        ];
    }
}
