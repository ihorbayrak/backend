<?php

namespace App\Modules\V1\User\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class DeactivatingFailedException extends FailedResponseException
{
    protected $message = "Deactivating failed";
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
