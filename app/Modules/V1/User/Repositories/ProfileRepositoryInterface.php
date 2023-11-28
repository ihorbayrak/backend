<?php

namespace App\Modules\V1\User\Repositories;

use App\Modules\V1\User\DTO\UpdateProfileFields;

interface ProfileRepositoryInterface
{
    public function findById($profileId);

    public function findByUsername($username);

    public function update($username, UpdateProfileFields $data);

    public function followersList($username);

    public function followingList($username);
}
