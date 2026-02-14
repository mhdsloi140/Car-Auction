@extends('layouts-users.app')

@section('title', 'تفاصيل المزاد')

@section('content')

<div class="container my-5" style="direction: rtl; text-align: right;">

    <div class="row g-4">

        {{-- صور السيارة --}}
        <div class="col-lg-6">

            @php
            $images = $auction->car->getMedia('cars');
            @endphp

            @if($images->count() > 0)

            {{-- السلايدر --}}
            <div id="carImagesSlider" class="carousel slide shadow-sm rounded mb-3" data-bs-ride="carousel">

                <div class="carousel-inner rounded">
                    @foreach($images as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ $image->getUrl() }}" class="d-block w-100 rounded"
                            style="height: 420px; object-fit: cover;">
                    </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carImagesSlider"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carImagesSlider"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>

            {{-- الصور المصغّرة --}}
            <div class="d-flex gap-2 flex-wrap">
                @foreach($images as $index => $image)
                <img src="{{ $image->getUrl() }}"
                    onclick="bootstrap.Carousel.getInstance(document.getElementById('carImagesSlider')).to({{ $index }})"
                    class="rounded shadow-sm"
                    style="width: 100px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid #ddd;">
                @endforeach
            </div>

            @else

            <img src="{{ asset('users/img/no-image.png') }}" class="img-fluid rounded w-100 shadow-sm"
                style="height: 420px; object-fit: cover;" alt="لا توجد صور">

            @endif

        </div>

        {{-- معلومات المزاد --}}
        <div class="col-lg-6">

            <h2 class="fw-bold mb-3">
                {{ $auction->car->brand->name }}
                {{ $auction->car->model->name }}
                <span class="text-muted">({{ $auction->car->year }})</span>
            </h2>

            <p class="text-muted mb-2">
                رقم المزاد:
                <strong>#{{ $auction->id }}</strong>
            </p>

            <p class="mb-3">
                حالة المزاد:
                <span class="badge px-3 py-2 bg-{{ $auction->status === 'active' ? 'success' : 'secondary' }}">
                    {{ $auction->status === 'active' ? 'نشط' : 'غير متاح' }}
                </span>
            </p>

            <div class="mb-4">
                <h5 class="fw-bold mb-2">مواصفات السيارة:</h5>
                <div class="p-3 bg-light ">
                    <p class="text-muted mb-0" style="white-space: pre-line;">
                        {{ $auction->car->specs ?? 'لا توجد مواصفات مضافة' }}
                    </p>
                </div>
                <div class="p-3 bg-light ">
                    <p class="text-muted mb-0" style="white-space: pre-line;">
                        {{ $auction->car->description ?? 'لا توجد مواصفات مضافة' }}
                    </p>
                </div>
            </div>

            {{-- زر المشاركة في المزاد --}}
            @auth
            @if($auction->status === 'active')
            <a href="{{ route('auction.bid', $auction->id) }}"
                class="btn btn-primary btn-lg w-100 mt-3 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-cash-coin"></i>
                المشاركة في المزاد
            </a>

            @else
            <div class="alert alert-warning mt-3">
                هذا المزاد غير متاح حالياً
            </div>
            @endif
            @else
            <div class="alert alert-info mt-3">
                يرجى تسجيل الدخول للمزايدة
            </div>
            @endauth

        </div>

    </div>

</div>

@endsection
