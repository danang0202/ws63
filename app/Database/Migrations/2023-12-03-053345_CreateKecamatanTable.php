<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKecamatanTable extends Migration
{
    protected $DBGroup = 'wilayah';

    public function up()
    {
        $this->forge->addField([
            'id_kec' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
            'nama_kec' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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
