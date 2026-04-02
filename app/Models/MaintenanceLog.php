<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceLog extends Model
{
    use SoftDeletes;

    protected $table = 'maintenance_logs';

    protected $fillable = [
        'vehicle_id',
        'type',
        'date',
        'km_before',
        'km_after',
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
        'cost' => 'decimal:2',
        'next_maintenance_date' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getTypeLabel()
    {
        return [
            'maintenance' => 'Perawatan',
            'repair' => 'Perbaikan',
            'inspection' => 'Inspeksi',
            'service' => 'Servis',
        ][$this->type] ?? $this->type;
    }
}
