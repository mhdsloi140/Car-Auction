@extends('layouts.app')

@section('content')
<div class="container py-4 page-rtl" dir="rtl">

    {{-- أزرار الإدارة --}}
    @if(auth()->user()->hasRole('admin') && $auction->status === 'pending')
    <div class="d-flex justify-content-center gap-3 mb-4">
        {{-- زر القبول --}}
        <form action="{{ route('auctions.approve', $auction->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-success px-4 d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                قبول المزاد
            </button>
        </form>

        {{-- زر الرفض (Livewire) --}}
        <livewire:admin.reject-auction :auction="$auction" wire:key="reject-{{ $auction->id }}" />
    </div>
    @endif

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

    {{-- بطاقة تفاصيل المزاد --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-gradient-primary text-white py-3" style="background: linear-gradient(45deg, #0d6efd, #0b5ed7);">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-info-circle-fill me-2"></i>
                تفاصيل المزاد
            </h5>
        </div>
        <div class="card-body p-4">
            {{-- عنوان السيارة --}}
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h3 class="fw-bold mb-2">
                        {{ $auction->car->brand?->name }} {{ $auction->car->model?->name }}
                        <span class="text-muted fs-5">({{ $auction->car->year }})</span>
                    </h3>

                    @php
                    $statusColors = [
                        'pending' => 'bg-warning text-dark',
                        'active' => 'bg-success',
                        'closed' => 'bg-secondary',
                        'rejected' => 'bg-danger',
                        'completed' => 'bg-info',
                    ];

                    $statusLabels = [
                        'pending' => 'معلق',
                        'active' => 'نشط',
                        'closed' => 'مغلق',
                        'rejected' => 'مرفوض',
                        'completed' => 'مكتمل',
                    ];

                    $colorClass = $statusColors[$auction->status] ?? 'bg-primary';
                    $statusLabel = $statusLabels[$auction->status] ?? $auction->status;
                    @endphp

                    <span class="badge {{ $colorClass }} px-3 py-2 rounded-pill">
                        <i class="bi bi-tag me-1"></i>
                        {{ $statusLabel }}
                    </span>
                </div>

                <div class="text-muted">
                    <small>رقم المزاد: #{{ $auction->id }}</small>
                </div>
            </div>

            <hr class="my-4">

            {{-- بيانات المزاد --}}
            <h5 class="fw-bold mb-3">
                <i class="bi bi-graph-up-arrow text-primary me-2"></i>
                بيانات المزاد
            </h5>
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="bg-light p-3 rounded-3">
                        <small class="text-muted d-block">البائع</small>
                        <span class="fw-bold">{{ $auction->seller?->name ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light p-3 rounded-3">
                        <small class="text-muted d-block">السعر الابتدائي</small>
                        <span class="fw-bold text-primary">{{ number_format($auction->starting_price) }} د.ع</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light p-3 rounded-3">
                        <small class="text-muted d-block">تاريخ الإنشاء</small>
                        <span class="fw-bold">{{ $auction->created_at->format('Y-m-d') }}</span>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            {{-- معلومات السيارة --}}
            <h5 class="fw-bold mb-3">
                <i class="bi bi-car-front-fill text-success me-2"></i>
                معلومات السيارة
            </h5>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <i class="bi bi-geo-alt-fill text-danger fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">المدينة</small>
                            <span class="fw-bold">{{ $auction->car->city ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <i class="bi bi-speedometer2 text-primary fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">عدد الكيلومترات</small>
                            <span class="fw-bold">{{ number_format($auction->car->mileage ?? 0) }} كم</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
                @foreach($auction->car->getMedia('cars') as $index => $photo)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="image-box rounded-3 shadow-sm overflow-hidden"
                         style="height:180px; cursor:pointer;"
                         data-bs-toggle="modal"
                         data-bs-target="#imagesModal"
                         onclick="openSlide({{ $index }})">
                        <img src="{{ $photo->getUrl() }}"
                             class="w-100 h-100"
                             style="object-fit:cover; transition: transform 0.3s;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'"
                             alt="Car image">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- زر حذف المزاد --}}
    @if(auth()->user()->hasRole('admin'))
    <div class="text-center mb-5">
        <form action="{{ route('auction.admin.destroy', $auction->id) }}" method="POST"
              onsubmit="return confirm('هل أنت متأكد من حذف هذا المزاد؟');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger px-5 py-2 rounded-pill d-inline-flex align-items-center gap-2">
                <i class="bi bi-trash-fill"></i>
                حذف المزاد
            </button>
        </form>
    </div>
    @endif

    {{-- مودال عرض الصور --}}
    <div class="modal fade" id="imagesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-dark">
                <div class="modal-body p-0 position-relative">
                    <button type="button"
                            class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>

                    <div id="modalCarousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            @foreach($auction->car->getMedia('cars') as $index => $photo)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $photo->getUrl() }}"
                                     class="d-block w-100"
                                     style="max-height:80vh; object-fit:contain;">
                            </div>
                            @endforeach
                        </div>

                        @if($auction->car->getMedia('cars')->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">السابق</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">التالي</span>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- CSS إضافي --}}
@push('styles')
<style>
    .bg-gradient-primary { background: linear-gradient(45deg, #0d6efd, #0b5ed7); }
    .bg-gradient-success { background: linear-gradient(45deg, #198754, #157347); }
    .bg-gradient-info { background: linear-gradient(45deg, #0dcaf0, #0aa2c0); }

    .modal-backdrop.show {
        z-index: 1040 !important;
    }
    .modal.show {
        z-index: 1050 !important;
    }
    .carousel-control-prev,
    .carousel-control-next {
        width: 10%;
    }
</style>
@endpush

{{-- JavaScript --}}
@push('scripts')
<script>
    // فتح الصورة المحددة في Carousel
    window.openSlide = function(index) {
        const carouselEl = document.getElementById('modalCarousel');
        if (carouselEl) {
            const carousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);
            carousel.to(index);
        }
    }

    // تنظيف backdrop عند إغلاق المودال
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('imagesModal');
        if (modal) {
            modal.addEventListener('hidden.bs.modal', () => {
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
            });
        }
    });
</script>
@endpush

@endsection
