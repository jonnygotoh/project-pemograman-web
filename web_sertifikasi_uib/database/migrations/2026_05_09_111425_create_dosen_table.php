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
    Schema::create('dosen', function (Blueprint $table) {
    $table->id();

    $table->char('nidn', 10)->unique();
    $table->string('nama', 100);
    $table->string('email', 100)->unique();
    $table->string('password');
    $table->string('no_hp', 20)->nullable();
    $table->string('jurusan', 100);

    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
