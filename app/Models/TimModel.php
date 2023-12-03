<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Tim;
use App\Models\MahasiswaModel;
use App\Libraries\Mahasiswa;

class TimModel extends Model
{
    protected $DBGroup              = 'sikoko';
    protected $table                = 'timpencacah';
    protected $primaryKey           = 'id_tim';

    public function getTim($id_tim): Tim
    {
        $result = $this->find($id_tim);

        $mahasiswaModel = new MahasiswaModel();
        $tim = new Tim(
            $result['id_tim'],
            $result['nama_tim'],
            $mahasiswaModel->getMahasiswa($result['nim_koor']),
            $this->getAnggotaTim($id_tim)
        );

        return $tim;
    }

    public function getAnggotaTim($id_tim): array
    {
        $mahasiswaModel = new MahasiswaModel();

        $list_anggota = $this->getAllAnggota($id_tim);
        $result = $this->find($id_tim);

        $anggota_tim = array();
        foreach ($list_anggota as $anggota) {
            if ($anggota['nim'] == $result['nim_koor'])
                continue;
            array_push($anggota_tim, $mahasiswaModel->getMahasiswa($anggota['nim']));
        }

        return $anggota_tim;
    }

    public function getAllAnggota($id_tim): array
    {
        $mahasiswaModel = new MahasiswaModel();
        $result = $mahasiswaModel->where('id_tim', $id_tim)->findAll();

        return $result;
    }
}
