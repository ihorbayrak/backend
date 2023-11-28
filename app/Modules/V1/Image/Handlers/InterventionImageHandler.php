<?php

namespace App\Modules\V1\Image\Handlers;

use App\Modules\V1\Image\Exceptions\ImageProcessingFailedException;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class InterventionImageHandler implements ImageHandlerInterface
{
    public function resize(UploadedFile $image, int $width, int $height): string
    {
        try {
            return (string)Image::make($image)->fit($width, $height)->encode('data-url');
        } catch (\Exception $exception) {
            throw new ImageProcessingFailedException();
        }
    }
}
