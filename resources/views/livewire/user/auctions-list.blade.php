<div wire:poll.visible.10s class="auctions-modern">

    <!-- شريط الماركات الحديث -->
    <div class="brand-section mb-5">
        <h3 class="section-title text-center mb-4">
            <span class="gradient-text">اختر الماركة</span>
        </h3>
        <div class="brand-grid">
            <!-- زر الكل -->
            <div class="brand-card {{ is_null($selectedBrand) ? 'active' : '' }}"
                 wire:click="selectBrand(null)"
                 role="button"
                 tabindex="0">
                <div class="brand-icon">
                    <i class="fas fa-car"></i>
                </div>
                <span class="brand-name">الكل</span>
            </div>

            <!-- الماركات -->
            @foreach ($brands as $brand)
                <div class="brand-card {{ $selectedBrand == $brand->id ? 'active' : '' }}"
                     wire:click="selectBrand({{ $brand->id }})"
                     role="button"
                     tabindex="0">
                    <div class="brand-logo-wrapper">
                        <img src="{{ $brand->getFirstMediaUrl('logo') }}"
                             class="brand-logo"
                             alt="{{ $brand->name }}">
                    </div>
                    <span class="brand-name">{{ $brand->name }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- شبكة المزادات -->
    <div class="row g-4">
        @forelse ($auctions as $auction)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="auction-card">
                    <div class="auction-card-image">
                        <img src="{{ $auction->car->getFirstMediaUrl('cars') }}"
                             class="card-img-top"
                             alt="{{ $auction->car->model->name ?? 'سيارة' }}">
                        <div class="card-overlay">
                            <a href="{{ route('auction.users.show', $auction->id) }}"
                               class="btn-view">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        @if($auction->end_at->isFuture())
                            <span class="badge-live">مباشر</span>
                        @else
                            <span class="badge-ended">منتهي</span>
                        @endif
                    </div>
                    <div class="auction-card-body">
                        <div class="brand-model">
                            <span class="brand">{{ $auction->car->brand->name ?? 'غير محدد' }}</span>
                            <span class="model">{{ $auction->car->model->name ?? 'غير محدد' }}</span>
                        </div>
                        <div class="car-year">
                            <i class="fas fa-calendar-alt"></i> {{ $auction->car->year ?? '' }}
                        </div>
                        <div class="current-bid">
                            <span class="label">السعر الحالي:</span>
                            <span class="price">{{ number_format($auction->starting_price, 0) }}$</span>
                        </div>
                        <div class="time-remaining">
                            <i class="fas fa-hourglass-half"></i>
                            <span>{{ $auction->end_at->diffForHumans() }}</span>
                        </div>
                        <a href="{{ route('auction.users.show', $auction->id) }}"
                           class="btn-bid">
                            <i class="fas fa-gavel me-2"></i> دخول المزاد
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-car-side"></i>
                    <h4>لا توجد مزادات متاحة</h4>
                    <p>حاول تعديل الفلاتر أو العودة لاحقاً</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
