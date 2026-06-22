<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - TroPlus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        body { background-color: #f8faff; }
        .room-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
            border-radius: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .detail-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            margin-bottom: 30px;
        }
        .owner-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            position: sticky;
            top: 100px;
        }
        .badge-tag {
            border-radius: 999px;
            padding: 6px 16px;
            font-size: 0.85rem;
        }
        .star-rating {
            font-size: 1.25rem;
            color: #ffc107;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <x-layouts.navbar />

    <!-- Modals (Login/Register) -->
    @include('partials.modals')

    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('products.search') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i> Quay lại danh sách
            </a>
        </div>

        <div class="row g-4">
            <!-- Cột trái: Chi tiết phòng trọ -->
            <div class="col-lg-8">
                <!-- Hình ảnh -->
                <div class="mb-4">
                    @if($product->photo)
                        <img src="{{ asset('storage/' . $product->photo) }}" class="room-image" alt="{{ $product->name }}">
                    @else
                        <div class="room-image bg-light d-flex align-items-center justify-content-center">
                            <i class="bi bi-image text-muted fs-1"></i>
                        </div>
                    @endif
                </div>

                <!-- Thông tin chính -->
                <div class="detail-card">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <h2 class="fw-bold mb-0 text-dark">{{ $product->name }}</h2>
                        <div class="d-flex align-items-center gap-2">
                            <!-- Favorite Button -->
                            @auth
                                @php
                                    $isFavorited = $product->favoritedBy()->where('users.id', auth()->id())->exists();
                                @endphp
                                <form action="{{ route('products.favorite', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn {{ $isFavorited ? 'btn-danger' : 'btn-outline-danger' }} rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                        <i class="bi bi-heart{{ $isFavorited ? '-fill' : '' }} fs-5"></i>
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-outline-danger rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <i class="bi bi-heart fs-5"></i>
                                </button>
                            @endauth
                        </div>
                    </div>

                    <p class="text-muted mb-4"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $product->address }}, {{ $product->city }}</p>

                    <div class="row g-4 mb-4 border-top border-bottom py-3">
                        <div class="col-6 col-md-3">
                            <span class="text-muted small d-block">Giá thuê</span>
                            <strong class="text-success fs-4">{{ number_format($product->price) }} đ/tháng</strong>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="text-muted small d-block">Diện tích</span>
                            <strong class="text-dark fs-4">{{ $product->acreage }} m²</strong>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="text-muted small d-block">Trạng thái</span>
                            @if($product->status === 'available')
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill mt-1">Còn trống</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill mt-1">Đã cho thuê</span>
                            @endif
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="text-muted small d-block">Danh mục</span>
                            @if($product->categories->count() > 0)
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill mt-1">{{ $product->categories->first()->name }}</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill mt-1">Chưa phân loại</span>
                            @endif
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3">Tiện ích & Đặc điểm</h5>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @foreach(explode(',', $product->description) as $item)
                            @php $item = trim($item); @endphp
                            @if($item)
                                <x-amenity-tag :name="$item" class="badge-tag" />
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Bản đồ vị trí -->
                <div class="detail-card">
                    <h5 class="fw-bold mb-3"><i class="bi bi-map me-2"></i>Vị trí trên bản đồ</h5>
                    <div id="map" style="height: 350px; border-radius: 16px; overflow: hidden; z-index: 1;"></div>
                </div>

                <!-- Đánh giá khách hàng -->
                <div class="detail-card">
                    <h5 class="fw-bold mb-4"><i class="bi bi-chat-square-text me-2"></i>Đánh giá từ khách thuê</h5>

                    <!-- Form viết bình luận -->
                    @auth
                        @if(auth()->user()->role === 'tenant')
                            <div class="bg-light p-4 rounded-4 mb-4">
                                <h6 class="fw-bold mb-3">Viết đánh giá của bạn</h6>
                                <form action="{{ route('comments.store', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label small text-muted mb-1">Chấm điểm</label>
                                        <select name="rating" class="form-select rounded-3" required>
                                            <option value="5">⭐⭐⭐⭐⭐ (5/5 sao - Rất tốt)</option>
                                            <option value="4">⭐⭐⭐⭐ (4/5 sao - Tốt)</option>
                                            <option value="3">⭐⭐⭐ (3/5 sao - Bình thường)</option>
                                            <option value="2">⭐⭐ (2/5 sao - Kém)</option>
                                            <option value="1">⭐ (1/5 sao - Rất kém)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted mb-1">Nội dung bình luận</label>
                                        <textarea name="content" rows="3" class="form-control rounded-3" placeholder="Chia sẻ trải nghiệm của bạn về phòng trọ này..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                        Gửi đánh giá <i class="bi bi-send ms-1"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="alert alert-info rounded-4 mb-4 small">
                                <i class="bi bi-info-circle me-1"></i> Chỉ tài khoản <strong>Khách Thuê (Tenant)</strong> mới có thể gửi đánh giá.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-warning rounded-4 mb-4 small">
                            <i class="bi bi-exclamation-triangle me-1"></i> Vui lòng <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập</a> để viết bình luận đánh giá.
                        </div>
                    @endauth

                    <!-- Danh sách bình luận -->
                    <div class="comment-list">
                        @php
                            $approvedComments = $product->comments()->where('is_approved', true)->latest()->get();
                        @endphp

                        @forelse($approvedComments as $comment)
                            <div class="d-flex gap-3 mb-4 pb-4 border-bottom align-items-start">
                                @if($comment->user->avatar)
                                    <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=3b82f6&color=fff" class="rounded-circle" style="width: 48px; height: 48px;">
                                @endif
                                <div class="flex-fill">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold mb-0 text-dark">{{ $comment->user->name }}</h6>
                                        <span class="text-muted small">{{ $comment->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="text-warning mb-2" style="font-size: 0.85rem;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $comment->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="mb-0 text-secondary" style="font-size: 0.95rem;">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center py-4 mb-0">Chưa có đánh giá nào cho phòng trọ này.</p>
                        @endforelse
                    </div>

                </div>
            </div>

            <!-- Cột phải: Thông tin Chủ trọ -->
            <div class="col-lg-4">
                <div class="owner-card">
                    <h5 class="fw-bold mb-4">Thông tin chủ trọ</h5>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        @if($product->user->avatar)
                            <img src="{{ asset('storage/' . $product->user->avatar) }}" class="rounded-circle border" style="width: 64px; height: 64px; object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($product->user->name) }}&background=10b981&color=fff" class="rounded-circle" style="width: 64px; height: 64px;">
                        @endif
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $product->user->name }}</h6>
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill small">Chủ trọ uy tín</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Điểm uy tín:</span>
                            <span class="fw-bold text-warning"><i class="bi bi-star-fill me-1"></i>{{ number_format($product->user->reputation_score, 1) }}/5.0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Tổng đánh giá chủ:</span>
                            <span class="fw-bold text-dark">{{ $product->user->total_reviews }} nhận xét</span>
                        </div>
                    </div>

                    <!-- Nút liên hệ -->
                    @if($product->user->phone)
                        <a href="tel:{{ $product->user->phone }}" class="btn btn-success w-100 rounded-pill py-2.5 mb-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-telephone-fill"></i> Gọi: {{ $product->user->phone }}
                        </a>
                    @else
                        <button class="btn btn-secondary w-100 rounded-pill py-2.5 mb-2 fw-semibold" disabled>
                            <i class="bi bi-telephone-x-fill"></i> Chưa có SĐT
                        </button>
                    @endif
                    <button class="btn btn-outline-primary w-100 rounded-pill py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-chat-dots-fill"></i> Gửi tin nhắn
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Init Map
        const lat = {{ $product->lat ?? 10.0452 }};
        const lng = {{ $product->lng ?? 105.7469 }};
        const map = L.map('map').setView([lat, lng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup("<b>{{ $product->name }}</b><br>{{ $product->address }}")
            .openPopup();
    </script>
</body>
</html>
