<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftar_seminar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seminar_id')->constrained('seminar')->onDelete('cascade');
            $table->string('user_id');
            $table->string('user_type');
            
            // Kolom baru untuk Sertifikat
            $table->string('token_sertifikat')->nullable();
            $table->string('status_sertifikat')->default('menunggu'); // 'menunggu' atau 'verified'
            $table->string('sertifikat_path')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftar_seminar');
    }
};
