<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeminarMahasiswa extends Model
{
    protected $table = 'seminar_mahasiswa';

    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = [
        'npm',
        'seminar_id',
        'status',
        'keterangan',
    ];
}