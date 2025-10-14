@extends('layouts.app')

@php
    use App\Models\CartItem;
@endphp

@section('title', 'ShopCraft - Premium E-commerce Experience')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-900 via-teal-900 to-emerald-900 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="2"/></g></svg>');"></div>
    </div>
    
    <div class="absolute inset-0 bg-black/30"></div>
    
    <div class="relative z-10 text-center text-white max-w-6xl mx-auto px-4">
        <div class="mb-8 mt-2">
            <span class="inline-block bg-emerald-500/20 backdrop-blur-sm border border-emerald-400/30 text-emerald-200 px-4 py-2 rounded-full text-sm font-medium mb-6">
                🎉 New Collection Available Now
            </span>
        </div>
        
        <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-white via-emerald-100 to-teal-200 leading-tight">
            Glow Candles With<br>
            <span class="text-emerald-400">Love</span>
        </h1>
        
        <p class="text-xl md:text-2xl mb-8 text-emerald-100 max-w-3xl mx-auto leading-relaxed">
            ✨Illuminate your world with our handcrafted glowing candles. Bringing warmth, beauty, and serenity to every moment.✨
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center mb-12">
            <a href="{{ route('products.index') }}" class="group bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 inline-flex justify-center">
                <span class="flex items-center justify-center space-x-2">
                    <span>Shop Now</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </span>
            </a>
            <a href="{{ route('categories.index') }}" class="group bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300 inline-flex justify-center">
                <span class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h6m2 5H7a2 2 0 01-2-2V9a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>View Catalog</span>
                </span>
            </a>
        </div>

        <!-- Hero Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
            @foreach($stats as $stat)
            <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold text-white mb-1">
                    {{ $stat['count'] }}{{ $stat['suffix'] ?? '' }}
                </div>
                <div class="text-sm text-emerald-200">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <span class="inline-block bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full text-sm font-medium mb-4">
                ⭐ Featured Products
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                Best Selling <span class="text-emerald-600">Products</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover our most popular items loved by thousands of customers worldwide
            </p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts->take(4) as $product)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden border border-gray-100 hover:border-emerald-200 hover:rounded-3xl">
                <!-- Product Badge -->
                @if($product->badge)
                <div class="absolute top-4 left-4 z-10">
                    <span class="bg-gradient-to-r from-orange-500 to-red-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        {{ $product->badge }}
                    </span>
                </div>
                @endif

                <!-- Product Image -->
                <div class="relative bg-gray-100 aspect-square flex items-center">
                    <img src="{{ $product->image ? (filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image)) : asset('images/placeholder-product.jpg') }}" 
                         alt="{{ $product->name }}" 
                         class="w-full max-h-full object-contain mx-auto group-hover:scale-105 transition-transform duration-300"
                         onerror="this.onerror=null; this.src='{{ asset('images/placeholder-product.jpg') }}'"
                         loading="lazy"
                         style="max-width: 100%;">
                    
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

        <!-- View All Products Button -->
        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" class="inline-block bg-white border-2 border-emerald-500 text-emerald-600 hover:bg-emerald-500 hover:text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-20 bg-gradient-to-br from-slate-900 to-slate-800">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <span class="inline-block bg-emerald-500/20 text-emerald-400 px-4 py-2 rounded-full text-sm font-medium mb-4">
                🛍️ Shop by Category
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Explore Our <span class="text-emerald-400">Categories</span>
            </h2>
            <p class="text-xl text-slate-300 max-w-3xl mx-auto">
                Find exactly what you're looking for in our carefully curated product categories
            </p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($categories as $category)
            <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 overflow-hidden border border-gray-100">
                <a href="{{ route('categories.show', $category->slug) }}" class="block">
                    <!-- Category Image -->
                    <div class="relative overflow-hidden bg-gray-100 aspect-square">
                        <img src="{{ $category->featured_image_url }}" 
                             alt="{{ $category->name }}" 
                             class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-category.png') }}';">
                        
                        <!-- Overlay Effect -->
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <span class="inline-flex items-center bg-white/90 text-emerald-600 px-4 py-2 rounded-full font-medium">
                                Browse Collection
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Category Info -->
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">
                            {{ $category->name }}
                        </h3>
                        
                        @if(isset($category->description) && $category->description)
                            <p class="mt-2 text-gray-600 line-clamp-2">
                                {{ $category->description }}
                            </p>
                        @endif
                        
                        <div class="mt-4 flex items-center justify-between">
                            <span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-medium rounded-full">
                                {{ $category->products_count ?? 0 }} items
                            </span>
                            
                            <span class="inline-flex items-center text-emerald-600 font-medium text-sm">
                                Shop Now
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        
        <!-- Show More Button -->
        @if($categories->count() > 4)
        <div class="text-center mt-8">
            <button id="showMoreBtn" class="bg-white/10 hover:bg-white/20 text-white font-semibold py-3 px-8 rounded-full border border-white/20 transition-all duration-300">
                Show More Categories
            </button>
        </div>
        @endif
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const showMoreBtn = document.getElementById('showMoreBtn');
                const categoryItems = document.querySelectorAll('.category-item.hidden');
                let showingAll = false;
                
                if (showMoreBtn) {
                    showMoreBtn.addEventListener('click', function() {
                        categoryItems.forEach(item => {
                            item.classList.toggle('hidden');
                        });
                        
                        showingAll = !showingAll;
                        showMoreBtn.textContent = showingAll ? 'Show Less' : 'Show More Categories';
                    });
                }
            });
        </script>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gradient-to-br from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <span class="inline-block bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium mb-4">
                ✨ Why Choose ShopCraft
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                Premium <span class="text-blue-600">Shopping Experience</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We're committed to providing you with the best online shopping experience
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1: Free Shipping -->
            <div class="group bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-blue-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-4">Free Shipping</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">Free shipping on all orders over ₹999. Fast and reliable delivery to your doorstep.</p>
            </div>

            <!-- Feature 2: 24/7 Support -->
            <div class="group bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-emerald-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-4">24/7 Support</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">Our customer support team is available round the clock to assist you with any queries.</p>
            </div>

            <!-- Feature 3: Secure Payments -->
            <div class="group bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-orange-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-4">Secure Payments</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">Your payment information is protected with bank-level security and encryption.</p>
            </div>

            <!-- Feature 4: Easy Returns -->
            <div class="group bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-purple-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-4">Easy Returns</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">30-day hassle-free returns and exchanges. Your satisfaction is our priority.</p>
            </div>

            <!-- Feature 5: Quality Guarantee -->
            <div class="group bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-green-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-4">Quality Guarantee</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">We stand behind every product we sell with our comprehensive quality guarantee.</p>
            </div>

            <!-- Feature 6: Fast Delivery -->
            <div class="group bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-indigo-200/50">
                <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-4">Fast Delivery</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">Lightning-fast delivery options including same-day delivery in select areas.</p>
            </div>
        </div>
    </div>
