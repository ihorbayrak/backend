<?php

namespace App\Modules\V1\User\Requests;

use App\Models\Profile;
use App\Modules\V1\Base\Requests\BaseRequest;
use App\Modules\V1\User\Services\UserService;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'username' => ['sometimes', 'max:255', Rule::unique('profiles', 'username')->ignore($this->id)],
            'bio' => ['sometimes', 'nullable', 'max:'.Profile::MAX_BIO_CHARS],
            'avatar' => [
                'sometimes',
                'nullable',
                'mimes:jpg,jpeg,png',
                File::image()
                    ->max(3 * 1024)
                    ->dimensions(
                        Rule::dimensions()->minHeight(Profile::AVATAR_HEIGHT)->minWidth(Profile::AVATAR_WIDTH)
                    ),
            ],
        ];
    }

    protected function prepareForValidation(UserService $userService)
    {
        $this->merge([
            'id' => $userService->currentUser()->profile->id
        ]);
    }
}
