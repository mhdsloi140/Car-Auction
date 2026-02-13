<div>

    {{-- الفلترة --}}
    <div class="card p-3 mb-4 shadow-sm">
        <div class="row g-3">

            {{-- فلترة حسب المزاد --}}
            <div class="col-md-3">
                <label class="fw-bold">المزاد</label>
                <select wire:model.lazy="auction_id" class="form-control">
                    <option value="">كل المزادات</option>
                    @foreach($auctions as $auction)
                        <option value="{{ $auction->id }}">
                            مزاد #{{ $auction->id }} - {{ $auction->car->brand->name ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- فلترة حسب نوع العملية --}}
            <div class="col-md-3">
                <label class="fw-bold">نوع العملية</label>
                <select wire:model.lazy="action" class="form-control">
                    <option value="">كل العمليات</option>
                    <option value="login">تسجيل دخول</option>
                    <option value="create">إنشاء</option>
                    <option value="update">تعديل</option>
                    <option value="delete">حذف</option>
                    <option value="bid">مزايدة</option>
                </select>
            </div>

            {{-- من تاريخ --}}
            <div class="col-md-3">
                <label class="fw-bold">من تاريخ</label>
                <input type="date" wire:model="from" class="form-control">
            </div>

            {{-- إلى تاريخ --}}
            <div class="col-md-3">
                <label class="fw-bold">إلى تاريخ</label>
                <input type="date" wire:model="to" class="form-control">
            </div>

        </div>
    </div>

    {{-- الجدول --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" wire:model="selectAll"></th>
                        <th>المستخدم</th>
                        <th>العملية</th>
                        <th>الوصف</th>
                        <th>IP</th>
                        <th>المتصفح</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td><input type="checkbox" wire:model="selected" value="{{ $log->id }}"></td>
                        <td>{{ $log->user->name ?? 'غير معروف' }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->ip }}</td>
                        <td>{{ Str::limit($log->user_agent, 30) }}</td>
                        <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">لا توجد سجلات</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 d-flex justify-content-between align-items-center">
            <button class="btn btn-danger" wire:click="deleteSelected">
                حذف السجلات المحددة
            </button>

            {{ $logs->links() }}
        </div>
    </div>

</div>
