<?php

namespace App\Controllers;

use App\Libraries\RumahtanggaR1;
use App\Libraries\RumahtanggaR2;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MahasiswaModel;
use App\Models\RutaModelR1;
use App\Models\RutaModelR2;
use App\Models\SampelModelR2;
use App\Models\TimModel;
use App\Models\WilayahKerjaModelR2;

class ListingR2 extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $rutaModelR1 = new RutaModelR1();
        $rutaModelR2 = new RutaModelR2();
        $wilayahKerjaModel = new WilayahKerjaModelR2();
        $mahasiswaModel = new MahasiswaModel();
        $timModel = new TimModel();
        $sampelModel = new SampelModelR2();
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

                $result = array();

                if ($success == count($object_array)) {
                    $data_bs = $rutaModelR2->getAllRuta($kodeBs);

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

                    //pesan jika berhasil
                    // $message = $infoBs['nama_pcl'] . " memperbarui data blok sensus " . $infoBs['nama'];

                    //Jika bukan kortim maka akan mendapat pesan seperti berikut
                    // if ($nim != $infoBs['nim_kortim']) {
                    //     $push->prepareMessageToNim($infoBs['nim_kortim'], 'Data Blok Sensus Diperbarui', $message, $data);
                    // }
                } else {
                    //jika gagal
                    $result = 'IDK';
                }

                return $this->respond($result);
            }

            return $this->respond(null, null, 'WHAT?');
        } else if ($k == 'cbs') { // CHANGE_BLOK_SENSUS_STATUS 

            //get data kodeBs, status & nim
            $kodeBs = $this->request->getPost('kodeBs');
            $status = $this->request->getPost('status');
            $nim = $this->request->getPost('nim');

            $infoBs = $wilayahKerjaModel->getBSPCLKortim($kodeBs);

            $data = array(
                'type' => 'sams_sync_ruta',
                'kodeBs' => $kodeBs
            );

            //kondisi status apakah dalam keadaan siap cacah atau listing
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

            //ambil nim
            $nim = $this->request->getPost('nim');

            $mahasiswa = $mahasiswaModel->getMahasiswa($nim);
            $tim = $timModel->getTim($mahasiswa->id_tim);

            $wilayah_kerja = null;

            //pengkondisian bila koor maka akan diambil pcl dalam tim nya, jika pcl maka hanya akan ditampilkan pcl itu sendiri
            if ($mahasiswa->isKoor) {
                $wilayah_kerja = $wilayahKerjaModel->getWilayahKerja2($tim->getNimAnggota());
            } else {
                $wilayah_kerja = $wilayahKerjaModel->getWilayahKerja2($mahasiswa->nim);
            }

            return $this->respond($wilayah_kerja);
        } else if ($k == 'ujr') { // UPDATE_JUMLAH_RUTA

            //ambil kode bloksensus dan json
            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json');

            //Kondisi awal masih gagal
            $result = 'gagal';

            if ($json) {
                $object_array = (array) json_decode($json);
                $success = 0;

                //update jumlah ruta update dan internet
                foreach ($object_array as $object) {
                    $object = (array) $object;
                    $success++;
                    // if ($wilayahKerjaModel->updateJumlahRuta($object['jumlah_rt_update'], $object['jumlah_rt_internet'], $kodeBs)) {
                    // }
                }

                //jika semua baris sukses melakukan update maka status hasil akan = 'sukses'
                if ($success == count($object_array)) {
                    $result = 'sukses';
                }
            }

            return $this->respond($result);
        } else if ($k == 'ssb') { // SENT_SAMPLE_BLOK_SENSUS

            //ambil post kode bloksensus, json dan nim
            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json'); // json type data
            $nim = $this->request->getPost('nim');

            //status awal gagal
            $result = 'gagal';

            //ambil data nama,nim dari kortim dan pcl
            $infoBs = $wilayahKerjaModel->getBSPCLKortim($kodeBs);
            $data = array(
                'type' => 'sams_sampel_terambil',
                'kodeBs' => $kodeBs
            );

            //jika ketika di post json nya ada maka akan melakukan perintah sebagai berikut
            if ($json) {
                $object_array = (array) json_decode($json);
                $success = 0;
                $sampelModel->deleteAllSampelFromBS($kodeBs); // Delete sampel sebelumnya


                //insert koderuta dan kode bloksensus yang di input
                foreach ($object_array as $object) {
                    $object = (array) $object;
                    if ($sampelModel->insertSampel($object['kodeRuta'], $kodeBs)) {
                        $success++;
                    }
                }

                //jika semua baris dapat di insert maka akan melakukan perintah
                if ($success == count($object_array)) {

                    //jika kode bs dengan status upload maka akan menjalankan perintah
                    if ($wilayahKerjaModel->updateStatusBS($kodeBs, 'uploaded')) {

                        //Jika kortim maka pesan sebagai berikut
                        if ($nim == $infoBs['nim_kortim']) {
                            $message = $infoBs['nama_kortim'] . " telah melakukan pengambilan sampel untuk " . $infoBs['nama'];
                            // GROUP = LIST SAMPLE
                            $push->prepareMessageToNim($infoBs['nim_pcl'], 'Blok Sensus Telah Disampling', $message, $data);
                        }

                        // Jika bukan kortim maka pesan sebagai berikut 
                        else if ($nim == $infoBs['nim_pcl']) {
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
