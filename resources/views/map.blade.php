<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bản đồ tìm phòng trọ - TroPlus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        body { background-color: #f8faff; }
        .map-container {
            width: 100%;
            height: calc(100vh - 100px);
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            position: relative;
        }
        #bigMap {
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .map-card-popup img {
            width: 100%;
            height: 110px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .map-card-popup .title {
            font-weight: bold;
            font-size: 0.95rem;
            color: #1a1a2e;
            margin-bottom: 4px;
        }
        .map-card-popup .price {
            color: #198754;
            font-weight: bold;
            font-size: 0.9rem;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <x-layouts.navbar />

    <!-- Modals -->
    @include('partials.modals')

    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-0"><i class="bi bi-map-fill text-primary me-2"></i>Bản đồ phòng trọ</h4>
                <p class="text-muted small mb-0">Rà quét tìm phòng trọ trống trực quan trên bản đồ lớn</p>
            </div>
            <a href="{{ route('products.search') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-list-ul me-1"></i> Xem dạng danh sách
            </a>
        </div>

        <div class="map-container">
            <div id="bigMap"></div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Khởi tạo bản đồ tại Cần Thơ làm trung tâm mặc định
        const map = L.map('bigMap').setView([10.0452, 105.7469], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const products = @json($mapProducts);

        products.forEach(function(p) {
            // Sử dụng divIcon để hiện thị giá tiền trực tiếp trên ghim bản đồ
            const icon = L.divIcon({
                html: `
                    <div style="background:#2563eb; color:white; padding:4px 10px; border-radius:20px;
                                font-size:11px; font-weight:bold; white-space:nowrap;
                                box-shadow:0 2px 6px rgba(0,0,0,0.3); position:relative; border: 1px solid #ffffff;">
                        ${p.price}đ
                        <div style="position:absolute; bottom:-6px; left:50%; transform:translateX(-50%);
                                    width:0; height:0; border-left:6px solid transparent;
                                    border-right:6px solid transparent; border-top:6px solid #2563eb;"></div>
                    </div>
                `,
                className: '',
                iconAnchor: [35, 30],
            });

            const marker = L.marker([p.lat, p.lng], { icon }).addTo(map);

            // Gắn popup hiển thị thông tin khi click vào ghim
            marker.bindPopup(`
                <div class="map-card-popup" style="width:200px; font-family:sans-serif;">
                    ${p.photo ? `<img src="${p.photo}">` : '<div class="bg-light text-center py-4 rounded mb-2"><i class="bi bi-image text-muted fs-3"></i></div>'}
                    <div class="title">${p.name}</div>
                    <div class="price">💰 ${p.price} đ/tháng</div>
                    <div style="font-size:0.8rem; color:#6c757d; margin-bottom:8px;">📍 ${p.address}</div>
                    <a href="/products/${p.id}" class="btn btn-primary btn-sm w-100 rounded-pill text-white" style="font-size:0.8rem;">
                        <i class="bi bi-eye"></i> Xem chi tiết
                    </a>
                </div>
            `);
        });
    </script>
</body>
</html>
