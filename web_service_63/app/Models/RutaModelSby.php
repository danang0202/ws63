<?php

namespace App\Models;


use App\Libraries\RumahtanggaSby;
use CodeIgniter\Model;

class RutaModelSby extends Model
{
    protected $DBGroup              = 'wilayahSby';
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

    public function getRuta($kodeRuta): RumahtanggaSby
    {
        $result = $this->find($kodeRuta);
        $ruta = new RumahtanggaSby(
            $result['kodeRuta'],
            $result['kodeBs'],
            $result['nomorUrut'],
            $result['noSegmen'],
            $result['bf'],
            $result['bs'],
            $result['namaPemberiInformasi'],
            $result['noHp'],
            $result['provider'],
            $result['alamatDomisili'],
        	$result['provinsi'],
            $result['kodeProvinsi'],
            $result['kabkot'],
            $result['kodeKabkot'],
            $result['kecamatan'],
            $result['kodeKecamatan'],
            $result['kelurahan'],
            $result['kodeKelurahan'],
            $result['latitude'],
            $result['longitude'],
            $result['akurasi'],
            $result['status'],
            $result['time']
        );

        return $ruta;
    }

    public function addRuta(RumahtanggaSby $ruta): bool
    {
        $ruta = (array) $ruta;
        // die(var_dump($ruta));
        unset($ruta['status']);
        return $this->replace($ruta);
    }

    public function updateRuta(RumahtanggaSby $ruta): bool
    {
        $ruta = (array) $ruta;
        unset($ruta['status']);
        return $this->replace((array) $ruta);
    }

    public function deleteRuta(RumahtanggaSby $ruta): bool
    {
        return $this->delete(['kodeRuta' => $ruta->kodeRuta]);
    }
}
