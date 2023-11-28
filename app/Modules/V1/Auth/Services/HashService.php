<?php

namespace App\Modules\V1\Auth\Services;

use Illuminate\Support\Facades\Hash;

class HashService
{
    public function makeHash(string $value): string
    {
        return Hash::make($value);
    }

    public function isEquals(string $value, string $hash): bool
    {
        return Hash::check($value, $hash);
    }

    public function isNotEquals(string $value, string $hash): bool
    {
        return !Hash::check($value, $hash);
    }
}
