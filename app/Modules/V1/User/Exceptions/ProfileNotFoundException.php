<?php

namespace App\Modules\V1\User\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class ProfileNotFoundException extends FailedResponseException
{
    protected $message = 'This profile does not exists';
    protected $code = Response::HTTP_NOT_FOUND;
}
