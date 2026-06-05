<x-layouts.owner title="Sửa phòng - TroPlus">

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
                    <input type="text" name="name" class="form-control rounded-3" value="{{ $product->name }}">
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Giá thuê (đ/tháng)</label>
                    <input type="number" name="price" class="form-control rounded-3" value="{{ $product->price }}">
                    @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Diện tích (m²)</label>
                    <input type="number" name="acreage" class="form-control rounded-3" value="{{ $product->acreage }}">
                    @error('acreage') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Địa chỉ</label>
                    <input type="text" name="address" class="form-control rounded-3" value="{{ $product->address }}">
                    @error('address') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Trạng thái</label>
                    <select name="status" class="form-select rounded-3">
                        <option value="available" {{ $product->status === 'available' ? 'selected' : '' }}>Còn trống</option>
                        <option value="rented"    {{ $product->status === 'rented'    ? 'selected' : '' }}>Đã thuê</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Mô tả tiện ích</label>
                    <textarea name="description" class="form-control rounded-3" rows="3">{{ $product->description }}</textarea>
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
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary rounded-pill px-5">
                        <i class="bi bi-check-circle me-1"></i> Cập nhật
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-layouts.owner>