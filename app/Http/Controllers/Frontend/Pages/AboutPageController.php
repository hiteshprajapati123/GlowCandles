<?php

namespace App\Http\Controllers;Pages;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Pages\AboutPage;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public function index()
    {
        $page = AboutPage::firstOrFail();
        return view('pages.about', compact('page'));
    }
}
