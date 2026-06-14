<x-layouts.owner title="Đánh giá & Nhận xét - TroPlus">

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold mb-0">Quản lý Đánh giá & Nhận xét</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Nav tabs -->
    <ul class="nav nav-tabs mb-4 border-bottom-0 gap-2" id="commentsTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-pill border-0 px-4 py-2" id="room-comments-tab" data-bs-toggle="tab" data-bs-target="#room-comments" type="button" role="tab">
                <i class="bi bi-house me-2"></i>Đánh giá về phòng ({{ $totalComments }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill border-0 px-4 py-2" id="tenant-reviews-tab" data-bs-toggle="tab" data-bs-target="#tenant-reviews" type="button" role="tab">
                <i class="bi bi-person-check me-2"></i>Đánh giá người thuê ({{ $tenantReviews->count() }})
            </button>
        </li>
    </ul>

    <!-- Tab contents -->
    <div class="tab-content" id="commentsTabContent">
        <!-- Tab 1: Đánh giá về phòng của tôi -->
        <div class="tab-pane fade show active" id="room-comments" role="tabpanel">
            <!-- Filter tabs -->
            <div class="d-flex gap-2 mb-3">
                <a href="{{ route('owner.comments') }}"
                   class="btn btn-sm rounded-pill {{ !request('filter') ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Tất cả ({{ $totalComments }})
                </a>
                <a href="{{ route('owner.comments', ['filter' => 'approved']) }}"
                   class="btn btn-sm rounded-pill {{ request('filter') === 'approved' ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Đã duyệt ({{ $approvedCount }})
                </a>
                <a href="{{ route('owner.comments', ['filter' => 'pending']) }}"
                   class="btn btn-sm rounded-pill {{ request('filter') === 'pending' ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Chờ duyệt ({{ $pendingCount }})
                </a>
            </div>

            <!-- Danh sách đánh giá phòng -->
            <div class="d-flex flex-column gap-3">
                @forelse($comments as $comment)
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-3">
                            @if($comment->user->avatar)
                                <img src="{{ asset('storage/' . $comment->user->avatar) }}"
                                     style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? 'U') }}&background=3b82f6&color=fff"
                                     style="width: 48px; height: 48px; border-radius: 50%;">
                            @endif
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold">{{ $comment->user->name ?? '-' }}</span>
                                    <div>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $comment->rating ? '-fill' : '' }} text-warning" style="font-size: 0.8rem;"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-muted small">
                                    Phòng: <strong>{{ $comment->product->name ?? '-' }}</strong>
                                </div>
                                <p class="mt-2 mb-0 text-secondary">{{ $comment->content }}</p>
                            </div>
                        </div>

                        <div>
                            @if($comment->is_approved)
                                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle">Đã duyệt</span>
                            @else
                                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle">Chờ duyệt</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5 bg-white rounded-4 shadow-sm">
                    <i class="bi bi-chat-square-text fs-1 text-secondary"></i>
                    <p class="mt-2">Chưa có đánh giá nào cho phòng trọ của bạn</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Tab 2: Đánh giá người thuê -->
        <div class="tab-pane fade" id="tenant-reviews" role="tabpanel">
            <div class="row g-4">
                <!-- Cột trái: Form đánh giá -->
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <h5 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2 text-primary"></i>Viết nhận xét người thuê</h5>
                        
                        <form action="{{ route('owner.tenant_reviews.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Người thuê</label>
                                <select name="tenant_id" class="form-select rounded-3" required>
                                    <option value="">-- Chọn khách thuê --</option>
                                    @foreach($tenants as $tenant)
                                        <option value="{{ $tenant->id }}">
                                            {{ $tenant->name }} ({{ $tenant->phone ?? 'Không có SĐT' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Thuê tại phòng</label>
                                <select name="product_id" class="form-select rounded-3" required>
                                    <option value="">-- Chọn phòng trọ --</option>
                                    @foreach($myProducts as $prod)
                                        <option value="{{ $prod->id }}">
                                            {{ $prod->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Đánh giá uy tín</label>
                                <select name="rating" class="form-select rounded-3" required>
                                    <option value="5">⭐⭐⭐⭐⭐ (5/5 sao - Rất tốt)</option>
                                    <option value="4">⭐⭐⭐⭐ (4/5 sao - Tốt)</option>
                                    <option value="3">⭐⭐⭐ (3/5 sao - Bình thường)</option>
                                    <option value="2">⭐⭐ (2/5 sao - Kém)</option>
                                    <option value="1">⭐ (1/5 sao - Kém/Trễ hẹn)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Ghi chú nhận xét</label>
                                <textarea name="comment" rows="3" class="form-control rounded-3" placeholder="Ví dụ: Thanh toán tiền phòng đúng hạn, giữ gìn vệ sinh chung..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
                                Gửi đánh giá <i class="bi bi-send ms-1"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Cột phải: Lịch sử nhận xét của chủ trọ -->
                <div class="col-md-7">
                    <div class="d-flex flex-column gap-3">
                        <h5 class="fw-bold mb-1"><i class="bi bi-clock-history me-2 text-secondary"></i>Lịch sử bạn đã đánh giá</h5>
                        @forelse($tenantReviews as $review)
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-3">
                                    @if($review->tenant->avatar)
                                        <img src="{{ asset('storage/' . $review->tenant->avatar) }}"
                                             style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($review->tenant->name ?? 'T') }}&background=10b981&color=fff"
                                             style="width: 44px; height: 44px; border-radius: 50%;">
                                    @endif
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-semibold text-dark">{{ $review->tenant->name ?? '-' }}</span>
                                            <span class="badge bg-warning text-dark small" style="font-size: 0.7rem;">
                                                <i class="bi bi-star-fill me-1"></i>{{ $review->rating }} sao
                                            </span>
                                        </div>
                                        <div class="text-muted small">
                                            Phòng trọ: <strong>{{ $review->product->name ?? '-' }}</strong>
                                        </div>
                                        <p class="mt-2 mb-0 text-secondary" style="font-size: 0.9rem;">
                                            &ldquo;{{ $review->comment }}&rdquo;
                                        </p>
                                    </div>
                                </div>
                                <span class="text-muted small">{{ $review->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-5 bg-white rounded-4 shadow-sm">
                            <i class="bi bi-person-dash fs-1"></i>
                            <p class="mt-2">Bạn chưa thực hiện đánh giá khách thuê nào</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.owner>