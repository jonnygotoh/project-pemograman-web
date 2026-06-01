<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    protected $table = 'seminar';

    protected $fillable = [
        'nama', 
        'periode', 
        'tanggal', 
        'waktu', 
        'jumlah_pendaftar',
    ];

    public function pendaftar()
    {
        return $this->hasMany(Pendaftar::class, 'seminar_id');
    }
}