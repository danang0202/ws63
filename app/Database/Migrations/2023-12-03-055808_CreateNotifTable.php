<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotifTable extends Migration
{
    protected $DBGroup = 'pkl63';
    public function up()
    {
        $this->forge->addField([
            '_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'unique_id_instance' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => 9
            ],
            'kortim' => [
                'type' => 'VARCHAR',
                'constraint' => 9
            ],
            'status_isian' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'form_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'UploadName' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ],
            'timestamp' => [
                'type' => 'timestamp',
                // 'default' => 'current_timestamp()'
                
            ]
        ]);

        $this->forge->addKey('_id', true);
        $this->forge->createTable('notif');
    }

    public function down()
    {
        $this->forge->dropTable('notif');
    }
}
