<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = [
        'platform',
        'url',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}