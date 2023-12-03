<?php

namespace App\Libraries;

class Tim
{
    public string $id_tim;
    public string $nama_tim;
    public Mahasiswa $kortim;
    public array $anggota;

    public function __construct($id_tim, $nama_tim, $kortim, $anggota)
    {
        $this->id_tim = $id_tim;
        $this->nama_tim = $nama_tim;
        $this->kortim = $kortim;
        $this->anggota = $anggota;
    }

    public function getNimAnggota()
    {
        $nim_anggota = array();
        foreach ($this->anggota as $anggota_item) {
            array_push($nim_anggota, $anggota_item->nim);
        }
        return $nim_anggota;
    }
}
