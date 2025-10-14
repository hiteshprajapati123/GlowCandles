<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Product;
use App\Models\Activity;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /**
     * Get all activities for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Activity::class)->latest();
    }

    /**
     * Get all addresses for the user.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'date_of_birth',
        'gender',
        'billing_address_line1',
        'billing_address_line2',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'shipping_address_line1',
        'shipping_address_line2',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'is_active',
        'is_verified',
        'last_login_at',
        'last_login_ip',
        'timezone',
        'locale',
        'currency',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * The products in the user's default wishlist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id')
            ->withTimestamps()
            ->withPivot(['created_at']);
    }
    
    /**
     * Alias for wishlist() for backward compatibility
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wishlistItems()
    {
        return $this->wishlist();
    }
    

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'date_of_birth' => 'date:Y-m-d',
        'last_login_at' => 'datetime',
    ];
    
    /**
     * Get the user's date of birth in the correct format for forms.
     *
     * @return string|null
     */
    public function getDateOfBirthFormattedAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->format('Y-m-d') : null;
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    
    /**
     * Get all orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all wishlist items for the user, including named wishlists.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function hasDefaultAddress()
    {
        return !empty($this->billing_address_line1) && 
               !empty($this->billing_city) && 
               !empty($this->billing_state) && 
               !empty($this->billing_zip);
    }
}
