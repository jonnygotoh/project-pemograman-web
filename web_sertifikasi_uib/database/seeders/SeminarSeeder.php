<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seminar;

class SeminarSeeder extends Seeder
{
    public function run(): void
    {
        Seminar::updateOrCreate(
            ['nama' => 'Seminar Teknologi Masa Depan'],
            [
                'periode' => 'Genap 2026',
                'tanggal' => '2026-06-15',
                'waktu' => '09:00 - 12:00',
                'tipe' => 'free',
                'biaya' => 0,
                'jumlah_pendaftar' => 10,
                'token_event' => 'Tech-2026',
            ]
        );

        Seminar::updateOrCreate(
            ['nama' => 'Web Development Workshop'],
            [
                'periode' => 'Genap 2026',
                'tanggal' => '2026-06-20',
                'waktu' => '13:00 - 16:00',
                'tipe' => 'paid',
                'biaya' => 50000,
                'jumlah_pendaftar' => 5,
                'token_event' => 'WEBDEV-2026',
            ]
        );
    }
}
