<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDesaTable extends Migration
{
    protected $DBGroup = 'wilayah';

    public function up()
    {
        $this->forge->addField([
            // 'id_desa' => [
            //     'type'           => 'CHAR',
            //     'constraint'     => '10',
            // ],
            // 'kabno' => [
            //     'type'       => 'VARCHAR',
            //     'constraint' => '2',
            // ],
            // 'kecno' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '3',
            // ],
            // 'desano' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '3',
            // ],
            // 'nama' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '20',
            // ],
            // 'status' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '50',
            // ],

            'id_desa' => [
                'type' => 'INT',
                'constraint' => 7,
            ],
            'nama_desa' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ]
        ]);
        $this->forge->addKey('id_desa', true);
        $this->forge->createTable('desa');
    }

    public function down()
    {
        $this->forge->dropTable('desa');
    }
}
