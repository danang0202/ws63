<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\WilayahKerja;

class WilayahKerjaModel extends Model
{
    protected $DBGroup              = 'wilayah';
    protected $table                = 'bloksensus';
    protected $primaryKey           = 'id';
    protected $protectFields        = false;

    public function getWilayahKerja($id)
    {
        $result = $this->select(
            'bloksensus.id as kode_bs,
            bloksensus.nama as nama_bs,
            bloksensus.kelurahandesa as kode_desa,
            desa.nama as nama_desa,
            bloksensus.kecamatan as kode_kecamatan,
            kecamatan.nama as nama_kecamatan,
            bloksensus.kabupaten as kode_kabupaten,
            kabupaten.nama as nama_kabupaten,
            bloksensus.stratifikasi,
            bloksensus.beban_cacah as jumlah,
            bloksensus.beban_cacah,
            bloksensus.beban_cacah as progress,
            bloksensus.status,
            bloksensus.jumlah_rt as jumlahRTLama,
            bloksensus.jumlah_rt_update as jumlahRTBaru,
            bloksensus.jumlah_rt_internet as jumlahRTInternet,
            bloksensus.beban_cacah as jumlah_terkirim'
        )
            ->join(
                'desa',
                'bloksensus.kelurahandesa = desa.desano AND bloksensus.kecamatan = desa.kecno AND bloksensus.kabupaten = desa.kabno',
                'inner'
            )
            ->join(
                'kecamatan',
                'bloksensus.kecamatan = kecamatan.kecno AND bloksensus.kabupaten = kecamatan.kabno',
                'inner'
            )
            ->join('kabupaten', 'bloksensus.kabupaten = kabupaten.kabno', 'inner')
            ->where('id', $id)
            ->first();

        $rumahTanggaModel = new RutaModel();
        $wilayah_kerja = new WilayahKerja(
            $result['kode_bs'],
            $result['nama_bs'],
            $result['kode_desa'],
            $result['nama_desa'],
            $result['kode_kecamatan'],
            $result['nama_kecamatan'],
            $result['kode_kabupaten'],
            $result['nama_kabupaten'],
            $result['stratifikasi'],
            $result['jumlah'],
            $result['beban_cacah'],
            $result['progress'],
            $result['status'],
            $result['jumlahRTLama'],
            $result['jumlahRTBaru'],
            $result['jumlahRTInternet'],
            $result['jumlah_terkirim'],
            $rumahTanggaModel->getAllRuta($result['kode_bs'])
        );

        return $wilayah_kerja;
    }

    public function getWilayahKerja2($ids)
    {
        $result = $this->select(
            'bloksensus.nim as nim,
            bloksensus.id as kodeBs,
            bloksensus.nama as noBs,
            bloksensus.kelurahandesa as desa,
            desa.nama as namaDesa,
            bloksensus.kecamatan as kecamatan,
            kecamatan.nama as namaKecamatan,
            bloksensus.kabupaten as kabupaten,
            kabupaten.nama as namaKabupaten,
            SUBSTRING(bloksensus.id, 1, 2) as provinsi,
            bloksensus.sls as sls,
            bloksensus.stratifikasi,
            bloksensus.beban_cacah as jumlah,
            bloksensus.beban_cacah,
            bloksensus.beban_cacah as progress,
            bloksensus.status,
            bloksensus.jumlah_rt as jumlahRTLama,
            bloksensus.jumlah_rt_update as jumlahRTBaru,
            bloksensus.jumlah_rt_internet as jumlahRTInternet,
            bloksensus.beban_cacah as jumlah_terkirim'
        )
            ->join(
                'desa',
                'bloksensus.kelurahandesa = desa.desano AND bloksensus.kecamatan = desa.kecno AND bloksensus.kabupaten = desa.kabno',
                'inner'
            )
            ->join(
                'kecamatan',
                'bloksensus.kecamatan = kecamatan.kecno AND bloksensus.kabupaten = kecamatan.kabno',
                'inner'
            )
            ->join('kabupaten', 'bloksensus.kabupaten = kabupaten.kabno', 'inner');

        if (is_array($ids)) {
            $result = $result->whereIn('bloksensus.nim', $ids)->findAll();
        } else {
            $result = $result->where('bloksensus.nim', $ids)->findAll();
        }

        $wilayah_kerja = array();
        foreach ($result as $item) {
            array_push(
                $wilayah_kerja,
                $item
            );
        }

        return $wilayah_kerja;
    }

    public function getAllWilayahKerja($nim): array
    {
        $result = $this
            ->where('nim', $nim)
            ->findAll();

        return $result;
    }

    public function getBSPCLKortim($id_bs)
    {
        return $this->select(
            'bloksensus.nama as nama,
            pcl.nim as nim_pcl,
            pcl.nama as nama_pcl,
            kortim.nim as nim_kortim,
            kortim.nama as nama_kortim'
        )
            ->join('pkl62_sikoko.mahasiswa pcl', 'bloksensus.nim = pcl.nim')
            ->join('pkl62_sikoko.timpencacah tim', 'pcl.id_tim = tim.id_tim')
            ->join('pkl62_sikoko.mahasiswa kortim', 'tim.nim_koor = kortim.nim')
            ->where('bloksensus.id', $id_bs)
            ->first();
    }

    public function updateStatusBS($id_bs, $status)
    {
        return $this
            ->update($id_bs, ['status' => $status]);
    }

    public function updateJumlahRuta($jumlah_rt_update, $jumlah_rt_internet, $kodeBs)
    {
        return $this
            ->update($kodeBs, [
                'jumlah_rt_update' => $jumlah_rt_update,
                'jumlah_rt_internet' => $jumlah_rt_internet
            ]);
    }
}
