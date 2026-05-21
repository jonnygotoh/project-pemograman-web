<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\UserUmum;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder Dosen
        Dosen::create([
            'nidn' => '1234567890',
            'nama' => 'Andi',
            'email' => 'andi@gmail.com',
            'password' => '1234',
            'no_hp' => '08111111111',
            'jurusan' => 'TI',
        ]);

        // Seeder Mahasiswa
        Mahasiswa::create([
            'npm' => '2532001',
            'nama' => 'Andhika',
            'email' => 'Andhika@gmail.com',
            'password' => '1234',
            'no_hp' => '08123456789',
            'prodi' => 'TI',
        ]);

        // Seeder UserUmum
        UserUmum::create([
            'nama' => 'Siti',
            'email' => 'siti@gmail.com',
            'password' => '1234',
            'no_hp' => '08222222222',
            'alamat' => 'Batam',
        ]);
    }
}
