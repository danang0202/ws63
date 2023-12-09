<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBloksensusTable extends Migration
{
    protected $DBGroup = 'wilayah';
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'VARCHAR',
            ],
            'kabupaten' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
            ],
            'kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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
                'constraint' => '10',
            ],
            'tgl_cacah' => [
                'type' => 'DATE',
            ],
            'nim_pengawas' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'tgl_periksa' => [
                'type' => 'DATE',
            ],
            'catatan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('no_bs', true);
        $this->forge->createTable('bloksensus');
    }

    public function down()
    {
        $this->forge->dropTable('bloksensus');
    }
}
