<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HimafaProfile extends Model
{
    protected $fillable = [
        'nama_organisasi',
        'tagline',
        'deskripsi',
        'tahun_berdiri',
        'sejarah_awal',
        'sejarah_perjalanan',
        'sejarah_kini',
        'hero_image',
    ];
}