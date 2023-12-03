<?php

namespace App\Libraries;

class InstancePost
{
    private $unique_id_instance, $nim, $koortim, $form_id, $status, $perlakuan, $filename;

    function __construct($unique_id_instance, $nim, $koortim, $form_id, $status_isian, $perlakuan, $filename)
    {
        $this->unique_id_instance = $unique_id_instance;
        $this->nim = $nim;
        $this->koortim = $koortim;
        $this->form_id = $form_id;
        $this->status = $status_isian;
        $this->perlakuan = $perlakuan;
        $this->filename = $filename;
    }

    function getUniqueIdInstance()
    {
        return $this->unique_id_instance;
    }
    function getNim()
    {
        return $this->nim;
    }
    function getKoorTIm()
    {
        return $this->koortim;
    }
    function getFormId()
    {
        return $this->form_id;
    }
    function getStatusIsian()
    {
        return $this->status;
    }
    function getPerlakuan()
    {
        return $this->perlakuan;
    }
    function getFilename()
    {
        return $this->filename;
    }
}
