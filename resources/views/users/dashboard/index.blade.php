@extends('layouts-users.app')


@section('content')
  <main id="mainContent">
        <!-- القسم الرئيسي (hero) مع تمييز 24 ساعة -->
        <section class="hero fade-up" aria-label="القسم الرئيسي">
            <div class="hero-container">
                <div class="hero-grid">
                    <div class="hero-content">
                        <span class="hero-badge">
                            <i class="fas fa-check-circle" aria-hidden="true"></i> بدون عمولة · بدون مفاوضات
                        </span>
                        <h1 class="hero-title">
                            لا تبيع سيارتك
                            <span class="gradient-text">بأقل من قيمتها</span>
                        </h1>
                        <p class="hero-description">
                            مع سيّر، أدخل بيانات سيارتك وارفع تقرير فحص السونار،
                            وخلال <strong>24 ساعة فقط</strong> من الموافقة على طلبك ستحصل على أعلى عرض من شبكة تجار
                            معتمدين.
                        </p>
                        <!-- إضافة badge مميز 24 ساعة -->
                        <div class="d-flex align-center gap-2" style="margin-bottom: 20px;">
                            <span class="badge-24h"><i class="fas fa-clock"></i> 24 ساعة فقط</span>
                            <span style="color: var(--text-muted);">ضمان سرعة البيع</span>
                        </div>
                        <div class="hero-buttons">
                            <button class="btn-primary" aria-label="سجل سيارتك الآن">
                                <i class="fas fa-car" aria-hidden="true"></i> سجّل سيارتك الآن
                            </button>
                            <button class="btn-secondary" aria-label="كيف تعمل سير">
                                <i class="fas fa-play-circle" aria-hidden="true"></i> كيف تعمل سيّر؟
                            </button>
                        </div>
                        <div class="trust-icons">
                            <div class="trust-icon-item">
                                <i class="fas fa-user-check" aria-hidden="true"></i>
                                <span>بدون إعلانات</span>
                            </div>
                            <div class="trust-icon-item">
                                <i class="fas fa-handshake" aria-hidden="true"></i>
                                <span>بدون مفاوضات</span>
                            </div>
                            <div class="trust-icon-item">
                                <i class="fas fa-percent" aria-hidden="true"></i>
                                <span>بدون عمولات</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero-image">
                        <i class="fas fa-car-side" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- قسم نبني الثقة مع العداد -->
        <section class="section fade-up" aria-labelledby="trust-heading">
            <div class="section-container">
                <div class="section-title">
                    <h2 id="trust-heading">نحن نبني الثقة في سوق السيارات</h2>
                    <p>سوق السيارات يحتاج إلى شفافية… وسيّر جاءت لتوفرها</p>
                </div>
                <div class="trust-grid">
                    <div class="trust-content">
                        <h3>نعلم أن بيع السيارة قد يكون تجربة مرهقة:</h3>
                        <ul class="features-list">
                            <li><i class="fas fa-times-circle" style="color:#dc3545;" aria-hidden="true"></i> عروض غير
                                واضحة</li>
                            <li><i class="fas fa-times-circle" style="color:#dc3545;" aria-hidden="true"></i> مساومات
                                طويلة</li>
                            <li><i class="fas fa-times-circle" style="color:#dc3545;" aria-hidden="true"></i> عدم معرفة
                                السعر الحقيقي</li>
                            <li><i class="fas fa-times-circle" style="color:#dc3545;" aria-hidden="true"></i> خوف من
                                إخفاء المعلومات</li>
                        </ul>
                        <p class="mt-4 fw-700" style="font-size: 1.25rem;">في سيّر، بنينا نظامًا يعتمد على:</p>
                        <ul class="features-list">
                            <li class="text-success"><i class="fas fa-check-circle" style="color:#28a745;"
                                    aria-hidden="true"></i> فحص سونار موثق</li>
                            <li class="text-success"><i class="fas fa-check-circle" style="color:#28a745;"
                                    aria-hidden="true"></i> شبكة تجار معتمدين</li>
                            <li class="text-success"><i class="fas fa-check-circle" style="color:#28a745;"
                                    aria-hidden="true"></i> منافسة شفافة للحصول على أعلى سعر</li>
                            <li class="text-success"><i class="fas fa-check-circle" style="color:#28a745;"
                                    aria-hidden="true"></i> وضوح كامل في كل خطوة</li>
                        </ul>
                        <p class="mt-4"><strong>نحن لا نشتري السيارات. ولا نتدخل في الصفقة النهائية. نحن فقط نربطك بأفضل
                                عرض متاح — بثقة.</strong></p>

                        <!-- العداد المتحرك -->
                        <div class="stats-counter">
                            <div class="stat-item">
                                <span class="stat-number" id="dealerCount" data-target="150">0</span>
                                <span class="stat-label">تاجر معتمد</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" id="carsSold" data-target="3200">0</span>
                                <span class="stat-label">سيارة مباعة</span>
                            </div>
                        </div>
                    </div>
                    <div class="trust-card">
                        <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        <h4>الثقة هي أساسنا</h4>
                        <p>نظامنا مبني على الشفافية والمصداقية مع كل عملية</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- قسم كيف تعمل سيّر -->
        <section class="section fade-up" style="background: var(--card-bg); border-radius: 80px 80px 0 0;"
            aria-labelledby="how-heading">
            <div class="section-container">
                <div class="section-title">
                    <h2 id="how-heading">كيف تعمل سيّر</h2>
                    <p>4 خطوات بسيطة لبيع سيارتك</p>
                </div>
                <div class="steps-grid">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <div class="step-icon"><i class="fas fa-edit"></i></div>
                        <h4>إدخال بيانات السيارة</h4>
                        <p>قم بإدخال تفاصيل سيارتك عبر المنصة مع رفع تقرير فحص السونار.</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <div class="step-icon"><i class="fas fa-clipboard-check"></i></div>
                        <h4>مراجعة الطلب</h4>
                        <p>يقوم فريق سيّر بمراجعة الطلب والتأكد من اكتمال البيانات.</p>
                    </div>
                    <!-- تمييز الخطوة الثالثة ب badge 24 ساعة -->
                    <div class="step-card step-highlight">
                        <div class="step-number">3</div>
                        <div class="step-icon"><i class="fas fa-clock"></i></div>
                        <h4>أعلى عرض خلال 24 ساعة</h4>
                        <p>بعد الموافقة، يتم إرسال بيانات السيارة إلى شبكة التجار المعتمدين ويتنافسون لتقديم أفضل سعر.
                        </p>
                        <span class="badge-24h" style="margin-top: 10px; display: inline-block; font-size: 0.9rem;"><i
                                class="fas fa-hourglass-half"></i> 24 ساعة فقط</span>
                    </div>
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <div class="step-icon"><i class="fas fa-hand-holding-usd"></i></div>
                        <h4>إتمام البيع مباشرة</h4>
                        <p>إذا وافقت على العرض، نزودك بمعلومات التاجر. تذهب إليه مباشرة لإغلاق الصفقة بينكما.</p>
                    </div>
                </div>
                <p class="text-center mt-5 text-primary fw-700" style="font-size: 1.125rem;">ببساطة. سريع. بدون تعقيد.
                </p>
            </div>
        </section>

        <!-- قسم لماذا سيّر -->
        <section class="section fade-up" aria-labelledby="why-heading">
            <div class="section-container">
                <div class="section-title">
                    <h2 id="why-heading">لماذا سيّر؟</h2>
                    <p>لأننا نعيد التوازن للبائع</p>
                </div>
                <div class="why-grid">
                    <div class="why-item"><i class="fas fa-check-circle"></i> <span>الخدمة مجانية بالكامل للبائع</span>
                    </div>
                    <div class="why-item"><i class="fas fa-check-circle"></i> <span>لا توجد عمولات أو رسوم مخفية</span>
                    </div>
                    <div class="why-item"><i class="fas fa-check-circle"></i> <span>شبكة تجار موثوقين</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i> <span>لا تدخل في الصفقة النهائية</span>
                    </div>
                    <div class="why-item"><i class="fas fa-check-circle"></i> <span>لا حاجة لنشر إعلانات وانتظار
                            الاتصالات</span></div>
                    <div class="why-item"><i class="fas fa-check-circle"></i> <span>لا حاجة لمقابلة عشرات
                            المشترين</span></div>
                </div>
                <p class="text-center mt-5" style="font-size: 1.25rem; color: var(--text-dark); font-weight: 700;">نحن
                    لا نأخذ منك القرار. نعطيك أفضل عرض… والقرار لك.</p>
            </div>
        </section>

        <!-- قسم الرؤية -->
        <section class="section fade-up" aria-labelledby="vision-heading">
            <div class="section-container">
                <div class="section-title">
                    <h2 id="vision-heading">نحو سوق سيارات عراقي قائم على الثقة</h2>
                    <p>نطمح إلى:</p>
                </div>
                <div class="vision-grid">
                    <div class="vision-card">
                        <i class="fas fa-chart-bar"></i>
                        <h4>رفع مستوى الشفافية</h4>
                        <p>في السوق</p>
                    </div>
                    <div class="vision-card">
                        <i class="fas fa-balance-scale"></i>
                        <h4>خلق معيار واضح</h4>
                        <p>لتقييم السيارات</p>
                    </div>
                    <div class="vision-card">
                        <i class="fas fa-tag"></i>
                        <h4>تمكين البائع</h4>
                        <p>من معرفة القيمة الحقيقية لسيارته</p>
                    </div>
                    <div class="vision-card">
                        <i class="fas fa-comments"></i>
                        <h4>تقليل الفوضى</h4>
                        <p>والمساومات غير العادلة</p>
                    </div>
                    <div class="vision-card">
                        <i class="fas fa-users"></i>
                        <h4>بناء شبكة تجار</h4>
                        <p>تعتمد على الاحتراف والمصداقية</p>
                    </div>
                    <div class="vision-card">
                        <i class="fas fa-heart"></i>
                        <h4>نؤمن أن الثقة ليست إعلانًا…</h4>
                        <p>بل نظام عمل. وسيّر هي بداية هذا التغيير.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- قسم CTA مع تأكيد 24 ساعة -->
        <section class="cta-section fade-up" aria-labelledby="cta-heading">
            <div class="section-container">
                <h2 class="cta-title" id="cta-heading">جاهز لبيع سيارتك <span class="badge-24h"
                        style="font-size: 1.8rem; padding: 10px 30px;">خلال 24 ساعة</span></h2>
                <p class="cta-text">سجّل بيانات سيارتك الآن، وخلال 24 ساعة من الموافقة ستحصل على أفضل عرض من تجار
                    معتمدين.</p>
                <button class="btn-cta" aria-label="ابدأ الآن" id="openLoginBtn">
                    <i class="fas fa-rocket"></i> ابدأ الآن — الخدمة مجانية
                </button>
                <div class="cta-trust">
                    <span><i class="fas fa-user-check"></i> تجار معتمدين</span>
                    <span><i class="fas fa-eye"></i> عملية شفافة</span>
                    <span><i class="fas fa-wallet"></i> بدون عمولة</span>
                </div>
            </div>
        </section>
    </main>


<div class="container-fluid product py-5">
    <div class="container py-5">
        <div class="tab-class">

            @auth
                @livewire('user.auctions-list')
            @endauth

        </div>
    </div>
</div>


@endsection
