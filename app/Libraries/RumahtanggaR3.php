<?php

namespace App\Libraries;

class RumahtanggaR3
{
    public $kodeRuta;
    public $kodeBs;
    public $noSLS;
    public $bf;
    public $bs;
    public $noUrutRuta;
    public $namaKRT;
    public $alamat;
    public $jumlahART;
    public $jumlahART10;
    public $noHp;
    public $noHp2;
    public $kodeEligible;
    public $latitude;
    public $longitude;
    public $akurasi;
    public $status;
    public $time;

    public function __construct(
        $kodeRuta,
        $kodeBs,
        $noSLS,
        $bf,
        $bs,
        $noUrutRuta,
        $namaKRT,
        $alamat,
        $jumlahART,
        $jumlahART10,
        $noHp,
        $noHp2,
        $kodeEligible,
        $latitude,
        $longitude,
        $akurasi,
        $status,
        $time
    ) {
        $this->kodeRuta = $kodeRuta;
        $this->kodeBs = $kodeBs;
        $this->noSLS = $noSLS;
        $this->bf = $bf;
        $this->bs = $bs;
        $this->noUrutRuta = $noUrutRuta;
        $this->namaKRT = $namaKRT;
        $this->alamat = $alamat;
        $this->jumlahART = $jumlahART;
        $this->jumlahART10 = $jumlahART10;
        $this->noHp = $noHp;
        $this->noHp2 = $noHp2;
        $this->kodeEligible = $kodeEligible;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->akurasi = $akurasi;
        $this->status = $status;
        $this->time = $time;
    }
}
