@extends('layouts-users.app')

@section('title', 'تفاصيل المزاد')

@section('content')
<div class="auction-detail-wrapper" style="background: linear-gradient(135deg, #f8fafd 0%, #f1f5f9 100%); min-height: 100vh; padding: 20px 0;">
    <div class="container">
        <!-- شريط التنقل - باستخدام Bootstrap فقط -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill px-4">
                <i class="fas fa-arrow-right me-2"></i>
                العودة للرئيسية
            </a>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white p-2 px-4 rounded-pill shadow-sm mb-0">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">المزادات</a></li>
                    <li class="breadcrumb-item active">تفاصيل</li>
                </ol>
            </nav>
        </div>

        <!-- محتوى الصفحة -->
        <div class="row g-4">
            <!-- عمود الصور -->
            <div class="col-lg-6">
                @php $images = $auction->car->getMedia('cars'); @endphp

                @if($images->count() > 0)
                <!-- الصورة الرئيسية -->
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-3">
                    <img src="{{ $images[0]->getUrl() }}"
                         class="w-100"
                         style="height: 400px; object-fit: cover;"
                         id="mainCarImage"
                         alt="سيارة">
                </div>

                <!-- صور مصغرة -->
                @if($images->count() > 1)
                <div class="d-flex gap-2 overflow-auto pb-2" style="scrollbar-width: thin;">
                    @foreach($images as $index => $image)
                    <img src="{{ $image->getUrl() }}"
                         class="rounded-3 border {{ $index === 0 ? 'border-primary border-2' : 'border-secondary' }}"
                         style="width: 80px; height: 60px; object-fit: cover; cursor: pointer; flex-shrink: 0;"
                         onclick="document.getElementById('mainCarImage').src = '{{ $image->getUrl() }}'"
                         alt="مصغرة">
                    @endforeach
                </div>
                @endif
                @else
                <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="fas fa-car-side fa-4x text-muted"></i>
                </div>
                @endif

                <!-- صور السونار -->
                @if($auction->car->getMedia('car_reports')->count() > 0)
                <div class="card shadow-sm border-0 rounded-4 p-3 mt-3">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-file-image text-primary me-2"></i>
                        صور السونار ({{ $auction->car->getMedia('car_reports')->count() }})
                    </h6>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach($auction->car->getMedia('car_reports') as $report)
                        <a href="{{ $report->getUrl() }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="fas fa-image me-1"></i>
                            صورة {{ $loop->iteration }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- عمود المعلومات -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <!-- العنوان والحالة -->
                    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                        <h2 class="fw-bold h3 mb-0">
                            {{ $auction->car->brand->name }} {{ $auction->car->model->name }}
                            <span class="badge bg-light text-dark fs-6">{{ $auction->car->year }}</span>
                        </h2>
                        @if($auction->status === 'active')
                            <span class="badge bg-success px-3 py-2">
                                <i class="fas fa-circle me-1"></i> مباشر
                            </span>
                        @else
                            <span class="badge bg-secondary px-3 py-2">
                                <i class="fas fa-stop-circle me-1"></i> منتهي
                            </span>
                        @endif
                    </div>

                    <!-- رقم المزاد -->
                    <div class="bg-light p-3 rounded-3 mb-3">
                        <i class="fas fa-hashtag text-primary me-2"></i>
                        <span>رقم المزاد: <strong>#{{ $auction->id }}</strong></span>
                    </div>

                    <!-- المواصفات -->
                    <div class="bg-light p-3 rounded-3 mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-clipboard-list text-primary me-2"></i>
                            المواصفات
                        </h6>
                        <p class="mb-1"><span class="text-secondary">النوع:</span> {{ $auction->car->specs_label ?? 'غير محدد' }}</p>
                        <p class="mb-0"><span class="text-secondary">الوصف:</span> {{ $auction->car->description ?? 'لا يوجد' }}</p>
                    </div>

                    <!-- الإحصائيات -->
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="bg-white border rounded-3 p-3 text-center">
                                <i class="fas fa-money-bill-wave text-success fs-3 mb-2"></i>
                                <div class="text-secondary small">السعر الحالي</div>
                                <div class="fw-bold fs-4 text-primary">{{ number_format($auction->starting_price, 0) }}</div>
                                <small class="text-secondary">د.ع</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white border rounded-3 p-3 text-center">
                                <i class="fas fa-users text-primary fs-3 mb-2"></i>
                                <div class="text-secondary small">المزايدات</div>
                                <div class="fw-bold fs-4 text-primary">{{ $auction->bidders_count ?? 0 }}</div>
                                <small class="text-secondary">مزايدة</small>
                            </div>
                        </div>
                    </div>

                    <!-- الوقت المتبقي -->
                    @if($auction->status === 'active' && $auction->end_at)
                    <div class="bg-light p-3 rounded-3 mb-3 d-flex align-items-center gap-2 flex-wrap">
                        <i class="fas fa-hourglass-half text-warning"></i>
                        <span>الوقت المتبقي:</span>
                        <strong class="text-primary">{{ $auction->end_at->diffForHumans() }}</strong>
                    </div>
                    @endif

                    <!-- زر المزايدة -->
                    @auth
                        @if($auction->status === 'active')
                        <a href="{{ route('auction.bid', $auction->id) }}" class="btn btn-primary w-100 py-3 rounded-3">
                            <i class="fas fa-gavel me-2"></i>
                            دخول المزاد والمزايدة
                            <i class="fas fa-arrow-left ms-2"></i>
                        </a>
                        @else
                        <div class="alert alert-warning py-3 mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            هذا المزاد غير متاح حالياً
                        </div>
                        @endif
                    @else
                        <div class="alert alert-info py-3 mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            يرجى <a href="#" id="openLoginBtn" class="fw-bold text-decoration-underline">تسجيل الدخول</a> للمزايدة
                        </div>
                    @endauth

                    <!-- مميزات -->
                    <div class="d-flex justify-content-between mt-4 pt-3 border-top flex-wrap gap-2">
                        <span class="small text-secondary"><i class="fas fa-shield-alt text-primary me-1"></i> مزايدة آمنة</span>
                        <span class="small text-secondary"><i class="fas fa-clock text-primary me-1"></i> تحديث فوري</span>
                        <span class="small text-secondary"><i class="fab fa-whatsapp text-primary me-1"></i> إشعار واتساب</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- سكريبت فتح المودال -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const openLoginBtn = document.getElementById('openLoginBtn');
    if (openLoginBtn) {
        openLoginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const modal = document.getElementById('loginModal');
            if (modal) modal.classList.add('active');
        });
    }
});
</script>
@endsection
