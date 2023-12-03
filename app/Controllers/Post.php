<?php

namespace App\Controllers;


use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MahasiswaModel;
use App\Models\PostModel;
use App\Libraries\XPath;
use App\Libraries\NXPath;
use App\Libraries\Instance;
use App\Libraries\InstancePost;
use App\Libraries\Push;

class Post extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        //Inisialisasi model
        $mahasiswaModel = new MahasiswaModel();
        $postModel = new PostModel();
        $push = new Push();

        if (isset($_POST['json'])) {
            $json = $_POST['json'];

            $object_array = (array) json_decode($json);
            $instances = $object_array['data'];

            foreach ($instances as $instan) {
                $instan = (array) $instan;
                $unique_id_instance = $instan['unique_id_instance'];
                $nim = $instan['nim'];
                $koortim = $instan['koortim'];
                $status_isian = $instan['status_isian'];
                $perlakuan = $instan['perlakuan'];
                $form_id = $instan['form_id'];
                $nxpaths_js = $instan['nxpaths'];
                $xpaths_js = $instan['xpaths'];
                $xpaths = array();
                $nxpaths = array();
                $filename = $instan['filename'];

                foreach ($xpaths_js as $xpath_js) {
                    $xpath_js = (array) $xpath_js;
                    $xpaths[] = new Xpath($xpath_js['xpath']);
                }
                foreach ($nxpaths_js as $nxpath_js) {
                    $nxpath_js = (array) $nxpath_js;
                    $nxpaths[] = new NXpath($nxpath_js['nxpath']);
                }
                $instance = new Instance(
                    $unique_id_instance,
                    $nim,
                    $koortim,
                    $xpaths,
                    $nxpaths,
                    $form_id,
                    $status_isian,
                    $perlakuan,
                    $filename
                );

                $postModel->insertInstance($instance);
            };
        } else if (isset($_POST['koortim'])) {
            $koortim = $_POST['koortim'];
            return $this->respond($postModel->getJSONInstance($koortim));
        } else if (isset($_POST['json2'])) { // PCL Ngirim data
            $json = $_POST['json2'];
            $object_array = (array) json_decode($json);
            if (isset($object_array['data'])) {
                $namafile = md5(date("h:i:sa")) . '.json';
                $saved = json_encode($object_array);
                // file_put_contents('jsonsuccess/' . $namafile, $saved);
                $instances = $object_array['data'];
                $response = array();
                $response['success'] = '1';
                $response['gagal'] = array();
                foreach ($instances as $instan) {
                    $instan = (array) $instan;
                    $unique_id_instance = $instan['unique_id_instance'];
                    $nim = $instan['nim'];
                    $koortim = $instan['koortim'];
                    $status_isian = $instan['status_isian'];
                    $perlakuan = $instan['perlakuan'];
                    $form_id = $instan['form_id'];
                    $filename = $instan['fileName'];
                    $instance = new InstancePost($unique_id_instance, $nim, $koortim, $form_id, $status_isian, $perlakuan, $filename);
                    if ($postModel->insertInstancePost($instance)) {
                        // Tambahan luqman
                        $data = array('type' => 'kortimpcl');
                        $nama_pcl = $mahasiswaModel->getMahasiswa($nim)->nama;
                        $nama_koortim = $mahasiswaModel->getMahasiswa($koortim)->nama;
                        if ($nim != $koortim && ($perlakuan == 'Final' || $perlakuan == 'Periksa Kembali')) { // Kasus kortim menanggapi pcl
                            $message = ($perlakuan == 'Final') ? "$nama_koortim memfinalisasi kuesioner $filename" : "$nama_koortim mengembalikan kuesioner $filename";
                            $push->prepareMessageToNim($nim, 'Pemeriksaan Kuesioner Selesai', $message, $data);
                        } else if ($nim === $koortim) { // Kasus kortim mengirim sendiri
                            $message = "Kamu telah berhasil mengirimkan kuesioner $filename";
                            $push->prepareMessageToNim($koortim, 'Pengiriman Kuesioner Berhasil', $message, $data);
                        } else { // Kasus pcl mengirim isian
                            $message = "$nama_pcl Mengirimkan isian kuesioner $filename";
                            $push->prepareMessageToNim($koortim, 'Kuesioner Baru', $message, $data);
                            $message = "Kamu telah berhasil mengirimkan kuesioner $filename";
                            $push->prepareMessageToNim($nim, 'Pengiriman Kuesioner Berhasil', $message, $data);
                        }
                    } else {
                        $gagal1 = array();
                        $gagal1['error'] = $unique_id_instance;
                        array_push($response['gagal'], $gagal1);
                        $response['success'] = '0';
                    }
                }
                return $this->respond($response);
            } else {
                $namafile = md5(date("h:i:sa")) . '.json';
                $saved = json_encode($object_array);
                // file_put_contents('jsonerror/' . $namafile, $saved);
                http_response_code(400);
            }
            // } else if (isset($_POST['json3'])) {
            //   echo 'masoook';
        } else if (
            isset($_POST['uuid']) && isset($_POST['nim']) && isset($_POST['kortim']) && isset($_POST['status_isian']) &&
            isset($_POST['status']) && isset($_POST['formid']) && isset($_POST['fileName']) && isset($_POST['xml'])
        ) {
            $unique_id_instance = $_POST['uuid'];
            $nim = $_POST['nim'];
            $koortim = $_POST['kortim'];
            $status_isian = $_POST['status_isian'];
            $perlakuan = $_POST['status'];
            $form_id = $_POST['formid'];
            $filename = $_POST['fileName'];
            $instance = new InstancePost($unique_id_instance, $nim, $koortim, $form_id, $status_isian, $perlakuan, $filename);
            if ($postModel->insertInstancePost($instance)) {
                $base = $_POST['xml'];
                header('Content-Type: text/xml; charset=utf-8');
                $file = fopen('block/' . $filename . '.xml', 'wb');
                fwrite($file, $base);
                fclose($file);
                return $this->respond("sukses");
            }
            return $this->respond("gagal");
        } else if (
            isset($_POST['uuid']) && isset($_POST['nim']) && isset($_POST['kortim']) && isset($_POST['status_isian']) &&
            isset($_POST['status']) && isset($_POST['formid']) && isset($_POST['fileName'])
        ) {
            $unique_id_instance = $_POST['uuid'];
            $nim = $_POST['nim'];
            $koortim = $_POST['kortim'];
            $status_isian = $_POST['status_isian'];
            $perlakuan = $_POST['status'];
            $form_id = $_POST['formid'];
            $filename = $_POST['fileName'];
            $instance = new InstancePost($unique_id_instance, $nim, $koortim, $form_id, $status_isian, $perlakuan, $filename);
            if ($postModel->insertInstancePost($instance)) {
            }
        } else if (isset($_POST['nim']) && isset($_POST['lastid']) && isset($_POST['idjabatan'])) {
            $nim = $_POST['nim'];
            $idlast = $_POST['lastid'];
            $idjabatan = $_POST['idjabatan'];
            if ($idjabatan) {
                $postModel->getallnotifkortim($nim, $idlast);
            } else {
                $postModel->getallnotifnim($nim, $idlast);
            }
        } else {
            //<!DOCTYPE html>
            // $result = $push->prepareDummyMessage("14.8325");
            // $data = array('type' => 'monitoring');
            // $result = $push->prepareMessageToNim("14.8294", "a", "a", $data);
            // echo ($result);
            // echo json_encode($db->getLoginInfo("14.8325", ""));
            return $this->respond($status = 404);
        }
    }
}
