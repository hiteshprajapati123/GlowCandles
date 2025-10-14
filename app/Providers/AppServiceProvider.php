<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Gloudemans\Shoppingcart\ShoppingcartServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the shopping cart service provider
        $this->app->register(ShoppingcartServiceProvider::class);
        
        // Set the cart instance name
        $this->app->when('Gloudemans\Shoppingcart\Cart')
            ->needs('$instance')
            ->giveConfig('cart.instance');
            
        // Register CartService
        $this->app->singleton(CartService::class, function ($app) {
            return new CartService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set the cart database connection
        if (config('cart.database.connection')) {
            $this->app->when('Gloudemans\Shoppingcart\Cart')
                ->needs('$connection')
                ->giveConfig('cart.database.connection');
        }
    }
}
