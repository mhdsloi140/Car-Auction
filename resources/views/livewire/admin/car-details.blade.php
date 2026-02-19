<div class="container my-5" style="direction: rtl; text-align: right;" wire:poll.5s>

    {{-- عنوان السيارة --}}
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <h3 class="fw-bold mb-1">
                    {{ $car->brand?->name ?? '' }}
                    {{ $car->model?->name ?? '' }}
                </h3>

                <span class="text-muted">
                    <i class="bi bi-calendar"></i>
                    سنة الصنع: {{ $car->year ?? '' }}
                </span>
            </div>

            @if($car->auction)
            <span class="badge {{ $car->auction->status === 'active' ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                @if($car->auction->status === 'active')
                    <i class="bi bi-broadcast me-1"></i> مزاد مباشر
                @else
                    <i class="bi bi-lock-fill me-1"></i> {{ __('status.' . $car->auction->status) }}
                @endif
            </span>
            @endif

        </div>
    </div>

    {{-- معلومات المزاد --}}
    @if($car->auction)
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card bg-light border-0 rounded-4 p-3 text-center">
                <small class="text-muted">السعر الحالي</small>
                <h4 class="fw-bold text-primary mb-0">{{ number_format($car->auction->current_price) }}</h4>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card bg-light border-0 rounded-4 p-3 text-center">
                <small class="text-muted">عدد المزايدات</small>
                <h4 class="fw-bold mb-0">{{ $car->auction->bids()->count() }}</h4>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card bg-light border-0 rounded-4 p-3 text-center">
                <small class="text-muted">بداية المزاد</small>
                <h6 class="fw-bold mb-0">{{ $car->auction->start_at ? $car->auction->start_at->format('Y-m-d') : '-' }}</h6>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card bg-light border-0 rounded-4 p-3 text-center">
                <small class="text-muted">الوقت المتبقي</small>
                <h6 class="fw-bold text-danger mb-0" id="countdown-timer" data-end="{{ $car->auction->end_at ? $car->auction->end_at->toIso8601String() : '' }}">
                    {{ $car->auction->end_at ? $car->auction->end_at->diffForHumans() : '-' }}
                </h6>
            </div>
        </div>
    </div>
    @endif

    {{-- قائمة المزايدات --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

        <div class="card-header bg-light py-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-cash-stack me-2"></i>
                سجل المزايدات
            </h5>
        </div>

        <div class="card-body p-0">

            @php
            $bids = $car->auction?->bids()->with('user')->latest()->get();
            $colors = ['#6c757d', '#495057', '#343a40', '#868e96', '#212529', '#adb5bd'];
            $maxBid = $bids?->max('amount');
            @endphp

            @if($bids && $bids->count() > 0)

            <ul class="list-group list-group-flush">

                @foreach($bids as $index => $bid)

                @php
                $isHighest = $bid->amount == $maxBid;
                $bidColor = $colors[$index % count($colors)];
                @endphp

                <li class="list-group-item border-0 px-4 py-3 {{ $isHighest ? 'bg-warning bg-opacity-10' : '' }}">

                    <div class="d-flex justify-content-between align-items-center">

                        {{-- بيانات المستخدم --}}
                        <div class="d-flex align-items-center gap-3">

                            {{-- Avatar --}}
                            @php
                            $nameParts = explode(' ', trim($bid->user->name ?? 'مزايد'));
                            $firstLetter = mb_substr($nameParts[0] ?? 'م', 0, 1);
                            $secondLetter = mb_substr($nameParts[1] ?? 'ز', 0, 1);
                            $avatarText = strtoupper($firstLetter . $secondLetter);

                            $hash = md5($bid->user->id ?? $bid->user_id);
                            $color = '#' . substr($hash, 0, 6);
                            @endphp

                            @if($bid->user && $bid->user->avatar)
                            <img src="{{ Storage::url($bid->user->avatar) }}"
                                 class="rounded-circle"
                                 width="42" height="42"
                                 style="object-fit: cover;"
                                 alt="{{ $bid->user->name }}">
                            @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                 style="width:42px; height:42px; background-color: {{ $color }}; font-size:14px;">
                                {{ $avatarText }}
                            </div>
                            @endif

                            {{-- الاسم + الوقت --}}
                            <div>
                                <div class="fw-bold">
                                    {{ $bid->user->name ?? 'مزايد' }}
                                    @if($isHighest)
                                        <span class="badge bg-warning text-dark ms-2">
                                            <i class="bi bi-trophy-fill"></i> الأعلى
                                        </span>
                                    @endif
                                </div>

                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $bid->created_at->diffForHumans() }}
                                </small>
                            </div>

                        </div>

                        {{-- المبلغ --}}
                        <div class="text-end">
                            <div class="fw-bold fs-5 {{ $isHighest ? 'text-success' : '' }}">
                                {{ number_format($bid->amount) }}
                                <small>د.ع</small>
                            </div>
                            <small class="text-muted">#{{ $bid->id }}</small>
                        </div>

                    </div>

                </li>

                @endforeach

            </ul>

            @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox display-4 d-block mb-3"></i>
                <h5>لا توجد مزايدات حتى الآن</h5>
                <p class="mb-0">كن أول من يزايد على هذه السيارة</p>
            </div>
            @endif

        </div>

        @if($bids && $bids->count() > 10)
        <div class="card-footer bg-white text-center py-3">
            <button class="btn btn-outline-primary btn-sm" wire:click="loadMore">
                <i class="bi bi-arrow-down me-1"></i>
                عرض المزيد
            </button>
        </div>
        @endif

    </div>

</div>

@push('scripts')
<script>
    // تحديث عداد الوقت المتبقي
    function updateCountdown() {
        const timerElement = document.getElementById('countdown-timer');
        if (!timerElement) return;

        const endTime = timerElement.dataset.end;
        if (!endTime) return;

        const end = new Date(endTime);
        const now = new Date();

        const diff = end - now;

        if (diff <= 0) {
            timerElement.textContent = 'انتهى';
            return;
        }

        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        timerElement.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    setInterval(updateCountdown, 1000);
</script>
@endpush
