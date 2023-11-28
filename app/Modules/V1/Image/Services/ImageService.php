<?php

namespace App\Modules\V1\Image\Services;

use App\Modules\V1\Image\DTO\UploadImageData;
use App\Modules\V1\Image\Exceptions\ImageDeletingFailed;
use App\Modules\V1\Image\Exceptions\ImageProcessingFailedException;
use App\Modules\V1\Image\Handlers\ImageHandlerInterface;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function __construct(private ImageHandlerInterface $imageHandler)
    {
    }

    public function save(UploadImageData $dto)
    {
        $image = $dto->image;

        $imageName = $this->createImageName($image);
        $path = $dto->folder ? $dto->folder.'/'.$imageName : $imageName;

        if ($dto->resize) {
            $image = $this->imageHandler->resize($image, $dto->width, $dto->height);
        }

        if (!Storage::put($path, file_get_contents($image))) {
            throw new ImageProcessingFailedException();
        }

        return $path;
    }

    public function delete(string $path)
    {
        if (!Storage::delete($path)) {
            throw new ImageDeletingFailed();
        }
    }

    public static function get(?string $path)
    {
        if ($path) {
            return Storage::url($path);
        }

        return null;
    }

    protected function createImageName(UploadedFile $image)
    {
        $extension = $image->getClientOriginalExtension();
        return Carbon::now()->format('Y-m-d').'_'.uniqid().'.'.$extension;
    }
}
