<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
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
                <a class="nav-link {{ request()->is('/') ? 'active fw-semibold' : '' }}" href="/">Trang chủ</a>
                <a class="nav-link {{ request()->routeIs('products.search') ? 'active fw-semibold' : '' }}" href="{{ route('products.search') }}">Tìm Phòng</a>
                <a class="nav-link {{ request()->routeIs('products.map') ? 'active fw-semibold' : '' }}" href="{{ route('products.map') }}">Bản Đồ</a>
            </div>

            <div class="d-flex gap-2 align-items-center">
                @auth
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
                                        <i class="bi bi-grid"></i> Dashboard
                                    </a>
                                </li>
                            @elseif(auth()->user()->role === 'owner')
                                <li>
                                    <a class="dropdown-item rounded-3 d-flex align-items-center gap-2"
                                       href="{{ route('owner.dashboard') }}">
                                        <i class="bi bi-grid"></i> Dashboard
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a class="dropdown-item rounded-3 d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person"></i> Trang cá nhân
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 d-flex align-items-center gap-2" href="{{ route('products.favorites') }}">
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