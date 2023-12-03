<?php

namespace App\Models;


use App\Libraries\RumahtanggaR5;
use CodeIgniter\Model;

class RutaModelR5 extends Model
{
    protected $DBGroup              = 'wilayahR5';
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

    public function getRuta($kodeRuta): RumahtanggaR5
    {
        $result = $this->find($kodeRuta);
        $ruta = new RumahtanggaR5(
            $result['noSls'],
            $result['akurasi'],
            $result['alamat'],
            $result['bf'],
            $result['bs'],
            $result['kodeBs'],
            $result['kodeRuta'],
            $result['latitude'],
            $result['longitude'],
            $result['timestamp'],
            $result['namaKrt'],
            $result['noUrutRuta'],
            $result['rtUp'],
            $result['noRtUp'],
            $result['statusPetaniTerhadapKrt'],
            $result['namaPetani'],
            $result['jkPetani'],
            $result['umurPetani'],
            $result['pendidikanPetani'],
            $result['alatKomunikasi_1'],
            $result['alatKomunikasi_2'],
            $result['alatKomunikasi_3'],
            $result['alatKomunikasi_4'],
            $result['alatKomunikasi_5'],
            $result['moda_cawi'],
            $result['moda_ti'],
            $result['moda_tidakMemilih'],
            $result['statusCpTerhadapPetani'],
            $result['namaCp'],
            $result['noHpCp'],
            $result['emailCp']
        );

        return $ruta;
    }

    public function addRuta(RumahtanggaR5 $ruta): bool
    {
        $ruta = (array) $ruta;
        unset($ruta['status']);
        return $this->replace($ruta);
    }

    public function updateRuta(RumahtanggaR5 $ruta): bool
    {
        $ruta = (array) $ruta;
        unset($ruta['status']);
        return $this->replace((array) $ruta);
    }

    public function deleteRuta(RumahtanggaR5 $ruta): bool
    {
        return $this->delete(['kodeRuta' => $ruta->kodeRuta]);
    }
}
