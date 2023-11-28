<?php

namespace App\Modules\V1\Image\Exceptions;

use App\Modules\V1\Base\Exceptions\FailedResponseException;
use Illuminate\Http\Response;

class ImageProcessingFailedException extends FailedResponseException
{
    protected $message = "Image processing failed";
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
