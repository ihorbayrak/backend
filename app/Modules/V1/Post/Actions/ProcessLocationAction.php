<?php

namespace App\Modules\V1\Post\Actions;

use App\Models\Post;
use App\Modules\V1\Geolocation\Services\GeolocationServiceInterface;

class ProcessLocationAction
{
    public function __construct(
        private GeolocationServiceInterface $geolocationService
    ) {
    }

    public function handle(Post $post, string $ip)
    {
        $coordinates = $this->geolocationService->findLocation($ip);

        $post->update([
            'location' => $coordinates
        ]);
    }
}
