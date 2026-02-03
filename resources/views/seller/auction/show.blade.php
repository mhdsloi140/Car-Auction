@extends('layouts.app')

@section('content')
<div class="container">


    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap">

            <h3 class="fw-bold mb-2">
                {{ $car->brand?->name ?? 'ماركة غير محددة' }}
                {{ $car->model?->name ?? 'موديل غير محدد' }}
                <span class="text-muted">({{ $car->year ?? '-' }})</span>
            </h3>

            @if($car->auction)
            @php
            $statusColors = [
            'pending' => 'bg-warning text-dark',
            'active' => 'bg-success',
            'closed' => 'bg-secondary',
            'rejected' => 'bg-danger',
            ];
            $colorClass = $statusColors[$car->auction->status] ?? 'bg-primary';
            @endphp

            <span class="badge {{ $colorClass }} px-3 py-2 fs-6">
                {{ ucfirst($car->auction->status) }}
            </span>
            @endif

        </div>

        @if($car->auction)
        <div class="card-body border-top mt-2">

            <h5 class="fw-bold">تفاصيل المزاد</h5>

            <div class="row mt-2">

                <div class="col-md-4 mb-2">
                    <strong>السعر الابتدائي:</strong>
                    <span class="text-success">
                        {{ number_format($car->auction->starting_price) }}
                    </span>
                </div>

                <div class="col-md-4 mb-2">
                    <strong>سعر الشراء الفوري:</strong>
                    <span class="text-danger">
                        {{ $car->auction->buy_now_price ? number_format($car->auction->buy_now_price) . ' ريال' : 'لا
                        يوجد' }}
                    </span>
                </div>

                {{-- <div class="col-md-4 mb-2">
                    <strong>البائع:</strong>
                    {{ $car->auction->seller?->name ?? 'غير متوفر' }}
                </div> --}}

                <div class="col-md-4 mb-2">
                    <strong>تاريخ البداية:</strong>
                    {{ $car->auction->start_at ?? '-' }}
                </div>

                <div class="col-md-4 mb-2">
                    <strong>تاريخ النهاية:</strong>
                    {{ $car->auction->end_at ?? '-' }}
                </div>
              <div class="col-md-4 mb-2">
    <strong>الوقت المتبقي:</strong>
    @if($car->auction && $car->auction->end_at)
        @php
            $now = \Carbon\Carbon::now();
            $end = \Carbon\Carbon::parse($car->auction->end_at);
            $diff = $now->diff($end);
        @endphp

        @if($now->greaterThan($end))
            انتهى المزاد
        @else
            {{ $diff->d }} أيام
            {{ $diff->h }} ساعات
            {{ $diff->i }} دقائق
        @endif
    @else
        -
    @endif
</div>


            </div>

        </div>
        @endif
    </div>

  
    <div class="card shadow-sm mb-4 border-0 rounded-3">

        <div class="card-header bg-light">
            <h5 class="fw-bold mb-0">معلومات السيارة</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>المدينة:</strong> {{ $car->city ?? '-' }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>عدد الكيلومترات:</strong> {{ $car->mileage ?? '-' }}
                </div>

                <div class="col-md-12 mb-3">
                    <strong>الوصف:</strong>
                    <p class="mt-1">{{ $car->description ?? '-' }}</p>
                </div>

                <div class="col-md-12 mb-3">
                    <strong>المعلومات القانونية:</strong>
                    <p class="mt-1">{{ $car->inspection_report ?? '-' }}</p>
                </div>

            </div>

        </div>

    </div>


    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-header bg-light">
            <h5 class="fw-bold mb-0">صور السيارة</h5>
        </div>

        <div class="card-body">

            <div class="row g-3">
                @foreach($car->getMedia('cars') as $photo)
                <div class="col-6 col-md-3">
                    <img src="{{ $photo->getUrl() }}" class="img-fluid rounded shadow-sm"
                        style="height:160px; object-fit:cover; width:100%;">
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">
            <img src="" id="modalImage" class="img-fluid rounded">
        </div>

    </div>

</div>

@push('scripts')
<script>
    const imageModal = document.getElementById('imageModal');

    imageModal.addEventListener('show.bs.modal', function (event) {
        const link = event.relatedTarget;
        const src = link.getAttribute('data-img');
        document.getElementById('modalImage').src = src;
    });
</script>
@endpush
@endsection
