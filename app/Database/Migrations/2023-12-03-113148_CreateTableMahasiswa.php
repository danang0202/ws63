<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableMahasiswa extends Migration
{
    protected $DBGroup = 'sikoko';
    public function up()
    {
        $this->forge->addField([
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => '9',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => '16',
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'plain_password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'id_tim' => [
                'type' => 'int',
                'constraint' => '11',
            ],
        ]);

        $this->forge->addPrimaryKey('nim');
        $this->forge->addKey('id_tim', false, false);
        $this->forge->createTable('mahasiswa');
    }

    public function down()
    {
        $this->forge->dropKey('mahasiswa', 'nim');

        // Foreign key ke timpencacah

        $this->forge->dropKey('mahasiswa', 'id_tim');

        $this->forge->dropTable('mahasiswa');
    }
}
