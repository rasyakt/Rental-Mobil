<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'branch_id',
        'category_id',
        'plat_number',
        'brand',
        'model',
        'year',
        'color',
        'seat_capacity',
        'transmission',
        'fuel_type',
        'price_daily',
        'price_weekly',
        'price_monthly',
        'price_driver_daily',
        'status',
        'total_km',
        'last_service_date',
        'service_interval_km',
        'notes',
    ];

    protected $casts = [
        'price_daily' => 'decimal:2',
        'price_weekly' => 'decimal:2',
        'price_monthly' => 'decimal:2',
        'price_driver_daily' => 'decimal:2',
        'last_service_date' => 'datetime',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(VehicleImage::class);
    }

    public function features()
    {
        return $this->hasMany(VehicleFeature::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class, 'vehicle_id');
    }

    public function maintenanceLogs()
    {
        return $this->maintenance();
    }

    public function damages()
    {
        return $this->hasMany(VehicleDamage::class);
    }

    public function trackingLocations()
    {
        return $this->hasMany(VehicleTracking::class);
    }

    public function getPrimaryImage()
    {
        return $this->images()->where('is_primary', true)->first() ?? $this->images()->first();
    }

    public function isAvailable($startDate, $endDate)
    {
        return !$this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('pickup_date', [$startDate, $endDate])
                    ->orWhereBetween('return_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('pickup_date', '<=', $startDate)
                            ->where('return_date', '>=', $endDate);
                    });
            })
            ->exists();
    }

    public function isNeedsMaintenance()
    {
        if (is_null($this->last_service_date)) {
            return true;
        }

        $lastService = $this->last_service_date;
        $nextServiceKm = $this->service_interval_km;
        $nextServiceMonths = 6;

        $daysSinceService = now()->diffInDays($lastService);
        $kmSinceService = $this->total_km - ($this->last_service_date ? 0 : 0);

        return ($daysSinceService > ($nextServiceMonths * 30)) || ($kmSinceService >= $nextServiceKm);
    }
}
