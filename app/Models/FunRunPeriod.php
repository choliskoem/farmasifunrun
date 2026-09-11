<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FunRunPeriod extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'start_at',
        'end_at',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(FunRunEvent::class, 'event_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(FunRunPrice::class, 'period_id');
    }
}