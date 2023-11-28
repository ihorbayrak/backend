<?php

namespace App\Modules\V1\User\Repositories;

use App\Models\Profile;
use App\Modules\V1\User\Actions\StoreAvatarAction;
use App\Modules\V1\User\DTO\UpdateProfileFields;
use App\Modules\V1\User\Exceptions\ProfileNotFoundException;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function __construct(private StoreAvatarAction $storeAvatar)
    {
    }

    public function findById($profileId, ?array $with = null)
    {
        $query = Profile::query();

        if (!empty($with)) {
            $query->with($with);
        }

        $profile = $query->find($profileId);

        if (!$profile) {
            throw new ProfileNotFoundException();
        }

        return $profile;
    }

    public function findByUsername($username, ?array $with = null)
    {
        $query = Profile::query();

        if (!empty($with)) {
            $query->with($with);
        }

        $profile = $query->where('username', $username)->first();

        if (!$profile) {
            throw new ProfileNotFoundException();
        }

        return $profile;
    }

    public function update($username, UpdateProfileFields $data)
    {
        $profile = $this->findByUsername($username);

        $profile->update([
            'username' => $data->username ?? $profile->username,
            'bio' => $data->bio
        ]);

        if ($data->avatar) {
            $profile->update([
                'avatar' => $this->storeAvatar->handle($profile, $data->avatar)
            ]);
        }

        return $profile;
    }

    public function followersList($username)
    {
        $profile = $this->findByUsername($username, ['followers']);

        return $this->popularProfiles($profile->followers());
    }

    public function followingList($username)
    {
        $profile = $this->findByUsername($username, ['follows']);

        return $this->popularProfiles($profile->follows());
    }

    private function popularProfiles($query)
    {
        return $query->withCount('followers')->orderByDesc('followers_count')->latest()->get();
    }
}
