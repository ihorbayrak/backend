<?php

namespace App\Modules\V1\Comment\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class CommentNotFoundException extends FailedResponseException
{
    protected $message = 'Comment does not exist';
    protected $code = Response::HTTP_NOT_FOUND;
}
