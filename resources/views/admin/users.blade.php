<x-layouts.admin title="Quản lý người dùng - TroPlus">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold mb-0">Quản lý người dùng</h4>
        <span class="text-muted">Tổng: <strong>{{ $totalUsers }}</strong> tài khoản</span>
    </div>

    <!-- Filter -->
    <div class="card rounded-4 mb-4 border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" 
                               placeholder="Tìm theo tên hoặc email"
                               id="searchInput">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="roleFilter">
                        <option value="">Tất cả vai trò</option>
                        <option value="admin">Quản trị viên</option>
                        <option value="owner">Chủ trọ</option>
                        <option value="tenant">Khách thuê</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active">Hoạt động</option>
                        <option value="banned">Bị khóa</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng người dùng -->
    <div class="card rounded-4 border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0" id="userTable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 30%;">Người dùng</th>
                        <th style="width: 25%;">Email</th>
                        <th style="width: 15%;">Vai trò</th>
                        <th style="width: 15%;">Trạng thái</th>
                        <th style="width: 15%;" class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}"
                                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
                                         alt="{{ $user->name }}">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b82f6&color=fff"
                                         style="width: 40px; height: 40px; border-radius: 50%;"
                                         alt="{{ $user->name }}">
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">{{ $user->phone ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">{{ $user->email }}</td>
                        <td class="align-middle">
                            @if($user->role === 'admin')
                                <span class="badge" style="background-color: #fee2e2; color: #dc2626;">Quản trị viên</span>
                            @elseif($user->role === 'owner')
                                <span class="badge" style="background-color: #dbeafe; color: #2563eb;">Chủ trọ</span>
                            @else
                                <span class="badge" style="background-color: #f3f4f6; color: #374151;">Khách thuê</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <span class="badge" style="background-color: #dcfce7; color: #16a34a;">Hoạt động</span>
                        </td>
                        <td class="align-middle text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <!-- Xem -->
                                <button class="btn btn-sm btn-light" title="Xem chi tiết">
                                    <i class="bi bi-eye text-muted"></i>
                                </button>
                                <!-- Khóa -->
                                <button class="btn btn-sm btn-light" title="Khóa tài khoản">
                                    <i class="bi bi-lock text-muted"></i>
                                </button>
                                <!-- Xóa -->
                                <form action="#" method="POST" class="d-inline"
                                      onsubmit="return confirm('Xóa người dùng này?')">
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
                        <td colspan="5" class="text-center text-muted py-4">Không có người dùng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script tìm kiếm -->
    <script>
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('roleFilter').addEventListener('change', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);

        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const role   = document.getElementById('roleFilter').value.toLowerCase();
            const rows   = document.querySelectorAll('#userTable tbody tr');

            rows.forEach(row => {
                const name  = row.querySelector('td:nth-child(1)')?.innerText.toLowerCase() ?? '';
                const email = row.querySelector('td:nth-child(2)')?.innerText.toLowerCase() ?? '';
                const badge = row.querySelector('td:nth-child(3) .badge')?.innerText.toLowerCase() ?? '';

                const matchSearch = name.includes(search) || email.includes(search);
                const matchRole   = role === '' || badge.includes(role);

                row.style.display = matchSearch && matchRole ? '' : 'none';
            });
        }
    </script>

</x-layouts.admin>