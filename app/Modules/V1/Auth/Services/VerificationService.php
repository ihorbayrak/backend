<?php

namespace App\Modules\V1\Auth\Services;

use App\Models\User;
use App\Modules\V1\Auth\Actions\SendVerificationEmailAction;
use Carbon\Carbon;
use Illuminate\Support\Str;

class VerificationService
{
    public function __construct(private SendVerificationEmailAction $sendVerificationEmail)
    {
    }

    public function sendEmail(User $user)
    {
        $user->update([
            'email_token' => $this->generateEmailToken()
        ]);

        $this->sendVerificationEmail->handle($user, $this->createVerificationLink($user->email_token));
    }

    public function verifyUser(User $user)
    {
        $user->update([
            'email_token' => null,
            'email_verified_at' => Carbon::now()
        ]);
    }

    private function generateEmailToken()
    {
        return Str::random(64);
    }

    private function createVerificationLink($emailToken)
    {
        return route('verify-email').'?token='.$emailToken;
    }
}
