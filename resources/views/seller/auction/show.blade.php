@extends('layouts.app')

@section('content')
<div class="container py-4" style="direction: rtl; text-align: right;">

    {{-- رأس الصفحة --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-car-front text-primary me-2"></i>
            تفاصيل السيارة
        </h3>
        <a href="javascript:history.back()" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i>
            العودة
        </a>
    </div>

    {{-- معلومات السيارة الأساسية --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-gradient-primary text-white py-3" style="background: linear-gradient(45deg, #0d6efd, #0b5ed7);">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-info-circle-fill me-2"></i>
                معلومات السيارة
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <i class="bi bi-geo-alt-fill text-danger fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">المدينة</small>
                            <span class="fw-bold">{{ $auction->car->city ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <i class="bi bi-speedometer2 text-primary fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">عدد الكيلومترات</small>
                            <span class="fw-bold">{{ number_format($auction->car->mileage ?? 0) }} كم</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <i class="bi bi-calendar-check text-success fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">سنة الصنع</small>
                            <span class="fw-bold">{{ $auction->car->year ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <i class="bi bi-gear text-warning fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">المواصفات</small>
                            <span class="fw-bold">
                                @if($auction->car->specs)
                                    @if($auction->car->specs == 'gcc')
                                        <span class="badge bg-success">خليجية</span>
                                    @elseif($auction->car->specs == 'non_gcc')
                                        <span class="badge bg-warning text-dark">غير خليجية</span>
                                    @else
                                        <span class="badge bg-secondary">لا أعلم</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 bg-light rounded-3">
                        <div class="d-flex">
                            <i class="bi bi-file-text text-secondary fs-4 me-3"></i>
                            <div>
                                <small class="text-muted d-block">الوصف</small>
                                <p class="mb-0">{{ $auction->car->description ?? 'لا يوجد وصف' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ملف كشف السيارة --}}
    @if($auction->car->report_pdf)
    <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-gradient-success text-white py-3" style="background: linear-gradient(45deg, #198754, #157347);">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-file-pdf-fill me-2"></i>
                كشف السيارة
            </h5>
        </div>
        <div class="card-body p-4 text-center">
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ Storage::url($auction->car->report_pdf) }}"
                   target="_blank"
                   class="btn btn-outline-primary px-4 py-2 rounded-pill">
                    <i class="bi bi-eye me-2"></i>
                    عرض الكشف
                </a>

                <a href="{{ Storage::url($auction->car->report_pdf) }}"
                   download
                   class="btn btn-primary px-4 py-2 rounded-pill">
                    <i class="bi bi-download me-2"></i>
                    تحميل الكشف
                </a>
            </div>

            <small class="text-muted d-block mt-3">
                <i class="bi bi-info-circle me-1"></i>
                {{-- الملف: {{ basename($auction->car->report_pdf) }} --}}
            </small>
        </div>
    </div>
    @endif

    {{-- صور السيارة --}}
    @if($auction->car->getMedia('cars')->count() > 0)
    <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-gradient-info text-white py-3" style="background: linear-gradient(45deg, #0dcaf0, #0aa2c0);">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-images me-2"></i>
                صور السيارة ({{ $auction->car->getMedia('cars')->count() }})
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                @foreach($auction->car->getMedia('cars') as $photo)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ $photo->getUrl() }}" target="_blank" class="d-block">
                        <img src="{{ $photo->getUrl() }}"
                             class="img-fluid rounded-3 shadow-sm"
                             style="height: 160px; object-fit: cover; width: 100%; transition: transform 0.3s;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'"
                             alt="Car image">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary { background: linear-gradient(45deg, #0d6efd, #0b5ed7); }
    .bg-gradient-success { background: linear-gradient(45deg, #198754, #157347); }
    .bg-gradient-info { background: linear-gradient(45deg, #0dcaf0, #0aa2c0); }
    .bg-gradient-warning { background: linear-gradient(45deg, #ffc107, #ffb300); }

    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }

    .rounded-4 {
        border-radius: 1rem !important;
    }
</style>
@endpush
