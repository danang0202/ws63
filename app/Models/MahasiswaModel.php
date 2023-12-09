<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Mahasiswa;
use App\Models\WilayahKerjaModelR12;
use App\Models\WilayahKerjaModelR3;
use App\Models\WilayahKerjaModelR4_2;
use App\Models\SampelModelR12;
use App\Models\SampelModelR3;
use App\Models\SampelModelR4;

class MahasiswaModel extends Model
{
    //Inisialisasi database dan tabel yang digunakan di database
    protected $DBGroup              = 'sikoko';
    protected $table                = 'mahasiswa';
    protected $primaryKey           = 'nim';

    public function getMahasiswa($nim): Mahasiswa
    {
        $result = $this->find($nim);
        if (!$result) {
            return null;
        }

        //inisialisasi Wilayah Kerja
        $riset_Sby = [1, 3];
        $riset_12 = [4, 62];
        $riset_3 = [63, 94];
        $riset_4 = [95, 125];

        // if (((int) $result['id_tim'] >= $riset_12[0] && (int) $result['id_tim'] <= $riset_12[1]) || (int) $result['id_tim'] == 991 || (int) $result['id_tim'] == 992) {
        //     $wilayahKerjaModel = new WilayahKerjaModelR12();
        //     $sampelModel = new SampelModelR12();
        // } else if (((int) $result['id_tim'] >= $riset_3[0] && (int) $result['id_tim'] <= $riset_3[1]) || (int) $result['id_tim'] == 993) {
        //     $wilayahKerjaModel = new WilayahKerjaModelR3();
        //     $sampelModel = new SampelModelR3();
        // } else if (((int) $result['id_tim'] >= $riset_4[0] && (int) $result['id_tim'] <= $riset_4[1]) || (int) $result['id_tim'] == 994 || ((int) $result['id_tim'] >= 441 && (int) $result['id_tim'] <= 444)) {
        //     $wilayahKerjaModel = new WilayahKerjaModelR4_2();
        //     $sampelModel = new SampelModelR4();
        // } else if (((int) $result['id_tim'] >= $riset_Sby[0] && (int) $result['id_tim'] <= $riset_Sby[1]) || (int) $result['id_tim'] == 995) {
        //     $wilayahKerjaModel = new WilayahKerjaModelSby();
        //     $sampelModel = new SampelModelSby();
        // }

        // $listWilayahKerja = $wilayahKerjaModel->getAllWilayahKerja($result['nim']);

        // $wilayah_kerja = array();
        // $total_terkirim = 0;
        // foreach ($listWilayahKerja as $wilayah) {
        //     array_push($wilayah_kerja, $wilayahKerjaModel->getWilayahKerja($wilayah['id']));
        //     $total_terkirim += $wilayahKerjaModel->getJumlahTerkirim($wilayah['id']);
        // }

        // $timModel = new TimModel();
        // $isKoor = $timModel->where('nim_koor', $nim)->find() ? true : false;

        // $beban_kerja = $sampelModel->getBebanKerja($nim);
        // if ($beban_kerja > 0) {
        //     $total_progress = (int) $total_terkirim / $beban_kerja;
        // } else {
        //     $total_progress = 0;
        // }

        $mahasiswa = new Mahasiswa(
            $result['nim'],
            $result['nama'],
            $result['no_hp'],
            $result['alamat'],
            // $result['email'],
            $result['password'],
            // $result['foto'],
            // $result['id_tim'],
            // $wilayah_kerja,
            // $total_progress,
            // $isKoor
        );

        return $mahasiswa;
    }
}
