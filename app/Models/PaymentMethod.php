<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'logo',
        'config',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    public function transactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo && Storage::exists($this->logo)) {
            return Storage::url($this->logo);
        }
        return asset('images/payment-method-default.png');
    }

    public function getConfigValue($key, $default = null)
    {
        return data_get($this->config, $key, $default);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
