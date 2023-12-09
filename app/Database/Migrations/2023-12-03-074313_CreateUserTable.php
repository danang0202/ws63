<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    protected $DBGroup = 'lokasi';
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'serial',
            ],
            'nama' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'jenis' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'jabatan' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
