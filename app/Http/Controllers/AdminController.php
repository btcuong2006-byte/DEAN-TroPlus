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

    public function approveComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['is_approved' => true]);

        return back()->with('success', 'Phê duyệt đánh giá thành công!');
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Xóa đánh giá thành công!');
    }

    /**
     * Display account upgrade requests list
     */
    public function upgrades()
    {
        $filter = request('filter');

        $upgrades = \App\Models\UpgradeRequest::with('user')
            ->when($filter === 'pending',  fn($q) => $q->where('status', 'pending'))
            ->when($filter === 'approved', fn($q) => $q->where('status', 'approved'))
            ->when($filter === 'rejected', fn($q) => $q->where('status', 'rejected'))
            ->latest()
            ->get();

        $totalRequests = \App\Models\UpgradeRequest::count();
        $pendingCount  = \App\Models\UpgradeRequest::where('status', 'pending')->count();
        $approvedCount = \App\Models\UpgradeRequest::where('status', 'approved')->count();

        return view('admin.upgrades', compact('upgrades', 'totalRequests', 'pendingCount', 'approvedCount'));
    }

    /**
     * Approve account upgrade to landlord
     */
    public function approveUpgrade($id)
    {
        $req = \App\Models\UpgradeRequest::findOrFail($id);
        
        if ($req->status !== 'pending') {
            return back()->with('error', 'Yêu cầu này đã được xử lý trước đó.');
        }

        // Update User role to owner
        $user = User::findOrFail($req->user_id);
        $user->update(['role' => 'owner']);

        // Automatically create the landlord's first product listing
        Product::create([
            'user_id'     => $user->id,
            'name'        => $req->property_name,
            'price'       => $req->property_price,
            'address'     => $req->property_address,
            'city'        => $req->property_city,
            'acreage'     => $req->property_acreage,
            'description' => $req->property_description,
            'photo'       => $req->property_photo,
            'status'      => 'available',
            'lat'         => 10.0452,
            'lng'         => 105.7469,
        ]);

        $req->update(['status' => 'approved']);

        return back()->with('success', 'Phê duyệt tài khoản lên Chủ Trọ thành công! Phòng trọ đăng ký kèm theo đã được đăng tải tự động.');
    }

    /**
     * Reject account upgrade request
     */
    public function rejectUpgrade($id)
    {
        $req = \App\Models\UpgradeRequest::findOrFail($id);
        
        if ($req->status !== 'pending') {
            return back()->with('error', 'Yêu cầu này đã được xử lý trước đó.');
        }

        $req->update(['status' => 'rejected']);

        return back()->with('success', 'Đã từ chối yêu cầu nâng cấp tài khoản.');
    }
}