</section>

<!-- Shopping Section -->
<section class="py-20 bg-gradient-to-r from-emerald-600 to-teal-700">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="mb-8">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Premium Shopping <span class="text-emerald-200">Experience</span>
            </h2>
            <p class="text-xl text-emerald-100 max-w-2xl mx-auto">
                Discover handpicked collections of the finest products, curated just for you. Enjoy seamless shopping with fast delivery and exceptional customer service.
            </p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Handle add to cart form submission
    $(document).on('submit', '.add-to-cart-form', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $button = $form.find('button[type="submit"]');
        const buttonText = $button.html();
        
        // Disable button and show loading state
        $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Adding...');
        
        // Get form data
        const formData = $form.serialize();
        
        // Send AJAX request
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    // Update button state
                    $button.html('<i class="fas fa-check mr-2"></i>Added to Cart')
                          .removeClass('bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700')
                          .addClass('bg-gray-400 cursor-not-allowed')
                          .prop('disabled', true);
                    
                    // Update cart count in header
                    updateCartCount(response.cart_count);
                    
                    // Show success message
                    showSuccessAlert('Success!', response.message || 'Product added to cart!');
                } else {
                    showErrorAlert('Error', response.message || 'Failed to add product to cart');
                    $button.prop('disabled', false).html(buttonText);
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while adding the product to cart';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    // Handle validation errors
                    const errors = [];
                    for (const [key, value] of Object.entries(xhr.responseJSON.errors)) {
                        errors.push(value[0]);
                    }
                    errorMessage = errors.join('<br>');
                } else if (xhr.status === 401) {
                    errorMessage = 'Please login to add items to cart';
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                
                showErrorAlert('Error', errorMessage);
                $button.prop('disabled', false).html(buttonText);
            }
        });
    });
    
    // Function to update cart count in the header
    function updateCartCount(count) {
        const $cartCount = $('.cart-count');
        if ($cartCount.length) {
            $cartCount.text(count);
            
            // Add animation
            $cartCount.addClass('animate-bounce');
            setTimeout(() => {
                $cartCount.removeClass('animate-bounce');
            }, 1000);
        }
    }
    
    // Show success alert
    function showSuccessAlert(title, message) {
        Swal.fire({
            icon: 'success',
            title: title,
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    }
    
    // Show error alert
    function showErrorAlert(title, message) {
        Swal.fire({
            icon: 'error',
            title: title,
            html: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    }
});
</script>
@endpush