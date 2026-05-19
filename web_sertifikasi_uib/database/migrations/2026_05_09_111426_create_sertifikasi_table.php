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
    Schema::create('sertifikasi', function (Blueprint $table) {
    $table->id();

    $table->string('nama', 150);
    $table->string('batch', 50)->nullable();
    $table->string('periode');
    $table->date('waktu');

    $table->integer('biaya_mahasiswa')->default(0);
    $table->integer('biaya_dosen')->default(0);
    $table->integer('biaya_umum')->default(0);

    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikasi');
    }
};
