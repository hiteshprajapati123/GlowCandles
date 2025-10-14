<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\ProductReview;
use App\Models\Category;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['main_image_url'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'meta_keywords' => 'array',
        'tags' => 'array',
        'track_quantity' => 'boolean',
        'sell_when_out_of_stock' => 'boolean',
        'images' => 'array',
        'features' => 'array',
        'specifications' => 'array',
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_new' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'cost_per_item' => 'decimal:2',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
                
                // Ensure slug is unique
                $originalSlug = $model->slug;
                $count = 2;
                while (static::where('slug', $model->slug)->where('id', '!=', $model->id ?? 0)->exists()) {
                    $model->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'compare_at_price',
        'cost_per_item',
        'sku',
        'barcode',
        'quantity',
        'track_quantity',
        'sell_when_out_of_stock',
        'type',
        'status',
        'main_image',
        'images',
        'brand',
        'tags',
        'weight',
        'weight_unit',
        'length',
        'width',
        'height',
        'dimension_unit',
        'color',
        'size',
        'material',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'features',
        'specifications',
        'warranty',
        'is_featured',
        'is_bestseller',
        'is_new',
        'is_active',
        'view_count',
        'sold_count',
    ];

    /**
     * Set the main_image attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setMainImageAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['main_image'] = $value[0] ?? null;
        } else {
            $this->attributes['main_image'] = $value;
        }
    }
    
    // Since we're not using a separate variants table,
    // we'll handle variants through product options
    public function getVariantsAttribute()
    {
        // Return an empty collection since we're not using variants
        return collect([]);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the URL to the product's main image.
     *
     * @return string
     */
    /**
     * Get the URL to the product's main image.
     *
     * @return string
     */
    public function getMainImageUrlAttribute()
    {
        if (empty($this->main_image)) {
            return asset('images/default-product.png');
        }

        // If it's already a full URL, return as is
        if (filter_var($this->main_image, FILTER_VALIDATE_URL)) {
            return $this->main_image;
        }

        // If it's a path in public storage
        if (strpos($this->main_image, 'public/') === 0) {
            return asset(str_replace('public/', 'storage/', $this->main_image));
        }

        // If it's a path in private storage
        if (strpos($this->main_image, 'private/') === 0) {
            return route('private.asset', ['path' => $this->main_image]);
        }

        // If it's a path relative to storage directory
        if (strpos($this->main_image, 'storage/') === 0) {
            return asset($this->main_image);
        }

        // Default case - assume it's a path relative to storage/app/public
        return asset('storage/' . $this->main_image);
    }

    public function getGalleryAttribute()
    {
        return $this->images ?? [];
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_at_price > $this->price) {
            return round((($this->compare_at_price - $this->price) / $this->compare_at_price) * 100);
        }
        return 0;
    }

    public function getFormattedPriceAttribute()
    {
        return '₹' . number_format($this->price, 2);
    }

    public function getFormattedCompareAtPriceAttribute()
    {
        return $this->compare_at_price ? '₹' . number_format($this->compare_at_price, 2) : null;
    }
}
