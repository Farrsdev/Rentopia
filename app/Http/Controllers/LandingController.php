<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Get 6 featured products (latest or random)
        $featuredProduks = Produk::latest()->take(6)->get();

        return view('landing', compact('featuredProduks'));
    }
}
