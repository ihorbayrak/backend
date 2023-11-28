<?php

namespace App\Modules\V1\Post\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class PostAlreadyLikedException extends FailedResponseException
{
    protected $message = "Already liked this post";
    protected $code = Response::HTTP_BAD_REQUEST;
}
