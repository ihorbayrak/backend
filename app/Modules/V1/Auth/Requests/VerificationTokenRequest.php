<?php

namespace App\Modules\V1\Auth\Requests;

use App\Modules\V1\Base\Requests\BaseRequest;

class VerificationTokenRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'token' => ['required', 'string']
        ];
    }
}
