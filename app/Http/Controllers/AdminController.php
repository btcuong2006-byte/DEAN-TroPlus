<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;

class AdminController extends Controller
{
    // ✅ Hiển thị trang quản lý settings
    public function settings()
    {
        $settings = Setting::all();
        return view('admin.settings', compact('settings'));
    }

    // ✅ Cập nhật ảnh
    public function updateSetting(Request $request, $key)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => 'storage/' . $path]
            );
        }

        return back()->with('success', 'Cập nhật ảnh thành công!');
    }
    public function showDashboard()
{
    $totalProducts     = Product::count();
    $availableProducts = Product::where('status', 'available')->count();
    $totalUsers        = User::count();
    $totalComments     = Comment::count();
    $recentProducts    = Product::with('user')->latest()->take(5)->get();
    $recentComments    = Comment::with('user')
                                ->where('is_approved', false)
                                ->latest()
                                ->take(5)
                                ->get(); // ✅ thêm dòng này

    return view('admin.dashboard', compact(
        'totalProducts',
        'availableProducts',
        'totalUsers',
        'totalComments',
        'recentProducts',
        'recentComments' // ✅ thêm vào compact
    ));
}

public function users()
{
    $users      = User::latest()->get();
    $totalUsers = $users->count();

    return view('admin.users', compact('users', 'totalUsers'));
}
public function products()
{
    $products      = Product::with('user')->latest()->paginate(10);
    $totalProducts = Product::count();

    return view('admin.products', compact('products', 'totalProducts'));
}
public function comments()
{
    $filter = request('filter');

    $comments = Comment::with('user', 'product')
        ->when($filter === 'pending',  fn($q) => $q->where('is_approved', false))
        ->when($filter === 'approved', fn($q) => $q->where('is_approved', true))
        ->latest()
        ->get();

    $totalComments  = Comment::count();
    $pendingCount   = Comment::where('is_approved', false)->count();
    $approvedCount  = Comment::where('is_approved', true)->count();

    return view('admin.comments', compact(
        'comments',
        'totalComments',
        'pendingCount',
        'approvedCount'
    ));
}
}
