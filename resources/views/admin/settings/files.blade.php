@extends('layouts.app')



@section('content')

<div class="container my-5" style="direction: rtl; text-align: right;">

    <h3 class="fw-bold mb-4">إعدادات الملفات</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.save') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- حجم الصور --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold mb-3">حجم الصور</h5>

                    <div class="mb-3">
                        <label class="form-label">الحد الأقصى لحجم الصورة (MB)</label>
                        <input type="number" name="max_image_size" class="form-control"
                               value="{{ $settings['max_image_size'] ?? 5 }}">
                    </div>
                </div>
            </div>

            {{-- أنواع الملفات --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold mb-3">أنواع الملفات المسموح بها</h5>

                    <div class="mb-3">
                        <label class="form-label">الامتدادات</label>
                        <input type="text" name="allowed_extensions" class="form-control"
                               value="{{ $settings['allowed_extensions'] ?? 'jpg, png, jpeg, webp' }}">
                    </div>
                </div>
            </div>

            {{-- مسار التخزين --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold mb-3">مسار التخزين</h5>

                    <div class="mb-3">
                        <label class="form-label">المسار</label>
                        <input type="text" name="storage_path" class="form-control"
                               value="{{ $settings['storage_path'] ?? 'storage/app/public' }}">
                    </div>
                </div>
            </div>

            {{-- عدد الصور --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold mb-3">عدد الصور المسموح برفعها</h5>

                    <div class="mb-3">
                        <label class="form-label">العدد</label>
                        <input type="number" name="max_images" class="form-control"
                               value="{{ $settings['max_images'] ?? 10 }}">
                    </div>
                </div>
            </div>

        </div>

        <button class="btn btn-primary w-100 mt-4">حفظ الإعدادات</button>

    </form>

</div>

@endsection
