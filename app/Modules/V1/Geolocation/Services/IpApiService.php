<?php

namespace App\Modules\V1\Geolocation\Services;

use App\Modules\V1\Geolocation\VO\Coordinates;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class IpApiService implements GeolocationServiceInterface
{
    public function findLocation(string $ip)
    {
        try {
            $client = new Client([
                'base_uri' => "http://ip-api.com/json/",
                'timeout' => 5
            ]);

            $response = $client->get($ip);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['lat']) && !isset($data['lon'])) {
                return null;
            }

            return Coordinates::from($data['lat'], $data['lon']);
        } catch (GuzzleException $e) {
            Log::info($e->getMessage());

            return null;
        }
    }
}
