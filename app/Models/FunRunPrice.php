<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FunRunPrice extends Model
{
    protected $fillable = [
        'event_id',
        'period_id',
        'category_id',
        'price',
        'quota',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(FunRunEvent::class, 'event_id');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(FunRunPeriod::class, 'period_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FunRunCategory::class, 'category_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(FunRunRegistration::class, 'price_id');
    }
}