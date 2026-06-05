<x-layouts.owner title="Đăng phòng - TroPlus">

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
                   placeholder="VD: Phòng trọ gần Đại học..." value="{{ old('name') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Giá thuê (đ/tháng)</label>
            <input type="number" name="price" class="form-control rounded-3"
                   placeholder="VD: 2500000" value="{{ old('price') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Diện tích (m²)</label>
            <input type="number" name="acreage" class="form-control rounded-3"
                   placeholder="VD: 25" value="{{ old('acreage') }}">
        </div>
        <div class="col-md-12">
            <label class="form-label fw-semibold">Địa chỉ</label>
            <input type="text" name="address" class="form-control rounded-3"
                   placeholder="VD: Ninh Kiều, Cần Thơ" value="{{ old('address') }}">
        </div>
        <div class="col-md-12">
            <label class="form-label fw-semibold">Mô tả tiện ích</label>
            <textarea name="description" class="form-control rounded-3" rows="3"
                      placeholder="VD: Có wifi, máy lạnh, bảo vệ 24/7">{{ old('description') }}</textarea>
        </div>
        <div class="col-md-12">
            <label class="form-label fw-semibold">Ảnh phòng</label>
            <input type="file" name="photo" class="form-control rounded-3" accept="image/*">
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary rounded-pill px-5">
                <i class="bi bi-plus-circle me-1"></i> Đăng phòng
            </button>
        </div>
    </div>
</form>
    </div>

</x-layouts.owner>