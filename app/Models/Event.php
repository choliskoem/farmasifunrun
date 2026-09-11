<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'nama',
        'tipe',
        'deskripsi',
        'tanggal',
        'tahun',
        'link',
        'gambar',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function isFlyerOnly(): bool
    {
        return $this->tipe === 'flyer';
    }
}