@extends('layouts.app')

@section('title', 'Checkout - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Progress Steps -->
        <div class="max-w-3xl mx-auto mb-12">
            <div class="flex items-center justify-between">
                <!-- Step 1: Cart -->
                <div class="flex flex-col items-center relative">
                    <div class="h-10 w-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-medium mb-2 z-10">
                        1
                    </div>
                    <span class="text-sm font-medium text-emerald-600">Cart</span>
                </div>

                <div class="flex-1 border-t-2 border-emerald-600 mx-2 relative -top-5"></div>

                <!-- Step 2: Checkout -->
                <div class="flex flex-col items-center relative">
                    <div class="h-10 w-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-medium mb-2 z-10">
                        2
                    </div>
                    <span class="text-sm font-medium text-emerald-600">Checkout</span>
                </div>

                <div class="flex-1 border-t-2 border-gray-200 mx-2 relative -top-5"></div>

                <!-- Step 3: Complete -->
                <div class="flex flex-col items-center relative">
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-medium mb-2 z-10">
                        3
                    </div>
                    <span class="text-sm font-medium text-gray-500">Complete</span>
                </div>
            </div>
        </div>

        <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <!-- Hidden order ID if it exists -->
            @if(isset($order) && $order)
                <input type="hidden" name="order_id" value="{{ $order->id }}">
            @endif
            
            <!-- Hidden address ID field that will be populated by JavaScript -->
            @php
                $defaultAddress = $addresses->firstWhere('is_default', true) ?? $addresses->first();
                $defaultAddressId = $defaultAddress ? $defaultAddress->id : '';
            @endphp
            <input type="hidden" name="shipping_address_id" id="shipping_address_id" value="{{ old('shipping_address_id', $defaultAddressId) }}">
            
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Left Column - Checkout Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="h-5 w-5 text-emerald-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Contact Information
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                                    <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? '' }}" 
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" 
                                           {{ auth()->check() ? 'readonly' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Shipping Address
                            </h2>
                            <h1>{{ auth()->user()->addresses->count() }}</h1>
                        </div>
                        <h1>Maximum 2 addresses. Edit anytime, but can't be deleted</h1>
                        <!-- Addresses Container -->
                        <div id="addressesContainer" class="space-y-4">
                            @php
                                $displayedAddresses = 0;
                                $maxAddresses = 2;
                            @endphp
                            @forelse(auth()->user()->addresses as $address)
                                @if($displayedAddresses >= $maxAddresses)
                                    @continue
                                @endif
                                @php $displayedAddresses++; @endphp
                                <div class="border rounded-xl p-4 hover:border-emerald-400 transition-colors cursor-pointer address-option {{ $address->is_default ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200' }}" 
                                     data-address-id="{{ $address->id }}" 
                                     onclick="this.querySelector('input[type=\'radio\']').click()">
                                    <div class="flex items-start gap-4">
                                        <div class="mt-1" onclick="event.stopPropagation()">
                                            <input type="radio" 
                                                   name="address_radio" 
                                                   value="{{ $address->id }}" 
                                                   {{ old('shipping_address_id', $address->is_default ? 'checked' : '') == $address->id ? 'checked' : '' }}
                                                   class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300" 
                                                   onchange="updateSelectedAddress(this)">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-start gap-4">
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between w-full">
                                                        <div class="flex items-center gap-2">
                                                            <h4 class="font-medium text-gray-900">{{ $address->full_name }}</h4>
                                                            @if($address->is_default)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                                    Default
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <a href="{{ route('checkout.address.edit', $address->id) }}" 
                                                           class="text-emerald-600 hover:text-emerald-800 text-sm font-medium flex items-center"
                                                           onclick="event.stopPropagation()">
                                                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            Edit
                                                        </a>
                                                    </div>
                                                    <div class="mt-1">
                                                        <p class="text-sm text-gray-600 break-words">{{ $address->address_line1 }}</p>
                                                        @if($address->address_line2)
                                                            <p class="text-sm text-gray-600 break-words">{{ $address->address_line2 }}</p>
                                                        @endif
                                                        <p class="text-sm text-gray-600">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                                        <p class="text-sm text-gray-600">{{ $address->country }}</p>
                                                        <p class="text-sm text-gray-600">Phone: {{ $address->phone }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div id="noAddressMessage" class="text-center py-8 text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No saved addresses</h3>
                                    <p class="mt-1 text-sm text-gray-500">Add your first address to get started</p>
                                </div>
                            @endforelse
                            
                            @if(auth()->user()->addresses->count() > $maxAddresses)
                                <div class="text-center text-sm text-gray-500 mt-2">
                                    Showing 2 of {{ auth()->user()->addresses->count() }} addresses
                                </div>
                            @endif
                        </div>

                        @error('shipping_address_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Add New Address Button -->
                        @if(auth()->user()->addresses->count() < 2)
                        <div class="mt-6" id="addAddressContainer">
                            <a href="{{ route('checkout.address.create') }}" class="block w-full">
                                <button type="button" class="w-full flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-emerald-500 hover:bg-emerald-50 transition-colors">
                                    <svg class="h-5 w-5 text-emerald-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span class="text-emerald-600 font-medium">Add New Address</span>
                                </button>
                            </a>
                        </div>
                        @endif
                    </div>

                </div>

                <!-- Right Column - Order Summary -->
                <div class="mt-12 lg:mt-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Order Summary</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                <!-- Order Items -->
                                <div class="space-y-4 max-h-64 overflow-y-auto">
                                    @foreach($orderSummary['items'] ?? [] as $item)
                                    <div class="flex items-center">
                                        <div class="h-16 w-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                            @if(isset($item['image']))
                                                <img src="{{ $item['image'] }}" 
                                                     alt="{{ $item['name'] }}" 
                                                     class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-gray-200">
                                                    <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M4 4h16v12H4z" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/>
                                                        <path d="M21 15l-5-5L5 21" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</h4>
                                            <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                        </div>
                                        <div class="ml-4 text-sm font-medium text-gray-900">
                                            ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Order Summary -->
                                <div class="border-t border-gray-200 pt-6 space-y-4">
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <p>Subtotal</p>
                                        <p>₹{{ number_format($orderSummary['subtotal'] ?? 0, 2) }}</p>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <p>Shipping</p>
                                        <p>₹{{ number_format($orderSummary['shipping'] ?? 0, 2) }}</p>
                                    </div>
                                    @if(($orderSummary['tax'] ?? 0) > 0)
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <p>Tax</p>
                                        <p>₹{{ number_format($orderSummary['tax'] ?? 0, 2) }}</p>
                                    </div>
                                    @endif
                                    <div class="flex justify-between text-base font-medium text-gray-900 border-t border-gray-200 pt-4">
                                        <p>Total</p>
                                        <p>₹{{ number_format($orderSummary['total'] ?? 0, 2) }}</p>
                                    </div>
                                </div>

                                <!-- Place Order Button -->
                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                                    Place Order
                                </button>

                                <!-- Security Info -->
                                <div class="text-center text-sm text-gray-500">
                                    <div class="flex items-center justify-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Secure Checkout
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Handle address selection
    function updateSelectedAddress(radio) {
        // Update the hidden shipping address field
        document.getElementById('shipping_address_id').value = radio.value;
        
        // Update visual feedback for all address cards
        document.querySelectorAll('.address-option').forEach(card => {
            if (card.dataset.addressId === radio.value) {
                card.classList.add('border-emerald-500', 'bg-emerald-50');
                card.classList.remove('border-gray-200');
            } else {
                card.classList.remove('border-emerald-500', 'bg-emerald-50');
                card.classList.add('border-gray-200');
            }
        });
    }
</script>
@endpush

@endsection
