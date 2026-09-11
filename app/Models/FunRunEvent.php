<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FunRunEvent extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'event_date',
        'start_time',
        'location',
        'banner',
        'registration_start',
        'registration_end',

        'is_maintenance',
        'maintenance_until',
        'is_active',

        // Payment
        'bank_name',
        'account_number',
        'account_holder',

        'bank_name_2',
        'account_number_2',
        'account_holder_2',

        'contact_person_name',
        'contact_person_phone',
        'qris_image',
    ];

    protected $casts = [
        'event_date' => 'date',
        'registration_start' => 'datetime',
        'registration_end' => 'datetime',

        'is_maintenance' => 'boolean',
        'maintenance_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(
            FunRunCategory::class,
            'event_id'
        );
    }

    public function periods(): HasMany
    {
        return $this->hasMany(
            FunRunPeriod::class,
            'event_id'
        );
    }

    public function prices(): HasMany
    {
        return $this->hasMany(
            FunRunPrice::class,
            'event_id'
        );
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(
            FunRunRegistration::class,
            'event_id'
        );
    }
}