<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembayaran_sertifikasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID dari tabel Mahasiswa/Dosen/Umum
            $table->string('user_type'); // 'student', 'lecturer', atau 'public'
            $table->foreignId('sertifikasi_id')->constrained('sertifikasi')->onDelete('cascade');
            $table->string('bukti_bayar');
            $table->enum('status', ['menunggu', 'lunas', 'ditolak'])->default('menunggu');
            $table->integer('skor')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pembayaran_sertifikasi'); }
};
