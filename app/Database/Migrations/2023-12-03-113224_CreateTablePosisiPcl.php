<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePosisiPcl extends Migration
{
    protected $DBGroup = 'sikoko';
    public function up()
    {
        $this->forge->addField([
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => '9',
            ],
            'nama_tim' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => 'NULL'
            ],
            'latitude' => [
                'type' => 'double precision',
                'null' => true,
            ],
            'longitude' => [
                'type' => 'double precision',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('nim');
        $this->forge->createTable('posisipcl');
    }

    public function down()
    {
        $this->forge->dropTable('posisipcl');
    }
}

