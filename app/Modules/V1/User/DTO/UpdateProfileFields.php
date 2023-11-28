<?php

namespace App\Modules\V1\User\DTO;

class UpdateProfileFields
{
    public function __construct(
        public readonly ?string $username,
        public readonly ?string $bio
    ) {
    }
}
