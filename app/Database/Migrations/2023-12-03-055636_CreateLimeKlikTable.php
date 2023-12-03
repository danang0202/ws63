<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLimeKlikTable extends Migration
{
    protected $DBGroup = 'pkl63';
    public function up()
    {
        $this->forge->addField([
            'no' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_pertanyaan' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'tipe' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'jumlah' => [
                'type' => 'int',
                'constraint' => 11
            ]
        ]);

        $this->forge->addKey('no', true);
        $this->forge->createTable('lime_klik');
    }

    public function down()
    {
        $this->forge->dropTable('lime_klik');
    }
}
