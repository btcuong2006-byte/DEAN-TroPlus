<x-layouts.owner title="Tổng quan - Chủ Trọ">

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold mb-0">Tổng quan</h4>
    </div>

    <!-- Thống kê -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-light rounded-4">
                <div class="card-body">
                    <i class="stat-icon text-primary bi bi-house-fill"></i>
                    <h3 class="fw-bold">{{ $totalProducts }}</h3>
                    <p class="text-secondary mb-0">Tổng phòng</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light rounded-4">
                <div class="card-body">
                    <i class="stat-icon text-success bi bi-door-closed"></i>
                    <h3 class="fw-bold">{{ $availableProducts }}</h3>
                    <p class="text-secondary mb-0">Phòng trống</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light rounded-4">
                <div class="card-body">
                    <i class="stat-icon text-danger bi bi-door-open"></i>
                    <h3 class="fw-bold">{{ $rentedProducts }}</h3>
                    <p class="text-secondary mb-0">Đã thuê</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light rounded-4">
                <div class="card-body">
                    <i class="stat-icon text-warning bi bi-chat-left-text"></i>
                    <h3 class="fw-bold">{{ $totalComments }}</h3>
                    <p class="text-secondary mb-0">Đánh giá</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng dữ liệu -->
    <div class="row g-4">

        <!-- Phòng mới đăng -->
        <div class="col-md-6">
            <div class="db-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Phòng của tôi</h5>
                    <a href="{{ route('owner.products') }}" class="link-hover">Xem thêm</a>
                </div>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50%;">Tên phòng</th>
                            <th style="width: 30%;">Giá</th>
                            <th style="width: 20%;">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts as $product)
                        <tr>
                            <td>{{ Str::limit($product->name, 25) }}</td>
                            <td>{{ number_format($product->price) }}đ</td>
                            <td>
                                @if($product->status === 'available')
                                    <span class="badge" style="background-color: #dcfce7; color: #16a34a;">Trống</span>
                                @else
                                    <span class="badge" style="background-color: #fee2e2; color: #dc2626;">Đã thuê</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Chưa có phòng nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Đánh giá mới -->
        <div class="col-md-6">
            <div class="db-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Đánh giá mới</h5>
                    <a href="{{ route('owner.comments') }}" class="link-hover">Xem thêm</a>
                </div>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 25%;">Người dùng</th>
                            <th style="width: 45%;">Nội dung</th>
                            <th style="width: 30%;">Đánh giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentComments as $comment)
                        <tr>
                            <td>{{ $comment->user->name ?? '-' }}</td>
                            <td>{{ Str::limit($comment->content, 30) }}</td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $comment->rating ? '-fill' : '' }} text-warning" style="font-size: 0.75rem;"></i>
                                @endfor
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Chưa có đánh giá</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-layouts.owner>