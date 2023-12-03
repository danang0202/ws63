<?php

namespace App\Models;


use App\Libraries\Posisipcl;
use CodeIgniter\Model;

class PosisipclModel extends Model
{
    protected $DBGroup              = 'sikoko';
    protected $table                = 'posisipcl';
    protected $primaryKey           = 'nim';
    protected $protectFields        = false;

    public function getAllMahasiswaRiset($nama_tim): array
    {
        $result = $this
            ->select('posisipcl')
            ->where('nama_tim', $nama_tim)
            ->findAll();

        $all_position = array();
        foreach ($result as $pcl_position) {
            array_push($all_position, $this->getPosisipcl($pcl_position['nim']));
        }

        return $all_position;
    }

    public function getPosisipcl($nim): Posisipcl
    {
        $result = $this->find($nim);
        $posisipcl = new Posisipcl(
            $result['nim'],
            $result['nama_tim'],
            $result['latitude'],
            $result['longitude']
        );

        return $posisipcl;
    }

    public function addPosisi(Posisipcl $nim): bool
    {
        $nim = (array) $nim;
        // die(var_dump($ruta));
        unset($ruta['status']);
        return $this->replace($nim);
    }

    public function updatePosisi(Posisipcl $nim): bool
    {
        $nim = (array) $nim;
        unset($nim['status']);
        return $this->replace((array) $nim);
    }

    public function deletePosisi(Posisipcl $nim): bool
    {
        return $this->delete(['nim' => $nim->kodeRuta]);
    }
}
