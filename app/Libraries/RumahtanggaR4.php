<?php

namespace App\Libraries;

class RumahtanggaR4
{
    public $kodeUUP;
    public $kodeBs;
    public $noSegmen;
    public $bf;
    public $bs;
    public $noUrutRuta;
    public $namaKRT;
    public $alamat;
    public $jumlahisUUP;
    public $noUrutPemilikUUP;
    public $namaPemilikUUP;
    public $kedudukanUP;
    public $statusKelola;
    public $tanggungJawab;
    public $lokasiUP;
    public $skalaUsaha;
    public $jenisUUP;
    public $noUrutUUP;
	public $catatan;
    public $latitude;
    public $longitude;
    public $akurasi;
	public $status;
    public $time;


    public function __construct(
        $kodeUUP,
        $kodeBs,
        $noSegmen,
        $bf,
        $bs,
        $noUrutRuta,
        $namaKRT,
        $alamat,
        $jumlahisUUP,
        $noUrutPemilikUUP,
        $namaPemilikUUP,
        $kedudukanUP,
        $statusKelola,
        $tanggungJawab,
        $lokasiUP,
        $skalaUsaha,
        $jenisUUP,
        $noUrutUUP,
    	$catatan,
        $latitude,
        $longitude,
        $akurasi,
        $status,
        $time
    ) {
        $this->kodeUUP = $kodeUUP;
        $this->kodeBs = $kodeBs;
        $this->noSegmen = $noSegmen;
        $this->bf = $bf;
        $this->bs = $bs;
        $this->noUrutRuta = $noUrutRuta;
        $this->namaKRT = $namaKRT;
        $this->alamat = $alamat;
        $this->jumlahisUUP = $jumlahisUUP;
        $this->noUrutPemilikUUP = $noUrutPemilikUUP;
        $this->namaPemilikUUP = $namaPemilikUUP;
        $this->kedudukanUP = $kedudukanUP;
        $this->statusKelola = $statusKelola;
        $this->tanggungJawab = $tanggungJawab;
        $this->lokasiUP = $lokasiUP;
        $this->skalaUsaha = $skalaUsaha;
        $this->jenisUUP = $jenisUUP;
        $this->noUrutUUP = $noUrutUUP;
    	$this->catatan = $catatan;
        $this->latitude = (float) $latitude;
        $this->longitude = (float) $longitude;
        $this->akurasi = $akurasi;
        $this->status = $status;
        $this->time = $time;
    }
}