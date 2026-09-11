<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ManagementPeriod extends Model
{
    protected $fillable = [
        'nama_periode',
        'tahun_mulai',
        'tahun_selesai',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(ManagementMember::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }
}