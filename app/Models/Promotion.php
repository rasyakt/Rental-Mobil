<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'description',
        'discount_type',
        'discount_value',
        'min_booking_amount',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
        'applicable_categories',
        'applicable_branches',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_booking_amount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'applicable_categories' => 'json',
        'applicable_branches' => 'json',
    ];

    public function isValidNow()
    {
        return $this->is_active && now()->between($this->start_date, $this->end_date);
    }

    public function isUsageExceeded()
    {
        if (is_null($this->usage_limit)) {
            return false;
        }
        return $this->used_count >= $this->usage_limit;
    }

    public function canBeUsed()
    {
        return $this->isValidNow() && !$this->isUsageExceeded();
    }

    public function getDiscountAmount($basePrice)
    {
        if ($this->discount_type === 'fixed') {
            return min($this->discount_value, $basePrice);
        }
        return ($basePrice * $this->discount_value) / 100;
    }
}
