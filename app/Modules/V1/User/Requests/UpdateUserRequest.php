<?php

namespace App\Modules\V1\User\Requests;

use App\Modules\V1\User\Services\UserService;
use App\Modules\V1\Base\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'max:255'],
            'email' => ['sometimes', 'email:rfc,dns', Rule::unique('users', 'email')->ignore($this->id)],
        ];
    }

    protected function prepareForValidation(UserService $userService): void
    {
        $this->merge([
            'id' => $userService->currentUser()->id,
        ]);
    }
}
