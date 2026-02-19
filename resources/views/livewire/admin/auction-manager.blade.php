<div class="page-rtl">
    <div wire:poll.5s style="padding-top: 20px">

        {{-- رسائل النجاح والخطأ --}}
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show text-center fw-bold" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center fw-bold" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- قسم البحث والتصفية --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="بحث عن مزاد (ماركة، موديل، بائع)..."
                                wire:model.debounce.500ms="search">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <select class="form-select" wire:model.live="statusFilter">
                            <option value="">كل الحالات</option>
                            <option value="pending">🟡 معلق</option>
                            <option value="active">🟢 نشط</option>
                            <option value="closed">⚪ مغلق</option>
                            <option value="rejected">🔴 مرفوض</option>
                            <option value="completed">🔵 مكتمل</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- جدول المزادات --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>السيارة</th>
                                <th>البائع</th>
                                <th>السعر الابتدائي</th>
                                <th>الحالة</th>
                                <th>تاريخ الإنشاء</th>
                                <th colspan="2">الإجراءات</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($auctions as $auction)
                            <tr>
                                <td class="fw-bold">{{ $auction->id }}</td>

                                <td class="text-start">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($auction->car->getFirstMediaUrl('cars', 'thumb'))
                                        <img src="{{ $auction->car->getFirstMediaUrl('cars', 'thumb') }}" alt="Car"
                                            style="width: 50px; height: 40px; object-fit: cover; border-radius: 4px;">
                                        @elseif($auction->car->getFirstMediaUrl('cars'))
                                        <img src="{{ $auction->car->getFirstMediaUrl('cars') }}" alt="Car"
                                            style="width: 50px; height: 40px; object-fit: cover; border-radius: 4px;">
                                        @else
                                        <div style="width: 50px; height: 40px; background: #e9ecef; border-radius: 4px;"
                                            class="d-flex align-items-center justify-content-center">
                                            <i class="bi bi-car-front text-muted"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <strong>{{ $auction->car->brand?->name ?? '-' }}</strong>
                                            {{ $auction->car->model?->name ?? '-' }}
                                            <br>
                                            <small class="text-muted">{{ $auction->car->year ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div>
                                        <strong>{{ $auction->seller?->name ?? '-' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $auction->seller?->phone ?? '' }}</small>
                                    </div>
                                </td>

                                <td class="fw-bold text-primary">
                                    {{ number_format($auction->starting_price) }} د.ع
                                </td>

                                <td>
                                    @php
                                    $statusColors = [
                                    'pending' => 'bg-warning text-dark',
                                    'active' => 'bg-success',
                                    'closed' => 'bg-secondary',
                                    'rejected' => 'bg-danger',
                                    'completed' => 'bg-info text-white',
                                    ];

                                    $statusLabels = [
                                    'pending' => '🟡 معلق',
                                    'active' => '🟢 نشط',
                                    'closed' => '⚪ مغلق',
                                    'rejected' => '🔴 مرفوض',
                                    'completed' => '🔵 مكتمل',
                                    ];

                                    $colorClass = $statusColors[$auction->status] ?? 'bg-secondary';
                                    $statusLabel = $statusLabels[$auction->status] ?? $auction->status;
                                    @endphp

                                    <span class="badge {{ $colorClass }} px-3 py-2 rounded-pill">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $auction->created_at->format('d/m/Y') }}
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $auction->created_at->diffForHumans() }}
                                    </small>
                                </td>

                                <td width="80">
                                    <a href="{{ route('auction.admin.show', $auction->id) }}"
                                        class="btn btn-sm btn-info text-white" data-bs-toggle="tooltip"
                                        title="عرض التفاصيل">
                                        <i class="bi bi-eye-fill"> غرض</i>
                                    </a>
                                </td>

                                <td width="120">
                                    @if($auction->status === 'active')
                                    <a href="{{ route('auction.admin.details', $auction->id) }}"
                                        class="btn btn-sm btn-outline-success w-100">
                                        <i class="bi bi-graph-up-arrow me-1"></i>
                                        المزايدات
                                    </a>
                                    @else
                                    <button class="btn btn-sm btn-outline-secondary w-100" disabled>
                                        <i class="bi bi-lock-fill me-1"></i>
                                        غير نشط
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                        <h5>لا توجد مزادات مطابقة للبحث</h5>
                                        <p class="mb-0">جرب تغيير كلمة البحث أو تصفية الحالات</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        @if($auctions->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $auctions->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
    // تفعيل tooltips
    document.addEventListener('livewire:init', () => {
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
    });
</script>
@endpush
