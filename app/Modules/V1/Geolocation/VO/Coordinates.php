<?php

namespace App\Modules\V1\Geolocation\VO;

use InvalidArgumentException;

class Coordinates
{
    private function __construct(
        private readonly float $latitude,
        private readonly float $longitude
    ) {
        $this->validateLatitude($this->latitude);
        $this->validateLongitude($this->longitude);
    }

    public static function from(float $latitude, float $longitude): array
    {
        $class = new self($latitude, $longitude);

        return [
            'lat' => $class->latitude,
            'lon' => $class->longitude
        ];
    }

    private function validateLatitude(float $latitude)
    {
        if ($latitude < -90 || $latitude > 90) {
            throw new InvalidArgumentException('Latitude must be between -90 and 90 degrees');
        }
    }


    private function validateLongitude(float $longitude)
    {
        if ($longitude < -180 || $longitude > 180) {
            throw new InvalidArgumentException('Longitude must be between -180 and 180 degrees');
        }
    }
}
