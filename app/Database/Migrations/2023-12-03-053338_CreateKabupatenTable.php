<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKabupatenTable extends Migration
{
    protected $DBGroup = 'wilayah';

    public function up()
    {
        $this->forge->addField([
            'kabno' => [
                'type'           => 'VARCHAR',
                'constraint'     => '2',
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
        ]);
        $this->forge->addKey('kabno', true);
        $this->forge->createTable('kabupaten');
    }

    public function down()
    {
        $this->forge->dropTable('kabupaten');
    }
}
