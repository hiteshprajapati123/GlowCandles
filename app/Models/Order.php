<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'grand_total',
        'item_count',
        'payment_status',
        'payment_method',
        'first_name',
        'last_name',
        'email',
        'address',
        'address_line2',
        'city',
        'state',
        'country',
        'post_code',
        'phone_number',
        'order_notes',
        'subtotal',
        'tax',
        'shipping'
    ];

    protected $casts = [
        'grand_total' => 'float',
        'subtotal' => 'float',
        'tax' => 'float',
        'shipping' => 'float',
        'item_count' => 'integer',
    ];
    
    protected $appends = ['full_name'];
    
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
