<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDataKonvenTable extends Migration
{
    protected $DBGroup = 'wilayah';

    public function up()
    {
        $this->forge->addField([
            'kodebs' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'kab' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'desa' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'kodes' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'bs' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'jumlah' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
        ]);
        $this->forge->addPrimaryKey('kodebs');
        $this->forge->createTable('data_konven');
    }

    public function down()
    {
        $this->forge->dropTable('data_konven');
    }
}
