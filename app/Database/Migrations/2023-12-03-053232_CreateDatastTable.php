<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDatastTable extends Migration
{
    protected $DBGroup = 'wilayah';
    public function up()
    {
        $this->forge->addField([
            'kodeBS' => [
                'type'           => 'VARCHAR',
                'constraint'     => '14',
            ],
            'kodeUUP' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
        ]);
        $this->forge->createTable('datast');
    }

    public function down()
    {
        $this->forge->dropTable('datast');
    }
}
