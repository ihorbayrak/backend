<?php

namespace App\Modules\V1\Auth\DTO;

class RegisterCredentials
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $ip = null
    ) {
    }
}
