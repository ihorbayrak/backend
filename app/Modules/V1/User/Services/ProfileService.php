<?php

namespace App\Modules\V1\User\Services;

use App\Models\User;
use App\Modules\V1\User\DTO\UpdateProfileFields;
use App\Modules\V1\User\Exceptions\ProfileAlreadyFollowingException;
use App\Modules\V1\User\Exceptions\ProfileFollowsHimselfException;
use App\Modules\V1\User\Repositories\ProfileRepositoryInterface;

class ProfileService
{
    public function __construct(private ProfileRepositoryInterface $profileRepository, private UserService $userService)
    {
    }

    public function update($username, UpdateProfileFields $dto)
    {
        return $this->profileRepository->update($username, $dto);
    }

    public function follow($username)
    {
        $owner = $this->userService->currentUser()->profile;
        $profileToFollow = $this->profileRepository->findByUsername($username);

        if ($owner->id === $profileToFollow->id) {
            throw new ProfileFollowsHimselfException();
        }

        if ($owner->isFollowing($profileToFollow->id)) {
            throw new ProfileAlreadyFollowingException();
        }

        $owner->follows()->attach($profileToFollow->id);

        return $profileToFollow;
    }

    public function unfollow($username)
    {
        $owner = $this->userService->currentUser()->profile;
        $profileToUnfollow = $this->profileRepository->findByUsername($username);

        $owner->follows()->detach($profileToUnfollow->id);

        return $profileToUnfollow;
    }

    public function followers($username)
    {
        return $this->profileRepository->followersList($username);
    }

    public function following($username)
    {
        return $this->profileRepository->followingList($username);
    }

    public function generateProfile(User $user)
    {
        $user->profile()->create([
            'username' => $this->generateUsername($user)
        ]);
    }

    private function generateUsername(User $user)
    {
        $name = str_replace(' ', '', $user->name);

        return $name.$user->id;
    }
}
