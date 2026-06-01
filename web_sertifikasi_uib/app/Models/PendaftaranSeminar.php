<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranSeminar extends Model
{
    protected $table = 'pendaftar_seminar';
    protected $fillable = [
    'seminar_id', 
    'user_id', 
    'user_type', 
    'token_event',    
    'status_sertifikat',  
    'sertifikat_path'     
];

    public function seminar() {
        return $this->belongsTo(Seminar::class, 'seminar_id');
    }
}