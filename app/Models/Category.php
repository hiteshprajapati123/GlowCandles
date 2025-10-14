<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'image',
        'meta_title',
        'meta_description',
        'is_active',
        'order',
        'is_featured',
        'position',
        'icon',
        'attributes'
    ];
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['featured_image_url'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get the URL to the category's featured image.
     *
     * @return string
     */
    public function getFeaturedImageUrlAttribute()
    {
        if (empty($this->image)) {
            return asset('images/default-category.png');
        }

        // If it's already a full URL, return as is
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Clean up the path
        $imagePath = ltrim($this->image, '/');
        
        // Remove 'public/' prefix if it exists
        if (strpos($imagePath, 'public/') === 0) {
            $imagePath = str_replace('public/', '', $imagePath);
        }
        
        // If it's in the categories directory, make sure the path is correct
        if (strpos($imagePath, 'categories/') === 0) {
            return asset('storage/' . $imagePath);
        }
        
        // If it's just a filename, assume it's in the categories directory
        if (strpos($imagePath, '/') === false) {
            return asset('storage/categories/' . $imagePath);
        }
        
        // Default fallback
        return asset('storage/' . $imagePath);
    }

    /**
     * Set the image attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setImageAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['image'] = $value[0] ?? null;
        } else {
            $this->attributes['image'] = $value;
        }
    }
}
