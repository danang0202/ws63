<?php

namespace App\Controllers;

use App\Libraries\RumahtanggaR5;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\MahasiswaModel;
use App\Models\RutaModelR5;
use App\Models\SampelModelR5;
use App\Models\TimModel;
use App\Models\WilayahKerjaModelR5;

class ListingR5 extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $rutaModel = new RutaModelR5();
        $wilayahKerjaModel = new WilayahKerjaModelR5();
        $mahasiswaModel = new MahasiswaModel();
        $timModel = new TimModel();
        $sampelModel = new SampelModelR5();
        $push = new Push();

        $k = $this->request->getPost('k');

        if ($k == 'srp') { //srp = SYNC_RUTA_PCL
            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json');
            $nim = $this->request->getPost('nim');
            if ($json) {
                $object_array = (array) json_decode($json);
                $success = 0;

                foreach ($object_array as $object) {
                    $object = (array) $object;

                    $ruta = new RumahtanggaR5(
                        $object['noSls'],
                        $object['akurasi'],
                        $object['alamat'],
                        $object['bf'],
                        $object['bs'],
                        $object['kodeBs'],
                        $object['kodeRuta'],
                        $object['latitude'],
                        $object['longitude'],
                        $object['timestamp'],
                        $object['namaKrt'],
                        $object['noUrutRuta'],
                        $object['rtUp'],
                        $object['noRtUp'],
                        $object['statusPetaniTerhadapKrt'],
                        $object['namaPetani'],
                        $object['jkPetani'],
                        $object['umurPetani'],
                        $object['pendidikanPetani'],
                        $object['alatKomunikasi_1'],
                        $object['alatKomunikasi_2'],
                        $object['alatKomunikasi_3'],
                        $object['alatKomunikasi_4'],
                        $object['alatKomunikasi_5'],
                        $object['moda_cawi'],
                        $object['moda_ti'],
                        $object['moda_tidakMemilih'],
                        $object['statusCpTerhadapPetani'],
                        $object['namaCp'],
                        $object['noHpCp'],
                        $object['emailCp']
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

                $object = array();

                if ($success == count($object_array)) {
                    $data_bs = $rutaModel->getAllRuta($kodeBs);

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

                    //pesan jika berhasil
                    // $message = $infoBs['nama_pcl'] . " memperbarui data blok sensus " . $infoBs['nama'];

                    //Jika bukan kortim maka akan mendapat pesan seperti berikut
                    // if ($nim != $infoBs['nim_kortim']) {
                    //     $push->prepareMessageToNim($infoBs['nim_kortim'], 'Data Blok Sensus Diperbarui', $message, $data);
                    // }
                } else {
                    $object = 'IDK';
                }

                return $this->respond($object);
            }
            return $this->respond(null, null, 'WHAT?');
        } else if ($k == 'cbs') { // cbs = CHANGE_BLOK_SENSUS_STATUS

            //get data kodeBs, status & nim
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

            $object = ($wilayahKerjaModel->updateStatusBS($kodeBs, $status)) ? 'sukses' : 'gagal';

            return $this->respond($object);
        } else if ($k == 'gab') { // gab = GET_ALL_BLOK_SENSUS
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
        } else if ($k == 'ujr') { // ujr = UPDATE_JUMLAH_RUTA
            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json');

            $object = 'gagal';

            if ($json) {
                $object_array = (array) json_decode($json);
                $success = 0;

                foreach ($object_array as $object) {
                    $object = (array) $object;
                    // if ($wilayahKerjaModel->updateJumlahRuta($object['jumlah_rt_update'], $object['jumlah_rt_internet'], $kodeBs)) {
                    if (true) {
                        $success++;
                    }
                }

                if ($success == count($object_array)) {
                    $object = 'sukses';
                }
            }

            return $this->respond($object);
        } else if ($k == 'ssb') { // ssb = SENT_SAMPLE_BLOK_SENSUS , bukan Sekolah Sepak Bola :v

            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json'); // json type data
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
                            // GROUP = LIST SAMPLE
                            $push->prepareMessageToNim($infoBs['nim_pcl'], 'Blok Sensus Telah Disampling', $message, $data);
                        } else if ($nim == $infoBs['nim_pcl']) {
                            $message = $infoBs['nama_pcl'] . " telah melakukan pengambilan sampel sendiri untuk " . $infoBs['nama'];
                            // GROUP = LIST SAMPLE
                            $push->prepareMessageToNim($infoBs['nim_kortim'], 'Blok Sensus Telah Disampling', $message, $data);
                        }

                        $object = 'sukses';
                    }
                }
            }

            return $this->respond($object);
        } else if ($k == 'gas') { // gas = GET_ALL_SAMPEL, bukan yang buat masak :v
            $nim = $this->request->getPost('nim');
            $object = $sampelModel->getAllSampel($nim);

            return $this->respond($object);
        }
    }
}
