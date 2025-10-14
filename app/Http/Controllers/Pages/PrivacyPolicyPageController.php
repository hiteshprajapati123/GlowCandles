<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicyPage;
use Illuminate\Http\Request;

class PrivacyPolicyPageController extends Controller
{
    public function index()
    {
        $page = PrivacyPolicyPage::firstOrFail();
        return view('pages.privacy-policy', compact('page'));
    }
}
