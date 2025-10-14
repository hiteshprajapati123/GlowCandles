<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\ProductReview as Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products, fallback to active products if no featured products found
        $featuredProducts = Product::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('is_active', true)
            ->when(
                Product::where('is_featured', true)->exists(),
                function($query) {
                    return $query->where('is_featured', true);
                },
                function($query) {
                    // Fallback to any active products if no featured products exist
                    return $query->inRandomOrder();
                }
            )
            ->take(8)
            ->get()
            ->map(function($product) {
                $hasDiscount = $product->compare_at_price > $product->price;
                
                return (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'original_price' => $hasDiscount ? $product->compare_at_price : null,
                    'image' => $product->main_image,
                    'rating' => (float) number_format($product->reviews_avg_rating ?? 0, 1),
                    'reviews' => $product->reviews_count,
                    'badge' => $hasDiscount ? 'Sale' : 'New',
                    'stock' => $product->stock
                ];
            });

        // Get new arrivals
        $newArrivals = Product::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('is_active', true)
            ->latest()
            ->limit(4)
            ->get()
            ->map(function($product) {
                $hasDiscount = $product->compare_at_price > $product->price;
                
                return (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'original_price' => $hasDiscount ? $product->compare_at_price : null,
                    'image' => $product->main_image,
                    'rating' => (float) number_format($product->reviews_avg_rating ?? 0, 1),
                    'reviews' => $product->reviews_count,
                    'badge' => $hasDiscount ? 'Sale' : 'New',
                    'stock' => $product->stock
                ];
            });

        // Get categories with product count
        $categories = \App\Models\Category::withCount('products')
            ->where('is_active', true)
            ->orderBy('name')
            ->take(8) // Limit to 8 categories for the homepage
            ->get();

        // Get best sellers
        $bestSellers = Product::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('is_active', true)
            ->orderBy('reviews_count', 'desc')
            ->orderBy('reviews_avg_rating', 'desc')
            ->limit(4)
            ->get()
            ->map(function($product) {
                $hasDiscount = $product->compare_at_price > $product->price;
                
                return (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'original_price' => $hasDiscount ? $product->compare_at_price : null,
                    'image' => $product->main_image,
                    'rating' => (float) number_format($product->reviews_avg_rating ?? 0, 1),
                    'reviews' => $product->reviews_count,
                    'badge' => 'Popular',
                    'stock' => $product->stock
                ];
            });

        // Stats for the hero section
        $stats = [
            [
                'count' => Product::count(),
                'label' => 'Products',
                'suffix' => '+'
            ],
            [
                'count' => User::count(),
                'label' => 'Happy Customers',
                'suffix' => '+'
            ],
            [
                'count' => 24,
                'label' => 'Hour Support',
                'suffix' => '/7'
            ],
            [
                'count' => 10,
                'label' => 'Years Experience',
                'suffix' => '+'
            ]
        ];

        return view('welcome', compact(
            'featuredProducts',
            'newArrivals',
            'categories',
            'bestSellers',
            'stats'
        ));
    }

    /**
     * Get dynamic stats for the hero section
     * 
     * @return array
     */
    protected function getStats()
    {
        try {
            $customerCount = User::count();
            $productsSold = 0;
            
            // Check if OrderItem model exists
            if (class_exists('App\\Models\\OrderItem')) {
                $productsSold = \App\Models\OrderItem::sum('quantity') ?? 0;
            }
            
            $satisfactionRate = 95; // Default value
            try {
                $avgRating = Review::avg('rating');
                $satisfactionRate = $avgRating ? round($avgRating * 20) : 95; // Convert 5-star to percentage
            } catch (\Exception $e) {
                // If there's an error (e.g., reviews table doesn't exist), use default values
                $satisfactionRate = 95;
            }
            
            return [
                'customers' => [
                    'count' => $customerCount,
                    'label' => 'Happy Customers',
                    'suffix' => '+'
                ],
                'products_sold' => [
                    'count' => $productsSold,
                    'label' => 'Products Sold',
                    'suffix' => '+'
                ],
                'satisfaction' => [
                    'count' => $satisfactionRate,
                    'label' => 'Satisfaction Rate',
                    'suffix' => '%'
                ],
                'support' => [
                    'count' => '24/7',
                    'label' => 'Support'
                ]
            ];
        } catch (\Exception $e) {
            // Fallback to default stats if there's any error
            return [
                'customers' => [
                    'count' => 1000,
                    'label' => 'Happy Customers',
                    'suffix' => '+'
                ],
                'products_sold' => [
                    'count' => 5000,
                    'label' => 'Products Sold',
                    'suffix' => '+'
                ],
                'satisfaction' => [
                    'count' => 95,
                    'label' => 'Satisfaction Rate',
                    'suffix' => '%'
                ],
                'support' => [
                    'count' => '24/7',
                    'label' => 'Support'
                ]
            ];
        }
    }
}