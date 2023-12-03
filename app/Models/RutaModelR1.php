<?php

namespace App\Models;


use App\Libraries\RumahtanggaR1;
use CodeIgniter\Model;

class RutaModelR1 extends Model
{
    protected $DBGroup              = 'wilayahR1';
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

    public function getRuta($kodeRuta): RumahtanggaR1
    {
        $result = $this->find($kodeRuta);
        $ruta = new RumahtanggaR1(
            $result['kodeRuta'],
            $result['kodeBs'],
            $result['noSegmen'],
            $result['bf'],
            $result['bs'],
            $result['noUrutRuta'],
            $result['namaKrt'],
            $result['alamat'],
            $result['noHp'],
            $result['TTPWDalam'],
            $result['TTPWLuar'],
            $result['jmlhanggotaruta'],
            $result['nortluarkota'],
            $result['nortdalamkota'],
            $result['kodeeligible'],
        	$result['pemberiInformasi'],
            $result['pelakuWisata'],
            $result['tujuanWisata'],
            $result['latitude'],
            $result['longitude'],
            $result['akurasi'],
            $result['status'],
            $result['time']
        );

        return $ruta;
    }

    public function addRuta(RumahtanggaR1 $ruta): bool
    {
        $ruta = (array) $ruta;
        // die(var_dump($ruta));
        unset($ruta['status']);
        return $this->replace($ruta);
    }

    public function updateRuta(RumahtanggaR1 $ruta): bool
    {
        $ruta = (array) $ruta;
        unset($ruta['status']);
        return $this->replace((array) $ruta);
    }

    public function deleteRuta(RumahtanggaR1 $ruta): bool
    {
        return $this->delete(['kodeRuta' => $ruta->kodeRuta]);
    }
}