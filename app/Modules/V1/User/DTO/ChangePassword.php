<?php

namespace App\Modules\V1\User\DTO;

class ChangePassword
{
    public function __construct(
        public readonly int $id,
        public readonly string $newPassword,
        public readonly string $oldPassword
    ) {
    }
}
