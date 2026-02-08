
<div wire:poll.5s>

    <div class="container mb-4">
        <h3 class="fw-bold mb-3 text-center">اختر الماركة</h3>

        <div class="brand-container">


            <div class="brand-item text-center"
                 wire:click="selectBrand(null)"
                 style="cursor:pointer; background: {{ $selectedBrand ? '#fff' : '#e9ecef' }};">
                <div class="fw-bold small">الكل</div>
            </div>


            @foreach ($brands as $brand)
                <div class="brand-item text-center"
                     wire:click="selectBrand({{ $brand->id }})"
                     style="cursor:pointer; background: {{ $selectedBrand == $brand->id ? '#e9ecef' : '#fff' }};">

                    <img src="{{ $brand->getFirstMediaUrl('logo') }}"
                         class="brand-logo mb-1">

                    <div class="fw-bold small">{{ $brand->name }}</div>
                </div>
            @endforeach

        </div>
    </div>


<div class="row g-4">

    @foreach ($auctions as $auction)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="product-item rounded">

                <div class="product-item-inner border rounded">
                    <div class="product-item-inner-item">

                        <img src="{{ $auction->car->getFirstMediaUrl('cars') }}"
                             class="img-fluid w-100 rounded-top" alt="">

                        <div class="product-details">
                            <a href="{{ route('auction.users.show', $auction->id) }}">
                                <i class="fa fa-eye fa-1x"></i>
                            </a>
                        </div>
                    </div>

                    <div class="text-center rounded-bottom p-4">

                        <a class="d-block mb-2">
                            {{ $auction->car->brand->name ?? 'غير محدد' }}
                        </a>

                        <a href="{{ route('auction.show', $auction->id) }}"
                           class="d-block h4">
                           {{ $auction->car->model?->name ?? 'غير محدد' }} <br>
                           {{ $auction->car->year ?? '' }}
                        </a>

                    </div>
                </div>

                <div class="product-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">
                    <a href="{{ route('auction.users.show', $auction->id) }}"
                       class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4">
                        <i class="fas fa-gavel me-2"></i> دخول المزاد
                    </a>
                </div>

            </div>
        </div>
    @endforeach

</div>

</div>
