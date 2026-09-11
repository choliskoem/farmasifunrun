<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $fillable = [
        'nomor',
        'isi',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}