{{-- @extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">قائمة المزادات</h4>

    <!-- فلترة حسب الحالة -->
    <form method="GET" class="mb-3 d-flex align-items-center gap-2">
        <label>فلترة حسب الحالة:</label>
        <select name="status" class="form-select w-auto">
            <option value="">كل المزادات</option>
            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>قيد الانتظار</option>
            <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>موافق عليه</option>
            <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>مرفوض</option>
            <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>نشط</option>
            <option value="closed" {{ request('status')=='closed' ? 'selected' : '' }}>مغلق</option>
        </select>
        <button class="btn btn-primary">تطبيق</button>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>البائع</th>
                    <th>السيارة</th>
                    <th>السعر الابتدائي</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($auctions as $index => $auction)
                <tr>
                    <td>{{ $auctions->firstItem() + $index }}</td>
                    <td>{{ $auction->seller->name }}</td>
                    <td>{{ $auction->car->name }} - {{ $auction->car->brand }} ({{ $auction->car->year }})</td>
                    <td>{{ $auction->start_price }}</td>
                    <td>
                        @if($auction->status == 'pending')
                        <span class="badge bg-warning text-dark">قيد الانتظار</span>
                        @elseif($auction->status == 'approved')
                        <span class="badge bg-success">موافق عليه</span>
                        @elseif($auction->status == 'rejected')
                        <span class="badge bg-danger">مرفوض</span>
                        @elseif($auction->status == 'active')
                        <span class="badge bg-primary">نشط</span>
                        @else
                        <span class="badge bg-secondary">مغلق</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">لا توجد مزادات</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $auctions->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection --}}
{{-- @extends('layouts.app')

@section('content')
<div class="container mt-4">
    <livewire:auction.auction-table />
    <button class="btn btn-success mb-3" wire:click="$emit('showCreateCarWizard')">
        إضافة سيارة جديدة ومزاد
    </button>
    <livewire:auction.create-auction-wizard />
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="container mt-5">
       

        {{--
        <!-- استدعاء الـ Component بالكامل --> --}}
        <livewire:auction.create-auction-wizard />
        <livewire:auction.index-auction />
    </div>

</div>
@endsection
