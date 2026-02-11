<div class="row g-4" style="direction: rtl; text-align: right;">

    {{-- إجمالي المزادات --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-3 p-4 text-center bg-white h-100 d-flex align-items-center justify-content-center flex-column">
            <i class="fas fa-gavel text-primary fs-2 mb-2"></i>
            <h6 class="fw-bold text-secondary mb-1">المزادات الكلية</h6>
            <p class="fw-bold fs-3 text-dark mb-0">{{ $totalAuctions }}</p>
        </div>
    </div>

    {{-- المزادات النشطة --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-3 p-4 text-center bg-white h-100 d-flex align-items-center justify-content-center flex-column">
            <i class="fas fa-bolt text-success fs-2 mb-2"></i>
            <h6 class="fw-bold text-secondary mb-1">المزادات النشطة</h6>
            <p class="fw-bold fs-3 text-success mb-0">{{ $activeAuctions }}</p>
        </div>
    </div>

    {{-- المزادات المنتهية --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-3 p-4 text-center bg-white h-100 d-flex align-items-center justify-content-center flex-column">
            <i class="fas fa-flag-checkered text-danger fs-2 mb-2"></i>
            <h6 class="fw-bold text-secondary mb-1">المزادات المنتهية</h6>
            <p class="fw-bold fs-3 text-danger mb-0">{{ $closedAuctions }}</p>
        </div>
    </div>

    {{-- المزادات المرفوضة --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-3 p-4 text-center bg-white h-100 d-flex align-items-center justify-content-center flex-column">
            <i class="fas fa-times-circle text-danger fs-2 mb-2"></i>
            <h6 class="fw-bold text-secondary mb-1">المزادات المرفوضة</h6>
            <p class="fw-bold fs-3 text-danger mb-0">{{ $rejectedAuctions }}</p>
        </div>
    </div>

    {{-- المزادات المعلقة --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-3 p-4 text-center bg-white h-100 d-flex align-items-center justify-content-center flex-column">
            <i class="fas fa-hourglass-half text-warning fs-2 mb-2"></i>
            <h6 class="fw-bold text-secondary mb-1">المزادات المعلقة</h6>
            <p class="fw-bold fs-3 text-warning mb-0">{{ $pendingAuctions }}</p>
        </div>
    </div>

</div>
