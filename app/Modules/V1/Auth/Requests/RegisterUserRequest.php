<?php

namespace App\Modules\V1\Auth\Requests;

use App\Modules\V1\Base\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')],
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(),
            ],
        ];
    }
}
