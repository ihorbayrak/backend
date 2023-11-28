<?php

namespace App\Modules\V1\Post\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class PostNotFoundException extends FailedResponseException
{
    protected $message = 'Post with this identifier not found';
    protected $code = Response::HTTP_NOT_FOUND;
}
