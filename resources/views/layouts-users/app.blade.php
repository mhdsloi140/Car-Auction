<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سَيِّر SIR | منصة المزادات الرقمية الأقوى</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

      <link rel="stylesheet" href="{{ asset('users/css/app.css  ') }}" />
    @livewireStyles
</head>

<body>

    <!-- خلفية -->
    <div class="bg-pattern">
        <svg viewBox="0 0 1000 1000" preserveAspectRatio="none">
            <defs>
                <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#e0edff" stop-opacity="0.3" />
                    <stop offset="100%" stop-color="#c0d8ff" stop-opacity="0.3" />
                </linearGradient>
            </defs>
            <rect width="100%" height="100%" fill="url(#grad)" />
        </svg>
    </div>

    <!-- الهيدر -->
<header class="header">
    <div class="header-container">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-gavel"></i>
            </div>
            <div class="logo-text">
                <h1>سَيِّر <span>SIR</span></h1>
                <p>منصة المزادات الرقمية</p>
            </div>
        </div>

        {{-- زر تسجيل الدخول أو تسجيل الخروج --}}
        @guest
            <button class="login-btn" id="openLoginBtn">
                <i class="fas fa-user-circle"></i>
                تسجيل الدخول
            </button>
        @endguest

        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    تسجيل الخروج
                </button>
            </form>
        @endauth
    </div>
</header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-grid">
                <div>
                    <h1 class="hero-title">
                        منصة <span class="gradient-text">سَيِّر</span> <br>
                        <span class="highlight">المزادات الرقمية</span> <br>
                        الأوقوى
                    </h1>
                    <p class="hero-description">
                        منصة متكاملة لمزادات السيارات الإلكترونية بتقنية المزايدة الفورية.
                        شفافية كاملة، توثيق آمن، وحرية القرار للبائع.
                    </p>

                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">+15,000</div>
                            <div class="stat-label">سيارة مباعة</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">+28,000</div>
                            <div class="stat-label">مستخدم نشط</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">24 ساعة</div>
                            <div class="stat-label">مدة المزاد</div>
                        </div>
                    </div>

                    <button class="cta-button" onclick="openModal()" style="padding: 14px 40px; font-size: 18px;">
                        <i class="fas fa-user-plus"></i>
                        ابدأ الآن مجاناً
                    </button>
                </div>

                <div class="hero-image">
                    <i class="fas fa-car"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم التعريف المتكامل -->
    <section class="about">
        <div class="about-container">
            <div class="section-title">
                <h2>ما هي منصة سَيِّر؟</h2>
                <p>أول منصة متخصصة في مزادات السيارات الإلكترونية بمعايير عالمية</p>
            </div>

            <div class="about-grid">
                <div class="about-content">
                    <h3>مزادات الكترونية بكل شفافية</h3>
                    <p>
                        سَيِّر ليست مجرد منصة مزادات عادية، بل هي نقلة نوعية في عالم تجارة السيارات.
                        نوفر بيئة مزايدة إلكترونية متكاملة تجمع بين البائعين والمشترين في آنٍ واحد،
                        مع ضمان أعلى درجات الشفافية والأمان.
                    </p>

                    <ul class="features-list">
                        <li><i class="fas fa-check-circle"></i> توثيق المستخدمين عبر أحدث الطرق لأقصى درجات الأمان</li>
                        <li><i class="fas fa-check-circle"></i> مزادات زمنية 24 ساعة قابلة للتمديد</li>
                        <li><i class="fas fa-check-circle"></i> إشعارات فورية عبر واتساب للمزايدات</li>
                        <li><i class="fas fa-check-circle"></i> البائع يملك حرية قبول أو رفض العرض النهائي</li>
                        <li><i class="fas fa-check-circle"></i> تقارير فنية شاملة لكل سيارة</li>
                    </ul>

                    <div class="stats-mini">
                        <div class="stat-mini-item">
                            <div class="stat-mini-number">+500</div>
                            <div class="stat-mini-label">مزاد شهري</div>
                        </div>
                        <div class="stat-mini-item">
                            <div class="stat-mini-number">24/7</div>
                            <div class="stat-mini-label">دعم فني</div>
                        </div>
                        <div class="stat-mini-item">
                            <div class="stat-mini-number">100%</div>
                            <div class="stat-mini-label">شفافية</div>
                        </div>
                    </div>
                </div>

                <div class="about-image">
                    <i class="fas fa-chart-line"></i>
                    <h4>نظام مزادات متطور</h4>
                    <p>تقنية المزايدة الفورية (Real-time Bidding) مع عداد زمني مرئي وتحديث لحظي للأسعار</p>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم المميزات -->
    <section class="features">
        <div class="features-container">
            <div class="section-title">
                <h2>مميزات المنصة</h2>
                <p>كل ما تحتاجه في مكان واحد لتجربة مزادات استثنائية</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>أمان وتوثيق</h3>
                    <p>توثيق المستخدمين عبر OTP وحماية متقدمة ضد التلاعب بالمزايدات وفق أعلى المعايير</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>مزايدة فورية</h3>
                    <p>تحديث مباشر للمزايدات مع عرض فوري للسعر والوقت المتبقي بدون أي تأخير</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h3>إشعارات واتساب</h3>
                    <p>تنبيهات فورية عبر الواتساب عند تجاوز المزايدة أو الفوز بالمزاد</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>عداد زمني مرئي</h3>
                    <p>مدة مزاد ثابتة 24 ساعة مع عداد زمني واضح لكل سيارة</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3>صلاحيات متكاملة</h3>
                    <p>نظام متكامل للمستخدمين (بائع - مشتري - إدارة) مع تحكم كامل</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3>تقارير وإحصائيات</h3>
                    <p>تحليلات دقيقة عن عدد السيارات، متوسط الأسعار، ونشاط المستخدمين</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="cta-container">
            <h2>انضم إلى منصة سَيِّر الآن</h2>
            <p>توثيق اّمن - مزادات شفافة - حرية القرار للبائع</p>

        </div>
    </section>

    <!-- مودال تسجيل الدخول - فقط رقم الجوال -->


    @yield(section: 'content')
    @livewire('user.login')

    @livewireScripts
<script>
document.addEventListener("DOMContentLoaded", function () {
    const openBtn = document.getElementById('openLoginBtn');
    if (openBtn) {
        openBtn.addEventListener('click', function () {
            const modal = document.getElementById('loginModal');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    // إغلاق المودال عند الضغط على زر الإغلاق
    const closeBtn = document.querySelector('.modal-close');
    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            const modal = document.getElementById('loginModal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
    }
});
</script>
</body>

</html>
