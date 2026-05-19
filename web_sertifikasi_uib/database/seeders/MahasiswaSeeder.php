<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        Mahasiswa::create([
            'npm' => '2532001',
            'nama' => 'Andhika',
            'email' => 'Andhika@gmail.com',
            'password' => '1234',
            'no_hp' => '08123456789',
            'prodi' => 'TI',
        ]);
    }
}