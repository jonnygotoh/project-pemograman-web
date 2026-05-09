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
       Schema::create('seminar_mahasiswa', function (Blueprint $table) {

    $table->char('npm', 10);

    $table->foreign('npm')
          ->references('npm')
          ->on('mahasiswa')
          ->cascadeOnDelete();

    $table->foreignId('seminar_id')
          ->constrained('seminar')
          ->cascadeOnDelete();

    $table->enum('status', ['daftar', 'hadir', 'tidak_hadir'])
          ->default('daftar');

    $table->timestamps();

    $table->primary(['npm', 'seminar_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar_mahasiswa');
    }
};
