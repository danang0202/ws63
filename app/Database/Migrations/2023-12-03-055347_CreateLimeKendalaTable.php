<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLimeKendalaTable extends Migration
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
            'kendala' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ]
        ]);

        $this->forge->addKey('no', true);
        $this->forge->createTable('lime_kendala');
    }

    public function down()
    {
        $this->forge->dropTable('lime_kendala');
    }
}
