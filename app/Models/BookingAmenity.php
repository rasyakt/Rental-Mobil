<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAmenity extends Model
{
    protected $fillable = [
        'booking_id',
        'amenity_name',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
