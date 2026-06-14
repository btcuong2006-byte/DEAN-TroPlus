<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ cá nhân - TroPlus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8faff; }
        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            margin-bottom: 30px;
        }
        .avatar-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <x-layouts.navbar />

    <!-- Modals (Login/Register) -->
    @include('partials.modals')

    <div class="container py-5">
        <div class="mb-4">
            <h3 class="fw-bold mb-1"><i class="bi bi-person-circle text-primary me-2"></i>Trang cá nhân</h3>
            <p class="text-muted">Cập nhật thông tin tài khoản và cấu hình mật khẩu của bạn</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> Cập nhật mật khẩu thành công!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Cột trái: Thông tin cá nhân -->
            <div class="col-lg-8">
                <div class="profile-card">
                    <h5 class="fw-bold mb-4"><i class="bi bi-card-text me-2 text-primary"></i>Thông tin cá nhân</h5>
                    
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="d-flex align-items-center gap-4 mb-4 flex-wrap">
                            <div class="text-center">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="avatar-preview" id="avatarPreview">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff" class="avatar-preview" id="avatarPreview">
                                @endif
                            </div>
                            <div class="flex-fill">
                                <label class="form-label fw-semibold small text-muted">Thay đổi ảnh đại diện</label>
                                <input type="file" name="avatar" class="form-control rounded-3" accept="image/*" onchange="previewImage(event)">
                                @error('avatar') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Họ và tên</label>
                                <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control rounded-3" value="{{ old('phone', $user->phone) }}" placeholder="VD: 0909000000">
                                @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Địa chỉ Email</label>
                                <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mt-4 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                                    Lưu thay đổi <i class="bi bi-save ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Đổi mật khẩu -->
                <div class="profile-card">
                    <h5 class="fw-bold mb-4"><i class="bi bi-key me-2 text-warning"></i>Đổi mật khẩu</h5>
                    
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Mật khẩu hiện tại</label>
                                <input type="password" name="current_password" class="form-control rounded-3" required autocomplete="current-password">
                                @error('current_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mật khẩu mới</label>
                                <input type="password" name="password" class="form-control rounded-3" required autocomplete="new-password">
                                @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Xác nhận mật khẩu mới</label>
                                <input type="password" name="password_confirmation" class="form-control rounded-3" required autocomplete="new-password">
                                @error('password_confirmation') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mt-4 text-end">
                                <button type="submit" class="btn btn-warning rounded-pill px-5 py-2 fw-semibold text-white">
                                    Cập nhật mật khẩu <i class="bi bi-arrow-repeat ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Cột phải: Thống kê & Xóa tài khoản -->
            <div class="col-lg-4">
                <div class="profile-card">
                    <h5 class="fw-bold mb-4">Thông tin tài khoản</h5>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Vai trò:</span>
                        <strong class="text-primary">
                            @if($user->role === 'admin') Quản trị viên
                            @elseif($user->role === 'owner') Chủ trọ
                            @else Khách thuê trọ
                            @endif
                        </strong>
                    </div>
                    @if($user->role === 'tenant')
                        <div class="mb-3 d-flex justify-content-between">
                            <span class="text-muted">Điểm uy tín:</span>
                            <span class="fw-bold text-warning"><i class="bi bi-star-fill me-1"></i>{{ number_format($user->reputation_score, 1) }}/5.0</span>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <span class="text-muted">Số lượt nhận xét:</span>
                            <span class="fw-bold text-dark">{{ $user->total_reviews }} lượt</span>
                        </div>
                    @endif
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Ngày tham gia:</span>
                        <span class="text-dark">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>

                @if($user->role === 'tenant')
                <div class="profile-card border border-primary-subtle bg-primary-subtle bg-opacity-10">
                    <h5 class="fw-bold text-primary mb-3"><i class="bi bi-person-up me-2"></i>Trở thành Chủ trọ</h5>
                    <p class="text-secondary small mb-4">Bạn có phòng trọ muốn cho thuê? Hãy nâng cấp tài khoản để tự do đăng tải phòng trọ và tiếp cận khách thuê tiềm năng.</p>
                    
                    <a href="{{ route('profile.upgrade') }}" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                        <i class="bi bi-arrow-up-circle-fill me-1"></i> Đăng ký nâng cấp ngay
                    </a>
                </div>
                @endif

                <div class="profile-card border border-danger-subtle bg-danger-subtle bg-opacity-10">
                    <h5 class="fw-bold text-danger mb-3"><i class="bi bi-exclamation-triangle-fill me-2"></i>Xóa tài khoản</h5>
                    <p class="text-secondary small mb-4">Một khi xóa tài khoản, mọi dữ liệu phòng trọ, bình luận, và thông tin liên quan của bạn sẽ bị gỡ bỏ vĩnh viễn khỏi hệ thống.</p>
                    
                    <button class="btn btn-danger w-100 rounded-pill py-2" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                        <i class="bi bi-trash-fill me-1"></i> Yêu cầu xóa tài khoản
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirm delete account -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger" id="confirmDeleteModalLabel">Bạn có chắc chắn?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="text-secondary mb-3">Vui lòng nhập mật khẩu xác nhận của bạn để hoàn tất yêu cầu xóa tài khoản.</p>
                    <form action="{{ route('profile.destroy') }}" method="POST" id="deleteAccountForm">
                        @csrf
                        @method('DELETE')
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control rounded-3" placeholder="Nhập mật khẩu hiện tại..." required>
                            @error('password', 'userDeletion') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" form="deleteAccountForm" class="btn btn-danger rounded-pill px-4">Xác nhận xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('avatarPreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
