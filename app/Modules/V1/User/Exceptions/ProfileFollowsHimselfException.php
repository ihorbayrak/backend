<?php

namespace App\Modules\V1\User\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class ProfileFollowsHimselfException extends FailedResponseException
{
    protected $message = "Cannot follow yourself";
    protected $code = Response::HTTP_BAD_REQUEST;
}
