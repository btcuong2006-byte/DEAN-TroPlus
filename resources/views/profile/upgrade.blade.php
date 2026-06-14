<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký nâng cấp Chủ trọ - TroPlus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8faff; }
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .section-title {
            color: #1e3a8a;
            border-left: 4px solid #3b82f6;
            padding-left: 10px;
            font-weight: 700;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <x-layouts.navbar />

    <!-- Modals -->
    @include('partials.modals')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h3 class="fw-bold mb-1"><i class="bi bi-person-up text-primary me-2"></i>Đăng ký nâng cấp Chủ trọ</h3>
                        <p class="text-muted small">Cung cấp hồ sơ định danh và thông tin phòng trọ để trở thành người cho thuê trên TroPlus</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left"></i> Quay lại hồ sơ
                    </a>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($pendingRequest)
                    <!-- Trạng thái chờ duyệt -->
                    <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                        <div class="mb-4 text-warning">
                            <i class="bi bi-hourglass-split display-1"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Hồ sơ của bạn đang chờ phê duyệt</h4>
                        <p class="text-secondary mb-4 mx-auto" style="max-width: 600px;">
                            Cảm ơn bạn đã gửi hồ sơ nâng cấp tài khoản lên Chủ trọ. Hệ thống đang tiến hành thẩm định thông tin định danh và phòng trọ của bạn để đảm bảo tuân thủ đầy đủ các quy định về an ninh mạng và thương mại điện tử tại Việt Nam.
                        </p>
                        <div class="p-3 bg-light rounded-4 d-inline-block text-start mb-4">
                            <div class="small mb-1 text-muted"><strong>Họ tên đăng ký:</strong> {{ $pendingRequest->full_name }}</div>
                            <div class="small mb-1 text-muted"><strong>Số điện thoại:</strong> {{ $pendingRequest->phone }}</div>
                            <div class="small mb-1 text-muted"><strong>Phòng trọ đăng ký:</strong> {{ $pendingRequest->property_name }}</div>
                            <div class="small text-muted"><strong>Thời gian gửi:</strong> {{ $pendingRequest->created_at->format('H:i d/m/Y') }}</div>
                        </div>
                        <div>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-4 py-2 fs-6">
                                <i class="bi bi-clock-history me-1"></i> Đang chờ Admin xét duyệt
                            </span>
                        </div>
                    </div>
                @else
                    <!-- Form đăng ký nâng cấp -->
                    <div class="form-card">
                        <!-- Cảnh báo tuân thủ pháp luật -->
                        <div class="alert alert-info rounded-4 mb-4 small" style="border: 1px solid #bfe3f7;">
                            <h6 class="alert-heading fw-bold mb-2"><i class="bi bi-shield-lock-fill me-2"></i>Quy định pháp lý & Bảo mật thông tin</h6>
                            <p class="mb-0">
                                Nhằm tuân thủ các quy định tại <strong>Nghị định số 72/2013/NĐ-CP</strong> về quản lý, cung cấp, sử dụng dịch vụ internet và thông tin trên mạng, cũng như <strong>Luật An ninh mạng Việt Nam</strong>, TroPlus yêu cầu người cho thuê cung cấp thông tin định danh chính xác (CCCD/CMND). Mọi thông tin của bạn được cam kết mã hóa bảo mật và chỉ dùng cho mục đích xác thực tính pháp lý của bài đăng.
                            </p>
                        </div>

                        <form action="{{ route('profile.upgrade.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- PHẦN 1: THÔNG TIN CÁ NHÂN -->
                            <h5 class="section-title">1. Thông tin định danh cá nhân</h5>
                            <div class="row g-3 mb-5">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Họ và tên chủ hộ (trùng trên CCCD)</label>
                                    <input type="text" name="full_name" class="form-control rounded-3" placeholder="VD: NGUYỄN ANH MINH" value="{{ old('full_name', $user->name) }}" required>
                                    @error('full_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Số CCCD / CMND</label>
                                    <input type="text" name="identity_number" class="form-control rounded-3" placeholder="Số định danh gồm 9 hoặc 12 chữ số" value="{{ old('identity_number') }}" required>
                                    @error('identity_number') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ngày cấp</label>
                                    <input type="date" name="identity_date" class="form-control rounded-3" value="{{ old('identity_date') }}" required>
                                    @error('identity_date') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nơi cấp (VD: Cục CSQLHC về trật tự xã hội)</label>
                                    <input type="text" name="identity_place" class="form-control rounded-3" placeholder="VD: Cục Cảnh sát QLHC về trật tự xã hội" value="{{ old('identity_place') }}" required>
                                    @error('identity_place') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Số điện thoại liên hệ chủ hộ</label>
                                    <input type="text" name="phone" class="form-control rounded-3" placeholder="Số điện thoại dùng để nhận cuộc gọi từ khách thuê" value="{{ old('phone', $user->phone) }}" required>
                                    @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Mã số thuế / Giấy phép kinh doanh <span class="text-muted fw-normal">(Không bắt buộc)</span></label>
                                    <input type="text" name="business_license" class="form-control rounded-3" placeholder="Điền nếu là hộ kinh doanh/Doanh nghiệp" value="{{ old('business_license') }}">
                                    @error('business_license') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- PHẦN 2: THÔNG TIN PHÒNG TRỌ ĐẦU TIÊN -->
                            <h5 class="section-title">2. Thông tin bài đăng phòng trọ đính kèm</h5>
                            <p class="text-secondary small mb-3">Đăng ký trước một căn phòng trọ đang còn trống để hệ thống kiểm tra và phê duyệt. Phòng trọ này sẽ tự động được đăng công khai sau khi nâng cấp thành công.</p>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Tiêu đề bài đăng phòng trọ</label>
                                    <input type="text" name="property_name" class="form-control rounded-3" placeholder="VD: Phòng trọ cao cấp có gác lửng gần Đại học Cần Thơ" value="{{ old('property_name') }}" required>
                                    @error('property_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Giá thuê (đ/tháng)</label>
                                    <input type="number" name="property_price" class="form-control rounded-3" placeholder="VD: 2500000" value="{{ old('property_price') }}" required>
                                    @error('property_price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Diện tích (m²)</label>
                                    <input type="number" name="property_acreage" class="form-control rounded-3" placeholder="VD: 25" value="{{ old('property_acreage') }}" required>
                                    @error('property_acreage') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Thành phố</label>
                                    <select name="property_city" class="form-select rounded-3" required>
                                        <option value="">-- Chọn thành phố --</option>
                                        <option value="Cần Thơ" {{ old('property_city') == 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                                        <option value="Hồ Chí Minh" {{ old('property_city') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                                        <option value="Hà Nội" {{ old('property_city') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                        <option value="Đà Nẵng" {{ old('property_city') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                    </select>
                                    @error('property_city') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Địa chỉ chi tiết phòng trọ</label>
                                    <input type="text" name="property_address" class="form-control rounded-3" placeholder="Số nhà, tên đường, phường, quận" value="{{ old('property_address') }}" required>
                                    @error('property_address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Mô tả chi tiết phòng trọ (Vị trí, tiện ích...)</label>
                                    <textarea name="property_description" rows="3" class="form-control rounded-3" placeholder="VD: Phòng có sẵn điều hòa, kệ bếp, giường nệm, điện nước giá nhà nước..." required>{{ old('property_description') }}</textarea>
                                    @error('property_description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Hình ảnh phòng trọ hoặc giấy tờ chứng minh sở hữu</label>
                                    <input type="file" name="property_photo" class="form-control rounded-3" accept="image/*" required>
                                    <div class="form-text small">Vui lòng tải lên ảnh chụp mặt trước của phòng trọ hoặc giấy đăng ký sở hữu/hợp đồng ủy quyền cho thuê để Admin kiểm duyệt tính thực tế của phòng trọ. (Tối đa 3MB)</div>
                                    @error('property_photo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2.5 fw-semibold">
                                    <i class="bi bi-send-fill me-1"></i> Gửi hồ sơ yêu cầu nâng cấp
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
