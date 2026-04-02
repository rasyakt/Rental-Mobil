<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'booking_id',
        'customer_id',
        'subtotal',
        'tax',
        'discount',
        'total_amount',
        'issued_at',
        'due_at',
        'status',
        'notes',
        'terms',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'issued_at' => 'datetime',
        'due_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function getStatusLabel()
    {
        return [
            'draft' => 'Draft',
            'issued' => 'Diterbitkan',
            'partially_paid' => 'Sebagian Dibayar',
            'paid' => 'Lunas',
            'overdue' => 'Kadaluarsa',
            'cancelled' => 'Dibatalkan',
        ][$this->status] ?? $this->status;
    }
}
