@extends('layouts.app')

@section('content')
<div class="container py-4" dir="rtl">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 py-3">
            <h4 class="mb-0 fw-bold">
                <i class="bi bi-person-circle text-primary me-2"></i>
                الملف الشخصي
            </h4>
        </div>

        <div class="card-body p-4">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('seller.profile.update') }}" method="POST">
                @csrf

                {{-- معلومات أساسية --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-person me-1"></i>
                            الاسم
                        </label>
                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', auth()->user()->name) }}"
                               placeholder="أدخل اسمك الكامل">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-telephone me-1"></i>
                            رقم الهاتف
                        </label>
                        <input type="tel"
                               name="phone"
                               id="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', auth()->user()->phone) }}"
                               placeholder="05xxxxxxxx">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                </div>

                <hr class="my-4">

                {{-- تغيير كلمة المرور --}}
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-shield-lock text-warning me-2"></i>
                    تغيير كلمة المرور
                </h5>

                <div class="row g-3">
                    {{-- كلمة المرور الحالية --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">كلمة المرور الحالية</label>
                        <div class="input-group">
                            <input type="password"
                                   name="current_password"
                                   id="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="********">
                            <button class="btn btn-outline-secondary"
                                    type="button"
                                    onclick="togglePassword('current_password', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- كلمة المرور الجديدة --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">كلمة المرور الجديدة</label>
                        <div class="input-group">
                            <input type="password"
                                   name="password"
                                   id="new_password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="********">
                            <button class="btn btn-outline-secondary"
                                    type="button"
                                    onclick="togglePassword('new_password', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- تأكيد كلمة المرور --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
                        <div class="input-group">
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   placeholder="********">
                            <button class="btn btn-outline-secondary"
                                    type="button"
                                    onclick="togglePassword('password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- مؤشر قوة كلمة المرور --}}
                    <div class="col-12" id="password-strength" style="display: none;">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%;"></div>
                        </div>
                        <small class="text-muted" id="strength-text"></small>
                    </div>
                </div>

                <hr class="my-4">

                {{-- معلومات إضافية --}}
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded-3">
                            <small class="text-muted d-block">تاريخ التسجيل</small>
                            <span class="fw-bold">{{ auth()->user()->created_at->format('Y-m-d') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded-3">
                            <small class="text-muted d-block">آخر تحديث</small>
                            <span class="fw-bold">{{ auth()->user()->updated_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>

                {{-- أزرار الإجراءات --}}
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2">
                        <i class="bi bi-check-circle me-2"></i>
                        حفظ التغييرات
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-5 py-2">
                        <i class="bi bi-arrow-right me-2"></i>
                        رجوع
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@push('scripts')
<script>
    // دالة إظهار/إخفاء كلمة المرور
    window.togglePassword = function(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // التحقق من قوة كلمة المرور
    document.getElementById('new_password')?.addEventListener('input', function() {
        const password = this.value;
        const strengthDiv = document.getElementById('password-strength');
        const progressBar = strengthDiv.querySelector('.progress-bar');
        const strengthText = document.getElementById('strength-text');

        if (password.length > 0) {
            strengthDiv.style.display = 'block';

            let strength = 0;
            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]+/)) strength += 25;
            if (password.match(/[A-Z]+/)) strength += 25;
            if (password.match(/[0-9]+/)) strength += 25;
            if (password.match(/[$@#&!]+/)) strength += 25;

            strength = Math.min(strength, 100);

            progressBar.style.width = strength + '%';

            if (strength < 50) {
                progressBar.className = 'progress-bar bg-danger';
                strengthText.textContent = 'كلمة مرور ضعيفة';
            } else if (strength < 75) {
                progressBar.className = 'progress-bar bg-warning';
                strengthText.textContent = 'كلمة مرور متوسطة';
            } else {
                progressBar.className = 'progress-bar bg-success';
                strengthText.textContent = 'كلمة مرور قوية';
            }
        } else {
            strengthDiv.style.display = 'none';
        }
    });
</script>
@endpush

@endsection
