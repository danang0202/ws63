<?php

namespace App\Libraries;

class Posisipcl
{
    public string $nim;
    public string $nama_tim;
    public float $latitude;
    public float $longitude;



    public function __construct(
        $nim,
        $nama_tim,
        $latitude,
        $longitude,
    ) {
        $this->nim = $nim;
        $this->nama_tim = $nama_tim;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}
