<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftar_seminar', function (Blueprint $table) {
            // Add certificate data columns if not exists
            if (!Schema::hasColumn('pendaftar_seminar', 'sertif_no')) {
                $table->string('sertif_no')->nullable()->after('sertifikat_path');
            }
            if (!Schema::hasColumn('pendaftar_seminar', 'sertif_nama')) {
                $table->string('sertif_nama')->nullable()->after('sertif_no');
            }
            if (!Schema::hasColumn('pendaftar_seminar', 'sertif_npm')) {
                $table->string('sertif_npm')->nullable()->after('sertif_nama');
            }
            if (!Schema::hasColumn('pendaftar_seminar', 'sertif_peran')) {
                $table->string('sertif_peran')->nullable()->after('sertif_npm');
            }
            if (!Schema::hasColumn('pendaftar_seminar', 'sertif_kegiatan')) {
                $table->text('sertif_kegiatan')->nullable()->after('sertif_peran');
            }
            if (!Schema::hasColumn('pendaftar_seminar', 'sertif_tanggal')) {
                $table->string('sertif_tanggal')->nullable()->after('sertif_kegiatan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftar_seminar', function (Blueprint $table) {
            $table->dropColumnIfExists('sertif_no');
            $table->dropColumnIfExists('sertif_peran');
            $table->dropColumnIfExists('sertif_kegiatan');
            $table->dropColumnIfExists('sertif_tanggal');
        });
    }
};
