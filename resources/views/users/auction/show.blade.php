@extends('layouts-users.app')

@section('title', 'تفاصيل المزاد')

@section('content-user')

<div class="container my-5">

    <div class="row g-4">


        <div class="col-lg-6">

            @php
                $images = $auction->car->getMedia('cars');
            @endphp

            @if($images->count() > 0)
                <div id="carImagesSlider" class="carousel slide" data-bs-ride="carousel">

                    <div class="carousel-inner">
                        @foreach($images as $index => $image)


                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $image->getUrl() }}"
                                     class="d-block w-100 rounded"
                                     style="height: 420px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carImagesSlider" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carImagesSlider" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>

                </div>
            @else
                <img src="{{ asset('users/img/no-image.png') }}" class="img-fluid rounded w-100" alt="">
            @endif

        </div>

        {{-- معلومات المزاد --}}
        <div class="col-lg-6">

            <h2 class="fw-bold mb-3">
                {{ $auction->car->brand->name }}
                {{ $auction->car->model->name }}
                - {{ $auction->car->year }}
            </h2>

            <p class="text-muted mb-2">
                رقم المزاد:
                <strong>#{{ $auction->id }}</strong>
            </p>

            <p class="mb-3">
                حالة المزاد:
                <span class="badge bg-{{ $auction->status === 'active' ? 'success' : 'secondary' }} px-3 py-2">
                    {{ $auction->status === 'active' ? 'نشط' : 'غير متاح' }}
                </span>
            </p>

            {{-- المواصفات --}}
            <div class="mb-4">
                <h5 class="fw-bold">مواصفات السيارة:</h5>
                <p class="text-muted">
                    {!! nl2br(e($auction->car->specs ?? 'لا توجد مواصفات مضافة')) !!}
                </p>
            </div>

            {{-- زر المزايدة --}}
            @auth
                @if($auction->status === 'active')
                    @livewire('user.place-bid', ['auction' => $auction])
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
