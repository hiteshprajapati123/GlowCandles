@extends('layouts.app')

@php
    $user = Auth::user();
    
    // Initialize recentActivities if not set
    $recentActivities = $recentActivities ?? collect();
    
    // Calculate profile completion
    $totalFields = 5; // name, email, phone, dob, gender
    $completedFields = 0;
    
    if (!empty($user->name)) $completedFields++;
    if (!empty($user->email)) $completedFields++;
    if (!empty($user->phone)) $completedFields++;
    if (!empty($user->date_of_birth)) $completedFields++;
    if (!empty($user->gender)) $completedFields++;
    
    $profileCompletion = ($completedFields / $totalFields) * 100;
    
    // Get user's orders
    $recentOrders = $user->orders()->latest()->take(3)->get();
    $totalOrders = $user->orders()->count();
    $totalSpent = $user->orders()->where('status', '!=', 'cancelled')->sum('grand_total');
    
    // Get wishlist count
    $wishlistCount = $user->wishlist()->count();
    
    // Recent activity will be loaded from the controller
    // The $recentActivities variable is passed from the controller
@endphp

@section('title', 'Dashboard')

@section('content')
<div class="py-6">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 p-5">
        <!-- Welcome Banner -->
        <div class="mb-8 overflow-hidden bg-white rounded-lg shadow">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            Welcome back, {{ $user->name }}!
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            @if($recentOrders->isNotEmpty())
                                Your last order was placed on {{ $recentOrders->first()->created_at->format('M d, Y') }}.
                            @else
                                Thanks for joining us! Start shopping to see your orders here.
                            @endif
                        </p>
                    </div>
                    <div class="flex flex-col mt-4 space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2 sm:mt-0">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Shop Now
                        </a>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Orders -->
            <div class="overflow-hidden transition-all duration-200 bg-white rounded-lg shadow hover:shadow-md">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-md bg-blue-500 bg-opacity-10">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $totalOrders }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="px-5 py-3 bg-gray-50">
                    <div class="text-sm">
                        <a href="{{ route('user.orders.index') }}" class="font-medium text-blue-600 hover:text-blue-500">View all</a>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="overflow-hidden transition-all duration-200 bg-white rounded-lg shadow hover:shadow-md">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-md bg-green-500 bg-opacity-10">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Spent</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">₹{{ number_format($totalSpent, 2) }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="px-5 py-3 bg-gray-50">
                    <div class="text-sm">
                        <a href="{{ route('user.orders.index') }}" class="font-medium text-blue-600 hover:text-blue-500">View spending</a>
                    </div>
                </div>
            </div>

            <!-- Wishlist Items -->
            <div class="overflow-hidden transition-all duration-200 bg-white rounded-lg shadow hover:shadow-md">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-md bg-yellow-500 bg-opacity-10">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Wishlist Items</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $wishlistCount }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('wishlist.index') }}" class="text-sm font-medium text-yellow-600 hover:text-yellow-500">
                            View wishlist
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Card -->
            <div class="overflow-hidden transition-all duration-200 bg-white rounded-lg shadow hover:shadow-md">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-md bg-emerald-500 bg-opacity-10">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Profile Status</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ (int)$profileCompletion }}% Complete
                                    </div>
                                </dd>
                                <dt class="mt-1">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-emerald-600 h-2 rounded-full transition-all duration-500 ease-in-out" style="width: {{ $profileCompletion }}%"></div>
                                    </div>
                                </dt>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-500">
                            Complete your profile
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-3">
            <!-- Recent Orders -->
            <div class="lg:col-span-2">
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Orders</h3>
                            <a href="{{ route('user.orders.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                View all
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </div>
                    </div>
                    <div class="px-4 sm:px-6">
                        @if($recentOrders->isEmpty())
                            <div class="py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No orders yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by making your first order.</p>
                                <div class="mt-6">
                                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Shop Now
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg my-5">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Order #</th>
                                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Total</th>
                                                        <th scope="col" class="relative px-6 py-3">
                                                            <span class="sr-only">Actions</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($recentOrders as $order)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                @php
                                                                    $statusColors = [
                                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                                        'processing' => 'bg-blue-100 text-blue-800',
                                                                        'shipped' => 'bg-indigo-100 text-indigo-800',
                                                                        'delivered' => 'bg-green-100 text-green-800',
                                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                                    ];
                                                                    $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                                                @endphp
                                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $statusColor }}">
                                                                    {{ ucfirst($order->status) }}
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                                ₹{{ number_format($order->grand_total, 2) }}
                                                            </td>
                                                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                                <a href="{{ route('user.orders.index', $order) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Quick Actions</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <a href="{{ route('profile.edit') }}" class="relative flex items-center p-4 transition-all duration-200 bg-white rounded-lg shadow hover:shadow-md group">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Profile Settings</p>
                                <p class="text-xs text-gray-500">Update your personal information</p>
                            </div>
                            <div class="absolute text-gray-300 right-4 top-1/2 transform -translate-y-1/2 group-hover:text-gray-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </a>
                        
                        <a href="{{ route('user.orders.index') }}" class="relative flex items-center p-4 transition-all duration-200 bg-white rounded-lg shadow hover:shadow-md group">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 group-hover:bg-indigo-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">My Orders</p>
                                <p class="text-xs text-gray-500">Track or manage orders</p>
                            </div>
                            <div class="absolute text-gray-300 right-4 top-1/2 transform -translate-y-1/2 group-hover:text-gray-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </a>
                        
                        <a href="{{ route('wishlist.index') }}" class="relative flex items-center p-4 transition-all duration-200 bg-white rounded-lg shadow hover:shadow-md group">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg bg-yellow-50 text-yellow-600 group-hover:bg-yellow-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Wishlist</p>
                                <p class="text-xs text-gray-500">View saved items</p>
                            </div>
                            <div class="absolute text-gray-300 right-4 top-1/2 transform -translate-y-1/2 group-hover:text-gray-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Recent Activity -->
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Activity</h3>
                    </div>
                    <div class="px-4 sm:px-6">
                        <div class="flow-root">
                            @if(isset($recentActivities) && $recentActivities->count() > 0)
                                <ul class="divide-y divide-gray-200">
                                    @foreach($recentActivities as $activity)
                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-50">
                                                        <svg class="w-6 h-6 {{ $activity->color ?? 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            @if(($activity->icon ?? '') === 'shopping-bag')
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                            @elseif(($activity->icon ?? '') === 'truck')
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                            @elseif(($activity->icon ?? '') === 'star')
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                            @else
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                                            @endif
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900">{{ $activity->title ?? 'Activity' }}</p>
                                                    <p class="text-sm text-gray-500">{{ $activity->description ?? '' }}</p>
                                                    <p class="text-xs text-gray-400">{{ isset($activity->created_at) ? $activity->created_at->diffForHumans() : 'Just now' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-6">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No recent activity</h3>
                                    <p class="mt-1 text-sm text-gray-500">Your recent activities will appear here.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Help & Support -->
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Help & Support</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Need help with your order?</h4>
                                <p class="mt-1 text-sm text-gray-500">Our support team is here to help you with any questions or concerns.</p>
                                <div class="mt-4">
                                    <a href="{{ route('contact') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                                        Contact Support
                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection