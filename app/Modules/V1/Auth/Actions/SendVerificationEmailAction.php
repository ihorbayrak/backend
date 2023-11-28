<?php

namespace App\Modules\V1\Auth\Actions;

use App\Models\User;
use App\Modules\V1\Auth\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmailAction
{
    public function handle(User $user, $verificationLink)
    {
        Mail::to($user)->send(new VerificationEmail($verificationLink));
    }
}
