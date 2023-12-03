<?php

namespace App\Controllers;

use App\Libraries\RumahtanggaR3;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MahasiswaModel;
use App\Models\RutaModelR3;
use App\Models\SampelModelR3;
use App\Models\TimModel;
use App\Models\WilayahKerjaModelR3;

class ListingR3 extends ResourceController
{
    use ResponseTrait;
    private $sampel_minimum = 2;

    public function index()
    {
        $rutaModel = new RutaModelR3();
        $wilayahKerjaModel = new WilayahKerjaModelR3();
        $mahasiswaModel = new MahasiswaModel();
        $timModel = new TimModel();
        $sampelModel = new SampelModelR3();
        $push = new Push();

        $k = $this->request->getPost('k');

        // jika k = srp
        if ($k == 'srp') { //SYNC_RUTA_PCL
            $kodeBs = $this->request->getPost('kodeBs');
            $json = $this->request->getPost('json');
            $nim = $this->request->getPost('nim');

            //Jika post json ada, maka akan menjalankan perintah
            if ($json) {
                $object_array = (array) json_decode($json);
                $success = 0;


                //kondisi status ruta (add, delete & update) pada masing-masing baris
                foreach ($object_array as $object) {
                    $object = (array) $object;

                    $ruta = new RumahtanggaR3(
                        $object['kodeRuta'],
                        $object['kodeBs'],
                        $object['noSLS'],
                        $object['bf'],
                        $object['bs'],
                        $object['noUrutRuta'],
                        $object['namaKRT'],
                        $object['alamat'],
                        $object['jumlahART'],
                        $object['jumlahART10'],
                        $object['noHp'],
                        $object['noHp2'],
                        $object['kodeEligible'],
                        $object['latitude'],
                        $object['longitude'],
                        $object['akurasi'],
                        $object['status'],
                        $object['time']
                    );


                    //Kondisi status ruta
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


                //Jika semua baris sukses menjalankan (add, delete & update ruta), maka akan menjalankan perintah
                if ($success == count($object_array)) {

                    //mendapatkan semua baris data ruta
                    $data_bs = $rutaModel->getAllRuta($kodeBs);

                    //jika array, maka akan inisialisasi status data per baris = upload
                    if (is_array($data_bs)) {
                        foreach ($data_bs as $data) {
                            $data->status = 'uploaded';
                            array_push($result, $data);
                        }
                    }

                    //Mendapatkan nama pcl, kortim dan bs
                    $infoBs = $wilayahKerjaModel->getBSPCLKortim($kodeBs);

                    //inisialisasi array dengan kode bs yang di input
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
                    // if ($wilayahKerjaModel->updateJumlahRuta($object['jumlah_rt_update'], $object['jumlah_rt_internet'], $kodeBs)) {
                    if (true) {
                        $success++;
                    }
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

    public function getAlokasiSampel($id_bs)
    {
        $wilayahKerjaModel = new WilayahKerjaModelR3();
        $rutacount = $wilayahKerjaModel->getRutaCount();

        $alokasisampel = array();
        $total_kekurangan = 0;
        $total_sisa = 0;
        foreach ($rutacount as $bs) {
            $is_cukup = $bs['jumlah_ruta'] > $this->sampel_minimum;

            array_push($alokasisampel, array(
                'bs' => $bs['id'],
                'jumlah_ruta' => $bs['jumlah_ruta'],
                'ket_alokasi_awal' => $is_cukup ? 'Equal Size' : 'Take All',
                'alokasi_awal' => $is_cukup ? $this->sampel_minimum : $bs['jumlah_ruta'],
                'sisa_populasi' => $is_cukup ? ((int) $bs['jumlah_ruta'] - $this->sampel_minimum) : 0,
                'alokasi_kekurangan' => null,
                'alokasi_akhir' => null
            ));

            $total_kekurangan += !$is_cukup ? ((int) $this->sampel_minimum - $bs['jumlah_ruta']) : 0;
            $total_sisa += $is_cukup ? ((int) $bs['jumlah_ruta'] - $this->sampel_minimum) : 0;
        }

        for ($i = 0; $i < sizeof($alokasisampel); $i++) {
            $alokasisampel[$i]['alokasi_kekurangan'] = floor($alokasisampel[$i]['sisa_populasi'] / $total_sisa * $total_kekurangan);
            $total_kekurangan -= $alokasisampel[$i]['alokasi_kekurangan'];
        }

        usort($alokasisampel, function ($a, $b) {
            return $a['sisa_populasi'] <=> $b['sisa_populasi'];
        });

        for ($i = 0; $i < $total_kekurangan; $i++) {
            $alokasisampel[$i]['alokasi_kekurangan'] += 1;
        }

        for ($i = 0; $i < sizeof($alokasisampel); $i++) {
            $alokasisampel[$i]['alokasi_akhir'] = $alokasisampel[$i]['alokasi_awal'] + $alokasisampel[$i]['alokasi_kekurangan'];
            if ($alokasisampel[$i]['bs'] == $id_bs) return $this->respond(['alokasi_akhir' => $alokasisampel[$i]['alokasi_akhir']]);
        }

        return $this->respond($alokasisampel);
    }
}
