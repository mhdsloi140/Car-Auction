@extends('layouts-users.app')

@section('title', 'تفاصيل المزاد')

@section('content')
<div class="auction-detail-modern">
    <div class="container py-5">
        <!-- زر العودة الى الصفحة الرئيسية -->
        <div class="mb-4">
            <a href="{{ route('home') }}" class="btn-back-home">
                <i class="fas fa-arrow-right me-2"></i>
                <span>العودة إلى الصفحة الرئيسية</span>
            </a>
        </div>

        <!-- مسار التنقل الحديث -->
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb modern-breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/" class="breadcrumb-link">
                        <i class="fas fa-home"></i>
                        <span class="ms-2 d-none d-sm-inline">الرئيسية</span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" class="breadcrumb-link">
                        <i class="fas fa-gavel"></i>
                        <span class="ms-2 d-none d-sm-inline">المزادات</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-file-alt"></i>
                    <span class="ms-2">تفاصيل المزاد</span>
                </li>
            </ol>
        </nav>

        <div class="row g-5 align-items-stretch">
            <!-- عمود الصور -->
            <div class="col-lg-6">
                @php $images = $auction->car->getMedia('cars'); @endphp

                @if($images->count() > 0)
                <!-- السلايدر الرئيسي -->
                <div id="carImagesSlider" class="carousel slide rounded-5 mb-4 shadow-modern" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-5 overflow-hidden">
                        @foreach($images as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ $image->getUrl() }}" class="d-block w-100" alt="سيارة"
                                style="height: 480px; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carImagesSlider"
                        data-bs-slide="prev">

                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carImagesSlider"
                        data-bs-slide="next">

                        <span class="carousel-control-next-icon"></span>
                    </button>

                </div>

                <!-- المصغرات -->
                <div class="d-flex gap-3 flex-wrap justify-content-center">
                    @foreach($images as $index => $image)
                    <img src="{{ $image->getUrl() }}"
                        onclick="bootstrap.Carousel.getInstance(document.getElementById('carImagesSlider')).to({{ $index }})"
                        class="thumbnail-modern" style="width: 110px; height: 85px; object-fit: cover;">
                    @endforeach
                </div>
                @else
                <div class="placeholder-image rounded-5 shadow-modern">
                    <img src="{{ asset('users/img/no-image.png') }}" class="img-fluid w-100 h-100"
                        style="object-fit: cover;" alt="لا توجد صور">
                </div>
                @endif
            </div>

            <!-- عمود المعلومات -->
            <div class="col-lg-6">
                <div class="info-card-modern p-4 p-xl-5 rounded-5">
                    <!-- العنوان والشارة -->
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                        <h2 class="fw-bold display-6 mb-0 text-dark-blue">
                            {{ $auction->car->brand->name }} {{ $auction->car->model->name }}
                            <span class="year-badge-modern">{{ $auction->car->year }}</span>
                        </h2>
                        <span class="status-badge-modern {{ $auction->status === 'active' ? 'live' : 'ended' }}">
                            <span class="status-dot-modern"></span>
                            {{ $auction->status === 'active' ? 'مزاد مباشر' : 'مزاد منتهي' }}
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-3 text-secondary mb-4 id-wrapper-modern">
                        <i class="fas fa-qrcode fs-4 text-primary-blue"></i>
                        <span class="fs-5">رقم المزاد: <strong class="text-primary-blue">#{{ $auction->id
                                }}</strong></span>
                    </div>

                    <!-- المواصفات -->
                    <div class="specs-modern p-4 rounded-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="fas fa-file-alt fs-2 text-primary-blue"></i>
                            <h4 class="fw-bold mb-0 text-dark-blue">المواصفات</h4>
                        </div>
                        @if($auction->car->specs)
                        <p class="mb-3 text-gray-700">{{ $auction->car->specs_label }}</p>
                        @endif
                        @if($auction->car->description)
                        <p class="text-gray-600 mb-0">{{ $auction->car->description }}</p>
                        @endif
                        @if(!$auction->car->specs && !$auction->car->description)
                        <p class="text-gray-500 mb-0">لا توجد مواصفات مضافة</p>
                        @endif

                    </div>
         @if($auction->car->report_pdf)
    <div class="mt-4">

        {{-- زر العرض --}}
        <a href="{{ asset('storage/' . $auction->car->report_pdf) }}"
           class="btn-bid-modern w-100 mb-2"
           target="_blank">
            <i class="fas fa-eye me-2"></i>
            <span>عرض كشف السيارة</span>
            <i class="fas fa-external-link-alt ms-2"></i>
        </a>

        {{-- زر التحميل (كما هو) --}}
        <a href="{{ asset('storage/' . $auction->car->report_pdf) }}"
           class="btn-bid-modern w-100"
           download>
            <i class="fas fa-file-pdf me-2"></i>
            <span>تحميل كشف السيارة</span>
            <i class="fas fa-download ms-2"></i>
        </a>

    </div>
