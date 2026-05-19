<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SertifikasiDosen extends Model
{
    protected $table = 'sertifikasi_dosen';

    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = [
        'nidn',
        'sertifikasi_id',
        'status',
        'status_pembayaran',
        'keterangan',
    ];
}