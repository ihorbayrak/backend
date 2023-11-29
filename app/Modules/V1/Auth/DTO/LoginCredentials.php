<?php

namespace App\Modules\V1\Auth\DTO;

class LoginCredentials
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $ip
    ) {
    }
}
