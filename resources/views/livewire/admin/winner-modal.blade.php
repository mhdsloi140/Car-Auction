<div>
    @if($show)
    <div class="modal-backdrop fade show" style="z-index: 1040;"></div>

    <div class="modal fade show d-block" tabindex="-1" style="z-index: 1050; display: block; background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white border-0">
                    <h5 class="modal-title">
                        <i class="bi bi-trophy-fill me-2"></i>
                        بيانات الفائز
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="close"></button>
                </div>

                @if($auction && $auction->winner)
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-person-circle fs-1 text-success"></i>
                        </div>
                        <h4 class="fw-bold">{{ $auction->winner->name }}</h4>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="bg-light p-3 rounded-3">
                                <small class="text-muted d-block">رقم الجوال</small>
                                <span class="fw-bold fs-5">
                                    {{ $auction->winner->phone ?? '—' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="bg-light p-3 rounded-3">
                                <small class="text-muted d-block">قيمة المزايدة الفائزة</small>
                                <span class="fw-bold fs-4 text-success">
                                    {{ number_format($auction->final_price) }} د.ع
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="modal-body p-4 text-center">
                    <p class="text-muted">لا توجد بيانات للفائز</p>
                </div>
                @endif

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill" wire:click="close">
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
