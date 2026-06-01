<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = [
        'npm',
        'nama',
        'email',
        'no_hp',
        'prodi',
        'pasfoto',
    ];

    public function setPasfotoAttribute($value)
    {
        $this->attributes['pasfoto'] = $value
            ? strtolower($value)
            : null;
    }
}