<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TroPlus - Tìm phòng trọ nhanh chóng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        body { background-color: rgb(249, 251, 255); }
        .highlight { color: blue; }
        .stats-list { list-style: none; padding: 0; display: flex; gap: 30px; margin-top: 20px; }
        .stats-number { font-weight: 700; font-size: 1.5rem; color: #6c757d; margin-bottom: -6px; }
        .end-number { font-size: 0.8em; color: #6c757d; }
        .a { font-weight: 700; font-size: 1rem; color: #1a1a2e; margin: 0; line-height: 1.3; }
        .b { font-size: 0.7em; color: #6c757d; margin: 0; }
        .slogan { font-size: 0.9em; color: #6c757d; margin-bottom: 20px; }
        .badge-tag {
            border-radius: 999px; color: rgba(25, 135, 84, 0.7);
            background-color: rgba(25, 135, 84, 0.1); border: 1px solid rgba(25, 135, 84, 0.4);
            font-size: 0.90em; display: inline-flex; align-items: center;
            gap: 8px; width: fit-content; padding: 6px 16px; pointer-events: none;
        }
        .box {
            padding: 12px 16px; background-color: #ffffff; border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08); position: absolute;
            bottom: 20px; left: 20px; right: 20px; z-index: 10;
        }
        @keyframes bounce { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .box-2 {
            padding: 12px 16px; background-color: #ffffff; border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08); position: absolute;
            top: -20px; right: -20px; z-index: 10;
            animation: bounce 2s ease-in-out infinite;
        }
        .img-wrapper { position: relative; display: inline-block; width: 100%; }
        .nhato { border-radius: 20px; width: 100%; height: 400px; object-fit: cover; display: block; }
        .icon-wrap {
            background-color: #d1fae5; border-radius: 10px; padding: 10px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .find {
            width: 100%; max-width: 1000px; border-radius: 10px;
            display: flex; flex-wrap: wrap; align-items: center;
            justify-content: center; gap: 10px; padding: 20px 30px;
            background-color: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-top: 70px;
        }
        .find select { height: 40px; width: 180px; border-radius: 7px; padding: 0 10px; border: #6c757d solid 2px; }
        .find button { height: 40px; width: 150px; }
        .find label { color: #6c757d; font-size: 0.85rem; display: flex; flex-direction: column; gap: 4px; }
        .card { border-radius: 25px !important; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; }
        .card:hover { transform: translateY(-20px); box-shadow: 0 10px 10px rgba(0,0,0,0.2); }
        .card-title a { text-decoration: none; color: #1a1a2e; }
        .card-title a:hover { color: #3498db; }
    </style>
</head>

<body>

    {{-- Navbar --}}
    <x-layouts.navbar />

    {{-- Modals --}}
    @include('partials.modals')

    <!-- Header -->
    <header>
        <div class="container pt-4">
            <div class="row align-items-center">

                <!-- Cột trái -->
                <div class="col d-flex flex-column align-items-start text-start">
                    <p class="badge-tag">
                        <i class="bi bi-house"></i>
                        Nền tảng thuê phòng #1 Việt Nam
                    </p>
                    <h1 class="mt-3"><b>Tìm phòng trọ <br>
                        <span class="highlight">Nhanh Chóng</span> và <br>
                        <span class="highlight">Minh Bạch</span>
                    </b></h1>
                    <p class="slogan">Hàng ngàn phòng trọ được xác minh, đánh giá thực từ khách thuê. Kết nối trực tiếp với chủ trọ uy tín.</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('products.search') }}" class="btn btn-dark ps-4 pe-4 p-2 rounded-4">
                            <i class="bi bi-search"></i>
                            <span class="m-2">Tìm phòng ngay</span>
                        </a>
                        <a href="{{ route('products.map') }}" class="btn btn-outline-secondary ps-4 pe-4 p-2 rounded-4">
                            <i class="bi bi-geo-alt"></i>
                            <span class="m-2">Xem bản đồ</span>
                        </a>
                    </div>
                    <ul class="stats-list">
                        <li>
                            <p class="stats-number">{{ $availableCount }}+</p>
                            <p class="end-number">Phòng Trọ</p>
                        </li>
                        <li>
                            <p class="stats-number">5,000+</p>
                            <p class="end-number">Người Thuê</p>
                        </li>
                        <li>
                            <p class="stats-number">{{ $cityCount }}+</p>
                            <p class="end-number">Thành Phố</p>
                        </li>
                    </ul>
                </div>

                <!-- Cột phải -->
                <div class="col">
                    <div class="img-wrapper">
                        <div class="box-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-wrap">
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <p class="a">4.8/5</p>
                                    <p class="b">Đánh giá</p>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-wrap">
                                    <i class="bi bi-shield-check text-success fs-5"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <p class="a">Phòng đã xác minh</p>
                                    <p class="b">Tất cả phòng được kiểm tra thực tế</p>
                                </div>
                            </div>
                        </div>
                        <img class="nhato" src="{{ asset('storage/' . optional($product)->photo) }}" alt="">
                    </div>
                </div>
            </div>

            <!-- Thanh tìm kiếm -->
            <div class="d-flex justify-content-center">
                <form action="{{ route('products.search') }}" method="GET">
                    <div class="find">
                        <label>Thành Phố
                            <select name="city">
                                <option value="">Tất Cả Thành Phố</option>
                                <option value="Cần Thơ">Cần Thơ</option>
                                <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                                <option value="Hà Nội">Hà Nội</option>
                                <option value="Đà Nẵng">Đà Nẵng</option>
                            </select>
                        </label>
                        <label>Quận / Huyện
                            <select name="district">
                                <option value="">Tất Cả Quận/Huyện</option>
                                <option value="Ninh Kiều">Ninh Kiều</option>
                                <option value="Bình Thủy">Bình Thủy</option>
                                <option value="Cái Răng">Cái Răng</option>
                                <option value="Ô Môn">Ô Môn</option>
                            </select>
                        </label>
                        <label>Loại Phòng
                            <select name="type">
                                <option value="">Tất Cả Loại Phòng</option>
                                <option value="phòng đơn">Phòng đơn</option>
                                <option value="phòng ghép">Phòng ghép</option>
                                <option value="căn hộ mini">Căn hộ mini</option>
                            </select>
                        </label>
                        <label>Khoảng Giá
                            <select name="price">
                                <option value="">Tất Cả Giá</option>
                                <option value="under2">Dưới 2 triệu</option>
                                <option value="2to4">2 - 4 triệu</option>
                                <option value="4to8">4 - 8 triệu</option>
                                <option value="above8">Trên 8 triệu</option>
                            </select>
                        </label>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>

            <!-- Phòng nổi bật -->
            <div class="mt-5 pt-4" id="featured-rooms">
                <h2 class="fw-bold">Phòng trọ nổi bật</h2>
                <p style="color: #6c757d;">Những phòng trọ được đánh giá cao và đang còn trống</p>

                <div class="row row-cols-1 row-cols-md-3 g-4 align-items-start mt-2">
                    @foreach($products as $product)
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/' . $product->photo) }}"
                                class="card-img-top"
                                style="height: 200px; object-fit: cover;"
                                alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                                </h5>
                                <p class="card-text text-muted">
                                    <small><i class="bi bi-geo-alt"></i> {{ $product->address }}</small>
                                </p>
                                <p class="card-text text-success fw-bold">
                                    {{ number_format($product->price) }} đ/tháng
                                </p>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(explode(',', $product->description) as $item)
                                    <span class="badge bg-light text-dark border">
                                        @php $item = trim($item); @endphp
                                        @if(str_contains($item, 'wifi')) <i class="bi bi-wifi"></i>
                                        @elseif(str_contains($item, 'máy lạnh')) <i class="bi bi-snow"></i>
                                        @elseif(str_contains($item, 'bảo vệ')) <i class="bi bi-shield-check"></i>
                                        @elseif(str_contains($item, 'gác')) <i class="bi bi-house"></i>
                                        @elseif(str_contains($item, 'chợ')) <i class="bi bi-bag"></i>
                                        @else <i class="bi bi-check-circle"></i>
                                        @endif
                                        {{ $item }}
                                    </span>
                                    @endforeach
                                </div>
                                <div class="mt-3 d-flex align-items-center justify-content-between border-top pt-2">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($product->user->avatar)
                                            <img src="{{ asset('storage/' . $product->user->avatar) }}"
                                                style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                                        @else
                                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #3498db; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.8rem;">
                                                {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span style="font-size: 0.85rem;">{{ $product->user->name }}</span>
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
                                                <i class="bi bi-heart{{ $isFavorited ? '-fill' : '' }}"></i>
                                                <span class="favorite-count" style="font-size: 0.85rem;">{{ $product->favorite_count }}</span>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-link text-danger p-0 border-0 d-flex align-items-center gap-1 text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginModal" style="box-shadow: none;">
                                            <i class="bi bi-heart"></i>
                                            <span style="font-size: 0.85rem;">{{ $product->favorite_count }}</span>
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Bản đồ -->
            @php
            $mapProducts = $products->map(function($p) {
                return [
                    'name'    => $p->name,
                    'address' => $p->address,
                    'price'   => number_format($p->price),
                    'lat'     => $p->lat ?? 10.0452,
                    'lng'     => $p->lng ?? 105.7469,
                    'user'    => $p->user->name ?? '',
                    'photo'   => $p->photo ? '/storage/' . $p->photo : '',
                ];
            });
            @endphp

            <div class="mt-5 pt-5 text-center">
                <h2 class="fw-bold">Phòng trọ trên bản đồ</h2>
                <p style="color: #6c757d;">Xem vị trí các phòng trọ trên bản đồ để chọn chỗ ở thuận tiện nhất</p>
                <div style="position: relative; width: 100%; margin-top: 30px;">
                    <div id="map" style="width: 100%; height: 450px; border-radius: 20px; z-index: 1;"></div>
                    <div class="d-flex align-items-center gap-3 bg-white px-4 py-3 rounded-4 shadow"
                        style="position: absolute; bottom: 16px; left: 16px; z-index: 10;">
                        <ul class="stats-list mb-0" style="margin-top: 0;">
                            <li>
                                <p class="stats-number">{{ $availableCount }}</p>
                                <p class="end-number">Phòng Trống</p>
                            </li>
                            <li>
                                <p class="stats-number">{{ $cityCount }}</p>
                                <p class="end-number">Thành Phố</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Đánh giá -->
            <div class="mt-5 pt-5 text-center">
                <h2 class="fw-bold">Khách hàng nói gì về chúng tôi</h2>
                <p style="color: #6c757d;">Những đánh giá thực tế từ người đã tìm được phòng trọ ưng ý</p>
                <div class="row row-cols-1 row-cols-md-3 g-4 align-items-start mt-2">
                    @foreach($comments as $comment)
                    <div class="col">
                        <div class="card rounded-4 p-2">
                            <div class="card-body text-start">
                                <div class="d-flex align-items-center gap-1 text-warning mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $comment->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <p class="mb-3">{{ $comment->content }}</p>
                                <div class="d-flex align-items-center gap-2 border-top pt-2">
                                    @if($comment->user->avatar)
                                        <img src="{{ asset('storage/' . $comment->user->avatar) }}"
                                            style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #3498db; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.8rem;">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span style="font-size: 0.85rem;">{{ $comment->user->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Banner cho thuê -->
            <div style="position: relative; width: 100%; max-width: 1000px; margin: 80px auto 0;">
                <img src="{{ asset($settings['banner_image'] ?? 'images/default.jpg') }}"
                    alt="" style="width: 100%; border-radius: 20px; display: block; height: 300px; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); border-radius: 20px; z-index: 5;"></div>
                <div class="d-flex flex-column align-items-center justify-content-center text-center text-white"
                    style="position: absolute; inset: 0; z-index: 10; padding: 20px;">
                    <h2 class="fw-bold mb-2">Bạn có phòng cho thuê?</h2>
                    <p class="mb-4">Đăng tin ngay để tiếp cận hàng ngàn khách hàng tiềm năng.<br>
                        Đơn giản, nhanh gọn và hoàn toàn miễn phí.</p>
                    <div class="d-flex gap-3">
                        @auth
                            @if(auth()->user()->role === 'owner')
                                <a href="{{ route('owner.products.create') }}" class="btn btn-light fw-bold">Đăng phòng ngay</a>
                            @elseif(auth()->user()->role === 'tenant')
                                <a href="{{ route('profile.upgrade') }}" class="btn btn-light fw-bold">Đăng phòng ngay</a>
                            @else
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-light fw-bold">Trang quản trị</a>
                            @endif
                        @else
                            <button class="btn btn-light fw-bold"
                                data-bs-toggle="modal" data-bs-target="#loginModal">
                                Đăng phòng ngay
                            </button>
                        @endauth
                        <button class="btn btn-outline-light">Tìm hiểu thêm</button>
                    </div>
                </div>
            </div>

        </div>
    </header>

    {{-- Footer --}}
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([10.0452, 105.7469], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const products = @json($mapProducts);

        products.forEach(function(p) {
            const icon = L.divIcon({
                html: `
                    <div style="background:#1d4ed8; color:white; padding:5px 12px; border-radius:20px;
                                font-size:12px; font-weight:bold; white-space:nowrap;
                                box-shadow:0 2px 6px rgba(0,0,0,0.3); position:relative;">
                        ${p.price}đ
                        <div style="position:absolute; bottom:-6px; left:50%; transform:translateX(-50%);
                                    width:0; height:0; border-left:6px solid transparent;
                                    border-right:6px solid transparent; border-top:6px solid #1d4ed8;"></div>
                    </div>
                `,
                className: '',
                iconAnchor: [40, 36],
            });

            const marker = L.marker([p.lat, p.lng], { icon }).addTo(map);

            marker.bindPopup(`
                <div style="width:200px; font-family:Arial;">
                    ${p.photo ? `<img src="${p.photo}" style="width:100%; height:100px; object-fit:cover; border-radius:8px; margin-bottom:8px;">` : ''}
                    <div style="font-weight:bold; font-size:14px;">${p.name}</div>
                    <div style="color:#6c757d; font-size:12px; margin:4px 0;">📍 ${p.address}</div>
                    <div style="color:#16a34a; font-weight:bold; margin-top:4px;">💰 ${p.price}đ/tháng</div>
                    <div style="color:#6c757d; font-size:12px; margin-top:4px;">👤 ${p.user}</div>
                </div>
            `);
        });

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