@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>
    
    @if(count($cartItems) > 0)
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Cart Items -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="hidden md:grid grid-cols-12 bg-gray-100 p-4 font-semibold text-gray-600">
                    <div class="col-span-5">Product</div>
                    <div class="col-span-2 text-center">Price</div>
                    <div class="col-span-3 text-center">Quantity</div>
                    <div class="col-2 text-center">Total</div>
                </div>

                @foreach($cartItems as $item)
                <div class="p-4 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-stretch">
                        <!-- Product Image and Info -->
                        <div class="flex items-start md:w-5/12 mb-4 md:mb-0">
                            <div class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded-md overflow-hidden mr-4">
                                @php
                                    $imageUrl = $item->product->main_image;
                                    if ($imageUrl && !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                                        $imageUrl = asset('storage/' . ltrim($imageUrl, '/'));
                                    } elseif (!$imageUrl) {
                                        $imageUrl = asset('images/placeholder-product.jpg');
                                    }
                                @endphp
                                <img src="{{ $imageUrl }}" 
                                     alt="{{ $item->product->name }}"
                                     class="w-full h-full object-contain p-1">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-900 truncate">{{ $item->product->name }}</h3>
                                @if(isset($item->options['variant']))
                                    <p class="text-sm text-gray-500 truncate">Variant: {{ $item->options['variant'] }}</p>
                                @endif
                                <div class="flex items-center gap-3 mt-2">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 text-sm hover:text-red-700">
                                            Remove
                                        </button>
                                    </form>
                                    <form id="update-form-{{ $item->id }}" action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <button type="submit" class="text-blue-500 text-sm hover:text-blue-700">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="md:w-2/12 flex md:justify-center items-center mb-4 md:mb-0">
                            <span class="md:hidden font-medium mr-2">Price:</span>
                            <span class="text-gray-900">₹{{ number_format($item->price, 2) }}</span>
                        </div>

                        <!-- Quantity -->
                        <div class="md:w-3/12 flex items-center mb-4 md:mb-0">
                            <span class="font-medium mr-2">Quantity:</span>
                            <div class="flex items-center">
                                <input type="number" 
                                       name="quantity" 
                                       value="{{ $item->quantity }}" 
                                       min="1" 
                                       max="100"
                                       form="update-form-{{ $item->id }}"
                                       class="quantity-input w-12 h-8 border rounded-md border-gray-300 text-center"
                                       data-item-id="{{ $item->id }}"
                                       required>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="md:w-2/12 flex items-center justify-between">
                            <span class="md:hidden font-medium">Total:</span>
                            <span class="font-medium">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-lg shadow-md p-6 h-fit">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($summary['subtotal'], 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span>₹{{ number_format($summary['shipping'], 2) }}</span>
                    </div>
                    @if($summary['tax'] > 0)
                    <div class="flex justify-between">
                        <span>Tax</span>
                        <span>₹{{ number_format($summary['tax'], 2) }}</span>
                    </div>
                    @endif
                    @if($summary['discount'] > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Discount</span>
                        <span>-₹{{ number_format($summary['discount'], 2) }}</span>
                    </div>
                    @endif
                    <div class="border-t border-gray-200 my-2"></div>
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <div class="text-2xl font-bold">₹{{ number_format($summary['total'], 2) }}</div>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" 
                   class="block w-full bg-indigo-600 text-white text-center py-3 px-4 rounded-md hover:bg-indigo-700 transition duration-200">
                    Proceed to Checkout
                </a>

                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">or</p>
                    <a href="{{ route('products.index') }}" 
                       class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-12">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <h2 class="mt-4 text-xl font-medium text-gray-900">Your cart is empty</h2>
        <p class="mt-2 text-gray-600">Looks like you haven't added any items to your cart yet.</p>
        <div class="mt-6">
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                Continue Shopping
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
async function updateCartItem(itemId) {
    const quantityInput = document.querySelector(`input[data-item-id="${itemId}"][name="quantity"]`);
    const quantity = quantityInput.value;
    const token = document.querySelector('meta[name="csrf-token"]').content;
    
    try {
        const response = await fetch(`/cart/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                _method: 'PUT',
                item_id: itemId,
                quantity: quantity
            })
        });

        if (!response.ok) {
            throw new Error('Failed to update cart');
        }

        const data = await response.json();
        
        if (data.success) {
            window.location.reload();
        } else {
            throw new Error(data.message || 'Failed to update cart');
        }
        
    } catch (error) {
        console.error('Error updating cart:', error);
        alert(error.message || 'Error updating cart. Please try again.');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle quantity input changes on Enter key
    document.querySelectorAll('input[name="quantity"]').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const itemId = this.getAttribute('data-item-id');
                updateCartItem(itemId);
            }
        });
    });
});
</script>
@endpush