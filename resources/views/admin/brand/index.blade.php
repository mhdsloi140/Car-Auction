{{-- @extends('layouts.app')

@section('content')
<livewire:brand.create-brand />

<table class="table table-bordered table-striped align-middle text-center">
    <thead class="table-primary">
        <tr>
            <th>#</th>
            <th>الصورة</th>
            <th>اسم الماركة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($brands as $index => $brand)
        <tr>
            <td>{{ $index + 1 }}</td>


            <td>
                <img src="{{ $brand->getFirstMediaUrl('brands') ?: 'https://via.placeholder.com/60' }}" width="60"
                    height="60" style="object-fit: cover;">
            </td>


            <td>{{ $brand->name }}</td>


            <td>
                <a href="{{ route('brand.edit', $brand->id) }}" class="btn btn-sm btn-primary">
                    تعديل
                </a>


                <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $brand->id }})">
                    حذف
                </button>

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">لا توجد بيانات</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection --}}
@extends('layouts.app')

@section('content')

<!-- نموذج إضافة الماركة -->
<livewire:brand.create-brand />

<!-- جدول الماركات -->
<livewire:brand.brand-table />

@endsection
