<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phòng trọ đã lưu - TroPlus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8faff; }
        .card {
            border-radius: 16px !important;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.12);
        }
        .card-title a {
            text-decoration: none;
            color: #1a1a2e;
            font-weight: 600;
        }
        .card-title a:hover { color: #3b82f6; }
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }
        .empty-state .icon {
            width: 80px;
            height: 80px;
            background: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            color: #ef4444;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <x-layouts.navbar />

    <div class="container py-5">
        <div class="mb-4">
            <h3 class="fw-bold mb-1"><i class="bi bi-heart-fill text-danger me-2"></i>Phòng trọ đã lưu</h3>
            <p class="text-muted">Danh sách các phòng trọ bạn đã lưu để xem lại sau</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($products->count() > 0)
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($products as $product)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $product->photo) }}"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;"
                             alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title mb-2">
                                    <a href="{{ route('products.show', $product->id) }}">{{ Str::limit($product->name, 40) }}</a>
                                </h5>
                                <p class="text-muted mb-2 small"><i class="bi bi-geo-alt"></i> {{ $product->address }}</p>
                                <p class="text-success fw-bold mb-3">{{ number_format($product->price) }} đ/tháng</p>
                                
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    @foreach(explode(',', $product->description) as $item)
                                        @php $item = trim($item); @endphp
                                        @if($item)
                                            <x-amenity-tag :name="$item" style="font-size: 0.75rem;" />
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="border-top pt-3 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    @if($product->user->avatar)
                                        <img src="{{ asset('storage/' . $product->user->avatar) }}"
                                             style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <div style="width: 28px; height: 28px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem;">
                                            {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="small text-secondary">{{ $product->user->name }}</span>
                                </div>

                                <form action="{{ route('products.favorite', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3">
                                        <i class="bi bi-heart-break-fill me-1"></i> Bỏ lưu
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="icon"><i class="bi bi-heart"></i></div>
                <h5 class="fw-bold">Bạn chưa lưu phòng trọ nào</h5>
                <p class="text-muted mb-4">Hãy lướt xem danh sách phòng trọ và lưu lại những căn phòng bạn ưng ý nhất nhé!</p>
                <a href="{{ route('products.search') }}" class="btn btn-primary rounded-pill px-4">
                    Tìm phòng ngay
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
