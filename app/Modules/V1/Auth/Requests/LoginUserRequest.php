<?php

namespace App\Modules\V1\Auth\Requests;

use App\Modules\V1\Base\Requests\BaseRequest;

class LoginUserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'string']
        ];
    }
}
