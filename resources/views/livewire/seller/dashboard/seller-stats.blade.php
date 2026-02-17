
<style>
/* ========== بطاقات إحصائيات خارقة ========== */
.stat-card {
    position: relative;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 32px;
    box-shadow: var(--card-shadow), 0 0 30px rgba(15, 59, 94, 0.1);
    transition: all 0.4s cubic-bezier(0.2, 0.9, 0.3, 1.1);
    padding: 1.8rem 1.5rem;
    overflow: hidden;
    z-index: 1;
}

/* طبقة خلفية متوهجة */
.stat-card::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(145deg, var(--primary-light), var(--secondary-light), #a0c8ff);
    border-radius: 34px;
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: -2;
}

.stat-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    border-radius: 32px;
    z-index: -1;
}

/* تأثير hover الخارق */
.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 30px 50px -15px rgba(15, 59, 94, 0.4), 0 0 0 2px rgba(255,255,255,0.5);
    border-color: transparent;
}

.stat-card:hover::before {
    opacity: 1;
    animation: borderGlow 2s linear infinite;
}

@keyframes borderGlow {
    0% { filter: blur(4px); }
    50% { filter: blur(6px); }
    100% { filter: blur(4px); }
}

/* الأيقونة بتأثير سحري */
.stat-card i {
    font-size: 3rem;
    margin-bottom: 1rem;
    transition: all 0.4s ease;
    filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1));
}

.stat-card:hover i {
    transform: scale(1.1) rotate(5deg);
    filter: drop-shadow(0 8px 20px currentColor);
}

/* النص الثانوي */
.stat-card .text-muted {
    color: #2c3e50 !important;
    font-weight: 700;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    position: relative;
    display: inline-block;
    padding-bottom: 8px;
}

.stat-card .text-muted::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 25%;
    width: 50%;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--primary), var(--secondary), transparent);
    border-radius: 2px;
    transition: width 0.3s;
}

.stat-card:hover .text-muted::after {
    width: 70%;
    left: 15%;
}

/* الرقم الرئيسي */
.stat-card h3 {
    font-weight: 900;
    background: linear-gradient(145deg, var(--primary), var(--secondary), #4a7daa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-top: 0.8rem;
    font-size: 2.4rem;
    transition: all 0.3s;
    text-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.stat-card:hover h3 {
    transform: scale(1.05);
    letter-spacing: 1px;
}

/* ألوان الأيقونات مع توهج مخصص */
.text-primary {
    color: var(--primary) !important;
}
.text-success {
    color: #2ecc71 !important;
}
.text-warning {
    color: #f39c12 !important;
}
.text-danger {
    color: #ff4d4d !important;
}

/* جسيمات متحركة */
@keyframes particleMove {
    0% { transform: translate(0,0) scale(1); opacity: 0.3; }
    100% { transform: translate(20px, -20px) scale(1.5); opacity: 0; }
}

.stat-card .particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: white;
    border-radius: 50%;
    pointer-events: none;
    opacity: 0;
}

.stat-card:hover .particle {
    animation: particleMove 1s ease-out forwards;
}
</style>
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
