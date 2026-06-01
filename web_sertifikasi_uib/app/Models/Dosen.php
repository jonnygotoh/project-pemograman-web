<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';

    protected $fillable = [
        'nidn',
        'nama',
        'email',
        'no_hp',
        'jurusan',
        'pasfoto',
    ];
    public function setPasfotoAttribute($value)
    {
        $this->attributes['pasfoto'] = $value
            ? strtolower($value)
            : null;
    }
}