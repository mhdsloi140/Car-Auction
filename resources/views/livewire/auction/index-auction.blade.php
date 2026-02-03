<div>
    <h4 class="mb-4">قائمة المزادات</h4>

    @if($auctions->count())
    <div class="row row-cols-1 row-cols-md-2 g-4">

        @foreach($auctions as $auction)
        <div class="col">
            <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">

                @php
                $media = $auction->car->getFirstMedia('cars');
                @endphp

             
                <div class="position-relative">
                    @if($media)
                    <img src="{{ $media->getUrl() }}" class="card-img-top" style="height:220px; object-fit:cover;">
                    @endif


                    @php
                    $statusNames = [
                    'pending' => 'معلق',
                    'active' => 'نشط',
                    'closed' => 'مغلق',
                    'rejected' => 'مرفوض',
                    ];

                    $statusColors = [
                    'pending' => 'secondary',
                    'active' => 'success',
                    'closed' => 'dark',
                    'rejected' => 'danger',
                    ];

                    $status = $auction->status ?? 'pending';
                    $statusText = $statusNames[$status] ?? $status;
                    $statusColor = $statusColors[$status] ?? 'secondary';
                    @endphp

                    <span class="badge bg-{{ $statusColor }} position-absolute top-0 end-0 m-2 px-3 py-2">
                        {{ $statusText }}
                    </span>




                </div>

                <div class="card-body">


                    <h5 class="card-title fw-bold">
                        {{ $auction->car->brand->name }}
                        {{ $auction->car->model->name ?? '' }}
                        <span class="text-muted">({{ $auction->car->year }})</span>
                    </h5>


                    <ul class="list-unstyled small mt-3">
                        <li class="mb-1">
                            <i class="bi bi-geo-alt text-danger"></i>
                            <strong>المدينة:</strong> {{ $auction->car->city }}
                        </li>

                        <li class="mb-1">
                            <i class="bi bi-cash-coin text-success"></i>
                            <strong>السعر الابتدائي:</strong>
                            {{ number_format($auction->starting_price) }} ريال
                        </li>
                    </ul>

                    <a href="{{ route('auction.show', $auction->id) }}" class="btn btn-outline-primary w-100 mt-3">
                        عرض التفاصيل
                    </a>

                </div>
            </div>
        </div>
        @endforeach

    </div>
    @else
    <p class="text-muted">لا يوجد أي مزادات حتى الآن.</p>
    @endif
</div>
