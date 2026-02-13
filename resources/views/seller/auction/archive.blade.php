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
                    <th>الإجراءات</th>
                    <th>تاريخ الانتهاء</th>
                </tr>
            </thead>

            <tbody>
                @foreach($auctions as $auction)
                <tr>
                    <td>{{ $auction->id }}</td>

                    <td>
                        {{ $auction->car->brand?->name }}
                        {{ $auction->car->model?->name }}
                    </td>

                    <td>{{ number_format($auction->starting_price) }}</td>

                    <td>
                        @if($auction->final_price)
                            {{ number_format($auction->final_price) }}
                        @else
                            <span class="text-muted">لا توجد مزايدات</span>
                        @endif
                    </td>

                    {{-- الإجراءات: قبول / رفض --}}
                  <td>
    {{-- إذا لا يوجد فائز --}}
    @if(!$auction->winner)
        <span class="text-muted">—</span>

    {{-- إذا كانت حالة المزاد مرفوضة --}}
    @elseif($auction->status === 'rejected')
        <span class="badge bg-danger">مرفوض</span>

    {{-- إذا كانت حالة المزاد مكتملة --}}
    @elseif($auction->status === 'completed')
        <span class="badge bg-success">مكتمل</span>

    {{-- إذا كانت حالة المزاد منتهية ويحتاج قرار --}}
    @elseif($auction->status === 'closed')

        {{-- زر قبول (يغيّر الحالة + يفتح المودال) --}}
        <form action="{{ route('auction.sellers.complete', $auction->id) }}"
              method="POST" class="d-inline">
            @csrf
            @method('PATCH')

            <button type="submit"
                    class="btn btn-success btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#winnerModal{{ $auction->id }}">
                قبول
            </button>
        </form>

        {{-- زر رفض --}}
        <form action="{{ route('auction.sellers.reject', $auction->id) }}"
              method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button class="btn btn-danger btn-sm">رفض</button>
        </form>

        {{-- مودال بيانات الفائز --}}
        <div class="modal fade" id="winnerModal{{ $auction->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">بيانات الفائز</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p><strong>الاسم:</strong> {{ $auction->winner->name }}</p>
                        <p><strong>البريد:</strong> {{ $auction->winner->email }}</p>
                        <p><strong>رقم الجوال:</strong> {{ $auction->winner->phone ?? '—' }}</p>
                        <p><strong>قيمة المزايدة الفائزة:</strong>
                            {{ number_format($auction->final_price) }}
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    </div>

                </div>
            </div>
        </div>

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
