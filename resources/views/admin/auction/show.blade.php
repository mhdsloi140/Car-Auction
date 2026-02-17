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
                <button class="btn btn-success px-4 d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill"></i>
                    قبول المزاد
                </button>
            </form>

            {{-- زر الرفض --}}
            <livewire:admin.reject-auction :auction="$auction" />

            {{-- تعديل السعر --}}
            <div class="text-center mb-4">
                <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#editPriceModal">
                    تعديل سعر المزاد
                </button>
            </div>
        </div>
    @endif

    {{-- بطاقة تفاصيل المزاد --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            {{-- عنوان السيارة --}}
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h3 class="fw-bold mb-1">
                        {{ $auction->car->brand?->name }} {{ $auction->car->model?->name }} ({{ $auction->car->year }})
                    </h3>

                    @php
                        $statusColors = [
                            'pending' => 'bg-warning text-dark',
                            'active' => 'bg-success',
                            'closed' => 'bg-secondary',
                            'rejected' => 'bg-danger',
                        ];

                        $statusLabels = [
                            'pending' => 'معلق',
                            'active' => 'نشط',
                            'closed' => 'مغلق',
                            'rejected' => 'مرفوض',
                        ];

                        $colorClass = $statusColors[$auction->status] ?? 'bg-primary';
                        $statusLabel = $statusLabels[$auction->status] ?? $auction->status;
                    @endphp

                    <span class="badge {{ $colorClass }} px-3 py-2">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>

            <hr>

            {{-- بيانات المزاد --}}
            <h5 class="fw-bold mb-3"><i class="bi bi-info-circle"></i> بيانات المزاد</h5>
            <div class="row mb-3">
                <div class="col-md-4"><p><strong>البائع:</strong> {{ $auction->seller?->name }}</p></div>
                <div class="col-md-4"><p><strong>السعر الابتدائي:</strong> {{ number_format($auction->starting_price, 0, '.', ',') }}</p></div>
                <div class="col-md-4"><p><strong>سعر الشراء الفوري:</strong> {{ $auction->buy_now_price ? number_format($auction->buy_now_price, 0, '.', ',') : 'لا يوجد' }}</p></div>
            </div>

            <hr>

            {{-- معلومات السيارة --}}
            <h5 class="fw-bold mb-3"><i class="bi bi-car-front-fill"></i> معلومات السيارة</h5>
            <div class="row mb-3">
                <div class="col-md-4"><p><strong>المدينة:</strong> {{ $auction->car->city }}</p></div>
                <div class="col-md-4"><p><strong>عدد الكيلومترات:</strong> {{ $auction->car->mileage }}</p></div>
                <div class="col-md-12 mt-2"><p><strong>الوصف:</strong> {{ $auction->car->description }}</p></div>
            </div>

            <hr>

            {{-- صور السيارة --}}
            <h5 class="fw-bold mb-3"><i class="bi bi-images"></i> صور السيارة</h5>
            @if($auction->car->hasMedia('cars'))
                <div class="row g-3">
                    @foreach($auction->car->getMedia('cars') as $index => $photo)
                        <div class="col-md-3 col-6">
                            <div class="image-box shadow-sm rounded" style="height:180px; overflow:hidden; cursor:pointer;"
                                data-bs-toggle="modal" data-bs-target="#imagesModal" onclick="openSlide({{ $index }})">
                                <img src="{{ $photo->getUrl() }}" class="img-fluid w-100 h-100" style="object-fit:cover;">
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    {{-- زر حذف المزاد --}}
    <div class="text-center mb-5">
        <form action="{{ route('auction.admin.destroy', $auction->id) }}" method="POST">
            @csrf
            @method('delete')
            <button class="btn btn-danger px-4 d-flex align-items-center gap-2 mx-auto">
                <i class="bi bi-trash-fill"></i> حذف المزاد
            </button>
        </form>
    </div>

    {{-- مودال عرض الصور --}}
    <div class="modal fade" id="imagesModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-dark">
                <div class="modal-body p-0">
                    <div id="modalCarousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            @foreach($auction->car->getMedia('cars') as $index => $photo)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ $photo->getUrl() }}" class="d-block w-100" style="max-height:80vh; object-fit:contain;">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- مودال تعديل السعر --}}
    <div class="modal fade" id="editPriceModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('auction.update.price', $auction->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="modal-header">
                        <h5 class="modal-title">تعديل سعر المزاد</h5>
                        <button type="button" class="btn-close ms-3" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>

                    <div class="modal-body">
                        <label class="fw-bold mb-2">السعر الجديد:</label>
                        <input type="number" name="new_price" class="form-control" min="1"
                               value="{{ $auction->starting_price }}" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التعديل</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

{{-- CSS إضافي لتصحيح RTL و z-index --}}
<style>
.modal-backdrop.show { z-index: 1040 !important; }
.modal.show { z-index: 1050 !important; }
#editPriceModal input { direction: ltr; }
</style>

{{-- JS للتأكد من فتح Carousel و focus على input --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    // فتح الصورة المحددة في Carousel
    window.openSlide = function(index) {
        const carouselEl = document.getElementById('modalCarousel');
        const carousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);
        carousel.to(index);
    }

    // وضع focus مباشرة على حقل السعر عند فتح المودال
    const priceModal = document.getElementById('editPriceModal');
    priceModal.addEventListener('shown.bs.modal', () => {
        const input = priceModal.querySelector('input[name="new_price"]');
        if(input) input.focus();
    });
});
</script>

@endsection
