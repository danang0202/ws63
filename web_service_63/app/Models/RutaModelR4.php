<?php

namespace App\Models;


use App\Libraries\RumahtanggaR4;
use CodeIgniter\Model;

class RutaModelR4 extends Model
{
    protected $DBGroup              = 'wilayahR4';
    protected $table                = 'usahapariwisata';
    protected $primaryKey           = 'kodeUUP';
    protected $protectFields        = false;

    public function getAllRuta($id_bs): array
    {
        $result = $this
            ->select('kodeUUP')
            ->where('kodeBS', $id_bs)
            ->findAll();

        $all_ruta = array();
        foreach ($result as $ruta_item) {
            array_push($all_ruta, $this->getRuta($ruta_item['kodeUUP']));
        }

        return $all_ruta;
    }

    public function getRuta($kodeUUP): RumahtanggaR4
    {
        $object = $this->find($kodeUUP);
        $ruta = new RumahtanggaR4(
            $object['kodeUUP'],
            $object['kodeBs'],
            $object['noSegmen'],
            $object['bf'],
            $object['bs'],
            $object['noUrutRuta'],
            $object['namaKRT'],
            $object['alamat'],
            $object['jumlahisUUP'],
            $object['noUrutPemilikUUP'],
            $object['namaPemilikUUP'],
            $object['kedudukanUP'],
            $object['statusKelola'],
            $object['tanggungJawab'],
            $object['lokasiUP'],
            $object['skalaUsaha'],
            $object['jenisUUP'],
            $object['noUrutUUP'],
        	$object['catatan'],
            $object['latitude'],
            $object['longitude'],
            $object['akurasi'],
            $object['status'],
            $object['time'],
        );

        return $ruta;
    }

    public function addRuta(RumahtanggaR4 $ruta): bool
    {
        $ruta = (array) $ruta;
        unset($ruta['status']);
        return $this->replace($ruta);
    }

    public function updateRuta(RumahtanggaR4 $ruta): bool
    {
        $ruta = (array) $ruta;
        unset($ruta['status']);
        return $this->replace((array) $ruta);
    }

    public function deleteRuta(RumahtanggaR4 $ruta): bool
    {
        return $this->delete(['kodeUUP' => $ruta->kodeUUP]);
    }
}
