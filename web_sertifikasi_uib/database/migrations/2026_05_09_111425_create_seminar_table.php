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
    Schema::create('seminar', function (Blueprint $table) {
    $table->id();

    $table->string('nama', 150);
    $table->date('tanggal');
    $table->string('waktu', 50);
    $table->string('tempat', 150);

    $table->enum('tipe', ['free', 'paid'])->default('free');
    $table->integer('harga')->default(0);

    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar');
    }
};
