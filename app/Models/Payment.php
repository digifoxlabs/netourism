<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'form_submission_id',
        'event_id',
        'package_id',
        'txnid',
        'status',
        'amount',
        'currency',
        'productinfo',
        'firstname',
        'email',
        'phone',
        'payu_payment_id',
        'payu_status',
        'gateway_request',
        'gateway_response',
        'paid_at',
        'cancelled_at',
        'failed_at',
        'refunded_at',
        'expires_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_request' => 'array',
        'gateway_response' => 'array',
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'failed_at' => 'datetime',
        'refunded_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function submission()
    {
        return $this->belongsTo(FormSubmission::class, 'form_submission_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function isExpiredPending(): bool
    {
        return $this->status === self::STATUS_PENDING
            && $this->expires_at
            && $this->expires_at->isPast();
    }
}
