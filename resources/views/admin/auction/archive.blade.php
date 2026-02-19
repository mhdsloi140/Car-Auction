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
                    <th>حالة المزاد</th>
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

                    {{-- ================== حالة المزاد ================== --}}
                    <td>
                        @if(!$auction->winner)
                        <span class="badge bg-secondary">لا يوجد فائز</span>

                        @elseif($auction->status === 'rejected')
                        <span class="badge bg-danger">مرفوض</span>

                        @elseif($auction->status === 'completed')
                        <span class="badge bg-success">مكتمل</span>

                        @elseif($auction->status === 'closed')
                        <span class="badge bg-warning text-dark">بانتظار القرار</span>

                        @else
                        <span class="badge bg-light text-dark">
                            {{ $auction->status }}
                        </span>
                        @endif
                    </td>

                    {{-- ================== الإجراءات ================== --}}
                    <td>

                        @if(!$auction->winner)
                        <span class="text-muted">—</span>

                        {{-- إذا كانت مكتملة يظهر زر عرض --}}
                        @elseif($auction->status === 'completed')
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#winnerModal{{ $auction->id }}">
                            عرض
                        </button>

                        {{-- إذا كانت منتهية وتحتاج قرار --}}
                        @elseif($auction->status === 'closed')

                        {{-- زر قبول --}}
                        <form action="{{ route('auction.admin.complete', $auction->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">
                                قبول
                            </button>
                        </form>

                        {{-- زر رفض --}}
                        <form action="{{ route('auction.admin.reject', $auction->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-danger btn-sm">
                                رفض
                            </button>
                        </form>

                        {{-- إذا مرفوض أو غير ذلك --}}
                        @else
                        <span class="text-muted">—</span>
                        @endif

                    </td>

                    <td>{{ $auction->end_at?->format('Y-m-d H:i') }}</td>
                </tr>

                {{-- ================== مودال بيانات الفائز ================== --}}
                @if($auction->winner)
                <div class="modal fade" id="winnerModal{{ $auction->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            {{-- <div class="modal-header">
                                <h5 class="modal-title">بيانات الفائز</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div> --}}
                            <div class="modal-header d-flex justify-content-between">

                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>

                                <h5 class="modal-title">
                                    بيانات الفائز
                                </h5>

                            </div>
                            <div class="modal-body">
                                <p><strong>الاسم:</strong> {{ $auction->winner->name }}</p>
                                <p><strong>رقم الجوال:</strong> {{ $auction->winner->phone ?? '—' }}</p>
                                <p>
                                    <strong>قيمة المزايدة الفائزة:</strong>
                                    {{ number_format($auction->final_price) }}
                                </p>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">
                                    إغلاق
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                @endif

                @endforeach
            </tbody>
        </table>
    </div>

    {{ $auctions->links() }}

    @else
    <div class="alert alert-info">
        لا توجد مزادات منتهية بعد
    </div>
    @endif

</div>
@endsection
