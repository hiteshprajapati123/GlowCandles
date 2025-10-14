<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Get the cart count for the current user
     * 
     * @return int
     */
    public static function getCartCount()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())->sum('quantity');
        }
        $cart = Session::get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
    
    /**
     * Get the cart count for the current user (JSON response)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function count()
    {
        return response()->json([
            'count' => self::getCartCount(),
            'cart_count' => self::getCartCount() // For backward compatibility
        ]);
    }
    
    /**
     * Display the shopping cart.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cartItems = [];
        $cartCount = 0;
        $subtotal = 0;
        $shipping = 0;
        $tax = 0;
        $total = 0;
        
        if (Auth::check()) {
            // Get cart items from database for logged-in users
            $cartItems = CartItem::with('product')
                ->where('user_id', Auth::id())
                ->get();
                
            $cartCount = $cartItems->sum('quantity');
            $subtotal = $cartItems->sum(function($item) {
                return $item->price * $item->quantity;
            });
        } else {
            // Get cart items from session for guests
            $cart = Session::get('cart', []);
            $productIds = array_map(function($key) {
                return explode('_', $key)[0];
            }, array_keys($cart));
            
            if (!empty($productIds)) {
                $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
                
                foreach ($cart as $itemKey => $item) {
                    $productId = explode('_', $itemKey)[0];
                    if (isset($products[$productId])) {
                        $product = $products[$productId];
                        $quantity = $item['quantity'];
                        $itemTotal = $product->price * $quantity;
                        
                        $cartItems[] = (object)[
                            'id' => $itemKey,
                            'product' => $product,
                            'quantity' => $quantity,
                            'price' => $product->price,
                            'options' => $item['options'] ?? []
                        ];
                        
                        $subtotal += $itemTotal;
                        $cartCount += $quantity;
                    }
                }
            }
        }
        
        // Calculate shipping, tax, and total
        $shipping = $subtotal > 0 ? config('cart.shipping_cost', 0) : 0;
        $taxRate = config('cart.tax_rate', 0);
        $tax = $subtotal * ($taxRate / 100);
        $discount = 0; // Initialize discount to 0
        $total = $subtotal + $shipping + $tax - $discount;
        
        // Prepare summary - pass raw numbers and let the view handle formatting
        $summary = [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'tax_rate' => $taxRate,
            'discount' => $discount,
            'total' => $total,
            'count' => $cartCount
        ];
        
        // For backward compatibility, also pass individual variables
        return view('cart.index', compact('cartItems', 'summary'));
    }
    
    /**
     * Add an item to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1|max:100',
                'variant' => 'nullable|string|max:100'
            ]);
            
            $product = Product::findOrFail($validated['product_id']);
            $quantity = (int)$validated['quantity'];
            $variant = $validated['variant'] ?? 'default';
            
            if (Auth::check()) {
                // For authenticated users
                $cartItem = $this->addToDatabaseCart($product, $quantity, $variant);
                $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
            } else {
                // For guests
                $cartItem = $this->addToSessionCart($product, $quantity, $variant);
                $cart = Session::get('cart', []);
                $cartCount = array_sum(array_column($cart, 'quantity'));
            }
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart!',
                    'cart_count' => $cartCount,
                    'item' => [
                        'id' => $cartItem['id'],
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'image' => $product->main_image ? asset('storage/' . $product->main_image) : null
                    ]
                ]);
            }
            
            return redirect()->route('cart.index')->with('success', 'Product added to cart!');
            
        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error adding to cart: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error adding to cart: ' . $e->getMessage());
        }
    }
    
    /**
     * Add item to database cart (for authenticated users).
     *
     * @param  \App\Models\Product  $product
     * @param  int  $quantity
     * @param  string  $variant
     * @return \App\Models\CartItem
     */
    protected function addToDatabaseCart($product, $quantity, $variant)
    {
        return DB::transaction(function () use ($product, $quantity, $variant) {
            $cartId = 'user_' . Auth::id();
            
            // Check if the same product with same variant already exists in cart
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->whereJsonContains('options->variant', $variant)
                ->first();
            
            if ($cartItem) {
                // Update quantity if item exists
                $cartItem->increment('quantity', $quantity);
            } else {
                // Create new cart item
                $cartItem = CartItem::create([
                    'cart_id' => $cartId,
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'options' => ['variant' => $variant],
                    'added_at' => now()
                ]);
            }
            
            return $cartItem;
        });
    }
    
    /**
     * Add item to session cart (for guests).
     *
     * @param  \App\Models\Product  $product
     * @param  int  $quantity
     * @param  string  $variant
     * @return array
     */
    protected function addToSessionCart($product, $quantity, $variant)
    {
        $cart = Session::get('cart', []);
        $productId = $product->id;
        $variantKey = md5($variant);
        
        // Create a unique key for this product + variant combination
        $itemKey = $productId . '_' . $variantKey;
        
        if (isset($cart[$itemKey])) {
            // Update quantity if item exists
            $cart[$itemKey]['quantity'] += $quantity;
        } else {
            // Add new item to cart
            $cart[$itemKey] = [
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
                'options' => ['variant' => $variant],
                'added_at' => now()->toDateTimeString()
            ];
        }
        
        Session::put('cart', $cart);
        
        return [
            'id' => $itemKey,
            'product_id' => $productId,
            'quantity' => $cart[$itemKey]['quantity'],
            'price' => $product->price,
            'options' => $cart[$itemKey]['options']
        ];
    }
    
    /**
     * Update the specified cart item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1|max:100',
                'item_id' => 'required|string',
            ]);
            
            $quantity = (int)$validated['quantity'];
            $itemId = $validated['item_id'];
            
            if (Auth::check()) {
                $cartItem = CartItem::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->with('product')
                    ->firstOrFail();
                
                $cartItem->update(['quantity' => $quantity]);
                
                // Recalculate cart totals
                $cartItems = CartItem::with('product')
                    ->where('user_id', Auth::id())
                    ->get();
                    
                $subtotal = $cartItems->sum(function($item) {
                    return $item->price * $item->quantity;
                });
                
                $cartCount = $cartItems->sum('quantity');
                $itemTotal = $cartItem->price * $quantity;
                
                // Get shipping cost (example: free shipping over 1000)
                $shipping = $subtotal >= 1000 ? 0 : 100;
                $total = $subtotal + $shipping;
                
            } else {
                $cart = Session::get('cart', []);
                
                if (isset($cart[$id])) {
                    $cart[$id]['quantity'] = $quantity;
                    Session::put('cart', $cart);
                    
                    // Recalculate cart totals
                    $subtotal = 0;
                    foreach ($cart as $item) {
                        $subtotal += $item['price'] * $item['quantity'];
                    }
                    
                    $cartCount = array_sum(array_column($cart, 'quantity'));
                    $itemTotal = $cart[$id]['price'] * $quantity;
                    $shipping = $subtotal >= 1000 ? 0 : 100;
                    $total = $subtotal + $shipping;
                } else {
                    throw new \Exception('Item not found in cart');
                }
            }
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'cart_count' => $cartCount,
                    'item_total' => number_format($itemTotal, 2),
                    'subtotal' => number_format($subtotal, 2),
                    'shipping' => number_format($shipping, 2),
                    'total' => number_format($total, 2),
                    'item' => [
                        'id' => $itemId,
                        'quantity' => $quantity,
                        'price' => $cartItem->price ?? $cart[$id]['price']
                    ]
                ]);
            }
            
            return redirect()->route('cart.index')->with('success', 'Cart updated!');
            
        } catch (\Exception $e) {
            Log::error('Error updating cart: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating cart: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error updating cart: ' . $e->getMessage());
        }
    }
    
    /**
     * Remove the specified item from cart.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        try {
            if (Auth::check()) {
                $cartItem = CartItem::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
                
                $cartItem->delete();
                $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
            } else {
                $cart = Session::get('cart', []);
                
                if (isset($cart[$id])) {
                    unset($cart[$id]);
                    Session::put('cart', $cart);
                    $cartCount = array_sum(array_column($cart, 'quantity'));
                } else {
                    throw new \Exception('Item not found in cart');
                }
            }
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'cart_count' => $cartCount,
                    'subtotal' => $this->getCartSubtotal(),
                    'message' => 'Item removed from cart'
                ]);
            }
            
            return redirect()->route('cart.index')->with('success', 'Item removed from cart');
            
        } catch (\Exception $e) {
            Log::error('Error removing from cart: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error removing item: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error removing item: ' . $e->getMessage());
        }
    }
    
    /**
     * Get the cart subtotal.
     *
     * @return string
     */
    protected function getCartSubtotal()
    {
        if (Auth::check()) {
            $cartItems = CartItem::where('user_id', Auth::id())->get();
            $subtotal = $cartItems->sum(function($item) {
                return $item->price * $item->quantity;
            });
        } else {
            $cart = Session::get('cart', []);
            $subtotal = array_reduce($cart, function($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);
        }
        
        return number_format($subtotal, 2);
    }
}
