@extends('layouts.app')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ $page->banner_title }}</h1>
            @if($page->banner_subtitle)
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    {{ $page->banner_subtitle }}
                </p>
            @endif
        </div>

        <div class="mt-16 max-w-4xl mx-auto">
            <div class="prose prose-lg text-gray-500 mx-auto text-center">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ $page->section1_title }}</h2>
                <div class="prose mx-auto">
                    {!! $page->section1_content !!}
                </div>
                    
                @if($page->section2_title && $page->section2_content)
                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-6">{{ $page->section2_title }}</h2>
                    <div class="prose mx-auto">
                        {!! $page->section2_content !!}
                    </div>
                @endif
                    
                @if($page->mission_title && $page->mission_content)
                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-6">{{ $page->mission_title }}</h2>
                    <div class="prose mx-auto">
                        {!! $page->mission_content !!}
                    </div>
                @endif
                    
                @if($page->vision_title && $page->vision_content)
                    <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-6">{{ $page->vision_title }}</h2>
                    <div class="prose mx-auto">
                        {!! $page->vision_content !!}
                    </div>
                @endif
            </div>
        </div>
        
        @if($page->section1_image)
            <div class="mt-12 flex justify-center">
                <div class="max-w-2xl w-1/3 rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $page->section1_image) }}" 
                         alt="{{ $page->section1_title }}" 
                         class="w-full h-auto object-cover">
                </div>
            </div>
        @endif

        @if($page->team_section_title)
            <div class="mt-20">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-4">{{ $page->team_section_title }}</h2>
                @if($page->team_section_subtitle)
                    <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto mb-12">
                        {{ $page->team_section_subtitle }}
                    </p>
                @else
                    <div class="mb-12"></div>
                @endif
                <div class="grid md:grid-cols-3 gap-10">
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Premium Quality</h3>
                        <p class="text-gray-600">Hand-poured with care using the finest ingredients for a clean, long-lasting burn.</p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Eco-Friendly</h3>
                        <p class="text-gray-600">Made with sustainable soy wax and lead-free cotton wicks for a cleaner burn.</p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Handcrafted with Love</h3>
                        <p class="text-gray-600">Each candle is carefully crafted by our team of skilled artisans.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
