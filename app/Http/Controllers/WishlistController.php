<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $wishlistItems = auth()->user()->wishlist()
                ->with(['reviews'])
                ->get()
                ->map(function($product) {
                    return (object) [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'price' => $product->price,
                        'compare_at_price' => $product->compare_at_price,
                        'image' => $product->main_image_url,
                        'short_description' => $product->short_description ?? '',
                        'in_wishlist' => true,
                        'rating' => (float) number_format($product->reviews->avg('rating') ?? 0, 1),
                        'reviews_count' => $product->reviews->count(),
                    ];
                });
                
            return view('wishlist.index', compact('wishlistItems'));
        } catch (\Exception $e) {
            \Log::error('Error fetching wishlist: ' . $e->getMessage());
            return back()->with('error', 'Unable to load wishlist. Please try again.');
        }
    }

    /**
     * Add a product to the user's wishlist
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function add(Product $product, Request $request)
    {
        $user = Auth::user();
        
        // Check if product is already in wishlist
        if (\App\Models\Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->exists()) {
            return $request->wantsJson() 
                ? response()->json(['success' => false, 'message' => 'Product is already in your wishlist.'])
                : redirect()->back()->with('info', 'Product is already in your wishlist.');
        }
        
        try {
            // Create a new wishlist item
            \App\Models\Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'name' => null // Default wishlist
            ]);
            
            // Handle redirect if specified
            if ($request->has('redirect_to')) {
                return redirect($request->input('redirect_to'))->with('success', 'Product added to wishlist!');
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist!',
                'wishlist_count' => $user->wishlist()->count()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error adding to wishlist: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to wishlist. Please try again.'
            ], 500);
        }
    }
    
    /**
     * Remove a product from the user's wishlist
     *
     * @param  string  $productSlug
     * @return \Illuminate\Http\Response
     */
    public function remove($productId)
    {
        try {
            $user = auth()->user();
            
            // Find and delete the wishlist item directly
            $deleted = \App\Models\Wishlist::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->delete();
            
            if ($deleted > 0) {
                if (request()->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Product removed from wishlist',
                        'wishlist_count' => $user->wishlist()->count()
                    ]);
                }
                
                return redirect()->route('wishlist.index')
                    ->with('success', 'Product removed from wishlist');
            }
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in your wishlist.'
                ], 404);
            }
            
            return redirect()->route('wishlist.index')
                ->with('error', 'Product not found in your wishlist.');
            
        } catch (\Exception $e) {
            \Log::error('Error removing from wishlist: ' . $e->getMessage());
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove product from wishlist. Please try again.'
                ], 500);
            }
            
            return redirect()->route('wishlist.index')
                ->with('error', 'Failed to remove product from wishlist. Please try again.');
        }
    }
    
    /**
     * Move a product from wishlist to cart
     *
     * @param  string  $productSlug
     * @return \Illuminate\Http\Response
     */
    public function moveToCart(Product $product)
    {
        $user = Auth::user();
        
        try {
            // Manually add to cart instead of using CartController
            $cartId = 'user_' . $user->id;
            $quantity = 1;
            
            // Check if product is already in cart
            $cartItem = \App\Models\CartItem::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();
            
            if ($cartItem) {
                // Update quantity if already in cart
                $cartItem->increment('quantity', $quantity);
            } else {
                // Add new item to cart
                $cartItem = new \App\Models\CartItem([
                    'cart_id' => $cartId,
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'options' => [
                        'variant' => 'default',
                        'image' => $product->main_image,
                        'slug' => $product->slug
                    ]
                ]);
                $cartItem->save();
            }
            
            // Remove from wishlist
            $user->wishlist()->detach($product->id);
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product moved to cart!',
                    'cart_count' => \App\Models\CartItem::where('user_id', $user->id)->sum('quantity'),
                    'wishlist_count' => $user->wishlist()->count()
                ]);
            }
            
            return back()->with('success', 'Product moved to cart!');
        } catch (\Exception $e) {
            \Log::error('Error moving product to cart: ' . $e->getMessage());
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to move product to cart. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to move product to cart. Please try again.');
        }
    }
}
