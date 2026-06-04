<x-layouts.admin title="Quản lý bài đăng - TroPlus">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold mb-0">Quản lý bài đăng</h4>
        <span class="text-muted">Tổng: <strong>{{ $totalProducts }}</strong> bài đăng</span>
    </div>

    <!-- Filter -->
    <div class="card rounded-4 mb-4 border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0"
                            placeholder="Tìm theo tiêu đề"
                            id="searchInput">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">Tất cả trạng thái</option>
                        <option value="available">Còn trống</option>
                        <option value="rented">Đã thuê</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng bài đăng -->
    <div class="card rounded-4 border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0" id="productTable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 35%;">Phòng trọ</th>
                        <th style="width: 15%;">Chủ trọ</th>
                        <th style="width: 12%;">Trạng thái</th>
                        <th style="width: 15%;">Giá</th>
                        <th style="width: 13%;">Ngày đăng</th>
                        <th style="width: 10%;" class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <!-- Phòng trọ -->
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                @if($product->photo)
                                <img src="{{ asset('storage/' . $product->photo) }}"
                                    style="width: 50px; height: 40px; border-radius: 8px; object-fit: cover;"
                                    alt="{{ $product->name }}">
                                @else
                                <div style="width: 50px; height: 40px; border-radius: 8px; background: #e5e7eb; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-house text-muted"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ Str::limit($product->name, 35) }}</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">{{ $product->address }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Chủ trọ -->
                        <td class="align-middle">
                            <div class="d-flex align-items-center gap-2">
                                @if($product->user->avatar)
                                <img src="{{ asset('storage/' . $product->user->avatar) }}"
                                    style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover;"
                                    alt="{{ $product->user->name }}">
                                @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($product->user->name ?? 'U') }}&background=3b82f6&color=fff"
                                    style="width: 28px; height: 28px; border-radius: 50%;">
                                @endif
                                <span style="font-size: 0.85rem;">{{ $product->user->name ?? '-' }}</span>
                            </div>
                        </td>

                        <!-- Trạng thái -->
                        <td class="align-middle">
                            @if($product->status === 'available')
                            <span class="badge" style="background-color: #dcfce7; color: #16a34a;">Còn trống</span>
                            @elseif($product->status === 'rented')
                            <span class="badge" style="background-color: #fee2e2; color: #dc2626;">Đã thuê</span>
                            @else
                            <span class="badge" style="background-color: #fef9c3; color: #ca8a04;">Bảo trì</span>
                            @endif
                        </td>

                        <!-- Giá -->
                        <td class="align-middle fw-semibold text-primary">
                            {{ number_format($product->price / 1000000, 1) }} triệu/tháng
                        </td>

                        <!-- Ngày đăng -->
                        <td class="align-middle text-muted" style="font-size: 0.85rem;">
                            {{ $product->created_at->format('d/m/Y') }}
                        </td>

                        <!-- Thao tác -->
                        <td class="align-middle text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <!-- Xem -->
                                <a href="{{ route('products.show', $product->id) }}"
                                    class="btn btn-sm btn-light" title="Xem chi tiết">
                                    <i class="bi bi-eye text-muted"></i>
                                </a>
                                <!-- Sửa -->
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="btn btn-sm btn-light" title="Chỉnh sửa">
                                    <i class="bi bi-pencil text-muted"></i>
                                </a>
                                <!-- Xóa -->
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Xóa bài đăng này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-light" title="Xóa">
                                        <i class="bi bi-trash text-muted"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Không có bài đăng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $products->links() }}
        </div>
        @endif
    </div>

    <!-- Script tìm kiếm -->
    <script>
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);

        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const status = document.getElementById('statusFilter').value.toLowerCase();
            const rows = document.querySelectorAll('#productTable tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(1)')?.innerText.toLowerCase() ?? '';
                const badge = row.querySelector('td:nth-child(3) .badge')?.innerText.toLowerCase() ?? '';

                const matchSearch = name.includes(search);
                const matchStatus = status === '' || badge.includes(
                    status === 'available' ? 'còn trống' : 'đã thuê'
                );

                row.style.display = matchSearch && matchStatus ? '' : 'none';
            });
        }
    </script>

</x-layouts.admin>