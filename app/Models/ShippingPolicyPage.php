<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingPolicyPage extends Model
{
    use SoftDeletes;

    protected $table = 'shipping_policy_pages';
    
    protected $fillable = [
        'banner_title',
        'banner_subtitle',
        'banner_image',
        'shipping_info_title',
        'shipping_info_content',
        'delivery_times_title',
        'delivery_times_content',
        'order_tracking_title',
        'order_tracking_content',
        'international_shipping_title',
        'international_shipping_content',
        'damaged_lost_packages_title',
        'damaged_lost_packages_content',
        'faq_title',
        'faq_content',
        'contact_section_title',
        'contact_section_content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
