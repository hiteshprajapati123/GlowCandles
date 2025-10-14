<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'title',
        'comment',
        'images',
        'is_approved',
        'approved_at',
        'approved_by',
        'pros',
        'cons',
        'helpful_yes',
        'helpful_no',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
        'images' => 'array',
        'pros' => 'array',
        'cons' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getHelpfulPercentageAttribute()
    {
        $total = $this->helpful_yes + $this->helpful_no;
        return $total > 0 ? round(($this->helpful_yes / $total) * 100) : 0;
    }
}
