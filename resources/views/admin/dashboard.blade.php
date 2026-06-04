<x-layouts.admin title="Dashboard - TroPlus">

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
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
                    <i class="stat-icon text-warning bi bi-people"></i>
                    <h3 class="fw-bold">{{ $totalUsers }}</h3>
                    <p class="text-secondary mb-0">Người dùng</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light rounded-4">
                <div class="card-body">
                    <i class="stat-icon text-danger bi bi-chat-left-text"></i>
                    <h3 class="fw-bold">{{ $totalComments }}</h3>
                    <p class="text-secondary mb-0">Bình luận</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng dữ liệu -->
    <div class="row g-4">

        <!-- Bài đăng mới -->
        <div class="col-md-6">
            <div class="db-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Bài Đăng mới</h5>
                    <a href="{{ route('admin.products') }}" class="link-hover">Xem thêm</a>  

                </div>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50%;">Tiêu đề</th>
                            <th style="width: 30%;">Chủ trọ</th>
                            <th style="width: 20%;">Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentProducts as $product)
                        <tr>
                            <td>{{ Str::limit($product->name, 25) }}</td>
                            <td>{{ $product->user->name ?? '-' }}</td>
                            <td>{{ number_format($product->price) }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Đánh giá chờ duyệt -->
        <div class="col-md-6">
            <div class="db-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Đánh giá chờ duyệt</h5>
                   <a href="{{ route('admin.comments') }}" class="link-hover">Xem thêm</a>  

                </div>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 20%;">Người dùng</th>
                            <th style="width: 50%;">Nội dung</th>
                            <th style="width: 30%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentComments as $comment)
                        <tr>
                            <td>{{ $comment->user->name ?? '-' }}</td>
                            <td>{{ Str::limit($comment->content, 35) }}</td>
                            <td>
                                <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.comments.delete', $comment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Không có đánh giá chờ duyệt</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-layouts.admin>