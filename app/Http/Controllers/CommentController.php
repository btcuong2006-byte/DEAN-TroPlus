<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $product = Product::findOrFail($productId);

        Comment::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_approved' => false, // Awaiting admin approval
        ]);

        return back()->with('success', 'Đánh giá thành công! Đang chờ admin phê duyệt.');
    }
}
