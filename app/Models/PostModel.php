<?php

namespace App\Models;

use App\Libraries\Instance;
use App\Libraries\InstancePost;
use CodeIgniter\Model;

class PostModel extends Model
{
    protected $DBGroup              = 'post';
    protected $table                = 'notif';
    protected $primaryKey           = '_id';
    protected $protectFields        = false;

    public function insertInstance(Instance $instance)
    {
        $unique_id_instance = $instance->unique_id_instance;
        $nim = $instance->nim;
        $koortim = $instance->koortim;
        $xpaths = $instance->xpaths;
        $nxpaths = $instance->nxpaths;
        $form_id = $instance->form_id;
        $status_isian = $instance->status;
        $perlakuan = $instance->perlakuan;

        if (count($xpaths) > 0) {
            //insert into tabel error
            foreach ($xpaths as $key => $__xpath) {
                $xpath = $__xpath->getValue();
                $nxpath = $nxpaths[$key]->getValue();
                $this->table('error')->insert([
                    $unique_id_instance,
                    $xpath,
                    $nxpath,
                    $form_id
                ]);
            }

            $this->insert([
                $unique_id_instance,
                $nim,
                $koortim,
                'unclear',
                $perlakuan
            ]);
        } else {
            $this->insert([
                $unique_id_instance,
                $nim,
                $koortim,
                'clear',
                $perlakuan
            ]);
        }
    }

    function insertInstancePost(InstancePost $instance)
    {
        $unique_id_instance = $instance->getUniqueIdInstance();
        $nim = $instance->getNim();
        $koortim = $instance->getKoorTIm();
        $form_id = $instance->getFormId();
        $status_isian = $instance->getStatusIsian();
        $perlakuan = $instance->getPerlakuan();
        $filename = $instance->getFilename();

        return $this->insert([
            'unique_id_instance' => $unique_id_instance,
            'nim' => $nim,
            'kortim' => $koortim,
            'status_isian' => $status_isian,
            'status' => $perlakuan,
            'form_id' => $form_id,
            'UploadName' => $filename
        ]);
    }

    function getJSONInstance($koortim)
    {
        $result = $this->where('kortim', $koortim)->findAll();

        $instances = array();
        $instances['data'] = array();
        foreach ($result as $key => $instance) {
            $instan = array();
            $instan['unique_id_instance'] = $instance['unique_id_instance'];
            $instan['nim'] = $instance['nim'];
            $instan['koortim'] = $instance['kortim'];
            $instan['status_isian'] = $instance['status_isian'];
            $instan['form_id'] = $instance['form_id'];
            $instan['perlakuan'] = $instance['status'];

            //$instances[] = $instan;
            array_push($instances['data'], $instan);
        }

        echo json_encode($instances);
    }

    function ubahstatus($uuid, $ubah)
    {
        $this->set('status', $ubah, false)->where('unique_id_instance', $uuid)->update();
    }

    function getallnotifkortim($kortim, $idlast)
    {
        $result = $this
            ->select('sm.nama, notif.*')
            ->join('pkl62_sikoko.mahasiswa sm', 'notif.nim = sm.nim')
            ->where('notif.kortim', $kortim)
            ->where('notif._id >', $idlast)
            ->findAll();

        $instances = array();
        $instances['data'] = array();
        foreach ($result as $key => $instance) {

            $instan = array();
            $instan['id'] = $instance['_id'];
            $instan['unique_id_instance'] = $instance['unique_id_instance'];
            $instan['nim'] = $instance['nim'];
            $instan['nama'] = $instance['nama'];
            $instan['koortim'] = $instance['kortim'];
            $instan['status_isian'] = $instance['status_isian'];
            $instan['form_id'] = $instance['form_id'];
            $instan['perlakuan'] = $instance['status'];
            $instan['filename'] = $instance['UploadName'];

            //$instances[] = $instan;
            array_push($instances['data'], $instan);
        }

        echo json_encode($instances);
    }

    function getallnotifnim($nim, $idlast)
    {
        $result = $this
            ->select('sm.nama, notif.*')
            ->table('notif')
            ->join('pkl62_sikoko.mahasiswa sm', 'notif.nim = sm.nim')
            ->where('notif.nim', $nim)
            ->where('notif._id >', $idlast)
            ->findAll();

        $instances = array();
        $instances['data'] = array();
        foreach ($result as $key => $instance) {

            $instan = array();
            $instan['id'] = $instance['_id'];
            $instan['unique_id_instance'] = $instance['unique_id_instance'];
            $instan['nim'] = $instance['nim'];
            $instan['nama'] = $instance['nama'];
            $instan['koortim'] = $instance['kortim'];
            $instan['status_isian'] = $instance['status_isian'];
            $instan['form_id'] = $instance['form_id'];
            $instan['perlakuan'] = $instance['status'];
            $instan['filename'] = $instance['UploadName'];

            //$instances[] = $instan;
            array_push($instances['data'], $instan);
        }
        echo json_encode($instances);
    }
}
