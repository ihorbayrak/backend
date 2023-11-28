<?php

namespace App\Modules\V1\Image\DTO;

use App\Models\Profile;
use Illuminate\Http\UploadedFile;

class UploadImageData
{
    public function __construct(
        public readonly UploadedFile $image,
        public readonly ?string $folder = null,
        public readonly bool $resize = false,
        public readonly ?int $width = Profile::AVATAR_WIDTH,
        public readonly ?int $height = Profile::AVATAR_HEIGHT
    ) {
    }
}
