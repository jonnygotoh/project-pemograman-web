<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sertifikasi;

class SertifikasiSeeder extends Seeder
{
    public function run(): void
    {
        Sertifikasi::updateORCreate(
            ['nama' => 'Sertifikasi Cisco CCNA'],
            [
                'periode' => 'Juni 2026',
                'waktu' => '2026-06-10',
                'biaya_mahasiswa' => 200000,
                'biaya_dosen' => 300000,
                'biaya_umum' => 500000,
            ]
        );

        Sertifikasi::updateORCreate(
            ['nama' => 'Sertifikasi AWS Cloud'],
            [
                'periode' => 'Juni 2026',
                'waktu' => '2026-06-25',
                'biaya_mahasiswa' => 300000,
                'biaya_dosen' => 400000,
                'biaya_umum' => 600000,
            ]
        );
    }
}
