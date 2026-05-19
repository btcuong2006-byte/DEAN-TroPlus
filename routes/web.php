<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product; 

Route::get('/', function () {
    $products = Product::where('status', 'available')  // ✅ chỉ lấy phòng còn trống
                        ->orderBy('favorite_count', 'desc')  // ✅ sắp xếp theo phổ biến
                        ->take(9)  // ✅ lấy 9 phòng (hoặc 7-10 tùy bạn)
                        ->get();
    $product = $products->first();
    return view('index', compact('products','product'));
});

Route::resource('products', ProductController::class);