<?php

namespace App\Models;

use CodeIgniter\Model;

class VersionModel extends Model
{
    //Inisialisasi database dan tabel yang digunakan di database
    protected $DBGroup              = 'sikoko';
    protected $table                = 'versioninfo';
    protected $primaryKey           = 'nim';

    public function getLatestVersion(string $riset)
    {
        $result = $this->where('riset', $riset)->first();
        return json_encode([
            'latestVersion' => $result['latestVersion'],
            'latestVersionCode' => $result['latestVersionCode'],
            'url' => $result['url'],
            'releaseNotes' => [
                'Versi terbaru : ' . $result['latestVersion'],
                'Pengguna dihimbau untuk mengupdate aplikasi ini demi kenyamanan pada waktu pencacahan!',
                $result['releaseNotes']
            ]
        ]);
    }
}
