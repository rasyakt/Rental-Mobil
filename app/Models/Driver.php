<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'branch_id',
        'name',
        'email',
        'phone',
        'id_number',
        'birth_date',
        'gender',
        'address',
        'city',
        'license_number',
        'license_type',
        'license_expiry_date',
        'rating',
        'total_trips',
        'status',
        'photo_path',
        'daily_rate',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'license_expiry_date' => 'date',
        'rating' => 'decimal:2',
        'daily_rate' => 'decimal:2',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function schedules()
    {
        return $this->hasMany(DriverSchedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailableOnDate($date)
    {
        $schedule = $this->schedules()->whereDate('date', $date)->first();
        if (!$schedule) {
            return $this->status === 'available';
        }
        return $schedule->status === 'available';
    }

    public function licenseIsValid()
    {
        return $this->license_expiry_date > now();
    }
}
