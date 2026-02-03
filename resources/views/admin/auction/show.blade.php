@extends('layouts.app')

@section('content')
<div class="container">

    {{-- أزرار الإدارة أعلى الصفحة --}}
    @role('admin')
    @if($auction->status === 'pending')
    <div class="d-flex justify-content-center gap-3 mb-4">

        {{-- زر القبول --}}
        <form action="{{ route('auctions.approve', $auction->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button class="btn btn-success px-4 d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                قبول المزاد
            </button>
        </form>

        {{-- زر الرفض (Livewire) --}}
        <livewire:admin.reject-auction :auction="$auction" />

    </div>
    @endif
    @endrole


    {{-- بطاقة تفاصيل المزاد --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            {{-- عنوان السيارة --}}
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h3 class="fw-bold mb-1">
                        {{ $auction->car->brand?->name }}
                        {{ $auction->car->model?->name }}
                        ({{ $auction->car->year }})
                    </h3>

                    @php
                    // ألوان الحالات
                    $statusColors = [
                    'pending' => 'bg-warning text-dark',
                    'active' => 'bg-success',
                    'closed' => 'bg-secondary',
                    'rejected' => 'bg-danger',
                    ];

                    // النصوص العربية للحالات
                    $statusLabels = [
                    'pending' => 'معلق',
                    'active' => 'نشط',
                    'closed' => 'مغلق',
                    'rejected' => 'مرفوض',
                    ];

                    // اختيار اللون والنص المناسب
                    $colorClass = $statusColors[$auction->status] ?? 'bg-primary';
                    $statusLabel = $statusLabels[$auction->status] ?? $auction->status;
                    @endphp

                    <span class="badge {{ $colorClass }} px-3 py-2">
                        {{ $statusLabel }}
                    </span>

                </div>
            </div>

            <hr>


            <h5 class="fw-bold mb-3">
                <i class="bi bi-info-circle"></i>
                بيانات المزاد
            </h5>

            <div class="row mb-3">
                <div class="col-md-4">
                    <p><strong>البائع:</strong> {{ $auction->seller?->name }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>السعر الابتدائي:</strong> {{ number_format($auction->starting_price) }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>سعر الشراء الفوري:</strong>
                        {{ $auction->buy_now_price ? number_format($auction->buy_now_price) : 'لا يوجد' }}
                    </p>
                </div>
            </div>

            <hr>

            {{-- معلومات السيارة --}}
            <h5 class="fw-bold mb-3">
                <i class="bi bi-car-front-fill"></i>
                معلومات السيارة
            </h5>

            <div class="row mb-3">
                <div class="col-md-4">
                    <p><strong>المدينة:</strong> {{ $auction->car->city }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>عدد الكيلومترات:</strong> {{ $auction->car->mileage }}</p>
                </div>
                <div class="col-md-12 mt-2">
                    <p><strong>الوصف:</strong> {{ $auction->car->description }}</p>
                </div>
            </div>

            <hr>

            {{-- صور السيارة --}}
            <h5 class="fw-bold mb-3">
                <i class="bi bi-images"></i>
                صور السيارة
            </h5>


            {{-- <div class="row g-3">
                @foreach($car->getMedia('cars') as $photo)
                <div class="col-md-3 col-6">
                    <div class="border rounded overflow-hidden shadow-sm" style="height:160px;">
                        <img src="{{ $photo->getUrl() }}" class="img-fluid w-100 h-100" style="object-fit:cover;">
                    </div>
                </div>
                @endforeach
            </div> --}}


        </div>
    </div>


    <div class="text-center mb-5">
        <form action="{{ route('auction.admin.destroy', $auction->id) }}" method="POST">
            @csrf
            @method('delete')
            <button class="btn btn-danger px-4 d-flex align-items-center gap-2 mx-auto">
                <i class="bi bi-trash-fill"></i>
                حذف المزاد
            </button>
        </form>
    </div>

</div>
@endsection
