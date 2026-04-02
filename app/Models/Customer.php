<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'phone',
        'id_number',
        'id_type',
        'birth_date',
        'gender',
        'address',
        'city',
        'postal_code',
        'photo_id_path',
        'is_verified',
        'verified_at',
        'total_bookings',
        'rating',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'rating' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Booking::class);
    }
}
