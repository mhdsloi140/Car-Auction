<div wire:poll.5s class="modern-auctions">

   

    <!-- شبكة المزادات الحديثة -->
    <div class="container-fluid px-0">
        <div class="row g-4">
            @forelse ($auctions as $auction)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="auction-card-modern">
                        <div class="auction-card-media">
                            <img src="{{ $auction->car->getFirstMediaUrl('cars') }}"
                                 class="card-img"
                                 alt="{{ $auction->car->model->name ?? 'سيارة' }}">
                            <div class="card-overlay">
                                <a href="{{ route('auction.users.show', $auction->id) }}"
                                   class="btn-view-modern">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                            @if($auction->end_at && $auction->end_at->isFuture())
                                <span class="badge-modern live">مباشر</span>
                            @else
                                <span class="badge-modern ended">منتهي</span>
                            @endif
                        </div>
                        <div class="auction-card-content">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="brand-name-tag">{{ $auction->car->brand->name ?? 'غير محدد' }}</span>
                                <span class="model-name">{{ $auction->car->model->name ?? 'غير محدد' }}</span>
                            </div>
                            <div class="car-year mb-3">
                                <i class="fas fa-calendar-alt text-primary-blue"></i>
                                <span>{{ $auction->car->year ?? '' }}</span>
                            </div>
                            <div class="current-bid-modern mb-3">
                                <span class="label">السعر الحالي</span>
                                <span class="price">{{ number_format($auction->starting_price, 0) }} د.ع</span>
                            </div>
                            <div class="bid-meta-modern d-flex justify-content-between align-items-center">
                                @if($auction->end_at)
                                    <div class="time-remaining">
                                        <i class="fas fa-hourglass-half"></i>
                                        <span>{{ $auction->end_at->diffForHumans() }}</span>
                                    </div>
                                @endif
                                <span class="bids-count">
                                    <i class="fas fa-users"></i> {{ $auction->bids_count ?? 0 }}
                                </span>
                            </div>
                            <a href="{{ route('auction.users.show', $auction->id) }}"
                               class="btn-bid-modern mt-3">
                                <i class="fas fa-gavel me-2"></i> دخول المزاد
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state-modern">
                        <i class="fas fa-car-side"></i>
                        <h4>لا توجد مزادات متاحة</h4>
                        <p>لا توجد مزادات متاحة حالياً</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ستايلات عصرية حديثة مستوحاة من bid-modern -->
    <style>
        /* استيراد خطوط عصرية */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap');

        .modern-auctions {
            font-family: 'Inter', 'Cairo', sans-serif;
            background: linear-gradient(135deg, #f5f9ff 0%, #e8f0fe 100%);
            padding: 30px 0;
            min-height: 100vh;
        }

        /* قسم الماركات */
        .brands-section {
            padding: 0 20px;
        }
        .section-title {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 30px;
            color: #0a2540;
        }
        .gradient-text {
            background: linear-gradient(135deg, #004c80 0%, #0a2540 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            display: inline-block;
        }
        .gradient-text::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #004c80 0%, #0a2540 100%);
            border-radius: 4px;
        }

        /* شبكة الماركات */
        .brands-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 20px;
            justify-content: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        .brand-card {
            background: white;
            border-radius: 24px;
            padding: 20px 10px;
            box-shadow: 0 10px 30px -10px rgba(0, 40, 80, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid rgba(0, 76, 128, 0.1);
            text-align: center;
        }
        .brand-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -12px rgba(0, 76, 128, 0.3);
            border-color: #004c80;
        }
        .brand-card.active {
            border: 2px solid #004c80;
            box-shadow: 0 15px 35px -8px rgba(0, 76, 128, 0.4);
        }
        .brand-icon {
            width: 60px;
            height: 60px;
            background: #004c80;
            border-radius: 30px 30px 30px 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            color: white;
            font-size: 28px;
            transition: 0.3s;
        }
        .brand-card:hover .brand-icon {
            border-radius: 30px 5px 30px 30px;
            background: #002b44;
        }
        .brand-logo-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 15px;
            border: 2px solid #e0edff;
            padding: 8px;
            background: white;
            transition: 0.3s;
        }
        .brand-card:hover .brand-logo-wrapper {
            border-color: #004c80;
            transform: rotate(5deg);
        }
        .brand-logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .brand-name {
            font-weight: 700;
            font-size: 14px;
            color: #0a2540;
            letter-spacing: 0.3px;
        }

        /* بطاقات المزادات الحديثة */
        .auction-card-modern {
            background: white;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 15px 35px -8px rgba(0, 40, 80, 0.15);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0, 76, 128, 0.1);
        }
        .auction-card-modern:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 76, 128, 0.3);
            border-color: #004c80;
        }
        .auction-card-media {
            position: relative;
            height: 220px;
            overflow: hidden;
        }
        .auction-card-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .auction-card-modern:hover .auction-card-media img {
            transform: scale(1.08);
        }
        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(3px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .auction-card-modern:hover .card-overlay {
            opacity: 1;
        }
        .btn-view-modern {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #004c80;
            font-size: 24px;
            transform: scale(0.8);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }
        .auction-card-modern:hover .btn-view-modern {
            transform: scale(1);
        }
        .btn-view-modern:hover {
            background: #004c80;
            color: white;
        }

        /* شارات الحالة */
        .badge-modern {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 18px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.3);
        }
        .badge-modern.live {
            background: linear-gradient(135deg, #004c80, #0a2540);
            color: white;
        }
        .badge-modern.ended {
            background: rgba(108, 117, 125, 0.9);
            color: white;
        }

        /* محتوى البطاقة */
        .auction-card-content {
            padding: 22px 20px 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .brand-name-tag {
            font-weight: 700;
            color: #004c80;
            font-size: 16px;
            background: rgba(0, 76, 128, 0.1);
            padding: 4px 12px;
            border-radius: 30px;
        }
        .model-name {
            font-weight: 600;
            color: #0a2540;
            font-size: 16px;
        }
        .car-year {
            font-size: 14px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f8fafd;
            padding: 8px 12px;
            border-radius: 40px;
        }
        .text-primary-blue {
            color: #004c80;
        }

        /* السعر الحالي */
        .current-bid-modern {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 15px 0;
            border-top: 1px dashed #e2e8f0;
            border-bottom: 1px dashed #e2e8f0;
        }
        .current-bid-modern .label {
            font-weight: 500;
            color: #64748b;
            font-size: 15px;
        }
        .current-bid-modern .price {
            font-weight: 800;
            color: #004c80;
            font-size: 22px;
            letter-spacing: -0.5px;
        }

        /* ميتا البيانات */
        .bid-meta-modern {
            font-size: 14px;
        }
        .time-remaining {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #dc2626;
            background: #fee2e2;
            padding: 6px 14px;
            border-radius: 40px;
            font-weight: 600;
        }
        .bids-count {
            background: #e0edff;
            padding: 6px 14px;
            border-radius: 40px;
            color: #004c80;
            font-weight: 600;
        }

        /* زر دخول المزاد */
        .btn-bid-modern {
            background: #004c80;
            color: white;
            border: none;
            padding: 14px 18px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            text-align: center;
            transition: all 0.3s;
            display: block;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(0, 76, 128, 0.3);
            position: relative;
            overflow: hidden;
        }
        .btn-bid-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        .btn-bid-modern:hover::before {
            left: 100%;
        }
        .btn-bid-modern:hover {
            background: #002b44;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 76, 128, 0.5);
            color: white;
        }

        /* حالة عدم وجود مزادات */
        .empty-state-modern {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 40px;
            box-shadow: 0 15px 35px -8px rgba(0,40,80,0.1);
        }
        .empty-state-modern i {
            font-size: 100px;
            color: #cbd5e1;
            margin-bottom: 20px;
        }
        .empty-state-modern h4 {
            font-weight: 700;
            color: #0a2540;
            font-size: 28px;
        }
        .empty-state-modern p {
            color: #64748b;
            font-size: 18px;
        }

        /* تحسينات الجوال */
        @media (max-width: 768px) {
            .brands-grid {
                grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
                gap: 10px;
            }
            .brand-card {
                padding: 12px 5px;
            }
            .brand-icon, .brand-logo-wrapper {
                width: 50px;
                height: 50px;
            }
            .section-title {
                font-size: 26px;
            }
        }
    </style>
</div>
