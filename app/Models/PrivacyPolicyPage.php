<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivacyPolicyPage extends Model
{
    use SoftDeletes;

    protected $table = 'privacy_policy_pages';
    
    protected $fillable = [
        'banner_title',
        'banner_subtitle',
        'banner_image',
        'introduction_title',
        'introduction_content',
        'information_collection_title',
        'information_collection_content',
        'how_we_use_title',
        'how_we_use_content',
        'information_sharing_title',
        'information_sharing_content',
        'data_security_title',
        'data_security_content',
        'your_rights_title',
        'your_rights_content',
        'cookies_title',
        'cookies_content',
        'third_party_links_title',
        'third_party_links_content',
        'children_privacy_title',
        'children_privacy_content',
        'policy_changes_title',
        'policy_changes_content',
        'contact_us_title',
        'contact_us_content',
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
