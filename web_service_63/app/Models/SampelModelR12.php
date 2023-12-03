<?php

namespace App\Models;

use App\Libraries\Rumahtangga;
use CodeIgniter\Model;

class SampelModelR12 extends Model
{
    protected $DBGroup              = 'wilayahR12';
    protected $table                = 'datast';
    protected $primaryKey           = 'kodeRuta';

    public function deleteAllSampelFromBS($id_bs): bool
    {
        return $this->delete(['kodeBs' => $id_bs]);
    }

    public function insertSampel($kodeRuta, $kodeBs, $riset)
    {
        return $this->replace(['kodeRuta' => $kodeRuta, 'kodeBs' => $kodeBs, 'riset' => $riset]);
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

    public function getBebanKerja(string $kodeBs): int
    {
        return (int) $this->select('COUNT(*) as beban_kerja')
            ->join('bloksensus', 'datast.kodeBs = bloksensus.id', 'inner')
            ->where('kodeBs', $kodeBs)
            ->first()['beban_kerja'];
    }
}