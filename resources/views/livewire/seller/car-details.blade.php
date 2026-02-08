<div class="container my-5" style="direction: rtl; text-align: right;" wire:poll.5s>

    {{-- عنوان السيارة --}}
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <h3 class="fw-bold mb-1">
                    {{ $car->brand?->name }}
                    {{ $car->model?->name }}
                </h3>

                <span class="text-muted">
                    <i class="bi bi-calendar"></i>
                    سنة الصنع: {{ $car->year }}
                </span>
            </div>

            <span class="text-muted fw-semibold">
                مزاد مباشر
            </span>

        </div>
    </div>

    {{-- قائمة المزايدات --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

        <div class="card-header bg-light py-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-cash-stack"></i>
                سجل المزايدات
            </h5>
        </div>

        <div class="card-body p-0">

            @php
            $bids = $car->auction?->bids()->with('user')->latest()->get();

            $colors = [
            '#6c757d', '#495057', '#343a40',
            '#868e96', '#212529', '#adb5bd'
            ];
            @endphp

            @if($bids && $bids->count() > 0)

            <ul class="list-group list-group-flush">

                @foreach($bids as $index => $bid)

                <li class="list-group-item border-0 px-4 py-3">

                    <div class="d-flex justify-content-between align-items-center">

                        {{-- بيانات المستخدم --}}
                        <div class="d-flex align-items-center gap-3">

                            {{-- Avatar --}}
                            @php
                            $nameParts = explode(' ', trim($bid->user->name));
                            $firstLetter = mb_substr($nameParts[0] ?? '', 0, 1);
                            $secondLetter = mb_substr($nameParts[1] ?? '', 0, 1);
                            $avatarText = strtoupper($firstLetter . $secondLetter);

                            $hash = md5($bid->user->id);
                            $color = '#' . substr($hash, 0, 6);
                            @endphp

                            @if($bid->user->avatar)
                            <img src="{{ asset('storage/' . $bid->user->avatar) }}" class="rounded-circle" width="42"
                                height="42" style="object-fit: cover;" alt="{{ $bid->user->name }}">
                            @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                style="
                                                width:42px;
                                                height:42px;
                                                background-color: {{ $color }};
                                                font-size:14px;
                                            ">
                                {{ $avatarText }}
                            </div>
                            @endif

                            {{-- الاسم + الوقت --}}
                            <div>
                                <div class="fw-bold">
                                    {{ $bid->user->name }}
                                    @if($index === 0)
                                    <span class="badge bg-warning text-dark ms-2">الاعلى</span>
                                    @endif
                                </div>

                                <small class="text-muted">
                                    <i class="bi bi-clock"></i>
                                    {{ $bid->created_at->diffForHumans() }}
                                </small>
                            </div>

                        </div>

                        {{-- المبلغ --}}
                        <div class="text-end">
                            <div class="fw-bold fs-5">
                                {{ number_format($bid->amount) }}
                            </div>

                        </div>

                    </div>

                </li>

                @endforeach

            </ul>

            @else
            <div class="text-center text-muted py-5">
                لا توجد مزايدات حتى الآن
            </div>
            @endif

        </div>

    </div>

</div>
