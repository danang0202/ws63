<?php

namespace App\Libraries;

class Instance
{
    public $unique_id_instance;
    public $nim;
    public $koortim;
    public $xpaths = array();
    public $nxpaths = array();
    public $form_id;
    public $status;
    public $perlakuan;
    public $filename;

    public function __construct(
        $unique_id_instance,
        $nim,
        $koortim,
        $xpaths,
        $nxpaths,
        $form_id,
        $status,
        $perlakuan,
        $filename
    ) {
        $this->unique_id_instance = $unique_id_instance;
        $this->nim = $nim;
        $this->koortim = $koortim;
        $this->xpaths = $xpaths;
        $this->nxpaths = $nxpaths;
        $this->form_id = $form_id;
        $this->status = $status;
        $this->perlakuan = $perlakuan;
        $this->filename = $filename;
    }
}
