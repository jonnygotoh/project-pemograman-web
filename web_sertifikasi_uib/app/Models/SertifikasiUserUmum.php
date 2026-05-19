<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SertifikasiUserUmum extends Model
{
    protected $table = 'sertifikasi_user_umum';

    protected $fillable = [
        'user_umum_id',
        'sertifikasi_id',
        'status',
        'status_pembayaran',
        'keterangan',
    ];
}