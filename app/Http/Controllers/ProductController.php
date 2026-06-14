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
    public function search(Request $request)
{
    $query = Product::with('user')->where('status', 'available');

    // Lọc theo thành phố
    if ($request->city) {
        $query->where('city', $request->city);
    }

    // Lọc theo quận/huyện
    if ($request->district) {
        $query->where('address', 'like', '%' . $request->district . '%');
    }

    // Lọc theo loại phòng
    if ($request->type) {
        $query->where('description', 'like', '%' . $request->type . '%');
    }

    // Lọc theo khoảng giá
    if ($request->price) {
        switch ($request->price) {
            case 'under2':
                $query->where('price', '<', 2000000);
                break;
            case '2to4':
                $query->whereBetween('price', [2000000, 4000000]);
                break;
            case '4to8':
                $query->whereBetween('price', [4000000, 8000000]);
                break;
            case 'above8':
                $query->where('price', '>', 8000000);
                break;
        }
    }

    // Sắp xếp
    switch ($request->sort) {
        case 'price_asc':
            $query->orderBy('price', 'asc');
            break;
        case 'price_desc':
            $query->orderBy('price', 'desc');
            break;
        default:
            $query->latest();
    }

    $products = $query->paginate(9)->withQueryString();
    $totalResults = $query->count();
    $cities = Product::where('status', 'available')->distinct()->pluck('city');

    return view('search', compact('products', 'totalResults', 'cities'));
}

    /**
     * Toggle favorite status of a room
     */
    public function toggleFavorite(Request $request, $productId)
    {
        $user = auth()->user();
        $product = Product::findOrFail($productId);

        $favorite = \DB::table('favorites')
            ->where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            \DB::table('favorites')
                ->where('user_id', $user->id)
                ->where('product_id', $productId)
                ->delete();

            $product->decrement('favorite_count');
            $status = 'removed';
        } else {
            \DB::table('favorites')->insert([
                'user_id' => $user->id,
                'product_id' => $productId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $product->increment('favorite_count');
            $status = 'added';
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'action' => $status,
                'favorite_count' => $product->favorite_count
            ]);
        }

        return back()->with('success', $status === 'added' ? 'Đã lưu phòng vào danh sách yêu thích!' : 'Đã xóa phòng khỏi danh sách yêu thích!');
    }

    /**
     * Display favorited rooms list
     */
    public function favoritesList()
    {
        $userId = auth()->id();
        $products = Product::whereHas('favoritedBy', function($q) use ($userId) {
            $q->where('users.id', $userId);
        })->paginate(9);

        return view('products.favorites', compact('products'));
    }

    /**
     * Display dedicated full-screen map page
     */
    public function mapView()
    {
        $products = Product::where('status', 'available')->with('user')->get();
        
        $mapProducts = $products->map(function($p) {
            return [
                'name'    => $p->name,
                'address' => $p->address,
                'price'   => number_format($p->price),
                'lat'     => $p->lat ?? 10.0452,
                'lng'     => $p->lng ?? 105.7469,
                'user'    => $p->user->name ?? '',
                'photo'   => $p->photo ? '/storage/' . $p->photo : '',
                'id'      => $p->id,
            ];
        });

        return view('map', compact('mapProducts'));
    }
}