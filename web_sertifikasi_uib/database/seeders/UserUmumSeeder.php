<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserUmum;

class UserUmumSeeder extends Seeder
{
    public function run(): void
    {
        UserUmum::create([
            'nama' => 'Siti',
            'email' => 'siti@gmail.com',
            'password' => '1234',
            'no_hp' => '08222222222',
            'alamat' => 'Batam',
        ]);
    }
}