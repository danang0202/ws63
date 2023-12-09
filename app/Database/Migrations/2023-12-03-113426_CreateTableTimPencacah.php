<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableTimPencacah extends Migration
{
    protected $DBGroup = "sikoko";
    public function up()
    {
        $this->forge->addField([
            'id_tim' => [
                'type' => 'int',
                'constraint' => '11',
                'null' => false,
            ],
            'nama_tim' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'nim_koor' => [
                'type' => 'VARCHAR',
                'null' => true,
                'default' => 'NULL'
            ],
        ]);

        $this->forge->addPrimaryKey('id_tim');
        
        $this->forge->addKey('nim_koor');

        $this->forge->addForeignKey('nim_koor', 'mahasiswa', 'nim', 'NULL', 'CASCADE');
        
        $this->forge->createTable('timpencacah');
    }

    public function down()
    {
        $this->forge->dropTable('timpencacah');
    }
}
