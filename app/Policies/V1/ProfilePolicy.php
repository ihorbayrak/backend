<?php

namespace App\Policies\V1;

use App\Models\Profile;
use App\Models\User;

class ProfilePolicy
{
    public function update(User $user, Profile $profile): bool
    {
        return $user->id === $profile->user_id;
    }
}
