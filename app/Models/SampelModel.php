<?php

namespace App\Models;

use App\Libraries\Rumahtangga;
use CodeIgniter\Model;

class SampelModel extends Model
{
    protected $DBGroup              = 'wilayah';
    protected $table                = 'datast';
    protected $primaryKey           = 'kodeRuta';

    public function deleteAllSampelFromBS($id_bs): bool
    {
        return $this->delete(['kodeBs' => $id_bs]);
    }

    public function insertSampel($kodeRuta, $kodeBs)
    {
        return $this->replace(['kodeRuta' => $kodeRuta, 'kodeBs' => $kodeBs]);
    }

    public function getAllSampel($nim)
    {
        $mahasiswaModel = new MahasiswaModel();
        $timModel = new TimModel();

        $mahasiswa = $mahasiswaModel->getMahasiswa($nim);
        $tim = $timModel->getTim($mahasiswa->id_tim);

        if ($mahasiswa->isKoor) {
            $list_anggota = $tim->getNimAnggota();
            return $this
                ->select('datast.*')
                ->join('bloksensus', 'datast.kodeBs = bloksensus.id', 'inner')
                ->whereIn('bloksensus.nim', $list_anggota)
                ->findAll();
        } else {
            return $this
                ->select('datast.*')
                ->join('bloksensus', 'datast.kodeBs = bloksensus.id', 'inner')
                ->where('bloksensus.nim', $nim)
                ->findAll();
        }
    }
}