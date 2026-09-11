<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vision extends Model
{
    protected $fillable = [
        'isi',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}