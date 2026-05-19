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
        'tipe',
    ];
}