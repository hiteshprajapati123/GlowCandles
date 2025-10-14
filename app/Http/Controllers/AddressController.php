<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Address::class, 'address');
    }

    /**
     * Display a listing of the user's addresses.
     */
    /**
     * Show the form for creating a new address.
     */
    public function create()
    {
        return view('checkout.address.create');
    }

    /**
     * Show the form for editing the specified address.
     */
    public function edit(Address $address)
    {
        $this->authorize('update', $address);
        return view('checkout.address.edit', compact('address'));
    }

    /**
     * Display a listing of the user's addresses.
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
        
        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'billing_address' => [
                    'line1' => $user->billing_address_line1,
                    'line2' => $user->billing_address_line2,
                    'city' => $user->billing_city,
                    'state' => $user->billing_state,
                    'postal_code' => $user->billing_zip,
                    'country' => $user->billing_country
                ],
                'shipping_address' => [
                    'line1' => $user->shipping_address_line1,
                    'line2' => $user->shipping_address_line2,
                    'city' => $user->shipping_city,
                    'state' => $user->shipping_state,
                    'postal_code' => $user->shipping_zip,
                    'country' => $user->shipping_country
                ]
            ],
            'addresses' => $addresses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'nullable|boolean',
        ]);

        try {
            // If this is set as default, unset default from other addresses
            if ($request->boolean('is_default')) {
                Auth::user()->addresses()->update(['is_default' => false]);
            }

            // Create the new address
            $address = new Address($validated);
            $address->user_id = Auth::id();
            $address->is_default = $request->boolean('is_default', false);
            $address->save();

            // If this is an AJAX request, return JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Address added successfully!',
                    'address' => $address->load('user'),
                    'redirect' => $request->has('_redirect') ? $request->input('_redirect') : route('checkout.index')
                ]);
            }

            // For regular form submission, redirect back with success message
            return redirect($request->input('_redirect', route('checkout.index')))
                ->with('success', 'Address added successfully!');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error saving address: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error saving address: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified address in storage.
     */
    public function update(Request $request, Address $address)
    {
        $validated = $request->validate([
            'full_name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'address_line1' => 'sometimes|required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'sometimes|required|string|max:100',
            'state' => 'sometimes|required|string|max:100',
            'postal_code' => 'sometimes|required|string|max:20',
            'country' => 'sometimes|required|string|max:100',
            'is_default' => 'sometimes|boolean'
        ]);

        if (isset($validated['is_default']) && $validated['is_default']) {
            $address->user->addresses()
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update($validated);

        // If this is an AJAX request, return JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully',
                'address' => $address->fresh(),
                'redirect' => $request->has('_redirect') ? $request->input('_redirect') : route('checkout.index')
            ]);
        }

        // For regular form submission, redirect back with success message
        return redirect($request->input('_redirect', route('checkout.index')))
            ->with('success', 'Address updated successfully!');
    }

    /**
     * Set an address as default.
     */
    public function setDefault(Address $address): JsonResponse
    {
        $this->authorize('update', $address);

        $address->user->addresses()
            ->where('id', '!=', $address->id)
            ->update(['is_default' => false]);
            
        $address->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Default address updated successfully',
            'data' => $address->fresh()
        ]);
    }

    /**
     * Remove the specified address from storage.
     */
    public function destroy(Address $address): JsonResponse
    {
        $this->authorize('delete', $address);

        // Check if this is the last address
        if ($address->user->addresses()->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete your only address.'
            ], 422);
        }

        // If this is the default address, make another address default
        if ($address->is_default) {
            $newDefault = $address->user->addresses()
                ->where('id', '!=', $address->id)
                ->first();
                
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully',
            'new_default_id' => $newDefault->id ?? null
        ]);
    }
}
