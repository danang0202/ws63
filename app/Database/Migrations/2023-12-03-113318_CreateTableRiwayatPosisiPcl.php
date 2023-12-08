<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableRiwayatPosisiPcl extends Migration
{
    
    protected $DBGroup = 'sikoko';
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => '11',
                'null' => false,
                'auto_increment' => true
            ],
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => '9',
                'null' => false,
            ],
            'latitude' => [
                'type' => 'double precision',
                'null' => false,
            ],
            'longitude' => [
                'type' => 'double precision',
                'null' => false,
            ],
            'akurasi' => [
                'type' => 'double precision',
                'null' => false,
            ],
            'time' => [
                'type' => 'timestamp',
                'null' => false,
                'default' => Date('Y-m-d'),
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('riwayatposisipcl');
    }

    public function down()
    {
        $this->forge->dropTable('riwayatposisipcl');
    }
}
