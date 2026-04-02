<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'payment_number',
        'booking_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'reference_number',
        'payment_details',
        'paid_at',
        'failure_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'json',
        'paid_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function refund()
    {
        return $this->hasOne(Refund::class);
    }

    public function isPaid()
    {
        return $this->status === 'success';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function getPaymentMethodLabel()
    {
        return [
            'midtrans' => 'Midtrans',
            'xendit' => 'Xendit',
            'bank_transfer' => 'Transfer Bank',
            'qris' => 'QRIS',
            'e_wallet' => 'E-Wallet',
        ][$this->payment_method] ?? $this->payment_method;
    }
}
