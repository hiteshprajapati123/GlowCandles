@extends('layouts.app')

@section('title', 'Order Confirmed - ' . config('app.name'))

@section('content')
@php
    session()->flash('success', 'Your order received successfully! In few days order will arrive at your address.');
@endphp

<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Order Confirmation Header -->
        <div class="text-center mb-12">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
                <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="mt-4 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
                Order Confirmed!
            </h1>
            <p class="mt-3 text-lg text-gray-500">
                Thank you for your purchase. We've sent an order confirmation to 
                <span class="font-medium text-gray-900">{{ $order['email'] ?? 'your email' }}</span>.
            </p>
            <p class="mt-2 text-sm text-gray-500">
                Order #{{ $order['order_number'] ?? '' }} • {{ $order['date'] ?? now()->format('F j, Y') }}
            </p>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
            </div>
            
            <!-- Order Items -->
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <div class="flow-root">
                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                        @foreach($order['items'] ?? [] as $item)
                        <li class="py-6 flex">
                            <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                <img src="{{ $item['image'] ?? asset('images/placeholder-product.jpg') }}" 
                                     alt="{{ $item['name'] ?? 'Product' }}" 
                                     class="w-full h-full object-center object-cover">
                            </div>

                            <div class="ml-4 flex-1 flex flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <h3>{{ $item['name'] ?? 'Product' }}</h3>
                                        <p class="ml-4">₹{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}</p>
                                    </div>
                                    @if(isset($item['variant']))
                                    <p class="mt-1 text-sm text-gray-500">{{ $item['variant'] }}</p>
                                    @endif
                                </div>
                                <div class="flex-1 flex items-end justify-between text-sm">
                                    <p class="text-gray-500">Qty {{ $item['quantity'] ?? 1 }}</p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Order Details -->
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <div class="space-y-4">
                    <div class="flex justify-between text-base font-medium text-gray-900">
                        <p>Subtotal</p>
                        <p>₹{{ number_format($order['subtotal'] ?? 0, 2) }}</p>
                    </div>
                    
                    <div class="flex justify-between text-base font-medium text-gray-900">
                        <p>Shipping</p>
                        <p>₹{{ number_format($order['shipping'] ?? 0, 2) }}</p>
                    </div>
                    
                    <div class="flex justify-between text-base font-medium text-gray-900">
                        <p>Tax ({{ $order['tax_rate'] ?? 8 }}%)</p>
                        <p>₹{{ number_format($order['tax'] ?? 0, 2) }}</p>
                    </div>
                    
                    @if(isset($order['discount']) && $order['discount'] > 0)
                    <div class="flex justify-between text-base font-medium text-green-600">
                        <p>Discount</p>
                        <p>-₹{{ number_format($order['discount'], 2) }}</p>
                    </div>
                    @endif
                    
                    <div class="flex justify-between text-lg font-bold text-gray-900 pt-4 border-t border-gray-200">
                        <p>Total</p>
                        <p>₹{{ number_format($order['total'] ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium text-gray-900">Shipping Information</h3>
                <div class="mt-4">
                    @if(isset($order['shipping_address']))
                        <address class="not-italic">
                            <div class="text-base text-gray-700">
                                <p class="font-medium">{{ $order['shipping_address']['name'] ?? 'N/A' }}</p>
                                <p>{{ $order['shipping_address']['address'] ?? 'N/A' }}</p>
                                @if(!empty($order['shipping_address']['address_line2'] ?? ''))
                                    <p>{{ $order['shipping_address']['address_line2'] }}</p>
                                @endif
                                <p>
                                    {{ $order['shipping_address']['city'] ?? 'N/A' }}, 
                                    {{ $order['shipping_address']['state'] ?? 'N/A' }} 
                                    {{ $order['shipping_address']['postal_code'] ?? 'N/A' }}
                                </p>
                                <p>{{ $order['shipping_address']['country'] ?? 'N/A' }}</p>
                                <p class="mt-2">
                                    <span class="font-medium">Phone:</span> 
                                    {{ $order['shipping_address']['phone'] ?? 'N/A' }}
                                </p>
                            </div>
                        </address>
                    @else
                        <p class="text-gray-500">Shipping information not available</p>
                    @endif
                </div>
            </div>

            <!-- Payment Method -->
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium text-gray-900">Payment Method</h3>
                <div class="mt-4 flex items-center">
                    <div class="bg-gray-100 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">Cash on Delivery (COD)</span>
                </div>
            </div>

            <!-- Order Status -->
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium text-gray-900">Order Status</h3>
                <div class="mt-4">
                    <div class="flex items-center">
                        <div class="relative w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-600 h-2.5 rounded-full" style="width: 60%"></div>
                        </div>
                        <span class="ml-3 text-sm font-medium text-green-600">Processing</span>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">We're preparing your order for shipment</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('home') }}" 
               class="w-full sm:w-auto flex justify-center py-3 px-6 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Continue Shopping
            </a>
            <a href="{{ route('user.orders.index') }}" 
               class="w-full sm:w-auto flex justify-center py-3 px-6 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                View All Orders
            </a>
        </div>

        <!-- Support Section -->
        <div class="mt-16 text-center">
            <h3 class="text-lg font-medium text-gray-900">Need help with your order?</h3>
            <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                If you have any questions about your order, our customer service team is happy to help.
            </p>
            <div class="mt-4">
                <a href="{{ route('contact') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-500 font-medium">
                    Contact Support
                    <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection