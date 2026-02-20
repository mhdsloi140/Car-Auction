<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('site_name', 'سَيِّر') }} | منصة بيع السيارات بالثقة</title>
    <meta name="description"
        content="سَيِّر: منصة تربطك بشبكة تجار معتمدين لبيع سيارتك خلال 24 ساعة بدون عمولة وبدون مفاوضات.">

    <!-- Preload fonts and critical assets -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap"
        as="style">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <style>
        /* متغيرات الألوان*/
        :root {
            --primary-dark: #0a1a3a;
            --primary: #0a2472;
            --primary-light: #3a6ea5;
            --accent: #f9c74f;
            --accent-light: #f9844a;
            --gray-light: #f8fafd;
            --gray: #e9edf2;
            --text-dark: #0a1a3a;
            --text-muted: #2d3e50;
            --white: #ffffff;
            --bg-body: linear-gradient(145deg, #ffffff 0%, #f0f5fe 100%);
            --shadow-sm: 0 10px 30px -15px rgba(10, 36, 114, 0.15);
            --shadow-md: 0 20px 40px -20px rgba(10, 36, 114, 0.25);
            --shadow-lg: 0 30px 60px -20px rgba(10, 36, 114, 0.3);
            --border-radius-card: 32px;
            --border-radius-btn: 60px;
            --header-bg: rgba(255, 255, 255, 0.75);
            --card-bg: #ffffff;
            --transition: all 0.3s ease;
            --badge-24h-bg: linear-gradient(145deg, #f9c74f, #f9844a);
            --badge-24h-color: #0a1a3a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: var(--bg-body);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* شريط تقدم التمرير */
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            z-index: 1001;
            transition: width 0.1s, opacity 0.3s;
            opacity: 0;
            box-shadow: 0 0 10px var(--accent);
        }

        /* تأثيرات الزجاج المحسنة */
        .header {
            background: var(--header-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(10, 36, 114, 0.08);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: background 0.3s, backdrop-filter 0.3s, box-shadow 0.3s;
        }

        /* تأثير الانزلاق للعناصر عند الظهور */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.2, 0.9, 0.3, 1), transform 0.8s cubic-bezier(0.2, 0.9, 0.3, 1);
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(145deg, var(--primary), #12315e);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 25px -8px var(--primary);
            transition: transform 0.3s;
        }

        .logo-icon:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .logo-icon i {
            font-size: 28px;
            color: white;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.2));
        }

        .logo-text h1 {
            font-size: 28px;
            font-weight: 900;
            background: linear-gradient(145deg, var(--primary-dark), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .logo-text p {
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
            margin: 0;
        }

        .btn-login {
            background: white;
            color: var(--primary);
            border: 2px solid var(--gray);
            padding: 12px 35px;
            border-radius: var(--border-radius-btn);
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-login:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-profile,
        .btn-logout {
            padding: 12px 25px;
            border-radius: var(--border-radius-btn);
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-profile {
            background: var(--primary);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-profile:hover {
            background: #12315e;
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-logout {
            background: white;
            color: var(--primary);
            border: 2px solid var(--gray);
        }

        .btn-logout:hover {
            background: #fee2e2;
            border-color: #fecaca;
            color: #b91c1c;
        }

        /* فئات مساعدة */
        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .mt-5 {
            margin-top: 2.5rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .p-4 {
            padding: 1.5rem;
        }

        .d-flex {
            display: flex;
        }

        .align-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .gap-3 {
            gap: 1rem;
        }

        .gap-4 {
            gap: 1.5rem;
        }

        .fw-700 {
            font-weight: 700;
        }

        .text-primary {
            color: var(--primary);
        }

        /* Badge 24 ساعة المميز */
        .badge-24h {
            background: var(--badge-24h-bg);
            color: var(--badge-24h-color);
            padding: 8px 20px;
            border-radius: 60px;
            font-size: 1.1rem;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 5px 15px rgba(249, 199, 79, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
            animation: pulse 2s infinite;
            margin-right: 10px;
            letter-spacing: 0.5px;
        }

        .badge-24h i {
            font-size: 1.2rem;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 5px 15px rgba(249, 199, 79, 0.4);
            }

            50% {
                transform: scale(1.02);
                box-shadow: 0 8px 25px rgba(249, 199, 79, 0.6);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 5px 15px rgba(249, 199, 79, 0.4);
            }
        }

        /* هيرو */
        .hero {
            padding: 80px 0 60px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .hero-container {
            padding: 0 30px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 50px;
            align-items: center;
        }

        .hero-badge {
            background: rgba(10, 36, 114, 0.08);
            color: var(--primary);
            padding: 8px 20px;
            border-radius: 60px;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(10, 36, 114, 0.1);
        }

        .hero-badge i {
            color: var(--accent);
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 3.75rem);
            font-weight: 900;
            line-height: 1.2;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        .gradient-text {
            background: linear-gradient(145deg, var(--primary), var(--primary-light), #5a8ec9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
        }

        .hero-description {
            font-size: 1.125rem;
            color: var(--text-muted);
            line-height: 1.8;
            margin-bottom: 30px;
            max-width: 550px;
        }

        /* التأكيد على 24 ساعة في الوصف */
        .hero-description strong {
            color: var(--primary);
            font-size: 1.2rem;
            background: rgba(10, 36, 114, 0.1);
            padding: 2px 8px;
            border-radius: 30px;
            display: inline-block;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin: 40px 0 30px;
        }

        .btn-primary {
            background: linear-gradient(145deg, var(--primary), #12315e);
            color: white;
            border: none;
            padding: 16px 42px;
            border-radius: var(--border-radius-btn);
            font-weight: 800;
            font-size: 1.125rem;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 140%;
            height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(30deg) translateX(-100%);
            transition: transform 0.6s;
        }

        .btn-primary:hover::after {
            transform: rotate(30deg) translateX(100%);
        }

        .btn-primary:hover {
            background: linear-gradient(145deg, #12315e, var(--primary-dark));
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 16px 42px;
            border-radius: var(--border-radius-btn);
            font-weight: 800;
            font-size: 1.125rem;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .trust-icons {
            display: flex;
            gap: 35px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .trust-icon-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .trust-icon-item i {
            width: 42px;
            height: 42px;
            background: rgba(10, 36, 114, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.125rem;
            transition: all 0.3s;
        }

        .trust-icon-item:hover i {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .trust-icon-item span {
            font-weight: 600;
            color: var(--text-dark);
        }

        .hero-image {
            background: linear-gradient(145deg, #c7d9f0, #aac0df);
            border-radius: 50px;
            padding: 50px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .hero-image::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.5), transparent 50%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .hero-image i {
            font-size: clamp(120px, 20vw, 260px);
            color: white;
            filter: drop-shadow(0 30px 20px rgba(10, 36, 114, 0.4));
            animation: float 6s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(2deg);
            }
        }

        /* أقسام عامة */
        .section {
            padding: 90px 0;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-container {
            padding: 0 30px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 900;
            color: var(--text-dark);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 5px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            border-radius: 5px;
        }

        .section-title p {
            color: var(--text-muted);
            font-size: 1.125rem;
            max-width: 700px;
            margin: 0 auto;
        }

        /* قسم من نحن */
        .trust-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .trust-content h3 {
            font-size: clamp(1.5rem, 4vw, 2.25rem);
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 25px;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 25px 0;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 1.125rem;
            font-weight: 500;
            color: var(--text-dark);
        }

        .features-list li i {
            width: 36px;
            height: 36px;
            background: rgba(10, 36, 114, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.125rem;
        }

        .features-list .text-success i {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .trust-card {
            background: linear-gradient(145deg, var(--primary), #12315e);
            border-radius: 50px;
            padding: 60px 40px;
            color: white;
            text-align: center;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .trust-card i {
            font-size: 100px;
            color: rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
        }

        .trust-card h4 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .trust-card p {
            color: #e0edff;
            font-size: 1.125rem;
            line-height: 1.7;
            max-width: 300px;
            margin: 0 auto;
        }

        /* خطوات */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .step-card {
            background: var(--card-bg);
            border-radius: var(--border-radius-card);
            padding: 40px 25px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray);
            transition: all 0.4s;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        /* تمييز الخطوة الثالثة (24 ساعة) */
        .step-card.step-highlight {
            border: 2px solid var(--accent);
            box-shadow: 0 0 20px rgba(249, 199, 79, 0.5);
            transform: translateY(-5px);
        }

        .step-card.step-highlight .step-number {
            background: var(--accent);
            color: var(--primary-dark);
        }

        .step-card.step-highlight .step-icon i {
            color: var(--accent);
        }

        .step-card.step-highlight h4 {
            color: var(--accent);
        }

        .step-card.step-highlight::before {
            background: linear-gradient(145deg, var(--accent), var(--accent-light));
        }

        .step-card.step-highlight:hover .step-number,
        .step-card.step-highlight:hover .step-icon i,
        .step-card.step-highlight:hover h4,
        .step-card.step-highlight:hover p {
            color: var(--primary-dark);
        }

        .step-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 0;
            background: linear-gradient(145deg, var(--primary), #12315e);
            transition: height 0.4s;
            z-index: -1;
        }

        .step-card:hover::before {
            height: 100%;
        }

        .step-card:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .step-card:hover .step-number,
        .step-card:hover .step-icon i,
        .step-card:hover h4,
        .step-card:hover p {
            color: white;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            font-weight: 900;
            margin: 0 auto 20px;
            transition: all 0.3s;
        }

        .step-icon i {
            font-size: 3.125rem;
            color: var(--primary);
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .step-card h4 {
            font-size: 1.375rem;
            font-weight: 800;
            margin-bottom: 15px;
            transition: all 0.3s;
        }

        .step-card p {
            color: var(--text-muted);
            font-size: 1rem;
            line-height: 1.7;
            transition: all 0.3s;
        }

        /* لماذا سير */
        .why-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .why-item {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray);
            transition: all 0.3s;
        }

        .why-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: transparent;
        }

        .why-item i {
            width: 60px;
            height: 60px;
            background: linear-gradient(145deg, var(--primary), #12315e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.625rem;
            flex-shrink: 0;
        }

        .why-item span {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 1.125rem;
        }

        /* الرؤية */
        .vision-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .vision-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 40px;
            padding: 40px 25px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s;
        }

        .vision-card:hover {
            background: var(--card-bg);
            transform: scale(1.02);
            box-shadow: var(--shadow-lg);
        }

        .vision-card i {
            font-size: 3.125rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .vision-card h4 {
            font-size: 1.375rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .vision-card p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        /* CTA */
        .cta-section {
            padding: 100px 0;
            background: linear-gradient(145deg, var(--primary), #0a1a3a);
            border-radius: 100px 100px 0 0;
            margin-top: 60px;
            color: white;
            text-align: center;
        }

        .cta-title {
            font-size: clamp(2rem, 6vw, 3.25rem);
            font-weight: 900;
            margin-bottom: 20px;
        }

        .cta-text {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-cta {
            background: var(--accent);
            color: var(--primary-dark);
            border: none;
            padding: 20px 60px;
            border-radius: 80px;
            font-size: 1.5rem;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 25px 40px -15px rgba(0, 0, 0, 0.4);
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-cta:hover {
            background: var(--accent-light);
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 35px 50px -15px black;
        }

        .cta-trust {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 50px;
            flex-wrap: wrap;
        }

        .cta-trust span {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        .cta-trust i {
            color: var(--accent);
        }

        /* عداد */
        .stats-counter {
            display: flex;
            gap: 2rem;
            margin: 2rem 0;
            justify-content: flex-start;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--primary);
            line-height: 1.2;
        }

        .stat-label {
            font-size: 1rem;
            color: var(--text-muted);
        }

        /* مودال */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 26, 58, 0.8);
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
            background: var(--card-bg);
            border-radius: 60px;
            padding: 50px 45px;
            max-width: 480px;
            width: 92%;
            position: relative;
            transform: scale(0.9) translateY(20px);
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 50px 80px -30px black;
            text-align: center;
            border-top: 5px solid var(--accent);
        }

        .modal.active .modal-content {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--gray);
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: var(--primary);
            color: white;
            transform: rotate(90deg);
        }

        .modal-icon {
            font-size: 4.375rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .modal h3 {
            font-size: 2rem;
            font-weight: 900;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .modal p {
            color: var(--text-muted);
            margin-bottom: 30px;
            font-size: 1rem;
        }

        .phone-field {
            margin-bottom: 20px;
            text-align: right;
        }

        .phone-label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.9375rem;
        }

        .phone-input-group {
            display: flex;
            align-items: center;
            background: var(--gray-light);
            border: 2px solid var(--gray);
            border-radius: 60px;
            overflow: hidden;
            transition: all 0.3s;
            direction: ltr;
        }

        .phone-input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(10, 36, 114, 0.15);
            background: var(--card-bg);
        }

        .country-code {
            background: var(--card-bg);
            padding: 16px 20px;
            color: var(--primary);
            font-weight: 700;
            font-size: 1rem;
            border-left: 2px solid var(--gray);
        }

        .phone-input {
            flex: 1;
            border: none;
            padding: 16px 15px;
            font-size: 1rem;
            background: transparent;
            outline: none;
            text-align: left;
            color: var(--text-dark);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            text-align: right;
            min-height: 20px;
        }

        .send-code-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(145deg, var(--primary), #12315e);
            border: none;
            border-radius: 60px;
            color: white;
            font-size: 1.125rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 15px 0 20px;
            position: relative;
        }

        .send-code-btn .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        .send-code-btn.loading .spinner {
            display: inline-block;
        }

        .send-code-btn.loading .btn-text {
            opacity: 0.7;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .modal-footer a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: border-color 0.3s;
        }

        .modal-footer a:hover {
            border-bottom-color: var(--primary);
        }

        .modal-terms {
            margin-top: 25px;
            font-size: 0.8125rem;
            color: var(--text-muted);
        }

        /* تأثير Ripple */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.6);
            width: 100px;
            height: 100px;
            margin-top: -50px;
            margin-left: -50px;
            animation: ripple 0.6s linear;
            transform: scale(0);
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .vision-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .hero-grid {
                grid-template-columns: 1fr;
            }

            .trust-grid {
                grid-template-columns: 1fr;
            }

            .hero-image {
                max-width: 500px;
                margin: 0 auto;
            }
        }

        @media (max-width: 768px) {
            .steps-grid {
                grid-template-columns: 1fr;
            }

            .why-grid {
                grid-template-columns: 1fr;
            }

            .vision-grid {
                grid-template-columns: 1fr;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .trust-icons {
                flex-direction: column;
                align-items: flex-start;
            }

            .cta-trust {
                flex-direction: column;
                gap: 15px;
            }

            .header-container {
                justify-content: center;
            }

            .logo-text h1 {
                font-size: 1.375rem;
            }

            .stats-counter {
                justify-content: center;
            }
        }
    </style>

    <!-- تحميل غير متزامن لـ Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </noscript>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="manifest" href="/manifest.json">
    @livewireStyles
</head>

<body>
    <!-- شريط تقدم التمرير -->
    <div class="scroll-progress" id="scrollProgress"></div>

    <!-- خلفية متحركة -->
    <div class="bg-pattern"></div>
    <div class="floating-dots"></div>

    <!-- الهيدر (بدون زر الوضع الليلي) -->
    <header class="header" id="mainHeader">
        <div class="header-container">
            <div class="logo">
                <div class="logo-icon" aria-hidden="true">
                    <i class="{{ setting('site_icon', 'fas fa-gavel') }}"></i>
                </div>
                <div class="logo-text">
                    <h1>{{ setting('site_name', 'سَيِّر') }}</h1>
                    <p>{{ setting('site_tagline', 'منصة المزادات الرقمية') }}</p>
                </div>
            </div>

            <nav class="d-flex align-center gap-3" aria-label="القائمة الرئيسية">
                @guest
                <button class="btn-login" id="openLoginBtn" aria-label="تسجيل الدخول">
                    <i class="fas fa-user-circle" aria-hidden="true"></i>
                    تسجيل الدخول
                </button>
                @endguest

                @auth
                <form method="get" action="{{ route('user.profile') }}" style="display: inline;">
                    <button type="submit" class="btn-profile" aria-label="الملف الشخصي">
                        <i class="fas fa-user-alt" aria-hidden="true"></i>
                        الملف الشخصي
                    </button>
                </form>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout" aria-label="تسجيل الخروج">
                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                        تسجيل الخروج
                    </button>
                </form>
                @endauth
            </nav>
        </div>
    </header>

    <!-- المحتوى الرئيسي -->
@yield('content')

    <!-- مودال تسجيل الدخول -->
    {{-- <div class="modal" id="loginModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-content">
            <button class="modal-close" id="closeModalBtn" aria-label="إغلاق">&times;</button>
            <div class="modal-icon">
                <i class="fas fa-car"></i>
            </div>
            <h3 id="modalTitle">تسجيل الدخول إلى سيّر</h3>
            <p>أدخل رقم هاتفك</p>

            <form id="loginForm" action="#" method="post">
                <div class="phone-field">
                    <label for="phone" class="phone-label">رقم الهاتف</label>
                    <div class="phone-input-group">
                        <span class="country-code" id="countryCode">+964</span>
                        <input type="tel" class="phone-input" id="phone" name="phone" placeholder="xxx xxxx xxx"
                            aria-labelledby="countryCode phone" required>
                    </div>
                    <div class="error-message" id="phoneError" role="alert"></div>
                </div>

                <button type="submit" class="send-code-btn" id="submitBtn">
                    <span class="spinner"></span>
                    <span class="btn-text"> تسجيل الدخول </span>
                </button>
            </form>


            <div class="modal-terms">
                بالتسجيل أنت توافق على <a href="#">الشروط والأحكام</a>
            </div>
        </div>
    </div> --}}
  @livewire('user.login')
@livewireScripts

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // شريط تقدم التمرير
        const scrollProgress = document.getElementById('scrollProgress');
        window.addEventListener('scroll', () => {
            const winScroll = document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            if (scrollProgress) {
                scrollProgress.style.width = scrolled + '%';
                scrollProgress.style.opacity = winScroll > 50 ? '1' : '0';
            }
        });

        // تأثير زجاجي ديناميكي للهيدر
        const header = document.getElementById('mainHeader');
        window.addEventListener('scroll', () => {
            if (header) {
                const currentScrollY = window.scrollY;
                if (currentScrollY > 100) {
                    header.style.backdropFilter = 'blur(16px)';
                    header.style.background = 'rgba(255,255,255,0.85)';
                } else {
                    header.style.backdropFilter = 'blur(12px)';
                    header.style.background = 'rgba(255,255,255,0.75)';
                }
            }
        });

        // عناصر الظهور
        const fadeElements = document.querySelectorAll('.fade-up');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    if (entry.target.querySelector('.stats-counter')) {
                        startCounters();
                    }
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });

        fadeElements.forEach(el => observer.observe(el));

        // العداد المتحرك
        function startCounters() {
            const dealerCounter = document.getElementById('dealerCount');
            const carsCounter = document.getElementById('carsSold');
            if (!dealerCounter || !carsCounter) return;
            const dealerTarget = parseInt(dealerCounter.getAttribute('data-target'), 10);
            const carsTarget = parseInt(carsCounter.getAttribute('data-target'), 10);
            animateCounter(dealerCounter, 0, dealerTarget, 2000);
            animateCounter(carsCounter, 0, carsTarget, 2000);
        }

        function animateCounter(element, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                element.innerText = Math.floor(progress * (end - start) + start);
                if (progress < 1) window.requestAnimationFrame(step);
            };
            window.requestAnimationFrame(step);
        }

        // مودال - متوافق مع Livewire
        const openBtn = document.getElementById('openLoginBtn');
        const modal = document.getElementById('loginModal');

        // إعادة تعيين المتغيرات القديمة حتى لا تسبب أخطاء
        const closeBtn = document.getElementById('closeModalBtn');
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const phoneInput = document.getElementById('phone');
        const phoneError = document.getElementById('phoneError');

        let focusableElementsString = 'a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])';
        let focusableElements, firstFocusable, lastFocusable;

        function openModal() {
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    // التركيز على أول عنصر قابل للتركيز في المودال
                    const closeButton = modal.querySelector('.modal-close');
                    if (closeButton) closeButton.focus();

                    focusableElements = modal.querySelectorAll(focusableElementsString);
                    firstFocusable = focusableElements[0];
                    lastFocusable = focusableElements[focusableElements.length - 1];
                }, 100);
            }
        }

        function closeModal() {
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
                if (openBtn) openBtn.focus();

                // إعادة تعيين خطوات Livewire عند إغلاق المودال (اختياري)
                // يمكنك تفعيل هذا السطر إذا أردت إعادة تعيين الخطوات
                // Livewire.first().call('backToLogin');
            }
        }

        // فتح المودال عند الضغط على زر فتح
        if (openBtn) {
            openBtn.addEventListener('click', openModal);
        }

        // إغلاق المودال عند الضغط على زر الإغلاق
        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        } else {
            // إذا لم يكن هناك زر إغلاق محدد، نستخدم event delegation
            document.addEventListener('click', function(e) {
                if (e.target.closest('.modal-close')) {
                    closeModal();
                }
            });
        }

        // التحكم في المودال باستخدام لوحة المفاتيح
        if (modal) {
            modal.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                }

                if (e.key === 'Tab') {
                    if (!focusableElements) return;

                    if (e.shiftKey) {
                        if (document.activeElement === firstFocusable) {
                            e.preventDefault();
                            lastFocusable.focus();
                        }
                    } else {
                        if (document.activeElement === lastFocusable) {
                            e.preventDefault();
                            firstFocusable.focus();
                        }
                    }
                }
            });

            // إغلاق المودال عند الضغط على الخلفية
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        // استماع لحدث closeModal من Livewire
        window.addEventListener('closeModal', function() {
            closeModal();
        });

        // استماع لحدث فتح المودال من Livewire (إذا احتجت)
        window.addEventListener('openModal', function() {
            openModal();
        });

        // تحديث focusable elements عندما يتغير محتوى المودال (بسبب تغيير خطوات Livewire)
        if (modal) {
            const observer = new MutationObserver(() => {
                setTimeout(() => {
                    focusableElements = modal.querySelectorAll(focusableElementsString);
                    firstFocusable = focusableElements[0];
                    lastFocusable = focusableElements[focusableElements.length - 1];
                }, 50);
            });

            observer.observe(modal, { childList: true, subtree: true });
        }

        // إلغاء السكريبت القديم للـ form حتى لا يتعارض مع Livewire
        // (لأن Livewire يدير الـ form تلقائياً)
        /*
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                // هذا السكريبت تم تعطيله لأنه يتعارض مع Livewire
                e.preventDefault();
                // ... الكود القديم
            });
        }
        */

        // تأثير Ripple على الأزرار
        const buttons = document.querySelectorAll('.btn-primary, .btn-secondary, .btn-cta, .send-code-btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                this.appendChild(ripple);
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                ripple.style.width = ripple.style.height = Math.max(rect.width, rect.height) + 'px';
                setTimeout(() => ripple.remove(), 600);
            });
        });
    });

    // دالة togglePassword (إذا كانت مستخدمة)
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('toggleIcon');

        if (input && icon) {
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    }
</script>
</body>

</html>
