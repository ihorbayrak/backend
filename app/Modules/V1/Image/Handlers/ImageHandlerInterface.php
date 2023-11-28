<?php

namespace App\Modules\V1\Image\Handlers;

use Illuminate\Http\UploadedFile;

interface ImageHandlerInterface
{
    public function resize(UploadedFile $image, int $width, int $height): string;
}
