<div class="card p-3 shadow-sm">
    <h3 class="mb-3" style="text-align: center">قائمة المزادات</h3>
     <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
        <label class="fw-bold mb-0">فلترة حسب الحالة:</label>
        <select wire:model="statusFilter" class="form-select w-auto">
            <option value="">كل المزادات</option>
            <option value="pending">قيد الانتظار</option>
            <option value="approved">موافق عليه</option>
            <option value="rejected">مرفوض</option>
            <option value="active">نشط</option>
            <option value="closed">مغلق</option>
        </select>
    </div>


  <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>البائع</th>
                    <th>السيارة</th>
                    <th>السعر الابتدائي</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($auctions as $index => $auction)
                <tr>
                    <td>{{ $auctions->firstItem() + $index }}</td>
                    <td>{{ $auction->seller->name }}</td>
                    <td>{{ $auction->car->name }} - {{ $auction->car->brand }} ({{ $auction->car->year }})</td>
                    <td>{{ $auction->start_price }}</td>
                    <td>
                        @if($auction->status == 'pending')
                            <span class="badge bg-warning text-dark">قيد الانتظار</span>
                        @elseif($auction->status == 'approved')
                            <span class="badge bg-success">موافق عليه</span>
                        @elseif($auction->status == 'rejected')
                            <span class="badge bg-danger">مرفوض</span>
                        @elseif($auction->status == 'active')
                            <span class="badge bg-primary">نشط</span>
                        @else
                            <span class="badge bg-secondary">مغلق</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">لا توجد مزادات</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $auctions->links('pagination::bootstrap-5') }}
    </div>
</div>
