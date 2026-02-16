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

    <link rel="stylesheet" href="{{ asset('users/css/app.css') }}" />
    <link rel="manifest" href="/manifest.json">
    <script>
        if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js');
    }
    </script>
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
            {{-- @auth
            <a href="{{ route('user.profile') }}" class="profile-btn">
                <i class="fas fa-user"></i>
                الملف الشخصي
            </a>
            @endauth --}}



            @guest
            <button class="login-btn" id="openLoginBtn">
                <i class="fas fa-user-circle"></i>
                تسجيل الدخول
            </button>
            @endguest


            @auth
            <form method="get" action="{{ route('user.profile') }}" style="margin-right: 600px">
                @csrf
                <button type="submit" class="login-btn">

                    <i class="fas fa-user-alt"></i>
                    الملف الشخصي
                </button>
            </form>
            @endauth
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
