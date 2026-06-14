<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Setting;

// ✅ include Breeze routes
require __DIR__.'/auth.php';

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

Route::resource('products', ProductController::class)->except(['show']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show'); // Custom show route (accessible by guests)

Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/map', [ProductController::class, 'mapView'])->name('products.map');

Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::post('/products/{product}/favorite', [ProductController::class, 'toggleFavorite'])->name('products.favorite');
    Route::get('/favorites', [ProductController::class, 'favoritesList'])->name('products.favorites');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Nâng cấp tài khoản Chủ trọ
    Route::get('/profile/upgrade', [\App\Http\Controllers\ProfileController::class, 'showUpgradeForm'])->name('profile.upgrade');
    Route::post('/profile/upgrade', [\App\Http\Controllers\ProfileController::class, 'storeUpgradeRequest'])->name('profile.upgrade.store');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'showDashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/comments', [AdminController::class, 'comments'])->name('comments');
    Route::post('/comments/{id}/approve', [AdminController::class, 'approveComment'])->name('comments.approve');
    Route::delete('/comments/{id}', [AdminController::class, 'deleteComment'])->name('comments.delete');
    
    // Quản lý nâng cấp tài khoản
    Route::get('/upgrades', [AdminController::class, 'upgrades'])->name('upgrades');
    Route::post('/upgrades/{id}/approve', [AdminController::class, 'approveUpgrade'])->name('upgrades.approve');
    Route::post('/upgrades/{id}/reject', [AdminController::class, 'rejectUpgrade'])->name('upgrades.reject');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings/{key}', [AdminController::class, 'updateSetting'])->name('settings.update');
});

Route::prefix('owner')->middleware(['auth', 'role:owner'])->name('owner.')->group(function () {
    Route::get('/', [OwnerController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [OwnerController::class, 'products'])->name('products');
    Route::get('/products/create', [OwnerController::class, 'create'])->name('products.create');
    Route::post('/products', [OwnerController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [OwnerController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [OwnerController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [OwnerController::class, 'destroy'])->name('products.destroy');
    Route::get('/comments', [OwnerController::class, 'comments'])->name('comments');
    Route::post('/tenant-reviews', [OwnerController::class, 'storeTenantReview'])->name('tenant_reviews.store');
});