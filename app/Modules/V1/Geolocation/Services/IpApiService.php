<?php

namespace App\Modules\V1\Geolocation\Services;

use App\Modules\V1\Geolocation\VO\Coordinates;
use GuzzleHttp\Client;

class IpApiService implements GeolocationServiceInterface
{
    public function findLocation(string $ip)
    {
        $client = new Client([
            'base_uri' => "http://ip-api.com/json/",
            'timeout' => 5
        ]);

        $response = $client->get($ip);

        $data = json_decode($response->getBody()->getContents());

        return Coordinates::from($data->lat, $data->lon);
    }
}
