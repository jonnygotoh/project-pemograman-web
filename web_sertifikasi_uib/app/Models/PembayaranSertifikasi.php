<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranSertifikasi extends Model
{
    protected $table = 'pembayaran_sertifikasi';
    protected $fillable = ['user_id', 'user_type', 'sertifikasi_id', 'bukti_bayar', 'status', 'skor', 'catatan_admin'];

    public function sertifikasi() {
        return $this->belongsTo(Sertifikasi::class, 'sertifikasi_id');
    }
}