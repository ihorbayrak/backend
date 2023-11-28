<?php

namespace App\Modules\V1\User\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class ProfileAlreadyFollowingException extends FailedResponseException
{
    protected $message = "Profile already following";
    protected $code = Response::HTTP_CONFLICT;
}
