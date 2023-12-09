<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatPosisiPclTable extends Migration
{
    protected $DBGroup = 'wilayah';
    public function up()
    {
        $this->forge->addField([
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => '9',
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
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'lokus' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => true,
            ],
            'latitude' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => true,
            ],
            'longitude' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => true,
            ],
            'time_created' => [
                'type' => 'VARCHAR',
                'constraint' => '1024',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('nim');
        $this->forge->createTable('riwayat_posisi_pcl');
    }

    public function down()
    {
        $this->forge->dropTable('riwayat_posisi_pcl');
    }
}
