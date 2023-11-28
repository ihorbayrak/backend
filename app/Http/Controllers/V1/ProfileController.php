<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Modules\V1\User\DTO\UpdateProfileFields;
use App\Modules\V1\User\Repositories\ProfileRepositoryInterface;
use App\Modules\V1\User\Requests\UpdateProfileRequest;
use App\Modules\V1\User\Resources\ProfileInfoResource;
use App\Modules\V1\User\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(
        private ProfileService $profileService,
        private ProfileRepositoryInterface $profileRepository
    ) {
    }

    public function show($username)
    {
        $profile = $this->profileRepository->findByUsername($username);

        return response()->json(new ProfileInfoResource($profile));
    }

    public function update(UpdateProfileRequest $request, $username)
    {
        $dto = new UpdateProfileFields(
            username: $request->get('username'),
            bio: $request->get('bio'),
            avatar: $request->get('avatar')
        );

        $profile = $this->profileService->update($username, $dto);

        return response()->json(new ProfileInfoResource($profile));
    }

    public function follow($username)
    {
        $profile = $this->profileService->follow($username);

        return response()->json(new ProfileInfoResource($profile));
    }

    public function unfollow($username)
    {
        $profile = $this->profileService->unfollow($username);

        return response()->json(new ProfileInfoResource($profile));
    }

    public function followers($username)
    {
        $followers = $this->profileService->followers($username);

        return response()->json(ProfileInfoResource::collection($followers));
    }

    public function following($username)
    {
        $following = $this->profileService->following($username);

        return response()->json(ProfileInfoResource::collection($following));
    }
}
