<?php

namespace App\Modules\V1\Image\DTO;

use Illuminate\Http\UploadedFile;

class UploadImageData
{
    public function __construct(
        public readonly UploadedFile $image,
        public readonly ?string $folder = null,
        public readonly bool $resize = false,
        public readonly ?int $width = null,
        public readonly ?int $height = null
    ) {
    }
}
