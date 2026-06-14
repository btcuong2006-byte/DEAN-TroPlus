<!-- Modal Đăng nhập -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 p-2">
            <div class="modal-header border-0">
                <div>
                    <h5 class="modal-title fw-bold">Đăng nhập</h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Chào mừng bạn quay lại!</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control border-start-0"
                                placeholder="Nhập địa chỉ email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control border-start-0"
                                placeholder="Nhập mật khẩu">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label text-muted" for="remember">Ghi nhớ đăng nhập</label>
                        </div>
                        <a href="#" class="text-primary text-decoration-none">Quên mật khẩu?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">
                        Đăng nhập
                    </button>
                    <div class="mt-3 p-3 rounded-3" style="background: #f8f9fa;">
                        <p class="mb-1 fw-semibold" style="font-size: 0.85rem;">Tài khoản demo:</p>
                        <p class="mb-0 text-primary" style="font-size: 0.8rem;">admin@troplus.com (Admin)</p>
                        <p class="mb-0 text-primary" style="font-size: 0.8rem;">AnhMinh@gmail.com (Chủ trọ)</p>
                        <p class="mb-0 text-primary" style="font-size: 0.8rem;">TungNguyen@gmail.com (Khách thuê)</p>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">Mật khẩu: 123456</p>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <p class="mb-0 text-muted">Chưa có tài khoản?
                    <a href="#" class="text-primary fw-semibold text-decoration-none"
                        data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Đăng ký ngay
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Đăng ký -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 p-2">
            <div class="modal-header border-0">
                <div>
                    <h5 class="modal-title fw-bold">Đăng ký</h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Tạo tài khoản mới</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Họ tên</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="name" class="form-control border-start-0"
                                placeholder="Nhập họ tên" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control border-start-0"
                                placeholder="Nhập địa chỉ email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control border-start-0"
                                placeholder="Nhập mật khẩu">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Xác nhận mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password_confirmation" class="form-control border-start-0"
                                placeholder="Nhập lại mật khẩu">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Vai trò</label>
                        <select name="role" class="form-select rounded-3">
                            <option value="tenant">Khách thuê</option>
                            <option value="owner">Chủ trọ</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">
                        Đăng ký
                    </button>
                </form>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <p class="mb-0 text-muted">Đã có tài khoản?
                    <a href="#" class="text-primary fw-semibold text-decoration-none"
                        data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Đăng nhập
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>