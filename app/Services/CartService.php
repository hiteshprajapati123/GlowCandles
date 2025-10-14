<?php

namespace App\Services;

use App\Models\CartItem as CartItemModel;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartService
{
    public function getCart()
    {
        $cart = Cart::instance('cart');
        
        // If cart is empty, try to restore from database
        if ($cart->count() === 0) {
            $this->restoreCartFromDatabase();
        }
        
        return $cart;
    }
    
    public function restoreCartFromDatabase()
    {
        $userId = auth()->id();
        if (!$userId) {
            return;
        }
        
        try {
            // Get product names from the products table
            $dbCartItems = DB::table('cart_items as ci')
                ->leftJoin('products as p', 'ci.product_id', '=', 'p.id')
                ->where('ci.user_id', $userId)
                ->select('ci.*', 'p.name as product_name', 'p.price as product_price')
                ->get();
                
            if ($dbCartItems->isEmpty()) {
                Log::debug('No cart items found in database for user', ['user_id' => $userId]);
                return;
            }
            
            $cart = Cart::instance('cart');
            $restoredCount = 0;
            
            foreach ($dbCartItems as $item) {
                try {
                    // Handle options field
                    $options = [];
                    if (!empty($item->options)) {
                        if (is_string($item->options)) {
                            // Fix malformed JSON if needed
                            $optionsStr = $item->options;
                            if (Str::startsWith($optionsStr, '"') && Str::endsWith($optionsStr, '"')) {
                                $optionsStr = trim($optionsStr, '"');
                                $optionsStr = str_replace('\\"', '"', $optionsStr);
                            }
                            
                            $decoded = json_decode($optionsStr, true);
                            $options = (json_last_error() === JSON_ERROR_NONE) ? $decoded : [];
                        } elseif (is_array($item->options)) {
                            $options = $item->options;
                        }
                    }
                    
                    // Ensure we have valid product data
                    $productName = $item->product_name ?? ('Product ' . $item->product_id);
                    $price = is_numeric($item->price) ? (float)$item->price : 0;
                    $quantity = max(1, (int)$item->quantity);
                    
                    // Add item to cart
                    $cartItem = $cart->add([
                        'id' => $item->product_id,
                        'name' => $productName,
                        'qty' => $quantity,
                        'price' => $price,
                        'options' => $options
                    ]);
                    
                    if ($cartItem) {
                        $restoredCount++;
                        Log::debug('Restored cart item:', [
                            'rowId' => $cartItem->rowId,
                            'product_id' => $item->product_id,
                            'name' => $productName,
                            'quantity' => $quantity,
                            'price' => $price,
                            'options' => $options
                        ]);
                    }
                    
                } catch (\Exception $e) {
                    Log::error('Error restoring cart item:', [
                        'error' => $e->getMessage(),
                        'item' => (array)$item,
                        'trace' => $e->getTraceAsString()
                    ]);
                    continue;
                }
            }
            
            if ($restoredCount > 0) {
                Log::info("Successfully restored $restoredCount items to cart", [
                    'user_id' => $userId,
                    'session_id' => session()->getId()
                ]);
            }
        
        Log::info('Cart restored from database', [
            'user_id' => $userId,
            'items_restored' => $dbCartItems->count(),
            'cart_count' => $cart->count()
        ]);
        } catch (\Exception $e) {
            Log::error('Error restoring cart from database:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
