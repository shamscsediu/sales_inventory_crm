<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'last_purchase_date', 'employee_id'];

    protected $casts = [
        'last_purchase_date' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function getIsLostAttribute(): bool
    {
        if (!$this->last_purchase_date) {
            return false;
        }

        $days = config('crm.lost_customer_inactivity_days', 90);
        return $this->last_purchase_date->diffInDays(now()) > $days;
    }

    public function scopeLost($query)
    {
        $days = config('crm.lost_customer_inactivity_days', 90);
        return $query->whereNotNull('last_purchase_date')
                     ->where('last_purchase_date', '<', now()->subDays($days));
    }
}
