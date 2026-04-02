<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'latitude',
        'longitude',
        'opening_hour',
        'closing_hour',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'opening_hour' => 'datetime:H:i',
        'closing_hour' => 'datetime:H:i',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    public function staff()
    {
        return $this->hasMany(User::class);
    }

    public function pickupBookings()
    {
        return $this->hasMany(Booking::class, 'pickup_branch_id');
    }

    public function returnBookings()
    {
        return $this->hasMany(Booking::class, 'return_branch_id');
    }
}
