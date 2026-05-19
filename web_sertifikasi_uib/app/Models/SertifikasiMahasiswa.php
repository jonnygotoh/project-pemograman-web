<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SertifikasiMahasiswa extends Model
{
    protected $table = 'sertifikasi_mahasiswa';

    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = [
        'npm',
        'sertifikasi_id',
        'status',
        'status_pembayaran',
        'keterangan',
    ];
}