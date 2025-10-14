<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Sample data for the dashboard
        $totalOrders = 2;
        $totalSpent = 249.98;
        $wishlistCount = 0;
        
        return view('user.dashboard', [
            'totalOrders' => $totalOrders,
            'totalSpent' => $totalSpent,
            'wishlistCount' => $wishlistCount,
            'recentOrders' => [
                [
                    'id' => 'ORD-12345',
                    'date' => now()->subDays(2)->format('M j, Y'),
                    'status' => 'Delivered',
                    'total' => 99.99
                ],
                [
                    'id' => 'ORD-12344',
                    'date' => now()->subDays(5)->format('M j, Y'),
                    'status' => 'Processing',
                    'total' => 149.99
                ]
            ]
        ]);
    }

    /**
     * Show the user profile edit form.
     */
    public function editProfile()
    {
        $user = Auth::user();
        $countries = $this->getCountriesList();
        
        return view('user.profile.edit', compact('user', 'countries'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female,other,prefer_not_to_say'],
        ]);

        $user->update($validated);

        return redirect()->route('user.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    /**
     * Update the user's address information.
     */
    public function updateAddress(Request $request)
    {
        $validated = $request->validate([
            // Billing Address
            'billing_address_line1' => ['required', 'string', 'max:255'],
            'billing_address_line2' => ['nullable', 'string', 'max:255'],
            'billing_city' => ['required', 'string', 'max:255'],
            'billing_state' => ['required', 'string', 'max:255'],
            'billing_zip' => ['required', 'string', 'max:20'],
            'billing_country' => ['required', 'string', 'size:2'],
            
            // Shipping Address
            'shipping_address_line1' => ['required', 'string', 'max:255'],
            'shipping_address_line2' => ['nullable', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:255'],
            'shipping_state' => ['required', 'string', 'max:255'],
            'shipping_zip' => ['required', 'string', 'max:20'],
            'shipping_country' => ['required', 'string', 'size:2'],
        ]);

        $user = Auth::user();
        $user->update($validated);

        return back()->with('success', 'Addresses updated successfully.');
    }

    /**
     * Get the list of countries.
     */
    protected function getCountriesList()
    {
        return [
            'US' => 'United States',
            'CA' => 'Canada',
            'GB' => 'United Kingdom',
            'AU' => 'Australia',
            'IN' => 'India',
            // Add more countries as needed
        ];
    }
}
