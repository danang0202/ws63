<?php

namespace App\Libraries;

class RumahtanggaR12
{
    public string $kodeRuta;
    public string $kodeBs;
    public string $noSegmen;
    public string $bf;
    public string $bs;
    public string $noUrutRuta;
    public string $namaKrt;
    public string $alamat;
	public string $objekWisata;
    public string $akomodasiKomersial;
    public string $lainnya;
    public string $TTPWDalam;
    public string $TTPWLuar;
    public string $jmlhanggotaruta;
    public string $nortluarkota;
    public string $nortdalamkota;
    public string $kodeeligible;
    public string $pemberiInformasi;
    public string $pelakuWisata;
    public string $tujuanWisata;
    public $latitude;
    public $longitude;
    public $akurasi;
    public $status;
    public $time;

    // public string $status;

    public function __construct(
        string $kodeRuta,
        string $kodeBs,
        string $noSegmen,
        string $bf,
        string $bs,
        string $noUrutRuta,
        string $namaKrt,
        string $alamat,
        string $objekWisata,
        string $akomodasiKomersial,
        string $lainnya,
        string $TTPWDalam,
        string $TTPWLuar,
        string $jmlhanggotaruta,
        string $nortluarkota,
        string $nortdalamkota,
        string $kodeeligible,
        string $pemberiInformasi,
        string $pelakuWisata,
        string $tujuanWisata,
        $latitude,
        $longitude,
        $akurasi,
        $status,
        $time
    ) {
        $this->kodeRuta = $kodeRuta;
        $this->kodeBs = $kodeBs;
        $this->noSegmen = $noSegmen;
        $this->bf = $bf;
        $this->bs = $bs;
        $this->noUrutRuta = $noUrutRuta;
        $this->namaKrt = $namaKrt;
        $this->alamat = $alamat;
        $this->objekWisata = $objekWisata;
        $this->akomodasiKomersial = $akomodasiKomersial;
        $this->lainnya = $lainnya;
        $this->TTPWDalam = $TTPWDalam;
        $this->TTPWLuar = $TTPWLuar;
        $this->jmlhanggotaruta = $jmlhanggotaruta;
        $this->nortluarkota = $nortluarkota;
        $this->nortdalamkota = $nortdalamkota;
        $this->kodeeligible = $kodeeligible;
        $this->pemberiInformasi = $pemberiInformasi;
        $this->pelakuWisata = $pelakuWisata;
        $this->tujuanWisata = $tujuanWisata;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->akurasi = $akurasi;
        $this->status = $status;
        $this->time = $time;
    }
}