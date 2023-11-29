<?php

namespace App\Modules\V1\User\Actions;

use App\Models\User;
use App\Modules\V1\Geolocation\Services\GeolocationServiceInterface;

class ProcessLocationAction
{
    public function __construct(
        private GeolocationServiceInterface $geolocationService
    ) {
    }

    public function handle(User $user, string $ip)
    {
        $coordinates = $this->geolocationService->findLocation($ip);

        $user->update([
            'location' => $coordinates
        ]);
    }
}
