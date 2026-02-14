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

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: linear-gradient(145deg, #f8faff 0%, #f0f5fd 100%);
            min-height: 100vh;
            color: #0b1e3a;
        }

        /* أنيميشن الخلفية */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.4;
            pointer-events: none;
        }

        .bg-pattern svg {
            width: 100%;
            height: 100%;
        }

        /* الهيدر */
        .header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(30, 60, 114, 0.1);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* اللوغو */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #0b2545, #1e3c72);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 25px -10px #1e3c72;
            position: relative;
            overflow: hidden;
        }

        .logo-icon::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            animation: shine 4s infinite;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            20%,
            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        .logo-icon i {
            font-size: 26px;
            color: white;
            position: relative;
            z-index: 1;
        }

        .logo-text {
            line-height: 1.3;
        }

        .logo-text h1 {
            font-size: 28px;
            font-weight: 900;
            color: #0b2545;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .logo-text h1 span {
            color: #1e3c72;
            font-weight: 700;
            background: linear-gradient(145deg, #1e3c72, #2a5298);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logo-text p {
            color: #5a6f8d;
            font-size: 13px;
            font-weight: 500;
            margin: 0;
        }

        /* زر تسجيل الدخول */
        .login-btn {
            background: white;
            color: #1e3c72;
            border: 2px solid #e2eaf2;
            padding: 12px 35px;
            border-radius: 60px;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
        }

        .login-btn:hover {
            background: #1e3c72;
            border-color: #1e3c72;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -10px #1e3c72;
        }

        .login-btn i {
            font-size: 18px;
        }

        /* Hero Section الرئيسي */
        .hero {
            padding: 80px 0 60px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .hero-container {
            padding: 0 25px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 50px;
            align-items: center;
        }

        .hero-title {
            font-size: 58px;
            font-weight: 900;
            line-height: 1.2;
            color: #0b1e3a;
            margin-bottom: 20px;
        }

        .hero-title .gradient-text {
            background: linear-gradient(135deg, #1e3c72, #2a5c9a, #3a7bb5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
        }

        .hero-title .highlight {
            position: relative;
            display: inline-block;
        }

        .hero-title .highlight::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, #ffd700, #ffb347);
            opacity: 0.3;
            border-radius: 10px;
            z-index: -1;
        }

        .hero-description {
            font-size: 18px;
            color: #475569;
            line-height: 1.8;
            margin-bottom: 30px;
            max-width: 550px;
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin: 40px 0 30px;
        }

        .stat-item {
            text-align: right;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 900;
            color: #1e3c72;
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #5f7d9c;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .hero-image {
            background: linear-gradient(145deg, #dbe6f5, #c2d6ed);
            border-radius: 40px;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 30px 50px -20px #1e3c72;
        }

        .hero-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.3), transparent);
        }

        .hero-image i {
            font-size: 250px;
            color: #ffffff;
            filter: drop-shadow(0 20px 20px rgba(30, 60, 114, 0.3));
            animation: floatCar 6s infinite ease-in-out;
        }

        @keyframes floatCar {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(2deg);
            }
        }

        /* قسم التعريف المفصل */
        .about {
            padding: 80px 0;
            max-width: 1300px;
            margin: 0 auto;
        }

        .about-container {
            padding: 0 25px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 45px;
            font-weight: 900;
            color: #0b1e3a;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            border-radius: 2px;
        }

        .section-title p {
            color: #5f7d9c;
            font-size: 18px;
            max-width: 700px;
            margin: 0 auto;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-content h3 {
            font-size: 32px;
            font-weight: 800;
            color: #0b1e3a;
            margin-bottom: 25px;
        }

        .about-content p {
            color: #334155;
            font-size: 17px;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .features-list {
            list-style: none;
            padding: 0;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 17px;
            color: #1e293b;
            font-weight: 500;
        }

        .features-list li i {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #e0f0ff, #c8e0ff);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e3c72;
            font-size: 16px;
        }

        .stats-mini {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 40px;
        }

        .stat-mini-item {
            background: white;
            border-radius: 20px;
            padding: 20px 15px;
            text-align: center;
            box-shadow: 0 10px 30px -15px #1e3c72;
            border: 1px solid #eef5ff;
        }

        .stat-mini-number {
            font-size: 28px;
            font-weight: 900;
            color: #1e3c72;
            margin-bottom: 5px;
        }

        .stat-mini-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
        }

        .about-image {
            background: linear-gradient(145deg, #1e3c72, #2a5298);
            border-radius: 40px;
            padding: 50px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 30px 50px -20px #1e3c72;
        }

        .about-image i {
            font-size: 120px;
            color: rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
        }

        .about-image h4 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .about-image p {
            color: #e0edff;
            font-size: 16px;
            line-height: 1.7;
            max-width: 300px;
            margin: 0 auto;
        }

        /* قسم المميزات */
        .features {
            padding: 80px 0;
            background: white;
            border-radius: 60px 60px 0 0;
            margin-top: 40px;
        }

        .features-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 25px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 50px;
        }

        .feature-card {
            background: #f8fcff;
            border-radius: 30px;
            padding: 40px 30px;
            border: 1px solid #e8f0fe;
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px -15px #1e3c72;
            border-color: transparent;
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            margin-bottom: 25px;
        }

        .feature-card h3 {
            font-size: 24px;
            font-weight: 800;
            color: #0b1e3a;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #5f7d9c;
            line-height: 1.7;
        }

        /* Call to Action */
        .cta {
            padding: 80px 0;
            text-align: center;
            max-width: 1300px;
            margin: 0 auto;
        }

        .cta h2 {
            font-size: 48px;
            font-weight: 900;
            color: #0b1e3a;
            margin-bottom: 15px;
        }

        .cta p {
            color: #5f7d9c;
            font-size: 18px;
            margin-bottom: 35px;
        }

        .cta-button {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            padding: 18px 50px;
            border-radius: 60px;
            font-size: 20px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 20px 40px -15px #1e3c72;
        }

        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -15px #1e3c72;
        }

        /* مودال تسجيل الدخول - فقط رقم الجوال */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(11, 30, 58, 0.8);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .modal.active {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background: white;
            border-radius: 50px;
            padding: 50px 45px;
            max-width: 480px;
            width: 92%;
            position: relative;
            transform: scale(0.9) translateY(30px);
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.3);
        }

        .modal.active .modal-content {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #f1f5f9;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .modal-close:hover {
            background: #1e3c72;
            color: white;
            transform: rotate(90deg);
        }

        .modal-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .modal-logo i {
            font-size: 65px;
            color: #1e3c72;
            opacity: 0.8;
        }

        .modal h3 {
            font-size: 32px;
            font-weight: 900;
            color: #0b1e3a;
            margin-bottom: 8px;
            text-align: center;
        }

        .modal p {
            color: #64748b;
            text-align: center;
            margin-bottom: 35px;
            font-size: 16px;
        }

        /* حقل رقم الجوال فقط */
        .phone-field {
            margin-bottom: 25px;
        }

        .phone-label {
            display: block;
            margin-bottom: 10px;
            color: #334155;
            font-weight: 600;
            font-size: 15px;
        }

        .phone-input-group {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 60px;
            overflow: hidden;
            transition: all 0.3s;
            direction: ltr;
        }

        .phone-input-group:focus-within {
            border-color: #1e3c72;
            box-shadow: 0 0 0 4px rgba(30, 60, 114, 0.1);
            background: white;
        }

        .country-code {
            background: white;
            padding: 16px 20px;
            color: #1e3c72;
            font-weight: 700;
            font-size: 16px;
            border-left: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .phone-input {
            flex: 1;
            border: none;
            padding: 16px 15px;
            font-size: 16px;
            background: transparent;
            outline: none;
            text-align: left;
        }

        .phone-input::placeholder {
            color: #a0b3cc;
            font-weight: 400;
        }

        .send-code-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border: none;
            border-radius: 60px;
            color: white;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 15px 0 20px;
        }

        .send-code-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -10px #1e3c72;
        }

        .send-code-btn i {
            font-size: 18px;
        }

        .modal-footer {
            text-align: center;
            margin-top: 20px;
        }

        .modal-footer a {
            color: #1e3c72;
            font-weight: 700;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: border-color 0.3s;
        }

        .modal-footer a:hover {
            border-bottom-color: #1e3c72;
        }

        .modal-terms {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #94a3b8;
        }

        .modal-terms a {
            color: #1e3c72;
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .hero-grid {
                grid-template-columns: 1fr;
            }

            .hero-title {
                font-size: 42px;
            }

            .about-grid {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .features-grid {
                grid-template-columns: 1fr;
            }

            .hero-stats {
                flex-direction: column;
                gap: 20px;
            }

            .modal-content {
                padding: 40px 25px;
            }
            .send-code-btn {
    margin-top: 15px; 
}
        }
    </style>
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


    @yield('content')
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
