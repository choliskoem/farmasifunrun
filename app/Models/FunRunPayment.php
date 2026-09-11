<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FunRunPayment extends Model
{
    protected $fillable = [
        'registration_id',

        'payment_reference',
        'amount',

        'payment_method',
        'payment_channel',

        'transfer_type',
        'sender_name',
        'sender_bank',
        'sender_account_number',

        'transfer_date',
        'transfer_amount',

        'proof',
        'submitted_at',

        'verified_by',
        'verified_at',

        'admin_note',

        'status',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transfer_amount' => 'decimal:2',

        'transfer_date' => 'date',

        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(
            FunRunRegistration::class,
            'registration_id'
        );
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'verified_by'
        );
    }
}