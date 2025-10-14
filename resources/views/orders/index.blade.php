@extends('layouts.app')

@push('scripts')
<script>
    function toggleOrderDetails(orderId) {
        const details = document.getElementById(`order-details-${orderId}`);
        const icon = document.getElementById(`order-icon-${orderId}`);
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            icon.innerHTML = `
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                </svg>
            `;
        } else {
            details.classList.add('hidden');
            icon.innerHTML = `
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
            `;
        }
    }
</script>
@endpush

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('My Orders') }}
                    </h2>
                </div>
                @if($orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($orders as $order)
                            <div class="border rounded-lg overflow-hidden">
                                <button 
                                    onclick="toggleOrderDetails('{{ $order->id }}')" 
                                    class="w-full text-left p-6 hover:bg-gray-50 transition-colors focus:outline-none"
                                    aria-expanded="false"
                                    aria-controls="order-details-{{ $order->id }}"
                                >
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                                        <div class="space-y-1">
                                            <div class="flex items-center space-x-2">
                                                <h3 class="text-lg font-medium text-gray-900">
                                                    Order #{{ $order->order_number }}
                                                </h3>
                                                <span id="order-icon-{{ $order->id }}" class="text-gray-500">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500">
                                                Placed on {{ $order->created_at->format('F j, Y') }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                {{ $order->item_count }} {{ Str::plural('item', $order->item_count) }}
                                            </p>
                                        </div>
                                            <div class="flex flex-col items-end">
                                                <span class="px-3 py-1 text-sm font-medium rounded-full 
                                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                                <p class="mt-2 text-lg font-semibold text-gray-900">
                                                    ₹{{ number_format($order->grand_total, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        @if($order->items->count() > 0)
                                            <div class="mt-4 pt-4 border-t border-gray-100">
                                                <h4 class="text-sm font-medium text-gray-900 mb-2">Order Items:</h4>
                                                <div class="space-y-2">
                                                    @foreach($order->items->take(3) as $item)
                                                        <div class="flex items-center space-x-3">
                                                            @if($item->product && $item->product->main_image)
                                                                @php
                                                                    $imageUrl = $item->product->main_image;
                                                                    if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                                                                        $imageUrl = asset('storage/' . ltrim($imageUrl, '/'));
                                                                    }
                                                                @endphp
                                                                <img src="{{ $imageUrl }}" 
                                                                    alt="{{ $item->name }}" 
                                                                    class="h-12 w-12 flex-shrink-0 rounded-md object-cover">
                                                            @else
                                                                <div class="h-16 w-16 flex-shrink-0 rounded-md bg-gray-200 flex items-center justify-center">
                                                                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                            <div class="flex-1 ml-4">
                                                                <h5 class="font-medium text-gray-900">{{ $item->name }}</h5>
                                                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                                                @if(!empty($item->options['variant']))
                                                                    <p class="text-sm text-gray-500">Variant: {{ $item->options['variant'] }}</p>
                                                                @endif
                                                            </div>
                                                    <p class="text-sm font-medium text-gray-900">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                                                </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </button>

                                <!-- Order Details (Hidden by default) -->
                                <div id="order-details-{{ $order->id }}" class="hidden">
                                    <div class="p-6 border-t border-gray-100">
                                        <h4 class="font-medium text-gray-900 mb-4">Order Details</h4>
                                        
                                        <!-- Order Items -->
                                        <div class="space-y-4">
                                            @foreach($order->items as $item)
                                                <div class="flex items-start space-x-4">
                                                    @if($item->product && $item->product->main_image)
                                                        @php
                                                            $imageUrl = $item->product->main_image;
                                                            if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                                                                $imageUrl = asset('storage/' . ltrim($imageUrl, '/'));
                                                            }
                                                        @endphp
                                                        <img src="{{ $imageUrl }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded">
                                                    @else
                                                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="flex-1">
                                                        <h5 class="font-medium text-gray-900">{{ $item->name }}</h5>
                                                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                                        @if(!empty($item->options['variant']))
                                                            <p class="text-sm text-gray-500">Variant: {{ $item->options['variant'] }}</p>
                                                        @endif
                                                    </div>
                                                    <p class="text-sm font-medium text-gray-900">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Order Summary -->
                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <h5 class="font-medium text-gray-900 mb-3">Order Summary</h5>
                                            <div class="space-y-2 text-sm">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Subtotal</span>
                                                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                                                </div>
                                                @if($order->discount > 0)
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-600">Discount</span>
                                                        <span class="text-green-600">-₹{{ number_format($order->discount, 2) }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Shipping</span>
                                                    <span>₹{{ number_format($order->shipping_cost, 2) }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Tax</span>
                                                    <span>₹{{ number_format($order->tax, 2) }}</span>
                                                </div>
                                                <div class="flex justify-between pt-2 mt-2 border-t border-gray-200 font-medium">
                                                    <span>Total</span>
                                                    <span>₹{{ number_format($order->grand_total, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Shipping Address -->
                                        @if($order->shippingAddress)
                                            <div class="mt-6 pt-6 border-t border-gray-200">
                                                <h5 class="font-medium text-gray-900 mb-2">Shipping Address</h5>
                                                <address class="not-italic text-sm text-gray-600">
                                                    {{ $order->shippingAddress->name }}<br>
                                                    {{ $order->shippingAddress->address_line_1 }}<br>
                                                    @if($order->shippingAddress->address_line_2)
                                                        {{ $order->shippingAddress->address_line_2 }}<br>
                                                    @endif
                                                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->postal_code }}<br>
                                                    {{ $order->shippingAddress->country }}<br>
                                                    Phone: {{ $order->shippingAddress->phone }}
                                                </address>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">No orders yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Your order history will appear here.</p>
                            <div class="mt-6">
                                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
