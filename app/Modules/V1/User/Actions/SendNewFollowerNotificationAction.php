<?php

namespace App\Modules\V1\User\Actions;

use App\Models\Profile;
use App\Modules\V1\User\Notifications\NewFollowerNotification;

class SendNewFollowerNotificationAction
{
    public function handle(Profile $profileToFollow, Profile $owner)
    {
        $notification = new NewFollowerNotification($profileToFollow, $owner);
        $profileToFollow->user->notify($notification);
    }
}
