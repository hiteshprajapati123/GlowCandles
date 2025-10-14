<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PrivateFileController;

// Private File Access
Route::get('/private/{path}', [PrivateFileController::class, 'show'])
    ->where('path', '.*')
    ->name('private.asset');

// Main Website Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static Pages (Publicly accessible)
Route::get('/about', [\App\Http\Controllers\Pages\AboutPageController::class, 'index'])
    ->name('about');

Route::get('/shipping-policy', [\App\Http\Controllers\Pages\ShippingPolicyPageController::class, 'index'])
    ->name('shipping.policy');

Route::get('/privacy-policy', [\App\Http\Controllers\Pages\PrivacyPolicyPageController::class, 'index'])
    ->name('privacy.policy');

// Contact Routes
Route::get('/contact', [\App\Http\Controllers\Pages\ContactPageController::class, 'index'])
    ->name('contact');
Route::post('/contact', [\App\Http\Controllers\Pages\ContactPageController::class, 'submit'])
    ->name('contact.submit');   

// Checkout routes (outside auth middleware to ensure they're accessible)
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('checkout');

Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])
    ->where('order', '[0-9A-Z-]+') // Matches order numbers like ORD-ABC123
    ->middleware(['auth', 'verified'])
    ->name('checkout.success');

// Protected User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // User dashboard and related routes
    Route::prefix('user')->name('user.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, '__invoke'])
            ->name('dashboard');
        
        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        
        // Addresses
        Route::prefix('addresses')->name('addresses.')->group(function () {
            Route::get('/', [AddressController::class, 'index'])->name('index');
            Route::post('/', [AddressController::class, 'store'])->name('store');
            Route::put('/{address}', [AddressController::class, 'update'])->name('update');
            Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');
            Route::post('/{address}/set-default', [AddressController::class, 'setDefault'])->name('set-default');
        });
        
        // Wishlist routes are defined outside to avoid duplication
    });
});

// Checkout Routes
Route::middleware(['auth'])->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    
    // Address Management in Checkout
    Route::prefix('address')->name('address.')->group(function () {
        Route::get('/create', [AddressController::class, 'create'])->name('create');
        Route::match(['get', 'put'], '/{address}/edit', [AddressController::class, 'edit'])->name('edit');
        Route::post('/', [AddressController::class, 'store'])->name('store');
        Route::put('/{address}', [AddressController::class, 'update'])->name('update');
    });
});

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::match(['put', 'post'], '/update/{rowId}', [CartController::class, 'update'])->name('update');
    Route::match(['delete', 'post'], '/remove/{rowId}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});


// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/user/addresses', [AddressController::class, 'index'])->name('user.addresses.index');
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit')
        ->middleware('verified');
        
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
        
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Include Auth Routes
require __DIR__.'/auth.php';

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Wishlist Routes (Requires authentication)
Route::prefix('wishlist')->name('wishlist.')->middleware('auth')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/add/{product}', [WishlistController::class, 'add'])->name('add');
    Route::delete('/remove/{productId}', [WishlistController::class, 'remove'])->name('remove')->whereNumber('productId');
    Route::post('/move-to-cart/{product}', [WishlistController::class, 'moveToCart'])->name('move-to-cart');
});

Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
