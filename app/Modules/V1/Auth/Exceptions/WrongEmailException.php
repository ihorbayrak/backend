<?php

namespace App\Modules\V1\Auth\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class WrongEmailException extends FailedResponseException
{
    protected $message = "Wrong email provided";
    protected $code = Response::HTTP_UNAUTHORIZED;
}
