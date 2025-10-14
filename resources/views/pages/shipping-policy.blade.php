@extends('layouts.app')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $page->banner_title }}</h1>
            @if($page->banner_subtitle)
                <p class="text-lg text-gray-600">
                    {{ $page->banner_subtitle }}
                </p>
            @endif
        </div>

        <div class="prose prose-lg max-w-none text-gray-600">
            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->shipping_info_title }}</h2>
                <div class="prose max-w-none">
                    {!! $page->shipping_info_content !!}
                </div>
            </div>

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->delivery_times_title }}</h2>
                <div class="prose max-w-none">
                    {!! $page->delivery_times_content !!}
                </div>
            </div>

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->order_tracking_title }}</h2>
                <div class="prose max-w-none">
                    {!! $page->order_tracking_content !!}
                </div>
                <div class="bg-emerald-50 border-l-4 border-emerald-400 p-4 mt-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-emerald-700">
                                If you haven't received your tracking information within 48 hours of placing your order, please check your spam folder or contact our customer service team at <a href="mailto:support@glowcandles.in" class="font-medium underline text-emerald-700 hover:text-emerald-600">support@glowcandles.in</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($page->international_shipping_title && $page->international_shipping_content)
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->international_shipping_title }}</h2>
                    <div class="prose max-w-none">
                        {!! $page->international_shipping_content !!}
                    </div>
                </div>
            @endif

            @if($page->damaged_lost_packages_title && $page->damaged_lost_packages_content)
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->damaged_lost_packages_title }}</h2>
                    <div class="prose max-w-none">
                        {!! $page->damaged_lost_packages_content !!}
                    </div>
                </div>
            @endif

            @if($page->contact_section_title && $page->contact_section_content)
                <div class="bg-emerald-50 p-6 rounded-lg">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->contact_section_title }}</h2>
                    <div class="prose max-w-none mb-4">
                        {!! $page->contact_section_content !!}
                    </div>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Contact Us
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
