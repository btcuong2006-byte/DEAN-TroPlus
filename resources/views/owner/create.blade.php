<x-layouts.owner title="Đăng phòng - TroPlus">
    <!-- Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold mb-0">Đăng phòng mới</h4>
        <a href="{{ route('owner.products') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <div class="card rounded-4 border-0 shadow-sm p-4">
        <form action="{{ route('owner.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Tên phòng</label>
                    <input type="text" name="name" class="form-control rounded-3"
                           placeholder="VD: Phòng trọ gần Đại học..." value="{{ old('name') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Giá thuê (đ/tháng)</label>
                    <input type="number" name="price" class="form-control rounded-3"
                           placeholder="VD: 2500000" value="{{ old('price') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Diện tích (m²)</label>
                    <input type="number" name="acreage" class="form-control rounded-3"
                           placeholder="VD: 25" value="{{ old('acreage') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Thành phố</label>
                    <select name="city" class="form-select rounded-3" required>
                        <option value="">-- Chọn thành phố --</option>
                        <option value="Cần Thơ" {{ old('city') == 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                        <option value="Hồ Chí Minh" {{ old('city') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                        <option value="Hà Nội" {{ old('city') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                        <option value="Đà Nẵng" {{ old('city') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Danh mục phòng</label>
                    <select name="categories[]" class="form-select rounded-3" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Địa chỉ chi tiết</label>
                    <input type="text" name="address" id="address" class="form-control rounded-3"
                           placeholder="VD: 123 đường 3/2, Xuân Khánh, Ninh Kiều, Cần Thơ" value="{{ old('address') }}" required>
                </div>

                <input type="hidden" name="lat" id="lat" value="10.0452">
                <input type="hidden" name="lng" id="lng" value="105.7469">

                <div class="col-md-12">
                    <p class="text-muted" style="font-size: 0.85rem;">
                        <i class="bi bi-info-circle"></i> 
                        Nhập địa chỉ xong nhấn ngoài ô nhập (hoặc Tab) để tự động định vị trên bản đồ. Bạn cũng có thể click trực tiếp lên bản đồ để chọn vị trí chính xác.
                    </p>
                    <div id="previewMap" style="height: 250px; border-radius: 12px; border: 1px solid #dee2e6;"></div>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Mô tả tiện ích & Đặc điểm (Phân cách bằng dấu phẩy)</label>
                    <textarea name="description" class="form-control rounded-3" rows="3"
                              placeholder="VD: Wifi, Máy lạnh, Giờ giấc tự do, Toilet riêng">{{ old('description') }}</textarea>
                    
                    <div class="mt-2" style="font-size: 0.85rem; color: #5f6368; line-height: 1.6;">
                        <span class="d-block mb-1">
                            <i class="bi bi-lightbulb text-warning me-1"></i>
                            <strong>Mẫu ghi tiện ích để hiển thị biểu tượng (icon) tự động:</strong>
                        </span>
                        <div class="lh-lg">
                            Nhập các từ khóa phân cách bởi dấu phẩy, ví dụ: <code>wifi, máy lạnh, tủ lạnh, máy giặt, gác lửng, bảo vệ, tự do, nhà xe, vệ sinh riêng, bếp nấu ăn, ban công</code>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Ảnh phòng</label>
                    <input type="file" name="photo" class="form-control rounded-3" accept="image/*">
                </div>

                <div class="col-md-12 mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-5">
                        <i class="bi bi-plus-circle me-1"></i> Đăng phòng
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Script xử lý tọa độ tự động & click chọn vị trí -->
    <script>
        let previewMap = null;
        let previewMarker = null;

        const defaultLat = 10.0452;
        const defaultLng = 105.7469;

        // Khởi tạo bản đồ mặc định tại Cần Thơ
        previewMap = L.map('previewMap').setView([defaultLat, defaultLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(previewMap);

        previewMarker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(previewMap)
            .bindPopup('Kéo thả ghim để chọn vị trí chính xác')
            .openPopup();

        // Đồng bộ tọa độ khi kéo marker
        previewMarker.on('dragend', function (e) {
            const position = previewMarker.getLatLng();
            document.getElementById('lat').value = position.lat;
            document.getElementById('lng').value = position.lng;
        });

        // Click lên bản đồ để di chuyển marker
        previewMap.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            previewMarker.setLatLng([lat, lng]);
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
        });

        // Định vị tự động khi nhập địa chỉ
        document.getElementById('address').addEventListener('blur', function() {
            const address = this.value;
            if (!address) return;

            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address + ', Việt Nam')}&format=json&limit=1`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);

                        document.getElementById('lat').value = lat;
                        document.getElementById('lng').value = lng;

                        previewMap.setView([lat, lng], 15);
                        previewMarker.setLatLng([lat, lng]);
                    }
                });
        });


    </script>
</x-layouts.owner>