@extends('layouts.app')

@section('title', $product['name'] . ' - ShopCraft')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white py-3 md:py-6">
    <div class="max-w-6xl mx-auto px-2 sm:px-3">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-8">
            <a href="/" class="hover:text-emerald-600 transition-colors duration-300">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="#" class="hover:text-emerald-600 transition-colors duration-300">{{ $product['category'] }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-800 font-medium">{{ $product['name'] }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 lg:gap-8 mb-6 md:mb-10">
            <!-- Product Images -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="aspect-square bg-white rounded-lg md:rounded-2xl shadow overflow-hidden border border-gray-100">
                    <img id="mainImage" src="{{ $product['images'][0] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
                </div>

                <!-- Thumbnail Images -->
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($product['images'] as $index => $image)
                    <button class="aspect-square bg-white rounded-2xl shadow-md overflow-hidden border-2 {{ $index === 0 ? 'border-emerald-500' : 'border-gray-200' }} hover:border-emerald-400 transition-colors duration-300 thumbnail-btn" data-image="{{ $image }}">
                        <img src="{{ $image }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Product Details -->
            <div class="space-y-4 md:space-y-6">
                <!-- Product Header -->
                <div>
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-medium">{{ $product['brand'] }}</span>
                        <span class="text-gray-400">•</span>
                        <span class="text-gray-600 text-sm">SKU: {{ $product['sku'] }}</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">{{ $product['name'] }}</h1>
                    
                    <!-- Rating -->
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="flex items-center space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= floor($product['rating']) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-gray-600">{{ $product['rating'] ?? 0 }} ({{ $product['reviews'] ?? 0 }} reviews)</span>
                    </div>

                    <!-- Price -->
                    <div class="flex items-center space-x-4 mb-6">
                        <span class="text-3xl md:text-4xl font-bold text-gray-800">₹{{ number_format($product['price'], 2) }}</span>
                        @if($product['original_price'])
                            <span class="text-lg md:text-xl text-gray-500 line-through">₹{{ number_format($product['original_price'], 2) }}</span>
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ round((($product['original_price'] - $product['price']) / $product['original_price']) * 100) }}% OFF
                            </span>
                        @endif
                    </div>

                    <!-- Stock Status -->
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-green-600 font-medium">In Stock ({{ $product['stock'] }} available)</span>
                    </div>

                    <!-- Product Description -->
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 mb-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100 flex items-center">
                            <svg class="w-6 h-6 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Product Details
                        </h2>
                        <div class="prose prose-emerald max-w-none">
                            <p class="text-gray-700 leading-relaxed text-lg">{{ $product['description'] }}</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex flex-wrap gap-4">
                                @if(isset($product['features']) && is_array($product['features']))
                                    @foreach($product['features'] as $feature)
                                        <span class="inline-flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-700 text-sm font-medium rounded-full">
                                            <svg class="w-4 h-4 mr-1.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $feature }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <form id="add-to-cart-form" action="{{ route('cart.add') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                        <input type="hidden" name="quantity" id="quantity-input" value="1">
                        <input type="hidden" name="variant" id="selected-variant" value="Default">
                        <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white py-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                            <span class="whitespace-nowrap">Add to Cart</span>
                        </button>
                    </form>
                </div>
                
            </div>
        </div>

        <!-- Related Products -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">You May Also Like</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                @foreach($relatedProducts as $relatedProduct)
                <div class="group bg-white rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 relative transform hover:-translate-y-1 hover:border-emerald-200">
                    <a href="{{ route('products.show', $relatedProduct['slug']) }}" class="block">
                        <div class="relative overflow-hidden bg-gray-50 aspect-square">
                            @php
                                // Get the first image from the related product's images array
                                $imageUrl = null;
                                
                                if (isset($relatedProduct['images']) && is_array($relatedProduct['images']) && count($relatedProduct['images']) > 0) {
                                    $imageUrl = $relatedProduct['images'][0];
                                } elseif (isset($relatedProduct['image'])) {
                                    $imageUrl = $relatedProduct['image'];
                                }
                                
                                // If still no image, use placeholder
                                if (empty($imageUrl)) {
                                    $imageUrl = asset('images/placeholder-product.jpg');
                                }
                                
                                // Ensure the URL is absolute
                                if (!filter_var($imageUrl, FILTER_VALIDATE_URL) && !str_starts_with($imageUrl, '/')) {
                                    $imageUrl = asset('storage/' . ltrim($imageUrl, '/'));
                                }
                                
                                $placeholder = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23E5E7EB'%3E%3Cpath d='M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 16H6c-.55 0-1-.45-1-1V6c0-.55.45-1 1-1h12c.55 0 1 .45 1 1v12c0 .55-.45 1-1 1zm-4.44-6.19l-2.35 3.02-1.56-1.88c-.2-.25-.58-.24-.78.01l-1.74 2.23c-.26.33-.02.81.39.81h8.98c.41 0 .65-.47.4-.8l-2.55-3.39c-.19-.26-.59-.26-.79 0z'/%3E%3C/svg%3E";
                            @endphp
                            <div class="relative w-full h-full overflow-hidden group-hover:shadow-lg transition-all duration-300">
                                <div class="relative w-full h-full">
                                    <img 
                                        src="{{ $imageUrl }}" 
                                        alt="{{ $relatedProduct['name'] }}" 
                                        class="w-full h-full object-cover transition-all duration-500 transform group-hover:scale-105"
                                        onerror="this.onerror=null; this.src='{{ asset('images/placeholder-product.jpg') }}';"
                                        loading="lazy"
                                        style="background-image: url('{{ $placeholder }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
                                    >
                                    <div class="absolute inset-0 bg-gray-100 animate-pulse"></div>
                                </div>
                            </div>
                            @if(isset($relatedProduct['discount_percentage']) && $relatedProduct['discount_percentage'] > 0)
                                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    {{ $relatedProduct['discount_percentage'] }}% OFF
                                </span>
                            @endif
                        </div>
                        
                        <div class="p-3">
                            <div class="flex items-center space-x-1 mb-2">
                                @php
                                    $rating = $relatedProduct['rating'] ?? 0;
                                    $fullStars = floor($rating);
                                    $hasHalfStar = $rating - $fullStars >= 0.5;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $fullStars)
                                        <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                    @elseif($i == $fullStars + 1 && $hasHalfStar)
                                        <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M22 9.24l-7.19-.62L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.63-7.03L22 9.24zM12 15.4l-3.76 2.27 1-4.28-3.32-2.88 4.38-.38L12 6.1l1.71 4.04 4.38.38-3.32 2.88 1 4.28L12 15.4z"/>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M22 9.24l-7.19-.62L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.63-7.03L22 9.24zM12 15.4l-3.76 2.27 1-4.28-3.32-2.88 4.38-.38L12 6.1l1.71 4.04 4.38.38-3.32 2.88 1 4.28L12 15.4z"/>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="text-xs text-gray-500 ml-1">{{ $rating > 0 ? number_format($rating, 1) : 'New' }}</span>
                            </div>
                            
                            <h3 class="text-sm font-medium text-gray-800 mb-1 line-clamp-2 h-10 overflow-hidden group-hover:text-emerald-600 transition-colors duration-200" title="{{ $relatedProduct['name'] }}">
                                {{ $relatedProduct['name'] }}
                            </h3>
                            
                            <div class="flex items-center justify-between mt-2">
                                <div>
                                    <span class="text-sm font-bold text-gray-900">₹{{ number_format($relatedProduct['price'], 2) }}</span>
                                    @if(isset($relatedProduct['original_price']) && $relatedProduct['original_price'] > $relatedProduct['price'])
                                        <span class="text-xs text-gray-500 line-through ml-1">₹{{ number_format($relatedProduct['original_price'], 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <form action="{{ route('cart.add') }}" method="POST" class="px-3 pb-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $relatedProduct['id'] }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="w-full bg-white border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white text-xs font-medium py-2 px-3 rounded-md transition-all duration-200 flex items-center justify-center space-x-1.5 transform hover:scale-[1.02] hover:shadow-sm" 
                                onclick="event.stopPropagation();">
                            <i class="fas fa-shopping-cart text-xs"></i>
                            <span>Add to Cart</span>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Handle thumbnail click
    $('.thumbnail-btn').on('click', function() {
        const imageUrl = $(this).data('image');
        $('#mainImage').attr('src', imageUrl);
        $('.thumbnail-btn').removeClass('border-emerald-500').addClass('border-gray-200');
        $(this).removeClass('border-gray-200').addClass('border-emerald-500');
    });
    
    // Handle color selection
    $('.color-option').on('click', function() {
        $('.color-option').removeClass('ring-2 ring-offset-2 ring-emerald-500');
        $(this).addClass('ring-2 ring-offset-2 ring-emerald-500');
        $('#selected-color').val($(this).data('color'));
    });
    
    // Handle size selection
    $('.size-option').on('click', function() {
        $('.size-option').removeClass('border-gray-800 bg-gray-800 text-white').addClass('border-gray-300 text-gray-700');
        $(this).removeClass('border-gray-300 text-gray-700').addClass('border-gray-800 bg-gray-800 text-white');
        $('#selected-size').val($(this).data('size'));
    });

    // Quantity controls
    $('#increaseQty').on('click', function(e) {
        e.preventDefault();
        let quantity = parseInt($('#quantity').text());
        quantity++;
        $('#quantity').text(quantity);
        $('#quantity-input').val(quantity);
    });

    $('#decreaseQty').on('click', function(e) {
        e.preventDefault();
        let quantity = parseInt($('#quantity').text());
        if (quantity > 1) {
            quantity--;
            $('#quantity').text(quantity);
            $('#quantity-input').val(quantity);
        }
    });

    // Handle add to cart form submission
    $('#add-to-cart-form').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const originalText = $submitBtn.html();
        
        // Disable button to prevent multiple submissions
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Adding...');
        
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                if (response.success) {
                    // Update cart count in header
                    $('.cart-count').text(response.cart_count);
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Product added to cart!',
                        showConfirmButton: true,
                        timer: 2000
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    showConfirmButton: true
                });
            },
            complete: function() {
                // Re-enable button
                $submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Wishlist functionality
    $(document).on('click', '.wishlist-btn', function(e) {
        e.preventDefault();
        
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const isInWishlist = $btn.data('in-wishlist') === 'true';
        
        // Show loading state
        const $icon = $btn.find('svg');
        const $text = $btn.find('.wishlist-text');
        const originalHtml = $btn.html();
        $btn.prop('disabled', true);
        $btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Processing...');
        
        // Determine the endpoint and method based on current state
        let url, method;
        
        if (isInWishlist) {
            // For removal, use the product ID directly in the URL
            url = '{{ route("wishlist.remove", ["productId" => "__ID__"]) }}'.replace('__ID__', productId);
            method = 'DELETE';
        } else {
            // For adding, use the product model binding
            url = '{{ route("wishlist.add", ["product" => "__ID__"]) }}'.replace('__ID__', productId);
            method = 'POST';
        }
        
        // Make the AJAX request
        $.ajax({
            url: url,
            method: method,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    // Toggle button state
                    $btn.data('in-wishlist', !isInWishlist);
                    
                    if (isInWishlist) {
                        // Remove from wishlist
                        $btn.removeClass('border-red-500 text-red-500')
                            .addClass('border-gray-300 text-gray-700 hover:border-red-500 hover:text-red-500');
                        $icon.attr('fill', 'none');
                        $text.text('Add to Wishlist');
                    } else {
                        // Add to wishlist
                        $btn.removeClass('border-gray-300 text-gray-700 hover:border-red-500 hover:text-red-500')
                            .addClass('border-red-500 text-red-500');
                        $icon.attr('fill', 'currentColor');
                        $text.text('Remove from Wishlist');
                    }
                    
                    // Show success message
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    
                    Toast.fire({
                        icon: 'success',
                        title: isInWishlist ? 'Removed from wishlist' : 'Added to wishlist!'
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.status === 401) {
                    // Redirect to login if user is not authenticated
                    window.location.href = '{{ route("login") }}';
                    return;
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    showConfirmButton: true
                });
            },
            complete: function() {
                // Reset button state
                $btn.prop('disabled', false);
                if (isInWishlist) {
                    $btn.html('<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg><span class="wishlist-text">Remove from Wishlist</span>');
                } else {
                    $btn.html('<svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg><span class="wishlist-text">Add to Wishlist</span>');
                }
            }
        });
    });
});
</script>

@endsection