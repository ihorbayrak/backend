<?php

namespace App\Modules\V1\Comment\Actions;

use App\Modules\V1\Image\DTO\UploadImageData;
use App\Modules\V1\Image\Services\ImageService;
use Illuminate\Http\UploadedFile;

class StoreImageAction
{
    public function __construct(private ImageService $imageService)
    {
    }

    public function handle(UploadedFile $image)
    {
        return $this->imageService->save(
            new UploadImageData(
                image: $image,
                folder: config('aws-s3-folders.comments.images')
            )
        );
    }
}
