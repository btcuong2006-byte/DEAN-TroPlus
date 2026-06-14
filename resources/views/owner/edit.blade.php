<x-layouts.owner title="Sửa phòng - TroPlus">
    <!-- Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold mb-0">Chỉnh sửa phòng</h4>
        <a href="{{ route('owner.products') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <div class="card rounded-4 border-0 shadow-sm p-4">
        <form action="{{ route('owner.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Tên phòng</label>
                    <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $product->name) }}" required>
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Giá thuê (đ/tháng)</label>
                    <input type="number" name="price" class="form-control rounded-3" value="{{ old('price', $product->price) }}" required>
                    @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Diện tích (m²)</label>
                    <input type="number" name="acreage" class="form-control rounded-3" value="{{ old('acreage', $product->acreage) }}" required>
                    @error('acreage') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Thành phố</label>
                    <select name="city" class="form-select rounded-3" required>
                        <option value="">-- Chọn thành phố --</option>
                        <option value="Cần Thơ" {{ old('city', $product->city) == 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                        <option value="Hồ Chí Minh" {{ old('city', $product->city) == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                        <option value="Hà Nội" {{ old('city', $product->city) == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                        <option value="Đà Nẵng" {{ old('city', $product->city) == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                    </select>
                    @error('city') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Danh mục phòng</label>
                    @php
                        $selectedCategory = $product->categories->first();
                    @endphp
                    <select name="categories[]" class="form-select rounded-3" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) || (old('categories') == null && $selectedCategory && $selectedCategory->id == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Trạng thái</label>
                    <select name="status" class="form-select rounded-3">
                        <option value="available" {{ $product->status === 'available' ? 'selected' : '' }}>Còn trống</option>
                        <option value="rented"    {{ $product->status === 'rented'    ? 'selected' : '' }}>Đã thuê</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Địa chỉ chi tiết</label>
                    <input type="text" name="address" id="address" class="form-control rounded-3" value="{{ old('address', $product->address) }}" required>
                    @error('address') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <input type="hidden" name="lat" id="lat" value="{{ $product->lat ?? 10.0452 }}">
                <input type="hidden" name="lng" id="lng" value="{{ $product->lng ?? 105.7469 }}">

                <div class="col-md-12">
                    <p class="text-muted" style="font-size: 0.85rem;">
                        <i class="bi bi-info-circle"></i> 
                        Nhập địa chỉ xong nhấn ngoài ô nhập để định vị. Bạn cũng có thể kéo thả marker hoặc click trực tiếp lên bản đồ để chọn vị trí chính xác.
                    </p>
                    <div id="previewMap" style="height: 250px; border-radius: 12px; border: 1px solid #dee2e6;"></div>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Mô tả tiện ích (Phân cách bằng dấu phẩy)</label>
                    <textarea name="description" class="form-control rounded-3" rows="3">{{ old('description', $product->description) }}</textarea>
                    @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Ảnh phòng</label>
                    @if($product->photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->photo) }}"
                                 style="height: 100px; border-radius: 8px; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" name="photo" class="form-control rounded-3" accept="image/*">
                </div>

                <div class="col-md-12 mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-5">
                        <i class="bi bi-check-circle me-1"></i> Cập nhật
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Script xử lý tọa độ tự động & chọn vị trí -->
    <script>
        let previewMap = null;
        let previewMarker = null;

        const lat = parseFloat(document.getElementById('lat').value);
        const lng = parseFloat(document.getElementById('lng').value);

        // Khởi tạo bản đồ tại tọa độ hiện tại
        previewMap = L.map('previewMap').setView([lat, lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(previewMap);

        previewMarker = L.marker([lat, lng], { draggable: true }).addTo(previewMap)
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
            const clickLat = e.latlng.lat;
            const clickLng = e.latlng.lng;
            previewMarker.setLatLng([clickLat, clickLng]);
            document.getElementById('lat').value = clickLat;
            document.getElementById('lng').value = clickLng;
        });

        // Định vị tự động khi nhập địa chỉ
        document.getElementById('address').addEventListener('blur', function() {
            const address = this.value;
            if (!address) return;

            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address + ', Việt Nam')}&format=json&limit=1`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const newLat = parseFloat(data[0].lat);
                        const newLng = parseFloat(data[0].lon);

                        document.getElementById('lat').value = newLat;
                        document.getElementById('lng').value = newLng;

                        previewMap.setView([newLat, newLng], 15);
                        previewMarker.setLatLng([newLat, newLng]);
                    }
                });
        });
    </script>
</x-layouts.owner>