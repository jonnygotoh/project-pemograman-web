<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan kolom tempat ke tabel seminar
        Schema::table('seminar', function (Blueprint $table) {
            $table->string('tempat')->nullable();
        });

        // Menambahkan kolom jam dan tempat ke tabel sertifikasi
        Schema::table('sertifikasi', function (Blueprint $table) {
            $table->string('jam')->nullable();
            $table->string('tempat')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('seminar', function (Blueprint $table) {
            $table->dropColumn('tempat');
        });
        Schema::table('sertifikasi', function (Blueprint $table) {
            $table->dropColumn(['jam', 'tempat']);
        });
    }
};