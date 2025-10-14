<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactPage extends Model
{
    use SoftDeletes;

    protected $table = 'contact_pages';
    
    protected $fillable = [
        'banner_title',
        'banner_subtitle',
        'banner_image',
        'contact_form_title',
        'contact_form_subtitle',
        'contact_info_title',
        'contact_info_subtitle',
        'email',
        'phone',
        'address',
        'business_hours_title',
        'business_hours_content',
        'social_media_title',
        'social_media_subtitle',
        'instagram_url',
        'facebook_url',
        'pinterest_url',
        'map_embed_code',
        'faq_section_title',
        'faq_section_subtitle',
        'cta_section_title',
        'cta_section_content',
        'cta_button_text',
        'cta_button_link',
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
