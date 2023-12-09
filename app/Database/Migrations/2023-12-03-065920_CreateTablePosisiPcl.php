<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePosisiPcl extends Migration
{
    protected $DBGroup = 'lokasi';
    public function up()
    {
        $this->forge->addField([
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => '9',
                'null' => false,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => '16',
                'null' => true,
            ],
            'id_tim' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => false,
            ],
            'lokus' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => true,
            ],
            'latitude' => [
                'type' => 'DOUBLE PRECISION',
                'null' => true,
            ],
            'longitude' => [
                'type' => 'DOUBLE PRECISION',
                'null' => true,
            ],
            'akurasi' => [
                'type' => 'DOUBLE PRECISION',
                'null' => true,
            ],
            'time_created' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addPrimaryKey('nim');
        $this->forge->createTable('posisi_pcl', true);
    }

    public function down()
    {
        $this->forge->dropTable('posisi_pcl');
    }
}
