@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Our Categories
            </h1>
            <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                Browse through our wide range of product categories
            </p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($categories as $category)
                <div class="bg-white overflow-hidden shadow rounded-lg group">
                    <a href="{{ route('categories.show', $category->slug) }}" class="block">
                        <div class="aspect-w-16 aspect-h-9 bg-gray-200 overflow-hidden">
                            <img src="{{ $category->featured_image_url }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.onerror=null; this.src='{{ asset('images/default-category.png') }}';">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">
                                {{ $category->name }}
                            </h3>
                            @if($category->description)
                                <p class="mt-2 text-gray-600 line-clamp-2">
                                    {{ $category->description }}
                                </p>
                            @endif
                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <span>{{ $category->products_count ?? 0 }} products</span>
                                <span class="mx-2">•</span>
                                <span class="inline-flex items-center text-emerald-600">
                                    Explore
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No categories found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        There are no categories available at the moment.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