@endif


                    <!-- كروت إحصائية -->
                    <div class="row g-4 mb-4" style="margin-top: 20px">
                        <div class="col-6">
                            <div class="stat-modern p-4 rounded-4 text-center">
                                <i class="fas fa-money-bill-wave fs-1 mb-2 text-success"></i>
                                <span class="d-block text-secondary small">السعر الحالي</span>
                                <span class="fw-bold display-6 text-primary-blue">{{
                                    number_format($auction->starting_price, 0) }}</span>
                                <span class="small text-secondary">د.ع</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-modern p-4 rounded-4 text-center">
                                <i class="fas fa-users fs-1 mb-2 text-primary-blue"></i>
                                <span class="d-block text-secondary small">عدد المزايدات</span>
                                <span class="fw-bold display-6 text-primary-blue">{{ $auction->bidders_count ?? 0
                                    }}</span>
                                <span class="small text-secondary">مزايدة</span>
                            </div>
                        </div>
                    </div>



                    <!-- زر المشاركة / التنبيهات -->
                    @auth
                    @if($auction->status === 'active')
                    <a href="{{ route('auction.bid', $auction->id) }}" class="btn-bid-modern w-100">
                        <i class="fas fa-hand-pointer me-2"></i>
                        <span>دخول المزاد والمزايدة</span>
                        <i class="fas fa-arrow-left ms-2"></i>
                    </a>
                    @else
                    <div class="alert-modern warning d-flex align-items-center gap-3">
                        <i class="fas fa-exclamation-triangle fs-4"></i>
                        <span>هذا المزاد غير متاح حالياً</span>
                    </div>
                    @endif
                    @else
                    <div class="alert-modern info d-flex align-items-center gap-3">
                        <i class="fas fa-info-circle fs-4"></i>
                        <span>يرجى <a href="#" id="openLoginBtn"
                                class="fw-bold text-decoration-underline text-primary-blue">تسجيل الدخول</a>
                            للمزايدة</span>
                    </div>
                    @endauth

                    <!-- ميزات إضافية -->
                    <div class="features-strip-modern mt-5">
                        <div class="feature-item-modern">
                            <i class="fas fa-shield-alt text-primary-blue"></i>
                            <span>مزايدة آمنة</span>
                        </div>
                        <div class="feature-item-modern">
                            <i class="fas fa-clock text-primary-blue"></i>
                            <span>تحديث فوري</span>
                        </div>
                        <div class="feature-item-modern">
                            <i class="fab fa-whatsapp text-primary-blue"></i>
                            <span>إشعار واتساب</span>
                        </div>
                        <div class="feature-item-modern">
                            <i class="fas fa-star text-primary-blue"></i>
                            <span>ضمان الجودة</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cairo:wght@300;400;500;600;700&display=swap');

    .auction-detail-modern {
        font-family: 'Inter', 'Cairo', sans-serif;
        background: linear-gradient(135deg, #f5f9ff 0%, #e8f0fe 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* زر العودة إلى الرئيسية */
    .btn-back-home {
        display: inline-flex;
        align-items: center;
        padding: 0.8rem 2rem;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(0, 76, 128, 0.2);
        border-radius: 50px;
        color: #004c80;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .btn-back-home:hover {
        background: white;
        border-color: #004c80;
        transform: translateX(-5px);
        box-shadow: 0 8px 25px rgba(0, 76, 128, 0.2);
        color: #002b44;
    }

    .btn-back-home i {
        font-size: 1rem;
        transition: transform 0.3s ease;
    }

    .btn-back-home:hover i {
        transform: translateX(-3px);
    }

    /* شريط التنقل الحديث */
    .modern-breadcrumb {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(8px);
        border-radius: 60px;
        padding: 0.7rem 2rem;
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        border: 1px solid rgba(0, 76, 128, 0.15);
        box-shadow: 0 8px 20px -6px rgba(0, 20, 40, 0.1);
    }

    .modern-breadcrumb .breadcrumb-item {
        display: flex;
        align-items: center;
        color: #1e293b;
        font-size: 1rem;
    }

    .modern-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        color: #004c80;
        font-size: 1.4rem;
        line-height: 1;
        opacity: 0.8;
        margin: 0 0.5rem;
    }

    .breadcrumb-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #004c80;
        padding: 0.3rem 1.2rem;
        border-radius: 40px;
        transition: all 0.2s;
        font-weight: 500;
    }

    .breadcrumb-link:hover {
        background: rgba(0, 76, 128, 0.1);
        color: #002b44;
    }

    .modern-breadcrumb .breadcrumb-item.active {
        display: flex;
        align-items: center;
        color: #002b44;
        background: rgba(0, 76, 128, 0.1);
        padding: 0.3rem 1.5rem;
        border-radius: 40px;
        font-weight: 700;
        border: 1px solid rgba(0, 76, 128, 0.3);
    }

    /* الألوان الأساسية */
    .text-primary-blue {
        color: #004c80 !important;
    }

    .text-dark-blue {
        color: #0a2540 !important;
    }

    .text-secondary {
        color: #64748b !important;
    }

    .text-gray-700 {
        color: #334155;
    }

    .text-gray-600 {
        color: #475569;
    }

    .text-gray-500 {
        color: #64748b;
    }

    /* الظل الحديث */
    .shadow-modern {
        box-shadow: 0 15px 30px -10px rgba(0, 40, 80, 0.15);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .shadow-modern:hover {
        box-shadow: 0 25px 50px -12px rgba(0, 76, 128, 0.25);
    }

    /* أزرار التحكم في السلايدر */
    .control-icon-modern {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        padding: 15px;
        width: 45px;
        height: 45px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* المصغرات */
    .thumbnail-modern {
        border-radius: 20px;
        border: 2px solid transparent;
        transition: all 0.3s;
        box-shadow: 0 10px 20px -8px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .thumbnail-modern:hover {
        transform: scale(1.1) rotate(1deg);
        border-color: #004c80;
        box-shadow: 0 15px 30px -10px #004c80;
        cursor: pointer;
    }

    /* بطاقة المعلومات */
    .info-card-modern {
        background: white;
        border: 1px solid rgba(0, 76, 128, 0.1);
        box-shadow: 0 20px 40px -12px rgba(0, 40, 80, 0.2);
        transition: all 0.2s;
    }

    .info-card-modern:hover {
        box-shadow: 0 30px 60px -15px rgba(0, 76, 128, 0.3);
    }

    /* شارة السنة */
    .year-badge-modern {
        display: inline-block;
        background: rgba(0, 76, 128, 0.1);
        padding: 5px 18px;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 600;
        color: #004c80;
        border: 1px solid rgba(0, 76, 128, 0.2);
        margin-right: 10px;
    }

    /* شارة الحالة */
    .status-badge-modern {
        padding: 8px 22px;
        border-radius: 60px;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        border: 1px solid #cbd5e1;
        color: #334155;
    }

    .status-badge-modern.live {
        background: rgba(0, 76, 128, 0.1);
        border-color: #004c80;
        color: #004c80;
    }

    .status-badge-modern.ended {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #475569;
    }

    .status-dot-modern {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        background: #004c80;
    }

    .status-badge-modern.ended .status-dot-modern {
        background: #94a3b8;
    }

    /* معرف المزاد */
    .id-wrapper-modern {
        background: #f8fafd;
        padding: 10px 20px;
        border-radius: 60px;
        border: 1px solid #e2e8f0;
    }

    /* المواصفات */
    .specs-modern {
        background: #f8fafd;
        border: 1px solid #e2e8f0;
        border-right: 5px solid #004c80;
        border-radius: 24px;
    }

    /* كروت الإحصائيات */
    .stat-modern {
        background: white;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .stat-modern:hover {
        transform: translateY(-5px);
        border-color: #004c80;
        box-shadow: 0 20px 30px -15px rgba(0, 76, 128, 0.2);
    }

    /* زر المزايدة */
    .btn-bid-modern {
        background: #004c80;
        border: none;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        padding: 1rem 2rem;
        border-radius: 60px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 10px 20px -5px #004c80;
    }

    .btn-bid-modern:hover {
        background: #002b44;
        transform: translateY(-3px);
        box-shadow: 0 20px 30px -8px #004c80;
        color: white;
    }

    /* التنبيهات */
    .alert-modern {
        padding: 1rem 1.5rem;
        border-radius: 60px;
        background: #f8fafd;
        border: 1px solid #e2e8f0;
        color: #334155;
    }

    .alert-modern.warning {
        background: #fff3cd;
        border-color: #ffeeba;
        color: #856404;
    }

    .alert-modern.info {
        background: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
    }

    .alert-modern a {
        color: #004c80;
    }

    /* شريط الميزات */
    .features-strip-modern {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
        border-top: 1px solid #e2e8f0;
        padding-top: 2rem;
    }

    .feature-item-modern {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #475569;
        font-size: 0.95rem;
        padding: 0.5rem 1.2rem;
        border-radius: 40px;
        background: #f8fafd;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .feature-item-modern:hover {
        background: white;
        border-color: #004c80;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px -5px rgba(0, 76, 128, 0.2);
    }

    .feature-item-modern i {
        font-size: 1.2rem;
    }

    /* تحسينات الجوال */
    @media (max-width: 768px) {
        .info-card-modern {
            padding: 1.5rem !important;
        }

        .thumbnail-modern {
            width: 80px;
            height: 65px;
        }

        .btn-bid-modern {
            font-size: 1rem;
            padding: 0.8rem 1.5rem;
        }

        .features-strip-modern {
            gap: 1rem;
        }

        .modern-breadcrumb {
            padding: 0.5rem 1.2rem;
            gap: 0.3rem;
        }

        .breadcrumb-link,
        .modern-breadcrumb .breadcrumb-item.active {
            padding: 0.2rem 0.8rem;
        }

        .btn-back-home {
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
        }
    }
</style>

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
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var myCarousel = document.querySelector('#carImagesSlider');
    if (myCarousel) {
        new bootstrap.Carousel(myCarousel, {
            interval: false,
            ride: false
        });
    }
});
</script>


<!-- AOS (اختياري) -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>

@endsection
