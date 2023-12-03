<?php

namespace App\Controllers;

use App\Libraries\RumahtanggaSby;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MahasiswaModel;
use App\Models\RutaModelSby;
use App\Models\SampelModelSby;
use App\Models\TimModel;
use App\Models\WilayahKerjaModelSby;

class ListingSby extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $rutaModelSby = new RutaModelSby();
        $wilayahKerjaModel = new WilayahKerjaModelSby();
        $mahasiswaModel = new MahasiswaModel();
        $timModel = new TimModel();
        $sampelModel = new SampelModelSby();
        $push = new Push();

        $k = $this->request->getPost('k');

        if ($k == 'srp') {
            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json');
            $nim = $this->request->getPost('nim');

            if ($json) {
                $object_array = (array) json_decode($json);
                $success = 0;

                foreach ($object_array as $object) {
                    $object = (array) $object;

                    $rutaSby = new RumahtanggaSby(
                        $object['kodeRuta'],
                        $object['kodeBs'],
                        $object['nomorUrut'],
                        $object['noSegmen'],
                        $object['bf'],
                        $object['bs'],
                        $object['namaPemberiInformasi'],
                        $object['noHp'],
                        $object['provider'],
                        $object['alamatDomisili'],
                    	$object['provinsi'],
                        $object['kodeProvinsi'],
                        $object['kabkot'],
                        $object['kodeKabkot'],
                        $object['kecamatan'],
                        $object['kodeKecamatan'],
                        $object['kelurahan'],
                        $object['kodeKelurahan'],
                        $object['latitude'],
                        $object['longitude'],
                        $object['akurasi'],
                        $object['status'],
                        $object['time']
                    );


                    if ($object['status'] == 'insert') {
                        if ($rutaModelSby->addRuta($rutaSby)) {
                            $success++;
                        }
                    } else if ($object['status'] == 'update') {
                        if ($rutaModelSby->updateRuta($rutaSby)) {
                            $success++;
                        }
                    } else if ($object['status'] == 'delete') {
                        if ($rutaModelSby->deleteRuta($rutaSby)) {
                            $success++;
                        }
                    }
                }

                $object = array();

                if ($success == count($object_array)) {
                    $data_bs = $rutaModelSby->getAllRuta($kodeBs);

                    if (is_array($data_bs)) {
                        foreach ($data_bs as $data) {
                            $data->status = 'uploaded';
                            array_push($object, $data);
                        }
                    }

                    $infoBs = $wilayahKerjaModel->getBSPCLKortim($kodeBs);
                    $data = array(
                        'type' => 'sams_sync_ruta',
                        'kodeBs' => $kodeBs
                    );
                } else {
                    $object = 'IDK';
                }

                return $this->respond($object);
            }
            return $this->respond(null, null, 'WHAT?');
        } else if ($k == 'cbs') {
            $kodeBs = $this->request->getPost('kodeBs');
            $status = $this->request->getPost('status');
            $nim = $this->request->getPost('nim');

            $infoBs = $wilayahKerjaModel->getBSPCLKortim($kodeBs);
            $data = array(
                'type' => 'sams_sync_ruta',
                'kodeBs' => $kodeBs
            );

            if ($status == 'ready') {
                $message = $infoBs['nama_pcl'] . " memfinalisasi blok sensus " . $infoBs['nama'];

                $push->prepareMessageToNim($infoBs['nim_kortim'], 'Blok Sensus Difinalisasi', $message, $data);
            } else if ($status == 'listing') {

                $message = $infoBs['nama_kortim'] . " mengembalikan blok sensus " . $infoBs['nama'] . ", silakan periksa kembali data blok sensus " . $infoBs['nama'];
                $push->prepareMessageToNim($infoBs['nim_pcl'], 'Blok Sensus Dikembalikan', $message, $data);
            }

            $object = ($wilayahKerjaModel->updateStatusBS($kodeBs, $status)) ? 'sukses' : 'gagal';

            return $this->respond($object);
        } else if ($k == 'gab') {
            $nim = $this->request->getPost('nim');
            $mahasiswa = $mahasiswaModel->getMahasiswa($nim);
            $tim = $timModel->getTim($mahasiswa->id_tim);
            $wilayah_kerja = null;

            if ($mahasiswa->isKoor) {
                $wilayah_kerja = $wilayahKerjaModel->getWilayahKerja2($tim->getNimAnggota());
            } else {
                $wilayah_kerja = $wilayahKerjaModel->getWilayahKerja2($mahasiswa->nim);
            }

            return $this->respond($wilayah_kerja);
        } else if ($k == 'ujr') {
            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json');

            $object = 'gagal';

            if ($json) {
                $object_array = (array) json_decode($json);
                $success = 0;

                foreach ($object_array as $object) {
                    $object = (array) $object;

                    if (true) {
                        $success++;
                    }
                }

                if ($success == count($object_array)) {
                    $object = 'sukses';
                }
            }

            return $this->respond($object);
        } else if ($k == 'ssb') {
            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json');
            $nim = $this->request->getPost('nim');

            $object = 'gagal';

            $infoBs = $wilayahKerjaModel->getBSPCLKortim($kodeBs);
            $data = array(
                'type' => 'sams_sampel_terambil',
                'kodeBs' => $kodeBs
            );

            if ($json) {
                $object_array = (array) json_decode($json);
                $success = 0;
                $sampelModel->deleteAllSampelFromBS($kodeBs);

                foreach ($object_array as $object) {
                    $object = (array) $object;
                    if ($sampelModel->insertSampel($object['kodeRuta'], $kodeBs)) {
                        $success++;
                    }
                }

                if ($success == count($object_array)) {
                    if ($wilayahKerjaModel->updateStatusBS($kodeBs, 'uploaded')) {
                        if ($nim == $infoBs['nim_kortim']) {
                            $message = $infoBs['nama_kortim'] . " telah melakukan pengambilan sampel untuk " . $infoBs['nama'];

                            $push->prepareMessageToNim($infoBs['nim_pcl'], 'Blok Sensus Telah Disampling', $message, $data);
                        } else if ($nim == $infoBs['nim_pcl']) {
                            $message = $infoBs['nama_pcl'] . " telah melakukan pengambilan sampel sendiri untuk " . $infoBs['nama'];

                            $push->prepareMessageToNim($infoBs['nim_kortim'], 'Blok Sensus Telah Disampling', $message, $data);
                        }
                        $object = 'sukses';
                    }
                }
            }

            return $this->respond($object);
        } else if ($k == 'gas') {
            $nim = $this->request->getPost('nim');
            $object = $sampelModel->getAllSampel($nim);

            return $this->respond($object);
        }
    }
}
