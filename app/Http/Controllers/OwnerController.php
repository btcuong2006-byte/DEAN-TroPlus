<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    // ✅ Tổng quan
    public function dashboard()
    {
        $userId = auth()->id();
        $totalProducts     = Product::where('user_id', auth()->id())->count();
        $availableProducts = Product::where('user_id', auth()->id())
                                    ->where('status', 'available')->count();
        $rentedProducts    = Product::where('user_id', auth()->id())
                                    ->where('status', 'rented')->count();
        $totalComments     = Comment::whereHas('product', fn($q) => 
                                    $q->where('user_id', auth()->id()))->count();

        $recentProducts    = Product::where('user_id', auth()->id())
                                    ->latest()->take(5)->get();
        $recentComments    = Comment::with('user', 'product')
                                    ->whereHas('product', fn($q) => 
                                    $q->where('user_id', auth()->id()))
                                    ->where('is_approved', true)
                                    ->latest()->take(5)->get();

        return view('owner.dashboard', compact(
            'totalProducts',
            'availableProducts',
            'rentedProducts',
            'totalComments',
            'recentProducts',
            'recentComments'
        ));
    }

    // ✅ Danh sách phòng
    public function products()
    {
        $products      = Product::where('user_id', auth()->id())
                                ->latest()->paginate(10);
        $totalProducts = Product::where('user_id', auth()->id())->count();

        return view('owner.products', compact('products', 'totalProducts'));
    }

    // ✅ Form đăng phòng
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('owner.create', compact('categories'));
    }

    // ✅ Lưu phòng mới
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'address'     => 'required',
            'city'        => 'required',
            'acreage'     => 'required|numeric',
            'description' => 'required',
            'photo'       => 'nullable|image|max:2048',
            'lat'         => 'nullable|numeric',
            'lng'         => 'nullable|numeric',
            'categories'  => 'nullable|array',
        ]);

        $photoName = null;

        if ($request->hasFile('photo')) {
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('products', $photoName, 'public');
        }

        $product = Product::create([
            'user_id'     => auth()->id(),
            'name'        => $request->name,
            'price'       => $request->price,
            'address'     => $request->address,
            'city'        => $request->city,
            'acreage'     => $request->acreage,
            'description' => $request->description,
            'photo'       => $photoName ? 'products/' . $photoName : null,
            'status'      => 'available',
            'lat'         => $request->lat ?? 10.0452,
            'lng'         => $request->lng ?? 105.7469,
        ]);

        if ($request->categories) {
            $product->categories()->sync($request->categories);
        }

        return redirect()->route('owner.products')
                         ->with('success', 'Đăng phòng thành công!');
    }

    public function edit($id)
    {
        $product = Product::where('user_id', auth()->id())
                          ->findOrFail($id);
        $categories = \App\Models\Category::all();

        return view('owner.edit', compact('product', 'categories'));
    }

    // ✅ Cập nhật phòng
    public function update(Request $request, $id)
    {
        $product = Product::where('user_id', auth()->id())
                          ->findOrFail($id);

        $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'address'     => 'required',
            'city'        => 'required',
            'acreage'     => 'required|numeric',
            'description' => 'required',
            'photo'       => 'nullable|image|max:2048',
            'lat'         => 'nullable|numeric',
            'lng'         => 'nullable|numeric',
            'categories'  => 'nullable|array',
        ]);

        if ($request->hasFile('photo')) {
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('products', $photoName, 'public');
            $product->photo = 'products/' . $photoName;
        }

        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'address'     => $request->address,
            'city'        => $request->city,
            'acreage'     => $request->acreage,
            'description' => $request->description,
            'status'      => $request->status ?? $product->status,
            'lat'         => $request->lat ?? $product->lat,
            'lng'         => $request->lng ?? $product->lng,
        ]);

        if ($request->categories) {
            $product->categories()->sync($request->categories);
        } else {
            $product->categories()->detach();
        }

        return redirect()->route('owner.products')
                         ->with('success', 'Cập nhật thành công!');
    }

    // ✅ Xóa phòng
    public function destroy($id)
    {
        $product = Product::where('user_id', auth()->id())
                          ->findOrFail($id);
        $product->delete();

        return redirect()->route('owner.products')
                         ->with('success', 'Xóa phòng thành công!');
    }

    // ✅ Danh sách đánh giá
    public function comments()
    {
        $comments      = Comment::with('user', 'product')
                                ->whereHas('product', fn($q) => 
                                    $q->where('user_id', auth()->id()))
                                ->latest()->get();
        $totalComments = $comments->count();
        $pendingCount  = $comments->where('is_approved', false)->count();
        $approvedCount = $comments->where('is_approved', true)->count();

        // Lấy thêm dữ liệu cho tính năng đánh giá người thuê
        $tenants       = User::where('role', 'tenant')->get();
        $myProducts    = Product::where('user_id', auth()->id())->get();
        $tenantReviews = \App\Models\TenantReview::with('tenant', 'product')
                                                 ->where('owner_id', auth()->id())
                                                 ->latest()->get();

        return view('owner.comments', compact(
            'comments',
            'totalComments',
            'pendingCount',
            'approvedCount',
            'tenants',
            'myProducts',
            'tenantReviews'
        ));
    }

    /**
     * Store a review for a tenant (renter)
     */
    public function storeTenantReview(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        \App\Models\TenantReview::create([
            'owner_id' => auth()->id(),
            'tenant_id' => $request->tenant_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Recalculate tenant reputation_score
        $tenant = User::findOrFail($request->tenant_id);
        $reviews = \App\Models\TenantReview::where('tenant_id', $tenant->id)->get();
        $totalReviews = $reviews->count();
        $averageRating = $reviews->avg('rating');

        $tenant->update([
            'reputation_score' => round($averageRating, 1),
            'total_reviews' => $totalReviews,
        ]);

        return back()->with('success', 'Đánh giá người thuê thành công! Điểm uy tín của họ đã được cập nhật.');
    }
}