<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách phòng trọ
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        $product = Product::first();
        return view('products.index', compact('products'));
    }

    /**
     * Form thêm phòng
     */
    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    /**
     * Lưu phòng mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'address' => 'required',
            'acreage' => 'required',
            'description' => 'required',
            'photo' => 'nullable|image',
        ]);

        $photoName = null;

        if ($request->hasFile('photo')) {

            $photoName = time() . '.' .
                $request->photo->extension();

            $request->photo->storeAs(
                'products',
                $photoName,
                'public'
            );
        }

        $product = Product::create([

            'user_id' => auth()->id(),

            'name' => $request->name,

            'price' => $request->price,

            'address' => $request->address,

            'acreage' => $request->acreage,

            'description' => $request->description,

            'photo' => $photoName
                ? 'products/' . $photoName
                : null,

            'status' => 'available',
        ]);

        if ($request->categories) {

            $product->categories()->sync(
                $request->categories
            );
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Thêm phòng thành công');
    }

    /**
     * Chi tiết phòng
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Form sửa
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::all();

        return view(
            'products.edit',
            compact('product', 'categories')
        );
    }

    /**
     * Cập nhật phòng
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'address' => 'required',
            'acreage' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('photo')) {

            $photoName = time() . '.' .
                $request->photo->extension();

            $request->photo->storeAs(
                'products',
                $photoName,
                'public'
            );

            $product->photo = 'products/' . $photoName;
        }

        $product->update([

            'name' => $request->name,

            'price' => $request->price,

            'address' => $request->address,

            'acreage' => $request->acreage,

            'description' => $request->description,
        ]);

        if ($request->categories) {

            $product->categories()->sync(
                $request->categories
            );
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Cập nhật thành công');
    }

    /**
     * Xóa phòng
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Xóa thành công');
    }
}