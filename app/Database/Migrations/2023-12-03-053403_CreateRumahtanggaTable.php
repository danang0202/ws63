<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRumahtanggaTable extends Migration
{
    protected $DBGroup = 'wilayah';

    public function up()
    {
        $this->forge->addField([
            'kodeRuta' => [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
            ],
            'noSegmen' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'namaKrt' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'noHp' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'bf' => [
                'type' => 'VARCHAR',
                'constraint' => '4',
            ],
            'bs' => [
                'type' => 'VARCHAR',
                'constraint' => '4',
            ],
            'noUrutRuta' => [
                'type' => 'VARCHAR',
                'constraint' => '3',
            ],
            'kodeBs' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'longitude' => [
                'type' => 'double precision',
            ],
            'latitude' => [
                'type' => 'double precision',
            ],
            'time' => [
                'type' => 'TIMESTAMP',
            ],
            'akurasi' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'keterangan' => [
                'type' => 'TEXT',
            ],
            'rutaInternet' => [
                'type' => 'INT',
                'default' => '1',
                // 'constraint' => 'rutaPergi_domain CHECK (value IN ("1","2"))',
            ],
            'rutaPergi' => [
                'type' => 'INT',
                'default' => '1',
                // 'constraint' => 'rutaPergi_domain CHECK (value IN ("1","2"))',
            ],
        ]);
        $this->forge->addKey('kodeRuta', true);
        $this->forge->createTable('rumahtangga');
    }

    public function down()
    {
        $this->forge->dropTable('rumahtangga');
    }
}
