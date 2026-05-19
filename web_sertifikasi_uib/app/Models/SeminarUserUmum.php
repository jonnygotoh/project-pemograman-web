<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeminarUserUmum extends Model
{
    protected $table = 'seminar_user_umum';

    protected $fillable = [
        'user_umum_id',
        'seminar_id',
        'status',
        'keterangan',
    ];
}