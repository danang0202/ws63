<?php

namespace App\Controllers;

use App\Libraries\Rumahtangga;
use App\Libraries\Tim;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MahasiswaModel;
use App\Models\RutaModel;
use App\Models\SampelModel;
use App\Models\TimModel;
use App\Models\WilayahKerjaModel;

class Listing extends ResourceController
{
    use ResponseTrait;

    public function create()
    {
        //Inisialisasi Model
        $rutaModel = new RutaModel();
        $wilayahKerjaModel = new WilayahKerjaModel();
        $mahasiswaModel = new MahasiswaModel();
        $timModel = new TimModel();
        $sampelModel = new SampelModel();
        $push = new Push();

        $k = $this->request->getPost('k');

        if ($k == 'srp') { //SYNC_RUTA_PCL
            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json');
            $nim = $this->request->getPost('nim');

            if ($json) {
                $object_array = (array) json_decode($json);
                $success = 0;

                foreach ($object_array as $object) {
                    $object = (array) $object;

                    $ruta = new Rumahtangga(
                        $object['noSegmen'],
                        $object['akurasi'],
                        $object['alamat'],
                        $object['noHp'],
                        $object['bf'],
                        $object['bs'],
                        $object['kodeBs'],
                        $object['kodeRuta'],
                        $object['latitude'],
                        $object['longitude'],
                        $object['namaKrt'],
                        $object['keterangan'],
                        $object['noUrutRuta'],
                        $object['rutaInternet'],
                        $object['rutaPergi']
                    );

                    if ($object['status'] == 'insert') {
                        if ($rutaModel->addRuta($ruta)) {
                            $success++;
                        }
                    } else if ($object['status'] == 'update') {
                        if ($rutaModel->updateRuta($ruta)) {
                            $success++;
                        }
                    } else if ($object['status'] == 'delete') {
                        if ($rutaModel->deleteRuta($ruta)) {
                            $success++;
                        }
                    }
                }

                $result = array();

                if ($success == count($object_array)) {
                    $data_bs = $rutaModel->getAllRuta($kodeBs);

                    if (is_array($data_bs)) {
                        foreach ($data_bs as $data) {
                            $data->status = 'uploaded';
                            array_push($result, $data);
                        }
                    }

                    $infoBs = $wilayahKerjaModel->getBSPCLKortim($kodeBs);

                    $data = array(
                        'type' => 'sams_sync_ruta',
                        'kodeBs' => $kodeBs
                    );

                    $message = $infoBs['nama_pcl'] . " memperbarui data blok sensus " . $infoBs['nama'];

                    if ($nim != $infoBs['nim_kortim']) {
                        $push->prepareMessageToNim($infoBs['nim_kortim'], 'Data Blok Sensus Diperbarui', $message, $data);
                    }
                } else {
                    $result = 'IDK';
                }

                return $this->respond($result);
            }
            return $this->respond(null, null, 'WHAT?');
        } else if ($k == 'cbs') { // CHANGE_BLOK_SENSUS_STATUS
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
                // GROUP = LIST BS
                $push->prepareMessageToNim($infoBs['nim_kortim'], 'Blok Sensus Difinalisasi', $message, $data);
            } else if ($status == 'listing') {
                // GROUP = LIST BS
                $message = $infoBs['nama_kortim'] . " mengembalikan blok sensus " . $infoBs['nama'] . ", silakan periksa kembali data blok sensus " . $infoBs['nama'];
                $push->prepareMessageToNim($infoBs['nim_pcl'], 'Blok Sensus Dikembalikan', $message, $data);
            }

            $result = ($wilayahKerjaModel->updateStatusBS($kodeBs, $status)) ? 'sukses' : 'gagal';

            return $this->respond($result);
        } else if ($k == 'gab') { // GET_ALL_BLOK_SENSUS
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
        } else if ($k == 'ujr') { // UPDATE_JUMLAH_RUTA
            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json');
            $result = 'gagal';

            if ($json) {
                $object_array = (array) json_decode($json);
                $success = 0;

                foreach ($object_array as $object) {
                    $object = (array) $object;
                    if ($wilayahKerjaModel->updateJumlahRuta($object['jumlah_rt_update'], $object['jumlah_rt_internet'], $kodeBs)) {
                        $success++;
                    }
                }
                if ($success == count($object_array)) {
                    $result = 'sukses';
                }
            }

            return $this->respond($result);
        } else if ($k == 'ssb') { // SENT_SAMPLE_BLOK_SENSUS
            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json'); // json type data
            $nim = $this->request->getPost('nim');
            $result = 'gagal';
            $infoBs = $wilayahKerjaModel->getBSPCLKortim($kodeBs);
            $data = array(
                'type' => 'sams_sampel_terambil',
                'kodeBs' => $kodeBs
            );

            if ($json) {
                $object_array = (array) json_decode($json);
                $success = 0;
                $sampelModel->deleteAllSampelFromBS($kodeBs); // Delete sampel sebelumnya

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
                            // GROUP = LIST SAMPLE
                            $push->prepareMessageToNim($infoBs['nim_pcl'], 'Blok Sensus Telah Disampling', $message, $data);
                        } else if ($nim == $infoBs['nim_pcl']) {
                            $message = $infoBs['nama_pcl'] . " telah melakukan pengambilan sampel sendiri untuk " . $infoBs['nama'];
                            // GROUP = LIST SAMPLE
                            $push->prepareMessageToNim($infoBs['nim_kortim'], 'Blok Sensus Telah Disampling', $message, $data);
                        }

                        $result = 'sukses';
                    }
                }
            }
            return $this->respond($result);
        } else if ($k == 'gas') { // GET_ALL_SAMPEL
            $nim = $this->request->getPost('nim');

            $result = $sampelModel->getAllSampel($nim);
            

            return $this->respond($result);
        }
    }
}
