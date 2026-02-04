@extends('layouts.app')

@section('content')
<div class="container page-rtl mt-4">

    <h3 class="mb-4 fw-bold">إعدادات النظام</h3>

    <div class="row g-3">

        <!-- إعدادات الموقع -->
           <div class="col-md-4">
            <a href="{{ route('admin.settings.general') }}" class="text-decoration-none">
                <div class="card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-cog fa-2x ms-3 text-primary"></i>
                        <div>
                            <h5 class="mb-1">إعدادات الموقع</h5>
                            <p class="text-muted small">الاسم – الشعار </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- إعدادات السيارات -->
        <div class="col-md-4">
            <a href="{{ route('admin.brands.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-car fa-2x ms-3 text-success"></i>
                        <div>
                            <h5 class="mb-1">إعدادات السيارات</h5>
                            <p class="text-muted small">الماركات – الموديلات – المواصفات</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- إعدادات المزادات -->
        <div class="col-md-4">
            <a href="{{ route('admin.car-settings') }}" class="text-decoration-none">
                <div class="card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-gavel fa-2x ms-3 text-warning"></i>
                        <div>
                            <h5 class="mb-1">إعدادات المزادات</h5>
                            <p class="text-muted small">الحدود – المدة – الشراء الفوري</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- إعدادات المستخدمين -->
        <div class="col-md-4">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-users-cog fa-2x ms-3 text-info"></i>
                        <div>
                            <h5 class="mb-1">إعدادات المستخدمين</h5>
                            <p class="text-muted small">الأدوار – الصلاحيات – التحكم</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- إعدادات الأمان -->
        <div class="col-md-4">
            <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-shield-alt fa-2x ms-3 text-danger"></i>
                        <div>
                            <h5 class="mb-1">إعدادات الأمان</h5>
                            <p class="text-muted small">التحقق بخطوتين – السجلات</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- إعدادات الملفات -->
        <div class="col-md-4">
            <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-folder-open fa-2x ms-3 text-secondary"></i>
                        <div>
                            <h5 class="mb-1">إعدادات الملفات</h5>
                            <p class="text-muted small">الصور – الحجم – التخزين</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

</div>


@endsection
