<?php

namespace App\Modules\V1\User\Actions;

use App\Models\Profile;
use App\Modules\V1\Image\DTO\UploadImageData;
use App\Modules\V1\Image\Services\ImageService;
use Illuminate\Http\UploadedFile;

class StoreAvatarAction
{
    public function __construct(private ImageService $imageService)
    {
    }

    public function handle(Profile $profile, UploadedFile $avatar)
    {
        // If profile already has avatar then removing old avatar from storage
        if ($profile->avatar) {
            $this->imageService->delete($profile->avatar);
        }

        return $this->imageService->save(
            new UploadImageData(
                image: $avatar,
                folder: config('aws-s3-folders.profiles.avatars'),
                resize: true,
                width: Profile::AVATAR_WIDTH,
                height: Profile::AVATAR_WIDTH
            )
        );
    }
}
