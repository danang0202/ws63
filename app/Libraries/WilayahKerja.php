<?php

namespace App\Libraries;

class WilayahKerja
{
    public $kode_bs; // = "3471060005035B";
    public $nama_bs; // = "035B";
    public $kode_desa; // = "005";
    public $nama_desa; // = "TERBAN";
    public $kode_kecamatan; // = "060";
    public $nama_kecamatan; // = "GONDOKUSUMAN";
    public $kode_kabupaten; // = "71";
    public $nama_kabupaten; // = "YOGYAKARTA";
    public $stratifikasi; // = "1";
    public $jumlah; // = "12";
    public $beban_cacah; // = "12";
    public $progress; // = "100.00";
    public $status; // = "uploaded";
    public $jumlahRTLama; // = "119";
    public $jumlahRTBaru; // = "77";
    public $jumlahRTInternet; // = "49";
    public $jumlah_terkirim; // = "12";
    public array $rumahTangga;

    public function __construct(
        $kode_bs,
        $nama_bs,
        $kode_desa,
        $nama_desa,
        $kode_kecamatan,
        $nama_kecamatan,
        $kode_kabupaten,
        $nama_kabupaten,
        $stratifikasi,
        $jumlah,
        $beban_cacah,
        $progress,
        $status,
        $jumlahRTLama,
        $jumlahRTBaru,
        $jumlahRTInternet,
        $jumlah_terkirim,
        array $rumahTangga
    ) {
        $this->kode_bs = $kode_bs;
        $this->nama_bs = $nama_bs;
        $this->kode_desa = $kode_desa;
        $this->nama_desa = $nama_desa;
        $this->kode_kecamatan = $kode_kecamatan;
        $this->nama_kecamatan = $nama_kecamatan;
        $this->kode_kabupaten = $kode_kabupaten;
        $this->nama_kabupaten = $nama_kabupaten;
        $this->stratifikasi = $stratifikasi;
        $this->jumlah = $jumlah;
        $this->beban_cacah = $beban_cacah;
        $this->progress = $progress;
        $this->status = $status;
        $this->jumlahRTLama = $jumlahRTLama;
        $this->jumlahRTBaru = $jumlahRTBaru;
        $this->jumlahRTInternet = $jumlahRTInternet;
        $this->jumlah_terkirim = $jumlah_terkirim;
        $this->rumahTangga = $rumahTangga;
    }
}
