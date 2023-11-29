<?php

namespace App\Modules\V1\Auth\Services;

use App\Models\User;
use App\Modules\V1\Auth\Actions\SendCodeAction;
use Illuminate\Support\Facades\Cache;

class RestorationService
{
    public function __construct(private SendCodeAction $sendCode)
    {
    }

    public function sendCode(User $user)
    {
        $code = $this->generateCode(8);

        $this->sendCode->handle($user, $code);

        return $code;
    }

    public function match($code, $codeToCheck)
    {
        return $code === $codeToCheck;
    }

    public function store($key, $value, $expiration)
    {
        return Cache::put($key, $value, $expiration);
    }

    public function get($key)
    {
        return Cache::get($key);
    }

    public function delete($key)
    {
        return Cache::forget($key);
    }

    private function generateCode($length)
    {
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code = $code.mt_rand(0, 9);
        }

        return $code;
    }
}
