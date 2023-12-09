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
                'constraint' => '5',
            ],
            'kelurahandesa' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '4',
            ],
            'sertifikasi' => [
                'type' => 'VARCHAR',
                'default' => '1',
                // 'constraint' => 'stratifikasi_domain CHECK (value IN ("1","2"))',
            ],
            'jumlah_rt' => [
                'type' => 'VARCHAR',
                'constraint' => '4',
            ],
            'jumlah_rt_update' => [
                'type' => 'VARCHAR',
                'constraint' => '4',
            ],
            'sls' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => '9',
            ],
            'beban_cacah' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'jumlah_rt_genz' => [
                'type' => 'INT',
                'constraint' => 11,
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
