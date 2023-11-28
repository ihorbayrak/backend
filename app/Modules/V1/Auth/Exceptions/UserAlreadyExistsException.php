<?php

namespace App\Modules\V1\Auth\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class UserAlreadyExistsException extends FailedResponseException
{
    protected $message = "Users already exists";
    protected $code = Response::HTTP_CONFLICT;
}
