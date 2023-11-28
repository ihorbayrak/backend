<?php

namespace App\Modules\V1\Comment\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class InvalidParentCommentException extends FailedResponseException
{
    protected $message = "Comment does not match with post";
    protected $code = Response::HTTP_BAD_REQUEST;
}
