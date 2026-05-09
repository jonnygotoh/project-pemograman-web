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
        Schema::create('sertifikasi_dosen', function (Blueprint $table) {

    $table->char('nidn', 20);

    $table->foreign('nidn')
          ->references('nidn')
          ->on('dosen')
          ->cascadeOnDelete();

    $table->foreignId('sertifikasi_id')
          ->constrained('sertifikasi')
          ->cascadeOnDelete();

    $table->enum('status', ['terdaftar', 'lulus', 'tidak_lulus'])
          ->default('terdaftar');
    
    $table->enum('status_pembayaran', [
          'belum lunas',
          'lunas',
          'dispensasi'
    ])->default('belum lunas');

    $table->text('keterangan')->nullable();

    $table->timestamps();

    $table->primary(['nidn', 'sertifikasi_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikasi_dosen');
    }
};
