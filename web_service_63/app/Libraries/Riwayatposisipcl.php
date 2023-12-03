<?php

namespace App\Libraries;

class Riwayatposisipcl
{
    public string $nim;
    public float $latitude;
    public float $longitude;

    public function __construct(
        $nim,
        $latitude,
        $longitude,
    ) {
        $this->nim = $nim;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}
