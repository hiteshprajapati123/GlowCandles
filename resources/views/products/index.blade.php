@extends('layouts.app')

@php
use App\Models\CartItem;
@endphp

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 space-y-6">
                <!-- Categories -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center mb-4">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            Categories
                        </h2>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('products.index') }}" 
                                   class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ !request('category') ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 mr-3"></span>
                                    All Categories
                                    <span class="ml-auto bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-full">
                                        {{ \App\Models\Product::where('is_active', true)->count() }}
                                    </span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('products.index', ['category' => $category->slug] + request()->except('category')) }}" 
                                       class="flex items-center px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request('category') == $category->slug ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 mr-3"></span>
                                        {{ $category->name }}
                                        <span class="ml-auto bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-full">
                                            {{ $category->products_count }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <!-- Featured Products -->
                @if($featuredProducts->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center mb-4">
                            <svg class="w-5 h-5 mr-2 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Featured Products
                        </h2>
                        <div class="space-y-4">
                            @foreach($featuredProducts as $product)
                                <a href="{{ route('products.show', $product->id) }}" class="flex items-start space-x-3 group">
                                    <div class="flex-shrink-0 w-16 h-16 overflow-hidden rounded-lg bg-gray-100">
                                        <img src="{{ $product->main_image ?? asset('images/placeholder-product.jpg') }}" 
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate group-hover:text-indigo-600 transition-colors">
                                            {{ $product->name }}
                                        </p>
                                        <p class="text-sm font-bold text-indigo-600">
                                            ${{ number_format($product->price, 2) }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <!-- Header -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                @if(request('category'))
                                    {{ $categories->firstWhere('slug', request('category'))->name ?? 'Products' }}
                                @else
                                    All Products
                                @endif
                            </h1>
                            <p class="text-gray-500 mt-1">
                                {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found
                            </p>
                        </div>
                    </div>

                    <!-- Active Filters -->
                    @if(request('category') || request('search') || request('sort') !== 'newest')
                        <div class="flex flex-wrap items-center gap-2 mt-4 pt-4 border-t border-gray-100">
                            <span class="text-sm font-medium text-gray-600">Filters:</span>
                            
                            @if(request('category'))
                                <a href="{{ route('products.index', request()->except('category')) }}" class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors duration-200">
                                    Category: {{ $categories->firstWhere('slug', request('category'))->name ?? request('category') }}
                                    <svg class="ml-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                            
                            @if(request('search'))
                                <a href="{{ route('products.index', request()->except('search')) }}" class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors duration-200">
                                    Search: "{{ request('search') }}"
                                    <svg class="ml-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                            
                            @if(request('sort') && request('sort') !== 'newest')
                                <a href="{{ route('products.index', request()->except('sort')) }}" class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors duration-200">
                                    Sort: {{ 
                                        request('sort') == 'price_asc' ? 'Price: Low to High' : 
                                        (request('sort') == 'price_desc' ? 'Price: High to Low' : 
                                        (request('sort') == 'name_asc' ? 'Name: A to Z' : 'Name: Z to A')) 
                                    }}
                                    <svg class="ml-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                            
                            @if(request('category') || request('search') || request('sort'))
                                <a href="{{ route('products.index') }}" class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors duration-200 ml-2">
                                    Clear all filters
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($products as $product)
                    <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 overflow-hidden border border-gray-100">
                        <!-- Product Badge -->
                        @if($product->badge)
                        <div class="absolute top-4 left-4 z-10">
                            <span class="bg-gradient-to-r from-orange-500 to-red-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $product->badge }}
                            </span>
                        </div>
                        @endif

                        <!-- Product Image -->
                        <div class="relative overflow-hidden bg-gray-100 aspect-square">
                            @php
                                $imageUrl = $product->main_image;
                                if ($imageUrl && !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                                    $imageUrl = asset('storage/' . $imageUrl);
                                }
                            @endphp
                            <img src="{{ $imageUrl ?? asset('images/placeholder-product.jpg') }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'">
                            
                            <!-- Quick Actions -->
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center space-x-3">
                                <a href="{{ route('products.show', $product->slug) }}" class="bg-white/90 backdrop-blur-sm p-3 rounded-full hover:bg-white transition-colors duration-300 shadow-lg">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <form id="add-to-wishlist-{{ $product->id }}" action="{{ route('wishlist.add', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="redirect_to" value="{{ route('wishlist.index') }}">
                                    <button type="submit" class="bg-white/90 backdrop-blur-sm p-3 rounded-full hover:bg-white transition-colors duration-300 shadow-lg">
                                        <svg class="w-5 h-5 text-red-500" fill="{{ $product->in_wishlist ?? false ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            <!-- Rating -->
                            <div class="flex items-center space-x-1 mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= floor($product->rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @endfor
                                <span class="text-sm text-gray-500 ml-2">({{ $product->reviews }})</span>
                            </div>

                            <!-- Product Info Row -->
                            <div class="flex flex-col space-y-2">
                                <!-- Product Name -->
                                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors duration-300 line-clamp-1">
                                    <a href="{{ route('products.show', $product->slug) }}" class="hover:underline">{{ $product->name }}</a>
                                </h3>
                                
                                <!-- Price and Add to Cart -->
                                <div class="flex items-center justify-between">
                                    <!-- Price -->
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xl font-bold text-gray-800">₹{{ number_format($product->price, 2) }}</span>
                                        @if($product->original_price)
                                            <span class="text-base text-gray-500 line-through">₹{{ number_format($product->original_price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                @php
                                    $inCart = false;
                                    
                                    if (auth()->check()) {
                                        $inCart = CartItem::where('user_id', auth()->id())
                                            ->where('product_id', $product->id)
                                            ->exists();
                                    } else {
                                        $cartItems = session('cart', []);
                                        foreach($cartItems as $item) {
                                            if(isset($item['product_id']) && $item['product_id'] == $product->id) {
                                                $inCart = true;
                                                break;
                                            }
                                        }
                                    }
                                @endphp
                                
                                @if(auth()->check())
                                    <form action="{{ route('cart.add') }}" method="POST" class="w-full add-to-cart-form" data-product-id="{{ $product->id }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1" class="quantity-input">
                                        
                                        <button 
                                            type="submit" 
                                            class="w-full whitespace-nowrap px-4 py-2 rounded-xl font-semibold text-sm transition-all duration-300 shadow {{ $inCart ? 'bg-gray-400 cursor-not-allowed' : 'bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 hover:shadow-md' }} text-white"
                                            {{ $inCart ? 'disabled' : '' }}
                                        >
                                            @if($inCart)
                                                <i class="fas fa-check mr-2"></i>Added to Cart
                                            @else
                                                <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                            @endif
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" 
                                    class="block w-full text-center whitespace-nowrap px-4 py-2 rounded-xl font-semibold text-sm transition-all duration-300 shadow bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 hover:shadow-md text-white">
                                        <i class="fas fa-sign-in-alt mr-2"></i>Login to Purchase
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Empty State -->
                @if($products->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="mx-auto h-24 w-24 text-indigo-100">
                        <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                    <p class="mt-1 text-gray-500">We couldn't find any products matching your criteria.</p>
                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset Filters
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addToCart(productId, button = null) {
        // Disable the button to prevent multiple clicks
        if (button) {
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Adding...
            `;
        }

        // Get CSRF token from meta tag
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1,
                _token: token
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            // Update cart count in the header
            const cartCountElements = document.querySelectorAll('.cart-count');
            if (data.cart_count !== undefined) {
                cartCountElements.forEach(element => {
                    element.textContent = data.cart_count;
                    element.classList.remove('hidden');
                });
            }
            
            // Show success message
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: data.message || 'Product added to cart!',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Show error message
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: error.message || 'Failed to add product to cart. Please try again.',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        })
        .finally(() => {
            // Re-enable the button
            if (button) {
                button.disabled = false;
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Add to Cart
                `;
            }
        });
    }

    // Make function available globally
    window.addToCart = addToCart;
</script>
@endpush
@endsection