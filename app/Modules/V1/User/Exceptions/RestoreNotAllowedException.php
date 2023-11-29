<?php

namespace App\Modules\V1\User\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class RestoreNotAllowedException extends FailedResponseException
{
    protected $message = "User must be deleted to restore";
    protected $code = Response::HTTP_BAD_REQUEST;
}
