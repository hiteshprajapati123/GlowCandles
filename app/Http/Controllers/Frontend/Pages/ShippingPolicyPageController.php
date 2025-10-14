<?php

namespace App\Http\Controllers;Pages;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Pages\ShippingPolicyPage;
use Illuminate\Http\Request;

class ShippingPolicyPageController extends Controller
{
    public function index()
    {
        $page = ShippingPolicyPage::firstOrFail();
        return view('pages.shipping-policy', compact('page'));
    }
}
