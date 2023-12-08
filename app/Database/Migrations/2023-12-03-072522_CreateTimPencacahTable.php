<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTimPencacahTable extends Migration
{
    protected $DBGroup = 'wilayah';
    public function up()
    {
        $this->forge->addField([
            'id_tim' => [
                'type' => 'SERIAL',
                'unsigned' => true,
            ],
            'nama_tim' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'nim_koor' => [
                'type' => 'VARCHAR',
                'constraint' => 9,
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_tim');
        $this->forge->addKey('nim_koor',true);
        $this->forge->createTable('timpencacah');
    }

    public function down()
    {
        $this->forge->dropTable('timpencacah');
    }
}
