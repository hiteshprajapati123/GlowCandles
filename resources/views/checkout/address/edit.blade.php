@extends('layouts.app')

@section('title', 'Edit Address - ' . config('app.name'))

@section('content')
<div class="py-10 bg-gradient-to-br from-emerald-50 via-cyan-50 to-indigo-100 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden ring-1 ring-gray-200">
            <!-- Address Header -->
            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b bg-gradient-to-r from-emerald-500 to-cyan-600">
                <!-- Mobile Header -->
                <div class="sm:hidden">
                    <div class="flex items-center justify-between mb-3">
                        <h1 class="text-xl font-bold text-white drop-shadow-lg">Edit Address</h1>
                    </div>
                </div>

                <!-- Desktop Header -->
                <div class="hidden sm:flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white drop-shadow-lg">Edit Address</h1>
                </div>
                
                <!-- White line -->
                <div class="w-full h-px bg-white/30 mt-4"></div>
            </div>

            <div class="px-6 pb-8">
                <form id="address-form" method="POST" action="{{ route('checkout.address.update', $address) }}" class="space-y-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_redirect" value="{{ route('checkout.index') }}">

                    <!-- Address Form -->
                    <div class="bg-gradient-to-br from-white via-emerald-50 to-cyan-50 shadow-lg rounded-xl p-6">
                        <h2 class="text-lg font-semibold text-emerald-700">Address Information</h2>
                        <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Full Name -->
                            <div class="sm:col-span-2">
                                <label for="full_name" class="block text-sm font-medium text-emerald-800">Full Name *</label>
                                <div class="mt-2 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="full_name" id="full_name" required
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                        placeholder="John Doe" value="{{ old('full_name', $address->full_name) }}">
                                </div>
                                @error('full_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="sm:col-span-2">
                                <label for="phone" class="block text-sm font-medium text-emerald-800">Phone Number *</label>
                                <div class="mt-2 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <input type="tel" name="phone" id="phone" required
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                        placeholder="+1 (555) 123-4567" value="{{ old('phone', $address->phone) }}">
                                </div>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address Line 1 -->
                            <div class="sm:col-span-2">
                                <label for="address_line1" class="block text-sm font-medium text-emerald-800">Address Line 1 *</label>
                                <div class="mt-2 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="address_line1" id="address_line1" required
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                        placeholder="123 Main St" value="{{ old('address_line1', $address->address_line1) }}">
                                </div>
                                @error('address_line1')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address Line 2 -->
                            <div class="sm:col-span-2">
                                <label for="address_line2" class="block text-sm font-medium text-emerald-800">Address Line 2 (Optional)</label>
                                <div class="mt-2 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="address_line2" id="address_line2"
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                        placeholder="Apt, suite, unit, building, floor, etc." value="{{ old('address_line2', $address->address_line2) }}">
                                </div>
                                @error('address_line2')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-emerald-800">City *</label>
                                <div class="mt-2">
                                    <input type="text" name="city" id="city" required
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                        value="{{ old('city', $address->city) }}">
                                </div>
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- State/Province -->
                            <div>
                                <label for="state" class="block text-sm font-medium text-emerald-800">State/Province *</label>
                                <div class="mt-2">
                                    <input type="text" name="state" id="state" required
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                        value="{{ old('state', $address->state) }}">
                                </div>
                                @error('state')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-emerald-800">Postal Code *</label>
                                <div class="mt-2">
                                    <input type="text" name="postal_code" id="postal_code" required
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                        value="{{ old('postal_code', $address->postal_code) }}">
                                </div>
                                @error('postal_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div class="sm:col-span-2">
                                <label for="country" class="block text-sm font-medium text-emerald-800">Country *</label>
                                <div class="mt-2 relative">
                                    <select name="country" id="country" required
                                        class="block w-full pl-3 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all appearance-none bg-white">
                                        <option value="India" selected>India</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>  
                        </div>
                        
                        <!-- Form Submit Button -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('checkout.index') }}" 
                                class="px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-emerald-600 to-cyan-700 hover:from-emerald-700 hover:to-cyan-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all shadow-sm flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Address
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
