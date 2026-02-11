@extends('layouts.app')

@section('content')
<div class="container my-5" style="direction: rtl;">

    <h3 class="mb-4">أرشيف مزاداتي المنتهية</h3>

    @if($auctions->count())
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>السيارة</th>
                    <th>السعر الابتدائي</th>
                    <th>السعر النهائي</th>
                    <th>الفائز</th>
                    <th>تاريخ الانتهاء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($auctions as $auction)
                <tr>
                    <td>{{ $auction->id }}</td>
                    <td>{{ $auction->car->brand?->name }} {{ $auction->car->model?->name }}</td>
                    <td>{{ number_format($auction->starting_price) }}</td>
                    <td>
                        @if($auction->final_price)
                        {{ number_format($auction->final_price) }}
                        @else
                        <span class="text-muted">لا توجد مزايدات</span>
                        @endif
                    </td>
                    <td>
                        @if($auction->winner)
                        <a href="{{ route('auction.sellers.winner', $auction->winner) }}" class="text-decoration-none">
                            {{ $auction->winner->name }}
                        </a>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td>{{ $auction->end_at?->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $auctions->links() }}
    @else
    <div class="alert alert-info">لا توجد مزادات منتهية بعد</div>
    @endif


</div>
@endsection
