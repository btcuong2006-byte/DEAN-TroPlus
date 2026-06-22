<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm phòng trọ - TroPlus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { background-color: #f8faff; }

        .filter-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            position: sticky;
            top: 20px;
        }

        .filter-title {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-section {
            margin-bottom: 24px;
        }

        .filter-section label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #374151;
            margin-bottom: 10px;
            display: block;
        }

        .card {
            border-radius: 16px !important;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.12);
        }

        .card-title a {
            text-decoration: none;
            color: #1a1a2e;
            font-weight: 600;
        }

        .card-title a:hover { color: #3b82f6; }

        .sort-bar {
            background: white;
            border-radius: 12px;
            padding: 12px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 16px;
        }

        .empty-state .icon {
            width: 80px;
            height: 80px;
            background: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="/">TroPlus</a>
            <div class="collapse navbar-collapse">
                <div class="navbar-nav mx-auto">
                    <a class="nav-link" href="/">Trang chủ</a>
                    <a class="nav-link active fw-semibold" href="{{ route('products.search') }}">Tìm Phòng</a>
                    <a class="nav-link" href="{{ route('products.map') }}">Bản Đồ</a>
                </div>
                <div class="d-flex gap-2">
                    @auth
                        <span class="navbar-text">{{ auth()->user()->name }}</span>
                    @else
                        <a href="/" class="btn btn-outline-secondary btn-sm">Đăng nhập</a>
                        <a href="/" class="btn btn-primary btn-sm">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">

        <!-- Header -->
        <div class="mb-4">
            <h4 class="fw-bold mb-1">Tìm phòng trọ</h4>
            <p class="text-muted mb-0">{{ $totalResults }} phòng trọ được tìm thấy</p>
        </div>

        <div class="row g-4">

            <!-- Sidebar filter -->
            <div class="col-md-3">
                <form action="{{ route('products.search') }}" method="GET" id="filterForm">
                    <div class="filter-card">
                        <div class="filter-title">
                            <i class="bi bi-sliders text-primary"></i> Bộ lọc tìm kiếm
                        </div>

                        {{-- Thành phố --}}
                        <div class="filter-section">
                            <label>Thành phố</label>
                            <select name="city" class="form-select rounded-3">
                                <option value="">Tất cả thành phố</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Quận/Huyện --}}
                        <div class="filter-section">
                            <label>Quận / Huyện</label>
                            <select name="district" class="form-select rounded-3">
                                <option value="">Tất cả quận/huyện</option>
                                <option value="Ninh Kiều"   {{ request('district') == 'Ninh Kiều'   ? 'selected' : '' }}>Ninh Kiều</option>
                                <option value="Bình Thủy"   {{ request('district') == 'Bình Thủy'   ? 'selected' : '' }}>Bình Thủy</option>
                                <option value="Cái Răng"    {{ request('district') == 'Cái Răng'    ? 'selected' : '' }}>Cái Răng</option>
                                <option value="Ô Môn"       {{ request('district') == 'Ô Môn'       ? 'selected' : '' }}>Ô Môn</option>
                                <option value="Thốt Nốt"    {{ request('district') == 'Thốt Nốt'    ? 'selected' : '' }}>Thốt Nốt</option>
                                <option value="Quận 1"      {{ request('district') == 'Quận 1'      ? 'selected' : '' }}>Quận 1</option>
                                <option value="Quận 3"      {{ request('district') == 'Quận 3'      ? 'selected' : '' }}>Quận 3</option>
                                <option value="Hải Châu"    {{ request('district') == 'Hải Châu'    ? 'selected' : '' }}>Hải Châu</option>
                            </select>
                        </div>

                        {{-- Loại phòng --}}
                        <div class="filter-section">
                            <label>Loại phòng</label>
                            @foreach(['' => 'Tất cả loại phòng', 'phòng đơn' => 'Phòng đơn', 'phòng ghép' => 'Phòng ghép', 'căn hộ mini' => 'Căn hộ mini'] as $val => $label)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="type"
                                       value="{{ $val }}" id="type_{{ $val }}"
                                       {{ request('type') == $val ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_{{ $val }}">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>

                        {{-- Khoảng giá --}}
                        <div class="filter-section">
                            <label>Khoảng giá</label>
                            @foreach(['' => 'Tất cả giá', 'under2' => 'Dưới 2 triệu', '2to4' => '2 - 4 triệu', '4to8' => '4 - 8 triệu', 'above8' => 'Trên 8 triệu'] as $val => $label)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="price"
                                       value="{{ $val }}" id="price_{{ $val }}"
                                       {{ request('price') == $val ? 'checked' : '' }}>
                                <label class="form-check-label" for="price_{{ $val }}">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill rounded-3">
                                Áp dụng
                            </button>
                            <a href="{{ route('products.search') }}" class="btn btn-outline-secondary rounded-3">
                                Xóa lọc
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Danh sách phòng -->
            <div class="col-md-9">

                <!-- Sort bar -->
                <div class="sort-bar">
                    <span class="text-muted" style="font-size: 0.9rem;">
                        Hiển thị <strong>{{ $products->firstItem() ?? 0 }}</strong> -
                        <strong>{{ $products->lastItem() ?? 0 }}</strong> /
                        <strong>{{ $products->total() }}</strong> kết quả
                    </span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted" style="font-size: 0.9rem;">Sắp xếp:</span>
                        <select class="form-select form-select-sm rounded-3" style="width: 150px;"
                                onchange="window.location.href='{{ route('products.search') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value}).toString()">
                            <option value="latest"     {{ request('sort') == 'latest'     ? 'selected' : '' }}>Mới nhất</option>
                            <option value="price_asc"  {{ request('sort') == 'price_asc'  ? 'selected' : '' }}>Giá tăng dần</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                        </select>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach($products as $product)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . $product->photo) }}"
                                     class="card-img-top"
                                     style="height: 180px; object-fit: cover;"
                                     alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ route('products.show', $product->id) }}">
                                            {{ Str::limit($product->name, 40) }}
                                        </a>
                                    </h6>
                                    <p class="text-muted mb-1" style="font-size: 0.8rem;">
                                        <i class="bi bi-geo-alt"></i> {{ $product->address }}
                                    </p>
                                    <p class="text-success fw-bold mb-2">
                                        {{ number_format($product->price) }} đ/tháng
                                    </p>
                                    <div class="d-flex flex-wrap gap-1 mb-3">
                                        @foreach(explode(',', $product->description) as $item)
                                            <x-amenity-tag :name="$item" style="font-size: 0.75rem;" />
                                        @endforeach
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-2">
                                        <div class="d-flex align-items-center gap-2">
                                            @if($product->user->avatar)
                                                <img src="{{ asset('storage/' . $product->user->avatar) }}"
                                                     style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover;">
                                            @else
                                                <div style="width: 28px; height: 28px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem;">
                                                    {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <span style="font-size: 0.8rem;">{{ $product->user->name }}</span>
                                        </div>
                                        @auth
                                            @php
                                                $isFavorited = \DB::table('favorites')
                                                    ->where('user_id', auth()->id())
                                                    ->where('product_id', $product->id)
                                                    ->exists();
                                            @endphp
                                            <form action="{{ route('products.favorite', $product->id) }}" method="POST" class="favorite-form d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-link text-danger p-0 border-0 d-flex align-items-center gap-1 text-decoration-none favorite-btn" style="box-shadow: none;">
                                                    <i class="bi bi-heart{{ $isFavorited ? '-fill' : '' }}" style="font-size: 0.8rem;"></i>
                                                    <span class="favorite-count" style="font-size: 0.8rem;">{{ $product->favorite_count }}</span>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-link text-danger p-0 border-0 d-flex align-items-center gap-1 text-decoration-none" style="box-shadow: none;">
                                                <i class="bi bi-heart" style="font-size: 0.8rem;"></i>
                                                <span style="font-size: 0.8rem;">{{ $product->favorite_count }}</span>
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>

                @else
                    <div class="empty-state">
                        <div class="icon"><i class="bi bi-search"></i></div>
                        <h5 class="fw-bold">Không tìm thấy phòng trọ</h5>
                        <p class="text-muted">Thử thay đổi bộ lọc để tìm kiếm phòng phù hợp hơn</p>
                        <a href="{{ route('products.search') }}" class="btn btn-primary rounded-pill px-4">
                            Xóa bộ lọc
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        // Xử lý lưu yêu thích bằng AJAX
        document.querySelectorAll('.favorite-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const action = this.getAttribute('action');
                const btn = this.querySelector('.favorite-btn');
                const icon = btn.querySelector('i');
                const countSpan = btn.querySelector('.favorite-count');

                fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.action === 'added') {
                            icon.classList.remove('bi-heart');
                            icon.classList.add('bi-heart-fill');
                        } else {
                            icon.classList.remove('bi-heart-fill');
                            icon.classList.add('bi-heart');
                        }
                        countSpan.textContent = data.favorite_count;
                    }
                })
                .catch(err => console.error(err));
            });
        });
    </script>
</body>
</html>