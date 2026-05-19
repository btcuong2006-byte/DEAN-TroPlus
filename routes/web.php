<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Comment;

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

    return view('index', compact('products', 'product', 'comments', 'cityCount', 'availableCount'));
});

Route::resource('products', ProductController::class);