<div wire:poll.2s="checkForNewBids" class="bid-modern"
     x-data="{
        multiplier: 1,
        incrementValue: null,
        updateMultiplier(operation) {
            if (operation === 'plus') {
                this.multiplier = Math.min(this.multiplier + 1, 5); // حد أقصى 5 أضعاف
            } else if (operation === 'minus') {
                this.multiplier = Math.max(this.multiplier - 1, 1); // حد أدنى 1
            }
        }
     }"
     x-init="$watch('multiplier', value => {
        if (incrementValue) {
            $wire.set('selectedIncrement', incrementValue * value);
        }
     })">

    <div class="container py-4">

        {{-- تنبيه مزايدة جديدة --}}
        @if($newBidAlert)
        <div class="alert alert-info text-center">
            مزايدة جديدة بقيمة
            <strong>{{ number_format($newBidAlert['amount']) }} دينار عراقي</strong>
        </div>
        @endif

        {{-- الإحصائيات --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4" wire:ignore>
                <div class="stat-card timer-card">
                    <span class="stat-label">الوقت المتبقي</span>
                    <div class="timer-display" id="countdown">--:--:--</div>
                    <input type="hidden" id="auctionEndTime"
                        value="{{ optional($auction->end_at)->setTimezone('UTC')->toIso8601String() }}">
                </div>
            </div>

            {{-- بيانات المزاد --}}
            <div class="col-md-8">
                <div class="row g-4">
                    {{-- السعر الحالي --}}
                    <div class="col-sm-4">
                        <div class="stat-card">
                            <span class="stat-label">السعر الحالي</span>
                            <span class="stat-value">
                                {{ number_format($currentPrice) }} د.ع
                            </span>
                        </div>
                    </div>

                    {{-- عدد المزايدات --}}
                    <div class="col-sm-4">
                        <div class="stat-card">
                            <span class="stat-label">عدد المزايدات</span>
                            <span class="stat-value">
                                {{ $bidsCount }}
                            </span>
                        </div>
                    </div>

                    {{-- بداية المزاد --}}
                    <div class="col-sm-4">
                        <div class="stat-card">
                            <span class="stat-label">بداية المزاد</span>
                            <span class="stat-value">
                                {{ optional($auction->start_at)->format('Y-m-d') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- قسم تقديم المزايدة --}}
        <div class="row g-4">
            {{-- العمود الأيسر --}}
            <div class="col-lg-8">
                <div class="content-card">
                    <h2 class="section-title">تقديم مزايدة</h2>

                    {{-- السعر الحالي --}}
                    <div class="current-price">
                        <span class="price-label">السعر الحالي</span>
                        <span class="price-value">
                            {{ number_format($currentPrice) }} د.ع
                        </span>
                    </div>

                    {{-- أزرار الزيادة --}}
                    <div class="bid-increment-section mt-4">
                        <label class="form-label">اختر قيمة الزيادة:</label>

                        <div class="increment-buttons d-flex flex-wrap gap-2">
                            @foreach($increments as $inc)
                            <button type="button"
                                @click="incrementValue = {{ $inc }}; multiplier = 1; $wire.set('selectedIncrement', {{ $inc }})"
                                class="increment-btn {{ $selectedIncrement == $inc ? 'active' : '' }}">
                                + {{ number_format($inc) }} د.ع
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- مضاعف القيمة - يظهر فقط عند اختيار قيمة --}}
                    @if($selectedIncrement)
                    <div class="multiplier-section mt-3 p-3 bg-light rounded">
                        <label class="form-label fw-bold">مضاعف القيمة:</label>
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-outline-danger"
                                    @click="updateMultiplier('minus')"
                                    :disabled="multiplier <= 1">
                                <i class="bi bi-dash-lg"></i> -
                            </button>

                            <span class="fw-bold fs-4" x-text="multiplier"></span>

                            <button class="btn btn-outline-success"
                                    @click="updateMultiplier('plus')"
                                    :disabled="multiplier >= 5">
                                <i class="bi bi-plus-lg"></i> +
                            </button>

                            <span class="text-muted me-2">× {{ number_format($selectedIncrement) }} د.ع</span>
                        </div>
                    </div>

                    {{-- عرض القيمة النهائية --}}
                    <div class="alert alert-success mt-3 text-center">
                        قيمة المزايدة الجديدة:
                        <strong class="fs-4">
                            {{ number_format($selectedIncrement) }} × <span x-text="multiplier"></span> =
                            <span x-text="({{ $selectedIncrement }} * multiplier).toLocaleString()"></span> د.ع
                        </strong>
                    </div>
                    @endif

                    {{-- زر المزايدة --}}
                    <button class="btn-bid-now mt-3" wire:click="placeBid" wire:loading.attr="disabled"
                        wire:target="placeBid">
                        <span wire:loading.remove wire:target="placeBid">
                            زايد الآن
                        </span>
                        <span wire:loading wire:target="placeBid">
                            جاري التنفيذ...
                        </span>
                    </button>

                    {{-- الأخطاء --}}
                    @error('amount')
                    <div class="text-danger mt-2 text-center">{{ $message }}</div>
                    @enderror

                    {{-- رسالة النجاح --}}
                    @if (session()->has('success'))
                    <div class="alert alert-success mt-3 text-center">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
            </div>

            {{-- العمود الأيمن: أثر المزايدات --}}
            <div class="col-lg-4">
                <div class="content-card h-100">
                    <h2 class="section-title">أخر المزايدات</h2>

                    <div class="bids-timeline">
                        @if(count($latestBids))
                        @foreach($latestBids as $bid)
                        <div class="bid-timeline-item">
                            <div class="bid-amount-badge">
                                {{ number_format($bid->amount) }} د.ع
                            </div>
                            <div class="bidder-details">
                                <span class="bidder-name">{{ $bid->user->id ?? 'مزايد' }} مزايدة</span>
                                <span class="bid-time">{{ $bid->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="text-muted text-center py-3">
                            لا توجد مزايدات بعد
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('update-end-time', (data) => {
                const newEndTime = data.endTime;
                document.getElementById('auctionEndTime').value = newEndTime;
                startCountdown(newEndTime);
            });
        });
    </script>
</div>
