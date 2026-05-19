<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        Dosen::create([
            'nidn' => '1234567890',
            'nama' => 'Andi',
            'email' => 'andi@gmail.com',
            'password' => '1234',
            'no_hp' => '08111111111',
            'jurusan' => 'TI',
        ]);
    }
}