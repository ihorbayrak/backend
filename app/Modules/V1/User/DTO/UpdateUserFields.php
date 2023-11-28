<?php

namespace App\Modules\V1\User\DTO;

class UpdateUserFields
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $name,
        public readonly ?string $email
    ) {
    }
}
