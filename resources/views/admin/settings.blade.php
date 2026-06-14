<x-layouts.admin title="Cài đặt hệ thống - TroPlus">

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Cài đặt hệ thống</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @foreach($settings as $setting)
        <div class="col-md-6">
            <div class="db-card h-100 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="fw-bold text-dark mb-2">
                        <i class="bi bi-image me-2 text-primary"></i>{{ $setting->description ?? $setting->key }}
                    </h5>
                    <p class="text-secondary small mb-3">Khóa cấu hình: <code>{{ $setting->key }}</code></p>
                    
                    <div class="mb-4 text-center bg-light p-3 rounded-4" style="height: 180px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($setting->value)
                            <img src="{{ asset($setting->value) }}" alt="{{ $setting->key }}" class="img-fluid rounded shadow-sm" style="max-height: 100%; object-fit: contain;">
                        @else
                            <span class="text-muted">Không có ảnh</span>
                        @endif
                    </div>
                </div>

                <form action="{{ route('admin.settings.update', $setting->key) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group">
                        <input type="file" name="image" class="form-control rounded-start-3" required accept="image/*">
                        <button class="btn btn-primary rounded-end-3" type="submit">
                            <i class="bi bi-upload me-1"></i> Cập nhật
                        </button>
                    </div>
                    @error('image')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>
        @endforeach
    </div>

</x-layouts.admin>
