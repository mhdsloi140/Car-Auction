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
.text-info {
    color: var(--primary-light) !important;
}
.text-danger {
    color: #ff4d4d !important;
}
.text-success {
    color: #2ecc71 !important;
}
.text-secondary {
    color: #7f8c8d !important;
}

/* تأثيرات جسيمات صغيرة خلف الكارد */
.stat-card {
    &::after {
        background: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.6) 80%);
    }
}

/* جسيمات متحركة (اختياري) */
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

<!-- أضف هذا العنصر داخل كل كارد إذا أردت تأثير الجسيمات (اختياري) -->
<!-- <div class="particle" style="top:10%; left:20%;"></div> -->
<!-- يمكنك إضافته يدويًا لكل كارد أو توليده بالجافاسكربت -->

<div class="row g-4" wire:poll.5s>

    {{-- مزادات نشطة بدون مزايدات --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm text-center p-4 border-0">
            <i class="fas fa-envelope-open fa-2x mb-2 text-info"></i>
            <h6 class="text-muted">مزادات نشطة بدون مزايدات</h6>
            <h3 class="fw-bold">{{ $activeWithoutBids }}</h3>
            <div class="particle" style="top:15%; left:10%;"></div>
            <div class="particle" style="top:70%; right:20%;"></div>
        </div>
    </div>

    {{-- مزادات انتهت بدون فائز --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm text-center p-4 border-0">
            <i class="fas fa-exclamation-triangle fa-2x mb-2 text-danger"></i>
            <h6 class="text-muted">مزادات انتهت بدون فائز</h6>
            <h3 class="fw-bold">{{ $endedNoWinner }}</h3>
            <div class="particle" style="top:30%; left:80%;"></div>
        </div>
    </div>

    {{-- مزادات نشطة بمزايدات --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm text-center p-4 border-0">
            <i class="fas fa-gavel fa-2x mb-2 text-success"></i>
            <h6 class="text-muted">مزادات نشطة بمزايدات</h6>
            <h3 class="fw-bold">{{ $activeWithBids }}</h3>
            <div class="particle" style="top:50%; left:50%;"></div>
        </div>
    </div>

    {{-- مزادات مرفوضة اليوم --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm text-center p-4 border-0">
            <i class="fas fa-times-circle fa-2x mb-2 text-secondary"></i>
            <h6 class="text-muted">مزادات مرفوضة اليوم</h6>
            <h3 class="fw-bold">{{ $rejectedToday }}</h3>
            <div class="particle" style="top:80%; left:30%;"></div>
        </div>
    </div>

</div>
