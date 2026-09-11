<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FunRunPeriodPrice extends Model
{
    protected $fillable = [
        'period_id',
        'category_id',
        'price',
        'quota',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(
            FunRunPeriod::class,
            'period_id'
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            FunRunCategory::class,
            'category_id'
        );
    }
}