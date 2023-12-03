<?php

namespace App\Libraries;

class RumahtanggaR5
{
    public $noSls;
    public $akurasi;
    public $alamat;
    public $bf;
    public $bs;
    public $kodeBs;
    public $kodeRuta;
    public $latitude;
    public $longitude;
    public $timestamp;
    public $noUrutRuta;
    public $rtUp;
    public $noRtUp;
    public $statusPetaniTerhadapKrt;
    public $namaPetani;
    public $jkPetani;
    public $umurPetani;
    public $pendidikanPetani;
    public $alatKomunikasi_1;
    public $alatKomunikasi_2;
    public $alatKomunikasi_3;
    public $alatKomunikasi_4;
    public $alatKomunikasi_5;
    public $moda_cawi;
    public $moda_ti;
    public $moda_tidakMemilih;
    public $statusCpTerhadapPetani;
    public $namaCp;
    public $noHpCp;
    public $emailCp;

    public function __construct(
        $noSls,
        $akurasi,
        $alamat,
        $bf,
        $bs,
        $kodeBs,
        $kodeRuta,
        $latitude,
        $longitude,
        $timestamp,
        $namaKrt,
        $noUrutRuta,
        $rtUp,
        $noRtUp,
        $statusPetaniTerhadapKrt,
        $namaPetani,
        $jkPetani,
        $umurPetani,
        $pendidikanPetani,
        $alatKomunikasi_1,
        $alatKomunikasi_2,
        $alatKomunikasi_3,
        $alatKomunikasi_4,
        $alatKomunikasi_5,
        $moda_cawi,
        $moda_ti,
        $moda_tidakMemilih,
        $statusCpTerhadapPetani,
        $namaCp,
        $noHpCp,
        $emailCp
    ) {
        $this->noSls = $noSls;
        $this->akurasi = $akurasi;
        $this->alamat = $alamat;
        $this->bf = $bf;
        $this->bs = $bs;
        $this->kodeBs = $kodeBs;
        $this->kodeRuta = $kodeRuta;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->timestamp = $timestamp;
        $this->namaPetani= $namaKrt;
        $this->noUrutRuta = $noUrutRuta;
        $this->rtUp = $rtUp;
        $this->noRtUp = $noRtUp;
        $this->statusPetaniTerhadapKrt = $statusPetaniTerhadapKrt;
        $this->namaPetani = $namaPetani;
        $this->jkPetani = $jkPetani;
        $this->umurPetani = $umurPetani;
        $this->pendidikanPetani = $pendidikanPetani;
        $this->alatKomunikasi_1 = $alatKomunikasi_1;
        $this->alatKomunikasi_2 = $alatKomunikasi_2;
        $this->alatKomunikasi_3 = $alatKomunikasi_3;
        $this->alatKomunikasi_4 = $alatKomunikasi_4;
        $this->alatKomunikasi_5 = $alatKomunikasi_5;
        $this->moda_cawi = $moda_cawi;
        $this->moda_ti = $moda_ti;
        $this->moda_tidakMemilih = $moda_tidakMemilih;
        $this->statusCpTerhadapPetani = $statusCpTerhadapPetani;
        $this->namaCp = $namaCp;
        $this->noHpCp = $noHpCp;
        $this->emailCp = $emailCp;
    }
}
