<?php

namespace App\Modules\V1\Post\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class PostAlreadyRepostedException extends FailedResponseException
{
    protected $message = "You already reposted this post";
    protected $code = Response::HTTP_BAD_REQUEST;
}
