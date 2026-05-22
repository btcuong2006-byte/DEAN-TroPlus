<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Setting;

Route::get('/', function () {
    $products = Product::where('status', 'available')
        ->orderBy('favorite_count', 'desc')
        ->take(9)
        ->get();

    $product = $products->first();

    $comments = Comment::with('user')
        ->latest()
        ->take(6)
        ->get();

    $availableCount = Product::where('status', 'available')->count();

    $cityCount = Product::where('status', 'available')
        ->distinct('city')
        ->count('city');

    $settings = Setting::pluck('value', 'key'); // ✅ lấy tất cả settings

    return view('index', compact('products', 'product', 'comments', 'cityCount', 'availableCount', 'settings'));
});

Route::resource('products', ProductController::class);
