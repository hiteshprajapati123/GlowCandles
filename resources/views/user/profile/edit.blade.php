@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div class="py-10 bg-gradient-to-br from-emerald-50 via-cyan-50 to-indigo-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden ring-1 ring-gray-200">
            <!-- Profile Header -->
            <div class="px-6 py-5 border-b bg-gradient-to-r from-emerald-500 to-cyan-600 sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white drop-shadow-lg">Profile Settings</h1>
                    <p class="mt-1 text-sm text-emerald-100">Manage your account information and preferences</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-5 py-2 text-sm font-medium rounded-lg shadow-md text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-400 transition-all">
                        ← Dashboard
                    </a>
                    <button type="submit" form="profile-form" class="inline-flex items-center px-5 py-2 text-sm font-medium rounded-lg shadow-md text-white bg-gradient-to-r from-emerald-500 to-cyan-600 hover:from-emerald-600 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-400 transition-all">
                        💾 Save Changes
                    </button>
                </div>
            </div>

            <div class="px-6 py-8">
                <form id="profile-form" method="POST" action="{{ route('profile.update') }}" class="space-y-12">
                    <input type="hidden" name="_redirect" value="{{ route('user.dashboard') }}">
                    @csrf
                    @method('PATCH')

                    <!-- Profile Info -->
                    <div class="bg-gradient-to-br from-white via-emerald-50 to-cyan-50 shadow-lg rounded-xl p-6">
                        <h2 class="text-lg font-semibold text-emerald-700"> Profile Information</h2>
                        <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            <!-- Name (Required) -->
                            <div class="sm:col-span-4 lg:col-span-4 xl:col-span-4">
                                <label for="name" class="block text-sm font-medium text-emerald-800">Full Name *</label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-all bg-white/90" required>
                            </div>

                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-emerald-800">First Name</label>
                                <input type="text" name="first_name" id="first_name"
                                    value="{{ old('first_name', $user->first_name) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-all bg-white/90">
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-emerald-800">Last Name</label>
                                <input type="text" name="last_name" id="last_name"
                                    value="{{ old('last_name', $user->last_name) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-all bg-white/90">
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-emerald-800">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth"
                                    value="{{ old('date_of_birth', $user->date_of_birth_formatted) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-all bg-white/90">
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-medium text-emerald-800">Gender</label>
                                <select name="gender" id="gender"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-all bg-white/90">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    <option value="prefer_not_to_say" {{ old('gender', $user->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                </select>
                            </div>

                            <!-- Email -->
                            <div class="sm:col-span-2 lg:col-span-2 xl:col-span-2">
                                <label for="email" class="block text-sm font-medium text-emerald-800">Email</label>
                                <input id="email" name="email" type="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-all bg-white/90" required>
                            </div>

                            <!-- Phone -->
                            <div class="sm:col-span-2 lg:col-span-2 xl:col-span-2">
                                <label for="phone" class="block text-sm font-medium text-emerald-800">Phone</label>
                                <input type="tel" name="phone" id="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-all bg-white/90">
                            </div>
                        </div>
                    </div>

                    <!-- Billing -->
                    <div class="mt-10 bg-gradient-to-br from-cyan-50 via-indigo-50 to-white shadow-lg rounded-xl p-6">
                        <h2 class="text-lg font-semibold text-cyan-700"> Billing Address</h2>
                        <p class="mt-1 text-sm text-gray-500">Used for payment processing</p>

                        <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="billing_address_line1" class="block text-sm font-medium text-cyan-800">Address Line 1</label>
                                <input type="text" name="billing_address_line1" id="billing_address_line1"
                                    value="{{ old('billing_address_line1', $user->billing_address_line1) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm bg-white/90">
                            </div>

                            <div>
                                <label for="billing_address_line2" class="block text-sm font-medium text-cyan-800">Address Line 2</label>
                                <input type="text" name="billing_address_line2" id="billing_address_line2"
                                    value="{{ old('billing_address_line2', $user->billing_address_line2) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm bg-white/90">
                            </div>

                            <div>
                                <label for="billing_city" class="block text-sm font-medium text-cyan-800">City</label>
                                <input type="text" name="billing_city" id="billing_city"
                                    value="{{ old('billing_city', $user->billing_city) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm bg-white/90">
                            </div>

                            <div>
                                <label for="billing_state" class="block text-sm font-medium text-cyan-800">State/Province</label>
                                <input type="text" name="billing_state" id="billing_state"
                                    value="{{ old('billing_state', $user->billing_state) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm bg-white/90">
                            </div>

                            <div>
                                <label for="billing_zip" class="block text-sm font-medium text-cyan-800">Postal Code</label>
                                <input type="text" name="billing_zip" id="billing_zip"
                                    value="{{ old('billing_zip', $user->billing_zip) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm bg-white/90">
                            </div>

                            <div>
                                <label for="billing_country" class="block text-sm font-medium text-cyan-800">Country</label>
                                <select name="billing_country" id="billing_country"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 shadow-sm bg-white/90">
                                    <option value="">Select Country</option>
                                    @foreach(config('countries') as $code => $country)
                                        <option value="{{ $code }}" {{ old('billing_country', $user->billing_country) == $code ? 'selected' : '' }}>{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping -->
                    <div class="bg-gradient-to-br from-pink-50 via-purple-50 to-indigo-50 shadow-lg rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-purple-700">📦 Shipping Address (optional)</h2>
                            
                            <script>
                            function copyBillingToShipping() {
                                const checkbox = document.getElementById('same_as_billing');
                                const isChecked = checkbox.checked;
                                const fields = [
                                    'address_line1',
                                    'address_line2',
                                    'city',
                                    'state',
                                    'zip',
                                    'country'
                                ];

                                fields.forEach(field => {
                                    const billingField = document.getElementById('billing_' + field);
                                    const shippingField = document.getElementById('shipping_' + field);
                                    
                                    if (billingField && shippingField) {
                                        if (isChecked) {
                                            shippingField.value = billingField.value;
                                            shippingField.disabled = true;
                                        } else {
                                            shippingField.disabled = false;
                                        }
                                    }
                                });
                            }
                            </script>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="shipping_address_line1" class="block text-sm font-medium text-purple-800">Address Line 1</label>
                                <input type="text" name="shipping_address_line1" id="shipping_address_line1"
                                    value="{{ old('shipping_address_line1', $user->shipping_address_line1) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-white/90">
                            </div>

                            <div>
                                <label for="shipping_address_line2" class="block text-sm font-medium text-purple-800">Address Line 2</label>
                                <input type="text" name="shipping_address_line2" id="shipping_address_line2"
                                    value="{{ old('shipping_address_line2', $user->shipping_address_line2) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-white/90">
                            </div>

                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-purple-800">City</label>
                                <input type="text" name="shipping_city" id="shipping_city"
                                    value="{{ old('shipping_city', $user->shipping_city) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-white/90">
                            </div>

                            <div>
                                <label for="shipping_state" class="block text-sm font-medium text-purple-800">State/Province</label>
                                <input type="text" name="shipping_state" id="shipping_state"
                                    value="{{ old('shipping_state', $user->shipping_state) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-white/90">
                            </div>

                            <div>
                                <label for="shipping_zip" class="block text-sm font-medium text-purple-800">Postal Code</label>
                                <input type="text" name="shipping_zip" id="shipping_zip"
                                    value="{{ old('shipping_zip', $user->shipping_zip) }}"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-white/90">
                            </div>

                            <div>
                                <label for="shipping_country" class="block text-sm font-medium text-purple-800">Country</label>
                                <select name="shipping_country" id="shipping_country"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm bg-white/90">
                                    <option value="">Select Country</option>
                                    @foreach(config('countries') as $code => $country)
                                        <option value="{{ $code }}" {{ old('shipping_country', $user->shipping_country) == $code ? 'selected' : '' }}>{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Password -->
                <div class="mt-10 bg-gradient-to-br from-yellow-50 via-orange-50 to-red-50 shadow-lg rounded-xl p-6">
                    <h2 class="text-lg font-semibold text-orange-700">🔑 Change Password</h2>
                    <form method="POST" action="{{ route('password.update') }}" class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-3">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-orange-800">Current Password</label>
                            <input type="password" name="current_password" id="current_password"
                                class="mt-2 w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm bg-white/90" required>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-orange-800">New Password</label>
                            <input type="password" name="password" id="password"
                                class="mt-2 w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm bg-white/90" required>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-orange-800">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="mt-2 w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm bg-white/90" required>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
