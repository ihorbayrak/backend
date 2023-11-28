<?php

namespace App\Modules\V1\Post\DTO;

use Illuminate\Http\UploadedFile;

class PostContent
{
    public function __construct(
        public readonly int $profileId,
        public readonly ?string $body,
        public readonly ?UploadedFile $image
    ) {
    }
}
