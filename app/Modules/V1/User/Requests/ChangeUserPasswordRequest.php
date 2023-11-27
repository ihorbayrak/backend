<?php

namespace App\Modules\V1\User\Requests;

use App\Modules\V1\Base\Requests\BaseRequest;
use Illuminate\Validation\Rules\Password;

class ChangeUserPasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                'different:old_password',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(),
            ],
        ];
    }
}
