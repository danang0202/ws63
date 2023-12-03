<?php

namespace App\Models;


use App\Libraries\RumahtanggaR3;
use CodeIgniter\Model;

class RutaModelR3 extends Model
{
    protected $DBGroup              = 'wilayahR3';
    protected $table                = 'rumahtangga';
    protected $primaryKey           = 'kodeRuta';
    protected $protectFields        = false;

    public function getAllRuta($id_bs): array
    {
        $result = $this
            ->select('kodeRuta')
            ->where('kodeBS', $id_bs)
            ->findAll();

        $all_ruta = array();
        foreach ($result as $ruta_item) {
            array_push($all_ruta, $this->getRuta($ruta_item['kodeRuta']));
        }

        return $all_ruta;
    }

    public function getRuta($kodeRuta): RumahtanggaR3
    {
        $result = $this->find($kodeRuta);
        $ruta = new RumahtanggaR3(
            $result['kodeRuta'],
            $result['kodeBs'],
            $result['noSLS'],
            $result['bf'],
            $result['bs'],
            $result['noUrutRuta'],
            $result['namaKRT'],
            $result['alamat'],
            $result['jumlahART'],
            $result['jumlahART10'],
            $result['noHp'],
            $result['noHp2'],
            $result['kodeEligible'],
            $result['latitude'],
            $result['longitude'],
            $result['akurasi'],
            $result['status'],
            $result['time']
        );

        return $ruta;
    }

    public function addRuta(RumahtanggaR3 $ruta): bool
    {
        $ruta = (array) $ruta;
        unset($ruta['status']);
        return $this->replace($ruta);
    }

    public function updateRuta(RumahtanggaR3 $ruta): bool
    {
        $ruta = (array) $ruta;
        unset($ruta['status']);
        return $this->replace((array) $ruta);
    }

    public function deleteRuta(RumahtanggaR3 $ruta): bool
    {
        return $this->delete(['kodeRuta' => $ruta->kodeRuta]);
    }
}
