<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateErrorTable extends Migration
{
    protected $DBGroup = 'pkl63';
    public function up()
    {
        $this->forge->addField([
            'unique_id_instance' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'xpath' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'nxpath' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'form_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ]
        ]);

        $this->forge->addKey('unique_id_instance', true);
        $this->forge->createTable('error');
    }

    public function down()
    {
        $this->forge->dropTable('error');
    }
}
