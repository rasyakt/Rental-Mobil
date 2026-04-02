<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintenance extends Model
{
    use SoftDeletes;

    protected $table = 'maintenance_logs';

    protected $fillable = [
        'vehicle_id',
        'maintenance_type',
        'type', // alias for maintenance_type to match migration
        'date',
        'start_date',
        'end_date',
        'km_before',
        'km_after',
        'odometer', // alias for km_before
        'description',
        'work_done',
        'cost',
        'vendor',
        'notes',
        'next_maintenance_date',
        'next_maintenance_km',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'next_maintenance_date' => 'date',
        'cost' => 'decimal:2',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Accessors for compatibility with views
    public function getMaintenanceTypeAttribute()
    {
        return $this->attributes['type'] ?? null;
    }

    public function setMaintenanceTypeAttribute($value)
    {
        $this->attributes['type'] = $value;
    }

    public function getStartDateAttribute()
    {
        return $this->date;
    }

    public function setStartDateAttribute($value)
    {
        $this->date = $value;
    }

    public function getEndDateAttribute()
    {
        return $this->next_maintenance_date;
    }

    public function setEndDateAttribute($value)
    {
        $this->next_maintenance_date = $value;
    }

    public function getOdometerAttribute()
    {
        return $this->attributes['km_before'] ?? null;
    }

    public function setOdometerAttribute($value)
    {
        $this->attributes['km_before'] = $value;
    }
}
