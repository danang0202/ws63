<?php

namespace App\Libraries;

class RumahtanggaSby
{
    public string $kodeRuta;
    public string $kodeBs;
    public string $nomorUrut;
    public string $noSegmen;
    public string $bf;
    public string $bs;
    public string $namaPemberiInformasi;
    public string $noHp;
    public string $provider;
    public string $alamatDomisili;
	public string $provinsi;
    public string $kodeProvinsi;
    public string $kabkot;
    public string $kodeKabkot;
    public string $kecamatan;
    public string $kodeKecamatan;
    public string $kelurahan;
    public string $kodeKelurahan;
    public $latitude;
    public $longitude;
    public $akurasi;
    public $status;
    public $time;

    // public string $status;

    public function __construct(
        string $kodeRuta,
        string $kodeBs,
        string $nomorUrut,
        string $noSegmen,
        string $bf,
        string $bs,
        string $namaPemberiInformasi,
        string $noHp,
        string $provider,
        string $alamatDomisili,
        string $provinsi,
        string $kodeProvinsi,
        string $kabkot,
        string $kodeKabkot,
        string $kecamatan,
        string $kodeKecamatan,
        string $kelurahan,
        string $kodeKelurahan,
        $latitude,
        $longitude,
        $akurasi,
        $status,
        $time
    ) {
        $this->kodeRuta = $kodeRuta;
        $this->kodeBs = $kodeBs;
        $this->nomorUrut = $nomorUrut;
        $this->noSegmen = $noSegmen;
        $this->bf = $bf;
        $this->bs = $bs;
        $this->namaPemberiInformasi =  $namaPemberiInformasi;
        $this->noHp = $noHp;
        $this->provider = $provider;
        $this->alamatDomisili =  $alamatDomisili;
        $this->provinsi = $provinsi;
        $this->kodeProvinsi = $kodeProvinsi;
        $this->kabkot = $kabkot;
        $this->kodeKabkot =  $kodeKabkot;
        $this->kecamatan = $kecamatan;
        $this->kodeKecamatan = $kodeKecamatan;
        $this->kelurahan = $kelurahan;
        $this->kodeKelurahan = $kodeKelurahan;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->akurasi = $akurasi;
        $this->status = $status;
        $this->time = $time;
    }
}
