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
    Schema::create('seminar_user_umum', function (Blueprint $table) {

    $table->foreignId('user_umum_id')
          ->constrained('user_umum')
          ->cascadeOnDelete();

    $table->foreignId('seminar_id')
          ->constrained('seminar')
          ->cascadeOnDelete();

    $table->enum('status', ['daftar', 'hadir', 'tidak_hadir'])
          ->default('daftar');

    $table->timestamps();

    $table->primary(['user_umum_id', 'seminar_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar_user_umum');
    }
};
