<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MahasiswaModel;

class GetHashPW extends ResourceController
{
    use ResponseTrait;

    // Dapatkan hash password, parameternya nim
    public function index()
    {
        //Insisalisasi model yang digunakan
        $mahasiswaModel = new MahasiswaModel();

        $mahasiswa = $mahasiswaModel->getMahasiswa($this->request->getGet('nim'));
        if (!$mahasiswa)
            return $this->failNotFound('NIM tidak ditemukan');

        return $this->respond(['password' => $mahasiswa->password]);
    }
}
