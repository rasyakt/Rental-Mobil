<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $table = 'api_logs';

    protected $fillable = [
        'method',
        'endpoint',
        'request_data',
        'response_status',
        'response_data',
        'ip_address',
        'response_time_ms',
        'user_id',
    ];

    protected $casts = [
        'request_data' => 'json',
        'response_data' => 'json',
    ];

    public $timestamps = true;
    public const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
