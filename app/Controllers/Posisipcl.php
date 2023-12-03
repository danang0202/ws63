<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\LokasiModel;

class Posisipcl extends ResourceController
{
    use ResponseTrait;

	public function index()
    {
        if (isset($_POST['nim'])) {
            $model = new LokasiModel();
			
        
            $nim = $this->request->getPost('nim');
            $latitude = $this->request->getPost('latitude');
            $longitude = $this->request->getPost('longitude');
            $akurasi = $this->request->getPost('akurasi');

            if ($model->updateLokasi($nim, $latitude, $longitude, $akurasi)) {
                return 'Berhasil menambah data lokasi';
            }
        }
    }
}
