@extends('layouts-users.app')


@section('content-user')

<div class="container-fluid carousel bg-light px-0">
    <div class="row g-0 justify-content-end">
        <div class="col-12 col-lg-7 col-xl-9">
            <div class="header-carousel owl-carousel bg-light py-5">
                <!-- Slide 1 -->
                <div class="row g-0 header-carousel-item align-items-center">
                    <div class="col-xl-6 carousel-img wow fadeInLeft">
                        <img src="{{ asset('users/img/dasboard2.jpg') }}" class="img-fluid w-100" alt="Image">
                    </div>
                    {{-- <div class="col-xl-6 carousel-content p-4">
                        <h4 class="text-uppercase fw-bold mb-4 wow fadeInRight" style="letter-spacing:3px;">Save Up To
                            $400</h4>
                        <h1 class="display-3 text-capitalize mb-4 wow fadeInRight">On Selected Laptops & Desktop Or
                            Smartphone</h1>
                        <p class="text-dark wow fadeInRight">Terms and Conditions Apply</p>
                        <a href="#" class="btn btn-primary rounded-pill py-3 px-5 wow fadeInRight">Shop Now</a>
                    </div> --}}
                </div>
                <!-- Slide 2 -->
                <div class="row g-0 header-carousel-item align-items-center">
                    <div class="col-xl-6 carousel-img wow fadeInLeft">
                        <img src="{{ asset('users/img/dashboard.jpg') }}" class="img-fluid w-100" alt="Image">
                    </div>

                </div>
            </div>
        </div>
        <!-- Side Banner -->
        <div class="col-12 col-lg-5 col-xl-3 wow fadeInRight">

            <div class="border rounded p-4 bg-light">

                <h4 class="fw-bold mb-3 text-center">فلترة البحث</h4>

                {{-- السعر --}}
                <div class="mb-3">
                    <label class="form-label">السعر من</label>
                    <input type="number" wire:model.live="price_min" class="form-control" placeholder="0">
                </div>

                <div class="mb-3">
                    <label class="form-label">السعر إلى</label>
                    <input type="number" wire:model.live="price_max" class="form-control" placeholder="100000">
                </div>

                {{-- السنة --}}
                <div class="mb-3">
                    <label class="form-label">سنة الصنع</label>
                    <select wire:model.live="year" class="form-select">
                        <option value="">الكل</option>
                        @foreach(range(date('Y'), 1990) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>


                {{-- المواصفات --}}
                <div class="mb-3">
                    <label class="form-label">المواصفات</label>
                    <input type="text" wire:model.live="specs" class="form-control"
                        placeholder="مثال: فتحة سقف، شاشة، جلد">
                </div>


                {{-- زر إعادة تعيين --}}
                <button wire:click="resetFilters" class="btn btn-secondary w-100 mt-3">
                    إعادة تعيين الفلاتر
                </button>

            </div>

        </div>

    </div>
</div>
<div class="container-fluid product py-5">
    <div class="container py-5">
        <div class="tab-class">




            @livewire('user.auctions-list')

        </div>
    </div>
</div>


@endsection
