<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TroPlus - Tìm phòng trọ nhanh chóng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: rgb(249, 251, 255); }

        .nav-hover { color: gray; }
        .nav-hover:hover { color: blue; }

        .highlight { color: blue; }

        .stats-list {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 30px;
            margin-top: 20px;
        }

        .stats-number {
            font-weight: 700;
            font-size: 1.5rem;
            color: #6c757d;
            margin-bottom: -6px;
        }

        .end-number { font-size: 0.8em; color: #6c757d; }

        .a { font-weight: 700; font-size: 1rem; color: #1a1a2e; margin: 0; line-height: 1.3; }
        .b { font-size: 0.7em; color: #6c757d; margin: 0; }
        .slogan { font-size: 0.9em; color: #6c757d; margin-bottom: 20px; }

        .badge-tag {
            border-radius: 999px;
            color: rgba(25, 135, 84, 0.7);
            background-color: rgba(25, 135, 84, 0.1);
            border: 1px solid rgba(25, 135, 84, 0.4);
            font-size: 0.90em;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            padding: 6px 16px;
            pointer-events: none;
        }

        .box {
            padding: 12px 16px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            z-index: 10;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .box-2 {
            padding: 12px 16px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: absolute;
            top: -20px;
            right: -20px;
            z-index: 10;
            animation: bounce 2s ease-in-out infinite;
        }

        .img-wrapper { position: relative; display: inline-block; width: 100%; }

        .nhato {
            border-radius: 20px;
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }

        .icon-wrap {
            background-color: #d1fae5;
            border-radius: 10px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .find {
            width: 100%;
            max-width: 1000px;
            height: auto;
            border-radius: 10px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 20px 30px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-top: 70px;
        }

        .find select {
            height: 40px;
            width: 180px;
            border-radius: 7px;
            padding: 0 10px;
            border: #6c757d solid 2px;
        }

        .find button { height: 40px; width: 150px; }
        .find label { color: #6c757d; font-size: 0.85rem; display: flex; flex-direction: column; gap: 4px; }

        .card {
            border-radius: 25px !important;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-20px);
            box-shadow: 0 10px 10px rgba(0,0,0,0.2);
        }

        .card-title a { text-decoration: none; color: #1a1a2e; }
        .card-title a:hover { color: #3498db; }
    </style>
</head>

<body>

    <!-- Nav -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top shadow-sm">
        <div class="container-fluid px-4">
            <button class="btn btn-primary me-2">
                <i class="bi bi-house"></i>
            </button>
            <a class="navbar-brand fw-bold" href="/">TroPlus</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav mx-auto">
                    <a class="nav-link nav-hover" href="#">Trang chủ</a>
                    <a class="nav-link nav-hover" href="#">Tìm Phòng</a>
                    <a class="nav-link nav-hover" href="#">Bản Đồ</a>
                </div>

                <div class="d-flex gap-2 align-items-center">
                    @auth
                        <!-- Dropdown user đã đăng nhập -->
                        <div class="dropdown">
                            <button class="btn d-flex align-items-center gap-2 dropdown-toggle border-0"
                                    type="button" data-bs-toggle="dropdown">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                         style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff"
                                         style="width: 32px; height: 32px; border-radius: 50%;">
                                @endif
                                <span>{{ auth()->user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow rounded-4 p-2" style="min-width: 220px;">
                                <li class="px-3 py-2">
                                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">{{ auth()->user()->email }}</div>
                                </li>
                                <li><hr class="dropdown-divider"></li>

                                @if(auth()->user()->role === 'admin')
                                    <li>
                                        <a class="dropdown-item rounded-3 d-flex align-items-center gap-2"
                                           href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-grid"></i> Dashboard Admin
                                        </a>
                                    </li>
                                @elseif(auth()->user()->role === 'owner')
                                    <li>
                                        <a class="dropdown-item rounded-3 d-flex align-items-center gap-2"
                                           href="{{ route('owner.dashboard') }}">
                                            <i class="bi bi-grid"></i> Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 d-flex align-items-center gap-2"
                                           href="{{ route('owner.products.create') }}">
                                            <i class="bi bi-plus-circle"></i> Đăng phòng
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 d-flex align-items-center gap-2"
                                           href="{{ route('owner.products') }}">
                                            <i class="bi bi-house"></i> Phòng của tôi
                                        </a>
                                    </li>
                                @endif

                                <li>
                                    <a class="dropdown-item rounded-3 d-flex align-items-center gap-2" href="#">
                                        <i class="bi bi-person"></i> Trang cá nhân
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-3 d-flex align-items-center gap-2" href="#">
                                        <i class="bi bi-heart"></i> Phòng đã lưu
                                    </a>
                                </li>

                                <li><hr class="dropdown-divider"></li>

                                <li>
                                    <a class="dropdown-item rounded-3 d-flex align-items-center gap-2 text-danger"
                                       href="#"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Chưa đăng nhập -->
                        <button class="btn btn-outline-secondary"
                                data-bs-toggle="modal" data-bs-target="#loginModal">
                            Đăng Nhập
                        </button>
                        <button class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#registerModal">
                            Đăng Ký
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

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

    <!-- Header -->
    <header>
        <div class="container pt-4">
            <div class="row align-items-center">

                <!-- Cột trái -->
                <div class="col d-flex flex-column align-items-start text-start">
                    <p class="badge-tag">
                        <i class="bi bi-house"></i>
                        Nền tảng thuê phòng #1 Việt Nam
                    </p>
                    <h1 class="mt-3"><b>Tìm phòng trọ <br>
                        <span class="highlight">Nhanh Chóng</span> và <br>
                        <span class="highlight">Minh Bạch</span>
                    </b></h1>
                    <p class="slogan">Hàng ngàn phòng trọ được xác minh, đánh giá thực từ khách thuê. Kết nối trực tiếp với chủ trọ uy tín.</p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-dark ps-4 pe-4 p-2 rounded-4">
                            <i class="bi bi-search"></i>
                            <span class="m-2">Tìm phòng ngay</span>
                        </button>
                        <button class="btn btn-outline-secondary ps-4 pe-4 p-2 rounded-4">
                            <i class="bi bi-geo-alt"></i>
                            <span class="m-2">Xem bản đồ</span>
                        </button>
                    </div>
                    <ul class="stats-list">
                        <li>
                            <p class="stats-number">{{ $availableCount }}+</p>
                            <p class="end-number">Phòng Trọ</p>
                        </li>
                        <li>
                            <p class="stats-number">5,000+</p>
                            <p class="end-number">Người Thuê</p>
                        </li>
                        <li>
                            <p class="stats-number">{{ $cityCount }}+</p>
                            <p class="end-number">Thành Phố</p>
                        </li>
                    </ul>
                </div>

                <!-- Cột phải -->
                <div class="col">
                    <div class="img-wrapper">
                        <div class="box-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-wrap">
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <p class="a">4.8/5</p>
                                    <p class="b">Đánh giá</p>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-wrap">
                                    <i class="bi bi-shield-check text-success fs-5"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <p class="a">Phòng đã xác minh</p>
                                    <p class="b">Tất cả phòng được kiểm tra thực tế</p>
                                </div>
                            </div>
                        </div>
                        <img class="nhato" src="{{ asset('storage/' . optional($product)->photo) }}" alt="">
                    </div>
                </div>
            </div>

            <!-- Thanh tìm kiếm -->
            <div class="d-flex justify-content-center">
                <div class="find">
                    <label>Thành Phố
                        <select name="ThanhPho">
                            <option>Tất Cả Thành Phố</option>
                            <option>Hồ Chí Minh</option>
                            <option>Hà Nội</option>
                            <option>Cần Thơ</option>
                            <option>Đà Nẵng</option>
                        </select>
                    </label>
                    <label>Quận / Huyện
                        <select name="Quan">
                            <option>Tất Cả Quận/Huyện</option>
                        </select>
                    </label>
                    <label>Loại Phòng
                        <select name="LoaiPhong">
                            <option>Tất Cả Loại Phòng</option>
                        </select>
                    </label>
                    <label>Khoảng Giá
                        <select name="KhoangGia">
                            <option>Tất Cả Giá</option>
                        </select>
                    </label>
                    <button class="btn btn-primary">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                </div>
            </div>

            <!-- Phòng nổi bật -->
            <div class="mt-5 pt-4">
                <h2 class="fw-bold">Phòng trọ nổi bật</h2>
                <p style="color: #6c757d;">Những phòng trọ được đánh giá cao và đang còn trống</p>

                <div class="row row-cols-1 row-cols-md-3 g-4 align-items-start mt-2">
                    @foreach($products as $product)
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/' . $product->photo) }}"
                                class="card-img-top"
                                style="height: 200px; object-fit: cover;"
                                alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="#">{{ $product->name }}</a>
                                </h5>
                                <p class="card-text text-muted">
                                    <small><i class="bi bi-geo-alt"></i> {{ $product->address }}</small>
                                </p>
                                <p class="card-text text-success fw-bold">
                                    {{ number_format($product->price) }} đ/tháng
                                </p>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(explode(',', $product->description) as $item)
                                    <span class="badge bg-light text-dark border">
                                        @php $item = trim($item); @endphp
                                        @if(str_contains($item, 'wifi')) <i class="bi bi-wifi"></i>
                                        @elseif(str_contains($item, 'máy lạnh')) <i class="bi bi-snow"></i>
                                        @elseif(str_contains($item, 'bảo vệ')) <i class="bi bi-shield-check"></i>
                                        @elseif(str_contains($item, 'gác')) <i class="bi bi-house"></i>
                                        @elseif(str_contains($item, 'chợ')) <i class="bi bi-bag"></i>
                                        @else <i class="bi bi-check-circle"></i>
                                        @endif
                                        {{ $item }}
                                    </span>
                                    @endforeach
                                </div>
                                <div class="mt-3 d-flex align-items-center justify-content-between border-top pt-2">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($product->user->avatar)
                                            <img src="{{ asset('storage/' . $product->user->avatar) }}"
                                                style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                                        @else
                                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #3498db; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.8rem;">
                                                {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span style="font-size: 0.85rem;">{{ $product->user->name }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 text-danger">
                                        <i class="bi bi-heart-fill"></i>
                                        <span style="font-size: 0.85rem;">{{ $product->favorite_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Bản đồ -->
            <div class="mt-5 pt-5 text-center">
                <h2 class="fw-bold">Phòng trọ trên bản đồ</h2>
                <p style="color: #6c757d;">Xem vị trí các phòng trọ trên bản đồ để chọn chỗ ở thuận tiện nhất</p>

                <div style="position: relative; width: 100%; margin-top: 30px;">
                    <img src="{{ asset('storage/' . optional($product)->photo) }}"
                         alt=""
                         style="width: 100%; border-radius: 20px; display: block; height: 350px; object-fit: cover;">

                    <div class="d-flex align-items-center gap-3 bg-white px-4 py-3 rounded-4 shadow"
                        style="position: absolute; bottom: 16px; left: 16px; z-index: 10;">
                        <ul class="stats-list mb-0" style="margin-top: 0;">
                            <li>
                                <p class="stats-number">{{ $availableCount }}</p>
                                <p class="end-number">Phòng Trống</p>
                            </li>
                            <li>
                                <p class="stats-number">{{ $cityCount }}</p>
                                <p class="end-number">Thành Phố</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Đánh giá -->
            <div class="mt-5 pt-5 text-center">
                <h2 class="fw-bold">Khách hàng nói gì về chúng tôi</h2>
                <p style="color: #6c757d;">Những đánh giá thực tế từ người đã tìm được phòng trọ ưng ý</p>

                <div class="row row-cols-1 row-cols-md-3 g-4 align-items-start mt-2">
                    @foreach($comments as $comment)
                    <div class="col">
                        <div class="card rounded-4 p-2">
                            <div class="card-body text-start">
                                <div class="d-flex align-items-center gap-1 text-warning mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $comment->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <p class="mb-3">{{ $comment->content }}</p>
                                <div class="d-flex align-items-center gap-2 border-top pt-2">
                                    @if($comment->user->avatar)
                                        <img src="{{ asset('storage/' . $comment->user->avatar) }}"
                                            style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #3498db; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.8rem;">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span style="font-size: 0.85rem;">{{ $comment->user->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Banner cho thuê -->
            <div style="position: relative; width: 100%; max-width: 1000px; margin: 80px auto 0;">
                <img src="{{ asset($settings['banner_image'] ?? 'images/default.jpg') }}"
                     alt=""
                     style="width: 100%; border-radius: 20px; display: block; height: 300px; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); border-radius: 20px; z-index: 5;"></div>
                <div class="d-flex flex-column align-items-center justify-content-center text-center text-white"
                    style="position: absolute; inset: 0; z-index: 10; padding: 20px;">
                    <h2 class="fw-bold mb-2">Bạn có phòng cho thuê?</h2>
                    <p class="mb-4">Đăng tin ngay để tiếp cận hàng ngàn khách hàng tiềm năng.<br>
                        Đơn giản, nhanh gọn và hoàn toàn miễn phí.</p>
                    <div class="d-flex gap-3">
                        @auth
                            @if(auth()->user()->role === 'owner')
                                <a href="{{ route('owner.products.create') }}" class="btn btn-light fw-bold">
                                    Đăng phòng ngay
                                </a>
                            @else
                                <button class="btn btn-light fw-bold">Đăng phòng ngay</button>
                            @endif
                        @else
                            <button class="btn btn-light fw-bold"
                                    data-bs-toggle="modal" data-bs-target="#registerModal">
                                Đăng phòng ngay
                            </button>
                        @endauth
                        <button class="btn btn-outline-light">Tìm hiểu thêm</button>
                    </div>
                </div>
            </div>

        </div>
    </header>

    <!-- Footer -->
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
                    <a class="d-block text-secondary text-decoration-none mb-2" href="#">Trang chủ</a>
                    <a class="d-block text-secondary text-decoration-none mb-2" href="#">Tìm phòng</a>
                    <a class="d-block text-secondary text-decoration-none mb-2" href="#">Bản đồ phòng trọ</a>
                    <a class="d-block text-secondary text-decoration-none mb-2" href="#">Phòng nổi bật</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="mb-3">DÀNH CHO CHỦ TRỌ</h6>
                    <a class="d-block text-secondary text-decoration-none mb-2" href="#">Đăng phòng cho thuê</a>
                    <a class="d-block text-secondary text-decoration-none mb-2" href="#">Quản lý đăng bài</a>
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

</body>
</html>