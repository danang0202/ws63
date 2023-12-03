<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKecamatanTable extends Migration
{
    protected $DBGroup = 'wilayah';

    public function up()
    {
        $this->forge->addField([
            'kabno' => [
                'type'           => 'VARCHAR',
                'constraint'     => '2',
            ],
            'kecno' => [
                'type'       => 'VARCHAR',
                'constraint' => '3',
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
        ]);
        $this->forge->addKey('kabno', true);
        $this->forge->addKey('kecno', true);
        $this->forge->createTable('kecamatan');
    }

    public function down()
    {
        $this->forge->dropTable('kecamatan');
    }
}
