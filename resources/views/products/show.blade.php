@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">Home</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600">Products</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="text-gray-500">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Product Images -->
        <div class="lg:w-1/2">
            <div class="sticky top-4">
                <!-- Main Image -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
                    <img src="{{ $mainImage }}" 
                         alt="{{ $product->name }}" 
                         id="mainProductImage"
                         class="w-full h-auto max-h-[500px] object-contain">
                </div>
                
                <!-- Thumbnails -->
                @if(count($images) > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($images as $index => $image)
                            <button onclick="changeMainImage('{{ $image }}')" 
                                    class="border rounded-md p-1 hover:border-blue-500 transition-colors {{ $image === $mainImage ? 'border-blue-500' : 'border-gray-200' }}">
                                <img src="{{ $image }}" 
                                     alt="Thumbnail {{ $index + 1 }}" 
                                     class="w-full h-20 object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="lg:w-1/2">
            <div class="flex justify-between items-start mb-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="ml-4">
                    @csrf
                    <button type="submit" class="p-2 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-6 h-6 {{ $product->in_wishlist ? 'text-red-500 fill-current' : 'text-gray-400' }}" fill="{{ $product->in_wishlist ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </form>
            </div>
            
            <!-- Rating -->
            <div class="flex items-center mb-4">
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($averageRating))
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @elseif($i === ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <defs>
                                    <linearGradient id="half" x1="0" x2="100%" y1="0" y2="0">
                                        <stop offset="50%" stop-color="currentColor" />
                                        <stop offset="50%" stop-color="#D1D5DB" />
                                    </linearGradient>
                                </defs>
                                <path fill="url(#half)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endif
                    @endfor
                </div>
                <span class="text-gray-600 ml-2">
                    {{ number_format($averageRating, 1) }} ({{ $totalReviews }} reviews)
                </span>
                <a href="#reviews" class="text-blue-600 hover:underline ml-4">Write a review</a>
            </div>

            <!-- Price -->
            <div class="mb-6">
                @if($product->compare_at_price > $product->price)
                    <div class="flex items-baseline">
                        <span class="text-3xl font-bold text-emerald-600">₹{{ number_format($product->price, 2) }}</span>
                        <span class="text-lg text-gray-500 line-through ml-2">₹{{ number_format($product->compare_at_price, 2) }}</span>
                        <span class="ml-2 text-sm font-medium text-white bg-red-600 px-2 py-0.5 rounded-full">
                            {{ number_format((($product->compare_at_price - $product->price) / $product->compare_at_price) * 100, 0) }}% OFF
                        </span>
                    </div>
                @else
                    <span class="text-3xl font-bold text-emerald-600">₹{{ number_format($product->price, 2) }}</span>
                @endif
                <p class="text-green-600 text-sm mt-1">
                    @if($product->quantity > 5)
                        In Stock ({{ $product->quantity }} available)
                    @elseif($product->quantity > 0)
                        Only {{ $product->quantity }} left in stock!
                    @else
                        <span class="text-red-600">Out of Stock</span>
                    @endif
                </p>
            </div>

            <!-- Short Description -->
            <div class="prose max-w-none mb-6">
                {!! $product->description !!}
            </div>

            <!-- Add to Cart -->
            <div class="border-t border-b border-gray-200 py-6 mb-6">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center border border-gray-300 rounded-md">
                        <button type="button" class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100" onclick="decrementQuantity()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->quantity }}" 
                               class="w-16 text-center border-0 focus:ring-0 focus:outline-none">
                        <button type="button" class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100" onclick="incrementQuantity()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                    </div>
                    <button onclick="addToCart({{ $product->id }})" 
                            class="flex-1 bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition-colors duration-200"
                            {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                        Add to Cart
                    </button>
                </div>
                <div class="flex space-x-4">
                    <button type="button" class="flex-1 flex items-center justify-center py-2 px-4 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Add to Wishlist
                    </button>
                    <button type="button" class="flex-1 flex items-center justify-center py-2 px-4 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Share
                    </button>
                </div>
            </div>

            <!-- Product Meta -->
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">SKU:</span>
                    <span class="ml-2 font-medium">{{ $product->sku ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Category:</span>
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="ml-2 text-blue-600 hover:underline">
                        {{ $product->category->name }}
                    </a>
                </div>
                <div>
                    <span class="text-gray-500">Brand:</span>
                    <span class="ml-2 font-medium">{{ $product->brand ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Availability:</span>
                    <span class="ml-2 font-medium {{ $product->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="mt-16">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button id="description-tab" 
                        class="border-b-2 border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 text-sm font-medium">
                    Description
                </button>
                <button id="features-tab" 
                        class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                    Features
                </button>
                <button id="reviews-tab" 
                        class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                    Reviews ({{ $totalReviews }})
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="py-8">
            <!-- Description Tab -->
            <div id="description-content" class="prose max-w-none">
                {!! $product->description !!}
                
                @if(!empty($product->specifications))
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Specifications</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                @foreach(json_decode($product->specifications, true) as $key => $value)
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">{{ $key }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Features Tab -->
            <div id="features-content" class="hidden prose max-w-none">
                @if(!empty($features))
                    <ul class="list-disc pl-5 space-y-2">
                        @foreach($features as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No features available.</p>
                @endif
            </div>

            <!-- Reviews Tab -->
            <div id="reviews-content" class="hidden">
                <div class="md:flex md:items-center md:justify-between mb-8">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Customer Reviews</h3>
                        <div class="flex items-center mt-1">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @elseif($i === ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <defs>
                                                <linearGradient id="half" x1="0" x2="100%" y1="0" y2="0">
                                                    <stop offset="50%" stop-color="currentColor" />
                                                    <stop offset="50%" stop-color="#D1D5DB" />
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#half)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <p class="ml-2 text-sm text-gray-700">
                                <span class="font-medium">{{ number_format($averageRating, 1) }}</span> out of 5
                            </p>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Based on {{ $totalReviews }} customer ratings</p>
                    </div>

                    <div class="mt-4 md:mt-0">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Write a Review
                        </button>
                    </div>
                </div>

                <!-- Review List -->
                <div class="space-y-8">
                    @forelse($product->reviews as $review)
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex items-center mb-2">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <h4 class="ml-2 text-sm font-medium text-gray-900">{{ $review->title }}</h4>
                            </div>
                            <p class="text-sm text-gray-500 mb-2">
                                By {{ $review->user->name }} on {{ $review->created_at->format('F j, Y') }}
                            </p>
                            <p class="text-gray-700 mb-3">{{ $review->comment }}</p>
                            
                            @if(!empty($review->pros) || !empty($review->cons))
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    @if(!empty($review->pros))
                                        <div>
                                            <p class="text-sm font-medium text-green-700">Pros</p>
                                            <ul class="mt-1 text-sm text-gray-600">
                                                @foreach(json_decode($review->pros, true) as $pro)
                                                    <li class="flex items-start">
                                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        {{ $pro }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    
                                    @if(!empty($review->cons))
                                        <div>
                                            <p class="text-sm font-medium text-red-700">Cons</p>
                                            <ul class="mt-1 text-sm text-gray-600">
                                                @foreach(json_decode($review->cons, true) as $con)
                                                    <li class="flex items-start">
                                                        <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        {{ $con }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <span>Was this review helpful?</span>
                                <button type="button" class="ml-4 flex items-center text-gray-500 hover:text-green-600">
                                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                    <span>Yes ({{ $review->helpful_yes }})</span>
                                </button>
                                <button type="button" class="ml-4 flex items-center text-gray-500 hover:text-red-600">
                                    <svg class="h-5 w-5 mr-1 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                    <span>No ({{ $review->helpful_no }})</span>
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="block">
                            <div class="relative pb-3/4 h-48">
                                <img src="{{ $relatedProduct->main_image }}" 
                                     alt="{{ $relatedProduct->name }}"
                                     class="absolute h-full w-full object-cover">
                                @if($relatedProduct->compare_at_price > $relatedProduct->price)
                                    <span class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        SALE
                                    </span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $relatedProduct->name }}</h3>
                                <div class="flex items-center">
                                    @php
                                        $rating = $relatedProduct->reviews->avg('rating') ?? 0;
                                        $fullStars = floor($rating);
                                        $hasHalfStar = $rating - $fullStars >= 0.5;
                                    @endphp
                                    
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $fullStars)
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @elseif($i === ceil($rating) && $hasHalfStar)
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient id="half" x1="0" x2="100%" y1="0" y2="0">
                                                        <stop offset="50%" stop-color="currentColor" />
                                                        <stop offset="50%" stop-color="#D1D5DB" />
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endif
                                    @endfor
                                    <span class="text-gray-600 text-sm ml-1">({{ $relatedProduct->reviews->count() }})</span>
                                </div>
                                <div class="mt-2">
                                    @if($relatedProduct->compare_at_price > $relatedProduct->price)
                                        <span class="text-red-600 font-bold">₹{{ number_format($relatedProduct->price, 2) }}</span>
                                        <span class="text-gray-500 text-sm line-through ml-1">₹{{ number_format($relatedProduct->compare_at_price, 2) }}</span>
                                    @else
                                        <span class="text-gray-800 font-bold">₹{{ number_format($relatedProduct->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Change main product image when clicking on thumbnails
    function changeMainImage(imageUrl) {
        document.getElementById('mainProductImage').src = imageUrl;
    }
    
    // Quantity controls
    function incrementQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max'));
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
    
    function decrementQuantity() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
    
    // Add to cart function
    function addToCart(productId) {
        const quantity = document.getElementById('quantity').value;
        // Add to cart functionality will be implemented later
        alert(`Added ${quantity} item(s) to cart (Product ID: ${productId})`);
    }
    
    // Tab switching
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = {
            'description-tab': 'description-content',
            'features-tab': 'features-content',
            'reviews-tab': 'reviews-content'
        };
        
        // Set default tab
        showTab('description-content');
        
        // Add click event listeners to tabs
        Object.keys(tabs).forEach(tabId => {
            const tab = document.getElementById(tabId);
            if (tab) {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    document.querySelectorAll('[id$="-tab"]').forEach(t => {
                        t.classList.remove('border-blue-500', 'text-blue-600');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    });
                    
                    // Add active class to clicked tab
                    this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    this.classList.add('border-blue-500', 'text-blue-600');
                    
                    // Show corresponding content
                    showTab(tabs[tabId]);
                });
            }
        });
        
        // Show tab content function
        function showTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('[id$="-content"]').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show selected tab content
            const tabContent = document.getElementById(tabId);
            if (tabContent) {
                tabContent.classList.remove('hidden');
            }
        }
    });
</script>
@endpush

<style>
    /* Custom styles for the product page */
    .prose {
        max-width: 100%;
    }
    
    .prose ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .prose li {
        margin-bottom: 0.25rem;
    }
    
    /* Ensure images in content don't overflow */
    .prose img {
        max-width: 100%;
        height: auto;
    }
    
    /* Style the review section */
    #reviews-content .border-b:last-child {
        border-bottom: none;
    }
</style>

@endsection
