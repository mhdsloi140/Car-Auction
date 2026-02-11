<div class="row g-4" wire:poll.5s>

    {{-- مزادات نشطة بدون مزايدات --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm text-center p-4 border-0">
           <i class="fas fa-envelope-open fa-2x mb-2 text-info"></i>

            <h6 class="text-muted">مزادات نشطة بدون مزايدات</h6>
            <h3 class="fw-bold">{{ $activeWithoutBids }}</h3>
        </div>
    </div>

    {{-- مزادات انتهت بدون فائز --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm text-center p-4 border-0">
            <i class="fas fa-exclamation-triangle fa-2x mb-2 text-danger"></i>
            <h6 class="text-muted">مزادات انتهت بدون فائز</h6>
            <h3 class="fw-bold">{{ $endedNoWinner }}</h3>
        </div>
    </div>

    {{-- مزادات نشطة بمزايدات --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm text-center p-4 border-0">
            <i class="fas fa-gavel fa-2x mb-2 text-success"></i>
            <h6 class="text-muted">مزادات نشطة بمزايدات</h6>
            <h3 class="fw-bold">{{ $activeWithBids }}</h3>
        </div>
    </div>

    {{-- مزادات مرفوضة اليوم --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm text-center p-4 border-0">
            <i class="fas fa-times-circle fa-2x mb-2 text-secondary"></i>
            <h6 class="text-muted">مزادات مرفوضة اليوم</h6>
            <h3 class="fw-bold">{{ $rejectedToday }}</h3>
        </div>
    </div>

</div>
