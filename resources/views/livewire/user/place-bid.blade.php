<div wire:poll.2s="checkForNewBids" class="p-3 border rounded shadow-sm bg-white">

    {{-- تنبيه المزايدة الجديدة --}}
    @if($newBidAlert)
        <div class="alert alert-info mb-4">
            <strong>مزايدة جديدة!</strong><br>
            المزايد: {{ $newBidAlert['user_id'] }}<br>
            القيمة: {{ number_format($newBidAlert['amount']) }} ريال
        </div>
    @endif

    {{-- السعر الحالي --}}
    <div class="mb-4 text-center">
        <h4 class="fw-bold mb-1">السعر الحالي</h4>
        <span class="fs-3 text-success fw-bold">
            {{ number_format($currentPrice) }} $
        </span>
    </div>

    {{-- قائمة الزيادات --}}
    <div class="mb-3">
        <label class="fw-bold mb-2 d-block">اختر قيمة الزيادة:</label>

        <div class="d-flex flex-wrap gap-2">

            @foreach($increments as $inc)
                <button class="btn
                    {{ $selectedIncrement == $inc ? 'btn-primary' : 'btn-outline-primary' }}
                    px-4 py-2"
                    wire:click="setBidAmount({{ $inc }})">
                    + {{ number_format($inc) }} $
                </button>
            @endforeach

        </div>
    </div>

    {{-- عرض القيمة المختارة --}}
    @if($selectedIncrement)
        <div class="alert alert-success text-center mt-3 fw-bold fs-5">
            قيمة المزايدة المختارة:
            {{ number_format($currentPrice + $selectedIncrement) }} ريال
        </div>
    @endif

    {{-- زر المزايدة --}}
    <button class="btn btn-success w-100 py-2 fs-5 fw-bold mt-3"
            wire:click="placeBid">
        زايد الآن
    </button>

    {{-- الأخطاء --}}
    @error('amount')
        <div class="text-danger mt-2 text-center">
            {{ $message }}
        </div>
    @enderror

    {{-- رسالة النجاح --}}
    @if (session()->has('success'))
        <div class="alert alert-success mt-3 text-center">
            {{ session('success') }}
        </div>
    @endif

</div>
