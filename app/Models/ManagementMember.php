<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagementMember extends Model
{
    protected $fillable = [
        'management_period_id',
        'jabatan',
        'nama',
        'foto',
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