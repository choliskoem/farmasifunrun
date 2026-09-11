<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FunRunCategory extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'distance',
        'quota',
        'code_min',
        'code_max',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(FunRunEvent::class, 'event_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(FunRunPrice::class, 'category_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(FunRunRegistration::class, 'category_id');
    }
}