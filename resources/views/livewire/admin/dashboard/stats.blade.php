<div class="row g-4" wire:poll.5s>

    <!-- المستخدمين -->
    <div class="col-md-3">
        <div class="card shadow-sm text-center p-4 border-0" style="border-radius: 12px;">
            <i class="fas fa-users fa-2x mb-2 text-primary"></i>
            <h6 class="text-muted">المستخدمين</h6>
            <h3 class="fw-bold">{{ $users }}</h3>
        </div>
    </div>

    <!-- المزادات النشطة -->
    <div class="col-md-3">
        <div class="card shadow-sm text-center p-4 border-0" style="border-radius: 12px;">
            <i class="fas fa-gavel fa-2x mb-2 text-success"></i>
            <h6 class="text-muted">المزادات النشطة</h6>
            <h3 class="fw-bold">{{ $active }}</h3>
        </div>
    </div>

    <!-- بانتظار الموافقة -->
    <div class="col-md-3">
        <div class="card shadow-sm text-center p-4 border-0" style="border-radius: 12px;">
            <i class="fas fa-hourglass-half fa-2x mb-2 text-warning"></i>
            <h6 class="text-muted">بانتظار الموافقة</h6>
            <h3 class="fw-bold">{{ $pending }}</h3>
        </div>
    </div>

    <!-- المزادات المنتهية -->
    <div class="col-md-3">
        <div class="card shadow-sm text-center p-4 border-0" style="border-radius: 12px;">
            <i class="fas fa-check-circle fa-2x mb-2 text-danger"></i>
            <h6 class="text-muted">المزادات المنتهية</h6>
            <h3 class="fw-bold">{{ $closed }}</h3>
        </div>
    </div>

</div>
