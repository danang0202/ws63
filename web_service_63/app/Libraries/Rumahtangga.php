<?php

namespace App\Libraries;

class Rumahtangga
{
    public string $noSegmen;
    public int $akurasi;
    public string $alamat;
    public string $noHp;
    public string $bf;
    public string $bs;
    public string $kodeBs;
    public string $kodeRuta;
    public float $latitude;
    public float $longitude;
    public string $namaKrt;
    public string $keterangan;
    public string $noUrutRuta;
    public int $rutaInternet;
    public int $rutaPergi;
    public string $status;

    public function __construct(
        $noSegmen,
        $akurasi,
        $alamat,
        $noHp,
        $bf,
        $bs,
        $kodeBs,
        $kodeRuta,
        $latitude,
        $longitude,
        $namaKrt,
        $keterangan,
        $noUrutRuta,
        $rutaInternet,
        $rutaPergi,
        $status = ''
    ) {
        $this->noSegmen = $noSegmen;
        $this->akurasi = $akurasi;
        $this->alamat = $alamat;
        $this->noHp = $noHp;
        $this->bf = $bf;
        $this->bs = $bs;
        $this->kodeBs = $kodeBs;
        $this->kodeRuta = $kodeRuta;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->namaKrt = $namaKrt;
        $this->keterangan = $keterangan;
        $this->noUrutRuta = $noUrutRuta;
        $this->rutaInternet = $rutaInternet;
        $this->rutaPergi = $rutaPergi;
        $this->status = $status;
    }
}
