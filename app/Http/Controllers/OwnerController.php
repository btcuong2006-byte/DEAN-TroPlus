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
        return view('owner.create');
    }

    // ✅ Lưu phòng mới
    public function store(Request $request)
    {

        $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'address'     => 'required',
            'acreage'     => 'required|numeric',
            'description' => 'required',
            'photo'       => 'nullable|image|max:2048',
        ]);

        $photoName = null;

        if ($request->hasFile('photo')) {
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('products', $photoName, 'public');
        }

        Product::create([
       
            'user_id'     => 1 ,  // auth()->id()
            'name'        => $request->name,
            'price'       => $request->price,
            'address'     => $request->address,
            'acreage'     => $request->acreage,
            'description' => $request->description,
            'photo'       => $photoName ? 'products/' . $photoName : null,
            'status'      => 'available',
        ]);

        return redirect()->route('owner.products')
                         ->with('success', 'Đăng phòng thành công!');
    }

    // ✅ Form sửa phòng
    public function edit($id)
    {
        $product = Product::where('user_id', auth()->id())
                          ->findOrFail($id);

        return view('owner.edit', compact('product'));
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
            'acreage'     => 'required|numeric',
            'description' => 'required',
            'photo'       => 'nullable|image|max:2048',
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
            'acreage'     => $request->acreage,
            'description' => $request->description,
            'status'      => $request->status ?? $product->status,
        ]);

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

        return view('owner.comments', compact(
            'comments',
            'totalComments',
            'pendingCount',
            'approvedCount'
        ));
    }
}