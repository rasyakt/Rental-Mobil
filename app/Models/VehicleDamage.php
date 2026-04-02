<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleDamage extends Model
{
    use SoftDeletes;

    protected $table = 'vehicle_damages';

    protected $fillable = [
        'booking_id',
        'vehicle_id',
        'severity',
        'description',
        'photo_path',
        'estimated_cost',
        'actual_cost',
        'status',
        'notes',
        'reported_at',
        'resolved_at',
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'reported_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getSeverityLabel()
    {
        return [
            'minor' => 'Ringan',
            'moderate' => 'Sedang',
            'severe' => 'Berat',
            'critical' => 'Kritis',
        ][$this->severity] ?? $this->severity;
    }
}
