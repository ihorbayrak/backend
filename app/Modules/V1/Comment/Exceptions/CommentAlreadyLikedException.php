<?php

namespace App\Modules\V1\Comment\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class CommentAlreadyLikedException extends FailedResponseException
{
    protected $message = "Already liked this comment";
    protected $code = Response::HTTP_BAD_REQUEST;
}
