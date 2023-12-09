<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBloksensusTable extends Migration
{
    protected $DBGroup = 'wilayah';
    public function up()
    {
        $this->forge->addField([
            // 'id' => [
            //     'type'           => 'VARCHAR',
            //     'unsigned'       => true,
            //     'auto_increment' => true,
            // ],
            // 'kabupaten' => [
            //     'type'       => 'VARCHAR',
            //     'constraint' => '5',
            // ],
            // 'kecamatan' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '5',
            // ],
            // 'kelurahandesa' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '5',
            // ],
            // 'nama' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '4',
            // ],
            // 'sertifikasi' => [
            //     'type' => 'VARCHAR',
            //     'default' => '1',
            //     // 'constraint' => 'stratifikasi_domain CHECK (value IN ("1","2"))',
            // ],
            // 'jumlah_rt' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '4',
            // ],
            // 'jumlah_rt_update' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '4',
            // ],
            // 'sls' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '256',
            // ],
            // 'nim' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '9',
            // ],
            // 'beban_cacah' => [
            //     'type' => 'INT',
            //     'constraint' => 11,
            // ],
            // 'status' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '50',
            // ],
            // 'jumlah_rt_genz' => [
            //     'type' => 'INT',
            //     'constraint' => 11,
            // ],

            'no_bs' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'nama_sls' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_kab' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'id_kec' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'id_desa' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'jml_art' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'jml_genz_dewasa' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'jml_genz_anak' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'nim_pencacah' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'tgl_cacah' => [
                'type' => 'DATE',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'nim_pengawas' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'tgl_periksa' => [
                'type' => 'DATE',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'catatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bloksensus');
    }

    public function down()
    {
        $this->forge->dropTable('bloksensus');
    }
}
