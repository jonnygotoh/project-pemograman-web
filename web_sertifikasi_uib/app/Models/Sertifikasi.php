<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    protected $table = 'sertifikasi';

    protected $fillable = [
        'nama',
        'batch',
        'periode',
        'waktu',
        'jam',
        'tempat',
        'biaya_mahasiswa',
        'biaya_dosen',
        'biaya_umum',
        'jumlah_pendaftar', 
        'poster',
    ];

    public function pendaftarSertifikasi()
    {
        return $this->hasMany(PembayaranSertifikasi::class, 'sertifikasi_id');
    }
}