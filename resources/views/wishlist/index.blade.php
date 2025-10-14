@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Your Wishlist</h1>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('products.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                &larr; Continue Shopping
            </a>
        </div>
    </div>

    @if($wishlistItems->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Your wishlist is empty</h3>
            <p class="mt-1 text-gray-500">You haven't added any products to your wishlist yet.</p>
            <div class="mt-6">
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    Browse Products
                </a>
            </div>
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @foreach($wishlistItems as $item)
                    <li class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row">
                            <div class="flex-shrink-0">
                                <img class="w-32 h-32 object-cover rounded-md" 
                                     src="{{ $item->image }}" 
                                     alt="{{ $item->name }}">
                            </div>
                            <div class="mt-4 sm:mt-0 sm:ml-6 flex-1">
                                <div class="flex flex-col h-full">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <a href="{{ route('products.show', $item->slug) }}">
                                                {{ $item->name }}
                                            </a>
                                        </h3>
                                        <p class="mt-1 text-gray-600">
                                            {{ $item->short_description ?? '' }}
                                        </p>
                                        <p class="mt-2 text-lg font-medium text-gray-900">
                                            ₹{{ number_format($item->price, 2) }}
                                        </p>
                                    </div>
                                    <div class="mt-4 flex space-x-3">
                                        <form action="{{ route('wishlist.move-to-cart', ['product' => $item->id]) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                Move to Cart
                                            </button>
                                        </form>
                                        <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
