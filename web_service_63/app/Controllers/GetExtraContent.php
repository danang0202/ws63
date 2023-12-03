<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TimModel;

class GetExtraContent extends ResourceController
{
    use ResponseTrait;

    // Dapatkan extracontent (anggota tim / wilayah kerja) dengan parameter nim
    public function index()
    {
        $nim = $this->request->getGet('nim');

        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->getMahasiswa($nim);

        $timModel = new TimModel();

        if ($mahasiswa->isKoor) {
            return $this->respond([
                'anggota_tim' => $timModel->getAnggotaTim($mahasiswa->id_tim)
            ]);
        } else {
            return $this->respond([
                'wilayah_kerja' => $mahasiswa->wilayah_kerja
            ]);
        }
    }
}
