<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
   <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

{{-- أيقونة الموقع (Favicon) --}}
@php
    $logoUrl = setting('site_logo') ? asset('storage/' . setting('site_logo')) : null;
@endphp

@if($logoUrl)
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <link rel="shortcut icon" href="{{ $logoUrl }}">
    <link rel="apple-touch-icon" href="{{ $logoUrl }}">
@else
    {{-- أيقونة سيارة افتراضية (Font Awesome) --}}
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23004c80'%3E%3Cpath d='M19 16.5L17 13.5L15 16.5L13 13.5L11 16.5L9 13.5L7 16.5L5 13.5L3 16.5L2 10L4 6H20L22 10L21 16.5L19 16.5Z'/%3E%3C/svg%3E">
@endif

{{-- عنوان الموقع مع أيقونة --}}
<title>{{ setting('site_name', 'سَيِّر SIR') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

    {{-- <link rel="stylesheet" href="{{ asset('users/css/app.css') }}" /> --}}
 <style>* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Cairo", sans-serif;
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
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        45deg,
        transparent,
        rgba(255, 255, 255, 0.3),
        transparent
    );
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
    content: "";
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
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(
        circle at 30% 50%,
        rgba(255, 255, 255, 0.3),
        transparent
    );
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
    content: "";
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
        .brand-section {
            /* padding: 0 15px;
             */

    display: flex;
    flex-direction: column;
    align-items: center;
        }
        .section-title {
            font-size: 28px;
            font-weight: 800;
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .brand-grid {

    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center; /* توسيط العناصر داخل الشبكة */
    max-width: 900px; /* يتحكم بعرض القسم */

        }
        .brand-card {
            background: #fff;
            border-radius: 16px;
            padding: 15px 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 2px solid transparent;
            text-align: center;
        }
        .brand-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.15);
            border-color: #667eea;
        }
        .brand-card.active {
            border-color: #667eea;
            background: linear-gradient(135deg, #f5f7ff 0%, #ffffff 100%);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }
        .brand-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            color: #fff;
            font-size: 24px;
        }
        .brand-logo-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 10px;
            border: 2px solid #f0f0f0;
            padding: 5px;
            background: #fff;
        }
        .brand-logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .brand-name {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        /* بطاقات المزادات */
        .auction-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .auction-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
        }
        .auction-card-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }
        .auction-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .auction-card:hover .auction-card-image img {
            transform: scale(1.1);
        }
        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .auction-card:hover .card-overlay {
            opacity: 1;
        }
        .btn-view {
            width: 50px;
            height: 50px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            font-size: 20px;
            transform: scale(0.8);
            transition: all 0.3s;
        }
        .auction-card:hover .btn-view {
            transform: scale(1);
        }
        .badge-live {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: #fff;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        .badge-ended {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #6c757d;
            color: #fff;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
        }
        .auction-card-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .brand-model {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .brand-model .brand {
            font-weight: 700;
            color: #667eea;
            font-size: 16px;
        }
        .brand-model .model {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }
        .car-year {
            font-size: 14px;
            color: #777;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .current-bid {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px 0;
            border-top: 1px solid #f0f0f0;
            border-bottom: 1px solid #f0f0f0;
        }
        .current-bid .label {
            font-weight: 500;
            color: #555;
        }
        .current-bid .price {
            font-weight: 800;
            color: #28a745;
            font-size: 18px;
        }
        .time-remaining {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #dc3545;
            margin-bottom: 15px;
            background: #fff5f5;
            padding: 8px 12px;
            border-radius: 50px;
        }
        .time-remaining i {
            font-size: 16px;
        }
        .btn-bid {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 50px;
            font-weight: 700;
            text-align: center;
            transition: all 0.3s;
            display: block;
            margin-top: auto;
            text-decoration: none;
        }
        .btn-bid:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46a0 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: #fff;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #f8f9fa;
            border-radius: 20px;
        }
        .empty-state i {
            font-size: 80px;
            color: #ccc;
            margin-bottom: 20px;
        }
        .empty-state h4 {
            font-weight: 700;
            color: #333;
        }
        .empty-state p {
            color: #777;
        }

        .password-field {
    background: #fff;
    border: 1px solid #ccc;
    padding: 12px;
     border-radius: 60px;
    width: 100%;
    color: #000;
}
.password-wrapper {
    position: relative;
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #777;
    font-size: 18px;
}
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .bid-modern {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f5f9ff 0%, #e8f0fe 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* شريط التنقل */
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
    .modern-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
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

    /* البطاقات الإحصائية */
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 24px;
        box-shadow: 0 10px 30px -5px rgba(0, 40, 80, 0.1);
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px -8px rgba(0, 76, 128, 0.2);
    }
    .stat-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #0a2540;
        line-height: 1.2;
    }

    /* عداد الوقت */
    .timer-card {
        display: flex; flex-direction: column; justify-content: center; align-items: center;
    }.timer-display {
        font-size: 2.2rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        color: #004c80;
        background: #e0edff;
        padding: 0.5rem 1rem;
        border-radius: 60px;
        margin-top: 8px;
        letter-spacing: 1px;
        border: 2px solid #004c80;
    }

    /* البطاقات الرئيسية */
    .content-card {
        background: white;
        border-radius: 30px;
        padding: 2rem;
        box-shadow: 0 15px 35px -8px rgba(0, 40, 80, 0.15);
        transition: all 0.2s;
    }
    .content-card:hover {
        box-shadow: 0 25px 50px -12px rgba(0, 76, 128, 0.25);
    }
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0a2540;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        border-bottom: 2px solid #e0edff;
        padding-bottom: 0.75rem;
    }
    .section-title i {
        color: #004c80;
        font-size: 1.5rem;
    }

    /* السعر الحالي */
    .current-price {
        background: #f8fafd;
        border-radius: 60px;
        padding: 1rem 2rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #cbd5e1;
    }
    .price-label {
        font-size: 1rem;
        font-weight: 500;
        color: #475569;
    }
    .price-value {
        font-size: 2rem;
        font-weight: 800;
        color: #004c80;
    }

    /* أزرار الزيادة */
    .bid-increment-section {
        margin-bottom: 2rem;
    }
    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.75rem;
        display: block;
    }
    .increment-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    .increment-btn {
        background: white;
        border: 2px solid #cbd5e1;
        color: #1e293b;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 60px;
        transition: all 0.2s;
        font-size: 1rem;
        cursor: pointer;
        flex: 1 1 auto;
        min-width: 100px;
    }
    .increment-btn:hover {
        border-color: #004c80;
        background: #e0edff;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px -5px #004c80;
    }

    /* زر المزايدة الرئيسي */
    .btn-bid-now {
        background: #004c80;
        border: none;
        color: white;
        font-weight: 700;
        font-size: 1.25rem;
        padding: 1rem 2rem;
        border-radius: 60px;
        width: 100%;
        transition: all 0.3s;
        box-shadow: 0 10px 20px -5px #004c80;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-bid-now:hover {
        background: #002b44;
        transform: translateY(-3px);
        box-shadow: 0 20px 30px -8px #004c80;
    }

    /* رابط عرض الكل */
    .view-all-link {
        color: #004c80;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        transition: color 0.2s;
    }
    .view-all-link:hover {
        color: #002b44;
        text-decoration: underline;
    }

    /* تنسيق أثر المزايدات - تصميم جديد مطابق للصورة */
    .bids-timeline {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .bid-timeline-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f8fafd;
        padding: 0.75rem 1.25rem;
        border-radius: 50px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .bid-timeline-item:hover {
        background: #e0edff;
        border-color: #004c80;
        transform: translateX(-5px);
    }
    .bid-amount-badge {
        background: #004c80;
        color: white;
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 40px;
        min-width: 70px;
        text-align: center;
        font-size: 1rem;
        box-shadow: 0 4px 8px rgba(0, 76, 128, 0.2);
    }
    .bidder-details {
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .bidder-name {
        font-weight: 700;
        color: #0a2540;
        font-size: 1rem;
    }
    .bid-time {
        font-size: 0.8rem;
        color: #64748b;
    }

    /* أزرار All */
    .all-bids-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }
    .btn-all {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #334155;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 40px;
        transition: all 0.2s;
        cursor: pointer;
        flex: 1;
    }
    .btn-all:hover {
        background: #004c80;
        color: white;
        border-color: #004c80;
    }

    /* تحسينات الجوال */
    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }
        .timer-card .timer-display {
            font-size: 2rem;
        }
        .increment-btn {
            min-width: 80px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
        .price-value {
            font-size: 1.5rem;
        }
        .modern-breadcrumb {
            padding: 0.5rem 1.2rem;
            gap: 0.3rem;
        }
        .breadcrumb-link, .modern-breadcrumb .breadcrumb-item.active {
            padding: 0.2rem 0.8rem;
        }
    }

.timer-display {
    font-size: 2rem;
    font-weight: bold;
    transition: color 0.3s ease;
}

.timer-warning {
    color: #facc15; /* أصفر */
}

.timer-danger {
    color: #f97316; /* برتقالي */
}

.timer-critical {
    color: #ef4444; /* أحمر */
}
</style>
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
        <i class="{{ setting('site_icon', 'fas fa-gavel') }}"></i>
    </div>

    <div class="logo-text">
        <h1>
            {{ setting('site_name', 'سَيِّر SIR') }}
        </h1>

        <p>
            {{ setting('site_tagline', 'منصة المزادات الرقمية') }}
        </p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
