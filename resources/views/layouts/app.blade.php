<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ setting('site_name', 'سَيِّر SIR') }}</title>

    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

    <!-- Favicon -->
    <link rel="icon" href="{{ setting('site_logo') ?: asset('assets/img/kaiadmin/favicon.ico') }}"
        type="image/x-icon" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Google Fonts (Cairo) -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome 6 (Free CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- PWA Configuration -->
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#0ea5e9">
    <meta name="msapplication-navbutton-color" content="#0ea5e9">
    <meta name="apple-mobile-web-app-title" content="SIR Auctions">
    <meta name="application-name" content="SIR Auctions">
    <style>
        /* متغيرات الألوان - درجات الكحلي (الأزرق الداكن) */
        :root {
            --primary: #0f3b5e;
            /* كحلي غامق */
            --primary-light: #2b5e8c;
            /* أفتح */
            --primary-dark: #092235;
            /* أغمق */
            --secondary: #1f5a8e;
            /* درجة متوسطة من الكحلي */
            --secondary-light: #4a7daa;
            --secondary-dark: #0b3b5a;
            --bg-gradient: linear-gradient(145deg, #e0edff 0%, #c0d8ff 100%);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --card-shadow: 0 20px 35px -8px rgba(15, 59, 94, 0.15), 0 5px 12px -4px rgba(0, 0, 0, 0.05);
            --hover-shadow: 0 30px 45px -12px rgba(15, 59, 94, 0.25);
            --sidebar-width: 300px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            color: #1e293b;
        }

        /* خلفية متحركة */
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
            filter: blur(2px);
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
            backdrop-filter: blur(2px);
        }

        /* ========== سايدبار زجاجي ========== */
        .sidebar {
            width: var(--sidebar-width);
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-left: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 40px rgba(15, 59, 94, 0.1);
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            border-radius: 0 30px 30px 0;
        }

        .sidebar-logo {
            padding: 30px 20px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar-wrapper {
            padding: 20px 0 30px;
        }

        .nav-secondary {
            list-style: none;
            padding: 0 12px;
            margin: 0;
        }

        .nav-item {
            margin: 8px 0;
            border-radius: 18px;
            transition: all 0.3s;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            color: #1e293b;
            font-weight: 600;
            border-radius: 18px;
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .nav-link i {
            font-size: 1.5rem;
            margin-left: 16px;
            width: 30px;
            text-align: center;
            color: var(--primary);
            transition: all 0.3s;
        }

        .nav-link::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.6), transparent);
            transform: translateX(-100%);
            transition: 0.5s;
        }

        .nav-link:hover::before {
            transform: translateX(100%);
        }

        .nav-link:hover {
            background: white;
            box-shadow: 0 10px 25px -8px rgba(0, 0, 0, 0.1);
        }

        .nav-link:hover i {
            transform: scale(1.1) rotate(5deg);
        }

        /* العنصر النشط - تدرج كحلي */
        .nav-item.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            box-shadow: 0 15px 25px -8px rgba(15, 59, 94, 0.3);
        }

        .nav-item.active .nav-link {
            color: white;
        }

        .nav-item.active .nav-link i {
            color: white;
        }

        /* قسم الخروج */
        .logout-btn {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px dashed rgba(0, 0, 0, 0.1);
        }

        .logout-btn .nav-link {
            color: #dc2626;
        }

        .logout-btn .nav-link i {
            color: #dc2626;
        }

        /* ========== المين بانل ========== */
        .main-panel {
            flex: 1;
            margin-right: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            padding: 30px 35px;
            transition: margin-right 0.4s;
        }

        /* ========== هيدر زجاجي ========== */
        .main-header {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 28px;
            padding: 16px 30px;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px -15px rgba(15, 59, 94, 0.2);
        }

        /* زر القائمة (هامبورجر) - يظهر فقط في الشاشات الصغيرة */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 2rem;
            color: var(--primary);
            cursor: pointer;
            margin-left: 15px;
            transition: transform 0.2s;
        }

        .menu-toggle:hover {
            transform: scale(1.1);
        }

        .site-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            box-shadow: 0 10px 20px -5px rgba(15, 59, 94, 0.3);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-text h2 {
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1.2;
            margin: 0;
            background: linear-gradient(145deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-text span {
            font-size: 0.8rem;
            color: #5b687b;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* مؤشر الإشعارات */
        .notifications-badge {
            position: relative;
        }

        .notifications-badge .badge {
            position: absolute;
            top: -8px;
            left: -8px;
            background: #dc2626;
            color: white;
            border-radius: 50px;
            padding: 4px 8px;
            font-size: 0.7rem;
            font-weight: 700;
            border: 2px solid white;
        }

        /* بروفايل المستخدم */
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(8px);
            padding: 8px 20px 8px 15px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-dropdown:hover {
            transform: translateY(-2px);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            background: linear-gradient(145deg, var(--primary-light), var(--secondary-light));
            border-radius: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .user-info {
            line-height: 1.3;
            color: black;
        }

        .user-greeting {
            font-size: 0.8rem;
            color: rgba(0, 0, 0, 0.7);
        }

        .user-name {
            font-weight: 700;
            color: black;
        }

        /* ========== المحتوى الرئيسي ========== */
        .main-content {
            background: transparent;
            min-height: calc(100vh - 200px);
        }

        /* ========== فوتر أنيق ========== */
        .footer {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(8px);
            border-radius: 28px;
            padding: 18px 30px;
            margin-top: 40px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: #475569;
            font-weight: 500;
        }

        .footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            transition: 0.2s;
        }

        .footer a:hover {
            color: var(--secondary);
        }

        /* نص متدرج بتدرجات الكحلي */
        .gradient-text {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ========== تحسينات التجاوب ========== */
        @media (max-width: 1200px) {
            :root {
                --sidebar-width: 280px;
            }

            .brand-text h2 {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 992px) {
            .menu-toggle {
                display: block;
                /* إظهار زر القائمة */
            }

            .sidebar {
                right: -100%;
                border-radius: 0;
                transition: right 0.4s ease;
            }

            .sidebar.show {
                right: 0;
            }

            .main-panel {
                margin-right: 0;
                width: 100%;
                padding: 20px;
            }

            .main-header {
                padding: 12px 20px;
            }

            .brand-text h2 {
                font-size: 1.4rem;
            }

            .brand-text span {
                font-size: 0.7rem;
            }

            .header-actions {
                gap: 15px;
            }

            .user-dropdown {
                padding: 6px 15px 6px 10px;
            }
        }

        @media (max-width: 768px) {
            .main-panel {
                padding: 15px;
            }

            .main-header {
                padding: 10px 15px;
            }

            .brand-icon {
                width: 40px;
                height: 40px;
                font-size: 1.5rem;
            }

            .brand-text h2 {
                font-size: 1.2rem;
            }

            .brand-text span {
                display: none;
                /* إخفاء النص الفرعي لتوفير المساحة */
            }

            .header-actions {
                gap: 10px;
            }

            .user-avatar {
                width: 36px;
                height: 36px;
                font-size: 1rem;
            }

            .user-info {
                display: none;
                /* إخفاء الاسم والترحيب */
            }

            .footer {
                padding: 15px;
                font-size: 0.9rem;
                text-align: center;
            }

            .footer .d-flex {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .main-header {
                border-radius: 20px;
            }

            .menu-toggle {
                font-size: 1.8rem;
            }

            .brand-icon {
                width: 36px;
                height: 36px;
                font-size: 1.3rem;
            }

            .user-dropdown {
                padding: 4px 10px;
            }
        }

        /* تأثيرات إضافية */
        .animate-on-scroll {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* شريط التمرير */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.02);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* تراك خلفية السايدبار عند الفتح على الموبايل */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(3px);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>

    @livewireStyles
</head>

<body>

    <!-- خلفية pattern -->
    <div class="bg-pattern">
        <svg viewBox="0 0 1000 1000" preserveAspectRatio="none">
            <defs>
                <linearGradient id="glassGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#e0edff" stop-opacity="0.3" />
                    <stop offset="100%" stop-color="#c0d8ff" stop-opacity="0.3" />
                </linearGradient>
                <pattern id="pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                    <circle cx="20" cy="20" r="1.5" fill="#0f3b5e" opacity="0.1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#glassGrad)" />
            <rect width="100%" height="100%" fill="url(#pattern)" />
        </svg>
    </div>

    <div class="wrapper">

        <!-- طبقة خلفية تغطي الشاشة عند فتح السايدبار على الموبايل -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- سايدبار (بدون الأيقونات العلوية) -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <div class="logo-header">
                    <!-- تمت إزالة الأزرار بالكامل، يمكنك إضافة أي محتوى آخر هنا -->
                </div>
            </div>

            <div class="sidebar-wrapper">
                <div class="sidebar-content">
                    <ul class="nav-secondary">

                        <!-- Dashboard -->
                        @role('admin')
                        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="fa-solid fa-table-cells"></i>
                                <span>الصفحة الرئيسية</span>
                            </a>
                        </li>
                        @endrole


                        <!-- Seller: Auctions -->
                        @role('seller')
                        <li class="nav-item {{ request()->routeIs('auction.index') ? 'active' : '' }}">
                            <a href="{{ route('auction.index') }}" class="nav-link">
                                <i class="fa-solid fa-gavel"></i>
                                <span>بيع سيارة</span>
                            </a>
                        </li>


                        @endrole

                        <!-- Admin: Auctions & Settings -->
                        @role('admin')

                        <li class="nav-item {{ request()->routeIs('admin.auction.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.auction.index') }}" class="nav-link">
                                <i class="fa-solid fa-gavel"></i>
                                <span>إدارة المزادات</span>
                            </a>
                        </li>
                          <li class="nav-item {{ request()->routeIs('admin.auctions.archive') ? 'active' : '' }}">
                            <a href="{{ route('admin.auctions.archive') }}" class="nav-link">
                                <i class="fa-solid fa-box-archive"></i>
                                <span>أرشيف المزادات</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('settings.admin.*') ? 'active' : '' }}">
                            <a href="{{ route('settings.admin.index') }}" class="nav-link">
                                <i class="fa-solid fa-sliders"></i>
                                <span>الإعدادات</span>
                            </a>
                        </li>



                        @endrole


                        <!-- Profile -->
                        @role('seller')
                        <li class="nav-item {{ request()->routeIs('seller.profile') ? 'active' : '' }}">
                            <a href="{{ route('seller.profile') }}" class="nav-link">
                                <i class="fa-solid fa-user"></i>
                                <span>الملف الشخصي</span>
                            </a>
                        </li>
                        @endrole

                        @role('admin')
                        <li class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                            <a href="{{ route('admin.profile') }}" class="nav-link">
                                <i class="fa-solid fa-user"></i>
                                <span>الملف الشخصي</span>
                            </a>
                        </li>
                        @endrole

                        @role('buyer')
                        <li class="nav-item {{ request()->routeIs('buyer.add.user') ? 'active' : '' }}">
                            <a href="{{ route('sellers.add.user') }}" class="nav-link">
                                <i class="fa-solid fa-user-plus"></i>
                                <span>إضافة معرض</span>
                            </a>
                        </li>
                        @endrole

                        @role('buyer')
                        <li class="nav-item {{ request()->routeIs('buyer.profile') ? 'active' : '' }}">
                            <a href="{{ route('buyer.profile') }}" class="nav-link">
                                <i class="fa-solid fa-user"></i>
                                <span>الملف الشخصي</span>
                            </a>
                        </li>
                        @endrole

                        <!-- Logout Buttons -->
                        @role('admin')
                        <li class="nav-item logout-btn">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link w-100 text-start"
                                    style="background:none; border:none;">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span>تسجيل الخروج</span>
                                </button>
                            </form>
                        </li>
                        @endrole

                        @role('seller')
                        <li class="nav-item logout-btn">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link w-100 text-start"
                                    style="background:none; border:none;">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span>تسجيل الخروج</span>
                                </button>
                            </form>
                        </li>
                        @endrole
                        @role('buyer')
                        <li class="nav-item logout-btn">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link w-100 text-start"
                                    style="background:none; border:none;">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span>تسجيل الخروج</span>
                                </button>
                            </form>
                        </li>
                        @endrole

                    </ul>
                </div>
            </div>
        </div>

        <div class="main-panel">

            <!-- هيدر -->
            <div class="main-header">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <!-- زر القائمة (للجوال) والشعار -->
                    <div class="d-flex align-items-center">
                        <button class="menu-toggle" id="menuToggle">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <div class="site-brand">
                            @if(setting('site_logo'))
                            <img src="{{ setting('site_logo') }}" alt="Logo" style="height: 48px; max-width: 100%;">
                            @else
                            <div class="brand-icon">
                                <i class="fa-solid fa-gavel"></i>
                            </div>
                            @endif
                            <div class="brand-text">
                                <h2>{{ setting('site_name', 'سَيِّر SIR') }}</h2>
                                <span>منصة المزادات الرقمية</span>
                            </div>
                        </div>
                    </div>

                    <!-- الإجراءات -->
                    <div class="header-actions">
                        @role('seller')
                        @livewire('seller.notifications-counter')
                        @endrole

                        <!-- Dropdown المستخدم (تم تبسيطه) -->
                        <div class="dropdown">
                            <div class="user-dropdown" id="userDropdown" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <div class="user-avatar">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="user-info">
                                    <div class="user-greeting">مرحباً</div>
                                    <div class="user-name">{{ auth()->user()->name }}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- المحتوى الديناميكي -->
            <div class="main-content">
                @if (isset($slot))
                {{ $slot }}
                @else
                @yield('content')
                @endif
            </div>

            <!-- فوتر -->
            <footer class="footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        © 2025 <span class="gradient-text" style="font-weight:800;">سَيِّر</span> | منصة المزادات
                        الرقمية
                    </div>
                    <!-- يمكن إضافة روابط إضافية هنا إن لزم الأمر -->
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tom Select -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // عناصر التحكم بالقائمة الجانبية
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                document.body.classList.toggle('sidebar-open');
            }

            function closeSidebar() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.classList.remove('sidebar-open');
            }

            if (menuToggle) {
                menuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            // إغلاق السايدبار عند تغيير حجم الشاشة إذا كان مفتوحاً (للشاشات الكبيرة)
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992 && sidebar.classList.contains('show')) {
                    closeSidebar();
                }
            });

            // إضافة تأثير ظهور للمحتوى
            const content = document.querySelector('.main-content');
            if(content) {
                content.classList.add('animate-on-scroll');
            }
        });
    </script>

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(function(registration) {
                        console.log('✅ Service Worker registered successfully with scope:', registration.scope);
                    })
                    .catch(function(error) {
                        console.log('❌ Service Worker registration failed:', error);
                    });
            });
        }
    </script>


    @livewireScripts
    @stack('scripts')
</body>

</html>
