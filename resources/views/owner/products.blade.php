<x-layouts.owner title="Phòng của tôi - TroPlus">

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold mb-0">Phòng của tôi</h4>
        <a href="{{ route('owner.products.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i> Đăng phòng
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    <div class="card rounded-4 border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 40%;">Phòng trọ</th>
                        <th style="width: 15%;">Giá</th>
                        <th style="width: 15%;">Diện tích</th>
                        <th style="width: 15%;">Trạng thái</th>
                        <th style="width: 15%;" class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                @if($product->photo)
                                    <img src="{{ asset('storage/' . $product->photo) }}"
                                         style="width: 50px; height: 40px; border-radius: 8px; object-fit: cover;">
                                @else
                                    <div style="width: 50px; height: 40px; border-radius: 8px; background: #e5e7eb; display:flex; align-items:center; justify-content:center;">
                                        <i class="bi bi-house text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ Str::limit($product->name, 30) }}</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">{{ $product->address }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle fw-semibold text-primary">
                            {{ number_format($product->price) }}đ
                        </td>
                        <td class="align-middle">{{ $product->acreage }} m²</td>
                        <td class="align-middle">
                            @if($product->status === 'available')
                                <span class="badge" style="background-color: #dcfce7; color: #16a34a;">Còn trống</span>
                            @else
                                <span class="badge" style="background-color: #fee2e2; color: #dc2626;">Đã thuê</span>
                            @endif
                        </td>
                        <td class="align-middle text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('owner.products.edit', $product->id) }}"
                                   class="btn btn-sm btn-light" title="Sửa">
                                    <i class="bi bi-pencil text-muted"></i>
                                </a>
                                <form action="{{ route('owner.products.destroy', $product->id) }}" method="POST"
                                      onsubmit="return confirm('Xóa phòng này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-light" title="Xóa">
                                        <i class="bi bi-trash text-muted"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Chưa có phòng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $products->links() }}
        </div>
        @endif
    </div>

</x-layouts.owner>