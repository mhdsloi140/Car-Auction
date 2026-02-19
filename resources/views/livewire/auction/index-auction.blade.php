<div wire:poll.5s class="container my-4" dir="rtl">

    {{-- صندوق الفلترة --}}
    <div class="card p-4 mb-4 shadow-sm border-0 rounded-4">
        <div class="d-flex align-items-center mb-3">
            <i class="bi bi-funnel-fill text-primary fs-4 me-2"></i>
            <h5 class="fw-bold mb-0">فلترة النتائج</h5>
        </div>

        <div class="row g-3">
            {{-- الحالة --}}


            {{-- المحافظة --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">
                    <i class="bi bi-geo-alt ms-1 text-danger"></i>المحافظة
                </label>
                <select class="form-select" wire:model.live="filterCity">
                    <option value="">الكل</option>
                    <option value="بغداد">🇮🇶 بغداد</option>
                    <option value="البصرة">🇮🇶 البصرة</option>
                    <option value="نينوى">🇮🇶 نينوى</option>
                    <option value="أربيل">🇮🇶 أربيل</option>
                    <option value="السليمانية">🇮🇶 السليمانية</option>
                    <option value="دهوك">🇮🇶 دهوك</option>
                    <option value="النجف">🇮🇶 النجف</option>
                    <option value="كربلاء">🇮🇶 كربلاء</option>
                    <option value="الأنبار">🇮🇶 الأنبار</option>
                    <option value="ديالى">🇮🇶 ديالى</option>
                    <option value="صلاح الدين">🇮🇶 صلاح الدين</option>
                    <option value="واسط">🇮🇶 واسط</option>
                    <option value="ميسان">🇮🇶 ميسان</option>
                    <option value="ذي قار">🇮🇶 ذي قار</option>
                    <option value="المثنى">🇮🇶 المثنى</option>
                    <option value="بابل">🇮🇶 بابل</option>
                    <option value="القادسية">🇮🇶 القادسية</option>
                    <option value="كركوك">🇮🇶 كركوك</option>
                </select>
            </div>

            {{-- الماركة --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">
                    <i class="bi bi-car-front ms-1"></i>الماركة
                </label>
                <select class="form-select" wire:model.live="filterBrand">
                    <option value="">الكل</option>
                    @foreach(\App\Models\Brand::orderBy('name')->get() as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- الموديل --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">
                    <i class="bi bi-diagram-3 ms-1"></i>الموديل
                </label>
                <select class="form-select" wire:model.live="filterModel">
                    <option value="">الكل</option>
                    @if($models)
                    @foreach($models as $model)
                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>

            {{-- المواصفات --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">
                    <i class="bi bi-gear ms-1"></i>المواصفات
                </label>
                <select class="form-select" wire:model.live="filterSpecs">
                    <option value="">الكل</option>
                    <option value="gcc"> خليجية</option>
                    <option value="non_gcc"> غير خليجية</option>
                    <option value="unknown"> لا أعلم</option>
                </select>
            </div>

            {{-- نطاق السعر --}}



            {{-- زر إعادة تعيين --}}
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-outline-secondary w-100" wire:click="resetFilters">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    إعادة تعيين
                </button>
            </div>
        </div>
    </div>

    {{-- عنوان الصفحة --}}
    <div class="text-center mb-4">
        <h4 class="fw-bold position-relative d-inline-block">
            سياراتك
            <span class="position-absolute start-50 translate-middle-x bottom-0"
                style="width: 50%; height: 3px; background: linear-gradient(90deg, transparent, #0d6efd, transparent);"></span>
        </h4>
        <div class="text-muted mt-2">
            عدد السيارات: <span class="fw-bold text-primary">{{ $auctions->total() }}</span>
        </div>
    </div>

    {{-- عرض المزادات --}}
    @if($auctions->count())
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">

        @foreach($auctions as $auction)
        @php
        $media = $auction->car->getFirstMedia('cars');
        $bidCount = $auction->bids()->count();
        $currentPrice = $auction->current_price ?? $auction->starting_price;
        $timeLeft = $auction->end_at ? $auction->end_at->diffForHumans() : '-';
        @endphp

        <div class="col">
            <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden hover-lift">

                {{-- صورة السيارة --}}
                <div class="position-relative">
                    @if($media)
                    <img src="{{ $media->getUrl() }}" class="card-img-top"
                        style="height: 200px; object-fit: cover; transition: transform 0.3s;"
                        onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-car-front fs-1 text-muted"></i>
                    </div>
                    @endif



                    {{-- شارة عدد المزايدات --}}

                </div>

                {{-- تفاصيل السيارة --}}
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0">
                            {{ $auction->car->brand->name ?? '' }}
                            {{ $auction->car->model->name ?? '' }}
                        </h5>
                        <span class="text-muted small">{{ $auction->car->year ?? '' }}</span>
                    </div>

                    <div class="row g-2 mt-3">
                        <div class="col-6">
                            <div class="bg-light p-2 rounded-3 text-center">
                                <small class="text-muted d-block">المدينة</small>
                                <span class="fw-bold">{{ $auction->car->city ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light p-2 rounded-3 text-center">
                                <small class="text-muted d-block">المواصفات</small>
                                <span class="fw-bold">
                                    @if($auction->car->specs == 'gcc')
                                    خليجية
                                    @elseif($auction->car->specs == 'non_gcc')
                                    غير خليجية
                                    @else
                                    -
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr>


                </div>

                {{-- زر التفاصيل --}}
           <div class="card-footer bg-white border-0 p-3 pt-0">
    @if($auction->status === 'pending_seller')
        {{-- إذا كان المزاد بانتظار البائع - يظهر زر النتيجة --}}
        <a href="{{ route('auction.sellers.result', $auction->id) }}"
           class="btn btn-success w-100 rounded-pill py-2">
            <i class="bi bi-trophy-fill me-1"></i>
            عرض النتيجة
        </a>
    @elseif($auction->status === 'rejected')
        {{-- إذا كان المزاد مرفوض - يظهر رسالة مرفوض --}}
        <button class="btn btn-danger w-100 rounded-pill py-2" disabled>
            <i class="bi bi-x-circle-fill me-1"></i>
            تم رفض السعر
        </button>
    @else
        {{-- إذا كان المزاد في حالة أخرى - يظهر زر التفاصيل العادي --}}
        <a href="{{ route('auction.show', $auction->id) }}"
           class="btn btn-primary w-100 rounded-pill py-2">
            <i class="bi bi-eye me-1"></i>
            عرض التفاصيل
        </a>
    @endif
</div>
            </div>
        </div>
        @endforeach

    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $auctions->links('pagination::bootstrap-5') }}
    </div>

    @else
    <div class="d-flex justify-content-center align-items-center" style="min-height: 50vh;">
        <div class="text-center">
            <div class="display-1 text-muted mb-4">
                <i class="bi bi-car-front"></i>
            </div>
            <h4 class="text-muted mb-2">لا توجد سيارات</h4>
            <p class="text-muted mb-4">لا يوجد أي سيارة تطابق معايير البحث</p>
            <button class="btn btn-primary" wire:click="resetFilters">
                <i class="bi bi-arrow-counterclockwise me-1"></i>
                إعادة تعيين الفلترة
            </button>
        </div>
    </div>
    @endif

</div>

@push('styles')
<style>
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .card-img-top {
        transition: transform 0.3s ease;
    }

    .pagination {
        gap: 5px;
    }

    .page-link {
        border-radius: 8px !important;
        margin: 0 2px;
    }
</style>
@endpush
