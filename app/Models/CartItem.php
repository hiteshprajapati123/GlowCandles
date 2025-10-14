<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartItem extends Model
{
    protected $table = 'cart_items';
    
    protected $fillable = [
        'cart_id',
        'product_id',
        'user_id',
        'quantity',
        'price',
        'options',
        'added_at'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'options' => 'array',
        'quantity' => 'integer',
        'added_at' => 'datetime'
    ];

    protected $with = ['product'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // Set default values
        if (!isset($this->attributes['options'])) {
            $this->attributes['options'] = json_encode(['variant' => 'default']);
        }
        
        if (!isset($this->attributes['added_at'])) {
            $this->attributes['added_at'] = now();
        }
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($cartItem) {
            Log::info('Creating cart item', [
                'cart_id' => $cartItem->cart_id ?? null,
                'product_id' => $cartItem->product_id ?? null,
                'user_id' => $cartItem->user_id ?? null
            ]);
            
            // Ensure cart_id is set
            if (empty($cartItem->cart_id)) {
                $cartItem->cart_id = $cartItem->user_id 
                    ? 'user_' . $cartItem->user_id 
                    : 'guest_' . (request()->session()->getId() ?? Str::random(32));
            }
            
            // Ensure options is a JSON string
            if (is_array($cartItem->options)) {
                $cartItem->options = json_encode($cartItem->options);
            } elseif (empty($cartItem->options)) {
                $cartItem->options = json_encode(['variant' => 'default']);
            }
        });
        
        static::updating(function ($cartItem) {
            // Ensure options is a JSON string when updating
            if (is_array($cartItem->options)) {
                $cartItem->options = json_encode($cartItem->options);
            }
        });
    }

    public function getSubtotalAttribute(): float
    {
        return (float) bcmul($this->price, $this->quantity, 2);
    }
}
