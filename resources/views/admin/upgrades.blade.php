<x-layouts.admin title="Quản lý yêu cầu nâng cấp - TroPlus">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold mb-0">Quản lý yêu cầu nâng cấp Chủ trọ</h4>
        <span class="text-muted">Tổng: <strong>{{ $totalRequests }}</strong> yêu cầu</span>
    </div>

    <!-- Thông báo thành công / lỗi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Thống kê -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-light rounded-4 border-0">
                <div class="card-body">
                    <i class="stat-icon text-primary bi bi-person-up"></i>
                    <h3 class="fw-bold">{{ $totalRequests }}</h3>
                    <p class="text-secondary mb-0">Tổng số yêu cầu</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light rounded-4 border-0">
                <div class="card-body">
                    <i class="stat-icon text-warning bi bi-hourglass-split"></i>
                    <h3 class="fw-bold">{{ $pendingCount }}</h3>
                    <p class="text-secondary mb-0">Đang chờ duyệt</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light rounded-4 border-0">
                <div class="card-body">
                    <i class="stat-icon text-success bi bi-check-circle"></i>
                    <h3 class="fw-bold">{{ $approvedCount }}</h3>
                    <p class="text-secondary mb-0">Đã phê duyệt</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter tabs -->
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <a href="{{ route('admin.upgrades') }}"
           class="btn btn-sm rounded-pill px-3 {{ !request('filter') ? 'btn-primary' : 'btn-outline-secondary' }}">
            Tất cả ({{ $totalRequests }})
        </a>
        <a href="{{ route('admin.upgrades', ['filter' => 'pending']) }}"
           class="btn btn-sm rounded-pill px-3 {{ request('filter') === 'pending' ? 'btn-primary' : 'btn-outline-secondary' }}">
            Chờ duyệt ({{ $pendingCount }})
        </a>
        <a href="{{ route('admin.upgrades', ['filter' => 'approved']) }}"
           class="btn btn-sm rounded-pill px-3 {{ request('filter') === 'approved' ? 'btn-primary' : 'btn-outline-secondary' }}">
            Đã duyệt ({{ $approvedCount }})
        </a>
        <a href="{{ route('admin.upgrades', ['filter' => 'rejected']) }}"
           class="btn btn-sm rounded-pill px-3 {{ request('filter') === 'rejected' ? 'btn-primary' : 'btn-outline-secondary' }}">
            Đã từ chối ({{ $totalRequests - $pendingCount - $approvedCount }})
        </a>
    </div>

    <!-- Bảng danh sách yêu cầu -->
    <div class="card rounded-4 border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="upgradeTable">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 25%;">Tài khoản</th>
                            <th style="width: 20%;">Thông tin liên hệ</th>
                            <th style="width: 15%;">Số CCCD/CMND</th>
                            <th style="width: 20%;">Phòng đăng ký</th>
                            <th style="width: 10%;">Trạng thái</th>
                            <th style="width: 10%;" class="text-end pe-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upgrades as $req)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    @if($req->user->avatar)
                                        <img src="{{ asset('storage/' . $req->user->avatar) }}"
                                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
                                             alt="{{ $req->user->name }}">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($req->user->name) }}&background=3b82f6&color=fff"
                                             style="width: 40px; height: 40px; border-radius: 50%;"
                                             alt="{{ $req->user->name }}">
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ $req->user->name }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">Yêu cầu: {{ $req->created_at->format('H:i d/m/Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><strong>{{ $req->full_name }}</strong></div>
                                <div class="text-muted small"><i class="bi bi-telephone me-1"></i>{{ $req->phone }}</div>
                            </td>
                            <td>
                                <code class="text-danger fw-bold">{{ $req->identity_number }}</code>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 180px;" title="{{ $req->property_name }}">
                                    {{ $req->property_name }}
                                </div>
                                <div class="text-success small fw-semibold">{{ number_format($req->property_price) }}đ/tháng</div>
                            </td>
                            <td>
                                @if($req->status === 'approved')
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-2 py-1">Đã duyệt</span>
                                @elseif($req->status === 'rejected')
                                    <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Từ chối</span>
                                @else
                                    <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">Chờ duyệt</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <!-- Xem chi tiết -->
                                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#upgradeModal{{ $req->id }}" title="Xem chi tiết">
                                        <i class="bi bi-eye text-primary"></i>
                                    </button>

                                    @if($req->status === 'pending')
                                        <!-- Duyệt nhanh -->
                                        <form action="{{ route('admin.upgrades.approve', $req->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Phê duyệt tài khoản này lên Chủ trọ? Phòng kèm theo sẽ được đăng tự động.')">
                                            @csrf
                                            <button class="btn btn-sm btn-light" title="Phê duyệt">
                                                <i class="bi bi-check-circle text-success"></i>
                                            </button>
                                        </form>
                                        <!-- Từ chối nhanh -->
                                        <form action="{{ route('admin.upgrades.reject', $req->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Từ chối yêu cầu nâng cấp này?')">
                                            @csrf
                                            <button class="btn btn-sm btn-light" title="Từ chối">
                                                <i class="bi bi-x-circle text-danger"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Chi Tiết Cho Từng Yêu Cầu -->
                        <div class="modal fade" id="upgradeModal{{ $req->id }}" tabindex="-1" aria-labelledby="upgradeModalLabel{{ $req->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold text-primary" id="upgradeModalLabel{{ $req->id }}">
                                            <i class="bi bi-shield-check me-2"></i>Chi tiết hồ sơ nâng cấp tài khoản
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body py-4">
                                        <!-- Cảnh báo quy định pháp luật -->
                                        <div class="alert alert-light border rounded-3 mb-4 small py-2 px-3">
                                            <i class="bi bi-info-circle text-primary me-2"></i>
                                            Thông tin định danh cá nhân (CCCD) được thu thập tuân thủ theo <strong>Nghị định 72/2013/NĐ-CP</strong> và <strong>Luật An ninh mạng Việt Nam</strong> để định danh hoạt động kinh doanh phòng trọ trên mạng xã hội.
                                        </div>

                                        <div class="row g-4">
                                            <!-- Cột trái: Thông tin cá nhân -->
                                            <div class="col-md-6 border-end">
                                                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-badge text-primary me-2"></i>1. Thông tin định danh cá nhân</h6>
                                                <table class="table table-sm table-borderless">
                                                    <tr>
                                                        <td class="text-muted" style="width: 40%;">Họ và tên:</td>
                                                        <td class="fw-semibold">{{ $req->full_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Số CCCD/CMND:</td>
                                                        <td class="fw-bold text-danger">{{ $req->identity_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Ngày cấp:</td>
                                                        <td>{{ \Carbon\Carbon::parse($req->identity_date)->format('d/m/Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Nơi cấp:</td>
                                                        <td>{{ $req->identity_place }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Điện thoại:</td>
                                                        <td>
                                                            <a href="tel:{{ $req->phone }}" class="text-decoration-none fw-semibold">
                                                                <i class="bi bi-telephone me-1"></i>{{ $req->phone }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Mã số thuế/GPKD:</td>
                                                        <td>
                                                            @if($req->business_license)
                                                                <span class="badge bg-success-subtle text-success">{{ $req->business_license }}</span>
                                                            @else
                                                                <span class="text-muted italic small">Không cung cấp</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <!-- Cột phải: Thông tin phòng trọ đính kèm -->
                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-house-add text-primary me-2"></i>2. Thông tin phòng trọ đính kèm</h6>
                                                <table class="table table-sm table-borderless">
                                                    <tr>
                                                        <td class="text-muted" style="width: 35%;">Tên phòng:</td>
                                                        <td class="fw-semibold">{{ $req->property_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Giá thuê:</td>
                                                        <td class="fw-bold text-success">{{ number_format($req->property_price) }} đ/tháng</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Diện tích:</td>
                                                        <td>{{ $req->property_acreage }} m²</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Thành phố:</td>
                                                        <td>{{ $req->property_city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Địa chỉ:</td>
                                                        <td>{{ $req->property_address }}</td>
                                                    </tr>
                                                </table>
                                                <div class="mt-2 small text-muted">
                                                    <strong>Mô tả chi tiết:</strong>
                                                    <p class="mb-0 bg-light p-2 rounded text-dark mt-1" style="max-height: 80px; overflow-y: auto; font-size: 0.85rem;">
                                                        {{ $req->property_description }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Ảnh phòng trọ/giấy tờ đính kèm -->
                                        @if($req->property_photo)
                                            <div class="mt-4">
                                                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-image text-primary me-2"></i>Hình ảnh xác minh phòng trọ/giấy tờ pháp lý</h6>
                                                <div class="bg-light p-3 rounded text-center border">
                                                    <a href="{{ asset('storage/' . $req->property_photo) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $req->property_photo) }}" 
                                                             class="img-fluid rounded shadow-sm" 
                                                             style="max-height: 250px; object-fit: contain;" 
                                                             alt="Xác minh nâng cấp">
                                                    </a>
                                                    <div class="text-muted small mt-2"><i class="bi bi-zoom-in"></i> Click vào ảnh để mở xem chi tiết ở tab mới</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0">
                                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
                                        @if($req->status === 'pending')
                                            <form action="{{ route('admin.upgrades.reject', $req->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger rounded-pill px-4" onclick="return confirm('Bạn có chắc chắn muốn từ chối yêu cầu này?')">
                                                    <i class="bi bi-x-circle me-1"></i>Từ chối
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.upgrades.approve', $req->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success rounded-pill px-4" onclick="return confirm('Phê duyệt tài khoản này lên Chủ trọ? Phòng kèm theo sẽ được đăng tải tự động.')">
                                                    <i class="bi bi-check-circle me-1"></i>Phê duyệt
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-person-up fs-1"></i>
                                <p class="mt-2 mb-0">Không có yêu cầu nâng cấp tài khoản nào</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts.admin>
