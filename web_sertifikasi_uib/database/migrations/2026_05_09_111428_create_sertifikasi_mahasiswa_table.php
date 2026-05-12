<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sertifikasi_mahasiswa', function (Blueprint $table) {

    $table->char('npm', 10);

    $table->foreign('npm')
          ->references('npm')
          ->on('mahasiswa')
          ->cascadeOnDelete();

    $table->foreignId('sertifikasi_id')
          ->constrained('sertifikasi')
          ->cascadeOnDelete();

    $table->enum('status', ['terdaftar', 'lulus', 'tidak_lulus'])
          ->default('terdaftar');

    $table->text('keterangan')->nullable();

    $table->timestamps();

    $table->primary(['npm', 'sertifikasi_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikasi_mahasiswa');
    }
};
