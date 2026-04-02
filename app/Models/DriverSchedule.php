<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverSchedule extends Model
{
    protected $fillable = [
        'driver_id',
        'date',
        'status',
        'start_time',
        'end_time',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
