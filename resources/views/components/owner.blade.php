<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Chủ Trọ - TroPlus' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://getbootstrap.com/docs/5.3/examples/dashboard/dashboard.css" rel="stylesheet">
    <style>
        html, body { height: 100%; margin: 0; }

        .sidebar {
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
            background-color: #1a1f2e !important;
        }

        .sidebar .nav-link {
            color: #a0aec0;
            border-radius: 8px;
            margin: 2px 10px;
            padding: 10px 14px;
        }

        .sidebar .nav-link:hover {
            background-color: #2d3748;
            color: #fff;
        }

        .sidebar .nav-link.active {
            background-color: #3b82f6;
            color: #fff !important;
        }

        .sidebar-brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 20px 16px 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-icon {
            background-color: #3b82f6;
            border-radius: 8px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #fff;
        }

        .sidebar-user {
            padding: 16px;
            border-top: 1px solid #2d3748;
        }

        .sidebar-user img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }

        .sidebar-user .name { color: #fff; font-size: 0.9rem; font-weight: 600; }
        .sidebar-user .role { color: #a0aec0; font-size: 0.75rem; }

        .db-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 16px;
        }

        .link-hover { text-decoration: none; color: gray; font-size: 0.85rem; }
        .link-hover:hover { color: blue; }
        .stat-icon { font-size: 1.8rem; margin-bottom: 8px; }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="sidebar border-0 col-md-3 col-lg-2 p-0 d-flex flex-column justify-content-between">
                <div>
                    <!-- Brand -->
                    <div class="sidebar-brand">
                        <div class="brand-icon">
                            <i class="bi bi-house-fill"></i>
                        </div>
                        TrọPlus
                    </div>

                    <!-- Nav links -->
                    <ul class="nav flex-column mt-2">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}"
                                href="{{ route('owner.dashboard') }}">
                                <i class="bi bi-grid"></i> Tổng quan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('owner.products.create') ? 'active' : '' }}"
                                href="{{ route('owner.products.create') }}">
                                <i class="bi bi-plus-circle"></i> Đăng phòng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('owner.products*') ? 'active' : '' }}"
                                href="{{ route('owner.products') }}">
                                <i class="bi bi-house"></i> Phòng của tôi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('owner.comments*') ? 'active' : '' }}"
                                href="{{ route('owner.comments') }}">
                                <i class="bi bi-chat-square-text"></i> Đánh giá
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- User info + Logout -->
                <div>
                    <div class="sidebar-user d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('storage/owner.jpg') }}"
                             onerror="this.src='https://ui-avatars.com/api/?name=Owner&background=3b82f6&color=fff'"
                             alt="avatar">
                        <div>
                            <div class="name">Chủ Nhà Mẫu</div>
                            <div class="role">Chủ trọ</div>
                        </div>
                    </div>
                    <a class="nav-link d-flex align-items-center gap-2 text-danger mx-2 mb-3" href="#">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </a>
                </div>
            </div>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                {{ $slot }}
            </main>

        </div>
    </div>
</body>
</html>