<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    protected $fillable = [
        'management_period_id',
        'nama',
        'deskripsi',
        'ketua',
        'sekretaris',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(
            ManagementPeriod::class,
            'management_period_id'
        );
    }
}