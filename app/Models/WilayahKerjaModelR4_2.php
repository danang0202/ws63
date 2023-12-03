<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\WilayahKerja;

class WilayahKerjaModelR4_2 extends Model
{
    protected $DBGroup              = 'wilayahR4';
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

        $wilayah_kerja = [];

        if ($result != NULL) {
            $rumahTanggaModel = new RutaModel();
            $sampelModel = new SampelModelR4();
            $result['beban_cacah'] = $sampelModel->getBebanKerja($id);
            $result['jumlah'] = $this->getJumlahTerkirim($id);

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
        };

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
            $sampelModel = new SampelModelR4();
            $item['beban_cacah'] = $sampelModel->getBebanKerja($item['kodeBs']);
            $item['jumlah'] = $this->getJumlahTerkirim($item['kodeBs']);
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

    public function getJumlahTerkirim(string $kodeBs): int
    {
        $sql = "
        SELECT t2.jumlah as jumlah_terkirim FROM 
            (SELECT dkb.id as kode_bs, dkb.nama as nama_bs, dkd.desano as kode_desa, 
            dkd.nama as nama_desa, dkc.kecno as kode_kecamatan, dkc.nama as nama_kecamatan, 
            dkk.kabno as kode_kabupaten, dkk.nama as nama_kabupaten FROM 
                pkl62_wilayah_riset4.bloksensus dkb INNER JOIN 
                    pkl62_wilayah_riset4.desa dkd ON dkd.desano = dkb.kelurahandesa AND dkd.kecno = dkb.kecamatan 
                    AND dkd.kabno = dkb.kabupaten 
                INNER JOIN pkl62_wilayah_riset4.kecamatan dkc ON dkc.kecno = dkb.kecamatan AND dkc.kabno = dkb.kabupaten 
                INNER JOIN pkl62_wilayah_riset4.kabupaten dkk ON dkk.kabno = dkb.kabupaten 
            WHERE dkb.id = ?) t1
        LEFT OUTER JOIN
            (SELECT n.nim, COUNT(DISTINCT(n.UploadName)) as jumlah,  SUBSTRING(n.UploadName,7,4) as kode_kabupaten, 
            SUBSTRING(n.UploadName,12,3) as kode_kecamatan, SUBSTRING(n.UploadName,16,3) as kode_desa, 
            SUBSTRING(n.UploadName,20,4) as nama_bs, SUBSTRING(n.UploadName,7,17) as bs
            FROM pkl62.notif n
            WHERE SUBSTRING(n.UploadName,1,2)='R4' AND n.status = 'Terkirim'
            GROUP BY bs) t2
        ON t1.kode_kabupaten = t2.kode_kabupaten AND t1.kode_kecamatan = t2.kode_kecamatan 
        AND t1.kode_desa = t2.kode_desa AND t1.nama_bs = t2.nama_bs";
        $res = $this->query($sql, [$kodeBs])->getResultArray()[0];

        return (int) $res['jumlah_terkirim'];
    }
}
