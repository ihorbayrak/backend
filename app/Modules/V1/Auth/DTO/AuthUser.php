<?php

namespace App\Modules\V1\Auth\DTO;

use App\Models\User;

class AuthUser
{
    public function __construct(
        public readonly User $user,
        public readonly string $token
    ) {
    }
}
