<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeminarDosen extends Model
{
    protected $table = 'seminar_dosen';

    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = [
        'nidn',
        'seminar_id',
        'status',
        'keterangan',
    ];
}