<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\UserUmum;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        // Seeder Dosen
        Dosen::updateOrCreate(
            ['nidn' => '1234567890'],
            [
                'nama' => 'Andi',
                'email' => 'andi@gmail.com',
                'password' => '1234',
                'no_hp' => '08111111111',
                'jurusan' => 'TI',
            ]
        );

        // Seeder Mahasiswa
        Mahasiswa::updateOrCreate(
            ['npm' => '2532001'],
            [
                'nama' => 'Andhika',
                'email' => 'Andhika@gmail.com',
                'password' => '1234',
                'no_hp' => '08123456789',
                'prodi' => 'TI',
            ]
        );

        // Seeder UserUmum
        UserUmum::updateOrCreate(
            ['email' => 'siti@gmail.com'],
            [
                'nama' => 'Siti',
                'password' => '1234',
                'no_hp' => '08222222222',
                'alamat' => 'Batam',
            ]
        );

        // Seeder Admin
        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => 'admin123',
            ]
        // call seeder
        );

        $this->call([
            SeminarSeeder::class,
            SertifikasiSeeder::class,
        ]);
    }
}
