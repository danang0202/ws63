<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotifTable extends Migration
{
    protected $DBGroup = 'wilayah';

    public function up()
    {
        $this->forge->addField([
            'unique_id_instance' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'nim' => [
                'type'       => 'VARCHAR',
                'constraint' => '9',
            ],
            'kortim' => [
                'type' => 'VARCHAR',
                'constraint' => '9',
            ],
            'status_isian' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'form_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            '_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'UploadName' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'time' => [
                'type' => 'TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('_id', true);
        $this->forge->createTable('notif');
    }

    public function down()
    {
        $this->forge->dropTable('notif');
    }
}
