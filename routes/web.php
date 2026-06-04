<?php

use App\Http\Controllers\AdminController;
use App\Http\Controller\OwnerController;
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
        ->where('is_approved', true)
        ->latest()
        ->take(6)
        ->get();

    $availableCount = Product::where('status', 'available')->count();

    $cityCount = Product::where('status', 'available')
        ->distinct('city')
        ->count('city');

    $settings = Setting::pluck('value', 'key');

    return view('index', compact('products', 'product', 'comments', 'cityCount', 'availableCount', 'settings'));
});

Route::resource('products', ProductController::class);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'showDashboard'])->name('dashboard');      
     Route::get('/users', [AdminController::class, 'users'])->name('users'); // ✅ thêm
         // ✅ admin.dashboard
    Route::get('/comments', [AdminController::class, 'comments'])->name('comments');         // ✅ admin.comments
    Route::post('/comments/{id}/approve', [AdminController::class, 'approveComment'])->name('comments.approve'); // ✅
    Route::delete('/comments/{id}', [AdminController::class, 'deleteComment'])->name('comments.delete');         // ✅
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');         // ✅ admin.settings
    Route::post('/settings/{key}', [AdminController::class, 'updateSetting'])->name('settings.update');          // ✅
// web.php
Route::get('/products', [AdminController::class, 'products'])->name('products');
    });

    Route::prefix('owner')->name('owner.')->group(function () {
    Route::get('/', [OwnerController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [OwnerController::class, 'products'])->name('products');
    Route::get('/products/create', [OwnerController::class, 'create'])->name('products.create');
    Route::get('/comments', [OwnerController::class, 'comments'])->name('comments');
});