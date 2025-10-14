<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutPage extends Model
{
    use SoftDeletes;

    protected $table = 'about_pages';
    
    protected $fillable = [
        'banner_title',
        'banner_subtitle',
        'banner_image',
        'section1_title',
        'section1_content',
        'section1_image',
        'section2_title',
        'section2_content',
        'section2_image',
        'mission_title',
        'mission_content',
        'vision_title',
        'vision_content',
        'team_section_title',
        'team_section_subtitle',
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
