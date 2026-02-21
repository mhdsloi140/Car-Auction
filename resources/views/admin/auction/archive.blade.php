@extends('layouts.app')

@section('content')
<div class="container my-5" style="direction: rtl;">

    {{-- عنوان الصفحة --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-archive text-primary me-2"></i>
            أرشيف مزاداتي المنتهية
        </h3>
        <span class="badge bg-secondary px-3 py-2">
            إجمالي المزادات: {{ $auctions->total() }}
        </span>
    </div>

    @if($auctions->count())
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3">#</th>
                        <th class="py-3">السيارة</th>
                        <th class="py-3">السعر الابتدائي</th>
                        <th class="py-3">السعر النهائي</th>
                        <th class="py-3">حالة المزاد</th>
                        <th class="py-3">الإجراءات</th>
                        <th class="py-3">تاريخ الانتهاء</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($auctions as $auction)
                    <tr>
                        <td class="fw-bold">{{ $auction->id }}</td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($auction->car->getFirstMediaUrl('cars', 'thumb'))
                                <img src="{{ $auction->car->getFirstMediaUrl('cars', 'thumb') }}" class="rounded-3"
                                    style="width: 50px; height: 40px; object-fit: cover;">
                                @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 40px;">
                                    <i class="bi bi-car-front text-muted"></i>
                                </div>
                                @endif
                                <div>
                                    <span class="fw-bold">{{ $auction->car->brand?->name }}</span>
                                    {{ $auction->car->model?->name }}
                                    <br>
                                    <small class="text-muted">{{ $auction->car->year }}</small>
                                </div>
                            </div>
                        </td>

                        <td class="fw-bold text-primary">
                            {{ number_format($auction->starting_price) }} د.ع
                        </td>

                        <td>
                            @if($auction->current_price)
                            <span class="fw-bold text-success">
                                {{ number_format($auction->current_price) }} د.ع
                            </span>
                            @else
                            <span class="badge bg-light text-muted px-3 py-2">
                                <i class="bi bi-dash"></i>
                            </span>
                            @endif
                        </td>

                        {{-- حالة المزاد --}}
                        <td>
                            @php
                            $statusConfig = [
                            'completed' => ['bg-success', 'مكتمل', 'bi-check-circle-fill'],
                            'rejected' => ['bg-danger', 'مرفوض', 'bi-x-circle-fill'],
                            'closed' => ['bg-warning text-dark', 'بانتظار القرار', 'bi-clock-fill'],
                            'pending_seller' => ['bg-warning text-dark', 'بانتظار قرار البائع', 'bi-clock-fill'],
                            'default' => ['bg-light text-dark', $auction->status, 'bi-tag-fill']
                            ];

                            $config = $statusConfig[$auction->status] ?? $statusConfig['default'];
                            @endphp
                            <span class="badge {{ $config[0] }} px-3 py-2 rounded-pill">
                                <i class="bi {{ $config[2] }} me-1"></i>
                                {{ $config[1] }}
                            </span>
                        </td>

                        {{-- الإجراءات --}}
                        <td>
                            @if(($auction->status === 'pending_seller' || $auction->status === 'completed') && $auction->winner)
                            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3"
                                onclick="Livewire.dispatch('openWinnerModal', { auctionId: {{ $auction->id }} })">
                                <i class="bi bi-person-badge me-1"></i>
                                عرض الفائز
                            </button>

                            @elseif($auction->status === 'closed')
                            <div class="d-flex gap-2">
                                <form action="{{ route('auction.admin.complete', $auction->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-3"
                                        onclick="return confirm('هل أنت متأكد من قبول هذا المزاد؟')">
                                        <i class="bi bi-check-circle me-1"></i>
                                        قبول
                                    </button>
                                </form>

                                <form action="{{ route('auction.admin.reject', $auction->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3"
                                        onclick="return confirm('هل أنت متأكد من رفض هذا المزاد؟')">
                                        <i class="bi bi-x-circle me-1"></i>
                                        رفض
                                    </button>
                                </form>
                            </div>

                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td>
                            <span class="badge bg-light text-dark py-2 px-3">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $auction->end_at?->format('Y-m-d') }}
                                <br>
                                <small>{{ $auction->end_at?->format('H:i') }}</small>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $auctions->links('pagination::bootstrap-5') }}
    </div>

    @else

    @endif

    {{-- مودال الفائز (مرة واحدة فقط) --}}
    <livewire:admin.winner-modal />


</div>
@endsection

@push('styles')
<style>
    .table th {
        font-weight: 600;
        color: #495057;
    }

    .table td {
        vertical-align: middle;
    }

    .modal-content {
        border-radius: 1rem;
    }

    .pagination {
        gap: 5px;
    }

    .page-link {
        border-radius: 8px !important;
        margin: 0 2px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        // تنظيف أي backdrops عالقة عند تحميل الصفحة
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('modal-open');

        // عندما يفتح المودال
        Livewire.on('modal-opened', () => {
            document.body.classList.add('modal-open');
        });

        // عندما يغلق المودال
        Livewire.on('modal-closed', () => {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
        });
    });
</script>
@endpush
