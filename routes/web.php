<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product; 

Route::get('/', function () {
    $products = Product::latest()->get(); // ✅ nhiều sản phẩm
    $product = $products->first();        // ✅ 1 sản phẩm cho ảnh
    return view('index', compact('products', 'product'));
});

Route::resource('products', ProductController::class);