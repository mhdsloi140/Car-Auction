<div class="page-rtl">
    <div wire:poll.5s style="padding-top: 20px">


        @if (session()->has('success'))
        <div class="alert alert-success text-center fw-bold">
            {{ session('success') }}
        </div>
        @endif

        @if (session()->has('error'))
        <div class="alert alert-danger text-center fw-bold">
            {{ session('error') }}
        </div>
        @endif


        <div class="mb-3 d-flex gap-3">

            <input type="text" class="form-control" placeholder="بحث عن مزاد..." wire:model.debounce.500ms="search">

            <select class="form-select" wire:model.lazy="statusFilter">
                <option value="">كل الحالات</option>
                <option value="pending">معلق</option>
                <option value="active">نشط</option>
                <option value="closed">مغلق</option>
                <option value="rejected">مرفوض</option>
            </select>

        </div>


        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>السيارة</th>
                        <th>البائع</th>
                        <th>السعر الابتدائي</th>

                        <th>الحالة</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($auctions as $auction)
                    <tr>
                        <td>{{ $auction->id }}</td>

                        <td>
                            {{ $auction->car->brand?->name ?? '-' }}
                            {{ $auction->car->model?->name ?? '-' }}
                            ({{ $auction->car->year ?? '-' }})
                        </td>

                        <td>{{ $auction->seller?->name ?? '-' }}</td>

                        <td>{{ number_format($auction->starting_price) }}</td>


                        <td>
                            @php
                            $statusColors = [

                            'pending' => 'bg-warning text-dark', // قيد الانتظار
                            'active' => 'bg-primary', // مزاد نشط
                            'closed' => 'bg-secondary', // منتهي ولم يُقبل أو يُرفض بعد
                            'rejected' => 'bg-danger', // مرفوض
                            'completed' => 'bg-success', // مكتمل


                            ];

                            $statusLabels = [
                            'pending' => 'معلق',
                            'active' => 'نشط',
                            'closed' => 'مغلق',
                            'rejected' => 'مرفوض',
                            'completed' => 'مكتمل',
                            ];

                            $colorClass = $statusColors[$auction->status] ?? 'bg-secondary';
                            $statusLabel = $statusLabels[$auction->status] ?? $auction->status;
                            @endphp

                            <span class="badge {{ $colorClass }} px-3 py-2">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <td>{{ $auction->created_at->format('d/m/Y') }}</td>

                        <td>
                            <a href="{{ route('auction.admin.show', $auction->id) }}"
                                class="btn btn-sm btn-info text-white">
                                عرض
                            </a>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            لا توجد مزادات مطابقة للبحث
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $auctions->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>
