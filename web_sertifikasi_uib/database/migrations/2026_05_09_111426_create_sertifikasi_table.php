<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->id();

            $table->string('nama', 150);
            $table->string('batch', 50)->nullable();
            $table->string('periode');
            $table->date('waktu');
            $table->string('poster')->nullable();

            // Biaya
            $table->integer('biaya_mahasiswa')->default(0);
            $table->integer('biaya_dosen')->default(0);
            $table->integer('biaya_umum')->default(0);

            // Kolom untuk optimasi sistem (Cache Manual)
            $table->integer('jumlah_pendaftar')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikasi');
    }
};