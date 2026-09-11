<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FunRunRegistration extends Model
{
  protected $fillable = [
    'event_id',
    'category_id',
    'price_id',

    'registration_code',

    'name',
    'email',
    'email_verified_at',

    'phone',
    'identity_number',
    'gender',
    'birth_date',
    'address',

    'shirt_size',
    'medical_history',

    'emergency_contact_phone',

    'amount',
    'unique_code',
    'status',
    'channel',

    'payment_token_hash',
    'payment_link_sent_at',
];

  protected $casts = [
    'birth_date' => 'date',

    'email_verified_at' => 'datetime',

    'payment_link_sent_at' => 'datetime',

    'amount' => 'decimal:2',
    'unique_code' => 'integer',
];

    public function event(): BelongsTo
    {
        return $this->belongsTo(
            FunRunEvent::class,
            'event_id'
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            FunRunCategory::class,
            'category_id'
        );
    }

    public function price(): BelongsTo
    {
        return $this->belongsTo(
            FunRunPrice::class,
            'price_id'
        );
    }

    public function payments(): HasMany
    {
        return $this->hasMany(
            FunRunPayment::class,
            'registration_id'
        );
    }

    public function latestPayment()
    {
        return $this->hasOne(
            FunRunPayment::class,
            'registration_id'
        )->latestOfMany();
    }
}