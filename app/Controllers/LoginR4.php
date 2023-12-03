<?php

namespace App\Controllers;


use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MahasiswaModelR4;
use App\Models\TimModel;

// TIDAK DIPAKAI DI ANGKATAN 62
class LoginR4 extends ResourceController
{
    use ResponseTrait;

    public function index()
    {

        //Inisialisasi model
        $mahasiswaModel = new MahasiswaModelR4();
        $timModel = new TimModel();


        //dapet nim dan password dari form, kemudian ambil data dari database menggunakan MahasiswaModelR3()
        $mahasiswa = $mahasiswaModel->getMahasiswa($this->request->getGet('nim'));
        if (!$mahasiswa)
            return $this->failNotFound('NIM tidak ditemukan');
        if ($this->request->getGet('password') != $mahasiswa->password)
            return $this->fail('Password Salah');


        //ambil data dari database lewat model TimModel()    
        $tim = $timModel->getTim($mahasiswa->id_tim);


        //Informasi yang diambil dan dijadikan array
        $result = array();
        $result['nama'] = $mahasiswa->nama;
        $result['nim'] = $mahasiswa->nim;
        $result['idTim'] = $mahasiswa->id_tim;
        $result['namaTim'] = $tim->nama_tim;
        $result['isKoor'] = $mahasiswa->isKoor;
        $result['avatar'] = $mahasiswa->foto;
        $result['passKoor'] = $tim->kortim->password;
        $result['status'] = 'success';
        $result['id_kuesioner'] = 'VKD.PKL56.RT.v1';

        //Cek apakah merupakan koorTim atau bukan
        if (!$result['isKoor']) {
            $result['nimKoor'] = $tim->kortim->nim;
            $result['namaKoor'] = $tim->kortim->nama;
            $result['teleponKoor'] = $tim->kortim->no_hp;
        }


        //print array data yang dihasilkan
        return $this->respond($result);
    }
}
