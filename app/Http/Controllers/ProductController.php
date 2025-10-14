<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'reviews'])
            ->where('is_active', true)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');
            
        // Filter by category if provided
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'top_rated':
                $query->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
        
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function($query) {
                $query->where('is_active', true);
            }])
            ->get();
        
        // Get featured products for sidebar
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();
            
        // Add wishlist status to products
        if (auth()->check()) {
            $wishlistProductIds = auth()->user()->wishlist()->pluck('products.id')->toArray();
            
            $products->each(function($product) use ($wishlistProductIds) {
                $product->in_wishlist = in_array($product->id, $wishlistProductIds);
            });
            
            $featuredProducts->each(function($product) use ($wishlistProductIds) {
                $product->in_wishlist = in_array($product->id, $wishlistProductIds);
            });
        } else {
            $products->each(function($product) {
                $product->in_wishlist = false;
            });
            
            $featuredProducts->each(function($product) {
                $product->in_wishlist = false;
            });
        }
        
        return view('products.index', compact('products', 'categories', 'featuredProducts'));
    }
    
    public function show($slug)
    {
        $product = Product::with([
            'category', 
            'reviews.user'
        ])
        ->where('slug', $slug)
        ->where('is_active', true)
        ->firstOrFail();
        
        // Since we're not using variants, use the product's own price
        $hasVariants = false;
        $lowestPrice = $product->price;
        $highestPrice = $product->price;
        $hasDiscount = $product->compare_at_price > $product->price;
        
        // Helper function to check if string is a URL
        $isUrl = function($str) {
            return filter_var($str, FILTER_VALIDATE_URL) !== false;
        };

        // Process main image
        $mainImage = $product->main_image 
            ? ($isUrl($product->main_image) ? $product->main_image : Storage::url($product->main_image))
            : asset('images/placeholder-product.jpg');
            
        $images = [];
        
        if (!empty($product->images)) {
            if (is_string($product->images)) {
                $imagesArray = json_decode($product->images, true) ?? [];
                $images = array_map(function($image) use ($isUrl) {
                    if (empty($image)) return null;
                    return $isUrl($image) ? $image : Storage::url($image);
                }, is_array($imagesArray) ? $imagesArray : []);
                $images = array_filter($images); // Remove null values
            } elseif (is_array($product->images)) {
                $images = array_map(function($image) use ($isUrl) {
                    if (empty($image)) return null;
                    return $isUrl($image) ? $image : Storage::url($image);
                }, $product->images);
                $images = array_filter($images); // Remove null values
            }
        }
        
        // If no images but has main image, use it as the only image
        if (empty($images) && $product->main_image) {
            $images = [$mainImage];
        } elseif (empty($images)) {
            $images = [asset('images/placeholder-product.jpg')];
        }

        // Format product data as array for the view
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => $product->price,
            'original_price' => $hasDiscount ? $product->compare_at_price : null,
            'image' => $mainImage,
            'images' => $images,
            'category' => $product->category ? $product->category->name : 'Uncategorized',
            'category_slug' => $product->category ? $product->category->slug : 'category',
            'stock' => $product->stock,
            'sku' => $product->sku,
            'brand' => $product->brand ?? 'No Brand',
            'rating' => $product->reviews->avg('rating') ?? 0,
            'review_count' => $product->reviews->count(),
            'variants' => []
        ];
        
        // Calculate average rating
        $averageRating = $product->reviews->avg('rating');
        $totalReviews = $product->reviews->count();
        
        // Helper function to process product images
        $processProductImages = function($product) {
            $isUrl = function($str) {
                return filter_var($str, FILTER_VALIDATE_URL) !== false;
            };

            // Process main image
            $mainImage = $product->main_image 
                ? ($isUrl($product->main_image) ? $product->main_image : Storage::url($product->main_image))
                : asset('images/placeholder-product.jpg');
                
            $images = [];
            
            if (!empty($product->images)) {
                if (is_string($product->images)) {
                    $imagesArray = json_decode($product->images, true) ?? [];
                    $images = array_map(function($image) use ($isUrl) {
                        if (empty($image)) return null;
                        return $isUrl($image) ? $image : Storage::url($image);
                    }, is_array($imagesArray) ? $imagesArray : []);
                    $images = array_filter($images);
                } elseif (is_array($product->images)) {
                    $images = array_map(function($image) use ($isUrl) {
                        if (empty($image)) return null;
                        return $isUrl($image) ? $image : Storage::url($image);
                    }, $product->images);
                    $images = array_filter($images);
                }
            }
            
            // If no images but has main image, use it as the only image
            if (empty($images) && $product->main_image) {
                $images = [$mainImage];
            } elseif (empty($images)) {
                $images = [asset('images/placeholder-product.jpg')];
            }
            
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'original_price' => $product->compare_at_price > $product->price ? $product->compare_at_price : null,
                'discount_percentage' => $product->compare_at_price > $product->price 
                    ? round((($product->compare_at_price - $product->price) / $product->compare_at_price) * 100)
                    : 0,
                'image' => $mainImage,
                'images' => $images,
                'stock' => $product->stock,
                'sku' => $product->sku,
                'brand' => $product->brand ?? 'No Brand',
                'rating' => $product->reviews_avg_rating ?? 0,
                'review_count' => $product->reviews_count ?? 0,
                'in_wishlist' => $product->in_wishlist ?? false
            ];
        };
        
        // Get related products with reviews data
        $relatedProducts = Product::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get()
            ->map(function($related) use ($processProductImages) {
                return $processProductImages($related);
            });
            
        // Add wishlist status to main product
        $productData['in_wishlist'] = auth()->check() 
            ? in_array($product->id, auth()->user()->wishlist()->pluck('products.id')->toArray())
            : false;
        
        return view('products.detail', [
            'product' => $productData,
            'relatedProducts' => $relatedProducts,
            'averageRating' => $averageRating,
            'totalReviews' => $totalReviews,
            'hasVariants' => false,
            'variantAttributes' => []
        ]);
    }
}