<?php

namespace App\Models;

use App\Libraries\Rumahtangga;
use CodeIgniter\Model;

class RutaModel extends Model
{
    protected $DBGroup              = 'wilayah';
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

    public function getRuta($kodeRuta): Rumahtangga
    {
        $result = $this->find($kodeRuta);
        $ruta = new Rumahtangga(
            $result['noSegmen'],
            $result['akurasi'],
            $result['alamat'],
            $result['noHp'],
            $result['bf'],
            $result['bs'],
            $result['kodeBs'],
            $result['kodeRuta'],
            $result['latitude'],
            $result['longitude'],
            $result['namaKrt'],
            $result['keterangan'],
            $result['noUrutRuta'],
            $result['rutaInternet'],
            $result['rutaPergi']
        );

        return $ruta;
    }

    public function addRuta(Rumahtangga $ruta): bool
    {
        $ruta = (array) $ruta;
        unset($ruta['status']);
        return $this->replace($ruta);
    }

    public function updateRuta(Rumahtangga $ruta): bool
    {
        $ruta = (array) $ruta;
        unset($ruta['status']);
        return $this->replace((array) $ruta);
    }

    public function deleteRuta(Rumahtangga $ruta): bool
    {
        return $this->delete(['kodeRuta' => $ruta->kodeRuta]);
    }
}
