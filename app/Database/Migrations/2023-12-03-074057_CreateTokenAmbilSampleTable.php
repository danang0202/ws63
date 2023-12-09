<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTokenAmbilSampelTable extends Migration
{
    protected $DBGroup = 'lokasi';
    public function up()
    {
        $this->forge->addField([
            'riset' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'token' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'lokus' => [
                'type' => 'VARCHAR',
                'constraint' => '16',
                'null' => true,
            ],
            'count' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addPrimaryKey('riset');
        // $this->forge->addForeignKey('token', 'token', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('token_ambil_sampel');
    }

    public function down()
    {
        $this->forge->dropTable('token_ambil_sampel');
    }
}
