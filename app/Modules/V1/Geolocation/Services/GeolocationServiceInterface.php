<?php

namespace App\Modules\V1\Geolocation\Services;

interface GeolocationServiceInterface
{
    public function findLocation(string $ip);
}
