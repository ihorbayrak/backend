<?php

namespace App\Modules\V1\Comment\DTO;

use Illuminate\Http\UploadedFile;

class CommentContent
{
    public function __construct(
        public readonly int $profileId,
        public readonly ?int $parentId,
        public readonly ?string $body,
        public readonly ?UploadedFile $image
    ) {
    }
}
