<?php

namespace App\Controllers;

use App\Libraries\RumahtanggaR1;
use App\Libraries\RumahtanggaR2;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MahasiswaModel;
use App\Models\RutaModelR1;
use App\Models\RutaModelR2;
use App\Models\SampelModelR1;
use App\Models\TimModel;
use App\Models\WilayahKerjaModelR1;

class ListingR1 extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $rutaModelR1 = new RutaModelR1();
        $rutaModelR2 = new RutaModelR2();
        $wilayahKerjaModel = new WilayahKerjaModelR1();
        $mahasiswaModel = new MahasiswaModel();
        $timModel = new TimModel();
        $sampelModel = new SampelModelR1();
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

                    $rutaR1 = new RumahtanggaR1(
                        $object['kodeRuta'],
                        $object['kodeBs'],
                        $object['noSegmen'],
                        $object['bf'],
                        $object['bs'],
                        $object['noUrutRuta'],
                        $object['namaKrt'],
                        $object['alamat'],
                        $object['noHp'],
                        $object['TTPWDalam'],
                        $object['TTPWLuar'],
                        $object['jmlhanggotaruta'],
                        $object['nortluarkota'],
                        $object['nortdalamkota'],
                        $object['kodeeligible'],
                    	$object['pemberiInformasi'],
                        $object['pelakuWisata'],
                        $object['tujuanWisata'],
                        $object['latitude'],
                        $object['longitude'],
                        $object['akurasi'],
                        $object['status'],
                        $object['time']
                    );

                    $rutaR2 = new RumahtanggaR2(
                        $object['kodeRuta'],
                        $object['kodeBs'],
                        $object['noSegmen'],
                        $object['bf'],
                        $object['bs'],
                        $object['noUrutRuta'],
                        $object['namaKrt'],
                        $object['alamat'],
                        $object['noHp'],
                        $object['TTPWDalam'],
                        $object['TTPWLuar'],
                        $object['jmlhanggotaruta'],
                        $object['nortluarkota'],
                        $object['nortdalamkota'],
                        $object['kodeeligible'],
                    	$object['pemberiInformasi'],
                        $object['pelakuWisata'],
                        $object['tujuanWisata'],
                        $object['latitude'],
                        $object['longitude'],
                        $object['akurasi'],
                        $object['status'],
                        $object['time']
                    );

                    if ($object['status'] == 'insert') {
                        if ($rutaModelR1->addRuta($rutaR1) && $rutaModelR2->addRuta($rutaR2)) {
                            $success++;
                        }
                    } else if ($object['status'] == 'update') {
                        if ($rutaModelR1->updateRuta($rutaR1) && $rutaModelR2->updateRuta($rutaR2)) {
                            $success++;
                        }
                    } else if ($object['status'] == 'delete') {
                        if ($rutaModelR1->deleteRuta($rutaR1) && $rutaModelR2->deleteRuta($rutaR2)) {
                            $success++;
                        }
                    }
                }

                $object = array();

                if ($success == count($object_array)) {
                    $data_bs = $rutaModelR1->getAllRuta($kodeBs);

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