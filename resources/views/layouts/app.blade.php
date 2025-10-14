@php
use App\Http\Controllers\CartController;
$cartCount = CartController::getCartCount();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShopCraft - Premium E-commerce Experience')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @routes
    <script src="{{ asset('vendor/ziggy/js/route.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .cart-count { animation: pulse 0.5s ease-in-out; }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Sticky Header -->
    <header class="sticky top-0 z-50 bg-white shadow-lg border-b border-gray-100" x-data="{ mobileMenuOpen: false, cartItemsCount: {{ $cartCount }} }">
        <!-- Main Navigation -->
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">ShopCraft</h1>
                            <p class="text-xs text-gray-500 -mt-1">Premium Store</p>
                        </div>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                    <form action="{{ route('products.index') }}" method="GET" class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-2 rounded-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Wishlist -->
                    <a href="{{ route('wishlist.index') }}" class="relative p-2 text-gray-600 hover:text-emerald-600 transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        @auth
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center wishlist-count">{{ auth()->user()->wishlist->count() }}</span>
                        @else
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center wishlist-count">0</span>
                        @endauth
                    </a>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-emerald-600 transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"/>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-emerald-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center cart-count" x-text="cartItemsCount">
                            {{ $cartCount }}
                        </span>
                    </a>

                    <!-- User Account -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 p-2 text-gray-600 hover:text-emerald-600 transition-colors duration-300">
                            @auth
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="hidden md:inline text-sm font-medium">Account</span>
                            @endauth
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                             style="display: none;">
                            @auth
                                <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="{{ route('user.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                                <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Wishlist</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Login</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Create account</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="flash-message" data-type="success" data-message="{{ session('success') }}"></div>
    @endif
    @if(session('error'))
    <div class="flash-message" data-type="error" data-message="{{ session('error') }}"></div>
    @endif
    @if(session('info'))
    <div class="flash-message" data-type="info" data-message="{{ session('info') }}"></div>
    @endif
    @if(session('warning'))
    <div class="flash-message" data-type="warning" data-message="{{ session('warning') }}"></div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

            <!-- About -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-3">About Us</h3>
                <p class="text-sm leading-relaxed">
                    Glow Candles is one of India's leading handmade decorative candle stores.
                    We deliver love and light across the nation with beautiful candles made from pure heart.
                </p>
                <div class="mt-4 text-sm">
                    <p>glowcandles123@gmail.com</p>
                    <p>+91 9580684014</p>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-3">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="hover:text-emerald-400 transition">About Us</a></li>
                    <li><a href="{{ route('shipping.policy') }}" class="hover:text-emerald-400 transition">Shipping Policy</a></li>
                    <li><a href="{{ route('privacy.policy') }}" class="hover:text-emerald-400 transition">Privacy Policy</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-emerald-400 transition">Contact</a></li>
                </ul>
            </div>

            <!-- Follow Us -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-3">Follow Us</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="https://www.instagram.com/glow_candels01?igsh=OTc0MTdzOGlmbHIz" class="hover:text-emerald-400 transition">Instagram</a></li>
                </ul>
            </div>

            <!-- Product Highlights -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-3">Premium Collections</h3>
                <p class="text-sm mb-4">Discover our exclusive range of handcrafted products designed for your lifestyle.</p>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center">
                        <span class="text-emerald-400 mr-2">✓</span> Premium Quality
                    </li>
                    <li class="flex items-center">
                        <span class="text-emerald-400 mr-2">✓</span> Fast Delivery
                    </li>
                    <li class="flex items-center">
                        <span class="text-emerald-400 mr-2">✓</span> Secure Checkout
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-slate-700 mt-6">
            <p class="text-center text-sm text-slate-400 py-4">
                © {{ date('Y') }} Glow Candles. All Rights Reserved.
            </p>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Main app script with routes -->
    @routes
    @vite(['resources/js/app.js'])
    <script src="{{ asset('vendor/ziggy/js/route.js') }}" defer></script>
    
    <script>
        // Initialize cart count from localStorage if available
        document.addEventListener('alpine:init', () => {
            Alpine.store('cart', {
                count: {{ Cart::instance('default')->count() }},
                updateCount(newCount) {
                    this.count = newCount;
                    // Dispatch event to update other components
                    window.dispatchEvent(new CustomEvent('cart-updated', {
                        detail: { count: newCount }
                    }));
                }
            });
        });
        
        $(document).ready(function() {
            // Add to cart functionality
            $('.add-to-cart').on('click', function() {
                const productId = $(this).data('product-id');
                $('.cart-count').addClass('cart-count');
                setTimeout(() => $('.cart-count').removeClass('cart-count'), 500);
            });

            // Mobile menu toggle
            $('.mobile-menu-toggle').on('click', function() {
                $('.mobile-menu').toggleClass('hidden');
            });
        });
        
        // Global AJAX setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle form submissions with AJAX and show notifications
        $(document).on('submit', 'form[data-ajax="true"]', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('[type="submit"]');
            const originalBtnText = $submitBtn.html();
            
            // Show loading state
            $submitBtn.prop('disabled', true);
            $submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Processing...');
            
            $.ajax({
                url: $form.attr('action'),
                method: $form.attr('method'),
                data: $form.serialize(),
                success: function(response) {
                    // Show success message
                    if (response.message) {
                        showNotification('success', response.message);
                    } else {
                        showNotification('success', 'Operation completed successfully!');
                    }
                    
                    // If there's a redirect in the response
                    if (response.redirect) {
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1500);
                    }
                    
                    // If there's a callback function
                    if (response.callback) {
                        if (typeof window[response.callback] === 'function') {
                            window[response.callback](response);
                        }
                    }
                    
                    // If the form has a data-reload attribute, reload the page
                    if ($form.data('reload')) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'An error occurred. Please try again.';
                    
                    if (xhr.status === 422) {
                        // Handle validation errors
                        const errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors)[0][0];
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 401) {
                        // Redirect to login if unauthorized
                        window.location.href = '{{ route("login") }}';
                        return;
                    }
                    
                    showNotification('error', errorMessage);
                },
                complete: function() {
                    // Reset button state
                    $submitBtn.prop('disabled', false).html(originalBtnText);
                }
            });
        });
        
        // Function to show notifications
        function showNotification(type, message) {
            const Toast = Swal.mixin({
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
            
            Toast.fire({
                icon: type,
                title: message
            });
        }
        
        // Show flash messages on page load
        $(document).ready(function() {
            $('.flash-message').each(function() {
                const type = $(this).data('type');
                const message = $(this).data('message');
                showNotification(type, message);
            });
        });
    </script>
</body>
</html>