@extends('layouts.app')

@section('content')
<div class="container" style="direction: rtl; text-align: right;">

    {{-- بطاقة معلومات السيارة والمزاد --}}
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="fw-bold mb-2">
                {{ $auction->car->brand?->name ?? 'ماركة غير محددة' }}
                {{ $auction->car->model?->name ?? 'موديل غير محدد' }}
                <span class="text-muted">({{ $auction->car->year ?? '-' }})</span>
            </h3>

            @php
            $statusColors = [
            'pending' => 'bg-warning text-dark',
            'active' => 'bg-success',
            'closed' => 'bg-secondary',
            'rejected' => 'bg-danger',
            ];
            $colorClass = $statusColors[$auction->status] ?? 'bg-primary';
            @endphp

            <span class="badge {{ $colorClass }} px-3 py-2 fs-6">
                {{ ucfirst($auction->status) }}
            </span>
        </div>

        {{-- تفاصيل المزاد --}}
        <div class="card-body border-top mt-2">
            <h5 class="fw-bold">تفاصيل المزاد</h5>
            <div class="row mt-2">
                <div class="col-md-4 mb-2">

                    <div class="col-md-4 mb-2">
                        <strong>تاريخ البداية:</strong> {{ $auction->start_at ?? '-' }}
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>تاريخ النهاية:</strong> {{ $auction->end_at ?? '-' }}
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>الوقت المتبقي:</strong>
                        @if($auction->end_at)
                        @php
                        $now = \Carbon\Carbon::now();
                        $end = \Carbon\Carbon::parse($auction->end_at);
                        @endphp
                        @if($now->greaterThan($end))
                        انتهى المزاد
                        @else
                        {{ $now->diffInDays($end) }} أيام
                        {{ $now->copy()->addDays($now->diffInDays($end))->diffInHours($end) }} ساعات
                        @endif
                        @else
                        -
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- معلومات السيارة --}}
        <div class="card shadow-sm mb-4 border-0 rounded-3">
            <div class="card-header bg-light">
                <h5 class="fw-bold mb-0">معلومات السيارة</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>المدينة:</strong> {{ $auction->car->city ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>عدد الكيلومترات:</strong> {{ $auction->car->mileage ?? '-' }}
                    </div>
                    <div class="col-md-12 mb-3">
                        <strong>المواصفات</strong>
                        @if($auction->car->specs)
                        <p class="mb-3 text-gray-700">{{ $auction->car->specs_label }}</p>
                        @endif

                    </div>
                    <div class="col-md-12 mb-3">
                        <strong>الوصف:</strong>
                        <p class="mt-1">{{ $auction->car->description ?? '-' }}</p>
                    </div>

                </div>
            </div>
        </div>

        {{-- صور السيارة --}}
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-light">
                <h5 class="fw-bold mb-0">صور السيارة</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($auction->car->getMedia('cars') as $photo)
                    <div class="col-6 col-md-3">
                        <img src="{{ $photo->getUrl() }}" class="img-fluid rounded shadow-sm"
                            style="height:160px; object-fit:cover; width:100%;">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>




    </div>
    @endsection
