<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUmum extends Model
{
    protected $table = 'user_umum';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'alamat',
        'pasfoto',

    ];
    public function setPasfotoAttribute($value)
    {
        $this->attributes['pasfoto'] = $value
            ? strtolower($value)
            : null;
    }

    protected $hidden = [
        'password',
    ];
}