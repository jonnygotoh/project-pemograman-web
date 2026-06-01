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
    $table->string('periode', 100);
    $table->date('tanggal');
    $table->string('waktu', 50);
    $table->enum('tipe', ['free', 'paid'])->default('free');
    $table->string('token_event', 50)->nullable();
    
    $table->decimal('biaya', 12, 2)->default(0); 
    $table->integer('jumlah_pendaftar')->default(0);

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
