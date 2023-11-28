<?php

namespace App\Modules\V1\User\DTO;

use Illuminate\Http\UploadedFile;

class UpdateProfileFields
{
    public function __construct(
        public readonly ?string $username,
        public readonly ?string $bio,
        public readonly ?UploadedFile $avatar
    ) {
    }
}
