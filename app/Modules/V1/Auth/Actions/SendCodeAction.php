<?php

namespace App\Modules\V1\Auth\Actions;

use App\Modules\V1\Auth\Mail\RestoreEmail;
use Illuminate\Support\Facades\Mail;

class SendCodeAction
{
    public function handle($to, $code)
    {
        Mail::to($to)->send(new RestoreEmail($code));
    }
}
