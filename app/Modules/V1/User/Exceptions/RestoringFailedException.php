<?php

namespace App\Modules\V1\User\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class RestoringFailedException extends FailedResponseException
{
    protected $message = "Restoring failed";
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
