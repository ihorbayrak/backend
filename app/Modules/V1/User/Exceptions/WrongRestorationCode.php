<?php

namespace App\Modules\V1\User\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class WrongRestorationCode extends FailedResponseException
{
    protected $message = "Wrong restoration code provided";
    protected $code = Response::HTTP_UNAUTHORIZED;
}
