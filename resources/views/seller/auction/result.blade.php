@extends('layouts.app')

@section('content')
<div class="container py-5" dir="rtl">

    {{-- رسائل التنبيه --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-4"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close me-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close me-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
            <div>{{ session('info') }}</div>
            <button type="button" class="btn-close me-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- رأس الصفحة --}}
    @if($auction->status === 'pending_seller')
    <div class="text-center mb-5">
        <div class="d-inline-block bg-warning bg-opacity-10 rounded-circle p-3 mb-3">
            <i class="bi bi-trophy-fill text-warning fs-1"></i>
        </div>
        <h1 class="fw-bold mb-2">نتيجة السيارة</h1>
        <p class="text-muted">لقد قمنا بجلب لك افضل سعر، يرجى اتخاذ القرار المناسب</p>
    </div>

    {{-- بطاقة السعر --}}
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden position-relative">

                {{-- شارة الحالة --}}
                <div class="position-absolute top-0 end-0 m-4" style="z-index: 10;">
                    @if($auction->status === 'completed')
                        <span class="badge bg-success px-4 py-3 rounded-pill fs-6">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            مكتمل
                        </span>
                    @elseif($auction->status === 'pending_seller')
                        <span class="badge bg-warning text-dark px-4 py-3 rounded-pill fs-6">
                            <i class="bi bi-clock-fill me-1"></i>
                            بانتظار قرارك
                        </span>
                    @elseif($auction->status === 'rejected')
                        <span class="badge bg-danger px-4 py-3 rounded-pill fs-6">
                            <i class="bi bi-x-circle-fill me-1"></i>
                            مرفوض
                        </span>
                    @endif
                </div>

                {{-- محتوى البطاقة --}}
                <div class="card-body p-5 text-center">

                    {{-- معلومات السيارة المصغرة --}}
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-4">
                        @if($auction->car->getFirstMediaUrl('cars', 'thumb'))
                            <img src="{{ $auction->car->getFirstMediaUrl('cars', 'thumb') }}"
                                 class="rounded-circle"
                                 style="width: 60px; height: 60px; object-fit: cover;"
                                 alt="{{ $auction->car->name }}">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-car-front fs-2 text-muted"></i>
                            </div>
                        @endif
                        <div class="text-end">
                            <h5 class="fw-bold mb-0">{{ $auction->car->brand?->name }} {{ $auction->car->model?->name }}</h5>
                            <small class="text-muted">{{ $auction->car->year }} • {{ $auction->car->city }}</small>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- السعر النهائي --}}
                    <div class="mb-4">
                        <span class="text-muted d-block mb-2">السعر النهائي</span>
                        <div class="display-3 fw-bold text-success mb-0">
                            {{ number_format($auction->final_price) }}
                            <small class="fs-4">د.ع</small>
                        </div>
                    </div>

                    {{-- أزرار القرار --}}
                    @if($auction->status === 'pending_seller' && !$accepted)
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <form action="{{ route('accept.sellers', $auction->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="btn btn-success w-100 py-3 rounded-pill"
                                            onclick="return confirm('هل أنت متأكد من قبول هذا السعر؟')">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        قبول السعر
                                    </button>
                                </form>
                            </div>

                            <div class="col-md-6">
                                <form action="{{ route('reject.sellers', $auction->id) }}" method="POST"
                                      onsubmit="return confirm('هل أنت متأكد من رفض هذا السعر؟ السعر النهائي: {{ number_format($auction->final_price) }} د.ع')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger w-100 py-3 rounded-pill">
                                        <i class="bi bi-x-circle-fill me-2"></i>
                                        رفض السعر
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{-- رسالة تأكيد القبول --}}
                    @if($accepted)
                        <div class="alert alert-success mt-4">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            لقد قمت بقبول هذا السعر مسبقاً
                        </div>
                    @endif

                    {{-- رسالة الرفض --}}
                    @if($auction->status === 'rejected' && $auction->rejection_reason)
                        <div class="alert alert-danger mt-4">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>سبب الرفض:</strong> {{ $auction->rejection_reason }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- تفاصيل المزاد بعد القبول --}}
    @if($accepted || $auction->status === 'completed')
    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        السيارة
                    </h5>
                </div>
                <div class="card-body p-4">

                    {{-- صورة السيارة --}}
                    @if($auction->car->getFirstMediaUrl('cars'))
                        <div class="text-center mb-4">
                            <img src="{{ $auction->car->getFirstMediaUrl('cars') }}"
                                 class="img-fluid rounded-4 shadow"
                                 style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    {{-- معلومات الفائز --}}
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px;">
                                        <i class="bi bi-person-fill fs-3"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">الفائز</small>
                                        <h5 class="fw-bold mb-1">{{ $auction->winner->name ?? 'لا يوجد' }}</h5>
                                        @if($auction->winner && $auction->winner->phone)
                                            <small class="text-muted">
                                                <i class="bi bi-telephone ms-1"></i>
                                                {{ $auction->winner->phone }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px;">
                                        <i class="bi bi-cash-coin fs-3"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">السعر النهائي</small>
                                        <h3 class="fw-bold text-success mb-0">
                                            {{ number_format($auction->final_price) }} د.ع
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- معلومات إضافية --}}
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="border rounded-3 p-3 text-center">
                                <small class="text-muted d-block">تاريخ البداية</small>
                                <span class="fw-bold">{{ $auction->start_at->format('Y-m-d') }}</span>
                                <small class="text-muted d-block">{{ $auction->start_at->format('H:i') }}</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="border rounded-3 p-3 text-center">
                                <small class="text-muted d-block">تاريخ الانتهاء</small>
                                <span class="fw-bold">{{ $auction->end_at->format('Y-m-d') }}</span>
                                <small class="text-muted d-block">{{ $auction->end_at->format('H:i') }}</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .badge {
        font-weight: 500;
    }
</style>
@endpush
