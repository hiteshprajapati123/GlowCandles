<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Services\ActivityService;

class CheckoutController extends Controller
{
    protected $taxRate;
    protected $shippingCost;

    public function __construct()
    {
        $this->taxRate = config('cart.tax_rate', 8); // 8% default tax rate
        $this->shippingCost = config('cart.shipping_cost', 30); // Default shipping cost
    }

    /**
     * Display the checkout page
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get saved addresses
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
        
        if ($addresses->isEmpty()) {
            return redirect()->route('checkout.address.create')
                ->with('info', 'Please add a shipping address before proceeding with checkout.');
        }

        // Get cart items
        $cartItems = $this->getCartItems();
        
        if (empty($cartItems)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add items before checking out.');
        }

        // Calculate order summary
        $subtotal = collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $tax = $subtotal * ($this->taxRate / 100);
        $total = $subtotal + $tax + $this->shippingCost;

        // Prepare order summary
        $orderSummary = [
            'items' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $this->shippingCost,
            'total' => $total,
            'tax_rate' => $this->taxRate
        ];

        return view('checkout.index', [
            'orderSummary' => $orderSummary,
            'addresses' => $addresses,
            'cartItems' => $cartItems
        ]);
    }

    /**
     * Process the checkout
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Validate request
        $validated = $request->validate([
            'shipping_address_id' => [
                'required',
                'exists:addresses,id',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Address::where('id', $value)->where('user_id', $user->id)->exists()) {
                        $fail('The selected shipping address is invalid.');
                    }
                }
            ]
        ]);

        // Get cart items
        $cartItems = $this->getCartItems();
        
        if (empty($cartItems)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add items before checking out.');
        }

        // Calculate order values
        $subtotal = collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $tax = $subtotal * ($this->taxRate / 100);
        $total = $subtotal + $tax + $this->shippingCost;

        // Get shipping address
        $shippingAddress = Address::findOrFail($validated['shipping_address_id']);

        // Generate order number
        $orderNumber = 'ORD-' . strtoupper(Str::random(8)) . now()->format('Ymd');

        // Create the order
        $order = new Order([
            'order_number' => $orderNumber,
            'user_id' => $user->id,
            'status' => 1, // 1 = pending, 2 = processing, 3 = completed, etc.
            'grand_total' => $total,
            'item_count' => count($cartItems),
            'payment_status' => 1, // 1 = pending, 2 = paid, 3 = failed, etc.
            'payment_method' => 'cod',
            'first_name' => $shippingAddress->first_name ?? $user->name,
            'last_name' => $shippingAddress->last_name ?? '',
            'email' => $user->email,
            'address' => $shippingAddress->address_line1,
            'address_line2' => $shippingAddress->address_line2,
            'city' => $shippingAddress->city,
            'state' => $shippingAddress->state,
            'country' => $shippingAddress->country,
            'post_code' => $shippingAddress->postal_code,
            'phone_number' => $shippingAddress->phone,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $this->shippingCost,
            'order_notes' => $request->input('order_notes'),
        ]);

        $order->save();

        // Add order items
        foreach ($cartItems as $item) {
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'options' => json_encode($item['options'] ?? []),
            ]);
            $orderItem->save();
        }

        // Clear the cart
        CartItem::where('user_id', $user->id)->delete();

        // Log the order placement
        ActivityService::log(
            user: $user,
            type: 'order_placed',
            title: 'Order Placed',
            description: 'Order #' . $order->order_number . ' has been placed',
            icon: 'shopping-bag',
            color: 'text-green-500',
            metadata: [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'amount' => $order->grand_total,
                'item_count' => $order->item_count
            ]
        );

        // Redirect to success page with the order number
        return redirect()->route('checkout.success', $order->order_number);
    }

    /**
     * Show order success page
     */
    public function success($orderNumber)
    {
        $order = Order::with(['items.product', 'user'])
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Format order items for the view
        $formattedItems = $order->items->map(function ($item) {
            $options = $item->options ? json_decode($item->options, true) : [];
            
            // Handle product image URL
            $image = 'images/placeholder-product.jpg';
            if (!empty($item->product->main_image)) {
                if (filter_var($item->product->main_image, FILTER_VALIDATE_URL)) {
                    $image = $item->product->main_image;
                } elseif (strpos($item->product->main_image, 'http') === 0) {
                    $image = $item->product->main_image;
                } elseif (strpos($item->product->main_image, 'products/') === 0) {
                    $image = asset('storage/' . $item->product->main_image);
                } elseif (strpos($item->product->main_image, 'public/') === 0) {
                    $image = asset(str_replace('public/', 'storage/', $item->product->main_image));
                } else {
                    $image = asset($item->product->main_image);
                }
            }

            return [
                'id' => $item->product_id,
                'name' => $item->name,
                'price' => (float)$item->price,
                'quantity' => (int)$item->quantity,
                'image' => $image,
                'variant' => $options['variant'] ?? null,
                'options' => $options
            ];
        });

        // Format shipping address
        $shippingAddress = [
            'name' => trim($order->first_name . ' ' . $order->last_name),
            'address' => $order->address,
            'address_line2' => $order->address_line2,
            'city' => $order->city,
            'state' => $order->state,
            'postal_code' => $order->post_code,
            'country' => $order->country,
            'phone' => $order->phone_number
        ];

        // Format payment method
        $paymentMethod = $order->payment_method ? ucwords(str_replace('_', ' ', $order->payment_method)) : 'Cash on Delivery';
        
        // Format order status
        $status = $order->status ? ucfirst($order->status) : 'Processing';

        $formattedOrder = [
            'order_number' => $order->order_number,
            'date' => $order->created_at->format('F j, Y'),
            'email' => $order->email ?? ($order->user->email ?? ''),
            'subtotal' => (float)$order->subtotal,
            'shipping' => (float)$order->shipping,
            'tax' => (float)$order->tax,
            'tax_rate' => $this->taxRate,
            'total' => (float)$order->grand_total,
            'items' => $formattedItems,
            'shipping_address' => $shippingAddress,
            'payment_method' => $paymentMethod,
            'status' => $status
        ];

        return view('checkout.success', ['order' => $formattedOrder]);
    }

    /**
     * Get cart items from the database
     */
    protected function getCartItems()
    {
        if (!Auth::check()) {
            return [];
        }

        return CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {
                $product = $item->product;
                $imageUrl = $product->main_image ?? null;
                
                if ($imageUrl && !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                    $imageUrl = asset('storage/' . ltrim($imageUrl, '/'));
                } elseif (!$imageUrl) {
                    $imageUrl = asset('images/placeholder-product.jpg');
                }

                $options = $item->options;
                if (is_string($options)) {
                    $options = json_decode($options, true) ?? [];
                }

                return [
                    'id' => $item->product_id,
                    'name' => $product->name ?? 'Product Not Found',
                    'price' => (float)$item->price,
                    'quantity' => (int)$item->quantity,
                    'image' => $imageUrl,
                    'variant' => $options['variant'] ?? 'Default',
                    'options' => $options
                ];
            })
            ->toArray();
    }

    /**
     * Clear the user's cart
     */
    protected function clearCart()
    {
        try {
            $userId = Auth::id();
            
            // Clear database cart items
            CartItem::where('user_id', $userId)->delete();
            
            // Clear session cart if exists
            if (session()->has('cart')) {
                session()->forget('cart');
            }
            
            // Clear cart service if available
            if (class_exists('Cart') && method_exists('Cart', 'destroy')) {
                Cart::destroy();
            }
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Error clearing cart: ' . $e->getMessage());
            return false;
        }
    }
}