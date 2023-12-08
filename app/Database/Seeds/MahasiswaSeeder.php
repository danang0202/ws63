<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    protected $DBGroup = 'sikoko';  
    public function run()
    {
        $data = [
            [
                'nim' => '123456789',
                'nama' => 'Mahasiswa 1',
                'no_hp' => '08123456789',
                'alamat' => 'Alamat Mahasiswa 1',
                'plain_password' => 'password1',
                'password' => password_hash('password1', PASSWORD_DEFAULT), // Gunakan hashing untuk password
                'id_tim' => 1, // Gantilah dengan id tim yang sesuai
            ],
            [
                'nim' => '987654321',
                'nama' => 'Mahasiswa 2',
                'no_hp' => '08234567890',
                'alamat' => 'Alamat Mahasiswa 2',
                'plain_password' => 'password2',
                'password' => password_hash('password2', PASSWORD_DEFAULT),
                'id_tim' => 2, // Gantilah dengan id tim yang sesuai
            ],
        ];

        // Insert data ke tabel 'mahasiswa'
        $this->db->table('mahasiswa')->insertBatch($data);
    }
}
