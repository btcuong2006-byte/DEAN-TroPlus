<x-layouts.owner title="Đánh giá - TroPlus">

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold mb-0">Đánh giá phòng của tôi</h4>
        <span class="text-muted">Tổng: <strong>{{ $totalComments }}</strong> đánh giá</span>
    </div>

    <!-- Filter tabs -->
    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('owner.comments') }}"
           class="btn btn-sm rounded-pill {{ !request('filter') ? 'btn-primary' : 'btn-outline-secondary' }}">
            Tất cả ({{ $totalComments }})
        </a>
        <a href="{{ route('owner.comments', ['filter' => 'approved']) }}"
           class="btn btn-sm rounded-pill {{ request('filter') === 'approved' ? 'btn-primary' : 'btn-outline-secondary' }}">
            Đã duyệt ({{ $approvedCount }})
        </a>
        <a href="{{ route('owner.comments', ['filter' => 'pending']) }}"
           class="btn btn-sm rounded-pill {{ request('filter') === 'pending' ? 'btn-primary' : 'btn-outline-secondary' }}">
            Chờ duyệt ({{ $pendingCount }})
        </a>
    </div>

    <!-- Danh sách đánh giá -->
    <div class="d-flex flex-column gap-3">
        @forelse($comments as $comment)
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex gap-3">
                    @if($comment->user->avatar)
                        <img src="{{ asset('storage/' . $comment->user->avatar) }}"
                             style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? 'U') }}&background=3b82f6&color=fff"
                             style="width: 48px; height: 48px; border-radius: 50%;">
                    @endif
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-semibold">{{ $comment->user->name ?? '-' }}</span>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $comment->rating ? '-fill' : '' }} text-warning" style="font-size: 0.8rem;"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="text-muted" style="font-size: 0.8rem;">
                            Phòng: {{ $comment->product->name ?? '-' }}
                        </div>
                        <p class="mt-2 mb-0">{{ $comment->content }}</p>
                    </div>
                </div>

                <div>
                    @if($comment->is_approved)
                        <span class="badge rounded-pill" style="background-color: #dcfce7; color: #16a34a;">Đã duyệt</span>
                    @else
                        <span class="badge rounded-pill" style="background-color: #fef9c3; color: #ca8a04;">Chờ duyệt</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-muted py-5">
            <i class="bi bi-chat-square-text fs-1"></i>
            <p class="mt-2">Chưa có đánh giá nào</p>
        </div>
        @endforelse
    </div>

</x-layouts.owner>