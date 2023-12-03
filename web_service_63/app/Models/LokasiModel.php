<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiModel extends Model
{
    //Inisialisasi database dan tabel yang digunakan di database
    protected $DBGroup              = 'lokasi';
    protected $table                = 'posisi_pcl';
    protected $primaryKey           = 'nim';
    protected $allowedFields        = ['latitude', 'longitude', 'akurasi', 'time_created'];

    public function updateLokasi(string $nim, float $latitude, float $longitude, float $akurasi): bool
    {
        $data = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'akurasi' => $akurasi,
            'time_created' => date('Y-m-d H:i:s')
        ];
        $this->update($nim, $data);
        return true;
    }

}
