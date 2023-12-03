<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Mahasiswa;
use App\Models\WilayahKerjaModelR4;

// Tidak digunakan di angkatan 62
class MahasiswaModelR4 extends Model
{
    protected $DBGroup              = 'sikoko';
    protected $table                = 'mahasiswa';
    protected $primaryKey           = 'nim';

    public function getMahasiswa($nim): Mahasiswa
    {
        $result = $this->find($nim);
        if (!$result) {
            return null;
        }

        //inisialisasi Wilayah Kerja Riset 4
        $wilayahKerjaModel = new WilayahKerjaModelR4();
        $listWilayahKerja = $wilayahKerjaModel->getAllWilayahKerja($result['nim']);

        $wilayah_kerja = array();
        foreach ($listWilayahKerja as $wilayah) {
            array_push($wilayah_kerja, $wilayahKerjaModel->getWilayahKerja($wilayah['id']));
        }

        $timModel = new TimModel();
        $isKoor = $timModel->where('nim_koor', $nim)->find() ? true : false;

        $mahasiswa = new Mahasiswa(
            $result['nim'],
            $result['nama'],
            $result['no_hp'],
            $result['alamat'],
            $result['email'],
            $result['password'],
            $result['foto'],
            $result['id_tim'],
            $wilayah_kerja,
            $isKoor
        );

        return $mahasiswa;
    }
}
