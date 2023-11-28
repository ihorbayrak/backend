<?php

namespace App\Modules\V1\Image\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class ImageDeletingFailed extends FailedResponseException
{
    protected $message = "Image deleting failed";
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
