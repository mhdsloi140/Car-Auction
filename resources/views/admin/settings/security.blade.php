@extends('layouts.app')

@section('title', 'إعدادات الأمان')

@section('content')

<div class="container my-5" style="direction: rtl; text-align: right;">

    <h3 class="fw-bold mb-4">إعدادات الأمان</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.security.save') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- التحقق بخطوتين --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold mb-3">التحقق بخطوتين (2FA)</h5>

                    <select name="enable_2fa" class="form-select">
                        <option value="1" {{ ($settings['enable_2fa'] ?? 0) == 1 ? 'selected' : '' }}>مفعل</option>
                        <option value="0" {{ ($settings['enable_2fa'] ?? 0) == 0 ? 'selected' : '' }}>غير مفعل</option>
                    </select>
                </div>
            </div>

            {{-- مدة الجلسة --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold mb-3">مدة الجلسة (بالدقائق)</h5>

                    <input type="number" name="session_timeout" class="form-control"
                           value="{{ $settings['session_timeout'] ?? 30 }}">
                </div>
            </div>

            {{-- عدد محاولات تسجيل الدخول --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold mb-3">عدد محاولات تسجيل الدخول قبل الحظر</h5>

                    <input type="number" name="login_attempts" class="form-control"
                           value="{{ $settings['login_attempts'] ?? 5 }}">
                </div>
            </div>

            {{-- مدة الحظر --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold mb-3">مدة الحظر (بالدقائق)</h5>

                    <input type="number" name="lockout_time" class="form-control"
                           value="{{ $settings['lockout_time'] ?? 15 }}">
                </div>
            </div>

            {{-- سجل النشاطات --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold mb-3">سجل النشاطات</h5>

                    <select name="activity_logs" class="form-select">
                        <option value="1" {{ ($settings['activity_logs'] ?? 0) == 1 ? 'selected' : '' }}>مفعل</option>
                        <option value="0" {{ ($settings['activity_logs'] ?? 0) == 0 ? 'selected' : '' }}>غير مفعل</option>
                    </select>
                </div>
            </div>

            {{-- إشعارات تسجيل الدخول --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold mb-3">إشعارات تسجيل الدخول</h5>

                    <select name="login_notifications" class="form-select">
                        <option value="1" {{ ($settings['login_notifications'] ?? 0) == 1 ? 'selected' : '' }}>مفعل</option>
                        <option value="0" {{ ($settings['login_notifications'] ?? 0) == 0 ? 'selected' : '' }}>غير مفعل</option>
                    </select>
                </div>
            </div>

        </div>

        <button class="btn btn-primary w-100 mt-4">حفظ الإعدادات</button>

    </form>

</div>

@endsection
