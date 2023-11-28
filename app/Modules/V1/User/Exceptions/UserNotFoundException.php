<?php

namespace App\Modules\V1\User\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class UserNotFoundException extends FailedResponseException
{
    protected $message = 'User not found';
    protected $code = Response::HTTP_NOT_FOUND;
}
