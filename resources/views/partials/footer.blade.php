<footer style="margin-top: 100px; width: 100%; background-color: rgb(30, 41, 59); color: rgb(194, 194, 194);">
    <div class="pt-4 pb-4 px-5">
        <div class="row gx-5 pt-5">
            <div class="col-md-3 mb-4">
                <a class="navbar-brand text-white fw-bold fs-4" href="/">TroPlus</a>
                <p class="mt-3 text-secondary" style="font-size: 0.9em;">
                    Nền tảng tìm kiếm và cho thuê phòng trọ hàng đầu Việt Nam.<br>
                    Kết nối người thuê và chủ trọ một cách nhanh chóng, minh bạch.
                </p>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="mb-3">LIÊN KẾT NHANH</h6>
                <a class="d-block text-secondary text-decoration-none mb-2" href="/">Trang chủ</a>
                <a class="d-block text-secondary text-decoration-none mb-2" href="{{ route('products.search') }}">Tìm phòng</a>
                <a class="d-block text-secondary text-decoration-none mb-2" href="{{ route('products.map') }}">Bản đồ phòng trọ</a>
                <a class="d-block text-secondary text-decoration-none mb-2" href="/#featured-rooms">Phòng nổi bật</a>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="mb-3">DÀNH CHO CHỦ TRỌ</h6>
                @auth
                    @if(auth()->user()->role === 'owner')
                        <a class="d-block text-secondary text-decoration-none mb-2" href="{{ route('owner.products.create') }}">Đăng phòng cho thuê</a>
                        <a class="d-block text-secondary text-decoration-none mb-2" href="{{ route('owner.products') }}">Quản lý đăng bài</a>
                    @elseif(auth()->user()->role === 'tenant')
                        <a class="d-block text-secondary text-decoration-none mb-2" href="{{ route('profile.upgrade') }}">Đăng phòng cho thuê</a>
                        <a class="d-block text-secondary text-decoration-none mb-2" href="{{ route('profile.upgrade') }}">Quản lý đăng bài</a>
                    @else
                        <a class="d-block text-secondary text-decoration-none mb-2" href="#" onclick="alert('Tính năng này dành riêng cho tài khoản Chủ trọ!')">Đăng phòng cho thuê</a>
                        <a class="d-block text-secondary text-decoration-none mb-2" href="#" onclick="alert('Tính năng này dành riêng cho tài khoản Chủ trọ!')">Quản lý đăng bài</a>
                    @endif
                @else
                    <a class="d-block text-secondary text-decoration-none mb-2" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng phòng cho thuê</a>
                    <a class="d-block text-secondary text-decoration-none mb-2" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Quản lý đăng bài</a>
                @endauth
                <a class="d-block text-secondary text-decoration-none mb-2" href="#">Hướng dẫn sử dụng</a>
                <a class="d-block text-secondary text-decoration-none mb-2" href="#">Chính sách và quy định</a>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="mb-3">LIÊN HỆ</h6>
                <p class="text-secondary mb-2"><i class="bi bi-geo-alt me-2"></i>123 Nguyễn Anh Minh</p>
                <p class="text-secondary mb-2"><i class="bi bi-telephone me-2"></i>1900 12345</p>
                <p class="text-secondary mb-2"><i class="bi bi-envelope me-2"></i>nguyenanhminh@troplus.vn</p>
            </div>
        </div>
        <hr style="border-color: #333;">
        <p class="text-center text-secondary mb-0" style="font-size: 0.85em;">
            © 2026 TroPlus. All rights reserved.
        </p>
    </div>
</footer>