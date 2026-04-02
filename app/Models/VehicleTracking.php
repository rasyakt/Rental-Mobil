<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleTracking extends Model
{
    protected $fillable = [
        'booking_id',
        'vehicle_id',
        'latitude',
        'longitude',
        'speed',
        'altitude',
        'address',
        'route_data',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'route_data' => 'json',
    ];

    public $timestamps = true;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getCoordinates()
    {
        return [
            'lat' => (float) $this->latitude,
            'lng' => (float) $this->longitude,
        ];
    }
}
