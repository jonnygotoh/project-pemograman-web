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
       Schema::create('seminar_dosen', function (Blueprint $table) {

    $table->char('nidn', 20);

    $table->foreign('nidn')
          ->references('nidn')
          ->on('dosen')
          ->cascadeOnDelete();

    $table->foreignId('seminar_id')
          ->constrained('seminar')
          ->cascadeOnDelete();

    $table->enum('status', ['daftar', 'hadir', 'tidak_hadir'])
          ->default('daftar');

    $table->text('keterangan')->nullable();

    $table->timestamps();

    $table->primary(['nidn', 'seminar_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar_dosen');
    }
};
