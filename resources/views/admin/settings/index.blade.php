@extends('layouts.app')

@section('content')
<div class="container page-rtl mt-4">

    <h3 class="mb-4 fw-bold">
        <i class="bi bi-gear-fill text-primary ms-2"></i>
        إعدادات النظام
    </h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close me-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close me-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        <!-- إعدادات الموقع -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.settings.general') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 ms-3">
                                <i class="fas fa-cog fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">إعدادات الموقع</h5>
                                <p class="text-muted small mb-0">الاسم – الشعار – وصف الموقع</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- إعدادات السيارات -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.brands.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3 ms-3">
                                <i class="fas fa-car fa-2x text-success"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">إعدادات السيارات</h5>
                                <p class="text-muted small mb-0">الماركات – الموديلات – المواصفات</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- إعدادات المستخدمين -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3 ms-3">
                                <i class="fas fa-users-cog fa-2x text-info"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">إعدادات المستخدمين</h5>
                                <p class="text-muted small mb-0">الأدوار – الصلاحيات – التحكم</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- إعدادات المزادات -->


        <!-- إعدادات الملفات -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.settings.file') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-secondary bg-opacity-10 p-3 ms-3">
                                <i class="fas fa-folder-open fa-2x text-secondary"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">إعدادات الملفات</h5>
                                <p class="text-muted small mb-0">الصور – الحجم – التخزين – الامتدادات</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- سجلات النشاطات -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.activity.logs') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3 ms-3">
                                <i class="fas fa-list-alt fa-2x text-danger"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">سجلات النشاطات</h5>
                                <p class="text-muted small mb-0">عمليات الدخول – التعديلات – الأحداث</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>



</div>
@endsection

@push('styles')
<style>
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    .card {
        transition: all 0.2s ease;
    }
</style>
@endpush
