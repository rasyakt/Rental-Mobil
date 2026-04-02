<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'booking_number',
        'customer_id',
        'vehicle_id',
        'driver_id',
        'pickup_branch_id',
        'return_branch_id',
        'pickup_date',
        'return_date',
        'rental_type',
        'with_driver',
        'pickup_address',
        'return_address',
        'total_price',
        'tax',
        'additional_charges',
        'discount',
        'final_price',
        'status',
        'notes',
        'admin_notes',
    ];

    protected $casts = [
        'pickup_date' => 'datetime',
        'return_date' => 'datetime',
        'with_driver' => 'boolean',
        'total_price' => 'decimal:2',
        'tax' => 'decimal:2',
        'additional_charges' => 'decimal:2',
        'discount' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function pickupBranch()
    {
        return $this->belongsTo(Branch::class, 'pickup_branch_id');
    }

    public function returnBranch()
    {
        return $this->belongsTo(Branch::class, 'return_branch_id');
    }

    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function amenities()
    {
        return $this->hasMany(BookingAmenity::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function trackingLocations()
    {
        return $this->hasMany(VehicleTracking::class);
    }

    public function damages()
    {
        return $this->hasMany(VehicleDamage::class);
    }

    public function getDurationDays()
    {
        return $this->pickup_date->diffInDays($this->return_date);
    }

    public function getStatus()
    {
        return [
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'active' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ][$this->status] ?? $this->status;
    }
}
